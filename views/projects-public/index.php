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
            <?php
            // Same polished "browser window" treatment as the home grid: the
            // screenshot sits in a fixed viewport (cover-fit, pans down on
            // hover) and every label lives on the solid chrome bar — never over
            // the screenshot, so it stays legible on any cover image.
            $themeBgs = [
                'dark'   => 'linear-gradient(135deg, #1e2a3a 0%, #2d4258 50%, #3d5f7e 100%)',
                'light'  => 'linear-gradient(135deg, #d8d4cf 0%, #c0bcb4 100%)',
                'orange' => 'linear-gradient(135deg, #F26522 0%, #C44A0F 100%)',
            ];
            ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6 lg:gap-7" data-fluid-stagger>
                <?php foreach ($projects as $i => $project):
                    $theme    = $project['color_theme'] ?? 'dark';
                    $isLight  = $theme === 'light';
                    $bg       = $themeBgs[$theme] ?? $themeBgs['dark'];
                    $chrome   = $isLight ? '#111111' : '#FFFFFF';
                    $muted    = $isLight ? 'rgba(17,17,17,0.55)' : 'rgba(255,255,255,0.55)';
                    // Address-bar label: real domain when we have one, else a slug-based stand-in.
                    $host = '';
                    if (!empty($project['external_url'])) {
                        $host = preg_replace('/^www\./', '', parse_url($project['external_url'], PHP_URL_HOST) ?: '');
                    }
                    if ($host === '') $host = 'kyros.solutions/' . ($project['slug'] ?? 'caso');
                ?>
                    <a href="<?= url('/proyectos/' . $project['slug']) ?>" class="case-card group block">
                        <div class="case-card__media" style="background: <?= $bg ?>; color: <?= $chrome ?>;">
                            <div class="case-chrome">
                                <span class="case-chrome__dots" aria-hidden="true"><i></i><i></i><i></i></span>
                                <span class="case-chrome__url"></span>
                                <span class="case-chrome__url" style="opacity: 1; background: none; flex: 0 1 auto;">
                                    <span style="color: <?= $muted ?>;" class="font-mono"><?= e($host) ?></span>
                                </span>
                                <?php if (!empty($project['year'])): ?>
                                    <span class="text-[10px] font-mono flex-shrink-0 pl-1" style="color: <?= $muted ?>;"><?= e($project['year']) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="case-shot">
                                <?php if (!empty($project['cover_image'])): ?>
                                    <img src="<?= e($project['cover_image']) ?>" alt="<?= e($project['title']) ?>" loading="lazy" decoding="async">
                                <?php else: ?>
                                    <svg class="absolute inset-0 w-full h-full opacity-50" viewBox="0 0 400 300" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
                                        <circle cx="<?= 80 + ($i * 40) ?>" cy="120" r="80" fill="rgba(242,101,34,0.45)" filter="blur(40px)"/>
                                        <circle cx="<?= 280 - ($i * 30) ?>" cy="180" r="60" fill="rgba(99,102,241,0.40)" filter="blur(30px)"/>
                                    </svg>
                                <?php endif; ?>
                                <span class="case-shot__fade" aria-hidden="true"></span>
                                <div class="case-btn <?= $isLight ? 'case-btn--dark' : '' ?>">
                                    <span class="case-btn__label">Ver caso</span>
                                    <span class="case-btn__icon">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-5-5l5 5-5 5"/></svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2.5 mt-4">
                            <?php if (!empty($project['client'])): ?>
                                <span class="text-[11px] font-mono tracking-[0.18em] uppercase flex-shrink-0" style="color: var(--ink-muted);"><?= e($project['client']) ?></span>
                            <?php endif; ?>
                            <h3 class="case-card__title" style="margin-top: 0;"><?= e($project['title']) ?></h3>
                        </div>
                        <p class="case-card__desc"><?= e($project['description'] ?? '') ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
