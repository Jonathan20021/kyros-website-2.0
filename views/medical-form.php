<?php
require_once base_path('views/partials/icons.php');

$status     = flash('med_status');
$generalErr = flash('med_error');
$errors     = flash('med_errors') ?: [];
$ref        = flash('med_ref');
$sentName   = flash('med_name');
$sentPlan   = flash('med_plan');
$clientMail = flash('med_client_mail');

/** Field error helper. */
$err = fn(string $f): string => $errors[$f] ?? '';

// ── Rehydrate after a validation bounce ──────────────────────
$oldExtras  = array_filter(explode(',', (string) old('extras')));
$oldSocials = json_decode((string) old('socials'), true) ?: [];
$oldClinics = json_decode((string) old('clinics'), true) ?: [];

// The price cards link here as ?plan=chequeo-completo. A previous attempt's
// choice always wins over the query string.
$queryPlan = (string) ($_GET['plan'] ?? '');
if (!isset($plans[$queryPlan])) $queryPlan = '';
$selectedPlan = (string) old('plan', $queryPlan);

// Always render at least one consultorio card; a blank one is the starting state.
if (!$oldClinics) {
    $oldClinics = [[
        'name' => '', 'address' => '', 'suite' => '', 'phone' => '', 'maps' => '',
        // Lun–Vie 08:00–17:00 is the schedule most consultorios actually keep —
        // pre-filling it saves 14 inputs for the majority of doctors.
        'sched' => array_fill_keys(['lun', 'mar', 'mie', 'jue', 'vie'], ['from' => '08:00', 'to' => '17:00']),
    ]];
}

$logoKept     = (string) old('logo_url');
$portraitKept = (string) old('portrait_url');

/**
 * One consultorio card. Shared by the server-rendered list and the <template>
 * the "Agregar consultorio" button clones, so the two can never diverge —
 * the template just passes '__i__' as the index for JS to substitute.
 */
$renderClinic = function ($idx, array $c) use ($days) {
    $n = "clinics[{$idx}]";
    $sched = is_array($c['sched'] ?? null) ? $c['sched'] : [];
    ?>
    <div class="med-clinic" data-clinic>
        <div class="med-clinic__head">
            <span class="med-clinic__badge"><?= icon('map-pin', 'w-3.5 h-3.5') ?><span data-clinic-num>1</span></span>
            <h3 class="med-clinic__title">Consultorio</h3>
            <button type="button" class="med-clinic__remove" data-clinic-remove title="Quitar este consultorio">
                <?= icon('trash', 'w-3.5 h-3.5') ?>
                <span>Quitar</span>
            </button>
        </div>

        <div class="brief-grid-2">
            <div class="brief-field">
                <label class="brief-label">Centro médico o consultorio <span class="req">*</span></label>
                <input type="text" name="<?= $n ?>[name]" class="brief-input" maxlength="160"
                       placeholder="Ej: Centro Médico Real, Torre Profesional" value="<?= e((string) ($c['name'] ?? '')) ?>">
            </div>
            <div class="brief-field">
                <label class="brief-label">Consultorio / suite <span class="brief-optional">Opcional</span></label>
                <input type="text" name="<?= $n ?>[suite]" class="brief-input" maxlength="60"
                       placeholder="Ej: Suite 304, 3er piso" value="<?= e((string) ($c['suite'] ?? '')) ?>">
            </div>
        </div>

        <div class="brief-field">
            <label class="brief-label">Dirección</label>
            <input type="text" name="<?= $n ?>[address]" class="brief-input" maxlength="300"
                   placeholder="Av. Abraham Lincoln #955, Piantini, Santo Domingo" value="<?= e((string) ($c['address'] ?? '')) ?>">
        </div>

        <div class="brief-grid-2">
            <div class="brief-field">
                <label class="brief-label">Teléfono de este consultorio <span class="brief-optional">Opcional</span></label>
                <input type="tel" name="<?= $n ?>[phone]" class="brief-input" maxlength="40"
                       placeholder="(809) 000-0000" value="<?= e((string) ($c['phone'] ?? '')) ?>">
            </div>
            <div class="brief-field">
                <label class="brief-label">Enlace de Google Maps <span class="brief-optional">Opcional</span></label>
                <input type="text" name="<?= $n ?>[maps]" class="brief-input" maxlength="500"
                       placeholder="Pega aquí el enlace de tu ubicación" value="<?= e((string) ($c['maps'] ?? '')) ?>">
            </div>
        </div>

        <div class="med-sched">
            <div class="med-sched__head">
                <span class="brief-label" style="margin-bottom:0;">Horario de consulta</span>
                <button type="button" class="med-sched__copy" data-sched-copy>Aplicar el primer horario a todos</button>
            </div>

            <div class="med-sched__rows">
                <?php foreach ($days as $key => [$short, $full]):
                    $on   = !empty($sched[$key]['from']) && !empty($sched[$key]['to']);
                    $from = (string) ($sched[$key]['from'] ?? '08:00');
                    $to   = (string) ($sched[$key]['to']   ?? '17:00');
                ?>
                    <div class="med-sched__row <?= $on ? 'is-on' : '' ?>" data-sched-row>
                        <label class="med-sched__toggle">
                            <input type="checkbox" name="<?= $n ?>[sched][<?= e($key) ?>][on]" value="1" <?= $on ? 'checked' : '' ?> data-sched-on>
                            <span class="med-sched__box"><?= icon('check', 'w-3 h-3') ?></span>
                            <span class="med-sched__day"><?= e($full) ?></span>
                        </label>
                        <div class="med-sched__times">
                            <input type="time" name="<?= $n ?>[sched][<?= e($key) ?>][from]" value="<?= e($from) ?>" aria-label="<?= e($full) ?> desde">
                            <span class="med-sched__dash">—</span>
                            <input type="time" name="<?= $n ?>[sched][<?= e($key) ?>][to]" value="<?= e($to) ?>" aria-label="<?= e($full) ?> hasta">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php
};
?>

