# Development roadmap

**Status:** baseline <!-- draft | official --> approved on YYYY-MM-DD.

## Purpose and authority

This document orders the development of Bridge Traducciones (website) in 8 phases with no fixed length (phase-based), grouped into releases, and governs their sequence in GitHub Issues. It does not replace the ADR, `CLAUDE.md` or the methodology. In a contradiction, those documents prevail.

The scope comes from <!-- RELLENAR: source document (requirements, thesis, contract) -->: RF-01..RF-NN, RNF-01..RNF-NN and NN stories. Stories and their acceptance criteria live in GitHub Issues; this roadmap only assigns them to a target window.

## Planning assumptions

- Start: 2026-10-16. Deadline: <!-- YYYY-MM-DD -->. Time zone: <!-- … -->.
- 8 phases with no fixed length (phase-based): P0 Lock, P1 Skeleton, P2 Data, P3 Admin, P4 Public site, P5 Leads, P6 Hardening, P7 Ship. If a phase meets its goal early, continue with the next one without waiting for the calendar (continuous flow).
- Fibonacci estimation (1, 2, 3, 5) with no direct translation to hours. Backlog: NN HU and NN SP.
- Capacity: <!-- people × hours per phase -->. Specs, tests, review, integration, fixes, documentation and human infrastructure consume that same capacity. Agent hours are not counted and no multiplier is assumed.
- SDD/TDD cycle in mode B (methodology §2).
- Each phase closes with a demonstrable increment in staging (merge to `develop`). Only the last release is deployed to production.

## Progress milestones

| Milestone | Week | Deadline | Condition |
| --------- | ---: | -------- | --------- |
|           |      |          |           |

## Releases

| Release | Phases | Weeks | Expected outcome | Environment |
| ------- | ------ | ----- | ---------------- | ----------- |
| R1 —    |        |       |                  | Staging     |

A release can ship only when all its stories meet the Definition of Done.

## Scope and capacity distribution

| Phase     | Window | Main HU | HU SP | Cross-cutting reserve | Target capacity |
| --------- | ------ | ------- | ----: | --------------------: | --------------: |
| P0        |        |         |       |                       |                 |
| **Total** |        |         |       |                       |                 |

<!-- RELLENAR: if there are cross-cutting quality stories (integral tests, RNF, acceptance), reserve equivalent SP in each phase and close them in the last one. That way QA is not concentrated at the end. SP are counted only once. -->

## Target sequence per phase

| Phase | Stories and cross-cutting work | Demonstrable at close | Main risk or dependency |
| ----- | ------------------------------ | --------------------- | ----------------------- |
|       |                                |                       |                         |

### Requirements coverage

| Requirement | Stories | Phase(s) |
| ----------- | ------- | -------- |
|             |         |          |

## Continuous flow and capacity control

- The window of each phase is a maximum. If all its stories meet Done early, the next one starts with Ready stories.
- A story blocked by an OPEN ADR point or by essential infrastructure is never pulled forward.
- At each mid-phase and end-of-phase checkpoint, real velocity is compared with the target. Two consecutive checkpoints below it force a decision between increasing capacity, reducing external waits or renegotiating the date. <!-- RELLENAR: is scope an authorized lever? -->
- Every carry-over is recorded with the reassigned capacity and its effect on the gates. It is not absorbed invisibly.

## Scope rules

- What is not cut to meet the date: <!-- security, tests, acceptance… -->
- Out of scope: <!-- explicit list -->
- Prototype elements with no RF behind them: they do not enter the roadmap until a formal decision.

## Parallel track: ADR, infrastructure and documentation

| Period | Deliverable |
| ------ | ----------- |
|        |             |

## Gates and external dependencies

- **PN:** <!-- what must be decided or configured before which story -->
- Hostinger (hPanel, SSH, DNS, mail, cron), GitHub (repo settings, Actions secrets, deploy key), Google GA4 are configured by the human team. The agent documents the dependency and stops.

## Discrepancies to reconcile

| Discrepancy | Where | Action |
| ----------- | ----- | ------ |
|             |       |        |

## Governance in GitHub Issues

GitHub Issues is the operational source of truth; the current key map is in [`key-map.md`](key-map.md). A replan is applied by moving the existing tickets, never by re-importing a batch.

## Next step

1. …
