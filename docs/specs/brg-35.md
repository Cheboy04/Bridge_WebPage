# brg-35 (site) — Content entities: migrations, models, enums and factories

> **GitHub Issues:** `BRG-45` (local `brg-35`) · **Phase:** P2 · **Covers:** RF-02–RF-06, RF-08, RNF-06
> **Counterpart:** — (does not cross layers)
> **Status:** `[x]` draft · `[x]` approved · `[x]` implemented

Turns the issue's acceptance criteria (migrations run on MySQL; models declare `$fillable` and translatable attributes) into the schema of the approved ERD slice, plus the tests that prove each constraint and each model contract can fail.

## 1. Scope in this layer

**In:**

- Migrations for every table in [`docs/erd/modelo-contenido.md`](../erd/modelo-contenido.md) §3, one intent each (`nomenclatura.md` §7): `create_services_table`, `create_languages_table`, `create_language_service_table`, `create_faqs_table`, `create_posts_table`, `create_clients_table`, `create_testimonials_table`, `create_pages_table`, `add_role_to_users_table`.
- Models `Service`, `Language`, `Faq`, `Post`, `Client`, `Testimonial`, `Page` in `app/Models`, with explicit `$fillable` (§3.2), the translatable list (§3.2), the casts (§3.3) and the relations (§3.4).
- Enums `App\Enums\ServiceMode` (`Documento` = `documento`, `Cabina` = `cabina`) and `App\Enums\UserRole` (`Admin` = `admin`, `Editor` = `editor`).
- `User` gets the `role` cast. `role` is **not** added to `$fillable` (§3.5).
- One factory per new model, with invented Spanish data (D2.2, D6.4) and no image paths (all null).

**Out / deferred (with reason):**

- Query scopes (`Language::published()`, published services and posts) → P4, in the page stories that query them (HU-11–HU-15, HU-19). Nothing reads them in P2.
- Spanish enum labels (`getLabel()`) → P3, when Filament first shows them (HU-02, HU-03).
- Policies, `FilamentUser::canAccessPanel()`, how the first admin is created → HU-02 (P3).
- `LanguageSeeder` and `DatabaseSeeder` wiring → brg-37 / `BRG-47`.
- Settings and Lead → brg-36 / `BRG-46`, in their own ERD slice.
- "Migrations run on staging" (issue AC) → checked locally until brg-33 lands (phase-01 *Carry-over*).

## 2. Dependencies

- **GitHub Issues:** `BRG-44` (brg-34) closed; `BRG-42` (brg-32) merged, so CI proves the migrations on MySQL.
- **Data model:** `docs/erd/modelo-contenido.md`, approved by the owner 2026-10-19. It is the only source of columns, nullability, defaults and constraints. This spec doesn't repeat them.
- **Vetoes:** `CLAUDE.md` §5 lifts the veto for brg-35 (2026-10-19, P2 scope), now that its ERD slice is approved.
- **ADR (DECIDED):** D3.2, D3.5, D3.6 (with the 2026-10-19 slug-index note), D4.1, D4.2, D6.2, 6.3 (content slice), D6.4, D2.2.
- **OPEN items that don't block:** 3.4 (blog pagination) needs no column. Stamp (#6) and the others don't touch this schema.
- **External:** none.

## 3. Technical contract

### 3.1 Migrations

- Built with the schema builder: `id()`, `foreignId()->constrained()->cascadeOnDelete()` / `->nullOnDelete()`, `json()`, `boolean()->default(false)`, `unsignedInteger('sort')->default(0)`, `timestamps()`.
- The functional slug index (ERD I3) is raw DDL right after `Schema::create`, named `<table>_slug_es_unique`:
  `ALTER TABLE <table> ADD UNIQUE <table>_slug_es_unique ((CAST(slug->>'$.es' AS CHAR(255) CHARACTER SET utf8mb4)))`.
  `down()` drops the table, which drops the index with it.
- `language_service`: composite primary key (`language_id`, `service_id`), no `id`, no timestamps.
- `add_role_to_users_table`: `string('role')->default('editor')`; `down()` drops the column.

### 3.2 Models: fillable and translatable

Every model uses `HasFactory` (with the `@use HasFactory<…Factory>` generic, as `User` does). Translatable models also use `Spatie\Translatable\HasTranslations`.

