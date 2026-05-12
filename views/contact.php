<?php
require_once base_path('views/partials/icons.php');
$status     = flash('contact_status');
$generalErr = flash('contact_error');
$errors     = flash('contact_errors') ?: [];
?>

<!-- HERO -->
<section class="relative pt-20 lg:pt-32 pb-16 overflow-hidden" data-hero>
    <div class="absolute inset-0 grid-mask"></div>
    <div class="mesh-bg" style="opacity:0.55"></div>

    <!-- Liquid orbs -->
    <div class="liquid-orb liquid-orb--indigo" style="width: 580px; height: 580px; top: -200px; left: -120px;"></div>
    <div class="liquid-orb liquid-orb--cyan"   style="width: 400px; height: 400px; top: 18%; right: -80px;"></div>
    <div class="liquid-orb liquid-orb--violet" style="width: 280px; height: 280px; bottom: -100px; left: 35%; opacity: 0.4;"></div>

    <div class="absolute top-0 left-[15%] beam"></div>
    <div class="absolute top-24 right-[20%] beam" style="animation-delay: 1.2s;"></div>

    <div class="container relative z-10">
        <div class="flex items-center justify-between gap-4 mb-12 reveal">
            <div class="glow-tag"><span class="text-chalk">Contacto</span></div>
            <div class="hidden md:flex items-center gap-3 text-[12px] text-chalk-quiet font-mono">
                <span>Respuesta en &lt;24h</span>
            </div>
        </div>

        <div class="grid lg:grid-cols-12 gap-12 items-end">
            <div class="lg:col-span-9">
                <h1 class="font-display font-normal tracking-tightest leading-[0.95] text-balance
                           text-[clamp(2.5rem,6.5vw,5.5rem)] reveal">
                    <span class="block text-grad-cream">Hablemos de tu</span>
                    <span class="block text-grad-cream"><span class="text-italic-serif text-grad-indigo">próximo proyecto</span>.</span>
                </h1>
            </div>
            <div class="lg:col-span-3 reveal" style="transition-delay:180ms">
                <p class="text-chalk/65 text-[16px] leading-relaxed">
                    Cuéntanos qué necesitas. Respondemos en menos de 24 horas con una propuesta concreta.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- FORM + INFO -->
