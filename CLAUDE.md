# CLAUDE.md — Agent manual (Bridge Traducciones website)

This file loads in every session. It tells the agent **how to behave**, not what to build. **Read it in full at the start of every session.**

This is a single-layer repo: one Laravel monolith in `site/` (ADR D2.3). The stack rules are in §7 of this file.

---

## 0. Hard rules (non-negotiable)

1. **Git:** I don't run git writes (`add`, `commit`, `push`, `merge`, `branch`, `checkout`/`switch`, `reset`, `tag`, `stash`). I **do** read (`git status/branch/log/diff/show`). I hand over the write commands already filled in, and stop. → `docs/global/reglas-git.md`.
2. **Who writes application code:** mode **B** of `docs/global/metodologia-sdd-tdd.md` §2. I write the spec, the red tests and the code. The owner approves the spec **before** I write tests, and reads every diff. I never approve my own spec or my own C3 without showing the evidence.
3. **One change at a time, one task at a time.** I don't touch anything outside the task's diff "while I'm at it".
4. **The source of truth rules.** Stories and AC → GitHub Issues. Technical decisions → ADR (by number: `D3.1`…). Design → brand docs (ADR D3.8). If the code must differ from the spec, **the spec is updated first**, in the same session.
5. **Secrets never go into the repo or to the client.** The repo is **public** (ADR D2.2): never secrets or real client data in code, config, seeds, tests, the tracker or the history. `.env` always in `.gitignore`; `site/.env.example` versioned with no real values.
6. **I don't touch infrastructure by hand** (Hostinger hPanel/SSH/DNS/mail/cron, GitHub repo settings/secrets/deploy keys, Google GA4). If a task needs it, I flag it as a dependency and stop.

---

## 1. Check before any change (mandatory)

Before writing a spec or a test, or proposing an implementation:

1. **Does it touch something `OPEN` in the ADR?** If yes, I don't work on it yet: I flag the pending decision. The live list is at the end of the ADR ("Summary of prioritised open points"); I consult it, I don't copy it.
2. **Does it fall under "What NOT to do yet" (§5)?** If yes, I don't do it, even if it looks reasonable.
3. **Does it affect a convention** (names, commits, branches, error handling, time zone, tokens, contrast)? I check it against the document that owns it before applying it.

---

## 2. Session ritual

**At start**, I read in this order:

1. This `CLAUDE.md`.
2. `docs/global/metodologia-sdd-tdd.md`: the cycle, the gates and the roles.
3. The latest `docs/global/handoffs/HANDOFF_vN.md`: state, decisions and traps from the previous session.
4. The **story spec** in `docs/specs/HU-XX.md` and its acceptance criteria in GitHub Issues.
5. I search the code with codebase-memory-mcp (§8) before writing tests or proposing code, to reuse instead of rewrite.

**When a task closes**, I report: what I did, which files I touched, what's left and the review findings (methodology §5), and I **hand over the git command block**. Then I stop.

**When the session closes**, I write the next `HANDOFF_vN.md` from `docs/global/PLANTILLA-HANDOFF.md`.

---

## 3. Repo structure

```
/
├── CLAUDE.md                       ← agent rules (stack in §7)
├── brand/                          ← brand system: DIRECTION.md, SIGNATURE-COMPONENTS.md, logo/ (owners per ADR D3.8)
├── prototype/                      ← static reference implementation (8 pages, 6 signature components)
├── audit/                          ← brand/UX audits (captures with real data are git-ignored)
├── docs/
│   ├── ARCHITECTURE.md             ← site overview: sitemap, content-model draft, lead forms (decisions → ADR)
│   ├── global/                     ← methodology, git rules, lessons, style guide, templates, handoffs/
│   ├── adr/decisiones-tecnicas.md  ← technical source of truth
│   ├── erd/                        ← data model (slices from P2)
│   ├── backlog/                    ← roadmap, backlog, phase docs (sprints/), key map, anexo-github/
│   ├── specs/HU-XX.md              ← one spec per story
│   └── nomenclatura.md             ← naming conventions
└── site/                           ← the Laravel 12 + Filament 5 app (created in P1)
```

---

