// BRG-68 spec tests 1–7. Browser evidence is test 8.
import assert from 'node:assert/strict';
import { readdirSync, readFileSync } from 'node:fs';
import { test } from 'node:test';

const read = (path) => {
  try { return readFileSync(new URL(`../${path}`, import.meta.url), 'utf8'); }
  catch { return ''; }
};
const occurrences = (source, value) => source.split(value).length - 1;
const ordered = (source, values) => values.every((value, index) => {
  const at = source.indexOf(value);
  return at >= 0 && (index === 0 || at > source.indexOf(values[index - 1]));
});

const home = read('src/pages/index.html');
const certified = read('src/pages/traduccion-certificada.html');
const pages = readdirSync(new URL('../src/pages', import.meta.url)).filter((name) => name.endsWith('.html'));

test('only the approved two pages opt into R1', () => {
  assert.match(home, /<body[^>]*class="[^"]*page-home-r1/);
  assert.match(home, /data-remaster-page="home"/);
  assert.match(certified, /<body[^>]*class="[^"]*page-certified-r1/);
  assert.match(certified, /data-remaster-page="certified"/);

  for (const name of pages.filter((name) => !['index.html', 'traduccion-certificada.html'].includes(name))) {
    const source = read(`src/pages/${name}`);
    assert.doesNotMatch(source, /page-(?:home|certified)-r1|data-remaster-/, name);
  }
});

test('Home follows the approved story with one signature moment', () => {
  assert.ok(ordered(home, [
    'data-remaster-beat="arrival"',
    'data-remaster-beat="relevance"',
    'data-remaster-beat="document-proof"',
    'data-remaster-beat="cabina-handoff"',
    'data-remaster-beat="proof-process"',
    'data-remaster-beat="close"',
  ]));
  assert.equal(occurrences(home, 'data-signature-moment="home-crossing"'), 1);
  assert.ok(home.indexOf('data-remaster-beat="document-proof"') < home.indexOf('data-remaster-beat="cabina-handoff"'));
  assert.equal(occurrences(home, '@include sig-lang-checker'), 1);
  assert.equal(occurrences(home, 'assets/photo/cabina-'), 2, 'one responsive booth image has two src/srcset paths');
});

test('Certified Translation is document led with one signature moment', () => {
  assert.ok(ordered(certified, [
    'data-remaster-beat="arrival"',
    'data-remaster-beat="transformation"',
    'data-remaster-beat="fit-proof"',
    'data-remaster-beat="process"',
    'data-remaster-beat="close"',
  ]));
  assert.equal(occurrences(certified, 'data-signature-moment="certified-before-after"'), 1);
  assert.match(certified, /data-signature-moment="certified-before-after"[\s\S]*?@include sig-before-after/);
  assert.match(certified, /@include seal/);
  assert.doesNotMatch(certified, /assets\/photo\//);
});

test('both pages finish the story through the shared close', () => {
  assert.equal(occurrences(home, '@include remaster-close'), 1);
  assert.equal(occurrences(certified, '@include remaster-close'), 1);
  for (const built of [read('dist/index.html'), read('dist/traduccion-certificada.html')]) {
    assert.match(built, /data-remaster-close/);
    assert.match(built, /original[\s\S]*traducción[\s\S]*firma/i);
    assert.ok(built.indexOf('data-remaster-close') < built.indexOf('<footer'));
  }
});

test('R1 styles stay page scoped and support reflow', () => {
  const entry = read('src/styles/app.css');
  const css = read('src/styles/remaster-r1.css');
  assert.match(entry, /@import "\.\/remaster-r1\.css";/);
  assert.ok(css.length > 0);
  for (const line of css.split('\n').filter((line) => line.includes('.r1-') && line.trimEnd().endsWith('{'))) {
    assert.match(line, /\.page-(?:home|certified)-r1/, line);
  }
  assert.match(css, /@media \(max-width: 20rem\)/);
  assert.match(css, /\.r1-crossing-decor[^}]*display:\s*none/s);
  assert.doesNotMatch(css, /#[\da-f]{3,8}\b/i);
  assert.doesNotMatch(css, /font-family\s*:/);
});

test('Home arrival progressively enhances to a static accessible end state', () => {
  const js = read('src/assets/js/remaster-home.js');
  const css = read('src/styles/remaster-r1.css');
  assert.equal(occurrences(home, 'assets/js/remaster-home.js'), 1);
  assert.match(home, /data-arrival-state="complete"/);
  assert.match(home, /<button[^>]*type="button"[^>]*data-arrival-skip/);
  assert.match(home, /<button[^>]*type="button"[^>]*data-arrival-replay/);
  assert.match(js, /bridge-remaster-arrival-seen/);
  assert.match(js, /prefers-reduced-motion:\s*reduce/);
  assert.match(css, /@media \(prefers-reduced-motion: reduce\)/);
  const keyframes = css.match(/@keyframes r1-arrival[\s\S]*?\n\}/)?.[0] ?? '';
  assert.match(keyframes, /opacity/);
  assert.match(keyframes, /transform/);
  assert.doesNotMatch(keyframes, /(?:width|height|top|left|margin|padding)\s*:/);
});

test('built remaster keeps semantic and disclosure safeguards', () => {
  for (const [name, built] of [['Home', read('dist/index.html')], ['Certified', read('dist/traduccion-certificada.html')]]) {
    assert.equal(occurrences(built, '<h1'), 1, name);
    assert.match(built, /<section[^>]*aria-labelledby=/, name);
    assert.match(built, /aria-hidden="true"[^>]*class="[^"]*r1-crossing-decor|class="[^"]*r1-crossing-decor[^"]*"[^>]*aria-hidden="true"/, name);
    assert.doesNotMatch(built, /validez legal|resultado garantizado/i, name);
  }
  assert.match(read('dist/traduccion-certificada.html'), /provisional|por definir|demostr/i);
});
