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

test('T7 tiles move, pause on hover, focus and button, and stand still under reduced motion', async () => {
  const cols = (tab) => tab.locator('.r3-tiles-col').evaluateAll((els) => els.map((el) => getComputedStyle(el)));
  const states = (tab) => tab.locator('.r3-tiles-col').evaluateAll((els) => els.map((el) => getComputedStyle(el).animationPlayState));
  const real = '.r3-tile:not([data-tile-copy])';

  const tab = await open('index.html', { motion: 'no-preference' });
  const pause = tab.locator('[data-r3-tiles-pause]');
  assert.ok(await pause.isVisible(), 'pause button shown with JS and motion');
  assert.ok((await tab.locator('.r3-tiles-col').evaluateAll((els) => els.map((el) => getComputedStyle(el).animationName))).every((n) => n !== 'none'), 'columns animate');
  assert.ok((await states(tab)).every((s) => s === 'running'), 'running at rest');
  await tab.locator(`${real}[data-tile="ia"]`).hover({ force: true }); // a moving tile is never "stable"
  assert.ok((await states(tab)).every((s) => s === 'paused'), 'hover pauses');
  await tab.mouse.move(5, 890);
  await tab.locator(`${real}[data-tile="traduccion"]`).focus();
  assert.ok((await states(tab)).every((s) => s === 'paused'), 'focus pauses');
  await tab.evaluate(() => document.activeElement.blur());
  assert.ok((await states(tab)).every((s) => s === 'running'), 'running again');
  await pause.click();
  await tab.mouse.move(5, 890);
  await tab.evaluate(() => document.activeElement.blur());
  assert.equal(await pause.getAttribute('aria-pressed'), 'true');
  assert.ok((await states(tab)).every((s) => s === 'paused'), 'the button pauses');

  // keyboard: each real tile link once, never a copy
  await tab.locator('#hero-title').evaluate((el) => { el.tabIndex = -1; el.focus(); });
  const reached = [];
  for (let i = 0; i < 12; i++) {
    await tab.keyboard.press('Tab');
    const info = await tab.evaluate(() => {
      const el = document.activeElement;
      return { inHero: !!el.closest('[data-remaster-beat="arrival"]'), tile: el.dataset.tile ?? null, copy: el.closest('[data-tile-copy]') !== null };
    });
    if (!info.inHero) break;
    assert.equal(info.copy, false, 'a copy took focus');
    if (info.tile) reached.push(info.tile);
  }
  assert.deepEqual(reached, ['traduccion', 'interpretacion']);
  await tab.context().close();

  for (const [label, options] of [['reduced motion', { motion: 'reduce' }], ['no JS', { motion: 'no-preference', javaScriptEnabled: false }]]) {
    const still = await open('index.html', options);
    assert.ok((await cols(still)).every((s) => s.animationName === 'none'), `${label}: no animation`);
    for (const t of await still.locator(real).all()) assert.ok(await t.isVisible(), `${label}: ${await t.getAttribute('data-tile')} visible`);
    assert.equal(await still.locator(real).count(), 6);
    assert.equal(await still.locator('[data-tile-copy]').first().isVisible(), false, `${label}: copies hidden`);
    if (label === 'no JS') assert.equal(await still.locator('[data-r3-tiles-pause]').isVisible(), false, 'no pause button without JS');
    await still.context().close();
  }
});

test('T9 no YouTube request before the click; nocookie iframe after it', async () => {
  const tab = await open('index.html');
  const google = /youtube|ytimg|googlevideo|doubleclick/;
  const hits = [];
  tab.on('request', (r) => { if (google.test(r.url())) hits.push(r.url()); });
  await tab.route(google, (route) => route.abort()); // hermetic: the iframe never really loads
  await tab.reload();
  const video = tab.locator('a.r3-video');
  await video.scrollIntoViewIfNeeded();
  await tab.waitForTimeout(300);
  assert.deepEqual(hits, [], 'no request before the click');
  await video.click();
  const frame = tab.locator('[data-remaster-beat="video"] iframe');
  assert.equal(await frame.count(), 1);
  assert.match(await frame.getAttribute('src'), /^https:\/\/www\.youtube-nocookie\.com\/embed\/himqflZxhNs\?autoplay=1/);
  assert.equal(await frame.getAttribute('title'), 'Bridge Traducciones: video institucional');
  assert.ok(await frame.evaluate((el) => document.activeElement === el), 'focus moves to the player');
  assert.ok(hits.every((u) => u.startsWith('https://www.youtube-nocookie.com/')), `only the nocookie host: ${hits}`);
  await tab.context().close();

  const still = await open('index.html', { javaScriptEnabled: false });
  assert.equal(await still.locator('a.r3-video').getAttribute('href'), 'https://www.youtube.com/watch?v=himqflZxhNs');
  await still.context().close();
});

