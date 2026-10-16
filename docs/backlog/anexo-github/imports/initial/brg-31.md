Scope: Laravel 12 app in `site/`, Filament 5 panel at `/admin`, Pest, Larastan, Pint, `spatie/laravel-translatable`, `spatie/laravel-sitemap`, Tailwind 4 with the brand `@theme` tokens, self-hosted Literata and Manrope.

Acceptance criteria:
- `php artisan test`, `vendor/bin/pint --test`, `vendor/bin/phpstan analyse` and `npm run build` pass from `site/`.
- The home route returns 200 with a token-styled placeholder; `/admin/login` returns 200.
- Lockfiles are committed; versions recorded in ADR D2.1.

References: ADR D2.1, D2.3, D3.7; docs/specs/brg-31.md.

Execution checklist:
- [ ] `brg-31.01` Plan or spec. Done when: Plan or spec approved by the owner.
- [ ] `brg-31.02` Execute. Done when: The work in Scope is done. Internal order: brg-31.01.
- [ ] `brg-31.03` Verify. Done when: Each acceptance criterion checked, with evidence. Internal order: brg-31.02.
- [ ] `brg-31.04` Integration and close. Done when: PR to develop with CI green (if code); handoff updated. Internal order: brg-31.03.
