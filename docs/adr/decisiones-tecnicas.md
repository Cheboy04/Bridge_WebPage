# Bridge Traducciones (website) — Technical Decision Record (ADR)

**Project:** Bridge Traducciones (website): the public site and content CMS for Bridge Traducciones (Quito), a certified-translation and conference-interpreting company.
**Team:** the owner (GitHub `@Cheboy04`) as PO and developer, plus agents (Opus plans, writes specs and reviews; Sonnet builds; Haiku does mechanical work). The Bridge team supplies content and approves claims.
**Product Owner:** the owner (`@Cheboy04`).
**Last updated:** 2026-10-16 (session close: 3.2 and 3.5 decided; board loaded)

**Status legend:**
`DECIDED` closed decision · `OPEN` needs a definition · `PENDING` depends on another block · `PARTIAL` decided, but parts depend on a point that is still open

How this document works:
- Each block opens with a summary table (`# | Point | Status | Decision`). Points that need detail get a `### Dx.y — Title (YYYY-MM-DD)` entry below it.
- A decision is never rewritten. It is **extended** with a dated note (`> **Extension of YYYY-MM-DD (BRG-n):** …`) or marked **SUPERSEDED** with a link to the decision that replaces it.
- An OPEN point blocks only the work that touches it (methodology §8).
- Decisions 1–18 of `docs/global/handoffs/HANDOFF_v1.md` §3 were migrated here on 2026-10-16. The handoff keeps them only as history.

---

## 1. Process and team

| #   | Point                            | Status  | Decision |
| --- | -------------------------------- | ------- | -------- |
| 1.1 | Cadence                          | DECIDED | Phase-based, no fixed sprints. See D1.1. |
| 1.2 | Roles                            | DECIDED | Owner = PO + dev. Agents per D1.2. Bridge = content owner and approver of claims. |
| 1.3 | Ceremonies                       | DECIDED | One phase review at the end of each phase (D1.1). No other ceremonies. |
| 1.4 | Reporting to stakeholders        | OPEN    | Today: private claude.ai artifacts shared with Bridge (prototype, logo sheet). Not formalised. |
| 1.5 | Anchor story (estimation)        | OPEN    | No story-point estimation agreed. Low priority under phase-based work. |
| 1.6 | Definition of Ready              | PARTIAL | See below. |
| 1.7 | Agent/human roles mode           | DECIDED | Mode **C** since 2026-10-19: the agent runs the whole cycle and git up to the PR; the owner merges. See D1.2. |

**Definition of Done (current):** merged into `develop` through a PR with CI green; tests passing and each non-trivial test proven red (C3); the story's acceptance criteria met; applicable RNF verified with their instrument (block 11); public UI at visual parity with the prototype (D3.8); accepted at the phase review.

**Definition of Ready:** story format; verifiable acceptance criteria in GitHub Issues; no OPEN dependency in this ADR (or compatible with every outcome, methodology §8); entities already in the ERD slice; screen already designed (the prototype and the brand book cover every MVP page); measurement instrument defined if the story evidences an RNF. **Partial because** there is no estimation anchor (1.5), so "estimated against the anchor" doesn't apply yet.

### D1.1 — Phase-based delivery (2026-10-16)

The project runs eight phases in dependency order instead of sprints: **P0 Lock → P1 Skeleton → P2 Data → P3 Admin → P4 Public site → P5 Leads → P6 Hardening → P7 Ship**. A phase has no fixed length. It closes when its stories meet the DoD and the owner approves it at the phase review. The sequence, contents and gates live in `docs/backlog/roadmap.md`.

Why: a single part-time developer with agents. A calendar cadence adds ceremony without adding control. The phase gate is where the owner approves.
→ *Quality attribute: maintainability (modularity of delivery).*

### D1.2 — Roles mode C, agent-run cycle, owner merges (2026-10-19)

**Replaces mode B** (2026-10-16: owner approved every spec and ran every git write), by the owner's decision on 2026-10-19.

