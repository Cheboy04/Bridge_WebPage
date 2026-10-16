# Bridge Traducciones — Site Architecture

Status: draft for approval · 2026-10-15
Inputs: `brand/DIRECTION.md` (Puente system), `audit/*.md`, client decisions recorded below.

## 1. Constraints (decided)

| Topic | Decision |
|---|---|
| Content editing | Owner builds; Bridge team edits via a CMS (blog, clients, services, anything listed later) |
| CMS | Filament 5 on Laravel (requires PHP 8.2+, Laravel 11.28+, Tailwind 4.1+) |
| Languages | MVP **Spanish only**; adding locales later must not need a rewrite |
| Lead channels | WhatsApp (floating button), forms, email + phone always visible where it matters |
| Hosting | Hostinger shared/business plan |
| Brand | Direction "Puente": Documento mode (light) for translation, Cabina mode (dark) for interpreting |

## 2. Stack

One Laravel application. Public site and admin share models, validation and deploy.

- **Laravel 12** + **Filament 5** at `/admin`.
- **Public front end:** Blade components + Tailwind 4 (Filament already requires it). Brand tokens live in one CSS file as `@theme` variables, used by both the site and the Filament theme.
- **Interactivity:** Livewire (ships with Filament) for forms and file upload; Alpine for small UI (menu, WhatsApp button, accordions). No SPA, no separate API.
- **Database:** MySQL (included with Hostinger).
- **Mail:** SMTP (Hostinger mailbox or a transactional provider; decide at setup).
- **Packages, kept minimal:**
  - `spatie/laravel-translatable` — translatable JSON columns from day one (see §5).
  - `spatie/laravel-sitemap` — sitemap.xml.
  - Nothing else until a need shows up. Media library, permission packages and page builders are deferred (see §10).

## 3. Sitemap (Spanish URLs)

Mode in brackets: **D** = Documento (light), **C** = Cabina (dark).

```
/                                Inicio            both modes, equal weight
/traduccion                      Translation hub   D
/traduccion/{servicio}           e.g. certificada, legal, notariada, escrita   D
/interpretacion                  Interpreting hub  C
/interpretacion/{servicio}       e.g. simultanea, consecutiva, equipos-y-cabinas   C
/cotizacion                      Quote: choose type → form   D
/cotizacion/traduccion           Document quote form   D
/cotizacion/interpretacion       Event quote form   D (forms are always Documento)
/nosotros                        About, team, ATA, clients   D
/blog  ·  /blog/{slug}           D
/preguntas-frecuentes            FAQ (same URL as old site)   D
/contacto                        Contact (same URL as old site)   D
/privacidad                      Privacy policy (LOPDP)   D
```

- The services under each hub come from the CMS. The URL prefix comes from the service's `mode` field, so one field drives both the URL and the visual mode.
- The old site's `/contacto/` and `/preguntas-frecuentes/` keep the same paths. Anything else from the old site gets a 301 (§8).

## 4. Content model (Filament resources)

| Model | Key fields | Notes |
|---|---|---|
| **Service** | title, slug, mode (documento/cabina), summary, body, icon, image, turnaround, featured, sort, published, seo_title, seo_description | Drives hubs, nav, quote form options |
| **Language** | name, iso_code, featured, sort | "Idiomas que trabajamos" list + quote form selects |
| **Post** | title, slug, excerpt, body, cover, published_at, seo_* | Blog; categories deferred |
| **Client** | name, logo, url, sector, **logo_permission** (bool), sort | Logo shown publicly only when permission = true (audit: logo permissions unknown) |
| **Testimonial** | quote, person, role, company, client_id?, published | Optional for MVP; schema costs nothing |
| **Faq** | question, answer, service_id (nullable = global), sort | Shown on /preguntas-frecuentes and per service |
| **Page** | title, slug, body, seo_* | Simple pages only (privacy, about body) |
| **Lead** | type (contacto/traduccion/interpretacion), name, email, phone, company, service_id, source_lang, target_lang, event fields, message, files, consent_at, status (nuevo/contactado/cotizado/ganado/perdido), notes | Inbound inbox in Filament; replaces scattered emails |
| **Settings** (single row) | phones, emails, WhatsApp number + default message, address, map link, socials, founding_year, verified stats, ATA text, hero copy | All contact data editable, so placeholders are swapped later with no deploy |

