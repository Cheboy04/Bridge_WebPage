# brg-31 (site) — Scaffold Laravel 12 + Filament 5 with the quality chain and brand tokens

> **GitHub Issues:** `BRG-<n>` (pending the board load; local `brg-31`) · **Phase:** P1 · **Covers:** RNF-06, RNF-07, RNF-09
> **Counterpart:** — (does not cross layers)
> **Status:** `[x]` draft · `[ ]` approved · `[ ]` implemented

Turns the issue's acceptance criteria (quality chain passes, placeholder home and `/admin/login` respond, lockfiles and versions recorded) into the scaffold's contract and its smoke tests.

## 1. Scope in this layer

**In:**

- A Laravel 12 application in `site/` (ADR D2.3), PHP 8.3 constraint in `composer.json`.
- Filament 5 panel `admin` at `/admin` with Filament's login (ADR 4.5). No resources yet.
- Dev tooling: Pest, Larastan, Pint (`laravel` preset). Runtime packages: `spatie/laravel-translatable`, `spatie/laravel-sitemap` (ADR D3.7). Nothing else.
- Tailwind 4 via Vite. `resources/css/app.css` carries the brand `@theme` block **copied from** `prototype/src/styles/app.css` (palette, fonts, type scale, spacing, radii, shadow, breakpoints, durations, easing) plus the `.mode-documento` / `.mode-cabina` roles.
- Literata and Manrope self-hosted as WOFF2 in `public/fonts/`, Latin + Latin Extended (ADR D3.7, ARCHITECTURE §4).
- `config/app.php`: `locale` and `fallback_locale` = `es`, `faker_locale` = `es_EC`. Time zone stays Laravel's default `UTC` until brg-34 decides (compatible with both outcomes: storage is UTC either way).
- A placeholder home view at `/` (`home` route): the `<html lang="es">` shell, the tokens, "Bridge Traducciones" in Literata and one line in Manrope. No header, footer or Settings (those are HU-01 and HU-09).
- `site/.env.example` with every key the app reads and **no real values** (ADR D2.2).
- `phpunit.xml` pins `APP_LOCALE=es` and `APP_ENV=testing`, and uses MySQL through env vars, so CI (brg-32) runs against MySQL (lessons: same engine as production). Locally the suite may point at a local MySQL.

**Out / deferred (with reason):**

- CI workflow → brg-32.
- Deploy → brg-33.
- Any model, migration beyond Laravel's defaults (users, cache, jobs, sessions) → P2 (brg-35, brg-36).
- Layout components → HU-01 (P4).
- Time zone and PK decisions → brg-34. Laravel's defaults stay meanwhile.

## 2. Dependencies

- **GitHub Issues:** none.
- **Data model:** none.
- **Vetoes:** `CLAUDE.md` §5 "No Laravel code" is lifted **for brg-31–brg-33 only**, when P1 starts.
- **ADR (DECIDED):** D2.1, D2.2, D2.3, D3.6, D3.7, 4.5, D11.1.
- **OPEN that don't block:** 3.2 time zone (UTC storage is the proposal and Laravel's default; the display rule arrives with brg-34), 3.5 PK type (no table of ours is created here).
- **External:** none (runs locally).

## 3. Technical contract

### 3.1 Routes

| Method | Path | Name | Who | Response |
| --- | --- | --- | --- | --- |
| GET | `/` | `home` | anyone | 200, placeholder view `pages.home` |
| GET | `/admin/login` | Filament | guest | 200, Filament login |
| GET | `/admin` | Filament | guest → redirect | 302 to `/admin/login` |

### 3.2 Files created (beyond the Laravel skeleton)

