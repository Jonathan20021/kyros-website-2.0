<?php require_once base_path('views/partials/icons.php'); ?>

<!-- ════════════════════════════════════════════════════════════
     SECTION 1 — HERO (full viewport on desktop, natural on mobile)
     ════════════════════════════════════════════════════════════ -->
<section id="hero" class="relative lg:min-h-screen flex flex-col bg-[#EFEFEF] overflow-hidden pt-28 sm:pt-32 lg:pt-0">

    <!-- Animated shader-style background -->
    <div class="hero-canvas" aria-hidden="true">
        <div class="hero-canvas__chroma"></div>
        <!-- Network grid: drawn by kyros-hero-grid.js. Purely decorative — if the
             script never runs the canvas stays empty and the hero is unchanged. -->
        <canvas id="hero-grid" class="hero-canvas__grid"></canvas>
        <div class="hero-canvas__fluted"></div>
        <div class="hero-canvas__grain"></div>
    </div>

    <!-- Spacer pushes hero content to bottom on desktop only -->
    <div class="hidden lg:block flex-1"></div>

    <!-- Hero content -->
    <div class="relative z-20 max-w-[1440px] mx-auto w-full px-5 sm:px-8 lg:px-12 pb-14 sm:pb-16 lg:pb-20">

        <p class="hero-in hero-in--1 text-[13px] sm:text-[14px] text-ink tracking-wide mb-5 sm:mb-8" style="color: var(--ink);">
            <span class="hero-eyebrow-dot" aria-hidden="true"></span>KYROS Solutions
        </p>

        <!-- Each line masks up on load. Below sm the lines flow inline again so
             the natural mobile wrapping is preserved. -->
        <h1 class="hero-title font-medium leading-[1.08] tracking-[-0.03em] text-ink text-balance"
            style="color: var(--ink); font-size: clamp(1.75rem, 6vw, 4.2rem);">
            <span class="hero-line"><span class="hero-line__in">Construimos tecnología</span></span>
            <span class="sm:hidden"> </span>
            <span class="hero-line"><span class="hero-line__in">para empresas que</span></span>
            <span class="sm:hidden"> </span>
            <span class="hero-line"><span class="hero-line__in">no pueden permitirse fallar.</span></span>
        </h1>

        <div class="hero-in hero-in--3 mt-8 sm:mt-12 flex flex-col sm:flex-row gap-4 sm:gap-5 items-start sm:items-center">

            <!-- Orange CTA with text-roll -->
            <a href="<?= url('/hablemos') ?>" class="btn-orange group">
                <span class="text-roll">
                    <span class="text-roll__inner">
                        <span>Iniciar proyecto</span>
                        <span>Iniciar proyecto</span>
                    </span>
                </span>
                <span class="arrow-circle arrow-circle--lg arrow-circle__orange">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-5-5l5 5-5 5"/></svg>
                </span>
            </a>

            <!-- Partner badge -->
            <div class="partner-badge">
                <span class="partner-badge__icon"><?= partner_star('w-5 h-5 sm:w-6 sm:h-6') ?></span>
                <span class="partner-badge__label">Equipo senior · +10 años</span>
                <span class="partner-badge__featured">Featured</span>
            </div>
        </div>
    </div>

    <!-- Scroll cue — desktop only, where the hero fills the viewport -->
    <a href="#about" class="hero-scroll hidden lg:flex" aria-label="Ver más">
        <span class="hero-scroll__label">Scroll</span>
        <span class="hero-scroll__line" aria-hidden="true"></span>
    </a>
</section>

<!-- ════════════════════════════════════════════════════════════
     SECTION 2 — LOGO STRIP (clients)
     ════════════════════════════════════════════════════════════ -->
