<?php require_once base_path('views/partials/icons.php'); ?>

<section class="relative pt-32 sm:pt-36 pb-12 overflow-hidden bg-[#EFEFEF]">
    <div class="hero-canvas" aria-hidden="true">
        <div class="hero-canvas__chroma"></div>
        <div class="hero-canvas__fluted"></div>
        <div class="hero-canvas__grain"></div>
    </div>

    <div class="relative z-20 max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <div class="section-badge mb-6">
            <span class="section-badge__num">P</span>
            <span class="section-badge__label">Proyectos</span>
        </div>
        <h1 class="font-medium leading-[1.05] tracking-[-0.03em] text-balance"
            style="color: var(--ink); font-size: clamp(2rem, 6vw, 4.2rem);">
            Casos de estudio
        </h1>
        <p class="mt-6 max-w-2xl text-[16px] sm:text-[17px] leading-[1.6]" style="color: var(--ink-soft);">
            Trabajos reales para empresas reales. Software, ciberseguridad, infraestructura y soporte que mueven negocios.
        </p>
    </div>
</section>

<section class="bg-[#F5F5F5] pt-12 pb-16 sm:pb-24">
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <?php if (empty($projects)): ?>
            <div class="text-center py-20">
                <p class="text-[18px]" style="color: var(--ink-muted);">Próximamente más casos publicados.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6 lg:gap-7" data-fluid-stagger>
                <?php foreach ($projects as $project): ?>
                    <a href="<?= url('/proyectos/' . $project['slug']) ?>" class="case-card group block">
                        <div class="case-card__media" style="aspect-ratio: 16/10; background: linear-gradient(135deg, #1e2a3a 0%, #3d5f7e 100%);">
                            <?php if (!empty($project['cover_image'])): ?>
                                <img src="<?= e($project['cover_image']) ?>" alt="<?= e($project['title']) ?>">
                            <?php endif; ?>
                            <div class="absolute top-5 left-5 right-5 flex items-center justify-between">
                                <span class="text-white/85 text-[11px] font-mono tracking-[0.18em] uppercase"><?= e($project['client'] ?? 'Cliente') ?></span>
                                <?php if (!empty($project['year'])): ?>
                                    <span class="text-white/65 text-[11px] font-mono"><?= e($project['year']) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="case-btn case-btn--dark">
                                <span class="case-btn__label">Ver caso</span>
                                <span class="case-btn__icon">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-5-5l5 5-5 5"/></svg>
                                </span>
                            </div>
                        </div>
                        <p class="case-card__desc"><?= e($project['description'] ?? '') ?></p>
                        <h3 class="case-card__title"><?= e($project['title']) ?></h3>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
