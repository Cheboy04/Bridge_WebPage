# Phase 3 — Admin (Bridge Traducciones website)

**Status:** **closed 2026-10-19** with brg-33 carried forward again (*Carry-over* below). Opened 2026-10-19 after P2 ([`phase-02.md`](phase-02.md) *Carry-over*). Next: [`phase-04.md`](phase-04.md).
**Owns:** the plan, tickets and close criteria of P3. **Referenced by:** `CLAUDE.md` §5, `docs/backlog/roadmap.md`.

## Goal

An `admin` and an `editor` sign in at `/admin` and manage every content entity and the Settings row through Filament, within the rights of ADR D4.2. Every public query the P4 pages will call (published services and languages, permitted client logos, public posts) exists as a tested model scope, so P4 renders data without adding rules. Preconditions met: every P2 table, model and factory (brg-35–37), and Filament 5's panel at `/admin` (brg-31).

## Capacity and commitment

No story points (ADR 1.5 OPEN). P3 has eight Stories and no Tasks, plus brg-33 carried.

## Phase records

| Key | Local ID | Type | Title | Delivery dependencies |
| --- | --- | --- | --- | --- |
| `BRG-13` | `brg-02` | Story | HU-02 Admin sign-in with admin and editor roles | — |
| `BRG-14` | `brg-03` | Story | HU-03 Editor manages services | brg-02 |
| `BRG-15` | `brg-04` | Story | HU-04 Editor manages languages and services per language | brg-02, brg-03 |
| `BRG-16` | `brg-05` | Story | HU-05 Editor manages FAQs | brg-02, brg-03 |
| `BRG-17` | `brg-06` | Story | HU-06 Editor manages blog posts | brg-02 |
| `BRG-18` | `brg-07` | Story | HU-07 Editor manages clients and testimonials | brg-02 |
| `BRG-19` | `brg-08` | Story | HU-08 Editor manages simple pages | brg-02 |
| `BRG-20` | `brg-09` | Story | HU-09 Admin edits site settings | brg-02 |
| `BRG-43` | `brg-33` | Task | Release deploy to staging (carried from P1, P2) | owner's hosting checks |

## Execution sequence

1. **brg-02** first: the panel access rule, the policies and the permission matrix (ADR 8.1, PARTIAL) that every resource story reuses. The matrix is closed in the ADR in the same PR. Merged 2026-10-19 (PR #71, spec [`brg-02.md`](../../specs/brg-02.md)).
2. **brg-03**, then **brg-04** and **brg-05**: both reference services (the language pivot and the FAQ's optional service). Merged 2026-10-19 (PRs #72, #73, #75).
3. **brg-06**, **brg-07**, **brg-08**, **brg-09** in any order; each is independent once brg-02 is merged. Merged 2026-10-19 (PRs #76, #77, #78, #74).
4. **brg-33** whenever the hosting checks land; it doesn't gate P3.

## Ready conditions

- All eight Stories: Ready once brg-02 is merged (brg-02 itself is Ready now). No OPEN ADR point blocks them; their ERD slices are approved (P2).
- The Lead resource is **not** in P3: the editor's lead rights from D4.2 arrive with HU-27 (P5). brg-02's matrix records them so HU-27 only applies it.

## Tasks and cross-cutting line

Each Story follows its checklist in the issue body. Cross-cutting rules for every resource:

- Translatable fields are edited in the single locale `es` through `spatie/laravel-translatable` (D3.6, D3.9 no second locale); no extra Filament plugin without an ADR entry (D3.7).
- Validation errors render in Spanish (test config pins `es`, lessons).
- Every policy is tested per role (guest, editor, admin), never only through the UI.

## Control gates

### Start

- `CLAUDE.md` §5 updated with P3's scope (2026-10-19, with this document).
- P2's carry-over is recorded ([`phase-02.md`](phase-02.md)).

### Close

- An `editor` and an `admin` manage every content entity locally, and staging once brg-33 lands (P1 carry-over). **Met locally:** every resource has a per-role test through Filament, and `migrate:fresh --seed` plus the suite (241/241) are green on `develop` at `a399e27`. "On staging" is **carried** with brg-33.
- ADR 8.1 (permission matrix) is DECIDED (**met**, D8.1, PR #71).
- CI green on MySQL for every P3 PR (**met**, PRs #71–#78).

## Carry-over

Recorded 2026-10-19:

- **brg-33 / `BRG-43`** stays open and blocked on ADR 9.1's hosting checks (owner), on the same terms as P1 and P2: it doesn't block P4–P5 and must land before P6.
- **For P4 (recorded in the specs, not drift):** every rich-text body (`Service.body`, `Faq.answer`, `Post.body`, `Page.body`) is sanitised on render (ERD I9); only `Post.body` is also sanitised on save (brg-06). P4 reads public data only through the tested scopes: `Service::published()`, `Language::published()` and `checkerPayload()`, `Faq::withoutService()`, `Post::published()`, `Client::publicLogos()`, `Testimonial::published()`. A deleted `nosotros` page needs a P4 fallback (brg-08).
- **For P5:** HU-27 applies D8.1's lead rights and makes a service delete report the restrict-on-delete case when leads reference it.

## Phase Definition of Done

The eight Stories are Done per ADR block 1, with no drift between the policies, ADR 8.1 and the ERD slices.

## Active risks

| Risk | Signal | Response |
| --- | --- | --- |
| Filament 5's form fields and spatie's translatable casts disagree on reads or writes | A saved title shows as JSON, or a locale key is lost | A test per translatable resource saves through the Filament form and reads back through the model |
| Rich text (posts, pages) needs a sanitiser beyond D3.7 | HU-06 finds no sanitiser in the installed set | Prefer what Filament already ships; otherwise record an ADR entry before adding one |
| Public scopes drift from the AC before P4 uses them | P4 adds a `where` in a controller | Scopes live on the model and are tested in P3; P4 only calls them |

## GitHub Issues sync executed

- `2026-10-19` — PRs #71–#78 merged into `develop`. Their `Closes #n` keywords only fire on the default branch (`main`), so issues #13–#20 are still open.
- **Pending (owner):** close issues #13–#20 by hand; move `BRG-43` (#43, still in `P2 Data`) to the `P4 Public site` milestone.