<section class="bg-white py-12 border-y border-[rgba(17,17,17,0.06)]">
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <p class="text-center text-[11px] font-mono uppercase tracking-[0.24em] text-[var(--ink-muted)] mb-8">
            Confían en nosotros · +80 empresas en LATAM
        </p>
        <div class="overflow-hidden mask-fade-x marquee-paused">
            <div class="flex gap-12 items-center animate-ticker w-max" style="animation: ticker 35s linear infinite;">
                <?php
                $clients = ['Evallish BPO', 'Hospital Las Colinas', 'M&M Montas', 'AMD Accounting', 'Tafer Business Group'];
                foreach (array_merge($clients, $clients, $clients) as $client):
                ?>
                    <div class="flex items-center gap-2.5 text-[15px] font-medium whitespace-nowrap" style="color: var(--ink-soft);">
                        <span class="w-1.5 h-1.5 rounded-full" style="background: var(--orange);"></span>
                        <?= e($client) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════════
     SECTION 3 — ABOUT (Strategy-led intro, Axion-asymmetric layout)
     ════════════════════════════════════════════════════════════ -->
<section id="about" class="bg-white pt-16 sm:pt-20 lg:pt-32 pb-12 sm:pb-16 lg:pb-24 overflow-hidden">
    <div class="max-w-[1440px] mx-auto">

        <!-- Badge row -->
        <div class="px-5 sm:px-8 lg:px-12 mb-6 sm:mb-8">
            <div class="section-badge">
                <span class="section-badge__num">1</span>
                <span class="section-badge__label">Conoce KYROS</span>
            </div>
        </div>

        <!-- Heading -->
        <h2 class="px-5 sm:px-8 lg:px-12 font-medium leading-[1.12] tracking-[-0.02em] text-balance mb-12 sm:mb-16 lg:mb-28"
            style="color: var(--ink); font-size: clamp(1.5rem, 4vw, 3.2rem);">
            Estrategia y código, entregando<br class="hidden sm:block"><span class="sm:hidden"> </span>resultados medibles en cada sprint.
        </h2>

<?php
// Auto-detect about images. Drop files at /assets/img/about-estudio.{jpg,webp}
// and /assets/img/about-equipo.{jpg,webp} — they replace the gradient placeholders.
$findAboutImg = function (string $base) {
    foreach (['webp', 'jpg', 'jpeg', 'png'] as $ext) {
        if (is_file(base_path("assets/img/{$base}.{$ext}"))) {
            return asset("img/{$base}.{$ext}");
        }
    }
    return null;
};
$imgEstudio = $findAboutImg('about-estudio');
$imgEquipo  = $findAboutImg('about-equipo');
$gradEstudio = 'background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 50%, #d8d4cf 100%);';
$gradEquipo  = 'background: linear-gradient(135deg, #ffe5d3 0%, #fcc89b 50%, #f5a262 100%);';

// Panel contents shown when no photo is present. Every figure here is already
// claimed elsewhere on this page (hero, ticker, services) — nothing new.
$statEstudio = function () { ?>
    <span class="stat-panel__grid" aria-hidden="true"></span>
    <div class="flex items-start justify-between">
        <span class="stat-panel__tag">Estudio</span>
        <span class="stat-panel__dot" aria-hidden="true"></span>
    </div>
    <div>
        <p class="stat-panel__num" data-count-to="10" data-count-suffix="+">10+</p>
        <p class="stat-panel__cap">Años construyendo software<br>para operaciones críticas.</p>
    </div>
<?php };

