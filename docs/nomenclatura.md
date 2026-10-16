# Naming — site (Bridge Traducciones website)

**Status:** official since 2026-10-16. Rules beyond Laravel's defaults are revisited when P1 scaffolds `site/`.
**Owns:** names and structure of the `site/` code. **Referenced by:** `CLAUDE.md` §7.6, specs, the PR template.

It records what Laravel and Filament dictate, plus the few project rules on top. It doesn't invent rules nobody will follow.

---

## 0. Who owns what (so tools don't overlap)

- **Pint** owns **formatting** (indentation, braces, quotes, import order). Nobody formats by hand.
- **Larastan** owns **types**.
- **This document** owns **names and structure**.
- Database object names are governed by the ADR (D6.2) and the ERD, not by this document.

## 1. Identifier language

**Code in English. User-facing content in Spanish.**

| What | Language |
| --- | --- |
| Classes, methods, variables, columns, tables, route names, enum cases, test descriptions, comments | English |
| Visible text (Blade, `lang/es/*.php`, validation messages, mail, Filament labels) | Spanish, always through `__()` (ADR D3.6) |
| Public URL paths | Spanish (`/traduccion/certificada`, ADR D3.6) |
| Enum stored values | English (`new`), with a Spanish label (`getLabel()` → "Nuevo") |
| Seed data | Spanish, invented (ADR D2.2) |

**Exception:** the brand mode names **Documento** and **Cabina** are proper nouns of the brand system (`brand/DIRECTION.md`). They stay as they are in code: `ServiceMode::Documento`, value `documento`.

**Domain dictionary:**

| Domain (Spanish) | Identifier (English) |
| --- | --- |
| servicio | `Service` |
| modo Documento / Cabina | `ServiceMode::Documento` / `ServiceMode::Cabina` |
| idioma | `Language` |
| par de idiomas | `languagePair` (`source_language_id`, `target_language_id`) |
| cliente (logo) | `Client` |
| testimonio | `Testimonial` |
| pregunta frecuente | `Faq` |
| entrada del blog | `Post` |
| página | `Page` |
| solicitud / cotización (lead) | `Lead` |
| tipo de solicitud: contacto / traducción / interpretación | `LeadType::Contact` / `Translation` / `Interpreting` |
| estado: nuevo / contactado / cotizado / ganado / perdido | `LeadStatus::New` / `Contacted` / `Quoted` / `Won` / `Lost` |
| adjunto | `attachment` |
| consentimiento | `consent_at` |
| ajustes del sitio | `Settings` |
| traducción certificada | `certified-translation` (slug data; the URL slug is Spanish) |
| interpretación simultánea | `simultaneous-interpreting` (same) |
| cabina, receptores, técnico (planner) | `booth`, `receiver`, `technician` |

## 2. Casing table

| Element | Convention | Example |
| --- | --- | --- |
| Class file | `PascalCase.php`, one class per file | `LeadController.php` |
| Class / enum / interface | `PascalCase` | `LeadStatus` |
| Method / function | `camelCase`, verb first | `storeAttachments()` |
| Variable / property | `camelCase` | `$targetLanguage` |
| Constant | `UPPER_SNAKE` | `MAX_ATTACHMENTS` |
| Enum case | `PascalCase` | `LeadStatus::Quoted` |
| Table / column | `snake_case`, tables plural | `leads.consent_at` |
| Route name | dot-separated English | `quote.translation.store` |
| URL path | Spanish `kebab-case` | `/cotizacion/traduccion` |
| Blade view / component | `kebab-case` | `components/contact-block.blade.php` → `<x-contact-block>` |
| Config key | `snake_case` | `config('site.locales')` |
| Env var | `UPPER_SNAKE` | `LEAD_ATTACHMENT_RETENTION_DAYS` |
| CSS class | `kebab-case`, **prefixed per component** | `.ba-knob`, `.hseg` (HANDOFF_v1 trap 6) |
| JS file | `kebab-case` | `resources/js/sig-hero.js` |

## 3. Artifact types and suffixes

| Type | Convention | Example |
| --- | --- | --- |
| Model | singular noun | `Service` |
| Controller | `<Thing>Controller`, resource verbs | `ServiceController@show` |
| Form request | `<Action><Thing>Request` | `StoreTranslationQuoteRequest` |
| Livewire component | `<Thing>Form` for forms | `TranslationQuoteForm` |
| Filament resource | `<Model>Resource` | `LeadResource` |
| Policy | `<Model>Policy` | `LeadPolicy` |
| Enum | singular noun | `LeadStatus` |
| Job | verb phrase | `PurgeExpiredAttachments` |
| Mailable | `<Event>Mail` | `LeadReceivedMail` |
| Seeder / factory | `<Model>Seeder` / `<Model>Factory` | `LanguageSeeder` |
| Blade component (signature) | `sig-<name>`, matching the prototype | `<x-sig-hero>` |
| Blade component (base) | plain noun | `<x-contact-block>` |

## 4. Functions and methods

- Verb first. Booleans with an `is`/`has`/`can` prefix.
- The framework's standard methods (resource controller verbs, Filament hooks) are never renamed.
- Services use domain verbs, not an anaemic CRUD that just forwards calls.

## 5. Variables

- Descriptive; no bare `data`, `tmp` or `a`.
- Collections plural, entities singular.
- No abbreviations, except universal ones (`id`, `url`, `seo`).

## 6. Folder structure

| Folder (in `site/`) | What goes there |
| --- | --- |
| `app/Models`, `app/Enums`, `app/Policies` | Domain model |
| `app/Http/Controllers`, `app/Http/Requests` | Public site |
| `app/Livewire` | Lead forms |
| `app/Filament/Resources` | Admin |
| `app/Jobs`, `app/Mail` | Async work and email |
| `resources/views/components` | Blade components (from `prototype/src/components/`) |
| `resources/views/pages` | Page views |
| `resources/css` | `app.css` (the `@theme` tokens) + `sig-*.css` |
| `resources/js` | Alpine bootstrap + `sig-*.js` |
| `lang/es` | Spanish UI strings |
| `tests/Feature/<Area>`, `tests/Unit` | Pest tests |

## 7. Migrations / schema

- File name: the action in `snake_case`, verb first (`create_leads_table`, `add_turnaround_to_services_table`).
- **One intent per migration.**
- **Never edit a migration that has been applied in any environment**: create a new one.

## 8. Tests

- File: `tests/Feature/<Area>/<Thing>Test.php`, Pest `it('…')`.
- Case description: one English sentence describing the observable behaviour, identical to the "Test" column of the spec.
- **One behaviour per test.** If the name needs an "and", it's probably two tests.
- Datasets keyed by a description, not by numeric index.
- The test asserts the **shape** of the result (fields, status, rendered text), not just the state, and is proven red (C3).

## 9. Boundary interfaces (if needed)

Only at the system's external edges (storage, mail, analytics): `{Capability}Contract` with an implementation named after the technology. No interfaces for our own domain with a single implementation.

## Sources

- Laravel 12 and Filament 5 documentation (naming as generated by `artisan make:*` and `make:filament-resource`).
- PSR-12 via Pint's `laravel` preset.
- ADR D2.3, D3.6, D3.7, D6.2.
