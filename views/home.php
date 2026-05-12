<?php require_once base_path('views/partials/icons.php'); ?>

<!-- Section dot navigation (lg+) -->
<nav class="section-nav hidden lg:flex" aria-label="Section navigation">
    <a href="#hero"        class="section-nav__dot" data-label="Hero"></a>
    <a href="#services"    class="section-nav__dot" data-label="Servicios"></a>
    <a href="#stats"       class="section-nav__dot" data-label="Stats"></a>
    <a href="#estimator"   class="section-nav__dot" data-label="Estimador"></a>
    <a href="#why"         class="section-nav__dot" data-label="Por qué"></a>
    <a href="#process"     class="section-nav__dot" data-label="Proceso"></a>
    <a href="#showcase"    class="section-nav__dot" data-label="Casos"></a>
    <a href="#stack"       class="section-nav__dot" data-label="Stack"></a>
    <a href="#testimonials" class="section-nav__dot" data-label="Voces"></a>
    <a href="#faq"         class="section-nav__dot" data-label="FAQ"></a>
    <a href="#cta"         class="section-nav__dot" data-label="Hablemos"></a>
</nav>

<!-- ════════════════════════════════════════════════════════
     HERO — Cinematic + Live Dashboard
     ════════════════════════════════════════════════════════ -->
<section id="hero" class="relative pt-16 lg:pt-24 pb-20 lg:pb-28 overflow-hidden" data-spotlight-section>
    <div class="absolute inset-0 grid-mask"></div>

    <!-- Liquid orbs (toned down) -->
    <div class="liquid-orb liquid-orb--indigo" style="width: 560px; height: 560px; top: -200px; left: -160px;"></div>
    <div class="liquid-orb liquid-orb--cyan"   style="width: 360px; height: 360px; top: 10%; right: -80px;"></div>

    <div class="container relative z-10" data-hero>

        <!-- Top status -->
        <div class="flex flex-wrap items-center justify-between gap-3 mb-10 lg:mb-14 reveal">
            <div class="glow-tag">
                <span class="text-emerald-300">Disponible · Q2 2026</span>
            </div>
            <div class="hidden md:flex items-center gap-3 text-[11.5px] font-mono tracking-tight text-chalk-quiet">
                <span>Santo Domingo · RD</span>
                <span class="w-1 h-1 rounded-full bg-chalk-quiet/40"></span>
                <span id="live-clock">--:--</span>
            </div>
        </div>

        <!-- Main hero grid: headline + live dashboard -->
        <div class="grid lg:grid-cols-12 gap-10 lg:gap-14 items-center">
            <!-- Headline column -->
            <div class="lg:col-span-7">
                <h1 class="font-display font-normal tracking-tightest text-balance leading-[0.92]
                           text-[clamp(2.5rem,7.5vw,6rem)] reveal">
                    <span class="block text-grad-cream">Tecnología que</span>
                    <span class="block text-grad-cream">funciona como <span class="text-italic-serif text-grad-indigo">debe</span>.</span>
                </h1>

                <p class="text-chalk/65 text-[16px] md:text-[17px] leading-[1.6] max-w-xl mt-7 reveal" style="transition-delay:140ms">
                    Software, ciberseguridad, infraestructura y soporte para empresas que no pueden permitirse fallar. Equipo senior, operación bajo SLA, garantía contractual.
                </p>

                <div class="flex flex-wrap items-center gap-2.5 mt-8 reveal" style="transition-delay:260ms">
                    <a href="<?= url('/contact') ?>" class="btn-ember sheen magnetic text-[13.5px] py-3 px-5">
                        Iniciar proyecto
                        <svg class="w-3.5 h-3.5 arrow-ic" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-5-5l5 5-5 5"/></svg>
                    </a>
                    <a href="<?= url('/services') ?>" class="btn-outline text-[13.5px]">
                        Ver servicios
                    </a>
                </div>
            </div>

            <!-- Live Dashboard column -->
            <div class="lg:col-span-5 reveal tilt" style="transition-delay:220ms">
                <div class="tilt-target dash-card" style="padding: 0;">

                    <!-- Window chrome -->
                    <div class="flex items-center justify-between px-4 py-3 border-b border-white/5">
                        <div class="flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-white/15"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-white/15"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-white/15"></span>
                        </div>
                        <div class="font-mono text-[10px] text-chalk-quiet tracking-tight">kyros · live ops</div>
                        <div class="flex items-center gap-1.5 pl-3 pr-1 py-0.5 rounded-full" style="background: rgba(52,211,153,0.10); border: 1px solid rgba(52,211,153,0.20);">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400" style="box-shadow:0 0 8px #34d399"></span>
                            <span class="font-mono text-[9.5px] text-emerald-300 tracking-[0.12em]">LIVE</span>
                        </div>
                    </div>

                    <!-- Metrics -->
                    <div class="p-5 space-y-5">
                        <!-- Sparkline -->
                        <div>
                            <div class="flex items-baseline justify-between mb-2">
                                <span class="font-mono text-[10.5px] tracking-[0.2em] uppercase text-chalk-quiet">SLA · 30d</span>
                                <span class="font-display text-[24px] tracking-tightest font-normal text-chalk inline-flex items-baseline">
                                    <span data-live-sla>99.97</span><span class="text-chalk-quiet text-[14px]">%</span>
                                </span>
                            </div>
                            <svg class="sparkline w-full h-12" viewBox="0 0 300 50" preserveAspectRatio="none">
                                <path d="M0,30 L20,25 L40,28 L60,18 L80,22 L100,15 L120,20 L140,12 L160,18 L180,8 L200,14 L220,6 L240,10 L260,4 L280,8 L300,3"/>
                            </svg>
                        </div>

                        <!-- Bars -->
                        <div class="space-y-3.5">
                            <?php
                            $bars = [
                                ['Software entregado', '120+', 95],
                                ['Tickets resueltos', '4.2K', 88],
                                ['Vulns cerradas',    '250+', 76],
                                ['Uptime infra',      '99.9%', 99],
                            ];
                            foreach ($bars as [$label, $val, $w]):
                            ?>
                                <div>
                                    <div class="flex items-center justify-between mb-1.5">
                                        <span class="font-mono text-[10.5px] tracking-tight text-chalk/60"><?= e($label) ?></span>
                                        <span class="font-mono text-[11px] text-chalk"><?= e($val) ?></span>
                                    </div>
                                    <div class="dash-bar">
                                        <div class="dash-bar__fill" style="--w: <?= $w ?>%;"></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Live log rows (animated, rotating) -->
                        <div class="rounded-xl overflow-hidden border border-white/5" data-live-feed>
                            <!-- JS fills/rotates 3 visible rows -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hero signals strip -->
        <div class="relative reveal mt-16 lg:mt-20" style="transition-delay:300ms">
            <div class="liquid-glass grid grid-cols-2 md:grid-cols-4 gap-0" style="border-radius: 28px;">
                <?php
                $signals = [
                    ['shield',  'icon-chip-cyan',   '24/7',    'MONITOREO ACTIVO',   'Soporte siempre disponible'],
                    ['award',   '',                 '10+',     'AÑOS DE OPERACIÓN',  'Desde 2016'],
                    ['users',   'icon-chip-violet', '80+',     'CLIENTES EN LATAM',  'Sectores múltiples'],
                    ['trending','',                 '99.9%',   'UPTIME GARANTIZADO', 'SLA enterprise'],
                ];
                foreach ($signals as $i => [$ico, $chipClass, $val, $lbl, $sub]):
                ?>
                    <div class="relative px-5 py-6 md:px-8 md:py-9 group transition-colors hover:bg-white/[0.02] <?= ($i % 2 === 1) ? 'border-l border-white/5' : '' ?> <?= $i >= 2 ? 'border-t border-white/5 md:border-t-0' : '' ?> <?= $i >= 2 ? 'md:border-l' : '' ?>">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="icon-chip <?= $chipClass ?>" style="width:36px;height:36px;border-radius:10px;"><?= icon($ico, 'w-4 h-4') ?></div>
                            <span class="text-[9.5px] tracking-[0.22em] uppercase text-chalk-quiet font-medium"><?= e($lbl) ?></span>
                        </div>
                        <div class="font-display text-[clamp(2rem,3.5vw,2.75rem)] font-normal tracking-tightest text-chalk leading-none mb-1.5"><?= e($val) ?></div>
                        <div class="text-[12px] text-chalk/45"><?= e($sub) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════
     BANNER LINE — concise tagline strip
     ════════════════════════════════════════════════════════ -->
