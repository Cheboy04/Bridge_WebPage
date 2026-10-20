# Signature components

Status: approved by client 2026-10-15 (all six). **Owns the behaviour layer** (ADR D3.8); exact values locked 2026-10-16 in "Shipped behaviour" below. Inspiration: expertweb.com.ec (principles only: show the service working, a stage per service, process that progresses on scroll). Do not copy its look; it shares our navy + amber palette, so keep amber on the trail only and avoid its capsule nav.

**Thesis:** Bridge's product is invisible (a translated document, a voice in an ear). Each signature component makes one part of it visible.

## Shared rules (apply to all six)

1. **Complete at rest.** Without JS or with `prefers-reduced-motion: reduce`, every component shows its final, meaningful state (translated text, chosen channel, full trail). Animation only plays *from* the original state when motion is allowed. Never `opacity: 0` waiting for an observer.
2. **One signature moment per page.** Home: the hero. Traducción certificada: before/after. Interpretación simultánea: event planner. The living trail and the footer are system-wide and quiet.
3. **Accessible controls.** Native elements first (`button`, `input type=range`, `select`, `fieldset`). Tabs follow the ARIA tabs pattern. Visible focus. Targets of at least 44px. Live regions only announce user-triggered changes, never auto-cycling content.
4. **No libraries** beyond Alpine (already loaded). CSS scroll-driven animations (`animation-timeline: view()`) inside `@supports` and `prefers-reduced-motion: no-preference`; otherwise static. Transform and opacity only.
5. **Data is real or labelled.** Rules and numbers not confirmed by Bridge carry a visible "[regla de ejemplo, validar con Bridge]" or "[por confirmar]".
6. **Ports to Laravel.** Each one is a Blade component later; data comes from the CMS (Language model, Settings) or config. Prefill uses query parameters, which Livewire reads with `#[Url]`.
7. **Radius:** stages use `--radius-lg` (24px), controls `--radius-full`. See DIRECTION.md §5. On the R1 pages (Home, Traducción certificada) stages are square-edged (DIRECTION.md §5, R1 de-boxing).

---

## 1. Hero "Del original a la firma. Del orador al oído." (home)

> **Superseded on Home by the R1 arrival (BRG-68, 2026-10-19)**, see "R1 remaster" below. The tabbed stage described here remains the component contract for the gallery (`componentes.html`) and any page not yet remastered.

**H1:** `<h1>` contains the hook line large and, on a second line at about 40% size, "Traducción certificada e interpretación simultánea en Quito" (keeps search keywords).

**Stage** (right column desktop, below CTAs on mobile, `--radius-lg`): a segmented control with two tabs, **Documento** and **Evento**.

- **Documento state** (light stage): a document fragment. An English source sentence sits on top. Below it, the Spanish translation writes in phrase by phrase (about 1.6s total), then the provisional seal settles in with a short scale and opacity change (240ms). It ends on a signature line and "Folio [N.º 0000]". A small "Repetir" text button replays it.
- **Evento state** (Cabina stage, dark): a receiver UI. It shows a speaker line ("Orador · Sala 2"), a channel selector (ES, EN, FR, PT as `--radius-full` buttons with `aria-pressed`), a caption line showing the same sentence in the chosen language, and a 5-dot level meter (trail dots, amber) that pulses gently while motion is allowed. Changing channel swaps the caption with a quick crossfade. A polite live region announces "Canal inglés" etc. on user change only.
- **Default tab:** Documento (home order). Remember the last tab per visit with try/catch `sessionStorage`.
- **Copy:** one real sentence relevant to both audiences, correctly translated in four languages, e.g. ES "Las partes acuerdan los términos del presente contrato." Provide EN, FR, PT translations that are accurate.
- **Below 768px:** the stage keeps both tabs but drops the document's source line to keep height under about 420px.

## 2. Language-pair checker (home + Traducción certificada)

"¿De qué idioma a qué idioma?" Two native selects (origen, destino) with a swap button.

