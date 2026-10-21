// BRG-81 R2 behaviour (spec §3.4). The HTML is the complete state; this only enhances it.
(() => {
  if (window.__bridgeR2) return;
  window.__bridgeR2 = true;
  const reducedMotion = matchMedia('(prefers-reduced-motion: reduce)');

  // Live pair: mirrors the checker's selects into the aria-hidden monument. The checker re-renders its
  // result on every change and swap, so watching the result catches both without touching the checker.
  document.querySelectorAll('[data-r2-pair]').forEach((pair) => {
    const checker = pair.closest('section')?.querySelector('[data-lc]');
    if (!checker) return;
    const from = pair.querySelector('[data-r2-from]'), to = pair.querySelector('[data-r2-to]');
    const name = (select) => select.selectedOptions[0]?.textContent.toLocaleLowerCase('es') ?? '';
    const update = () => {
      const next = [name(checker.querySelector('[data-lc-origen]')), name(checker.querySelector('[data-lc-destino]'))];
      if (from.textContent === next[0] && to.textContent === next[1]) return;
      [from.textContent, to.textContent] = next;
      if (!reducedMotion.matches) pair.animate([{ opacity: 0.35, transform: 'translateY(0.4rem)' }, { opacity: 1, transform: 'none' }], { duration: 200, easing: 'cubic-bezier(.2,0,0,1)' });
    };
    new MutationObserver(update).observe(checker.querySelector('[data-lc-result]'), { childList: true, subtree: true, characterData: true });
    checker.addEventListener('change', update);
  });

  // Index tabs: ARIA tabs with automatic activation. Without JS the tablist stays hidden and every panel shows.
  document.querySelectorAll('[data-r2-tabs]').forEach((root) => {
    const list = root.querySelector('[data-r2-tablist]');
    const tabs = [...list.querySelectorAll('[data-r2-tab]')];
    const panel = (tab) => document.getElementById(tab.getAttribute('aria-controls'));
    const select = (index, focus) => {
      tabs.forEach((tab, i) => {
        tab.setAttribute('aria-selected', String(i === index));
        tab.tabIndex = i === index ? 0 : -1;
        panel(tab).hidden = i !== index;
      });
      if (focus) tabs[index].focus();
    };
    list.setAttribute('role', 'tablist');
    tabs.forEach((tab, i) => {
      tab.setAttribute('role', 'tab');
      panel(tab).setAttribute('role', 'tabpanel');
      panel(tab).setAttribute('aria-labelledby', tab.id);
      panel(tab).tabIndex = 0;
      tab.addEventListener('click', () => select(i, false));
    });
    list.addEventListener('keydown', (event) => {
      const at = tabs.indexOf(document.activeElement);
      const next = { ArrowRight: at + 1, ArrowLeft: at - 1, Home: 0, End: tabs.length - 1 }[event.key];
      if (at < 0 || next === undefined) return;
      event.preventDefault();
      select((next + tabs.length) % tabs.length, true);
    });
    root.dataset.enhanced = '';
    list.hidden = false;
    select(0, false);
  });

  // Sticky sheet: the step in the middle of the viewport sets the sheet's state. Reduced motion keeps the last step.
  if (reducedMotion.matches) return;
  document.querySelectorAll('[data-r2-sheet]').forEach((sheet) => {
    const steps = sheet.closest('[data-list-object="sticky-sheet"]').querySelectorAll('[data-r2-step]');
    const observer = new IntersectionObserver((entries) => entries.forEach((entry) => {
      if (entry.isIntersecting) sheet.dataset.step = entry.target.dataset.r2Step;
    }), { rootMargin: '-45% 0px -45% 0px' });
    steps.forEach((step) => observer.observe(step));
  });
})();