$statEquipo = function () { ?>
    <span class="stat-panel__grid" aria-hidden="true"></span>
    <div class="flex items-start justify-between">
        <span class="stat-panel__tag stat-panel__tag--light">Equipo · Santo Domingo, RD</span>
        <span class="stat-panel__dot stat-panel__dot--light" aria-hidden="true"></span>
    </div>
    <div class="stat-grid">
        <div>
            <p class="stat-panel__num stat-panel__num--sm" data-count-to="80" data-count-prefix="+">+80</p>
            <p class="stat-panel__cap stat-panel__cap--light">Clientes activos</p>
        </div>
        <div>
            <p class="stat-panel__num stat-panel__num--sm" data-count-to="4">4</p>
            <p class="stat-panel__cap stat-panel__cap--light">Disciplinas</p>
        </div>
        <div>
            <p class="stat-panel__num stat-panel__num--sm">24/7</p>
            <p class="stat-panel__cap stat-panel__cap--light">Soporte bajo SLA</p>
        </div>
    </div>
<?php };
?>

        <!-- Content: mobile/tablet stacked -->
        <div class="lg:hidden px-5 sm:px-8 lg:px-12">
            <p class="text-[15px] sm:text-[17px] leading-[1.6] font-medium mb-6" style="color: var(--ink);">
                Una década construyendo software, ciberseguridad e infraestructura para empresas que no pueden permitirse fallar.
            </p>
            <a href="<?= url('/about') ?>" class="btn-orange group mb-10 inline-flex">
                <span class="text-roll">
                    <span class="text-roll__inner">
                        <span>Sobre el equipo</span>
                        <span>Sobre el equipo</span>
                    </span>
                </span>
                <span class="arrow-circle arrow-circle__orange">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-5-5l5 5-5 5"/></svg>
                </span>
            </a>
            <div class="flex flex-col sm:flex-row gap-4 sm:gap-5">
                <div class="img-block <?= $imgEstudio ? '' : 'stat-panel stat-panel--dark' ?> sm:w-[45%]" style="aspect-ratio: 438/346; <?= $imgEstudio ? '' : '' ?>">
                    <?php if ($imgEstudio): ?>
                        <img src="<?= e($imgEstudio) ?>" alt="Estudio KYROS" class="w-full h-full object-cover" loading="lazy" decoding="async">
                        <div class="absolute inset-0 flex items-end p-5 pointer-events-none">
                            <span class="text-white/90 text-[11px] font-mono tracking-[0.18em] uppercase drop-shadow-md">Estudio</span>
                        </div>
                    <?php else: $statEstudio(); endif; ?>
                </div>
                <div class="img-block <?= $imgEquipo ? '' : 'stat-panel stat-panel--orange' ?> sm:w-[55%]" style="aspect-ratio: 900/600;">
                    <?php if ($imgEquipo): ?>
                        <img src="<?= e($imgEquipo) ?>" alt="Equipo KYROS" class="w-full h-full object-cover" loading="lazy" decoding="async">
                        <div class="absolute inset-0 flex items-end p-6 pointer-events-none">
                            <span class="text-white/90 text-[12px] font-mono tracking-[0.18em] uppercase drop-shadow-md">Equipo · Santo Domingo, RD</span>
                        </div>
                    <?php else: $statEquipo(); endif; ?>
                </div>
            </div>
        </div>

        <!-- Content: desktop asymmetric grid -->
        <div class="hidden lg:grid grid-cols-[26%_1fr_48%] items-end gap-6 xl:gap-8 px-5 sm:px-8 lg:px-12">
            <div class="self-end img-block <?= $imgEstudio ? '' : 'stat-panel stat-panel--dark' ?>" style="aspect-ratio: 438/346;">
                <?php if ($imgEstudio): ?>
                    <img src="<?= e($imgEstudio) ?>" alt="Estudio KYROS" class="w-full h-full object-cover" loading="lazy" decoding="async">
                    <div class="absolute inset-0 flex items-end p-5 pointer-events-none">
                        <span class="text-[11px] font-mono tracking-[0.18em] uppercase text-white/90 drop-shadow-md">Estudio</span>
                    </div>
                <?php else: $statEstudio(); endif; ?>
            </div>
            <div class="self-start flex flex-col justify-end items-end pr-2">
                <p class="text-[16px] xl:text-[18px] leading-[1.65] font-medium text-right mb-7" style="color: var(--ink);">
                    Estrategia + diseño + código,<br>
                    bajo SLA y con foco<br>
                    en métricas reales de negocio.
                </p>
                <a href="<?= url('/about') ?>" class="btn-orange group">
                    <span class="text-roll">
                        <span class="text-roll__inner">
                            <span>Sobre el equipo</span>
                            <span>Sobre el equipo</span>
                        </span>
                    </span>
                    <span class="arrow-circle arrow-circle__orange">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-5-5l5 5-5 5"/></svg>
                    </span>
                </a>
            </div>
            <div class="self-end img-block <?= $imgEquipo ? '' : 'stat-panel stat-panel--orange' ?>" style="aspect-ratio: 3/2;">
                <?php if ($imgEquipo): ?>
                    <img src="<?= e($imgEquipo) ?>" alt="Equipo KYROS · Santo Domingo, RD" class="w-full h-full object-cover" loading="lazy" decoding="async">
                    <div class="absolute inset-0 flex items-end justify-between p-6 pointer-events-none">
                        <span class="text-white/95 text-[13px] font-mono tracking-[0.18em] uppercase drop-shadow-md">Equipo · Santo Domingo, RD</span>
                        <span class="text-white/95 text-[13px] font-mono tracking-tight drop-shadow-md">+80 clientes activos</span>
                    </div>
                <?php else: $statEquipo(); endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════════
     SECTION 4 — SERVICES (4 clean cards)
     ════════════════════════════════════════════════════════════ -->