**Result panel** (updates on change; polite live region):
- **Supported pair** (both languages listed and one of them is Spanish; see "Shipped behaviour"): "Sí, trabajamos [origen] → [destino]", then which services apply (certificada, legal, notariada) and the turnaround "[por confirmar]". Primary button "Cotizar este par" links to `cotizacion-traduccion.html?origen=xx&destino=yy`.
- **Unlisted pair:** "Consúltenos: coordinamos este par con traductores aliados [validar con Bridge]". It has a WhatsApp link pre-filled with the pair.
- **Same language:** an inline error.

**Data:** `src/assets/data/languages.json` mirrors the CMS Language model (`code`, `name`, `services[]`, `featured`). Mark it as example data.

**Prefill:** the quote form reads `origen`, `destino`, `servicio` from the URL and preselects them. Unknown values are ignored safely.

## 3. Event planner (Interpretación simultánea)

"Arme el resumen de su evento". Inputs: modalidad (presencial / híbrido / remoto, segmented), duración (medio día / jornada completa / varios días + number of days), idiomas además del español (1 to 4, stepper), asistentes (range 20 to 1000, with a number input mirror).

**Live output** ("Lo que su evento necesitaría", amber trail dots as row markers on Cabina):
- intérpretes = 2 × idiomas (× 1.5 rounded up if más de 6 h)
- cabinas = idiomas (presencial and híbrido only)
- receptores = asistentes + 10% margin (presencial and híbrido)
- plataforma con canales de idioma (remoto and híbrido)
- técnico en sala = 1 per sala (presencial and híbrido)

Every rule shows "[regla de ejemplo, validar con Bridge]" once, at the panel foot. The button "Usar este resumen en mi cotización" links to `cotizacion-interpretacion.html?modalidad=&duracion=&dias=&idiomas=&asistentes=`. The event quote form (new page) reads these and prefills.

## 4. Before/after certified document (Traducción certificada)

A stage showing one document twice, stacked: the original (English, plain) and the certified Spanish version (translator's declaration, seal, signature line). A draggable divider reveals one over the other using `clip-path` driven by an `input type=range` (0 to 100, default 50). The range is visually styled as a handle with a vertical rule, keyboard operable. **Affordance (revised 2026-10-19 at the owner's request):** until the user first acts, the handle is a labelled pill "‹› Deslice"; after the first drag, key or tap it collapses to the round handle. The side labels "Original" and "Traducción certificada" are native buttons: a tap glides the divider to show that whole version. The how-to line ("Arrastre la barra o toque «Original» y «Traducción certificada». Con el teclado, use las flechas.") shows only while the slider exists.

- **Reduced motion / no JS:** both versions side by side (desktop) or stacked (mobile), no slider.
- **Content:** a redacted-looking sample (birth certificate). Names and numbers are clearly fake placeholders.

## 5. Living trail (system-wide)

- **Section connectors:** the existing connectors draw dot by dot as they enter the viewport (`animation-timeline: view()`, staggered with `animation-range`).
- **Process steps** (home "Cómo trabajamos", service pages): the dots between steps fill from source to target as the list scrolls through the viewport, and each step marker turns from outline to solid when its range is reached.
- **Fallback:** fully drawn, solid markers.
- **Color rules:** unchanged (blue on light, amber on Tinta, white on blue).
- **Never:** scroll-jacking, pinning, or moving text.

## 6. Multilingual footer

A large Bridge wordmark (outlined SVG from `brand/logo/lockup/bridge-wordmark-dark.svg`), full container width at desktop, at least 160px wide on mobile. Under it, the descriptor slot cycles **Traducciones → Translations → Traductions → Traduções → Übersetzungen → Переводы → Μεταφράσεις**, with a vertical slide every 2.4s.

- **Pause:** the cycle pauses on hover or focus within the footer, and when the tab is hidden.
- **Screen readers:** the cycling element is `aria-hidden`. A visually hidden static text reads "Bridge Traducciones".
- **Reduced motion:** a static line listing all seven names separated by middots, in `--text-muted`.
- **Script support:** the slot is sized for "Übersetzungen" and uses Manrope (Cyrillic and Greek supported).

---

## Shipped behaviour — exact values (locked 2026-10-16, P0)

Read from the reference implementation (`prototype/src/styles/app.css`, `sig-documento.css`, `sig-cabina.css`, `prototype/src/assets/js/sig-*.js`). The Laravel port must reproduce these values; changing one means changing this table first. Token names refer to `--dur-*` / `--ease-*` (brand book, `DIRECTION.md` §9). "Motion allowed" means `prefers-reduced-motion: no-preference`; otherwise the final state shows with no animation.

