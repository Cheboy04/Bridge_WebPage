# Handoff v4 — Bridge Traducciones (website)

**Date:** 2026-10-16 · **Phase:** P1 Skeleton (2026-10-16 → open) · **Layer:** site
**Session focus:** brg-31 (`BRG-5`) and brg-32 (`BRG-42`) taken through the whole cycle and merged; P1 only waits on the owner's call about brg-33. **Start the next session here.**

> Continues [`HANDOFF_v3.md`](HANDOFF_v3.md). PRs #59 (brg-31) and #60 (brg-32) are merged into `develop` (head `efedd8b`). This close-out goes on `docs/session-close-v4` (commit block handed over).

## 1. Executive status

- **`site/` exists:** Laravel 12.70 + Filament 5.10 panel at `/admin`, the brand tokens copied from the prototype, self-hosted Literata and Manrope, and a placeholder home. Versions: ADR D2.1.
- **CI is live:** `.github/workflows/ci.yml`, job `quality`, on PRs to `develop`/`main`. It runs Pint → Larastan → Pest on MySQL 8.4 → Vite build.
- **Suite:** 9 tests, 39 assertions, green locally and in CI.
- **Not done:** the ruleset doesn't enforce the check yet (§6.1). brg-33 is blocked on the Hostinger checks. Issues #5 and #42 are still open (§2).

## 2. GitHub Issues

Nothing was written to the board by the agent. **Owner:**
- Close `#5` and `#42`. `Closes #N` only fires on the default branch (`main`), not `develop`. For example: `gh issue close 5 --comment "Done in PR #59"`, `gh issue close 42 --comment "Done in PR #60"`.
- `#44` (brg-34) is still to close, from HANDOFF_v3 §2, if that hasn't been done.

## 3. Decisions of the session

1. **D3.2 re-confirmed** by the owner: store UTC, display `America/Guayaquil`. A line was added to D3.2; nothing blocks P2's migrations.
2. **`composer.json` pins `config.platform.php = 8.3.0`** (owner): the local CLI is PHP 8.5, production is 8.3. ADR D2.1, brg-31 spec §5.
3. **Larastan at level 6, `tests/` excluded** (agent, recorded in D2.1). Pest closures bind `$this` at runtime, so tests only produce false positives. Level 7+ flags only the skeleton's `config/filesystems.php:44`. Fixing that line would let the level go up; that's the owner's call.
4. **No `pestphp/pest-plugin-laravel`, no `axios`, no `laravel/sail`.** These are generator extras outside D3.7 and D2.1.
5. **Filament's published assets stay git-ignored** (`public/{css,js,fonts}/filament`): `filament:upgrade` in `post-autoload-dump` republishes them on every `composer install`, so the D9.1 CI build gets them.
6. **brg-32 test 4 used the cheaper proof** (owner): one red CI run plus local exit codes, not one red run per step.

## 4. Evidence

- **brg-31:**
  - C2: all 8 cases red before the implementation.
  - C3: 11 mutations, 11 killed.
  - Chain green.
  - Browser check of `/` and `/admin/login` at 390 and 1440: 0 axe violations, no overflow, no console errors, no external requests.
