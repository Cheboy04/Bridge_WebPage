# brg-32 (site) — CI quality pipeline on GitHub Actions against MySQL

> **GitHub Issues:** `BRG-42` (local `brg-32`) · **Phase:** P1 · **Covers:** RNF-06, RNF-07
> **Counterpart:** — (does not cross layers)
> **Status:** `[x]` draft · `[x]` approved · `[x]` implemented (ruleset pending, test 5)

Turns the issue's acceptance criteria (a PR runs the chain in order and fails on any step, tests run against MySQL, the check is required) into one workflow, one suite fix and the evidence each one can fail.

## 1. Scope in this layer

**In:**

- One workflow, `.github/workflows/ci.yml`, on `pull_request` to `develop` and `main`. One job, `quality`, with `working-directory: site` (ADR D2.3).
- The job runs `CLAUDE.md` §7.2 steps 1–4 in order: install from the lockfiles (`composer install`, `npm ci`), Pint `--test`, Larastan, Pest, Vite build. A failing step fails the job, and the steps after it don't run.
- Pest runs against a MySQL service container (ADR 11.1, lessons: same engine as production), with the `DB_*` env vars set by the job. `phpunit.xml` already selects `mysql` (brg-31).
- PHP 8.3 (ADR D2.1) with the extensions the app needs (`intl`, `pdo_mysql`). Node 24, matching the local toolchain.
- `permissions: contents: read`. The workflow uses no secrets, so PRs from forks of the public repo (ADR D2.2) run without exposing anything.
- **Suite fix found while specifying:** the suite only passes when `public/build/manifest.json` exists, because `@vite` throws without it. CI builds *after* testing (§7.2 order), so `Tests\TestCase` calls `$this->withoutVite()` in `setUp()`. The build itself stays checked by step 4.
- A Pest test that proves the suite really talks to MySQL (test 1, §4).

**Out / deferred (with reason):**

- §7.2 step 5 (axe and overflow in a browser) → ADR 11.3 is OPEN (decide in P4). The run stays a local review step until then.
- Requiring the check on `develop` and `main` (branch rulesets) → **owner**, GitHub repo settings (`CLAUDE.md` §0.6). The spec gives the check's name (§3.1).
- Deploy jobs and `push` triggers → brg-33 (D9.1).
- Caching beyond what `setup-php`/`setup-node` give with one flag, matrices, concurrency groups → not needed for one job on one PHP version.

## 2. Dependencies

