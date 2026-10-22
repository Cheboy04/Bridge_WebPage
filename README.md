# Bridge Traducciones — website

**Status:** official since 2026-10-21.
**Owns:** how to set up, run, test and stop the project locally. **Referenced by:** newcomers to the repo.

The public website and admin panel for Bridge Traducciones, a translation and interpreting company in Ecuador. It is a Laravel 12 monolith with a Blade front end and a Filament 5 admin panel, in `site/`.

The repo is **public** (ADR D2.2): never commit secrets, a real `.env` or real client data.

## Where things live

| Need | Document |
| --- | --- |
| Repo structure, stack rules, agent rules | [`CLAUDE.md`](CLAUDE.md) (§3 structure, §7 stack) |
| Technical decisions (`D2.1`, `D3.7`…) | [`docs/adr/decisiones-tecnicas.md`](docs/adr/decisiones-tecnicas.md) |
| Sitemap and content model | [`docs/ARCHITECTURE.md`](docs/ARCHITECTURE.md) |
| Roadmap, backlog, current phase | [`docs/backlog/`](docs/backlog/) |
| Brand system | [`brand/DIRECTION.md`](brand/DIRECTION.md) |
| Branches, commits, PRs | [`docs/global/reglas-git.md`](docs/global/reglas-git.md) |
| How each task is worked (SDD/TDD) | [`docs/global/metodologia-sdd-tdd.md`](docs/global/metodologia-sdd-tdd.md) |

## Prerequisites

- PHP 8.3 with the `intl` and `pdo_mysql` extensions.
- Composer.
- Node 24 and npm.
- Docker, to run MySQL 8.4. A local MySQL 8.4 install works too.

## First-time setup

Run everything from `site/` unless a step says otherwise.

1. Install dependencies from the lockfiles. Never run `composer update` or `npm install <pkg>` without an ADR entry (D3.7).

   ```bash
   composer install && npm ci
   ```

2. Create `.env` and an app key. **Only** on a fresh clone: `cp` overwrites an existing `.env`.

   ```bash
   cp .env.example .env && php artisan key:generate
   ```

3. Start MySQL in Docker. Pick your own local root password; this container is for local use only.

   ```bash
   docker run -d --name bridge-mysql -p 3306:3306 \
     -e MYSQL_ROOT_PASSWORD=<your-local-password> \
     -e MYSQL_DATABASE=bridge_test \
     mysql:8.4
   ```

   This creates the `bridge_test` database that the tests use. Wait until `docker logs bridge-mysql` shows `ready for connections`.

4. Create the development database `bridge`. The container has its own `mysql` client, so you don't need one on your machine:

   ```bash
   docker exec -it bridge-mysql mysql -uroot -p -e "CREATE DATABASE IF NOT EXISTS bridge;"
   ```

5. In `site/.env`, set `DB_USERNAME=root` and `DB_PASSWORD=<your-local-password>`. `DB_HOST=127.0.0.1` and `DB_PORT=3306` are already correct.

6. Create the tables and load the demo data (services, languages, settings and placeholder content; no real Bridge data):

   ```bash
   php artisan migrate --seed
   ```

7. Create an admin user. New users get the `editor` role, which hides Users and Settings, so promote the user afterwards with the same email:

   ```bash
   php artisan make:filament-user
   php artisan app:promote-admin you@example.com
   ```

8. Build the front-end assets:

   ```bash
   npm run build
   ```

## Run the site

```bash
php artisan serve --port=8080     # terminal 1
npm run dev                       # terminal 2, optional: live CSS/JS reload
```

| What | URL |
| --- | --- |
| Public site | http://localhost:8080 |
| Admin panel | http://localhost:8080/admin (log in with the user from step 7) |

Any free port works. `php artisan serve` defaults to 8000, which another local project may already use.

`composer dev` starts the server, queue worker, log viewer and Vite together in one terminal.

## Test

Tests use Pest against the real MySQL `bridge_test` database. `site/phpunit.xml` sets the database name, the locale (`es`) and fakes for mail, queue and cache. Host, user and password come from `site/.env`, so MySQL must be running.

```bash
composer test                                   # whole suite (clears the config cache first)
php artisan test --testsuite=Unit               # or Feature
php artisan test tests/Feature/Admin            # one folder
php artisan test --filter="part of a test name" # one test
```

### Quality chain (run before opening a PR)

This is the same order as the CI job `quality` in [`.github/workflows/ci.yml`](.github/workflows/ci.yml). [`CLAUDE.md`](CLAUDE.md) §7.2 owns this list.

```bash
vendor/bin/pint --test                          # 1. format: no diff
vendor/bin/phpstan analyse --memory-limit=1G    # 2. static analysis: 0 errors
php artisan test                                # 3. tests: green
npm run build                                   # 4. build: no errors
```

Step 5, the public UI check (axe, no overflow at 390 and 1440 px), runs locally with the prototype tooling below.

## Prototype

`prototype/` is the static reference implementation the Blade pages are ported from. It changes only to fix a drift or in an owner-approved remaster round; see `CLAUDE.md` §5.

```bash
cd prototype
npm install && npm run build    # build into dist/
npm run serve                   # http://localhost:4173
npm test                        # build, then run the prototype tests (node --test)
node check.mjs <page …>         # axe-core, overflow at 390/1440, console errors, screenshots
```

## Stop everything

1. Press `Ctrl+C` in each terminal running `php artisan serve`, `npm run dev`, `composer dev` or `npm run serve`.
2. Stop MySQL. Its data stays in the container:

   ```bash
   docker stop bridge-mysql
   ```

Next time, run `docker start bridge-mysql` and then `php artisan serve --port=8080`. You don't need to repeat setup.

To delete the database and start over: `docker rm bridge-mysql`, then repeat setup steps 3–6. This permanently erases the local data.

## Troubleshooting

| Symptom | Cause | Fix |
| --- | --- | --- |
| `Conflict. The container name "/bridge-mysql" is already in use` | The container exists but is stopped (`docker ps -a` lists it). | `docker start bridge-mysql`. |
| `Access denied for user 'root'` | `DB_PASSWORD` in `.env` doesn't match the container's root password. | Fix `.env`, or recreate the container (data loss). |
| `Connection refused` on 3306 | MySQL isn't running or is still starting. | `docker start bridge-mysql`, wait for `ready for connections`. |
| `Unknown database 'bridge'` | Setup step 4 was skipped. | Run step 4, then step 6. |
| `Failed to listen on 127.0.0.1:8000` | Another app uses port 8000. | `php artisan serve --port=8080`. |
| Admin panel has no Users or Settings menu | The user has the `editor` role (D4.2). | `php artisan app:promote-admin <email>`. |
| Pages render without styles | Assets not built. | `npm run build`, or keep `npm run dev` running. |
| Tests pick up stale settings | Cached config. | `php artisan config:clear`, or use `composer test`. |
| `fish: Unknown command: mysql` | No MySQL client on the host. | Use the client inside the container: `docker exec -it bridge-mysql mysql -uroot -p`. |

## Contributing

Work happens on branches from `develop` and goes back by pull request to `develop`. Only the owner merges. Naming and the PR routine are in [`docs/global/reglas-git.md`](docs/global/reglas-git.md).