- The agent runs the whole SDD/TDD cycle **without approval gates**: it writes and approves its own specs and ERD slices, writes the red tests, implements, reviews with C3, and records the evidence.
- The agent runs git and `gh` up to the PR: branches, commits, pushes to its own branches, opens PRs, comments on and closes issues. Rules: `docs/global/reglas-git.md`.
- The **owner merges** every PR into `develop` and `main`. A merge is the review point; the agent asks for it with the PR link.
- **Stays with the owner:** decisions that need business input, money, accounts or Bridge's data (e.g. ADR 7 retention, 10 domain and mail provider, the stamp); infrastructure (`CLAUDE.md` §0.6); repo settings. Technical OPEN points the agent may decide itself, recording the rationale in the ADR and flagging it in the PR.

Why mode C: the owner wants speed and trusts the gates. The counterweight to removing approvals is **visible evidence** in the history and the PR: the spec commit precedes the test commit (C1), the red is committed (C2), and the C3 mutation table is in the spec's log and the PR body.

Agents: Opus plans, writes specs, integrates and reviews visually. Sonnet workers build in parallel with **strict file ownership**. Haiku does mechanical work (captures, renames, bulk checks).

Mode B (2026-10-16 → 2026-10-19) lives on in the git history and HANDOFF_v1–v4.

---

## 2. Repository, branches and conventions

| #   | Point               | Status  | Decision |
| --- | ------------------- | ------- | -------- |
| 2.1 | Topology            | DECIDED | `solo-backend` variant: one Laravel monolith in `site/`. See D2.3. |
| 2.2 | Visibility          | DECIDED | **Public**, with compensating controls. See D2.2. |
| 2.3 | Branch model        | DECIDED | `feature/*` → `develop` (staging) → `main` (production). Rules: `docs/global/reglas-git.md`. |
| 2.4 | Stack versions      | DECIDED | Pinned by the lockfiles in `site/` (brg-31, 2026-10-16). See D2.1. |
| 2.5 | Tracker             | DECIDED | GitHub Issues + Projects on `Cheboy04/Bridge_WebPage`, prefix `BRG`. See D2.4. |
| 2.6 | Languages           | DECIDED | Docs English · code English · UI Spanish (i18n-ready, D3.6). |

### D2.1 — Pinned stack versions, linters and analysers (2026-10-16)

| Component | Version | Where it is pinned | Note |
| --- | --- | --- | --- |
| PHP | 8.3 (selected in hPanel) | hPanel; `composer.json` `require.php` `^8.3` and `config.platform.php` `8.3.0` | Filament 5 needs ≥ 8.2. The platform pin makes the lockfile resolve for 8.3 even on a newer local CLI. |
| Laravel | 12.70.0 | `site/composer.lock` | Filament 5 needs ≥ 11.28. |
| Filament | 5.10.2 | `site/composer.lock` | Install steps verified on context7 on 2026-10-16. |
| Livewire | 4.4.7 | `site/composer.lock` | Pulled in by Filament; not chosen separately. |
| Tailwind CSS | 4.3.3 (with `@tailwindcss/vite` 4.3.3, Vite 7.3.7, `laravel-vite-plugin` 2.1.0) | `site/package-lock.json` | Filament 5 needs ≥ 4.1. |
| MySQL | the version Hostinger provides | hPanel | **Not verified yet** (P7 hosting checks). Local tests run on MySQL 8.4 (throwaway container). |
| Pest · Larastan · Pint | Pest 3.8.7 · Larastan 3.13.0 · Pint 1.32.1 | `site/composer.lock` | Larastan **level 6** over `app`, `bootstrap/app.php`, `config`, `database`, `routes` (`site/phpstan.neon`). Tests are left out because Pest closures bind `$this` at runtime. Level 7+ flags only the skeleton's `config/filesystems.php`; raise the level once it's fixed. |
| `spatie/laravel-translatable`, `spatie/laravel-sitemap` | 6.14.1 · 8.0.0 | `site/composer.lock` | The only extra packages (D3.7). |

Versions recorded on 2026-10-16 when brg-31 installed them. The lockfiles stay the real pin; this table is updated when a lockfile changes a major or minor.

### D2.2 — Public repository with compensating controls (2026-10-16)

The repo `Cheboy04/Bridge_WebPage` is public. Controls that compensate:
- `.env` is always git-ignored; `site/.env.example` is versioned with no real values.
- No real client data (people, phones, addresses, documents, leads) in code, seeds, fixtures, tests, the tracker or the history. Seeds use invented data.
- `.gitignore` keeps out client raw material (`Design_references/`), research captures (`audit/screens/`, `audit/reference/`, `audit/sites-*.json`, `audit/directions.html`) and anything with real contact data.
- The booth photo in `prototype/src/assets/photo/cabina-*.webp` shows identifiable interpreters. **Bridge holds their consent** (confirmed by the owner on 2026-10-16). The consent record lives with Bridge, not in this repo.
- Before every PR, the diff is reviewed for secrets and real data (git rules §6). GitHub secret scanning stays on.

