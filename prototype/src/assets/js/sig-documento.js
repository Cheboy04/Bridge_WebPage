// Signature #4 (before/after document); the #2 pair checker was replaced by the R3 language band (BRG-84). Vanilla JS, no deps. Idempotent.
(() => {
  if (window.__sigDocumento) return;
  window.__sigDocumento = true;

  /* ---------- #4 before/after ---------- */
  document.querySelectorAll('[data-ba]').forEach((root) => {
    const stage = root.querySelector('[data-ba-stage]'), range = root.querySelector('[data-ba-range]');
    const set = (v) => {
      stage.style.setProperty('--p', v);
      range.setAttribute('aria-valuetext', v >= 98 ? 'Mostrando el original' : v <= 2 ? 'Mostrando la traducción certificada' : `Original ${Math.round(v)} %, traducción certificada ${Math.round(100 - v)} %`);
    };
    // Ease-out cubic glide of the divider; any user input cancels it.
    let raf = 0;
    const cancel = () => raf && (cancelAnimationFrame(raf), (raf = 0));
    const glide = (to, dur) => {
      cancel();
      const from = +range.value, t0 = performance.now();
      const step = (t) => {
        const k = Math.min(1, (t - t0) / dur), e = 1 - Math.pow(1 - k, 3);
        const v = from + (to - from) * e; range.value = v; set(v);
        raf = k < 1 ? requestAnimationFrame(step) : 0;
      };
      raf = requestAnimationFrame(step);
    };
    const touched = () => root.setAttribute('data-touched', '');   // collapses the "Deslice" label
    range.addEventListener('input', () => { cancel(); touched(); set(+range.value); });
    root.querySelectorAll('[data-ba-jump]').forEach((b) => b.addEventListener('click', () => { touched(); glide(+b.dataset.baJump, 600); }));
    set(+range.value);
    root.setAttribute('data-ready', '');   // CSS decides: slider only when motion is allowed

    // One-time sweep from "original only" to the middle, only when motion is allowed and the stage enters view.
    if (!matchMedia('(prefers-reduced-motion: no-preference)').matches || !('IntersectionObserver' in window)) return;
    const io = new IntersectionObserver((es) => {
      if (!es.some((e) => e.isIntersecting)) return;
      io.disconnect();
      if (root.hasAttribute('data-touched')) return;
      range.value = 100; set(100); glide(50, 1100);
    }, { threshold: 0.55 });
    io.observe(stage);
  });
})();
