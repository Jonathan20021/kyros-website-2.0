<?php require_once base_path('views/partials/icons.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#FBFBFA">
    <meta name="robots" content="noindex, nofollow">
    <title><?= e($adminTitle ?? 'Panel') ?> · KYROS Admin</title>
    <link rel="icon" type="image/svg+xml" href="<?= asset('img/favicon.svg') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600&family=Geist+Mono:wght@400;500&display=swap">
    <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
    <meta name="view-transition" content="same-origin">
    <style>
        body { background: #FAFAFA; }
        .admin-shell { display: grid; grid-template-columns: 240px 1fr; min-height: 100vh; }
        .admin-aside {
            background: #FFFFFF;
            border-right: 1px solid rgba(17,17,17,0.06);
            padding: 20px 16px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }
        /* ── Mobile drawer ────────────────────────────────── */
        @media (max-width: 1023px) {
            .admin-shell { grid-template-columns: 1fr; }
            .admin-aside {
                position: fixed;
                top: 0; left: 0;
                width: 280px;
                max-width: 88vw;
                height: 100vh;
                z-index: 50;
                transform: translateX(-100%);
                transition: transform 0.35s cubic-bezier(0.32, 0.72, 0, 1);
                border-right: 1px solid rgba(17,17,17,0.06);
                box-shadow: 0 30px 80px rgba(0,0,0,0.15);
            }
            .admin-aside.is-mobile-open { transform: translateX(0); }
            .admin-aside-backdrop {
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.45);
                z-index: 49;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.3s ease;
            }
            .admin-aside-backdrop.is-mobile-open { opacity: 1; pointer-events: auto; }
            body.admin-drawer-open { overflow: hidden; }
        }
        .admin-logo {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 10px 18px;
            border-bottom: 1px solid rgba(17,17,17,0.06);
            margin-bottom: 16px;
        }
        .admin-logo__mark {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: #111;
            color: #fff;
            display: inline-flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 11px;
        }
        .admin-section-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            color: var(--ink-muted);
            padding: 16px 12px 6px;
            font-weight: 600;
        }
        .admin-link {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px;
            border-radius: 10px;
            color: var(--ink-soft);
            font-size: 14px;
            font-weight: 500;
            transition: background .2s, color .2s;
        }
        .admin-link:hover { background: #F5F5F5; color: var(--ink); }
        .admin-link.is-active {
            background: #111;
            color: #fff;
        }
        .admin-link svg { width: 16px; height: 16px; flex-shrink: 0; }
        .admin-main {
            padding: 0;
            min-width: 0;
        }
        .admin-topbar {
            padding: 18px 28px;
            background: #FFFFFF;
            border-bottom: 1px solid rgba(17,17,17,0.06);
            display: flex; align-items: center; justify-content: space-between;
            gap: 12px;
            position: sticky; top: 0; z-index: 10;
            backdrop-filter: blur(12px);
            flex-wrap: wrap;
        }
        .admin-content {
            padding: 28px;
            max-width: 1280px;
        }
        @media (max-width: 640px) {
            .admin-topbar {
                padding: 12px 16px;
                gap: 10px;
            }
            .admin-topbar > div:first-child { flex: 1; min-width: 0; }
            .admin-content { padding: 16px; }
            .admin-card { padding: 16px; border-radius: 14px; }
        }

        /* ── Table wrapping (horizontal scroll on narrow screens) ── */
        .admin-card.p-0 { padding: 0 !important; }
        .table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .admin-table { min-width: 640px; width: 100%; }
        @media (max-width: 640px) {
            .admin-table th, .admin-table td { padding: 10px 12px; font-size: 13px; }
        }

        /* ── Word breaks for long URLs/emails ── */
        .admin-table td a, .admin-table td code { word-break: break-word; }

        /* ── Filter pills wrap nicely ── */
        @media (max-width: 640px) {
            .filter-pill { padding: 5px 10px; font-size: 12px; }
        }
        .admin-card {
            background: #FFFFFF;
            border: 1px solid rgba(17,17,17,0.06);
            border-radius: 16px;
            padding: 24px;
        }
        .admin-input, .admin-textarea, .admin-select {
            width: 100%;
            background: #FFFFFF;
            border: 1px solid rgba(17,17,17,0.12);
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 14px;
            color: var(--ink);
            font-family: inherit;
            transition: border-color .2s, box-shadow .2s;
        }
        .admin-input:focus, .admin-textarea:focus, .admin-select:focus {
            outline: none;
            border-color: var(--orange);
            box-shadow: 0 0 0 3px rgba(242,101,34,0.16);
        }
        .admin-textarea { min-height: 120px; resize: vertical; }
        .admin-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--ink-soft);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }
        .admin-help { font-size: 12px; color: var(--ink-muted); margin-top: 6px; }
        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }
        .admin-table th, .admin-table td {
            text-align: left;
            padding: 12px 14px;
            border-bottom: 1px solid rgba(17,17,17,0.06);
            font-size: 14px;
        }
        .admin-table th {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.10em;
            color: var(--ink-muted);
            font-weight: 600;
            background: #FAFAFA;
        }
        .admin-table tr:hover td { background: #FAFAFA; }
        .badge-status {
            display: inline-flex;
            padding: 3px 9px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }
        .badge-status--published { background: #ECFDF5; color: #047857; border: 1px solid #A7F3D0; }
        .badge-status--draft     { background: #FEF3C7; color: #92400E; border: 1px solid #FDE68A; }
        .admin-flash {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .admin-flash--success { background: #ECFDF5; color: #047857; border: 1px solid #A7F3D0; }
        .admin-flash--error   { background: #FEF2F2; color: #B91C1C; border: 1px solid #FECACA; }
        .admin-mobile-toggle {
            display: none;
            width: 40px; height: 40px;
            border-radius: 10px;
            background: #111;
            color: #fff;
            align-items: center; justify-content: center;
        }
        @media (max-width: 1023px) { .admin-mobile-toggle { display: inline-flex; } }
        .file-drop {
            border: 2px dashed rgba(17,17,17,0.16);
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            background: #FAFAFA;
            cursor: pointer;
            transition: border-color .2s, background .2s;
        }
        .file-drop:hover { border-color: var(--orange); background: #FFF; }
        .file-drop__preview {
            max-height: 200px;
            margin: 12px auto 0;
            border-radius: 8px;
        }
    </style>
</head>
<body class="bg-[#FAFAFA] text-ink antialiased">
<div class="admin-aside-backdrop" id="admin-aside-backdrop" aria-hidden="true"></div>
<div class="admin-shell">

    <?php $u = auth_user(); ?>
    <aside class="admin-aside" id="admin-aside">
        <a href="<?= url('/admin') ?>" class="admin-logo" style="padding-top: 0; padding-bottom: 14px; gap: 6px;">
            <img src="<?= asset('img/logo.png') ?>" alt="KYROS Solutions" style="height: 60px; width: auto; max-width: 170px; object-fit: contain; margin: -10px 0;">
            <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-[0.16em] self-center" style="background: var(--orange); color: #fff;">Admin</span>
        </a>

        <?php
        $here = current_path();
        $items = [
            'GESTIÓN' => [
                ['/admin',            'Dashboard',  'sparkles'],
                ['/admin/projects',   'Proyectos',  'briefcase'],
            ],
            'BLOG' => [
                ['/admin/posts',      'Posts',       'message'],
                ['/admin/categories', 'Categorías',  'layers'],
            ],
            'AJUSTES' => [
                ['/admin/settings',   'Configuración', 'cpu'],
            ],
        ];
        foreach ($items as $section => $links):
        ?>
            <div class="admin-section-label"><?= e($section) ?></div>
            <?php foreach ($links as [$path, $label, $ic]):
                $active = $here === $path || ($path !== '/admin' && str_starts_with($here, $path));
            ?>
                <a href="<?= url($path) ?>" class="admin-link <?= $active ? 'is-active' : '' ?>">
                    <?= icon($ic, 'w-4 h-4') ?>
                    <?= e($label) ?>
                </a>
            <?php endforeach; ?>
        <?php endforeach; ?>

        <div class="mt-auto pt-4 border-t border-[rgba(17,17,17,0.06)]">
            <a href="<?= url('/') ?>" target="_blank" class="admin-link">
                <?= icon('globe', 'w-4 h-4') ?> Ver sitio público
            </a>
            <a href="<?= url('/admin/logout') ?>" class="admin-link">
                <?= icon('x', 'w-4 h-4') ?> Cerrar sesión
            </a>
        </div>
    </aside>

    <div class="admin-main">
        <div class="admin-topbar">
            <div class="flex items-center gap-3">
                <button class="admin-mobile-toggle" id="admin-mobile-toggle" aria-label="Abrir menú">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="4" y1="8" x2="20" y2="8"/><line x1="4" y1="16" x2="20" y2="16"/></svg>
                </button>
                <div class="leading-tight">
                    <div class="text-[16px] font-medium" style="color: var(--ink);"><?= e($adminTitle ?? 'Dashboard') ?></div>
                    <?php if (!empty($adminSubtitle)): ?>
                        <div class="text-[12px]" style="color: var(--ink-muted);"><?= e($adminSubtitle) ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <?php if (!empty($adminAction)): ?>
                    <?= $adminAction ?>
                <?php endif; ?>
                <div class="hidden sm:flex items-center gap-2 text-[13px]" style="color: var(--ink-soft);">
                    <span class="w-8 h-8 rounded-full bg-[#F26522] text-white flex items-center justify-center text-[12px] font-semibold">
                        <?= e(strtoupper(substr($u['name'] ?? 'A', 0, 1))) ?>
                    </span>
                    <span class="hidden md:inline"><?= e($u['name'] ?? 'Admin') ?></span>
                </div>
            </div>
        </div>

        <div class="admin-content">
            <?php
            $success = flash('success');
            $error = flash('error');
            if ($success): ?>
                <div class="admin-flash admin-flash--success">✓ <?= e($success) ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="admin-flash admin-flash--error">✕ <?= e($error) ?></div>
            <?php endif; ?>

            <?= $content ?>
        </div>
    </div>
</div>

<!-- ── Reusable delete confirm modal (driven by data-confirm-delete attrs) ── -->
<div class="modal-overlay" id="modal-confirm-delete" data-modal>
    <div class="modal-card modal-card--danger" role="dialog" aria-labelledby="m-cd-title">
        <div class="modal-card__header">
            <div>
                <div class="modal-card__title" id="m-cd-title">¿Confirmar eliminación?</div>
                <div class="modal-card__subtitle" id="m-cd-subtitle">Esta acción no se puede deshacer.</div>
            </div>
            <button type="button" class="modal-card__close" data-modal-close aria-label="Cerrar">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="6" y1="6" x2="18" y2="18"/><line x1="18" y1="6" x2="6" y2="18"/></svg>
            </button>
        </div>
        <div class="modal-card__body">
            <div class="flex items-start gap-4">
                <span class="modal-confirm-icon">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                </span>
                <div class="flex-1">
                    <p class="text-[14px] mb-2" style="color: var(--ink);">Vas a eliminar:</p>
                    <p class="font-semibold text-[15px]" id="m-cd-item" style="color: var(--ink);">—</p>
                </div>
            </div>
        </div>
        <div class="modal-card__footer">
            <button type="button" class="btn-admin-ghost" data-modal-close>Cancelar</button>
            <form id="m-cd-form" method="POST" action="" class="inline">
                <?= csrf_field() ?>
                <button type="submit" class="btn-admin-danger">Eliminar</button>
            </form>
        </div>
    </div>
</div>

<!-- Fluid layer: Lenis smooth scroll + reveal animations + image fade-in -->
<script defer src="https://unpkg.com/lenis@1.1.13/dist/lenis.min.js"></script>
<script>
    /* ───────────────────────────────────────────────────────
       MODAL FRAMEWORK (reusable, accessible)
       Open:   any element with data-modal-open="modal-id"
       Close:  data-modal-close, click on overlay, or Escape
       ─────────────────────────────────────────────────────── */
    window.Modal = (() => {
        const openModal = (id, ctx = {}) => {
            const el = typeof id === 'string' ? document.getElementById(id) : id;
            if (!el) return;
            // Allow callers to populate via ctx { fields: { 'm-cd-item': 'Foo', 'm-cd-form-action': '/x' }}
            if (ctx.title)    el.querySelector('[data-modal-title]')?.replaceChildren(document.createTextNode(ctx.title));
            if (ctx.subtitle) el.querySelector('[data-modal-subtitle]')?.replaceChildren(document.createTextNode(ctx.subtitle));
            Object.entries(ctx.fields || {}).forEach(([k, v]) => {
                const t = el.querySelector('#' + k);
                if (!t) return;
                if (t.tagName === 'FORM')      t.setAttribute('action', v);
                else if ('value' in t)         t.value = v;
                else                           t.textContent = v;
            });
            document.body.classList.add('modal-open');
            el.classList.add('is-open');
            // focus first focusable
            setTimeout(() => {
                const focusable = el.querySelector('input, textarea, button:not([data-modal-close])');
                if (focusable) focusable.focus();
            }, 60);
        };
        const closeModal = (el) => {
            if (!el) return;
            el.classList.remove('is-open');
            // remove modal-open only if no other modals are open
            if (!document.querySelector('.modal-overlay.is-open')) {
                document.body.classList.remove('modal-open');
            }
        };
        // Event delegation
        document.addEventListener('click', (e) => {
            const trigger = e.target.closest('[data-modal-open]');
            if (trigger) {
                e.preventDefault();
                const id = trigger.dataset.modalOpen;
                const ctx = {};
                // Read ctx fields from data-modal-* attributes (kebab → field id "m-cd-item" stays as is)
                for (const [key, value] of Object.entries(trigger.dataset)) {
                    if (key.startsWith('modalField')) {
                        const fieldId = key.replace('modalField', '').replace(/^([A-Z])/, m => m.toLowerCase());
                        ctx.fields = ctx.fields || {};
                        ctx.fields[fieldId] = value;
                    }
                }
                // Also support direct attributes for the built-in delete modal
                if (trigger.dataset.confirmTitle)  ctx.fields = { ...(ctx.fields||{}), 'm-cd-item': trigger.dataset.confirmTitle };
                if (trigger.dataset.confirmAction) ctx.fields = { ...(ctx.fields||{}), 'm-cd-form': trigger.dataset.confirmAction };
                openModal(id, ctx);
                return;
            }
            const closer = e.target.closest('[data-modal-close]');
            if (closer) {
                closeModal(closer.closest('.modal-overlay'));
                return;
            }
            // Click on overlay (not card)
            if (e.target.classList.contains('modal-overlay')) {
                closeModal(e.target);
            }
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal-overlay.is-open').forEach(closeModal);
            }
        });
        return { open: openModal, close: closeModal };
    })();

    // Mobile sidebar drawer (proper overlay with backdrop)
    (() => {
        const toggle = document.getElementById('admin-mobile-toggle');
        const aside = document.getElementById('admin-aside');
        const backdrop = document.getElementById('admin-aside-backdrop');
        if (!toggle || !aside) return;
        const open = () => {
            aside.classList.add('is-mobile-open');
            backdrop?.classList.add('is-mobile-open');
            document.body.classList.add('admin-drawer-open');
        };
        const close = () => {
            aside.classList.remove('is-mobile-open');
            backdrop?.classList.remove('is-mobile-open');
            document.body.classList.remove('admin-drawer-open');
        };
        toggle.addEventListener('click', () => {
            aside.classList.contains('is-mobile-open') ? close() : open();
        });
        backdrop?.addEventListener('click', close);
        // Close on link click (navigate)
        aside.querySelectorAll('a').forEach(a => a.addEventListener('click', close));
        // Close on Escape
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') close(); });
        // Close on resize to desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) close();
        });
    })();

    // Animate dashboard counters
    document.querySelectorAll('[data-counter]').forEach(el => {
        if (!('IntersectionObserver' in window)) return;
        const target = parseFloat(el.dataset.counter);
        const suffix = el.dataset.suffix || '';
        const dur = 1200;
        const io = new IntersectionObserver(entries => {
            entries.forEach(en => {
                if (!en.isIntersecting) return;
                io.unobserve(en.target);
                const start = performance.now();
                const tick = (now) => {
                    const p = Math.min(1, (now - start) / dur);
                    const eased = 1 - Math.pow(1 - p, 3);
                    el.textContent = Math.round(target * eased) + suffix;
                    if (p < 1) requestAnimationFrame(tick);
                };
                requestAnimationFrame(tick);
            });
        }, { threshold: 0.5 });
        io.observe(el);
    });

    // Reveal cards in admin grids
    (() => {
        if (matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        if (!('IntersectionObserver' in window)) return;
        const targets = document.querySelectorAll('[data-fluid-stagger], .fluid-up');
        if (!targets.length) return;
        const vh = window.innerHeight;
        targets.forEach(el => {
            const r = el.getBoundingClientRect();
            if (r.top > vh - 80) el.classList.add('is-pre');
        });
        const io = new IntersectionObserver((entries) => {
            entries.forEach(en => {
                if (en.isIntersecting) {
                    en.target.classList.remove('is-pre');
                    en.target.classList.add('is-in');
                    io.unobserve(en.target);
                }
            });
        }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
        targets.forEach(el => io.observe(el));
        setTimeout(() => {
            document.querySelectorAll('.is-pre').forEach(el => {
                el.classList.remove('is-pre'); el.classList.add('is-in');
            });
        }, 2500);
    })();

    // Lenis smooth scroll for admin (desktop only — let mobile use native scroll)
    (() => {
        if (matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        if (matchMedia('(pointer: coarse)').matches) return;
        const iv = setInterval(() => {
            if (!window.Lenis) return;
            clearInterval(iv);
            const lenis = new window.Lenis({
                duration: 1.05,
                easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
                smoothWheel: true,
                smoothTouch: false,
                lerp: 0.12,
            });
            const raf = (time) => { lenis.raf(time); requestAnimationFrame(raf); };
            requestAnimationFrame(raf);
            document.querySelectorAll('a[href^="#"]').forEach(a => {
                a.addEventListener('click', (e) => {
                    const id = a.getAttribute('href');
                    if (!id || id === '#' || id.length < 2) return;
                    const target = document.querySelector(id);
                    if (!target) return;
                    e.preventDefault();
                    lenis.scrollTo(target, { offset: -20, duration: 1 });
                });
            });
        }, 60);
        setTimeout(() => clearInterval(iv), 6000);
    })();
</script>
</body>
</html>
