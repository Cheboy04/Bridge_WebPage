# Phase 2 — Data (Bridge Traducciones website)

**Status:** in progress since 2026-10-19 (P1 closed with brg-33 carried forward, [`phase-01.md`](phase-01.md) *Carry-over*).
**Owns:** the plan, tickets and close criteria of P2. **Referenced by:** `CLAUDE.md` §5, `docs/backlog/roadmap.md`.

## Goal

Every CMS entity exists as an approved ERD slice, a migration, a model with explicit `$fillable` and translatable attributes (D3.6), and a factory with invented data. `php artisan migrate:fresh --seed` builds a browsable dataset, so P3 (Admin) builds its resources against real tables. Preconditions met: ADR D3.2 (UTC storage) and D3.5 (auto-increment `bigint`), both decided in P1.

## Capacity and commitment

No story points (ADR 1.5 OPEN). P2 has three Tasks and no Stories.

## Phase records

| Key | Local ID | Type | Title | Delivery dependencies |
| --- | --- | --- | --- | --- |
| `BRG-45` | `brg-35` | Task | ERD slice, migrations and models: content entities (Service, Language + pivot, Faq, Post, Client, Testimonial, Page, User role) | — |
| `BRG-46` | `brg-36` | Task | ERD slice, migrations and models: Settings and Lead (+ attachments), `LeadType` / `LeadStatus` enums | — |
| `BRG-47` | `brg-37` | Task | Factories and seeders (invented data; real public language list) | brg-35, brg-36 |
| `BRG-43` | `brg-33` | Task | Release deploy to staging (carried from P1) | owner's hosting checks |
| `BRG-68` | — | Task | Evidence-led visual remaster: gated Home and Certified Translation reference-prototype slice | approved R1 synthesis and story |

## Execution sequence

1. **brg-35**: ERD slice in `docs/erd/` (from `PLANTILLA-ERD.md`), owner approves it, then spec, red tests, migrations and models. Its factories are written with it, because the model tests need them. ERD [`modelo-contenido.md`](../../erd/modelo-contenido.md) and spec [`brg-35.md`](../../specs/brg-35.md) approved 2026-10-19; merged 2026-10-19 (PR #64, C3 15/15).
2. **brg-36**: same cycle. ERD [`modelo-leads-settings.md`](../../erd/modelo-leads-settings.md) and spec [`brg-36.md`](../../specs/brg-36.md) approved by the agent (mode C) 2026-10-19; merged 2026-10-19 (PR #65, C3 17/17).
3. **brg-37**: the seeders and anything brg-35/36 didn't already need: the public language list and `DatabaseSeeder` wiring. Spec [`brg-37.md`](../../specs/brg-37.md); merged 2026-10-19 (PR #67, C3 7/7).
4. **brg-33** whenever the hosting checks land; it doesn't gate P2.
5. **BRG-68** runs as an owner-approved design track without changing P2's data goal: evidence and story gates, committed prototype spec, red tests, then only Home and Certified Translation. It adds no Laravel public UI and does not redesign the other prototype pages.

## Ready conditions

- brg-35, brg-36: Ready. No OPEN ADR point blocks them. ADR 7 (retention period) only affects P5's cleanup job; brg-36 stores the attachment rows, not the policy.
- brg-37: Ready once brg-35 and brg-36 are merged.
- brg-33: unchanged from P1 (ADR 9.1 checks, owner).

## Tasks and cross-cutting line

Each Task follows its checklist in the issue body. The cross-cutting line is the CI chain on MySQL (brg-32): every migration is proven against MySQL 8.4 in CI, never only locally.

## Control gates

### Start

- ~~`CLAUDE.md` §5 updated with P2's scope.~~ Done 2026-10-19.
- P1's carry-over is recorded ([`phase-01.md`](phase-01.md)).
- BRG-68's narrow prototype exception was approved by the owner and recorded in `CLAUDE.md` §5 on 2026-10-19.

### Close

- Every ERD slice is approved and matches its migrations.
- Migrations run green in CI on MySQL. "On staging" (the issues' AC) is checked locally until brg-33 lands, then re-checked on staging (P1 carry-over).
- `php artisan migrate:fresh --seed` builds the dataset with no real client data (D2.2).

## Phase Definition of Done

The three Tasks are Done, with no drift between the ERD slices, the migrations and `docs/nomenclatura.md`.

## Active risks

| Risk | Signal | Response |
| --- | --- | --- |
| Translatable JSON columns behave differently on MySQL vs other drivers | A query on a JSON column passes locally but fails in CI | CI on MySQL is the proof (lessons); never test JSON behaviour elsewhere |
| The content model in `docs/ARCHITECTURE.md` is a draft | A slice needs a field the draft doesn't have, or the prototype shows one it lacks | The ERD slice decides; the draft is updated in the same PR |
| brg-33 still blocked at P2 close | Hosting checks not done | P2 closes locally, as P1 did; brg-33 must still land before P6 |

## GitHub Issues sync executed

- **Pending (owner):** move `BRG-43` to the `P2 Data` milestone.
