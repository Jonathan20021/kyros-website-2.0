<?php
declare(strict_types=1);

require_once base_path('app/mailer.php');
require_once base_path('app/rate_limit.php');
require_once base_path('app/fx.php');

/**
 * "Páginas web para médicos" — the doctor intake form (/mi-pagina-medica).
 *
 * Same guarantee as BriefController: validate → store → notify admin → confirm
 * to the doctor, with the row written BEFORE the emails so a mail outage can
 * never lose a request. Two things are different here:
 *
 *   1. There are file uploads. They are processed BEFORE validation and their
 *      paths survive a redirect through old(), because a browser cannot
 *      repopulate <input type=file> — losing them on a typo'd email would make
 *      the doctor upload their logo again for nothing.
 *   2. Consultorios (with a weekly schedule each) are variable length, so they
 *      come in as a nested array and are stored as JSON.
 */
class MedicalSiteController
{
    /* ── Option catalog ──────────────────────────────────────────
       Single source of truth: the view renders from it, submit()
       validates against it, and the admin panel resolves labels from
       it — so the three can never drift apart. */

    /**
     * Plans. Priced in DOP (this is a product sold in the DR); the USD column
     * is derived from the live rate at render time, never stored — the same
     * rule BriefController follows for its budget bands.
     */
    public const PLANS = [
        'consulta-express' => [
            'name'     => 'Consulta Express',
            'tagline'  => 'Entrada baja, tu web al aire esta semana.',
            'blurb'    => 'Una página única, impecable, con todo lo que un paciente necesita para decidir llamarte.',
            'price'    => 12900,
            'unit'     => 'pago único',
            // The only plan with a required monthly. It is not a separate fee:
            // it is the Signos Vitales add-on, bundled from day one — which is
            // why the two figures must stay in step.
            'price_monthly' => 3200,
            'delivery' => '7 días',
            'pages'    => 'Landing de 1 página',
            'popular'  => false,
            'features' => [
                'Diseño a medida de una página (secciones: inicio, sobre ti, servicios, consultorios, contacto)',
                'Botón de WhatsApp directo a tu teléfono',
                'Mapa y dirección de tu consultorio',
                'Tus horarios de consulta siempre visibles',
                'Optimizada para celular (donde te busca el 80% de tus pacientes)',
                'Google Business: te ayudamos a aparecer en el mapa',
                'Capacitación de 30 minutos para que sepas moverte',
                'Incluye el plan Signos Vitales desde el primer día: dominio, hosting, SSL, respaldos, monitoreo 24/7 y 2 cambios de contenido al mes',
            ],
        ],
        'chequeo-completo' => [
            'name'     => 'Chequeo Completo',
            'tagline'  => 'El estudio completo. Nada queda sin revisar.',
            'blurb'    => 'El sitio que la mayoría de los especialistas necesita: varias páginas, blog y captación de pacientes.',
            'price'    => 49900,
            'unit'     => 'pago único',
            'delivery' => '15 días',
            'pages'    => 'Hasta 7 páginas',
            'popular'  => true,
            'features' => [
                'Todo lo del plan Consulta Express, y además:',
                'Hasta 7 páginas (una por servicio o procedimiento)',
                'Blog médico para publicar artículos y posicionarte como referente',
                'Galería de fotos del consultorio y de procedimientos',
                'Sección de testimonios de pacientes',
                'Formulario de solicitud de cita que te llega al correo y al WhatsApp',
                'Listado de seguros y ARS que aceptas',
                'Correo profesional (tunombre@tudominio.com)',
                'SEO local: que te encuentren buscando "tu especialidad + tu ciudad"',
                'Google Analytics para ver cuántos pacientes te visitan',
            ],
        ],
        'cirugia-mayor' => [
            'name'     => 'Cirugía Mayor',
            'tagline'  => 'Intervención completa. Para clínicas y equipos.',
            'blurb'    => 'Para centros médicos, consultorios con varias sedes o especialistas con un equipo detrás.',
            'price'    => 89900,
            'unit'     => 'pago único',
            'delivery' => '30 días',
            'pages'    => 'Páginas ilimitadas',
            'popular'  => false,
            'features' => [
                'Todo lo del plan Chequeo Completo, y además:',
                'Páginas ilimitadas y múltiples sedes',
                'Agenda de citas en línea con confirmación y recordatorios automáticos',
                'Perfil individual para cada médico del centro',
                'Sitio bilingüe español / inglés',
                'Panel propio para que edites textos, horarios y artículos sin depender de nadie',
                'Newsletter para mantener el contacto con tus pacientes',
                'Integración con Doctoralia y redes sociales',
                'SEO avanzado y estrategia de contenido a 3 meses',
                'Video de presentación editado (tú pones la grabación)',
            ],
        ],
    ];