**Editors:** two roles via a `role` column + policies. **admin** (you) has everything. **editor** (Bridge team) can manage content and leads but not settings or users.

## 5. Multilingual readiness (MVP = es)

- All user-facing text columns (titles, bodies, slugs, SEO fields) are **translatable JSON** via `spatie/laravel-translatable`, with only `es` filled at launch. Adding English later is a data task, not a migration.
- **URLs:** Spanish stays at the root with no prefix (`/traduccion/certificada`). Future locales get a prefix (`/en/translation/certified`). Spanish URLs and rankings never change.
- Interface strings go in `lang/es/*.php` through `__()`. No hard-coded Spanish in Blade.
- The `<html lang>`, `hreflang` and sitemap alternates are generated from a `config('site.locales')` list. With one locale, no hreflang is printed.
- **Deferred:** the Filament translatable plugin (a locale switcher in the admin). Add it with the second locale and check its Filament 5 compatibility at that time.
- The logo descriptor already exists in 7 languages (`brand/logo/`). The header picks it by locale.

## 6. Leads: WhatsApp, forms, contact

**Always visible**
- A header strip on desktop with the phone and email (from Settings). On mobile they move into the menu and footer.
- Footer: phones, emails, address, hours, WhatsApp.
- Every service page ends with a contact block in this order: WhatsApp, phone, email, then the matching quote form link.

**WhatsApp**
- A floating button on every page except the quote forms, where it would cover the submit button.
- Pre-filled message per context, e.g. *"Hola, quisiera cotizar: Traducción certificada"*, built from the current service.
- Plain `https://wa.me/<number>?text=` link. No third-party widget script, so no tracking cookies and no slowdown.
- **Accessibility:** a real `<a>` with a label, at least 48px, kept clear of the phone's safe area, and respecting reduced motion (no pulsing animation).

**Forms** (Livewire, server-side validation)

| Form | Where | Fields beyond name/email/phone |
|---|---|---|
| Contacto rápido | /contacto, service pages | message |
| Cotización traducción | /cotizacion/traduccion | service, language pair, certified/notarized?, deadline, files (PDF/JPG/PNG/DOCX, ≤20 MB, ≤5 files) |
| Cotización interpretación | /cotizacion/interpretacion | service, event date(s), city/venue, attendees, language pairs, needs booths/receivers?, duration |

- **Rules for all forms:**
  - Email or phone is required; not both.
  - Explicit privacy consent checkbox, stored with a timestamp.
  - Honeypot field plus rate limiting per IP.
  - Cloudflare Turnstile only if spam appears.
- **After submit:**
  - Create a Lead.
  - Queue an email to Bridge with a link to the lead in Filament. Attachments are never put in the email.
  - Send the client a confirmation email in Spanish.
  - Show a confirmation page that repeats the WhatsApp option for urgent requests.

## 7. Privacy and uploads (LOPDP, Ecuador)

Clients will upload IDs, deeds and court documents.

- Uploads go to a **private disk** (`storage/app/private`), never `public/`. They're downloadable only from Filament through a signed, time-limited URL.
- **Automatic deletion:** a scheduled job removes lead attachments **90 days** after creation. The period must be confirmed with Bridge and stated in /privacidad.
- Only the files and the fields needed to quote are stored. IPs are kept only for rate limiting and aren't saved on the lead.
- /privacidad states who is responsible for the data, its purpose, the retention period and how to request deletion. Bridge provides the legal text; we provide a template.
- **Analytics:** GA4 runs only after cookie consent. The WhatsApp link sets no cookies.

