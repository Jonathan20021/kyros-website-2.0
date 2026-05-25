<?php require_once base_path('views/partials/icons.php'); ?>

<section class="min-h-[85vh] flex items-center pt-32 sm:pt-36 pb-16 relative overflow-hidden bg-[#EFEFEF]">
    <div class="hero-canvas" aria-hidden="true">
        <div class="hero-canvas__chroma"></div>
        <div class="hero-canvas__fluted"></div>
        <div class="hero-canvas__grain"></div>
    </div>

    <div class="relative z-20 max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12 w-full">
        <div class="max-w-3xl mx-auto text-center">
            <div class="section-badge mb-6 justify-center inline-flex">
                <span class="section-badge__num"><?= e((string)($code ?? 404)) ?></span>
                <span class="section-badge__label">Error</span>
            </div>

            <div class="font-medium leading-none mb-6 tracking-[-0.06em]"
                 style="color: var(--ink); font-size: clamp(6rem, 18vw, 14rem);">
                <?= e((string)($code ?? 404)) ?><span style="color: var(--orange);">.</span>
            </div>

            <h1 class="font-medium tracking-tight leading-[1.05] text-balance mb-5"
                style="color: var(--ink); font-size: clamp(1.5rem, 4vw, 3rem);">
                <?= e($message ?? 'Página no encontrada') ?>
            </h1>
            <p class="text-[15px] sm:text-[16px] leading-[1.6] max-w-md mx-auto mb-10" style="color: var(--ink-soft);">
                La página que buscas no existe o fue movida. Podemos ayudarte a encontrar lo que necesitas.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="<?= url('/') ?>" class="btn-orange group">
                    <span class="text-roll">
                        <span class="text-roll__inner">
                            <span>Volver al inicio</span>
                            <span>Volver al inicio</span>
                        </span>
                    </span>
                    <span class="arrow-circle arrow-circle--lg arrow-circle__orange">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-5-5l5 5-5 5"/></svg>
                    </span>
                </a>
                <a href="<?= url('/contact') ?>" class="inline-flex items-center gap-2 text-[14px] font-medium hover:text-[#F26522] transition-colors" style="color: var(--ink);">
                    Hablar con nosotros →
                </a>
            </div>
        </div>
    </div>
</section>
