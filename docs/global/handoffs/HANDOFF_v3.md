# Handoff v3 — Bridge Traducciones (website)

**Date:** 2026-10-16 · **Phase:** P1 Skeleton (just started) · **Layer:** site
**Session focus:** session close: owner approvals recorded, board loaded, ADR 3.2/3.5 decided, P1 opened. **Start the next session here.**

> Continues [`HANDOFF_v2.md`](HANDOFF_v2.md), which has the full session record (kit fill, P0, backlog) and its traps. PRs #1–#3 are merged into `develop`. This close-out is on `docs/session-close` (commit block handed over).

## 1. Executive state

- **P0 closed.** The owner approved the brand book [Bridge Puente](https://claude.ai/artifact/JCunauKZ4Binpf7tXxQmuo), the contracts, the timings and the register.
- **The backlog and roadmap are official, and the board is loaded:** 54 issues, `BRG-4`…`BRG-57`. 47 sub-issue links were verified, and brg-47 (P0) is Done. Local ID ↔ key: `docs/backlog/key-map.md` (HU-n = `BRG-(n+11)`; brg-31 = `BRG-5`; other tasks brg-n = `BRG-(n+10)`).
- **ADR 3.2 and 3.5 are DECIDED:** store UTC and display `America/Guayaquil`; Laravel's auto-increment `bigint` ids.
- **P1 is open.** Spec `docs/specs/brg-31.md` (`BRG-5`, the scaffold) is **approved**. `CLAUDE.md` §5 lifts the "no Laravel code" veto for brg-31/32/33 only.
- **No application code exists yet.** `site/` is created by brg-31.

## 2. GitHub Issues

The owner ran `initial.sh` (sample, then rest) and closed `BRG-57`. Still to do on the board, **owner:** close `BRG-44` (brg-34, decided today), e.g. `gh issue close 44 --comment "Decided 2026-10-16: ADR D3.2, D3.5"`.

## 3. Decisions of the session close

1. **Backlog and roadmap approved** (owner, 2026-10-16), including the staging deploy in P1.
2. **brg-33 doesn't block anything** (owner): the Hostinger checks are in progress, so phases demo locally until the deploy works. Recorded in the roadmap, `phase-01.md` and `CLAUDE.md` §5.
3. **ADR D3.2:** store UTC, display `America/Guayaquil`. ⚠️ The owner wrote "UTC storage should be America/Guayaquil". This was recorded as approving the proposal (store UTC, display Guayaquil). If they meant *storing* local time, D3.2 must be extended **before P2's migrations**. Ask at the start of the next session.
4. **ADR D3.5:** Laravel's default auto-increment `bigint` `id`; foreign keys with `foreignId()`.
5. **brg-31 spec approved** (C1); brand book approved (P0 closed).

## 4. Evidence

- `gh issue list`: 54 issues #4–#57, #57 closed; per-epic sub-issue counts 6/11/11/5/6/5/3 (equal to the backlog).
- `key-map.md`'s range formulas were checked against all 54 rows of `keys.tsv`.
- Prototype and brand-book evidence: HANDOFF_v2 §4 (nothing changed since).

## 5. Files of the session close

By the agent: `CLAUDE.md` (§5 → P1, §6, §7.3 time zone), `docs/adr/decisiones-tecnicas.md` (3.2, 3.5, D2.4 extension, open list), `docs/backlog/{backlog,roadmap,key-map}.md`, `docs/backlog/sprints/phase-00.md` (closed), `phase-01.md` (in progress), `docs/backlog/anexo-github/imports/README.md`, `docs/specs/brg-31.md` (approved), this handoff. By the owner's run: `docs/backlog/anexo-github/imports/keys.tsv`.

## 6. Operational traps

1. **hPanel's "import from GitHub" isn't the deploy path.** The owner was having trouble with it. ADR D9.1 deploys from GitHub Actions over SSH (build in CI, upload a release, swap a symlink), and hPanel's Git integration was rejected because it only pulls code. What brg-33 needs from hPanel is **SSH access, the PHP path, the cron settings, a staging subdomain and a deploy key**, not the Git import.
2. **The owner may be on `develop` when work starts.** Check `git branch --show-current` before the first write, every time (git rules §4).

Still in force: HANDOFF_v2 §6 (GateGuard cost, shared issue/PR numbering, brand-book index rules, stale prototype artifact) and HANDOFF_v1 traps 2–7, 9–11.

## 7. Drift detected

None open. (v2's two items are resolved: the staging decision was approved, and `CLAUDE.md` §5 is updated.)

## 8. Next steps (in dependency order)

1. **Ask the owner** to confirm the reading of D3.2 (§3.3 above).
2. **Owner:** create the branch `git switch develop && git pull && git switch -c feature/BRG-5-scaffold`.
3. **Agent, brg-31 (`BRG-5`):** read `docs/specs/brg-31.md`. Write the 7 Pest tests and show them red (C2), then scaffold `site/` per the spec. Check the Filament 5 install steps on context7, not from memory. Then run the quality chain and C3 (break each test), update ADR D2.1 with the installed versions, and hand over the commit block.
4. **Then brg-32 (`BRG-42`):** the CI workflow against MySQL.
5. **brg-33 (`BRG-43`)** only once the owner has the Hostinger SSH details; otherwise carry it forward and start P2.
6. Optional: republish the prototype artifact (it predates the P0 polish); delete the 36 superseded brand-book uploads (each delete needs the owner's confirmation).
