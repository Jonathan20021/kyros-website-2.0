<?php
$pageKey       = $meta['page_key']    ?? 'home';
$ogImage       = $meta['og_image']    ?? url('assets/img/og-default.jpg');
$canonical     = $meta['canonical']   ?? url(current_path());
$title         = $meta['title']       ?? 'KYROS Solutions';
$description   = $meta['description'] ?? 'Soluciones tecnológicas, seguras e inteligentes para empresas modernas.';
$bodyClass     = $meta['body_class']  ?? '';

$homeFaqs = [
    ['¿Cuánto tarda un proyecto típico?', 'Depende del alcance, pero un MVP suele tomar 8 a 12 semanas. Te entregamos un cronograma detallado tras la sesión de descubrimiento (gratuita).'],
    ['¿Trabajan con startups y empresas pequeñas?', 'Sí. Tenemos planes flexibles diseñados para equipos en crecimiento, con la posibilidad de escalar conforme tu negocio madura.'],
    ['¿Qué sucede después del lanzamiento?', 'Ofrecemos planes de mantenimiento y soporte 24/7 con SLA, además de mejoras continuas y nuevas features según tu roadmap.'],
    ['¿Cómo manejan la seguridad y los datos?', 'Trabajamos con buenas prácticas (OWASP, ISO 27001), cifrado en tránsito y reposo, control de accesos por rol y auditorías periódicas.'],
    ['¿Pueden modernizar un sistema existente?', 'Absolutamente. Hacemos auditorías técnicas y migraciones progresivas hacia arquitecturas modernas sin interrumpir tu operación.'],
    ['¿Trabajan de forma remota o presencial?', 'Operamos 100% remoto cubriendo Latinoamérica, con visitas on-site puntuales para clientes en República Dominicana.'],
];
?>
<!DOCTYPE html>
<html lang="es-DO">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="color-scheme" content="light">
    <meta name="theme-color" content="#FBFBFA">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="x-ua-compatible" content="IE=edge">

    <title><?= e($title) ?></title>
    <meta name="description" content="<?= e($description) ?>">
    <meta name="author" content="KYROS Solutions">
    <meta name="publisher" content="KYROS Solutions">
    <meta name="application-name" content="KYROS Solutions">
    <meta name="apple-mobile-web-app-title" content="KYROS">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="rating" content="general">
    <meta name="distribution" content="global">
    <meta name="keywords" content="desarrollo de software, ciberseguridad, infraestructura de redes, soporte técnico 24/7, software a medida, SaaS, pentesting, helpdesk, KYROS Solutions, República Dominicana, Latinoamérica">

    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="googlebot" content="index, follow">

    <link rel="canonical" href="<?= e($canonical) ?>">
    <link rel="alternate" hreflang="es" href="<?= e(url(current_path())) ?>">
    <link rel="alternate" hreflang="es-DO" href="<?= e(url(current_path())) ?>">
    <link rel="alternate" hreflang="x-default" href="<?= e(url(current_path())) ?>">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="KYROS Solutions">
    <meta property="og:locale" content="es_DO">
    <meta property="og:locale:alternate" content="es_ES">
    <meta property="og:locale:alternate" content="en_US">
    <meta property="og:url" content="<?= e($canonical) ?>">
    <meta property="og:title" content="<?= e($title) ?>">
    <meta property="og:description" content="<?= e($description) ?>">
    <meta property="og:image" content="<?= e($ogImage) ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="KYROS Solutions · Tecnología que funciona como debe">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@kyrossolutions">
    <meta name="twitter:creator" content="@kyrossolutions">
    <meta name="twitter:title" content="<?= e($title) ?>">
    <meta name="twitter:description" content="<?= e($description) ?>">
    <meta name="twitter:image" content="<?= e($ogImage) ?>">
    <meta name="twitter:image:alt" content="KYROS Solutions">

    <!-- Geo -->
    <meta name="geo.region" content="DO">
    <meta name="geo.placename" content="Santo Domingo">
    <meta name="geo.position" content="18.4861;-69.9312">
    <meta name="ICBM" content="18.4861, -69.9312">

    <!-- Favicons -->
    <link rel="icon" type="image/svg+xml" href="<?= asset('img/favicon.svg') ?>">
    <link rel="mask-icon" href="<?= asset('img/favicon.svg') ?>" color="#4F46E5">
    <link rel="apple-touch-icon" href="<?= asset('img/favicon.svg') ?>">

    <!-- Performance hints -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="dns-prefetch" href="https://unpkg.com">

    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&family=Instrument+Serif:ital@0;1&family=Geist+Mono:wght@400;500&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&family=Instrument+Serif:ital@0;1&family=Geist+Mono:wght@400;500&display=swap" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&family=Instrument+Serif:ital@0;1&family=Geist+Mono:wght@400;500&display=swap"></noscript>

    <link rel="stylesheet" href="<?= asset('css/app.css') ?>">

    <!-- Structured Data (rich JSON-LD for SEO) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "Organization",
          "@id": "<?= e(url('/#organization')) ?>",
          "name": "KYROS Solutions",
          "alternateName": ["KYROS", "Kyros RD"],
          "url": "<?= e(url('/')) ?>",
          "logo": {
            "@type": "ImageObject",
            "url": "<?= e(asset('img/logo.png')) ?>",
            "width": 500,
            "height": 500
          },
          "image": "<?= e($ogImage) ?>",
          "description": "Desarrollo de software a medida, ciberseguridad avanzada, soporte IT 24/7 e infraestructura de redes para empresas modernas en Latinoamérica.",
          "email": "info@kyrosrd.com",
          "telephone": "+1-849-502-4061",
          "foundingDate": "2016",
          "areaServed": [
            {"@type": "Place", "name": "Latin America"},
            {"@type": "Country", "name": "Dominican Republic"}
          ],
          "address": {
            "@type": "PostalAddress",
            "addressLocality": "Santo Domingo",
            "addressRegion": "Distrito Nacional",
            "addressCountry": "DO"
          },
          "geo": {"@type": "GeoCoordinates", "latitude": 18.4861, "longitude": -69.9312},
          "sameAs": [
            "https://www.linkedin.com/company/kyrossolutions",
            "https://www.instagram.com/kyrossolutions"
          ],
          "contactPoint": [{
            "@type": "ContactPoint",
            "telephone": "+1-849-502-4061",
            "contactType": "customer service",
            "areaServed": ["DO", "MX", "CO", "AR", "US"],
            "availableLanguage": ["es", "en"]
          }]
        },
        {
          "@type": "WebSite",
          "@id": "<?= e(url('/#website')) ?>",
          "url": "<?= e(url('/')) ?>",
          "name": "KYROS Solutions",
          "description": "<?= e($description) ?>",
          "publisher": {"@id": "<?= e(url('/#organization')) ?>"},
          "inLanguage": "es-DO",
          "potentialAction": {
            "@type": "SearchAction",
            "target": {"@type": "EntryPoint", "urlTemplate": "<?= e(url('/services?q={search_term_string}')) ?>"},
            "query-input": "required name=search_term_string"
          }
        },
        {
          "@type": "WebPage",
          "@id": "<?= e($canonical) ?>#webpage",
          "url": "<?= e($canonical) ?>",
          "name": "<?= e($title) ?>",
          "description": "<?= e($description) ?>",
          "inLanguage": "es-DO",
          "isPartOf": {"@id": "<?= e(url('/#website')) ?>"},
          "about": {"@id": "<?= e(url('/#organization')) ?>"}
        }
        <?php if ($pageKey === 'home'): ?>
        ,
        {
          "@type": "ProfessionalService",
          "@id": "<?= e(url('/#service')) ?>",
          "name": "KYROS Solutions",
          "image": "<?= e($ogImage) ?>",
          "telephone": "+1-849-502-4061",
          "url": "<?= e(url('/')) ?>",
          "priceRange": "$$",
          "address": {"@type": "PostalAddress", "addressLocality": "Santo Domingo", "addressCountry": "DO"},
          "aggregateRating": {"@type": "AggregateRating", "ratingValue": "4.9", "reviewCount": "60", "bestRating": "5"},
          "hasOfferCatalog": {
            "@type": "OfferCatalog",
            "name": "Servicios KYROS",
            "itemListElement": [
              {"@type": "Offer", "itemOffered": {"@type": "Service", "name": "Desarrollo de software a medida", "url": "<?= e(url('/services/software-development')) ?>"}},
              {"@type": "Offer", "itemOffered": {"@type": "Service", "name": "Ciberseguridad avanzada", "url": "<?= e(url('/services/cybersecurity')) ?>"}},
              {"@type": "Offer", "itemOffered": {"@type": "Service", "name": "Soporte técnico 24/7", "url": "<?= e(url('/services/technical-support')) ?>"}},
              {"@type": "Offer", "itemOffered": {"@type": "Service", "name": "Infraestructura de redes", "url": "<?= e(url('/services/network-infrastructure')) ?>"}}
            ]
          }
        },
        {
          "@type": "FAQPage",
          "@id": "<?= e(url('/#faq')) ?>",
          "mainEntity": [
            <?php foreach ($homeFaqs as $i => [$q, $a]): ?>
            {
              "@type": "Question",
              "name": <?= json_encode($q, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>,
              "acceptedAnswer": {"@type": "Answer", "text": <?= json_encode($a, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>}
            }<?= $i < count($homeFaqs) - 1 ? ',' : '' ?>
            <?php endforeach; ?>
          ]
        }
        <?php endif; ?>
      ]
    }
    </script>

    <!-- Lenis smooth scroll (lightweight, ~10KB) -->
    <script defer src="https://unpkg.com/lenis@1.1.13/dist/lenis.min.js"></script>
