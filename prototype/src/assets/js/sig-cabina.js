// Signature #3, event planner. Vanilla JS. Rules are EXAMPLE rules [validar con Bridge]; keep in sync with SIGNATURE-COMPONENTS.md section 3.
(() => {
  const root = document.querySelector('[data-planner]');
  if (!root) return;
  const $ = (id) => document.getElementById(id);
  const q = (n) => root.querySelector(`[name="${n}"]:checked`);
  const num = (el, lo, hi, dflt) => { const v = Math.round(Number(el.value)); return Number.isFinite(v) && el.value !== '' ? Math.min(hi, Math.max(lo, v)) : dflt; };
  const MOD = { presencial: 'Presencial', hibrido: 'Híbrido', remoto: 'Remoto' };
  const DUR = { medio: 'medio día', jornada: 'jornada completa', varios: 'varios días' };
  const el = { dias: $('plan-dias'), idi: $('plan-idiomas'), asi: $('plan-asistentes'), rng: $('plan-asistentes-r'), cta: $('plan-cta'), live: $('plan-live') };
  const plural = (n, one, many) => (n === 1 ? one : many);
  let first = true, timer;

  // Pure rules (also what the server-rendered default shows).
  function calc(s) {
    const room = s.modalidad !== 'remoto', online = s.modalidad !== 'presencial';
    const long = s.duracion !== 'medio';                    // más de 6 h
    return {
      interpretes: Math.ceil(2 * s.idiomas * (long ? 1.5 : 1)),
      cabinas: room ? s.idiomas : 0,
      receptores: room ? Math.ceil(s.asistentes * 1.1) : 0,
      plataforma: online,
      tecnico: room ? 1 : 0,
      room, long,
    };
  }
  function read() {
    const duracion = q('duracion').value;
    return { modalidad: q('modalidad').value, duracion, dias: duracion === 'varios' ? num(el.dias, 2, 30, 2) : 1, idiomas: num(el.idi, 1, 4, 1), asistentes: num(el.asi, 20, 1000, 120) };
  }
  function set(id, v) { const n = $(id); if (n.textContent !== String(v)) { n.textContent = v; n.classList.remove('tick'); void n.offsetWidth; n.classList.add('tick'); } }

  function render() {
    const s = read(), r = calc(s);
    root.querySelector('[data-days]').hidden = s.duracion !== 'varios';
    set('o-interpretes', r.interpretes);
    $('n-interpretes').textContent = '2 por idioma, por turnos' + (r.long ? ', más 50% por jornada larga' : '') + (s.duracion === 'varios' ? `. Por jornada, durante ${s.dias} días` : '');
    $('row-cabinas').hidden = !r.room; set('o-cabinas', r.cabinas); $('l-cabinas').textContent = plural(r.cabinas, 'cabina', 'cabinas');
    $('row-receptores').hidden = !r.room; set('o-receptores', r.receptores); $('n-receptores').textContent = `${s.asistentes} asistentes y 10% de margen`;
    $('row-plataforma').hidden = !r.plataforma;
    $('row-tecnico').hidden = !r.room;
    $('plan-remoto').hidden = r.room;
    const idi = `español y ${s.idiomas} ${plural(s.idiomas, 'idioma', 'idiomas')}`;
    $('plan-resumen').textContent = `${MOD[s.modalidad]} · ${DUR[s.duracion]}${s.duracion === 'varios' ? ` (${s.dias})` : ''} · ${idi} · ${s.asistentes} asistentes`;
    const qs = new URLSearchParams({ modalidad: s.modalidad, duracion: s.duracion, dias: s.dias, idiomas: s.idiomas, asistentes: s.asistentes });
    el.cta.href = 'cotizacion-interpretacion.html?' + qs;
    el.rng.style.setProperty('--p', ((Math.min(1000, Math.max(20, s.asistentes)) - 20) / 980 * 100).toFixed(1) + '%');
    el.rng.setAttribute('aria-valuetext', `${s.asistentes} asistentes`);
    // polite, debounced: one summary after the user pauses, never on load
    if (first) { first = false; return; }
    clearTimeout(timer);
    timer = setTimeout(() => {
      const parts = [`${r.interpretes} intérpretes`];
      if (r.room) parts.push(`${r.cabinas} ${plural(r.cabinas, 'cabina', 'cabinas')}`, `${r.receptores} receptores`);
      if (r.plataforma) parts.push('plataforma con canales de idioma');
      if (r.room) parts.push('1 técnico en sala');
      el.live.textContent = 'Resumen actualizado: ' + parts.join(', ') + '.';
    }, 800);
  }

  root.querySelectorAll('input[type=radio]').forEach((i) => i.addEventListener('change', render));
  el.dias.addEventListener('input', render);
  el.idi.addEventListener('input', render);
  el.rng.addEventListener('input', () => { el.asi.value = el.rng.value; render(); });
  el.asi.addEventListener('input', () => { if (el.asi.value !== '') { el.rng.value = num(el.asi, 20, 1000, 120); render(); } });
  // clamp on blur so the visible field never keeps an out-of-range value
  el.asi.addEventListener('blur', () => { el.asi.value = num(el.asi, 20, 1000, 120); render(); });
  el.idi.addEventListener('blur', () => { el.idi.value = num(el.idi, 1, 4, 1); render(); });
  el.dias.addEventListener('blur', () => { el.dias.value = num(el.dias, 2, 30, 2); render(); });
  root.querySelectorAll('[data-step]').forEach((b) => b.addEventListener('click', () => { el.idi.value = num({ value: num(el.idi, 1, 4, 1) + Number(b.dataset.step) }, 1, 4, 1); render(); }));
  render();
})();
