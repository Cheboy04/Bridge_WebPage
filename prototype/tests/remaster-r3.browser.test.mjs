// BRG-84 (R3) spec tests: behaviour in a real browser against the built dist/ (run after build.mjs).
import assert from 'node:assert/strict';
import { spawn } from 'node:child_process';
import { readdirSync } from 'node:fs';
import { createRequire } from 'node:module';
import { homedir } from 'node:os';
import { after, before, test } from 'node:test';
import { fileURLToPath } from 'node:url';

// Same Playwright and pinned Chromium as check.mjs (HANDOFF_v5 trap 1). Own port: node --test runs files in parallel.
const { chromium } = createRequire(import.meta.url)('/home/cheboy04/.npm/_npx/e41f203b7505f1fb/node_modules/playwright');
const port = 4176;
const url = (page) => `http://localhost:${port}/${page}`;
const dist = fileURLToPath(new URL('../dist', import.meta.url));
// componentes.html is the internal component gallery, not a site page
const sitePages = () => readdirSync(dist).filter((f) => f.endsWith('.html') && f !== 'componentes.html');
let server, browser;

before(async () => {
  server = spawn('python3', ['-m', 'http.server', String(port), '-d', dist], { stdio: 'ignore' });
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

test('T2 each section shows its heading and first content in one 1440x900 viewport', async () => {
  const problems = [];
  for (const page of sitePages()) {
    const tab = await open(page);
    problems.push(...await tab.evaluate(async () => {
      const out = [];
      const shown = (el) => el.getClientRects().length && !el.closest('.sr-only, [hidden]');
      const sections = new Set([...document.querySelectorAll('main > section, [data-remaster-beat]')]);
      for (const section of sections) {
        const heading = [...section.querySelectorAll('h1, h2')].find(shown);
        if (!heading) continue;
        const after = [...section.querySelectorAll('p, ul, ol, dl, form, figure')]
          .find((el) => shown(el) && !heading.contains(el) && (heading.compareDocumentPosition(el) & Node.DOCUMENT_POSITION_FOLLOWING));
        window.scrollTo({ top: section.getBoundingClientRect().top + window.scrollY, behavior: 'instant' });
        await new Promise((r) => requestAnimationFrame(() => requestAnimationFrame(r)));
        const name = heading.textContent.trim().slice(0, 40);
        if (heading.getBoundingClientRect().bottom > innerHeight) out.push(`heading "${name}" ends below the fold`);
        if (after && after.getBoundingClientRect().top > innerHeight) out.push(`first content under "${name}" starts below the fold`);
      }
      return out;
    }).then((list) => list.map((p) => `${page}: ${p}`)));
    await tab.context().close();
  }
  for (const page of ['index.html', 'traduccion-certificada.html']) {
    const tab = await open(page);
    const low = await tab.evaluate(() => {
      const hero = document.querySelector('h1').closest('section');
      return [hero.querySelector('h1'), hero.querySelector('.lead'), hero.querySelector('.btn-primary')]
        .filter((el) => !el || el.getBoundingClientRect().bottom > innerHeight)
        .map((el) => (el ? el.tagName + '.' + el.className.split(' ')[0] : 'missing element'));
    });
    if (low.length) problems.push(`${page}: hero ${low.join(', ')} below the fold`);
    await tab.context().close();
  }
  assert.deepEqual(problems, []);
});

test('T5 idioma=otro preselects Otro; unknown values are ignored', async () => {
  const cases = [['otro', 'otro'], ['xyz', ''], ['%3Cb%3Ex', '']];
  for (const [query, value] of cases) {
    const tab = await open(`cotizacion-traduccion.html?idioma=${query}`);
    assert.equal(await tab.locator('#idioma-origen').inputValue(), value, `?idioma=${query}`);
    if (!value) assert.ok(await tab.locator('#prefill-nota').isHidden(), `?idioma=${query} shows no note`);
    assert.equal(await tab.locator('#prefill-nota b, #prefill-nota img').count(), 0, `?idioma=${query} injects no markup`);
    await tab.context().close();
  }
  for (const page of ['index.html', 'traduccion-certificada.html']) {
    const tab = await open(page, { javaScriptEnabled: false });
    assert.ok(await tab.locator('[data-list-object="lang-band"] li').count() > 0, `${page}: band renders without JS`);
    await tab.context().close();
  }
});
