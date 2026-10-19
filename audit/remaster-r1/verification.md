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
