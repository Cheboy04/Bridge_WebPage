// BRG-81 spec tests 9–12: behaviour in a real browser against the built dist/ (run after build.mjs).
import assert from 'node:assert/strict';
import { spawn } from 'node:child_process';
import { createRequire } from 'node:module';
import { homedir } from 'node:os';
import { after, before, test } from 'node:test';
import { fileURLToPath } from 'node:url';

// Same Playwright and pinned Chromium as check.mjs (HANDOFF_v5 trap 1). Own port: node --test runs files in parallel.
const { chromium } = createRequire(import.meta.url)('/home/cheboy04/.npm/_npx/e41f203b7505f1fb/node_modules/playwright');
const port = 4175;
const url = (page) => `http://localhost:${port}/${page}.html`;
let server, browser;

before(async () => {
  server = spawn('python3', ['-m', 'http.server', String(port), '-d', fileURLToPath(new URL('../dist', import.meta.url))], { stdio: 'ignore' });
  await new Promise((r) => setTimeout(r, 800));
  browser = await chromium.launch({ executablePath: `${homedir()}/.cache/ms-playwright/chromium-1234/chrome-linux64/chrome` });
});
after(async () => { await browser?.close(); server?.kill(); });

const open = async (page, { width = 1440, motion = 'reduce', javaScriptEnabled = true } = {}) => {
  const context = await browser.newContext({ viewport: { width, height: 900 }, reducedMotion: motion, javaScriptEnabled });
  const tab = await context.newPage();
  await tab.goto(url(page));
  return tab;
};

test('decorations stay inside their section and amber stays on Tinta', async () => {
  for (const page of ['index', 'traduccion-certificada']) for (const width of [1440, 390]) {
    const tab = await open(page, { width });
    const problems = await tab.evaluate(() => {
      const amber = '#e3a148';
      const shown = [...document.querySelectorAll('.r2-seam, .r2-cross, .r2-stop, [data-r2-pair], [data-r2-sheet]')]
        .filter((el) => getComputedStyle(el).display !== 'none');
      if (shown.length < 3) return ['fewer than three R2 decorations rendered'];
      return shown.flatMap((el) => {
          const section = el.closest('[data-remaster-beat]');
          if (!section) return [`${el.className}: outside any chapter`];
          const d = el.getBoundingClientRect(), s = section.getBoundingClientRect();
          const out = [];
          if (d.top < s.top - 1 || d.bottom > s.bottom + 1 || d.left < s.left - 1 || d.right > s.right + 1) out.push(`${el.className}: escapes ${section.dataset.remasterBeat}`);
          const trail = getComputedStyle(el).getPropertyValue('--trail').trim().toLowerCase();
          if (el.matches('.r2-seam, .r2-stop') && trail === amber && section.dataset.ground !== 'tinta') out.push(`${el.className}: amber on ${section.dataset.ground}`);
          return out;
        });
    });
    assert.deepEqual(problems, [], `${page} @${width}`);
    await tab.context().close();
  }
});

test('the pair headline follows the checker', async () => {
  for (const page of ['index', 'traduccion-certificada']) {
    const tab = await open(page);
    const pair = tab.locator('[data-r2-pair]');
    const origin = tab.locator('[data-lc-origen]');
    await tab.waitForSelector('[data-lc-origen]:enabled');
    assert.match(await pair.innerText(), /español\s*·+\s*inglés/i, `${page}: static pair`);
    await origin.selectOption('fr');
    await tab.locator('[data-lc-destino]').selectOption('es');
    await tab.waitForFunction(() => /francés[\s·]+español/i.test(document.querySelector('[data-r2-pair]').textContent));
    await tab.locator('[data-lc-swap]').click();
    await tab.waitForFunction(() => /español[\s·]+francés/i.test(document.querySelector('[data-r2-pair]').textContent));
    await tab.context().close();
  }
});

test('institution tabs work by keyboard', async () => {
  const tab = await open('traduccion-certificada');
  const tabs = tab.getByRole('tab');
  assert.equal(await tabs.count(), 4);
  const visiblePanels = () => tab.locator('[role="tabpanel"]:visible').count();
  assert.equal(await visiblePanels(), 1);
  assert.equal(await tabs.nth(0).getAttribute('aria-selected'), 'true');

  await tabs.nth(0).focus();
  await tab.keyboard.press('ArrowRight');
  assert.equal(await tabs.nth(1).getAttribute('aria-selected'), 'true');
  assert.equal(await tabs.nth(0).getAttribute('aria-selected'), 'false');
  assert.equal(await tab.evaluate(() => document.activeElement.getAttribute('role')), 'tab');
  assert.ok(await tab.locator(`#${await tabs.nth(1).getAttribute('aria-controls')}`).isVisible());
  assert.equal(await visiblePanels(), 1);

  await tab.keyboard.press('End');
  assert.equal(await tabs.nth(3).getAttribute('aria-selected'), 'true');
  await tab.keyboard.press('ArrowRight');
  assert.equal(await tabs.nth(0).getAttribute('aria-selected'), 'true', 'arrow keys wrap');
  assert.equal(await visiblePanels(), 1);
  await tab.context().close();

  const noScript = await open('traduccion-certificada', { javaScriptEnabled: false });
  assert.equal(await noScript.locator('[role="tablist"]:visible').count(), 0, 'no tablist without JS');
  assert.equal(await noScript.locator('[data-r2-tabs] [data-r2-panel]:visible').count(), 4, 'every panel listed without JS');
  await noScript.context().close();
});

test('the sheet follows the steps, and is complete at rest', async () => {
  for (const [page, last] of [['index', '3'], ['traduccion-certificada', '4']]) {
    const moving = await open(page, { motion: 'no-preference' });
    const sheet = moving.locator('[data-r2-sheet]');
    await moving.locator('[data-r2-step="1"]').evaluate((el) => el.scrollIntoView({ block: 'center' }));
    await moving.waitForFunction(() => document.querySelector('[data-r2-sheet]').dataset.step === '1');
    await moving.locator('[data-r2-step="3"]').evaluate((el) => el.scrollIntoView({ block: 'center' }));
    await moving.waitForFunction(() => document.querySelector('[data-r2-sheet]').dataset.step === '3');
    assert.equal(await sheet.getAttribute('data-step'), '3', page);
    await moving.context().close();

    const still = await open(page);
    await still.locator('[data-r2-step="1"]').evaluate((el) => el.scrollIntoView({ block: 'center' }));
    await still.waitForTimeout(300);
    assert.equal(await still.locator('[data-r2-sheet]').getAttribute('data-step'), last, `${page}: reduced motion keeps the complete sheet`);
    const running = await still.evaluate(() => document.getAnimations().filter((a) => a.playState === 'running' && a.constructor.name === 'CSSAnimation').length);
    assert.equal(running, 0, `${page}: nothing animates under reduced motion`);
    await still.context().close();

    const noScript = await open(page, { javaScriptEnabled: false });
    assert.equal(await noScript.locator('[data-r2-sheet]').getAttribute('data-step'), last, `${page}: complete without JS`);
    await noScript.context().close();
  }
});