    /** Recurring / one-off add-ons, shown apart from the build plans. */
    public const ADDONS = [
        'signos-vitales' => [
            'name'    => 'Signos Vitales',
            'tagline' => 'Tu web en observación permanente.',
            'price'   => 3200,
            'unit'    => 'al mes',
            'icon'    => 'trending',
            'features' => [
                'Hosting, dominio y SSL renovados sin que tengas que acordarte',
                'Respaldos automáticos y actualizaciones de seguridad',
                'Monitoreo 24/7: si tu sitio se cae, lo sabemos antes que tú',
                'Hasta 2 cambios de contenido al mes (horarios, textos, fotos)',
                'Reporte mensual de visitas y solicitudes de cita',
                'Soporte prioritario por WhatsApp',
            ],
        ],
        'codigo-azul' => [
            'name'    => 'Código Azul',
            'tagline' => 'Rescate urgente. Ya tienes web y algo salió mal.',
            'price'   => 9900,
            'unit'    => 'pago único',
            'icon'    => 'zap',
            'features' => [
                'Diagnóstico completo en menos de 24 horas',
                'Recuperación de sitios caídos, hackeados o secuestrados',
                'Rescate de dominios y accesos perdidos',
                'Migración desde el proveedor anterior sin perder contenido',
                'Limpieza de malware y blindaje posterior',
                'Informe de qué pasó y cómo evitar que se repita',
            ],
        ],
    ];

    /** USD equivalent of a DOP price, rounded to a legible number. */
    public static function priceUsd(int $dop): int
    {
        $fx = Fx::usdToDop();
        $rate = (float) ($fx['rate'] ?: 60.0);
        $usd = $dop / $rate;
        // Round to the nearest 5 so the toggle never shows "US$831".
        return (int) max(5, round($usd / 5) * 5);
    }

    public static function formatDop(int $dop): string
    {
        return 'RD$' . number_format($dop);
    }

    public static function formatUsd(int $dop): string
    {
        return 'US$' . number_format(self::priceUsd($dop));
    }

    /**
     * A plan's full cost as one line: "RD$12,900 + RD$3,200/mes".
     *
     * Plans may or may not carry a required mensualidad, and the total shows up
     * in the price cards, the picker, the admin panel and both emails — so the
     * assembly lives here rather than being re-derived in five templates.
     */
    public static function planPriceText(?string $key, string $currency = 'DOP'): string
    {
        $p = self::PLANS[$key] ?? null;
        if (!$p) return '—';

        $fmt = fn(int $v): string => $currency === 'USD' ? self::formatUsd($v) : self::formatDop($v);

        $out = $fmt((int) $p['price']);
        if (!empty($p['price_monthly'])) {
            $out .= ' + ' . $fmt((int) $p['price_monthly']) . '/mes';
        }
        return $out;
    }

    public const PREFIXES = ['Dr.', 'Dra.', 'Lic.', 'Licda.', 'Ing.', 'Sin título'];

    public const SPECIALTIES = [
        'alergologia'      => 'Alergología e Inmunología',
        'anestesiologia'   => 'Anestesiología',
        'cardiologia'      => 'Cardiología',
        'cirugia-general'  => 'Cirugía General',
        'cirugia-plastica' => 'Cirugía Plástica y Estética',
        'dermatologia'     => 'Dermatología',
        'endocrinologia'   => 'Endocrinología',
        'fisiatria'        => 'Fisiatría y Rehabilitación',
        'gastroenterologia'=> 'Gastroenterología',
        'geriatria'        => 'Geriatría',
        'ginecologia'      => 'Ginecología y Obstetricia',
        'hematologia'      => 'Hematología',
        'infectologia'     => 'Infectología',
        'medicina-estetica'=> 'Medicina Estética',
        'medicina-familiar'=> 'Medicina Familiar',
        'medicina-interna' => 'Medicina Interna',
        'nefrologia'       => 'Nefrología',
        'neumologia'       => 'Neumología',
        'neurocirugia'     => 'Neurocirugía',
        'neurologia'       => 'Neurología',
        'nutricion'        => 'Nutrición y Dietética',
        'odontologia'      => 'Odontología',
        'oftalmologia'     => 'Oftalmología',
        'oncologia'        => 'Oncología',
        'ortopedia'        => 'Ortopedia y Traumatología',
        'otorrino'         => 'Otorrinolaringología',
        'pediatria'        => 'Pediatría',
        'podologia'        => 'Podología',
        'psicologia'       => 'Psicología Clínica',
        'psiquiatria'      => 'Psiquiatría',
        'radiologia'       => 'Radiología e Imágenes',
        'reumatologia'     => 'Reumatología',
        'terapia-fisica'   => 'Terapia Física',
        'urologia'         => 'Urología',
        'otra'             => 'Otra especialidad',
    ];

    public const EXTRAS = [
        'agenda'       => ['Agenda de citas en línea',       'Que el paciente reserve solo, sin llamar.'],
        'blog'         => ['Blog / artículos de salud',      'Publica y posiciónate como referente.'],
        'galeria'      => ['Galería de fotos',               'Consultorio, equipo y procedimientos.'],
        'antes-despues'=> ['Galería antes / después',        'Ideal para estética, dermatología y odontología.'],
        'testimonios'  => ['Testimonios de pacientes',       'La prueba social que más convierte.'],
        'video'        => ['Video de presentación',          'Que te conozcan antes de la consulta.'],
        'bilingue'     => ['Sitio bilingüe (ES / EN)',       'Para pacientes internacionales y turismo médico.'],
        'telemedicina' => ['Telemedicina / videoconsulta',   'Atiende a distancia con enlace seguro.'],
        'pagos'        => ['Pagos o anticipos en línea',     'Cobra la consulta antes de que llegue.'],
        'newsletter'   => ['Newsletter para pacientes',      'Mantén el contacto después de la consulta.'],
        'faq'          => ['Preguntas frecuentes',           'Menos llamadas repetidas a tu secretaria.'],
        'seguros'      => ['Listado de seguros y ARS',       'La pregunta número uno de todo paciente.'],
    ];

