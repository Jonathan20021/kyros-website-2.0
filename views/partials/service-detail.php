<?php require_once base_path('views/partials/icons.php'); ?>

<!-- HERO -->
<section class="relative pt-20 lg:pt-32 pb-28 overflow-hidden" data-hero>
    <div class="absolute inset-0 grid-mask"></div>
    <div class="mesh-bg" style="opacity:0.6"></div>

    <!-- Liquid orbs -->
    <div class="liquid-orb liquid-orb--indigo" style="width: 620px; height: 620px; top: -220px; left: -160px;"></div>
    <div class="liquid-orb liquid-orb--cyan"   style="width: 380px; height: 380px; top: 18%; right: -60px;"></div>
    <div class="liquid-orb liquid-orb--violet" style="width: 300px; height: 300px; bottom: -100px; left: 35%; opacity: 0.4;"></div>

    <div class="absolute top-0 left-[15%] beam"></div>
    <div class="absolute top-24 right-[20%] beam" style="animation-delay: 1.2s;"></div>

    <div class="container relative z-10">
        <a href="<?= url('/services') ?>" class="inline-flex items-center gap-2 text-[13px] text-chalk/55 hover:text-chalk transition mb-12 font-mono link-anim">
            ← Volver a servicios
        </a>

        <div class="grid lg:grid-cols-12 gap-12 items-end">
            <div class="lg:col-span-8">
                <div class="glow-tag mb-7 reveal"><?= e($service['eyebrow']) ?></div>
                <h1 class="font-display font-normal tracking-tightest leading-[0.95] text-balance
                           text-[clamp(2.25rem,5.5vw,5rem)] reveal">
                    <?= $service['title'] ?>
                </h1>
                <p class="text-chalk/65 text-[17px] leading-relaxed max-w-2xl mt-8 reveal" style="transition-delay:160ms"><?= e($service['intro']) ?></p>

                <div class="flex flex-wrap items-center gap-3 mt-10 reveal" style="transition-delay:240ms">
                    <a href="<?= url('/contact') ?>" class="btn-ember sheen magnetic">
                        Solicitar propuesta
                        <svg class="w-4 h-4 arrow-ic" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-5-5l5 5-5 5"/></svg>
                    </a>
                    <a href="#features" class="btn-outline sheen">Ver lo incluido</a>
                </div>
            </div>

            <div class="lg:col-span-4 reveal tilt" style="transition-delay:200ms">
                <div class="tilt-target conic-border overflow-hidden relative spotlight" style="padding: 1.75rem;">
                    <div class="absolute -top-12 -right-12 w-56 h-56 rounded-full" style="background: radial-gradient(circle, rgba(91,94,255,0.50), transparent 65%); filter: blur(60px);"></div>
                    <div class="relative p-2 tilt-up">
                        <div class="icon-chip icon-chip-lg mb-7"><?= icon($service['icon'], 'w-7 h-7') ?></div>
                        <h3 class="font-display text-[18px] font-normal tracking-tight mb-1.5">Métricas de impacto</h3>
                        <p class="text-chalk/45 text-[12px] mb-6 font-mono">Promedio últimos 24 meses</p>

                        <div class="grid grid-cols-2 gap-3">
                            <?php foreach ($service['hero_metrics'] as $m): ?>
                                <div class="liquid-glass p-4" style="border-radius: 16px;">
                                    <div class="big-num text-[clamp(1.5rem,3vw,2.25rem)] text-grad-indigo mb-2"><?= e($m[0]) ?></div>
                                    <div class="font-mono text-[9.5px] tracking-[0.18em] uppercase text-chalk-quiet leading-snug"><?= e($m[1]) ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section id="features" class="section border-t border-white/5">
    <div class="container">
        <div class="grid lg:grid-cols-12 gap-10 mb-16 items-end">
            <div class="lg:col-span-7">
                <span class="eyebrow reveal"><span class="eyebrow-num">[01]</span>Lo que entregamos</span>
                <h2 class="font-display font-normal tracking-tightest text-[clamp(2rem,5vw,4rem)] leading-[0.93] mt-7 reveal text-balance">
                    Servicios <span class="text-italic-serif text-grad-indigo">incluidos</span>.
                </h2>
            </div>
            <div class="lg:col-span-4 lg:col-start-9 reveal">
                <p class="text-chalk/55 text-[15px] leading-relaxed">
                    Todo lo que necesitas para que tu proyecto funcione, sin manos pasando la pelota a terceros.
                </p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            <?php foreach ($service['features'] as $i => $f): ?>
                <div class="tilt reveal" style="transition-delay: <?= $i*60 ?>ms;">
                    <div class="tilt-target card spotlight">
                        <div class="icon-chip mb-6 tilt-up"><?= icon($f['icon'], 'w-5 h-5') ?></div>
                        <span class="font-mono text-[10px] tracking-[0.2em] text-chalk-quiet mb-2 block">0<?= $i+1 ?></span>
                        <h3 class="font-display text-[18px] font-normal tracking-tight mb-2"><?= e($f['title']) ?></h3>
                        <p class="text-chalk/55 text-[13.5px] leading-relaxed"><?= e($f['desc']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- DELIVERABLES -->
<?php if (!empty($service['deliverables'])): ?>
<section class="section-tight">
    <div class="container">
        <div class="liquid-panel reveal overflow-hidden">
            <div class="liquid-orb liquid-orb--cyan" style="width: 460px; height: 460px; top: -160px; right: -80px;"></div>
            <div class="liquid-orb liquid-orb--indigo" style="width: 320px; height: 320px; bottom: -120px; left: -60px; opacity: 0.4;"></div>
            <div class="relative grid lg:grid-cols-12 gap-10">
                <div class="lg:col-span-5">
                    <span class="eyebrow"><span class="eyebrow-num">[02]</span>Entregables</span>
                    <h2 class="font-display font-normal tracking-tightest text-[clamp(1.75rem,3.5vw,2.75rem)] leading-tight mt-6 mb-5 text-balance">
                        Lo que recibirás <span class="text-italic-serif text-grad-indigo">al finalizar</span>.
                    </h2>
                    <p class="text-chalk/55 leading-relaxed text-[14.5px]">
                        Documentación clara, código mantenible y handoff completo. Nada queda en cabezas de personas.
                    </p>
                </div>
                <ul class="lg:col-span-7 grid sm:grid-cols-2 gap-3">
                    <?php foreach ($service['deliverables'] as $i => $d): ?>
                        <li class="liquid-glass flex items-start gap-3 text-chalk/80 text-[14.5px] reveal p-4"
                            style="transition-delay: <?= $i*40 ?>ms; border-radius: 16px;">
                            <span class="w-6 h-6 mt-0.5 rounded-full flex items-center justify-center text-indigo-300 flex-shrink-0"
                                  style="background: rgba(91,94,255,0.15); border: 1px solid rgba(91,94,255,0.3);">
                                <?= icon('check', 'w-3.5 h-3.5') ?>
                            </span>
                            <span><?= e($d) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- PROCESS -->
<?php if (!empty($service['process'])): ?>
<section class="section border-t border-white/5">
    <div class="container">
        <div class="grid lg:grid-cols-12 gap-10 mb-16 items-end">
            <div class="lg:col-span-7">
                <span class="eyebrow reveal"><span class="eyebrow-num">[03]</span>Cómo trabajamos</span>
                <h2 class="font-display font-normal tracking-tightest text-[clamp(2rem,5vw,4rem)] leading-[0.93] mt-7 reveal text-balance">
                    Un proceso <span class="text-italic-serif text-grad-indigo">probado</span>.
                </h2>
            </div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-5">
            <?php foreach ($service['process'] as $i => $p): ?>
                <div class="tilt reveal" style="transition-delay: <?= $i*80 ?>ms;">
                    <div class="tilt-target card spotlight relative" style="min-height: 240px;">
                        <span class="big-num absolute top-6 right-7 text-grad-cream opacity-15 text-6xl tilt-up"><?= e($p['num']) ?></span>
                        <div class="relative">
                            <span class="font-mono text-[10px] tracking-[0.22em] text-indigo-300 block mb-2">FASE <?= e($p['num']) ?></span>
                            <h3 class="font-display text-[18px] font-normal tracking-tight mb-3"><?= e($p['title']) ?></h3>
                            <p class="text-chalk/55 text-[13.5px] leading-relaxed"><?= e($p['desc']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- FAQ -->
<?php if (!empty($service['faqs'])): ?>
<section class="section border-t border-white/5">
    <div class="container">
        <div class="grid lg:grid-cols-12 gap-14">
            <div class="lg:col-span-4">
                <span class="eyebrow reveal"><span class="eyebrow-num">[04]</span>FAQ</span>
                <h2 class="font-display font-normal tracking-tightest text-[clamp(1.75rem,3.5vw,2.75rem)] leading-tight mt-7 mb-5 reveal text-balance">
                    Resolvamos tus <span class="text-italic-serif text-grad-indigo">dudas</span>.
                </h2>
                <p class="text-chalk/55 text-[14.5px] leading-relaxed reveal">
                    ¿No encuentras tu pregunta? Contáctanos y te respondemos en menos de 24 horas.
                </p>
            </div>
            <div class="lg:col-span-8 space-y-2">
                <?php foreach ($service['faqs'] as $i => [$q, $a]): ?>
                    <div data-faq class="liquid-glass reveal" style="transition-delay: <?= $i*40 ?>ms; border-radius: 20px;">
                        <button data-faq-btn class="w-full flex items-center justify-between gap-4 p-5 md:p-6 text-left transition-colors">
                            <span class="font-display font-normal text-chalk tracking-tight text-[16px] pr-4"><?= e($q) ?></span>
                            <span data-faq-icon class="w-8 h-8 rounded-full liquid-glass-light flex items-center justify-center text-chalk/70 flex-shrink-0 transition-transform" style="border: 1px solid rgba(255,255,255,0.12);">
                                <?= icon('chevron-down', 'w-4 h-4') ?>
                            </span>
                        </button>
                        <div data-faq-body class="overflow-hidden transition-[max-height] duration-300" style="max-height:0">
                            <p class="px-5 md:px-6 pb-6 text-chalk/65 leading-relaxed text-[14px]"><?= e($a) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- RELATED + CTA -->
<section class="section-tight">
    <div class="container">
        <div class="grid lg:grid-cols-3 gap-5">
            <div class="liquid-panel lg:col-span-2 reveal overflow-hidden" style="padding: clamp(1.5rem, 3.5vw, 3rem);">
                <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse 80% 100% at 50% 0%, rgba(91,94,255,0.40), transparent 60%);"></div>
                <div class="liquid-orb liquid-orb--indigo" style="width: 380px; height: 380px; top: -120px; right: -60px;"></div>
                <div class="liquid-orb liquid-orb--violet" style="width: 280px; height: 280px; bottom: -100px; left: 30%; opacity: 0.4;"></div>
                <div class="relative">
                    <div class="eyebrow mb-7">Empezar</div>
                    <h2 class="font-display font-normal tracking-tightest text-[clamp(1.75rem,3.5vw,2.75rem)] leading-[0.95] text-balance">
                        ¿Listo para empezar con<br>
                        <span class="text-italic-serif text-grad-indigo"><?= e($service['eyebrow']) ?></span>?
                    </h2>
                    <p class="text-chalk/55 mt-6 mb-8 max-w-lg text-[15px] leading-relaxed">
                        Una llamada de 30 minutos. Sin compromiso. Te entregamos una propuesta concreta en 48 horas.
                    </p>
                    <a href="<?= url('/contact') ?>" class="btn-ember magnetic">
                        Solicitar propuesta
                        <svg class="w-4 h-4 arrow-ic" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-5-5l5 5-5 5"/></svg>
                    </a>
                </div>
            </div>

            <div class="card spotlight">
                <p class="font-mono text-[10px] tracking-[0.22em] uppercase text-chalk-quiet mb-5">Otros servicios</p>
                <div class="space-y-2">
                    <?php foreach ($service['related'] as $r): ?>
                        <a href="<?= url('/services/' . $r['slug']) ?>"
                           class="liquid-glass flex items-center gap-3 p-3 transition-all group"
                           style="border-radius: 16px;">
                            <div class="icon-chip" style="width:36px;height:36px;border-radius:10px;">
                                <?= icon($r['icon'], 'w-4 h-4') ?>
                            </div>
                            <span class="font-medium text-chalk text-[13.5px] flex-grow tracking-tight"><?= e($r['title']) ?></span>
                            <?= icon('arrow-right', 'w-4 h-4 text-chalk/40 group-hover:text-chalk group-hover:translate-x-1 transition-all') ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
