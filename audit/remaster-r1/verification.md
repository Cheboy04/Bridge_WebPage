# BRG-68 R1 verification

**Date:** 2026-10-19. **Scope:** Home and Certified Translation reference-prototype pages only.

## Automated gates

- `npm test`: 7/7 Node contract cases green; the real prototype build runs before assertions.
- `node --check`: `check.mjs`, `remaster-home.js` and `sig-documento.js` parse cleanly.
- `node check.mjs index traduccion-certificada`: both pages pass at 320, 390 and 1440 CSS px with no horizontal overflow, console error, undersized non-inline target or axe WCAG A/AA/best-practice violation.
- Browser gate now exits nonzero on any recorded failure. An intentional 640 px minimum-width mutation produced overflow at 390 and 320 and exited 1.
- C3: 10/10 targeted mutations killed; details are recorded in `docs/specs/brg-68.md`.

## Visual evidence

- Local before evidence: `audit/remaster-r1/before/{home,certified-translation}/`.
- Local after evidence: `audit/remaster-r1/after/{home,certified-translation}/`, including 1440, 390 and 320 full-page captures and contact sheets.
- `after-evidence.json` passes the frontend-direction evidence checker. Captures remain git-ignored because Home contains the provisional booth photo with identifiable people and the repository is public.

Visual inspection confirms the approved synthesis:

- Home opens with one source → target → signed-result composition; translation leads and Cabina remains a full dark chapter.
- Service proof is de-boxed into ruled rows; the existing checker and all verified content remain.
- Certified Translation is document-led and contains no stock-photo asset.
- Both pages finish with the shared “original → traducción → firma” close.
- At 390 and 320, content stays in linear order and decorative crossings withdraw before they can cover meaning.

## Independent review

The final read-only reviewer found four issues. All were resolved before delivery: the browser checker now fails closed, the Certified signature uses a page-scoped transform/opacity entrance rather than the shared clip slider, arrival controls preserve focus and disappear under reduced motion, and the static Certified sheet uses a border instead of a resting shadow.

The remaining six prototype pages have no R1 opt-in class or `data-remaster-*` hook and were not redesigned.

## Post-review revision — 2026-10-19

An independent review of PR #69 (Claude, at the owner's request) found what the gates above missed:

- **Escaped amber trail.** The Home hero rule `.page-home-r1 .r1-crossing-decor { position: absolute; top: 26% }` also matched the close's trail. `.r1-close` is not positioned, so the trail rendered at the top of the page as amber dots on a light surface (brand `DIRECTION.md` §2). Axe, overflow and the source contract cannot see this, and the full-page captures were checked only downscaled. Fixed by scoping to `.r1-crossing > .r1-crossing-decor`; browser test 9 now fails on any decoration outside its section.
- **Brand docs drift.** The monument type role, R1 de-boxing, arrival and close existed only in code. Now recorded in `brand/DIRECTION.md` §3–§5 and `brand/SIGNATURE-COMPONENTS.md`.
- **Slider restored (owner decision).** The before/after slider is the Certified signature moment again, with a "Deslice" handle label, tappable "Original" / "Traducción certificada" buttons and a how-to line shown only in slider mode.
- **Certified hero.** The hidden, unused monument paragraph is removed; the "En resumen" heading is separated from the sample text by a rule.

Evidence: `npm test` 10/10; `check.mjs` green on both pages at 320/390/1440; axe on the live slider 0 violations; C3 5/5 (see spec log). Review method that caught the bug: full-page captures cut into 1440×1800 crops and read at 50 %, not as a single thumbnail.
