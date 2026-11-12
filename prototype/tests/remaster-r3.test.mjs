// BRG-84 (R3) spec tests: contract checks on src/ and dist/. Browser behaviour is in remaster-r3.browser.test.mjs; check.mjs is T20.
import assert from 'node:assert/strict';
import { existsSync, readFileSync } from 'node:fs';
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

// ---- Task 4: hero tiles (spec §3.3) ----
const chapterOf = (html, beat) => html.split(/(?=<[^>]*data-remaster-beat=")/).find((c) => c.includes(`data-remaster-beat="${beat}"`)) ?? '';

test('T6 hero holds six distinct tiles; copies are hidden and inert', () => {
  const home = read('dist/index.html');
  const hero = chapterOf(home, 'arrival');
  assert.equal((home.match(/data-signature-moment="home-tiles"/g) ?? []).length, 1, 'tiles are the signature moment');
  assert.match(hero, /class="r3-tiles"[^>]*data-r3-tiles|data-r3-tiles[^>]*class="r3-tiles"/);
  assert.doesNotMatch(home, /data-signature-moment="home-crossing"/);

  const tiles = [...hero.matchAll(/<(a|div)\b[^>]*\bclass="r3-tile\b[^"]*"[^>]*>/g)].map(([tag, name]) => ({ tag, name }));
  const real = tiles.filter(({ tag }) => !/data-tile-copy/.test(tag));
  const kind = (tag) => tag.match(/data-tile="([^"]+)"/)?.[1];
  assert.deepEqual(real.map(({ tag }) => kind(tag)).sort(), ['certificacion', 'ia', 'interpretacion', 'profesionales', 'traduccion', 'volumen']);
  for (const { tag, name } of real) {
    const k = kind(tag);
    if (k === 'traduccion') assert.match(tag, /^<a[^>]*href="traduccion-certificada\.html"/, k);
    else if (k === 'interpretacion') assert.match(tag, /^<a[^>]*href="interpretacion-simultanea\.html"/, k);
    else assert.equal(name, 'div', `${k} is not a link`);
  }
  const copies = tiles.filter(({ tag }) => /data-tile-copy/.test(tag));
  assert.ok(copies.length >= 6, 'the loop has copies');
  for (const { tag } of copies) {
    assert.match(tag, /aria-hidden="true"/, tag);
    assert.match(tag, /\binert\b/, tag);
  }
  for (const { tag } of tiles) {
    const grounds = (tag.match(/class="([^"]*)"/)[1].match(/\b(?:bg-[\w-]+|mode-[\w-]+)/g) ?? []);
    assert.equal(grounds.length, 1, `one ground per tile: ${tag}`);
    assert.match(grounds[0], /^(?:bg-surface|bg-raised|mode-cabina|mode-bridge)$/, tag);
  }
  assert.doesNotMatch(hero, /class="r1-crossing"/, 'the crossing left the hero');
  assert.match(chapterOf(home, 'document-proof'), /class="r1-crossing"/, 'the crossing sits in Documentos exactos');
});

test('T6 photo tiles paint a halftone photo mask in the ground trail colour', () => {
  const css = read('src/styles/remaster-r3.css');
  const rule = [...css.matchAll(/\.r3-tile:not\(\[data-tile="ia"\]\) \.r3-tile-mark\s*\{([^}]*)\}/g)].map((m) => m[1]).join(';');
  assert.match(rule, /background-color:\s*var\(--trail\)/, 'dots take the ground trail token');
  assert.match(rule, /\bmask:\s*var\(--tile-photo\)/, 'the photo is a mask, not a background image');
  for (const k of ['traduccion', 'interpretacion', 'certificacion', 'volumen', 'profesionales']) {
    const url = css.match(new RegExp(`\\[data-tile="${k}"\\]\\s*\\{\\s*--tile-photo:\\s*url\\("([^"]+)"\\)`))?.[1];
    assert.ok(existsSync(new URL(`../dist/assets/${url}`, import.meta.url)), `${k}: ${url} is built`);
  }
});

// ---- Task 5: video facade (spec §3.4) ----
test('T8 video beat follows the hero, text first and poster second', () => {
  const home = read('dist/index.html');
  const beats = [...home.matchAll(/data-remaster-beat="([^"]+)"/g)].map(([, b]) => b);
  assert.equal(beats[1], 'video', 'second beat is the video');
  const video = chapterOf(home, 'video');
  const link = video.match(/<a\b[^>]*class="r3-video"[^>]*>/)?.[0] ?? '';
  assert.match(link, /href="https:\/\/www\.youtube\.com\/watch\?v=himqflZxhNs"/);
  assert.match(link, /data-r3-video="himqflZxhNs"/);
  assert.match(link, /aria-label="Reproducir video: Bridge Traducciones"/);
  assert.ok(video.indexOf('<h2') < video.indexOf('class="r3-video"'), 'text block comes first');
  const poster = video.slice(video.indexOf('class="r3-video"')).match(/<img\b[^>]*src="([^"]+)"/)?.[1] ?? '';
  assert.match(poster, /^assets\/photo\/video-poster-\d+\.png$/, 'poster is local');
  assert.match(video, /\[texto de Bridge\]/, 'copy is marked as a placeholder');
  assert.doesNotMatch(video, /<iframe/, 'no iframe before the click');
});

