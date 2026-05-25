<?php
require_once base_path('views/partials/icons.php');
$status     = flash('contact_status');
$generalErr = flash('contact_error');
$errors     = flash('contact_errors') ?: [];
?>

<!-- ════════════════════════════════════════════════════════════
     HERO STRIP — animated bg
     ════════════════════════════════════════════════════════════ -->
<section class="relative pt-32 sm:pt-36 pb-14 overflow-hidden bg-[#EFEFEF]">
    <div class="hero-canvas" aria-hidden="true">
        <div class="hero-canvas__chroma"></div>
        <div class="hero-canvas__fluted"></div>
        <div class="hero-canvas__grain"></div>
    </div>

    <div class="relative z-20 max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <div class="section-badge mb-6">
            <span class="section-badge__num">C</span>
            <span class="section-badge__label">Contacto</span>
        </div>
        <div class="grid lg:grid-cols-12 gap-10 items-end">
            <div class="lg:col-span-9">
                <h1 class="font-medium leading-[1.05] tracking-[-0.03em] text-balance"
                    style="color: var(--ink); font-size: clamp(2rem, 6vw, 4.2rem);">
                    Hablemos de tu<br>próximo proyecto.
                </h1>
            </div>
            <div class="lg:col-span-3">
                <p class="text-[15px] sm:text-[16px] leading-[1.6]" style="color: var(--ink-soft);">
                    Cuéntanos qué necesitas. Respondemos en menos de 24 horas con una propuesta concreta.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════════════════════
     FORM + INFO
     ════════════════════════════════════════════════════════════ -->
