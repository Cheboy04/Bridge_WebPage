# brg-05 (site) — Editor manages FAQs

> **GitHub Issues:** `BRG-16` (local `brg-05`) · **Phase:** P3 · **Covers:** RF-06
> **Counterpart:** — (does not cross layers)
> **Status:** `[x]` draft · `[x]` approved (agent, mode C, 2026-10-19) · `[x]` implemented

Turns the issue's acceptance criteria (create, edit, reorder and delete FAQs; an FAQ without a service is global, with one it belongs to that service's page) into a Filament resource, its policy and the scope P4 reads global FAQs with.

## 1. Scope in this layer

**In:**

- `FaqPolicy` on the `StaffContentPolicy` base (brg-04 §3.2, ADR D8.1).
- `FaqResource`: list, create, edit; drag-reorderable by `sort`; delete in the edit page header.
- `Faq::withoutService()` scope: the global FAQs for `/preguntas-frecuentes`. A service's own FAQs are `$service->faqs()` (brg-35). The scope isn't named `global` because that's a PHP keyword.

**Out / deferred (with reason):**

- The FAQ page, the per-service FAQ block, `FAQPage` JSON-LD and sanitising `answer` on render (ERD I9) → P4 (HU-15, HU-11/12), P6 (HU-29).
- A filter by service in the list: the table shows the service column and sorts by `sort`; a filter waits until the list is long enough to need one.

## 2. Dependencies

- **GitHub Issues:** `BRG-14` (services) and `BRG-15` (`StaffContentPolicy`) merged.
- **Data model:** `docs/erd/modelo-contenido.md` §3.4. No schema change.
- **Vetoes:** `CLAUDE.md` §5 lifts the veto for HU-05 (P3).
- **ADR (DECIDED):** D8.1, D3.6, D4.1, D1.2.
- **OPEN items that don't block:** none.
- **External:** none.

## 3. Technical contract

### 3.1 Model

- `#[Scope] withoutService(Builder $query)` → `whereNull('service_id')`.

### 3.2 Resource

Generated as brg-03 (`--embed-schemas --embed-table`).

| Field | Component | Rules |
| --- | --- | --- |
| `question` | TextInput | required, max 255 |
| `answer` | RichEditor | required (column not nullable; HTML, ERD I9) |
| `service_id` | Select, relationship `service` | optional; options labelled with the Spanish title; empty = global, the placeholder says so |

- Table: question, service title (placeholder "General"), `defaultSort('sort')`, `reorderable('sort')`. Edit row action; delete in the edit header. No bulk actions.
- The edit page uses `FillsTranslations` (brg-03 §3.3). Labels in `lang/es/admin.php`.

## 4. Acceptance criteria of this layer → tests

Runner: Pest, MySQL (C4), `RefreshDatabase`. File `tests/Feature/Admin/FaqResourceTest.php` unless noted; acting as an editor unless noted.

| # | Test (file::case) | What it asserts | How we prove it FAILS (C3) |
| --- | --- | --- | --- |
| 1 | `it opens the faq pages for both roles` (dataset: role × index, create, edit) | 200 | `FaqPolicy` no longer extends the base |
| 2 | `it lets an editor create a global faq` | Through `CreateFaq` without a service: `question` stored as `{"es": …}`, `service_id` null | Give the select a default service |
| 3 | `it lets an editor attach a faq to a service` | Through `CreateFaq` with a service: it is in `$service->faqs` | Remove the `service_id` field from the form |
| 4 | `it requires a question and an answer` | `assertHasFormErrors`: `required` on `question`, an error on `answer` | Remove `->required()` from `answer` |
| 5 | `it loads the Spanish question into the edit form` | `assertSchemaStateSet` shows the plain question | Remove `FillsTranslations` from `EditFaq` |
| 6 | `it reorders faqs by drag` | `reorderTable` writes `sort` in the new order | Remove `->reorderable('sort')` |
| 7 | `it lets an editor delete a faq` | The edit header's delete action removes the row | Remove `DeleteAction` from the header |
| 8 | `Content/ScopeTest::it keeps service faqs out of the global scope` | `Faq::withoutService()` returns only the global one | The scope adds no `whereNull` |

## 5. Implementation notes

- Select labels: `getOptionLabelFromRecordUsing(fn (Service $s) => $s->title)` (brg-04 §5).
- Larastan with `--memory-limit=1G`.

## 6. Spec change log

- `2026-10-19` — review with C3: **8 mutations, 8 killed**, each lint-checked and with a named failing case. Review findings: none open.
- `2026-10-19` — implemented: suite 185 green (405 assertions); Pint clean; Larastan 0 errors; Vite build ok. Ping-pong on test 4: the rich editor enforces `required` with its own closure rule, so Livewire can't match the rule name; the test checks that `answer` has an error (the message is "El campo respuesta es obligatorio."), and the C3 mutation still kills it.
- `2026-10-19` — red: 13 cases failing (commit `a223908`).
- `2026-10-19` — draft created and approved by the agent (mode C). Decisions taken alone: the scope name (§1), no list filter yet (§1).
