// Quote form (prototype): validation on blur + submit, error summary, file rules. Vanilla JS, no deps.
// Rules mirror ARCHITECTURE §6: email OR phone; files PDF/JPG/PNG/DOCX, <=20 MB, <=5.
(() => {
  const form = document.getElementById('quote-form');
  if (!form) return;
  const $ = (id) => document.getElementById(id);
  const summary = $('error-summary'), summaryList = $('error-summary-list');
  const ORDER = ['nombre', 'email', 'telefono', 'servicio', 'idioma-origen', 'idioma-destino', 'archivos', 'fecha', 'consentimiento'];
  const errors = new Map();        // id -> message (current state)
  const touched = new Set();
  const MAX_FILES = 5, MAX_BYTES = 20 * 1024 * 1024, EXT = ['pdf', 'jpg', 'jpeg', 'png', 'docx'];
  const ICON = '<svg class="icon icon-20" aria-hidden="true"><use href="#i-circle-alert"/></svg>';

  const escapeHtml = (s) => s.replace(/[&<>"]/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]));
  const fmtMB = (b) => (b / 1048576).toFixed(1).replace('.', ',') + ' MB';

  function setError(id, msg) {
    const el = $(id), out = $(id + '-err');
    if (!el || !out) return;
    if (msg) {
      errors.set(id, msg);
      el.setAttribute('aria-invalid', 'true');
      out.innerHTML = ICON + '<span>' + escapeHtml(msg) + '</span>';
    } else {
      errors.delete(id);
      el.removeAttribute('aria-invalid');
      out.innerHTML = '';
    }
    if (el.type === 'file') el.closest('.field').querySelector('.dropzone').classList.toggle('err', !!msg);
    if (!summary.hidden) renderSummary();
  }

  function renderSummary() {
    const ids = ORDER.filter((id) => errors.has(id));
    summary.hidden = ids.length === 0;
    summaryList.innerHTML = ids.map((id) => `<li><a class="link" href="#${id}" data-field="${id}">${escapeHtml(errors.get(id))}</a></li>`).join('');
    $('error-summary-title').textContent = ids.length === 1 ? 'Hay 1 dato por corregir' : `Hay ${ids.length} datos por corregir`;
  }

  // ---- validators (each returns nothing, sets errors) ----
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
  const V = {
    nombre: () => setError('nombre', $('nombre').value.trim() ? '' : 'Escriba su nombre completo.'),
    email: vContact, telefono: vContact,
    servicio: () => setError('servicio', $('servicio').value ? '' : 'Seleccione el servicio que necesita.'),
    'idioma-origen': () => { setError('idioma-origen', $('idioma-origen').value ? '' : 'Seleccione el idioma del documento original.'); vSame(); },
    'idioma-destino': () => { setError('idioma-destino', $('idioma-destino').value ? '' : 'Seleccione el idioma al que debe traducirse.'); vSame(); },
    fecha: () => {
      const d = $('fecha'), bad = !d.disabled && d.value && d.value < d.min;
      setError('fecha', bad ? 'Esa fecha ya pasó. Elija una fecha desde hoy, o marque «Sin urgencia».' : '');
    },
    consentimiento: () => setError('consentimiento', $('consentimiento').checked ? '' : 'Para enviar la solicitud debe aceptar la política de privacidad.'),
  };
  function vSame() {
    const a = $('idioma-origen').value, b = $('idioma-destino').value;
    if (a && a === b) setError('idioma-destino', 'El idioma original y el de destino deben ser distintos.');
    else if (b && errors.get('idioma-destino') === 'El idioma original y el de destino deben ser distintos.') setError('idioma-destino', '');
  }

  // ---- blur validation ----
  Object.keys(V).forEach((id) => {
    const el = $(id);
    el.addEventListener('blur', () => { touched.add(id); V[id](); });
    if (el.tagName === 'SELECT' || el.type === 'checkbox' || el.type === 'date') el.addEventListener('change', () => { touched.add(id); V[id](); });
    else el.addEventListener('input', () => { if (errors.has(id)) V[id](); });   // clear stale errors while fixing
  });
  $('email').addEventListener('input', () => errors.has('telefono') && vContact());
  $('telefono').addEventListener('input', () => errors.has('email') && vContact());

  // ---- language swap ----
  $('swap-idiomas').addEventListener('click', () => {
    const a = $('idioma-origen'), b = $('idioma-destino');
    [a.value, b.value] = [b.value, a.value];
    $('swap-status').textContent = 'Idiomas intercambiados: de ' + (a.selectedOptions[0].text || '—') + ' a ' + (b.selectedOptions[0].text || '—') + '.';
    if (touched.has('idioma-origen') || touched.has('idioma-destino') || errors.has('idioma-origen') || errors.has('idioma-destino')) { V['idioma-origen'](); V['idioma-destino'](); }
  });

  // ---- deadline: min=today, "Sin urgencia" disables the date (value kept) ----
  const fecha = $('fecha'), sin = $('sin-urgencia');
  const t = new Date(); fecha.min = `${t.getFullYear()}-${String(t.getMonth() + 1).padStart(2, '0')}-${String(t.getDate()).padStart(2, '0')}`;
  sin.addEventListener('change', () => { fecha.disabled = sin.checked; V.fecha(); });

  // ---- files ----
  const fileInput = $('archivos');
  function checkFiles() {
    const keep = [], msgs = [];
    [...fileInput.files].forEach((f) => {
      const ext = f.name.split('.').pop().toLowerCase();
      if (!EXT.includes(ext)) msgs.push(`«${f.name}» no es un formato admitido. Use PDF, JPG, PNG o DOCX.`);
      else if (f.size > MAX_BYTES) msgs.push(`«${f.name}» pesa ${fmtMB(f.size)} y el máximo es 20 MB por archivo. Comprímalo o divídalo.`);
      else if (keep.length >= MAX_FILES) msgs.push(`Solo se admiten ${MAX_FILES} archivos; «${f.name}» no se adjuntó. Puede reunir varios en un solo PDF.`);
      else keep.push(f);
    });
    if (msgs.length) {
      const dt = new DataTransfer(); keep.forEach((f) => dt.items.add(f)); fileInput.files = dt.files;
      const w = fileInput.closest('.field'); window.Alpine && window.Alpine.$data(w).sync();   // Alpine ran first: resync its list
      setError('archivos', msgs.join(' '));
      $('archivos-err').setAttribute('role', 'alert');
    } else { setError('archivos', ''); $('archivos-err').removeAttribute('role'); }
    return msgs.length === 0;
  }
  // registered before Alpine starts, so its @change sync() sees the corrected list
  fileInput.addEventListener('change', checkFiles);
  fileInput.closest('.field').querySelector('.dropzone').addEventListener('drop', () => setTimeout(() => {
    checkFiles();
  }));
  fileInput.closest('.field').addEventListener('click', (e) => { if (e.target.closest('ul button')) setTimeout(() => setError('archivos', ''), 0); });

  // ---- submit ----
  function validateAll() {
    touched.add('email'); touched.add('telefono');
    ['nombre', 'email', 'servicio', 'idioma-origen', 'idioma-destino', 'fecha', 'consentimiento'].forEach((id) => V[id]());
    checkFiles();
  }
  const submitBtn = $('enviar'), status = $('submit-status');
  form.addEventListener('submit', (e) => {
    e.preventDefault();
    if ($('web').value) return;                       // honeypot filled: silently drop
    validateAll();
    if (errors.size) {
      renderSummary(); summary.focus(); summary.scrollIntoView({ block: 'center' });
      return;
    }
    summary.hidden = true;
    submitBtn.disabled = true; submitBtn.querySelector('span').textContent = 'Enviando…'; status.textContent = 'Enviando su solicitud…';
    setTimeout(() => { location.href = 'cotizacion-gracias.html'; }, 700);   // prototype: simulated success
  });
  summary.addEventListener('click', (e) => {
    const a = e.target.closest('a[data-field]'); if (!a) return;
    e.preventDefault(); const el = $(a.dataset.field); el.focus(); el.scrollIntoView({ block: 'center' });
  });

  // ---- prefill from the URL: ?origen=xx&destino=yy&servicio=zz (language checker CTA, service pages). Unknown values are ignored. ----
  (() => {
    const q = new URLSearchParams(location.search), done = [];
    const apply = (id, v) => {
      const el = $(id);
      if (!v || v === 'otro' || ![...el.options].some((o) => o.value === v)) return false;
      el.value = v; return true;
    };
    const o = apply('idioma-origen', q.get('origen')), d = apply('idioma-destino', q.get('destino'));
    if (o && d && $('idioma-origen').value === $('idioma-destino').value) { $('idioma-destino').value = ''; }   // same language: keep origin only
    const s = apply('servicio', q.get('servicio'));
    const pair = o && $('idioma-destino').value;
    const note = $('prefill-nota');
    if (o || d) note.querySelector('span').textContent = pair ? 'Hemos completado el par de idiomas que eligió. Puede cambiarlo si lo necesita.' : 'Hemos completado el idioma que eligió. Falta indicar el otro.';
    if (!(o || d) && s) note.querySelector('span').textContent = 'Hemos completado el servicio que eligió. Puede cambiarlo si lo necesita.';
    note.hidden = !(o || d || s);
  })();

  // ---- review toggle: ?estado=errores renders server-style errors with sample input ----
  if (new URLSearchParams(location.search).get('estado') === 'errores') {
    $('estado-aviso').hidden = false;
    $('email').value = 'maria.perez@'; $('idioma-origen').value = 'en'; $('idioma-destino').value = 'en';
    fecha.value = '2024-01-10'; $('mensaje').value = 'Necesito traducir mi título universitario para presentarlo en un consulado.';
    ['email', 'telefono'].forEach((id) => touched.add(id));
    errors.clear();
    setError('nombre', 'Escriba su nombre completo.');
    vContact(); V.servicio(); V.fecha(); V.consentimiento(); vSame();
    setError('archivos', '«escritura-notarial.pdf» pesa 26,0 MB y el máximo es 20 MB por archivo. Comprímalo o divídalo.');
    renderSummary();
  }
})();
