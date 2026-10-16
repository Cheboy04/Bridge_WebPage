# Phase 1 — Skeleton (Bridge Traducciones website)

**Status:** planned 2026-10-16; starts when the owner approves the backlog and P0 closes.
**Owns:** the plan, tickets and close criteria of P1. **Referenced by:** `CLAUDE.md` §5, `docs/backlog/roadmap.md`.

## Goal

Create the `site/` Laravel application with the full quality chain and CI, deployed to staging by the release pipeline (ADR D9.1), so that every later phase is built, tested and demonstrated the same way.

## Capacity and commitment

No story points (ADR 1.5 OPEN). P1 has four Tasks and no Stories.

## Phase records

| Key | Local ID | Type | Title | Delivery dependencies |
| --- | --- | --- | --- | --- |
| pending | `brg-31` | Task | Scaffold Laravel 12 + Filament 5 in `site/` with the quality chain and brand tokens | — |
| pending | `brg-32` | Task | CI quality pipeline on GitHub Actions against MySQL | brg-31 |
| pending | `brg-33` | Task | Release deploy to staging | brg-32; owner's hosting checks |
| pending | `brg-34` | Task | Decide time zone and primary key type | owner's decision |

Keys are filled from `key-map.md` after the board is loaded.

## Execution sequence

1. **brg-31** (spec [`docs/specs/brg-31.md`](../../specs/brg-31.md)): scaffold, packages, tokens, fonts, smoke tests. Branch `feature/BRG-<n>-scaffold`.
2. **brg-34** in parallel: two short decisions the owner takes; they block P2 only.
3. **brg-32**: the CI workflow, once `site/` exists.
4. **brg-33**: the deploy workflow, once CI is green **and** the owner has done the hosting checks.

## Ready conditions

- brg-31: Ready once the backlog is approved (no OPEN ADR point blocks it; D2.1, D2.3 and D3.7 are DECIDED).
- brg-33: needs, from the owner: SSH enabled; the output of `php -v; composer -V; which php`; plan limits from hPanel → Details; the minimum cron interval; a staging subdomain; a deploy key; the Actions secrets (host, user, key, paths). Until then it is blocked (`external_blocker`).
- brg-34: the owner chooses; the proposal is in ADR D3.2 (UTC storage, `America/Guayaquil` display) and 3.5 (Laravel's auto-increment `bigint`).

## Tasks and cross-cutting line

Each Task follows its checklist in the issue body. The cross-cutting quality line in P1 is the chain itself: from brg-32 on, every PR runs it.

## Control gates

### Start

- `CLAUDE.md` §5 updated with P1's scope (lifts the "no Laravel code" veto **only** for brg-31–brg-33).
- The board is loaded and brg-31 has its real key.

### Close

- A PR to `develop` runs the chain green; the merge deploys to staging.
- Staging serves the token-styled placeholder and `/admin/login`.
- ADR D2.1 records the installed versions; ADR 3.2 and 3.5 are DECIDED.

## Phase Definition of Done

The four Tasks are Done (or brg-33 is explicitly carried to the next phase because the hosting checks are pending, recorded here), with no drift between the ADR and `site/composer.lock`.

## Active risks

| Risk | Signal | Response |
| --- | --- | --- |
| Hosting checks take long | brg-33 still blocked when brg-32 is Done | Carry brg-33 forward and continue with P2 locally; the roadmap's staging assumption is revisited |
| Shared-hosting limits (PHP path, cron interval, inodes) differ from the research | The checks report different values | Update ADR D9.1 first, then the workflow |
| Filament 5 / Laravel 12 / Tailwind 4 version mismatch at install | Composer or npm conflicts | Record the working set in D2.1; no unpinned upgrades |

## GitHub Issues sync executed

- None yet: the board is loaded after the owner approves the backlog.
