# Remaster R3 — design document (brainstorm output)

**Date:** 2026-11-05 · **Status:** draft, waiting for owner approval · **Track:** P4 design track (prototype), after BRG-81 (R2)
**Sources:** owner review of R2 (2026-11-05, three captures at 1440–1920 px), client comments on the prototype (relayed by the owner, explored, not taken literally), client taste reference lionbridge.com.

## 1. Intent

R2 proved the brand system but over-scaled it: headings eat whole viewports and sections are separated by more air than content. The client likes the base and wants a clearer, more corporate reading of it, with the institutional video and real proof. R3 tightens the system, applies the client's content changes, and **finishes every page the menu links to**, so the P4 page stories port a complete, approved prototype and nobody invents layouts later.

Success: the owner approves R3 as the P4 start gate (phase-04 *Control gates*), covering every page in §4.

## 2. Goals, non-goals, anti-goals

**Goals**

1. One shorter vertical rhythm for the whole prototype (owner point 1).
2. Headings sized so each section's heading and first content share one 1440×900 viewport (owner point 2).
3. Client changes on Home, Certified Translation, Interpretation and the quote flow (§4).
4. A video section on Home with the company video (owner point 4).
5. New pages: Blog (index + article), FAQ, Contacto. Nosotros is dropped from the menu.

**Non-goals**

- Final copy. The client writes the hero message, the six boxes, and the video text; R3 uses marked placeholders (`[texto de Bridge]`).
- Laravel/Blade work, real form submission, a language-inquiry lead form (P5, CLAUDE.md §5).
- Real client documents in the repo (rule 5). The certified samples are placeholders until Bridge supplies redacted ones.

**Anti-goals (failure even if it works)**

- Copying Lionbridge's look. Take its sobriety, density and the text-left/video-right block; keep Bridge's type, grounds and seal.
- Losing the R2 identity in the shrink: grounds rotation, monuments (smaller), seal, list objects and motion stay.
- A video embed that loads YouTube (cookies, ~1 MB of JS) before the visitor asks for it.

## 3. System changes (all pages)

### 3.1 Vertical rhythm

- One section spacing scale in the tokens, replacing the stacked `sec` padding + kicker margins + monument blocks. Target: about 40 % less section padding at desktop than R2; mobile keeps its current spacing unless the same stacking shows there.
- The empty band between header and hero (capture 1: ~150 px of nothing above the kicker) goes.

### 3.2 Type ceiling

- Rule: at 1440×900, a section's heading plus its first content line fit in the viewport; the hero shows heading, lead and primary button above the fold.
- Hero `h1`: max ≈ 4.5 rem (≈ 72 px), at most 3 lines at 1440. Today `clamp(2.6rem, 7vw, 7rem)` reaches 104 px+ and wraps to 4 lines.
- Chapter monuments (`r2-monument`, the crossed-word block `original → traducción → firma`, `clamp(…, 10rem)`) capped at ≈ 3.5–4 rem. The crossed word keeps its arrows and dotted rules but drops to the same ceiling.
- The ceiling is a token, so the port inherits it. A browser test asserts it (§6).

## 4. Pages

### 4.1 Header and footer (all pages)

- Logo and menu stay as they are (client).
- Menu: Traducción · Interpretación · Blog · Preguntas frecuentes · Contacto · button "Solicitar cotización". **Nosotros removed** (owner + agent: its job is done better by the video, the "Profesionales certificados" box and the certified samples; a thin "our story" page adds little).

### 4.2 Home

Order:

