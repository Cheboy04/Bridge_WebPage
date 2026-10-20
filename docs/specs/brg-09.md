# brg-09 (site) — Admin edits site settings

> **GitHub Issues:** `BRG-20` (local `brg-09`) · **Phase:** P3 · **Covers:** RF-07, RNF-05
> **Counterpart:** — (does not cross layers)
> **Status:** `[x]` draft · `[x]` approved (agent, mode C, 2026-10-19) · `[ ]` implemented

Turns the issue's acceptance criteria (only `admin` opens and saves Settings; phone and WhatsApp numbers in international format; a saved change shows on the next request) into one Filament page bound to the single Settings row.

## 1. Scope in this layer

**In:**

- `App\Filament\Pages\EditSettings` at `/admin/settings`: one form over `Settings::current()`, sections for contact, WhatsApp, presence, credentials and the home hero. Admin only, through `SettingsPolicy` (brg-02, ADR D8.1).
- Validation of the number formats (§3.2).
- Labels in `lang/es/admin.php`.

**Out / deferred (with reason):**

- Rendering any of it on the public site → P4 (layout, footer, ContactBlock, TrustStrip).
- Sending lead notifications to `notification_email` → P5 (HU-26).
- A settings cache: none exists, so nothing to clear (§3.3).

## 2. Dependencies

- **GitHub Issues:** `BRG-13` (brg-02) merged: `SettingsPolicy`, strict authorization.
- **Data model:** `docs/erd/modelo-leads-settings.md` §3.1. No schema change.
- **Vetoes:** `CLAUDE.md` §5 lifts the veto for HU-09 (P3).
- **ADR (DECIDED):** D4.1, D4.2, 4.6, D8.1, D3.6, D2.2, D1.2.
- **OPEN items that don't block:** the placeholder register rows this screen fills (#2–#10, #25, #29): Bridge's answers are typed here, not committed (D2.2).
- **External:** none.

## 3. Technical contract

### 3.1 The page

- A plain Filament `Page` without a Blade view: `content()` holds a `Form` that embeds the `form` schema and submits to `save()`, the same pattern as Filament's own profile page.
- `canAccess()` → the current user `can('viewAny', Settings::class)`. That hides the navigation item and returns 403 on the route for editors.
- `mount()` fills the form from `Settings::current()`; translatable fields are filled with their `es` value (the same rule as `FillsTranslations`, brg-03 §3.3, here written inline because this is not an `EditRecord` page).
- `save()` authorizes `update` on the row, then `fill($data)->save()` and sends a success notification. It never creates a row: `Settings::current()` is the only creator (ERD I11).

### 3.2 Fields and rules

| Section | Fields | Rules |
| --- | --- | --- |
| Contacto | `phone_landline`, `phone_mobile` | optional; international format: `+`, country code, then digits and single spaces (`^\+[1-9]\d{0,2}( ?\d){6,14}$`), e.g. `+593 2 000 0000` |
| | `contact_email`, `notification_email` | optional, email. Helper: the notification address is never shown publicly |
| | `address`, `map_url`, `office_hours` | optional; `map_url` is a URL |
| WhatsApp | `whatsapp_number` | optional; international format as `wa.me` needs it: digits only, no `+`, country code first (`^[1-9]\d{7,14}$`), e.g. `593990000000` |
| | `whatsapp_default_message` | optional |
| Presencia | `socials` | Repeater of `{network, url}`, both required per row, `url` a URL; stored as a list |
| | `founding_year` | optional integer, 1900 to the current year |
| | `legal_name` | optional |
| Credenciales | `ata_text` | optional |
| | `stats` | Repeater of `{value, label, source, verified_on}`, all required per row (a stat is shown only when documented, register #9); `verified_on` a date |
| Portada | `hero_hook` | optional; empty keeps the `lang/es` default (register #25) |

`whatsapp_default_message`, `office_hours`, `stats`, `ata_text`, `hero_hook` are translatable (`es`, D3.6).

### 3.3 "On the next request"

`Settings::current()` runs one query per call and nothing caches it, so a saved value is what the next request reads. If P4 adds a cache, the same PR makes `save()` (or a model `saved` hook) clear it, and test 8 keeps guarding the behaviour.

## 4. Acceptance criteria of this layer → tests

Runner: Pest, MySQL (C4), `RefreshDatabase`. File `tests/Feature/Admin/SettingsPageTest.php`; acting as an admin unless noted.

| # | Test (file::case) | What it asserts | How we prove it FAILS (C3) |
| --- | --- | --- | --- |
| 1 | `it opens the settings page only for admins` (dataset: admin 200, editor 403) | Status per role | `canAccess()` returns true |
| 2 | `it forbids an editor from saving` | `Livewire::test` as an editor is forbidden; the row is unchanged | Same mutation as #1 |
| 3 | `it saves the settings` | Contact fields, a translatable field (`{"es": …}`) and `socials` as a list persist; still one row | `save()` drops `fill($data)` |
| 4 | `it loads the saved values in Spanish` | `assertSchemaStateSet` shows plain strings for the translatable fields | Fill the form with raw attributes |
| 5 | `it rejects a phone that is not international` (dataset: `022000000`, `+593 2 abc 0000`, `+0 2 000 0000`) | `assertHasFormErrors(['data.phone_landline' …])` regex | Remove the phone regex |
| 6 | `it rejects a WhatsApp number that wa.me cannot use` (dataset: `+593990000000`, `099 000 0000`) | Regex error on `whatsapp_number` | Remove the WhatsApp regex |
| 7 | `it keeps a documented stat with its source and date` | A stat row round-trips per locale | Remove `stats` from the form |
| 8 | `it shows a saved change on the next read` | After save, `Settings::current()` (a fresh query) returns the new value | Guard rail (born green: no cache). Proven red by memoising `current()` in a static |

## 5. Implementation notes

- Form errors on a page with `statePath('data')` are keyed `data.<field>` in Livewire; Filament's `assertHasFormErrors` takes the bare field name. Check which one this version expects.
- Larastan with `--memory-limit=1G`.

## 6. Spec change log

- `2026-10-19` — draft created and approved by the agent (mode C). Decisions taken alone: the two number formats (§3.2), stats require source and date (§3.2), no cache (§3.3), page without a Blade view (§3.1).
