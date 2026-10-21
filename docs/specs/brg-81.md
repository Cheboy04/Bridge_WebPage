# BRG-81 (prototype) — Remaster R2: Home and Certified Translation, designed all the way through

> **GitHub Issues:** `BRG-81` · **Phase:** P4 design track (before the page stories port the prototype) · **Covers:** RNF-06, RNF-09
> **Counterpart:** — (the Laravel public-site port stays in the P4 page stories)
> **Status:** `[x]` draft · `[x]` approved (mode C) · `[ ]` implemented

This spec turns the approved R2 synthesis (A–D) and story v2 into a testable contract for the static reference. It changes only Home and Certified Translation, on top of BRG-68 (R1), whose contract stays in force except where §3.9 says otherwise.

## 1. Scope in this layer

**In:**

- Rebuild every middle chapter of `prototype/src/pages/index.html` and `traduccion-certificada.html` to `audit/remaster-r2/decisions/story-v2.md`: four-ground rotation, a monument heading per chapter, list objects, seam bands, the halftone booth, the sticky sheet, the crossed word, the live pair headline, reading-paced motion and a cross-document view transition between the two pages.
- A Bridge-blue ground (`.mode-bridge`) in the token file, with computed contrast pairs.
- One page-scoped stylesheet `src/styles/remaster-r2.css` and one script `src/assets/js/remaster-r2.js`.
- Halftone images `src/assets/photo/cabina-halftone-{800,1600}.png`, generated from `cabina-1600.webp` by the committed script `tools/halftone.py`.
- The brand docs that own the rules (`brand/DIRECTION.md` §2, §3, §4, §5, §6, §9; `brand/SIGNATURE-COMPONENTS.md`) updated in the same change.
- Contract tests, browser tests and the `check.mjs` gate for both pages.

**Out / deferred:**

- The other six prototype pages, and any shared component's markup (checker, slider, FAQ item, header, footer, close).
- Laravel/Blade, CMS wiring → P4 page stories.
- New copy claims, credentials, real documents, final seal → Bridge-owned (`docs/placeholder-register.md`).
- An animation library, WebGL, smooth-scroll or wheel hijacking (ADR D3.7; owner decision B keeps wheel hijacking out).

## 2. Dependencies

- **GitHub Issues:** BRG-81.
- **Design evidence:** `audit/remaster-r2/r1-review.md`, `research/*`, `decisions/r2-synthesis.md` (A–D answered 2026-10-21), `decisions/story-v2.md` (approved 2026-10-21).
- **Vetoes:** `CLAUDE.md` §5 allows `prototype/` changes for "a remaster round with a new owner-approved synthesis gate"; this is that round.
- **ADR (DECIDED):** D2.2, D3.7, D3.8, D11.2. **Owner decision B (2026-10-21):** `DIRECTION.md` §9's ban on parallax and concurrent motion is removed.
- **External:** none. Pillow runs only in an isolated venv to regenerate the halftone; it is not a project dependency.

## 3. Technical contract

### 3.1 Page boundary

- Both pages' `<body>` carry `data-remaster-round="r2"`; no other page does. R1's opt-in classes stay.
- Every rule in `remaster-r2.css` is rooted in `.page-home-r1` or `.page-certified-r1`. No hex values, no font-family literals (tokens only).
- `.mode-bridge` is a token mode in `app.css` (the only file that holds hex values).

### 3.2 Grounds

- Every chapter (`[data-remaster-beat]`) carries `data-ground` = `white | bruma | blue | tinta`.
- Home order: arrival white · relevance bruma · document-proof white · cabina-handoff tinta · proof-process bruma · why blue · guides white · close tinta · contact bruma.
- Certified order: arrival white · transformation tinta · fit-proof white · documents bruma · price blue · languages white · faq bruma · related white · process bruma · close tinta · contact white.
- No two adjacent chapters share a ground; at most one `blue` per page.
- `.mode-bridge`: surface `#1C61AD`, text `#FFFFFF` (6.25:1), muted `#F4F6F9` (5.77:1), accent (button fill) `#FFFFFF` with on-accent `#1C61AD` (6.25:1), focus and trail white. Amber never appears on blue.

### 3.3 Monuments and list objects