### 1. Hero stage

| Element | Animation | Duration | Delay | Easing |
| --- | --- | --- | --- | --- |
| Translation phrases (4 `.ph` spans) | opacity 0→1, translateY 5px→0 | 400ms each | `index × 400ms` (0, 400, 800, 1200) | `ease-out` |
| Seal | opacity 0→1, scale 1.25→1 | 240ms | 1700ms | `ease-out` |
| Signature line | scaleX 0→1 from the left | 320ms | 1750ms | `ease-out` |
| Caption on channel change | opacity 1→0, swap text, 0→1 | 120ms out (`dur-instant`) | text swaps at 120ms | `ease-out` |
| Level meter (5 dots) | opacity low→1→low, infinite | 1.8s cycle | `dot index × 140ms` | ease-in-out |
| Tab and chip state | background and colour | 200ms (`dur-base`) | — | `ease-out` |

- The document sequence replays on every selection of the Documento tab and on "Repetir" (shown only when JS runs). The whole sequence lasts about 2.07s.
- Meter resting opacities: dots 1–3 at 0.65, dots 4–5 at 0.25 (static at rest: 1–3 full, 4–5 at 0.3).
- Tabs: ArrowLeft/ArrowRight wrap, Home/End jump; the chosen tab is stored in `sessionStorage['bridge-hero-tab']` (`doc`|`evt`) and restored on load without replaying the announcement.
- The live region announces "Canal inglés" etc. only on a user's channel change.
- Without JS both panels are stacked in their final state and the tablist is hidden.

### 2. Language-pair checker

- No animation. The result is a polite, atomic live region that updates on `change` of either select and on swap.
- **Supported pair rule (as shipped):** both languages are listed **and one of them is Spanish**. The services shown are the intersection of the two languages' `services`. Any other pair (including two listed non-Spanish languages) shows "Consúltenos" with the WhatsApp link. Same language on both sides: inline error on the "Traducir a" select (`aria-invalid`).
- Without JS: the selects stay disabled and the static es → en result shows.

### 3. Event planner

| Element | Behaviour | Value |
| --- | --- | --- |
| Output number change | opacity 0.35→1, translateY 4px→0 | 320ms (`dur-slow`), `ease-out` |
| Live summary for screen readers | debounced after the last input, never on load | 800ms |
| Range ↔ number input | mirrored on input; out-of-range numbers clamp on blur | asistentes 20–1000 (range step 10), idiomas 1–4, días 2–30 |