<section class="relative py-6 md:py-8 overflow-hidden border-y border-white/5">
    <div class="container">
        <div class="flex flex-wrap items-center justify-center gap-x-8 gap-y-3 text-center">
            <?php
            $taglines = [
                ['code',     'Build'],
                ['shield',   'Secure'],
                ['trending', 'Scale'],
                ['headset',  'Operate'],
            ];
            foreach ($taglines as $i => [$ic, $txt]):
            ?>
                <span class="inline-flex items-center gap-2.5 text-chalk/60">
                    <span class="text-indigo-300"><?= icon($ic, 'w-4 h-4') ?></span>
                    <span class="font-display text-[15px] tracking-tight"><?= e($txt) ?></span>
                </span>
                <?php if ($i < count($taglines) - 1): ?>
                    <span class="text-chalk/15 hidden sm:inline">·</span>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════
     LOGO STRIP
     ════════════════════════════════════════════════════════ -->
<section class="py-8 border-b border-white/5 overflow-hidden">
    <div class="container">
        <div class="grid lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-3">
                <p class="font-mono text-[10px] tracking-[0.32em] uppercase text-chalk-quiet">
                    Trabajan con KYROS
                </p>
                <p class="font-display text-2xl tracking-tighter text-chalk mt-1 font-normal">+80 equipos</p>
            </div>
            <div class="lg:col-span-9 overflow-hidden mask-fade-x marquee-paused">
                <div class="flex gap-3 animate-ticker w-max">
                    <?php
                    $clients = ['Evallish BPO', 'Hospital Las Colinas', 'M&M Montas', 'AMD Accounting', 'Tafer Business Group'];
                    foreach (array_merge($clients, $clients, $clients) as $client):
                    ?>
                        <div class="liquid-glass-light flex-shrink-0 px-6 py-3.5 rounded-2xl flex items-center gap-2.5" style="border: 1px solid rgba(255,255,255,0.10);">
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-400" style="box-shadow: 0 0 10px var(--indigo);"></span>
                            <span class="text-[13px] font-medium tracking-tight text-chalk/65 whitespace-nowrap"><?= e($client) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════
     SERVICES — Massive bento grid
     ════════════════════════════════════════════════════════ -->
