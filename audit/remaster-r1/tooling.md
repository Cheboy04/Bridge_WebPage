# BRG-68 remaster round 1 — tooling preflight

**Date:** 2026-10-19

**Scope:** current-prototype evidence and direction research only. No prototype source was changed.

## Repository state

- Base: `develop` synchronized to `845be14` after PR #67 merged.
- Working branch: `feature/BRG-68-visual-remaster`.
- Issue: [BRG-68](https://github.com/Cheboy04/Bridge_WebPage/issues/68).
- Static prototype: Tailwind 4.1.11 with the repository's include build; no new package was installed.

## Commands and evidence

| Purpose | Command / instrument | Result |
| --- | --- | --- |
| Build | `cd prototype && npm run build` | Pass; `dist/` rebuilt in 173 ms. |
| Real-scroll capture | `wow-direction/capture.mjs <url> <outdir> --frames 16 --step 650` | Pass for both scoped pages; 21 frames plus source and contact sheet each. |
| Baseline accessibility / layout | `prototype/check.mjs index traduccion-certificada`, run from a temporary directory so historical screenshots were not overwritten | 0 axe violations, no horizontal overflow and 0 console errors at 1440×900 and 390×844 for both pages. |
| Visual review | Contact sheets and full-page captures opened directly | Completed; findings are in `audit.md`. |
| Reference research | Same capture instrument, 12 scroll frames per live reference | Seven usable captures and one blocked capture (`kudo.ai`). |

## Capture compatibility

The installed Playwright JavaScript package requests browser revision 1243, while the machine contains the repository-pinned revision 1234. The capture ran with a temporary compatibility path under `/tmp/bridge-pw`; `prototype/check.mjs` already pins the same revision 1234 explicitly. This is an environment workaround, not a repository dependency or product change.

Local socket binding also requires managed-sandbox approval. Browser evidence therefore uses the approved local-only server; it does not deploy or publish the concept.

## Available and missing capability

- Available: Chromium captures, axe-core, overflow and console checks, full-page screenshots, source snapshots, responsive 390 px evidence, reduced-motion browser contexts.
- Available but not needed before the gate: the project build and existing vanilla/CSS signature-component stack.
- Missing: the shared library's referenced frame files. Its prose index was queried, but no move from it is treated as proof without a frame.
- Blocked reference: KUDO's consent modal remained over every scroll frame, so it is excluded from visual synthesis.
- Not run at this stage: Lighthouse/performance. The project assigns that instrument to P6, and no implementation exists to compare yet.
