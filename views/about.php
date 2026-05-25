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
                <span class="section-badge__num">A</span>
                <span class="section-badge__label">Nosotros</span>
            </div>
            <div class="text-[12px] font-mono flex items-center gap-3" style="color: var(--ink-muted);">
                <span>Fundada 2016</span>
                <span class="w-1 h-1 rounded-full" style="background: var(--ink-muted);"></span>
                <span>Santo Domingo · RD</span>
            </div>
        </div>

        <div class="grid lg:grid-cols-12 gap-10 items-end">
            <div class="lg:col-span-9">
                <h1 class="font-medium leading-[1.05] tracking-[-0.03em] text-balance"
                    style="color: var(--ink); font-size: clamp(2rem, 6vw, 4.2rem);">
                    Tecnología que<br>transforma empresas.
                </h1>
            </div>
            <div class="lg:col-span-3">
                <p class="text-[15px] sm:text-[16px] leading-[1.6]" style="color: var(--ink-soft);">
                    Equipo de ingenieros, diseñadores y especialistas de seguridad construyendo el futuro digital de Latinoamérica desde República Dominicana.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════════
     MISSION & VISION
     ════════════════════════════════════════════════════════════ -->
<section class="bg-white py-16 sm:py-20 lg:py-24">
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-12 gap-5">
            <!-- Mission -->
            <div class="lg:col-span-7 rounded-2xl p-8 md:p-10" style="background: linear-gradient(135deg, #FFF4ED 0%, #FFFFFF 60%); border: 1px solid #FED7B5;">
                <div class="flex items-center gap-3 mb-7">
                    <span class="w-11 h-11 rounded-xl flex items-center justify-center" style="background: #F26522; color: #fff;">
                        <?= icon('target', 'w-5 h-5') ?>
                    </span>
                    <span class="pill" style="background: rgba(255,255,255,0.7); border-color: rgba(242,101,34,0.20);">Misión</span>
                </div>
                <h2 class="font-medium text-[clamp(1.5rem,2.8vw,2.5rem)] tracking-tight leading-[1.05] mb-5 text-balance" style="color: var(--ink);">
                    Hacer accesible <em class="text-italic-serif" style="color: #F26522;">nivel Silicon Valley</em> en LATAM.
                </h2>
                <p class="text-[15px] leading-[1.65] max-w-xl" style="color: var(--ink-soft);">
                    Empoderar a empresas latinoamericanas con tecnología de vanguardia, transformando desafíos en oportunidades de crecimiento sostenible.
                </p>
            </div>

            <!-- Vision -->
            <div class="lg:col-span-5 rounded-2xl p-8 md:p-10 bg-white border border-[rgba(17,17,17,0.08)]">
                <div class="flex items-center gap-3 mb-7">
                    <span class="w-11 h-11 rounded-xl flex items-center justify-center" style="background: #EEF2FF; color: #4F46E5;">
                        <?= icon('trending', 'w-5 h-5') ?>
                    </span>
                    <span class="pill">Visión</span>
                </div>
                <h2 class="font-medium text-[clamp(1.3rem,2.2vw,1.9rem)] tracking-tight leading-tight mb-5 text-balance" style="color: var(--ink);">
                    Ser la <em class="text-italic-serif" style="color: #4F46E5;">primera llamada</em> de toda empresa con tecnología que importa.
                </h2>
                <p class="text-[14px] leading-[1.65]" style="color: var(--ink-muted);">
                    El socio tecnológico de referencia en Latinoamérica.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════════
     VALUES
     ════════════════════════════════════════════════════════════ -->
