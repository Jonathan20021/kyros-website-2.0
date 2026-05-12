<!DOCTYPE html>
<html lang="es" class="scroll-smooth dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#050508">

    <title><?= e($meta['title']) ?></title>
    <meta name="description" content="<?= e($meta['description']) ?>">
    <meta name="author" content="KYROS Solutions">
    <link rel="canonical" href="<?= e($meta['canonical']) ?>">

    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= e($meta['canonical']) ?>">
    <meta property="og:title" content="<?= e($meta['title']) ?>">
    <meta property="og:description" content="<?= e($meta['description']) ?>">
    <meta property="og:image" content="<?= e($meta['og_image']) ?>">
    <meta property="og:site_name" content="KYROS Solutions">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($meta['title']) ?>">
    <meta name="twitter:description" content="<?= e($meta['description']) ?>">
    <meta name="twitter:image" content="<?= e($meta['og_image']) ?>">

    <link rel="icon" type="image/svg+xml" href="<?= asset('img/favicon.svg') ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&family=Instrument+Serif:ital@0;1&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= asset('css/app.css') ?>">

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "KYROS Solutions",
      "url": "https://kyrosrd.com",
      "logo": "<?= e(asset('img/logo.png')) ?>",
      "email": "info@kyrosrd.com",
      "telephone": "+1-849-502-4061",
      "areaServed": "Latin America",
      "sameAs": ["https://www.linkedin.com/company/kyrossolutions"]
    }
    </script>
