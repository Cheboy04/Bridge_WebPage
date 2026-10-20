# brg-06 (site) — Editor manages blog posts

> **GitHub Issues:** `BRG-17` (local `brg-06`) · **Phase:** P3 · **Covers:** RF-04
> **Counterpart:** — (does not cross layers)
> **Status:** `[x]` draft · `[x]` approved (agent, mode C, 2026-10-19) · `[ ]` implemented

Turns the issue's acceptance criteria (draft, schedule and publish a post; a future `published_at` stays private until then; rich text sanitised on save) into a Filament resource, its policy, the public scope and a sanitising mutator on the model.

## 1. Scope in this layer

**In:**

- `PostPolicy` on the `StaffContentPolicy` base (ADR D8.1).
- `PostResource`: list, create, edit; delete in the edit header. Publication is the `published_at` field: empty = draft, future = scheduled, now or past = published (ERD §3.5).
- `Post::published()` scope: `published_at` not null and `≤ now()`.
- `Post.body` is sanitised **on save** by a model set mutator, so every write path is covered, not only the admin form.
- `config('app.display_timezone')` = `America/Guayaquil` (D3.2), applied to every Filament date field and column through `FilamentTimezone::set()`. The schedule picker shows Ecuador time; the database keeps UTC. `UserResource`'s hard-coded zone (brg-02) moves onto it.
- `App\Filament\Fields\SlugFields`: the title + slug pair (slug proposed from the title on create, lowercase kebab, unique on `slug->es`, ERD I3). Posts are its second user and Pages (HU-08) its third, so `ServiceResource` (brg-03) moves onto it instead of a copy.

**Out / deferred (with reason):**

- The blog list and post pages, pagination (ADR 3.4, OPEN) and `Article` JSON-LD → P4 (HU-14), P6 (HU-29).
- Sanitising on render stays required by ERD I9 for every rich-text body; P4 does it. `Service.body` and `Faq.answer` (brg-03, brg-05) are not sanitised on save: their stories had no such criterion, and render-time sanitising covers them. HU-08 decides whether `Page.body` reuses this mutator.

## 2. Dependencies

- **GitHub Issues:** `BRG-13`, `BRG-14`, `BRG-15` merged (strict authorization, `FillsTranslations`, Spanish validation, `StaffContentPolicy`).
- **Data model:** `docs/erd/modelo-contenido.md` §3.5. No schema change.
- **Vetoes:** `CLAUDE.md` §5 lifts the veto for HU-06 (P3). No new package: the sanitiser is Symfony's `html-sanitizer`, already installed and configured by Filament (`Str::sanitizeHtml()`; D3.7 untouched).
- **ADR (DECIDED):** D8.1, D3.2, D3.6, D3.9 (no categories), D1.2.
- **OPEN items that don't block:** 3.4 (pagination, P4).
- **External:** none.

## 3. Technical contract

### 3.1 Model

- `#[Scope] published(Builder $query)` → `whereNotNull('published_at')->where('published_at', '<=', now())`.
- `body(): Attribute` with a set mutator → `Str::sanitizeHtml($value)` (null stays null). Spatie calls attribute set mutators per locale value, so the stored `{"es": …}` holds the sanitised HTML.

### 3.2 Resource

| Field | Component | Rules |
| --- | --- | --- |
| `title`, `slug` | `SlugFields` | as `ServiceResource` (brg-03 §3.3), unique on `posts.slug->es` |
| `excerpt` | Textarea | optional, max 500 |
| `body` | RichEditor | required (column not nullable) |
| `cover` | FileUpload, image | optional; `public` disk, `posts/` (ERD I8) |
| `published_at` | DateTimePicker | optional; helper explains draft / scheduled / published; shown in `America/Guayaquil` |
| `seo_title`, `seo_description` | TextInput, Textarea | optional, max 255 |

- Table: title, status badge (Borrador / Programado / Publicado, computed from `published_at`), `published_at`; `defaultSort('published_at', 'desc')` (ERD listing order). Edit row action; delete in the edit header. No reordering, no bulk actions.
- Edit page uses `FillsTranslations`. Labels in `lang/es/admin.php`.

## 4. Acceptance criteria of this layer → tests

Runner: Pest, MySQL (C4), `RefreshDatabase`. File `tests/Feature/Admin/PostResourceTest.php` unless noted; acting as an editor unless noted.

| # | Test (file::case) | What it asserts | How we prove it FAILS (C3) |
| --- | --- | --- | --- |
| 1 | `it opens the post pages for both roles` (dataset: role × index, create, edit) | 200 | `PostPolicy` no longer extends the base |
| 2 | `it saves a post without a date as a draft` | Through `CreatePost`: `published_at` null, `title` as `{"es": …}` | Give `published_at` a default of now |
| 3 | `it schedules a post for a future date` | A future date (entered in Guayaquil time) is stored as the matching UTC instant | Remove the display time zone |
| 4 | `Content/ScopeTest::it keeps drafts and scheduled posts out of the published scope` | Past → in; null and future → out; once time passes the scheduled date, it's in (`travelTo`) | Drop the `<= now()` condition |
| 5 | `Content/SanitizeTest::it sanitises the post body on save` | A body with `<script>`, an `onclick` and a `javascript:` link is stored without them; safe markup (`<p>`, `<strong>`, a normal link) survives | Remove the `body()` mutator |
| 6 | `it sanitises a body saved through the admin form` | Same through `CreatePost` | Same mutation as #5 |
| 7 | `it rejects a duplicate slug` | `assertHasFormErrors(['slug' => 'unique'])` | `SlugFields` unique rule swapped for a no-op → the database throws |
| 8 | `it loads the Spanish title into the edit form` | `assertSchemaStateSet` | Remove `FillsTranslations` from `EditPost` |
| 9 | `Admin/ServiceResourceTest` (brg-03), `Admin/UserResourceTest` (brg-02) | Still green after moving onto `SlugFields` and the global zone | Run unchanged |

## 5. Implementation notes

- `FilamentTimezone::set(config('app.display_timezone'))` in `AppServiceProvider::boot()`.
- Test 3: fill `published_at` with a Guayaquil wall time (for example `2030-01-15 09:00:00`) and expect `2030-01-15 14:00:00` UTC.
- Larastan with `--memory-limit=1G`.

## 6. Spec change log

- `2026-10-19` — draft created and approved by the agent (mode C). Decisions taken alone: sanitise in a model mutator with Filament's configured Symfony sanitiser (§1, §3.1), the global display time zone (§1), the shared `SlugFields` (§1), no sanitise-on-save for Service/FAQ bodies (§1).
