# Official backlog

**Status:** baseline draft since 2026-10-16, pending the owner's approval. An official ticket is not thereby Ready and does not commit to a delivery date.

## Authority and use

This backlog breaks down [the roadmap](roadmap.md) and follows the [common format](backlog-format.md). The ADR, `CLAUDE.md` and the [methodology](../global/metodologia-sdd-tdd.md) prevail. The scope comes from the requirements below (**derived on 2026-10-16** from `docs/ARCHITECTURE.md`, ADR D3.6–D9.1, `brand/DIRECTION.md` and `brand/SIGNATURE-COMPONENTS.md`; there is no separate requirements document).

Until the backlog is loaded into GitHub Issues, this catalog is its design. After that, GitHub Issues is the source of truth (including each story's acceptance criteria) and only the design stays here; real keys live in [`key-map.md`](key-map.md).

**No story points:** the estimation anchor is OPEN (ADR 1.5) and delivery is phase-based (D1.1). The SP column stays empty until estimation is adopted.

## Requirements (derived)

| ID | Requirement | Source |
| --- | --- | --- |
| RF-01 | The public site serves the sitemap's pages in Spanish (home, hubs, service pages, about, blog, FAQ, contact, privacy). | ARCHITECTURE §1 |
| RF-02 | Services are managed in the CMS and drive the hubs, navigation, service pages and visual mode. | D4.1 |
| RF-03 | Languages are managed in the CMS and feed the language list, the checker and the quote forms. | D4.1 |
| RF-04 | Blog posts are managed in the CMS and published at `/blog`. | D4.1 |
| RF-05 | Client logos (only with permission) and testimonials are managed in the CMS. | D4.1, DIRECTION §10 |
| RF-06 | FAQs are managed in the CMS, globally and per service. | D4.1 |
| RF-07 | Contact data, claims and hero copy are editable in Settings without a deploy. | D4.1 |
| RF-08 | The admin has two roles: `admin` (everything) and `editor` (content and leads). | D4.2 |
| RF-09 | A quick contact form creates a lead. | ARCHITECTURE §3 |
| RF-10 | A translation quote form with file upload creates a lead. | ARCHITECTURE §3, D7.1 |
| RF-11 | An interpreting quote form creates a lead, prefilled from the event planner. | ARCHITECTURE §3, COMPONENT-CONTRACTS |
| RF-12 | Leads are managed in an admin inbox with statuses. | D4.1 |
| RF-13 | A new lead emails Bridge (a link, never attachments) and sends the client a confirmation. | ARCHITECTURE §3, D7.1 |
| RF-14 | WhatsApp, phone and email are always reachable (floating button, header strip, footer, contact block). | ARCHITECTURE §3 |
| RF-15 | The six signature components work on their pages (hero, checker, planner, before/after, living trail, multilingual footer). | SIGNATURE-COMPONENTS |
| RF-16 | SEO: per-page metadata, sitemap, robots, JSON-LD and 301s from the old site. | ARCHITECTURE §4 |
| RF-17 | Lead attachments are deleted automatically after the retention period. | D7.1 |
| RNF-01 | Accessibility: WCAG 2.2 AA; 0 axe violations at 390 and 1440 px; every text pair ≥ 4.5:1. | D11.2, DIRECTION §2 |
| RNF-02 | Performance: LCP < 2.5 s on mobile 4G. | ARCHITECTURE §4 |
| RNF-03 | Responsive: no horizontal overflow from 390 to 1440 px. | D11.2 |
| RNF-04 | Privacy (LOPDP): consent, minimal data, private storage, retention, GA4 only after consent. | D7.1, D8.5, 8.6 |
| RNF-05 | Security: admin auth and policies, rate limiting, honeypot, signed downloads, debug off. | D4.5, D8.4, D3.1 |
| RNF-06 | i18n-ready: translatable columns, no hard-coded strings, locale-prefixed URLs later. | D3.6 |
| RNF-07 | Deployable on Hostinger Business: CI-built releases, symlink swap, cron-driven queue. | D9.1 |
| RNF-08 | Motion: complete at rest, reduced-motion fallbacks, no animation libraries. | D3.7, SIGNATURE-COMPONENTS |
| RNF-09 | Visual parity with the prototype and the brand book. | D3.8 |

## Epic catalog

| Local ID | Key | Epic | Outcome and limits | Contents | Window |
| --- | --- | --- | --- | --- | --- |
| `brg-epic-infra` | — | Infrastructure and delivery | `site/` scaffold, quality chain, CI, staging and production deploys, backups. Configured accounts are the owner's. | brg-31, brg-32, brg-33, brg-34, brg-45, brg-46 | P1, P7 |
| `brg-epic-content` | — | Content model and admin | Data model, migrations and Filament resources for every CMS entity, with roles. | brg-35–37, HU-02–HU-09 | P2–P3 |
| `brg-epic-site` | — | Public site | Layout and every public page, at parity with the prototype. | HU-01, HU-10–HU-17, brg-38, brg-39 | P4 |
| `brg-epic-signature` | — | Signature components | The five page-level signature components (the footer is in HU-01). | HU-18–HU-22 | P4 |
| `brg-epic-leads` | — | Leads | Three forms, the inbox, notifications and attachment retention. | HU-23–HU-28 | P5 |
| `brg-epic-launch` | — | Launch | SEO, analytics, hardening, 301s and go-live. | HU-29, HU-30, brg-40–brg-44 | P6–P7 |
| `brg-epic-quality` | — | Quality and acceptance | Cross-cutting: accessibility, performance, parity and the owner's acceptance in every phase. | Checklist items in every story; brg-40, brg-41, brg-47 | P0–P7 |

## Stories

Roles: **visitor** (a legal or corporate client needing a document; an event organiser needing interpreting), **editor** (the Bridge team), **admin** (the owner).

| Local ID | HU | Epic | Title | SP | Release | Target phase | Layer | Risk |
| --- | --- | --- | --- | -: | --- | --- | --- | --- |
| `brg-01` | HU-01 | site | Branded layout: header, footer with the multilingual descriptor, WhatsApp button, Documento/Cabina modes | | R1 | P4 | site | normal |
| `brg-02` | HU-02 | content | Admin sign-in with `admin` and `editor` roles | | R1 | P3 | site | seguridad |
| `brg-03` | HU-03 | content | Editor manages services (mode, copy, turnaround, SEO) | | R1 | P3 | site | normal |
| `brg-04` | HU-04 | content | Editor manages languages and the services per language | | R1 | P3 | site | normal |
| `brg-05` | HU-05 | content | Editor manages FAQs, global and per service | | R1 | P3 | site | normal |
| `brg-06` | HU-06 | content | Editor manages blog posts | | R1 | P3 | site | normal |
| `brg-07` | HU-07 | content | Editor manages clients (logo permission) and testimonials | | R1 | P3 | site | normal |
| `brg-08` | HU-08 | content | Editor manages simple pages (privacy, about body) | | R1 | P3 | site | normal |
| `brg-09` | HU-09 | content | Admin edits site settings (contact data, claims, hero copy) | | R1 | P3 | site | seguridad |
| `brg-10` | HU-10 | site | Visitor sees a home page that gives both services equal weight | | R1 | P4 | site | normal |
| `brg-11` | HU-11 | site | Visitor browses the translation hub and its service pages (Documento) | | R1 | P4 | site | normal |
| `brg-12` | HU-12 | site | Visitor browses the interpreting hub and its service pages (Cabina) | | R1 | P4 | site | normal |
| `brg-13` | HU-13 | site | Visitor reads the about page (team, ATA, permitted client logos) | | R1 | P4 | site | normal |
| `brg-14` | HU-14 | site | Visitor reads the blog list and posts | | R1 | P4 | site | normal |
| `brg-15` | HU-15 | site | Visitor reads the FAQ page | | R1 | P4 | site | normal |
| `brg-16` | HU-16 | site | Visitor finds every contact channel on the contact page | | R1 | P4 | site | normal |
| `brg-17` | HU-17 | site | Visitor reads the privacy policy | | R1 | P4 | site | normal |
| `brg-18` | HU-18 | signature | Hero stage shows a translation and a live channel (home) | | R1 | P4 | site | normal |
| `brg-19` | HU-19 | signature | Visitor checks a language pair and jumps to a prefilled quote | | R1 | P4 | site | normal |
| `brg-20` | HU-20 | signature | Visitor builds an event summary and jumps to a prefilled quote | | R1 | P4 | site | normal |
| `brg-21` | HU-21 | signature | Visitor compares an original with its certified translation | | R1 | P4 | site | normal |
| `brg-22` | HU-22 | signature | The living trail draws section connectors and process steps | | R1 | P4 | site | normal |
| `brg-23` | HU-23 | leads | Visitor sends a quick contact message | | R1 | P5 | site | datos |
| `brg-24` | HU-24 | leads | Visitor requests a translation quote and uploads documents | | R1 | P5 | site | archivos |
| `brg-25` | HU-25 | leads | Visitor requests an interpreting quote | | R1 | P5 | site | datos |
| `brg-26` | HU-26 | leads | Bridge is emailed about each lead and the visitor gets a confirmation | | R1 | P5 | site | normal |
| `brg-27` | HU-27 | leads | Editor works leads in an inbox (status, notes, signed downloads) | | R1 | P5 | site | seguridad |
| `brg-28` | HU-28 | leads | Lead attachments are deleted after the retention period | | R1 | P5 | site | archivos |
| `brg-29` | HU-29 | launch | Search engines get metadata, sitemap, robots and structured data | | R1 | P6 | site | normal |
| `brg-30` | HU-30 | launch | Analytics load only after cookie consent | | R1 | P6 | site | normal |

## Tasks

| Local ID | Epic | Title | Blocks | Window |
| --- | --- | --- | --- | --- |
| `brg-31` | infra | Scaffold Laravel 12 + Filament 5 + Pest, Larastan and Pint in `site/`; brand tokens as Tailwind `@theme`; self-hosted fonts | everything after P1 | P1 |
| `brg-32` | infra | CI quality pipeline on GitHub Actions against MySQL | every PR from P1 | P1 |
| `brg-33` | infra | Release deploy to staging (D9.1 option A). External: SSH, PHP path, cron interval, deploy key, staging subdomain (owner) | the staging demo of every phase | P1 |
| `brg-34` | infra | Decide time zone and primary key type (ADR 3.2, 3.5) | brg-35, brg-36 | P1 |
| `brg-35` | content | ERD slice + migrations + models: content entities (Service, Language, Faq, Post, Client, Testimonial, Page) | HU-03–HU-08 | P2 |
| `brg-36` | content | ERD slice + migrations + models: Settings and Lead | HU-09, HU-23–HU-28 | P2 |
| `brg-37` | content | Factories and seeders (invented data; real public language list) | P3 tests | P2 |
| `brg-38` | site | Error pages 404, 419, 429, 500 (D3.1) | — | P4 |
| `brg-39` | site | Browser check harness for the Laravel site (decide ADR 11.3; port `prototype/check.mjs`) | every P4 story's parity check | P4 (first) |
| `brg-40` | quality | Accessibility and parity audit of every page | R1 acceptance | P6 |
| `brg-41` | quality | Performance budget audit (decide the instrument, ADR 11.2) | R1 acceptance | P6 |
| `brg-42` | launch | Security hardening review (rate limits, headers, debug, uploads) | R1 acceptance | P6 |
| `brg-43` | launch | Observability: decide and set up error and uptime monitoring (ADR 9.3) | R2 | P6 |
| `brg-44` | launch | Crawl the old site and write the 301 map (needs the canonical domain) | R2 | P7 |
| `brg-45` | infra | Production launch: deploy from `main`, DNS, smoke test (external: DNS, domain) | — | P7 |
| `brg-46` | infra | Backups and database rollback runbook (ADR 9.4) | R2 | P7 |
| `brg-47` | quality | P0 Lock: brand book, contracts, shipped timings, placeholder register (done before the board; evidence PR #2) | — | P0 |

## Coverage of approved scope

| Requirement | Main epic | Stories / tasks |
| --- | --- | --- |
| RF-01 | site | HU-10–HU-17 |
| RF-02 | content | HU-03, HU-11, HU-12 |
| RF-03 | content | HU-04, HU-19 |
| RF-04 | content | HU-06, HU-14 |
| RF-05 | content | HU-07, HU-13 |
| RF-06 | content | HU-05, HU-15 |
| RF-07 | content | HU-09 |
| RF-08 | content | HU-02 |
| RF-09 | leads | HU-23 |
| RF-10 | leads | HU-24 |
| RF-11 | leads | HU-20, HU-25 |
| RF-12 | leads | HU-27 |
| RF-13 | leads | HU-26 |
| RF-14 | site | HU-01, HU-16 |
| RF-15 | signature | HU-01 (footer), HU-18–HU-22 |
| RF-16 | launch | HU-29, brg-44 |
| RF-17 | leads | HU-28 |
| RNF-01 | quality | every UI story's checklist; brg-39, brg-40 |
| RNF-02 | quality | brg-41 |
| RNF-03 | quality | every UI story's checklist; brg-39 |
| RNF-04 | leads | HU-23–HU-28, HU-30, HU-17 |
| RNF-05 | launch | HU-02, HU-27, brg-42 |
| RNF-06 | content | brg-35, brg-36, every UI story |
| RNF-07 | infra | brg-32, brg-33, brg-45 |
| RNF-08 | signature | HU-01, HU-18–HU-22 |
| RNF-09 | site | every UI story's checklist; brg-40 |

Every RF and RNF has at least one main epic. Items from the prototype without a requirement behind them (none found on 2026-10-16) would wait for a formal decision.