## 4. Document index

| Document | What it holds | Owns |
| --- | --- | --- |
| `CLAUDE.md` | Hard rules, ritual, structure, stack (§7) | Agent behaviour and stack rules |
| `docs/global/metodologia-sdd-tdd.md` | SDD/TDD cycle, gates, roles | How each task is worked |
| `docs/global/reglas-git.md` | Branches, commits, command hand-over | Everything git |
| `docs/global/lecciones-transversales.md` | Learned traps still in force | What not to repeat |
| `docs/global/GUIA-ESTILO-DOCS.md` | Doc conventions | How docs are written |
| `docs/adr/decisiones-tecnicas.md` | Closed decisions (`Dx.y`) and the open list | What is technically decided |
| `brand/DIRECTION.md`, `brand/SIGNATURE-COMPONENTS.md`, `brand/logo/LOGO.md` | Brand system, component behaviour, logo rules | Design |
| `docs/ARCHITECTURE.md` | Sitemap, content-model draft, lead forms | Site information architecture |
| `docs/erd/…` | Data model | Tables, columns, constraints |
| `docs/backlog/…` | Roadmap, backlog, phase docs | Planning |
| `docs/specs/…` | Contract and tests per story | The "how" of each story |
| `docs/nomenclatura.md` | Names and structure | How things are named |
| `docs/global/handoffs/HANDOFF_vN.md` | State between sessions | Continuity |

---

## 5. What NOT to do yet (scope of Phase 1, Skeleton)

**Updated on 2026-10-16:** P0 closed (owner approved the brand book); the project is in **P1 (Skeleton)** (ADR D1.1, `docs/backlog/sprints/phase-01.md`). The "no Laravel code" veto is lifted **only** for brg-31 (`BRG-5`), brg-32 (`BRG-42`) and brg-33 (`BRG-43`). Until P1 closes:

- No models, migrations of our own, ERD slices or factories (P2: brg-35–37).
- No Filament resources, Blade components or pages beyond brg-31's placeholder home (P3, P4).
- No packages beyond those in ADR D3.7 and the dev tooling in D2.1.
- brg-33 (staging deploy) is **not a blocker**: the owner is still sorting out the Hostinger checks, so work continues locally. Don't stall P1 or P2 waiting for it.
- `prototype/` is the reference implementation: no changes except to fix a drift the site's token tests reveal (recorded in the phase doc).
- No real Bridge data in any file; it goes to `Settings` through the admin later (placeholder register).

## 6. Closed infrastructure decisions

- **Repository:** `Cheboy04/Bridge_WebPage` on GitHub, **public** (D2.2). Branches `main` (production) and `develop` (staging).
- **Board:** GitHub Issues + Projects, tickets `BRG-<n>` (D2.4). Loaded 2026-10-16: `BRG-4`…`BRG-57`; local ID ↔ key in `docs/backlog/key-map.md`.
- **Hosting:** Hostinger Business, shared (D9.1). Canonical domain OPEN.
- **Package managers:** Composer and npm, with lockfiles committed.
- **Drift to carry:** older published artifacts (directions, logo options) show the pre-revision radius and amber-on-light trails. They are historical; say so if they are shown to anyone (ADR §12).

---

## 7. Stack of this repo

This section governs the `site/` code. **It doesn't repeat the ADR:** decisions live in `docs/adr/decisiones-tecnicas.md` and are cited by number here.

### 7.0 Technical baseline (don't assume other versions)

The real pin is the lockfile (`site/composer.lock` + `site/package-lock.json`). Majors and constraints: ADR D2.1. Until P1 installs them, no minor version is assumed.

### 7.1 Commands

From `site/` (exist from P1; confirm against `composer.json` scripts when they land):

```bash
php artisan serve                       # dev server
php artisan test                        # tests, one pass (Pest)
vendor/bin/pint --test                  # format check, no changes
vendor/bin/phpstan analyse              # Larastan
npm run build                           # Vite build
composer install && npm ci              # install respecting the lockfiles (never `composer update` / `npm install <pkg>` without an ADR entry)
```

From `prototype/` (the reference implementation):

