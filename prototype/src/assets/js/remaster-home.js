// BRG-68 Home arrival. The HTML is the complete end state; JavaScript only replays the crossing.
(() => {
  const root = document.querySelector('[data-arrival]');
  if (!root) return;

  const controls = root.querySelector('[data-arrival-controls]');
  const skip = root.querySelector('[data-arrival-skip]');
  const replay = root.querySelector('[data-arrival-replay]');
  const fallback = root.querySelector('a.btn');
  const status = root.querySelector('[data-arrival-status]');
  const reducedMotion = matchMedia('(prefers-reduced-motion: reduce)');
  const seenKey = 'bridge-remaster-arrival-seen';
  let timer;

  const remember = () => {
    try { localStorage.setItem(seenKey, '1'); } catch {}
  };

  const hasSeen = () => {
    try { return localStorage.getItem(seenKey) === '1'; } catch { return false; }
  };

  const complete = (announce = false) => {
    const moveFocus = document.activeElement === skip;
    clearTimeout(timer);
    root.dataset.arrivalState = 'complete';
    skip.hidden = true;
    replay.hidden = reducedMotion.matches;
    if (moveFocus) (replay.hidden ? fallback : replay).focus();
    if (announce) status.textContent = 'Recorrido completado: del original a la traducción firmada.';
    remember();
  };

  const play = () => {
    if (reducedMotion.matches) {
      complete();
      return;
    }

    clearTimeout(timer);
    root.dataset.arrivalState = 'ready';
    void root.offsetWidth;
    root.dataset.arrivalState = 'playing';
    skip.hidden = false;
    replay.hidden = true;
    if (document.activeElement === replay) skip.focus();
    status.textContent = '';
    timer = setTimeout(() => complete(), 1600);
  };

  controls.hidden = false;
  skip.addEventListener('click', () => complete(true));
  replay.addEventListener('click', play);
  reducedMotion.addEventListener?.('change', (event) => {
    if (event.matches) complete();
  });

  if (hasSeen() || reducedMotion.matches) complete();
  else play();
})();