<?php if ($status === 'success'): ?>
<!-- ════════════════════════════════════════════════════════════
     SUCCESS — replaces the form entirely
     ════════════════════════════════════════════════════════════ -->
<section id="gracias" class="relative min-h-[80vh] flex items-center overflow-hidden bg-[#EFEFEF] pt-32 pb-20">
    <div class="hero-canvas" aria-hidden="true">
        <div class="hero-canvas__chroma"></div>
        <div class="hero-canvas__fluted"></div>
        <div class="hero-canvas__grain"></div>
    </div>
    <div class="relative z-20 max-w-[760px] mx-auto px-5 sm:px-8 text-center">
        <span class="brief-check brief-check--med" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 6L9 17l-5-5" class="brief-check__path"/>
            </svg>
        </span>
        <h1 class="font-medium leading-[1.06] tracking-[-0.03em] text-balance mt-8"
            style="color: var(--ink); font-size: clamp(1.9rem, 5.5vw, 3.6rem);">
            Gracias<?= $sentName ? ', ' . e($sentName) : '' ?>.<br>Ya tenemos tu historia clínica digital.
        </h1>
        <p class="mt-5 text-[15px] sm:text-[17px] leading-[1.65] max-w-[560px] mx-auto" style="color: var(--ink-soft);">
            Revisamos tu información y te contactamos en <strong style="color: var(--ink);">menos de 24 horas hábiles</strong>
            con la propuesta<?= $sentPlan && isset($plans[$sentPlan]) ? ' del plan <strong style="color: var(--ink);">' . e($plans[$sentPlan]['name']) . '</strong>' : '' ?> y el calendario de trabajo.
        </p>

        <?php if ($ref): ?>
            <div class="brief-ref mt-8">
                <span class="brief-ref__label">Tu referencia</span>
                <span class="brief-ref__code"><?= e($ref) ?></span>
            </div>
        <?php endif; ?>

        <p class="mt-5 text-[13px]" style="color: var(--ink-muted);">
            <?php if ($clientMail === '1'): ?>
                Te enviamos una copia por correo. Si no la ves, revisa la carpeta de spam.
            <?php else: ?>
                Guarda esta referencia: no pudimos enviarte la copia por correo, pero tu solicitud sí quedó registrada.
            <?php endif; ?>
        </p>

        <div class="mt-10 flex flex-wrap gap-3 justify-center">
            <a href="<?= url('/services/medical-websites') ?>" class="btn-med group">
                <span class="text-roll"><span class="text-roll__inner"><span>Volver al servicio</span><span>Volver al servicio</span></span></span>
                <span class="arrow-circle arrow-circle__med">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-5-5l5 5-5 5"/></svg>
                </span>
            </a>
            <a href="<?= url('/') ?>" class="inline-flex items-center px-5 py-3 text-[14px] font-medium rounded-full border border-[rgba(17,17,17,0.14)] hover:bg-[rgba(17,17,17,0.04)] transition-colors" style="color: var(--ink);">
                Volver al inicio
            </a>
        </div>
    </div>
