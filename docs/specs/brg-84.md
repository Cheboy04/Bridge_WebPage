# BRG-84 (prototype) — Remaster R3: rhythm, client changes and the remaining pages

> **GitHub Issues:** `BRG-84` · **Phase:** P4 design track (before the page stories port the prototype) · **Covers:** RNF-06, RNF-09
> **Counterpart:** — (the Laravel port stays in the P4 page stories)
> **Status:** `[x]` draft · `[x]` approved (mode C; design approved by the owner 2026-11-05) · `[ ]` implemented

This spec turns the approved R3 design ([`r3-design.md`](../../audit/remaster-r3/decisions/r3-design.md)) into a testable contract for the static reference. The plan is [`2026-11-05-remaster-r3.md`](../superpowers/plans/2026-11-05-remaster-r3.md). BRG-68 (R1) and BRG-81 (R2) stay in force except where §3.9 says otherwise.

## 1. Scope in this layer

**In:** design §3 (rhythm, type ceiling) on every page; design §4.2–4.7: Home hero tiles, video, language band; Certified samples; Interpretation trims and photo; quote-flow adjustments 1–8; new pages `blog.html`, `blog-articulo.html`, `preguntas-frecuentes.html`, `contacto.html`; header/footer without Nosotros; brand docs updated in the same change.

**Out / deferred:**

- `site/` (Laravel/Blade) → P4 page stories.
- Real form submission, a language-inquiry form, the contact form's backend → P5.
- Final copy, real certified samples, photos of Bridge → placeholder register #31–#37.

## 2. Dependencies

