// BRG-81 R2 behaviour (spec §3.4). The HTML is the complete state; this only enhances it.
(() => {
  if (window.__bridgeR2) return;
  window.__bridgeR2 = true;
  const reducedMotion = matchMedia('(prefers-reduced-motion: reduce)');

  // Index tabs: ARIA tabs with automatic activation. Without JS the tablist stays hidden and every panel shows.
  document.querySelectorAll('[data-r2-tabs]').forEach((root) => {
    const list = root.querySelector('[data-r2-tablist]');
    if (!list) return;
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
    const steps = sheet.closest('[data-list-object="sticky-sheet"]')?.querySelectorAll('[data-r2-step]') ?? [];
    if (!steps.length) return;
    sheet.dataset.step = '1'; // the story starts from the request; the HTML keeps the complete sheet for no-JS
    const observer = new IntersectionObserver((entries) => entries.forEach((entry) => {
      if (entry.isIntersecting) sheet.dataset.step = entry.target.dataset.r2Step;
    }), { rootMargin: '-45% 0px -45% 0px' });
    steps.forEach((step) => observer.observe(step));
  });
})();