Why public: owner's choice. Revisit if the repo ever needs real client material.

### D2.3 — Laravel monolith in `site/`; headless rejected for now (2026-10-16)

One Laravel 12 application serves the public site (Blade) and the admin (Filament 5 at `/admin`). It shares models, validation and the deploy. The Laravel app lives in `site/`, beside `brand/`, `prototype/` and `docs/`. CI uses `working-directory: site`.

**Headless rejected (alternative considered on 2026-10-16):** a Laravel API plus a separate front end.
- An SSR front end (Next/Nuxt) needs a Node process, which Hostinger Business doesn't usefully offer (D9.1).
- A static front end built in CI (e.g. Astro) fits the host, but every CMS edit would need a webhook and a rebuild before it goes live. It would also mean two deploys, an API contract, duplicated i18n routing, sitemap and SEO, and cross-origin forms with uploads.
- The front end is plain HTML, CSS and vanilla JS, which Blade outputs unchanged. Headless would buy no freedom here.

**Reopen if:** a second client app (mobile, partner portal) needs the content, or the public site needs a JS framework that Blade can't host. The escape hatch: content lives in Eloquent models, so adding `/api` resources later doesn't require a rewrite.
→ *Principle: KISS / YAGNI. Quality attribute: maintainability, deployability.*

### D2.4 — GitHub Issues as tracker (2026-10-16)

Stories, tasks and acceptance criteria live in GitHub Issues on `Cheboy04/Bridge_WebPage`, with a GitHub Project board for status.

