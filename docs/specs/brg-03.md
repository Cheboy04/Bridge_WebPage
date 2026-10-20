# brg-03 (site) — Editor manages services

> **GitHub Issues:** `BRG-14` (local `brg-03`) · **Phase:** P3 · **Covers:** RF-02, RNF-06
> **Counterpart:** — (does not cross layers)
> **Status:** `[x]` draft · `[x]` approved (agent, mode C, 2026-10-19) · `[ ]` implemented

Turns the issue's acceptance criteria (create, edit, reorder, publish and unpublish; a required mode; unique slugs with a Spanish error; unpublished services kept out of public queries) into a Filament resource, its policy, the model's public scope and the Spanish validation messages the whole admin needs.

## 1. Scope in this layer

**In:**

- `ServicePolicy`: both roles, every action (ADR D8.1).
- `ServiceResource` with list, create and edit pages; the table is drag-reorderable by `sort`.
- `Service::published()` scope: the only way P4 reads services.
- `lang/es/validation.php`: Laravel's validation messages in Spanish. Without it, every validation error in the admin shows the raw key (`validation.unique`); this also fixes HU-02's duplicate-email message.
- `ServiceMode` gets Spanish labels (`HasLabel`).

**Out / deferred (with reason):**

- Public hub and service pages, and sanitising `body` on render (ERD I9) → P4 (HU-11, HU-12).
- Deleting a service that leads reference: the database refuses it (brg-36, restrict). No lead rows exist until P5; the inbox story (HU-27) makes the delete action report it instead of failing.
- Picking the icon from the sprite → P4, when the sprite moves into `resources/views`. Until then it's a text field validated as a sprite id.
- Languages per service → HU-04 (edited from the language side).

## 2. Dependencies

- **GitHub Issues:** `BRG-13` (brg-02) merged: strict authorization, D8.1.
- **Data model:** `docs/erd/modelo-contenido.md`, `services` table. No schema change.
- **Vetoes:** `CLAUDE.md` §5 lifts the veto for HU-03 (P3).
- **ADR (DECIDED):** D8.1, D3.6, D4.1, D3.1, D3.2, D1.2.
- **OPEN items that don't block:** none.
- **External:** none.

**Contract note — slug uniqueness.** The issue says "unique per mode"; the approved ERD (I3) is stricter: the Spanish slug is unique across **all** services, through a functional index. The ERD owns constraints, and the stricter rule still meets the criterion (a duplicate in the same mode is rejected). Validation matches the database, so the form rejects a duplicate in either mode with a Spanish message instead of a 500.

## 3. Technical contract

### 3.1 Model

- `#[Scope] protected function published(Builder $query): void` → `where('published', true)`. No ordering in the scope; P4 orders where it lists.

### 3.2 Policy

`app/Policies/ServicePolicy.php`: `viewAny`, `view`, `create`, `update`, `delete`, `reorder` return true. Every user is staff with panel access (brg-02 §3.2), and D8.1 gives both roles every action. Strict mode requires each method Filament asks for; a missing one throws, so the tests reveal it.

### 3.3 Resource

Generated with `make:filament-resource Service --embed-schemas --embed-table` (as brg-02).

| Field | Component | Rules |
| --- | --- | --- |
| `title` | TextInput | required, max 255. On create, filling it proposes the slug (`Str::slug`) |
| `slug` | TextInput | required, max 255, lowercase kebab (`^[a-z0-9]+(?:-[a-z0-9]+)*$`), unique on `slug->es` ignoring the record |
| `mode` | Select (`ServiceMode`) | required |
| `summary` | Textarea | optional, max 500 |
| `body` | RichEditor | optional (HTML, ERD I9) |
| `icon` | TextInput | optional, same kebab pattern; helper names the sprite |
| `image` | FileUpload, image | optional; `public` disk, `services/` directory (ERD I8) |
| `turnaround` | TextInput | optional, max 255 |
| `featured`, `published` | Toggle | `published` defaults to off |
| `seo_title`, `seo_description` | TextInput, Textarea | optional, max 255 |

- Translatable fields are plain fields: in the single `es` locale, spatie reads and writes the current locale's value (D3.6, D3.9). The tests prove the round trip (phase-03 risk 1).
- Table: title, mode (badge), published and featured (icons), `defaultSort('sort')`, `reorderable('sort')`. Edit row action; delete in the edit page header. No bulk actions.
- Labels in Spanish in `lang/es/admin.php`; `ServiceMode` labels "Documento (traducción)" and "Cabina (interpretación)".

### 3.4 Spanish validation

`lang/es/validation.php` translates every key of Laravel 12's `en/validation.php`. Filament passes each field's label as `:attribute`, so no `attributes` map is needed.

## 4. Acceptance criteria of this layer → tests

Runner: Pest, MySQL (C4), `RefreshDatabase`. File `tests/Feature/Admin/ServiceResourceTest.php` unless noted; acting as an editor (the lower role) unless noted. `Storage::fake('public')` for the upload.

| # | Test (file::case) | What it asserts | How we prove it FAILS (C3) |
| --- | --- | --- | --- |
| 1 | `it opens the services pages for both roles` (dataset: role × index, create, edit) | 200 | `ServicePolicy::viewAny` returns false |
| 2 | `it lets an editor create a service` | Through `CreateService`: `title` stored as `{"es": …}`, the chosen mode, `published` false by default | `published` toggle defaults to on |
| 3 | `it loads the Spanish values into the edit form` | `assertSchemaStateSet` shows the plain Spanish `title`, not JSON | Remove `title` from `Service::$translatable` |
| 4 | `it requires a mode` | `assertHasFormErrors(['mode' => 'required'])` | Remove `->required()` from `mode` |
| 5 | `it rejects a duplicate slug in either mode` (dataset: same mode, other mode) | `assertHasFormErrors(['slug' => 'unique'])`; nothing created | Remove the unique rule → the database throws instead |
| 6 | `it rejects a slug that is not lowercase kebab` | `assertHasFormErrors(['slug' => 'regex'])` | Remove the regex |
| 7 | `it reorders services by drag` | `reorderTable` with a new order writes `sort` in that order | Remove `->reorderable('sort')` |
| 8 | `it lets an editor unpublish and publish a service` | Through `EditService`: off persists, then on persists | Remove the `published` toggle from the form |
| 9 | `it stores the image on the public disk` | The saved path exists on the fake `public` disk under `services/` | Store on the `local` disk |
| 10 | `Content/ScopeTest::it keeps unpublished services out of the published scope` | `Service::published()` returns only the published one | The scope adds no `where` |
| 11 | `Admin/ValidationLangTest::it shows validation messages in Spanish` (dataset: required, unique, regex, max.string) | `__("validation.$key")` is neither the key nor the English text | Delete `lang/es/validation.php` |

## 5. Implementation notes

- `#[Scope]` exists in the installed Laravel (`Illuminate\Database\Eloquent\Attributes\Scope`).
- Filament writes `sort` from 1 when reordering; test 7 asserts the relative order, not the values.
- Larastan with `--memory-limit=1G`.

## 6. Spec change log

- `2026-10-19` — draft created and approved by the agent (mode C). Decisions taken alone: global slug uniqueness follows ERD I3 (§2 note), Spanish validation file in this story (§1), icon as a validated text field until P4 (§1), delete-with-leads handling deferred to HU-27 (§1).