</section>

<?php else: ?>
<!-- ════════════════════════════════════════════════════════════
     HERO
     ════════════════════════════════════════════════════════════ -->
<section class="relative pt-32 sm:pt-36 pb-12 overflow-hidden bg-[#EFEFEF]">
    <div class="hero-canvas" aria-hidden="true">
        <div class="hero-canvas__chroma"></div>
        <div class="hero-canvas__fluted"></div>
        <div class="hero-canvas__grain"></div>
    </div>
    <div class="relative z-20 max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <div class="section-badge mb-6">
            <span class="section-badge__num">+</span>
            <span class="section-badge__label">Tu página web médica</span>
        </div>
        <div class="grid lg:grid-cols-12 gap-8 items-end">
            <div class="lg:col-span-8">
                <h1 class="font-medium leading-[1.05] tracking-[-0.03em] text-balance"
                    style="color: var(--ink); font-size: clamp(2rem, 6vw, 4.2rem);">
                    Cuéntanos de tu <span class="text-italic-serif" style="color: #0D9488;">práctica</span>.
                </h1>
            </div>
            <div class="lg:col-span-4">
                <p class="text-[15px] sm:text-[16px] leading-[1.65]" style="color: var(--ink-soft);">
                    Cinco pasos, unos 10 minutos. Todo lo que llenes aquí es exactamente lo que llevará tu sitio, así que tómate tu tiempo.
                </p>
                <p class="mt-3 text-[13px] flex items-center gap-2" style="color: var(--ink-muted);">
                    <span class="stat-panel__dot" style="margin-top:0;"></span>
                    Puedes dejarlo a medias: guardamos tu avance en este navegador
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════════
     FORM
     ════════════════════════════════════════════════════════════ -->
