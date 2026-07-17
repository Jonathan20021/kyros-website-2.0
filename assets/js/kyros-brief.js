/* ════════════════════════════════════════════════════════════
   KYROS · Brief wizard
   Progressive enhancement: without this file the form renders as
   one long page and submits normally. This turns it into steps.
   ════════════════════════════════════════════════════════════ */
(() => {
  const form = document.getElementById('brief-form');
  if (!form) return;

  const steps = [...form.querySelectorAll('.brief-step')];
  if (steps.length < 2) return;

  const STEP_LABELS = ['Servicio', 'Proyecto', 'Alcance', 'Contacto'];
  const CHECK_SVG = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>';

  const progress   = form.querySelector('[data-brief-progress]');
  const fill       = form.querySelector('[data-brief-fill]');
  const dots       = form.querySelector('[data-brief-dots]');
  const counter    = form.querySelector('[data-brief-count]');
  const pctOut     = form.querySelector('[data-brief-pct]');
  const btnPrev    = form.querySelector('[data-brief-prev]');
  const btnNext    = form.querySelector('[data-brief-next]');
  const btnSubmit  = form.querySelector('[data-brief-submit]');
  const submitLbl  = form.querySelector('[data-brief-submit-label]');
  const rail       = document.querySelector('[data-brief-rail]');

  let current = 0;

  /* ── Currency toggle ────────────────────────────────────── */
  // Both label sets are already in the DOM, so switching costs no request
  // and can't lose form state. RD$ is the default (and the no-JS state).
  const curInput = document.getElementById('brief-currency');
  const curBtns  = [...document.querySelectorAll('[data-cur-btn]')];
  if (curBtns.length) {
    const setCurrency = (cur) => {
      document.querySelectorAll('[data-cur]').forEach(el => {
        el.hidden = el.dataset.cur !== cur;
      });
      curBtns.forEach(b => {
        const on = b.dataset.curBtn === cur;
        b.classList.toggle('is-active', on);
        b.setAttribute('aria-pressed', on ? 'true' : 'false');
      });
      if (curInput) curInput.value = cur;
      try { localStorage.setItem('kyros_cur', cur); } catch (e) { /* private mode */ }
    };
    curBtns.forEach(b => b.addEventListener('click', () => setCurrency(b.dataset.curBtn)));
    let saved = null;
    try { saved = localStorage.getItem('kyros_cur'); } catch (e) { /* ignore */ }
    if (saved === 'USD') setCurrency('USD');
  }

  /* ── Validation ─────────────────────────────────────────── */

  const showError = (el, msg) => {
    clearError(el);
    const field = el.closest('.brief-field') || el.closest('.brief-step');
    if (!field) return;
    const p = document.createElement('p');
    p.className = 'brief-err';
    p.dataset.briefJsErr = '1';
    p.textContent = msg;
    (field.querySelector('.brief-meta') || field).appendChild(p);
    if (el.classList) el.classList.add('is-invalid');
  };

  const clearError = (el) => {
    const field = el.closest('.brief-field') || el.closest('.brief-step');
    if (!field) return;
    field.querySelectorAll('[data-brief-js-err]').forEach(n => n.remove());
    if (el.classList) el.classList.remove('is-invalid');
  };

  // Mirrors BriefController::validate — the server stays the authority.
  const validateStep = (index) => {
    const step = steps[index];
    let ok = true;
    let firstBad = null;

    // Checkbox/radio groups
    const groups = new Set(
      [...step.querySelectorAll('[data-brief-required-group]')].map(i => i.dataset.briefRequiredGroup)
    );
    groups.forEach(g => {
      const inputs = [...step.querySelectorAll(`[data-brief-required-group="${g}"]`)];
      if (!inputs.some(i => i.checked)) {
        ok = false;
        firstBad = firstBad || inputs[0];
        showError(inputs[0], g === 'services' ? 'Selecciona al menos un servicio.' : 'Selecciona una opción.');
      } else {
        clearError(inputs[0]);
      }
    });

    // Text inputs
    step.querySelectorAll('[data-brief-required]').forEach(el => {
      const v = el.value.trim();
      let msg = '';
      if (!v) {
        msg = 'Este campo es obligatorio.';
      } else if (el.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) {
        msg = 'Ingresa un email válido.';
      } else if (el.id === 'description' && v.length < 20) {
        msg = `Cuéntanos un poco más: ${v.length}/20 caracteres.`;
      } else if (el.id === 'name' && v.length < 2) {
        msg = 'Ingresa tu nombre completo.';
      }
      if (msg) {
        ok = false;
        firstBad = firstBad || el;
        showError(el, msg);
      } else {
        clearError(el);
      }
    });

    if (firstBad) {
      const focusTarget = firstBad.type === 'checkbox' || firstBad.type === 'radio'
        ? firstBad.closest('label') : firstBad;
      (focusTarget || firstBad).scrollIntoView({ behavior: 'smooth', block: 'center' });
      if (firstBad.focus) setTimeout(() => firstBad.focus({ preventScroll: true }), 200);
    }
    return ok;
  };

  /* ── Rendering ──────────────────────────────────────────── */

  const render = (animate = true) => {
    steps.forEach((s, i) => {
      const hidden = i !== current;
      s.classList.toggle('is-hidden', hidden);
      if (!hidden && animate) {
        s.classList.remove('is-entering');
        void s.offsetWidth; // restart the animation
        s.classList.add('is-entering');
      }
    });

    const pct = ((current + 1) / steps.length) * 100;
    if (fill)    fill.style.width = pct + '%';
    if (counter) counter.textContent = `Paso ${current + 1} de ${steps.length}`;
    if (pctOut)  pctOut.textContent = Math.round(pct) + '%';

    if (dots) {
      [...dots.children].forEach((d, i) => {
        d.classList.toggle('is-active', i === current);
        d.classList.toggle('is-done', i < current);
      });
    }

    if (rail) {
      [...rail.children].forEach((li, i) => {
        li.classList.toggle('is-active', i === current);
        li.classList.toggle('is-done', i < current);
        const bullet = li.querySelector('.brief-rail__bullet');
        if (bullet) bullet.innerHTML = i < current ? CHECK_SVG : String(i + 1);
        li.style.cursor = i < current ? 'pointer' : 'default';
      });
    }

    const last = current === steps.length - 1;
    if (btnPrev)   btnPrev.hidden   = current === 0;
    if (btnNext)   btnNext.hidden   = last;
    if (btnSubmit) btnSubmit.hidden = !last;
  };

  const goTo = (index, animate = true) => {
    current = Math.max(0, Math.min(index, steps.length - 1));
    render(animate);
  };

  /* ── Wire up ────────────────────────────────────────────── */

  if (progress) {
    progress.hidden = false;
    steps.forEach((_, i) => {
      const d = document.createElement('span');
      d.className = 'brief-progress__step';
      d.textContent = `${i + 1}. ${STEP_LABELS[i] || 'Paso ' + (i + 1)}`;
      dots.appendChild(d);
    });
  }

  if (rail) {
    rail.closest('.brief-rail')?.removeAttribute('aria-hidden');
    steps.forEach((_, i) => {
      const li = document.createElement('li');
      li.className = 'brief-rail__item';
      li.innerHTML = `<span class="brief-rail__bullet">${i + 1}</span><span>${STEP_LABELS[i] || 'Paso ' + (i + 1)}</span>`;
      // Jumping back to a finished step is safe; jumping forward would skip validation.
      li.addEventListener('click', () => {
        if (i < current) {
          goTo(i);
          form.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });
      li.style.cursor = 'default';
      rail.appendChild(li);
    });
  }

  btnNext?.addEventListener('click', () => {
    if (!validateStep(current)) return;
    goTo(current + 1);
    form.scrollIntoView({ behavior: 'smooth', block: 'start' });
  });

  btnPrev?.addEventListener('click', () => {
    goTo(current - 1);
    form.scrollIntoView({ behavior: 'smooth', block: 'start' });
  });

  // Enter should advance, not submit early — except on the last step.
  form.addEventListener('keydown', (e) => {
    if (e.key !== 'Enter') return;
    if (e.target.tagName === 'TEXTAREA') return;
    if (current < steps.length - 1) {
      e.preventDefault();
      btnNext?.click();
    }
  });

  form.addEventListener('submit', (e) => {
    // Validate every step: a user can reach submit with an earlier step invalid
    // only if JS was bypassed, but check anyway before we disable the button.
    for (let i = 0; i < steps.length; i++) {
      if (!validateStep(i)) {
        e.preventDefault();
        goTo(i);
        return;
      }
    }
    if (btnSubmit) {
      btnSubmit.disabled = true;
      if (submitLbl) submitLbl.textContent = 'Enviando…';
    }
  });

  // Live character counter
  form.querySelectorAll('[data-brief-counter]').forEach(el => {
    const out = form.querySelector(`[data-count-for="${el.id}"]`);
    if (!out) return;
    const max = el.getAttribute('maxlength') || 0;
    const upd = () => {
      out.textContent = `${el.value.length} / ${max}`;
      out.classList.toggle('is-near', max && el.value.length > max * 0.9);
    };
    el.addEventListener('input', upd);
    upd();
  });

  // Clear a field's error as soon as the user fixes it
  form.querySelectorAll('.brief-input').forEach(el => {
    el.addEventListener('input', () => {
      if (el.classList.contains('is-invalid')) clearError(el);
    });
  });
  form.querySelectorAll('.brief-card input, .brief-chip input').forEach(el => {
    el.addEventListener('change', () => clearError(el));
  });

  // If the server bounced us back with errors, land on the first bad step.
  const firstServerErr = form.querySelector('.is-invalid, .brief-err');
  if (firstServerErr) {
    const step = firstServerErr.closest('.brief-step');
    const idx = steps.indexOf(step);
    goTo(idx > -1 ? idx : 0, false);
  } else {
    render(false);
  }
})();
