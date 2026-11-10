// BRG-84 (R3) spec tests: contract checks on src/ and dist/. Browser behaviour is in remaster-r3.browser.test.mjs; check.mjs is T20.
import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import { test } from 'node:test';

const read = (path) => {
  try { return readFileSync(new URL(`../${path}`, import.meta.url), 'utf8'); }
  catch { return ''; }
};
const tokenRem = { 'var(--type-hero-max)': 4.5, 'var(--type-monument-max)': 4 };
const rem = (value) => {
  const v = value.trim();
  if (v in tokenRem) return tokenRem[v];
  const m = v.match(/^([\d.]+)rem$/);
  return m ? Number(m[1]) : Infinity; // any other unit can't be checked against the ceiling, so it fails
};

// [selector, clamp max] for every font / font-size declaration that uses clamp()
const fontClamps = (css) => {
  const out = [];
  for (const m of css.matchAll(/font(?:-size)?\s*:[^;{}]*?clamp\(([^,]+),([^,]+),([^)]+\)?)\)/g)) {
    const open = css.lastIndexOf('{', m.index);
    const start = Math.max(css.lastIndexOf('}', open), css.lastIndexOf(';', open)) + 1;
    out.push([css.slice(start, open).replace(/\/\*[\s\S]*?\*\//g, '').trim(), m[3]]);
  }
  return out;
};

test('T1 type and section spacing never exceed the R3 ceiling', () => {
  const app = read('src/styles/app.css');
  for (const [token, value] of [['--space-section', '3rem'], ['--space-section-lg', '4.75rem'], ['--type-hero-max', '4.5rem'], ['--type-monument-max', '4rem']]) {
    assert.match(app, new RegExp(`${token}:\\s*${value.replace('.', '\\.')};`), `${token} is ${value}`);
  }
  assert.match(app, /\.sec\s*\{\s*padding-block:\s*var\(--space-section\);\s*\}/, '.sec uses --space-section');
  assert.match(app, /\.sec\s*\{\s*padding-block:\s*var\(--space-section-lg\);\s*\}/, '.sec uses --space-section-lg on desktop');

  const sheets = ['app.css', 'remaster-r1.css', 'remaster-r2.css', 'remaster-r3.css', 'sig-documento.css', 'sig-cabina.css'];
  const clamps = sheets.flatMap((name) => fontClamps(read(`src/styles/${name}`)).map(([sel, max]) => [name, sel, max]));
  assert.ok(clamps.length > 5, 'font clamps found');
  for (const [name, sel, max] of clamps) {
    // only the hero heading itself may reach the hero ceiling
    const limit = /\.(r1-monument|r1-certified-title)$/.test(sel) ? 4.5 : 4;
    assert.ok(rem(max) <= limit, `${name} "${sel}" clamp max ${max.trim()} exceeds ${limit}rem`);
  }
});

// ---- Task 3: language band (spec §3.2) ----
const languages = () => JSON.parse(read('src/assets/data/languages.json') || '{"languages":[]}').languages;
const band = (html) => html.match(/<ul[^>]*data-list-object="lang-band"[^>]*>([\s\S]*?)<\/ul>/)?.[1] ?? '';
const bandPages = ['index.html', 'traduccion-certificada.html'];

test('T3 language band lists every language in languages.json once, with its native name', () => {
  const expected = languages().filter((l) => l.code !== 'es');
  assert.ok(expected.length > 10, 'languages.json read');
  for (const l of expected) assert.ok(l.native, `${l.code} has a native name`);
  for (const page of bandPages) {
    const html = read(`dist/${page}`);
    const items = [...band(html).matchAll(/<li>\s*<span class="r3-lang-name">([^<]+)<\/span>\s*<span class="r3-lang-native" lang="([^"]+)"( dir="rtl")?>([^<]+)<\/span>\s*<\/li>/g)]
      .map(([, name, lang, rtl, native]) => ({ name, lang, rtl: !!rtl, native }));
    assert.deepEqual(items, expected.map((l) => ({ name: l.name, lang: l.code, rtl: l.dir === 'rtl', native: l.native })), page);
    assert.ok(items.some((i) => i.lang === 'ar' && i.rtl), `${page}: Arabic is right-to-left`);
    assert.doesNotMatch(html, /data-lc\b|data-r2-pair|sig-lang-checker/, `${page}: no pair checker left`);
  }
});

test('T4 unknown-language asks route to WhatsApp and to the quote form with Otro', () => {
  const wa = `https://wa.me/593990000000?text=${encodeURIComponent('Hola, ¿trabajan con el idioma …?')}`;
  for (const page of bandPages) {
    const html = read(`dist/${page}`);
    assert.match(html, new RegExp(`<a[^>]*data-lang-ask="whatsapp"[^>]*href="${wa.replace(/[.?]/g, '\\$&')}"|<a[^>]*href="${wa.replace(/[.?]/g, '\\$&')}"[^>]*data-lang-ask="whatsapp"`), `${page}: WhatsApp ask`);
    assert.match(html, /<a[^>]*(?:data-lang-ask="quote"[^>]*href="cotizacion-traduccion\.html\?idioma=otro"|href="cotizacion-traduccion\.html\?idioma=otro"[^>]*data-lang-ask="quote")/, `${page}: quote ask`);
  }
});
