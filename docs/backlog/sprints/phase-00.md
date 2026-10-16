# Phase 0 — Lock (Bridge Traducciones website)

**Status:** deliverables done 2026-10-16; awaiting the owner's review to close. **Branch:** `docs/p0-lock` (no issue numbers: the board is loaded after P0, `CLAUDE.md` §5).
**Owns:** the plan, deliverables and close criteria of P0. **Referenced by:** `CLAUDE.md` §5, ADR D1.1, D3.8.

## Goal

Lock every prototype component in its three layers (ADR D3.8): **design** in the brand book, **behaviour** in `brand/SIGNATURE-COMPONENTS.md`, **code** in `brand/COMPONENT-CONTRACTS.md`. Also gather in one register everything Bridge must supply. After P0, the Laravel build (P1–P5) ports the prototype without inventing anything.

## Capacity and commitment

Phase-based work, no story points (ADR 1.5 OPEN). P0 has no functional stories; its deliverables are documents and one artifact.

## Deliverables

| # | Deliverable | Owner file | Done when | Status |
| --- | --- | --- | --- | --- |
| a | Brand book: tokens, 21 components with live previews and guidelines, logo and icon assets, cover | [Bridge Puente](https://claude.ai/artifact/JCunauKZ4Binpf7tXxQmuo) (Design System artifact) | Published; previews render in both modes; owner reviewed | Published 2026-10-16 (v4); 21 previews, 0 component axe violations in both modes. Awaiting owner review |
| b | Component contracts: props, data source, events and query params for every component | `brand/COMPONENT-CONTRACTS.md` | Every brand-book component has a section; query contracts listed | Done 2026-10-16. Seal stays provisional (stamp OPEN) |
| c | Exact timings and easing from the shipped code | `brand/SIGNATURE-COMPONENTS.md` ("Shipped behaviour") | Every animation and debounce in `sig-*.js` / CSS has a row | Done 2026-10-16, read from the code. Fixed drift: the checker's "one side Spanish" rule |
| d | Placeholder register | `docs/placeholder-register.md` | Merges ARCHITECTURE §12, DIRECTION §11, HANDOFF_v1 §8; each row has where it lives and what it blocks | Done 2026-10-16: 29 rows, all open |
| e | Polish carried over from v2 | `prototype/` | See the polish list below | Done 2026-10-16 |

### Polish list (e)

These are the only `prototype/` changes allowed in P0 (`CLAUDE.md` §5):

1. ~~"Jornada completa" wraps inside the planner's duration control at 1440px.~~ **Fixed 2026-10-16:** from 40rem the segments are equal columns at least as wide as the longest label (max 34rem). One line at 390, 768, 1024, 1280 and 1440.
2. ~~The logo trail dots read slightly understated at large sizes.~~ **Strengthened 2026-10-16** (owner's choice): each dot radius +0.5 u (3–5 u, matching the app icon), re-spaced on the same curve; 46 files (every M1 SVG, `logo-sheet.html`, the footer watermark). Spec: `brand/logo/LOGO.md` §1. The M5 app icon and favicon are unchanged.
3. ~~The footer wordmark is very large at desktop.~~ **Capped 2026-10-16** (owner's choice) at `max-width: 52rem` (832px).

## Ready conditions

- The stamp stays OPEN: the Seal contract is written, but the component can't be called locked (ADR summary #6).
- Contracts that touch OPEN ADR points (4.3 validation, 3.2 time zone) are written to work with any outcome (methodology §8).

## Control gates

### Close

- The owner reviews the brand book, the contracts and the register.
- The kit's Phases 4–6 follow: backlog, phase docs for P1+, the first spec.
- The handoff is written.

## Phase Definition of Done

All five deliverables done (the Seal excepted while the stamp is OPEN), no drift between the brand book, the contracts and the prototype, and the owner's approval recorded below.

## Active risks

| Risk | Signal | Response |
| --- | --- | --- |
| Brand book and repo docs drift apart | A value differs between the brand book and `app.css` or `DIRECTION.md` | The repo docs own the values; fix the brand book in the same session (tokens.json is generated from `app.css`) |
| The stamp choice stays open into P4 | No answer from Bridge by P4 | Ship the provisional seal labelled as such; it is isolated in `<x-seal>` |

## GitHub Issues sync executed

- None: the board is loaded after P0.
