<?php require_once base_path('views/partials/icons.php'); ?>

<!-- HERO -->
<section class="relative pt-20 lg:pt-32 pb-24 overflow-hidden" data-hero>
    <div class="absolute inset-0 grid-mask"></div>
    <div class="mesh-bg" style="opacity:0.55"></div>

    <!-- Liquid orbs -->
    <div class="liquid-orb liquid-orb--indigo" style="width: 600px; height: 600px; top: -220px; left: -140px;"></div>
    <div class="liquid-orb liquid-orb--cyan"   style="width: 400px; height: 400px; top: 20%; right: -80px;"></div>
    <div class="liquid-orb liquid-orb--violet" style="width: 300px; height: 300px; bottom: -100px; left: 40%; opacity: 0.4;"></div>

    <div class="absolute top-0 left-[15%] beam"></div>
    <div class="absolute top-24 right-[20%] beam" style="animation-delay: 1.5s;"></div>

    <div class="container relative z-10">
        <div class="flex items-center justify-between gap-4 mb-14 reveal">
            <div class="glow-tag"><span class="text-chalk">Sobre nosotros</span></div>
            <div class="hidden md:flex items-center gap-3 text-[12px] text-chalk-quiet font-mono">
                <span>Fundada en 2016</span>
                <span class="w-1 h-1 rounded-full bg-chalk-quiet/50"></span>
                <span>Santo Domingo · RD</span>
            </div>
        </div>

        <div class="grid lg:grid-cols-12 gap-12 items-end">
            <div class="lg:col-span-9">
                <h1 class="font-display font-normal tracking-tightest leading-[0.95] text-balance
                           text-[clamp(2.5rem,6.5vw,5.5rem)] reveal">
                    <span class="block text-grad-cream">Tecnología que</span>
                    <span class="block text-grad-cream"><span class="text-italic-serif text-grad-indigo">transforma</span> empresas.</span>
                </h1>
            </div>
            <div class="lg:col-span-3 reveal" style="transition-delay:180ms">
                <p class="text-chalk/65 text-[16px] leading-relaxed">
                    Somos un equipo de ingenieros, diseñadores y especialistas de seguridad construyendo el futuro digital de Latinoamérica desde República Dominicana.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- MISSION & VISION -->
<section class="section-tight">
    <div class="container">
        <div class="grid lg:grid-cols-12 gap-5">
            <div class="lg:col-span-7 reveal tilt" style="min-height: 360px;">
                <div class="tilt-target conic-border h-full overflow-hidden spotlight" style="padding: 1.75rem;">
                    <div class="absolute top-0 right-0 w-72 h-72 rounded-full" style="background: radial-gradient(circle, rgba(91,94,255,0.32), transparent 65%); filter: blur(70px);"></div>
                    <div class="relative h-full flex flex-col p-2 tilt-up">
                        <div class="flex items-center gap-3 mb-7">
                            <div class="icon-chip"><?= icon('target', 'w-6 h-6') ?></div>
                            <span class="pill">Misión</span>
                        </div>
                        <h2 class="font-display text-[clamp(1.75rem,3.2vw,2.75rem)] tracking-tightest font-normal leading-[0.95] mb-6 text-balance">
                            Hacer accesible <span class="text-italic-serif text-grad-indigo">nivel Silicon Valley</span> en LATAM.
                        </h2>
                        <p class="text-chalk/60 leading-relaxed text-[15px] max-w-lg mt-auto">
                            Empoderar a empresas latinoamericanas con tecnología de vanguardia, transformando desafíos en oportunidades de crecimiento sostenible.
                        </p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 tilt reveal" style="transition-delay:120ms; min-height: 360px;">
                <div class="tilt-target card spotlight h-full">
                    <div class="absolute top-0 right-0 w-60 h-60 rounded-full" style="background: radial-gradient(circle, rgba(34,211,238,0.22), transparent 65%); filter: blur(60px);"></div>
                    <div class="relative h-full flex flex-col">
                        <div class="flex items-center gap-3 mb-7 tilt-up">
                            <div class="icon-chip icon-chip-cyan"><?= icon('trending', 'w-6 h-6') ?></div>
                            <span class="pill">Visión</span>
                        </div>
                        <h2 class="font-display text-[clamp(1.5rem,2.5vw,2rem)] tracking-tightest font-normal leading-tight mb-5 text-balance">
                            Ser la <span class="text-italic-serif">primera llamada</span> de toda empresa con tecnología que importa.
                        </h2>
                        <p class="text-chalk/60 leading-relaxed text-[14px] mt-auto">
                            El socio tecnológico de referencia en Latinoamérica.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- VALUES -->
