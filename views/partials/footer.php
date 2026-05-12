<footer class="relative mt-28 overflow-hidden border-t border-white/5">
    <div class="mesh-bg" style="opacity:0.22"></div>

    <!-- Liquid orbs -->
    <div class="liquid-orb liquid-orb--indigo" style="width: 520px; height: 520px; top: -180px; left: -100px;"></div>
    <div class="liquid-orb liquid-orb--cyan"   style="width: 380px; height: 380px; bottom: -120px; right: 8%;"></div>
    <div class="liquid-orb liquid-orb--violet" style="width: 300px; height: 300px; top: 30%; right: 30%; opacity: 0.35;"></div>

    <div class="container relative z-10 pt-24 pb-12">

        <div class="grid lg:grid-cols-12 gap-12 items-end pb-16 border-b border-white/5">
            <div class="lg:col-span-8">
                <span class="eyebrow mb-7">¿Empezamos un proyecto?</span>
                <a href="<?= url('/') ?>" class="font-display font-normal tracking-tightest leading-[0.82] block text-balance mt-6"
                   style="font-size: clamp(4rem, 13vw, 11rem);">
                    <span class="text-grad-cream">KYROS</span><span class="text-italic-serif text-grad-indigo">.</span>
                </a>
                <p class="text-chalk/55 max-w-md mt-7 text-[15px] leading-relaxed">
                    Construimos software, ciberseguridad e infraestructura para empresas que no pueden permitirse fallar.
                </p>
            </div>
            <div class="lg:col-span-4 lg:text-right">
                <div class="flex flex-col lg:items-end gap-3">
                    <a href="<?= url('/contact') ?>" class="btn-ember magnetic">
                        Iniciar proyecto
                        <svg class="w-3.5 h-3.5 arrow-ic" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-5-5l5 5-5 5"/></svg>
                    </a>
                    <a href="tel:+18495024061" class="btn-outline text-[13px]">
                        <?= icon('phone', 'w-3.5 h-3.5') ?> +1 (849) 502-4061
                    </a>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-12 gap-10 py-16 border-b border-white/5">

            <div class="md:col-span-5">
                <p class="font-mono text-[10px] tracking-[0.3em] uppercase text-chalk-quiet mb-6">Contacto directo</p>
                <div class="space-y-5">
                    <a href="mailto:info@kyrosrd.com" class="block group">
                        <span class="font-display text-[clamp(1.5rem,3vw,2rem)] tracking-tightest font-normal text-chalk group-hover:text-indigo-300 transition-colors">
                            info@kyrosrd.com
                        </span>
                        <span class="block text-[10.5px] tracking-[0.22em] uppercase text-chalk-quiet mt-1 font-mono">Email general</span>
                    </a>
                    <a href="tel:+18495024061" class="block group">
                        <span class="font-display text-[clamp(1.5rem,3vw,2rem)] tracking-tightest font-normal text-chalk group-hover:text-indigo-300 transition-colors">
                            +1 (849) 502-4061
                        </span>
                        <span class="block text-[10.5px] tracking-[0.22em] uppercase text-chalk-quiet mt-1 font-mono">Llamada o WhatsApp</span>
                    </a>
                </div>
                <div class="hairline my-7"></div>
                <div class="flex items-center gap-2">
                    <a href="https://www.linkedin.com/company/kyrossolutions" target="_blank" rel="noopener" aria-label="LinkedIn"
                       class="liquid-glass-light w-10 h-10 rounded-full flex items-center justify-center text-chalk/75 hover:text-chalk transition" style="border: 1px solid rgba(255,255,255,0.12);">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    </a>
                    <a href="#" aria-label="Instagram" class="liquid-glass-light w-10 h-10 rounded-full flex items-center justify-center text-chalk/75 hover:text-chalk transition" style="border: 1px solid rgba(255,255,255,0.12);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="18" cy="6" r="1" fill="currentColor"/></svg>
                    </a>
                    <a href="https://wa.me/18495024061" target="_blank" rel="noopener" aria-label="WhatsApp"
                       class="liquid-glass-light w-10 h-10 rounded-full flex items-center justify-center text-chalk/75 hover:text-chalk transition" style="border: 1px solid rgba(255,255,255,0.12);">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448L.057 24z"/></svg>
                    </a>
                </div>
            </div>

            <div class="md:col-span-3">
                <p class="font-mono text-[10px] tracking-[0.3em] uppercase text-chalk-quiet mb-6">Servicios</p>
                <ul class="space-y-3.5">
                    <li><a href="<?= url('/services/software-development') ?>" class="text-chalk/65 hover:text-chalk text-[14.5px] transition link-anim">Desarrollo de Software</a></li>
                    <li><a href="<?= url('/services/cybersecurity') ?>" class="text-chalk/65 hover:text-chalk text-[14.5px] transition link-anim">Ciberseguridad</a></li>
                    <li><a href="<?= url('/services/technical-support') ?>" class="text-chalk/65 hover:text-chalk text-[14.5px] transition link-anim">Soporte & Helpdesk</a></li>
                    <li><a href="<?= url('/services/network-infrastructure') ?>" class="text-chalk/65 hover:text-chalk text-[14.5px] transition link-anim">Infraestructura de Redes</a></li>
                </ul>
            </div>

            <div class="md:col-span-2">
                <p class="font-mono text-[10px] tracking-[0.3em] uppercase text-chalk-quiet mb-6">Empresa</p>
                <ul class="space-y-3.5">
                    <li><a href="<?= url('/about') ?>" class="text-chalk/65 hover:text-chalk text-[14.5px] transition link-anim">Sobre Nosotros</a></li>
                    <li><a href="<?= url('/services') ?>" class="text-chalk/65 hover:text-chalk text-[14.5px] transition link-anim">Servicios</a></li>
                    <li><a href="<?= url('/contact') ?>" class="text-chalk/65 hover:text-chalk text-[14.5px] transition link-anim">Contacto</a></li>
                </ul>
            </div>

            <div class="md:col-span-2">
                <p class="font-mono text-[10px] tracking-[0.3em] uppercase text-chalk-quiet mb-6">Legal</p>
                <ul class="space-y-3.5">
                    <li><a href="<?= url('/privacy') ?>" class="text-chalk/65 hover:text-chalk text-[14.5px] transition link-anim">Privacidad</a></li>
                    <li><a href="<?= url('/terms') ?>" class="text-chalk/65 hover:text-chalk text-[14.5px] transition link-anim">Términos</a></li>
                </ul>
            </div>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-center gap-4 pt-8">
            <p class="text-chalk-quiet text-[12px] font-mono tracking-tight">© <?= date('Y') ?> KYROS Solutions · Built in Santo Domingo, RD</p>
            <div class="flex items-center gap-3 text-chalk-quiet text-[12px] font-mono">
                <span class="inline-flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full" style="background:#22D3EE; box-shadow:0 0 10px #22D3EE, 0 0 20px rgba(34,211,238,0.6);"></span>
                    All systems operational
                </span>
            </div>
        </div>
    </div>
</footer>
