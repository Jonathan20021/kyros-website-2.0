/* ════════════════════════════════════════════════════════════
   KYROS · Service hero scenes
   One canvas, one service-specific animation selected by
   [data-scene] on #svc-scene:
     code     → streaming source lines (software)
     security → radar sweep detecting blips (ciberseguridad)
     support  → live signal rings + incoming tickets (soporte)
     network  → packets routing a lattice (infraestructura)
     social   → reactions rising from a broadcast hub (redes)
     medical  → ECG trace on monitor paper (webs médicas)

   Same defensive contract as the home grid:
     · reduced-motion → one static frame, no loop
     · pauses off-screen / on hidden tab
     · DPR capped at 2, first frame painted immediately
   ════════════════════════════════════════════════════════════ */
(() => {
  const canvas = document.getElementById('svc-scene');
  if (!canvas) return;
  const which = canvas.dataset.scene;
  if (!which) return;

  const ctx = canvas.getContext('2d', { alpha: true });
  if (!ctx) return;

  const REDUCE = matchMedia('(prefers-reduced-motion: reduce)').matches;
  // Accent tracks the page theme (data-accent), so the scene matches the
  // service's colour. Defaults to brand orange for the technical services.
  const ORANGE = canvas.dataset.accent || '242, 101, 34';
  const INK    = '17, 17, 17';

  const rand = (a, b) => a + Math.random() * (b - a);
  const clamp = (v, a, b) => v < a ? a : v > b ? b : v;

  let w = 0, h = 0, dpr = 1;
  let raf = null, last = 0, running = false, elapsed = 0;

  /* ─────────────────────────────────────────────────────────
     SCENE: code — source lines streaming upward, newest typing in
     ───────────────────────────────────────────────────────── */
  const codeScene = {
    rows: [], rowH: 26, speed: 20,
    makeRow() {
      const indent = ((Math.random() * 4) | 0) * 13;
      const tokens = [];
      let x = indent;
      const maxW = w * 0.62;
      while (x < maxW && Math.random() > 0.10) {
        const tw = rand(14, 62);
        tokens.push({ x, w: tw, kw: Math.random() < 0.24 });
        x += tw + 8;
      }
      return { tokens, y: 0 };
    },
    reset() {
      this.rows = [];
      const n = Math.ceil(h / this.rowH) + 2;
      for (let i = 0; i < n; i++) {
        const r = this.makeRow();
        r.y = h - i * this.rowH;
        this.rows.push(r);
      }
    },
    frame(dt) {
      let lowest = null;
      for (const r of this.rows) {
        r.y -= this.speed * dt;
        if (r.y < -this.rowH) {
          Object.assign(r, this.makeRow());
          r.y = h + this.rowH;
        }
        if (!lowest || r.y > lowest.y) lowest = r;
      }
      // reveal grows as a row rises from the bottom (a typing sweep)
      for (const r of this.rows) {
        const reveal = clamp((h - r.y) / 150, 0, 1);
        const fade = clamp(r.y / (h * 0.28), 0, 1) * clamp((h - r.y) / 40 + 0.15, 0, 1);
        const rowW = r.tokens.length ? r.tokens[r.tokens.length - 1].x + r.tokens[r.tokens.length - 1].w : 0;
        const edge = rowW * reveal;
        for (const tk of r.tokens) {
          if (tk.x > edge) break;
          const drawW = Math.min(tk.w, edge - tk.x);
          const a = (tk.kw ? 0.55 : 0.16) * fade;
          ctx.fillStyle = tk.kw ? `rgba(${ORANGE}, ${a.toFixed(3)})` : `rgba(${INK}, ${a.toFixed(3)})`;
          roundRect(tk.x, r.y - 6, drawW, 9, 2.5);
          ctx.fill();
        }
        // cursor at the typing edge of the row still being revealed
        if (reveal < 1 && r === lowest) {
          const blink = (elapsed % 1) < 0.5 ? 0.7 : 0.15;
          ctx.fillStyle = `rgba(${ORANGE}, ${(blink * fade).toFixed(3)})`;
          ctx.fillRect(edge + 3, r.y - 9, 2, 14);
        }
      }
    },
  };

  /* ─────────────────────────────────────────────────────────
     SCENE: security — radar sweep lighting up detected blips
     ───────────────────────────────────────────────────────── */
  const securityScene = {
    cx: 0, cy: 0, R: 0, blips: [], sweep: 0,
    reset() {
      this.cx = w * 0.70; this.cy = h * 0.48;
      this.R = Math.min(w, h) * 0.62;
      this.blips = [];
      const n = 9;
      for (let i = 0; i < n; i++) {
        this.blips.push({ a: rand(0, Math.PI * 2), r: rand(0.25, 0.95) * this.R, lit: 0 });
      }
    },
    frame(dt) {
      const speed = 0.85;            // rad/s
      const prev = this.sweep;
      this.sweep = (this.sweep + speed * dt) % (Math.PI * 2);

      // range rings + crosshair
      ctx.strokeStyle = `rgba(${INK}, 0.09)`;
      ctx.lineWidth = 1;
      for (let i = 1; i <= 4; i++) {
        ctx.beginPath();
        ctx.arc(this.cx, this.cy, (this.R / 4) * i, 0, Math.PI * 2);
        ctx.stroke();
      }
      ctx.beginPath();
      ctx.moveTo(this.cx - this.R, this.cy); ctx.lineTo(this.cx + this.R, this.cy);
      ctx.moveTo(this.cx, this.cy - this.R); ctx.lineTo(this.cx, this.cy + this.R);
      ctx.stroke();

      // sweep wedge (fan of fading lines trailing the arm)
      const trail = 0.6;
      for (let k = 0; k < 26; k++) {
        const a = this.sweep - (k / 26) * trail;
        const alpha = (1 - k / 26) * 0.16;
        ctx.strokeStyle = `rgba(${ORANGE}, ${alpha.toFixed(3)})`;
        ctx.lineWidth = 1.5;
        ctx.beginPath();
        ctx.moveTo(this.cx, this.cy);
        ctx.lineTo(this.cx + Math.cos(a) * this.R, this.cy + Math.sin(a) * this.R);
        ctx.stroke();
      }
      // leading arm
      ctx.strokeStyle = `rgba(${ORANGE}, 0.5)`;
      ctx.lineWidth = 1.6;
      ctx.beginPath();
      ctx.moveTo(this.cx, this.cy);
      ctx.lineTo(this.cx + Math.cos(this.sweep) * this.R, this.cy + Math.sin(this.sweep) * this.R);
      ctx.stroke();

      // blips light when the arm crosses them, then decay
      for (const b of this.blips) {
        const crossed = angleBetween(prev, this.sweep, b.a);
        if (crossed) b.lit = 1;
        b.lit = Math.max(0, b.lit - dt * 0.7);
        const x = this.cx + Math.cos(b.a) * b.r;
        const y = this.cy + Math.sin(b.a) * b.r;
        if (b.lit > 0.01) {
          ctx.fillStyle = `rgba(${ORANGE}, ${(b.lit * 0.9).toFixed(3)})`;
          ctx.beginPath(); ctx.arc(x, y, 2.6, 0, Math.PI * 2); ctx.fill();
          ctx.strokeStyle = `rgba(${ORANGE}, ${(b.lit * 0.4).toFixed(3)})`;
          ctx.lineWidth = 1;
          ctx.beginPath(); ctx.arc(x, y, 4 + (1 - b.lit) * 10, 0, Math.PI * 2); ctx.stroke();
        } else {
          ctx.fillStyle = `rgba(${INK}, 0.12)`;
          ctx.beginPath(); ctx.arc(x, y, 1.4, 0, Math.PI * 2); ctx.fill();
        }
      }
      // hub
      ctx.fillStyle = `rgba(${ORANGE}, 0.85)`;
      ctx.beginPath(); ctx.arc(this.cx, this.cy, 3, 0, Math.PI * 2); ctx.fill();
    },
  };

  /* ─────────────────────────────────────────────────────────
     SCENE: support — live signal rings + tickets resolving at a hub
     ───────────────────────────────────────────────────────── */
  const supportScene = {
    cx: 0, cy: 0, rings: [], tickets: [], emit: 0, spawn: 0,
    reset() {
      this.cx = w * 0.68; this.cy = h * 0.5;
      this.rings = []; this.tickets = [];
      this.emit = 0; this.spawn = 0;
      this.maxR = Math.min(w, h) * 0.6;
    },
    frame(dt) {
      // emit a signal ring on a steady cadence
      this.emit -= dt;
      if (this.emit <= 0) { this.emit = 1.15; this.rings.push({ r: 6 }); }
      for (let i = this.rings.length - 1; i >= 0; i--) {
        const rg = this.rings[i];
        rg.r += 46 * dt;
        const k = rg.r / this.maxR;
        if (k >= 1) { this.rings.splice(i, 1); continue; }
        ctx.strokeStyle = `rgba(${ORANGE}, ${(0.28 * (1 - k)).toFixed(3)})`;
        ctx.lineWidth = 1.4;
        ctx.beginPath(); ctx.arc(this.cx, this.cy, rg.r, 0, Math.PI * 2); ctx.stroke();
      }

      // incoming tickets converge on the hub, trigger a ping, resolve
      this.spawn -= dt;
      if (this.spawn <= 0 && this.tickets.length < 5) {
        this.spawn = rand(0.7, 1.4);
        const a = rand(0, Math.PI * 2);
        const d = this.maxR * rand(0.9, 1.15);
        this.tickets.push({ x: this.cx + Math.cos(a) * d, y: this.cy + Math.sin(a) * d, t: 0 });
      }
      for (let i = this.tickets.length - 1; i >= 0; i--) {
        const tk = this.tickets[i];
        tk.t += dt;
        tk.x += (this.cx - tk.x) * Math.min(1, dt * 1.3);
        tk.y += (this.cy - tk.y) * Math.min(1, dt * 1.3);
        const dist = Math.hypot(this.cx - tk.x, this.cy - tk.y);
        // trail line toward hub
        ctx.strokeStyle = `rgba(${INK}, 0.10)`;
        ctx.lineWidth = 1;
        ctx.beginPath(); ctx.moveTo(tk.x, tk.y); ctx.lineTo(this.cx, this.cy); ctx.stroke();
        ctx.fillStyle = `rgba(${ORANGE}, 0.8)`;
        ctx.beginPath(); ctx.arc(tk.x, tk.y, 2.4, 0, Math.PI * 2); ctx.fill();
        if (dist < 8) { this.rings.push({ r: 6 }); this.tickets.splice(i, 1); }
      }

      // pulsing hub
      const pulse = 0.5 + 0.5 * Math.sin(elapsed * 3);
      const glow = ctx.createRadialGradient(this.cx, this.cy, 0, this.cx, this.cy, 22);
      glow.addColorStop(0, `rgba(${ORANGE}, ${(0.35 + pulse * 0.2).toFixed(3)})`);
      glow.addColorStop(1, `rgba(${ORANGE}, 0)`);
      ctx.fillStyle = glow;
      ctx.beginPath(); ctx.arc(this.cx, this.cy, 22, 0, Math.PI * 2); ctx.fill();
      ctx.fillStyle = `rgba(${ORANGE}, 0.95)`;
      ctx.beginPath(); ctx.arc(this.cx, this.cy, 4.5, 0, Math.PI * 2); ctx.fill();
    },
  };

  /* ─────────────────────────────────────────────────────────
     SCENE: network — packets routing an orthogonal lattice
     ───────────────────────────────────────────────────────── */
  const networkScene = {
    CELL: 58, cols: 0, rows: 0, packets: [], grid: null,
    reset() {
      this.CELL = w < 640 ? 46 : 58;
      this.cols = Math.ceil(w / this.CELL);
      this.rows = Math.ceil(h / this.CELL);
      this.buildGrid();
      const n = REDUCE ? 0 : Math.max(4, Math.min(9, Math.round((w * h) / 110000)));
      this.packets = Array.from({ length: n }, () => this.spawn());
    },
    buildGrid() {
      this.grid = document.createElement('canvas');
      this.grid.width = canvas.width; this.grid.height = canvas.height;
      const g = this.grid.getContext('2d');
      g.setTransform(dpr, 0, 0, dpr, 0, 0);
      g.strokeStyle = `rgba(${INK}, 0.06)`;
      g.lineWidth = 1;
      g.beginPath();
      for (let c = 0; c <= this.cols; c++) { g.moveTo(c * this.CELL + 0.5, 0); g.lineTo(c * this.CELL + 0.5, h); }
      for (let r = 0; r <= this.rows; r++) { g.moveTo(0, r * this.CELL + 0.5); g.lineTo(w, r * this.CELL + 0.5); }
      g.stroke();
      for (let c = 0; c <= this.cols; c++) for (let r = 0; r <= this.rows; r++) {
        if (((c * 31 + r * 17) % 10) === 0) {
          g.fillStyle = `rgba(${INK}, 0.18)`;
          g.beginPath(); g.arc(c * this.CELL, r * this.CELL, 2, 0, Math.PI * 2); g.fill();
        }
      }
    },
    spawn() {
      const dirs = [[1, 0], [-1, 0], [0, 1], [0, -1]];
      const d = dirs[(Math.random() * 4) | 0];
      return {
        x: ((Math.random() * (this.cols + 1)) | 0) * this.CELL,
        y: ((Math.random() * (this.rows + 1)) | 0) * this.CELL,
        dx: d[0], dy: d[1], trail: [], acc: 0,
        speed: rand(58, 104), life: 0, ttl: rand(6, 13),
      };
    },
    frame(dt) {
      if (this.grid) ctx.drawImage(this.grid, 0, 0, w, h);
      const STEP = 6, TRAIL = 120;
      ctx.lineCap = 'round';
      for (const p of this.packets) {
        p.life += dt;
        const px = p.x, py = p.y;
        p.x += p.dx * p.speed * dt; p.y += p.dy * p.speed * dt;
        const crossed = p.dx !== 0
          ? Math.floor(px / this.CELL) !== Math.floor(p.x / this.CELL)
          : Math.floor(py / this.CELL) !== Math.floor(p.y / this.CELL);
        if (crossed && Math.random() < 0.4) {
          const cx = Math.round(p.x / this.CELL) * this.CELL;
          const cy = Math.round(p.y / this.CELL) * this.CELL;
          p.x = cx; p.y = cy;
          const t = (p.dx !== 0 ? [[0, 1], [0, -1]] : [[1, 0], [-1, 0]])[(Math.random() * 2) | 0];
          p.dx = t[0]; p.dy = t[1];
          p.trail.push(cx, cy); p.acc = 0;
        }
        p.acc += Math.abs(p.x - px) + Math.abs(p.y - py);
        if (p.acc >= STEP) { p.acc = 0; p.trail.push(p.x, p.y); }
        const max = Math.ceil(TRAIL / STEP) * 2;
        if (p.trail.length > max) p.trail.splice(0, p.trail.length - max);
        if (p.x < -this.CELL || p.x > w + this.CELL || p.y < -this.CELL || p.y > h + this.CELL || p.life > p.ttl) {
          Object.assign(p, this.spawn());
        }
        const n = p.trail.length / 2;
        const fade = Math.min(1, p.life * 1.6, Math.max(0, (p.ttl - p.life) * 1.2));
        for (let i = 1; i < n; i++) {
          ctx.strokeStyle = `rgba(${ORANGE}, ${((i / n) * 0.8 * fade).toFixed(3)})`;
          ctx.lineWidth = 1.6 * (i / n) + 0.4;
          ctx.beginPath();
          ctx.moveTo(p.trail[(i - 1) * 2], p.trail[(i - 1) * 2 + 1]);
          ctx.lineTo(p.trail[i * 2], p.trail[i * 2 + 1]);
          ctx.stroke();
        }
        if (n >= 1) {
          const glow = ctx.createRadialGradient(p.x, p.y, 0, p.x, p.y, 8);
          glow.addColorStop(0, `rgba(${ORANGE}, ${0.5 * fade})`);
          glow.addColorStop(1, `rgba(${ORANGE}, 0)`);
          ctx.fillStyle = glow;
          ctx.beginPath(); ctx.arc(p.x, p.y, 8, 0, Math.PI * 2); ctx.fill();
          ctx.fillStyle = `rgba(${ORANGE}, ${0.95 * fade})`;
          ctx.beginPath(); ctx.arc(p.x, p.y, 1.8, 0, Math.PI * 2); ctx.fill();
        }
      }
    },
  };

  /* ─────────────────────────────────────────────────────────
     SCENE: social — engagement reactions floating up from a hub
     ───────────────────────────────────────────────────────── */
  const socialScene = {
    bubbles: [], spawnT: 0, originX: 0, originY: 0,
    make() {
      return {
        x: this.originX + rand(-w * 0.12, w * 0.12),
        y: this.originY,
        vy: rand(24, 46),
        phase: rand(0, Math.PI * 2),
        size: rand(7, 14),
        heart: Math.random() < 0.55,
        life: 0, ttl: rand(3.6, 6),
      };
    },
    reset() {
      this.originX = w * 0.68; this.originY = h * 0.92;
      this.bubbles = []; this.spawnT = 0;
      // seed a few mid-flight so the first paint isn't empty
      for (let i = 0; i < 7; i++) {
        const b = this.make();
        b.y = rand(h * 0.2, h * 0.85);
        b.life = rand(0, 2.5);
        this.bubbles.push(b);
      }
    },
    frame(dt) {
      // faint broadcast source at the hub
      const glow = ctx.createRadialGradient(this.originX, this.originY, 0, this.originX, this.originY, 44);
      glow.addColorStop(0, `rgba(${ORANGE}, 0.12)`);
      glow.addColorStop(1, `rgba(${ORANGE}, 0)`);
      ctx.fillStyle = glow;
      ctx.beginPath(); ctx.arc(this.originX, this.originY, 44, 0, Math.PI * 2); ctx.fill();

      this.spawnT -= dt;
      if (this.spawnT <= 0 && this.bubbles.length < 14) {
        this.spawnT = rand(0.35, 0.7);
        this.bubbles.push(this.make());
      }
      for (let i = this.bubbles.length - 1; i >= 0; i--) {
        const b = this.bubbles[i];
        b.life += dt;
        b.y -= b.vy * dt;
        b.x += Math.sin(b.life * 1.6 + b.phase) * 15 * dt;
        const k = b.life / b.ttl;
        if (k >= 1 || b.y < h * 0.1) { this.bubbles.splice(i, 1); continue; }
        const fade = Math.min(1, b.life * 2.2) * clamp(1 - (k - 0.5) / 0.5, 0, 1);
        const s = b.size * (1 + Math.sin(b.life * 4 + b.phase) * 0.09);
        if (b.heart) {
          heart(b.x, b.y, s, `rgba(${ORANGE}, ${(fade * 0.85).toFixed(3)})`);
        } else {
          ctx.fillStyle = `rgba(${ORANGE}, ${(fade * 0.55).toFixed(3)})`;
          ctx.beginPath(); ctx.arc(b.x, b.y, s * 0.42, 0, Math.PI * 2); ctx.fill();
          ctx.strokeStyle = `rgba(${ORANGE}, ${(fade * 0.3).toFixed(3)})`;
          ctx.lineWidth = 1;
          ctx.beginPath(); ctx.arc(b.x, b.y, s * 0.75, 0, Math.PI * 2); ctx.stroke();
        }
      }
    },
  };

  /* ─────────────────────────────────────────────────────────
     SCENE: medical — ECG trace running across monitor paper
     The waveform is evaluated per column from a single `phase`
     counter rather than buffered, so it survives a resize and
     never drifts out of sync with the pulse rings.
     ───────────────────────────────────────────────────────── */
  const medicalScene = {
    phase: 0,        // beats elapsed
    bpm: 64,
    pxPerBeat: 240,
    rings: [],
    lastBeat: -1,
    reset() {
      this.phase = 0.35;   // start mid-beat so the first paint shows a trace
      this.rings = [];
      this.lastBeat = -1;
      this.pxPerBeat = clamp(w * 0.42, 170, 310);
    },
    /** One heartbeat, t ∈ [0,1): P wave, QRS complex, T wave. */
    wave(t) {
      const g = (mu, sigma, amp) => amp * Math.exp(-((t - mu) * (t - mu)) / (2 * sigma * sigma));
      return g(0.120, 0.022, 0.16)    // P
           - g(0.225, 0.008, 0.13)    // Q
           + g(0.250, 0.009, 1.00)    // R
           - g(0.278, 0.012, 0.30)    // S
           + g(0.430, 0.046, 0.30);   // T
    },
    frame(dt) {
      const baseY = h * 0.56;
      const amp   = Math.min(h * 0.21, 118);
      this.phase += dt * (this.bpm / 60);

      const scrolled = this.phase * this.pxPerBeat;

      // ── ECG paper, scrolling with the trace
      const cell = 24;
      ctx.lineWidth = 1;
      ctx.strokeStyle = `rgba(${ORANGE}, 0.055)`;
      ctx.beginPath();
      for (let x = w - (scrolled % cell); x > 0; x -= cell) { ctx.moveTo(x, 0); ctx.lineTo(x, h); }
      for (let y = baseY % cell; y < h; y += cell)          { ctx.moveTo(0, y); ctx.lineTo(w, y); }
      ctx.stroke();

      // ── isoelectric line
      ctx.strokeStyle = `rgba(${INK}, 0.05)`;
      ctx.beginPath(); ctx.moveTo(0, baseY); ctx.lineTo(w, baseY); ctx.stroke();

      const at = (x) => {
        const t = this.phase - (w - x) / this.pxPerBeat;
        return baseY - this.wave(t - Math.floor(t)) * amp;
      };

      // ── pulse rings, emitted as each R peak reaches the leading edge
      const beat = Math.floor(this.phase - 0.25);
      if (beat !== this.lastBeat) {
        this.lastBeat = beat;
        this.rings.push({ y: at(w), r: 6, life: 0 });
      }
      for (let i = this.rings.length - 1; i >= 0; i--) {
        const ring = this.rings[i];
        ring.life += dt;
        ring.r += 78 * dt;
        const fade = clamp(1 - ring.life / 1.15, 0, 1);
        if (fade <= 0) { this.rings.splice(i, 1); continue; }
        ctx.strokeStyle = `rgba(${ORANGE}, ${(fade * 0.34).toFixed(3)})`;
        ctx.lineWidth = 1.4;
        ctx.beginPath(); ctx.arc(w, ring.y, ring.r, 0, Math.PI * 2); ctx.stroke();
      }

      // ── the trace itself, oldest end fading into the page
      const grad = ctx.createLinearGradient(0, 0, w, 0);
      grad.addColorStop(0,    `rgba(${ORANGE}, 0)`);
      grad.addColorStop(0.40, `rgba(${ORANGE}, 0.38)`);
      grad.addColorStop(1,    `rgba(${ORANGE}, 0.95)`);
      ctx.strokeStyle = grad;
      ctx.lineWidth = 2;
      ctx.lineJoin = 'round';
      ctx.lineCap  = 'round';
      ctx.beginPath();
      ctx.moveTo(0, at(0));
      for (let x = 2; x <= w; x += 2) ctx.lineTo(x, at(x));
      ctx.stroke();

      // ── leading dot with a soft halo
      const ly = at(w);
      const halo = ctx.createRadialGradient(w, ly, 0, w, ly, 34);
      halo.addColorStop(0, `rgba(${ORANGE}, 0.30)`);
      halo.addColorStop(1, `rgba(${ORANGE}, 0)`);
      ctx.fillStyle = halo;
      ctx.beginPath(); ctx.arc(w, ly, 34, 0, Math.PI * 2); ctx.fill();
      ctx.fillStyle = `rgba(${ORANGE}, 0.95)`;
      ctx.beginPath(); ctx.arc(w, ly, 3.4, 0, Math.PI * 2); ctx.fill();
    },
  };

  const SCENES = {
    code: codeScene, security: securityScene, support: supportScene,
    network: networkScene, social: socialScene, medical: medicalScene,
  };
  const scene = SCENES[which];
  if (!scene) return;

  /* ── helpers ───────────────────────────────────────────── */
  function roundRect(x, y, ww, hh, r) {
    r = Math.min(r, ww / 2, hh / 2);
    ctx.beginPath();
    ctx.moveTo(x + r, y);
    ctx.arcTo(x + ww, y, x + ww, y + hh, r);
    ctx.arcTo(x + ww, y + hh, x, y + hh, r);
    ctx.arcTo(x, y + hh, x, y, r);
    ctx.arcTo(x, y, x + ww, y, r);
    ctx.closePath();
  }
  function heart(cx, cy, s, style) {
    ctx.fillStyle = style;
    const top = cy - s * 0.35;
    ctx.beginPath();
    ctx.moveTo(cx, cy + s * 0.5);
    ctx.bezierCurveTo(cx - s, cy - s * 0.1, cx - s * 0.6, top - s * 0.5, cx, top);
    ctx.bezierCurveTo(cx + s * 0.6, top - s * 0.5, cx + s, cy - s * 0.1, cx, cy + s * 0.5);
    ctx.closePath();
    ctx.fill();
  }
  // did the angle `target` fall in the arc swept from a→b (handles wrap)?
  function angleBetween(a, b, target) {
    const norm = (x) => (x % (Math.PI * 2) + Math.PI * 2) % (Math.PI * 2);
    a = norm(a); b = norm(b); target = norm(target);
    if (a <= b) return target > a && target <= b;
    return target > a || target <= b;   // wrapped past 0
  }

  /* ── harness ───────────────────────────────────────────── */
  function render(dt) {
    ctx.clearRect(0, 0, w, h);
    scene.frame(dt);
  }
  function frame(now) {
    if (!running) return;
    const dt = Math.min((now - last) / 1000, 0.05);
    last = now; elapsed += dt;
    render(dt);
    raf = requestAnimationFrame(frame);
  }
  function start() {
    if (running || REDUCE) return;
    running = true; last = performance.now();
    raf = requestAnimationFrame(frame);
  }
  function stop() { running = false; if (raf) cancelAnimationFrame(raf); raf = null; }

  function resize() {
    const rect = canvas.getBoundingClientRect();
    if (!rect.width || !rect.height) return;
    dpr = Math.min(window.devicePixelRatio || 1, 2);
    w = rect.width; h = rect.height;
    canvas.width = Math.round(w * dpr);
    canvas.height = Math.round(h * dpr);
    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    elapsed = 0;
    scene.reset();
    render(0);   // paint immediately so there's never a blank flash
  }

  resize();

  let rt = null;
  window.addEventListener('resize', () => { clearTimeout(rt); rt = setTimeout(resize, 180); }, { passive: true });

  if (REDUCE) return; // static frame only

  const host = document.getElementById('svc-hero');
  if (host && 'IntersectionObserver' in window) {
    new IntersectionObserver((entries) => {
      entries.forEach(e => (e.isIntersecting && !document.hidden) ? start() : stop());
    }, { threshold: 0 }).observe(host);
  } else {
    start();
  }
  document.addEventListener('visibilitychange', () => {
    if (document.hidden) stop();
    else if (!host || host.getBoundingClientRect().bottom > 0) start();
  });
})();
