# brg-07 (site) — Editor manages clients and testimonials

> **GitHub Issues:** `BRG-18` (local `brg-07`) · **Phase:** P3 · **Covers:** RF-05
> **Counterpart:** — (does not cross layers)
> **Status:** `[x]` draft · `[x]` approved (agent, mode C, 2026-10-19) · `[x]` implemented

Turns the issue's acceptance criteria (editors manage clients and testimonials; `logo_permission` defaults to false and the form says written permission is required; a client without permission never comes back from the public logo query) into two Filament resources, their policies and two public scopes.

## 1. Scope in this layer

**In:**

- `ClientPolicy`, `TestimonialPolicy` on the `StaffContentPolicy` base (ADR D8.1).
- `ClientResource`: list (logo thumbnail), create, edit; drag-reorderable by `sort`; delete in the edit header.
- `TestimonialResource`: list, create, edit; delete in the edit header. Testimonials have no `sort` column (ERD §3.7), so no reordering.
- `Client::publicLogos()`: clients with `logo_permission` **and** a logo, in `sort` order. The only query the TrustStrip and `/nosotros` may use for logos.
- `Testimonial::published()`.

**Out / deferred (with reason):**

- The logo row (grayscale, fixed height, at least six, no empty heading: `brand/DIRECTION.md` §10) and any testimonial display → P4. The "at least six" rule is a rendering rule; the scope returns what's permitted and P4 decides whether to show the row.
- Where the written permission itself is kept: the form only records that it exists. Storing the document isn't in any story (register #26).

## 2. Dependencies

- **GitHub Issues:** `BRG-15` (`StaffContentPolicy`) merged. Independent of PR #76.
- **Data model:** `docs/erd/modelo-contenido.md` §3.6–3.7. No schema change.
- **Vetoes:** `CLAUDE.md` §5 lifts the veto for HU-07 (P3).
- **ADR (DECIDED):** D8.1, D4.1, D3.6, D2.2, D1.2.
- **OPEN items that don't block:** register #26 (Bridge's written logo permissions).
- **External:** none.

## 3. Technical contract

### 3.1 Models

- `Client`: `#[Scope] publicLogos(Builder $query)` → `where('logo_permission', true)->whereNotNull('logo')->orderBy('sort')->orderBy('id')`. Unlike the other scopes it orders, because the logo row has exactly one order (I7).
- `Testimonial`: `#[Scope] published(Builder $query)` → `where('published', true)`.

### 3.2 Client form

| Field | Component | Rules |
| --- | --- | --- |
| `name` | TextInput | required, max 255 (proper noun, the logo's `alt`) |
| `logo` | FileUpload, image | optional; `public` disk, `clients/` |
| `url` | TextInput | optional, URL |
| `sector` | TextInput | optional, max 255 (translatable) |
| `logo_permission` | Toggle | defaults to off; helper text: the logo appears on the site only with the client's **written permission** |

Table: logo (thumbnail), name, sector, permission (icon); `defaultSort('sort')`, `reorderable('sort')`.

### 3.3 Testimonial form

| Field | Component | Rules |
| --- | --- | --- |
| `quote` | Textarea | required |
| `person` | TextInput | required, max 255 |
| `role` | TextInput | optional, max 255 (translatable) |
| `company` | TextInput | optional, max 255; for companies that aren't a client |
| `client_id` | Select, relationship `client` | optional |
| `published` | Toggle | defaults to off |

Table: person, company, client name, published (icon).

Both edit pages use `FillsTranslations`. Labels in `lang/es/admin.php`.

## 4. Acceptance criteria of this layer → tests

Runner: Pest, MySQL (C4), `RefreshDatabase`. Files `tests/Feature/Admin/ClientResourceTest.php` and `TestimonialResourceTest.php`, plus `Content/ScopeTest.php`; acting as an editor unless noted.

| # | Test (file::case) | What it asserts | How we prove it FAILS (C3) |
| --- | --- | --- | --- |
| 1 | `ClientResourceTest::it opens the client pages for both roles` (dataset: role × index, create, edit) | 200 | `ClientPolicy` no longer extends the base |
| 2 | `ClientResourceTest::it creates a client without logo permission by default` | Through `CreateClient`: `logo_permission` false | Toggle defaults to on |
| 3 | `ClientResourceTest::it says a written permission is required` | The create page shows the helper text | Remove the helper text |
| 4 | `ClientResourceTest::it records a granted permission` | Through `EditClient`, on persists | Remove the toggle from the form |
| 5 | `ClientResourceTest::it reorders clients by drag` | `reorderTable` writes `sort` | Remove `->reorderable('sort')` |
| 6 | `ClientResourceTest::it loads the Spanish sector into the edit form` | `assertSchemaStateSet` | Remove `FillsTranslations` from `EditClient` |
| 7 | `Content/ScopeTest::it returns only permitted client logos` | Permitted with logo → in, in `sort` order; no permission or no logo → out | Drop the permission `where`; separately, drop `whereNotNull('logo')` |
| 8 | `TestimonialResourceTest::it opens the testimonial pages for both roles` (dataset as #1) | 200 | `TestimonialPolicy` no longer extends the base |
| 9 | `TestimonialResourceTest::it creates an unpublished testimonial linked to a client` | Through `CreateTestimonial`: `quote` as `{"es": …}`, `client_id` set, `published` false | Remove the `client_id` field |
| 10 | `Content/ScopeTest::it keeps unpublished testimonials out of the published scope` | Only the published one | The scope adds no `where` |

## 5. Implementation notes

- Logo thumbnail: `ImageColumn::make('logo')->disk('public')`.
- Labels added before `'faqs'` in `lang/es/admin.php`, away from PR #76's block, so the two PRs merge cleanly.
- Larastan with `--memory-limit=1G`.

## 6. Spec change log

- `2026-10-19` — review with C3: **11 mutations, 11 killed** (the 10 rows of §4, #7 split in two), each lint-checked and with a named failing case. Review findings: none open.
- `2026-10-19` — implemented: suite 217 green (483 assertions); Pint clean; Larastan 0 errors; Vite build ok.
- `2026-10-19` — red: 20 cases failing (commit `f69d62e`).
- `2026-10-19` — draft created and approved by the agent (mode C). Decisions taken alone: `publicLogos()` also requires a logo and orders by `sort` (§3.1), the "at least six" rule left to P4 (§1).
