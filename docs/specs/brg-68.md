# BRG-68 (prototype) — Evidence-led Home and Certified Translation remaster

> **GitHub Issues:** `BRG-68` · **Phase:** P2 parallel design track · **Covers:** RNF-06, RNF-09
> **Counterpart:** — (the Laravel public-site port remains in P4)
> **Status:** `[x]` draft · `[x]` approved (mode C) · `[x]` implemented

This spec turns the approved R1 synthesis and story into a testable static-reference contract. It changes only Home and Certified Translation; it does not implement the public site in Laravel.

## 1. Scope in this layer

**In:**

- Remaster `prototype/src/pages/index.html` and `prototype/src/pages/traduccion-certificada.html` to the approved story in `audit/remaster-r1/decisions/story-v1.md`.
- Add page-scoped R1 composition CSS imported by the existing Tailwind entrypoint. Reuse the current tokens, modes, components, fonts, booth image, trail, provisional seal and verified copy.
- Add only the small Home-arrival behavior needed for a skippable, replayable, one-time signature moment. The complete end state is present without JavaScript and under reduced motion.
- Keep the Home language-pair checker behavior/data unchanged and use the existing certified before/after component as that page's single signature moment.
- Extend the existing prototype browser check to exercise the two pages at 320, 390 and 1440 CSS px.
- Capture fresh after evidence and compare it with `audit/remaster-r1/before/` at desktop and mobile widths.

**Out / deferred:**

- Laravel/Blade public pages, CMS wiring and browser-test choice → P4 stories and `BRG-39`.
- Remastering any of the other six prototype pages → later owner-approved synthesis gate.
- New copy claims, credentials, real client documents, a final seal, or new photography → Bridge-owned facts/assets in `docs/placeholder-register.md`.
- Cross-document transitions, animation libraries, WebGL, smooth scrolling or a new dependency → no demonstrated need in this slice.
- Changes to the language-checker data contract or quote flows → outside BRG-68.

## 2. Dependencies

- **GitHub Issues:** BRG-68.
- **Design evidence:** `audit/remaster-r1/audit.md`, approved `audit/remaster-r1/decisions/r1-synthesis.md`, approved `audit/remaster-r1/decisions/story-v1.md`.
- **Vetoes:** the `prototype/` veto in `CLAUDE.md` §5 is lifted on 2026-10-19 only for BRG-68 Home and Certified Translation; `docs/backlog/sprints/phase-02.md` records the parallel track.
- **ADR (DECIDED):** D2.2, D3.7, D3.8, D11.2.
- **OPEN items that do not block:** final certification stamp and exact credentials remain provisional/omitted; D11.3 concerns the later Laravel harness; the performance instrument is not needed to preserve the existing no-new-asset/dependency budget.
- **External:** none.

## 3. Technical contract

### 3.1 Page boundary

- Home opts in with `body.page-home-r1`; Certified Translation opts in with `body.page-certified-r1`.
- New composition selectors live in `prototype/src/styles/remaster-r1.css` and are rooted in one or both opt-in classes. Existing tokens and shared components remain the source of colors, typefaces, controls, focus and modes.
- No other file in `prototype/src/pages/` receives either opt-in class or a `data-remaster-*` hook.

### 3.2 Home composition

- The beats appear in story order: arrival/promise, language relevance, document proof, Cabina handoff, process/proof, close.
- `data-signature-moment="home-crossing"` occurs exactly once. Its source phrase, target phrase, dotted trail and demonstrative signed result are meaningful in normal DOM order; decorative geometry is `aria-hidden="true"`.
- Translation appears before interpretation. The Cabina chapter has equal section weight, uses the existing booth image exactly once, and its field handoff is not marked as another signature moment.
- The current language-pair checker include and data behavior remain intact.
- `prototype/src/assets/js/remaster-home.js` enhances only the Home arrival. It skips automatically on repeat visits, exposes native skip/replay buttons when enhancement is active, and does not run the sequence when reduced motion is requested. Without JavaScript, the signed end state is visible.

### 3.3 Certified Translation composition

