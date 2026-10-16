# Handoff v2 — Bridge Traducciones (website)

**Date:** 2026-10-16 · **Phase:** P0 Lock (deliverables done, awaiting the owner's review) → kit Phases 4–6 · **Layer:** site
**Session focus:** sdd-kit fill (Phases 0–6), Phase 0 Lock (brand book, contracts, timings, register, polish), backlog and P1 plan.

> Continues [`HANDOFF_v1.md`](HANDOFF_v1.md). PR #1 (`docs/kit-fill`) and PR #2 (`docs/p0-lock`) are merged into `develop`. This work is on `docs/backlog`, uncommitted, with the commit block handed over.

## 1. Executive state

- **The sdd-kit is filled.** Every doc is in English. Mode B with human-run git, GitHub Issues with prefix `BRG`, a public repo, `main`/`develop` branches, phase-based delivery. The ADR has blocks 1–12 filled; its open list (14 items) is at the end.
- **P0 deliverables are done:**
  - Brand book [Bridge Puente](https://claude.ai/artifact/JCunauKZ4Binpf7tXxQmuo) (v4).
  - `brand/COMPONENT-CONTRACTS.md`, the "Shipped behaviour" section in `brand/SIGNATURE-COMPONENTS.md`, and `docs/placeholder-register.md` (29 items).
  - The polish: stronger logo trail, capped footer wordmark, no wrap in the planner.
  - P0 closes when the owner reviews the brand book (`docs/backlog/sprints/phase-00.md`).
- **The backlog is designed, not loaded:** 7 epics, 30 stories, 17 tasks, 17 RF and 9 RNF (derived). The load script is `docs/backlog/anexo-github/imports/initial.sh` (sample, then rest).
- **P1 is planned** (`phase-01.md`), and the first spec `docs/specs/brg-31.md` (the scaffold) is a draft awaiting approval (C1).

## 2. GitHub Issues

Nothing written. The batch is ready; the owner runs `bash initial.sh sample`, checks it, then `bash initial.sh rest`, and copies `keys.tsv` into `key-map.md`. Then `brg-47` (P0) is moved to Done by hand with PR #2 as evidence.

## 3. Decisions of the session

1. **sdd-kit values** (interview, 2026-10-16): the marker table recorded in ADR blocks 1–2 (D1.1, D1.2, D2.2–D2.4).
2. **Monolith, headless rejected for now** (D2.3): the owner asked about using Laravel as a headless CMS. The rejection gives reasons (hosting, content edits needing rebuilds, two deploys) and a reopen condition.
3. **Logo trail strengthened** (owner's choice): radii +0.5u (3–5u, like the app icon), re-spaced on the same curve; `LOGO.md` §1. The app icon and favicon are unchanged.
4. **Footer wordmark capped** at 52rem (owner's choice).
5. **Language checker rule** as shipped: a pair is supported only when one side is Spanish. The spec was corrected to match the code.
6. **Requirements derived** RF-01..RF-17, RNF-01..RNF-09 (`backlog.md`), pending the owner's approval.
7. **Proposed:** staging deploy moves from P7 to P1 (brg-33), so every phase demos on staging. This differs from HANDOFF_v1 decision 15; it's in the roadmap as an assumption for the owner to approve or revert.
8. **P0 work gets a ticket** (`brg-47`), per the format's "work done before the board" rule.

## 4. Evidence

- **Prototype** (`node check.mjs` on all 8 pages, after the polish): 16/16 runs with 0 axe violations, scrollWidth equal to the viewport, 0 console errors. Known noise: the 24px checkbox small-target warnings.
- **Planner labels:** one line (44px) at 390, 768, 1024, 1280 and 1440. Footer wordmark 832px from 1024 up.
- **Logo:** 46 files updated; every changed SVG passes xmllint; compared before and after at 400, 180 and 24px.
- **Brand book:** 21 component previews render with 0 console errors and 0 component-level axe violations in both themes (worker report). I looked at 3 renders and the worker at 7 of the 21.
- **Kit completion criteria:** markers, variant blocks and links checked (§1 of this session's final report).
- **Not done:** no application code exists, so no Pest suite and no C3.

## 5. Files of the session

All by agents. On `develop` via PR #1 and #2: the kit docs, the ADR, `CLAUDE.md`, `docs/nomenclatura.md`, `anexo-github/`, the P0 docs, logo and prototype polish. On `docs/backlog` (this hand-over): `docs/backlog/{backlog,roadmap,backlog-format,key-map}.md`, `docs/backlog/sprints/phase-01.md`, `docs/backlog/anexo-github/README.md` and `imports/`, `docs/specs/brg-31.md`, `docs/global/lecciones-transversales.md` (pruned), this handoff.

Outside the repo: the brand book's files and 106 uploads (70 live, 36 superseded by the logo change). The build tree is in the session scratchpad and is not needed again, because the artifact holds every file.

## 6. Operational traps

1. **GateGuard costs a full resend per first-touched file.** *Symptom:* the first Write or Edit of every file is refused until facts are stated, and a refused Write must be resent whole. *What to do:* state the facts first, or trip the gate with a tiny Edit before a big Write. For many generated files, write them with one script through Bash (the Bash gate passes once).
2. **GitHub numbers issues and PRs together.** PRs #1 and #2 exist, so the first issue will be #3 and `BRG-n` never equals the local number. Only `key-map.md` maps them.
3. **The Design System artifact's index goes last, re-read right before.** Changing a logo means re-uploading it (new blob id), updating the record in `assetGroups` and any preview that references the id. Old uploads stay until deleted one by one; each delete needs the owner's confirmation.
4. **Brand book previews use the prototype's compiled CSS** (`components/bundle.css`, with `:root` removed from the Documento selector so the theme drives the mode variables). A colour edited on the page reaches the components; spacing and radius edits don't reach Tailwind's own utility values.
5. **The owner may run only part of a branch command.** *Symptom:* `develop` checked out, no new branch. *What to do:* check `git branch --show-current` before the first write, every time.
6. **axe-core isn't in `prototype/node_modules`.** `check.mjs` finds it on its own, but a worker looking for `axe.min.js` loaded a copy from another project. Point workers at the path `check.mjs` uses.
7. **Old artifacts are stale:** the prototype v2 artifact still shows the old trail and the polish items unfixed. Republish on request (`prototype/publish/build-publish.sh`, HANDOFF_v1 trap 9).

Still in force from v1: traps 2 (zsh not fish), 3 (Playwright cached Chromium), 4 (old site bot challenge), 5 (Google Fonts UA), 6 (worker file ownership), 7 (stale worker screenshots), 9 (artifact publish), 10 (`cqw` clamping), 11 (compute contrast).

## 7. Drift detected

| Drift | Owner | Fix |
| --- | --- | --- |
| HANDOFF_v1 decision 15 has staging in P7; the roadmap proposes P1 | Roadmap (once approved) | Owner approves or reverts |
| `CLAUDE.md` §5 still holds P0's vetoes | `CLAUDE.md` | Update to P1's scope when P0 closes (phase-01 "Start" gate) |

## 8. Next steps (in dependency order)

1. **Owner:** run the commit block for `docs/backlog`; review and approve the backlog, the roadmap (and the staging-in-P1 proposal) and spec `brg-31`.
2. **Owner:** review the brand book to close P0 (`phase-00.md`); then the agent updates `CLAUDE.md` §5 to P1.
3. **Owner:** load the board: `cd docs/backlog/anexo-github/imports && bash initial.sh sample`, check, then `bash initial.sh rest`. Copy `keys.tsv` into `key-map.md`; move brg-47 to Done.
4. **Owner (whenever possible, blocks brg-33):** the Hostinger checks listed in `phase-01.md` "Ready conditions".
5. **Owner:** decide brg-34 (time zone, PK type) before P2.
6. **Agent:** brg-31 on `feature/BRG-<n>-scaffold`: red tests first (spec §4), then the scaffold.
7. Optional: republish the prototype artifact; delete the 36 superseded brand-book uploads.

## 9. How to resume the environment

Unchanged from v1 §9, plus: the brand book is edited by re-reading its files with the Artifact tool (`read`, `path`) and publishing to the same URL (type rules: `artifact-type/reference/format.md` on the artifact).
