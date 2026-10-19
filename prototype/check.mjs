// QA: serves dist, screenshots pages at 1440, 390 and 320, checks overflow, targets, console errors and axe-core. Usage: node check.mjs [page ...]
import { spawn } from 'node:child_process';
import { createRequire } from 'node:module';
import { homedir } from 'node:os';
const { chromium } = createRequire(import.meta.url)('/home/cheboy04/.npm/_npx/e41f203b7505f1fb/node_modules/playwright');
const pages = process.argv.slice(2).length ? process.argv.slice(2) : ['index', 'componentes'];
const srv = spawn('python3', ['-m', 'http.server', '4173', '-d', 'dist'], { stdio: 'ignore' });
await new Promise((r) => setTimeout(r, 800));
const browser = await chromium.launch({ executablePath: `${homedir()}/.cache/ms-playwright/chromium-1234/chrome-linux64/chrome` });
let failed = false;
for (const name of pages) for (const [w, h] of [[1440, 900], [390, 844], [320, 800]]) {
  const context = await browser.newContext({ viewport: { width: w, height: h }, reducedMotion: 'reduce' });
  const page = await context.newPage();
  const errors = [];
  page.on('console', (m) => m.type() === 'error' && errors.push(m.text()));
  page.on('pageerror', (e) => errors.push(String(e)));
  await page.goto(`http://localhost:4173/${name}.html`, { waitUntil: 'networkidle' });
  await page.evaluate(async () => { for (let y = 0; y < document.body.scrollHeight; y += 500) { scrollTo(0, y); await new Promise((r) => setTimeout(r, 60)); } scrollTo(0, 0); await new Promise((r) => setTimeout(r, 300)); });
  await page.screenshot({ path: `screens/${name}-${w}-v2.png`, fullPage: true });
  const sw = await page.evaluate(() => [document.documentElement.scrollWidth, innerWidth]);
  const overflow = sw[0] > sw[1] ? await page.evaluate(() => [...document.querySelectorAll('body *')].filter((e) => { const r = e.getBoundingClientRect(); return r.right > innerWidth + 1 || r.left < -1; }).slice(0, 8).map((e) => `${e.tagName}.${e.className.toString().slice(0, 50)} [${Math.round(e.getBoundingClientRect().left)},${Math.round(e.getBoundingClientRect().right)}]`)) : [];
  const small = await page.evaluate(() => [...document.querySelectorAll('a,button,summary,input,select,textarea,label.dropzone')].filter((e) => { const r = e.getBoundingClientRect(); return r.width && r.height && e.offsetParent && !e.classList.contains('sr-only') && !e.closest('[x-cloak]') && (r.height < 44 || r.width < 44) && getComputedStyle(e).display !== 'inline'; }).map((e) => `${e.tagName}.${e.className.toString().slice(0, 40)} ${Math.round(e.getBoundingClientRect().width)}x${Math.round(e.getBoundingClientRect().height)} "${e.textContent.trim().slice(0, 24)}"`));
  await page.addScriptTag({ url: 'https://cdn.jsdelivr.net/npm/axe-core@4.10.2/axe.min.js' });
  const axe = await page.evaluate(() => axe.run(document, { runOnly: ['wcag2a', 'wcag2aa', 'wcag21aa', 'wcag22aa', 'best-practice'] }));
  console.log(`\n== ${name} @${w}: scrollWidth ${sw[0]}/${sw[1]} ${sw[0] > sw[1] ? 'OVERFLOW' : 'ok'}; console errors: ${errors.length}`);
  errors.forEach((e) => console.log('  err:', e.slice(0, 160)));
  overflow.forEach((e) => console.log('  overflow:', e));
  small.slice(0, 12).forEach((s) => console.log('  small target:', s));
  for (const v of axe.violations) console.log(`  axe ${v.impact} ${v.id} (${v.nodes.length}): ${v.nodes.slice(0, 3).map((n) => n.target.join(' ')).join(' | ')}`);
  if (!axe.violations.length) console.log('  axe: 0 violations');
  if (sw[0] > sw[1] || errors.length || small.length || axe.violations.length) failed = true;
  await context.close();
}
// #5 proof: home process section with motion ALLOWED (everything above forces reduced motion), mid-scroll
{
  const ctx = await browser.newContext({ viewport: { width: 1440, height: 900 } });
  const page = await ctx.newPage();
  await page.goto('http://localhost:4173/index.html', { waitUntil: 'networkidle' });
  const y = await page.evaluate(() => { const r = document.querySelector('.process').getBoundingClientRect(); return Math.round(scrollY + r.top - innerHeight * 0.55); });
  await page.evaluate((y) => { document.documentElement.style.scrollBehavior = 'auto'; scrollTo(0, y); }, y);
  await page.waitForTimeout(400);
  await page.screenshot({ path: 'screens/index-process-motion-1440-v2.png' });
  console.log('\n== motion screenshot: screens/index-process-motion-1440-v2.png (scrollY ' + y + ')');
  await ctx.close();
}
await browser.close(); srv.kill();
if (failed) process.exitCode = 1;