    public const BOOKING = [
        'whatsapp' => 'Por WhatsApp (lo más común)',
        'formulario' => 'Formulario que me llega al correo',
        'agenda'   => 'Agenda en línea con horarios reales',
        'telefono' => 'Solo por teléfono, lo maneja mi secretaria',
    ];

    public const DOMAIN_STATUS = [
        'tengo'  => 'Ya tengo mi dominio',
        'quiero' => 'Quiero que ustedes lo consigan',
        'no-se'  => 'No sé qué es un dominio',
    ];

    public const LAUNCH = [
        'urgente'  => 'Lo antes posible',
        '1m'       => 'En el próximo mes',
        '2-3m'     => 'En 2 — 3 meses',
        'explorar' => 'Solo estoy explorando',
    ];

    /** Weekly schedule columns: key => [short label, full label]. */
    public const DAYS = [
        'lun' => ['L',  'Lunes'],
        'mar' => ['M',  'Martes'],
        'mie' => ['MI', 'Miércoles'],
        'jue' => ['J',  'Jueves'],
        'vie' => ['V',  'Viernes'],
        'sab' => ['S',  'Sábado'],
        'dom' => ['D',  'Domingo'],
    ];

    public const SOCIAL_NETWORKS = [
        'instagram'  => ['Instagram',  '@tuusuario'],
        'facebook'   => ['Facebook',   'facebook.com/tupagina'],
        'tiktok'     => ['TikTok',     '@tuusuario'],
        'linkedin'   => ['LinkedIn',   'linkedin.com/in/tuperfil'],
        'youtube'    => ['YouTube',    'youtube.com/@tucanal'],
        'doctoralia' => ['Doctoralia', 'doctoralia.com.do/tu-perfil'],
    ];

    /** Only paths we ourselves wrote may be carried across a failed submit. */
    private const ASSET_PREFIX = '/assets/uploads/medicos/';

    public function show(): void
    {
        render_view('medical-form', [
            'plans'      => self::PLANS,
            'addons'     => self::ADDONS,
            'prefixes'   => self::PREFIXES,
            'specialties'=> self::SPECIALTIES,
            'extras'     => self::EXTRAS,
            'booking'    => self::BOOKING,
            'domains'    => self::DOMAIN_STATUS,
            'launch'     => self::LAUNCH,
            'days'       => self::DAYS,
            'networks'   => self::SOCIAL_NETWORKS,
        ], [
            'title'       => 'Solicita tu página web médica · KYROS Solutions',
            'description' => 'Cuéntanos de tu práctica y construimos tu sitio web profesional. Formulario guiado en 5 pasos: identidad, contacto, trayectoria, consultorios y plan.',
            'body_class'  => 'page-medical-form',
        ]);
    }

