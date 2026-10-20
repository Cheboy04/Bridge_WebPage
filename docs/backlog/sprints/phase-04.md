# Phase 4 — Public site (Bridge Traducciones website)

**Status:** opened 2026-10-19 after P3 ([`phase-03.md`](phase-03.md) *Carry-over*). Page stories wait for the start gate below (owner's design approval).
**Owns:** the plan, tickets and close criteria of P4. **Referenced by:** `CLAUDE.md` §5, `docs/backlog/roadmap.md`.

## Goal

Every public page renders from Blade at parity with the reference prototype (`prototype/`), fed only by the P3 model scopes and `Settings`, with 0 axe violations and no horizontal overflow at 390 and 1440 (D11.2). Preconditions met: every content entity and its admin (P3), the public scopes tested in P3, and the `@theme` tokens (brg-31).

## Capacity and commitment

No story points (ADR 1.5 OPEN). P4 has fourteen Stories and two Tasks, plus brg-33 carried.

## Phase records

| Key | Local ID | Type | Title | Delivery dependencies |
| --- | --- | --- | --- | --- |
| `BRG-49` | `brg-39` | Task | Browser check harness for the Laravel site (decides ADR 11.3) | — |
| `BRG-12` | `brg-01` | Story | HU-01 Branded layout: header, footer, WhatsApp button, Documento/Cabina modes | brg-39, design gate |
| `BRG-21`…`BRG-28` | `brg-10`…`brg-17` | Story | HU-10–HU-17 Home, both hubs and service pages, about, blog, FAQ, contact, privacy | brg-01 |
| `BRG-29`…`BRG-33` | `brg-18`…`brg-22` | Story | HU-18–HU-22 Signature components (hero stage, LangChecker, event builder, before/after, living trail) | the page that hosts each |
| `BRG-48` | `brg-38` | Task | Error pages 404, 419, 429, 500 (D3.1) | brg-01 |
| `BRG-43` | `brg-33` | Task | Release deploy to staging (carried from P1–P3) | owner's hosting checks |

## Execution sequence

1. **brg-39** first: the harness every page story's parity check runs on. It decides ADR 11.3 (port `prototype/check.mjs` or Pest browser testing). It needs no design approval.
2. **brg-01** once the start gate is met: the layout every page extends.
3. **HU-10–HU-17** with their signature story alongside (HU-18 with Home, HU-21 with Certified Translation, HU-19 and HU-20 with their hubs, HU-22 wherever the trail appears). One signature moment per page.
4. **brg-38** after brg-01.
5. **brg-33** whenever the hosting checks land; it doesn't gate P4 but must land before P6.

## Ready conditions

- brg-39: Ready now.
- brg-01 and every page story: Ready once the owner approves the prototype design they port (start gate). The owner said page work begins "once the design is fully approved".
- HU-14 (blog) decides ADR 3.4 (pagination) in its spec.
- HU-19 and HU-20 link to the quote form with prefilled parameters; the form itself is P5 (HU-23).

## Tasks and cross-cutting line

Each Story follows its checklist in the issue body. Cross-cutting rules for every page:

- Public data only through the P3 scopes and `Settings` (phase-03 *Carry-over*); no new `where` in a controller.
- Every rich-text body is sanitised on render (ERD I9); `{!! !!}` only on sanitised output, with a comment (`CLAUDE.md` §7.4).
- UI strings through `__()`; tokens from `@theme` only; computed contrast (`brand/DIRECTION.md` §2).
- Quality chain step 5 (axe, overflow at 390 and 1440) on every page, through brg-39's harness.

## Control gates

### Start

- `CLAUDE.md` §5 updated with P4's scope (2026-10-19, with this document).
- P3's carry-over is recorded ([`phase-03.md`](phase-03.md)).
- **Pending (owner):** approve the prototype design the page stories port (the remastered Home and Certified Translation, and the pages not yet remastered).

### Close

- Every page renders locally at parity with the prototype, and on staging once brg-33 lands.
- 0 axe violations and no horizontal overflow at 390 and 1440 on every page (D11.2).
- ADR 11.3 and 3.4 are DECIDED.
- CI green on MySQL for every P4 PR.

## Phase Definition of Done

The fourteen Stories and two Tasks are Done per ADR block 1, with no drift between the Blade output, the prototype and the brand docs.

## Active risks

| Risk | Signal | Response |
| --- | --- | --- |
| The design keeps moving while pages are ported | A merged page differs from a newer prototype | Start gate: the owner approves the design first; a later change goes through the prototype and a new gate, then the page |
| Placeholder content reads as final | A page ships "[por confirmar]" text | Placeholders come from `Settings` and seeds (register); real content goes in through the admin |
| Signature JS diverges from the prototype | Behaviour or reduced-motion fallback differs | Port the prototype's vanilla JS; the brg-39 harness checks it |

## GitHub Issues sync executed

- **Pending (owner):** move `BRG-43` to the `P4 Public site` milestone.