> **Extension of 2026-10-16:** the backlog was loaded as batch `initial`: 54 issues, `BRG-4` to `BRG-57` (#1–#3 are pull requests). An issue is referred to as `BRG-<n>`, where `<n>` is the issue number. Branches and commits use that form (git rules §3). Mapping of the local backlog to issues: `docs/backlog/anexo-github/README.md`. Real keys: `docs/backlog/key-map.md`.

---

## 3. General architecture

| #   | Point                      | Status  | Decision |
| --- | -------------------------- | ------- | -------- |
| 3.1 | Error format               | DECIDED | No public JSON API. Validation errors and error pages per D3.1. |
| 3.2 | Time zone and dates        | DECIDED | Store UTC, display `America/Guayaquil`. See D3.2. |
| 3.3 | API versioning             | DECIDED | Not applicable: no public API (D2.3). |
| 3.4 | Pagination and filters     | OPEN    | Blog listing only. Decide in P4. |
| 3.5 | Primary key type           | DECIDED | Laravel's default auto-increment `bigint` `id`. See D3.5. |
| 3.6 | i18n                       | DECIDED | Spanish-only MVP, ready for more locales. See D3.6. |
| 3.7 | Public front end           | DECIDED | Blade + Tailwind 4, Livewire for forms, Alpine for small UI, vanilla JS for signature components. See D3.7. |
| 3.8 | Design system and "locked" | DECIDED | Three layers: design, behavior, code. The prototype is the reference implementation. See D3.8. |
| 3.9 | Deliberately deferred      | DECIDED | See D3.9. |

### D3.1 — Error handling for a server-rendered site (2026-10-16)

There is no public JSON API, so there is no Problem Details catalogue.
- **Form validation:** Laravel/Livewire validation errors render as an **error summary** at the top of the form (it receives focus on submit) plus inline messages linked by `aria-describedby`. This is the contract the prototype's quote forms already ship (`prototype/src/assets/js/quote-form.js`).
- **Validation messages are in Spanish** via `lang/es/validation.php`. Logic branches on the field and rule, never on the message text.
- **Error pages:** custom Spanish Blade views for 404, 419, 429 and 500, in Documento mode.
- **Debug:** `APP_DEBUG=false` on staging and production.

### D3.2 — Time zone (2026-10-16, brg-34)

Decided by the owner on 2026-10-16 (the proposal below, approved as written): persist in UTC (`config('app.timezone') = 'UTC'`), display in `America/Guayaquil` (UTC−5, no DST), and serialise ISO 8601 with offset in any machine output (sitemap, JSON-LD). Event dates in the interpreting quote form are local calendar dates, stored as `date` columns with no time zone.

Owner re-confirmed on 2026-10-16, after merging brg-31, that the earlier wording ("UTC storage should be America/Guayaquil") meant exactly this: store UTC, display `America/Guayaquil`.

### D3.5 — Primary keys (2026-10-16, brg-34)

Every table uses Laravel's default auto-increment unsigned `bigint` `id`, and foreign keys use `foreignId()`. No UUIDs or ULIDs: nothing exposes ids publicly in a way that needs them, and public URLs use slugs (D3.6).
→ *Principle: KISS. Quality attribute: maintainability.*

### D3.6 — Multilingual readiness, MVP = `es` (2026-10-15)

- Every user-facing text column (titles, bodies, slugs, SEO fields) is a translatable JSON column through `spatie/laravel-translatable` from day one. Only `es` is filled at launch. Adding a locale is a data task, not a migration, **except** one unique-index migration per sluggable table (services, posts, pages), because public slugs are unique per locale in the database (owner, 2026-10-19; `docs/erd/modelo-contenido.md` I3).
- Spanish URLs live at the root with no prefix (`/traduccion/certificada`). Future locales get a prefix (`/en/...`). Spanish URLs never change.
- Interface strings go through `__()` in `lang/es/*.php`. No hard-coded Spanish in Blade.
- `<html lang>`, `hreflang` and sitemap alternates come from `config('site.locales')`. With one locale, no hreflang is printed.
- The header picks the logo descriptor by locale (`brand/logo/lockup/`, 7 languages).

Why: local clients search in Spanish (owner's choice after first saying "English MVP"), but the business name works in many languages.
→ *Quality attribute: maintainability (modifiability).*

### D3.7 — Public front end (2026-10-15)

- **Blade components** mirror the prototype's include partials (`prototype/src/components/*.html`). Partial params become Blade props (the contracts are written in P0).
- **Tailwind 4:** brand tokens live in one CSS file as `@theme` variables, shared by the site and the Filament theme. The token source of truth is the brand book (D3.8).
- **Livewire** only for forms and file upload. **Alpine** for small UI (menu, WhatsApp button, accordions). **Signature components** stay vanilla JS. **No animation libraries.** Every component is complete at rest and has a reduced-motion fallback (`brand/SIGNATURE-COMPONENTS.md`).
- **Packages kept minimal:** `spatie/laravel-translatable` and `spatie/laravel-sitemap`. Anything else needs a new ADR entry.
- **Fonts:** Literata (display h1–h3) and Manrope (the rest), self-hosted WOFF2, Latin + Latin Extended at launch. Fraunces is rejected because it lacks Cyrillic and Greek (`brand/DIRECTION.md` §3).

### D3.8 — Design system and what "locked" means (2026-10-16)

A component is **locked** when it has all three layers:
1. **Design:** tokens plus component anatomy and states, in the brand book (a claude.ai artifact of the "Design System" type).
2. **Behavior:** exact timings, easing, a11y and rules, in `brand/SIGNATURE-COMPONENTS.md`.
3. **Code:** a component contract (params → Blade props, data source, events and query params).

Owners: `brand/DIRECTION.md` owns the brand system (modes, palette, contrast, type, shape, voice, motion). `brand/logo/LOGO.md` owns logo usage. The prototype (`prototype/`) is the **reference implementation**. Production Blade is written once, in Laravel, at visual parity with it.

Brand decisions migrated from HANDOFF_v1 (owner documents, not repeated here): direction "Puente" with Documento and Cabina modes (#1); logo M1 + M5 (#2); naming with a localised descriptor (#4); palette and contrast rules (#5); type (#6); voice (#7, hero hook **accepted by default**, to be confirmed by Bridge); "less square" shape (#8); six signature components (#9); footer outline wordmark (#10). The certification stamp (#3) is OPEN (see the summary).

### D3.9 — Deliberately deferred (2026-10-15)

| Deferred | Add when |
| --- | --- |
| Filament translatable plugin (admin locale switcher) | The second locale is added. Check Filament 5 compatibility then. |
| Media library package / responsive image sets | Image performance becomes a measured problem. |
| Page builder (Filament Builder blocks) | Bridge needs to compose landing pages without a developer. |
| Permission package (e.g. Shield) | More than two roles are needed. |
| Blog categories and tags | More than about 20 posts. |
| Online payment / price calculator | Bridge publishes fixed prices. |
| Cloudflare Turnstile | Spam actually appears. |
| Headless front end | The reopen condition of D2.3 is met. |

---

## 4. Server layer

| #   | Point                       | Status  | Decision |
| --- | --------------------------- | ------- | -------- |
| 4.1 | Content model               | DECIDED | Filament resources per D4.1. Columns are fixed in the ERD (P2). |
| 4.2 | Admin roles                 | DECIDED | Two roles, `admin` and `editor`, via a `role` column + policies. See D4.2. |
| 4.3 | Input validation            | OPEN    | Livewire rules vs Form Request objects for the three lead forms. Decide in P5. |
| 4.4 | Test framework              | DECIDED | Pest (11.1). |
| 4.5 | Admin auth                  | DECIDED | Filament's built-in session login. No external identity provider. |
| 4.6 | Settings storage            | DECIDED | One `Settings` row, editable in Filament (D4.1). |

### D4.1 — Content model (2026-10-15)

| Model | Purpose |
| --- | --- |
| `Service` | Drives the hubs, nav and quote-form options. Its `mode` (documento/cabina) sets both the URL prefix and the visual mode. |
| `Language` | The "Idiomas que trabajamos" list and quote-form selects. |
| `Post` | The blog. |
| `Client` | Client logos, shown publicly **only** when `logo_permission` is true. |
| `Testimonial` | Optional for the MVP; the schema is cheap. |
| `Faq` | Global (`service_id` null) or per service. |
| `Page` | Simple pages (privacy, about body). |
| `Lead` | The inbound inbox: type, contact fields, request fields, files, `consent_at`, status (`LeadStatus`, shown as nuevo/contactado/cotizado/ganado/perdido; stored values per `docs/nomenclatura.md` §1), notes. |
| `Settings` | Single row: phones, emails, WhatsApp number and default message, address, socials, founding year, verified stats, ATA text, hero copy. Placeholders get swapped without a deploy. |

Field lists are a draft in `docs/ARCHITECTURE.md` §2. The ERD (`docs/erd/`) becomes the owner of columns and constraints when its P2 slices are approved.

### D4.2 — Admin roles (2026-10-15)

`admin` (the owner) can do everything. `editor` (the Bridge team) manages content and leads, but not Settings or users. This is a `role` column plus Laravel policies, with no permission package (D3.9).

---

## 6. Database

| #   | Point                    | Status  | Decision |
| --- | ------------------------ | ------- | -------- |
| 6.1 | Engine                   | DECIDED | MySQL, included with Hostinger. CI runs against MySQL too (lessons: same engine as production). |
| 6.2 | Naming conventions       | DECIDED | Laravel conventions: plural `snake_case` tables, `snake_case` columns, `<model>_id` foreign keys. Translatable columns are JSON. |
| 6.3 | Index strategy           | OPEN    | Decided per ERD slice in P2. **Content slice decided 2026-10-19:** FK indexes and business uniques only, slugs unique per locale through a functional index (`docs/erd/modelo-contenido.md` §6). Settings and Lead slice pending (brg-36). |
| 6.4 | Seeders and factories    | DECIDED | Invented data only (D2.2). A `LanguageSeeder` may seed the real public language list. |
| 6.5 | Backups                  | DECIDED | Hostinger daily backups, plus a weekly `mysqldump` and private uploads copied off-server. See D9.1. |

### ERD status — PARTIAL

- **Content slice** (`docs/erd/modelo-contenido.md`, brg-35): **approved by the owner 2026-10-19**, with no soft deletes, FAQs cascading with their service, and new users defaulting to `editor`.
- **Settings and Lead slice** (brg-36): not written yet. Its draft is still D4.1 and `docs/ARCHITECTURE.md` §2.

---

## 7. File storage

### D7.1 — Lead attachments (2026-10-15)

- Accepted types: PDF, JPG, PNG, DOCX. At most 20 MB per file and 5 files per lead (translation quote form only).
- Stored on a **private disk** (`storage/app/private`), never `public/`. Downloadable only from Filament through a signed, time-limited URL.
- **Never attached to emails.** The notification email links to the lead in Filament.
- **Automatic deletion** by a daily scheduled job, **90 days** after the lead is created. The period is OPEN until Bridge confirms it (summary #2). It must be stated in `/privacidad`.

Why: clients upload IDs, deeds and court documents. Ecuador's LOPDP applies.
→ *Quality attribute: security (confidentiality).*

---

## 8. Security and access

| #   | Point                                     | Status  | Decision |
| --- | ----------------------------------------- | ------- | -------- |
| 8.1 | Permission matrix (role × resource × action) | PARTIAL | Roles decided (D4.2). The full matrix is written with the P3 admin stories. |
| 8.2 | Identity provider                         | DECIDED | None external. Filament login (4.5). |
| 8.3 | CORS                                      | DECIDED | Not applicable: same-origin monolith. |
| 8.4 | Rate limiting and spam                    | DECIDED | Per-IP rate limit on every form, plus a honeypot field. Turnstile is deferred (D3.9). |
| 8.5 | Privacy (LOPDP)                           | DECIDED | See D8.5. Legal text supplied by Bridge. |
| 8.6 | Analytics                                 | DECIDED | GA4 loads **only** after cookie consent. The WhatsApp link sets no cookies. |

### D8.5 — Personal data (2026-10-15)

- Store only the fields and files needed to quote. IPs are used for rate limiting and are **not** saved on the lead.
- Every form has an explicit privacy-consent checkbox, stored as `consent_at`.
- `/privacidad` states the controller, the purpose, the retention period (D7.1) and how to request deletion. We provide a template; Bridge provides the legal text.

---

## 9. CI/CD, environments and observability

| #   | Point                        | Status  | Decision |
| --- | ---------------------------- | ------- | -------- |
| 9.1 | CI pipeline and deploy       | DECIDED | Option A: CI builds the release and uploads it over SSH, then swaps a symlink. See D9.1. |
| 9.2 | Migrations on deploy         | DECIDED | Automatic: `php artisan migrate --force` after the symlink swap (D9.1). |
| 9.3 | Observability (errors, uptime) | OPEN  | Decide in P6. |
| 9.4 | Rollback                     | PARTIAL | Code: point the symlink back to the previous release. Database: OPEN, define **before** P7. |
| 9.5 | Queue and scheduler          | DECIDED | Database queue driven by cron (D9.1). |
| 9.6 | Environments                 | DECIDED | Staging on a subdomain first (deployed from `develop`), then production (deployed from `main`). |

### D9.1 — Hosting and deploy on Hostinger Business (2026-10-16)

**Host:** Hostinger Business (shared). Researched on 2026-10-16:
- SSH is restricted (no root).
- hPanel's Git auto-deploy **only pulls code**. It doesn't run Composer, the build or migrations.
- `npm` **can't run** over SSH. The plan's Node.js apps feature is irrelevant to us.
- Approximate limits: 2 CPU, 3 GB RAM, 600k inodes, 360 s PHP execution. These are **to be verified in hPanel** (summary #3).

**Deploy, option A (GitHub Actions):**
1. Run the tests and quality chain.
2. `composer install --no-dev --optimize-autoloader` and `npm ci && npm run build` (Vite) in CI.
3. Upload the release folder over SSH into `releases/<timestamp>/`, with shared `storage/` and `.env` linked in.
4. Swap the `current` symlink. The document root points at `current/public`.
5. Run `php artisan migrate --force` and `php artisan optimize`.

The server **never** runs `git pull` or `npm`.

**Scheduler:** one hPanel cron entry, `* * * * * <php-path> artisan schedule:run`. The schedule runs `queue:work --stop-when-empty` every minute and the attachment cleanup (D7.1) daily. Form emails may arrive up to about a minute late; that is accepted. The exact PHP path and the minimum cron interval are verified in P7.

**Backups:** Hostinger daily backups, plus a weekly `mysqldump` and private uploads copied off-server.

**Known ceiling:** no persistent queue worker and limited CPU. If traffic or features grow, move to a Hostinger VPS: the app doesn't change, and the cron is replaced by a supervisor process.

Alternatives rejected: hPanel Git auto-deploy (no build step), and building on the server (no `npm`).
→ *Quality attribute: deployability, recoverability.*

---

## 10. External accounts, by lead time

All configured by the owner; the agent records them as dependencies and stops (`CLAUDE.md` §0.6).

1. **Canonical domain:** `bridgetraducciones.com` vs `bridge-traducciones.com` (OPEN, summary #4). DNS changes are slow, so decide first.
2. **Hostinger:** enable SSH, select PHP 8.3, create the MySQL database, create the staging subdomain, create the cron entry (P7).
3. **GitHub:** deploy key and Actions secrets (SSH host, user, key, paths); branch protection (rulesets) on `main` and `develop`.
4. **Mail:** Hostinger mailbox SMTP or a transactional provider (OPEN, summary #7).
5. **Google GA4:** property and measurement ID (P6).
6. **WhatsApp:** the business number (placeholder register).

---

## 11. Testing and RNF evidence

| #    | Point                          | Status  | Decision |
| ---- | ------------------------------ | ------- | -------- |
| 11.1 | Test frameworks                | DECIDED | Pest (unit + feature), Larastan, Pint. CI against MySQL. |
| 11.2 | One instrument per RNF         | PARTIAL | Accessibility: axe-core with 0 violations at 390 and 1440 px (as `prototype/check.mjs` does). Layout: no horizontal overflow at 390 and 1440. Performance: the budget in `docs/ARCHITECTURE.md` §4, instrument OPEN (Lighthouse proposed). |
| 11.3 | Browser tests on the Laravel site | OPEN | Port `prototype/check.mjs` to run against the Laravel site, or Pest browser testing. Decide in P4. |

---

## 12. Documentation and traceability

- **This ADR** owns technical decisions. `docs/ARCHITECTURE.md` remains only as the site overview (sitemap, content model draft, lead form fields) and links here for every decision.
- **Brand documents** own the design: `brand/DIRECTION.md`, `brand/SIGNATURE-COMPONENTS.md`, `brand/logo/LOGO.md`, and the brand book artifact once P0 publishes it.
- **The placeholder register** (written in P0) owns everything Bridge must supply: contact data, claims, credentials, legal text, catalogue, planner rules, assets and approvals. It replaces the former open-items section of `docs/ARCHITECTURE.md`, `brand/DIRECTION.md` §11 and the seed list in HANDOFF_v1 §8.
- **Published artifacts** (prototype, logo sheet) are review copies. Older ones (directions, logo options) show the pre-revision radius and amber-on-light trails. They are historical and are not updated.

---

## Summary of prioritised open points

This is the **only** live list. `CLAUDE.md` and the methodology consult it; they don't copy it.

1. ~~**3.2 — Time zone.**~~ — **closed 2026-10-16** (D3.2).
2. ⚠️ **7 — Attachment retention period.** 90 days proposed; Bridge must confirm. Blocks the cleanup job in P5 and the `/privacidad` text. The job can be built with the period in config, which is compatible with any answer.
3. ⚠️ **9.1 — Hosting checks.** SSH enabled, `php -v; composer -V; which php`, plan limits in hPanel → Details, minimum cron interval, deploy key. Blocks brg-33 (staging deploy); work continues locally meanwhile (owner, 2026-10-16). Note: D9.1 deploys over SSH from GitHub Actions; hPanel's own "import from GitHub" is not needed.
4. ⚠️ **10 — Canonical domain.** Blocks the 301 map, sitemap and canonical URLs (P7). Long lead time.
5. ~~**3.5 — Primary key type.**~~ — **closed 2026-10-16** (D3.5).
6. **Brand — Certification stamp.** Five options (S1–S5); the recommendation is S2 as the official seal and S3 as the working stamp. The prototype uses a provisional S1-based seal. Owner: `brand/explore/logo-options.html`. Blocks locking the seal component in P0; the rest of P0 proceeds.
7. **10 — Mail provider.** Hostinger SMTP or transactional. Blocks P5 email delivery; code is the same with either (Laravel mailer config).
8. **4.3 — Validation approach** for the lead forms. Decide in P5.
9. **11.3 — Browser tests on Laravel.** Decide in P4.
10. **11.2 — Performance instrument.** Decide in P6.
11. **9.3 — Observability.** Decide in P6.
12. **9.4 — Database rollback.** Define before P7.
13. **3.4 — Blog pagination.** Decide in P4.
14. **1.4 — Stakeholder reporting** and **1.5 — estimation anchor.** Low priority.
