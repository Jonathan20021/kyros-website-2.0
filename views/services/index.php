<?php require_once base_path('views/partials/icons.php'); ?>

<!-- ════════════════════════════════════════════════════════════
     HERO STRIP
     ════════════════════════════════════════════════════════════ -->
<section class="relative pt-32 sm:pt-36 pb-16 overflow-hidden bg-[#EFEFEF]">
    <div class="hero-canvas" aria-hidden="true">
        <div class="hero-canvas__chroma"></div>
        <div class="hero-canvas__fluted"></div>
        <div class="hero-canvas__grain"></div>
    </div>

    <div class="relative z-20 max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <div class="flex items-center justify-between gap-4 mb-8 flex-wrap">
            <div class="section-badge">
                <span class="section-badge__num">S</span>
                <span class="section-badge__label">Servicios</span>
            </div>
            <span class="text-[12px] font-mono" style="color: var(--ink-muted);">6 disciplinas · 1 equipo</span>
        </div>
        <div class="grid lg:grid-cols-12 gap-10 items-end">
            <div class="lg:col-span-9">
                <h1 class="font-medium leading-[1.05] tracking-[-0.03em] text-balance"
                    style="color: var(--ink); font-size: clamp(2rem, 6vw, 4.2rem);">
                    Una plataforma <em class="text-italic-serif">end-to-end</em><br>para tu tecnología.
                </h1>
            </div>
            <div class="lg:col-span-3">
                <p class="text-[15px] sm:text-[16px] leading-[1.6]" style="color: var(--ink-soft);">
                    Software, ciberseguridad, soporte, redes, contenido y webs médicas. Seis disciplinas, un solo equipo, una responsabilidad: que tu tecnología funcione.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════════
     SERVICES GRID (2 columns, detailed cards)
     ════════════════════════════════════════════════════════════ -->