| Model | `$fillable` | `$translatable` |
| --- | --- | --- |
| `Service` | title, slug, mode, summary, body, icon, image, turnaround, featured, sort, published, seo_title, seo_description | title, slug, summary, body, turnaround, seo_title, seo_description |
| `Language` | code, name, featured, sort, published | name |
| `Faq` | question, answer, service_id, sort | question, answer |
| `Post` | title, slug, excerpt, body, cover, published_at, seo_title, seo_description | title, slug, excerpt, body, seo_title, seo_description |
| `Client` | name, logo, url, sector, logo_permission, sort | sector |
| `Testimonial` | quote, person, role, company, client_id, published | quote, role |
| `Page` | title, slug, body, seo_title, seo_description | title, slug, body, seo_title, seo_description |

These lists are the ERD's columns minus `id` and timestamps. If the ERD changes, this table changes in the same PR.

### 3.3 Casts

| Model | Casts |
| --- | --- |
| `Service` | `mode` → `ServiceMode`, `featured` and `published` → `boolean` |
| `Language` | `featured`, `published` → `boolean` |
| `Post` | `published_at` → `datetime` |
| `Client` | `logo_permission` → `boolean` |
| `Testimonial` | `published` → `boolean` |
| `User` | adds `role` → `UserRole` |

### 3.4 Relations

| Model | Method | Type |
| --- | --- | --- |
| `Service` | `languages()` | `belongsToMany(Language)` (table `language_service`) |
| `Service` | `faqs()` | `hasMany(Faq)` |
| `Language` | `services()` | `belongsToMany(Service)` |
| `Faq` | `service()` | `belongsTo(Service)` |
| `Client` | `testimonials()` | `hasMany(Testimonial)` |
| `Testimonial` | `client()` | `belongsTo(Client)` |

Each method declares its return type with generics (`BelongsToMany<Language, $this>` etc.) for Larastan.

### 3.5 Role safety

`role` stays out of `User::$fillable`. A form that mass-assigns request input can then never promote a user to `admin`. Changing a role is an explicit assignment, wired in HU-02 (P3).

### 3.6 Factories

- `ServiceFactory`: Spanish title from Faker (`es_EC`, already pinned in `config/app.php`), `slug` = `Str::slug(title)` made unique, random `mode`, `published` true. States: `documento()`, `cabina()`.
- `LanguageFactory`: unique `code` from `fake()->unique()->languageCode()`, Spanish name.
- `FaqFactory`: global (`service_id` null) by default; state `forService(Service)`.
- `PostFactory`: unique slug, `published_at` in the past by default; state `draft()` (null).
- `ClientFactory`: `logo_permission` false by default (D4.1: permission is opt-in).
- `TestimonialFactory`: no client by default.
- `PageFactory`: unique slug.
- Translatable values are written as `['es' => …]`.

## 4. Acceptance criteria of this layer → tests

Runner: Pest. Real boundary (C4): MySQL 8.4, the local container and the CI service; never SQLite (lessons). All files use `RefreshDatabase`. Helpers reused: none exist yet (`CLAUDE.md` §7.5). Files go in `tests/Feature/Content/`.

