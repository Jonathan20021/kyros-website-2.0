<?php
require_once base_path('views/partials/icons.php');

$status     = flash('brief_status');
$generalErr = flash('brief_error');
$errors     = flash('brief_errors') ?: [];
$ref        = flash('brief_ref');
$sentName   = flash('brief_name');
$clientMail = flash('brief_client_mail');

// Re-check previously selected services after a validation bounce.
$oldServices = array_filter(explode(',', (string) old('services')));

/** Field error helper. */
$err = function (string $f) use ($errors): string {
    return $errors[$f] ?? '';
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
        <span class="brief-check" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 6L9 17l-5-5" class="brief-check__path"/>
            </svg>
        </span>
        <h1 class="font-medium leading-[1.06] tracking-[-0.03em] text-balance mt-8"
            style="color: var(--ink); font-size: clamp(1.9rem, 5.5vw, 3.6rem);">
            Gracias<?= $sentName ? ', ' . e(explode(' ', (string) $sentName)[0]) : '' ?>.<br>Ya tenemos tu proyecto.
        </h1>
        <p class="mt-5 text-[15px] sm:text-[17px] leading-[1.65] max-w-[520px] mx-auto" style="color: var(--ink-soft);">
            Un miembro del equipo revisa tu solicitud y te responde en <strong style="color: var(--ink);">menos de 24 horas hábiles</strong> con próximos pasos concretos.
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
            <a href="<?= url('/proyectos') ?>" class="btn-dark group">
                <span class="text-roll"><span class="text-roll__inner"><span>Ver nuestro trabajo</span><span>Ver nuestro trabajo</span></span></span>
                <span class="arrow-circle">
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
            <span class="section-badge__num">→</span>
            <span class="section-badge__label">Hablemos del proyecto</span>
        </div>
        <div class="grid lg:grid-cols-12 gap-8 items-end">
            <div class="lg:col-span-8">
                <h1 class="font-medium leading-[1.05] tracking-[-0.03em] text-balance"
                    style="color: var(--ink); font-size: clamp(2rem, 6vw, 4.2rem);">
                    Cuéntanos qué<br>vamos a construir.
                </h1>
            </div>
            <div class="lg:col-span-4">
                <p class="text-[15px] sm:text-[16px] leading-[1.65]" style="color: var(--ink-soft);">
                    Toma unos 2 minutos. Mientras más contexto nos des, más concreta será nuestra respuesta.
                </p>
                <p class="mt-3 text-[13px] flex items-center gap-2" style="color: var(--ink-muted);">
                    <span class="stat-panel__dot" style="margin-top:0;"></span>
                    Respondemos en menos de 24 horas hábiles
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
                <ol class="brief-rail__list" data-brief-rail></ol>
                <div class="brief-rail__trust">
                    <p class="brief-rail__trust-item">
                        <span class="stat-panel__dot" style="margin-top:0;"></span>
                        Respuesta en &lt; 24 h hábiles
                    </p>
                    <p class="brief-rail__trust-item">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Tus datos no se comparten
                    </p>
                    <p class="brief-rail__trust-item">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        Toma ~2 minutos
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

        <form id="brief-form" method="POST" action="<?= url('/hablemos') ?>" novalidate>
            <?= csrf_field() ?>
            <!-- honeypot -->
            <div class="hp-field" aria-hidden="true">
                <label for="website">No llenar</label>
                <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
            </div>
            <!-- Currency the user is viewing; RD$ unless they toggle. -->
            <input type="hidden" name="currency" id="brief-currency" value="DOP">

            <!-- Progress: only meaningful once JS turns this into a wizard -->
            <div class="brief-progress" data-brief-progress hidden>
                <div class="brief-progress__head">
                    <span class="brief-progress__count" data-brief-count>Paso 1 de 4</span>
                    <span class="brief-progress__pct" data-brief-pct>25%</span>
                </div>
                <div class="brief-progress__bar"><span class="brief-progress__fill" data-brief-fill></span></div>
                <div class="brief-progress__steps" data-brief-dots></div>
            </div>

            <!-- ── STEP 1 ── -->
            <fieldset class="brief-step" data-step="1">
                <legend class="brief-step__legend">
                    <span class="brief-step__num">1</span>
                    <span>
                        <span class="brief-step__title">¿Qué necesitas?</span>
                        <span class="brief-step__hint">Elige uno o varios servicios.</span>
                    </span>
                </legend>

                <div class="brief-cards" role="group" aria-label="Servicios">
                    <?php foreach ($services as $key => [$label, $desc]):
                        $checked = in_array($key, $oldServices, true);
                    ?>
                        <label class="brief-card">
                            <input type="checkbox" name="services[]" value="<?= e($key) ?>" <?= $checked ? 'checked' : '' ?> data-brief-required-group="services">
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
                <?php if ($e = $err('services')): ?><p class="brief-err"><?= e($e) ?></p><?php endif; ?>
            </fieldset>

            <!-- ── STEP 2 ── -->
            <fieldset class="brief-step" data-step="2">
                <legend class="brief-step__legend">
                    <span class="brief-step__num">2</span>
                    <span>
                        <span class="brief-step__title">Cuéntanos del proyecto</span>
                        <span class="brief-step__hint">Sin tecnicismos: en tus palabras.</span>
                    </span>
                </legend>

                <div class="brief-field">
                    <label class="brief-label" for="description">¿Qué quieres construir? <span class="req">*</span></label>
                    <textarea id="description" name="description" rows="5" class="brief-input <?= $err('description') ? 'is-invalid' : '' ?>"
                              placeholder="Ej: Necesitamos un sistema para gestionar inventario y facturación de 3 sucursales, con reportes por sucursal."
                              maxlength="4000" data-brief-counter data-brief-required><?= e((string) old('description')) ?></textarea>
                    <div class="brief-meta">
                        <?php if ($e = $err('description')): ?><span class="brief-err"><?= e($e) ?></span><?php else: ?><span class="brief-hint">Mínimo 20 caracteres.</span><?php endif; ?>
                        <span class="brief-count" data-count-for="description">0 / 4000</span>
                    </div>
                </div>

                <div class="brief-field">
                    <label class="brief-label" for="goals">¿Qué problema resuelve? <span class="brief-optional">Opcional</span></label>
                    <textarea id="goals" name="goals" rows="3" class="brief-input <?= $err('goals') ? 'is-invalid' : '' ?>"
                              placeholder="Ej: Hoy lo llevamos en Excel y perdemos horas cuadrando inventario."
                              maxlength="2000"><?= e((string) old('goals')) ?></textarea>
                    <?php if ($e = $err('goals')): ?><p class="brief-err"><?= e($e) ?></p><?php endif; ?>
                </div>

                <div class="brief-field">
                    <label class="brief-label" for="features">Funcionalidades clave <span class="brief-optional">Opcional</span></label>
                    <textarea id="features" name="features" rows="3" class="brief-input <?= $err('features') ? 'is-invalid' : '' ?>"
                              placeholder="Ej: login por roles, facturación, reportes en PDF, app móvil…"
                              maxlength="2000"><?= e((string) old('features')) ?></textarea>
                    <?php if ($e = $err('features')): ?><p class="brief-err"><?= e($e) ?></p><?php endif; ?>
                </div>

                <div class="brief-field">
                    <span class="brief-label">¿Partimos de cero? <span class="brief-optional">Opcional</span></span>
                    <div class="brief-chips">
                        <?php foreach ($existing as $key => $label): ?>
                            <label class="brief-chip">
                                <input type="radio" name="has_existing" value="<?= e($key) ?>" <?= old('has_existing') === $key ? 'checked' : '' ?>>
                                <span><?= e($label) ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <?php if ($e = $err('has_existing')): ?><p class="brief-err"><?= e($e) ?></p><?php endif; ?>
                </div>

                <div class="brief-field">
                    <label class="brief-label" for="existing_url">Si ya tienes algo, ¿cuál es la URL? <span class="brief-optional">Opcional</span></label>
                    <input type="url" id="existing_url" name="existing_url" class="brief-input <?= $err('existing_url') ? 'is-invalid' : '' ?>"
                           placeholder="https://tusitio.com" maxlength="500" value="<?= e((string) old('existing_url')) ?>">
                    <?php if ($e = $err('existing_url')): ?><p class="brief-err"><?= e($e) ?></p><?php endif; ?>
                </div>
            </fieldset>

            <!-- ── STEP 3 ── -->
            <fieldset class="brief-step" data-step="3">
                <legend class="brief-step__legend">
                    <span class="brief-step__num">3</span>
                    <span>
                        <span class="brief-step__title">Alcance</span>
                        <span class="brief-step__hint">Nos ayuda a proponerte algo realista, no a encarecer nada.</span>
                    </span>
                </legend>

                <div class="brief-field">
                    <div class="brief-label-row">
                        <span class="brief-label" style="margin-bottom:0;">Presupuesto estimado <span class="req">*</span></span>
                        <div class="brief-cur" role="group" aria-label="Moneda">
                            <button type="button" class="brief-cur__btn is-active" data-cur-btn="DOP" aria-pressed="true">RD$</button>
                            <button type="button" class="brief-cur__btn" data-cur-btn="USD" aria-pressed="false">US$</button>
                        </div>
                    </div>

                    <div class="brief-chips">
                        <?php foreach ($budgetsDop as $key => $labelDop): ?>
                            <label class="brief-chip brief-chip--budget">
                                <input type="radio" name="budget" value="<?= e($key) ?>" <?= old('budget') === $key ? 'checked' : '' ?> data-brief-required-group="budget">
                                <span>
                                    <span data-cur="DOP"><?= e($labelDop) ?></span>
                                    <span data-cur="USD" hidden><?= e($budgetsUsd[$key] ?? $labelDop) ?></span>
                                </span>
                            </label>
                        <?php endforeach; ?>
                    </div>

                    <p class="brief-fx" data-cur="DOP">
                        <?php
                        $rate = number_format((float) $fx['rate'], 2);
                        $when = $fx['fetched_at'] ? date('d/m/Y', (int) $fx['fetched_at']) : null;
                        ?>
                        Montos en pesos convertidos a US$1 = RD$<?= e($rate) ?><?php if ($when && !$fx['stale']): ?> · tasa del <?= e($when) ?><?php endif; ?>.
                        <?php if ($fx['stale']): ?>
                            <span style="color:#B45309;">Tasa de referencia: no pudimos actualizarla hoy.</span>
                        <?php endif; ?>
                        Son rangos de referencia, no una cotización.
                    </p>
                    <p class="brief-fx" data-cur="USD" hidden>Rangos de referencia, no una cotización.</p>

                    <?php if ($e = $err('budget')): ?><p class="brief-err"><?= e($e) ?></p><?php endif; ?>
                </div>

                <div class="brief-field">
                    <span class="brief-label">¿Para cuándo? <span class="req">*</span></span>
                    <div class="brief-chips">
                        <?php foreach ($timelines as $key => $label): ?>
                            <label class="brief-chip">
                                <input type="radio" name="timeline" value="<?= e($key) ?>" <?= old('timeline') === $key ? 'checked' : '' ?> data-brief-required-group="timeline">
                                <span><?= e($label) ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <?php if ($e = $err('timeline')): ?><p class="brief-err"><?= e($e) ?></p><?php endif; ?>
                </div>
            </fieldset>

            <!-- ── STEP 4 ── -->
            <fieldset class="brief-step" data-step="4">
                <legend class="brief-step__legend">
                    <span class="brief-step__num">4</span>
                    <span>
                        <span class="brief-step__title">¿Cómo te contactamos?</span>
                        <span class="brief-step__hint">Te escribimos solo por tu proyecto. Nada de spam.</span>
                    </span>
                </legend>

                <div class="brief-grid-2">
                    <div class="brief-field">
                        <label class="brief-label" for="name">Nombre completo <span class="req">*</span></label>
                        <input type="text" id="name" name="name" class="brief-input <?= $err('name') ? 'is-invalid' : '' ?>"
                               placeholder="Tu nombre" maxlength="120" autocomplete="name"
                               value="<?= e((string) old('name')) ?>" data-brief-required>
                        <?php if ($e = $err('name')): ?><p class="brief-err"><?= e($e) ?></p><?php endif; ?>
                    </div>
                    <div class="brief-field">
                        <label class="brief-label" for="email">Email <span class="req">*</span></label>
                        <input type="email" id="email" name="email" class="brief-input <?= $err('email') ? 'is-invalid' : '' ?>"
                               placeholder="tu@empresa.com" maxlength="180" autocomplete="email"
                               value="<?= e((string) old('email')) ?>" data-brief-required>
                        <?php if ($e = $err('email')): ?><p class="brief-err"><?= e($e) ?></p><?php endif; ?>
                    </div>
                    <div class="brief-field">
                        <label class="brief-label" for="company">Empresa <span class="brief-optional">Opcional</span></label>
                        <input type="text" id="company" name="company" class="brief-input <?= $err('company') ? 'is-invalid' : '' ?>"
                               placeholder="Nombre de tu empresa" maxlength="160" autocomplete="organization"
                               value="<?= e((string) old('company')) ?>">
                        <?php if ($e = $err('company')): ?><p class="brief-err"><?= e($e) ?></p><?php endif; ?>
                    </div>
                    <div class="brief-field">
                        <label class="brief-label" for="phone">Teléfono / WhatsApp <span class="brief-optional">Opcional</span></label>
                        <input type="tel" id="phone" name="phone" class="brief-input <?= $err('phone') ? 'is-invalid' : '' ?>"
                               placeholder="+1 (809) 000-0000" maxlength="40" autocomplete="tel"
                               value="<?= e((string) old('phone')) ?>">
                        <?php if ($e = $err('phone')): ?><p class="brief-err"><?= e($e) ?></p><?php endif; ?>
                    </div>
                </div>

                <div class="brief-field">
                    <span class="brief-label">¿Cómo nos conociste? <span class="brief-optional">Opcional</span></span>
                    <div class="brief-chips">
                        <?php foreach ($heardFrom as $key => $label): ?>
                            <label class="brief-chip">
                                <input type="radio" name="heard_from" value="<?= e($key) ?>" <?= old('heard_from') === $key ? 'checked' : '' ?>>
                                <span><?= e($label) ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <?php if ($e = $err('heard_from')): ?><p class="brief-err"><?= e($e) ?></p><?php endif; ?>
                </div>

                <p class="brief-privacy">
                    Al enviar aceptas nuestra <a href="<?= url('/privacy') ?>">política de privacidad</a>. Usamos tus datos solo para responderte.
                </p>
            </fieldset>

            <!-- Nav — JS swaps in Atrás/Continuar; without JS it's a single submit -->
            <div class="brief-nav">
                <button type="button" class="brief-btn brief-btn--ghost" data-brief-prev hidden>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5m5 5l-5-5 5-5"/></svg>
                    Atrás
                </button>
                <div class="brief-nav__spacer"></div>
                <button type="button" class="brief-btn brief-btn--primary" data-brief-next hidden>
                    Continuar
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-5-5l5 5-5 5"/></svg>
                </button>
                <button type="submit" class="brief-btn brief-btn--primary" data-brief-submit>
                    <span data-brief-submit-label>Enviar solicitud</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-5-5l5 5-5 5"/></svg>
                </button>
            </div>
        </form>
        </div><!-- /brief-main -->
    </div>
</section>
<?php endif; ?>
