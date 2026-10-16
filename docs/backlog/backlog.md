# Official backlog

**Status:** official baseline of scope and traceability since YYYY-MM-DD. An official ticket is not thereby Ready and does not commit to a delivery date.

## Authority and use

This backlog breaks down [the roadmap](roadmap.md) and follows the [common format](backlog-format.md). The ADR, `CLAUDE.md` and the [methodology](../global/metodologia-sdd-tdd.md) prevail. The scope comes from <!-- source document -->.

Before the backlog is loaded into GitHub Issues, this catalog is its design. After that, GitHub Issues is the source of truth and only the design is kept here; the real keys are in [`key-map.md`](key-map.md).

## Epic catalog

| Local ID | Key | Epic | Outcome and limits | Content | Window |
| -------- | --- | ---- | ------------------ | ------- | ------ |
| `brg-epic-infra` | — | Infrastructure and environments | Repository, CI/CD, data model, environments and external providers configured by the team. | HU-01, … | P0-P7 |
| `brg-epic-quality` | — | Quality and acceptance | Integral tests, RNF verification and acceptance with the client. | … | P1-P7 |
|  |  |  |  |  |  |

<!-- RELLENAR: one epic per functional module (bounded outcome and clear limits), plus the cross-cutting ones for infrastructure, quality and documentation. Every infrastructure Task hangs from the infrastructure epic, even if it blocks another epic. -->

## Stories

| Local ID | HU | Epic | Title | SP | Release | Target phase | Layer | Risk |
| -------- | -- | ---- | ----- | -: | ------- | ------------ | ----- | ---- |
| `brg-01` | HU-01 | | | | | | | |

## Tasks

| Local ID | Epic | Title | Blocks | Window |
| -------- | ---- | ----- | ------ | ------ |
|          |      |       |        |        |

## Coverage of the approved scope

| Requirement | Main epic | Complementary coverage |
| ----------- | --------- | ---------------------- |
| RF-01 …     |           |                        |
| RNF-01 …    |           |                        |

Each RF and RNF has at least one main epic. Items with no RF behind them stay pending a decision (see roadmap) and have no ticket.