## 8. SEO continuity and launch

- **Redirects:** a 301 map from every indexed old URL. Crawl bridge-traducciones.com before launch to list them. Pick **one canonical domain** (bridgetraducciones.com vs bridge-traducciones.com is still open) and 301 the other one to it.
- **Structured data:** JSON-LD `ProfessionalService` (name, address, phone, areaServed Ecuador, sameAs), `FAQPage` on the FAQ page, `Article` on blog posts.
- **Per-page SEO:** title and description from the CMS with sensible fallbacks, OG image per service and post, `sitemap.xml` and `robots.txt`.
- **Performance budget for mobile 4G:**
  - LCP under 2.5 s.
  - Fonts self-hosted as WOFF2, subset to Latin plus Latin Extended at launch, with Cyrillic and Greek added with those locales.
  - Images resized on upload with explicit width and height.

## 9. Hosting and deploy (Hostinger shared)

- PHP 8.3 selected in hPanel, MySQL database, SSH and Composer (Business plan).
- The domain document root points at Laravel's `public/` (or a `public_html` symlink).
- **Assets:** Vite builds locally or in GitHub Actions, and the compiled `public/build` is deployed. Don't rely on Node on the server.
- **Deploy:** Git → GitHub Actions → SSH (`git pull`, `composer install --no-dev`, `php artisan migrate --force`, `optimize`). A manual SSH script works at first.
- **Cron**, one hPanel entry: `* * * * * php artisan schedule:run`. The schedule runs `queue:work --stop-when-empty` every minute (database queue driver) and the attachment cleanup daily. Form emails may arrive up to about a minute late; that's acceptable.
- **Backups:** Hostinger daily backups plus a weekly `mysqldump` and private uploads copied off-server.
- **Known ceiling:** no persistent queue worker and limited CPU. If traffic or features grow (search, heavy image processing), move to a Hostinger VPS. The app needs no code changes for that, only the cron is replaced by a supervisor process.

## 10. Deliberately deferred

| Deferred | Add when |
|---|---|
| Filament translatable plugin | Second locale is added |
| Media library package / responsive image sets | Image performance becomes measurable problem |
| Page builder (Filament Builder blocks) | Bridge needs to compose new landing pages without a developer |
| Permission package (e.g. Shield) | More than two roles are needed |
| Blog categories/tags | More than ~20 posts |
| Online payment / price calculator | Bridge publishes fixed prices |
| Turnstile captcha | Spam actually appears |

## 11. Next: prototype

A high-fidelity static prototype, built **before** the Laravel build, to check the Puente system on real pages:

1. **Inicio:** both modes, trust strip (ATA, years, clients), equal paths to both services.
2. **/traduccion/certificada:** Documento mode, certification seal, FAQ, contact block.
3. **/interpretacion/simultanea:** Cabina mode, event-oriented content.
4. **/cotizacion/traduccion:** the full form with upload, plus validation and success states.
5. **Global:** header (phone/email strip, M1 lockup), footer, WhatsApp button, mobile menu.

- **Build:** static HTML + Tailwind 4 + the draft tokens. Markup is split into the same parts the Blade components will use (header, footer, service-card, contact-block, lead-form, seal), so it ports over almost unchanged.
- **Copy:** real Spanish draft copy following the voice rules in DIRECTION.md. Contact data uses placeholders.
- **Output:** the prototype is published as an artifact for review. What we learn from it goes back into the tokens before the brand book is locked.

## 12. Open items for Bridge

1. Canonical domain and the real phones, emails and WhatsApp number.
2. Founding year and the verifiable stats.
3. ATA: individual certification or corporate membership, and permission to use the badge.
4. Legal wording for certified translations, plus the privacy policy text and the retention period.
5. The service list for launch (which services under each hub).
6. Client logo permissions, and a photo shoot (booths, real redacted documents).