// ---- Task 6: certified samples (spec §3.5) ----
test('T10 certified page shows three marked sample documents', () => {
  const cert = read('dist/traduccion-certificada.html');
  const beats = [...cert.matchAll(/data-remaster-beat="([^"]+)"/g)].map(([, b]) => b);
  assert.equal(beats[beats.indexOf('documents') + 1], 'samples', 'samples follow documents');
  const figures = [...chapterOf(cert, 'samples').matchAll(/<figure\b[^>]*data-certified-sample[^>]*>([\s\S]*?)<\/figure>/g)].map(([, body]) => body);
  assert.equal(figures.length, 3);
  for (const body of figures) {
    assert.match(body, /aria-label="Sello de certificación/, 'each sample carries the seal');
    assert.match(body.match(/<figcaption[^>]*>([\s\S]*?)<\/figcaption>/)?.[1] ?? '', /\[muestra de Bridge, documento anonimizado\]/);
    const text = body.replace(/<[^>]+>/g, ' ');
    const runs = (text.match(/\d{3,}/g) ?? []).filter((r) => r !== '0000');
    assert.deepEqual(runs, [], 'no real-looking numbers in a sample');
  }
});

// ---- Task 7: interpretation trims and photo (spec §3.6) ----
test('T11 interpretation drops the comparison and FAQ, keeps the planner, links to the FAQ page', () => {
  const page = read('dist/interpretacion-simultanea.html');
  const h2s = [...page.matchAll(/<h2\b[^>]*>([\s\S]*?)<\/h2>/g)].map(([, t]) => t);
  assert.ok(h2s.length > 0, 'page built');
  assert.ok(!h2s.some((t) => /consecutiva/i.test(t)), 'no simultaneous-vs-consecutive section');
  assert.doesNotMatch(page, /class="[^"]*\bfaq\b|<details\b/, 'no FAQ accordion');
  assert.match(page, /id="planificador"/);
  assert.match(page, /href="preguntas-frecuentes\.html#interpretacion"/);
  const hero = page.match(/<img\b[^>]*fetchpriority="high"[^>]*>/)?.[0] ?? '';
  assert.match(hero, /src="assets\/photo\/interpretacion-800\.webp"/, 'hero is the new photo');
  assert.match(hero, /alt="[^"]+"/, 'hero photo has alt text');
});

