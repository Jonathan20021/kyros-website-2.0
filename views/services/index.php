<?php require_once base_path('views/partials/icons.php'); ?>

<!-- HERO -->
<section class="relative pt-20 lg:pt-32 pb-24 overflow-hidden">
    <div class="absolute inset-0 grid-mask"></div>
    <div class="mesh-bg" style="opacity:0.55"></div>

    <!-- Liquid orbs -->
    <div class="liquid-orb liquid-orb--indigo" style="width: 580px; height: 580px; top: -200px; left: -120px;"></div>
    <div class="liquid-orb liquid-orb--cyan"   style="width: 400px; height: 400px; top: 15%; right: -80px;"></div>
    <div class="liquid-orb liquid-orb--violet" style="width: 320px; height: 320px; bottom: -120px; left: 40%; opacity: 0.4;"></div>

    <div class="absolute top-0 left-[15%] beam"></div>
    <div class="absolute top-24 right-[20%] beam" style="animation-delay: 1.5s;"></div>

    <div class="container relative z-10">
        <div class="flex items-center justify-between gap-4 mb-14 reveal">
            <div class="glow-tag"><span class="text-chalk">Servicios</span></div>
            <div class="hidden md:flex items-center gap-3 text-[12px] text-chalk-quiet font-mono">
                <span>4 disciplinas · 1 equipo</span>
            </div>
        </div>

        <div class="grid lg:grid-cols-12 gap-12 items-end">
            <div class="lg:col-span-9">
                <h1 class="font-display font-normal tracking-tightest leading-[0.88] text-balance
                           text-[clamp(2.75rem,7.5vw,7rem)] reveal">
                    <span class="block text-grad-cream">
                        Una plataforma <span class="text-italic-serif text-grad-indigo">end-to-end</span>
                    </span>
                    <span class="text-grad-cream block">para tu tecnología.</span>
                </h1>
            </div>
            <div class="lg:col-span-3 reveal" style="transition-delay:180ms">
                <p class="text-chalk/65 text-[16px] leading-relaxed">
                    Software, ciberseguridad, soporte y redes. Cuatro disciplinas, un solo equipo, una sola responsabilidad: que tu tecnología funcione.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- SERVICES GRID with 3D tilt -->
