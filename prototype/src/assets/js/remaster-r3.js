// BRG-84 R3 behaviour (spec §3.3–3.4). The HTML is the complete state; this only enhances it.
(() => {
  if (window.__bridgeR3) return;
  window.__bridgeR3 = true;
  const motion = matchMedia('(prefers-reduced-motion: no-preference)');

  // Hero tiles: CSS moves them only under [data-r3-moving]; hover and focus pause in CSS, the button pauses here (WCAG 2.2.2).
  document.querySelectorAll('[data-r3-tiles]').forEach((root) => {
    const button = root.querySelector('[data-r3-tiles-pause]');
    const sync = () => {
      root.toggleAttribute('data-r3-moving', motion.matches);
      button.hidden = !motion.matches;
    };
    button.addEventListener('click', () => button.setAttribute('aria-pressed', String(root.toggleAttribute('data-paused'))));
    motion.addEventListener('change', sync);
    sync();
  });
})();