<section id="services" class="bg-white pt-8 pb-16 sm:pb-20 lg:pb-28">
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">

        <div class="section-badge mb-6 sm:mb-8">
            <span class="section-badge__num">2</span>
            <span class="section-badge__label">Qué hacemos</span>
        </div>

        <h2 class="font-medium leading-[1.12] tracking-[-0.02em] text-balance mb-10 sm:mb-14 lg:mb-16"
            style="color: var(--ink); font-size: clamp(1.5rem, 4vw, 3.2rem);">
            Seis disciplinas,<br class="hidden sm:block"><span class="sm:hidden"> </span>un solo equipo responsable.
        </h2>

        <?php /* Six services: 3 columns splits into two even rows. The old
                 xl:grid-cols-5 would leave the sixth card orphaned on its own. */ ?>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6" data-fluid-stagger>
            <?php
            $services = [
                ['code',    'Desarrollo de software',    'Aplicaciones web, plataformas SaaS y sistemas empresariales con arquitectura moderna y entregas medibles.', '/services/software-development'],
                ['shield',  'Ciberseguridad',            'Pentesting, hardening, monitoreo y respuesta ante incidentes con respuesta certificada.',                   '/services/cybersecurity'],
                ['headset', 'Soporte 24/7',              'Mesa de ayuda con SLA contractual. Resolvemos en minutos, no en días.',                                     '/services/technical-support'],
                ['wifi',    'Infraestructura de redes',  'Diseño y administración de redes empresariales: cableado certificado, WiFi 6, firewalls y VPN.',            '/services/network-infrastructure'],
                ['share',   'Redes sociales',            'Estrategia, contenido, community management y campañas para empresas y marcas personales.',                 '/services/social-media'],
                ['stethoscope', 'Webs para médicos',     'Sitios para médicos y centros de salud: perfil, consultorios, horarios y solicitud de citas.',              '/services/medical-websites'],
            ];
            foreach ($services as [$ic, $title, $desc, $link]):
            ?>
                <a href="<?= url($link) ?>" class="group block rounded-2xl p-6 bg-[#FAFAFA] border border-[rgba(17,17,17,0.06)] hover:bg-white hover:shadow-[0_8px_24px_rgba(0,0,0,0.06)] transition-all">
                    <div class="w-10 h-10 rounded-xl bg-white border border-[rgba(17,17,17,0.06)] flex items-center justify-center mb-5" style="color: var(--orange);">
                        <?= icon($ic, 'w-5 h-5') ?>
                    </div>
                    <h3 class="text-[16px] font-semibold mb-2 tracking-tight" style="color: var(--ink);"><?= e($title) ?></h3>
                    <p class="text-[13.5px] leading-relaxed mb-6" style="color: var(--ink-muted);"><?= e($desc) ?></p>
                    <div class="flex items-center gap-2 text-[13px] font-medium" style="color: var(--ink);">
                        <span>Conocer más</span>
                        <span class="inline-block transition-transform group-hover:translate-x-1">→</span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════════
     SECTION 5 — CASE STUDIES (only renders if there's content to show)
     If DB reachable + empty → section hidden entirely.
     If DB unreachable → curated fallback (so visitors don't see a broken page).
     ════════════════════════════════════════════════════════════ -->
<?php
$homeProjects = $projects ?? [];
$useDbReachable = $dbReachable ?? true;
// Show fallback ONLY when DB is unreachable (graceful for visitors).
if (empty($homeProjects) && !$useDbReachable) {
    $homeProjects = [
        ['slug' => null, 'title' => 'Hospital Las Colinas',  'client' => '', 'year' => '2025', 'description' => 'Modernización completa del sistema de información hospitalaria. 40% menos fricción operativa.', 'cover_image' => null, 'color_theme' => 'dark'],
        ['slug' => null, 'title' => 'Evallish BPO',          'client' => '', 'year' => '2024 — 2026', 'description' => 'Suite operativa: ponche electrónico, nómina, gestión de calidad de call center.', 'cover_image' => null, 'color_theme' => 'dark'],
        ['slug' => null, 'title' => 'Tafer Business Group',  'client' => '', 'year' => '2025', 'description' => 'App web para gestión de finanzas y préstamos más landing corporativa.', 'cover_image' => null, 'color_theme' => 'light'],
        ['slug' => null, 'title' => 'M&M Montas',            'client' => '', 'year' => '2024', 'description' => 'App a medida para control financiero con reportes consolidados.', 'cover_image' => null, 'color_theme' => 'dark'],
    ];
}
?>
<?php if (!empty($homeProjects)): ?>
<section id="cases" class="bg-[#F5F5F5] pt-16 sm:pt-20 lg:pt-28 pb-16 sm:pb-20 lg:pb-28">
    <div class="max-w-[1440px] mx-auto">

        <div class="px-5 sm:px-8 lg:px-12 mb-6 sm:mb-8">
            <div class="section-badge">
                <span class="section-badge__num">3</span>
                <span class="section-badge__label" style="border-color: rgba(17,17,17,0.18);">Trabajo destacado</span>
            </div>
        </div>

        <h2 class="px-5 sm:px-8 lg:px-12 font-medium leading-[1.08] tracking-[-0.03em] text-balance mb-10 sm:mb-14 lg:mb-16"
            style="color: var(--ink); font-size: clamp(1.75rem, 6vw, 4.2rem);">
            Nuestros proyectos
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6 lg:gap-7 px-5 sm:px-8 lg:px-12" data-fluid-stagger>
            <?php
            $themeBgs = [
                'dark'   => 'linear-gradient(135deg, #1e2a3a 0%, #2d4258 50%, #3d5f7e 100%)',
                'light'  => 'linear-gradient(135deg, #d8d4cf 0%, #c0bcb4 100%)',
                'orange' => 'linear-gradient(135deg, #F26522 0%, #C44A0F 100%)',
            ];
            foreach ($homeProjects as $i => $proj):
                $theme = $proj['color_theme'] ?? 'dark';
                $isLight = $theme === 'light';
                $href = !empty($proj['slug']) ? url('/proyectos/' . $proj['slug']) : url('/contact');
                $bg = $themeBgs[$theme] ?? $themeBgs['dark'];
                $chromeColor = $isLight ? '#111111' : '#FFFFFF';
                $textColorMuted = $isLight ? 'rgba(17,17,17,0.55)' : 'rgba(255,255,255,0.55)';
                // Address-bar label: real domain when we have one, else a slug-based stand-in.
                $host = '';
                if (!empty($proj['external_url'])) {
                    $host = parse_url($proj['external_url'], PHP_URL_HOST) ?: '';
                    $host = preg_replace('/^www\./', '', $host);
                }
                if ($host === '') {
                    $host = 'kyros.solutions/' . ($proj['slug'] ?? 'caso-0' . ($i + 1));
                }
            ?>
                <a href="<?= e($href) ?>" class="case-card group block">
                    <div class="case-card__media" style="background: <?= $bg ?>; color: <?= $chromeColor ?>;">
                        <div class="case-chrome">
                            <span class="case-chrome__dots" aria-hidden="true"><i></i><i></i><i></i></span>
                            <span class="case-chrome__url"></span>
                            <span class="case-chrome__url" style="opacity: 1; background: none; flex: 0 1 auto;">
                                <span style="color: <?= $textColorMuted ?>;" class="font-mono"><?= e($host) ?></span>
                            </span>
                            <?php if (!empty($proj['year'])): ?>
                                <span class="text-[10px] font-mono flex-shrink-0 pl-1" style="color: <?= $textColorMuted ?>;"><?= e($proj['year']) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="case-shot">
                            <?php if (!empty($proj['cover_image'])): ?>
                                <img src="<?= e($proj['cover_image']) ?>" alt="<?= e($proj['title']) ?>" loading="lazy" decoding="async">
                            <?php else: ?>
                                <svg class="absolute inset-0 w-full h-full opacity-50" viewBox="0 0 400 300" preserveAspectRatio="xMidYMid slice">
                                    <circle cx="<?= 80 + ($i*40) ?>" cy="120" r="80" fill="rgba(242,101,34,0.45)" filter="blur(40px)"/>
                                    <circle cx="<?= 280 - ($i*30) ?>" cy="180" r="60" fill="rgba(99,102,241,0.40)" filter="blur(30px)"/>
                                </svg>
                            <?php endif; ?>
                            <span class="case-shot__fade" aria-hidden="true"></span>
                            <div class="case-btn <?= ($i % 2) === 1 ? 'case-btn--dark' : '' ?>">
                                <span class="case-btn__label"><?= !empty($proj['slug']) ? 'Ver caso' : 'Hablemos' ?></span>
                                <span class="case-btn__icon">
                                    <?php if (($i % 2) === 1): ?>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-5-5l5 5-5 5"/></svg>
                                    <?php else: ?>
                                        <?= icon('link', 'w-3.5 h-3.5') ?>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-baseline gap-2.5 mt-4">
                        <span class="text-[11px] font-mono tracking-[0.18em] uppercase flex-shrink-0" style="color: var(--ink-muted);">Caso 0<?= $i + 1 ?></span>
                        <h3 class="case-card__title" style="margin-top: 0;"><?= e($proj['title']) ?></h3>
                    </div>
                    <p class="case-card__desc"><?= e($proj['description'] ?? '') ?></p>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if (!empty($projects) && count($projects) >= 4): ?>
            <div class="text-center mt-12">
                <a href="<?= url('/proyectos') ?>" class="inline-flex items-center gap-2 text-[15px] font-medium text-[#F26522] hover:underline">
                    Ver todos los proyectos →
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; // !empty($homeProjects) ?>

<!-- ════════════════════════════════════════════════════════════
     SECTION 5.5 — RECENT BLOG POSTS (only if posts exist)
     ════════════════════════════════════════════════════════════ -->
<?php if (!empty($recentPosts)): ?>
<section id="recent-blog" class="bg-white pt-16 sm:pt-20 lg:pt-24 pb-12 sm:pb-16">
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <div class="flex items-end justify-between mb-10 gap-6 flex-wrap">
            <div>
                <div class="section-badge mb-5">
                    <span class="section-badge__num">B</span>
                    <span class="section-badge__label">Del blog</span>
                </div>
                <h2 class="font-medium leading-[1.05] tracking-[-0.03em] text-balance" style="color: var(--ink); font-size: clamp(1.75rem, 4vw, 3rem);">
                    Ideas y aprendizajes recientes
                </h2>
            </div>
            <a href="<?= url('/blog') ?>" class="text-[14px] font-medium text-[#F26522] hover:underline whitespace-nowrap">Ver todos →</a>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6" data-fluid-stagger>
            <?php foreach ($recentPosts as $rp): ?>
                <a href="<?= url('/blog/' . $rp['slug']) ?>" class="group">
                    <div class="rounded-2xl overflow-hidden bg-gray-100 mb-4" style="aspect-ratio: 16/10;">
                        <?php if (!empty($rp['cover_image'])): ?>
                            <img src="<?= e($rp['cover_image']) ?>" alt="" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        <?php else: ?>
                            <div class="w-full h-full" style="background: linear-gradient(135deg, <?= e($rp['category_color'] ?? '#F26522') ?>22, transparent);"></div>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($rp['category_name'])): ?>
                        <span class="text-[11px] font-medium uppercase tracking-[0.10em] px-2.5 py-1 rounded-full inline-block mb-3" style="background: <?= e($rp['category_color'] ?? '#F26522') ?>15; color: <?= e($rp['category_color'] ?? '#F26522') ?>;">
                            <?= e($rp['category_name']) ?>
                        </span>
                    <?php endif; ?>
                    <h3 class="font-medium text-[18px] tracking-tight leading-tight group-hover:text-[#F26522] transition-colors" style="color: var(--ink);">
                        <?= e($rp['title']) ?>
                    </h3>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ════════════════════════════════════════════════════════════
     SECTION 6 — FINAL CTA (clean focused)
     ════════════════════════════════════════════════════════════ -->
<section id="cta" class="bg-white pt-16 sm:pt-20 lg:pt-28 pb-16 sm:pb-20 lg:pb-28">
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <div class="relative rounded-3xl overflow-hidden p-10 sm:p-14 lg:p-20 bg-[#EFEFEF]">

            <!-- Reuse hero canvas inside CTA box -->
            <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
                <div class="hero-canvas__chroma"></div>
                <div class="hero-canvas__grain"></div>
            </div>

            <div class="relative z-10 max-w-3xl">
                <div class="section-badge mb-6 sm:mb-8">
                    <span class="section-badge__num">4</span>
                    <span class="section-badge__label">Hablemos</span>
                </div>

                <h2 class="font-medium leading-[1.08] tracking-[-0.03em] text-balance mb-6"
                    style="color: var(--ink); font-size: clamp(1.75rem, 5vw, 3.75rem);">
                    ¿Listo para empezar?<br>Hablemos en 30 minutos.
                </h2>

                <p class="text-[15px] sm:text-[17px] leading-[1.6] max-w-xl mb-8" style="color: var(--ink-soft);">
                    Discovery gratuito, sin compromiso. Te entregamos una propuesta concreta en 48 horas con cronograma realista y costo cerrado.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 sm:gap-5 items-start sm:items-center">
                    <a href="<?= url('/hablemos') ?>" class="btn-orange group">
                        <span class="text-roll">
                            <span class="text-roll__inner">
                                <span>Agendar consulta</span>
                                <span>Agendar consulta</span>
                            </span>
                        </span>
                        <span class="arrow-circle arrow-circle--lg arrow-circle__orange">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-5-5l5 5-5 5"/></svg>
                        </span>
                    </a>
                    <a href="tel:+18495024061" class="inline-flex items-center gap-2 text-[14px] font-medium" style="color: var(--ink);">
                        <?= icon('phone', 'w-4 h-4') ?>
                        +1 (849) 502-4061
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