<section class="section border-t border-white/5">
    <div class="container">
        <div class="grid lg:grid-cols-12 gap-10 mb-16 items-end">
            <div class="lg:col-span-7">
                <span class="eyebrow reveal"><span class="eyebrow-num">[01]</span>Valores</span>
                <h2 class="font-display font-normal tracking-tightest text-[clamp(2.25rem,5vw,4.25rem)] leading-[0.93] mt-7 reveal text-balance">
                    Los principios que <span class="text-italic-serif text-grad-indigo">nos guían</span>.
                </h2>
            </div>
            <div class="lg:col-span-4 lg:col-start-9 reveal">
                <p class="text-chalk/55 text-[15px] leading-relaxed">
                    Cuatro principios operativos que vivimos en cada decisión, cada commit y cada cliente.
                </p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-5">
            <?php
            $values = [
                ['target',    '',                'Excelencia',   'Comprometidos con calidad superior en cada proyecto, sin atajos. Lo que sale lleva nuestro nombre.'],
                ['lightbulb', 'icon-chip-cyan',   'Innovación',   'Adoptamos las últimas tecnologías cuando aportan valor real. Nunca por moda.'],
                ['shield',    'icon-chip-violet', 'Seguridad',    'Protección y privacidad como prioridad fundamental desde el primer commit.'],
                ['users',     'icon-chip-mono',   'Colaboración', 'Trabajamos junto a nuestros clientes como verdaderos socios, no como proveedores.'],
            ];
            foreach ($values as $i => [$ico, $chipClass, $title, $desc]):
            ?>
                <div class="tilt reveal" style="transition-delay: <?= $i*70 ?>ms;">
                    <div class="tilt-target card spotlight flex flex-col" style="min-height: 280px;">
                        <div class="icon-chip <?= $chipClass ?> mb-7 tilt-up"><?= icon($ico, 'w-6 h-6') ?></div>
                        <span class="font-mono text-[10px] tracking-[0.2em] text-chalk-quiet mb-2">0<?= $i+1 ?></span>
                        <h3 class="font-display text-[20px] font-normal tracking-tighter mb-2"><?= e($title) ?></h3>
                        <p class="text-chalk/55 text-[13.5px] leading-relaxed"><?= e($desc) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- TEAM -->
<section class="section">
    <div class="container">
        <div class="grid lg:grid-cols-12 gap-10 mb-16 items-end">
            <div class="lg:col-span-8">
                <span class="eyebrow reveal"><span class="eyebrow-num">[02]</span>Equipo</span>
                <h2 class="font-display font-normal tracking-tightest text-[clamp(2.25rem,5vw,4.25rem)] leading-[0.93] mt-7 reveal text-balance">
                    Las personas <span class="text-italic-serif text-grad-indigo">detrás</span> de KYROS.
                </h2>
            </div>
            <div class="lg:col-span-4 reveal">
                <p class="text-chalk/55 text-[15px] leading-relaxed">
                    Especialistas con +10 años de experiencia promedio, organizados para entregar valor desde la semana uno.
                </p>
            </div>
        </div>

        <!-- Founder spotlight -->
        <div class="reveal mb-5 tilt" style="min-height: 400px;">
            <div class="tilt-target conic-border overflow-hidden spotlight" style="padding: 2rem;">
                <div class="absolute top-0 right-0 w-[28rem] h-[28rem] rounded-full" style="background: radial-gradient(circle, rgba(91,94,255,0.30), transparent 65%); filter: blur(80px);"></div>
                <div class="relative grid md:grid-cols-12 gap-10 items-center p-2 tilt-up">
                    <div class="md:col-span-4">
                        <div class="aspect-square max-w-[280px] rounded-3xl p-[2px] mx-auto md:mx-0"
                             style="background: conic-gradient(from 180deg at 50% 50%, var(--indigo), var(--cyan), var(--violet), var(--indigo));">
                            <div class="w-full h-full rounded-[22px] flex items-center justify-center text-7xl font-display font-normal text-chalk tracking-tightest"
                                 style="background: linear-gradient(180deg, #12121A, #050508);">
                                JS
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-8">
                        <span class="font-mono text-[10px] tracking-[0.3em] uppercase text-indigo-300 font-medium">Fundador & CEO</span>
                        <h3 class="font-display text-[clamp(1.75rem,3vw,2.5rem)] tracking-tightest font-normal mt-3 mb-2 text-balance">
                            Jonathan <span class="text-italic-serif text-chalk/65">Sandoval</span> Ferreira
                        </h3>
                        <p class="text-chalk/45 mb-5 text-[13px] font-mono">Software Architect · 8+ años</p>
                        <p class="text-chalk/70 leading-relaxed text-[15.5px] max-w-2xl">
                            Profesional en desarrollo de software, ciberseguridad e inteligencia artificial con más de 8 años de experiencia en el mercado latinoamericano e internacional. Lidera la visión técnica y estratégica de KYROS Solutions.
                        </p>
                        <div class="hairline my-6"></div>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach (['Software architecture','Cybersecurity','AI/ML','Engineering leadership'] as $t): ?>
                                <span class="pill"><?= e($t) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-5">
            <?php
            $team = [
                ['AR', 'Ana Rodríguez',  'CTO',                  '12+ años', 'Lidera arquitectura técnica y estándares de ingeniería.', ''],
                ['MT', 'Miguel Torres',  'Head of Security',     '10+ años', 'Pentesting, SOC y respuesta ante incidentes.', 'avatar-sky'],
                ['LS', 'Laura Sánchez',  'Lead Developer',       '8+ años',  'Frontend, fullstack y diseño de sistemas escalables.', 'avatar-amber'],
            ];
            foreach ($team as $i => [$initials, $name, $role, $exp, $bio, $avatarCls]):
            ?>
                <div class="tilt reveal" style="transition-delay: <?= $i*80 ?>ms;">
                    <div class="tilt-target card spotlight">
                        <div class="flex items-center gap-4 mb-5 tilt-up">
                            <div class="avatar <?= e($avatarCls) ?> w-14 h-14 text-base tracking-tight"><?= e($initials) ?></div>
                            <div>
                                <h3 class="font-display text-[17px] font-normal tracking-tight"><?= e($name) ?></h3>
                                <p class="text-chalk/45 text-[12px]"><?= e($role) ?> · <?= e($exp) ?></p>
                            </div>
                        </div>
                        <p class="text-chalk/55 text-[13.5px] leading-relaxed"><?= e($bio) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- STATS -->
