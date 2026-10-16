// Signature #1 hero stage. Progressive enhancement: markup is complete without this file.
(() => {
  const root = document.querySelector('[data-hero]');
  if (!root) return;
  const tabs = [...root.querySelectorAll('[role=tab]')];
  const panels = { doc: root.querySelector('[data-panel=doc]'), evt: root.querySelector('[data-panel=evt]') };
  const ids = ['doc', 'evt'];
  const motion = () => !matchMedia('(prefers-reduced-motion: reduce)').matches;
  const KEY = 'bridge-hero-tab';
  const T = { // verified translations of one sentence
    es: ['Canal 1 · Español', 'Las partes acuerdan los términos del presente contrato.', 'Canal español'],
    en: ['Canal 2 · English', 'The parties agree to the terms of this contract.', 'Canal inglés'],
    fr: ['Canal 3 · Français', 'Les parties conviennent des termes du présent contrat.', 'Canal francés'],
    pt: ['Canal 4 · Português', 'As partes concordam com os termos do presente contrato.', 'Canal portugués'],
  };
  const doc = panels.doc.querySelector('.doc');
  const replay = root.querySelector('.hero-replay');
  const live = root.querySelector('#hero-live');
  const cap = root.querySelector('#hero-caption');
  const capLabel = root.querySelector('#hero-cap-label');

  function play() {
    doc.classList.remove('is-playing');
    if (!motion()) return; // reduced motion: static final state
    void doc.offsetWidth;
    doc.classList.add('is-playing');
  }
  function select(id, focus, remember) {
    ids.forEach((k, i) => {
      const on = k === id;
      tabs[i].setAttribute('aria-selected', on);
      tabs[i].tabIndex = on ? 0 : -1;
      panels[k].hidden = !on;
    });
    if (focus) tabs[ids.indexOf(id)].focus();
    if (remember) { try { sessionStorage.setItem(KEY, id); } catch {} }
    if (id === 'doc') play();
  }
  function setLang(code, user) {
    const [label, text, say] = T[code];
    root.querySelectorAll('.chip').forEach((b) => b.setAttribute('aria-pressed', b.dataset.lang === code));
    const swap = () => { cap.lang = code; cap.textContent = text; capLabel.textContent = label; };
    if (!motion()) swap();
    else { cap.classList.add('is-out'); setTimeout(() => { swap(); cap.classList.remove('is-out'); }, 120); }
    if (user) live.textContent = say; // announce user-initiated changes only
  }

  root.dataset.js = '';
  tabs.forEach((t, i) => {
    t.addEventListener('click', () => select(ids[i], false, true));
    t.addEventListener('keydown', (e) => {
      const n = { ArrowRight: i + 1, ArrowLeft: i - 1, Home: 0, End: 1 }[e.key];
      if (n === undefined) return;
      e.preventDefault();
      select(ids[(n + 2) % 2], true, true);
    });
  });
  root.querySelectorAll('.chip').forEach((b) => b.addEventListener('click', () => setLang(b.dataset.lang, true)));
  replay.hidden = false;
  replay.addEventListener('click', play);

  let start = 'doc';
  try { const s = sessionStorage.getItem(KEY); if (ids.includes(s)) start = s; } catch {}
  select(start, false, false);
})();
