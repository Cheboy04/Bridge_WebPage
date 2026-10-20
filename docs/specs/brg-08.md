# brg-08 (site) — Editor manages simple pages

> **GitHub Issues:** `BRG-19` (local `brg-08`) · **Phase:** P3 · **Covers:** RF-01, RF-07
> **Counterpart:** — (does not cross layers)
> **Status:** `[x]` draft · `[x]` approved (agent, mode C, 2026-10-19) · `[ ]` implemented

Turns the issue's acceptance criteria (an editor edits a page's title, body and SEO fields; the `privacidad` page can't be deleted) into a Filament resource and a policy that blocks that one delete.

## 1. Scope in this layer

**In:**

- `PagePolicy` on the `StaffContentPolicy` base, overriding `delete`: false for the page whose `es` slug is `privacidad`, for both roles (ADR D8.1).
- `PageResource`: list, create, edit; delete in the edit header (hidden for `privacidad` by the policy).
- **The slug is locked on edit.** Page routes are fixed in code and look pages up by slug (ERD §3.8), so renaming `privacidad` would take the page off the site as surely as deleting it. The slug is set on create (`SlugFields`, brg-06) and shown disabled afterwards.

**Out / deferred (with reason):**

- The `/privacidad` and `/nosotros` routes and their rendering, including sanitising `body` on render (ERD I9) → P4.
- `Page.body` is **not** sanitised on save: the story has no such criterion, and render-time sanitising covers it, as for `Service.body` and `Faq.answer` (brg-06 §1).
- Blocking the delete of `nosotros`: D8.1 protects only `privacidad`, the legally required page. A missing `nosotros` body is P4's fallback question.

## 2. Dependencies

- **GitHub Issues:** `BRG-15` (`StaffContentPolicy`), `BRG-17` (`SlugFields`, `FillsTranslations` pattern) merged.
- **Data model:** `docs/erd/modelo-contenido.md` §3.8. No schema change.
- **Vetoes:** `CLAUDE.md` §5 lifts the veto for HU-08 (P3).
- **ADR (DECIDED):** D8.1, D4.1, D3.6, D1.2.
- **OPEN items that don't block:** none.
- **External:** none.

## 3. Technical contract

### 3.1 Policy

`PagePolicy::delete(User $user, Model $page)` → `$page->getTranslation('slug', 'es') !== 'privacidad'`. The `es` value is read explicitly, so the rule doesn't depend on the admin's locale.

### 3.2 Resource

| Field | Component | Rules |
| --- | --- | --- |
| `title`, `slug` | `SlugFields` | as brg-06; the slug is `disabledOn('edit')` |
| `body` | RichEditor | required (column not nullable) |
| `seo_title`, `seo_description` | TextInput, Textarea | optional, max 255 |

- Table: title, slug, `updated_at`. Edit row action; delete in the edit header. No reordering, no bulk actions.
- The edit page uses `FillsTranslations`. Labels in `lang/es/admin.php`.

## 4. Acceptance criteria of this layer → tests

Runner: Pest, MySQL (C4), `RefreshDatabase`. File `tests/Feature/Admin/PageResourceTest.php`; acting as an editor unless noted.

| # | Test (file::case) | What it asserts | How we prove it FAILS (C3) |
| --- | --- | --- | --- |
| 1 | `it opens the page pages for both roles` (dataset: role × index, create, edit) | 200 | `PagePolicy` no longer extends the base |
| 2 | `it lets an editor edit the title, body and seo fields` | Through `EditPage`: the four values persist as `{"es": …}` | Remove `seo_description` from the form |
| 3 | `it keeps the slug when a page is edited` | Filling a new slug through `EditPage` leaves the stored slug unchanged | Remove `disabledOn('edit')` |
| 4 | `it never deletes the privacy page` (dataset: admin, editor) | The edit header's delete action is hidden for `privacidad`, and `Gate` denies `delete` | `PagePolicy::delete` returns true |
| 5 | `it lets an editor delete another page` | The delete action removes a non-`privacidad` page | `PagePolicy::delete` returns false |
| 6 | `it loads the Spanish body into the edit form` | `assertSchemaStateSet` shows the plain title and body | Remove `FillsTranslations` from `EditPage` |

## 5. Implementation notes

- Generated with `make:filament-resource Page --embed-schemas --embed-table --record-title-attribute=title`. The resource's page classes are `ListPages`, `CreatePage` and `EditPage` under `App\Filament\Resources\Pages\Pages`.
- Labels added after the `posts` block in `lang/es/admin.php`, away from PR #77's block.
- Larastan with `--memory-limit=1G`.

## 6. Spec change log

- `2026-10-19` — draft created and approved by the agent (mode C). Decisions taken alone: the slug locked on edit (§1), no sanitise-on-save for `Page.body` (§1), only `privacidad` protected (§1).
