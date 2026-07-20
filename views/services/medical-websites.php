<?php
require_once base_path('views/partials/icons.php');

/**
 * Páginas web para médicos.
 *
 * Standalone rather than the shared service-detail partial: this page has to
 * carry a price table, a specialty index and a "what a patient finds today"
 * comparison, and the section order that sells it (problem → solution → price)
 * is not the order that partial renders. It reuses the same design-system
 * classes so it still reads as one of the service pages.
 */

$fg = '#0D9488';   // teal-600 — clinical, and unused by the other five services
$bg = '#F0FDFA';
$bd = '#99F6E4';

$plans  = MedicalSiteController::PLANS;
$addons = MedicalSiteController::ADDONS;
$specs  = MedicalSiteController::SPECIALTIES;
$fx     = Fx::usdToDop();

$formUrl = url('/mi-pagina-medica');
?>

<!-- ════════════════════════════════════════════════════════════
     HERO
     ════════════════════════════════════════════════════════════ -->
<section id="svc-hero" class="relative pt-32 sm:pt-36 pb-20 overflow-hidden bg-[#EFEFEF]">
    <div class="hero-canvas" aria-hidden="true">
        <div class="hero-canvas__chroma"></div>
        <canvas id="svc-scene" class="svc-scene" data-scene="medical" data-accent="13, 148, 136"></canvas>
        <div class="hero-canvas__fluted"></div>
        <div class="hero-canvas__grain"></div>
    </div>

    <div class="relative z-20 max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <a href="<?= url('/services') ?>" class="inline-flex items-center gap-2 text-[13px] font-mono mb-10 transition-colors hover:text-[#0D9488]" style="color: var(--ink-soft);">
            ← Volver a servicios
        </a>

        <div class="grid lg:grid-cols-12 gap-10 items-end">
            <div class="lg:col-span-8">
                <div class="inline-flex items-center gap-2 mb-7 px-3 py-1.5 rounded-full text-[12px] font-medium" style="background: <?= $bg ?>; color: <?= $fg ?>; border: 1px solid <?= $bd ?>;">
                    <span class="w-1.5 h-1.5 rounded-full" style="background: <?= $fg ?>;"></span>
                    Páginas web para el sector salud
                </div>
                <h1 class="font-medium leading-[1.05] tracking-[-0.03em] text-balance"
                    style="color: var(--ink); font-size: clamp(2rem, 5.5vw, 4.2rem);">
                    Tus pacientes te buscan en Google.<br>
                    <span class="text-italic-serif" style="color: <?= $fg ?>;">Que te encuentren</span>.
                </h1>
                <p class="text-[16px] sm:text-[17px] leading-[1.6] max-w-2xl mt-7" style="color: var(--ink-soft);">
                    Sitios web para médicos, especialistas, odontólogos, psicólogos y centros de salud. Tu trayectoria, tus consultorios, tus horarios y un botón para pedir cita —
                    en una página que se ve tan profesional como tu consulta.
                </p>

                <div class="flex flex-wrap items-center gap-3 sm:gap-4 mt-9">
                    <a href="<?= e($formUrl) ?>" class="btn-med group">
                        <span class="text-roll">
                            <span class="text-roll__inner">
                                <span>Solicitar mi página</span>
                                <span>Solicitar mi página</span>
                            </span>
                        </span>
                        <span class="arrow-circle arrow-circle__med">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-5-5l5 5-5 5"/></svg>
                        </span>
                    </a>
                    <a href="#planes" class="inline-flex items-center gap-2 px-5 py-3 rounded-full text-[14px] font-medium bg-white border border-[rgba(17,17,17,0.10)] hover:border-[#0D9488] transition-colors" style="color: var(--ink);">
                        Ver planes y precios
                    </a>
                </div>
            </div>

            <div class="lg:col-span-4">
                <div class="rounded-2xl p-7 border border-[rgba(17,17,17,0.08)] relative overflow-hidden" style="background: #fff; box-shadow: 0 12px 28px -8px rgba(0,0,0,0.08);">
                    <div class="absolute -top-12 -right-12 w-56 h-56 rounded-full" style="background: <?= $fg ?>; opacity: 0.12; filter: blur(40px);"></div>
                    <div class="relative">
                        <span class="w-12 h-12 rounded-xl flex items-center justify-center mb-5" style="background: <?= $bg ?>; color: <?= $fg ?>; border: 1px solid <?= $bd ?>;">
                            <?= icon('stethoscope', 'w-6 h-6') ?>
                        </span>
                        <h3 class="font-medium text-[16px] tracking-tight mb-1" style="color: var(--ink);">Por qué importa</h3>
                        <p class="text-[12px] font-mono mb-5" style="color: var(--ink-muted);">Cómo elige un paciente hoy</p>

                        <div class="grid grid-cols-2 gap-3">
                            <?php foreach ([
                                ['77%', 'Busca en internet antes de pedir cita'],
                                ['1ro',  'El sitio propio manda sobre los directorios'],
                                ['7 días', 'Desde la primera versión en línea'],
                                ['24/7', 'Tu consulta, siempre visible'],
                            ] as $m): ?>
                                <div class="p-3.5 rounded-xl border border-[rgba(17,17,17,0.06)] bg-[#FAFAFA]">
                                    <div class="text-[clamp(1.4rem,2.5vw,1.9rem)] font-medium tracking-[-0.03em] leading-none mb-2" style="color: <?= $fg ?>;"><?= e($m[0]) ?></div>
                                    <div class="text-[10px] font-mono uppercase tracking-[0.16em] leading-snug" style="color: var(--ink-muted);"><?= e($m[1]) ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════════
     THE REALITY CHECK — sin web vs. con web
     ════════════════════════════════════════════════════════════ -->
<section class="bg-white py-16 sm:py-20 lg:py-24">
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-12 gap-10 mb-12 items-end">
            <div class="lg:col-span-7">
                <div class="section-badge mb-6">
                    <span class="section-badge__num">1</span>
                    <span class="section-badge__label">La realidad</span>
                </div>
                <h2 class="font-medium leading-[1.05] tracking-[-0.03em] text-balance"
                    style="color: var(--ink); font-size: clamp(1.75rem, 4vw, 3rem);">
                    Qué encuentra un paciente <em class="text-italic-serif" style="color: <?= $fg ?>;">cuando busca tu nombre</em>.
                </h2>
            </div>
            <div class="lg:col-span-4 lg:col-start-9">
                <p class="text-[15px] leading-relaxed" style="color: var(--ink-soft);">
                    Antes de llamar a tu consultorio, el paciente ya te buscó. Lo que ve en esos 30 segundos decide si marca el teléfono o sigue de largo.
                </p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-5">
            <!-- Sin web -->
            <div class="med-compare med-compare--bad">
                <div class="med-compare__head">
                    <span class="med-compare__dot"></span>
                    <span class="med-compare__label">Hoy, sin página propia</span>
                </div>
                <ul class="med-compare__list">
                    <?php foreach ([
                        'Un perfil de directorio con datos desactualizados de hace tres años',
                        'Un número de teléfono que ya no usas',
                        'Reseñas que no controlas, en un sitio que no es tuyo',
                        'Ninguna mención de tu especialidad, tus estudios ni tu experiencia',
                        'Horarios incorrectos: el paciente llega y el consultorio está cerrado',
                        'Tu competencia aparece primero, con foto y con sitio web',
                    ] as $item): ?>
                        <li>
                            <span class="med-compare__icon"><?= icon('x', 'w-3 h-3') ?></span>
                            <?= e($item) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Con web -->
            <div class="med-compare med-compare--good">
                <div class="med-compare__head">
                    <span class="med-compare__dot"></span>
                    <span class="med-compare__label">Con tu página de KYROS</span>
                </div>
                <ul class="med-compare__list">
                    <?php foreach ([
                        'Tu nombre, tu foto y tu especialidad, con la información que tú decides',
                        'Tu trayectoria completa: formación, certificaciones y años de experiencia',
                        'Todos tus consultorios con dirección, mapa y horarios reales',
                        'Un botón de WhatsApp que abre el chat contigo, sin intermediarios',
                        'Los seguros y ARS que aceptas, respondidos antes de que pregunten',
                        'Apareces en Google Maps y en las búsquedas de tu especialidad en tu ciudad',
                    ] as $item): ?>
                        <li>
                            <span class="med-compare__icon"><?= icon('check', 'w-3 h-3') ?></span>
                            <?= e($item) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════════
     FEATURES
     ════════════════════════════════════════════════════════════ -->
<section id="incluye" class="bg-[#F5F5F5] py-16 sm:py-20 lg:py-24 border-y border-[rgba(17,17,17,0.06)]">
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-12 gap-10 mb-12 items-end">
            <div class="lg:col-span-7">
                <div class="section-badge mb-6">
                    <span class="section-badge__num">2</span>
                    <span class="section-badge__label">Lo que construimos</span>
                </div>
                <h2 class="font-medium leading-[1.05] tracking-[-0.03em] text-balance"
                    style="color: var(--ink); font-size: clamp(1.75rem, 4vw, 3rem);">
                    Pensado para <em class="text-italic-serif" style="color: <?= $fg ?>;">consulta médica</em>, no para una tienda.
                </h2>
            </div>
            <div class="lg:col-span-4 lg:col-start-9">
                <p class="text-[15px] leading-relaxed" style="color: var(--ink-soft);">
                    No adaptamos una plantilla genérica. Cada sección existe porque un paciente la busca antes de decidir.
                </p>
            </div>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5" data-fluid-stagger>
            <?php foreach ([
                ['icon' => 'users',      'title' => 'Tu perfil profesional',   'desc' => 'Foto, biografía, especialidad y subespecialidad, exequátur, universidades y certificaciones. La confianza empieza aquí.'],
                ['icon' => 'map-pin',    'title' => 'Consultorios y horarios', 'desc' => 'Todas tus sedes con dirección, número de consultorio, mapa y el horario real de cada día de la semana.'],
                ['icon' => 'calendar',   'title' => 'Solicitud de citas',      'desc' => 'WhatsApp directo, formulario que te llega al correo o agenda en línea con confirmación automática. Tú eliges.'],
                ['icon' => 'search',     'title' => 'SEO médico local',        'desc' => 'Optimizada para "tu especialidad + tu ciudad" y conectada a Google Business para salir en el mapa.'],
                ['icon' => 'smartphone', 'title' => 'Impecable en celular',    'desc' => 'Ocho de cada diez pacientes te van a ver desde el teléfono. Ahí es donde más cuidamos el diseño.'],
                ['icon' => 'shield',     'title' => 'Discreta y segura',       'desc' => 'Certificado SSL, formularios cifrados y aviso de privacidad. Ningún dato de paciente queda expuesto.'],
            ] as $i => $f): ?>
                <div class="svc-feature rounded-2xl p-6 bg-white border border-[rgba(17,17,17,0.06)] hover:shadow-[0_8px_24px_rgba(0,0,0,0.06)] transition-all">
                    <span class="w-10 h-10 rounded-xl flex items-center justify-center mb-5" style="background: <?= $bg ?>; color: <?= $fg ?>; border: 1px solid <?= $bd ?>;">
                        <?= icon($f['icon'], 'w-5 h-5') ?>
                    </span>
                    <span class="text-[11px] font-mono mb-2 block" style="color: var(--ink-muted);">0<?= $i + 1 ?></span>
                    <h3 class="font-medium text-[17px] tracking-tight mb-2" style="color: var(--ink);"><?= e($f['title']) ?></h3>
                    <p class="text-[13.5px] leading-relaxed" style="color: var(--ink-muted);"><?= e($f['desc']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════════
     PLANES
     ════════════════════════════════════════════════════════════ -->
<section id="planes" class="bg-white py-16 sm:py-20 lg:py-24" data-med-pricing>
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">

        <div class="grid lg:grid-cols-12 gap-10 mb-12 items-end">
            <div class="lg:col-span-7">
                <div class="section-badge mb-6">
                    <span class="section-badge__num">3</span>
                    <span class="section-badge__label">Planes</span>
                </div>
                <h2 class="font-medium leading-[1.05] tracking-[-0.03em] text-balance"
                    style="color: var(--ink); font-size: clamp(1.75rem, 4vw, 3rem);">
                    Elige tu <em class="text-italic-serif" style="color: <?= $fg ?>;">tratamiento</em>.
                </h2>
                <p class="text-[15px] leading-relaxed mt-5 max-w-xl" style="color: var(--ink-soft);">
                    Precio cerrado, sin sorpresas y sin mensualidades obligatorias. Lo que ves es lo que pagas.
                </p>
            </div>
            <div class="lg:col-span-4 lg:col-start-9 lg:text-right">
                <div class="inline-flex flex-col items-start lg:items-end gap-2">
                    <div class="brief-cur" role="group" aria-label="Moneda">
                        <button type="button" class="brief-cur__btn is-active" data-cur-btn="DOP" aria-pressed="true">RD$</button>
                        <button type="button" class="brief-cur__btn" data-cur-btn="USD" aria-pressed="false">US$</button>
                    </div>
                    <p class="text-[11.5px] leading-[1.5]" style="color: var(--ink-quiet, rgba(15,15,20,0.40));">
                        <span data-cur="DOP">Referencia: US$1 = RD$<?= e(number_format((float) $fx['rate'], 2)) ?><?= $fx['stale'] ? ' (tasa de referencia)' : '' ?></span>
                        <span data-cur="USD" hidden>Se factura en pesos dominicanos.</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Build plans -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5 items-stretch" data-fluid-stagger>
            <?php foreach ($plans as $key => $p): ?>
                <div class="med-plan <?= $p['popular'] ? 'med-plan--popular' : '' ?>">
                    <?php if ($p['popular']): ?>
                        <span class="med-plan__flag">El más pedido</span>
                    <?php endif; ?>

                    <div class="med-plan__top">
                        <h3 class="med-plan__name"><?= e($p['name']) ?></h3>
                        <p class="med-plan__tagline"><?= e($p['tagline']) ?></p>

                        <div class="med-plan__price">
                            <span data-cur="DOP"><?= e(MedicalSiteController::formatDop($p['price'])) ?></span>
                            <span data-cur="USD" hidden><?= e(MedicalSiteController::formatUsd($p['price'])) ?></span>
                        </div>
                        <p class="med-plan__unit"><?= e($p['unit']) ?></p>

                        <?php /* Always rendered — the "sin mensualidad" case keeps the three
                                 cards aligned and is itself worth saying out loud. */ ?>
                        <?php if (!empty($p['price_monthly'])): ?>
                            <p class="med-plan__monthly">
                                <span class="med-plan__monthly-plus">+</span>
                                <strong>
                                    <span data-cur="DOP"><?= e(MedicalSiteController::formatDop($p['price_monthly'])) ?></span>
                                    <span data-cur="USD" hidden><?= e(MedicalSiteController::formatUsd($p['price_monthly'])) ?></span>
                                </strong>
                                al mes de mantenimiento
                            </p>
                        <?php else: ?>
                            <p class="med-plan__monthly med-plan__monthly--none">
                                <?= icon('check', 'w-3 h-3') ?>
                                Sin mensualidad obligatoria
                            </p>
                        <?php endif; ?>

                        <div class="med-plan__meta">
                            <span><?= icon('file-text', 'w-3.5 h-3.5') ?> <?= e($p['pages']) ?></span>
                            <span><?= icon('clock', 'w-3.5 h-3.5') ?> Entrega en <?= e($p['delivery']) ?></span>
                        </div>

                        <a href="<?= e($formUrl . '?plan=' . $key) ?>" class="med-plan__cta">
                            Elegir <?= e($p['name']) ?>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-5-5l5 5-5 5"/></svg>
                        </a>
                    </div>

                    <ul class="med-plan__list">
                        <?php foreach ($p['features'] as $f): ?>
                            <li>
                                <span class="med-plan__tick"><?= icon('check', 'w-3 h-3') ?></span>
                                <span><?= e($f) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Add-ons -->
        <div class="mt-6 grid md:grid-cols-2 gap-5">
            <?php foreach ($addons as $a): ?>
                <div class="med-addon">
                    <div class="med-addon__head">
                        <span class="med-addon__icon"><?= icon($a['icon'], 'w-5 h-5') ?></span>
                        <div class="flex-1 min-w-0">
                            <h3 class="med-addon__name"><?= e($a['name']) ?></h3>
                            <p class="med-addon__tagline"><?= e($a['tagline']) ?></p>
                        </div>
                        <div class="med-addon__price">
                            <span data-cur="DOP"><?= e(MedicalSiteController::formatDop($a['price'])) ?></span>
                            <span data-cur="USD" hidden><?= e(MedicalSiteController::formatUsd($a['price'])) ?></span>
                            <em><?= e($a['unit']) ?></em>
                        </div>
                    </div>
                    <ul class="med-addon__list">
                        <?php foreach ($a['features'] as $f): ?>
                            <li><span class="med-addon__tick"><?= icon('check', 'w-3 h-3') ?></span><?= e($f) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>

        <p class="mt-7 text-[13px] leading-relaxed max-w-3xl" style="color: var(--ink-muted);">
            Todos los precios incluyen diseño, desarrollo, contenido maquetado y publicación. El mantenimiento cuesta lo mismo en todos los casos:
            <strong style="color: var(--ink);">RD$3,200 al mes</strong>, el plan <strong style="color: var(--ink);">Signos Vitales</strong>.
            <strong style="color: var(--ink);">Consulta Express</strong> lo lleva incluido desde el primer día — así baja la entrada a RD$12,900.
            En <strong style="color: var(--ink);">Chequeo Completo</strong> y <strong style="color: var(--ink);">Cirugía Mayor</strong> el primer año de dominio y hosting ya va incluido y no hay mensualidad obligatoria:
            a partir del segundo año los renuevas por tu cuenta o los dejas en nuestras manos.
            ¿Tu caso no encaja en ningún plan? <a href="<?= url('/contact') ?>" class="underline underline-offset-2" style="color: var(--ink);">Escríbenos</a> y lo cotizamos aparte.
        </p>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════════
     ESPECIALIDADES
     ════════════════════════════════════════════════════════════ -->
<section class="bg-[#F5F5F5] py-16 sm:py-20 border-y border-[rgba(17,17,17,0.06)]">
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-12 gap-10">
            <div class="lg:col-span-5">
                <div class="section-badge mb-6">
                    <span class="section-badge__num">4</span>
                    <span class="section-badge__label">Especialidades</span>
                </div>
                <h2 class="font-medium leading-[1.05] tracking-[-0.03em] text-balance mb-5"
                    style="color: var(--ink); font-size: clamp(1.5rem, 3vw, 2.5rem);">
                    Trabajamos con <em class="text-italic-serif" style="color: <?= $fg ?>;">todo el sector salud</em>.
                </h2>
                <p class="text-[14.5px] leading-relaxed mb-6" style="color: var(--ink-soft);">
                    Cada especialidad tiene su propia manera de explicarse a un paciente. Un cardiólogo no comunica igual que un cirujano plástico,
                    y una clínica dental no se presenta como un psicólogo. Adaptamos el lenguaje, las secciones y las fotos a lo tuyo.
                </p>
                <a href="<?= e($formUrl) ?>" class="btn-med group inline-flex">
                    <span class="text-roll">
                        <span class="text-roll__inner">
                            <span>Empezar mi solicitud</span>
                            <span>Empezar mi solicitud</span>
                        </span>
                    </span>
                    <span class="arrow-circle arrow-circle__med">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-5-5l5 5-5 5"/></svg>
                    </span>
                </a>
            </div>
            <div class="lg:col-span-7">
                <div class="med-specs">
                    <?php foreach ($specs as $key => $label):
                        if ($key === 'otra') continue; ?>
                        <span class="med-spec"><?= e($label) ?></span>
                    <?php endforeach; ?>
                    <span class="med-spec med-spec--more">y tu especialidad también</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════════
     PROCESO
     ════════════════════════════════════════════════════════════ -->
<section class="bg-white py-16 sm:py-20 lg:py-24">
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-12 gap-10 mb-12 items-end">
            <div class="lg:col-span-7">
                <div class="section-badge mb-6">
                    <span class="section-badge__num">5</span>
                    <span class="section-badge__label">Cómo trabajamos</span>
                </div>
                <h2 class="font-medium leading-[1.05] tracking-[-0.03em] text-balance"
                    style="color: var(--ink); font-size: clamp(1.75rem, 4vw, 3rem);">
                    De la solicitud <em class="text-italic-serif" style="color: <?= $fg ?>;">al alta</em>.
                </h2>
            </div>
            <div class="lg:col-span-4 lg:col-start-9">
                <p class="text-[15px] leading-relaxed" style="color: var(--ink-soft);">
                    Tu única tarea real es el primer paso. El resto lo llevamos nosotros y solo te pedimos que apruebes.
                </p>
            </div>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5" data-fluid-stagger>
            <?php foreach ([
                ['num' => '01', 'title' => 'Historia clínica',  'desc' => 'Llenas el formulario con tus datos, tu trayectoria, tus consultorios y tu logo. Toma unos 10 minutos.'],
                ['num' => '02', 'title' => 'Diagnóstico',       'desc' => 'Te llamamos, afinamos detalles y te enviamos la propuesta con el diseño y el calendario.'],
                ['num' => '03', 'title' => 'Tratamiento',       'desc' => 'Construimos el sitio, redactamos los textos y preparamos las fotos. Te mostramos un avance antes de publicar.'],
                ['num' => '04', 'title' => 'Alta médica',       'desc' => 'Publicamos, conectamos Google, te entregamos los accesos y te capacitamos para moverte solo.'],
            ] as $p): ?>
                <div class="svc-process rounded-2xl p-6 bg-white border border-[rgba(17,17,17,0.06)] relative overflow-hidden">
                    <span class="absolute top-4 right-5 text-[60px] font-medium tracking-[-0.04em] leading-none" style="color: <?= $bg ?>;"><?= e($p['num']) ?></span>
                    <div class="relative">
                        <span class="text-[10px] font-mono tracking-[0.22em] mb-2 block" style="color: <?= $fg ?>;">FASE <?= e($p['num']) ?></span>
                        <h3 class="font-medium text-[17px] tracking-tight mb-3" style="color: var(--ink);"><?= e($p['title']) ?></h3>
                        <p class="text-[13.5px] leading-relaxed" style="color: var(--ink-muted);"><?= e($p['desc']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════════
     FAQ
     ════════════════════════════════════════════════════════════ -->
<section class="bg-[#F5F5F5] py-16 sm:py-20 border-y border-[rgba(17,17,17,0.06)]">
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-12 gap-12">
            <div class="lg:col-span-4">
                <div class="lg:sticky lg:top-28">
                    <div class="section-badge mb-6">
                        <span class="section-badge__num">6</span>
                        <span class="section-badge__label">FAQ</span>
                    </div>
                    <h2 class="font-medium leading-[1.05] tracking-tight text-balance mb-5"
                        style="color: var(--ink); font-size: clamp(1.5rem, 3vw, 2.2rem);">
                        Resolvamos tus <em class="text-italic-serif" style="color: <?= $fg ?>;">dudas</em>.
                    </h2>
                    <p class="text-[14.5px] leading-relaxed" style="color: var(--ink-soft);">
                        ¿No encuentras tu pregunta? Escríbenos por WhatsApp y te respondemos el mismo día.
                    </p>
                </div>
            </div>
            <div class="lg:col-span-8 space-y-3" data-fluid-stagger>
                <?php foreach ([
                    ['¿Necesito saber de tecnología para tener mi página?', 'Para nada. Llenas un formulario contándonos de ti, tu consulta y tus horarios, y nosotros nos encargamos del resto: diseño, textos, dominio, hosting, correo y publicación. Al final te damos una capacitación de 30 minutos para que sepas dónde está todo.'],
                    ['¿Qué pasa si no tengo logo ni fotos profesionales?', 'No es un problema. Si no tienes logo, lo diseñamos contigo dentro del proyecto. Y si no tienes fotos, te damos una guía de cómo tomarlas con el celular para que se vean bien, o coordinamos una sesión con un fotógrafo si lo prefieres.'],
                    ['¿Puedo actualizar mis horarios o textos después?', 'Sí. En el plan Cirugía Mayor tienes un panel propio para editar todo tú mismo. En los otros planes, el plan de mantenimiento Signos Vitales incluye hasta dos cambios de contenido al mes; y si prefieres no contratarlo, cualquier cambio puntual se cotiza aparte sin compromiso.'],
                    ['¿Los datos de mis pacientes están seguros?', 'Sí. Los formularios van cifrados por SSL y llegan directo a tu correo: no almacenamos información clínica en el sitio. Incluimos el aviso de privacidad correspondiente y, si manejas datos sensibles, adaptamos el flujo para que ninguno quede guardado en la web.'],
                    ['Ya tengo una página, pero es vieja. ¿La rehacen?', 'Sí, y es de los trabajos más comunes que hacemos. Migramos tu contenido, conservamos tu dominio y tu posicionamiento en Google, y te entregamos un sitio nuevo. Si tu web está caída, hackeada o perdiste los accesos, el plan Código Azul es exactamente para eso.'],
                    ['¿Cuánto tiempo toma realmente?', 'Depende del plan: 7 días para Consulta Express, 15 para Chequeo Completo y 30 para Cirugía Mayor. El reloj empieza cuando recibimos tu contenido aprobado. La demora más común no es técnica: es esperar las fotos y los textos, así que mientras antes los tengas, antes sales.'],
                    ['¿Tengo que pagar todo por adelantado?', 'No. Se trabaja con 50% para arrancar y 50% contra entrega, antes de publicar. Aceptamos transferencia bancaria y tarjeta. Si necesitas factura con comprobante fiscal, la emitimos sin problema.'],
                    ['Somos varios médicos en un mismo centro. ¿Cómo funciona?', 'El plan Cirugía Mayor está hecho para eso: un sitio del centro con un perfil individual para cada especialista, sus horarios y su propio botón de contacto. Cada médico se puede compartir su perfil como si fuera su página personal.'],
                ] as [$q, $a]): ?>
                    <div data-faq class="faq-item">
                        <button data-faq-btn class="w-full flex items-center justify-between gap-4 p-5 text-left">
                            <span class="font-medium text-[16px] pr-4" style="color: var(--ink);"><?= e($q) ?></span>
                            <span data-faq-icon class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 transition-transform bg-[#FAFAFA]" style="color: var(--ink-soft);">
                                <?= icon('chevron-down', 'w-4 h-4') ?>
                            </span>
                        </button>
                        <div data-faq-body class="overflow-hidden transition-[max-height] duration-300" style="max-height:0">
                            <p class="px-5 pb-5 text-[14px] leading-relaxed" style="color: var(--ink-soft);"><?= e($a) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════════
     CTA + RELATED
     ════════════════════════════════════════════════════════════ -->
<section class="bg-white py-16 sm:py-20 lg:py-24">
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-3 gap-5">
            <div class="lg:col-span-2 relative rounded-3xl overflow-hidden p-10 sm:p-12 bg-[#EFEFEF]">
                <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
                    <div class="hero-canvas__chroma"></div>
                    <div class="hero-canvas__grain"></div>
                </div>
                <div class="relative z-10 max-w-xl">
                    <div class="section-badge mb-6">
                        <span class="section-badge__num">!</span>
                        <span class="section-badge__label">Empezar</span>
                    </div>
                    <h2 class="font-medium leading-[1.05] tracking-[-0.03em] text-balance mb-5"
                        style="color: var(--ink); font-size: clamp(1.5rem, 3.4vw, 2.5rem);">
                        Diez minutos hoy. Tu página <em class="text-italic-serif" style="color: <?= $fg ?>;">esta semana</em>.
                    </h2>
                    <p class="text-[15px] leading-[1.6] max-w-lg mb-7" style="color: var(--ink-soft);">
                        Llena el formulario con tu información profesional y tus consultorios. Te respondemos en menos de 24 horas hábiles con la propuesta lista.
                    </p>
                    <a href="<?= e($formUrl) ?>" class="btn-med group inline-flex">
                        <span class="text-roll">
                            <span class="text-roll__inner">
                                <span>Solicitar mi página web</span>
                                <span>Solicitar mi página web</span>
                            </span>
                        </span>
                        <span class="arrow-circle arrow-circle--lg arrow-circle__med">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-5-5l5 5-5 5"/></svg>
                        </span>
                    </a>
                </div>
            </div>

            <div class="rounded-2xl p-6 bg-white border border-[rgba(17,17,17,0.08)]">
                <p class="text-[11px] font-mono uppercase tracking-[0.22em] mb-5" style="color: var(--ink-muted);">Otros servicios</p>
                <div class="space-y-2">
                    <?php foreach ([
                        ['slug' => 'social-media',        'icon' => 'share',   'title' => 'Redes Sociales'],
                        ['slug' => 'software-development','icon' => 'code',    'title' => 'Desarrollo de Software'],
                        ['slug' => 'technical-support',   'icon' => 'headset', 'title' => 'Soporte & Helpdesk'],
                    ] as $r): ?>
                        <a href="<?= url('/services/' . $r['slug']) ?>" class="flex items-center gap-3 p-3 rounded-xl bg-[#FAFAFA] hover:bg-[#F0FDFA] transition-colors group">
                            <span class="w-9 h-9 rounded-lg flex items-center justify-center" style="background: #fff; color: <?= $fg ?>; border: 1px solid <?= $bd ?>;">
                                <?= icon($r['icon'], 'w-4 h-4') ?>
                            </span>
                            <span class="font-medium text-[13.5px] flex-grow tracking-tight" style="color: var(--ink);"><?= e($r['title']) ?></span>
                            <span class="text-[var(--ink-quiet)] group-hover:text-[#0D9488] group-hover:translate-x-1 transition-all">
                                <?= icon('arrow-right', 'w-4 h-4') ?>
                            </span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
/* Currency toggle for the price table. Both label sets are already in the DOM,
   so switching costs no request and cannot lose scroll position. */
(() => {
  const root = document.querySelector('[data-med-pricing]');
  if (!root) return;
  const btns = [...document.querySelectorAll('[data-cur-btn]')];
  const set = (cur) => {
    document.querySelectorAll('[data-cur]').forEach(el => { el.hidden = el.dataset.cur !== cur; });
    btns.forEach(b => {
      const on = b.dataset.curBtn === cur;
      b.classList.toggle('is-active', on);
      b.setAttribute('aria-pressed', on ? 'true' : 'false');
    });
  };
  btns.forEach(b => b.addEventListener('click', () => set(b.dataset.curBtn)));
})();
</script>