</head>
<body class="<?= e($bodyClass) ?> bg-void text-chalk min-h-screen flex flex-col antialiased">

    <div id="scroll-progress" class="scroll-progress" aria-hidden="true"></div>

    <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-[100] focus:px-4 focus:py-2 focus:rounded-lg focus:bg-indigo-600 focus:text-white">Saltar al contenido</a>

    <?php partial('header'); ?>

    <main id="main" class="flex-grow relative z-10">
        <?= $content ?>
    </main>

    <?php partial('footer'); ?>

    <!-- Floating contact widget -->
    <div class="float-bubble" data-bubble>
        <div class="float-bubble__panel" role="dialog" aria-label="Contacto rápido">
            <div class="flex items-center gap-3 px-3 pt-2 pb-3 border-b border-stone-200">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500" style="box-shadow: 0 0 0 3px rgba(16,185,129,0.16);"></span>
                <div class="leading-tight">
                    <div class="font-medium text-[14px] text-chalk">Equipo disponible</div>
                    <div class="text-[12px] text-chalk-muted">Respuesta promedio &lt; 5 min</div>
                </div>
            </div>
            <a href="https://wa.me/18495024061" target="_blank" rel="noopener" class="float-bubble__row">
                <span class="w-10 h-10 rounded-full flex items-center justify-center" style="background:#25D366;">
                    <svg class="w-5 h-5" fill="#FFF" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448L.057 24z"/></svg>
                </span>
                <div class="leading-tight">
                    <div class="font-medium text-[14px] text-chalk">WhatsApp directo</div>
                    <div class="text-[12px] text-chalk-muted">+1 849 502 4061</div>
                </div>
            </a>
            <a href="mailto:info@kyrosrd.com" class="float-bubble__row">
                <span class="icon-chip" style="width:40px;height:40px;border-radius:10px;"><?= icon('mail', 'w-5 h-5') ?></span>
                <div class="leading-tight">
                    <div class="font-medium text-[14px] text-chalk">Email</div>
                    <div class="text-[12px] text-chalk-muted">info@kyrosrd.com</div>
                </div>
            </a>
            <a href="<?= url('/contact') ?>" class="float-bubble__row">
                <span class="icon-chip icon-chip-violet" style="width:40px;height:40px;border-radius:10px;"><?= icon('message', 'w-5 h-5') ?></span>
                <div class="leading-tight">
                    <div class="font-medium text-[14px] text-chalk">Formulario completo</div>
                    <div class="text-[12px] text-chalk-muted">Te respondemos en 24 h</div>
                </div>
            </a>
        </div>
        <button type="button" class="float-bubble__main" aria-label="Abrir contacto rápido" data-bubble-toggle>
            <svg class="w-6 h-6" data-bubble-icon-open fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
            <svg class="w-6 h-6 absolute opacity-0" data-bubble-icon-close fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><line x1="18" y1="6" x2="6" y2="18" stroke-linecap="round"/><line x1="6" y1="6" x2="18" y2="18" stroke-linecap="round"/></svg>
        </button>
    </div>

    <script>
        // ─── Mobile nav (slide-up sheet) ───
        (() => {
            const btn  = document.getElementById('nav-toggle');
            const sheet = document.getElementById('mobile-sheet');
            const iconOpen = document.getElementById('nav-icon-open');
            const iconClose = document.getElementById('nav-icon-close');
            if (!btn || !sheet) return;
            const setOpen = (v) => {
                sheet.classList.toggle('is-open', v);
                document.body.classList.toggle('overflow-hidden', v);
                sheet.setAttribute('aria-hidden', String(!v));
                if (iconOpen)  iconOpen.classList.toggle('hidden', v);
                if (iconClose) iconClose.classList.toggle('hidden', !v);
            };
            btn.addEventListener('click', () => setOpen(!sheet.classList.contains('is-open')));
            sheet.querySelectorAll('[data-sheet-close], a').forEach(el => {
                el.addEventListener('click', () => setOpen(false));
            });
            document.addEventListener('keydown', (e) => { if (e.key === 'Escape') setOpen(false); });
        })();

        // ─── Sticky header shadow + scroll progress bar ───
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
            const onScroll = () => { if (!ticking) { requestAnimationFrame(run); ticking = true; } };
            run();
            window.addEventListener('scroll', onScroll, { passive: true });
            window.addEventListener('resize', onScroll);
        })();

        // ─── FAQ accordion ───
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

        // ─── Spotlight cursor on cards (desktop only) ───
        (() => {
            const els = document.querySelectorAll('.spotlight');
            if (!els.length || matchMedia('(pointer:coarse)').matches) return;
            els.forEach(el => {
                el.addEventListener('pointermove', (e) => {
                    const r = el.getBoundingClientRect();
                    el.style.setProperty('--mx', (e.clientX - r.left) + 'px');
                    el.style.setProperty('--my', (e.clientY - r.top)  + 'px');
                });
            });
        })();

        // ─── Magnetic buttons ───
        (() => {
            const els = document.querySelectorAll('.magnetic');
            if (!els.length || matchMedia('(pointer:coarse)').matches) return;
            els.forEach(el => {
                el.addEventListener('pointermove', (e) => {
                    const r = el.getBoundingClientRect();
                    const x = e.clientX - (r.left + r.width / 2);
                    const y = e.clientY - (r.top  + r.height / 2);
                    el.style.transform = `translate3d(${x * 0.10}px, ${y * 0.12}px, 0)`;
                });
                el.addEventListener('pointerleave', () => { el.style.transform = 'translate3d(0,0,0)'; });
            });
        })();

        // ─── 3D Tilt on .tilt cards ───
        (() => {
            const els = document.querySelectorAll('.tilt');
            if (!els.length || matchMedia('(pointer:coarse)').matches) return;
            els.forEach(el => {
                const target = el.querySelector('.tilt-target') || el;
                el.addEventListener('pointermove', (e) => {
                    const r = el.getBoundingClientRect();
                    const dx = (e.clientX - (r.left + r.width / 2)) / (r.width / 2);
                    const dy = (e.clientY - (r.top + r.height / 2)) / (r.height / 2);
                    target.style.setProperty('--rx', (dx * 3.5).toFixed(2) + 'deg');
                    target.style.setProperty('--ry', (-dy * 3.5).toFixed(2) + 'deg');
                });
                el.addEventListener('pointerleave', () => {
                    target.style.setProperty('--rx', '0deg');
                    target.style.setProperty('--ry', '0deg');
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
                const dur = 1500;
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
                    if (en.isIntersecting) { animate(en.target); io.unobserve(en.target); }
                });
            }, { threshold: 0.5 });
            counters.forEach(c => io.observe(c));
        })();

        // ─── Section dot navigation (xl+ only — CSS hides it below 1380px) ───
        (() => {
            const nav = document.querySelector('.section-nav');
            if (!nav) return;
            if (window.innerWidth < 1380) return; // skip scroll handler when nav is hidden
            const dots = nav.querySelectorAll('.section-nav__dot');
            const sections = Array.from(dots).map(d => document.querySelector(d.getAttribute('href'))).filter(Boolean);
            let ticking = false;
            const update = () => {
                if (ticking) return;
                ticking = true;
                requestAnimationFrame(() => {
                    const y = window.scrollY + window.innerHeight * 0.35;
                    let active = 0;
                    sections.forEach((s, i) => { if (s.offsetTop <= y) active = i; });
                    dots.forEach((d, i) => d.classList.toggle('is-active', i === active));
                    ticking = false;
                });
            };
            update();
            window.addEventListener('scroll', update, { passive: true });
            window.addEventListener('resize', update);
        })();

        // ─── Live clock (updates every second to match Axion behavior) ───
        (() => {
            const els = document.querySelectorAll('#live-clock, #live-clock-mobile, #cta-clock');
            if (!els.length) return;
            const fmt = () => new Date().toLocaleTimeString('es-DO', { hour:'2-digit', minute:'2-digit', hour12:false, timeZone:'America/Santo_Domingo' });
            const update = () => { const v = fmt(); els.forEach(el => el.textContent = v); };
            update();
            setInterval(update, 1000);
        })();

        // ─── Floating bubble open/close ───
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
            };
            btn.addEventListener('click', (e) => { e.stopPropagation(); setOpen(!root.classList.contains('is-open')); });
            document.addEventListener('click', (e) => { if (!root.contains(e.target)) setOpen(false); });
            document.addEventListener('keydown', (e) => { if (e.key === 'Escape') setOpen(false); });
        })();
    </script>

    <!-- Lenis smooth scroll + GSAP scroll-tied accents (loaded after DOM, deferred-safe) -->
    <script src="<?= asset('js/kyros-ultra.js') ?>" defer></script>
</body>
</html>