// ---- Task 8: quote flow (spec §3.7) ----
test('T13 event form needs at least one language; two languages pass', async () => {
  const fill = async (tab) => {
    await tab.fill('#nombre', 'Ana Prueba'); await tab.fill('#email', 'ana@example.com');
    await tab.selectOption('#servicio', 'simultanea'); await tab.selectOption('#modalidad', 'presencial');
    await tab.selectOption('#duracion', 'jornada'); await tab.fill('#asistentes', '80'); await tab.check('#consentimiento');
  };
  let tab = await open('cotizacion-interpretacion.html');
  await fill(tab);
  await tab.click('#enviar');
  assert.ok(await tab.locator('#error-summary').isVisible(), 'summary shows');
  assert.deepEqual(await tab.locator('#error-summary-list a').evaluateAll((as) => as.map((a) => a.dataset.field)), ['lenguas']);
  await tab.context().close();
  tab = await open('cotizacion-interpretacion.html');
  await fill(tab);
  await tab.check('#lang-en'); await tab.check('#lang-fr');
  await Promise.all([tab.waitForURL(/cotizacion-gracias\.html\?servicio=interpretacion$/), tab.click('#enviar')]);
  await tab.context().close();
});

test('T13 leaving the language group empty shows its error on every checkbox', async () => {
  const tab = await open('cotizacion-interpretacion.html');
  await tab.evaluate(() => [...document.querySelectorAll('#lenguas input')].pop().focus());
  await tab.keyboard.press('Tab');
  assert.match(await tab.locator('#lenguas-err').innerText(), /al menos un idioma/, 'error on leaving the group');
  const boxes = await tab.locator('#lenguas input').evaluateAll((is) => is.map((i) => [i.getAttribute('aria-invalid'), i.getAttribute('aria-describedby')]));
  for (const [invalid, describedby] of boxes) {
    assert.equal(invalid, 'true');
    assert.match(describedby, /\blenguas-err\b/);
  }
  await tab.check('#lang-en');
  assert.equal(await tab.locator('#lenguas-err').innerText(), '', 'cleared by a check');
  await tab.uncheck('#lang-en');
  assert.match(await tab.locator('#lenguas-err').innerText(), /al menos un idioma/, 'back on uncheck');
  await tab.context().close();
});

// ---- Task 9: contact form (spec §3.8) ----
test('T19 contact form checks required fields and confirms in place', async () => {
  const tab = await open('contacto.html');
  await tab.click('#contact-form button[type="submit"]');
  assert.ok(await tab.locator('#contact-form').isVisible(), 'empty form stays');
  assert.ok(await tab.locator('#contact-sent').isHidden());
  await tab.fill('#nombre', 'Ana Prueba'); await tab.fill('#mensaje', 'Hola'); await tab.check('#consentimiento');
  await tab.click('#contact-form button[type="submit"]');
  assert.ok(await tab.locator('#contact-sent').isVisible(), 'confirmation shows');
  assert.equal(await tab.evaluate(() => document.activeElement.id), 'contact-sent', 'focus moves to it');
  assert.match(tab.url(), /\/contacto\.html$/, 'never leaves the page');
  await tab.context().close();
});

test('T16 thank-you text follows the service; unknown values fall back', async () => {
  const text = async (query) => {
    const tab = await open(`cotizacion-gracias.html${query}`);
    const out = { body: await tab.locator('main').innerText(), imgs: await tab.locator('main img').count() };
    await tab.context().close();
    return out;
  };
  const ev = await text('?servicio=interpretacion');
  assert.match(ev.body, /su evento/); assert.doesNotMatch(ev.body, /documentos que adjuntó/);
  const tr = await text('?servicio=traduccion');
  assert.match(tr.body, /documentos/);
  const generic = await text('');
  const hostile = await text('?servicio=%3Cimg%20src%3Dx%3E');
  assert.equal(hostile.body, generic.body, 'unknown value shows the generic text');
  assert.equal(hostile.imgs, generic.imgs, 'no markup injected');
  assert.doesNotMatch(generic.body, /documentos que adjuntó|su evento/, 'generic text names neither service');
});
