# Handoff v8 — Bridge Traducciones (website)

**Date:** 2026-10-21 · **Phase:** P4 Public site (opened 2026-10-19) · **Layer:** prototype
**Session focus:** BRG-81, the R2 remaster of Home and Certified Translation with the wow-direction skill, run end to end under mode C; PR #82 waits for the owner.

> Continues [`HANDOFF_v7.md`](HANDOFF_v7.md). Branch `feature/BRG-81-remaster-r2`, head `00c2006` plus this handoff, pushed. PR [#82](https://github.com/Cheboy04/Bridge_WebPage/pull/82) to `develop` is open. Rollback point: `origin/develop` at `98834e5`.

## 1. Executive status

- R2 is built on the two R1 pages: ground rotation (white, Bruma, Tinta, new Bridge blue), one monument per chapter, a live language pair, a type wall, institution tabs, a sticky request sheet, a halftone booth photo and motion paced to reading.
- `npm test` passes 22/22 (BRG-68 and BRG-81). `check.mjs` is green at 320, 390 and 1440. C3: 15 of 15 mutations killed.
- One independent review, one fix batch and a delta review are done. The reviewer's 9 findings are all closed or recorded as known limits in spec §6.
- The site (`site/`) was not touched. The phase-04 start gate still waits on the owner's approval of the prototype design.

## 2. GitHub Issues

- #81 was opened in milestone P4. PR #82 closes it.
- Not done: #43 (brg-33) is still in milestone "P2 Data"; moving it is the owner's call.

## 3. Decisions of the session

1. The owner approved synthesis A–D: the blue ground, motion allowed (the DIRECTION.md ban on parallax and animation is removed), the halftone, and full strength. The owner then approved story v2.
2. Decisions I took alone are listed in the PR: the test 8 `:is()` root, stage roles on Documento tokens, the phone band under the monument, the visible kicker, the dropped logo placeholder line, the type-wall languages as examples, the sheet starting at step 1 with motion on, the halftone as a committed script, and #6F9BD0 as a decorative-only border.

## 4. Evidence

- Red at `6eb02c7`: 12 of 12 R2 cases failed and BRG-68's 10 stayed green. Green from `a69788f` to `8e6da57`.
- C3: 15 of 15 killed. The runner (`scratchpad/c3/run.py`) restores each file's original text.
- After captures are in `audit/remaster-r2/after/` (git-ignored), recaptured after the last fix.

## 5. Files of the session (agent)

- `docs/specs/brg-81.md`, `brand/DIRECTION.md`, `brand/SIGNATURE-COMPONENTS.md`, `docs/backlog/key-map.md`, `docs/backlog/sprints/phase-04.md`, `docs/global/lecciones-transversales.md`.
- In `prototype/`: `src/pages/index.html`, `src/pages/traduccion-certificada.html`, `src/styles/remaster-r2.css`, `src/styles/app.css`, `src/assets/js/remaster-r2.js`, `tools/halftone.py`, the halftone images, and `tests/remaster-r2*.mjs`.
- Outside the repo (no git): the wow-direction `lessons.md`, and in the library `directions.md` (BD2), `references.md` (L8–L17) and `frames/`.

## 6. Operational traps

1. **The C3 restore wiped fixes.** `git checkout -- f` undid uncommitted fixes. The runner now writes the original text back. This is in the lessons.
2. **Overflow checks miss clipped text.** `overflow-x: clip` keeps `scrollWidth` green while text is cut. Test 9 now checks text edges, with motion off and on.
3. **Motion-only bugs.** The parallax image covered its caption only with motion on. Test 9 runs both passes.
4. **Stale captures.** The reviewer caught captures older than the commit they were meant to prove. Recapture after the last fix.
5. **Tooling.** The shell is zsh (use `bash -c` for loops). Pillow is only in the scratchpad venv. `motion-probe.mjs` ignores `CHROMIUM_PATH`. The GateGuard hook asks for facts before each first edit.

Still valid from earlier handoffs: the v5 trap 1 (pinned Playwright and Chromium for `check.mjs`).

## 7. Detected drift

- None new. Home's guide plates and Certified's related plates still read as a plain list; that is a known weak beat, not drift.

## 8. Ordered next steps

1. Owner reviews and merges PR #82, or asks for changes.
2. Owner: move #43 to the right milestone; decide what to do with branch `docs/readme` (`25fbe4f`, no PR); upgrade local PHP to ≥ 8.5.12.
3. Owner approves the prototype design for P4 (start gate), or runs another round. A candidate for that round is the plates.
4. brg-39 / `BRG-49` (browser harness, ADR 11.3) is Ready. Then brg-01 and the page stories per `phase-04.md`. When ported, the R2 behaviour carries over from SIGNATURE-COMPONENTS.
5. Carried: brg-33 hosting checks; mail provider (ADR open #7) before P5.
