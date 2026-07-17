<?php require_once base_path('views/partials/icons.php'); ?>
<header id="site-header" class="absolute top-0 inset-x-0 z-20">
    <style>
        /* Logo sizing — artwork is edge-to-edge, so height is the real height.
           Fluid between 26px (small phones) and 34px (desktop); the pill's
           height is driven by the CTA button, so this never reflows the bar. */
        .nav-logo-img {
            height: clamp(26px, 2.4vw, 34px);
            width: auto;
        }
    </style>
    <div class="max-w-[1440px] mx-auto p-2 sm:p-3">
        <div class="pill-nav">
            <!-- LEFT — Logo + nav links -->
            <div class="flex items-center gap-4 lg:gap-5 min-w-0">
                <a href="<?= url('/') ?>" class="flex items-center flex-shrink-0 pl-2 sm:pl-3 nav-logo-link" aria-label="KYROS Solutions">
                    <img src="<?= asset('img/logo.png') ?>" alt="KYROS Solutions" class="block nav-logo-img" fetchpriority="high" decoding="async">
                </a>
                <nav class="hidden lg:flex items-center gap-5 xl:gap-6">
                    <?php
                    $links = [
                        ['/', 'Inicio'],
                        ['/services', 'Servicios'],
                        ['/proyectos', 'Proyectos'],
                        ['/blog', 'Blog'],
                        ['/about', 'Nosotros'],
                        ['/contact', 'Contacto'],
                    ];
                    foreach ($links as [$path, $label]):
                        $active = is_active($path);
                    ?>
                        <a href="<?= url($path) ?>" class="pill-nav__link <?= $active ? 'is-active' : '' ?>"><?= e($label) ?></a>
                    <?php endforeach; ?>
                </nav>
            </div>

            <!-- RIGHT — Status + time + CTA -->
            <div class="hidden lg:flex items-center gap-4 xl:gap-5 pr-1 flex-shrink-0">
                <span class="hidden xl:inline whitespace-nowrap text-[13px] text-ink-soft" style="color: var(--ink-muted);">Tomando proyectos para Q2 2026</span>
                <span class="pill-nav__time">
                    <?= icon('clock', 'w-3.5 h-3.5') ?>
                    <span><span id="live-clock">--:--</span> en SDQ</span>
                </span>
                <a href="<?= url('/hablemos') ?>" class="btn-dark group flex-shrink-0 whitespace-nowrap">
                    <span class="text-roll">
                        <span class="text-roll__inner">
                            <span>Hablemos del proyecto</span>
                            <span>Hablemos del proyecto</span>
                        </span>
                    </span>
                    <span class="arrow-circle">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-5-5l5 5-5 5"/></svg>
                    </span>
                </a>
            </div>

            <!-- MOBILE menu button -->
            <button id="nav-toggle" type="button" class="lg:hidden flex-shrink-0 w-10 h-10 rounded-full bg-[#111] text-white flex items-center justify-center" aria-label="Abrir menú">
                <svg id="nav-icon-open" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="4" y1="8" x2="20" y2="8"/><line x1="4" y1="16" x2="20" y2="16"/></svg>
                <svg id="nav-icon-close" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="6" y1="6" x2="18" y2="18"/><line x1="18" y1="6" x2="6" y2="18"/></svg>
            </button>
        </div>
    </div>
</header>

<!-- Mobile slide-up sheet -->
<div id="mobile-sheet" class="mobile-sheet lg:hidden" aria-hidden="true">
    <div class="mobile-sheet__backdrop" data-sheet-close></div>
    <div class="mobile-sheet__panel">
        <div class="flex items-center justify-between mb-5">
            <span class="pill-nav__time"><?= icon('clock', 'w-3.5 h-3.5') ?> <span id="live-clock-mobile">--:--</span> en SDQ</span>
            <button data-sheet-close class="w-9 h-9 rounded-full bg-[#111] text-white flex items-center justify-center" aria-label="Cerrar">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><line x1="6" y1="6" x2="18" y2="18"/><line x1="18" y1="6" x2="6" y2="18"/></svg>
            </button>
        </div>
        <nav class="flex flex-col gap-1 mb-6">
            <?php foreach ($links as [$path, $label]):
                $active = is_active($path);
            ?>
                <a href="<?= url($path) ?>"
                   class="block py-3 text-[22px] font-medium tracking-tight transition-colors hover:text-[#F26522]"
                   style="color: <?= $active ? '#F26522' : 'var(--ink)' ?>;">
                    <?= e($label) ?>
                </a>
            <?php endforeach; ?>
        </nav>
        <a href="<?= url('/hablemos') ?>" class="btn-orange group w-full justify-center" style="padding: 14px 14px 14px 22px;">
            <span class="text-roll">
                <span class="text-roll__inner">
                    <span>Iniciar proyecto</span>
                    <span>Iniciar proyecto</span>
                </span>
            </span>
            <span class="arrow-circle arrow-circle__orange">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-5-5l5 5-5 5"/></svg>
            </span>
        </a>
    </div>
</div>