- The beats appear in story order: document-led arrival, before/after transformation, fit/proof, process, close.
- `data-signature-moment="certified-before-after"` occurs exactly once around the before/after signature component. The interactive clip-path slider stays enabled on this page (owner decision, 2026-10-19 review): no page-scoped entrance replaces it.
- The slider shows how to use it without reading the hint: a labelled handle (“Deslice”) that collapses once the user acts, and the two side labels are native buttons that move the divider to show the whole original or the whole certified translation. Drag, keyboard arrows and the buttons all drive the same `input type=range`. The how-to text shows only while the slider exists; the static side-by-side state never tells the user to drag.
- The page uses no `assets/photo/` image. Sheet geometry, folio, source/target text and the provisional seal supply the visual material.
- Existing service facts, caveats, language checker, FAQ, quote path, contact path and placeholder annotations remain present.

### 3.4 Shared close and growth

- Both pages use a small shared include for the “original → traducción → firma” close, followed by their existing contact/footer content.
- The close accepts only the existing destination/message differences needed by the two pages. It introduces no content model or future options.
- Monument text is an accent layer; each page retains a normal semantic heading. Long text stays in normal flow and no language name is embedded in decorative positioning.

### 3.5 Accessibility and motion

- DOM and heading order remain linear. Interactive elements are native, visibly labelled and at least 44 by 44 CSS px.
- New decoration cannot cover selectable text or controls and is hidden from assistive technology.
- At 320 CSS px (the 1280 px / 400% reflow equivalent), 390 px and 1440 px: no horizontal overflow, console error or axe WCAG A/AA violation.
- At narrow/reflow widths, decorative crossings withdraw before meaningful content clips or becomes two-dimensionally scrollable.
- New R1 motion uses transform/opacity only, completes within the existing duration vocabulary, and has a `prefers-reduced-motion` end state. Essential meaning never depends on animation. The before/after slider keeps its locked contract in `brand/SIGNATURE-COMPONENTS.md` #4, including the user-driven `clip-path`.
- Every decorative crossing stays inside the section that owns it. An absolutely positioned decoration is positioned only against its own composition (`.r1-crossing`, `.r1-certified-sheet`), never inherited by another section's decoration. Amber trail dots therefore appear only on Tinta (brand `DIRECTION.md` §2, §4).

### 3.6 Visual acceptance

- Desktop and mobile after captures show a material change from the baseline: monumental service language, hard white/Bruma/Tinta fields, de-boxed evidence rows and a designed close.
- The Home first composition is translation-led; the Cabina chapter remains a full chapter. Certified Translation remains document-led and stock-photo-free.
- The owner reviews the two-page after contact sheet before BRG-68 is considered complete. Remaining pages are not redesigned in this review.

## 4. Acceptance criteria of this layer → tests

Runner: Node's built-in `node:test` against the prototype source and built HTML, plus the existing Playwright/axe browser check. No new dependency. Real boundary (C4): `build.mjs` renders the actual includes and Tailwind entrypoint before built-output assertions.

| # | Test (file::case) | What it asserts | How we prove it FAILS (C3) |
| --- | --- | --- | --- |
| 1 | `tests/remaster-r1.test.mjs::only the approved two pages opt into R1` | Home and Certified carry their exact body classes/hooks; every other source page carries none | Remove Home's opt-in class; the page-boundary assertion fails |
| 2 | `tests/remaster-r1.test.mjs::Home follows the approved story with one signature moment` | Beat order, one Home signature hook, translation before Cabina, unchanged checker include and one booth image | Duplicate the signature hook on the Cabina handoff; the exact-count assertion fails |
| 3 | `tests/remaster-r1.test.mjs::Certified Translation is document led with one signature moment` | Beat order, one certified signature around the before/after include, provisional document material, no `assets/photo/`, the slider not disabled on the page and no competing entrance animation | Add the booth asset path to the certified source; the no-photo assertion fails |
| 4 | `tests/remaster-r1.test.mjs::both pages finish the story through the shared close` | Both pages include the same minimal close and built HTML contains the closing sequence before contact/footer | Remove the close include from either page; the source/built assertion fails |
| 5 | `tests/remaster-r1.test.mjs::R1 styles stay page scoped and support reflow` | The new stylesheet is imported, new selectors are rooted at the two opt-ins, a 320 px rule withdraws decoration, and no new raw color/font token is introduced | Remove `.page-home-r1` from a Home rule; the selector-scope assertion fails |
| 6 | `tests/remaster-r1.test.mjs::Home arrival progressively enhances to a static accessible end state` | One Home script, native skip/replay controls, repeat-visit state, reduced-motion branch, static end-state marker and transform/opacity-only keyframes | Remove the reduced-motion branch from the script; the motion-contract assertion fails |
| 7 | `tests/remaster-r1.test.mjs::built remaster keeps semantic and disclosure safeguards` | Built pages retain one h1, labelled sections, provisional/demo wording, `aria-hidden` on every crossing decoration, and no new credential/legal-validity claim | Remove `aria-hidden` from any crossing decoration; the built safeguard assertion fails |
| 9 | `tests/remaster-r1.browser.test.mjs::crossing decorations stay inside their own section` | At 1440 and 390, every visible `.r1-crossing-decor` box lies inside its closest `section` | Remove `position: relative` scoping so the close's trail inherits the hero offset; the trail lands in the hero and the case fails |
| 10 | `tests/remaster-r1.browser.test.mjs::Certified slider is operable by drag label, buttons and keyboard` | With motion allowed: the slider is live, the handle shows “Deslice”, the “Original” button reveals the whole original, “Traducción certificada” the whole translation, ArrowLeft moves the value, and the label collapses after use | Re-add the page-level early return in `sig-documento.js`; the slider never becomes ready and the case fails |
| 11 | `tests/remaster-r1.browser.test.mjs::reduced motion shows both sheets and no drag instruction` | With reduced motion: both sheets visible, no jump buttons, the how-to text hidden, Home arrival complete with skip hidden | Show the how-to text unconditionally; the case fails |
| 8 | `check.mjs index traduccion-certificada` | At 320/390/1440: no axe violation, horizontal overflow or console error; screenshots are produced with reduced motion | Give a remaster layer fixed width wider than 320 px; the 320 overflow result fails |

