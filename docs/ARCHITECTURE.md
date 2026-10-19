# Bridge Traducciones — Site Architecture (overview)

**Status:** approved 2026-10-15; trimmed to an overview on 2026-10-16.
**Owns:** the site's information architecture: sitemap, content-model draft, lead touchpoints and the SEO plan. **Referenced by:** ADR D4.1 and §12, `CLAUDE.md` §3.

**Every technical decision lives in the ADR** (`docs/adr/decisiones-tecnicas.md`): stack D2.3/D3.7, i18n D3.6, uploads D7.1, privacy D8.5, hosting and deploy D9.1, deferred items D3.9. What Bridge must supply lives in the placeholder register (ADR §12). The former sections on constraints, stack, i18n, privacy, hosting, deferred items, the prototype plan and the open items for Bridge were moved there on 2026-10-16.

## 1. Sitemap (Spanish URLs)

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
- The old site's `/contacto/` and `/preguntas-frecuentes/` keep the same paths. Anything else from the old site gets a 301 (§4).

## 2. Content model draft (Filament resources)

The model list and roles are decided in ADR D4.1–D4.2. These field lists are the **draft** for the P2 ERD slices; the ERD owns columns once a slice is approved. **Approved 2026-10-19:** Service, Language, Post, Client, Testimonial, Faq and Page → [`docs/erd/modelo-contenido.md`](erd/modelo-contenido.md) (the rows below are superseded for them). Lead and Settings → [`docs/erd/modelo-leads-settings.md`](erd/modelo-leads-settings.md) (2026-10-19).

| Model | Key fields (draft) |
| --- | --- |
| **Service** | title, slug, mode (documento/cabina), summary, body, icon, image, turnaround, featured, sort, published, seo_title, seo_description |
| **Language** | name, iso_code, featured, sort |
| **Post** | title, slug, excerpt, body, cover, published_at, seo_* |
| **Client** | name, logo, url, sector, logo_permission (bool), sort |
| **Testimonial** | quote, person, role, company, client_id?, published |
| **Faq** | question, answer, service_id (nullable = global), sort |
| **Page** | title, slug, body, seo_* |
| **Lead** | type, name, email, phone, company, service_id, source_lang, target_lang, event fields, message, files, consent_at, status, notes |
| **Settings** (single row) | phones, emails, WhatsApp number + default message, address, map link, socials, founding_year, verified stats, ATA text, hero copy |

## 3. Lead touchpoints

**Always visible**
- A header strip on desktop with the phone and email (from Settings). On mobile they move into the menu and footer.
- Footer: phones, emails, address, hours, WhatsApp.
- Every service page ends with a contact block in this order: WhatsApp, phone, email, then the matching quote form link.

**WhatsApp**
- A floating button on every page except the quote forms, where it would cover the submit button.
- Pre-filled message per context, e.g. *"Hola, quisiera cotizar: Traducción certificada"*, built from the current service.
- Plain `https://wa.me/<number>?text=` link. No third-party widget script, so no tracking cookies and no slowdown.
- **Accessibility:** a real `<a>` with a label, at least 48px, kept clear of the phone's safe area, and respecting reduced motion (no pulsing animation).

**Forms** (validation approach: ADR 4.3 OPEN; uploads: D7.1; consent and spam: D8.4–D8.5)

| Form | Where | Fields beyond name/email/phone |
| --- | --- | --- |
| Contacto rápido | /contacto, service pages | message |
| Cotización traducción | /cotizacion/traduccion | service, language pair, certified/notarized?, deadline, files |
| Cotización interpretación | /cotizacion/interpretacion | service, event date(s), city/venue, attendees, language pairs, needs booths/receivers?, duration |

- Email **or** phone is required; not both.
- **After submit:** create a Lead; queue an email to Bridge with a link to the lead in Filament (never the attachments); send the client a confirmation email in Spanish; show a confirmation page that repeats the WhatsApp option for urgent requests.

## 4. SEO continuity and launch

- **Redirects:** a 301 map from every indexed old URL. Crawl bridge-traducciones.com before launch to list them. One canonical domain (ADR §10, OPEN) and a 301 from the other one.
- **Structured data:** JSON-LD `ProfessionalService` (name, address, phone, areaServed Ecuador, sameAs), `FAQPage` on the FAQ page, `Article` on blog posts.
- **Per-page SEO:** title and description from the CMS with sensible fallbacks, OG image per service and post, `sitemap.xml` and `robots.txt`.
- **Performance budget for mobile 4G** (measurement instrument: ADR 11.2):
  - LCP under 2.5 s.
  - Fonts self-hosted as WOFF2, subset to Latin plus Latin Extended at launch, with Cyrillic and Greek added with those locales.
  - Images resized on upload with explicit width and height.