<section class="bg-white py-16 sm:py-20 lg:py-24">
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-2 gap-5 sm:gap-6" data-fluid-stagger>
            <?php
            $services = [
                [
                    'slug' => 'software-development', 'num' => '01', 'icon' => 'code',
                    'fg' => '#F26522', 'bg' => '#FFF4ED', 'bd' => '#FED7B5',
                    'title' => 'Desarrollo de Software', 'italic' => 'a medida',
                    'tag' => 'Web · SaaS · ERP',
                    'desc' => 'Construimos aplicaciones a medida con tecnologías modernas: desde landings y portales hasta plataformas SaaS multi-tenant y sistemas empresariales completos.',
                    'bullets' => ['Aplicaciones web y dashboards', 'Plataformas SaaS multi-tenant', 'APIs e integraciones (ERP/CRM)', 'Modernización de sistemas legacy'],
                ],
                [
                    'slug' => 'cybersecurity', 'num' => '02', 'icon' => 'shield',
                    'fg' => '#4F46E5', 'bg' => '#EEF2FF', 'bd' => '#C7D2FE',
                    'title' => 'Ciberseguridad', 'italic' => 'avanzada',
                    'tag' => 'Defensa · Pentest · SOC',
                    'desc' => 'Auditorías técnicas, ethical hacking, hardening de servidores y monitoreo continuo. Protegemos tu operación antes de que ocurra el incidente.',
                    'bullets' => ['Pentesting y auditorías', 'Hardening de servidores y nube', 'Respuesta ante incidentes', 'Capacitación a equipos'],
                ],
                [
                    'slug' => 'technical-support', 'num' => '03', 'icon' => 'headset',
                    'fg' => '#7C3AED', 'bg' => '#F5F3FF', 'bd' => '#DDD6FE',
                    'title' => 'Soporte Técnico', 'italic' => 'helpdesk 24/7',
                    'tag' => '24/7 · Remoto · On-site',
                    'desc' => 'Mesa de ayuda profesional con SLA garantizado. Resolvemos en minutos, no en días. Soporte remoto y presencial para tu equipo y tus clientes.',
                    'bullets' => ['Helpdesk multinivel (L1, L2, L3)', 'Soporte remoto y on-site', 'Gestión de inventario y activos', 'KyDesk: nuestra plataforma propia'],
                ],
                [
                    'slug' => 'network-infrastructure', 'num' => '04', 'icon' => 'wifi',
                    'fg' => '#0891B2', 'bg' => '#ECFEFF', 'bd' => '#A5F3FC',
                    'title' => 'Infraestructura', 'italic' => 'de redes',
                    'tag' => 'LAN · WAN · WiFi · Cloud',
                    'desc' => 'Diseñamos, instalamos y administramos redes empresariales: cableado estructurado, WiFi de alta densidad, firewalls, VPN y enlaces dedicados.',
                    'bullets' => ['Cableado estructurado certificado', 'WiFi 6 de alta densidad', 'Firewalls y segmentación', 'Enlaces dedicados y VPN'],
                ],
                [
                    'slug' => 'social-media', 'num' => '05', 'icon' => 'share',
                    'fg' => '#DB2777', 'bg' => '#FDF2F8', 'bd' => '#FBCFE8',
                    'title' => 'Redes Sociales', 'italic' => 'para tu marca',
                    'tag' => 'Contenido · Community · Ads',
                    'desc' => 'Manejamos la presencia digital de empresas y personas: estrategia, contenido, community management y campañas pagadas. Para que tu marca crezca y se vea profesional en cada plataforma.',
                    'bullets' => ['Estrategia y calendario de contenido', 'Diseño, foto y video profesional', 'Community management diario', 'Campañas en Meta, TikTok y Google Ads'],
                ],
                [
                    'slug' => 'medical-websites', 'num' => '06', 'icon' => 'stethoscope', 'is_new' => true,
                    'fg' => '#0D9488', 'bg' => '#F0FDFA', 'bd' => '#99F6E4',
                    'title' => 'Webs para', 'italic' => 'médicos',
                    'tag' => 'Salud · Planes cerrados',
                    'desc' => 'Sitios web para médicos, especialistas, odontólogos y centros de salud. Tu perfil profesional, tus consultorios, tus horarios y un botón para pedir cita. Con precio cerrado y entrega desde 7 días.',
                    'bullets' => ['Perfil profesional y trayectoria', 'Consultorios, mapas y horarios', 'Solicitud de citas y WhatsApp', 'SEO local para tu especialidad'],
                ],
            ];
            foreach ($services as $svc):
            ?>
                <a href="<?= url('/services/' . $svc['slug']) ?>" class="group block rounded-2xl p-8 bg-white border border-[rgba(17,17,17,0.08)] hover:shadow-[0_12px_32px_rgba(0,0,0,0.08)] hover:border-[rgba(17,17,17,0.14)] transition-all <?= !empty($svc['wide']) ? 'lg:col-span-2' : '' ?>">
                    <div class="flex items-start justify-between mb-7">
                        <span class="w-14 h-14 rounded-2xl flex items-center justify-center" style="background: <?= e($svc['bg']) ?>; color: <?= e($svc['fg']) ?>; border: 1px solid <?= e($svc['bd']) ?>;">
                            <?= icon($svc['icon'], 'w-6 h-6') ?>
                        </span>
                        <div class="text-right">
                            <span class="block text-[11px] font-mono mb-1.5" style="color: var(--ink-muted);">[<?= e($svc['num']) ?>]</span>
                            <span class="pill"><?= e($svc['tag']) ?></span>
                            <?php if (!empty($svc['is_new'])): ?>
                                <span class="inline-block mt-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-[0.12em]" style="background: <?= e($svc['fg']) ?>; color: #fff;">Nuevo</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <h3 class="font-medium text-[clamp(1.4rem,2.6vw,2rem)] tracking-tight leading-tight mb-4 text-balance" style="color: var(--ink);">
                        <?= e($svc['title']) ?> <em class="text-italic-serif" style="color: <?= e($svc['fg']) ?>;"><?= e($svc['italic']) ?></em>
                    </h3>
                    <p class="text-[14.5px] leading-relaxed mb-6 max-w-md" style="color: var(--ink-muted);"><?= e($svc['desc']) ?></p>

                    <ul class="space-y-2.5 mb-7">
                        <?php foreach ($svc['bullets'] as $b): ?>
                            <li class="flex items-start gap-3 text-[14px]" style="color: var(--ink-soft);">
                                <span class="w-5 h-5 mt-0.5 rounded-full flex items-center justify-center flex-shrink-0" style="background: <?= e($svc['bg']) ?>; color: <?= e($svc['fg']) ?>;">
                                    <?= icon('check', 'w-3 h-3') ?>
                                </span>
                                <?= e($b) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <div class="flex items-center justify-between pt-5 border-t border-[rgba(17,17,17,0.06)]">
                        <span class="text-[14px] font-medium" style="color: var(--ink);">Ver detalle</span>
                        <span class="w-10 h-10 rounded-full flex items-center justify-center transition-all group-hover:translate-x-1" style="background: <?= e($svc['fg']) ?>; color: #fff;">
                            <?= icon('arrow-right', 'w-4 h-4') ?>
                        </span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════════
     CTA
     ════════════════════════════════════════════════════════════ -->
<section class="bg-white pb-20 sm:pb-28">
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <div class="relative rounded-3xl overflow-hidden p-10 sm:p-14 lg:p-20 bg-[#EFEFEF]">
            <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
                <div class="hero-canvas__chroma"></div>
                <div class="hero-canvas__grain"></div>
            </div>
            <div class="relative z-10 max-w-2xl">
                <div class="section-badge mb-6">
                    <span class="section-badge__num">!</span>
                    <span class="section-badge__label">Discovery gratuito</span>
                </div>
                <h2 class="font-medium leading-[1.05] tracking-[-0.03em] text-balance mb-6"
                    style="color: var(--ink); font-size: clamp(1.75rem, 5vw, 3.75rem);">
                    ¿No sabes por dónde <em class="text-italic-serif">empezar</em>?
                </h2>
                <p class="text-[15px] sm:text-[17px] leading-[1.6] max-w-xl mb-8" style="color: var(--ink-soft);">
                    Te ayudamos a diagnosticar qué necesita realmente tu empresa. Consulta gratuita de 30 minutos.
                </p>
                <a href="<?= url('/contact') ?>" class="btn-orange group inline-flex">
                    <span class="text-roll">
                        <span class="text-roll__inner">
                            <span>Agendar consulta gratuita</span>
                            <span>Agendar consulta gratuita</span>
                        </span>
                    </span>
                    <span class="arrow-circle arrow-circle--lg arrow-circle__orange">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-5-5l5 5-5 5"/></svg>
                    </span>
                </a>
            </div>
        </div>
    </div>
</section>