<section class="pb-28">
    <div class="container">
        <div class="grid lg:grid-cols-2 gap-5">
            <?php
            $services = [
                [
                    'slug' => 'software-development', 'num' => '01', 'icon' => 'code', 'chip' => '',
                    'title'=> 'Desarrollo de Software', 'italic'=> 'a medida',
                    'tag'  => 'Web · SaaS · ERP',
                    'desc' => 'Construimos aplicaciones a medida con tecnologías modernas: desde landings y portales hasta plataformas SaaS multi-tenant y sistemas empresariales completos.',
                    'bullets' => ['Aplicaciones web y dashboards', 'Plataformas SaaS multi-tenant', 'APIs e integraciones (ERP/CRM)', 'Modernización de sistemas legacy'],
                    'featured' => true,
                ],
                [
                    'slug' => 'cybersecurity', 'num' => '02', 'icon' => 'shield', 'chip' => 'icon-chip-cyan',
                    'title'=> 'Ciberseguridad', 'italic'=> 'avanzada',
                    'tag'  => 'Defensa · Pentest · SOC',
                    'desc' => 'Auditorías técnicas, ethical hacking, hardening de servidores y monitoreo continuo. Protegemos tu operación antes de que ocurra el incidente.',
                    'bullets' => ['Pentesting y auditorías', 'Hardening de servidores y nube', 'Respuesta ante incidentes', 'Capacitación a equipos'],
                    'featured' => false,
                ],
                [
                    'slug' => 'technical-support', 'num' => '03', 'icon' => 'headset', 'chip' => 'icon-chip-violet',
                    'title'=> 'Soporte Técnico', 'italic'=> 'helpdesk 24/7',
                    'tag'  => '24/7 · Remoto · On-site',
                    'desc' => 'Mesa de ayuda profesional con SLA garantizado. Resolvemos en minutos, no en días. Soporte remoto y presencial para tu equipo y tus clientes.',
                    'bullets' => ['Helpdesk multinivel (L1, L2, L3)', 'Soporte remoto y on-site', 'Gestión de inventario y activos', 'KyDesk: nuestra plataforma propia'],
                    'featured' => false,
                ],
                [
                    'slug' => 'network-infrastructure', 'num' => '04', 'icon' => 'wifi', 'chip' => 'icon-chip-mono',
                    'title'=> 'Infraestructura de Redes', 'italic'=> 'empresarial',
                    'tag'  => 'LAN · WAN · WiFi · Cloud',
                    'desc' => 'Diseñamos, instalamos y administramos redes empresariales: cableado estructurado, WiFi de alta densidad, firewalls, VPN y enlaces dedicados.',
                    'bullets' => ['Cableado estructurado certificado', 'WiFi 6 de alta densidad', 'Firewalls y segmentación', 'Enlaces dedicados y VPN'],
                    'featured' => false,
                ],
            ];
            foreach ($services as $i => $svc):
                $wrapClass = $svc['featured'] ? 'conic-border' : 'card';
            ?>
                <a href="<?= url('/services/' . $svc['slug']) ?>" class="reveal group tilt" style="transition-delay: <?= $i*80 ?>ms; min-height: 540px;">
                    <div class="tilt-target <?= $wrapClass ?> spotlight h-full overflow-hidden flex flex-col"
                         <?= $svc['featured'] ? 'style="padding: 1.75rem;"' : '' ?>>
                        <div class="absolute top-0 right-0 w-72 h-72 rounded-full pointer-events-none" style="background: radial-gradient(circle, rgba(91,94,255,0.20), transparent 65%); filter: blur(70px);"></div>

                        <div class="relative flex flex-col h-full <?= $svc['featured'] ? 'p-2' : '' ?>">
                            <div class="flex items-start justify-between mb-8 tilt-up">
                                <div class="icon-chip icon-chip-lg <?= $svc['chip'] ?>"><?= icon($svc['icon'], 'w-7 h-7') ?></div>
                                <div class="text-right">
                                    <span class="font-mono text-[10.5px] tracking-tight text-chalk-quiet block mb-1.5">[<?= e($svc['num']) ?>]</span>
                                    <span class="pill"><?= e($svc['tag']) ?></span>
                                </div>
                            </div>

                            <h3 class="font-display text-[clamp(1.75rem,3vw,2.75rem)] tracking-tightest font-normal leading-[0.95] mb-5 text-balance">
                                <?= e($svc['title']) ?> <span class="text-italic-serif text-grad-indigo"><?= e($svc['italic']) ?></span>
                            </h3>
                            <p class="text-chalk/60 leading-relaxed mb-7 text-[15px] max-w-md"><?= e($svc['desc']) ?></p>

                            <ul class="space-y-3 mb-8 flex-grow">
                                <?php foreach ($svc['bullets'] as $b): ?>
                                    <li class="flex items-start gap-3 text-[14px] text-chalk/75">
                                        <span class="w-5 h-5 mt-0.5 rounded-full flex items-center justify-center text-indigo-300 flex-shrink-0"
                                              style="background: rgba(91,94,255,0.15); border: 1px solid rgba(91,94,255,0.3);">
                                            <?= icon('check', 'w-3 h-3') ?>
                                        </span>
                                        <?= e($b) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                            <div class="flex items-center gap-3 font-medium text-chalk text-[14px] mt-auto">
                                <span class="link-anim">Ver detalle del servicio</span>
                                <span class="w-9 h-9 rounded-full bg-chalk/10 flex items-center justify-center group-hover:bg-indigo-500 group-hover:translate-x-1 transition-all">
                                    <?= icon('arrow-right', 'w-3.5 h-3.5') ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="section-tight">
    <div class="container">
        <div class="liquid-panel reveal overflow-hidden" style="padding: clamp(1.5rem, 3.5vw, 3rem);">
            <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse 80% 100% at 50% 0%, rgba(91,94,255,0.40), transparent 60%);"></div>
            <div class="liquid-orb liquid-orb--indigo" style="width: 460px; height: 460px; top: -160px; right: -80px;"></div>
            <div class="liquid-orb liquid-orb--violet" style="width: 320px; height: 320px; bottom: -120px; left: 20%; opacity: 0.4;"></div>
            <div class="relative max-w-2xl">
                <div class="eyebrow mb-7">Discovery gratuito</div>
                <h2 class="font-display font-normal tracking-tightest text-[clamp(2.25rem,5vw,4.25rem)] leading-[0.93] text-balance">
                    ¿No sabes por dónde <span class="text-italic-serif text-grad-indigo">empezar</span>?
                </h2>
                <p class="text-chalk/60 text-[16px] mt-6 leading-relaxed">
                    Te ayudamos a diagnosticar qué necesita realmente tu empresa. Consulta gratuita de 30 minutos.
                </p>
                <a href="<?= url('/contact') ?>" class="btn-ember sheen magnetic mt-8">
                    Agendar consulta gratuita
                    <svg class="w-4 h-4 arrow-ic" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-5-5l5 5-5 5"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>
