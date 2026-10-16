# Development roadmap

**Status:** official baseline, approved by the owner on 2026-10-16.

## Purpose and authority

This document orders the development of Bridge Traducciones (website) in 8 phases with no fixed length (ADR D1.1), grouped into two releases, and governs their sequence in GitHub Issues. It does not replace the ADR, `CLAUDE.md` or the methodology. In a contradiction, those documents prevail.

The scope comes from the requirements derived in [`backlog.md`](backlog.md) on 2026-10-16: RF-01..RF-17, RNF-01..RNF-09, 30 stories and 17 tasks. Stories and their acceptance criteria live in GitHub Issues; this roadmap only assigns them to a target window.

## Planning assumptions

- Start: 2026-10-16. Deadline: none set. Dates are recorded as phases close.
- 8 phases with no fixed length: P0 Lock, P1 Skeleton, P2 Data, P3 Admin, P4 Public site, P5 Leads, P6 Hardening, P7 Ship. If a phase meets its goal early, the next one starts at once (continuous flow).
- No story points (ADR 1.5 OPEN). Progress is measured as stories Done per phase.
- Capacity: OPEN (the owner's hours per week aren't recorded). Specs, tests, review, integration, fixes, documentation and the owner's infrastructure work all draw on it. Agent hours are not counted.
- SDD/TDD cycle in mode B (methodology §2). The owner approves every spec and reads every diff.
- **Staging from P1 (proposed change):** the release deploy (brg-33) moves from P7 to P1, so every phase closes with a demo on staging and the shared-hosting constraints (D9.1) surface early. HANDOFF_v1 decision 15 had "Ship to staging" in P7. **Approved 2026-10-16**, with one condition from the owner: brg-33 doesn't block anything. Until the Hostinger checks are done, phases demo locally and brg-33 stays open.
- Only R2 deploys to production.

## Releases

| Release | Phases | Expected outcome | Environment |
| --- | --- | --- | --- |
| R1 — Complete site on staging | P1–P6 | Every page, signature component, form and admin tool working at parity with the prototype, audited for a11y, performance and security | Staging |
| R2 — Launch | P7 | Production on the canonical domain, 301s from the old site, backups and rollback | Production |

A release can ship only when all its stories meet the Definition of Done (ADR block 1).

## Target sequence per phase