<section id="services" class="section relative overflow-hidden">
    <div class="absolute top-10 left-0 section-num">/01</div>

    <div class="container relative">
        <!-- Section header -->
        <div class="grid lg:grid-cols-12 gap-10 mb-16 items-end">
            <div class="lg:col-span-7">
                <span class="eyebrow reveal"><span class="eyebrow-num">[01]</span>Servicios</span>
                <h2 class="font-display font-normal tracking-tightest leading-[0.98] text-balance
                           text-[clamp(2rem,4.5vw,3.75rem)] mt-6 reveal">
                    Cuatro disciplinas, <span class="text-italic-serif text-grad-indigo">un equipo</span>.
                </h2>
            </div>
            <div class="lg:col-span-4 lg:col-start-9 reveal" style="transition-delay:120ms">
                <p class="text-chalk/55 text-[15.5px] leading-relaxed">
                    Una plataforma integral. Sin proveedores múltiples. Sin manos pasando la pelota. Una sola responsabilidad: que tu tecnología funcione.
                </p>
            </div>
        </div>

        <!-- Massive bento -->
        <div class="grid lg:grid-cols-12 gap-5">
            <!-- Featured: Software (largest) -->
            <a href="<?= url('/services/software-development') ?>" class="lg:col-span-8 lg:row-span-2 tilt reveal group">
                <div class="tilt-target card spotlight h-full overflow-hidden" style="min-height: 440px;">
                    <div class="absolute inset-0 opacity-30"
                         style="background-image: linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px); background-size: 40px 40px;
                                -webkit-mask-image: radial-gradient(60% 60% at 100% 0%, #000, transparent 70%); mask-image: radial-gradient(60% 60% at 100% 0%, #000, transparent 70%);"></div>
                    <div class="absolute -top-32 -right-20 w-[26rem] h-[26rem] rounded-full pointer-events-none"
                         style="background: radial-gradient(circle, rgba(99,102,241,0.22), transparent 65%); filter: blur(90px);"></div>

                    <div class="relative h-full flex flex-col p-2 tilt-up">
                        <div class="flex items-start justify-between mb-10">
                            <div class="icon-chip icon-chip-lg"><?= icon('code', 'w-7 h-7') ?></div>
                            <div class="flex items-center gap-2">
                                <span class="font-mono text-[10.5px] tracking-tight text-chalk-quiet">[01] / 04</span>
                                <span class="code-badge">Featured</span>
                            </div>
                        </div>

                        <h3 class="font-display font-normal tracking-tightest text-[clamp(1.75rem,3.5vw,3rem)] leading-[1.02] mb-5 text-balance">
                            Desarrollo de software <span class="text-italic-serif text-grad-indigo">a medida</span>
                        </h3>

                        <p class="text-chalk/60 leading-relaxed max-w-lg mb-10 text-[15.5px]">
                            Aplicaciones web, plataformas SaaS y sistemas empresariales construidos con arquitectura moderna, entregas medibles y cero deuda técnica desde el primer commit.
                        </p>

                        <!-- Tech badges -->
                        <div class="mt-auto flex flex-wrap gap-2 mb-7">
                            <?php foreach (['React', 'Next.js', 'Laravel', 'Node', 'TypeScript', 'Python', 'AWS'] as $t): ?>
                                <span class="pill"><?= e($t) ?></span>
                            <?php endforeach; ?>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3 text-chalk font-medium text-[14px] group-hover:gap-4 transition-all">
                                <span class="link-anim">Ver detalle del servicio</span>
                                <span class="w-9 h-9 rounded-full bg-chalk/10 flex items-center justify-center group-hover:bg-indigo-500 transition-all">
                                    <?= icon('arrow-right', 'w-4 h-4') ?>
                                </span>
                            </div>
                            <!-- Mini metrics -->
                            <div class="hidden md:flex items-center gap-4 text-right">
                                <div>
                                    <div class="big-num text-grad-indigo text-[1.5rem] leading-none">120+</div>
                                    <div class="font-mono text-[9px] tracking-[0.2em] uppercase text-chalk-quiet mt-1">Proyectos</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Cybersecurity -->
            <a href="<?= url('/services/cybersecurity') ?>" class="lg:col-span-4 tilt reveal group" style="transition-delay:80ms">
                <div class="tilt-target card spotlight h-full" style="min-height: 230px;">
                    <div class="absolute top-0 right-0 w-48 h-48 rounded-full pointer-events-none"
                         style="background: radial-gradient(circle, rgba(34,211,238,0.22), transparent 65%); filter: blur(50px);"></div>
                    <div class="relative h-full flex flex-col tilt-up">
                        <div class="flex items-start justify-between mb-5">
                            <div class="icon-chip icon-chip-cyan"><?= icon('shield', 'w-6 h-6') ?></div>
                            <span class="font-mono text-[10.5px] tracking-tight text-chalk-quiet">[02]</span>
                        </div>
                        <h3 class="font-display text-[22px] tracking-tighter font-normal mb-2.5 leading-tight">Ciberseguridad avanzada</h3>
                        <p class="text-chalk/55 text-[13.5px] leading-relaxed mb-5 flex-grow">
                            Pentesting, hardening, monitoreo y respuesta ante incidentes.
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex gap-1.5">
                                <?php foreach (['Pentest','SIEM','OWASP'] as $t): ?>
                                    <span class="pill text-[10px]"><?= e($t) ?></span>
                                <?php endforeach; ?>
                            </div>
                            <span class="w-8 h-8 rounded-full bg-chalk/10 flex items-center justify-center group-hover:bg-indigo-500 group-hover:translate-x-1 transition-all">
                                <?= icon('arrow-right', 'w-3.5 h-3.5') ?>
                            </span>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Technical Support -->
            <a href="<?= url('/services/technical-support') ?>" class="lg:col-span-4 tilt reveal group" style="transition-delay:140ms">
                <div class="tilt-target card spotlight h-full" style="min-height: 230px;">
                    <div class="absolute top-0 right-0 w-48 h-48 rounded-full pointer-events-none"
                         style="background: radial-gradient(circle, rgba(167,139,250,0.22), transparent 65%); filter: blur(50px);"></div>
                    <div class="relative h-full flex flex-col tilt-up">
                        <div class="flex items-start justify-between mb-5">
                            <div class="icon-chip icon-chip-violet"><?= icon('headset', 'w-6 h-6') ?></div>
                            <span class="font-mono text-[10.5px] tracking-tight text-chalk-quiet">[03]</span>
                        </div>
                        <h3 class="font-display text-[22px] tracking-tighter font-normal mb-2.5 leading-tight">Soporte 24/7</h3>
                        <p class="text-chalk/55 text-[13.5px] leading-relaxed mb-5 flex-grow">
                            Mesa de ayuda con SLA. Resolvemos en minutos, no en días.
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex gap-1.5">
                                <?php foreach (['SLA','Remoto','KyDesk'] as $t): ?>
                                    <span class="pill text-[10px]"><?= e($t) ?></span>
                                <?php endforeach; ?>
                            </div>
                            <span class="w-8 h-8 rounded-full bg-chalk/10 flex items-center justify-center group-hover:bg-indigo-500 group-hover:translate-x-1 transition-all">
                                <?= icon('arrow-right', 'w-3.5 h-3.5') ?>
                            </span>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Network (wide) -->
            <a href="<?= url('/services/network-infrastructure') ?>" class="lg:col-span-12 tilt reveal group" style="transition-delay:200ms">
                <div class="tilt-target card spotlight">
                    <div class="grid md:grid-cols-12 gap-6 items-center tilt-up">
                        <div class="md:col-span-1">
                            <div class="icon-chip icon-chip-mono"><?= icon('wifi', 'w-6 h-6') ?></div>
                        </div>
                        <div class="md:col-span-7">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="font-mono text-[10.5px] tracking-tight text-chalk-quiet">[04]</span>
                                <h3 class="font-display text-[24px] tracking-tighter font-normal leading-tight">Infraestructura de redes</h3>
                            </div>
                            <p class="text-chalk/55 text-[14px] leading-relaxed">
                                Diseño, implementación y administración de redes empresariales: cableado certificado, WiFi 6, firewalls y VPN.
                            </p>
                        </div>
                        <div class="md:col-span-4 flex md:justify-end items-center gap-1.5 flex-wrap">
                            <?php foreach (['Cisco', 'MikroTik', 'WiFi 6', 'VPN'] as $t): ?>
                                <span class="pill text-[10.5px]"><?= e($t) ?></span>
                            <?php endforeach; ?>
                            <span class="w-8 h-8 rounded-full bg-chalk/10 flex items-center justify-center group-hover:bg-indigo-500 group-hover:translate-x-1 transition-all ml-2">
                                <?= icon('arrow-right', 'w-3.5 h-3.5') ?>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════
     STATS — Massive numbers with sparklines
     ════════════════════════════════════════════════════════ -->
<section id="stats" class="section-tight border-t border-white/5 relative overflow-hidden">
    <div class="absolute inset-0 dotted-mask opacity-40"></div>
    <div class="absolute top-0 right-0 section-num">/02</div>

    <div class="container relative z-10">
        <div class="grid md:grid-cols-12 gap-10 items-end mb-14">
            <div class="md:col-span-6">
                <span class="eyebrow reveal"><span class="eyebrow-num">[02]</span>Por los números</span>
                <h2 class="font-display font-normal tracking-tightest text-[clamp(2rem,4.5vw,3.75rem)] leading-[0.98] mt-6 reveal text-balance">
                    Resultados que se <span class="text-italic-serif text-grad-indigo">miden</span>.
                </h2>
            </div>
            <div class="md:col-span-5 md:col-start-8 reveal">
                <p class="text-chalk/55 text-[15px] leading-relaxed">
                    Una década entregando software, cerrando vulnerabilidades, levantando redes y atendiendo emergencias. Datos verificables, no promesas.
                </p>
            </div>
        </div>

        <!-- Big stats with sparklines -->
        <div class="liquid-glass grid grid-cols-2 md:grid-cols-4 gap-0" style="border-radius: 28px;">
            <?php
            $stats = [
                ['10',   '+',  'AÑOS',      'De experiencia',       'M0,30 L20,28 L40,25 L60,22 L80,20 L100,16 L120,12 L140,10 L160,7 L180,5'],
                ['80',   '+',  'CLIENTES',  'Activos en LATAM',     'M0,35 L20,30 L40,32 L60,25 L80,22 L100,18 L120,12 L140,8 L160,6 L180,4'],
                ['120',  '+',  'PROYECTOS', 'Entregados',           'M0,40 L20,38 L40,35 L60,30 L80,25 L100,22 L120,18 L140,12 L160,8 L180,5'],
                ['99.9', '%',  'UPTIME',    'En infra administrada','M0,12 L20,10 L40,12 L60,8 L80,10 L100,7 L120,8 L140,5 L160,7 L180,4'],
            ];
            foreach ($stats as $i => [$val, $suffix, $kpi, $desc, $path]):
            ?>
                <div class="relative p-6 sm:p-8 md:p-10 reveal <?= ($i % 2 === 1) ? 'border-l border-white/5' : '' ?> <?= $i >= 2 ? 'border-t border-white/5 md:border-t-0 md:border-l' : '' ?>"
                     style="transition-delay: <?= $i*80 ?>ms;">
                    <div class="big-num stat-shine text-[clamp(3.5rem,7.5vw,6.5rem)] mb-3">
                        <span data-counter="<?= e($val) ?>" data-suffix="<?= e($suffix) ?>">0<?= e($suffix) ?></span>
                    </div>
                    <svg class="sparkline w-full h-8 mb-3 opacity-60" viewBox="0 0 200 45" preserveAspectRatio="none">
                        <path d="<?= e($path) ?>"/>
                    </svg>
                    <div class="font-mono text-[10px] tracking-[0.24em] uppercase text-chalk-quiet font-medium mb-1"><?= e($kpi) ?></div>
                    <div class="text-[13px] text-chalk/55"><?= e($desc) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════
     INTERACTIVE ESTIMATOR
     ════════════════════════════════════════════════════════ -->
<section id="estimator" class="section relative overflow-hidden" data-spotlight-section>
    <div class="liquid-orb liquid-orb--indigo" style="width: 460px; height: 460px; top: -120px; left: -80px;"></div>

    <div class="container relative z-10">
        <div class="grid lg:grid-cols-12 gap-10 mb-14 items-end">
            <div class="lg:col-span-7">
                <span class="eyebrow reveal"><span class="eyebrow-num">[03]</span>Estimador interactivo</span>
                <h2 class="font-display font-normal tracking-tightest text-[clamp(2rem,4.5vw,3.75rem)] leading-[0.98] mt-6 reveal text-balance">
                    Calcula tu proyecto <span class="text-italic-serif text-grad-indigo">en segundos</span>.
                </h2>
            </div>
            <div class="lg:col-span-4 lg:col-start-9 reveal">
                <p class="text-chalk/55 text-[15px] leading-relaxed">
                    Selecciona el tipo, escala y plazo. Te damos una banda referencial inmediata. La propuesta final se hace tras discovery (30 min, gratis).
                </p>
            </div>
        </div>

        <div class="grid lg:grid-cols-12 gap-5" data-estimator>
            <!-- Left: Steps -->
            <div class="lg:col-span-7 space-y-5">
                <!-- Step 1: Service type -->
                <div class="liquid-panel reveal" data-step="1">
                    <div class="flex items-center justify-between mb-7">
                        <div class="flex items-center gap-3">
                            <span class="w-9 h-9 rounded-full liquid-glass-indigo flex items-center justify-center font-mono text-[12px] text-indigo-200 font-medium">01</span>
                            <span class="font-display text-[18px] tracking-tight">¿Qué tipo de proyecto?</span>
                        </div>
                        <span class="pill" data-step-status="1">Selecciona uno</span>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2.5">
                        <?php
                        $services = [
                            ['web',         'globe',    'Web app / SaaS',     'Dashboard / Portal'],
                            ['enterprise',  'building', 'Sistema empresarial','ERP / CRM / facturación'],
                            ['security',    'shield',   'Ciberseguridad',     'Pentest / SOC'],
                            ['infra',       'wifi',     'Infraestructura',    'Redes / Cloud'],
                            ['support',     'headset',  'Soporte 24/7',       'Helpdesk SLA'],
                            ['modernize',   'rocket',   'Modernización',      'Legacy → moderno'],
                        ];
                        foreach ($services as $s):
                        ?>
                            <button type="button" class="est-card group" data-est-service="<?= e($s[0]) ?>">
                                <span class="est-card__icon"><?= icon($s[1], 'w-5 h-5') ?></span>
                                <span class="est-card__title"><?= e($s[2]) ?></span>
                                <span class="est-card__sub"><?= e($s[3]) ?></span>
                                <span class="est-card__check"><?= icon('check', 'w-3 h-3') ?></span>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Step 2: Scale slider -->
                <div class="liquid-panel reveal" data-step="2">
                    <div class="flex items-center justify-between mb-7">
                        <div class="flex items-center gap-3">
                            <span class="w-9 h-9 rounded-full liquid-glass-cyan flex items-center justify-center font-mono text-[12px] text-cyan-300 font-medium">02</span>
                            <span class="font-display text-[18px] tracking-tight">Escala estimada</span>
                        </div>
                        <span class="pill" data-step-status="2" data-scale-label>Producto medio</span>
                    </div>
                    <div class="relative">
                        <input type="range" min="1" max="5" value="2" class="est-slider" data-est-scale aria-label="Escala del proyecto">
                        <div class="grid grid-cols-5 mt-4 text-[11px] font-mono text-chalk-quiet">
                            <span class="text-left">MVP</span>
                            <span class="text-center">Producto</span>
                            <span class="text-center">Plataforma</span>
                            <span class="text-center">Enterprise</span>
                            <span class="text-right">Custom</span>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Timeline -->
                <div class="liquid-panel reveal" data-step="3">
                    <div class="flex items-center justify-between mb-7">
                        <div class="flex items-center gap-3">
                            <span class="w-9 h-9 rounded-full liquid-glass-violet flex items-center justify-center font-mono text-[12px] text-violet-300 font-medium">03</span>
                            <span class="font-display text-[18px] tracking-tight">¿Cuándo lo necesitas?</span>
                        </div>
                        <span class="pill" data-step-status="3">Normal · 2-3 meses</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2.5">
                        <button type="button" class="est-chip" data-est-timeline="fast">
                            <span class="font-display text-[15px]">ASAP</span>
                            <span class="text-[11px] text-chalk-quiet font-mono mt-1">+20% velocidad</span>
                        </button>
                        <button type="button" class="est-chip est-chip--active" data-est-timeline="normal">
                            <span class="font-display text-[15px]">2-3 meses</span>
                            <span class="text-[11px] text-chalk-quiet font-mono mt-1">Plazo estándar</span>
                        </button>
                        <button type="button" class="est-chip" data-est-timeline="flex">
                            <span class="font-display text-[15px]">Flexible</span>
                            <span class="text-[11px] text-chalk-quiet font-mono mt-1">6+ meses</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right: Live output card -->
            <div class="lg:col-span-5">
                <div class="lg:sticky lg:top-28">
                    <div class="liquid-panel reveal overflow-hidden">
                        <div class="liquid-orb liquid-orb--indigo" style="width: 320px; height: 320px; top: -120px; right: -60px;"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-7">
                                <span class="glow-tag"><span class="text-chalk">En vivo</span></span>
                                <span class="font-mono text-[10.5px] tracking-[0.22em] uppercase text-chalk-quiet">Banda referencial</span>
                            </div>

                            <div class="font-mono text-[10.5px] tracking-[0.22em] uppercase text-chalk-quiet mb-2">Inversión estimada</div>
                            <div class="big-num text-grad-indigo text-[clamp(2.5rem,5vw,4rem)] mb-1 leading-none" data-est-output="price">
                                $15K — $30K
                            </div>
                            <div class="text-chalk/55 text-[13px] mb-7">USD · Valores referenciales (ajustes tras discovery)</div>

                            <div class="hairline mb-7"></div>

                            <div class="grid grid-cols-2 gap-3 mb-7">
                                <div class="liquid-glass p-4" style="border-radius: 16px;">
                                    <div class="font-mono text-[10px] tracking-[0.2em] uppercase text-chalk-quiet mb-2">Tiempo</div>
                                    <div class="font-display text-[22px] tracking-tight" data-est-output="time">10-14 sem</div>
                                </div>
                                <div class="liquid-glass p-4" style="border-radius: 16px;">
                                    <div class="font-mono text-[10px] tracking-[0.2em] uppercase text-chalk-quiet mb-2">Equipo</div>
                                    <div class="font-display text-[22px] tracking-tight" data-est-output="team">3-4 personas</div>
                                </div>
                            </div>

                            <div class="space-y-2.5 mb-7">
                                <div class="flex items-start gap-3 text-chalk/75 text-[13px]">
                                    <span class="w-5 h-5 mt-0.5 rounded-full bg-indigo-500/15 border border-indigo-500/30 flex items-center justify-center text-indigo-300 flex-shrink-0"><?= icon('check', 'w-3 h-3') ?></span>
                                    <span>Discovery <strong class="text-chalk">gratuito</strong> de 30 min antes de cualquier compromiso</span>
                                </div>
                                <div class="flex items-start gap-3 text-chalk/75 text-[13px]">
                                    <span class="w-5 h-5 mt-0.5 rounded-full bg-indigo-500/15 border border-indigo-500/30 flex items-center justify-center text-indigo-300 flex-shrink-0"><?= icon('check', 'w-3 h-3') ?></span>
                                    <span>Propuesta detallada en <strong class="text-chalk">48 horas</strong></span>
                                </div>
                                <div class="flex items-start gap-3 text-chalk/75 text-[13px]">
                                    <span class="w-5 h-5 mt-0.5 rounded-full bg-indigo-500/15 border border-indigo-500/30 flex items-center justify-center text-indigo-300 flex-shrink-0"><?= icon('check', 'w-3 h-3') ?></span>
                                    <span>Garantía contractual <strong class="text-chalk">en SLA</strong></span>
                                </div>
                            </div>

                            <a href="<?= url('/contact') ?>" class="btn-ember sheen magnetic w-full justify-center py-3.5 text-[14px]" data-est-cta>
                                Solicitar propuesta detallada
                                <svg class="w-4 h-4 arrow-ic" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-5-5l5 5-5 5"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════
     WHY US — Editorial bento
     ════════════════════════════════════════════════════════ -->
<section id="why" class="section relative overflow-hidden">
    <div class="absolute top-10 left-0 section-num">/04</div>

    <div class="container relative">
        <div class="grid md:grid-cols-12 gap-10 mb-16 items-end">
            <div class="md:col-span-7">
                <span class="eyebrow reveal"><span class="eyebrow-num">[03]</span>Por qué KYROS</span>
                <h2 class="font-display font-normal tracking-tightest text-[clamp(2rem,4.5vw,3.75rem)] leading-[0.98] mt-6 reveal text-balance">
                    No vendemos horas. <span class="text-italic-serif text-grad-indigo">Entregamos</span> resultados.
                </h2>
            </div>
            <div class="md:col-span-4 md:col-start-9 reveal">
                <p class="text-chalk/55 text-[15px] leading-relaxed">
                    Cuatro principios operativos que nos diferencian de cualquier proveedor de tecnología tradicional.
                </p>
            </div>
        </div>

        <div class="grid lg:grid-cols-12 gap-5">
            <div class="lg:col-span-7 reveal tilt" style="min-height: 420px;">
                <div class="tilt-target card h-full spotlight overflow-hidden">
                    <div class="absolute top-0 right-0 w-[22rem] h-[22rem] rounded-full pointer-events-none" style="background: radial-gradient(circle, rgba(99,102,241,0.18), transparent 65%); filter: blur(90px);"></div>
                    <div class="relative h-full flex flex-col tilt-up p-2">
                        <div class="flex items-center gap-3 mb-7">
                            <div class="icon-chip"><?= icon('rocket', 'w-6 h-6') ?></div>
                            <span class="pill">Filosofía operativa</span>
                        </div>
                        <h3 class="font-display text-[clamp(1.75rem,3.2vw,2.75rem)] tracking-tightest font-normal leading-[0.95] mb-6 text-balance">
                            Velocidad sin <span class="text-italic-serif text-chalk/60">sacrificar</span> <span class="text-grad-indigo">calidad</span>.
                        </h3>
                        <p class="text-chalk/60 text-[15.5px] leading-relaxed max-w-lg mb-10">
                            Sprints de 2 semanas, demos constantes y entregas medibles. Sabes en todo momento dónde está tu proyecto y qué viene después. Sin sorpresas, sin "fast and broken".
                        </p>
                        <div class="mt-auto grid grid-cols-3 gap-3">
                            <?php foreach ([['2','SEMANAS/SPRINT'],['100%','VISIBILIDAD'],['0','SORPRESAS']] as [$v,$l]): ?>
                                <div class="liquid-glass p-4" style="border-radius: 16px;">
                                    <div class="font-display text-[26px] font-normal tracking-tightest text-chalk leading-none mb-2"><?= e($v) ?></div>
                                    <div class="font-mono text-[9.5px] tracking-[0.18em] uppercase text-chalk-quiet"><?= e($l) ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 grid gap-5">
                <?php
                $subs = [
                    ['shield',  'icon-chip-cyan',   'Seguridad por diseño', 'Cifrado, auditorías y buenas prácticas desde el primer commit.'],
                    ['users',   'icon-chip-violet', 'Equipo senior',         '+10 años promedio por especialista. Sin juniors aprendiendo en tu proyecto.'],
                    ['target',  'icon-chip-mono',   'Foco en métricas',      'Si no se mide, no se entrega.'],
                ];
                foreach ($subs as $i => [$ico, $chipClass, $title, $desc]):
                ?>
                    <div class="tilt reveal" style="transition-delay: <?= 120 + $i*80 ?>ms;">
                        <div class="tilt-target card spotlight" style="padding: 1.5rem;">
                            <div class="flex items-start gap-4 tilt-up">
                                <div class="icon-chip <?= $chipClass ?> shrink-0" style="width:44px;height:44px;border-radius:12px;"><?= icon($ico, 'w-5 h-5') ?></div>
                                <div>
                                    <h3 class="font-display text-[18px] font-normal tracking-tighter mb-1.5"><?= e($title) ?></h3>
                                    <p class="text-chalk/55 text-[13.5px] leading-relaxed"><?= e($desc) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════
     PROCESS — Sticky stacking
     ════════════════════════════════════════════════════════ -->
<section id="process" class="section border-t border-white/5 relative overflow-hidden">
    <div class="absolute top-10 right-0 section-num">/05</div>

    <div class="container relative">
        <div class="grid lg:grid-cols-12 gap-14">
            <div class="lg:col-span-4">
                <div class="lg:sticky lg:top-28">
                    <span class="eyebrow reveal"><span class="eyebrow-num">[04]</span>Proceso</span>
                    <h2 class="font-display font-normal tracking-tightest text-[clamp(2rem,4vw,3.25rem)] leading-[0.98] mt-6 mb-6 reveal text-balance">
                        De la idea al <span class="text-italic-serif text-grad-indigo">despliegue</span>.
                    </h2>
                    <p class="text-chalk/55 text-[15px] leading-relaxed reveal">
                        Seis fases. Una metodología probada con +120 proyectos. Cada paso se apila mientras navegas — la historia completa visible.
                    </p>
                    <div class="hairline my-8"></div>
                    <a href="<?= url('/contact') ?>" class="btn-outline magnetic">
                        Empezar discovery
                        <svg class="w-3.5 h-3.5 arrow-ic" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-5-5l5 5-5 5"/></svg>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-8">
                <?php
                $steps = [
                    ['target',  '01', 'Descubrimiento', 'Workshop intensivo para mapear objetivos, usuarios, restricciones y métricas de éxito. Sin este paso, todo lo demás es ruido.', 'Sesión gratuita · 90 min'],
                    ['palette', '02', 'Diseño',         'Wireframes, prototipos clicables y design system validado con tu equipo antes de tocar una sola línea de código.', '2-3 semanas'],
                    ['code',    '03', 'Desarrollo',     'Sprints ágiles con entregas demostrables cada 2 semanas y un canal directo con el equipo. Cero opacidad.', 'Iterativo'],
                    ['shield',  '04', 'QA & Seguridad', 'Pruebas automatizadas, revisión manual, escaneo de vulnerabilidades y hardening antes del despliegue.', '1-2 semanas'],
                    ['rocket',  '05', 'Despliegue',     'Lanzamiento controlado por etapas, monitoreo activo y plan de rollback claro. Sin fines de semana en blanco.', 'Go-live'],
                    ['headset', '06', 'Soporte',        'Mantenimiento, mejoras continuas y métricas mensuales para evolucionar el producto post-lanzamiento.', 'Continuo'],
                ];
                $count = count($steps);
                foreach ($steps as $i => [$ico, $num, $title, $desc, $duration]):
                ?>
                    <div class="stack-card mb-4 reveal" style="top: <?= 96 + $i*22 ?>px; z-index: <?= 10 + $i ?>; transition-delay: <?= $i*60 ?>ms;">
                        <div class="card spotlight relative overflow-hidden p-7 md:p-9"
                             style="background: linear-gradient(180deg, var(--bg-elev-2), var(--bg-elev-1)); border: 1px solid rgba(255,255,255,0.08);">
                            <div class="absolute top-0 right-0 w-72 h-72 rounded-full pointer-events-none" style="background: radial-gradient(circle, rgba(91,94,255,0.20), transparent 65%); filter: blur(70px);"></div>
                            <div class="relative grid md:grid-cols-12 gap-5 items-start">
                                <div class="md:col-span-1">
                                    <div class="big-num text-grad-indigo text-[3.5rem] leading-none"><?= e($num) ?></div>
                                </div>
                                <div class="md:col-span-1">
                                    <div class="icon-chip" style="width:42px;height:42px;border-radius:12px;"><?= icon($ico, 'w-5 h-5') ?></div>
                                </div>
                                <div class="md:col-span-7">
                                    <h3 class="font-display text-[clamp(1.5rem,2.4vw,1.875rem)] tracking-tightest font-normal mb-3"><?= e($title) ?></h3>
                                    <p class="text-chalk/60 text-[14.5px] leading-relaxed"><?= e($desc) ?></p>
                                </div>
                                <div class="md:col-span-3 md:text-right">
                                    <span class="pill"><?= e($duration) ?></span>
                                    <div class="mt-4 font-mono text-[10px] tracking-[0.22em] uppercase text-chalk-quiet">
                                        Fase <?= $i+1 ?> / <?= $count ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════
     SHOWCASE — Horizontal scroll cases
     ════════════════════════════════════════════════════════ -->
<section id="showcase" class="section overflow-hidden relative">
    <div class="absolute top-10 left-0 section-num">/06</div>

    <div class="container relative mb-14">
        <div class="grid lg:grid-cols-12 gap-10 items-end">
            <div class="lg:col-span-7">
                <span class="eyebrow reveal"><span class="eyebrow-num">[05]</span>Trabajos recientes</span>
                <h2 class="font-display font-normal tracking-tightest text-[clamp(2rem,4.5vw,3.75rem)] leading-[0.98] mt-6 reveal text-balance">
                    Proyectos que <span class="text-italic-serif text-grad-indigo">mueven</span> negocios.
                </h2>
            </div>
            <div class="lg:col-span-4 lg:col-start-9 reveal">
                <p class="text-chalk/55 text-[15px] leading-relaxed">
                    Software construido para operar bajo presión real.
                </p>
                <p class="mt-4 font-mono text-[11px] tracking-[0.2em] uppercase text-chalk-quiet">→ Desliza horizontal</p>
            </div>
        </div>
    </div>

    <div class="carousel relative" data-carousel>
        <button type="button" class="carousel__btn carousel__btn--prev hidden md:inline-flex" aria-label="Anterior" data-carousel-prev>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button type="button" class="carousel__btn carousel__btn--next hidden md:inline-flex" aria-label="Siguiente" data-carousel-next>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        </button>
        <div class="carousel__track snap-x-mand pb-6 pt-1" data-carousel-track>
        <div class="flex gap-5 pl-6 md:pl-[max(1.5rem,calc((100vw-1400px)/2+2.5rem))] pr-6">
            <?php
            $cases = [
                ['Hospital Las Colinas', 'Sistema HIS hospitalario',                 'Modernización completa del sistema de información hospitalaria con módulos de admisión, historia clínica electrónica y facturación.',                                                  'icon-chip-cyan',   '40% menos fricción operativa'],
                ['Evallish BPO',         'Suite operativa BPO completa',             'Aplicaciones de control de empleados, ponche electrónico, control de nómina y gestión de calidad de call center, más una landing page moderna corporativa.',                                  '',                 'Operación BPO 100% digital'],
                ['Tafer Business Group', 'Finanzas, préstamos y landing',            'Aplicación web completa para gestión de finanzas y préstamos, junto con una landing page moderna que refuerza la presencia corporativa.',                                                      'icon-chip-violet', 'Operación financiera digitalizada'],
                ['M&M Montas',           'Control financiero avanzado',              'Aplicación web a medida para control financiero avanzado con módulos de seguimiento, reportes consolidados y dashboards de cumplimiento.',                                                    'icon-chip-mono',   'Control total de finanzas'],
                ['AMD Accounting',       'Gestión contable e igualas',               'Aplicación web completa para gestión de procesos contables y control de igualas, centralizando operaciones del estudio y reduciendo trabajo manual.',                                          'icon-chip-cyan',   'Procesos contables centralizados'],
            ];
            foreach ($cases as $i => [$client, $title, $desc, $chipClass, $metric]):
            ?>
                <article class="snap-start shrink-0 w-[88vw] max-w-[460px] tilt reveal" style="transition-delay: <?= $i*80 ?>ms;">
                    <div class="tilt-target card spotlight" style="min-height: 460px;">
                        <div class="flex items-start justify-between mb-7 tilt-up">
                            <div class="icon-chip <?= $chipClass ?>"><?= icon('briefcase', 'w-5 h-5') ?></div>
                            <span class="font-mono text-[10.5px] tracking-tight text-chalk-quiet">CASO 0<?= $i+1 ?></span>
                        </div>
                        <p class="font-mono text-[11px] tracking-[0.18em] uppercase text-chalk-quiet mb-3"><?= e($client) ?></p>
                        <h3 class="font-display text-[26px] tracking-tighter font-normal leading-tight mb-4 text-balance"><?= e($title) ?></h3>
                        <p class="text-chalk/55 text-[14px] leading-relaxed mb-8"><?= e($desc) ?></p>
                        <div class="mt-auto pt-6 border-t border-white/8">
                            <div class="flex items-baseline gap-3">
                                <span class="big-num text-grad-indigo text-[2rem]">→</span>
                                <p class="text-chalk font-medium text-[14.5px] tracking-tight"><?= e($metric) ?></p>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>

            <a href="<?= url('/contact') ?>" class="snap-start shrink-0 w-[88vw] max-w-[460px] card spotlight reveal flex flex-col items-center justify-center text-center group" style="min-height: 460px; background: linear-gradient(180deg, rgba(91,94,255,0.10), rgba(91,94,255,0.02));">
                <div class="icon-chip icon-chip-lg mb-6"><?= icon('arrow-right', 'w-6 h-6') ?></div>
                <h3 class="font-display text-[26px] tracking-tighter font-normal leading-tight mb-3">Tu proyecto<br><span class="text-italic-serif text-grad-indigo">aquí</span>.</h3>
                <p class="text-chalk/55 text-[14px] leading-relaxed max-w-xs mx-auto mb-8">Cuéntanos qué necesitas. Te entregamos una propuesta concreta en 48 horas.</p>
                <span class="btn-ember sheen magnetic">Empecemos <svg class="w-3.5 h-3.5 arrow-ic" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-5-5l5 5-5 5"/></svg></span>
            </a>
        </div>
        </div>
        <div class="carousel__dots container" data-carousel-dots></div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════
     TECH STACK
     ════════════════════════════════════════════════════════ -->
<section id="stack" class="section-tight overflow-hidden border-t border-white/5 relative">
    <div class="absolute top-10 right-0 section-num">/07</div>

    <div class="container relative">
        <div class="grid lg:grid-cols-12 gap-10 items-end mb-10">
            <div class="lg:col-span-7">
                <span class="eyebrow reveal"><span class="eyebrow-num">[06]</span>Stack</span>
                <h2 class="font-display font-normal tracking-tightest text-[clamp(1.85rem,3.8vw,3rem)] leading-[0.98] mt-6 reveal text-balance">
                    Las mejores herramientas, <span class="text-italic-serif text-grad-indigo">para cada trabajo</span>.
                </h2>
            </div>
        </div>
    </div>

    <div class="space-y-3 relative">
        <div class="overflow-hidden mask-fade-x marquee-paused">
            <div class="flex gap-3 animate-ticker w-max">
                <?php
                $row1 = ['React', 'Next.js', 'TypeScript', 'Vue.js', 'Node.js', 'Python', 'Laravel', 'PHP', 'Tailwind', 'Go', 'Rust', 'Astro', 'Svelte', 'FastAPI'];
                foreach (array_merge($row1, $row1, $row1) as $t):
                ?>
                    <div class="liquid-glass-light shrink-0 px-6 py-3.5 rounded-full" style="border: 1px solid rgba(255,255,255,0.12);">
                        <span class="text-[14px] font-medium text-chalk/80 whitespace-nowrap tracking-tight"><?= e($t) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="overflow-hidden mask-fade-x marquee-paused">
            <div class="flex gap-3 animate-marquee-rev w-max">
                <?php
                $row2 = ['AWS', 'Docker', 'Kubernetes', 'PostgreSQL', 'MongoDB', 'Redis', 'MySQL', 'Cloudflare', 'GitHub', 'Linux', 'Stripe', 'Resend', 'Vercel', 'GCP'];
                foreach (array_merge($row2, $row2, $row2) as $t):
                ?>
                    <div class="liquid-glass-light shrink-0 px-6 py-3.5 rounded-full" style="border: 1px solid rgba(255,255,255,0.12);">
                        <span class="text-[14px] font-medium text-chalk/80 whitespace-nowrap tracking-tight"><?= e($t) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════
     TESTIMONIALS
     ════════════════════════════════════════════════════════ -->
<section id="testimonials" class="section border-t border-white/5 relative overflow-hidden">
    <div class="absolute top-10 left-0 section-num">/08</div>

    <div class="container relative">
        <div class="grid md:grid-cols-12 gap-10 mb-16 items-end">
            <div class="md:col-span-7">
                <span class="eyebrow reveal"><span class="eyebrow-num">[07]</span>Voces</span>
                <h2 class="font-display font-normal tracking-tightest text-[clamp(2rem,4.5vw,3.75rem)] leading-[0.98] mt-6 reveal text-balance">
                    Lo que dicen <span class="text-italic-serif text-grad-indigo">nuestros clientes</span>.
                </h2>
            </div>
            <div class="md:col-span-3 md:col-start-10 reveal">
                <div class="flex items-baseline gap-2">
                    <span class="big-num text-grad-indigo text-[5rem] leading-none">4.9</span>
                    <div class="flex gap-0.5 text-indigo-400">
                        <?= str_repeat(icon('star', 'w-4 h-4 fill-current'), 5) ?>
                    </div>
                </div>
                <p class="text-chalk/45 text-[12px] tracking-tight mt-3 font-mono">basado en 60+ proyectos completados</p>
            </div>
        </div>

        <div class="grid md:grid-cols-12 gap-5">
            <?php
            $testimonials = [
                ['KYROS no solo entregó el sistema a tiempo, sino que nos ayudó a repensar procesos enteros. Hoy operamos con 40% menos fricción.', 'C. Hernández', 'Gerente de Operaciones', 'Hospital General Las Colinas', 'CH', '',             'md:col-span-7', true],
                ['Por fin un equipo de IT que habla nuestro idioma de negocio. La mesa de ayuda responde rápido y resuelve sin pretextos.', 'M. Montas',     'CEO',                    'M&M Montas',                    'MM', 'avatar-sky',   'md:col-span-5', false],
                ['Migramos toda la infraestructura sin downtime. La auditoría de seguridad nos cerró un riesgo crítico que llevábamos años cargando.', 'A. Domínguez', 'COO',                    'AMD Accounting',                'AD', 'avatar-amber', 'md:col-span-5', false],
                ['El equipo de KYROS funcionó como una extensión nuestra. Sprints transparentes, decisiones rápidas y un código que mis ingenieros pueden leer.', 'J. Tafer',     'Founder',                'Tafer Business Group',          'JT', '',             'md:col-span-7', true],
            ];
            foreach ($testimonials as $i => [$quote, $name, $role, $company, $initial, $avatarCls, $span, $big]):
            ?>
                <figure class="<?= e($span) ?> tilt reveal" style="transition-delay: <?= $i*60 ?>ms;">
                    <div class="tilt-target card spotlight flex flex-col h-full">
                        <div class="flex gap-1 mb-5 text-amber-300/90">
                            <?= str_repeat(icon('star', 'w-3.5 h-3.5 fill-current'), 5) ?>
                        </div>
                        <blockquote class="text-chalk/85 leading-relaxed flex-grow tracking-tight <?= $big ? 'text-[17px] md:text-[19px]' : 'text-[14.5px]' ?>">
                            "<?= e($quote) ?>"
                        </blockquote>
                        <figcaption class="mt-7 pt-5 border-t border-white/5 flex items-center gap-3">
                            <div class="avatar <?= e($avatarCls) ?> w-10 h-10 text-[13px]"><?= e($initial) ?></div>
                            <div class="min-w-0">
                                <div class="font-display text-[14px] font-medium text-chalk tracking-tight truncate"><?= e($name) ?></div>
                                <div class="text-[11.5px] text-chalk/50 mt-0.5 truncate"><?= e($role) ?> · <?= e($company) ?></div>
                            </div>
                        </figcaption>
                    </div>
                </figure>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════
     FAQ
     ════════════════════════════════════════════════════════ -->
<section id="faq" class="section border-t border-white/5 relative overflow-hidden">
    <div class="absolute top-10 right-0 section-num">/09</div>

    <div class="container relative">
        <div class="grid lg:grid-cols-12 gap-14">
            <div class="lg:col-span-4">
                <div class="lg:sticky lg:top-28">
                    <span class="eyebrow reveal"><span class="eyebrow-num">[08]</span>FAQ</span>
                    <h2 class="font-display font-normal tracking-tightest text-[clamp(1.85rem,3.8vw,3rem)] leading-[0.98] mt-6 mb-6 reveal text-balance">
                        Preguntas <span class="text-italic-serif text-grad-indigo">frecuentes</span>.
                    </h2>
                    <p class="text-chalk/55 text-[15px] leading-relaxed reveal">
                        ¿No encuentras lo que buscas? Escríbenos directamente y te respondemos en menos de 24 horas.
                    </p>
                    <a href="<?= url('/contact') ?>" class="inline-flex items-center gap-2 mt-7 text-indigo-300 hover:text-indigo-200 font-medium text-[14px] link-anim reveal">
                        Contactar al equipo →
                    </a>
                </div>
            </div>

            <div class="lg:col-span-8 space-y-2">
                <?php
                $faqs = [
                    ['¿Cuánto tarda un proyecto típico?', 'Depende del alcance, pero un MVP suele tomar 8 a 12 semanas. Te entregamos un cronograma detallado tras la sesión de descubrimiento (gratuita).'],
                    ['¿Trabajan con startups y empresas pequeñas?', 'Sí. Tenemos planes flexibles diseñados para equipos en crecimiento, con la posibilidad de escalar conforme tu negocio madura.'],
                    ['¿Qué sucede después del lanzamiento?', 'Ofrecemos planes de mantenimiento y soporte 24/7 con SLA, además de mejoras continuas y nuevas features según tu roadmap.'],
                    ['¿Cómo manejan la seguridad y los datos?', 'Trabajamos con buenas prácticas (OWASP, ISO 27001), cifrado en tránsito y reposo, control de accesos por rol y auditorías periódicas.'],
                    ['¿Pueden modernizar un sistema existente?', 'Absolutamente. Hacemos auditorías técnicas y migraciones progresivas hacia arquitecturas modernas sin interrumpir tu operación.'],
                    ['¿Trabajan de forma remota o presencial?', 'Operamos 100% remoto cubriendo Latinoamérica, con visitas on-site puntuales para clientes en República Dominicana.'],
                ];
                foreach ($faqs as $i => [$q, $a]):
                ?>
                    <div data-faq class="liquid-glass reveal" style="transition-delay: <?= $i*40 ?>ms; border-radius: 20px;">
                        <button data-faq-btn class="w-full flex items-center justify-between gap-4 p-5 md:p-6 text-left transition-colors">
                            <span class="font-display font-normal text-chalk tracking-tight text-[16.5px] md:text-[17.5px] pr-4"><?= e($q) ?></span>
                            <span data-faq-icon class="w-8 h-8 rounded-full liquid-glass-light flex items-center justify-center text-chalk/70 flex-shrink-0 transition-transform" style="border: 1px solid rgba(255,255,255,0.12);">
                                <?= icon('chevron-down', 'w-4 h-4') ?>
                            </span>
                        </button>
                        <div data-faq-body class="overflow-hidden transition-[max-height] duration-300" style="max-height:0">
                            <p class="px-5 md:px-6 pb-6 text-chalk/65 leading-relaxed text-[14.5px]"><?= e($a) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════
     FINAL CTA
     ════════════════════════════════════════════════════════ -->
<section id="cta" class="section-tight" data-spotlight-section>
    <div class="container">
        <div class="liquid-panel reveal overflow-hidden" style="padding: clamp(1.5rem, 3.5vw, 3rem);">

            <!-- Caustic light pool (top center) -->
            <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse 70% 90% at 50% 0%, rgba(91,94,255,0.34), transparent 60%);"></div>
            <!-- Liquid orbs -->
            <div class="liquid-orb liquid-orb--indigo" style="width: 420px; height: 420px; top: -180px; left: -80px;"></div>

            <div class="absolute inset-0 opacity-25 pointer-events-none" style="background-image: linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px); background-size: 48px 48px; -webkit-mask-image: radial-gradient(70% 70% at 50% 50%, #000, transparent 80%); mask-image: radial-gradient(70% 70% at 50% 50%, #000, transparent 80%);"></div>

            <div class="relative grid lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                <!-- Main CTA column -->
                <div class="lg:col-span-7">
                    <div class="flex items-center gap-2 mb-5">
                        <span class="eyebrow">Hablemos</span>
                        <span class="hidden sm:inline-flex glow-tag"><span class="text-chalk">Disponible</span></span>
                    </div>
                    <h2 class="font-display font-normal tracking-tightest text-[clamp(2.25rem,5.5vw,5rem)] leading-[0.9] text-balance">
                        ¿Listo para <span class="text-italic-serif text-grad-indigo">transformar</span> <span class="text-grad-cream">tu empresa</span>?
                    </h2>
                    <p class="text-chalk/65 text-[15.5px] md:text-[17px] leading-relaxed mt-6 max-w-xl">
                        30 minutos de consulta. Cero compromisos. Te entregamos una propuesta concreta en 48 horas y un cronograma realista de lo que viene después.
                    </p>

                    <!-- Trust chips -->
                    <div class="flex flex-wrap gap-2 mt-7">
                        <span class="pill"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400" style="box-shadow:0 0 8px #34d399"></span>+80 clientes</span>
                        <span class="pill"><span class="w-1.5 h-1.5 rounded-full bg-indigo-400" style="box-shadow:0 0 8px #6E6EFF"></span>+120 proyectos</span>
                        <span class="pill"><span class="w-1.5 h-1.5 rounded-full bg-cyan-400" style="box-shadow:0 0 8px #22D3EE"></span>99.9% uptime</span>
                    </div>

                    <div class="flex flex-col sm:flex-row flex-wrap gap-3 mt-8">
                        <a href="<?= url('/contact') ?>" class="btn-ember sheen magnetic text-[14.5px] py-3.5 px-6 justify-center">
                            Agendar consulta gratuita
                            <svg class="w-4 h-4 arrow-ic" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-5-5l5 5-5 5"/></svg>
                        </a>
                        <a href="tel:+18495024061" class="btn-outline sheen text-[14px] justify-center">
                            <?= icon('phone', 'w-4 h-4') ?> +1 (849) 502-4061
                        </a>
                    </div>
                </div>

                <!-- Right: next-steps panel -->
                <div class="lg:col-span-5">
                    <div class="liquid-glass p-5 sm:p-6" style="border-radius: 22px;">
                        <div class="flex items-center justify-between mb-5">
                            <p class="font-mono text-[10px] tracking-[0.22em] uppercase text-chalk-quiet">Próximos pasos</p>
                            <span class="font-mono text-[10.5px] text-chalk/55"><span id="cta-clock">--:--</span> · GMT-4</span>
                        </div>
                        <ol class="space-y-3.5">
                            <?php
                            $steps = [
                                ['01', 'Respondemos en menos de 24 h',          'Email + WhatsApp'],
                                ['02', 'Discovery gratuito de 30 min',          'Zoom / Meet'],
                                ['03', 'Propuesta detallada en 48 h',           'Alcance + cronograma + costo'],
                                ['04', 'Kickoff con tu equipo',                 'Empezamos cuando tú digas'],
                            ];
                            foreach ($steps as $i => [$n, $t, $sub]):
                            ?>
                                <li class="flex items-start gap-3 group">
                                    <span class="shrink-0 w-9 h-9 rounded-full liquid-glass-indigo flex items-center justify-center font-mono text-[12px] font-medium text-indigo-100 transition-transform group-hover:scale-105"><?= e($n) ?></span>
                                    <div class="min-w-0 flex-1">
                                        <div class="font-display text-[14.5px] tracking-tight text-chalk leading-tight"><?= e($t) ?></div>
                                        <div class="font-mono text-[10.5px] text-chalk/55 mt-1 tracking-tight"><?= e($sub) ?></div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                        <div class="hairline my-5"></div>
                        <a href="https://wa.me/18495024061" target="_blank" rel="noopener" class="flex items-center justify-between gap-3 -mx-1 px-3 py-2.5 rounded-xl transition-colors hover:bg-white/5 group">
                            <span class="flex items-center gap-3">
                                <span class="w-9 h-9 rounded-full flex items-center justify-center" style="background:#25D366; box-shadow:0 6px 18px -4px rgba(37,211,102,0.55);">
                                    <svg class="w-4 h-4" fill="#FFF" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448L.057 24z"/></svg>
                                </span>
                                <span>
                                    <span class="block font-display text-[13.5px] tracking-tight text-chalk">¿Prefieres WhatsApp?</span>
                                    <span class="block font-mono text-[10px] text-chalk/55 tracking-tight">Respuesta promedio &lt; 5 min</span>
                                </span>
                            </span>
                            <span class="text-chalk/30 group-hover:text-chalk group-hover:translate-x-1 transition-all"><?= icon('arrow-right', 'w-4 h-4') ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
