/* ════════════════════════════════════════════════════════════
   KYROS · Fluid motion layer
   - Lenis smooth scroll
   - Safe IntersectionObserver reveals (NEVER hide content)
   - Image fade-in on load
   ════════════════════════════════════════════════════════════ */

(() => {
  const REDUCE = matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ── Image fade-in on load (works even if JS partial fails) ── */
  document.querySelectorAll('img[data-fade]').forEach(img => {
    if (img.complete && img.naturalWidth > 0) {
      img.classList.add('is-loaded');
    } else {
      img.addEventListener('load',  () => img.classList.add('is-loaded'), { once: true });
      img.addEventListener('error', () => img.classList.add('is-loaded'), { once: true });
    }
  });

  /* ── Fluid scroll reveals (safe — content stays visible if JS errors) ──
     Strategy: at script start, immediately set `.is-pre` on targets that
     are BELOW the fold (offscreen). When they enter view, swap to `.is-in`.
     Anything above the fold stays naturally visible from page-load. */
  if (!REDUCE && 'IntersectionObserver' in window) {
    const targets = document.querySelectorAll('.fluid-up, [data-fluid-stagger]');
    if (targets.length) {
      const vh = window.innerHeight;
      targets.forEach(el => {
        const r = el.getBoundingClientRect();
        // Only pre-hide elements that are AT LEAST 80px below the viewport
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

      // Failsafe: reveal everything after 2.5s no matter what
      setTimeout(() => {
        document.querySelectorAll('.fluid-up.is-pre, [data-fluid-stagger].is-pre').forEach(el => {
          el.classList.remove('is-pre');
          el.classList.add('is-in');
        });
      }, 2500);
    }
  }

  /* ── Animated counters (re-run independent of GSAP) ── */
  document.querySelectorAll('[data-counter]').forEach(el => {
    if (REDUCE) return;
    if (!('IntersectionObserver' in window)) return;
    const target = parseFloat(el.dataset.counter);
    const decimals = (el.dataset.counter.split('.')[1] || '').length;
    const suffix = el.dataset.suffix || '';
    const prefix = el.dataset.prefix || '';
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(en => {
        if (!en.isIntersecting) return;
        observer.unobserve(en.target);
        const dur = 1500;
        const start = performance.now();
        const tick = (now) => {
          const p = Math.min(1, (now - start) / dur);
          const eased = 1 - Math.pow(1 - p, 3);
          el.textContent = prefix + (target * eased).toFixed(decimals) + suffix;
          if (p < 1) requestAnimationFrame(tick);
        };
        requestAnimationFrame(tick);
      });
    }, { threshold: 0.5 });
    observer.observe(el);
  });

  /* ── Lenis smooth scroll ── */
  if (REDUCE) return;
  const ready = (deps, cb) => {
    const tryRun = () => { if (deps.every(d => window[d])) { cb(); return true; } return false; };
    if (tryRun()) return;
    const iv = setInterval(() => { if (tryRun()) clearInterval(iv); }, 60);
    setTimeout(() => clearInterval(iv), 8000);
  };

  // Don't init Lenis on touch devices — let native scroll handle mobile/tablet
  const isTouch = matchMedia('(pointer: coarse)').matches;
  if (isTouch) return;

  ready(['Lenis'], () => {
    const lenis = new window.Lenis({
      duration: 1.2,
      easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
      smoothWheel: true,
      smoothTouch: false,
      wheelMultiplier: 1.0,
      lerp: 0.10,
    });
    window.__lenis = lenis;

    const raf = (time) => { lenis.raf(time); requestAnimationFrame(raf); };
    requestAnimationFrame(raf);

    // Anchor links → smooth scroll via Lenis
    document.querySelectorAll('a[href^="#"]').forEach(a => {
      a.addEventListener('click', (e) => {
        const id = a.getAttribute('href');
        if (!id || id === '#' || id.length < 2) return;
        const target = document.querySelector(id);
        if (!target) return;
        e.preventDefault();
        lenis.scrollTo(target, { offset: -20, duration: 1.2 });
      });
    });
  });
})();