| Phase | Stories and cross-cutting work | Demonstrable at close | Main risk or dependency |
| --- | --- | --- | --- |
| P0 Lock | Brand book, component contracts, shipped timings, placeholder register, polish | Brand book artifact; repo docs | Stamp OPEN (Seal stays provisional) |
| P1 Skeleton | brg-31 scaffold + tokens, brg-32 CI, brg-33 staging deploy, brg-34 time zone and PK decision | Staging serves a token-styled placeholder page and the `/admin` login; CI green on a PR | Owner's Hostinger checks (ADR summary #3) |
| P2 Data | brg-35, brg-36 ERD slices and migrations, brg-37 seeders | Migrations run on staging; models with translatable fields and factories | ADR 3.2, 3.5 (closed by brg-34) |
| P3 Admin | HU-02 roles, HU-03–HU-09 resources | Editor and admin sign in on staging and manage every entity | — |
| P4 Public site | brg-39 harness first, HU-01 layout, HU-10–HU-17 pages, HU-18–HU-22 signature, brg-38 error pages | Every page on staging at parity with the prototype; 0 axe violations | Bridge content still placeholders (register) |
| P5 Leads | HU-23–HU-25 forms, HU-26 notifications, HU-27 inbox, HU-28 retention | A quote with files reaches the inbox and both emails arrive | Mail provider (ADR #7), retention period (ADR #2), 4.3 validation |
| P6 Hardening | HU-29 SEO, HU-30 consent + GA4, brg-40 a11y/parity audit, brg-41 performance, brg-42 security, brg-43 observability | R1 accepted by the owner on staging | GA4 property (owner) |
| P7 Ship | brg-44 301 map, brg-46 backups and rollback runbook, brg-45 launch | Live on the canonical domain | Canonical domain (ADR #4), DNS lead time |

### Requirements coverage

| Requirement | Stories | Phase(s) |
| --- | --- | --- |
| RF-01 | HU-10–HU-17 | P4 |
| RF-02 – RF-08 | HU-02–HU-09 (+ pages in P4) | P3, P4 |
| RF-09 – RF-13, RF-17 | HU-23–HU-28 | P5 |
| RF-11 | HU-20, HU-25 | P4, P5 |
| RF-14 | HU-01, HU-16 | P4 |
| RF-15 | HU-01, HU-18–HU-22 | P4 |
| RF-16 | HU-29, brg-44 | P6, P7 |
| RNF-01, RNF-03, RNF-09 | every UI story; brg-39, brg-40 | P4–P6 |
| RNF-02 | brg-41 | P6 |
| RNF-04 | HU-17, HU-23–HU-28, HU-30 | P4–P6 |
| RNF-05 | HU-02, HU-27, brg-42 | P3, P5, P6 |
| RNF-06 | brg-35, brg-36, every UI story | P2–P4 |
| RNF-07 | brg-32, brg-33, brg-45 | P1, P7 |
| RNF-08 | HU-01, HU-18–HU-22 | P4 |

Quality is not saved for the end: every UI story's checklist carries its own a11y, overflow and parity check (RNF-01, RNF-03, RNF-09); P6 audits the whole.

## Continuous flow and control

- The window of each phase is a maximum. If all its stories meet Done early, the next one starts with Ready stories.
- A story blocked by an OPEN ADR point or by essential infrastructure is never pulled forward.
- Every carry-over is recorded in the phase doc with its effect on the gates. It is not absorbed invisibly.

## Scope rules

- **Never cut to meet a date:** security, privacy (LOPDP), tests with C3, accessibility, the owner's acceptance.
- **Out of scope** (ADR D3.9): a second locale, a page builder, a media library, a permission package, blog categories, online payment or a price calculator, Turnstile (until spam appears), a headless front end.
- Prototype elements with no RF behind them do not enter the roadmap until a formal decision.

## Parallel track: ADR, infrastructure and documentation

| Period | Deliverable |
| --- | --- |
| Before P2 | ADR 3.2 time zone, 3.5 PK type (brg-34) |
| Before P4 | ADR 11.3 browser tests (brg-39) |
| Before P5 | ADR 4.3 validation approach; mail provider (ADR #7); retention period confirmed by Bridge |
| P6 | ADR 9.3 observability, 11.2 performance instrument |
| Before P7 | ADR 9.4 database rollback; canonical domain |
| Every phase | Placeholder register: chase Bridge's answers |

## Gates and external dependencies

- **P1:** the owner enables SSH, runs `php -v; composer -V; which php`, checks the plan limits and the cron minimum, creates the staging subdomain and the deploy key, and adds the Actions secrets (brg-33).
- **P2:** ADR 3.2 and 3.5 DECIDED.
- **P5:** a working mailer on staging; ADR 4.3 decided; the retention period as config (compatible with any answer).
- **P6:** the GA4 property (owner).
- **P7:** the canonical domain and DNS (owner); production database and cron.
- Hostinger, GitHub settings and GA4 are configured by the owner. The agent documents the dependency and stops.

## Discrepancies to reconcile

| Discrepancy | Where | Action |
| --- | --- | --- |
| ~~Staging deploy in P1 vs P7~~ | HANDOFF_v1 decision 15 vs this roadmap | **Resolved 2026-10-16:** the owner approved P1, non-blocking |

## Governance in GitHub Issues

GitHub Issues is the operational source of truth; the current key map is in [`key-map.md`](key-map.md). A replan is applied by moving the existing tickets (milestones), never by re-running a creation batch.

## Next step

1. ~~The owner approves this roadmap and the backlog.~~ Done 2026-10-16.
2. ~~Load the board.~~ Done 2026-10-16 (`BRG-4`…`BRG-57`).
3. Start P1 with brg-31 / `BRG-5` (spec approved: `docs/specs/brg-31.md`).