1. **Hero with six moving tiles** (client, Lionbridge hero pattern, checked 2026-11-05 at 1440×900): message left (headline, lead, buttons; placeholders for the client's text), six tiles right in two or three columns that drift vertically in an endless loop, each column at its own pace/direction. Tiles: Traducción · Interpretación · Inteligencia artificial · Certificación y notarización · Proyectos de grandes volúmenes · Profesionales certificados. Each tile is a Bridge ground (blue, Tinta, Bruma) with a halftone-treated stock photo or a brand mark and its name; the tile links where a page exists (Traducción → certified page, Interpretación → interpretation page). Bridge's version, not Lionbridge's: no neon gradients, R2 halftone and grounds.
   - Motion: CSS `transform` loop, vanilla JS only for the pause control. Pauses on hover and focus-within; a visible "Pausar movimiento" button (WCAG 2.2.2, motion longer than 5 s). Reduced motion: a static 2×3 grid. Tiles are duplicated for the loop with the copies `aria-hidden` and `inert`, so screen readers and keyboard meet each tile once.
   - Mobile: one horizontal row that drifts, or a static grid (builder's call, recorded).
   - This becomes Home's signature moment. The crossing demo (original → translation → signed) leaves the hero and moves into the "Documentos exactos" chapter, where it proves the same point. `brand/SIGNATURE-COMPONENTS.md` updated in the same change.
2. *(merged into 1)*
3. **Video** (owner + client, Lionbridge pattern): text left (kicker, heading, short paragraph, CTA), video right, 16:9. Video `https://www.youtube.com/watch?v=himqflZxhNs` ("BRIDGE TRADUCCIONES subtitulado"). Click-to-load facade: a local poster image + play button; on click, swap in an `iframe` from `youtube-nocookie.com` with autoplay. No YouTube request before the click. Accessible name on the button ("Reproducir video: Bridge Traducciones").
   - Poster: YouTube's frames show the **old logo** and burned-in subtitles, which clash with the refreshed brand. So the poster is designed, not a frame: Tinta ground, halftone of the presenter frame, seal, "Conozca Bridge" and the duration. (Agent's call after checking the frames, owner agreed to pick a usable frame.)
   - Flag for the client, not blocking: the video itself shows the pre-refresh logo.
4. **Languages** (replaces the pair checker, see §4.6).
5. Existing R2 chapters (Documentos exactos, booth, Cómo trabajamos, Por qué Bridge, Guías, close, contacto) stay, resized. "Por qué Bridge" may overlap the six boxes; the builder merges or trims so the page does not say the same thing twice, and records the call.

### 4.3 Certified Translation

- Kept "practically as is" (client), resized.
- New section **Muestras certificadas**: 2–3 sample translated documents showing the certification (seal, signature block, folio), as images with a caption. Placeholders built from the existing `r2-sheet` / seal pieces and marked `[muestra de Bridge, documento anonimizado]`. Bridge supplies redacted real samples later (placeholder register).
- Language pair checker replaced (§4.6).

### 4.4 Interpretation (simultaneous)

- Layout kept; resized; brought lightly into the R2 grounds and monument system (it is still pre-R2 markup).
- Hero photo replaced (client: "una más apropiada"). The photo itself is open (§8).
- Event planner (configurator) kept.
- **Removed:** "Cuándo: simultánea vs consecutiva" and the FAQ section. Both contents **move to the FAQ page** (owner agreed).
- Rest kept (Qué incluye, Tipos de evento, Planificación, related services, contact).

### 4.5 Quote flow — proposed adjustments (agent review, for owner sign-off)

Functionality works; these are presentation and content fixes:

1. **Visual pass:** chooser, both forms and the thank-you page get the R3 rhythm and type; forms stay calm (no monuments, no motion).
2. **One language list.** The translation form offers 14 languages + Otro; the event form offers 5 + Otro. Both read from the same 10–15 language list as the Languages band (§4.6).
3. **Event form, languages:** drop the "Idiomas además del español" count select; the count follows the checked languages. Today they can contradict each other.
4. **Translation form, service vs. certification overlap:** the service select has "notariada" and the checkboxes have "Notarización". Proposal: service = Certificada · Legal · Escrita (general) · No estoy seguro; notarization and apostille stay only as checkboxes.
5. **Volume field** (supports the client's "grandes volúmenes" box): optional "Volumen aproximado" (pages or words) on the translation form.
6. **Consistent aside:** the translation form uses a raised card, the event form a top rule; use one. Also replace `rounded-[var(--radius-sm,8px)]` / `--radius-md,14px` fallbacks in the event form with the token classes (`rounded-control`, `rounded-card`).
7. **Copy fixes:** the event form's privacy note says "datos y archivos" but takes no files; the thank-you page says "los documentos que adjuntó" for event requests too. Thank-you text follows the service (query parameter, a few lines of JS).
8. **Chooser page:** add a third, quieter entry "¿Proyecto grande o con IA? Escríbanos" pointing to Contacto, so the two new boxes have somewhere to land.
9. Client's own text corrections: waiting for their list (§8).

### 4.6 Languages (Home and Certified)

- The pair checker (`sig-lang-checker`, two selects + swap + verdict) is **replaced** by a visible list of all working languages (10–15) as one typographic band: each name in Spanish with its own-language name beside it (`Inglés · English`, `Kichwa · Kichwa`), using the R2 type-wall look.
- Under it: **"¿No ve su idioma? Pregúntenos."** with two actions: WhatsApp with a prefilled message ("Hola, ¿trabajan con el idioma …?") and the translation quote form with "Otro" preselected. No new form (P5).
- `brand/SIGNATURE-COMPONENTS.md` is updated in the same change (the checker leaves the signature set; the band takes its place).
- The list in the prototype is an example; the real list is Bridge's (CMS `Language` model later).

### 4.7 New pages

- **Blog index:** featured post + list of post cards (title, date, category, excerpt); categories as plain filter links. Placeholder posts drawn from the current "Guías" topics.
- **Blog article:** readable column (~68ch), title, date, author line, body with headings, quote, image, and a closing CTA to quote. Related posts at the end.
- **FAQ:** grouped by Traducción · Interpretación · Cotización y pagos; native `<details>` items. Receives the interpretation FAQ and the simultánea-vs-consecutiva content. Anchor per group so service pages can link in.
- **Contacto:** contact data (placeholders; `Settings` in the real site), WhatsApp, hours, address and a map placeholder (static image + link, no Google embed before consent), plus a short static contact form styled like the quote forms, and a "Para cotizar, use el cotizador" link.

## 5. Constraints

- `prototype/` only; no Laravel. CLAUDE.md §5: this is "a remaster round with a new owner-approved synthesis gate"; this document is that gate.
- Tokens only, contrast computed (≥ 4.5:1), amber only on dark grounds, vanilla JS, no new libraries (ADR D3.7).
- R2 (BRG-81) and R1 (BRG-68) tests that assert the pair checker, monument sizes or removed sections are superseded: the R3 spec lists each one it replaces, as BRG-81 §3.9 did for R1.
- No real Bridge data or client documents; placeholders go to `docs/placeholder-register.md`.
- Mode C: spec `docs/specs/brg-<n>.md` before tests, red, green, C3, one independent review, `check.mjs` green at 320/390/1440 for every page.

## 6. How it will be checked

- Contract tests (markup) and browser tests per page, extending the R2 suites.
- New browser assertion for §3.2: at 1440×900, each section's heading and first content line sit inside one viewport height from the section top; hero button above the fold.
- Video: no request to any YouTube host before the click; after the click an `iframe` from `youtube-nocookie.com`.
- `check.mjs` on all pages (existing + Blog ×2, FAQ, Contacto): 0 axe violations, no overflow, no clipped text, motion on and off.

## 7. Delivery

One story (`BRG-<n>`, R3) on one branch, in this order so the owner can review partial work:

1. System (rhythm + type ceiling) on the existing pages.
2. Home (six boxes, video, languages band) and Certified (samples, languages band).
3. Interpretation.
4. Quote flow.
5. Blog, FAQ, Contacto.

Each block is a commit set with its own red/green. If the owner prefers, blocks 4 and 5 can be separate PRs.

## 8. Open — needs the owner

Answered 2026-11-05:

1. The six moving boxes are Lionbridge's hero tiles → §4.2 item 1.
2. Interpretation hero photo: licensed stock placeholder for now (free-licence source, e.g. Unsplash/Pexels, credited in the placeholder register).
3. Client's text corrections for the quoters: asked once the prototype is ready. Not blocking.
4. Video poster: see §4.2 item 3 (designed poster, since the frames carry the old logo).

5. The six tiles replace the crossing demo in the hero; the crossing moves to "Documentos exactos". Rollback point: the R2 hero is `develop` at `911dbb0` (proposed tag `prototype-r2`).

## 9. Calls made by the agent (check while reading)

- Nosotros removed from the menu rather than linked to the video.
- Video as click-to-load facade on `youtube-nocookie`.
- Pair checker removed, not kept beside the list.
- Map as static image + link.
- Quote-flow proposals 1–8 in §4.5.
- FAQ groups and Blog structure in §4.7.
- One story, five blocks, in the order of §7.
