/* ════════════════════════════════════════════════════════════
   KYROS · Doctor intake form (/mi-pagina-medica)

   Progressive enhancement, same contract as kyros-brief.js: the
   markup is a plain long form that submits fine without JS, and
   this turns it into a 5-step wizard. Everything it validates is
   re-validated by MedicalSiteController — the server stays the
   authority; this only spares the doctor a round trip.

   Extras over the brief wizard:
     · drag & drop uploads with preview (logo + retrato)
     · repeatable consultorio cards, reindexed on add/remove
     · weekly schedule rows with a copy-to-all shortcut
     · localStorage autosave, because this form is 10 minutes long
   ════════════════════════════════════════════════════════════ */
(() => {
  const form = document.getElementById('med-form');
  if (!form) return;

  const steps = [...form.querySelectorAll('.brief-step')];
  if (steps.length < 2) return;

  const STEP_LABELS = ['Identidad', 'Contacto', 'Trayectoria', 'Consultorios', 'Plan'];
  const CHECK_SVG = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>';
  const STORE_KEY = 'kyros_med_form_v1';
  const MAX_CLINICS = 6;
  const MAX_UPLOAD = 5 * 1024 * 1024;

  const progress  = form.querySelector('[data-med-progress]');
  const fill      = form.querySelector('[data-med-fill]');
  const dots      = form.querySelector('[data-med-dots]');
  const counter   = form.querySelector('[data-med-count]');
  const pctOut    = form.querySelector('[data-med-pct]');
  const btnPrev   = form.querySelector('[data-med-prev]');
  const btnNext   = form.querySelector('[data-med-next]');
  const btnSubmit = form.querySelector('[data-med-submit]');
  const submitLbl = form.querySelector('[data-med-submit-label]');
  const rail      = document.querySelector('[data-med-rail]');
  const savedFlag = document.querySelector('[data-med-saved]');

  let current = 0;

  /* ── Conditional fields ─────────────────────────────────── */
  const specialty      = form.querySelector('[data-med-specialty]');
  const specialtyOther = form.querySelector('[data-med-specialty-other]');
  if (specialty && specialtyOther) {
    const sync = () => { specialtyOther.hidden = specialty.value !== 'otra'; };
    specialty.addEventListener('change', sync);
    sync();
  }

  const domainName = form.querySelector('[data-med-domain-name]');
  if (domainName) {
    const sync = () => {
      const on = form.querySelector('[data-med-domain]:checked');
      domainName.hidden = !on || on.value !== 'tengo';
    };
    form.querySelectorAll('[data-med-domain]').forEach(r => r.addEventListener('change', sync));
    sync();
  }

  /* ── Errors ─────────────────────────────────────────────── */
  const showError = (el, msg) => {
    clearError(el);
    const field = el.closest('.brief-field') || el.closest('.med-clinic') || el.closest('.brief-step');
    if (!field) return;
    el.classList.add('is-invalid');
    const p = document.createElement('p');
    p.className = 'brief-err';
    p.dataset.medJsErr = '1';
    p.textContent = msg;
    (field.querySelector('.brief-meta') || field).appendChild(p);
  };

  const clearError = (el) => {
    el.classList.remove('is-invalid');
    const field = el.closest('.brief-field') || el.closest('.med-clinic') || el.closest('.brief-step');
    field?.querySelectorAll('[data-med-js-err]').forEach(n => n.remove());
  };

  /* ── Validation — mirrors MedicalSiteController::validate ── */
  const validateStep = (index) => {
    const step = steps[index];
    let ok = true;
    let firstBad = null;

    // Radio/checkbox groups
    const groups = new Set(
      [...step.querySelectorAll('[data-med-required-group]')].map(el => el.dataset.medRequiredGroup)
    );
    groups.forEach(g => {
      const inputs = [...step.querySelectorAll(`[data-med-required-group="${g}"]`)];
      if (!inputs.length) return;
      const picked = inputs.some(i => i.checked);
      if (!picked) {
        ok = false;
        firstBad = firstBad || inputs[0];
        showError(inputs[0], 'Elige una opción para continuar.');
      } else {
        clearError(inputs[0]);
      }
    });

    // Text inputs / selects / textareas
    step.querySelectorAll('[data-med-required]').forEach(el => {
      if (el.closest('[hidden]')) return;
      const v = (el.value || '').trim();
      let msg = '';

      if (v === '') {
        msg = 'Este campo es obligatorio.';
      } else if (el.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v)) {
        msg = 'Ingresa un email válido.';
      } else if (el.type === 'tel' && v.replace(/\D+/g, '').length < 7) {
        msg = 'Ingresa un teléfono válido.';
      } else if (el.id === 'full_name' && v.length < 3) {
        msg = 'Ingresa tu nombre completo.';
      } else if (el.id === 'bio' && v.length < 40) {
        msg = `Cuéntanos un poco más: faltan ${40 - v.length} caracteres.`;
      }

      if (msg) { ok = false; firstBad = firstBad || el; showError(el, msg); }
      else clearError(el);
    });

    // "Otra especialidad" is only required once that option is picked.
    if (specialty && specialtyOther && !specialtyOther.hidden && step.contains(specialty)) {
      const other = specialtyOther.querySelector('input');
      if (other && other.value.trim().length < 3) {
        ok = false; firstBad = firstBad || other;
        showError(other, 'Escribe cuál es tu especialidad.');
      } else if (other) clearError(other);
    }

    // At least one consultorio needs a name.
    const clinicList = step.querySelector('[data-clinic-list]');
    if (clinicList) {
      const named = [...clinicList.querySelectorAll('[data-clinic]')].filter(c => {
        const n = c.querySelector('input[name$="[name]"]');
        return n && n.value.trim() !== '';
      });
      const firstNameInput = clinicList.querySelector('input[name$="[name]"]');
      if (!named.length && firstNameInput) {
        ok = false; firstBad = firstBad || firstNameInput;
        showError(firstNameInput, 'Dinos al menos dónde pasas consulta.');
      } else if (firstNameInput) clearError(firstNameInput);
    }

    if (!ok && firstBad) {
      const target = (firstBad.type === 'checkbox' || firstBad.type === 'radio')
        ? firstBad.closest('label') : firstBad;
      (target || firstBad).scrollIntoView({ behavior: 'smooth', block: 'center' });
      if (firstBad.focus && firstBad.type !== 'radio' && firstBad.type !== 'checkbox') {
        setTimeout(() => firstBad.focus({ preventScroll: true }), 320);
      }
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
        void s.offsetWidth;          // restart the animation
        s.classList.add('is-entering');
      }
    });

    const pct = ((current + 1) / steps.length) * 100;
    if (fill)    fill.style.width = pct + '%';
    if (counter) counter.textContent = `Paso ${current + 1} de ${steps.length}`;
    if (pctOut)  pctOut.textContent = Math.round(pct) + '%';

    dots?.querySelectorAll('.brief-progress__step').forEach((d, i) => {
      d.classList.toggle('is-active', i === current);
      d.classList.toggle('is-done', i < current);
    });

    rail?.querySelectorAll('.brief-rail__item').forEach((li, i) => {
      li.classList.toggle('is-active', i === current);
      li.classList.toggle('is-done', i < current);
      const bullet = li.querySelector('.brief-rail__bullet');
      if (bullet) bullet.innerHTML = i < current ? CHECK_SVG : String(i + 1);
    });

    const last = current === steps.length - 1;
    if (btnPrev)   btnPrev.hidden = current === 0;
    if (btnNext)   btnNext.hidden = last;
    if (btnSubmit) btnSubmit.hidden = !last;
  };

  const goTo = (index, animate = true) => {
    current = Math.max(0, Math.min(steps.length - 1, index));
    render(animate);
    const shell = document.getElementById('form');
    if (shell && animate) {
      const top = shell.getBoundingClientRect().top + window.scrollY - 90;
      window.scrollTo({ top, behavior: 'smooth' });
    }
  };

  /* ── Chrome (dots + rail) ───────────────────────────────── */
  if (progress) progress.hidden = false;

  steps.forEach((_, i) => {
    if (dots) {
      const d = document.createElement('span');
      d.className = 'brief-progress__step';
      d.textContent = STEP_LABELS[i] || `Paso ${i + 1}`;
      dots.appendChild(d);
    }
    if (rail) {
      const li = document.createElement('li');
      li.className = 'brief-rail__item';
      li.innerHTML = `<span class="brief-rail__bullet">${i + 1}</span><span>${STEP_LABELS[i] || `Paso ${i + 1}`}</span>`;
      // Jumping back to a finished step is safe; forward would skip validation.
      li.addEventListener('click', () => { if (i < current) goTo(i); });
      li.style.cursor = 'pointer';
      rail.appendChild(li);
    }
  });
  rail?.parentElement?.removeAttribute('aria-hidden');

  btnNext?.addEventListener('click', () => { if (validateStep(current)) goTo(current + 1); });
  btnPrev?.addEventListener('click', () => goTo(current - 1));

  // Enter advances instead of submitting early — except on the last step.
  form.addEventListener('keydown', (e) => {
    if (e.key !== 'Enter') return;
    const t = e.target;
    if (t.tagName === 'TEXTAREA' || t.type === 'submit') return;
    if (current < steps.length - 1) {
      e.preventDefault();
      if (validateStep(current)) goTo(current + 1);
    }
  });

  form.addEventListener('submit', (e) => {
    // A user can only reach submit with an earlier step invalid if JS was
    // bypassed mid-flow, but check everything before disabling the button.
    for (let i = 0; i < steps.length; i++) {
      if (!validateStep(i)) {
        e.preventDefault();
        goTo(i);
        return;
      }
    }
    clearStore();
    if (btnSubmit) {
      btnSubmit.disabled = true;
      if (submitLbl) submitLbl.textContent = 'Enviando…';
    }
  });

  /* ── Character counters ─────────────────────────────────── */
  form.querySelectorAll('[data-med-counter]').forEach(el => {
    const out = form.querySelector(`[data-count-for="${el.id}"]`);
    if (!out) return;
    const max = parseInt(el.getAttribute('maxlength') || '0', 10);
    const sync = () => {
      const n = el.value.length;
      out.textContent = `${n} / ${max}`;
      out.classList.toggle('is-near', max > 0 && n > max * 0.9);
    };
    el.addEventListener('input', sync);
    sync();
  });

  /* ── Uploads: drag & drop, preview, clear ───────────────── */
  form.querySelectorAll('[data-drop]').forEach(drop => {
    const input   = drop.querySelector('[data-drop-input]');
    const kept    = drop.querySelector('[data-drop-kept]');
    const img     = drop.querySelector('[data-drop-img]');
    const nameOut = drop.querySelector('[data-drop-name]');
    const clear   = drop.querySelector('[data-drop-clear]');
    if (!input) return;

    const setError = (msg) => {
      drop.querySelectorAll('[data-med-js-err]').forEach(n => n.remove());
      if (!msg) return;
      const p = document.createElement('p');
      p.className = 'brief-err';
      p.dataset.medJsErr = '1';
      p.textContent = msg;
      drop.appendChild(p);
    };

    const preview = (file) => {
      if (!file) return;
      if (!/^image\/(jpeg|png|webp|avif)$/.test(file.type)) {
        setError('Formato no admitido. Usa JPG, PNG o WEBP.');
        input.value = '';
        return;
      }
      if (file.size > MAX_UPLOAD) {
        setError('La imagen supera los 5 MB. Prueba con una más liviana.');
        input.value = '';
        return;
      }
      setError('');
      const reader = new FileReader();
      reader.onload = () => {
        if (img) img.src = String(reader.result);
        if (nameOut) nameOut.textContent = file.name;
        drop.classList.add('has-file');
        // A newly chosen file replaces whatever the server carried over.
        if (kept) kept.value = '';
      };
      reader.readAsDataURL(file);
    };

    input.addEventListener('change', () => preview(input.files && input.files[0]));

    clear?.addEventListener('click', () => {
      input.value = '';
      if (kept) kept.value = '';
      if (img) img.removeAttribute('src');
      if (nameOut) nameOut.textContent = '';
      drop.classList.remove('has-file');
      setError('');
    });

    ['dragenter', 'dragover'].forEach(ev =>
      drop.addEventListener(ev, (e) => { e.preventDefault(); drop.classList.add('is-over'); })
    );
    ['dragleave', 'drop'].forEach(ev =>
      drop.addEventListener(ev, (e) => { e.preventDefault(); drop.classList.remove('is-over'); })
    );
    drop.addEventListener('drop', (e) => {
      const file = e.dataTransfer?.files?.[0];
      if (!file) return;
      // DataTransfer → the real input, so the file actually posts.
      const dt = new DataTransfer();
      dt.items.add(file);
      input.files = dt.files;
      preview(file);
    });
  });

  /* ── Consultorios: add / remove / reindex ───────────────── */
  const clinicList = form.querySelector('[data-clinic-list]');
  const clinicTpl  = form.querySelector('[data-clinic-template]');
  const clinicAdd  = form.querySelector('[data-clinic-add]');

  const reindexClinics = () => {
    if (!clinicList) return;
    const cards = [...clinicList.querySelectorAll('[data-clinic]')];
    cards.forEach((card, i) => {
      card.querySelectorAll('[name]').forEach(el => {
        el.name = el.name.replace(/^clinics\[[^\]]*\]/, `clinics[${i}]`);
      });
      const num = card.querySelector('[data-clinic-num]');
      if (num) num.textContent = String(i + 1);
      const rm = card.querySelector('[data-clinic-remove]');
      // Nothing to remove when it is the only one.
      if (rm) rm.hidden = cards.length < 2;
    });
    if (clinicAdd) clinicAdd.hidden = cards.length >= MAX_CLINICS;
  };

  const wireClinic = (card) => {
    card.querySelector('[data-clinic-remove]')?.addEventListener('click', () => {
      card.remove();
      reindexClinics();
      saveSoon();
    });
    wireSchedule(card);
  };

  clinicAdd?.addEventListener('click', () => {
    if (!clinicList || !clinicTpl) return;
    if (clinicList.querySelectorAll('[data-clinic]').length >= MAX_CLINICS) return;

    const idx = clinicList.querySelectorAll('[data-clinic]').length;
    const html = clinicTpl.innerHTML.replace(/__i__/g, String(idx));
    const holder = document.createElement('div');
    holder.innerHTML = html;
    const card = holder.querySelector('[data-clinic]');
    if (!card) return;

    clinicList.appendChild(card);
    wireClinic(card);
    reindexClinics();
    card.scrollIntoView({ behavior: 'smooth', block: 'center' });
    card.querySelector('input[name$="[name]"]')?.focus({ preventScroll: true });
  });

  /* ── Weekly schedule rows ───────────────────────────────── */
  function wireSchedule(scope) {
    scope.querySelectorAll('[data-sched-row]').forEach(row => {
      const on = row.querySelector('[data-sched-on]');
      if (!on) return;
      const sync = () => row.classList.toggle('is-on', on.checked);
      on.addEventListener('change', () => { sync(); saveSoon(); });
      sync();
    });

    scope.querySelector('[data-sched-copy]')?.addEventListener('click', () => {
      const rows = [...scope.querySelectorAll('[data-sched-row]')];
      const source = rows.find(r => r.querySelector('[data-sched-on]')?.checked) || rows[0];
      if (!source) return;
      const from = source.querySelector('input[type="time"][name$="[from]"]')?.value || '';
      const to   = source.querySelector('input[type="time"][name$="[to]"]')?.value || '';
      rows.forEach(r => {
        const on = r.querySelector('[data-sched-on]');
        if (on && !on.checked) return;      // only days already marked
        const f = r.querySelector('input[name$="[from]"]');
        const t = r.querySelector('input[name$="[to]"]');
        if (f) f.value = from;
        if (t) t.value = to;
      });
      saveSoon();
    });
  }

  clinicList?.querySelectorAll('[data-clinic]').forEach(wireClinic);
  reindexClinics();

  /* ── Autosave ───────────────────────────────────────────────
     Ten minutes of typing must survive a closed tab or a stray
     back button. Files are never stored (they can't be) and neither
     is anything the browser would have to re-upload. */
  let saveTimer = null;
  const saveSoon = () => { clearTimeout(saveTimer); saveTimer = setTimeout(save, 600); };

  function save() {
    try {
      const data = { clinics: form.querySelectorAll('[data-clinic]').length, fields: {}, checks: [] };
      form.querySelectorAll('input, select, textarea').forEach(el => {
        if (!el.name || el.type === 'file' || el.type === 'hidden' || el.name === 'fax' || el.name === '_csrf') return;
        if (el.type === 'checkbox' || el.type === 'radio') {
          if (el.checked) data.checks.push(el.name + '=' + el.value);
        } else if (el.value !== '') {
          data.fields[el.name] = el.value;
        }
      });
      localStorage.setItem(STORE_KEY, JSON.stringify(data));
      if (savedFlag) {
        savedFlag.hidden = false;
        savedFlag.classList.add('is-pulse');
        setTimeout(() => savedFlag.classList.remove('is-pulse'), 900);
      }
    } catch (_) { /* private mode / quota — autosave is a bonus, never required */ }
  }

  function clearStore() {
    try { localStorage.removeItem(STORE_KEY); } catch (_) {}
  }

  function restore() {
    let data;
    try { data = JSON.parse(localStorage.getItem(STORE_KEY) || 'null'); } catch (_) { return; }
    if (!data || !data.fields) return;

    // Add the consultorio cards the snapshot needs before filling anything.
    const want = Math.min(MAX_CLINICS, parseInt(data.clinics || 1, 10) || 1);
    while (clinicList && clinicList.querySelectorAll('[data-clinic]').length < want) {
      clinicAdd?.click();
    }

    // Server-rendered values always win: only ever fill an empty field, so a
    // validation bounce (which repopulates from old()) is never overwritten.
    Object.entries(data.fields).forEach(([name, value]) => {
      const el = form.querySelector(`[name="${CSS.escape(name)}"]`);
      if (!el || el.type === 'file' || el.value !== '') return;
      el.value = value;
    });

    (data.checks || []).forEach(entry => {
      const i = entry.indexOf('=');
      const name = entry.slice(0, i), value = entry.slice(i + 1);
      const group = [...form.querySelectorAll(`[name="${CSS.escape(name)}"]`)];
      if (!group.length) return;
      if (group.some(g => g.checked)) return;    // already answered
      const match = group.find(g => g.value === value);
      if (match) match.checked = true;
    });

    // Conditional fields and schedule dimming must catch up to restored values.
    specialty?.dispatchEvent(new Event('change'));
    form.querySelectorAll('[data-med-domain]:checked').forEach(r => r.dispatchEvent(new Event('change')));
    form.querySelectorAll('[data-clinic]').forEach(c => {
      c.querySelectorAll('[data-sched-row]').forEach(row => {
        row.classList.toggle('is-on', !!row.querySelector('[data-sched-on]')?.checked);
      });
    });
  }

  restore();
  form.addEventListener('input', saveSoon);
  form.addEventListener('change', saveSoon);

  goTo(0, false);
})();