- Every chapter after the arrival has a real `h2` with class `r2-monument` (≥ ~6vw on desktop, scaled down at 390 and 320). The arrival and the shared close keep their R1 monuments. In the languages chapter the `h2` carries a visible, stable kicker that is its accessible name ("Su combinación de idiomas") and shows the live pair `[data-r2-pair]` (`aria-hidden`); the checker's own heading drops to `h3`. A monument's final full stop may be a trail dot (`.r2-stop`, `aria-hidden`) with a visually hidden period kept for screen readers.
- List objects (`data-list-object`):
  - Home document-proof: `active-rows` (three services at monument scale; the row under hover or focus is ink, the rest muted; each row is a link).
  - Home proof-process and Certified process: `sticky-sheet`.
  - Home guides: `plates`.
  - Certified fit-proof: `index-tabs`. Certified documents: `type-wall`. Certified FAQ: `active-rows` (native `<details>`). Certified related: `plates`.
  - No two adjacent chapters use the same list object.
- Muted rows still meet 4.5:1 (they use `--text-muted`, never opacity on text).

### 3.4 Interactive pieces (`remaster-r2.js`)

- **Live pair headline** (both pages, languages chapter): an `aria-hidden` monument `[data-r2-pair]` shows the selected origin and target names joined by trail dots. It updates on the checker's `change` and on swap. The checker's own `role="status"` result stays the accessible output; the checker component is not edited.
- **Index tabs** (Certified fit-proof): `role="tablist"` with four `role="tab"` buttons and `role="tabpanel"` panels. Arrow keys, Home and End move between tabs (automatic activation); `aria-selected`, `tabindex` and `hidden` follow. Without JavaScript the tablist is hidden and every panel is visible as a list with its heading.
- **Sticky sheet** (both process chapters): `[data-r2-sheet]` sets `data-step` from the step in the middle of the viewport (IntersectionObserver). The sheet is `aria-hidden` (the steps carry the meaning). Without JavaScript, or under reduced motion, `data-step` is the last step (complete sheet). With motion allowed the script starts the sheet at step 1, so the story builds forward.
- The script runs once per page, makes no network requests, and adds no global other than an idempotence flag.

### 3.5 Imagery

- Home Cabina uses one `<img>`: `assets/photo/cabina-halftone-800.png` / `-1600.png` via `srcset`, real alt text, and a caption containing "trama de puntos" and "provisional". `cabina-*.webp` is no longer referenced on these pages (the file stays for other pages).
- Certified uses no `assets/photo/` image.

### 3.6 Crossed word and seams

