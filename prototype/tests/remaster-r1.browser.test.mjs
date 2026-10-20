// BRG-68 spec tests 9–11: behaviour in a real browser against the built dist/ (run after build.mjs).
import assert from 'node:assert/strict';
import { spawn } from 'node:child_process';
import { createRequire } from 'node:module';
import { homedir } from 'node:os';
import { after, before, test } from 'node:test';
import { fileURLToPath } from 'node:url';

// Same Playwright and pinned Chromium as check.mjs (HANDOFF_v5 trap 1).
const { chromium } = createRequire(import.meta.url)('/home/cheboy04/.npm/_npx/e41f203b7505f1fb/node_modules/playwright');
const port = 4174;
const url = (page) => `http://localhost:${port}/${page}.html`;
let server, browser;

before(async () => {
  server = spawn('python3', ['-m', 'http.server', String(port), '-d', fileURLToPath(new URL('../dist', import.meta.url))], { stdio: 'ignore' });
  await new Promise((r) => setTimeout(r, 800));
  browser = await chromium.launch({ executablePath: `${homedir()}/.cache/ms-playwright/chromium-1234/chrome-linux64/chrome` });
});
after(async () => { await browser?.close(); server?.kill(); });

const open = async (page, { width = 1440, motion = 'reduce' } = {}) => {
  const context = await browser.newContext({ viewport: { width, height: 900 }, reducedMotion: motion });
  const tab = await context.newPage();
  await tab.goto(url(page));
  return tab;
};

test('crossing decorations stay inside their own section', async () => {
  for (const page of ['index', 'traduccion-certificada']) for (const width of [1440, 390]) {
    const tab = await open(page, { width });
    const escaped = await tab.evaluate(() => [...document.querySelectorAll('.r1-crossing-decor')]
      .filter((el) => getComputedStyle(el).display !== 'none')
      .filter((el) => {
        const d = el.getBoundingClientRect(), s = el.closest('section').getBoundingClientRect();
        return d.top < s.top - 1 || d.bottom > s.bottom + 1 || d.left < s.left - 1 || d.right > s.right + 1;
      })
      .map((el) => el.closest('section').getAttribute('aria-labelledby')));
    assert.deepEqual(escaped, [], `${page} @${width}`);
    await tab.context().close();
  }
});

test('Certified slider is operable by drag label, buttons and keyboard', async () => {
  const tab = await open('traduccion-certificada', { motion: 'no-preference' });
  const range = tab.locator('[data-ba-range]');
  await tab.locator('[data-ba-stage]').scrollIntoViewIfNeeded();
  await tab.waitForSelector('.ba[data-ready]');
  assert.ok(await tab.getByText('Deslice', { exact: true }).isVisible(), 'handle label visible before use');
  assert.ok(await tab.locator('[data-ba-howto]').isVisible(), 'how-to visible in slider mode');

  await range.focus();
  await tab.keyboard.press('ArrowRight');
  assert.equal(await tab.getByText('Deslice', { exact: true }).isVisible(), false, 'label collapses after the first keyboard use');

  await tab.getByRole('button', { name: 'Original', exact: true }).click();
  await tab.waitForFunction(() => document.querySelector('[data-ba-range]').value === '100');
  assert.match(await range.getAttribute('aria-valuetext'), /Mostrando el original/);

  await tab.getByRole('button', { name: 'Traducción certificada', exact: true }).click();
  await tab.waitForFunction(() => document.querySelector('[data-ba-range]').value === '0');
  assert.match(await range.getAttribute('aria-valuetext'), /Mostrando la traducción certificada/);

  await range.focus();
  await tab.keyboard.press('ArrowRight');
  assert.equal(await range.inputValue(), '1');
  await tab.context().close();
});

test('reduced motion shows both sheets and no drag instruction', async () => {
  const tab = await open('traduccion-certificada');
  assert.ok(await tab.locator('.ba-orig').isVisible());
  assert.ok(await tab.locator('.ba-cert').isVisible());
  assert.equal(await tab.locator('.ba-cert').evaluate((el) => getComputedStyle(el).clipPath), 'none');
  assert.equal(await tab.locator('[data-ba-jump]').count(), 2, 'jump buttons exist for the slider state');
  assert.equal(await tab.locator('[data-ba-howto]').count(), 1, 'how-to text exists for the slider state');
  assert.equal(await tab.locator('[data-ba-jump]').first().isVisible(), false);
  assert.equal(await tab.locator('[data-ba-howto]').isVisible(), false);
  await tab.context().close();

  const home = await open('index');
  assert.equal(await home.locator('[data-arrival]').getAttribute('data-arrival-state'), 'complete');
  assert.equal(await home.locator('[data-arrival-skip]').isVisible(), false);
  await home.context().close();
});
