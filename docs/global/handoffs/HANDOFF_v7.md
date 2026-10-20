# Handoff v7 — Bridge Traducciones (website)

**Date:** 2026-10-19 · **Phase:** P3 Admin (2026-10-19 → 2026-10-19), P4 opened · **Layer:** site
**Session focus:** closed P2, ran all eight P3 stories (HU-02–HU-09) through mode C, closed P3 and opened P4.

> Continues [`HANDOFF_v6.md`](HANDOFF_v6.md). Branch `chore/close-p3` (this handoff, the P3 close and the P4 phase doc), PR to `develop` open. Everything else is merged.

## 1. Executive status

- **P2 closed** (PR #70) and **P3 closed**: PRs #71–#78 merged into `develop`, one per story, each with spec, red commit, C3 and CI green on MySQL.
- `develop` at `a399e27`: suite 241/241 (541 assertions), `migrate:fresh --seed` green on local MySQL, Pint and Larastan clean.
- **P4 opened** ([`phase-04.md`](../../backlog/sprints/phase-04.md)): brg-39 (browser harness, ADR 11.3) is Ready now. Page stories wait for the owner to approve the prototype design.
- brg-33 (staging deploy) is still carried, blocked on ADR 9.1's hosting checks (owner). It must land before P6.

## 2. GitHub Issues

- PRs #70–#78 opened and merged by the owner. No issue edited by the agent.
- **Pending (owner):** close issues #13–#20 by hand (`Closes #n` only fires on `main`); move #43 (`BRG-43`, still in `P2 Data`) to `P4 Public site`.

## 3. Decisions of the session

All taken by the agent in mode C and recorded in each spec's log and PR.

1. **D8.1 permission matrix** closed (brg-02): both roles manage content; Settings and Users are admin only; an admin can't delete themself; `privacidad` can't be deleted; editors view and update leads (applied in HU-27).
2. **Panel `strictAuthorization()`** with an abstract `StaffContentPolicy` base; a missing policy method throws instead of allowing.
3. **`FillsTranslations`** (`app/Filament/Concerns`): edit pages fill translatable fields with their `es` value, because spatie's cast hands Filament the whole array.
4. **`SlugFields`** (`app/Filament/Fields`): the shared title + slug pair, unique on `slug->es`; used by services, posts and pages.
5. **Display time zone** `config('app.display_timezone')` = `America/Guayaquil`, set once via `FilamentTimezone::set()` (D3.2).
6. **`Post.body` sanitised on save** by a model mutator (`Str::sanitizeHtml()`, Filament's Symfony sanitiser, no new package). Other rich-text bodies are sanitised on render in P4 (ERD I9).
7. **Page slugs locked on edit** (routes find pages by slug); only `privacidad` is protected from delete.
8. **`Client::publicLogos()`** requires permission **and** a logo, ordered by `sort`; the "at least six logos" rule is P4's.
9. **Settings phone and WhatsApp regexes** and required source + date on every stat (brg-09).
10. **P4 start gate:** page stories need the owner's design approval first (the owner's words: "once the design is fully approved"); brg-39 doesn't.

## 4. Evidence

- Suite 100 → 241 over the session. C3 per story: brg-02 to brg-05 all killed; brg-06 8 mutations, 1 survived and its test deleted (Filament already sanitises the form); brg-07 11/11; brg-08 6/6; brg-09 all killed.
- CI green on every PR (#70–#78).

## 5. Files of the session

- Agent, `site/`: `app/Filament/{Resources/*,Pages/EditSettings.php,Concerns/FillsTranslations.php,Fields/SlugFields.php}`, `app/Policies/*`, `app/Console/Commands/PromoteAdmin.php`, model scopes and `Post::body()`, `lang/es/{admin,validation}.php`, `config/app.php`, `AppServiceProvider`, `tests/Feature/{Admin,Content}/*`.
- Agent, docs: `docs/specs/brg-02.md`…`brg-09.md`, ADR D8.1, `phase-03.md`, `phase-04.md`, `roadmap.md`, `CLAUDE.md` §5, this handoff.

## 6. Operational traps

1. **Spatie casts translatable columns to arrays**, so Filament edit forms show JSON without `FillsTranslations`. Every new edit page uses it.
2. **MySQL reorders JSON object keys.** Compare JSON repeater items with `toEqual`, not `toBe`.
3. **Filament's RichEditor `required` is a closure rule**: `assertHasFormErrors(['body' => 'required'])` can't match; assert `['body']` only.
4. **Filament already sanitises RichEditor HTML on dehydrate**, so a form-level sanitise test can't fail (C3 deleted one). Test the model mutator directly.
5. **Parallel PRs that append to `ScopeTest.php` conflict.** Merge `develop` into the second one and keep both sets of tests, `use` lines and header lines. Check early with `git merge-tree --write-tree origin/<other> HEAD`.
6. **Merging develop once lost two closing brackets in `lang/es/admin.php`.** Run `php -l` on it after any merge.
7. **`Closes #n` doesn't fire on merges into `develop`.** Issues stay open until the owner closes them.
8. **git and gh network calls time out often** (TLS handshake). Wrap them in `timeout` and a retry loop, and check `git log origin/develop` after a fetch.
9. **The GateGuard hook** wants the facts (what it supersedes, where it's linked, the user's words) stated in a separate turn before the first Write of a file.

Still in force: HANDOFF_v6 §6 and earlier traps.

## 7. Detected drift

None open. Not drift: ADR "Summary of prioritised open points" #9 (11.3) and #13 (3.4) are now P4's to decide.

## 8. Ordered next steps

1. Owner merges the `chore/close-p3` PR, closes #13–#20 and moves #43.
2. Owner approves the prototype design for the P4 pages (start gate), or runs another remaster round first.
3. brg-39 / `BRG-49`: browser check harness, deciding ADR 11.3. Ready now.
4. Then brg-01 (layout) and the page stories per `phase-04.md`.
5. Carried: brg-33 hosting checks (owner, ADR 9.1); mail provider (ADR open #7) before P5.