<section class="bg-[#F5F5F5] py-16 sm:py-20 lg:py-24 border-y border-[rgba(17,17,17,0.06)]">
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-12 gap-10 mb-12 items-end">
            <div class="lg:col-span-7">
                <div class="section-badge mb-6">
                    <span class="section-badge__num">1</span>
                    <span class="section-badge__label">Valores</span>
                </div>
                <h2 class="font-medium leading-[1.05] tracking-[-0.03em] text-balance"
                    style="color: var(--ink); font-size: clamp(1.75rem, 4vw, 3rem);">
                    Los principios que <em class="text-italic-serif">nos guían</em>.
                </h2>
            </div>
            <div class="lg:col-span-4 lg:col-start-9">
                <p class="text-[15px] leading-relaxed" style="color: var(--ink-soft);">
                    Cuatro principios operativos que vivimos en cada decisión, cada commit y cada cliente.
                </p>
            </div>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5" data-fluid-stagger>
            <?php
            $values = [
                ['target',    '#F26522', '#FFF4ED', '#FED7B5', 'Excelencia',   'Comprometidos con calidad superior en cada proyecto, sin atajos. Lo que sale lleva nuestro nombre.'],
                ['lightbulb', '#4F46E5', '#EEF2FF', '#C7D2FE', 'Innovación',   'Adoptamos las últimas tecnologías cuando aportan valor real. Nunca por moda.'],
                ['shield',    '#7C3AED', '#F5F3FF', '#DDD6FE', 'Seguridad',    'Protección y privacidad como prioridad fundamental desde el primer commit.'],
                ['users',     '#0891B2', '#ECFEFF', '#A5F3FC', 'Colaboración', 'Trabajamos junto a nuestros clientes como verdaderos socios, no como proveedores.'],
            ];
            foreach ($values as $i => [$ic, $fg, $bg, $bd, $title, $desc]):
            ?>
                <div class="rounded-2xl p-6 bg-white border border-[rgba(17,17,17,0.06)] hover:shadow-[0_8px_24px_rgba(0,0,0,0.06)] transition-all">
                    <div class="flex items-start justify-between mb-5">
                        <span class="w-11 h-11 rounded-xl flex items-center justify-center" style="background: <?= $bg ?>; color: <?= $fg ?>; border: 1px solid <?= $bd ?>;">
                            <?= icon($ic, 'w-5 h-5') ?>
                        </span>
                        <span class="text-[12px] font-mono" style="color: var(--ink-muted);">0<?= $i+1 ?></span>
                    </div>
                    <h3 class="font-medium text-[17px] tracking-tight mb-2" style="color: var(--ink);"><?= e($title) ?></h3>
                    <p class="text-[13.5px] leading-relaxed" style="color: var(--ink-muted);"><?= e($desc) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════════
     TEAM
     ════════════════════════════════════════════════════════════ -->
<section class="bg-white py-16 sm:py-20 lg:py-24">
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-12 gap-10 mb-12 items-end">
            <div class="lg:col-span-7">
                <div class="section-badge mb-6">
                    <span class="section-badge__num">2</span>
                    <span class="section-badge__label">Equipo</span>
                </div>
                <h2 class="font-medium leading-[1.05] tracking-[-0.03em] text-balance"
                    style="color: var(--ink); font-size: clamp(1.75rem, 4vw, 3rem);">
                    Las personas <em class="text-italic-serif">detrás</em> de KYROS.
                </h2>
            </div>
            <div class="lg:col-span-4 lg:col-start-9">
                <p class="text-[15px] leading-relaxed" style="color: var(--ink-soft);">
                    Especialistas con +10 años de experiencia promedio, organizados para entregar valor desde la semana uno.
                </p>
            </div>
        </div>

        <!-- Founder spotlight -->
        <div class="rounded-2xl p-8 sm:p-10 mb-5 relative overflow-hidden" style="background: linear-gradient(135deg, #EFEFEF 0%, #FFFFFF 100%); border: 1px solid rgba(17,17,17,0.08);">
            <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full" style="background: radial-gradient(circle, rgba(242,101,34,0.10), transparent 65%); filter: blur(60px);"></div>
            <div class="relative grid md:grid-cols-12 gap-8 items-center">
                <div class="md:col-span-4">
                    <div class="aspect-square max-w-[260px] rounded-2xl mx-auto md:mx-0 flex items-center justify-center text-[80px] font-medium tracking-tight text-white" style="background: linear-gradient(135deg, #F26522 0%, #C44A0F 100%); letter-spacing: -0.04em;">
                        JS
                    </div>
                </div>
                <div class="md:col-span-8">
                    <p class="text-[11px] font-mono tracking-[0.22em] uppercase font-medium mb-3" style="color: #F26522;">Fundador &amp; CEO</p>
                    <h3 class="font-medium text-[clamp(1.5rem,3vw,2.25rem)] tracking-tight mb-2" style="color: var(--ink);">
                        Jonathan <em class="text-italic-serif" style="color: var(--ink-soft);">Sandoval</em> Ferreira
                    </h3>
                    <p class="text-[13px] font-mono mb-4" style="color: var(--ink-muted);">Software Architect · 8+ años</p>
                    <p class="text-[15px] leading-relaxed max-w-2xl" style="color: var(--ink-soft);">
                        Profesional en desarrollo de software, ciberseguridad e inteligencia artificial con más de 8 años de experiencia en el mercado latinoamericano e internacional. Lidera la visión técnica y estratégica de KYROS Solutions.
                    </p>
                    <div class="hairline my-5"></div>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach (['Software architecture','Cybersecurity','AI/ML','Engineering leadership'] as $t): ?>
                            <span class="pill"><?= e($t) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Team grid -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5" data-fluid-stagger>
            <?php
            $team = [
                ['AR', 'Ana Rodríguez',  'CTO',              '12+ años', 'Lidera arquitectura técnica y estándares de ingeniería.', '#F26522'],
                ['MT', 'Miguel Torres',  'Head of Security', '10+ años', 'Pentesting, SOC y respuesta ante incidentes.',           '#4F46E5'],
                ['LS', 'Laura Sánchez',  'Lead Developer',   '8+ años',  'Frontend, fullstack y diseño de sistemas escalables.',   '#7C3AED'],
            ];
            foreach ($team as [$initials, $name, $role, $exp, $bio, $col]):
            ?>
                <div class="rounded-2xl p-6 bg-white border border-[rgba(17,17,17,0.06)] hover:shadow-[0_8px_24px_rgba(0,0,0,0.06)] transition-all">
                    <div class="flex items-center gap-4 mb-5">
                        <div class="w-14 h-14 rounded-full flex items-center justify-center text-white font-medium text-[16px] tracking-tight" style="background: <?= $col ?>;">
                            <?= e($initials) ?>
                        </div>
                        <div>
                            <h3 class="font-medium text-[16px] tracking-tight" style="color: var(--ink);"><?= e($name) ?></h3>
                            <p class="text-[12px]" style="color: var(--ink-muted);"><?= e($role) ?> · <?= e($exp) ?></p>
                        </div>
                    </div>
                    <p class="text-[13.5px] leading-relaxed" style="color: var(--ink-muted);"><?= e($bio) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════════
     STATS
     ════════════════════════════════════════════════════════════ -->
