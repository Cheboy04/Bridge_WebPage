# Signature components

Status: approved by client 2026-10-15 (all six). Inspiration: expertweb.com.ec (principles only: show the service working, a stage per service, process that progresses on scroll). Do not copy its look; it shares our navy + amber palette, so keep amber on the trail only and avoid its capsule nav.

**Thesis:** Bridge's product is invisible (a translated document, a voice in an ear). Each signature component makes one part of it visible.

## Shared rules (apply to all six)

1. **Complete at rest.** Without JS or with `prefers-reduced-motion: reduce`, every component shows its final, meaningful state (translated text, chosen channel, full trail). Animation only plays *from* the original state when motion is allowed. Never `opacity: 0` waiting for an observer.
2. **One signature moment per page.** Home: the hero. Traducción certificada: before/after. Interpretación simultánea: event planner. The living trail and the footer are system-wide and quiet.
3. **Accessible controls.** Native elements first (`button`, `input type=range`, `select`, `fieldset`). Tabs follow the ARIA tabs pattern. Visible focus. Targets of at least 44px. Live regions only announce user-triggered changes, never auto-cycling content.
4. **No libraries** beyond Alpine (already loaded). CSS scroll-driven animations (`animation-timeline: view()`) inside `@supports` and `prefers-reduced-motion: no-preference`; otherwise static. Transform and opacity only.
5. **Data is real or labelled.** Rules and numbers not confirmed by Bridge carry a visible "[regla de ejemplo, validar con Bridge]" or "[por confirmar]".
6. **Ports to Laravel.** Each one is a Blade component later; data comes from the CMS (Language model, Settings) or config. Prefill uses query parameters, which Livewire reads with `#[Url]`.
7. **Radius:** stages use `--radius-lg` (24px), controls `--radius-full`. See DIRECTION.md §5.

---

## 1. Hero "Del original a la firma. Del orador al oído." (home)

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
- **Supported pair:** "Sí, trabajamos [origen] → [destino]", then which services apply (certificada, legal, notariada) and the turnaround "[por confirmar]". Primary button "Cotizar este par" links to `cotizacion-traduccion.html?origen=xx&destino=yy`.
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

A stage showing one document twice, stacked: the original (English, plain) and the certified Spanish version (translator's declaration, seal, signature line). A draggable divider reveals one over the other using `clip-path` driven by an `input type=range` (0 to 100, default 50). The range is visually styled as a round handle with a vertical rule, keyboard operable, with labels "Original" and "Traducción certificada" at each side.

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

## File ownership for the build (prototype)

| Worker | Owns | Builds |
|---|---|---|
| W1 | `src/styles/app.css`, all existing `src/components/*`, `build.mjs`, `check.mjs`, `src/pages/index.html`, `src/pages/componentes.html` | Shape refresh (radius tokens, de-boxing), #1 hero, #5 living trail, #6 footer, gallery entries |
| W2 | New `src/components/sig-lang-checker.html`, `sig-before-after.html`, `src/styles/sig-documento.css`, `src/assets/js/sig-documento.js`, `src/assets/data/languages.json`, `src/pages/traduccion-certificada.html`, `src/pages/cotizacion-traduccion.html`, `src/assets/js/quote-form.js` | #2 checker, #4 before/after, prefill |
| W3 | New `src/components/sig-event-planner.html`, `src/styles/sig-cabina.css`, `src/assets/js/sig-cabina.js`, `src/pages/interpretacion-simultanea.html`, new `src/pages/cotizacion-interpretacion.html` | #3 planner, event quote form with prefill |

W1 adds `@import "./sig-documento.css"; @import "./sig-cabina.css";` to app.css and creates both files empty first, so the build never breaks. W2 and W3 may only fill their own files. The lead integrates the checker into the home after all three finish.
