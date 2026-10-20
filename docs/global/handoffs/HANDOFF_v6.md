# Handoff v6 — Bridge Traducciones (website)

**Date:** 2026-10-19 · **Phase:** P2 Data + approved parallel design track · **Layer:** reference prototype
**Session focus:** review of PR #69 (BRG-68, built by another agent with the `wow-direction` skill) and post-review fixes on the same branch; the cycle is closed again and waits for the owner's merge.

> Continues [`HANDOFF_v5.md`](HANDOFF_v5.md). Branch `feature/BRG-68-visual-remaster`; PR #69 targets `develop`. Everything is committed and pushed.

## 1. Executive status

- The review found an escaped amber trail on Home, brand docs drift, string-pinned tests and a disabled before/after slider. All are fixed on the branch.
- The owner asked to bring the slider back with a clearer affordance: it now has a "Deslice" handle label, tappable "Original" / "Traducción certificada" buttons and a how-to line shown only in slider mode.
- `npm test` 10/10 (7 source-contract, 3 browser); `check.mjs` green on both pages at 320/390/1440.
- The `wow-direction` skill bundle (outside this repo, `~/Projects/BridgeV2/agent-agnostic-skills`) was patched in the same session; see §3.5.

## 2. GitHub Issues

- Review findings and fixes summarised as a comment on PR #69. No new issue: everything sits in BRG-68's scope.

## 3. Decisions of the session

1. **Slider restored (owner).** HANDOFF_v5 decision 4 is reversed: Certified's signature moment is the shared clip-path slider again. Spec §3.3 and §3.5 were updated first; `SIGNATURE-COMPONENTS.md` #4 records the new values.
2. **Decorations are positioned by their composition only.** Rule in spec §3.5, `DIRECTION.md` §4 and enforced by browser test 9.
3. **Brand docs now own the R1 rules:** monument type role (`DIRECTION.md` §3), R1 de-boxing (§5), trail placements (§4), arrival/close values (`SIGNATURE-COMPONENTS.md`, "R1 remaster"). The old tabbed hero (#1) remains the contract for the gallery only.
4. **Browser behaviour tests** (`prototype/tests/remaster-r1.browser.test.mjs`) reuse the Playwright and Chromium pinned by `check.mjs`; no new dependency. `npm test` runs both test files.
5. **Skill bundle (agent's decision, owner asked for the fixes):** portable `library/frames/<ID>.jpg` contact sheets; new taxonomy values (`sector:language-services`, `sector:professional-services`, `source:peer`, `project:bridge`); Bridge references L1–L7 and direction BD1 added; `wow-direction` gained an "inside an existing product repo" section, a brand-docs-first step 7, a review method and a three-item closing checklist; `capture.mjs` accepts `CHROMIUM_PATH`.

## 4. Evidence

- Red: commit `0b0f667`. Tests 3, 9, 10 and 11 failed for the intended reasons (test 9 named `r1-close-title` on Home at 1440).
- Green: 10/10. `check.mjs index traduccion-certificada`: 0 axe, overflow, console errors or small targets at all three widths. Axe on the live slider with motion allowed (1440, 390): 0 violations.
- C3: 5 mutations, 5 killed. One first survived (label collapse covered only through a button) and test 10 was hardened to use the keyboard first.
- Library: `node build-index.mjs` prints `SELF-CHECK PASS: 88 entries`.

## 5. Files of the session

- Agent: `docs/specs/brg-68.md`, `prototype/tests/*`, `prototype/package.json`, `prototype/src/{styles/remaster-r1.css,styles/sig-documento.css,assets/js/sig-documento.js,components/sig-before-after.html,pages/traduccion-certificada.html}`, `brand/{DIRECTION.md,SIGNATURE-COMPONENTS.md}`, `audit/remaster-r1/verification.md`, this handoff.
- Outside the repo: `~/Projects/BridgeV2/agent-agnostic-skills/{library/*,wow-direction/{SKILL.md,lessons.md,capture.mjs,worker-prompts.md},concept-redesign/SKILL.md}`. That folder is not under git.

## 6. Operational traps

1. **Downscaled captures hide faults.** The escaped trail was visible in every after capture, but nobody saw it at thumbnail size. Cut full pages into 1440×1800 crops and read them at 50 %.
2. **`check.mjs` runs with reduced motion only**, so the live slider (and any motion-only UI) is never axe-checked by it. Browser test 10 and a one-off axe run with `reducedMotion: 'no-preference'` cover it.
3. **`node --test tests/`** (a directory) fails on Node 24 here; pass the files (`tests/*.test.mjs`).
4. **The arrival plays once per browser** (`localStorage['bridge-remaster-arrival-seen']`). To see it again, use "Repetir recorrido" or clear site data.

Still in force: HANDOFF_v5 §6 and earlier traps.

## 7. Detected drift

- Resolved: the brand docs vs. R1 code drift (see §3.3).
- Open, not drift: the middle chapters of both pages (credentials, guides, why-us, document list) changed little. A second remaster round would need a new synthesis gate.

## 8. Ordered next steps

1. Owner reviews the branch locally (instructions in the PR comment) and merges PR #69 into `develop`.
2. Decide whether a round 2 should reach the middle chapters; if so, run `wow-direction` again from the synthesis step.
3. Continue P2 / BRG-43 hosting work per `docs/backlog/sprints/phase-02.md`.
