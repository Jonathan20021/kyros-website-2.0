<header id="site-header" class="fixed top-0 inset-x-0 z-40 transition-all duration-500">
    <style>
        #site-header .nav-shell {
            background: transparent;
            backdrop-filter: blur(0px);
            -webkit-backdrop-filter: blur(0px);
            border-bottom: 1px solid transparent;
            transition: background .5s cubic-bezier(0.16,1,0.3,1),
                        backdrop-filter .5s cubic-bezier(0.16,1,0.3,1),
                        border-color .5s, box-shadow .5s;
            position: relative;
            isolation: isolate;
        }
        #site-header .nav-shell::before {
            content: '';
            position: absolute;
            inset: 0;
            opacity: 0;
            pointer-events: none;
            background: linear-gradient(180deg, rgba(255,255,255,0.32), rgba(255,255,255,0.04) 18%, transparent 50%);
            transition: opacity .5s cubic-bezier(0.16,1,0.3,1);
            z-index: -1;
            mix-blend-mode: screen;
        }
        #site-header .nav-shell::after {
            content: '';
            position: absolute;
            left: 0; right: 0; bottom: -1px;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.16) 30%, rgba(255,255,255,0.16) 70%, transparent);
            opacity: 0;
            transition: opacity .5s;
            pointer-events: none;
        }
        #site-header.is-scrolled .nav-shell {
            background: rgba(8, 8, 14, 0.62);
            backdrop-filter: blur(28px) saturate(1.9) brightness(1.06);
            -webkit-backdrop-filter: blur(28px) saturate(1.9) brightness(1.06);
            border-bottom-color: rgba(255,255,255,0.04);
            box-shadow:
                inset 0 1px 0 rgba(255,255,255,0.10),
                0 8px 24px -12px rgba(0,0,0,0.6);
        }
        #site-header.is-scrolled .nav-shell::before { opacity: 1; }
        #site-header.is-scrolled .nav-shell::after  { opacity: 1; }

        /* Segmented active pill — Apple style */
        .nav-pill-link {
            position: relative;
            transition: color .35s var(--ease-out);
        }
        .nav-pill-link[data-active="true"] {
            background:
                linear-gradient(180deg, rgba(255,255,255,0.98) 0%, rgba(245,245,250,0.95) 100%);
            color: #050508;
            box-shadow:
                inset 0 1px 0 rgba(255,255,255,0.9),
                inset 0 -1px 0 rgba(0,0,0,0.08),
                0 6px 16px -4px rgba(255,255,255,0.18),
                0 0 0 1px rgba(255,255,255,0.4);
        }
        .nav-pill-link[data-active="false"]:hover {
            background: rgba(255,255,255,0.08);
            color: #FFFFFF;
        }

        /* Logo glass tile */
        .logo-tile {
            position: relative;
            isolation: isolate;
        }
        .logo-tile::after {
            content: '';
            position: absolute;
            inset: 1px;
            border-radius: inherit;
            background: linear-gradient(180deg, rgba(255,255,255,0.42), rgba(255,255,255,0) 55%);
            pointer-events: none;
            z-index: 1;
        }
        .logo-tile > * { position: relative; z-index: 2; }
    </style>

    <div class="nav-shell">
        <div class="container flex items-center justify-between h-[76px]">
            <a href="<?= url('/') ?>" class="flex items-center gap-2.5 group" data-cursor>
                <span class="logo-tile inline-flex items-center justify-center w-10 h-10 rounded-xl text-white font-display font-medium text-base tracking-tighter"
                      style="background: linear-gradient(135deg, #8A8AFF 0%, #5B5EFF 50%, #4B47E6 100%); box-shadow: 0 10px 28px -6px rgba(91,94,255,0.55), inset 0 1px 0 rgba(255,255,255,0.5), inset 0 -1px 0 rgba(0,0,0,0.2), 0 0 0 1px rgba(91,94,255,0.4);">
                    K
                    <span class="absolute -inset-px rounded-xl opacity-0 group-hover:opacity-100 transition-opacity"
                          style="background: radial-gradient(60% 60% at 50% 0%, rgba(255,255,255,0.55), transparent 70%); z-index: 3;"></span>
                </span>
                <span class="leading-none">
                    <span class="block font-display font-medium text-[17px] tracking-tightest text-chalk">KYROS</span>
                    <span class="block text-[9px] tracking-[0.32em] text-chalk-quiet uppercase mt-0.5 font-medium">Solutions</span>
                </span>
            </a>

            <nav class="hidden lg:flex items-center">
                <div class="segmented">
                    <?php
                    $links = [
                        ['/', 'Inicio'],
                        ['/services', 'Servicios'],
                        ['/about', 'Nosotros'],
                        ['/contact', 'Contacto'],
                    ];
                    foreach ($links as [$path, $label]):
                        $isActive = is_active($path);
                    ?>
                        <a href="<?= url($path) ?>"
                           data-active="<?= $isActive ? 'true' : 'false' ?>"
                           class="nav-pill-link px-4 py-1.5 rounded-full text-[13px] font-medium tracking-tight <?= $isActive ? '' : 'text-chalk/70' ?>"><?= e($label) ?></a>
                    <?php endforeach; ?>
                </div>
            </nav>

            <div class="flex items-center gap-2.5">
                <a href="<?= url('/contact') ?>" class="hidden sm:inline-flex btn-ember text-[13px] py-2.5 px-5 magnetic">
                    Iniciar proyecto
                    <svg class="w-3.5 h-3.5 arrow-ic" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-5-5l5 5-5 5"/>
                    </svg>
                </a>

                <button id="nav-toggle" type="button" aria-controls="nav-mobile" aria-expanded="false"
                        class="lg:hidden w-10 h-10 rounded-xl flex items-center justify-center text-chalk transition liquid-glass-light"
                        style="border: 1px solid rgba(255,255,255,0.12);">
                    <span class="sr-only">Abrir menú</span>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <div id="nav-mobile" class="hidden lg:hidden border-t border-white/5 liquid-glass-heavy" style="border-radius: 0;">
            <nav class="container py-6 flex flex-col gap-1.5">
                <?php foreach ($links as [$path, $label]):
                    $isActive = is_active($path);
                ?>
                    <a href="<?= url($path) ?>"
                       class="px-4 py-3.5 rounded-2xl text-[15px] font-medium transition-colors <?= $isActive ? 'bg-chalk text-void' : 'text-chalk/80 hover:bg-white/5 hover:text-chalk' ?>"><?= e($label) ?></a>
                <?php endforeach; ?>
                <a href="<?= url('/contact') ?>" class="btn-ember mt-3 w-full text-[15px] py-3.5">Iniciar proyecto</a>
            </nav>
        </div>
    </div>
</header>

<div aria-hidden="true" class="h-[76px]"></div>