The formulas (example rules until Bridge confirms them, placeholder register #19–20): interpreters = ceil(2 × languages × 1.5) for "jornada" and "varios" (more than 6 h), 2 × languages for "medio"; booths = languages (presencial, híbrido); receivers = ceil(attendees × 1.1) (presencial, híbrido); platform (remoto, híbrido); 1 technician per room (presencial, híbrido).

### 4. Before/after document

| Element | Behaviour | Value |
| --- | --- | --- |
| Intro sweep | once, when 55 % of the stage is visible; from "original only" (100) to the middle (50) | 1100ms, ease-out cubic (`1 − (1 − t)³`) |
| Cancel | any user input cancels the sweep | — |
| Knob while dragging | scale 1.06 | — |
| Knob label "Deslice" | pill 7.5rem wide until the first user input or tap; then the 3rem round knob. Clamp keeps either size inside the stage (`--kw`) | — |
| "Original" / "Traducción certificada" buttons | glide the divider to 100 / 0; cancel any running glide; count as first use | 600ms, ease-out cubic; min-height 44px |
| Range | 0–100, step 1, default 50 | `aria-valuetext`: "Mostrando el original" at ≥ 98, "Mostrando la traducción certificada" at ≤ 2, otherwise both percentages |

- The slider exists only with JS **and** motion allowed. Otherwise both sheets show side by side (desktop) or stacked (mobile), without the jump buttons or the how-to line.
- The intro sweep is skipped if the user already acted before the stage came into view.
- Desktop (≥ `breakpoint-lg`): text column and stage at 5fr / 7fr, gap 4rem. The knob is clamped inside the stage with `cqw` units (HANDOFF_v1 trap 10).

### 5. Living trail

| Element | Timeline | Range | Timing |
| --- | --- | --- | --- |
| Section connector `.trail-v` | `view()` | entry 10 % → entry 100 % | `steps(--n, jump-end)`: dot by dot |
| Process step 1 dot fill | `--proc` (the whole list) | cover 4 % → 10 % | `ease-out` |
| Trail 1 → 2 | `--proc` | cover 10 % → 26 % | linear |
| Step 2 dot fill | `--proc` | cover 26 % → 32 % | `ease-out` |
| Trail 2 → 3 | `--proc` | cover 32 % → 48 % | linear |
| Step 3 dot fill | `--proc` | cover 48 % → 54 % | `ease-out` |

- Only inside `@supports (animation-timeline: view())` and motion allowed. The dot reveal uses `clip-path` (a deliberate paint-only exception to "transform and opacity only").
- Resting state: fully drawn, solid markers.

### 6. Multilingual footer

| Element | Behaviour | Value |
| --- | --- | --- |
| Descriptor cycle | 7 names + the first repeated, vertical slide | 16.8s loop = 2.4s per name: hold about 1.97s, slide about 0.43s; `cubic-bezier(0.2, 0, 0, 1)` |
| Pause | on `:hover` or `:focus-within` of the footer, and while `document.hidden` | — |
| Reduced motion | static line of all seven names joined by middots, `text-muted` | — |

### R1 remaster (Home and Traducción certificada, BRG-68, 2026-10-19)

Pages opt in with `body.page-home-r1` / `body.page-certified-r1`; styles live in `prototype/src/styles/remaster-r1.css`, every selector rooted at an opt-in class.

| Element | Behaviour | Value |
| --- | --- | --- |
| Home arrival (signature moment) | source phrase → target phrase → signed result, stacked and offset; trail connector between source and target | target and signed block: opacity 0→1, translateY 0.75rem→0, `dur-slow` (320ms), `ease-out`, delays 320ms / 820ms; complete at 1600ms |
| Arrival controls | native "Omitir animación" / "Repetir recorrido" buttons, shown only when JS runs; skip announces "Recorrido completado…" politely and moves focus to "Repetir recorrido" (or the CTA under reduced motion) | — |
| Repeat visits | plays once; `localStorage['bridge-remaster-arrival-seen']` (try/catch) shows the end state directly | — |
| Reduced motion / no JS | the signed end state is the HTML; no sequence, no "Repetir recorrido" | — |
| Cabina handoff | hard edge into a full Tinta chapter, monument heading, booth photo once; no animation of its own (not a second signature moment) | — |
| Close | shared include `remaster-close.html`: "original → traducción → firma" on Tinta with one amber trail run under it, then the page's contact block and footer | static |
| Decorations | `.r1-crossing-decor`, always `aria-hidden`, positioned only inside its own composition; hidden at ≤ 320px | — |

---

## File ownership for the build (prototype)

| Worker | Owns | Builds |
|---|---|---|
| W1 | `src/styles/app.css`, all existing `src/components/*`, `build.mjs`, `check.mjs`, `src/pages/index.html`, `src/pages/componentes.html` | Shape refresh (radius tokens, de-boxing), #1 hero, #5 living trail, #6 footer, gallery entries |
| W2 | New `src/components/sig-lang-checker.html`, `sig-before-after.html`, `src/styles/sig-documento.css`, `src/assets/js/sig-documento.js`, `src/assets/data/languages.json`, `src/pages/traduccion-certificada.html`, `src/pages/cotizacion-traduccion.html`, `src/assets/js/quote-form.js` | #2 checker, #4 before/after, prefill |
| W3 | New `src/components/sig-event-planner.html`, `src/styles/sig-cabina.css`, `src/assets/js/sig-cabina.js`, `src/pages/interpretacion-simultanea.html`, new `src/pages/cotizacion-interpretacion.html` | #3 planner, event quote form with prefill |

W1 adds `@import "./sig-documento.css"; @import "./sig-cabina.css";` to app.css and creates both files empty first, so the build never breaks. W2 and W3 may only fill their own files. The lead integrates the checker into the home after all three finish.