<section class="bg-[#F5F5F5] py-14 sm:py-16 border-y border-[rgba(17,17,17,0.06)]">
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-px bg-[rgba(17,17,17,0.08)] rounded-2xl overflow-hidden">
            <?php
            $stats = [
                ['10', '+', 'Años',      'De operación'],
                ['80', '+', 'Clientes',  'Satisfechos'],
                ['120','+', 'Proyectos', 'Completados'],
                ['99', '%', 'Tasa',      'De éxito'],
            ];
            foreach ($stats as [$v, $suffix, $kpi, $desc]):
            ?>
                <div class="bg-white p-6 md:p-8">
                    <div class="big-num text-[clamp(2.5rem,5vw,4rem)] mb-2 leading-none" style="color: var(--ink);">
                        <span data-counter="<?= e($v) ?>" data-suffix="<?= e($suffix) ?>">0<?= e($suffix) ?></span>
                    </div>
                    <div class="text-[12px] font-mono uppercase tracking-[0.18em] mb-1" style="color: var(--ink-muted);"><?= e($kpi) ?></div>
                    <div class="text-[13.5px]" style="color: var(--ink-soft);"><?= e($desc) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════════
     CTA
     ════════════════════════════════════════════════════════════ -->
<section class="bg-white pt-16 sm:pt-20 pb-16 sm:pb-24">
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <div class="relative rounded-3xl overflow-hidden p-10 sm:p-14 lg:p-20 bg-[#EFEFEF]">
            <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
                <div class="hero-canvas__chroma"></div>
                <div class="hero-canvas__grain"></div>
            </div>

            <div class="relative z-10 max-w-2xl">
                <div class="section-badge mb-6">
                    <span class="section-badge__num">3</span>
                    <span class="section-badge__label">Discovery gratuito</span>
                </div>
                <h2 class="font-medium leading-[1.05] tracking-[-0.03em] text-balance mb-6"
                    style="color: var(--ink); font-size: clamp(1.75rem, 5vw, 3.75rem);">
                    ¿Hablamos<em class="text-italic-serif">?</em>
                </h2>
                <p class="text-[15px] sm:text-[17px] leading-[1.6] max-w-xl mb-8" style="color: var(--ink-soft);">
                    Cuéntanos qué necesitas. Respondemos en menos de 24 horas con una propuesta concreta.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 sm:gap-5 items-start sm:items-center">
                    <a href="<?= url('/contact') ?>" class="btn-orange group">
                        <span class="text-roll">
                            <span class="text-roll__inner">
                                <span>Iniciar conversación</span>
                                <span>Iniciar conversación</span>
                            </span>
                        </span>
                        <span class="arrow-circle arrow-circle--lg arrow-circle__orange">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-5-5l5 5-5 5"/></svg>
                        </span>
                    </a>
                    <a href="<?= url('/services') ?>" class="inline-flex items-center gap-2 text-[14px] font-medium hover:text-[#F26522] transition-colors" style="color: var(--ink);">
                        Ver servicios →
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
