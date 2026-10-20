# brg-04 (site) — Editor manages languages and services per language

> **GitHub Issues:** `BRG-15` (local `brg-04`) · **Phase:** P3 · **Covers:** RF-03
> **Counterpart:** — (does not cross layers)
> **Status:** `[x]` draft · `[x]` approved (agent, mode C, 2026-10-19) · `[ ]` implemented

Turns the issue's acceptance criteria (add, edit, reorder and unpublish a language and pick its services; unique, validated codes; the checker's data built from published languages only) into a Filament resource, its policy, the `published()` scope and the LangChecker payload builder.

## 1. Scope in this layer

**In:**

- `LanguagePolicy`: both roles, every action (ADR D8.1).
- `LanguageResource` with list, create and edit pages; drag-reorderable by `sort`; services picked as checkboxes.
- `Language::published()` scope.
- `Language::checkerPayload()`: the array P4's `<x-sig-lang-checker>` serialises (`brand/COMPONENT-CONTRACTS.md`, LangChecker).
- A shared `StaffContentPolicy` base: ServicePolicy and LanguagePolicy were the same six "every action" methods, and four more content policies follow (D8.1). ServicePolicy moves onto it.

**Out / deferred (with reason):**

- The checker component and its inline JSON → P4 (HU-19).
- Quote-form language selects → P5 (HU-24, HU-25); they reuse `published()`.

## 2. Dependencies

- **GitHub Issues:** `BRG-13` and `BRG-14` merged: strict authorization, D8.1, `FillsTranslations`, Spanish validation, `Service::published()`.
- **Data model:** `docs/erd/modelo-contenido.md` §3.2–3.3. No schema change.
- **Vetoes:** `CLAUDE.md` §5 lifts the veto for HU-04 (P3).
- **ADR (DECIDED):** D8.1, D3.6, D4.1, D1.2.
- **OPEN items that don't block:** register #16 (the real language list): Bridge edits the seeded examples here.
- **External:** none.

## 3. Technical contract

### 3.1 Model

- `#[Scope] published(Builder $query)` → `where('published', true)` (as `Service`).
- `public static function checkerPayload(): array` returns `['languages' => [...]]`, each item exactly `code`, `name` (Spanish), `services`, `featured`, in `sort` order (ties by `id`, ERD I7).
  - Only published languages (the AC).
  - `services` lists the Spanish slugs of the language's services that are **published and in the Documento mode**. The checker's CTA goes to the translation quote, whose `servicio` parameter accepts only a published Documento slug (contracts, query-parameter table), so an interpreting or unpublished service must not reach it.

### 3.2 Policies

- `app/Policies/StaffContentPolicy.php` (abstract): `viewAny`, `view`, `create`, `update`, `delete`, `reorder` return true, typed on `Model`. Every user is staff (brg-02 §3.2) and D8.1 gives both roles every action on these models.
- `ServicePolicy` and `LanguagePolicy` extend it with no body. Page (HU-08) will extend it and override `delete`.

### 3.3 Resource

Generated as brg-03 (`--embed-schemas --embed-table`).

| Field | Component | Rules |
| --- | --- | --- |
| `code` | TextInput | required, max 10, `^[a-z]{2,3}(-[A-Z]{2})?$` (ISO 639 code, optional region: `en`, `qu`, `pt-BR`), unique ignoring the record |
| `name` | TextInput | required, max 255 |
| `services` | CheckboxList, relationship | optional; options labelled with the Spanish title, ordered by `sort` |
| `featured` | Toggle | |
| `published` | Toggle | defaults to off |

- Table: code, name, featured and published (icons), `defaultSort('sort')`, `reorderable('sort')`. Edit row action; delete in the edit page header. No bulk actions.
- The edit page uses `FillsTranslations` (brg-03 §3.3).
- Labels in `lang/es/admin.php`.

## 4. Acceptance criteria of this layer → tests

Runner: Pest, MySQL (C4), `RefreshDatabase`. File `tests/Feature/Admin/LanguageResourceTest.php` unless noted; acting as an editor unless noted.

| # | Test (file::case) | What it asserts | How we prove it FAILS (C3) |
| --- | --- | --- | --- |
| 1 | `it opens the languages pages for both roles` (dataset: role × index, create, edit) | 200 | `LanguagePolicy` no longer extends the base (strict mode throws) |
| 2 | `it lets an editor create a language with its services` | Through `CreateLanguage`: name stored as `{"es": …}`, the two chosen services linked, `published` false | Remove `->relationship()` from the checkbox list |
| 3 | `it lets an editor change the services of a language` | Through `EditLanguage`: the link set becomes exactly the new choice | Same mutation as #2 |
| 4 | `it rejects a duplicate code` | `assertHasFormErrors(['code' => 'unique'])` | Remove the unique rule (no-op swap) → the database throws |
| 5 | `it rejects a code that is not an ISO 639 code` (dataset: `EN`, `english`, `e`, `pt-br`) | `assertHasFormErrors(['code' => 'regex'])` | Remove the regex |
| 6 | `it reorders languages by drag` | `reorderTable` writes `sort` in the new order | Remove `->reorderable('sort')` |
| 7 | `it lets an editor unpublish a language` | Through `EditLanguage`, off persists | Remove the `published` toggle |
| 8 | `Content/ScopeTest::it keeps unpublished languages out of the published scope` | Only the published one | The scope adds no `where` |
| 9 | `Content/CheckerPayloadTest::it builds the checker data from published languages` | Exact payload: only published languages, `sort` order, item keys, Spanish name | Drop `published()` from the language query |
| 10 | `Content/CheckerPayloadTest::it lists only published translation services` | A language linked to a published Documento, an unpublished Documento and a published Cabina service lists only the first slug | Drop the service `published()` filter; separately, drop the mode filter |
| 11 | `Admin/ServiceResourceTest` (brg-03) | Still green after ServicePolicy moves onto the base | ServicePolicy no longer extends the base |

## 5. Implementation notes

- Option labels: `getOptionLabelFromRecordUsing(fn (Service $s) => $s->title)`; the raw `title` column is JSON.
- Larastan with `--memory-limit=1G`.

## 6. Spec change log

- `2026-10-19` — draft created and approved by the agent (mode C). Decisions taken alone: checker `services` limited to published Documento services (§3.1), shared `StaffContentPolicy` base (§3.2), code format (§3.3).