<section class="section-tight border-t border-white/5 relative overflow-hidden">
    <div class="absolute inset-0 dotted-mask opacity-50"></div>
    <div class="container relative z-10">
        <div class="liquid-glass grid grid-cols-2 md:grid-cols-4 gap-0" style="border-radius: 28px;">
            <?php
            $stats = [['10','+','AÑOS','Experiencia'], ['80','+','CLIENTES','Satisfechos'], ['120','+','PROYECTOS','Completados'], ['99','%','TASA','De éxito']];
            foreach ($stats as $i => [$v, $suffix, $kpi, $desc]):
            ?>
                <div class="p-6 sm:p-8 md:p-10 reveal <?= ($i % 2 === 1) ? 'border-l border-white/5' : '' ?> <?= $i >= 2 ? 'border-t border-white/5 md:border-t-0 md:border-l' : '' ?>"
                     style="transition-delay: <?= $i*70 ?>ms;">
                    <div class="big-num stat-shine text-[clamp(3rem,6vw,5.5rem)] mb-3">
                        <span data-counter="<?= e($v) ?>" data-suffix="<?= e($suffix) ?>">0<?= e($suffix) ?></span>
                    </div>
                    <div class="font-mono text-[10px] tracking-[0.24em] uppercase text-chalk-quiet mb-1"><?= e($kpi) ?></div>
                    <div class="text-[13px] text-chalk/55"><?= e($desc) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="section-tight">
    <div class="container">
        <div class="liquid-panel reveal overflow-hidden" style="padding: clamp(1.5rem, 3.5vw, 3rem);">
            <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse 80% 100% at 50% 0%, rgba(91,94,255,0.40), transparent 60%);"></div>
            <div class="liquid-orb liquid-orb--indigo" style="width: 440px; height: 440px; top: -140px; right: -80px;"></div>
            <div class="liquid-orb liquid-orb--cyan" style="width: 320px; height: 320px; bottom: -120px; left: 20%; opacity: 0.4;"></div>
            <div class="relative max-w-2xl">
                <div class="eyebrow mb-7">Discovery gratuito</div>
                <h2 class="font-display font-normal tracking-tightest text-[clamp(2.25rem,5vw,4.25rem)] leading-[0.93] text-balance">
                    ¿Hablamos<span class="text-italic-serif text-grad-indigo">?</span>
                </h2>
                <p class="text-chalk/60 text-[16px] mt-6 leading-relaxed">
                    Cuéntanos lo que necesitas. Te respondemos en menos de 24 horas con una propuesta concreta.
                </p>
                <div class="flex flex-wrap gap-3 mt-8">
                    <a href="<?= url('/contact') ?>" class="btn-ember sheen magnetic">
                        Iniciar conversación
                        <svg class="w-4 h-4 arrow-ic" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-5-5l5 5-5 5"/></svg>
                    </a>
                    <a href="<?= url('/services') ?>" class="btn-outline">Ver servicios</a>
                </div>
            </div>
        </div>
    </div>
</section>