- **brg-32:**
  - Test 1 killed by `DB_CONNECTION=mariadb`.
  - Test 2 red without `withoutVite()`.
  - `pint`, `phpstan` and `vite build` each exit 1 when broken.
  - CI green [38950827776](https://github.com/Cheboy04/Bridge_WebPage/actions/runs/38950827776).
  - CI red at *Tests (Pest)* with *Build* skipped [38958419144](https://github.com/Cheboy04/Bridge_WebPage/actions/runs/38958419144).
  - Green after the revert [38958667420](https://github.com/Cheboy04/Bridge_WebPage/actions/runs/38958667420).
- **Ruleset `Quality`** (id 25272569): requires `quality`, but it's **disabled** and its branch pattern is wrong (§6.1).

## 5. Files of the session

- **By the agent, site:** all of `site/` (PR #59); `site/tests/TestCase.php`, `site/tests/Feature/Smoke/DatabaseTest.php`, `.github/workflows/ci.yml` (PR #60).
- **By the agent, docs:**
  - Specs: `docs/specs/brg-31.md` and `docs/specs/brg-32.md`.
  - ADR `docs/adr/decisiones-tecnicas.md`: D2.1, row 2.4, D3.2.
  - `CLAUDE.md` §7.2, `docs/global/lecciones-transversales.md`, `docs/backlog/sprints/phase-01.md`, this handoff.
- **By the owner:** composer + `php-intl` + PHP extensions installed locally; branches, commits, PRs, the throwaway red commit and its revert; the ruleset.

## 6. Operational traps

1. **The ruleset looks configured but protects nothing.**
   - `enforcement` is `disabled`.
   - `conditions.ref_name.include` is the single string `"refs/heads/main, develop"`, which matches no real branch.
   - Fix: two entries, `refs/heads/main` and `refs/heads/develop` (or `~DEFAULT_BRANCH` + `refs/heads/develop`), and enforcement `active`.
   - Check: `gh api repos/Cheboy04/Bridge_WebPage/rulesets/25272569 --jq '{enforcement, conditions}'`.
2. **The suite depended on a local Vite build.** `@vite` throws without `public/build/manifest.json`, and CI builds after testing. Fixed with `withoutVite()` in `Tests\TestCase`; moved up to the lessons file.
3. **Local `.env` vs tests.** `phpunit.xml` pins `SESSION_DRIVER=array`, but the local `.env` uses `database`. `php artisan serve` gave a 500 until the default migrations ran on the local DB. After a fresh clone, run `php artisan migrate`.
4. **SQLite isn't a valid C3 mutation locally.** There's no `pdo_sqlite`, so it dies on "could not find driver" before any assertion. Use `DB_CONNECTION=mariadb` to hit the driver assertion.
5. **GateGuard asks for facts on the first touch of every file** (and on `rm -rf` in the scratchpad). That still costs one retry per new file (HANDOFF_v2 §6).
6. **`prototype/check.mjs` is hard-wired to `prototype/dist`.** The site's browser check used a one-off copy in the scratchpad, pointed at `php artisan serve --port=8123`. The real instrument is ADR 11.3, OPEN (P4).

Still in force: HANDOFF_v3 §6 (hPanel Git import isn't the deploy path; check the branch before the first write), HANDOFF_v2 §6, HANDOFF_v1 traps 2–7 and 9–11.

## 7. Detected drift

- `phase-01.md`'s close gate asks for a staging deploy that can't happen yet (brg-33 blocked). The DoD allows carrying brg-33 forward; recording that is the owner's decision (§8.2).

## 8. Ordered next steps

1. **Owner:** fix the ruleset (§6.1), close `#5`, `#42` (and `#44` if still open), and merge this close-out PR.
2. **Owner decides:** close P1 now with brg-33 carried forward (the phase DoD allows it, and the roadmap risk table says "continue with P2 locally"), or wait for the Hostinger checks. If closing: `phase-01.md` records the carry-over and closes, `CLAUDE.md` §5 moves to P2's scope, and the roadmap is updated, all in one docs PR.
3. **P2 (Data):** brg-35–37 (ERD slices, models, migrations, factories), after reading `docs/backlog/sprints/` for P2 and writing its first spec (C1).
4. **brg-33** whenever the owner has the Hostinger SSH details (phase-01 §Ready conditions).
5. Optional:
   - Raise Larastan above level 6 (fix `config/filesystems.php:44` first).
   - Add `OFL.txt` next to the fonts.
   - Approve `esbuild`'s install script in npm (`npm install-scripts approve esbuild`). npm warns, but CI passed without it.

## 9. How to resume the environment

- The local toolchain is PHP 8.5.11 CLI (with `intl`, `pdo_mysql`, `iconv`), Composer 2.10 and Node 24.
- **Test DB:** the throwaway container `bridge-mysql` (`mysql:8.4`, root/root, database `bridge_test`, port 3306).
  - Start it with `docker start bridge-mysql`.
  - Recreate it if gone: `docker run -d --name bridge-mysql -e MYSQL_ROOT_PASSWORD=root -e MYSQL_DATABASE=bridge_test -p 3306:3306 mysql:8.4`.
- **`site/.env`** (git-ignored) points at that DB.
- **From a fresh clone:** `cd site && composer install && npm ci && cp .env.example .env`, set `DB_USERNAME=root` `DB_PASSWORD=root` `DB_DATABASE=bridge_test`, then `php artisan key:generate && php artisan migrate && npm run build`.