</head>
<body class="<?= e($meta['body_class']) ?> bg-void text-chalk min-h-screen flex flex-col antialiased">

    <div id="scroll-progress" class="scroll-progress" aria-hidden="true"></div>
    <div id="cursor" class="cursor-dot" aria-hidden="true"></div>

    <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-[100] focus:px-4 focus:py-2 focus:rounded-lg focus:bg-indigo-500 focus:text-white">Saltar al contenido</a>

    <?php partial('header'); ?>

    <main id="main" class="flex-grow relative z-10">
        <?= $content ?>
    </main>

    <?php partial('footer'); ?>

    <div class="float-bubble" data-bubble>
        <div class="float-bubble__panel" role="dialog" aria-label="Contacto rápido">
            <div class="flex items-center gap-3 px-4 pt-2 pb-4 border-b border-white/5">
                <span class="w-2.5 h-2.5 rounded-full bg-cyan-400" style="box-shadow: 0 0 10px #22D3EE;"></span>
                <div class="leading-tight">
                    <div class="font-display text-[14px] tracking-tight">Equipo disponible</div>
                    <div class="font-mono text-[10.5px] text-chalk/55 tracking-tight">Respuesta promedio &lt; 5 min</div>
                </div>
            </div>
            <a href="https://wa.me/18495024061" target="_blank" rel="noopener" class="float-bubble__row">
                <span class="w-10 h-10 rounded-full flex items-center justify-center" style="background:#25D366; box-shadow: 0 6px 20px -4px rgba(37,211,102,0.55);">
                    <svg class="w-5 h-5" fill="#FFF" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448L.057 24z"/></svg>
                </span>
                <div class="leading-tight">
                    <div class="font-display text-[14px] tracking-tight">WhatsApp directo</div>
                    <div class="font-mono text-[10.5px] text-chalk/55 tracking-tight">+1 849 502 4061</div>
                </div>
            </a>
            <a href="mailto:info@kyrosrd.com" class="float-bubble__row">
                <span class="icon-chip" style="width:40px;height:40px;border-radius:12px;"><?= icon('mail', 'w-5 h-5') ?></span>
                <div class="leading-tight">
                    <div class="font-display text-[14px] tracking-tight">Email</div>
                    <div class="font-mono text-[10.5px] text-chalk/55 tracking-tight">info@kyrosrd.com</div>
                </div>
            </a>
            <a href="<?= url('/contact') ?>" class="float-bubble__row">
                <span class="icon-chip icon-chip-violet" style="width:40px;height:40px;border-radius:12px;"><?= icon('message', 'w-5 h-5') ?></span>
                <div class="leading-tight">
                    <div class="font-display text-[14px] tracking-tight">Formulario detallado</div>
                    <div class="font-mono text-[10.5px] text-chalk/55 tracking-tight">Te respondemos en 24 h</div>
                </div>
            </a>
        </div>
        <button type="button" class="float-bubble__main" aria-label="Abrir contacto rápido" data-bubble-toggle>
            <svg class="w-6 h-6 transition-transform duration-300" data-bubble-icon-open fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
            <svg class="w-6 h-6 absolute opacity-0 transition-opacity duration-300" data-bubble-icon-close fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><line x1="18" y1="6" x2="6" y2="18" stroke-linecap="round"/><line x1="6" y1="6" x2="18" y2="18" stroke-linecap="round"/></svg>
        </button>
    </div>

    <script>
        // ─── Mobile nav ───
        (() => {
            const btn  = document.getElementById('nav-toggle');
            const menu = document.getElementById('nav-mobile');
            if (!btn || !menu) return;
            btn.addEventListener('click', () => {
                const open = menu.classList.toggle('hidden') === false;
                btn.setAttribute('aria-expanded', String(open));
                document.body.classList.toggle('overflow-hidden', open);
            });
            menu.querySelectorAll('a').forEach(a => a.addEventListener('click', () => {
                menu.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                btn.setAttribute('aria-expanded', 'false');
            }));
        })();

        // ─── Sticky header + scroll progress (rAF-throttled) ───
        (() => {
            const header = document.getElementById('site-header');
            const bar    = document.getElementById('scroll-progress');
            let ticking = false;
            const run = () => {
                const y = window.scrollY;
                if (header) header.classList.toggle('is-scrolled', y > 8);
                if (bar) {
                    const h = document.documentElement;
                    const scrolled = h.scrollTop / Math.max(1, (h.scrollHeight - h.clientHeight));
                    bar.style.width = (scrolled * 100).toFixed(2) + '%';
                }
                ticking = false;
            };
            const onScroll = () => {
                if (!ticking) { requestAnimationFrame(run); ticking = true; }
            };
            run();
            window.addEventListener('scroll', onScroll, { passive: true });
            window.addEventListener('resize', onScroll);
        })();

        // ─── Reveal on scroll (robust, retrigger-safe) ───
        (() => {
            const els = document.querySelectorAll('.reveal, .reveal-words, .reveal-chars');
            if (!els.length) return;

            // Cap excessive transition-delays inline so cascades stay snappy
            els.forEach(el => {
                const m = (el.getAttribute('style') || '').match(/transition-delay:\s*(\d+)/);
                if (m && parseInt(m[1], 10) > 320) {
                    el.style.transitionDelay = '320ms';
                }
            });

            // Safety net: force-reveal everything still hidden after 1.6s (no orphans)
            const failsafe = setTimeout(() => {
                els.forEach(el => el.classList.add('is-visible'));
            }, 1600);

            if (!('IntersectionObserver' in window)) {
                els.forEach(el => el.classList.add('is-visible'));
                clearTimeout(failsafe);
                return;
            }
            const io = new IntersectionObserver(entries => {
                entries.forEach(en => {
                    if (en.isIntersecting) {
                        en.target.classList.add('is-visible');
                        io.unobserve(en.target);
                    }
                });
            }, { threshold: 0.05, rootMargin: '0px 0px -40px 0px' });
            els.forEach(el => io.observe(el));

            // If user scrolls fast, immediately reveal anything already in viewport
            requestAnimationFrame(() => {
                const vh = window.innerHeight;
                els.forEach(el => {
                    const r = el.getBoundingClientRect();
                    if (r.top < vh && r.bottom > 0) el.classList.add('is-visible');
                });
            });
        })();

        // ─── Word reveal: split text into spans (capped stagger) ───
        (() => {
            document.querySelectorAll('.reveal-words').forEach(el => {
                if (el.dataset.split === '1') return;
                el.dataset.split = '1';
                const walk = (node, counter) => {
                    if (node.nodeType === 3) {
                        const frag = document.createDocumentFragment();
                        const parts = node.nodeValue.split(/(\s+)/);
                        parts.forEach(p => {
                            if (/^\s+$/.test(p)) {
                                frag.appendChild(document.createTextNode(p));
                            } else if (p.length) {
                                const span = document.createElement('span');
                                span.className = 'word';
                                // Cap stagger at index 8 so long headlines reveal in <500ms
                                span.style.setProperty('--i', Math.min(counter.n++, 8));
                                span.textContent = p;
                                frag.appendChild(span);
                            }
                        });
                        node.parentNode.replaceChild(frag, node);
                    } else if (node.nodeType === 1) {
                        Array.from(node.childNodes).forEach(c => walk(c, counter));
                    }
                };
                walk(el, { n: 0 });
            });
        })();

        // ─── Char reveal (capped) ───
        (() => {
            document.querySelectorAll('.reveal-chars').forEach(el => {
                if (el.dataset.split === '1') return;
                el.dataset.split = '1';
                const text = el.textContent;
                el.textContent = '';
                let n = 0;
                for (const ch of text) {
                    if (ch === ' ') {
                        el.appendChild(document.createTextNode(' '));
                        continue;
                    }
                    const span = document.createElement('span');
                    span.className = 'char';
                    span.style.setProperty('--i', Math.min(n++, 14));
                    span.textContent = ch;
                    el.appendChild(span);
                }
            });
        })();

        // ─── FAQ accordions ───
        (() => {
            document.querySelectorAll('[data-faq]').forEach(item => {
                const btn = item.querySelector('[data-faq-btn]');
                const body = item.querySelector('[data-faq-body]');
                const icon = item.querySelector('[data-faq-icon]');
                if (!btn || !body) return;
                btn.addEventListener('click', () => {
                    const open = item.classList.toggle('is-open');
                    body.style.maxHeight = open ? body.scrollHeight + 'px' : '0px';
                    if (icon) icon.style.transform = open ? 'rotate(180deg)' : 'rotate(0)';
                });
            });
        })();

        // ─── Spotlight cursor on cards ───
        (() => {
            const els = document.querySelectorAll('.spotlight');
            if (!els.length) return;
            els.forEach(el => {
                el.addEventListener('pointermove', (e) => {
                    const r = el.getBoundingClientRect();
                    el.style.setProperty('--mx', (e.clientX - r.left) + 'px');
                    el.style.setProperty('--my', (e.clientY - r.top)  + 'px');
                });
            });
        })();

        // ─── 3D Tilt on .tilt elements (subtler, smoother) ───
        (() => {
            const els = document.querySelectorAll('.tilt');
            if (!els.length || matchMedia('(pointer:coarse)').matches) return;
            els.forEach(el => {
                const target = el.querySelector('.tilt-target') || el;
                el.addEventListener('pointermove', (e) => {
                    const r = el.getBoundingClientRect();
                    const cx = r.left + r.width / 2;
                    const cy = r.top + r.height / 2;
                    const dx = (e.clientX - cx) / (r.width / 2);
                    const dy = (e.clientY - cy) / (r.height / 2);
                    const max = 4.5; // gentler than before
                    target.style.setProperty('--rx', (dx * max).toFixed(2) + 'deg');
                    target.style.setProperty('--ry', (-dy * max).toFixed(2) + 'deg');
                });
                el.addEventListener('pointerleave', () => {
                    target.style.setProperty('--rx', '0deg');
                    target.style.setProperty('--ry', '0deg');
                });
            });
        })();

        // ─── Stagger reveal (containers with [data-stagger]) ───
        (() => {
            const containers = document.querySelectorAll('[data-stagger]');
            if (!containers.length) return;
            const fallback = setTimeout(() => containers.forEach(c => c.classList.add('is-visible')), 1800);
            if (!('IntersectionObserver' in window)) {
                containers.forEach(c => c.classList.add('is-visible'));
                clearTimeout(fallback);
                return;
            }
            const io = new IntersectionObserver(entries => {
                entries.forEach(en => {
                    if (en.isIntersecting) {
                        en.target.classList.add('is-visible');
                        io.unobserve(en.target);
                    }
                });
            }, { threshold: 0.10, rootMargin: '0px 0px -40px 0px' });
            containers.forEach(c => io.observe(c));
        })();

        // ─── Magnetic buttons (subtle, springy reset) ───
        (() => {
            const els = document.querySelectorAll('.magnetic');
            if (!els.length || matchMedia('(pointer:coarse)').matches) return;
            els.forEach(el => {
                el.addEventListener('pointermove', (e) => {
                    const r = el.getBoundingClientRect();
                    const x = e.clientX - (r.left + r.width / 2);
                    const y = e.clientY - (r.top  + r.height / 2);
                    el.style.transform = `translate3d(${x * 0.12}px, ${y * 0.14}px, 0)`;
                });
                el.addEventListener('pointerleave', () => {
                    el.style.transform = 'translate3d(0,0,0)';
                });
            });
        })();

        // ─── Animated counters ───
        (() => {
            const counters = document.querySelectorAll('[data-counter]');
            if (!counters.length || !('IntersectionObserver' in window)) return;
            const animate = (el) => {
                const target = parseFloat(el.dataset.counter);
                const decimals = (el.dataset.counter.split('.')[1] || '').length;
                const suffix = el.dataset.suffix || '';
                const prefix = el.dataset.prefix || '';
                const dur = 1800;
                const start = performance.now();
                const tick = (now) => {
                    const p = Math.min(1, (now - start) / dur);
                    const eased = 1 - Math.pow(1 - p, 3);
                    const value = (target * eased).toFixed(decimals);
                    el.textContent = prefix + value + suffix;
                    if (p < 1) requestAnimationFrame(tick);
                };
                requestAnimationFrame(tick);
            };
            const io = new IntersectionObserver(entries => {
                entries.forEach(en => {
                    if (en.isIntersecting) {
                        animate(en.target);
                        io.unobserve(en.target);
                    }
                });
            }, { threshold: 0.5 });
            counters.forEach(c => io.observe(c));
        })();

        // ─── Parallax (data-parallax="0.15") ───
        (() => {
            const els = document.querySelectorAll('[data-parallax]');
            if (!els.length) return;
            const onScroll = () => {
                const y = window.scrollY;
                els.forEach(el => {
                    const speed = parseFloat(el.dataset.parallax) || 0.15;
                    el.style.transform = `translateY(${y * speed}px)`;
                });
            };
            onScroll();
            window.addEventListener('scroll', onScroll, { passive: true });
        })();

        // ─── Hero scroll-driven scale + fade (data-hero) ───
        (() => {
            const hero = document.querySelector('[data-hero]');
            if (!hero) return;
            // Gentler: caps opacity floor at 0.55, scale floor at 0.96 — content never disappears
            const onScroll = () => {
                const rect = hero.getBoundingClientRect();
                const p = Math.max(0, Math.min(1, -rect.top / Math.max(1, rect.height * 0.9)));
                const scale = 1 - p * 0.04;
                const opacity = 1 - p * 0.45;
                const ty = p * -20;
                hero.style.transform = `translate3d(0,${ty}px,0) scale(${scale})`;
                hero.style.opacity = String(Math.max(0.55, opacity));
            };
            onScroll();
            window.addEventListener('scroll', onScroll, { passive: true });
        })();

        // ─── Reactive aurora background (follows mouse) ───
        (() => {
            if (matchMedia('(pointer:coarse)').matches) return;
            let tx = 50, ty = 30, cx = 50, cy = 30;
            window.addEventListener('pointermove', (e) => {
                tx = (e.clientX / window.innerWidth) * 100;
                ty = (e.clientY / window.innerHeight) * 100;
            }, { passive: true });
            const tick = () => {
                cx += (tx - cx) * 0.04;
                cy += (ty - cy) * 0.04;
                document.documentElement.style.setProperty('--aurora-x', cx + '%');
                document.documentElement.style.setProperty('--aurora-y', cy + '%');
                requestAnimationFrame(tick);
            };
            tick();
        })();

        // ─── Custom cursor ───
        (() => {
            const cursor = document.getElementById('cursor');
            if (!cursor) return;
            if (matchMedia('(pointer:coarse)').matches) { cursor.style.display = 'none'; return; }
            let tx = 0, ty = 0, cx = 0, cy = 0;
            document.addEventListener('pointermove', (e) => { tx = e.clientX; ty = e.clientY; }, { passive: true });
            const tick = () => {
                cx += (tx - cx) * 0.3;
                cy += (ty - cy) * 0.3;
                cursor.style.left = cx + 'px';
                cursor.style.top  = cy + 'px';
                requestAnimationFrame(tick);
            };
            tick();
            const hoverables = 'a, button, [data-cursor], .magnetic, .spotlight, input, textarea, select, label';
            document.body.addEventListener('pointerover', (e) => {
                if (e.target.closest(hoverables)) cursor.classList.add('is-hover');
            });
            document.body.addEventListener('pointerout', (e) => {
                if (e.target.closest(hoverables)) cursor.classList.remove('is-hover');
            });
        })();

        // ─── Section dot navigation (auto-highlight active section) ───
        (() => {
            const nav = document.querySelector('.section-nav');
            if (!nav) return;
            const dots = nav.querySelectorAll('.section-nav__dot');
            const sections = Array.from(dots).map(d => document.querySelector(d.getAttribute('href'))).filter(Boolean);
            const update = () => {
                const y = window.scrollY + window.innerHeight * 0.35;
                let active = 0;
                sections.forEach((s, i) => { if (s.offsetTop <= y) active = i; });
                dots.forEach((d, i) => d.classList.toggle('is-active', i === active));
            };
            update();
            window.addEventListener('scroll', update, { passive: true });
            window.addEventListener('resize', update);
        })();

        // ─── Dashboard / sparkline animations on intersection ───
        (() => {
            const els = document.querySelectorAll('.dash-card, .sparkline');
            if (!els.length || !('IntersectionObserver' in window)) {
                els.forEach(el => el.classList.add('is-visible'));
                return;
            }
            const io = new IntersectionObserver(entries => {
                entries.forEach(en => {
                    if (en.isIntersecting) {
                        en.target.classList.add('is-visible');
                        io.unobserve(en.target);
                    }
                });
            }, { threshold: 0.3 });
            els.forEach(el => io.observe(el));
        })();

        // ─── Live clock (multiple targets) ───
        (() => {
            const els = document.querySelectorAll('#live-clock, #cta-clock');
            if (!els.length) return;
            const fmt = () => new Date().toLocaleTimeString('es-DO', { hour:'2-digit', minute:'2-digit', hour12:false, timeZone:'America/Santo_Domingo' });
            const update = () => { const v = fmt(); els.forEach(el => el.textContent = v); };
            update();
            setInterval(update, 30_000);
        })();

        // ═══════════════════════════════════════════════════════
        //  INTERACTIVE — Estimator
        // ═══════════════════════════════════════════════════════
        (() => {
            const root = document.querySelector('[data-estimator]');
            if (!root) return;
            const state = {
                services: new Set(),
                scale: 2,
                timeline: 'normal',
            };
            const scaleData = [
                { label: 'MVP simple',         priceMin: 8,  priceMax: 15,  weeksMin: 6,  weeksMax: 8,  teamMin: 2, teamMax: 3 },
                { label: 'Producto medio',     priceMin: 15, priceMax: 30,  weeksMin: 10, weeksMax: 14, teamMin: 3, teamMax: 4 },
                { label: 'Plataforma compleja',priceMin: 30, priceMax: 60,  weeksMin: 16, weeksMax: 22, teamMin: 4, teamMax: 6 },
                { label: 'Enterprise',         priceMin: 60, priceMax: 120, weeksMin: 24, weeksMax: 36, teamMin: 5, teamMax: 8 },
                { label: 'Custom · solicita cotización', priceMin: 0, priceMax: 0, weeksMin: 0, weeksMax: 0, teamMin: 0, teamMax: 0 },
            ];
            const timelineMult = { fast: 1.20, normal: 1.00, flex: 0.92 };

            const out = {
                price: root.querySelector('[data-est-output="price"]'),
                time:  root.querySelector('[data-est-output="time"]'),
                team:  root.querySelector('[data-est-output="team"]'),
            };
            const scaleLabel = root.querySelector('[data-scale-label]');
            const stepStatus = {
                1: root.querySelector('[data-step-status="1"]'),
                2: root.querySelector('[data-step-status="2"]'),
                3: root.querySelector('[data-step-status="3"]'),
            };

            const tick = (el, val) => {
                if (!el || el.textContent === val) return;
                el.textContent = val;
                el.classList.remove('est-tick');
                void el.offsetWidth;
                el.classList.add('est-tick');
            };

            const render = () => {
                const sIdx = Math.max(0, Math.min(4, state.scale - 1));
                const s = scaleData[sIdx];
                const mult = timelineMult[state.timeline] || 1;

                if (sIdx === 4) {
                    tick(out.price, 'Cotización personalizada');
                    tick(out.time, '—');
                    tick(out.team, '—');
                } else {
                    const pmin = Math.round(s.priceMin * mult);
                    const pmax = Math.round(s.priceMax * mult);
                    const wmin = Math.round(s.weeksMin * (state.timeline === 'fast' ? 0.85 : (state.timeline === 'flex' ? 1.20 : 1)));
                    const wmax = Math.round(s.weeksMax * (state.timeline === 'fast' ? 0.85 : (state.timeline === 'flex' ? 1.20 : 1)));
                    tick(out.price, `$${pmin}K — $${pmax}K`);
                    tick(out.time,  `${wmin}-${wmax} sem`);
                    tick(out.team,  s.teamMin === s.teamMax ? `${s.teamMin}` : `${s.teamMin}-${s.teamMax} personas`);
                }

                if (scaleLabel) scaleLabel.textContent = s.label;
                if (stepStatus[1]) stepStatus[1].textContent = state.services.size ? `${state.services.size} seleccionado${state.services.size === 1 ? '' : 's'}` : 'Selecciona uno';
                if (stepStatus[2]) stepStatus[2].textContent = s.label;
                if (stepStatus[3]) {
                    const tlMap = { fast: 'ASAP · alta prioridad', normal: 'Normal · 2-3 meses', flex: 'Flexible · 6+ meses' };
                    stepStatus[3].textContent = tlMap[state.timeline] || '—';
                }
            };

            // Service cards
            root.querySelectorAll('[data-est-service]').forEach(btn => {
                btn.setAttribute('data-active', 'false');
                btn.addEventListener('click', () => {
                    const v = btn.dataset.estService;
                    if (state.services.has(v)) { state.services.delete(v); btn.setAttribute('data-active', 'false'); }
                    else { state.services.add(v); btn.setAttribute('data-active', 'true'); }
                    render();
                });
            });

            // Slider
            const slider = root.querySelector('[data-est-scale]');
            const setSliderFill = () => {
                const pct = ((state.scale - 1) / 4) * 100;
                slider.style.setProperty('--est-fill', pct + '%');
            };
            if (slider) {
                slider.addEventListener('input', () => {
                    state.scale = parseInt(slider.value, 10);
                    setSliderFill();
                    render();
                });
                setSliderFill();
            }

            // Timeline chips
            root.querySelectorAll('[data-est-timeline]').forEach(btn => {
                btn.addEventListener('click', () => {
                    root.querySelectorAll('[data-est-timeline]').forEach(b => b.classList.remove('est-chip--active'));
                    btn.classList.add('est-chip--active');
                    state.timeline = btn.dataset.estTimeline;
                    render();
                });
            });

            render();
        })();

        // ═══════════════════════════════════════════════════════
        //  INTERACTIVE — Live hero dashboard
        // ═══════════════════════════════════════════════════════
        (() => {
            const feed = document.querySelector('[data-live-feed]');
            const slaEl = document.querySelector('[data-live-sla]');
            const reduce = matchMedia('(prefers-reduced-motion: reduce)').matches;

            const events = [
                ['✓', 'Deploy',  'tafer-saas.kyros.app',        'text-emerald-300'],
                ['↑', 'API',     'p95 latency · 142ms',          'text-indigo-300'],
                ['◉', 'WAF',     '17 amenazas bloqueadas',       'text-amber-300'],
                ['✓', 'CI',      'main → build #847 ok',         'text-emerald-300'],
                ['↓', 'Tickets', '4 abiertos · 12 resueltos',    'text-indigo-300'],
                ['◉', 'Backup',  'snapshot prod · 2.4 GB',       'text-violet-300'],
                ['✓', 'SSL',     'cert auto-renew · valid',      'text-emerald-300'],
                ['↑', 'CDN',     'cache hit ratio · 94.2%',      'text-cyan-300'],
                ['◉', 'Audit',   'OWASP scan completed',         'text-amber-300'],
                ['✓', 'DB',      'replica lag · 8ms',            'text-emerald-300'],
                ['→', 'Webhook', 'stripe.event · processed',     'text-indigo-300'],
                ['↑', 'Uptime',  '99.97% · 30d window',          'text-cyan-300'],
            ];

            const makeRow = (e) => {
                const div = document.createElement('div');
                div.className = 'live-log live-log--new';
                div.innerHTML = `
                    <span class="flex items-center gap-2">
                        <span class="${e[3]}">${e[0]}</span>
                        <span class="text-chalk-quiet">${e[1]}</span>
                    </span>
                    <span class="text-chalk/70 truncate ml-3">${e[2]}</span>
                `;
                return div;
            };

            if (feed) {
                // initial fill: first 3 events
                for (let i = 0; i < 3; i++) feed.appendChild(makeRow(events[i]));

                if (!reduce) {
                    let idx = 3;
                    setInterval(() => {
                        const newRow = makeRow(events[idx % events.length]);
                        const oldRow = feed.lastElementChild;
                        if (oldRow) {
                            oldRow.classList.add('live-log--out');
                            setTimeout(() => oldRow.remove(), 350);
                        }
                        feed.insertBefore(newRow, feed.firstChild);
                        idx++;
                    }, 3200);
                }
            }

            // SLA ticking (subtle fluctuation around 99.95-99.99)
            if (slaEl && !reduce) {
                let base = 99.97;
                setInterval(() => {
                    base += (Math.random() - 0.5) * 0.02;
                    base = Math.max(99.93, Math.min(99.99, base));
                    slaEl.textContent = base.toFixed(2);
                }, 2800);
            }
        })();

        // ═══════════════════════════════════════════════════════
        //  INTERACTIVE — Showcase carousel
        // ═══════════════════════════════════════════════════════
        (() => {
            const root = document.querySelector('[data-carousel]');
            if (!root) return;
            const track = root.querySelector('[data-carousel-track]');
            const prev  = root.querySelector('[data-carousel-prev]');
            const next  = root.querySelector('[data-carousel-next]');
            const dotsContainer = root.querySelector('[data-carousel-dots]');
            const slides = track.querySelectorAll('article, a');
            if (!slides.length) return;

            // build dots
            slides.forEach((_, i) => {
                const dot = document.createElement('button');
                dot.type = 'button';
                dot.className = 'carousel__dot';
                dot.setAttribute('aria-label', `Ir al caso ${i + 1}`);
                dot.dataset.idx = String(i);
                dot.addEventListener('click', () => scrollToIdx(i));
                dotsContainer.appendChild(dot);
            });
            const dots = Array.from(dotsContainer.children);

            const scrollToIdx = (i) => {
                const slide = slides[i];
                if (!slide) return;
                const slideRect = slide.getBoundingClientRect();
                const trackRect = track.getBoundingClientRect();
                const offset = slideRect.left - trackRect.left + track.scrollLeft - 24;
                track.scrollTo({ left: offset, behavior: 'smooth' });
            };

            const updateUI = () => {
                const trackRect = track.getBoundingClientRect();
                const center = trackRect.left + trackRect.width / 2;
                let activeIdx = 0, minDist = Infinity;
                slides.forEach((s, i) => {
                    const r = s.getBoundingClientRect();
                    const slideCenter = r.left + r.width / 2;
                    const d = Math.abs(slideCenter - center);
                    if (d < minDist) { minDist = d; activeIdx = i; }
                });
                dots.forEach((d, i) => d.setAttribute('data-active', String(i === activeIdx)));
                if (prev) prev.disabled = track.scrollLeft <= 4;
                if (next) next.disabled = track.scrollLeft >= track.scrollWidth - track.clientWidth - 4;
            };

            track.addEventListener('scroll', () => requestAnimationFrame(updateUI), { passive: true });
            window.addEventListener('resize', updateUI);

            // arrow buttons
            const step = () => {
                const first = slides[0];
                return first ? first.getBoundingClientRect().width + 20 : 400;
            };
            if (prev) prev.addEventListener('click', () => track.scrollBy({ left: -step(), behavior: 'smooth' }));
            if (next) next.addEventListener('click', () => track.scrollBy({ left:  step(), behavior: 'smooth' }));

            // drag to scroll (pointer events)
            let dragging = false, startX = 0, startScroll = 0;
            track.addEventListener('pointerdown', (e) => {
                if (e.pointerType === 'touch') return; // native touch scroll
                dragging = true;
                startX = e.clientX;
                startScroll = track.scrollLeft;
                track.classList.add('is-dragging');
                track.setPointerCapture(e.pointerId);
            });
            track.addEventListener('pointermove', (e) => {
                if (!dragging) return;
                track.scrollLeft = startScroll - (e.clientX - startX);
            });
            const endDrag = (e) => {
                if (!dragging) return;
                dragging = false;
                track.classList.remove('is-dragging');
                try { track.releasePointerCapture(e.pointerId); } catch (_) {}
            };
            track.addEventListener('pointerup', endDrag);
            track.addEventListener('pointercancel', endDrag);
            track.addEventListener('pointerleave', endDrag);

            // keyboard
            track.tabIndex = 0;
            track.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft')  { e.preventDefault(); track.scrollBy({ left: -step(), behavior: 'smooth' }); }
                if (e.key === 'ArrowRight') { e.preventDefault(); track.scrollBy({ left:  step(), behavior: 'smooth' }); }
            });

            updateUI();
        })();

        // ═══════════════════════════════════════════════════════
        //  INTERACTIVE — Floating contact bubble
        // ═══════════════════════════════════════════════════════
        (() => {
            const root = document.querySelector('[data-bubble]');
            if (!root) return;
            const btn  = root.querySelector('[data-bubble-toggle]');
            const open = root.querySelector('[data-bubble-icon-open]');
            const close= root.querySelector('[data-bubble-icon-close]');
            const setOpen = (v) => {
                root.classList.toggle('is-open', v);
                btn.setAttribute('aria-expanded', String(v));
                if (open)  open.style.opacity  = v ? '0' : '1';
                if (close) close.style.opacity = v ? '1' : '0';
                if (open)  open.style.transform  = v ? 'rotate(-90deg)' : 'rotate(0)';
            };
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                setOpen(!root.classList.contains('is-open'));
            });
            document.addEventListener('click', (e) => {
                if (!root.contains(e.target)) setOpen(false);
            });
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') setOpen(false);
            });
        })();

        // ═══════════════════════════════════════════════════════
        //  INTERACTIVE — Cursor spotlight on selected sections
        // ═══════════════════════════════════════════════════════
        (() => {
            if (matchMedia('(pointer:coarse)').matches) return;
            document.querySelectorAll('[data-spotlight-section]').forEach(section => {
                section.addEventListener('pointermove', (e) => {
                    const r = section.getBoundingClientRect();
                    section.style.setProperty('--sx', (e.clientX - r.left) + 'px');
                    section.style.setProperty('--sy', (e.clientY - r.top)  + 'px');
                });
            });
        })();
    </script>
</body>
</html>