// ---- Task 8: quote flow (spec §3.7) ----
const optionValues = (html, id) => [...(html.match(new RegExp(`<select[^>]*id="${id}"[^>]*>([\\s\\S]*?)</select>`))?.[1] ?? '').matchAll(/<option value='?"?([^'">]*)/g)].map(([, v]) => v);
const quotePages = ['cotizacion.html', 'cotizacion-traduccion.html', 'cotizacion-interpretacion.html', 'cotizacion-gracias.html'];

test('T12 both forms offer the languages.json list', () => {
  const codes = languages().map((l) => l.code);
  const tr = read('dist/cotizacion-traduccion.html');
  for (const id of ['idioma-origen', 'idioma-destino']) assert.deepEqual(optionValues(tr, id), ['', ...codes, 'otro'], id);
  const ev = read('dist/cotizacion-interpretacion.html');
  const fieldset = ev.match(/<fieldset[^>]*id="lenguas"[\s\S]*?<\/fieldset>/)?.[0] ?? '';
  const checks = [...fieldset.matchAll(/<input[^>]*type="checkbox"[^>]*>/g)].map(([tag]) => tag.match(/value="([^"]*)"/)?.[1]);
  assert.deepEqual(checks, [...codes.filter((c) => c !== 'es'), 'otro']);
});

test('T13 event form has no language count; the language fieldset is required', () => {
  const ev = read('dist/cotizacion-interpretacion.html');
  assert.ok(ev.includes('id="quote-form"'), 'page built');
  assert.doesNotMatch(ev, /<select[^>]*id="idiomas"/);
  assert.match(ev, /<fieldset[^>]*id="lenguas"/);
  assert.match(ev, /id="lenguas-err"/, 'the fieldset has an error slot');
});

test('T14 translation service list has no notarised option; volume is optional', () => {
  const tr = read('dist/cotizacion-traduccion.html');
  assert.deepEqual(optionValues(tr, 'servicio'), ['', 'certificada', 'legal', 'escrita', 'orientacion']);
  const volumen = tr.match(/<(?:input|textarea)[^>]*id="volumen"[^>]*>/)?.[0];
  assert.ok(volumen, '#volumen exists');
  assert.doesNotMatch(volumen, /\brequired\b/);
});

test('T15 forms share one aside style and token radii', () => {
  const aside = (html) => html.match(/<section[^>]*aria-labelledby="aside-title"[^>]*>\s*<div class="([^"]+)"/)?.[1];
  const tr = aside(read('dist/cotizacion-traduccion.html')), ev = aside(read('dist/cotizacion-interpretacion.html'));
  assert.ok(tr, 'translation aside found');
  assert.equal(ev, tr);
  for (const page of quotePages) assert.doesNotMatch(read(`src/pages/${page}`), /rounded-\[var\(/, page);
  const consent = read('dist/cotizacion-interpretacion.html').match(/<label[^>]*for="consentimiento"[\s\S]*?<\/label>/)?.[0] ?? '';
  assert.ok(consent, 'consent label found');
  assert.doesNotMatch(consent, /archivos/);
});

test('T17 chooser offers a quieter third route to Contacto', () => {
  const html = read('dist/cotizacion.html').match(/<main\b[\s\S]*?<\/main>/)?.[0] ?? ''; // the header menu also links contacto.html
  const link = html.match(/<a\b[^>]*href="contacto\.html"[^>]*>([\s\S]*?)<\/a>/);
  assert.ok(link, 'link to contacto.html');
  assert.match(link[1].replace(/<[^>]+>/g, ' ').replace(/\s+/g, ' '), /¿Proyecto grande o con IA\? Escríbanos/);
  assert.doesNotMatch(link[0], /svc-link/, 'not a service card');
});

// ---- Task 9: blog, FAQ, contact and menus (spec §3.8) ----
const builtPages = ['index', 'traduccion-certificada', 'interpretacion-simultanea', 'cotizacion', 'cotizacion-traduccion', 'cotizacion-interpretacion', 'cotizacion-gracias', 'componentes', 'blog', 'blog-articulo', 'preguntas-frecuentes', 'contacto'];
const menuLinks = ['blog.html', 'preguntas-frecuentes.html', 'contacto.html'];
const block = (html, tag) => html.match(new RegExp(`<${tag}\\b[\\s\\S]*?</${tag}>`))?.[0] ?? '';
const navs = (html) => [...html.matchAll(/<nav\b[\s\S]*?<\/nav>/g)].map((m) => m[0]);

test('T18 menus link the real pages and Nosotros is gone', () => {
  for (const page of builtPages) {
    const html = read(`dist/${page}.html`);
    const header = block(html, 'header'), footer = block(html, 'footer');
    assert.ok(header && footer, `${page}: header and footer built`);
    for (const [name, part] of [['header', header], ['footer', footer]]) {
      assert.doesNotMatch(part, />\s*Nosotros\s*</, `${page} ${name}: no Nosotros`);
      for (const href of menuLinks) assert.match(part, new RegExp(`href="${href}"`), `${page} ${name}: links ${href}`);
    }
    // header menus (desktop + mobile) and the footer "Empresa" menu
    const menus = [...navs(header), ...navs(footer).filter((n) => n.includes('aria-label="Empresa"'))];
    assert.equal(menus.length, 3, `${page}: three menus`);
    for (const nav of menus) assert.doesNotMatch(nav, /href="#"/, `${page}: no dead menu link`);
  }
  for (const [page, label] of [['blog', 'Blog'], ['preguntas-frecuentes', 'Preguntas frecuentes'], ['contacto', 'Contacto']]) {
    const current = [...block(read(`dist/${page}.html`), 'header').matchAll(/<a\b[^>]*aria-current="page"[^>]*>([^<]+)</g)].map((m) => m[1].trim());
    assert.deepEqual(current, [label, label], `${page}: own item current in desktop and mobile menus`);
  }
});

test('T19 new pages carry their structure', () => {
  const blog = read('dist/blog.html');
  assert.equal((blog.match(/data-post="featured"/g) ?? []).length, 1, 'one featured post');
  const cards = [...blog.matchAll(/<article class="r3-post-card[^"]*"[\s\S]*?<\/article>/g)].map((m) => m[0]);
  assert.ok(cards.length >= 3, 'three or more post cards');
  for (const c of cards) assert.match(c, /href="blog-articulo\.html"/);

  const art = read('dist/blog-articulo.html');
  const prose = art.match(/<div class="r3-prose"[\s\S]*?<!-- \/r3-prose -->/)?.[0] ?? '';
  assert.ok(prose, 'article body found');
  const ch = read('src/styles/remaster-r3.css').match(/\.r3-prose\s*\{[^}]*max-width:\s*([\d.]+)ch/)?.[1];
  assert.ok(ch && Number(ch) <= 70, `.r3-prose max-width ${ch}ch ≤ 70ch`);
  assert.equal((art.match(/<h1\b/g) ?? []).length, 1, 'one h1');
  assert.ok((prose.match(/<h2\b/g) ?? []).length >= 2, 'two or more h2 in the body');
  assert.match(prose, /<blockquote\b/);
  assert.match(prose, /<figure\b/);
  assert.match(block(art, 'main'), /<a\b[^>]*href="cotizacion\.html"/, 'quote CTA');
  assert.match(art, /aria-labelledby="related-title"[\s\S]*?class="r3-post-card/, 'related posts');

  const faq = read('dist/preguntas-frecuentes.html');
  const groups = faq.split(/(?=<section\b)/);
  for (const id of ['traduccion', 'interpretacion', 'cotizacion']) {
    const g = groups.find((s) => s.startsWith('<section') && new RegExp(`^<section[^>]*\\bid="${id}"`).test(s));
    assert.ok(g, `#${id} group`);
    const details = (g.match(/<details\b/g) ?? []).length;
    assert.ok(details >= 2, `#${id} has items`);
    assert.equal((g.match(/<summary\b/g) ?? []).length, details, `#${id}: each item has a summary`);
    if (id === 'interpretacion') assert.match(g, /<summary>[\s\S]*?[Ss]imultánea[\s\S]*?consecutiva[\s\S]*?<\/summary>/, 'simultaneous vs consecutive answer');
  }

  const contact = block(read('dist/contacto.html'), 'main');
  assert.match(contact, /href="tel:\+593/, 'phone');
  assert.match(contact, /href="https:\/\/wa\.me\/593/, 'WhatsApp');
  assert.match(contact, /href="mailto:/, 'email');
  assert.match(contact, /Horario/, 'hours');
  assert.match(contact, /<address\b/, 'address');
  assert.match(contact, /<a\b[^>]*>\s*<img\b[^>]*data-map/, 'map image inside a link');
  assert.doesNotMatch(contact, /<iframe\b/, 'no map embed');
  const form = block(contact, 'form');
  assert.match(form, /^<form\b[^>]*\bnovalidate\b/, 'static novalidate form');
  assert.ok((form.match(/class="field"/g) ?? []).length >= 3, 'built from field components');
  assert.match(contact, /<a\b[^>]*href="cotizacion\.html"/, 'link to the quote form');
});
