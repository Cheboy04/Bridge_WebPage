// Signature #2 (language-pair checker) and #4 (before/after document). Vanilla JS, no deps. Idempotent.
(() => {
  if (window.__sigDocumento) return;
  window.__sigDocumento = true;

  /* ---------- #2 language-pair checker ---------- */
  const SERVICE = { certificada: 'Traducción certificada', legal: 'Traducción legal', notariada: 'Traducción notariada' };
  const WA = '593990000000'; // placeholder number
  const esc = (s) => String(s).replace(/[&<>"]/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]));
  const ICON = (n) => `<svg class="icon icon-20" aria-hidden="true"><use href="#i-${n}"/></svg>`;

  function loadData(root) {
    const inline = () => { try { return JSON.parse(root.querySelector('[data-lc-data]').textContent).languages; } catch { return []; } };
    // fetch works when served over http; file:// and artifact viewers fall back to the inline copy.
    return fetch('assets/data/languages.json').then((r) => (r.ok ? r.json() : Promise.reject())).then((d) => d.languages).catch(inline);
  }

  function initChecker(root, langs) {
    const by = Object.fromEntries(langs.map((l) => [l.code, l]));
    const o = root.querySelector('[data-lc-origen]'), d = root.querySelector('[data-lc-destino]');
    const out = root.querySelector('[data-lc-result]'), swap = root.querySelector('[data-lc-swap]');
    const name = (c) => (by[c] ? by[c].name : c).toLowerCase();
    const code = (c) => c.toUpperCase();
    const pair = (a, b) => `<span class="lc-pair" aria-hidden="true">${code(a)}<i></i>${code(b)}</span>`;

    function render() {
      const a = o.value, b = d.value;
      d.removeAttribute('aria-invalid'); d.removeAttribute('aria-describedby');
      if (a === b) {
        d.setAttribute('aria-invalid', 'true'); d.setAttribute('aria-describedby', out.id || (out.id = 'lcr-' + Math.random().toString(36).slice(2, 7)));
        out.innerHTML = `<p class="lc-title lc-err">${ICON('circle-alert')}<span>Elija dos idiomas distintos. El documento y su traducción no pueden estar en el mismo idioma.</span></p>`;
        return;
      }
      const A = by[a], B = by[b];
      if (A && B && (a === 'es' || b === 'es')) {
        const services = A.services.filter((s) => B.services.includes(s));
        out.innerHTML = `<p class="lc-title">${pair(a, b)}${ICON('check').replace('class="', 'class="lc-ok ')}<span>Sí, trabajamos ${esc(name(a))} → ${esc(name(b))}</span></p>
          <p class="lc-sub">Servicios disponibles para este par</p>
          <ul class="lc-chips">${services.map((s) => `<li>${SERVICE[s]}</li>`).join('')}</ul>
          <p class="lc-meta">Plazo de entrega: [por confirmar]</p>
          <p><a class="btn btn-primary lc-cta" data-lc-cta href="cotizacion-traduccion.html?origen=${a}&amp;destino=${b}">Cotizar este par<svg class="icon icon-20 icon-go" aria-hidden="true"><use href="#i-arrow-right"/></svg></a></p>`;
      } else {
        const msg = encodeURIComponent(`Hola, quisiera consultar una traducción de ${name(a)} a ${name(b)}.`);
        out.innerHTML = `<p class="lc-title">${pair(a, b)}${ICON('message-circle').replace('class="', 'class="lc-ico ')}<span>Consúltenos: ${esc(name(a))} → ${esc(name(b))}</span></p>
          <p class="lc-sub">Este par no figura entre los habituales. Lo coordinamos con traductores aliados. [validar con Bridge]</p>
          <p><a class="btn btn-primary lc-cta" data-lc-cta href="https://wa.me/${WA}?text=${msg}" target="_blank" rel="noopener">Consultar por WhatsApp${ICON('message-circle').replace('class="', 'class="icon-go ')}<span class="sr-only"> (abre una pestaña nueva)</span></a></p>`;
      }
    }
    o.addEventListener('change', render); d.addEventListener('change', render);
    swap.addEventListener('click', () => { [o.value, d.value] = [d.value, o.value]; render(); });
    [o, d, swap].forEach((el) => el.removeAttribute('disabled'));
    root.setAttribute('data-ready', '');
  }

  document.querySelectorAll('[data-lc]').forEach((root) => {
    // no-JS keeps the static es → en result; with JS, data arrives (fetch or inline) then controls unlock
    loadData(root).then((langs) => initChecker(root, langs));
  });

  /* ---------- #4 before/after ---------- */
  document.querySelectorAll('[data-ba]').forEach((root) => {
    const stage = root.querySelector('[data-ba-stage]'), range = root.querySelector('[data-ba-range]');
    const set = (v) => {
      stage.style.setProperty('--p', v);
      range.setAttribute('aria-valuetext', v >= 98 ? 'Mostrando el original' : v <= 2 ? 'Mostrando la traducción certificada' : `Original ${Math.round(v)} %, traducción certificada ${Math.round(100 - v)} %`);
    };
    range.addEventListener('input', () => { cancelIntro(); set(+range.value); });
    set(+range.value);
    root.setAttribute('data-ready', '');   // CSS decides: slider only when motion is allowed

    // One-time sweep from "original only" to the middle, only when motion is allowed and the stage enters view.
    let raf = 0;
    const cancelIntro = () => raf && (cancelAnimationFrame(raf), (raf = 0));
    if (!matchMedia('(prefers-reduced-motion: no-preference)').matches || !('IntersectionObserver' in window)) return;
    const io = new IntersectionObserver((es) => {
      if (!es.some((e) => e.isIntersecting)) return;
      io.disconnect();
      const t0 = performance.now(), dur = 1100;
      const step = (t) => {
        const k = Math.min(1, (t - t0) / dur), e = 1 - Math.pow(1 - k, 3);
        const v = 100 - 50 * e; range.value = v; set(v);
        raf = k < 1 ? requestAnimationFrame(step) : 0;
      };
      range.value = 100; set(100); raf = requestAnimationFrame(step);
    }, { threshold: 0.55 });
    io.observe(stage);
  });
})();