| # | Test (file::case) | What it asserts | How we prove it FAILS (C3) |
| --- | --- | --- | --- |
| 1 | `SchemaTest::it creates the content tables with the ERD columns` (dataset keyed by table) | `Schema::hasColumns(table, [...])` for each of the 8 tables plus `users.role`, with the ERD's column list | Remove `turnaround` from the services migration → the `services` row fails |
| 2 | `SlugTest::it rejects a duplicate Spanish slug` (dataset: services, posts, pages) | A second row whose `slug.es` matches an existing one throws `UniqueConstraintViolationException` | Delete the raw index statement from the posts migration → the `posts` row passes the insert and the test fails |
| 3 | `SlugTest::it accepts the same slug under another locale` | A row with `slug = {es: x, en: y}` and another with `{es: z, en: y}` both persist | Index the whole `slug` value or the `en` key instead → second insert throws |
| 4 | `ConstraintTest::it rejects a duplicate language code` | A second `Language` with `code = en` throws `UniqueConstraintViolationException` | Remove `->unique()` from `code` |
| 5 | `ConstraintTest::it rejects a duplicate language-service pair` | Attaching the same language to a service twice (`attach`, not `sync`) throws | Replace the composite primary key with plain columns |
| 6 | `DeleteTest::it deletes a service's FAQs and language links with it` | After deleting a service: its FAQ is gone, a global FAQ remains, `language_service` has no rows for it, and the language still exists | `nullOnDelete()` on `faqs.service_id` → the FAQ survives as global, which is the failure the ERD Q3 names |
| 7 | `DeleteTest::it unlinks testimonials when their client is deleted` | After deleting a client, the testimonial exists with `client_id` null | `cascadeOnDelete()` on `testimonials.client_id` → the testimonial is gone |
| 8 | `ModelContractTest::it declares the ERD fillable columns` (dataset keyed by model) | `(new Model)->getFillable()` equals §3.2's list, in any order | Remove `turnaround` from `Service::$fillable` |
| 9 | `ModelContractTest::it declares the ERD translatable columns` (dataset keyed by model) | `(new Model)->getTranslatableAttributes()` equals §3.2's list | Remove `excerpt` from `Post::$translatable` |
| 10 | `ModelContractTest::it stores translatable text per locale` | A `Service` saved with `title = ['es' => 'Traducción certificada']` reads back as that string in `es`, and the raw column is the JSON `{"es": …}` | Drop `HasTranslations` from `Service` → the raw value isn't keyed by locale |
| 11 | `ModelContractTest::it rejects an unknown service mode` | Setting `mode = 'otro'` throws `ValueError` | Remove the `mode` cast → the value is stored |
| 12 | `RoleTest::it gives new users the editor role` | `User::factory()->create()->fresh()->role` is `UserRole::Editor` | Migration default `admin` → fails |
| 13 | `RoleTest::it does not mass-assign the role` | `User::create([... 'role' => 'admin'])` → `fresh()->role` is `UserRole::Editor` | Add `role` to `User::$fillable` |
| 14 | `RelationTest::it resolves every ERD relation` (dataset keyed by relation, §3.4) | Each relation returns the related record created through it | Point `Faq::service()` at the wrong foreign key → that row fails |
| 15 | `FactoryTest::it builds every content model from its factory` (dataset keyed by model) | `Model::factory()->create()` persists and refreshes with no exception, and translatable fields have an `es` value | Remove `body` from `PostFactory` → NOT NULL violation |

Tests 2, 4–7 repeat the ERD §8 probes in CI (R1–R4, A3–A4), which is where the ERD said they'd live.

## 5. Implementation notes

- Red first: write all 15 tests and see them fail for the right reason (missing table, class or column), not on a typo.
- Check the `spatie/laravel-translatable` 6.x API on context7 at implementation time (trait name, `$translatable` property, `getTranslatableAttributes()`), not from memory.
- Laravel's `where('slug->es', …)` doesn't use the functional index (ERD §8). Don't add a generated column to "fix" it. Lookups by slug are P4's concern.
- `UniqueConstraintViolationException` exists since Laravel 10; assert on it, not on the message text (D3.1 rule applied to tests).
- Larastan level 6: the relation generics in §3.4 and the factory generics keep it at 0 errors. Model `@property` blocks are not needed at level 6.
- Datasets keyed by a description (`nomenclatura.md` §8), e.g. `'services' => ['services', [...]]`.
- After a fresh clone, `php artisan migrate` on the local DB as before (HANDOFF_v4 §6.3); the tests use their own `RefreshDatabase`.

## 6. Spec change log

- `2026-10-19` — review with C3: **15 mutations, 15 killed**, each the one named in §4 and run with the test's filter, then restored from git. Two died by error, not assertion: #3 (index on `en`) threw the expected `1062 Duplicate entry 'same' for key services_slug_es_unique`; #10 (no `HasTranslations`) threw a `TypeError` saving the array title before the JSON assertion ran. Both are still red because of the mutation, so they count.
- `2026-10-19` — implemented: suite 57 green (124 assertions) on MySQL 8.4; Pint clean; Larastan level 6 **0 errors with `--memory-limit=1G`** (128M now runs out, so the CI step and `CLAUDE.md` §7.1 got the flag, as brg-32's spec §5 foresaw); Vite build ok. Unforeseen: a pipe operator (`|>`, PHP 8.5) slipped into a draft test and was rewritten, since production is PHP 8.3 (D2.1).
- `2026-10-19` — red: 48 new cases failed for the right reason (missing tables and `users.role`, missing models and enums); the 9 existing tests stayed green. Commit `c1d0fb1`.
- `2026-10-19` — approved by the owner (C1), including §3.5.
- `2026-10-19` — draft created from the approved ERD slice. Decisions carried from the ERD approval: functional slug index (Q1), no soft deletes (Q2), FAQ cascade (Q3), default `editor` (Q4). Added here: `role` stays out of `$fillable` (§3.5).