```bash
npm install && npm run build            # build the static pages into dist/
npm run serve                           # serve on port 4173
node check.mjs <page …>                 # axe-core, overflow at 390/1440, console errors, screenshots
```

### 7.2 Quality chain before asking for a commit

In the **same order as the CI job** (defined in P1). If CI changes, this list changes in the same PR.

1. Format (Pint) → no diff.
2. Static analysis (Larastan) → 0 errors. Known warnings are listed with their ticket.
3. Tests (Pest) → green, with new tests **proven red** (C3).
4. Build (Vite) → no errors.
5. Public UI: `check.mjs`-style run → 0 axe violations, no horizontal overflow at 390 and 1440 (D11.2).

### 7.3 Architecture rules (by ADR reference)

| Rule | Source | In one line |
| --- | --- | --- |
| Monolith, Blade front end | D2.3, D3.7 | No API, no SPA, no JS framework. Blade outputs the prototype's HTML. |
| Minimal packages | D3.7 | Only `spatie/laravel-translatable` and `spatie/laravel-sitemap` beyond Laravel/Filament. Anything else needs an ADR entry. |
| Translatable from day one | D3.6 | User-facing text columns are translatable JSON; UI strings via `__()`; no hard-coded Spanish in Blade. |
| Tokens from one file | D3.7, D3.8 | Colours, radii and type come from the `@theme` tokens. No hex values in components. |
| Contrast is computed | `brand/DIRECTION.md` §2 | Every text pair ≥ 4.5:1. Amber only on dark surfaces. Compute the ratio, never judge by eye. |
| Signature components | D3.7, `brand/SIGNATURE-COMPONENTS.md` | Vanilla JS, no animation libraries, complete at rest, reduced-motion fallback. One signature moment per page. |
| Error handling | D3.1 | Error summary + inline messages; branch on field/rule, never on message text. |
| Uploads | D7.1 | Private disk, signed URLs, never in emails, scheduled deletion (period OPEN). |
| Privacy | D8.5, 8.6 | Store only what's needed to quote; `consent_at`; GA4 only after consent. |
| Roles | D4.2 | `admin` / `editor` via `role` column + policies. No permission package. |
| Time zone | D3.2 | Store UTC (`app.timezone = UTC`); display in `America/Guayaquil`; event dates are plain `date` columns. |
| Deploy | D9.1 | The server never runs `git pull` or `npm`. CI builds the release. |

### 7.4 Language rules

- PHP: typed properties, parameters and return types everywhere. No `dd()`, `dump()` or `ray()` left in code.
- Env vars exist in `site/.env.example` with no real values. Code reads `config()`, never `env()` outside `config/`.
- User text renders escaped (`{{ }}`). `{!! !!}` only for CMS rich text that has been sanitised, with a comment saying where.
- Mass assignment: explicit `$fillable` per model.
- Contact data (phones, emails, WhatsApp, address) comes from `Settings`, never hard-coded.

### 7.5 Tests (how they're written here)

- Test files: `site/tests/Feature/<Area>/<Thing>Test.php` and `site/tests/Unit/…`, Pest syntax.
- Test descriptions in English. The file header cites the story, the task and the test number from the spec.
- Simulation boundary: tests run against a real MySQL database in CI (C4, lessons). Mail and queue are faked with `Mail::fake()` / `Queue::fake()`, and at least one test per mailable renders it for real. Storage uses `Storage::fake('private')`.
- Reusable helpers: none yet. Record them here as they appear.
- Test config pins the locale (`es`) and time zone so the suite doesn't depend on the local `.env` (lessons).

### 7.6 Naming

Names of files, classes, methods, routes and tests: **`docs/nomenclatura.md`**. This file owns *how to work*; that one owns *how to name*.

---

## 8. Code search

**codebase-memory-mcp** first, for any code exploration: `search_graph` to find functions, classes and routes; `trace_path` for call chains; `get_code_snippet` for a symbol's source; `search_code` for graph-augmented text search. If the project isn't indexed, run `index_repository` first, and re-index after structural changes. Grep and Read are for docs, config and non-code files.

It is memory **of the code**, not of the conversation. Memory between sessions lives in the specs and the handoffs.