<section class="pb-28" id="form">
    <div class="container">
        <div class="grid lg:grid-cols-12 gap-5">
            <div class="lg:col-span-7">
                <div class="conic-border reveal" style="padding: 0.5rem;">
                    <div class="p-8 md:p-10 rounded-[26px]" style="background: linear-gradient(180deg, #12121A, #0A0A12);">
                        <span class="eyebrow mb-7"><span class="eyebrow-num">[01]</span>Formulario</span>
                        <h2 class="font-display text-[clamp(1.5rem,2.8vw,2.25rem)] font-normal tracking-tightest mt-5 mb-3 text-balance">
                            Envíanos un <span class="text-italic-serif text-grad-indigo">mensaje</span>
                        </h2>
                        <p class="text-chalk/45 text-[13px] mb-8">
                            Los campos con <span class="text-indigo-300">*</span> son obligatorios.
                        </p>

                        <?php if ($status === 'success'): ?>
                            <div class="mb-6 p-5 rounded-2xl flex items-start gap-3"
                                 style="background: rgba(34,211,238,0.10); border: 1px solid rgba(34,211,238,0.30);">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center" style="background:rgba(34,211,238,0.22); color:#22D3EE;">
                                    <?= icon('check-circle', 'w-6 h-6') ?>
                                </div>
                                <div>
                                    <h3 class="font-display font-normal text-chalk mb-1">¡Mensaje enviado!</h3>
                                    <p class="text-chalk/70 text-[14px]">Gracias por contactarnos. Te responderemos en menos de 24 horas.</p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($generalErr): ?>
                            <div class="mb-6 p-5 rounded-2xl text-[14px]"
                                 style="background: rgba(255,90,90,0.10); border: 1px solid rgba(255,90,90,0.30); color: #FFB5B5;">
                                <?= e($generalErr) ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= url('/contact') ?>" method="POST" class="space-y-5" novalidate>
                            <?= csrf_field() ?>
                            <div class="hidden" aria-hidden="true">
                                <label>Tu sitio web<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[12px] font-medium text-chalk/70 mb-2 tracking-tight" for="name">Nombre completo <span class="text-indigo-300">*</span></label>
                                    <input id="name" name="name" type="text" required maxlength="120" autocomplete="name"
                                           value="<?= e(old('name')) ?>"
                                           class="input-field<?= isset($errors['name']) ? ' !border-red-500/60' : '' ?>"
                                           placeholder="Juan Pérez">
                                    <?php if (isset($errors['name'])): ?>
                                        <p class="mt-2 text-[12px] text-red-300"><?= e($errors['name']) ?></p>
                                    <?php endif; ?>
                                </div>

                                <div>
                                    <label class="block text-[12px] font-medium text-chalk/70 mb-2 tracking-tight" for="email">Email corporativo <span class="text-indigo-300">*</span></label>
                                    <input id="email" name="email" type="email" required maxlength="160" autocomplete="email"
                                           value="<?= e(old('email')) ?>"
                                           class="input-field<?= isset($errors['email']) ? ' !border-red-500/60' : '' ?>"
                                           placeholder="juan@empresa.com">
                                    <?php if (isset($errors['email'])): ?>
                                        <p class="mt-2 text-[12px] text-red-300"><?= e($errors['email']) ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[12px] font-medium text-chalk/70 mb-2 tracking-tight" for="company">Empresa</label>
                                    <input id="company" name="company" type="text" maxlength="160" autocomplete="organization"
                                           value="<?= e(old('company')) ?>" class="input-field" placeholder="Tu Empresa S.R.L.">
                                </div>
                                <div>
                                    <label class="block text-[12px] font-medium text-chalk/70 mb-2 tracking-tight" for="phone">Teléfono</label>
                                    <input id="phone" name="phone" type="tel" maxlength="40" autocomplete="tel"
                                           value="<?= e(old('phone')) ?>" class="input-field" placeholder="+1 (849) 000-0000">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[12px] font-medium text-chalk/70 mb-2 tracking-tight" for="service">¿Qué servicio te interesa?</label>
                                <select id="service" name="service" class="input-field appearance-none"
                                        style="background-image:url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2218%22 height=%2218%22 fill=%22none%22 stroke=%22%238E8EFF%22 stroke-width=%221.8%22 viewBox=%220 0 24 24%22><polyline points=%226 9 12 15 18 9%22/></svg>');background-position:right 1rem center;background-repeat:no-repeat;padding-right:2.5rem;">
                                    <option value="">Selecciona uno</option>
                                    <?php
                                    $opts = ['Desarrollo de Software', 'Ciberseguridad', 'Soporte & Helpdesk', 'Infraestructura de Redes', 'Consultoría / Otro'];
                                    foreach ($opts as $o):
                                        $sel = old('service') === $o ? ' selected' : '';
                                    ?>
                                        <option value="<?= e($o) ?>"<?= $sel ?> style="background:#12121A;color:#FFFFFF;"><?= e($o) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[12px] font-medium text-chalk/70 mb-2 tracking-tight" for="message">¿Cómo podemos ayudarte? <span class="text-indigo-300">*</span></label>
                                <textarea id="message" name="message" rows="5" required minlength="10" maxlength="4000"
                                          class="input-field resize-none<?= isset($errors['message']) ? ' !border-red-500/60' : '' ?>"
                                          placeholder="Cuéntanos sobre tu proyecto: objetivos, contexto, timeline ideal, presupuesto aproximado..."><?= e(old('message')) ?></textarea>
                                <?php if (isset($errors['message'])): ?>
                                    <p class="mt-2 text-[12px] text-red-300"><?= e($errors['message']) ?></p>
                                <?php endif; ?>
                            </div>

                            <button type="submit" class="btn-ember magnetic w-full py-4 text-[15px]">
                                Enviar mensaje
                                <?= icon('send', 'w-4 h-4 arrow-ic') ?>
                            </button>

                            <p class="text-[12px] text-chalk/40 text-center">
                                Al enviar aceptas nuestra <a href="<?= url('/privacy') ?>" class="text-indigo-300 hover:text-indigo-200 underline underline-offset-2">Política de Privacidad</a>.
                            </p>
                        </form>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 space-y-5">
                <div class="tilt reveal" style="transition-delay:80ms;">
                    <div class="tilt-target card spotlight">
                        <span class="eyebrow mb-7"><span class="eyebrow-num">[02]</span>Información</span>
                        <h3 class="font-display text-[clamp(1.25rem,2vw,1.5rem)] font-normal tracking-tighter mt-5 mb-7 tilt-up">Canales de contacto</h3>
                        <div class="space-y-5">
                            <a href="mailto:info@kyrosrd.com" class="flex items-start gap-4 group">
                                <div class="icon-chip" style="width:44px;height:44px;border-radius:12px;">
                                    <?= icon('mail', 'w-5 h-5') ?>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-mono text-[10px] tracking-[0.22em] uppercase text-chalk-quiet">Email</p>
                                    <p class="text-chalk font-medium text-[14.5px] truncate group-hover:text-indigo-300 transition-colors mt-0.5">info@kyrosrd.com</p>
                                </div>
                            </a>

                            <a href="tel:+18495024061" class="flex items-start gap-4 group">
                                <div class="icon-chip" style="width:44px;height:44px;border-radius:12px;">
                                    <?= icon('phone', 'w-5 h-5') ?>
                                </div>
                                <div>
                                    <p class="font-mono text-[10px] tracking-[0.22em] uppercase text-chalk-quiet">Teléfono</p>
                                    <p class="text-chalk font-medium text-[14.5px] group-hover:text-indigo-300 transition-colors mt-0.5">+1 (849) 502-4061</p>
                                </div>
                            </a>

                            <div class="flex items-start gap-4">
                                <div class="icon-chip icon-chip-cyan" style="width:44px;height:44px;border-radius:12px;">
                                    <?= icon('clock', 'w-5 h-5') ?>
                                </div>
                                <div>
                                    <p class="font-mono text-[10px] tracking-[0.22em] uppercase text-chalk-quiet">Horario</p>
                                    <p class="text-chalk font-medium text-[14.5px] mt-0.5">Lun – Vie · 9:00 - 18:00 (GMT-4)</p>
                                    <p class="text-chalk/50 text-[12.5px] mt-1">Soporte 24/7 para clientes con SLA</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="icon-chip icon-chip-violet" style="width:44px;height:44px;border-radius:12px;">
                                    <?= icon('globe', 'w-5 h-5') ?>
                                </div>
                                <div>
                                    <p class="font-mono text-[10px] tracking-[0.22em] uppercase text-chalk-quiet">Cobertura</p>
                                    <p class="text-chalk font-medium text-[14.5px] mt-0.5">100% remoto</p>
                                    <p class="text-chalk/50 text-[12.5px] mt-1">Servicio en toda Latinoamérica</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="https://wa.me/18495024061" target="_blank" rel="noopener" class="card spotlight group block reveal"
                   style="transition-delay:140ms; background: linear-gradient(180deg, rgba(37,211,102,0.10), rgba(37,211,102,0.015)); border: 1px solid rgba(37,211,102,0.25);">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform"
                             style="background:#25D366; color:#fff; box-shadow: 0 8px 24px -6px rgba(37,211,102,0.45);">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448L.057 24z"/></svg>
                        </div>
                        <div>
                            <p class="font-display text-[15px] font-normal tracking-tight text-chalk">WhatsApp directo</p>
                            <p class="text-chalk/55 text-[13px] mt-0.5">Respuesta más rápida en horario laboral</p>
                        </div>
                        <div class="ml-auto text-chalk/30 group-hover:text-chalk group-hover:translate-x-1 transition-all">
                            <?= icon('arrow-right', 'w-4 h-4') ?>
                        </div>
                    </div>
                </a>

                <div class="card reveal" style="transition-delay:200ms;">
                    <span class="eyebrow mb-5"><span class="eyebrow-num">[03]</span>Por qué KYROS</span>
                    <h3 class="font-display text-[17px] font-normal tracking-tight mt-5 mb-4">Razones para elegirnos</h3>
                    <ul class="space-y-3 text-[14px] text-chalk/75">
                        <?php foreach ([
                            'Respuesta en menos de 24 horas',
                            'Consultoría inicial gratuita',
                            'Equipo senior y dedicado',
                            'Propuesta concreta en 48h',
                        ] as $item): ?>
                            <li class="flex items-start gap-2.5">
                                <span class="w-4 h-4 mt-0.5 text-indigo-300 flex-shrink-0"><?= icon('check', 'w-4 h-4') ?></span>
                                <?= e($item) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
