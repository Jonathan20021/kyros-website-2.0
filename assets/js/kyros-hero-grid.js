/* ════════════════════════════════════════════════════════════
   KYROS · Hero network grid
   A blueprint lattice with data packets routing between nodes —
   the work KYROS actually does (software, redes, monitoreo), rather
   than a generic particle web.

   Purely decorative and defensive by design:
     · never runs on reduced-motion or coarse pointers (mobile GPU)
     · pauses when the hero scrolls away or the tab is hidden
     · the static grid is cached to an offscreen canvas and blitted
   ════════════════════════════════════════════════════════════ */
(() => {
  const canvas = document.getElementById('hero-grid');
  if (!canvas) return;

  // Reduced motion still gets the lattice — just no moving packets. Bailing
  // entirely would hand those users a blank hero for no reason.
  const REDUCE = matchMedia('(prefers-reduced-motion: reduce)').matches;
  // Runs on phones too: this canvas is a cached blit plus a few dozen strokes,
  // nothing like the blur(100px)/mix-blend layers that are disabled on mobile.
  // It's tuned down below rather than switched off.

  const ctx = canvas.getContext('2d', { alpha: true });
  if (!ctx) return;

  const INK        = '17, 17, 17';
  const ORANGE     = '242, 101, 34';
  // Trail is sampled by DISTANCE, not by frame: a frame-based trail changes
  // length with speed and refresh rate (a 16-sample trail at 68px/s is ~18px —
  // a comma, not a data stream).
  const TRAIL_PX   = 132;   // trail length in px
  const STEP_PX    = 6;     // distance between trail samples
  const SPEED      = 82;    // px per second
  const TURN_CHANCE = 0.42; // chance a packet turns at an intersection

  let w = 0, h = 0, dpr = 1;
  let cols = 0, rows = 0;
  // Grid pitch: tighter on phones so a 393px-wide hero still shows a lattice
  // rather than three lonely lines. Recomputed on resize/rotate.
  let CELL = 66;
  let gridLayer = null;     // cached static lattice
  let packets = [];
  let ripples = [];
  let raf = null, last = 0, running = false;

  const rand = (a, b) => a + Math.random() * (b - a);
  const pick = (arr) => arr[(Math.random() * arr.length) | 0];

  /* ── Static lattice, drawn once per resize ─────────────── */
  function buildGrid() {
    gridLayer = document.createElement('canvas');
    gridLayer.width = canvas.width;
    gridLayer.height = canvas.height;
    const g = gridLayer.getContext('2d');
    g.setTransform(dpr, 0, 0, dpr, 0, 0);

    g.lineWidth = 1;
    g.strokeStyle = `rgba(${INK}, 0.075)`;
    g.beginPath();
    for (let c = 0; c <= cols; c++) {
      const x = c * CELL + 0.5;
      g.moveTo(x, 0); g.lineTo(x, h);
    }
    for (let r = 0; r <= rows; r++) {
      const y = r * CELL + 0.5;
      g.moveTo(0, y); g.lineTo(w, y);
    }
    g.stroke();

    // Nodes: most intersections get a faint dot, a few become hubs.
    for (let c = 0; c <= cols; c++) {
      for (let r = 0; r <= rows; r++) {
        const x = c * CELL, y = r * CELL;
        const hub = ((c * 31 + r * 17) % 11) === 0; // deterministic, no flicker on resize
        if (hub) {
          g.beginPath();
          g.arc(x, y, 2.4, 0, Math.PI * 2);
          g.fillStyle = `rgba(${INK}, 0.24)`;
          g.fill();
          g.beginPath();
          g.arc(x, y, 5.5, 0, Math.PI * 2);
          g.strokeStyle = `rgba(${INK}, 0.11)`;
          g.stroke();
        } else if (((c + r) % 2) === 0) {
          g.beginPath();
          g.arc(x, y, 1, 0, Math.PI * 2);
          g.fillStyle = `rgba(${INK}, 0.14)`;
          g.fill();
        }
      }
    }
  }

  /* ── Packets ───────────────────────────────────────────── */
  const DIRS = [[1, 0], [-1, 0], [0, 1], [0, -1]];

  function spawn(seeded) {
    const c = (Math.random() * (cols + 1)) | 0;
    const r = (Math.random() * (rows + 1)) | 0;
    const d = pick(DIRS);
    return {
      x: c * CELL, y: r * CELL,
      dx: d[0], dy: d[1],
      trail: [],
      acc: 0,               // distance since the last trail sample
      speed: rand(SPEED * 0.7, SPEED * 1.5),
      life: 0,
      ttl: rand(6, 14),
      // stagger the first appearance so they don't all start together
      delay: seeded ? rand(0, 6) : 0,
    };
  }

  function stepPacket(p, dt) {
    if (p.delay > 0) { p.delay -= dt; return; }
    p.life += dt;

    const prevX = p.x, prevY = p.y;
    p.x += p.dx * p.speed * dt;
    p.y += p.dy * p.speed * dt;

    // Turn only when crossing an intersection.
    const crossed = p.dx !== 0
      ? Math.floor(prevX / CELL) !== Math.floor(p.x / CELL)
      : Math.floor(prevY / CELL) !== Math.floor(p.y / CELL);

    if (crossed) {
      const cx = Math.round(p.x / CELL) * CELL;
      const cy = Math.round(p.y / CELL) * CELL;
      if (Math.random() < TURN_CHANCE) {
        p.x = cx; p.y = cy;
        const turn = p.dx !== 0 ? [[0, 1], [0, -1]] : [[1, 0], [-1, 0]];
        const t = pick(turn);
        p.dx = t[0]; p.dy = t[1];
        // Pin a sample exactly on the corner so the trail turns crisply.
        p.trail.push(cx, cy);
        p.acc = 0;
        ripples.push({ x: cx, y: cy, t: 0 });
      }
    }

    // Sample by distance travelled, so the trail is always ~TRAIL_PX long.
    p.acc += Math.abs(p.x - prevX) + Math.abs(p.y - prevY);
    if (p.acc >= STEP_PX) {
      p.acc = 0;
      p.trail.push(p.x, p.y);
    }
    const maxPts = Math.ceil(TRAIL_PX / STEP_PX) * 2;
    if (p.trail.length > maxPts) p.trail.splice(0, p.trail.length - maxPts);

    const out = p.x < -CELL || p.x > w + CELL || p.y < -CELL || p.y > h + CELL;
    if (out || p.life > p.ttl) Object.assign(p, spawn(false));
  }

  function drawPacket(p) {
    if (p.delay > 0) return;
    const n = p.trail.length / 2;
    if (n < 2) return;

    // Fade the whole packet in/out at the ends of its life.
    const fade = Math.min(1, p.life * 1.6, Math.max(0, (p.ttl - p.life) * 1.2));

    for (let i = 1; i < n; i++) {
      const a = (i / n) * 0.8 * fade;
      ctx.strokeStyle = `rgba(${ORANGE}, ${a.toFixed(3)})`;
      ctx.lineWidth = 1.7 * (i / n) + 0.4;
      ctx.beginPath();
      ctx.moveTo(p.trail[(i - 1) * 2], p.trail[(i - 1) * 2 + 1]);
      ctx.lineTo(p.trail[i * 2], p.trail[i * 2 + 1]);
      ctx.stroke();
    }

    // Head rides the true position, not the last 6px sample, so it moves
    // smoothly instead of stepping.
    const hx = p.x, hy = p.y;
    ctx.strokeStyle = `rgba(${ORANGE}, ${0.8 * fade})`;
    ctx.lineWidth = 2.1;
    ctx.beginPath();
    ctx.moveTo(p.trail[p.trail.length - 2], p.trail[p.trail.length - 1]);
    ctx.lineTo(hx, hy);
    ctx.stroke();
    const glow = ctx.createRadialGradient(hx, hy, 0, hx, hy, 9);
    glow.addColorStop(0, `rgba(${ORANGE}, ${0.5 * fade})`);
    glow.addColorStop(1, `rgba(${ORANGE}, 0)`);
    ctx.fillStyle = glow;
    ctx.beginPath(); ctx.arc(hx, hy, 9, 0, Math.PI * 2); ctx.fill();

    ctx.fillStyle = `rgba(${ORANGE}, ${0.95 * fade})`;
    ctx.beginPath(); ctx.arc(hx, hy, 1.9, 0, Math.PI * 2); ctx.fill();
  }

  function drawRipples(dt) {
    for (let i = ripples.length - 1; i >= 0; i--) {
      const r = ripples[i];
      r.t += dt;
      const k = r.t / 0.9;
      if (k >= 1) { ripples.splice(i, 1); continue; }
      ctx.beginPath();
      ctx.arc(r.x, r.y, 3 + k * 13, 0, Math.PI * 2);
      ctx.strokeStyle = `rgba(${ORANGE}, ${(0.32 * (1 - k)).toFixed(3)})`;
      ctx.lineWidth = 1;
      ctx.stroke();
    }
    if (ripples.length > 40) ripples.splice(0, ripples.length - 40);
  }

  /* ── Loop ──────────────────────────────────────────────── */
  // dt = 0 paints without advancing — used once on resize so the lattice is
  // there immediately instead of flashing empty until the first frame.
  function render(dt) {
    ctx.clearRect(0, 0, w, h);
    if (gridLayer) ctx.drawImage(gridLayer, 0, 0, w, h);

    ctx.lineCap = 'round';
    for (const p of packets) {
      if (dt) stepPacket(p, dt);
      drawPacket(p);
    }
    drawRipples(dt);
  }

  function frame(now) {
    if (!running) return;
    const dt = Math.min((now - last) / 1000, 0.05); // clamp after tab switches
    last = now;
    render(dt);
    raf = requestAnimationFrame(frame);
  }

  function start() {
    if (running) return;
    running = true;
    last = performance.now();
    raf = requestAnimationFrame(frame);
  }
  function stop() {
    running = false;
    if (raf) cancelAnimationFrame(raf);
    raf = null;
  }

  function resize() {
    const rect = canvas.getBoundingClientRect();
    if (!rect.width || !rect.height) return;

    const small = rect.width < 640;
    CELL = small ? 46 : 66;
    // Phones ship DPR 3+; a 3x backing store triples fill cost for a texture
    // nobody inspects at pixel level. 2 is plenty for 1px lines.
    dpr = Math.min(window.devicePixelRatio || 1, 2);

    w = rect.width; h = rect.height;
    canvas.width  = Math.round(w * dpr);
    canvas.height = Math.round(h * dpr);
    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    cols = Math.ceil(w / CELL);
    rows = Math.ceil(h / CELL);
    buildGrid();

    const target = REDUCE
      ? 0
      : Math.max(small ? 4 : 6, Math.min(small ? 7 : 14, Math.round((w * h) / 90000)));
    packets = Array.from({ length: target }, () => spawn(true));
    render(0);
  }

  resize();

  let rt = null;
  window.addEventListener('resize', () => {
    clearTimeout(rt);
    rt = setTimeout(resize, 180);
  }, { passive: true });

  // Static lattice only — no loop, no observers.
  if (REDUCE) return;

  // Don't burn frames on an off-screen hero or a hidden tab.
  const hero = document.getElementById('hero');
  if (hero && 'IntersectionObserver' in window) {
    new IntersectionObserver((entries) => {
      entries.forEach(e => (e.isIntersecting && !document.hidden) ? start() : stop());
    }, { threshold: 0 }).observe(hero);
  } else {
    start();
  }
  document.addEventListener('visibilitychange', () => {
    if (document.hidden) stop();
    else if (!hero || hero.getBoundingClientRect().bottom > 0) start();
  });
})();
