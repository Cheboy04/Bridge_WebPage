# Placeholder register (Bridge Traducciones website)

**Status:** official since 2026-10-16 (P0 Lock).
**Owns:** everything **Bridge** must supply or approve before launch, and where each placeholder currently shows. **Referenced by:** ADR §12, `CLAUDE.md` §5, specs that render Bridge data.

It merges and replaces three earlier lists: the open items of the old `docs/ARCHITECTURE.md` §12, `brand/DIRECTION.md` §11 and the seed list in HANDOFF_v1 §8. Technical decisions that are still open live in the ADR summary, not here.

**Rules**
- **No real values in this file.** The repo is public (ADR D2.2). A row records that Bridge answered, the date, and **where** the answer lives (in `Settings`, the CMS, or Bridge's own records), never the value itself. Contact data goes into `Settings` in the admin, not into code.
- In the interface, an unanswered item keeps its visible label: "[por confirmar]", "[regla de ejemplo, validar con Bridge]", "[año]".
- Close a row with `answered YYYY-MM-DD → <where>`. Don't delete rows.

**Blocks** names the earliest phase that can't finish without the answer (ADR D1.1). An item that can sit in `Settings` blocks only P7 (launch).

| # | Item | Placeholder now | Lives in (when answered) | Blocks | Status |
| --- | --- | --- | --- | --- | --- |
| **Contact and identity** | | | | | |
| 1 | Canonical domain: `bridgetraducciones.com` or `bridge-traducciones.com` | — | ADR §10 (it's also an infra decision) | P7 (301s, sitemap, canonicals) | Open |
| 2 | Phone numbers (landline, mobile) | `+593 2 000 0000` | `Settings` | P7 | Open |
| 3 | WhatsApp business number and default message | `+593 99 000 0000` | `Settings` | P7 | Open |
| 4 | Emails (contact, quotes; where lead notifications go) | `contacto@bridge.example` | `Settings` / mail config | P5 (notification target), P7 | Open |
| 5 | Street address and map link | "Quito, Ecuador" | `Settings` | P7 | Open |
| 6 | Office hours | "Horario: [por confirmar]" | `Settings` | P7 | Open |
| 7 | Social profiles | — | `Settings` | P7 | Open |
| **Claims** | | | | | |
| 8 | Founding year (sources say 16 or 17+ years) | "Desde [año]" | `Settings.founding_year` | P7 | Open |
| 9 | Verifiable stats with source and date (sources disagree: 500+ vs 750+ clients) | none shown | `Settings` + Bridge's facts sheet | P7 (shown only once documented) | Open |
| **Credentials and legal** | | | | | |
| 10 | ATA scope: individual certified translators, corporate membership, or both | "Miembro de la American Translators Association (ATA)" | `Settings.ata_text` | P7 | Open |
| 11 | Permission to show the ATA badge | not shown | — | P7 | Open |
| 12 | The Ecuadorian designation behind "traducción certificada" and "notariada" (ATA alone has no legal standing in Ecuador) | the word "validez legal" is not used | service copy in the CMS | P4 (service copy) | Open |
| 13 | Privacy policy text (LOPDP): controller, purpose, rights | template to come | `Page` "privacidad" | P5 (forms link to it), P7 | Open |
| 14 | Attachment retention period (90 days proposed) | 90 in config | `config('leads.attachments')` + `/privacidad` | P5 (also ADR summary #2) | Open |
| **Catalogue** | | | | | |
| 15 | Launch service list per hub (Traducción, Interpretación) | 6 services in the prototype nav | `Service` | P4 | Open |
| 16 | Language list, with the services offered per language | 14 example languages | `Language` | P4 | Open |
| 17 | Turnaround times per service | "Plazo de entrega: [por confirmar]" | `Service.turnaround` | P4 | Open |
| 18 | How unlisted language pairs are handled ("traductores aliados") | "[validar con Bridge]" | LangChecker copy | P4 | Open |
| **Event planner rules** | | | | | |
| 19 | Interpreters per language (2), ×1.5 above 6 h, receivers = attendees + 10 %, 1 technician per room | "[regla de ejemplo, validar con Bridge]" | `config('planner')` | P4 (labels stay until confirmed) | Open |
| 20 | Half day ≤ 6 h, full day about 8 h | "[horas por confirmar]" | `config('planner')` | P4 | Open |
| 21 | Booking lead time ("4–6 weeks") | — | interpreting copy | P4 | Open |
| **Assets and approvals** | | | | | |
| 22 | Certification stamp: choose among S1–S5 (recommended S2 official + S3 working) | provisional S1-based seal | `brand/` + `<x-seal>` | Locking the Seal in P0; P4 | Open (also ADR summary #6) |
| 23 | Translator sign-off of the hero sentence in EN, FR, PT | the three translations in `sig-hero.js` | `config('site.hero.sentence')` | P4 | Open |
| 24 | Home order: Documento first (current default) or Cabina first | Documento first | home view | P4 | Accepted by default, confirm |
| 25 | Hero hook "Del original a la firma. Del orador al oído." (two alternatives offered) | the hook | `lang/es` | P4 | Accepted by default, confirm |
| 26 | Client logo permissions (written), at least six for the row | row hidden | `Client.logo_permission` | P7 | Open |
| 27 | Photo shoot: a real booth event and redacted certified documents | interim booth photo (consent held by Bridge, ADR D2.2) | media library | P4 (Documento imagery parity) | Open |
| 28 | Licence of `Interpreting Booth Hero image.png`, or drop it | not used | — | P4 | Open |
| 29 | Legal-entity name for the footer © line | "© [año] Bridge Traducciones" | `Settings` | P7 | Open |

## Change log

- `2026-10-16` — created in P0 from ARCHITECTURE §12, DIRECTION §11 and HANDOFF_v1 §8 (seed list), plus the open labels found in the prototype.
