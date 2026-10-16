// Event quote form (prototype): same validation pattern as quote-form.js (blur + submit, error summary), plus prefill from the event planner.
// Rules mirror ARCHITECTURE §6: email OR phone. Query params (Livewire #[Url] later): modalidad, duracion, dias, idiomas, asistentes. Invalid values are ignored.
(() => {
  const form = document.getElementById('quote-form');
  if (!form) return;
  const $ = (id) => document.getElementById(id);
  const summary = $('error-summary'), summaryList = $('error-summary-list');
  const ORDER = ['nombre', 'email', 'telefono', 'servicio', 'fecha', 'fecha-fin', 'modalidad', 'duracion', 'dias', 'idiomas', 'asistentes', 'consentimiento'];
  const errors = new Map();
  const touched = new Set();
  const ICON = '<svg class="icon icon-20" aria-hidden="true"><use href="#i-circle-alert"/></svg>';
  const escapeHtml = (s) => s.replace(/[&<>"]/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]));
  const today = (() => { const t = new Date(); return `${t.getFullYear()}-${String(t.getMonth() + 1).padStart(2, '0')}-${String(t.getDate()).padStart(2, '0')}`; })();
  $('fecha').min = today; $('fecha-fin').min = today;
  $('asistentes').min = 1; $('asistentes').max = 5000; $('asistentes').inputMode = 'numeric';
  $('dias').min = 2; $('dias').max = 30; $('dias').inputMode = 'numeric';

  function setError(id, msg) {
    const el = $(id), out = $(id + '-err');
    if (!el || !out) return;
    if (msg) { errors.set(id, msg); el.setAttribute('aria-invalid', 'true'); out.innerHTML = ICON + '<span>' + escapeHtml(msg) + '</span>'; }
    else { errors.delete(id); el.removeAttribute('aria-invalid'); out.innerHTML = ''; }
    if (!summary.hidden) renderSummary();
  }
  function renderSummary() {
    const ids = ORDER.filter((id) => errors.has(id));
    summary.hidden = ids.length === 0;
    summaryList.innerHTML = ids.map((id) => `<li><a class="link" href="#${id}" data-field="${id}">${escapeHtml(errors.get(id))}</a></li>`).join('');
    $('error-summary-title').textContent = ids.length === 1 ? 'Hay 1 dato por corregir' : `Hay ${ids.length} datos por corregir`;
  }

  const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
  function vContact() {
    const e = $('email').value.trim(), p = $('telefono').value.trim();
    let em = '', pm = '';
    if (e && !emailRe.test(e)) em = 'El correo no parece válido. Revise que tenga la forma nombre@dominio.com.';
    if (p && p.replace(/\D/g, '').length < 7) pm = 'El teléfono es muy corto. Escríbalo con código de país, por ejemplo +593 99 000 0000.';
    if (!e && !p && touched.has('email') && touched.has('telefono')) {
      em = 'Indique un correo o un teléfono para poder responderle.';
      pm = 'Indique un teléfono o un correo para poder responderle.';
    }
    setError('email', em); setError('telefono', pm);
  }
  const intIn = (el, lo, hi) => /^\d+$/.test(el.value.trim()) && +el.value >= lo && +el.value <= hi;
  function vFechas() {
    const a = $('fecha').value, b = $('fecha-fin').value;
    setError('fecha', a && a < today ? 'Esa fecha ya pasó. Elija una fecha desde hoy o déjela en blanco.' : '');
    setError('fecha-fin', b && b < today ? 'Esa fecha ya pasó. Elija una fecha desde hoy o déjela en blanco.' : (a && b && b < a ? 'La fecha de cierre debe ser igual o posterior a la fecha del evento.' : ''));
  }
  const V = {
    nombre: () => setError('nombre', $('nombre').value.trim() ? '' : 'Escriba su nombre completo.'),
    email: vContact, telefono: vContact,
    servicio: () => setError('servicio', $('servicio').value ? '' : 'Seleccione el servicio que necesita.'),
    fecha: vFechas, 'fecha-fin': vFechas,
    modalidad: () => setError('modalidad', $('modalidad').value ? '' : 'Seleccione cómo será el evento: presencial, híbrido o remoto.'),
    duracion: () => { setError('duracion', $('duracion').value ? '' : 'Seleccione cuánto dura el evento.'); },
    dias: () => setError('dias', $('dias-wrap').hidden || intIn($('dias'), 2, 30) ? '' : 'Indique cuántos días dura el evento, de 2 a 30.'),
    idiomas: () => setError('idiomas', $('idiomas').value ? '' : 'Seleccione cuántos idiomas necesita además del español.'),
    asistentes: () => setError('asistentes', intIn($('asistentes'), 1, 5000) ? '' : 'Indique cuántas personas asistirán, con un número entre 1 y 5000.'),
    consentimiento: () => setError('consentimiento', $('consentimiento').checked ? '' : 'Para enviar la solicitud debe aceptar la política de privacidad.'),
  };

  function syncDays() { $('dias-wrap').hidden = $('duracion').value !== 'varios'; }
  $('duracion').addEventListener('change', () => { syncDays(); if (errors.has('dias')) V.dias(); });

  Object.keys(V).forEach((id) => {
    const el = $(id);
    el.addEventListener('blur', () => { touched.add(id); V[id](); });
    if (el.tagName === 'SELECT' || el.type === 'checkbox' || el.type === 'date') el.addEventListener('change', () => { touched.add(id); V[id](); });
    else el.addEventListener('input', () => { if (errors.has(id)) V[id](); });
  });
  $('email').addEventListener('input', () => errors.has('telefono') && vContact());
  $('telefono').addEventListener('input', () => errors.has('email') && vContact());

  // ---- prefill from the planner (valid values only) ----
  const qs = new URLSearchParams(location.search);
  let filled = 0;
  const pick = (id, v, ok) => { if (ok) { $(id).value = v; filled++; return true; } return false; };
  const mod = qs.get('modalidad'), dur = qs.get('duracion');
  pick('modalidad', mod, ['presencial', 'hibrido', 'remoto'].includes(mod));
  const durOk = pick('duracion', dur, ['medio', 'jornada', 'varios'].includes(dur));
  syncDays();
  if (durOk && dur === 'varios') pick('dias', qs.get('dias'), /^\d+$/.test(qs.get('dias') || '') && +qs.get('dias') >= 2 && +qs.get('dias') <= 30);
  pick('idiomas', qs.get('idiomas'), ['1', '2', '3', '4'].includes(qs.get('idiomas')));
  pick('asistentes', qs.get('asistentes'), /^\d+$/.test(qs.get('asistentes') || '') && +qs.get('asistentes') >= 1 && +qs.get('asistentes') <= 5000);
  if (['presencial', 'hibrido', 'remoto'].includes(mod)) {   // equipment the planner's rules would add
    const room = mod !== 'remoto', online = mod !== 'presencial';
    $('need-cabinas').checked = room; $('need-receptores').checked = room; $('need-tecnico').checked = room; $('need-plataforma').checked = online;
  }
  if (filled) $('prefill-note').hidden = false;

  // ---- submit ----
  function validateAll() {
    touched.add('email'); touched.add('telefono');
    ['nombre', 'email', 'servicio', 'fecha', 'modalidad', 'duracion', 'dias', 'idiomas', 'asistentes', 'consentimiento'].forEach((id) => V[id]());
  }
  const submitBtn = $('enviar'), status = $('submit-status');
  form.addEventListener('submit', (e) => {
    e.preventDefault();
    if ($('web').value) return;
    validateAll();
    if (errors.size) { renderSummary(); summary.focus(); summary.scrollIntoView({ block: 'center' }); return; }
    summary.hidden = true;
    submitBtn.disabled = true; submitBtn.querySelector('span').textContent = 'Enviando…'; status.textContent = 'Enviando su solicitud…';
    setTimeout(() => { location.href = 'cotizacion-gracias.html'; }, 700);
  });
  summary.addEventListener('click', (e) => {
    const a = e.target.closest('a[data-field]'); if (!a) return;
    e.preventDefault(); const el = $(a.dataset.field); el.focus(); el.scrollIntoView({ block: 'center' });
  });

  // ---- review toggle: ?estado=errores ----
  if (qs.get('estado') === 'errores') {
    $('estado-aviso').hidden = false;
    $('email').value = 'carlos.mena@'; $('fecha').value = '2024-01-10'; $('modalidad').value = 'hibrido'; $('duracion').value = 'varios'; $('dias').value = '1'; $('asistentes').value = '0';
    $('mensaje').value = 'Es una jornada de capacitación con dos salas en paralelo.';
    syncDays();
    ['email', 'telefono'].forEach((id) => touched.add(id));
    errors.clear();
    setError('nombre', 'Escriba su nombre completo.');
    vContact(); V.servicio(); vFechas(); V.dias(); V.idiomas(); V.asistentes(); V.consentimiento();
    renderSummary();
  }
})();
