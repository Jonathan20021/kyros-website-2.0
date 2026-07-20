<?php require_once base_path('views/partials/icons.php');
// Color theme: services pass color_fg/bg/bd. Default is orange.
$fg = $service['color_fg'] ?? '#F26522';
$bg = $service['color_bg'] ?? '#FFF4ED';
$bd = $service['color_bd'] ?? '#FED7B5';
?>

<!-- ════════════════════════════════════════════════════════════
     HERO STRIP
     ════════════════════════════════════════════════════════════ -->
<section id="svc-hero" class="relative pt-32 sm:pt-36 pb-20 overflow-hidden bg-[#EFEFEF]">
    <div class="hero-canvas" aria-hidden="true">
        <div class="hero-canvas__chroma"></div>
        <!-- Service-specific motion (code stream / radar / pulse / routing),
             drawn by kyros-service-hero.js. Decorative; empty without JS. -->
        <canvas id="svc-scene" class="svc-scene" data-scene="<?= e($service['anim'] ?? '') ?>"<?= !empty($service['accent_rgb']) ? ' data-accent="' . e($service['accent_rgb']) . '"' : '' ?>></canvas>
        <div class="hero-canvas__fluted"></div>
        <div class="hero-canvas__grain"></div>
    </div>

    <div class="relative z-20 max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <a href="<?= url('/services') ?>" class="inline-flex items-center gap-2 text-[13px] font-mono mb-10 transition-colors hover:text-[#F26522]" style="color: var(--ink-soft);">
            ← Volver a servicios
        </a>

        <div class="grid lg:grid-cols-12 gap-10 items-end">
            <div class="lg:col-span-8">
                <div class="inline-flex items-center gap-2 mb-7 px-3 py-1.5 rounded-full text-[12px] font-medium" style="background: <?= e($bg) ?>; color: <?= e($fg) ?>; border: 1px solid <?= e($bd) ?>;">
                    <span class="w-1.5 h-1.5 rounded-full" style="background: <?= e($fg) ?>;"></span>
                    <?= e($service['eyebrow']) ?>
                </div>
                <h1 class="font-medium leading-[1.05] tracking-[-0.03em] text-balance"
                    style="color: var(--ink); font-size: clamp(2rem, 5.5vw, 4.2rem);">
                    <?= $service['title'] ?>
                </h1>
                <p class="text-[16px] sm:text-[17px] leading-[1.6] max-w-2xl mt-7" style="color: var(--ink-soft);">
                    <?= e($service['intro']) ?>
                </p>

                <div class="flex flex-wrap items-center gap-3 sm:gap-4 mt-9">
                    <a href="<?= url('/contact') ?>" class="btn-orange group">
                        <span class="text-roll">
                            <span class="text-roll__inner">
                                <span>Solicitar propuesta</span>
                                <span>Solicitar propuesta</span>
                            </span>
                        </span>
                        <span class="arrow-circle arrow-circle__orange">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-5-5l5 5-5 5"/></svg>
                        </span>
                    </a>
                    <a href="#features" class="inline-flex items-center gap-2 px-5 py-3 rounded-full text-[14px] font-medium bg-white border border-[rgba(17,17,17,0.10)] hover:border-[#F26522] transition-colors" style="color: var(--ink);">
                        Ver lo incluido
                    </a>
                </div>
            </div>

            <div class="lg:col-span-4">
                <div class="rounded-2xl p-7 border border-[rgba(17,17,17,0.08)] relative overflow-hidden" style="background: #fff; box-shadow: 0 12px 28px -8px rgba(0,0,0,0.08);">
                    <div class="absolute -top-12 -right-12 w-56 h-56 rounded-full" style="background: <?= e($fg) ?>; opacity: 0.12; filter: blur(40px);"></div>
                    <div class="relative">
                        <span class="w-12 h-12 rounded-xl flex items-center justify-center mb-5" style="background: <?= e($bg) ?>; color: <?= e($fg) ?>; border: 1px solid <?= e($bd) ?>;">
                            <?= icon($service['icon'], 'w-6 h-6') ?>
                        </span>
                        <h3 class="font-medium text-[16px] tracking-tight mb-1" style="color: var(--ink);">Métricas de impacto</h3>
                        <p class="text-[12px] font-mono mb-5" style="color: var(--ink-muted);">Promedio últimos 24 meses</p>

                        <div class="grid grid-cols-2 gap-3">
                            <?php foreach ($service['hero_metrics'] as $m): ?>
                                <div class="p-3.5 rounded-xl border border-[rgba(17,17,17,0.06)] bg-[#FAFAFA]">
                                    <div class="text-[clamp(1.4rem,2.5vw,1.9rem)] font-medium tracking-[-0.03em] leading-none mb-2" style="color: <?= e($fg) ?>;"><?= e($m[0]) ?></div>
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
     FEATURES
     ════════════════════════════════════════════════════════════ -->
<section id="features" class="bg-white py-16 sm:py-20 lg:py-24">
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-12 gap-10 mb-12 items-end">
            <div class="lg:col-span-7">
                <div class="section-badge mb-6">
                    <span class="section-badge__num">1</span>
                    <span class="section-badge__label">Lo que entregamos</span>
                </div>
                <h2 class="font-medium leading-[1.05] tracking-[-0.03em] text-balance"
                    style="color: var(--ink); font-size: clamp(1.75rem, 4vw, 3rem);">
                    Servicios <em class="text-italic-serif" style="color: <?= e($fg) ?>;">incluidos</em>.
                </h2>
            </div>
            <div class="lg:col-span-4 lg:col-start-9">
                <p class="text-[15px] leading-relaxed" style="color: var(--ink-soft);">
                    Todo lo que necesitas para que tu proyecto funcione, sin manos pasando la pelota a terceros.
                </p>
            </div>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5" data-fluid-stagger>
            <?php foreach ($service['features'] as $i => $f): ?>
                <div class="svc-feature rounded-2xl p-6 bg-white border border-[rgba(17,17,17,0.06)] hover:shadow-[0_8px_24px_rgba(0,0,0,0.06)] transition-all">
                    <span class="w-10 h-10 rounded-xl flex items-center justify-center mb-5" style="background: <?= e($bg) ?>; color: <?= e($fg) ?>; border: 1px solid <?= e($bd) ?>;">
                        <?= icon($f['icon'], 'w-5 h-5') ?>
                    </span>
                    <span class="text-[11px] font-mono mb-2 block" style="color: var(--ink-muted);">0<?= $i+1 ?></span>
                    <h3 class="font-medium text-[17px] tracking-tight mb-2" style="color: var(--ink);"><?= e($f['title']) ?></h3>
                    <p class="text-[13.5px] leading-relaxed" style="color: var(--ink-muted);"><?= e($f['desc']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════════
     DELIVERABLES
     ════════════════════════════════════════════════════════════ -->
<?php if (!empty($service['deliverables'])): ?>
<section class="bg-[#F5F5F5] py-16 sm:py-20 border-y border-[rgba(17,17,17,0.06)]">
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-12 gap-10">
            <div class="lg:col-span-5">
                <div class="section-badge mb-6">
                    <span class="section-badge__num">2</span>
                    <span class="section-badge__label">Entregables</span>
                </div>
                <h2 class="font-medium leading-[1.05] tracking-[-0.03em] text-balance mb-5"
                    style="color: var(--ink); font-size: clamp(1.5rem, 3vw, 2.5rem);">
                    Lo que recibirás <em class="text-italic-serif" style="color: <?= e($fg) ?>;">al finalizar</em>.
                </h2>
                <p class="text-[14.5px] leading-relaxed" style="color: var(--ink-soft);">
                    Documentación clara, código mantenible y handoff completo. Nada queda en cabezas de personas.
                </p>
            </div>
            <ul class="lg:col-span-7 grid sm:grid-cols-2 gap-3" data-fluid-stagger>
                <?php foreach ($service['deliverables'] as $d): ?>
                    <li class="flex items-start gap-3 p-4 rounded-xl bg-white border border-[rgba(17,17,17,0.06)] text-[14px]" style="color: var(--ink-soft);">
                        <span class="w-6 h-6 mt-0.5 rounded-full flex items-center justify-center flex-shrink-0" style="background: <?= e($bg) ?>; color: <?= e($fg) ?>;">
                            <?= icon('check', 'w-3.5 h-3.5') ?>
                        </span>
                        <span><?= e($d) ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ════════════════════════════════════════════════════════════
     PROCESS
     ════════════════════════════════════════════════════════════ -->
<?php if (!empty($service['process'])): ?>
<section class="bg-white py-16 sm:py-20 lg:py-24">
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-12 gap-10 mb-12 items-end">
            <div class="lg:col-span-7">
                <div class="section-badge mb-6">
                    <span class="section-badge__num">3</span>
                    <span class="section-badge__label">Cómo trabajamos</span>
                </div>
                <h2 class="font-medium leading-[1.05] tracking-[-0.03em] text-balance"
                    style="color: var(--ink); font-size: clamp(1.75rem, 4vw, 3rem);">
                    Un proceso <em class="text-italic-serif" style="color: <?= e($fg) ?>;">probado</em>.
                </h2>
            </div>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5" data-fluid-stagger>
            <?php foreach ($service['process'] as $p): ?>
                <div class="svc-process rounded-2xl p-6 bg-white border border-[rgba(17,17,17,0.06)] relative overflow-hidden">
                    <span class="absolute top-4 right-5 text-[60px] font-medium tracking-[-0.04em] leading-none" style="color: <?= e($bg) ?>;"><?= e($p['num']) ?></span>
                    <div class="relative">
                        <span class="text-[10px] font-mono tracking-[0.22em] mb-2 block" style="color: <?= e($fg) ?>;">FASE <?= e($p['num']) ?></span>
                        <h3 class="font-medium text-[17px] tracking-tight mb-3" style="color: var(--ink);"><?= e($p['title']) ?></h3>
                        <p class="text-[13.5px] leading-relaxed" style="color: var(--ink-muted);"><?= e($p['desc']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ════════════════════════════════════════════════════════════
     FAQ
     ════════════════════════════════════════════════════════════ -->
<?php if (!empty($service['faqs'])): ?>
<section class="bg-[#F5F5F5] py-16 sm:py-20 border-y border-[rgba(17,17,17,0.06)]">
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-12 gap-12">
            <div class="lg:col-span-4">
                <div class="lg:sticky lg:top-28">
                    <div class="section-badge mb-6">
                        <span class="section-badge__num">4</span>
                        <span class="section-badge__label">FAQ</span>
                    </div>
                    <h2 class="font-medium leading-[1.05] tracking-tight text-balance mb-5"
                        style="color: var(--ink); font-size: clamp(1.5rem, 3vw, 2.2rem);">
                        Resolvamos tus <em class="text-italic-serif" style="color: <?= e($fg) ?>;">dudas</em>.
                    </h2>
                    <p class="text-[14.5px] leading-relaxed" style="color: var(--ink-soft);">
                        ¿No encuentras tu pregunta? Contáctanos y te respondemos en menos de 24 horas.
                    </p>
                </div>
            </div>
            <div class="lg:col-span-8 space-y-3" data-fluid-stagger>
                <?php foreach ($service['faqs'] as [$q, $a]): ?>
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
<?php endif; ?>

<!-- ════════════════════════════════════════════════════════════
     RELATED + CTA
     ════════════════════════════════════════════════════════════ -->
<section class="bg-white py-16 sm:py-20 lg:py-24">
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-3 gap-5">
            <!-- CTA -->
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
                        ¿Listo para empezar con <em class="text-italic-serif"><?= e($service['eyebrow']) ?></em>?
                    </h2>
                    <p class="text-[15px] leading-[1.6] max-w-lg mb-7" style="color: var(--ink-soft);">
                        Una llamada de 30 minutos. Sin compromiso. Te entregamos una propuesta concreta en 48 horas.
                    </p>
                    <a href="<?= url('/contact') ?>" class="btn-orange group inline-flex">
                        <span class="text-roll">
                            <span class="text-roll__inner">
                                <span>Solicitar propuesta</span>
                                <span>Solicitar propuesta</span>
                            </span>
                        </span>
                        <span class="arrow-circle arrow-circle--lg arrow-circle__orange">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-5-5l5 5-5 5"/></svg>
                        </span>
                    </a>
                </div>
            </div>

            <!-- Related services -->
            <div class="rounded-2xl p-6 bg-white border border-[rgba(17,17,17,0.08)]">
                <p class="text-[11px] font-mono uppercase tracking-[0.22em] mb-5" style="color: var(--ink-muted);">Otros servicios</p>
                <div class="space-y-2">
                    <?php foreach ($service['related'] as $r): ?>
                        <a href="<?= url('/services/' . $r['slug']) ?>" class="flex items-center gap-3 p-3 rounded-xl bg-[#FAFAFA] hover:bg-[#FFF4ED] transition-colors group">
                            <span class="w-9 h-9 rounded-lg flex items-center justify-center" style="background: #fff; color: #F26522; border: 1px solid <?= e($bd) ?>;">
                                <?= icon($r['icon'], 'w-4 h-4') ?>
                            </span>
                            <span class="font-medium text-[13.5px] flex-grow tracking-tight" style="color: var(--ink);"><?= e($r['title']) ?></span>
                            <span class="text-[var(--ink-quiet)] group-hover:text-[#F26522] group-hover:translate-x-1 transition-all">
                                <?= icon('arrow-right', 'w-4 h-4') ?>
                            </span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
