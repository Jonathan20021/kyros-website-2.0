<?php
declare(strict_types=1);

require_once base_path('app/mailer.php');
require_once base_path('app/rate_limit.php');
require_once base_path('app/fx.php');

/**
 * "Hablemos del proyecto" — full project brief.
 *
 * Flow: validate → store in `leads` → notify admin → confirm to client.
 * The lead is saved BEFORE the emails go out, so a mail outage can never
 * lose a request: it still lands in the admin panel.
 */
class BriefController
{
    /* ── Option catalog ──────────────────────────────────────────
       Single source of truth: the view renders from it and submit()
       validates against it, so the two can never drift apart. */

    public const SERVICES = [
        'software'   => ['Desarrollo de software',     'Apps web, plataformas SaaS y sistemas empresariales a medida.'],
        'landing'    => ['Landing page / sitio web',   'Sitios corporativos y landings orientadas a conversión.'],
        'seguridad'  => ['Ciberseguridad',             'Pentesting, hardening, monitoreo y respuesta a incidentes.'],
        'redes'      => ['Infraestructura de redes',   'Cableado certificado, WiFi 6, firewalls y VPN.'],
        'soporte'    => ['Soporte 24/7',               'Mesa de ayuda con SLA contractual.'],
        'social'     => ['Manejo de redes sociales',   'Contenido, community management y campañas para tu marca.'],
        'otro'       => ['Otro / no estoy seguro',     'Cuéntanos la necesidad y te orientamos.'],
    ];

    /**
     * Budget bands in USD: [minUsd, maxUsd]; null = open-ended.
     *
     * The stored value is always the KEY, never a formatted amount — so a
     * moving exchange rate can never reinterpret an existing lead. Currency
     * only ever affects how a band is *displayed*.
     */
    public const BUDGET_BANDS = [
        'lt-5k'   => [null,   5000],
        '5k-15k'  => [5000,  15000],
        '15k-40k' => [15000, 40000],
        'gt-40k'  => [40000,  null],
        'no-idea' => [null,   null],
    ];

    public const CURRENCIES = ['DOP', 'USD'];

    /** Label for one band in the given currency. */
    public static function budgetLabel(string $key, string $currency = 'DOP'): string
    {
        if (!isset(self::BUDGET_BANDS[$key])) return '—';
        [$min, $max] = self::BUDGET_BANDS[$key];
        if ($min === null && $max === null) return 'Aún no lo defino';

        $fmt = function (int $usd) use ($currency): string {
            if ($currency === 'USD') return Fx::formatUsd($usd);
            $fx = Fx::usdToDop();
            return Fx::formatDop(Fx::roundDop($usd * $fx['rate']));
        };

        if ($min === null) return 'Menos de ' . $fmt((int) $max);
        if ($max === null) return 'Más de '   . $fmt((int) $min);
        return $fmt((int) $min) . ' — ' . $fmt((int) $max);
    }

    /** @return array<string,string> key => label, for rendering the chips. */
    public static function budgetOptions(string $currency = 'DOP'): array
    {
        $out = [];
        foreach (array_keys(self::BUDGET_BANDS) as $key) {
            $out[$key] = self::budgetLabel($key, $currency);
        }
        return $out;
    }

    /** Both currencies — used in emails and the admin panel. */
    public static function budgetLabelBoth(string $key): string
    {
        if (!isset(self::BUDGET_BANDS[$key])) return '—';
        [$min, $max] = self::BUDGET_BANDS[$key];
        if ($min === null && $max === null) return 'Aún no lo defino';
        return self::budgetLabel($key, 'DOP') . ' (' . self::budgetLabel($key, 'USD') . ')';
    }

    public const TIMELINES = [
        'urgente'  => 'Lo antes posible',
        '1-3m'     => 'En 1 — 3 meses',
        '3-6m'     => 'En 3 — 6 meses',
        'explorar' => 'Solo estoy explorando',
    ];

    public const EXISTING = [
        'no'     => 'Empezamos desde cero',
        'si'     => 'Ya tengo algo funcionando',
        'rehacer'=> 'Tengo algo, quiero rehacerlo',
    ];