## 5. Implementation notes

- Reuse before replacing: keep the language checker, before/after component, seal, contact block, header/footer, booth asset and process content. Remove the Home tabbed hero only from Home; do not alter its shared gallery instance.
- Prefer one page-specific stylesheet and one small Home script over changing shared selectors that serve unapproved pages.
- Keep the source pages readable. Unique narrative composition stays inline; only the identical close earns a shared include.
- The source contract tests are guardrails, not visual proof. The after contact sheet and browser run decide visual/a11y acceptance.
- The existing `check.mjs` uses remote axe-core. If network is unavailable, record that limitation and do not report axe as green from screenshots alone.

## 6. Spec change log

- `2026-10-19` — post-review revision implemented: 10/10 contract and browser cases green (`npm test`); `check.mjs index traduccion-certificada` green at 320/390/1440 (0 axe, overflow, console errors or small targets); axe on the live slider (motion allowed) at 1440/390: 0 violations. C3: **5 mutations, 5 killed** — unscoped hero decoration (test 9), slider disabled on the page (tests 3, 10), how-to shown in the static state (test 11), label never collapsing on keyboard use (test 10, after tightening the case to use the keyboard before any button; it first survived), "Original" button bound to the wrong end (test 10).
- `2026-10-19` — post-review revision (owner request after the PR #69 review): (a) the Home close's decorative trail escaped to the top of the page as amber dots on a light surface, because the hero's absolute-position rule matched every `.r1-crossing-decor` on Home; scoped to its composition and covered by browser test 9. (b) The owner wants the before/after slider back on Certified with a clearer affordance; §3.3 and tests 3, 10, 11 changed accordingly. (c) The Certified hero's dead `aria-hidden` monument paragraph is removed and its summary heading is separated from the sample text. (d) Brand docs now record the R1 type role, de-boxing and close (rule 4 drift). Browser cases run through Playwright already used by `check.mjs`; no new dependency.
- `2026-10-19` — implemented: 7/7 Node contract cases green; build green; fail-enforcing browser gate green for both pages at 320/390/1440 with 0 axe violations, overflow and console errors. Independent final review's four findings were fixed: browser exit status, Certified motion boundary, arrival-control focus/reduced-motion behavior and at-rest sheet shadow.
- `2026-10-19` — review with C3: **10 mutations, 10 killed**. Mutations covered page opt-in, signature count, no-photo Certified, shared close, CSS scoping, reduced motion, every decoration's semantics, Certified's non-clip motion boundary, arrival focus transfer and the browser gate's nonzero overflow failure.
- `2026-10-19` — red: 7 Node contract cases fail for the intended missing R1 page hooks, beats, shared close, scoped stylesheet, arrival enhancement and built safeguards. The prototype build passes before the assertions; no case fails from the runner.
- `2026-10-19` — approved by the agent under mode C after the owner approved R1 synthesis A–C and Story v1; no OPEN ADR point blocks the static slice.
- `2026-10-19` — created. No Laravel/Blade implementation; no other prototype page may opt into R1.
