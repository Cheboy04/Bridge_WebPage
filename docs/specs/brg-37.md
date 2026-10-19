# brg-37 (site) — Seeders: catalogue, Settings row and demo content

> **GitHub Issues:** `BRG-47` (local `brg-37`) · **Phase:** P2 · **Covers:** RNF-06
> **Counterpart:** — (does not cross layers)
> **Status:** `[x]` draft · `[x]` approved (agent, mode C, 2026-10-19) · `[x]` implemented

Turns the issue's acceptance criterion (`php artisan migrate:fresh --seed` builds a browsable dataset with no real client data) into four seeders and the tests that prove what they create, what they skip and what they never overwrite. The factories already exist (brg-35, brg-36).

## 1. Scope in this layer

**In:**

- `LanguageSeeder`: the 14 example languages of `prototype/src/assets/data/languages.json` (code, Spanish name, `featured`), published, with their `language_service` links. They are the prototype's **example** list (register #16, open); Bridge edits them in the admin.
- `ServiceSeeder`: the prototype's catalogue, published, by hub (register #15, open):

  | Slug (`es`) | Title (`es`) | Mode |
  | --- | --- | --- |
  | `certificada` | Traducción certificada | documento |
  | `legal` | Traducción legal | documento |
  | `notariada` | Traducción notariada | documento |
  | `escrita` | Traducción escrita | documento |
  | `simultanea` | Interpretación simultánea | cabina |
  | `consecutiva` | Interpretación consecutiva | cabina |
  | `equipos-y-cabinas` | Equipos y cabinas | cabina |

  Slugs follow the sitemap (`docs/ARCHITECTURE.md` §1). `summary`, `body` and `turnaround` stay null: the UI shows "[por confirmar]" (register #17).
- `SettingsSeeder`: `Settings::current()`, which creates the one empty row (ERD I11).
- `DemoContentSeeder`: invented content from the factories so the site and admin are browsable: 5 global FAQs, 2 FAQs per Documento service, 3 posts, 6 clients (no logo permission), 2 testimonials, the pages `privacidad` and `nosotros` with a "[Texto por confirmar con Bridge]" body, and the `test@example.com` user that `DatabaseSeeder` already creates.
- `DatabaseSeeder` calls them in that order.

**Rules:**

1. **The catalogue and Settings seeders never overwrite.** They create what's missing (by `code`, by `slug.es`, the single row) and leave existing rows alone, so a later run on staging or production can't undo Bridge's edits in the admin. Links are attached only when the language is created.
2. **Demo content never reaches production:** `DemoContentSeeder` returns at once when `app()->isProduction()`. Staging gets it (it's for demos).
3. **Demo content isn't duplicated:** it runs only when there are no posts yet.
4. **No real data** (D2.2): languages and services are the prototype's public examples; everything else is factory-invented; the Settings row is empty.

**Out / deferred (with reason):**

- The first admin user and roles → HU-02 (P3).
- Real catalogue, Settings values and page texts → Bridge, through the admin (register).
- Running seeders on deploy → brg-33 / D9.1 decide whether the release runs `db:seed --class=...` for the catalogue.

## 2. Dependencies

- **GitHub Issues:** `BRG-45`, `BRG-46` merged.
- **Data model:** both ERD slices (`docs/erd/`).
- **ADR (DECIDED):** D2.2, D6.4, D1.2.
- **OPEN items that don't block:** register #15, #16 (catalogue): the seeders create examples that Bridge edits.
- **External:** none.

## 3. Technical contract

- Seeders in `database/seeders/`, names per `nomenclatura.md` §3.
- `LanguageSeeder` holds the 14 rows as a PHP array (copied from `languages.json`, its source in a comment). Services link by `slug.es`, so `ServiceSeeder` runs first.
- Lookups by `slug.es` use `where('slug->es', …)` (the ERD §8 note: no index use needed at this size).
- `firstOrCreate` for languages (by `code`), for services (by `slug->es`), and `Settings::current()`.

## 4. Acceptance criteria of this layer → tests

Runner: Pest, MySQL (C4). File `tests/Feature/Seeders/SeederTest.php`, `RefreshDatabase`, seeding with `$this->seed()`.

| # | Test (file::case) | What it asserts | How we prove it FAILS (C3) |
| --- | --- | --- | --- |
| 1 | `it seeds the example languages with their services` | 14 languages; `en` featured and linked to `certificada`, `legal`, `notariada`; `qu` linked only to `certificada` | Drop `legal` from `en`'s links in the seeder |
| 2 | `it seeds the service catalogue by hub` | 7 services; 4 `documento`, 3 `cabina`; `simultanea` is `cabina` | Seed `simultanea` as `documento` |
| 3 | `it seeds one empty settings row` | One `settings` row; `contact_email`, `whatsapp_number`, `founding_year` null | Seeder sets an invented `contact_email` |
| 4 | `it keeps admin edits when seeding again` | Seed; rename `en` and unpublish `legal`; seed again → both edits survive, counts unchanged | `updateOrCreate` instead of `firstOrCreate` in `LanguageSeeder` |
| 5 | `it can seed twice without duplicating anything` | Row counts of every seeded table are equal after a second run | Remove the "no posts yet" guard → posts double |
| 6 | `it seeds a browsable demo dataset outside production` | Posts, global FAQs, FAQs on a Documento service, clients, pages `privacidad` and `nosotros`, the test user | `DatabaseSeeder` no longer calls `DemoContentSeeder` |
| 7 | `it keeps demo content out of production` | With the environment set to `production`: 0 posts, 0 clients, 0 users; 14 languages and 7 services still seeded | Remove the `isProduction()` guard |

The AC itself is also run once for real: `php artisan migrate:fresh --seed` against the local database, row counts in the PR.

## 5. Implementation notes

- In tests, switch the environment with `app()->detectEnvironment(fn () => 'production')` before `$this->seed()`.
- Keep `WithoutModelEvents` on `DatabaseSeeder` as generated.
- The test user moves from `DatabaseSeeder` into `DemoContentSeeder` (production gets no demo user) and uses `firstOrCreate` by email.

## 6. Spec change log

- `2026-10-19` — review with C3: **7 mutations, 7 killed**. #5 (no "no posts yet" guard) died by error: the second run hits the `pages` slug unique index creating `privacidad` again, which is the duplication the guard prevents.
- `2026-10-19` — implemented: suite 100 green (208 assertions); Pint clean; Larastan 0 errors; Vite build ok. AC run for real: `php artisan migrate:fresh --seed` on the local MySQL gave 14 languages, 7 services, 30 language links, 1 settings row, 13 FAQs, 3 posts, 6 clients, 2 testimonials, 2 pages, 1 user, 0 leads. Ping-pong on test 7: `db:seed` asks for confirmation in production, so the test runs `db:seed --force`, as a release would.
- `2026-10-19` — red: 7 cases (commit after the spec). Test 3 was born green on the first run, because `Settings::current()` creates the row itself; it now counts rows before reading.
- `2026-10-19` — draft created and approved by the agent (mode C). Decisions taken alone: never-overwrite rule (§1 rule 1), demo skipped only in production (rule 2), the prototype catalogue as seed data (§1).