    public const HEARD_FROM = [
        'google'      => 'Google',
        'redes'       => 'Redes sociales',
        'recomendado' => 'Me lo recomendaron',
        'evento'      => 'Un evento',
        'otro'        => 'Otro',
    ];

    public function show(): void
    {
        // Both label sets ship in the HTML so the currency toggle needs no
        // reload (which would lose form state) and no JS to show RD$ first.
        render_view('brief', [
            'services'   => self::SERVICES,
            'budgetsDop' => self::budgetOptions('DOP'),
            'budgetsUsd' => self::budgetOptions('USD'),
            'fx'         => Fx::usdToDop(),
            'timelines'  => self::TIMELINES,
            'existing'   => self::EXISTING,
            'heardFrom'  => self::HEARD_FROM,
        ], [
            'title'       => 'Hablemos del proyecto · KYROS Solutions',
            'description' => 'Cuéntanos qué necesitas construir. Respondemos en menos de 24 horas hábiles con próximos pasos concretos.',
        ]);
    }

    /**
     * Normalise a posted field to valid UTF-8.
     *
     * A client that posts Latin-1/cp1252 (some bots, some old clients) would
     * otherwise take down the whole request: the utf8mb4 INSERT throws AND
     * json_encode() returns false inside Mailer, so the lead would be lost
     * twice over. Recover the text instead of dropping the lead.
     */
    private static function clean($value): string
    {
        $v = trim((string) $value);
        if ($v !== '' && !mb_check_encoding($v, 'UTF-8')) {
            $v = mb_convert_encoding($v, 'UTF-8', 'Windows-1252');
        }
        // Strip control chars (keep tab/newline) that MySQL/JSON dislike.
        return (string) preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $v);
    }

    public function submit(): void
    {
        $services = $_POST['services'] ?? [];
        if (!is_array($services)) $services = [];
        // Keep only known keys — never trust the posted list.
        $services = array_values(array_intersect($services, array_keys(self::SERVICES)));

        $input = [
            'name'         => self::clean($_POST['name']         ?? ''),
            'email'        => self::clean($_POST['email']        ?? ''),
            'company'      => self::clean($_POST['company']      ?? ''),
            'phone'        => self::clean($_POST['phone']        ?? ''),
            'description'  => self::clean($_POST['description']  ?? ''),
            'goals'        => self::clean($_POST['goals']        ?? ''),
            'features'     => self::clean($_POST['features']     ?? ''),
            'existing_url' => self::clean($_POST['existing_url'] ?? ''),
            'has_existing' => self::clean($_POST['has_existing'] ?? ''),
            'budget'       => self::clean($_POST['budget']       ?? ''),
            'timeline'     => self::clean($_POST['timeline']     ?? ''),
            'heard_from'   => self::clean($_POST['heard_from']   ?? ''),
            'services'     => $services,
            // Which currency the client was looking at — only affects how we
            // phrase their confirmation email; the band itself is currency-free.
            'currency'     => in_array($_POST['currency'] ?? '', self::CURRENCIES, true)
                                ? (string) $_POST['currency'] : 'DOP',
        ];

        // 1. Honeypot — real users never fill this.
        if (!empty($_POST['website'])) {
            flash('brief_status', 'success');
            redirect('/hablemos#gracias');
        }

        // 2. CSRF
        if (!csrf_check((string)($_POST['_csrf'] ?? ''))) {
            flash('brief_status', 'error');
            flash('brief_error', 'La sesión expiró. Recarga la página e inténtalo de nuevo.');
            set_old($this->flatten($input));
            redirect('/hablemos#form');
        }

        // 3. Validation
        $errors = $this->validate($input);
        if ($errors) {
            flash('brief_status', 'error');
            flash('brief_errors', $errors);
            set_old($this->flatten($input));
            redirect('/hablemos#form');
        }

        // 4. Rate limit per IP
        $max    = (int) env('BRIEF_RATE_LIMIT_MAX', 5);
        $window = (int) env('BRIEF_RATE_LIMIT_WINDOW', 3600);
        if (!RateLimit::hit('brief', $max, $window)) {
            flash('brief_status', 'error');
            flash('brief_error', 'Has enviado demasiadas solicitudes. Intenta de nuevo en una hora.');
            set_old($this->flatten($input));
            redirect('/hablemos#form');
        }

        // 5. Persist first — a mail failure must never lose the lead.
        $ref = Lead::makeRef();
        $row = [
            'ref'          => $ref,
            'name'         => $input['name'],
            'email'        => $input['email'],
            'company'      => $input['company'],
            'phone'        => $input['phone'],
            'services'     => implode(',', $input['services']),
            'project_type' => self::SERVICES[$input['services'][0]][0] ?? null,
            'description'  => $input['description'],
            'goals'        => $input['goals'],
            'features'     => $input['features'],
            'has_existing' => $input['has_existing'],
            'existing_url' => $input['existing_url'],
            'budget'       => $input['budget'],
            'timeline'     => $input['timeline'],
            'heard_from'   => $input['heard_from'],
            'ip'           => client_ip(),
            'user_agent'   => substr((string)($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255),
        ];

        $leadId = 0;
        $stored = true;
        try {
            $leadId = Lead::create($row);
        } catch (Throwable $e) {
            // DB down — carry on and let the emails be the record of the lead.
            $stored = false;
            error_log('[brief] no se pudo guardar el lead: ' . $e->getMessage());
        }

        // 6. Notify admin + confirm to client.
        $adminRes = Mailer::send([
            'to'       => env('MAIL_TO', 'info@kyrosrd.com'),
            'reply_to' => $input['email'],
            'subject'  => "[{$ref}] Nueva solicitud: {$input['name']}" . ($input['company'] ? " · {$input['company']}" : ''),
            'html'     => $this->adminHtml($row, $input),
        ]);

        $clientRes = Mailer::send([
            'to'       => $input['email'],
            'reply_to' => env('MAIL_TO', 'info@kyrosrd.com'),
            'subject'  => "Recibimos tu solicitud · {$ref}",
            'html'     => $this->clientHtml($row, $input),
        ]);

        if ($stored && $leadId) {
            try {
                Lead::markMail($leadId, (bool) $adminRes['ok'], (bool) $clientRes['ok']);
            } catch (Throwable $e) {
                error_log('[brief] no se pudo marcar el estado de correo: ' . $e->getMessage());
            }
        }

        // Only a total failure (nothing stored AND admin mail failed) is fatal:
        // that is the one case where the request would vanish silently.
        if (!$stored && !$adminRes['ok']) {
            flash('brief_status', 'error');
            flash('brief_error', 'No pudimos registrar tu solicitud: ' . $adminRes['error'] . ' Escríbenos a ' . env('MAIL_TO', 'info@kyrosrd.com') . '.');
            set_old($this->flatten($input));
            redirect('/hablemos#form');
        }

        clear_old();
        flash('brief_status', 'success');
        flash('brief_ref', $ref);
        flash('brief_name', $input['name']);
        flash('brief_client_mail', $clientRes['ok'] ? '1' : '0');
        redirect('/hablemos#gracias');
    }

    /** old() only stores scalars — services[] is rejoined for redisplay. */
    private function flatten(array $input): array
    {
        $flat = $input;
        $flat['services'] = implode(',', $input['services']);
        return $flat;
    }

    /** @return array<string,string> */
    private function validate(array $i): array
    {
        $errors = [];

        if (!$i['services']) {
            $errors['services'] = 'Selecciona al menos un servicio.';
        }
        if (mb_strlen($i['name']) < 2) {
            $errors['name'] = 'Ingresa tu nombre completo.';
        }
        if (!filter_var($i['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Ingresa un email válido.';
        }
        if (mb_strlen($i['description']) < 20) {
            $errors['description'] = 'Cuéntanos un poco más: mínimo 20 caracteres.';
        }
        foreach (['budget' => self::BUDGET_BANDS, 'timeline' => self::TIMELINES] as $f => $opts) {
            if ($i[$f] === '' || !isset($opts[$i[$f]])) {
                $errors[$f] = 'Selecciona una opción.';
            }
        }
        // Optional selects: only validate when the user actually chose something.
        foreach (['has_existing' => self::EXISTING, 'heard_from' => self::HEARD_FROM] as $f => $opts) {
            if ($i[$f] !== '' && !isset($opts[$i[$f]])) {
                $errors[$f] = 'Selecciona una opción válida.';
            }
        }
        if ($i['existing_url'] !== '' && !filter_var($i['existing_url'], FILTER_VALIDATE_URL)) {
            $errors['existing_url'] = 'Ingresa una URL válida (https://…).';
        }
        foreach (['name' => 120, 'company' => 160, 'phone' => 40, 'existing_url' => 500,
                  'description' => 4000, 'goals' => 2000, 'features' => 2000] as $f => $max) {
            if (mb_strlen($i[$f]) > $max) {
                $errors[$f] = "Máximo {$max} caracteres.";
            }
        }
        return $errors;
    }

    /** Labels for the chosen service keys. */
    private function serviceLabels(array $keys): string
    {
        $out = [];
        foreach ($keys as $k) {
            if (isset(self::SERVICES[$k])) $out[] = self::SERVICES[$k][0];
        }
        return $out ? implode(', ', $out) : '—';
    }

    private function adminHtml(array $row, array $input): string
    {
        $fields = [
            'Referencia' => $row['ref'],
            'Nombre'     => $input['name'],
            'Email'      => $input['email'],
            'Empresa'    => $input['company'] ?: '—',
            'Teléfono'   => $input['phone'] ?: '—',
            'Servicios'  => $this->serviceLabels($input['services']),
            'Presupuesto'=> self::budgetLabelBoth($input['budget']),
            'Plazo'      => self::TIMELINES[$input['timeline']] ?? '—',
            'Punto de partida' => self::EXISTING[$input['has_existing']] ?? '—',
            'URL actual' => $input['existing_url'] ?: '—',
            'Nos conoció por' => self::HEARD_FROM[$input['heard_from']] ?? '—',
        ];

        $rows = '';
        foreach ($fields as $label => $val) {
            $rows .= '<tr>'
                . '<td style="padding:9px 14px;color:#6B7280;font-size:12px;border-bottom:1px solid #E7E5E4;width:150px;font-weight:600;vertical-align:top;">' . e($label) . '</td>'
                . '<td style="padding:9px 14px;color:#111827;font-size:14px;border-bottom:1px solid #E7E5E4;">' . e((string) $val) . '</td>'
                . '</tr>';
        }

        $blocks = '';
        foreach (['Descripción' => $input['description'], 'Objetivos' => $input['goals'], 'Funcionalidades' => $input['features']] as $label => $text) {
            if (trim((string) $text) === '') continue;
            $blocks .= '<div style="margin-top:16px;padding:16px;background:#FAFAF9;border-radius:10px;border:1px solid #E7E5E4;">'
                . '<p style="margin:0 0 6px;color:#6B7280;font-size:11px;text-transform:uppercase;letter-spacing:.1em;font-weight:700;">' . e($label) . '</p>'
                . '<div style="color:#1F2937;font-size:14px;line-height:1.65;">' . nl2br(e((string) $text)) . '</div>'
                . '</div>';
        }

        $mail  = e((string) $input['email']);
        $ip    = e((string) $row['ip']);
        $when  = e(date('Y-m-d H:i:s'));
        $ref   = e($row['ref']);
        $panel = e(url('/admin/leads'));

        return <<<HTML
<!doctype html>
<html><body style="margin:0;padding:0;background:#F4F4F5;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#F4F4F5;padding:28px 12px;">
    <tr><td align="center">
      <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#fff;border-radius:14px;overflow:hidden;border:1px solid #E7E5E4;">
        <tr><td style="background:linear-gradient(135deg,#F26522,#C44A0F);padding:24px 28px;">
          <p style="margin:0 0 4px;color:rgba(255,255,255,.8);font-size:11px;letter-spacing:.16em;text-transform:uppercase;font-weight:700;">Nueva solicitud · {$ref}</p>
          <h1 style="margin:0;color:#fff;font-size:21px;font-weight:600;letter-spacing:-.4px;">Hablemos del proyecto</h1>
          <p style="margin:6px 0 0;color:rgba(255,255,255,.85);font-size:13px;">Recibido el {$when}</p>
        </td></tr>
        <tr><td style="padding:22px 28px;">
          <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">{$rows}</table>
          {$blocks}
          <div style="margin-top:22px;">
            <a href="mailto:{$mail}" style="display:inline-block;background:#111;color:#fff;text-decoration:none;font-size:14px;font-weight:600;padding:11px 18px;border-radius:9999px;">Responder al cliente</a>
            <a href="{$panel}" style="display:inline-block;margin-left:8px;color:#F26522;text-decoration:none;font-size:14px;font-weight:600;padding:11px 4px;">Ver en el panel →</a>
          </div>
        </td></tr>
        <tr><td style="padding:14px 28px 22px;background:#FAFAF9;border-top:1px solid #E7E5E4;">
          <p style="margin:0;color:#9CA3AF;font-size:11px;">IP: {$ip}</p>
        </td></tr>
      </table>
    </td></tr>
  </table>
</body></html>
HTML;
    }

    private function clientHtml(array $row, array $input): string
    {
        $name     = e($input['name']);
        $ref      = e($row['ref']);
        $svc      = e($this->serviceLabels($input['services']));
        $budget   = e(self::budgetLabel($input['budget'], $input['currency']));
        $timeline = e(self::TIMELINES[$input['timeline']] ?? '—');
        $desc     = nl2br(e((string) $input['description']));
        $site     = e(url('/'));
        $mailTo   = e((string) env('MAIL_TO', 'info@kyrosrd.com'));

        return <<<HTML
<!doctype html>
<html><body style="margin:0;padding:0;background:#F4F4F5;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#F4F4F5;padding:28px 12px;">
    <tr><td align="center">
      <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#fff;border-radius:14px;overflow:hidden;border:1px solid #E7E5E4;">
        <tr><td style="background:#0d1420;padding:26px 28px;">
          <h1 style="margin:0;color:#fff;font-size:21px;font-weight:600;letter-spacing:-.4px;">Gracias, {$name}. Recibimos tu solicitud.</h1>
          <p style="margin:8px 0 0;color:rgba(255,255,255,.65);font-size:14px;line-height:1.6;">
            Tu referencia es <strong style="color:#F26522;">{$ref}</strong>. Un miembro del equipo la revisa y te responde en menos de 24 horas hábiles con próximos pasos concretos.
          </p>
        </td></tr>
        <tr><td style="padding:22px 28px;">
          <p style="margin:0 0 12px;color:#6B7280;font-size:11px;text-transform:uppercase;letter-spacing:.12em;font-weight:700;">Resumen de lo que nos enviaste</p>
          <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
            <tr>
              <td style="padding:9px 0;color:#6B7280;font-size:13px;border-bottom:1px solid #F0EFEE;width:130px;">Servicios</td>
              <td style="padding:9px 0;color:#111827;font-size:14px;border-bottom:1px solid #F0EFEE;">{$svc}</td>
            </tr>
            <tr>
              <td style="padding:9px 0;color:#6B7280;font-size:13px;border-bottom:1px solid #F0EFEE;">Presupuesto</td>
              <td style="padding:9px 0;color:#111827;font-size:14px;border-bottom:1px solid #F0EFEE;">{$budget}</td>
            </tr>
            <tr>
              <td style="padding:9px 0;color:#6B7280;font-size:13px;border-bottom:1px solid #F0EFEE;">Plazo</td>
              <td style="padding:9px 0;color:#111827;font-size:14px;border-bottom:1px solid #F0EFEE;">{$timeline}</td>
            </tr>
          </table>
          <div style="margin-top:16px;padding:16px;background:#FAFAF9;border-radius:10px;border:1px solid #E7E5E4;">
            <p style="margin:0 0 6px;color:#6B7280;font-size:11px;text-transform:uppercase;letter-spacing:.1em;font-weight:700;">Tu proyecto</p>
            <div style="color:#1F2937;font-size:14px;line-height:1.65;">{$desc}</div>
          </div>
          <p style="margin:20px 0 0;color:#6B7280;font-size:13px;line-height:1.65;">
            ¿Quieres agregar algo? Responde a este correo y se suma a tu solicitud.
          </p>
          <div style="margin-top:18px;">
            <a href="{$site}" style="display:inline-block;background:#F26522;color:#fff;text-decoration:none;font-size:14px;font-weight:600;padding:11px 20px;border-radius:9999px;">Ver nuestro trabajo</a>
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