    /**
     * Normalise a posted field to valid UTF-8.
     *
     * A client that posts Latin-1/cp1252 would otherwise take down the whole
     * request: the utf8mb4 INSERT throws AND json_encode() returns false inside
     * Mailer, so the request would be lost twice over.
     */
    private static function clean($value): string
    {
        $v = trim((string) $value);
        if ($v !== '' && !mb_check_encoding($v, 'UTF-8')) {
            $v = mb_convert_encoding($v, 'UTF-8', 'Windows-1252');
        }
        return (string) preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $v);
    }

    public function submit(): void
    {
        // 1. Honeypot — real users never see this field, let alone fill it.
        if (!empty($_POST['fax'])) {
            flash('med_status', 'success');
            redirect('/mi-pagina-medica#gracias');
        }

        // 2. CSRF. Checked before anything touches disk.
        if (!csrf_check((string)($_POST['_csrf'] ?? ''))) {
            flash('med_status', 'error');
            flash('med_error', 'La sesión expiró. Recarga la página e inténtalo de nuevo.');
            set_old($this->flatten($this->gather()));
            redirect('/mi-pagina-medica#form');
        }

        // 3. Uploads, before validation, so a rejected form keeps the images.
        //    Rate-limited on their own key: this is the only path that writes
        //    to disk, and it is reachable by anyone with a session.
        $logo = $portrait = null;
        $uploadErrors = [];
        if (RateLimit::hit('med_upload', 20, 3600)) {
            $logo     = $this->resolveAsset('logo', 'logo_kept', $uploadErrors);
            $portrait = $this->resolveAsset('portrait', 'portrait_kept', $uploadErrors);
        } else {
            $logo     = $this->keptAsset('logo_kept');
            $portrait = $this->keptAsset('portrait_kept');
        }

        $input = $this->gather();
        $input['logo_url']     = $logo;
        $input['portrait_url'] = $portrait;

        // 4. Validation
        $errors = array_merge($this->validate($input), $uploadErrors);
        if ($errors) {
            flash('med_status', 'error');
            flash('med_errors', $errors);
            set_old($this->flatten($input));
            redirect('/mi-pagina-medica#form');
        }

        // 5. Rate limit the actual submission
        if (!RateLimit::hit('med', (int) env('MED_RATE_LIMIT_MAX', 5), (int) env('MED_RATE_LIMIT_WINDOW', 3600))) {
            flash('med_status', 'error');
            flash('med_error', 'Has enviado demasiadas solicitudes. Intenta de nuevo en una hora.');
            set_old($this->flatten($input));
            redirect('/mi-pagina-medica#form');
        }

        // 6. Persist first — a mail failure must never lose the request.
        $ref = MedicalRequest::makeRef();
        $row = $input;
        $row['ref']        = $ref;
        $row['extras']     = implode(',', $input['extras']);
        $row['ip']         = client_ip();
        $row['user_agent'] = substr((string)($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255);

        $id = 0;
        $stored = true;
        try {
            $id = MedicalRequest::create($row);
        } catch (Throwable $e) {
            $stored = false;
            error_log('[medical] no se pudo guardar la solicitud: ' . $e->getMessage());
        }

        // 7. Notify us + confirm to the doctor.
        $displayName = trim(($input['title_prefix'] !== 'Sin título' ? $input['title_prefix'] . ' ' : '') . $input['full_name']);

        $adminRes = Mailer::send([
            'to'       => env('MAIL_TO', 'info@kyrosrd.com'),
            'reply_to' => $input['email'],
            'subject'  => "[{$ref}] Nueva web médica: {$displayName}" . ($input['specialty'] ? ' · ' . $this->specialtyLabel($input) : ''),
            'html'     => $this->adminHtml($ref, $input, $displayName),
        ]);

        $clientRes = Mailer::send([
            'to'       => $input['email'],
            'reply_to' => env('MAIL_TO', 'info@kyrosrd.com'),
            'subject'  => "Recibimos tu solicitud · {$ref}",
            'html'     => $this->clientHtml($ref, $input, $displayName),
        ]);

        if ($stored && $id) {
            try {
                MedicalRequest::markMail($id, (bool) $adminRes['ok'], (bool) $clientRes['ok']);
            } catch (Throwable $e) {
                error_log('[medical] no se pudo marcar el estado de correo: ' . $e->getMessage());
            }
        }

        // Only a total failure (nothing stored AND admin mail failed) is fatal:
        // that is the one case where the request would vanish silently.
        if (!$stored && !$adminRes['ok']) {
            flash('med_status', 'error');
            flash('med_error', 'No pudimos registrar tu solicitud: ' . $adminRes['error'] . ' Escríbenos a ' . env('MAIL_TO', 'info@kyrosrd.com') . '.');
            set_old($this->flatten($input));
            redirect('/mi-pagina-medica#form');
        }

        clear_old();
        flash('med_status', 'success');
        flash('med_ref', $ref);
        flash('med_name', $displayName);
        flash('med_plan', $input['plan']);
        flash('med_client_mail', $clientRes['ok'] ? '1' : '0');
        redirect('/mi-pagina-medica#gracias');
    }

    /* ── Input ───────────────────────────────────────────────── */

    /** @return array<string,mixed> Everything the form posts, cleaned. */
    private function gather(): array
    {
        $extras = $_POST['extras'] ?? [];
        if (!is_array($extras)) $extras = [];
        // Keep only known keys — never trust the posted list.
        $extras = array_values(array_intersect($extras, array_keys(self::EXTRAS)));

        $socials = [];
        foreach (array_keys(self::SOCIAL_NETWORKS) as $net) {
            $v = self::clean($_POST['social'][$net] ?? '');
            if ($v !== '') $socials[$net] = mb_substr($v, 0, 200);
        }

        return [
            'title_prefix'     => self::clean($_POST['title_prefix']     ?? ''),
            'full_name'        => self::clean($_POST['full_name']        ?? ''),
            'specialty'        => self::clean($_POST['specialty']        ?? ''),
            'specialty_other'  => self::clean($_POST['specialty_other']  ?? ''),
            'subspecialty'     => self::clean($_POST['subspecialty']     ?? ''),
            'license'          => self::clean($_POST['license']          ?? ''),
            'years_experience' => self::clean($_POST['years_experience'] ?? ''),
            'email'            => self::clean($_POST['email']            ?? ''),
            'phone'            => self::clean($_POST['phone']            ?? ''),
            'whatsapp'         => self::clean($_POST['whatsapp']         ?? ''),
            'city'             => self::clean($_POST['city']             ?? ''),
            'domain_status'    => self::clean($_POST['domain_status']    ?? ''),
            'domain_name'      => self::clean($_POST['domain_name']      ?? ''),
            'bio'              => self::clean($_POST['bio']              ?? ''),
            'career'           => self::clean($_POST['career']           ?? ''),
            'services_offered' => self::clean($_POST['services_offered'] ?? ''),
            'insurances'       => self::clean($_POST['insurances']       ?? ''),
            'languages'        => self::clean($_POST['languages']        ?? ''),
            'plan'             => self::clean($_POST['plan']             ?? ''),
            'booking'          => self::clean($_POST['booking']          ?? ''),
            'design_refs'      => self::clean($_POST['design_refs']      ?? ''),
            'launch_when'      => self::clean($_POST['launch_when']      ?? ''),
            'notes'            => self::clean($_POST['notes']            ?? ''),
            'extras'           => $extras,
            'socials'          => $socials,
            'clinics'          => $this->gatherClinics(),
            'logo_url'         => null,
            'portrait_url'     => null,
        ];
    }

    /**
     * Consultorios arrive as clinics[i][name] / clinics[i][sched][día][from|to].
     * Blank blocks are dropped: the form always renders one empty card, and a
     * doctor who only has a single office should not produce a ghost second one.
     *
     * @return array<int,array<string,mixed>>
     */
    private function gatherClinics(): array
    {
        $raw = $_POST['clinics'] ?? [];
        if (!is_array($raw)) return [];

        $out = [];
        foreach (array_slice($raw, 0, 6) as $c) {
            if (!is_array($c)) continue;

            $clinic = [
                'name'    => mb_substr(self::clean($c['name']    ?? ''), 0, 160),
                'address' => mb_substr(self::clean($c['address'] ?? ''), 0, 300),
                'suite'   => mb_substr(self::clean($c['suite']   ?? ''), 0, 60),
                'phone'   => mb_substr(self::clean($c['phone']   ?? ''), 0, 40),
                'maps'    => mb_substr(self::clean($c['maps']    ?? ''), 0, 500),
            ];

            $sched = [];
            $rawSched = is_array($c['sched'] ?? null) ? $c['sched'] : [];
            foreach (array_keys(self::DAYS) as $day) {
                $d = $rawSched[$day] ?? null;
                if (!is_array($d) || empty($d['on'])) continue;
                $from = self::cleanTime($d['from'] ?? '');
                $to   = self::cleanTime($d['to']   ?? '');
                if ($from === '' || $to === '') continue;
                $sched[$day] = ['from' => $from, 'to' => $to];
            }
            $clinic['sched'] = $sched;

            // A card with nothing but empty schedule checkboxes is not a clinic.
            if ($clinic['name'] === '' && $clinic['address'] === '' && !$sched) continue;
            $out[] = $clinic;
        }
        return $out;
    }

    /** Accept only HH:MM — a <input type=time> posts nothing else. */
    private static function cleanTime($value): string
    {
        $v = trim((string) $value);
        return preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $v) ? $v : '';
    }

    /* ── Uploads ─────────────────────────────────────────────── */

    /**
     * Resolve one image field: a newly posted file wins, otherwise the path
     * carried over from a previous failed submit.
     *
     * @param array<string,string> $errors Collected by reference.
     */
    private function resolveAsset(string $field, string $keptField, array &$errors): ?string
    {
        if (!empty($_FILES[$field]['name'])) {
            $err = null;
            $path = upload_public_image($_FILES[$field] ?? null, $err);
            if ($path) return $path;
            if ($err) $errors[$field] = $err;
            // Fall through: keep whatever they had uploaded before.
        }
        return $this->keptAsset($keptField);
    }

    /**
     * A path echoed back by our own form. Validated against the upload prefix
     * so a crafted POST cannot write an arbitrary string (or a remote URL)
     * into the row and have the admin panel render it as an <img src>.
     */
    private function keptAsset(string $field): ?string
    {
        $kept = self::clean($_POST[$field] ?? '');
        if ($kept === '') return null;
        if (!str_starts_with($kept, self::ASSET_PREFIX)) return null;
        if (str_contains($kept, '..')) return null;
        if (!preg_match('#^' . preg_quote(self::ASSET_PREFIX, '#') . '\d{4}/\d{2}/[a-f0-9]{20}\.(jpg|png|webp|avif)$#', $kept)) return null;
        return $kept;
    }

    /* ── Validation ──────────────────────────────────────────── */

    /** old() only stores scalars — arrays are re-encoded for redisplay. */
    private function flatten(array $input): array
    {
        $flat = $input;
        $flat['extras']  = implode(',', $input['extras'] ?? []);
        $flat['socials'] = json_encode($input['socials'] ?? [], JSON_UNESCAPED_UNICODE);
        $flat['clinics'] = json_encode($input['clinics'] ?? [], JSON_UNESCAPED_UNICODE);
        return $flat;
    }

    /** @return array<string,string> */
    private function validate(array $i): array
    {
        $errors = [];

        if (mb_strlen($i['full_name']) < 3) {
            $errors['full_name'] = 'Ingresa tu nombre completo.';
        }
        if ($i['specialty'] === '' || !isset(self::SPECIALTIES[$i['specialty']])) {
            $errors['specialty'] = 'Selecciona tu especialidad.';
        }
        if ($i['specialty'] === 'otra' && mb_strlen($i['specialty_other']) < 3) {
            $errors['specialty_other'] = 'Escribe cuál es tu especialidad.';
        }
        if (!filter_var($i['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Ingresa un email válido.';
        }
        // Digits only: a doctor may write "(809) 555-1234" or "809.555.1234".
        if (strlen(preg_replace('/\D+/', '', $i['phone']) ?? '') < 7) {
            $errors['phone'] = 'Ingresa un teléfono válido.';
        }
        if (mb_strlen($i['bio']) < 40) {
            $errors['bio'] = 'Cuéntanos un poco más de ti: mínimo 40 caracteres.';
        }
        if (!$i['clinics']) {
            $errors['clinics'] = 'Agrega al menos un centro médico o consultorio.';
        }
        if ($i['plan'] === '' || !isset(self::PLANS[$i['plan']])) {
            $errors['plan'] = 'Elige el plan que más te conviene.';
        }
        if ($i['title_prefix'] !== '' && !in_array($i['title_prefix'], self::PREFIXES, true)) {
            $errors['title_prefix'] = 'Selecciona una opción válida.';
        }

        // Optional selects: only validate when something was actually chosen.
        foreach (['booking' => self::BOOKING, 'domain_status' => self::DOMAIN_STATUS, 'launch_when' => self::LAUNCH] as $f => $opts) {
            if ($i[$f] !== '' && !isset($opts[$i[$f]])) {
                $errors[$f] = 'Selecciona una opción válida.';
            }
        }

        foreach (['full_name' => 160, 'subspecialty' => 200, 'license' => 60, 'years_experience' => 20,
                  'email' => 180, 'phone' => 40, 'whatsapp' => 40, 'city' => 120, 'domain_name' => 180,
                  'bio' => 3000, 'career' => 3000, 'services_offered' => 3000, 'insurances' => 1000,
                  'languages' => 200, 'design_refs' => 500, 'notes' => 2000] as $f => $max) {
            if (mb_strlen((string) $i[$f]) > $max) {
                $errors[$f] = "Máximo {$max} caracteres.";
            }
        }

        return $errors;
    }

    /* ── Labels (shared with the admin panel + emails) ────────── */

    public static function specialtyLabel(array $r): string
    {
        $key = (string) ($r['specialty'] ?? '');
        if ($key === 'otra') {
            return trim((string) ($r['specialty_other'] ?? '')) ?: 'Otra especialidad';
        }
        return self::SPECIALTIES[$key] ?? '—';
    }

    /** "Dr. Juan Pérez" — the prefix is dropped when they chose "Sin título". */
    public static function displayName(array $r): string
    {
        $prefix = (string) ($r['title_prefix'] ?? '');
        $name   = (string) ($r['full_name'] ?? '');
        return trim(($prefix !== '' && $prefix !== 'Sin título' ? $prefix . ' ' : '') . $name);
    }

    /** @return array<int,string> Human labels for the chosen extras. */
    public static function extraLabels(?string $csv): array
    {
        $out = [];
        foreach (array_filter(explode(',', (string) $csv)) as $k) {
            if (isset(self::EXTRAS[$k])) $out[] = self::EXTRAS[$k][0];
        }
        return $out;
    }

    /** "Lun 08:00–17:00 · Mar 08:00–17:00" for one clinic's week. */
    public static function scheduleText(array $sched): string
    {
        $parts = [];
        foreach (self::DAYS as $key => [, $full]) {
            if (empty($sched[$key]['from']) || empty($sched[$key]['to'])) continue;
            $parts[] = mb_substr($full, 0, 3) . ' ' . $sched[$key]['from'] . '–' . $sched[$key]['to'];
        }
        return $parts ? implode(' · ', $parts) : 'Sin horario indicado';
    }

    public static function planName(?string $key): string
    {
        return self::PLANS[$key]['name'] ?? '—';
    }

    /* ── Emails ──────────────────────────────────────────────── */

    private function adminHtml(string $ref, array $i, string $displayName): string
    {
        $fields = [
            'Referencia'      => $ref,
            'Médico'          => $displayName,
            'Especialidad'    => $this->specialtyLabel($i),
            'Subespecialidad' => $i['subspecialty'] ?: '—',
            'Exequátur'       => $i['license'] ?: '—',
            'Experiencia'     => $i['years_experience'] ? $i['years_experience'] . ' años' : '—',
            'Email'           => $i['email'],
            'Teléfono'        => $i['phone'],
            'WhatsApp'        => $i['whatsapp'] ?: '—',
            'Ciudad'          => $i['city'] ?: '—',
            'Plan elegido'    => self::planName($i['plan']) . ' · ' . self::planPriceText($i['plan']),
            'Dominio'         => (self::DOMAIN_STATUS[$i['domain_status']] ?? '—') . ($i['domain_name'] ? ' (' . $i['domain_name'] . ')' : ''),
            'Citas'           => self::BOOKING[$i['booking']] ?? '—',
            'Lanzamiento'     => self::LAUNCH[$i['launch_when']] ?? '—',
            'Idiomas'         => $i['languages'] ?: '—',
        ];

        $rows = '';
        foreach ($fields as $label => $val) {
            $rows .= '<tr>'
                . '<td style="padding:9px 14px;color:#6B7280;font-size:12px;border-bottom:1px solid #E7E5E4;width:150px;font-weight:600;vertical-align:top;">' . e($label) . '</td>'
                . '<td style="padding:9px 14px;color:#111827;font-size:14px;border-bottom:1px solid #E7E5E4;">' . e((string) $val) . '</td>'
                . '</tr>';
        }

        $blocks = '';
        $texts = [
            'Biografía'              => $i['bio'],
            'Trayectoria profesional'=> $i['career'],
            'Servicios que ofrece'   => $i['services_offered'],
            'Seguros y ARS'          => $i['insurances'],
            'Comentarios'            => $i['notes'],
        ];
        foreach ($texts as $label => $text) {
            if (trim((string) $text) === '') continue;
            $blocks .= '<div style="margin-top:14px;padding:16px;background:#FAFAF9;border-radius:10px;border:1px solid #E7E5E4;">'
                . '<p style="margin:0 0 6px;color:#6B7280;font-size:11px;text-transform:uppercase;letter-spacing:.1em;font-weight:700;">' . e($label) . '</p>'
                . '<div style="color:#1F2937;font-size:14px;line-height:1.65;">' . nl2br(e((string) $text)) . '</div>'
                . '</div>';
        }

        // Consultorios
        $clinicHtml = '';
        foreach ($i['clinics'] as $n => $c) {
            $line = array_filter([$c['address'] ?? '', $c['suite'] ?? '', $c['phone'] ?? '']);
            $clinicHtml .= '<div style="margin-top:10px;padding:14px 16px;background:#fff;border-radius:10px;border:1px solid #E7E5E4;">'
                . '<p style="margin:0;color:#111827;font-size:14px;font-weight:600;">' . e(($n + 1) . '. ' . ($c['name'] ?: 'Consultorio sin nombre')) . '</p>'
                . ($line ? '<p style="margin:4px 0 0;color:#6B7280;font-size:13px;">' . e(implode(' · ', $line)) . '</p>' : '')
                . '<p style="margin:6px 0 0;color:#F26522;font-size:12px;font-weight:600;">' . e(self::scheduleText($c['sched'] ?? [])) . '</p>'
                . '</div>';
        }
        if ($clinicHtml !== '') {
            $clinicHtml = '<div style="margin-top:14px;padding:14px 16px 16px;background:#FAFAF9;border-radius:10px;border:1px solid #E7E5E4;">'
                . '<p style="margin:0;color:#6B7280;font-size:11px;text-transform:uppercase;letter-spacing:.1em;font-weight:700;">Consultorios y horarios</p>'
                . $clinicHtml . '</div>';
        }

        // Extras + redes
        $extraLabels = self::extraLabels(implode(',', $i['extras']));
        $chips = '';
        foreach ($extraLabels as $label) {
            $chips .= '<span style="display:inline-block;margin:0 6px 6px 0;padding:5px 11px;background:#FFF4ED;border:1px solid #FED7B5;border-radius:9999px;color:#C2410C;font-size:12px;font-weight:600;">' . e($label) . '</span>';
        }
        if ($chips !== '') {
            $chips = '<div style="margin-top:14px;"><p style="margin:0 0 8px;color:#6B7280;font-size:11px;text-transform:uppercase;letter-spacing:.1em;font-weight:700;">Funcionalidades pedidas</p>' . $chips . '</div>';
        }

        $socialHtml = '';
        foreach ($i['socials'] as $net => $handle) {
            $socialHtml .= '<p style="margin:0 0 4px;color:#1F2937;font-size:13px;"><strong>' . e(self::SOCIAL_NETWORKS[$net][0] ?? $net) . ':</strong> ' . e($handle) . '</p>';
        }
        if ($socialHtml !== '') {
            $socialHtml = '<div style="margin-top:14px;padding:14px 16px;background:#FAFAF9;border-radius:10px;border:1px solid #E7E5E4;">'
                . '<p style="margin:0 0 8px;color:#6B7280;font-size:11px;text-transform:uppercase;letter-spacing:.1em;font-weight:700;">Redes sociales</p>'
                . $socialHtml . '</div>';
        }

        $assets = '';
        foreach (['Logo' => $i['logo_url'], 'Foto de perfil' => $i['portrait_url']] as $label => $p) {
            if (!$p) continue;
            $full = e(med_asset_url($p));
            $assets .= '<p style="margin:0 0 6px;font-size:13px;"><strong style="color:#6B7280;">' . e($label) . ':</strong> <a href="' . $full . '" style="color:#F26522;">ver imagen</a></p>';
        }
        if ($assets !== '') {
            $assets = '<div style="margin-top:14px;padding:14px 16px;background:#FAFAF9;border-radius:10px;border:1px solid #E7E5E4;">'
                . '<p style="margin:0 0 8px;color:#6B7280;font-size:11px;text-transform:uppercase;letter-spacing:.1em;font-weight:700;">Archivos subidos</p>'
                . $assets . '</div>';
        }

        $mail  = e($i['email']);
        $when  = e(date('Y-m-d H:i:s'));
        $refE  = e($ref);
        $panel = e(url('/admin/medicos'));

        return <<<HTML
<!doctype html>
<html><body style="margin:0;padding:0;background:#F4F4F5;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#F4F4F5;padding:28px 12px;">
    <tr><td align="center">
      <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#fff;border-radius:14px;overflow:hidden;border:1px solid #E7E5E4;">
        <tr><td style="background:linear-gradient(135deg,#0E9488,#0F766E);padding:24px 28px;">
          <p style="margin:0 0 4px;color:rgba(255,255,255,.8);font-size:11px;letter-spacing:.16em;text-transform:uppercase;font-weight:700;">Nueva web médica · {$refE}</p>
          <h1 style="margin:0;color:#fff;font-size:21px;font-weight:600;letter-spacing:-.4px;">Solicitud de página web</h1>
          <p style="margin:6px 0 0;color:rgba(255,255,255,.85);font-size:13px;">Recibida el {$when}</p>
        </td></tr>
        <tr><td style="padding:22px 28px;">
          <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">{$rows}</table>
          {$clinicHtml}
          {$blocks}
          {$chips}
          {$socialHtml}
          {$assets}
          <div style="margin-top:22px;">
            <a href="mailto:{$mail}" style="display:inline-block;background:#111;color:#fff;text-decoration:none;font-size:14px;font-weight:600;padding:11px 18px;border-radius:9999px;">Responder al médico</a>
            <a href="{$panel}" style="display:inline-block;margin-left:8px;color:#0E9488;text-decoration:none;font-size:14px;font-weight:600;padding:11px 4px;">Ver en el panel →</a>
          </div>
        </td></tr>
      </table>
    </td></tr>
  </table>
</body></html>
HTML;
    }

    private function clientHtml(string $ref, array $i, string $displayName): string
    {
        $name     = e($displayName);
        $refE     = e($ref);
        $plan     = e(self::planName($i['plan']));
        $planCopy = e((string) (self::PLANS[$i['plan']]['tagline'] ?? ''));
        $price    = e(self::planPriceText($i['plan']));
        $delivery = e((string) (self::PLANS[$i['plan']]['delivery'] ?? '—'));
        $spec     = e($this->specialtyLabel($i));
        $site     = e(url('/'));
        $mailTo   = e((string) env('MAIL_TO', 'info@kyrosrd.com'));
        $clinics  = count($i['clinics']);
        $clinicTxt= e($clinics === 1 ? '1 consultorio' : "{$clinics} consultorios");

        return <<<HTML
<!doctype html>
<html><body style="margin:0;padding:0;background:#F4F4F5;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#F4F4F5;padding:28px 12px;">
    <tr><td align="center">
      <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#fff;border-radius:14px;overflow:hidden;border:1px solid #E7E5E4;">
        <tr><td style="background:#0d1420;padding:26px 28px;">
          <h1 style="margin:0;color:#fff;font-size:21px;font-weight:600;letter-spacing:-.4px;">Gracias, {$name}. Ya tenemos todo.</h1>
          <p style="margin:8px 0 0;color:rgba(255,255,255,.65);font-size:14px;line-height:1.6;">
            Tu referencia es <strong style="color:#2DD4BF;">{$refE}</strong>. Revisamos tu información y te contactamos en menos de 24 horas hábiles con la propuesta y el calendario de trabajo.
          </p>
        </td></tr>
        <tr><td style="padding:22px 28px;">
          <p style="margin:0 0 12px;color:#6B7280;font-size:11px;text-transform:uppercase;letter-spacing:.12em;font-weight:700;">Resumen de tu solicitud</p>
          <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
            <tr>
              <td style="padding:9px 0;color:#6B7280;font-size:13px;border-bottom:1px solid #F0EFEE;width:130px;">Especialidad</td>
              <td style="padding:9px 0;color:#111827;font-size:14px;border-bottom:1px solid #F0EFEE;">{$spec}</td>
            </tr>
            <tr>
              <td style="padding:9px 0;color:#6B7280;font-size:13px;border-bottom:1px solid #F0EFEE;">Plan</td>
              <td style="padding:9px 0;color:#111827;font-size:14px;border-bottom:1px solid #F0EFEE;">{$plan} · {$price}</td>
            </tr>
            <tr>
              <td style="padding:9px 0;color:#6B7280;font-size:13px;border-bottom:1px solid #F0EFEE;">Entrega estimada</td>
              <td style="padding:9px 0;color:#111827;font-size:14px;border-bottom:1px solid #F0EFEE;">{$delivery}</td>
            </tr>
            <tr>
              <td style="padding:9px 0;color:#6B7280;font-size:13px;border-bottom:1px solid #F0EFEE;">Consultorios</td>
              <td style="padding:9px 0;color:#111827;font-size:14px;border-bottom:1px solid #F0EFEE;">{$clinicTxt}</td>
            </tr>
          </table>

          <div style="margin-top:18px;padding:16px;background:#F0FDFA;border-radius:10px;border:1px solid #99F6E4;">
            <p style="margin:0 0 6px;color:#0F766E;font-size:11px;text-transform:uppercase;letter-spacing:.1em;font-weight:700;">Qué sigue</p>
            <p style="margin:0;color:#134E4A;font-size:14px;line-height:1.7;">
              1. Revisamos tu información y preparamos la propuesta.<br>
              2. Te llamamos para afinar detalles y confirmar el diseño.<br>
              3. Construimos tu sitio y te mostramos un avance antes de publicarlo.
            </p>
          </div>

          <p style="margin:20px 0 0;color:#6B7280;font-size:13px;line-height:1.65;">
            <strong style="color:#111827;">{$planCopy}</strong><br>
            ¿Se te quedó algo? Responde a este correo y lo sumamos a tu solicitud.
          </p>
          <div style="margin-top:18px;">
            <a href="{$site}" style="display:inline-block;background:#0E9488;color:#fff;text-decoration:none;font-size:14px;font-weight:600;padding:11px 20px;border-radius:9999px;">Conocer KYROS</a>
          </div>
        </td></tr>
        <tr><td style="padding:16px 28px 22px;background:#FAFAF9;border-top:1px solid #E7E5E4;">
          <p style="margin:0;color:#9CA3AF;font-size:12px;line-height:1.6;">
            KYROS Solutions · Santo Domingo, RD<br>
            <a href="mailto:{$mailTo}" style="color:#9CA3AF;">{$mailTo}</a>
          </p>
        </td></tr>
      </table>
    </td></tr>
  </table>
</body></html>
HTML;
    }
}
