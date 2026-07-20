<footer class="bg-white border-t border-[rgba(17,17,17,0.06)]">
    <div class="max-w-[1440px] mx-auto px-5 sm:px-8 lg:px-12 pt-16 sm:pt-20 lg:pt-24 pb-10">

        <!-- Big logo + CTA row -->
        <div class="grid lg:grid-cols-12 gap-10 items-end pb-12 border-b border-[rgba(17,17,17,0.06)]">
            <div class="lg:col-span-8">
                <a href="<?= url('/') ?>" class="block font-medium tracking-[-0.04em] leading-[0.9]"
                   style="color: var(--ink); font-size: clamp(3rem, 9vw, 7rem);">
                    KYROS<span style="color: var(--orange);">.</span>
                </a>
                <p class="mt-6 max-w-md text-[14.5px] leading-relaxed" style="color: var(--ink-soft);">
                    Construimos software, ciberseguridad e infraestructura para empresas que no pueden permitirse fallar.
                </p>
            </div>
            <div class="lg:col-span-4 lg:text-right">
                <div class="flex flex-col lg:items-end gap-3">
                    <a href="<?= url('/hablemos') ?>" class="btn-orange group">
                        <span class="text-roll">
                            <span class="text-roll__inner">
                                <span>Iniciar proyecto</span>
                                <span>Iniciar proyecto</span>
                            </span>
                        </span>
                        <span class="arrow-circle arrow-circle__orange">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-5-5l5 5-5 5"/></svg>
                        </span>
                    </a>
                    <a href="tel:+18495024061" class="inline-flex items-center gap-2 text-[13px]" style="color: var(--ink-muted);">
                        <?= icon('phone', 'w-3.5 h-3.5') ?> +1 (849) 502-4061
                    </a>
                </div>
            </div>
        </div>

        <!-- Link columns -->
        <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-10 py-12 border-b border-[rgba(17,17,17,0.06)]">
            <div>
                <p class="text-[11px] font-mono uppercase tracking-[0.22em] mb-5" style="color: var(--ink-muted);">Contacto</p>
                <div class="space-y-3">
                    <a href="mailto:info@kyrosrd.com" class="block group">
                        <span class="text-[16px] font-medium block transition-colors group-hover:text-[var(--orange)]" style="color: var(--ink);">info@kyrosrd.com</span>
                        <span class="text-[12px] mt-0.5 block" style="color: var(--ink-muted);">Email general</span>
                    </a>
                    <a href="tel:+18495024061" class="block group">
                        <span class="text-[16px] font-medium block transition-colors group-hover:text-[var(--orange)]" style="color: var(--ink);">+1 (849) 502-4061</span>
                        <span class="text-[12px] mt-0.5 block" style="color: var(--ink-muted);">Llamada · WhatsApp</span>
                    </a>
                </div>
            </div>
            <div>
                <p class="text-[11px] font-mono uppercase tracking-[0.22em] mb-5" style="color: var(--ink-muted);">Servicios</p>
                <ul class="space-y-3">
                    <li><a href="<?= url('/services/software-development') ?>" class="text-[14px] hover:text-[var(--orange)] transition-colors" style="color: var(--ink-soft);">Desarrollo de Software</a></li>
                    <li><a href="<?= url('/services/cybersecurity') ?>" class="text-[14px] hover:text-[var(--orange)] transition-colors" style="color: var(--ink-soft);">Ciberseguridad</a></li>
                    <li><a href="<?= url('/services/technical-support') ?>" class="text-[14px] hover:text-[var(--orange)] transition-colors" style="color: var(--ink-soft);">Soporte 24/7</a></li>
                    <li><a href="<?= url('/services/network-infrastructure') ?>" class="text-[14px] hover:text-[var(--orange)] transition-colors" style="color: var(--ink-soft);">Infraestructura</a></li>
                    <li><a href="<?= url('/services/social-media') ?>" class="text-[14px] hover:text-[var(--orange)] transition-colors" style="color: var(--ink-soft);">Redes Sociales</a></li>
                    <li><a href="<?= url('/services/medical-websites') ?>" class="text-[14px] hover:text-[var(--orange)] transition-colors" style="color: var(--ink-soft);">Webs para Médicos</a></li>
                </ul>
            </div>
            <div>
                <p class="text-[11px] font-mono uppercase tracking-[0.22em] mb-5" style="color: var(--ink-muted);">Empresa</p>
                <ul class="space-y-3">
                    <li><a href="<?= url('/about') ?>" class="text-[14px] hover:text-[var(--orange)] transition-colors" style="color: var(--ink-soft);">Nosotros</a></li>
                    <li><a href="<?= url('/proyectos') ?>" class="text-[14px] hover:text-[var(--orange)] transition-colors" style="color: var(--ink-soft);">Proyectos</a></li>
                    <li><a href="<?= url('/blog') ?>" class="text-[14px] hover:text-[var(--orange)] transition-colors" style="color: var(--ink-soft);">Blog</a></li>
                    <li><a href="<?= url('/contact') ?>" class="text-[14px] hover:text-[var(--orange)] transition-colors" style="color: var(--ink-soft);">Contacto</a></li>
                </ul>
            </div>
            <div>
                <p class="text-[11px] font-mono uppercase tracking-[0.22em] mb-5" style="color: var(--ink-muted);">Social</p>
                <div class="flex items-center gap-2">
                    <a href="https://www.linkedin.com/company/kyrossolutions" target="_blank" rel="noopener" aria-label="LinkedIn"
                       class="w-10 h-10 rounded-full flex items-center justify-center bg-[#FAFAFA] hover:bg-[var(--orange)] hover:text-white transition-colors border border-[rgba(17,17,17,0.06)]" style="color: var(--ink);">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    </a>
                    <a href="#" aria-label="Instagram" class="w-10 h-10 rounded-full flex items-center justify-center bg-[#FAFAFA] hover:bg-[var(--orange)] hover:text-white transition-colors border border-[rgba(17,17,17,0.06)]" style="color: var(--ink);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="18" cy="6" r="1" fill="currentColor"/></svg>
                    </a>
                    <a href="https://wa.me/18495024061" target="_blank" rel="noopener" aria-label="WhatsApp"
                       class="w-10 h-10 rounded-full flex items-center justify-center bg-[#FAFAFA] hover:bg-[#25D366] hover:text-white transition-colors border border-[rgba(17,17,17,0.06)]" style="color: var(--ink);">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448L.057 24z"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Bottom strip -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 pt-8">
            <p class="text-[12px] font-mono" style="color: var(--ink-muted);">© <?= date('Y') ?> KYROS Solutions · Santo Domingo, RD</p>
            <span class="inline-flex items-center gap-2 text-[12px] font-mono" style="color: var(--ink-muted);">
                <span class="w-1.5 h-1.5 rounded-full bg-[#10B981]" style="box-shadow: 0 0 0 3px rgba(16,185,129,0.18);"></span>
                Todos los sistemas operativos
            </span>
        </div>
    </div>
</footer>