<section id="form" class="bg-white pt-10 pb-20 sm:pb-28">
    <div class="brief-shell">

        <!-- ── Sticky rail (desktop) ── -->
        <aside class="brief-rail" aria-hidden="true">
            <div class="brief-rail__inner">
                <ol class="brief-rail__list" data-med-rail></ol>
                <div class="brief-rail__trust">
                    <p class="brief-rail__trust-item">
                        <span class="stat-panel__dot" style="margin-top:0;"></span>
                        Respuesta en &lt; 24 h hábiles
                    </p>
                    <p class="brief-rail__trust-item">
                        <?= icon('shield', 'w-3.5 h-3.5') ?>
                        Tu información no se comparte
                    </p>
                    <p class="brief-rail__trust-item">
                        <?= icon('clock', 'w-3.5 h-3.5') ?>
                        Toma ~10 minutos
                    </p>
                    <p class="brief-rail__trust-item" data-med-saved hidden>
                        <?= icon('check-circle', 'w-3.5 h-3.5') ?>
                        <span>Avance guardado</span>
                    </p>
                </div>
            </div>
        </aside>

        <!-- ── Form column ── -->
        <div class="brief-main">

        <?php if ($generalErr): ?>
            <div class="brief-alert mb-6" role="alert">
                <?= icon('x', 'w-4 h-4') ?>
                <span><?= e((string) $generalErr) ?></span>
            </div>
        <?php endif; ?>
        <?php if ($errors): ?>
            <div class="brief-alert mb-6" role="alert">
                <?= icon('x', 'w-4 h-4') ?>
                <span>Revisa los campos marcados: falta algo por completar.</span>
            </div>
        <?php endif; ?>

        <form id="med-form" method="POST" action="<?= url('/mi-pagina-medica') ?>" enctype="multipart/form-data" novalidate>
            <?= csrf_field() ?>
            <!-- honeypot -->
            <div class="hp-field" aria-hidden="true">
                <label for="fax">No llenar</label>
                <input type="text" id="fax" name="fax" tabindex="-1" autocomplete="off">
            </div>

            <!-- Progress: only meaningful once JS turns this into a wizard -->
            <div class="brief-progress" data-med-progress hidden>
                <div class="brief-progress__head">
                    <span class="brief-progress__count" data-med-count>Paso 1 de 5</span>
                    <span class="brief-progress__pct" data-med-pct>20%</span>
                </div>
                <div class="brief-progress__bar"><span class="brief-progress__fill brief-progress__fill--med" data-med-fill></span></div>
                <div class="brief-progress__steps" data-med-dots></div>
            </div>

            <!-- ══════════════ STEP 1 — IDENTIDAD ══════════════ -->
            <fieldset class="brief-step" data-step="1">
                <legend class="brief-step__legend">
                    <span class="brief-step__num">1</span>
                    <span>
                        <span class="brief-step__title">¿Quién eres?</span>
                        <span class="brief-step__hint">Como quieres que aparezca en tu página.</span>
                    </span>
                </legend>

                <div class="med-name-row">
                    <div class="brief-field">
                        <label class="brief-label" for="title_prefix">Título</label>
                        <select id="title_prefix" name="title_prefix" class="brief-input">
                            <?php foreach ($prefixes as $p): ?>
                                <option value="<?= e($p) ?>" <?= old('title_prefix', 'Dr.') === $p ? 'selected' : '' ?>><?= e($p) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="brief-field">
                        <label class="brief-label" for="full_name">Nombre completo <span class="req">*</span></label>
                        <input type="text" id="full_name" name="full_name" class="brief-input <?= $err('full_name') ? 'is-invalid' : '' ?>"
                               placeholder="Juan Pérez Martínez" maxlength="160" autocomplete="name"
                               value="<?= e((string) old('full_name')) ?>" data-med-required>
                        <?php if ($e = $err('full_name')): ?><p class="brief-err"><?= e($e) ?></p><?php endif; ?>
                    </div>
                </div>

                <div class="brief-field">
                    <label class="brief-label" for="specialty">Especialidad <span class="req">*</span></label>
                    <select id="specialty" name="specialty" class="brief-input <?= $err('specialty') ? 'is-invalid' : '' ?>" data-med-required data-med-specialty>
                        <option value="">Selecciona tu especialidad…</option>
                        <?php foreach ($specialties as $key => $label): ?>
                            <option value="<?= e($key) ?>" <?= old('specialty') === $key ? 'selected' : '' ?>><?= e($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if ($e = $err('specialty')): ?><p class="brief-err"><?= e($e) ?></p><?php endif; ?>
                </div>

                <div class="brief-field" data-med-specialty-other <?= old('specialty') === 'otra' ? '' : 'hidden' ?>>
                    <label class="brief-label" for="specialty_other">¿Cuál es tu especialidad? <span class="req">*</span></label>
                    <input type="text" id="specialty_other" name="specialty_other" class="brief-input <?= $err('specialty_other') ? 'is-invalid' : '' ?>"
                           placeholder="Escríbela tal como quieres que aparezca" maxlength="160"
                           value="<?= e((string) old('specialty_other')) ?>">
                    <?php if ($e = $err('specialty_other')): ?><p class="brief-err"><?= e($e) ?></p><?php endif; ?>
                </div>

                <div class="brief-field">
                    <label class="brief-label" for="subspecialty">Subespecialidad o área de enfoque <span class="brief-optional">Opcional</span></label>
                    <input type="text" id="subspecialty" name="subspecialty" class="brief-input"
                           placeholder="Ej: Cardiología intervencionista · Cirugía de mano · Ortodoncia invisible" maxlength="200"
                           value="<?= e((string) old('subspecialty')) ?>">
                    <p class="brief-hint" style="margin-top:6px;">Si atiendes varias, sepáralas con comas.</p>
                </div>

                <div class="brief-grid-2">
                    <div class="brief-field">
                        <label class="brief-label" for="license">Exequátur / colegiatura <span class="brief-optional">Opcional</span></label>
                        <input type="text" id="license" name="license" class="brief-input"
                               placeholder="Ej: 123456" maxlength="60" value="<?= e((string) old('license')) ?>">
                        <p class="brief-hint" style="margin-top:6px;">Mostrarlo transmite confianza, pero es decisión tuya.</p>
                    </div>
                    <div class="brief-field">
                        <label class="brief-label" for="years_experience">Años de experiencia <span class="brief-optional">Opcional</span></label>
                        <input type="text" id="years_experience" name="years_experience" class="brief-input"
                               placeholder="Ej: 12" maxlength="20" inputmode="numeric" value="<?= e((string) old('years_experience')) ?>">
                    </div>
                </div>
            </fieldset>

            <!-- ══════════════ STEP 2 — CONTACTO ══════════════ -->
            <fieldset class="brief-step" data-step="2">
                <legend class="brief-step__legend">
                    <span class="brief-step__num">2</span>
                    <span>
                        <span class="brief-step__title">¿Cómo te contactan?</span>
                        <span class="brief-step__hint">Estos datos van visibles en tu sitio.</span>
                    </span>
                </legend>

                <div class="brief-grid-2">
                    <div class="brief-field">
                        <label class="brief-label" for="email">Email <span class="req">*</span></label>
                        <input type="email" id="email" name="email" class="brief-input <?= $err('email') ? 'is-invalid' : '' ?>"
                               placeholder="doctor@ejemplo.com" maxlength="180" autocomplete="email"
                               value="<?= e((string) old('email')) ?>" data-med-required>
                        <?php if ($e = $err('email')): ?><p class="brief-err"><?= e($e) ?></p><?php endif; ?>
                    </div>
                    <div class="brief-field">
                        <label class="brief-label" for="phone">Teléfono <span class="req">*</span></label>
                        <input type="tel" id="phone" name="phone" class="brief-input <?= $err('phone') ? 'is-invalid' : '' ?>"
                               placeholder="(809) 000-0000" maxlength="40" autocomplete="tel"
                               value="<?= e((string) old('phone')) ?>" data-med-required>
                        <?php if ($e = $err('phone')): ?><p class="brief-err"><?= e($e) ?></p><?php endif; ?>
                    </div>
                    <div class="brief-field">
                        <label class="brief-label" for="whatsapp">WhatsApp <span class="brief-optional">Si es distinto</span></label>
                        <input type="tel" id="whatsapp" name="whatsapp" class="brief-input"
                               placeholder="(829) 000-0000" maxlength="40" value="<?= e((string) old('whatsapp')) ?>">
                    </div>
                    <div class="brief-field">
                        <label class="brief-label" for="city">Ciudad / provincia <span class="brief-optional">Opcional</span></label>
                        <input type="text" id="city" name="city" class="brief-input"
                               placeholder="Santo Domingo, D.N." maxlength="120" value="<?= e((string) old('city')) ?>">
                    </div>
                </div>

                <div class="brief-field">
                    <span class="brief-label">¿Tienes dominio propio? <span class="brief-optional">Opcional</span></span>
                    <div class="brief-chips">
                        <?php foreach ($domains as $key => $label): ?>
                            <label class="brief-chip brief-chip--med">
                                <input type="radio" name="domain_status" value="<?= e($key) ?>" <?= old('domain_status') === $key ? 'checked' : '' ?> data-med-domain>
                                <span><?= e($label) ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="brief-field" data-med-domain-name <?= old('domain_status') === 'tengo' ? '' : 'hidden' ?>>
                    <label class="brief-label" for="domain_name">¿Cuál es tu dominio?</label>
                    <input type="text" id="domain_name" name="domain_name" class="brief-input"
                           placeholder="drjuanperez.com" maxlength="180" value="<?= e((string) old('domain_name')) ?>">
                </div>

                <div class="brief-field">
                    <span class="brief-label">Redes sociales <span class="brief-optional">Opcional</span></span>
                    <p class="brief-hint" style="margin-bottom:10px;">Las enlazamos desde tu sitio. Deja en blanco las que no uses.</p>
                    <div class="med-socials">
                        <?php foreach ($networks as $key => [$label, $placeholder]): ?>
                            <div class="med-social">
                                <span class="med-social__label"><?= e($label) ?></span>
                                <input type="text" name="social[<?= e($key) ?>]" class="brief-input"
                                       placeholder="<?= e($placeholder) ?>" maxlength="200"
                                       value="<?= e((string) ($oldSocials[$key] ?? '')) ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </fieldset>

            <!-- ══════════════ STEP 3 — TU PERFIL ══════════════ -->
            <fieldset class="brief-step" data-step="3">
                <legend class="brief-step__legend">
                    <span class="brief-step__num">3</span>
                    <span>
                        <span class="brief-step__title">Tu trayectoria</span>
                        <span class="brief-step__hint">El contenido real de tu página. Escribe como le hablarías a un paciente.</span>
                    </span>
                </legend>

                <div class="brief-field">
                    <label class="brief-label" for="bio">Biografía <span class="req">*</span></label>
                    <textarea id="bio" name="bio" rows="5" class="brief-input <?= $err('bio') ? 'is-invalid' : '' ?>"
                              placeholder="Ej: Soy cardiólogo con 15 años de experiencia. Me especializo en el manejo de hipertensión y prevención cardiovascular. Atiendo a mis pacientes con el tiempo que necesitan, sin prisas…"
                              maxlength="3000" data-med-counter data-med-required><?= e((string) old('bio')) ?></textarea>
                    <div class="brief-meta">
                        <?php if ($e = $err('bio')): ?>
                            <span class="brief-err"><?= e($e) ?></span>
                        <?php else: ?>
                            <span class="brief-hint">Mínimo 40 caracteres. No te preocupes por la redacción: la pulimos nosotros.</span>
                        <?php endif; ?>
                        <span class="brief-count" data-count-for="bio">0 / 3000</span>
                    </div>
                </div>

                <div class="brief-field">
                    <label class="brief-label" for="career">Formación y carrera profesional <span class="brief-optional">Recomendado</span></label>
                    <textarea id="career" name="career" rows="4" class="brief-input"
                              placeholder="Ej:&#10;· Doctor en Medicina — UNPHU, 2008&#10;· Residencia en Cardiología — Hospital Salvador B. Gautier, 2013&#10;· Fellowship en Hemodinamia — España, 2015&#10;· Miembro de la Sociedad Dominicana de Cardiología"
                              maxlength="3000"><?= e((string) old('career')) ?></textarea>
                    <p class="brief-hint" style="margin-top:6px;">Una línea por cada estudio, cargo o certificación.</p>
                </div>

                <div class="brief-field">
                    <label class="brief-label" for="services_offered">Servicios y procedimientos que ofreces <span class="brief-optional">Recomendado</span></label>
                    <textarea id="services_offered" name="services_offered" rows="4" class="brief-input"
                              placeholder="Ej:&#10;· Consulta cardiológica&#10;· Electrocardiograma&#10;· Prueba de esfuerzo&#10;· Ecocardiograma doppler&#10;· Monitoreo Holter 24h"
                              maxlength="3000"><?= e((string) old('services_offered')) ?></textarea>
                    <p class="brief-hint" style="margin-top:6px;">Cada uno puede convertirse en una página propia y traerte pacientes desde Google.</p>
                </div>

                <div class="brief-grid-2">
                    <div class="brief-field">
                        <label class="brief-label" for="insurances">Seguros y ARS que aceptas <span class="brief-optional">Opcional</span></label>
                        <textarea id="insurances" name="insurances" rows="3" class="brief-input"
                                  placeholder="Ej: Humano, ARS Palic, Senasa, Universal, Mapfre Salud…"
                                  maxlength="1000"><?= e((string) old('insurances')) ?></textarea>
                    </div>
                    <div class="brief-field">
                        <label class="brief-label" for="languages">Idiomas en que atiendes <span class="brief-optional">Opcional</span></label>
                        <input type="text" id="languages" name="languages" class="brief-input"
                               placeholder="Español, inglés, francés…" maxlength="200" value="<?= e((string) old('languages')) ?>">
                    </div>
                </div>

                <!-- Uploads -->
                <div class="brief-field">
                    <span class="brief-label">Tu logo y tu foto <span class="brief-optional">Opcional</span></span>
                    <p class="brief-hint" style="margin-bottom:12px;">Si no tienes logo, no te preocupes: lo diseñamos contigo. JPG, PNG o WEBP, máximo 5 MB cada uno.</p>

                    <div class="med-uploads">
                        <?php foreach ([
                            ['field' => 'logo',     'kept' => $logoKept,     'keptName' => 'logo_kept',     'label' => 'Logo',           'hint' => 'Tu marca o el logo de tu consultorio'],
                            ['field' => 'portrait', 'kept' => $portraitKept, 'keptName' => 'portrait_kept', 'label' => 'Foto de perfil', 'hint' => 'Preferiblemente con bata, fondo claro'],
                        ] as $u): ?>
                            <div class="med-drop <?= $u['kept'] ? 'has-file' : '' ?>" data-drop>
                                <input type="file" name="<?= e($u['field']) ?>" id="med-<?= e($u['field']) ?>" accept="image/jpeg,image/png,image/webp,image/avif" data-drop-input>
                                <input type="hidden" name="<?= e($u['keptName']) ?>" value="<?= e($u['kept']) ?>" data-drop-kept>

                                <label for="med-<?= e($u['field']) ?>" class="med-drop__zone">
                                    <span class="med-drop__icon"><?= icon('upload', 'w-5 h-5') ?></span>
                                    <span class="med-drop__label"><?= e($u['label']) ?></span>
                                    <span class="med-drop__hint"><?= e($u['hint']) ?></span>
                                    <span class="med-drop__action">Elegir archivo o arrastrarlo aquí</span>
                                </label>

                                <div class="med-drop__preview" data-drop-preview>
                                    <img src="<?= $u['kept'] ? e(med_asset_url($u['kept'])) : '' ?>" alt="" data-drop-img>
                                    <div class="med-drop__file">
                                        <span class="med-drop__name" data-drop-name><?= $u['kept'] ? 'Imagen cargada' : '' ?></span>
                                        <button type="button" class="med-drop__clear" data-drop-clear>Quitar</button>
                                    </div>
                                </div>
                                <?php if ($e = $err($u['field'])): ?><p class="brief-err"><?= e($e) ?></p><?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </fieldset>

            <!-- ══════════════ STEP 4 — CONSULTORIOS ══════════════ -->
            <fieldset class="brief-step" data-step="4">
                <legend class="brief-step__legend">
                    <span class="brief-step__num">4</span>
                    <span>
                        <span class="brief-step__title">¿Dónde y cuándo atiendes?</span>
                        <span class="brief-step__hint">Agrega todos los centros donde pasas consulta.</span>
                    </span>
                </legend>

                <?php if ($e = $err('clinics')): ?><p class="brief-err" style="margin-bottom:12px;"><?= e($e) ?></p><?php endif; ?>

                <div data-clinic-list>
                    <?php foreach ($oldClinics as $i => $c) $renderClinic($i, $c); ?>
                </div>

                <button type="button" class="med-add" data-clinic-add>
                    <?= icon('plus', 'w-4 h-4') ?>
                    Agregar otro consultorio
                </button>

                <template data-clinic-template>
                    <?php $renderClinic('__i__', ['name' => '', 'address' => '', 'suite' => '', 'phone' => '', 'maps' => '', 'sched' => []]); ?>
                </template>
            </fieldset>

            <!-- ══════════════ STEP 5 — PLAN ══════════════ -->
            <fieldset class="brief-step" data-step="5">
                <legend class="brief-step__legend">
                    <span class="brief-step__num">5</span>
                    <span>
                        <span class="brief-step__title">Tu plan</span>
                        <span class="brief-step__hint">Puedes cambiarlo después: esto solo nos orienta.</span>
                    </span>
                </legend>

                <div class="brief-field">
                    <span class="brief-label">¿Cuál plan te interesa? <span class="req">*</span></span>
                    <div class="med-plan-pick">
                        <?php foreach ($plans as $key => $p): ?>
                            <label class="med-pick">
                                <input type="radio" name="plan" value="<?= e($key) ?>" <?= $selectedPlan === $key ? 'checked' : '' ?> data-med-required-group="plan">
                                <span class="med-pick__box">
                                    <span class="med-pick__tick"><?= icon('check', 'w-3 h-3') ?></span>
                                    <?php if ($p['popular']): ?><span class="med-pick__flag">Más pedido</span><?php endif; ?>
                                    <span class="med-pick__name"><?= e($p['name']) ?></span>
                                    <span class="med-pick__price"><?= e(MedicalSiteController::planPriceText($key)) ?></span>
                                    <span class="med-pick__desc"><?= e($p['blurb']) ?></span>
                                    <span class="med-pick__meta"><?= e($p['pages']) ?> · entrega en <?= e($p['delivery']) ?></span>
                                </span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <?php if ($e = $err('plan')): ?><p class="brief-err"><?= e($e) ?></p><?php endif; ?>
                    <p class="brief-hint" style="margin-top:10px;">
                        ¿Dudas entre dos? <a href="<?= url('/services/medical-websites#planes') ?>" target="_blank" rel="noopener" style="color: var(--ink); text-decoration: underline; text-underline-offset: 2px;">Compara los planes</a> y vuelve: guardamos lo que llevas escrito.
                    </p>
                </div>

                <div class="brief-field">
                    <span class="brief-label">¿Qué te gustaría que tenga? <span class="brief-optional">Marca todo lo que aplique</span></span>
                    <div class="med-extras">
                        <?php foreach ($extras as $key => [$label, $desc]): ?>
                            <label class="brief-card">
                                <input type="checkbox" name="extras[]" value="<?= e($key) ?>" <?= in_array($key, $oldExtras, true) ? 'checked' : '' ?>>
                                <span class="brief-card__box">
                                    <span class="brief-card__tick" aria-hidden="true">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                                    </span>
                                    <span class="brief-card__label"><?= e($label) ?></span>
                                    <span class="brief-card__desc"><?= e($desc) ?></span>
                                </span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="brief-field">
                    <span class="brief-label">¿Cómo prefieres recibir las citas? <span class="brief-optional">Opcional</span></span>
                    <div class="brief-chips">
                        <?php foreach ($booking as $key => $label): ?>
                            <label class="brief-chip brief-chip--med">
                                <input type="radio" name="booking" value="<?= e($key) ?>" <?= old('booking') === $key ? 'checked' : '' ?>>
                                <span><?= e($label) ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="brief-field">
                    <span class="brief-label">¿Para cuándo la necesitas? <span class="brief-optional">Opcional</span></span>
                    <div class="brief-chips">
                        <?php foreach ($launch as $key => $label): ?>
                            <label class="brief-chip brief-chip--med">
                                <input type="radio" name="launch_when" value="<?= e($key) ?>" <?= old('launch_when') === $key ? 'checked' : '' ?>>
                                <span><?= e($label) ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="brief-field">
                    <label class="brief-label" for="design_refs">Páginas que te gustan <span class="brief-optional">Opcional</span></label>
                    <input type="text" id="design_refs" name="design_refs" class="brief-input"
                           placeholder="Pega una o dos direcciones de webs que te gusten" maxlength="500"
                           value="<?= e((string) old('design_refs')) ?>">
                    <p class="brief-hint" style="margin-top:6px;">Pueden ser de cualquier rubro. Nos ayuda a entender tu gusto en 5 segundos.</p>
                </div>

                <div class="brief-field">
                    <label class="brief-label" for="notes">Algo más que debamos saber <span class="brief-optional">Opcional</span></label>
                    <textarea id="notes" name="notes" rows="3" class="brief-input"
                              placeholder="Cualquier detalle: convenios, otro idioma, una fecha importante, algo que no te gustó de una web anterior…"
                              maxlength="2000"><?= e((string) old('notes')) ?></textarea>
                </div>

                <p class="brief-privacy">
                    Al enviar aceptas nuestra <a href="<?= url('/privacy') ?>">política de privacidad</a>. Usamos tu información únicamente para construir tu sitio y contactarte; no la compartimos con terceros.
                </p>
            </fieldset>

            <!-- Nav — JS swaps in Atrás/Continuar; without JS it's a single submit -->
            <div class="brief-nav">
                <button type="button" class="brief-btn brief-btn--ghost" data-med-prev hidden>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5m5 5l-5-5 5-5"/></svg>
                    Atrás
                </button>
                <div class="brief-nav__spacer"></div>
                <button type="button" class="brief-btn brief-btn--med" data-med-next hidden>
                    Continuar
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-5-5l5 5-5 5"/></svg>
                </button>
                <button type="submit" class="brief-btn brief-btn--med" data-med-submit>
                    <span data-med-submit-label>Enviar mi solicitud</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-5-5l5 5-5 5"/></svg>
                </button>
            </div>
        </form>
        </div><!-- /brief-main -->
    </div>
</section>
<?php endif; ?>