- Certified transformation: the `h2` monument "Fiel al original." is crossed by an `aria-hidden` band (`.r2-cross`) carrying `lang="en"` "Faithful to the original." Exactly one crossed band per page; none on Home. Below 64rem the band sits under the monument instead of across it, so the heading stays whole at phone sizes.
- Seam bands (`.r2-seam`, `aria-hidden`) sit inside the section they belong to, take that section's trail colour, and never render amber on a non-Tinta ground.
- The slider's sheets stay white on the Tinta chapter: `remaster-r2.css` re-points the stage's colour roles to the Documento tokens (the shared component is not edited, so no class is added to it); its contract (BRG-68 §3.3, `SIGNATURE-COMPONENTS.md` #4) is unchanged.

### 3.7 Motion

- Allowed (owner decision B): parallax and concurrent motion via CSS scroll-driven animations (`animation-timeline: view()` / `scroll()`), transforms and opacity; small JS only for the sheet and tabs.
- Everything is complete and readable at rest: without scroll-timeline support, without JS, and under `prefers-reduced-motion: reduce` (no running animation, every reveal at its end state).
- Reveal start states never hide text from assistive technology (no `visibility:hidden`, no `display:none`).
- Cross-document View Transition between the two pages only (`@view-transition { navigation: auto }` declared in each page, not in the shared stylesheet).

### 3.8 Accessibility gates

- DOM order is linear; one `h1` per page; every section is labelled.
- At 320, 390 and 1440: 0 axe violations, no horizontal overflow, no console errors, every target ≥ 44 px (`check.mjs`).
- Every decoration (`.r2-seam`, `.r2-cross`, `.r2-stop`, `[data-r2-pair]`, the sheet) is `aria-hidden` and stays inside its section.

### 3.9 Changes to the BRG-68 contract

- BRG-68 test 2's photo assertion (`cabina-800.webp` srcset) is replaced: Home's single image is now the halftone (§3.5). Logged in `brg-68.md` §6.
- BRG-68 test 2's beat list stays a subsequence of the R2 beat order.
- The home trust strip include is replaced by a ruled facts line inside the relevance chapter (same facts, same placeholders).

## 4. Acceptance criteria → tests

Runner: `node:test` on source and built `dist/` (contract), Playwright with the pinned Chromium (browser), and `check.mjs`. No new dependency.

| # | Test (file::case) | Asserts | Proven red (C3) by |
| --- | --- | --- | --- |
| 1 | `tests/remaster-r2.test.mjs::only Home and Certified opt into R2` | `data-remaster-round="r2"`, `remaster-r2.js` and `@view-transition` on exactly the two pages | Adding the attribute to another page |
| 2 | `…::grounds follow the story and never repeat` | Exact `data-ground` sequences per page; no adjacent repeat; ≤ 1 blue | Swapping two grounds |
| 3 | `…::every chapter heading is a monument` | Built pages: each beat except the arrival and the close has an `h2.r2-monument` | Removing the class from one heading |
| 4 | `…::list objects match the story and alternate` | `data-list-object` values and order per page; no adjacent repeat | Changing `type-wall` to `active-rows` next to the FAQ |
| 5 | `…::Home shows the booth as a disclosed halftone` | One `<img>`, halftone srcset, alt, caption disclosure; no `cabina-*.webp`; Certified has no photo; both halftone files exist | Pointing the img back to the webp |
| 6 | `…::one crossed word, decorations hidden from AT` | Exactly one `.r2-cross` on Certified, none on Home; every `.r2-seam`, `.r2-cross`, `.r2-stop`, `[data-r2-pair]`, `[data-r2-sheet]` is `aria-hidden="true"` | Dropping `aria-hidden` from one seam |
| 7 | `…::the blue ground meets contrast` | Parses `.mode-bridge` from `app.css`; text/surface, muted/surface and on-accent/accent ≥ 4.5:1; trail is not amber | Setting muted to `#A9B8CC` |
| 8 | `…::R2 styles are scoped, tokenised and motion-safe` | `remaster-r2.css` imported; every selector rooted at a page class; no hex; a reduced-motion block; scroll-driven rules inside `@supports` | Unscoping one rule |
| 9 | `tests/remaster-r2.browser.test.mjs::decorations stay inside their section and amber stays on Tinta` | At 1440 and 390 every R2 decoration's box is inside its section; no amber seam on a non-Tinta ground; no chapter text is pushed past the viewport (chapters clip horizontally, so `check.mjs` cannot see it) | Giving a seam a page-relative position |
| 10 | `…::the pair headline follows the checker` | Choosing francés → español and pressing swap updates `[data-r2-pair]` | Removing the change listener |
| 11 | `…::institution tabs work by keyboard` | ArrowRight / End move selection and panels; one panel visible | Not updating `hidden` on key press |
| 12 | `…::the sheet follows the steps, and is complete at rest` | Motion allowed: scrolling to step 3 sets `data-step="3"`; reduced motion: `data-step` is the last step and no animation runs | Leaving `data-step` at 1 under reduced motion |
| 13 | `check.mjs index traduccion-certificada` | 0 axe, overflow, console errors, small targets at 320/390/1440 | (gate, run as-is) |

BRG-68 tests 1–11 keep running (`npm test`); test 2 changes per §3.9.

## 5. Implementation notes

- Reuse: checker, slider, FAQ item, seal and close includes are used unchanged; only their surroundings change.
- Visual proof is the before/after crops per beat (`audit/remaster-r2/after/`), read at 50 % or more, and an independent review; the tests are guardrails.
- Lessons in force: decorations scoped to their composition (R1), no approved interaction removed by a new rule (R1), every beat checked in after captures (R1).

## 6. Spec change log

- `2026-10-21` — independent review (1 blocker, 5 should-fix, 3 nits), one fix batch: the halftone's parallax painted over its disclosure caption (only the image frame clips now; test 9 runs a second pass with motion allowed and checks that the caption is not covered, proven red on the old markup); the sheet starts at step 1 when motion is allowed; the plate nudge uses `transform` so the reveal's `translate` no longer cancels it; the tab stack renders (`isolation`), the selected tab joins its panel and carries a 3px trail rule; the script guards missing elements; the type wall says its target languages are examples and the dropped document names are back in the sentence under it; the languages kicker is visible (this section updated). DIRECTION §2 records the blue border token as #6F9BD0.
- `2026-10-21` — implemented: 22/22 cases green (`npm test`, BRG-68 and BRG-81); `check.mjs index traduccion-certificada` green at 320/390/1440. Visual pass on the after captures found two phone defects the gates missed: the fit-proof column was widened by the tab row and clipped by the chapter, and the crossed band covered most of the monument. Both fixed; test 9 now fails on clipped chapter text (proven red before the fix). Test 8 accepts `:is(.page-home-r1, .page-certified-r1)` as the page root. Home's trust strip include is replaced by the facts line (the client-logo placeholder line is dropped; it is in the placeholder register and returns with real permissions).
- `2026-10-21` — created and approved by the agent under mode C after the owner approved synthesis A–D and story v2.
