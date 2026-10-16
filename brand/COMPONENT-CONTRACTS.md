# Component contracts — code layer (Bridge Traducciones website)

**Status:** approved draft since 2026-10-16 (P0 Lock). Becomes binding as each component's story enters P4/P5.
**Owns:** the **code layer** of every component (ADR D3.8): Blade name, props, data source, events and query parameters. **Referenced by:** the brand book (each component's "Code contract" link), specs in `docs/specs/`.

The other two layers are owned elsewhere and not repeated here: **design** (anatomy, states, tokens) in the brand book [Bridge Puente](https://claude.ai/artifact/JCunauKZ4Binpf7tXxQmuo); **behaviour** (timings, a11y, rules) in [`SIGNATURE-COMPONENTS.md`](SIGNATURE-COMPONENTS.md) and [`DIRECTION.md`](DIRECTION.md). The reference implementation is `prototype/src/components/<partial>.html`: its header comment lists the params these props come from.

**Conventions for every component**
- Blade anonymous components in `site/resources/views/components/`, names per `docs/nomenclatura.md` §2–3 (`<x-contact-block>`, signature ones `<x-sig-…>`).
- Visible strings go through `__()` (`lang/es/…`); the prototype's Spanish strings are the `es` values. Contact data always comes from `Settings` (ADR D4.1), never from props or literals.
- "Gallery-only" params of the prototype (`state="is-hover|is-focus"`, `demo`) are **not** props: hover and focus come from CSS.
- Mode: a component either follows the section's mode (semantic tokens) or pins one with `mode-documento` / `mode-cabina`, as stated per row.
- A **query-parameter contract** is the only coupling between a signature component and a form: unknown or out-of-range values are ignored (never an error), read in Livewire with `#[Url]`.

---

## Actions

### Button

`<x-button>` · prototype `button.html` · follows the mode.

| Prop | Type | Default | Notes |
| --- | --- | --- | --- |
| `label` | string | — | Infinitive verb ("Solicitar cotización"). |
| `href` | ?string | null | Renders `<a>` when set, otherwise `<button>`. |
| `type` | string | `button` | Only for `<button>`: `button` or `submit`. |
| `variant` | `primary`\|`secondary` | `primary` | One primary per view. |
| `icon` | ?string | null | Lucide sprite id without `i-` (e.g. `arrow-right`). |
| `disabled` | bool | false | Adds `disabled aria-disabled="true"`. |
| `title` | ?string | null | Tooltip; production links never need it. |

Data: none. Events: none.

### WhatsApp

`<x-whatsapp>` · prototype `whatsapp.html` · fixed, Bridge blue in both modes.

| Prop | Type | Default | Notes |
| --- | --- | --- | --- |
| `message` | ?string | `Settings.whatsapp_default_message` | Plain text; the component URL-encodes it. Service pages pass "Hola, quisiera cotizar: {service title}". |

Data: `Settings.whatsapp_number`. Rendered by the layout on every page **except** routes named `quote.*` (it would cover the submit button). Plain `https://wa.me/<number>?text=` link, `target="_blank" rel="noopener"`, no third-party script.

## Forms (always Documento)

All five are used inside the Livewire lead forms (ADR 4.3 OPEN decides Livewire rules vs Form Requests; these contracts work with either). Shared props:

| Prop | Type | Default | Notes |
| --- | --- | --- | --- |
| `id` | string | — | Unique per page; also prefixes `-hint` / `-err`. |
| `name` | string | — | Form field name; also the `wire:model` target. |
| `label` | string | — | Visible label; FieldCheck allows inline HTML for the privacy link. |
| `hint` | ?string | null | Persistent help text (`aria-describedby`). |
| `error` | ?string | `$errors->first(name)` | Shown with an icon beside the field, sets `aria-invalid`. Error summary on submit: ADR D3.1. |
| `required` | bool | false | Adds "(obligatorio)" to the label. |
| `disabled` | bool | false | |

### FieldText

`<x-field-text>` · `field-text.html`. Extra: `type` (`text`\|`email`\|`tel`, `tel` adds `inputmode="tel"`), `value`, `placeholder`, `autocomplete`.

### FieldSelect

`<x-field-select>` · `field-select.html`. Extra: `options` (array `value => label`, or a slot), `placeholder` (first empty option). Data: services from `Service` (published, by mode), languages from `Language` (sorted, featured first).

### FieldTextarea

`<x-field-textarea>` · `field-textarea.html`. Extra: `value`, `placeholder`, `rows` (default 4).

### FieldFile

`<x-field-file>` · `field-file.html` · Alpine for the drop zone and file list; Livewire `WithFileUploads`. Extra: `accept` (default `.pdf,.jpg,.jpeg,.png,.docx`). Limits (5 files, 20 MB each) come from `config('leads.attachments')` (ADR D7.1) and appear in the drop-zone copy. Files go to the private disk only.

### FieldCheck

`<x-field-check>` · `field-check.html`. Used for privacy consent: `name="consent"`, `required`, label links `route('privacy')`. A checked consent sets `Lead.consent_at` (ADR D8.5).

## Content

### SectionHeading

`<x-section-heading>` · `section-heading.html` · follows the mode.

| Prop | Type | Default | Notes |
| --- | --- | --- | --- |
| `title` | string | — | Heading text (soft hyphens allowed). |
| `label` | ?string | null | The one eyebrow per section, naming a mode or service. |
| `lead` | ?string | null | Lead paragraph, max 52ch. |
| `tag` | `h1`…`h3` | `h2` | |
| `id` | ?string | null | Anchor target. |
| `trail` | bool | false | Draws the section connector above (LivingTrail). |

### ServiceCard

`<x-service-card :service="$service">` · `service-card.html` · follows the mode.

| Prop | Type | Default | Notes |
| --- | --- | --- | --- |
| `service` | `Service` | — | Supplies `title`, `summary` (text), `icon`, `turnaround` (meta, "Plazo de entrega: …"), and the href `route('services.show', $service)`. |
| `open` | bool | false | Open-list row (divider, no fill), the de-boxed default; boxed card only in the page's one card grid. |
| `linklabel` | string | "Ver servicio" | Specific text when needed ("Ver servicio de interpretación"). |

### FaqAccordion

`<x-faq-accordion :faq="$faq">` · `faq-accordion.html` · native `<details>`; wrap items in `<div class="faq">`.

| Prop | Type | Default | Notes |
| --- | --- | --- | --- |
| `faq` | `Faq` | — | `question`, `answer`. |
| `group` | ?string | null | Shared `name` for exclusive opening. |
| `open` | bool | false | |

Data: `Faq` global (`service_id` null) on `/preguntas-frecuentes`, per service on service pages. The FAQ page also emits `FAQPage` JSON-LD from the same records.

### Breadcrumb

`<x-breadcrumb>` · `breadcrumb.html`. Props: `items` (array of `['label' => …, 'href' => …]`, after "Inicio"), `current` (string), `label` (default "Migas de pan"). Data: the hub from the service's `mode`.

### ContactBlock

`<x-contact-block>` · `contact-block.html` · order fixed: WhatsApp, phone, email, quote.

| Prop | Type | Default | Notes |
| --- | --- | --- | --- |
| `message` | ?string | `Settings.whatsapp_default_message` | WhatsApp text for this context. |
| `quote` | ?string | `route('quote')` | Service pages pass `route('quote.translation')` or `route('quote.interpreting')` by the service's `mode`. |

Data: `Settings` phones, emails, WhatsApp number.

### TrustStrip

`<x-trust-strip>` · `trust-strip.html`. Props: `label` (default "Respaldo"). Data: `Settings.ata_text`, `Settings.founding_year` (rendered "Desde {year}"; while null, the row reads "[por confirmar]"), city. The client-logo row renders **only** when at least one `Client` has `logo_permission = true` (at least six for the fixed row, `DIRECTION.md` §10); otherwise the row is omitted entirely.

### Seal

`<x-seal>` · `seal.html` · Documento only. Props: `uid` (unique per page, for its `textPath` ids), `size` (px, default 240). **Provisional**: the stamp is OPEN (ADR summary #6). This contract can't be locked until the stamp is chosen; production keeps `data-provisional` and the "diseño provisional" label until then.

## Layout

### Header

`<x-header>` · `header.html` · Alpine menu (focus trap, Esc closes, focus returns to the toggle; desktop nav from `breakpoint-xl`).

| Prop | Type | Default | Notes |
| --- | --- | --- | --- |
| `active` | ?string | null | `translation`\|`interpreting`\|`about`\|`blog`\|`faq`\|`contact`; sets `aria-current="page"`. |
| `mode` | `documento`\|`cabina` | `documento` | Follows the section under it on service pages only; Home stays Documento. |

Data: nav items from `config('site.nav')` with route names; phone and email from `Settings`; the lockup `-light`/`-dark` by mode and descriptor by `app()->getLocale()`.

### Footer

`<x-footer>` · `footer.html` · `mode-cabina` (Tinta) in both modes. No props. Data: services list from `Service` (published), company links from `config('site.nav')`, contact from `Settings`, the descriptor cycle from `config('site.descriptors')` (the seven names), the year from `now()`. Behaviour (cycle, pause, reduced motion): `SIGNATURE-COMPONENTS.md` §6.

## Signature

### HeroStage

`<x-sig-hero>` · `sig-hero.html` + `resources/js/sig-hero.js` · Home only, once per page (fixed `hero-*` ids).

Props: none. Data: the demo sentence in ES/EN/FR/PT from `config('site.hero.sentence')` (keys `es`, `en`, `fr`, `pt`; the translations need sign-off by Bridge's translators, placeholder register). Channel labels from `lang/es/hero.php`. Storage: `sessionStorage['bridge-hero-tab']` = `doc`\|`evt` (try/catch). Events: none outside the component. Behaviour: `SIGNATURE-COMPONENTS.md` §1.

### LangChecker

`<x-sig-lang-checker>` · `sig-lang-checker.html` + `resources/js/sig-documento.js` · Documento.

| Prop | Type | Default | Notes |
| --- | --- | --- | --- |
| `uid` | string | — | Unique per page. |
| `level` | 2\|3 | 2 | Heading level. |
| `title` | ?string | "¿De qué idioma a qué idioma?" | |

Data: `Language::published()` serialised into the inline `<script type="application/json" data-lc-data>` as `{"languages":[{"code","name","services":["certificada","legal","notariada"],"featured"}]}` (the shape of `prototype/src/assets/data/languages.json`). `services[]` are service slugs. **Emits** the CTA `route('quote.translation', ['origen' => code, 'destino' => code])`; an unlisted pair links WhatsApp with the pair in the message.

### EventPlanner

`<x-sig-event-planner>` · `sig-event-planner.html` + `resources/js/sig-cabina.js` · `mode-cabina`, on `/interpretacion/simultanea`.

Props: none. Data: the rules from `config('planner')` (interpreters per language, ×1.5 above 6 h, receivers +10 %, one technician per room, half day ≤ 6 h, full day about 8 h). **They are example rules until Bridge confirms them** (placeholder register), and the panel keeps "[regla de ejemplo, validar con Bridge]". The JS computes the same formulas client-side; the server renders the default output (presencial, jornada, 1 idioma, 120 asistentes) so it is complete at rest. **Emits** `route('quote.interpreting', [...])` with the query contract below.

### BeforeAfter

`<x-sig-before-after>` · `sig-before-after.html` + `resources/js/sig-documento.js` · Documento, on `/traduccion/certificada`. Props: `uid` (unique per page), `level` (default 2). Data: the sample birth certificate is static copy in `lang/es/before-after.php`, every name and number a fake placeholder. Embeds `<x-seal>` (provisional). Range input 0–100, default 50.

### LivingTrail

`<x-trail>` and `<x-process-steps>` · CSS only (`.trail-v`, `.trail-h`, `.step-dot`, `.process` in `app.css`). `<x-trail>` props: `dots` (int, default 2, sets `--n`), `target` (bool, the 1.5× end dot). `<x-process-steps>` props: `steps` (array of `['title' => …, 'text' => …]`, copy from `lang/es`). No JS. Colour from `trail`. Behaviour: `SIGNATURE-COMPONENTS.md` §5.

---

## Query-parameter contracts

| Route | Param | Accepted values | Set by |
| --- | --- | --- | --- |
| `quote.translation` (`/cotizacion/traduccion`) | `origen`, `destino` | a published `Language.code` | LangChecker |
| | `servicio` | a published Documento `Service.slug` | ServiceCard / service pages |
| `quote.interpreting` (`/cotizacion/interpretacion`) | `modalidad` | `presencial` \| `hibrido` \| `remoto` | EventPlanner |
| | `duracion` | `medio` \| `jornada` \| `varios` | EventPlanner |
| | `dias` | integer 2–30 (only with `varios`) | EventPlanner |
| | `idiomas` | integer 1–4 | EventPlanner |
| | `asistentes` | integer 20–1000 | EventPlanner |

The query parameter names are Spanish because they are public URLs (`docs/nomenclatura.md` §1). In PHP they map to English properties (`#[Url(as: 'origen')] public ?string $sourceLanguage`). Any other value is dropped silently, and the form shows its default.

## Change log

- `2026-10-16` — created in P0 from the prototype partials, `ARCHITECTURE.md` and ADR D3.6–D8.5.
