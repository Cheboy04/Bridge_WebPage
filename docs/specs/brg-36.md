# brg-36 (site) — Settings and Lead: migrations, models, enums and factories

> **GitHub Issues:** `BRG-46` (local `brg-36`) · **Phase:** P2 · **Covers:** RF-07, RF-09–RF-13, RNF-04, RNF-06
> **Counterpart:** — (does not cross layers)
> **Status:** `[x]` draft · `[x]` approved (agent, mode C, 2026-10-19) · `[x]` implemented

Turns the issue's acceptance criteria (the ERD slice approved; migrations run in CI; lead type and status use `LeadType` and `LeadStatus`) into the schema of [`docs/erd/modelo-leads-settings.md`](../erd/modelo-leads-settings.md), plus tests that prove each constraint and model contract can fail.

## 1. Scope in this layer

**In:**

- Migrations, one intent each: `create_settings_table`, `create_leads_table`, `create_language_lead_table`, `create_lead_attachments_table`.
- Models `Settings`, `Lead`, `LeadAttachment` with `$fillable`, translatable list, casts and relations (§3).
- Enums in `app/Enums`: `LeadType`, `LeadStatus`, `LeadNeed`, `EventModality`, `EventDuration` (values in the ERD §3.2 and `nomenclatura.md`).
- `Settings::current()`.
- Factories for the three models, invented data only (`example.test` emails, `+593 2 000 0000`-style numbers, the register's placeholders).

**Out / deferred (with reason):**

- Form validation, value ranges, the Spanish→English mapping of form values → P5, ADR 4.3 (OPEN). The schema is compatible with either outcome.
- File storage, signed downloads, the retention job and deleting files with their rows (ERD I15) → P5 (HU-25, HU-27, HU-28).
- `config('leads.attachments')` → P5, with the upload code that reads it.
- Filament resources, policies (ERD §3 authorization) → P3 (HU-09, HU-27 inbox).
- Seeding the Settings row → brg-37.
- Lead-row retention → Bridge (register #30).

## 2. Dependencies

- **GitHub Issues:** `BRG-45` (brg-35) merged: `services` and `languages` exist.
- **Data model:** `docs/erd/modelo-leads-settings.md`, approved 2026-10-19. The only source of columns and constraints.
- **Vetoes:** `CLAUDE.md` §5 lifts the veto for brg-36 (P2).
- **ADR (DECIDED):** D1.2 (mode C), D2.2, D3.2, D3.5, D3.6, D4.1, D4.2, 4.6, 6.3, D7.1, D8.5.
- **OPEN items that don't block:** 4.3 (validation, P5), 7 (attachment retention period, config in P5), mail provider (P5).
- **External:** none.

## 3. Technical contract

### 3.1 Migrations

- Schema builder as in brg-35. Raw DDL only for the two `CHECK`s, right after `Schema::create`:
  - `ALTER TABLE settings ADD CONSTRAINT settings_single_row CHECK (singleton = 1)`
  - `ALTER TABLE leads ADD CONSTRAINT leads_contact_channel CHECK (email IS NOT NULL OR phone IS NOT NULL)`
- `settings.singleton`: `boolean()->default(true)->unique()`.
- `leads`: `foreignId(...)->nullable()->constrained(...)->restrictOnDelete()` for `service_id`, `source_language_id`, `target_language_id` (the last two `constrained('languages')`); `timestamp('consent_at')` **not** nullable; `string('status')->default('new')`.
- `language_lead`: composite PK; `language_id` restrict, `lead_id` cascade.
- `lead_attachments`: `lead_id` cascade.

### 3.2 Models

| Model | `$fillable` | `$translatable` |
| --- | --- | --- |
| `Settings` | every ERD column except `id`, `singleton` and timestamps | whatsapp_default_message, office_hours, stats, ata_text, hero_hook |
| `Lead` | every ERD column except `id` and timestamps | — (I12) |
| `LeadAttachment` | path, original_name, mime_type, size | — |

`singleton` is not fillable: nothing but the default should ever write it.

`Lead.status` and `Lead.notes` **are** fillable, unlike `User.role` (brg-35 §3.5): the inbox edits them in Filament (P3), and the public forms in P5 only pass validated fields. Neither grants a privilege.

### 3.3 Casts

| Model | Casts |
| --- | --- |
| `Settings` | `socials` → `array`, `founding_year` → `integer` |
| `Lead` | `type` → `LeadType`, `status` → `LeadStatus`, `modality` → `EventModality`, `duration` → `EventDuration`, `needs` → `AsEnumCollection::of(LeadNeed::class)`, `deadline`/`event_date`/`event_end_date` → `date`, `consent_at` → `datetime`, `days`/`language_count`/`attendees` → `integer` |
| `LeadAttachment` | `size` → `integer` |

### 3.4 Relations

| Model | Method | Type |
| --- | --- | --- |
| `Lead` | `service()` | `belongsTo(Service)` |
| `Lead` | `sourceLanguage()` | `belongsTo(Language, 'source_language_id')` |
| `Lead` | `targetLanguage()` | `belongsTo(Language, 'target_language_id')` |
| `Lead` | `languages()` | `belongsToMany(Language)` (table `language_lead`) |
| `Lead` | `attachments()` | `hasMany(LeadAttachment)` |
| `LeadAttachment` | `lead()` | `belongsTo(Lead)` |

No inverse relations on `Service` or `Language` yet: nothing reads them until the inbox (P3).

### 3.5 `Settings::current()`

`public static function current(): self` returns the single row, creating the empty one if none exists (`firstOrCreate([])`). Every reader uses it; nothing calls `create()` directly.

### 3.6 Factories

- `SettingsFactory`: invented values only: `contacto@bridge.example.test`-style emails, `+593 2 000 0000`-style numbers, `founding_year` null (register #8 unanswered).
- `LeadFactory`: `contact` type with an email and `consent_at = now()` by default; states `translation()` (service, language pair, `needs`, `deadline`) and `interpreting()` (service, event fields, `needs`).
- `LeadAttachmentFactory`: `path` under `leads/{lead}/`, `application/pdf`, a plausible size. No file is written (that's P5).

## 4. Acceptance criteria of this layer → tests

Runner: Pest. Real boundary (C4): MySQL 8.4, locally and in CI. `RefreshDatabase` in every file. Files in `tests/Feature/Leads/` (lead and attachment) and `tests/Feature/Settings/`. Reused: the brg-35 patterns (datasets keyed by name, `UniqueConstraintViolationException`).

| # | Test (file::case) | What it asserts | How we prove it FAILS (C3) |
| --- | --- | --- | --- |
| 1 | `Leads/SchemaTest::it creates the lead and settings tables with the ERD columns` (dataset by table) | `Schema::hasColumns` for the 4 tables | Drop `attendees` from the leads migration |
| 2 | `Settings/SettingsTest::it rejects a second settings row` | Second insert throws `UniqueConstraintViolationException` | Remove `->unique()` from `singleton` |
| 3 | `Settings/SettingsTest::it rejects a singleton other than one` | Insert with `singleton = 0` throws `QueryException` (check violation) | Remove the `settings_single_row` statement |
| 4 | `Settings/SettingsTest::it returns the same row from current` | Two `current()` calls return the same `id`; one row in the table | `current()` uses `create([])` → the second call throws |
| 5 | `Leads/ConstraintTest::it rejects a lead with no email or phone` | Insert throws `QueryException` | Remove the `leads_contact_channel` statement |
| 6 | `Leads/ConstraintTest::it accepts a lead with only a phone` | Insert succeeds | Write the CHECK with `AND` instead of `OR` |
| 7 | `Leads/ConstraintTest::it rejects a lead without consent` | Insert without `consent_at` throws `QueryException` | Make `consent_at` nullable |
| 8 | `Leads/ConstraintTest::it keeps a service that a lead references` | Deleting the service throws `QueryException`; service and lead remain | `nullOnDelete()` on `service_id` |
| 9 | `Leads/ConstraintTest::it keeps a language that a lead references` (dataset: source, target, interpreting pivot) | Deleting the language throws | `nullOnDelete()` on `target_language_id` → the `target` row fails |
| 10 | `Leads/ConstraintTest::it deletes attachment rows and language links with the lead` | After deleting the lead: 0 attachment rows, 0 pivot rows, languages remain | `restrictOnDelete()` on `lead_attachments.lead_id` |
| 11 | `Leads/LeadModelTest::it starts new leads as new` | `Lead::factory()->create()->fresh()->status` is `LeadStatus::New` | Migration default `contacted` |
| 12 | `Leads/LeadModelTest::it declares the ERD fillable columns` (dataset: Settings, Lead, LeadAttachment) | `getFillable()` equals §3.2 | Add `singleton` to `Settings::$fillable` |
| 13 | `Settings/SettingsTest::it declares the ERD translatable columns` | `getTranslatableAttributes()` equals §3.2 | Remove `hero_hook` |
| 14 | `Leads/LeadModelTest::it casts needs to LeadNeed values` | Saved `['notarization', 'apostille']` reads back as a collection of `LeadNeed` cases | Remove the `needs` cast |
| 15 | `Leads/LeadModelTest::it rejects unknown enum values` (dataset: type, status, modality, duration) | `setAttribute(column, 'otro')` throws `ValueError` | Remove the `modality` cast → that row fails |
| 16 | `Leads/LeadModelTest::it resolves every ERD relation` (dataset, §3.4) | Each relation returns the related record | `targetLanguage()` pointed at `source_language_id` → the `targetLanguage` row fails. (Dropping the key wouldn't do: Laravel infers `target_language_id` from the method name, so that mutation can't kill the test.) |
| 17 | `Leads/LeadModelTest::it builds every model from its factory` (dataset: Settings, Lead contact/translation/interpreting, LeadAttachment) | `create()->fresh()` succeeds | Remove `consent_at` from `LeadFactory` |

## 5. Implementation notes

- Red first, committed (C2).
- Laravel turns a MySQL `CHECK` violation (3819) into a plain `QueryException`; assert the class, not the message (D3.1 rule).
- `AsEnumCollection::of()` exists since Laravel 11; check the import path at implementation time.
- The model is `Settings` (plural, the dictionary's name); its table resolves to `settings` by convention. Check `(new Settings)->getTable()` once rather than assuming.
- Larastan with `--memory-limit=1G` (brg-35).

## 6. Spec change log

- `2026-10-19` — review with C3: **17 mutations, 17 killed**, each the one in §4, filtered to its test and restored from git. Dataset tests failed only on the targeted row (`target`, `modality`, `targetLanguage`, `Settings`). Four died by error, not assertion, because the database or Laravel refused the write the mutation enabled: #4 (`create([])` hits the singleton unique), #6 (`AND` rejects a phone-only lead), #10 (restrict refuses the lead delete), #14 (no cast can't save the array).
- `2026-10-19` — implemented: suite 93 green (179 assertions); Pint clean; Larastan 0 errors; Vite build ok. Ping-pong on tests 2–3: `DB::table()->insert([])` runs **no SQL** in Laravel (an empty insert returns `true`), so the tests insert an explicit null column. The tests still assert the same behaviour.
- `2026-10-19` — red: 36 cases failing on missing tables, models and enums (commit `f1b01df`). Test 3 was born green on the first run, because inserting into a missing table also throws `QueryException`; it now also asserts that a valid insert succeeds.
- `2026-10-19` — draft created and approved by the agent (mode C). Decisions taken alone: §3.2 (`status` and `notes` fillable, `singleton` not), §3.4 (no inverse relations yet).