- **GitHub Issues:** `BRG-5` (brg-31), merged 2026-10-16 (PR #59).
- **Data model:** none. The test uses Laravel's default migrations only.
- **Vetoes:** `CLAUDE.md` §5 lifts the "no Laravel code" veto for brg-31–33.
- **ADR (DECIDED):** D2.1, D2.2, D2.3, D9.1, 11.1.
- **OPEN items that don't block:** 11.3 (browser tests). The workflow gets one more step when it's decided; nothing here assumes its outcome. The production MySQL version is unverified (D2.1): CI uses 8.4, the same as local, and the version gets aligned when the hosting checks report it.
- **External:** the owner sets the ruleset after the first green run.

## 3. Technical contract

### 3.1 Workflow

| Item | Value |
| --- | --- |
| File | `.github/workflows/ci.yml` |
| Workflow name | `CI` |
| Trigger | `pull_request`, branches `develop`, `main` |
| Job id / required check name | `quality` (shown as `CI / quality`; the ruleset requires `quality`) |
| Runner | `ubuntu-latest` |
| Service | `mysql:8.4`, database `bridge_test`, throwaway root password set in the workflow (not a secret: the container lives for one job), health-checked before the steps run |
| Env for Pest | `DB_HOST=127.0.0.1`, `DB_PORT=3306`, `DB_USERNAME=root`, `DB_PASSWORD=<same throwaway value>` |

Steps, in order:

1. Checkout.
2. PHP 8.3 + `intl`, `pdo_mysql` (`shivammathur/setup-php`); Node 24 with the npm cache keyed on `site/package-lock.json` (`actions/setup-node`).
3. `composer install --no-interaction --prefer-dist --no-progress` and `npm ci`.
4. `cp .env.example .env && php artisan key:generate` (the app needs an `APP_KEY`; nothing real).
5. **Format:** `vendor/bin/pint --test`.
6. **Static analysis:** `vendor/bin/phpstan analyse --no-progress`.
7. **Tests:** `php artisan test`.
8. **Build:** `npm run build`.

The action versions are pinned to the current major tag, checked at implementation time (not from memory).

### 3.2 Test config change

`site/tests/TestCase.php`: `setUp()` calls `parent::setUp()` and then `$this->withoutVite()`. Nothing else changes.

## 4. Acceptance criteria of this layer → tests

Runner: Pest locally and in CI. Real boundary (C4): the MySQL service in CI and the MySQL container locally.

| # | Test / evidence | What it asserts | How it is proven to FAIL (C3) |
| --- | --- | --- | --- |
| 1 | `tests/Feature/Smoke/DatabaseTest.php::it runs the suite against MySQL` (with `RefreshDatabase`) | The default connection's driver is `mysql`, and the default migrations created `users`, `sessions` and `jobs` | Set `DB_CONNECTION` to `mariadb` in `phpunit.xml` (same server, different driver) → fails on the driver assertion. SQLite isn't used locally: without `pdo_sqlite` it dies on "could not find driver" before any assertion |
| 2 | The existing suite with **no** `public/build/` | All tests pass without a Vite manifest | Remove `withoutVite()` from `TestCase` and delete `public/build` → `HomeTest` and `FontsTest` fail with `ViteManifestNotFoundException` (the red was already seen on 2026-10-16) |
| 3 | CI run on the brg-32 PR | Job `quality` is green, and its log shows steps 5–8 in the §7.2 order | — (evidence; the order is read from the run) |
| 4 | One red CI run on the brg-32 PR, plus local exit codes | A failing test fails the job in CI. Locally, `pint --test`, `phpstan analyse` and `npm run build` each exit non-zero when broken, and Actions fails a step on any non-zero exit | CI: a throwaway commit with a failing assertion, pushed by the owner and then reverted (the report links the red run). Local: a Pint violation, a Larastan type error and a broken CSS import, each showing its exit code |
| 5 | The ruleset (owner) | `develop` and `main` require `quality` | Evidence: `gh api repos/Cheboy04/Bridge_WebPage/rulesets` output, or a screenshot |

Test 4 uses the cheaper option the owner chose on approval: one red CI run instead of one per step.

## 5. Implementation notes

- Write test 1 and the `withoutVite()` change first. Show test 1 red against SQLite and test 2 red without the build, then green.
- Check `shivammathur/setup-php`, `actions/checkout` and `actions/setup-node` majors at implementation time.
- `npm ci` flagged esbuild's install script as not covered by `allowScripts` locally (brg-31 review). If CI fails on it, approve `esbuild` in `package.json` rather than turning the check off.
- Larastan locally runs inside PHP's 128M memory limit with `phpstan.neon`'s paths. If CI runs out of memory, add `--memory-limit=1G` to the step and to `CLAUDE.md` §7.1 in the same PR.
- If CI changes the §7.2 list, `CLAUDE.md` §7.2 changes in the same PR (its own rule).
- The shell is zsh-compatible, not fish (`reglas-git.md` §6). `run:` steps use bash.

## 6. Spec change log

- `2026-10-16` — CI evidence (PR #60, merged). Test 3: [run 38950827776](https://github.com/Cheboy04/Bridge_WebPage/actions/runs/38950827776) green, steps Pint → Larastan → Pest → Vite in order. Test 4: [run 38958419144](https://github.com/Cheboy04/Bridge_WebPage/actions/runs/38958419144) red at *Tests (Pest)* with *Build (Vite)* skipped; [run 38958667420](https://github.com/Cheboy04/Bridge_WebPage/actions/runs/38958667420) green after the revert. Test 5 **not met yet**: ruleset `Quality` (id 25272569) requires `quality` but has `enforcement: disabled`, and its include pattern is the single string `refs/heads/main, develop` (it must be two entries, `refs/heads/main` and `refs/heads/develop`). Owner to fix.
- `2026-10-16` — approved by the owner (C1), with the single-red-run option for test 4.
- `2026-10-16` — implemented. Suite 9 green on MySQL with no `public/build`. C3: test 1 killed by `DB_CONNECTION=mariadb`; test 2 red without `withoutVite()`. Locally `pint --test`, `phpstan analyse` and `npm run build` each exit 1 when broken and 0 when restored. The CI steps ran green on a clean copy of `site/`. Pending: the green and red CI runs (tests 3–4) and the ruleset (test 5).
- `2026-10-16` — draft created. Found while specifying: the suite depends on a local Vite build (§1, test 2).