<section class="bg-white pt-14 pb-20 sm:pb-28">
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12">
        <div class="grid lg:grid-cols-12 gap-8">

            <!-- Form -->
            <div class="lg:col-span-7">
                <div class="rounded-2xl border border-[rgba(17,17,17,0.08)] bg-white p-6 sm:p-8 lg:p-10" style="box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                    <div class="section-badge mb-6">
                        <span class="section-badge__num">1</span>
                        <span class="section-badge__label">Formulario</span>
                    </div>
                    <h2 class="font-medium text-[clamp(1.4rem,2.5vw,1.9rem)] tracking-tight mb-2" style="color: var(--ink);">
                        Envíanos un mensaje
                    </h2>
                    <p class="text-[13px] mb-8" style="color: var(--ink-muted);">
                        Los campos con <span class="text-[#F26522]">*</span> son obligatorios.
                    </p>

                    <?php if ($status === 'success'): ?>
                        <div class="mb-6 p-4 rounded-xl flex items-start gap-3" style="background: #ECFDF5; border: 1px solid #A7F3D0;">
                            <div class="flex-shrink-0 w-9 h-9 rounded-full flex items-center justify-center" style="background: #10B981; color: #fff;">
                                <?= icon('check-circle', 'w-5 h-5') ?>
                            </div>
                            <div>
                                <h3 class="font-medium text-[15px] mb-0.5" style="color: #065F46;">¡Mensaje enviado!</h3>
                                <p class="text-[13px]" style="color: #047857;">Gracias por contactarnos. Te responderemos en menos de 24 horas.</p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($generalErr): ?>
                        <div class="mb-6 p-4 rounded-xl text-[14px]" style="background: #FEF2F2; border: 1px solid #FECACA; color: #B91C1C;">
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
                                <label class="block text-[12px] font-semibold uppercase tracking-[0.06em] mb-1.5" for="name" style="color: var(--ink-soft);">
                                    Nombre completo <span class="text-[#F26522]">*</span>
                                </label>
                                <input id="name" name="name" type="text" required maxlength="120" autocomplete="name"
                                       value="<?= e(old('name')) ?>"
                                       class="w-full px-3.5 py-3 text-[14px] rounded-xl border bg-white focus:outline-none focus:border-[#F26522] focus:ring-2 focus:ring-[#F26522]/16 transition-colors"
                                       style="border-color: <?= isset($errors['name']) ? '#FCA5A5' : 'rgba(17,17,17,0.14)' ?>; color: var(--ink);"
                                       placeholder="Juan Pérez">
                                <?php if (isset($errors['name'])): ?>
                                    <p class="mt-1.5 text-[12px] text-red-600"><?= e($errors['name']) ?></p>
                                <?php endif; ?>
                            </div>

                            <div>
                                <label class="block text-[12px] font-semibold uppercase tracking-[0.06em] mb-1.5" for="email" style="color: var(--ink-soft);">
                                    Email corporativo <span class="text-[#F26522]">*</span>
                                </label>
                                <input id="email" name="email" type="email" required maxlength="160" autocomplete="email"
                                       value="<?= e(old('email')) ?>"
                                       class="w-full px-3.5 py-3 text-[14px] rounded-xl border bg-white focus:outline-none focus:border-[#F26522] focus:ring-2 focus:ring-[#F26522]/16 transition-colors"
                                       style="border-color: <?= isset($errors['email']) ? '#FCA5A5' : 'rgba(17,17,17,0.14)' ?>; color: var(--ink);"
                                       placeholder="juan@empresa.com">
                                <?php if (isset($errors['email'])): ?>
                                    <p class="mt-1.5 text-[12px] text-red-600"><?= e($errors['email']) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[12px] font-semibold uppercase tracking-[0.06em] mb-1.5" for="company" style="color: var(--ink-soft);">Empresa</label>
                                <input id="company" name="company" type="text" maxlength="160" autocomplete="organization"
                                       value="<?= e(old('company')) ?>"
                                       class="w-full px-3.5 py-3 text-[14px] rounded-xl border border-[rgba(17,17,17,0.14)] bg-white focus:outline-none focus:border-[#F26522] focus:ring-2 focus:ring-[#F26522]/16 transition-colors"
                                       placeholder="Tu Empresa S.R.L.">
                            </div>
                            <div>
                                <label class="block text-[12px] font-semibold uppercase tracking-[0.06em] mb-1.5" for="phone" style="color: var(--ink-soft);">Teléfono</label>
                                <input id="phone" name="phone" type="tel" maxlength="40" autocomplete="tel"
                                       value="<?= e(old('phone')) ?>"
                                       class="w-full px-3.5 py-3 text-[14px] rounded-xl border border-[rgba(17,17,17,0.14)] bg-white focus:outline-none focus:border-[#F26522] focus:ring-2 focus:ring-[#F26522]/16 transition-colors"
                                       placeholder="+1 (849) 000-0000">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[12px] font-semibold uppercase tracking-[0.06em] mb-1.5" for="service" style="color: var(--ink-soft);">¿Qué servicio te interesa?</label>
                            <select id="service" name="service"
                                    class="w-full px-3.5 py-3 text-[14px] rounded-xl border border-[rgba(17,17,17,0.14)] bg-white focus:outline-none focus:border-[#F26522] focus:ring-2 focus:ring-[#F26522]/16 transition-colors appearance-none"
                                    style="background-image:url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2218%22 height=%2218%22 fill=%22none%22 stroke=%22%23111111%22 stroke-width=%221.8%22 viewBox=%220 0 24 24%22><polyline points=%226 9 12 15 18 9%22/></svg>');background-position:right 1rem center;background-repeat:no-repeat;padding-right:2.5rem;">
                                <option value="">Selecciona uno</option>
                                <?php
                                $opts = ['Desarrollo de Software', 'Ciberseguridad', 'Soporte & Helpdesk', 'Infraestructura de Redes', 'Consultoría / Otro'];
                                foreach ($opts as $o):
                                    $sel = old('service') === $o ? ' selected' : '';
                                ?>
                                    <option value="<?= e($o) ?>"<?= $sel ?>><?= e($o) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[12px] font-semibold uppercase tracking-[0.06em] mb-1.5" for="message" style="color: var(--ink-soft);">¿Cómo podemos ayudarte? <span class="text-[#F26522]">*</span></label>
                            <textarea id="message" name="message" rows="6" required minlength="10" maxlength="4000"
                                      class="w-full px-3.5 py-3 text-[14px] rounded-xl border bg-white focus:outline-none focus:border-[#F26522] focus:ring-2 focus:ring-[#F26522]/16 transition-colors resize-none"
                                      style="border-color: <?= isset($errors['message']) ? '#FCA5A5' : 'rgba(17,17,17,0.14)' ?>; color: var(--ink);"
                                      placeholder="Cuéntanos sobre tu proyecto: objetivos, contexto, timeline ideal, presupuesto aproximado..."><?= e(old('message')) ?></textarea>
                            <?php if (isset($errors['message'])): ?>
                                <p class="mt-1.5 text-[12px] text-red-600"><?= e($errors['message']) ?></p>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn-orange group w-full justify-center" style="padding: 14px 14px 14px 22px;">
                            <span class="text-roll">
                                <span class="text-roll__inner">
                                    <span>Enviar mensaje</span>
                                    <span>Enviar mensaje</span>
                                </span>
                            </span>
                            <span class="arrow-circle arrow-circle__orange">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-5-5l5 5-5 5"/></svg>
                            </span>
                        </button>

                        <p class="text-[12px] text-center" style="color: var(--ink-muted);">
                            Al enviar aceptas nuestra
                            <a href="<?= url('/privacy') ?>" class="underline underline-offset-2 hover:text-[#F26522]" style="color: var(--ink-soft);">Política de Privacidad</a>.
                        </p>
                    </form>
                </div>
            </div>

            <!-- Info sidebar -->
            <aside class="lg:col-span-5 space-y-5">
                <div class="rounded-2xl border border-[rgba(17,17,17,0.08)] bg-white p-6 sm:p-7">
                    <div class="section-badge mb-5">
                        <span class="section-badge__num">2</span>
                        <span class="section-badge__label">Información</span>
                    </div>
                    <h3 class="font-medium text-[18px] tracking-tight mb-6" style="color: var(--ink);">Canales de contacto</h3>

                    <div class="space-y-5">
                        <a href="mailto:info@kyrosrd.com" class="flex items-start gap-4 group">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0" style="background: #FFF4ED; color: #F26522; border: 1px solid #FED7B5;">
                                <?= icon('mail', 'w-5 h-5') ?>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] font-mono uppercase tracking-[0.18em]" style="color: var(--ink-muted);">Email</p>
                                <p class="font-medium text-[14.5px] truncate mt-0.5 group-hover:text-[#F26522] transition-colors" style="color: var(--ink);">info@kyrosrd.com</p>
                            </div>
                        </a>

                        <a href="tel:+18495024061" class="flex items-start gap-4 group">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0" style="background: #EEF2FF; color: #4F46E5; border: 1px solid #C7D2FE;">
                                <?= icon('phone', 'w-5 h-5') ?>
                            </div>
                            <div>
                                <p class="text-[11px] font-mono uppercase tracking-[0.18em]" style="color: var(--ink-muted);">Teléfono</p>
                                <p class="font-medium text-[14.5px] mt-0.5 group-hover:text-[#F26522] transition-colors" style="color: var(--ink);">+1 (849) 502-4061</p>
                            </div>
                        </a>

                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0" style="background: #ECFEFF; color: #0891B2; border: 1px solid #A5F3FC;">
                                <?= icon('clock', 'w-5 h-5') ?>
                            </div>
                            <div>
                                <p class="text-[11px] font-mono uppercase tracking-[0.18em]" style="color: var(--ink-muted);">Horario</p>
                                <p class="font-medium text-[14.5px] mt-0.5" style="color: var(--ink);">Lun – Vie · 9:00–18:00 (GMT-4)</p>
                                <p class="text-[12.5px] mt-1" style="color: var(--ink-muted);">Soporte 24/7 para clientes con SLA</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0" style="background: #F5F3FF; color: #7C3AED; border: 1px solid #DDD6FE;">
                                <?= icon('globe', 'w-5 h-5') ?>
                            </div>
                            <div>
                                <p class="text-[11px] font-mono uppercase tracking-[0.18em]" style="color: var(--ink-muted);">Cobertura</p>
                                <p class="font-medium text-[14.5px] mt-0.5" style="color: var(--ink);">100% remoto</p>
                                <p class="text-[12.5px] mt-1" style="color: var(--ink-muted);">Servicio en toda Latinoamérica</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- WhatsApp card -->
                <a href="https://wa.me/18495024061" target="_blank" rel="noopener" class="block rounded-2xl p-5 group transition-all hover:shadow-lg" style="background: linear-gradient(135deg, #DCFCE7 0%, #FFFFFF 60%); border: 1px solid #BBF7D0;">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform" style="background: #25D366; color: #fff;">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448L.057 24z"/></svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-[15px] tracking-tight" style="color: var(--ink);">WhatsApp directo</p>
                            <p class="text-[13px] mt-0.5" style="color: var(--ink-muted);">Respuesta más rápida en horario laboral</p>
                        </div>
                        <span class="text-[#16A34A] group-hover:translate-x-1 transition-transform">
                            <?= icon('arrow-right', 'w-4 h-4') ?>
                        </span>
                    </div>
                </a>

                <!-- Why KYROS -->
                <div class="rounded-2xl border border-[rgba(17,17,17,0.08)] bg-white p-6 sm:p-7">
                    <div class="section-badge mb-5">
                        <span class="section-badge__num">3</span>
                        <span class="section-badge__label">Por qué KYROS</span>
                    </div>
                    <h3 class="font-medium text-[17px] tracking-tight mb-4" style="color: var(--ink);">Razones para elegirnos</h3>
                    <ul class="space-y-3 text-[14px]" style="color: var(--ink-soft);">
                        <?php foreach ([
                            'Respuesta en menos de 24 horas',
                            'Consultoría inicial gratuita',
                            'Equipo senior y dedicado',
                            'Propuesta concreta en 48h',
                        ] as $item): ?>
                            <li class="flex items-start gap-2.5">
                                <span class="flex-shrink-0 mt-0.5 text-[#10B981]"><?= icon('check', 'w-4 h-4') ?></span>
                                <?= e($item) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</section>
