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
    const limit = /\.r1-monument$/.test(sel) ? 4.5 : 4;
    assert.ok(rem(max) <= limit, `${name} "${sel}" clamp max ${max.trim()} exceeds ${limit}rem`);
  }
});