| Path | Content |
| --- | --- |
| `site/app/Providers/Filament/AdminPanelProvider.php` | Panel `admin`, path `admin`, `->login()`, brand colour from the token `bridge` (#1c61ad) |
| `site/resources/css/app.css` | `@import "tailwindcss"`, `@theme` copied from the prototype, mode roles, `@font-face` for the two families |
| `site/resources/views/layouts/base.blade.php` | `<html lang="{{ str_replace('_','-',app()->getLocale()) }}">`, Vite assets, `@yield` |
| `site/resources/views/pages/home.blade.php` | The placeholder |
| `site/public/fonts/*.woff2` | Literata (variable, opsz + wght) and Manrope (variable wght), Latin + Latin Ext subsets |
| `site/tests/Feature/Smoke/*.php`, `site/tests/Unit/Brand/*.php` | The tests in §4 |

### 3.3 Visible strings

The placeholder shows exactly "Bridge Traducciones" (h1, Literata) and "Traducción certificada e interpretación simultánea, desde Quito." (Manrope), both through `__()` with keys in `lang/es/site.php`.

## 4. Acceptance criteria of this layer → tests

Runner: Pest. Real boundary (C4): the HTTP kernel and a MySQL connection. Helpers: none yet.

| # | Test (file::case) | What it asserts | How it is proven to FAIL (C3) |
| --- | --- | --- | --- |
| 1 | `tests/Feature/Smoke/HomeTest.php::it serves the placeholder home in Spanish` | GET `/` is 200, the html has `lang="es"` and contains the two strings of §3.3 | Set `locale` to `en` in `config/app.php` → `lang="en"` and the keys render untranslated |
| 2 | `tests/Feature/Smoke/AdminTest.php::it shows the admin login to guests` | GET `/admin/login` is 200 and contains the email field | Remove `->login()` from the panel → 404 |
| 3 | `tests/Feature/Smoke/AdminTest.php::it redirects guests from the admin to the login` | GET `/admin` is a redirect to `/admin/login` | Drop the `Authenticate` middleware from the panel → 200 |
| 4 | `tests/Unit/Brand/TokensTest.php::it keeps the site palette identical to the prototype` | Every `--color-*` in `site/resources/css/app.css`'s `@theme` equals the prototype's (parsed from both files) | Change `--color-rastro` in the site file → fails naming the token |
| 5 | `tests/Unit/Brand/TokensTest.php::it keeps both mode roles identical to the prototype` | The `.mode-documento` and `.mode-cabina` declarations match the prototype's values | Change `--accent` in `.mode-cabina` → fails |
| 6 | `tests/Feature/Smoke/FontsTest.php::it self-hosts the fonts` | The home HTML references no `fonts.googleapis.com`/`fonts.gstatic.com`, and every `@font-face` `url()` in `app.css` points at an existing file in `public/fonts/` | Add the Google Fonts `<link>` to the layout, or delete one woff2 → fails |
| 7 | `tests/Unit/Config/EnvExampleTest.php::it ships an env example without real values` | `.env.example` contains `APP_LOCALE=es`, `APP_DEBUG=false`, and every `*_PASSWORD`, `*_SECRET`, `*_KEY` (except the empty `APP_KEY=`) is empty | Put `MAIL_PASSWORD=x` → fails naming the key |

Not a Pest test, checked in review (step `.04`): `vendor/bin/pint --test` and `vendor/bin/phpstan analyse` clean; `npm run build` passes; `composer.lock` and `package-lock.json` committed; ADR D2.1 updated with the installed versions.

## 5. Implementation notes

- Install with `composer create-project laravel/laravel site` (Laravel 12), then `composer require filament/filament:"^5.0" spatie/laravel-translatable spatie/laravel-sitemap` and `composer require --dev pestphp/pest larastan/larastan`. Check the Filament 5 install steps on context7 at that moment, not from memory.
- Review the diff of every generator (lessons: generators add extras), especially `composer.json` and `package.json`.
- Tests 4 and 5 read `../prototype/src/styles/app.css` relative to `site/`. They're the guard that keeps the site and the reference implementation in sync until the prototype retires.
- Subset fonts with the Google Fonts CSS2 API using a full Chrome user agent (HANDOFF_v1 trap 5), or with `pyftsubset`. Literata needs its `opsz` axis.
- The shell is zsh-compatible, not fish (`reglas-git.md` §6).

## 6. Spec change log

- `2026-10-16` — draft created (kit Phase 6). Awaiting the owner's approval (C1).
