# Handoff v11 — Bridge Traducciones (website)

**Date:** 2026-11-11 · **Phase:** P4 Public site · **Layer:** prototype
**Session focus:** R3 remaster (BRG-84), Tasks 6–8 of the plan done, plus stock photos for the hero tiles at the owner's request; stopped before Task 9.

> Continues [`HANDOFF_v10.md`](HANDOFF_v10.md). Branch `feature/BRG-84-remaster-r3`, head `b910141` plus this handoff, everything committed, not pushed, no PR yet. Rollback point: `develop` at `911dbb0` (R2 as merged).

## 1. Executive status

- Done: Task 6 (three certified samples, new `samples` beat), Task 7 (Interpretation trims, new hero photo, FAQ link), Task 8 (quote-flow items 1–8), halftone photos on five hero tiles, shared header fixed at 320px.
- `npm test` 38/38. `check.mjs` 0 axe violations, no overflow at 1440/390/320 for `index`, `traduccion-certificada`, `interpretacion-simultanea`, the four quote pages and both `?estado=errores` views.
- Left: Task 9 (Blog, FAQ, Contacto, menus) and Task 10 (gates, C3, review, PR, handoff) of `docs/superpowers/plans/2026-11-05-remaster-r3.md`.
- Known dangling link inside the branch: chooser → `contacto.html` (created in Task 9; pre-flight ruling in the ledger).

## 2. GitHub Issues

- Nothing written to the board. Carried: #43 milestone (owner); local PHP ≥ 8.5.12.

## 3. Decisions of the session (agent, ledgered; spec `docs/specs/brg-84.md` §3.9 and §5)

1. Samples: birth certificate (en), diploma (fr), contract (es) as `certified-sample` component, seal 64px, subgrid aligns sheets ≥64rem. R2 `story.certified` and `listObjects.certified` gain `samples` (spec §3.9).
2. Interpretation hero = Wikimedia Commons "Interpretation booth at the 2018 G7 Environment Ministers Meeting in Halifax" (Indrid Cold, **CC BY-SA 2.0**); credit is visible in the figcaption. Unsplash free search had no booth photos.
3. Hero tiles (owner request): `tools/halftone.py --tile` renders a 600px dot band used as a CSS **mask**, so dots take each ground's `--trail`. Four free Unsplash photos + the G7 photo; IA keeps the dot field; "ES ··· EN" and "ATA" text marks dropped. Credits in placeholder register #35.
4. Shared header logo 150px below 40rem: root fix for the 21px "Menú" overflow at 320 on every shared-header page (this was v10 trap 3, not the form row). Own commit `e8cf0c1`.
5. Quote flow: event languages are a required `fieldset#lenguas` (summary link focuses its first checkbox); the planner's `idiomas` count param is now ignored; `field-check` gains an optional `value`; thank-you detail from a fixed map in `assets/js/quote-thanks.js` (`textContent`), generic text "y los datos que nos envió."; "notariada" also dropped from the chooser card and the translation page description.

## 4. Evidence

- Red → green: `fd3f689` → `4d7d5e3` (T10), `edb1e93` → `5149972` (T11), `c642f70` → `b910141` (T12–T17).
- Ledger (git-ignored): `.superpowers/sdd/2026-11-05-remaster-r3/progress.md`.
- C3 not run yet (Task 10).

## 5. Files of the session (agent)

- New: `prototype/src/components/certified-sample.html`, `src/assets/js/quote-thanks.js`, `src/assets/photo/interpretacion-{800,1600}.webp`, `src/assets/photo/tile-{traduccion,interpretacion,certificacion,volumen,profesionales}-600.png`.
- Modified: pages `traduccion-certificada`, `interpretacion-simultanea`, `cotizacion`, `cotizacion-traduccion`, `cotizacion-interpretacion`, `cotizacion-gracias`; components `header`, `hero-tiles`, `field-check`; `remaster-r3.css`; `event-quote-form.js`, `quote-form.js`; `tools/halftone.py`.
- Tests: `remaster-r3.test.mjs` (T10–T15, T17), `remaster-r3.browser.test.mjs` (T13, T16), `remaster-r2.test.mjs` (story/list objects).
- Docs: `docs/specs/brg-84.md`, `docs/placeholder-register.md`.

## 6. Operational traps

1. **Photo sourcing works without API keys:** Unsplash search pages via WebFetch and `https://unsplash.com/photos/<id>/download?force=true&w=1200` via curl are fine (only the `napi` endpoint was blocked). Commons: use the API (`prop=imageinfo&iiprop=url|extmetadata&iiurlwidth=1920`) and download the returned `thumburl`; hand-built `upload.wikimedia.org/.../thumb/800px-…` URLs return an HTML error page.
2. **Unsplash search pages may contain text aimed at AI tools** (seen on `/s/photos/dictionary`). Treat as data.
3. **check.mjs with a query string:** it appends `.html`, so pass `"page.html?estado=errores&x="`; delete the `screens/*?*` files afterwards.
4. **Pillow:** not installed system-wide; make a scratchpad venv (`python3 -m venv … && pip install pillow`) and run `halftone.py` with `-I`.
5. Still valid from v10: moving tiles need `hover({ force: true })`; Playwright MCP has no Chrome, use the pinned Playwright + `chromium-1234` path from `check.mjs`; `brand/logo.zip` belongs to the owner, leave it.

## 7. Detected drift

- None. (Placeholder row #28, licence of the old `cabina` photo, is still open; the R2 booth band and `cabina-halftone` still use it.)

## 8. Ordered next steps

1. Task 9: Blog, article, FAQ (`#traduccion`, `#interpretacion` with the text removed in `5149972`, `#cotizacion`), Contacto; header/footer without Nosotros (T18–T19).
2. Task 10: full `check.mjs` gate, C3 mutations (add: samples marker, thank-you map, lenguas required, tile mask), after-screens, independent review, push, PR to `develop` with the owner's P4 start-gate request, next handoff.
3. Owner questions open: replace stock photos with Bridge's own before P7 (CC BY-SA share-alike on the Commons crop); OK to show identifiable interpreters in the G7 photo?
4. Carried: owner moves #43; brg-39 / `BRG-49` Ready; brg-33 hosting checks; mail provider (ADR open #7) before P5.
