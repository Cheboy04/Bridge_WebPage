// BRG-81 spec tests 1–8. Browser behaviour is tests 9–12 (remaster-r2.browser.test.mjs); check.mjs is test 13.
import assert from 'node:assert/strict';
import { existsSync, readdirSync, readFileSync } from 'node:fs';
import { test } from 'node:test';

const read = (path) => {
  try { return readFileSync(new URL(`../${path}`, import.meta.url), 'utf8'); }
  catch { return ''; }
};
const occurrences = (source, value) => source.split(value).length - 1;
const pages = readdirSync(new URL('../src/pages', import.meta.url)).filter((name) => name.endsWith('.html'));
const sources = { home: read('src/pages/index.html'), certified: read('src/pages/traduccion-certificada.html') };
const built = () => ({ home: read('dist/index.html'), certified: read('dist/traduccion-certificada.html') });

// [beat, ground] in source order, from the tags that open each chapter
const beats = (html) => [...html.matchAll(/<[^>]*data-remaster-beat="([^"]+)"[^>]*>/g)]
  .map(([tag, beat]) => [beat, tag.match(/data-ground="([^"]+)"/)?.[1] ?? null]);
// each chapter's markup: from its opening tag to the next chapter's
const chapters = (html) => html.split(/(?=<[^>]*data-remaster-beat=")/).slice(1)
  .map((chunk) => [chunk.match(/data-remaster-beat="([^"]+)"/)[1], chunk]);

const story = {
  home: [
    ['arrival', 'white'], ['relevance', 'bruma'], ['document-proof', 'white'], ['cabina-handoff', 'tinta'],
    ['proof-process', 'bruma'], ['why', 'blue'], ['guides', 'white'], ['close', 'tinta'], ['contact', 'bruma'],
  ],
  certified: [
    ['arrival', 'white'], ['transformation', 'tinta'], ['fit-proof', 'white'], ['documents', 'bruma'], ['price', 'blue'],
    ['languages', 'white'], ['faq', 'bruma'], ['related', 'white'], ['process', 'bruma'], ['close', 'tinta'], ['contact', 'white'],
  ],
};
const listObjects = {
  home: ['active-rows', 'sticky-sheet', 'plates'],
  certified: ['index-tabs', 'type-wall', 'active-rows', 'plates', 'sticky-sheet'],
};

// WCAG 2.x relative luminance and contrast
const luminance = (hex) => {
  const [r, g, b] = hex.replace('#', '').match(/../g).map((c) => {
    const v = parseInt(c, 16) / 255;
    return v <= 0.03928 ? v / 12.92 : ((v + 0.055) / 1.055) ** 2.4;
  });
  return 0.2126 * r + 0.7152 * g + 0.0722 * b;
};
const contrast = (a, b) => {
  const [hi, lo] = [luminance(a), luminance(b)].sort((x, y) => y - x);
  return (hi + 0.05) / (lo + 0.05);
};

// removes every `<prefix> { … }` block, matching braces
const stripBlocks = (css, prefix) => {
  let out = css, at;
  while ((at = out.indexOf(prefix)) >= 0) {
    let i = out.indexOf('{', at), depth = 0;
    for (; i < out.length; i++) {
      if (out[i] === '{') depth++;
      if (out[i] === '}' && --depth === 0) break;
    }
    out = out.slice(0, at) + out.slice(i + 1);
  }
  return out;
};

test('only Home and Certified opt into R2', () => {
  for (const [name, html] of Object.entries(sources)) {
    assert.match(html, /<body[^>]*data-remaster-round="r2"/, name);
    assert.equal(occurrences(html, 'assets/js/remaster-r2.js'), 1, `${name} loads remaster-r2.js once`);
    assert.match(html, /@view-transition\s*\{\s*navigation:\s*auto;?\s*\}/, `${name} declares the page transition`);
  }
  for (const name of pages.filter((name) => !['index.html', 'traduccion-certificada.html'].includes(name))) {
    const html = read(`src/pages/${name}`);
    assert.doesNotMatch(html, /data-remaster-round|remaster-r2\.js|@view-transition/, name);
  }
});

test('grounds follow the story and never repeat', () => {
  for (const [name, html] of Object.entries(sources)) {
    const sequence = beats(html);
    assert.deepEqual(sequence, story[name], name);
    sequence.slice(1).forEach(([beat, ground], i) => assert.notEqual(ground, sequence[i][1], `${name}: ${beat} repeats its neighbour's ground`));
    assert.ok(sequence.filter(([, ground]) => ground === 'blue').length <= 1, `${name}: at most one blue chapter`);
  }
});

test('every chapter heading is a monument', () => {
  for (const [name, html] of Object.entries(built())) {
    const found = chapters(html);
    assert.ok(found.length > 0, `${name} is built with chapters`);
    for (const [beat, markup] of found.filter(([beat]) => !['arrival', 'close'].includes(beat))) {
      assert.match(markup, /<h2[^>]*class="[^"]*\br2-monument\b/, `${name}: ${beat}`);
    }
  }
});

test('list objects match the story and alternate', () => {
  for (const [name, html] of Object.entries(sources)) {
    const sequence = [...html.matchAll(/data-list-object="([^"]+)"/g)].map(([, value]) => value);
    assert.deepEqual(sequence, listObjects[name], name);
    sequence.slice(1).forEach((value, i) => assert.notEqual(value, sequence[i], `${name}: two ${value} in a row`));
  }
});

test('Home shows the booth as a disclosed halftone', () => {
  const { home, certified } = sources;
  assert.equal(occurrences(home, '<img'), 1, 'Home uses one image');
  assert.match(home, /srcset="assets\/photo\/cabina-halftone-800\.png 800w, assets\/photo\/cabina-halftone-1600\.png 1600w"/);
  assert.match(home, /<img[^>]*alt="[^"]{20,}"/);
  assert.match(home, /<figcaption[^>]*>[^<]*trama de puntos[^<]*<\/figcaption>/);
  assert.match(home, /<figcaption[^>]*>[^<]*provisional[^<]*<\/figcaption>/i);
  assert.doesNotMatch(home, /cabina-\d+\.webp/);
  assert.doesNotMatch(certified, /assets\/photo\//);
  for (const size of [800, 1600]) assert.ok(existsSync(new URL(`../src/assets/photo/cabina-halftone-${size}.png`, import.meta.url)), `${size} halftone exists`);
  assert.match(read('tools/halftone.py'), /cabina-1600\.webp/, 'the halftone is generated by the committed script');
});

test('one crossed word, decorations hidden from AT', () => {
  const { home, certified } = built();
  const crossed = (html) => (html.match(/<[^>]*class="[^"]*\br2-cross\b[^"]*"[^>]*>/g) ?? []).length;
  assert.equal(crossed(certified), 1, 'Certified has one crossed word');
  assert.equal(crossed(home), 0, 'Home has none');
  assert.match(certified, /class="[^"]*\br2-cross\b[^"]*"[^>]*lang="en"[^>]*>[\s\S]*?Faithful to the original/);
  for (const [name, html] of Object.entries({ home, certified })) {
    assert.ok(/\br2-seam\b/.test(html), `${name} has a seam band`);
    const decorations = html.match(/<[^>]*(?:class="[^"]*\br2-(?:seam|cross|stop)\b[^"]*"|data-r2-(?:pair|sheet))[^>]*>/g) ?? [];
    assert.ok(decorations.length >= 3, `${name} has R2 decorations`);
    decorations.forEach((tag) => assert.match(tag, /aria-hidden="true"/, `${name}: ${tag}`));
  }
});

test('the blue ground meets contrast', () => {
  const block = read('src/styles/app.css').match(/\.mode-bridge\s*\{([^}]*)\}/)?.[1] ?? '';
  const token = (name) => block.match(new RegExp(`--${name}:\\s*(#[\\da-f]{6})`, 'i'))?.[1];
  for (const name of ['surface', 'text', 'text-muted', 'accent', 'accent-contrast', 'focus', 'trail']) assert.ok(token(name), `--${name} is set`);
  assert.equal(token('surface').toLowerCase(), '#1c61ad');
  assert.ok(contrast(token('text'), token('surface')) >= 4.5, 'text on blue');
  assert.ok(contrast(token('text-muted'), token('surface')) >= 4.5, 'muted on blue');
  assert.ok(contrast(token('accent-contrast'), token('accent')) >= 4.5, 'button label on button');
  assert.ok(contrast(token('accent'), token('surface')) >= 3, 'button against the ground');
  assert.ok(contrast(token('focus'), token('surface')) >= 3, 'focus ring');
  assert.notEqual(token('trail').toLowerCase(), '#e3a148', 'no amber on blue');
});

test('R2 styles are scoped, tokenised and motion-safe', () => {
  const entry = read('src/styles/app.css');
  const css = read('src/styles/remaster-r2.css');
  assert.match(entry, /@import "\.\/remaster-r1\.css";\s*\n@import "\.\/remaster-r2\.css";/);
  assert.ok(css.length > 0);
  const rules = stripBlocks(css, '@keyframes');
  for (const line of rules.split('\n').map((line) => line.trim()).filter((line) => /[{,]$/.test(line) && !line.startsWith('@'))) {
    assert.match(line, /^(?:\.page-(?:home|certified)-r1\b|:is\(\.page-home-r1, \.page-certified-r1\))/, line);
  }
  assert.doesNotMatch(css, /#[\da-f]{3,8}\b/i);
  assert.doesNotMatch(css, /font-family\s*:\s*["']?(?:Literata|Manrope)/i);
  assert.match(css, /@media \(prefers-reduced-motion: reduce\)/);
  assert.match(css, /animation-timeline/, 'reading-paced motion exists');
  assert.doesNotMatch(stripBlocks(css, '@supports (animation-timeline'), /animation-timeline|view-timeline|scroll-timeline/, 'scroll-driven rules live inside @supports');
});