- **GitHub Issues:** BRG-84.
- **Design evidence:** `audit/remaster-r3/decisions/r3-design.md` (approved 2026-11-05, §8 answered the same day).
- **Vetoes:** `CLAUDE.md` §5 allows `prototype/` changes for "a remaster round with a new owner-approved synthesis gate"; this is that round.
- **ADR (DECIDED):** D2.2, D3.7, D3.8, D8.5 (no third-party request before consent → video facade, static map), D11.2.
- **External:** YouTube video `himqflZxhNs` (Bridge's own channel), loaded only on click. Stock photos under a free licence (Unsplash/Pexels), credited in the register.

## 3. Technical contract

### 3.1 Rhythm and type ceiling

- Tokens in `app.css`: `--space-section: 3rem`, `--space-section-lg: 4.75rem` (≥ 64rem), `--type-hero-max: 4.5rem`, `--type-monument-max: 4rem`. `.sec` uses the spacing tokens.
- No `clamp()` on a `font`/`font-size` in the prototype stylesheets has a max above `4.5rem`; only the Home/Certified hero `h1` (`.r1-monument`) may exceed `4rem`.
- At 1440×900 every section's heading and its first content block start inside one viewport from the section's top; on Home and Certified the hero `h1`, lead and primary button sit above the fold.
- New rules go in `src/styles/remaster-r3.css`: tokens only, no hex, no font-family literals.

### 3.2 Language band (Home and Certified)

- `src/components/lang-band.html` replaces `sig-lang-checker` on both pages. `languages.json` is the single language list (adds `native`, and `dir: "rtl"` where needed).
- Each language (except Spanish) appears once: Spanish name + native name with its `lang` (and `dir`).
- Ask block: `a[data-lang-ask="whatsapp"]` (prefilled "Hola, ¿trabajan con el idioma …?") and `a[data-lang-ask="quote"]` → `cotizacion-traduccion.html?idioma=otro`.
- `quote-form.js` accepts `?idioma=` only for codes in the list plus `otro`; it sets `.value`, never markup.

### 3.3 Home hero tiles (`remaster-r3.js`)

- Hero: message left (`[mensaje principal de Bridge]`), `.r3-tiles[data-r3-tiles][data-signature-moment="home-tiles"]` right.
- Six tiles, `data-tile` = `traduccion`, `interpretacion`, `ia`, `certificacion`, `volumen`, `profesionales`. `traduccion` → `traduccion-certificada.html`, `interpretacion` → `interpretacion-simultanea.html`; the rest are not links.
- Loop copies: `aria-hidden="true" inert data-tile-copy`.
- Motion only with `prefers-reduced-motion: no-preference`; pauses on hover, on focus within, and by `[data-r3-tiles-pause]` (`aria-pressed`). Reduced motion or no JS: static grid with all six visible; the pause button is hidden without JS.
- The crossing (`.r1-crossing`) moves into the `document-proof` chapter.

### 3.4 Video (Home)

- New beat `video` right after the hero: text first, then `a.r3-video[data-r3-video="himqflZxhNs"]` → `https://www.youtube.com/watch?v=himqflZxhNs`, `aria-label="Reproducir video: Bridge Traducciones"`, local poster.
- On click: an `iframe` from `https://www.youtube-nocookie.com/embed/himqflZxhNs?autoplay=1`, `title="Bridge Traducciones: video institucional"`, focus moved to it. No request to a YouTube/Google host before the click.
- Poster: presenter crop of the video frame (no old logo, no subtitle band), halftoned, on Tinta; text over it is live HTML.

### 3.5 Certified samples

- Beat `samples` right after `documents`: three `figure[data-certified-sample]`, each with a seal and a figcaption containing `[muestra de Bridge, documento anonimizado]`; no digit run of three or more other than `0000`.

### 3.6 Interpretation

- No simultaneous-vs-consecutive section and no FAQ section; `#planificador` kept; a link to `preguntas-frecuentes.html#interpretacion`; new stock hero photo with `alt`.

### 3.7 Quote flow

- Language options: translation selects = list codes + `otro`; event checkboxes = list codes without `es`, + `otro`.
- Event form: no language-count select; at least one language checked (error summary links the language fieldset).
- Translation `#servicio` values: `''`, `certificada`, `legal`, `escrita`, `orientacion`. Optional `#volumen`.
- One aside style on both forms; token radius classes only; the event privacy note doesn't mention files.
- Forms post to `cotizacion-gracias.html?servicio=traduccion|interpretacion`; the thank-you text follows the value from a fixed map (`textContent`), anything else → generic text.
- Chooser: a third, quieter entry "¿Proyecto grande o con IA? Escríbanos" → `contacto.html`.

### 3.8 New pages and menus

- Header (desktop and mobile) and footer: no Nosotros; Blog → `blog.html`, Preguntas frecuentes → `preguntas-frecuentes.html`, Contacto → `contacto.html`; no menu link with `href="#"`; `active` values `blog|faq|contacto`.
- Blog index: one featured post, ≥ 3 `post-card`s → `blog-articulo.html`. Article: body ≤ 70ch with `h1`, ≥ 2 `h2`, `blockquote`, `figure`, quote CTA, related posts.
- FAQ: groups `#traduccion`, `#interpretacion`, `#cotizacion`; items are `<details>`/`<summary>`; `#interpretacion` holds the simultaneous-vs-consecutive answer.
- Contacto: phone, WhatsApp, email (placeholders), hours, address, map `img` inside a link (no `iframe`), static `novalidate` form from the field components, link to `cotizacion.html`.

### 3.9 Changes to the BRG-68 / BRG-81 contract

Superseded assertions are edited in the same commit as the code that supersedes them, and listed here as they are touched:

- BRG-81 test 1 `story.home`: hero beat now holds the tiles; `relevance` (pair checker) becomes the language band; `video` beat added after `arrival`.
- BRG-81 language-pair assertions (`[data-r2-pair]`, `sig-lang-checker`): replaced by §3.2.
- R1/R2 monument `clamp()` maxima above the §3.1 ceiling.
- BRG-81 `listObjects.certified`: `samples` added; language band replaces the pair.
- BRG-81 `story.certified`: `samples` (white) added after `documents` (Task 6).
- BRG-81 browser test "the pair headline follows the checker": removed with the checker (Task 3).
- BRG-81 `story.home`: `video` (Tinta) added after `arrival` (Task 5).
- BRG-68 `home-crossing` signature moment, "Home arrival progressively enhances…" and the arrival-state browser check: replaced by the tiles (Task 4).

## 4. Acceptance criteria → tests

Runner: `node --test` (`npm test` builds first). Contract tests in `prototype/tests/remaster-r3.test.mjs`; browser tests in `prototype/tests/remaster-r3.browser.test.mjs` on the built `dist/` with the pinned Playwright and Chromium (port 4176). `check.mjs` is the last gate.

| # | Test | What it asserts | How we prove it FAILS (C3) |
| --- | --- | --- | --- |
| T1 | contract: type and section spacing never exceed the R3 ceiling | §3.1 clamp maxima, `.sec` tokens | raise one monument max to `7rem` |
| T2 | browser: each section shows its heading and first content in one 1440x900 viewport | §3.1 viewport rule | set `--space-section-lg: 8rem` |
| T3 | contract: language band lists every language once with its native name | §3.2 list sync, `lang`, `dir` | delete one `<li>` from the band |
| T4 | contract: unknown-language asks route to WhatsApp and the quote form | §3.2 ask links | change the quote href |
| T5 | browser: idioma=otro preselects Otro; unknown values are ignored | §3.2 whitelist | drop the whitelist check |
| T6 | contract: hero holds six distinct tiles; copies hidden and inert | §3.3 markup | remove `inert` from copies |
| T7 | browser: tiles move, pause on hover, focus and button, still under reduced motion | §3.3 behaviour | remove the focus-within pause rule |
| T8 | contract: video beat follows the hero, text first | §3.4 markup | move the beat after `relevance` |
| T9 | browser: no YouTube request before the click; nocookie iframe after | §3.4 behaviour | change the host to `www.youtube.com` |
| T10 | contract: certified page shows three marked samples | §3.5 | drop one marker |
| T11 | contract: interpretation drops comparison and FAQ, keeps planner, links FAQ | §3.6 | restore the FAQ include |
| T12 | contract: both forms offer the list | §3.7 options | remove `ko` from the event form |
| T13 | contract + browser: event form has no count; one language required | §3.7 | re-add the count select |
| T14 | contract: no notarised service; optional volume | §3.7 | add `required` to `#volumen` |
| T15 | contract: one aside style, token radii, privacy text | §3.7 | put back `rounded-[var(--radius-sm,8px)]` |
| T16 | browser: thank-you text follows the service; unknown values fall back | §3.7 | write the query value with `innerHTML` |
| T17 | contract: chooser's quieter third route | §3.7 | point it to `cotizacion.html` |
| T18 | contract: menus link the real pages; Nosotros gone | §3.8 | restore the Nosotros link |
| T19 | contract: new pages carry their structure | §3.8 | replace the map `img` with an `iframe` |
| T20 | gate: `npm test` + `check.mjs` on all 12 pages at 1440/390/320 | D11.2 | — (gate) |

## 5. Implementation notes

(Filled during implementation: the calls the agent took alone.)

- **T1:** the Certified hero `h1` is `.r1-certified-title`; it shares the hero ceiling with `.r1-monument`. The booth image is capped to a 5:2 band at ≥ 64rem and both heroes are top-aligned (owner point 1).
- **T3:** the band's chapter heading is "Traducimos su idioma" (monument with the `Idiomas` kicker); the ask heading takes the `level` param. Kichwa's native name is "Runa shimi" (example data). The dead checker code went with it: `sig-lang-checker.html`, the checker half of `sig-documento.js`/`.css` (the before/after half stays), the R2 live-pair JS and CSS. `?idioma=` only fills the origin select; `?origen=` still wins when both are present.
- **T6–T7:** the tiles carry brand marks on Bridge grounds instead of stock photos (design §4.2 allows "photo or brand mark"; the agent's stock search tools were blocked or returned noise, and the client's own photos replace either). Interpretación reuses the booth halftone. Below 64rem each column becomes a row drifting sideways (two rows, opposite directions) rather than one row. The hero splits 6/6 at ≥ 64rem. The crossing is static in "Documentos exactos"; its replay (`remaster-home.js`, skip/replay buttons, `r1-arrival` keyframes) was removed with it, so Home has one signature moment. "Por qué Bridge" drops "Dos servicios, un equipo" (the hero lead and the tiles say it); the ATA item stays because the tile shows only the mark.
- **T6–T7 photos (2026-11-11, owner asked for photos):** five tiles now carry halftone photos (`tools/halftone.py --tile`), used as CSS masks so the dots take each ground's `--trail`; IA keeps the dot field. Traducción, certificación, volumen and profesionales are free Unsplash photos; Interpretación is the Task 7 Commons photo. Credits in placeholder register #35. The "ES ··· EN" and "ATA" text marks are gone; the ATA claim stays in "Por qué Bridge".
- **T8–T9:** the video chapter is Tinta, between the hero (white) and the language band (Bruma). The poster is generated by `tools/halftone.py --poster` from the video's public thumbnail (presenter only; the studio wall gets no dots), at a finer pitch than the booth. No seal on the poster: `seal.html` is Documento-only and this chapter is Cabina. The "Conozca Bridge" label hides below 40rem, where it would sit on the face; the link's accessible name carries it. The iframe is built with `createElement` and the id is URI-encoded.

- **T10:** samples are a birth certificate (en), a diploma (fr) and a contract (es) built as `certified-sample.html`; seal 64px; a subgrid aligns the sheets at ≥ 64rem. R2's `story.certified` and `listObjects.certified` gain the `samples` beat (§3.9).
- **T11:** the Interpretation hero is a Wikimedia Commons photo (G7 Halifax 2018 booths, Indrid Cold, CC BY-SA 2.0) with a visible credit; free Unsplash search had no booth photos. The FAQ link sits under "Servicios relacionados". The shared header logo is 150px below 40rem, which fixes the 320px "Menú" overflow on every shared-header page.
- **T12–T17:** event languages are a required `fieldset#lenguas` (the summary link focuses its first checkbox); the planner's `idiomas` count parameter is ignored. `field-check` gains an optional `value`. The thank-you detail comes from a fixed map in `quote-thanks.js` (`textContent`); any other value keeps the generic "y los datos que nos envió." "Notariada" also left the chooser card and the translation page description.
- **T18:** "no dead menu link" covers the header menus (desktop and mobile) and the footer's "Bridge" menu. The footer's service stubs (legal, notariada, consecutiva, equipos) and the privacy link stay `#`: those pages are outside the prototype. The header's Traducción and Interpretación now link the two service pages; Home's "Guías" link the blog. T17 now reads only `<main>`, because the header links `contacto.html` first.
- **T19:** the article reuses the Commons interpretation photo with its credit. The map is a local SVG placeholder (`assets/img/mapa-quito.svg`) inside a link to a Google Maps search: no request to Google before the click. The contact form is static: native required checks, then an in-place confirmation; nothing is sent. P5 builds the real one with the D3.1 error summary. Placeholders: register #36 (posts, FAQ answers) and #37 (map, hours, address).

**C3 (2026-11-11).** Runner: apply one mutation, build, run the one test, restore the original text in a `finally` (no `git checkout`). 19 mutations; every one turned its test red.

| Test | Mutation | Result |
| --- | --- | --- |
| T1 | `--type-monument-max: 7rem` | red |
| T3 | drop `ko` from `languages.json` (list sync) | red |
| T5 | remove the `idioma` whitelist check | red |
| T6 | remove `inert` from the tile copies | red |
| T6 | remove the tile photo `mask` | survived at first → new T6 assertion → red |
| T7 | pause rule loses `:focus-within` | red |
| T9 | `youtube-nocookie.com` → `www.youtube.com` | red |
| T10 | drop the `data-certified-sample` marker | red |
| T13 | `lenguas` no longer required | red |
| T16 | thank-you writes the query with `innerHTML` | red |
| T17 | third route → `cotizacion.html` | red |
| T18 | restore a Nosotros link | red |
| T19 | map `img` → `iframe` | red |
| T13 (browser) | review fix: drop the group `focusout` validation | red |
| T13 (browser) | review fix: checkboxes lose `aria-invalid` | red |
| T19 (browser) | review fix: drop the contact required check | red |
| T19 (browser) | review fix: contact form posts again | red |
| T19 (browser) | delta fix: drop the email-or-phone rule | red |
| T6 (browser) | delta fix: drop the phone tile-name size | red |

**T20 gate (2026-11-11, after the review batch):** `npm test` 44/44; `check.mjs` on all 12 pages at 1440/390/320 with reduced motion: 0 axe violations, no overflow, 0 console errors.

**Independent review (2026-11-11, `/code-review high` on the branch, 10 findings).** Fixed in `404ddd1`:
1. The contact form posted to a static page (405 on the dev server) and skipped its required fields → it now confirms in place after native required checks.
2. Home showed the CC BY-SA tile photo without credit → credit line under the tiles (author, licence, "adaptada en semitono").
3. A plain message landed on the quote thank-you page → solved by 1.
4. The `lenguas` fieldset never blurs, so it gave no error on leaving it, and its checkboxes carried no invalid state → validates on `focusout` from the group and on every change; its checkboxes get `aria-invalid` and `aria-describedby` → `lenguas-err`.
6. The planner still sent the ignored `idiomas` count → removed from the CTA (static and JS).
7. "Todas" was always `aria-current` while the category links don't filter → no current state until the CMS port filters.
8. `notariada` survived in `languages.json` services and the gallery select → removed in `404ddd1`, **reverted** in `aebe711` (see the delta review): notarisation is still offered on Home, in the footer and as a quote add-on.
9. No `-webkit-mask` fallback for the photo tiles → no change needed: the Tailwind/Lightning CSS build already prefixes `mask`. The hand-written line was removed in `aebe711`.

Justified, not changed:
5. Every post card opens the one article: the prototype has a single article template, and T19 asserts the cards link it. The real routes come from the CMS (register #36).
10. Home's guide plates repeat two posts' copy: they are the R2 "plates" list object, not post cards. In the site both read the same CMS records, so the duplication ends at the port.

**Delta review (`/code-review medium 404ddd1`, 9 findings).** Fixed in `aebe711`:
- The contact form confirmed with no way to reply → it needs an email or a phone, as the quote forms do (ARCHITECTURE §6).
- The group error was read twice (fieldset and checkboxes) → only the checkboxes reference `lenguas-err`.
- A label click (no `relatedTarget`) flashed the group error → `focusout` validates only when focus moves to another control outside the group.
- The tile credit sat inside the "Nuestros servicios" group → moved out, under the tiles, in `index.html`.
- The planner CTA implied the languages carry over → the prefill note asks the visitor to mark them.
- The hand-written `-webkit-mask` duplicated the build's prefix → removed.
- Also found while checking the credit at 390: tile names split mid-word ("Interpretació/n") in the static phone grid → names are 0.9rem below 40rem. A new browser test measures it at 320/390 with motion on and off.

Justified, not changed:
- Without JS the contact form still POSTs to a static page (405 on the dev server). The quote forms behave the same, because the static prototype has no server. P5 posts to Laravel.
- The contact stand-in uses native validation bubbles in an inline script, not the D3.1 summary in a module. This is deliberate and marked `ponytail:` in the page: P5 builds the real form with the D3.1 pattern, and the prototype only shows the layout.
- `notariada`: the first review wanted it out of the data, the delta review wanted it kept. Whether notarised translation is a service of its own is a business call, so it goes to the owner. Data and gallery are back as on `develop`.

**Known limits.**
- With motion allowed, a whole-page axe run on Home and Certified reports colour contrast on 44–58 nodes. Every one passes once scrolled into view and settled: the R2 scroll reveals hold text at partial opacity until it enters the viewport. This is not a real contrast failure. `check.mjs` stays on reduced motion, and the motion pass is checked element by element.
- Stock photos (Unsplash, Commons CC BY-SA 2.0) are placeholders until Bridge supplies its own (register #35). CC BY-SA asks for share-alike on derived crops.
- Blog category links and the contact form are static.

## 6. Spec change log

- `2026-11-11` — §5: notes for T10–T19, C3 table, T20 gate, known limits; T6 gains the tile-mask assertion.
- `2026-11-05` — created from the approved R3 design.
