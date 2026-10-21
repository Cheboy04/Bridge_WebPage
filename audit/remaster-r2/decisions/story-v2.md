# Story v2: the page translates itself

*Direction lead, 2026-10-21 (`BRG-81`). Builds on [`../../remaster-r1/decisions/story-v1.md`](../../remaster-r1/decisions/story-v1.md) and applies the approved [`r2-synthesis.md`](r2-synthesis.md) (A–D). Scope: Home and Traducción certificada only.*

**Status:** draft for owner approval.

## The idea

Every chapter performs a small act of translation. A list of documents shows their target-language names. A word is crossed by its translation. A blank sheet fills with translated lines and a seal as you read. The visitor's own language pair is set as a monument. The interpreting photo is redrawn in the brand's own dots. Competitor test: "TranslationsInLondon: the page translates itself" does not fit their stock-photo-and-badges site; the sentence belongs to Bridge's trail.

## Shared vocabulary (used by both pages)

- **Grounds:** white, Bruma, **blue** (≤ 1 chapter per page), Tinta. No two adjacent chapters share one.
- **Monument:** every chapter heading on these pages is a monument (≥ ~6vw desktop), and its full stop is a trail dot.
- **List objects:** type wall, index tabs, numbered steps, active-row list. Never two of the same form adjacent.
- **Seam band:** a row of trail dots across a ground change, drawn left → right as it scrolls into view, in the trail colour of the ground *below* it (blue on light, amber on Tinta, white on blue).
- **Motion:** reveals tied to reading (`animation-timeline: view()`), parallax on image and sheet layers (CSS scroll-driven; small JS only where CSS cannot), sticky stages. Reduced motion: everything rendered in its final state, nothing moves.
- **Live thing:** the language checker writes the visitor's pair as a monument ("español ··· inglés") as they choose it.
- **Between pages:** a cross-document View Transition. The header stays put and the new page's arrival rises (CSS only, Chromium; others navigate normally).

## Home beats

| # | Beat | Ground | Composition (dominant object · layers) | Move |
| --- | --- | --- | --- | --- |
| 0 | Arrival: *Del original a la firma.* | white | R1 crossing kept: the monument H1 · source sheet, target sheet, signed result, seal | **Signature moment** (R1 sequence, unchanged). New: the sheets drift at different rates as the page starts to scroll (parallax, ≤ 8vh) |
| 1 | Your crossing | Bruma | The visitor's pair as a monument (`español ··· inglés`, updates live) · native selects, services for the pair, CTA | The pair re-sets with a 200 ms rise when it changes. Trust facts (ATA, year, Quito) sit as one ruled line under it |
| 2 | Documentos exactos | white | **Active-row list**: *Certificada · Legal · Notariada* at monument scale; the row in focus or hover turns ink, the others stay grey · a sticky detail column (text, deadline, link) | Rows sharpen from grey as they enter. Seam band (blue → amber) drawn into the next chapter |
| 3 | Voz en vivo, en la sala. | Tinta | **Halftone booth** (amber dots) · the monument crossing its lower edge in Bruma · the three interpreting services as numbered rows | Image parallax (moves slower than the type). Seam band in amber |
| 4 | Cómo trabajamos | Bruma | **Sticky sheet**: a written quote (folio, scope, deadline, value lines) held while *01 · 02 · 03* scroll past as monument numerals | Step 2 stamps the folio, step 3 fills the lines, the last step signs with the seal |
| 5 | Por qué Bridge. | **blue** | Monument in white · four facts on a white rule | Facts rise in sequence as the rule draws |
| 6 | Guías | white | **Editorial plates**: each guide a full-width row, serif title at h2+, service tag, date placeholder | Rows reveal on reading; the plate under the pointer shifts 8 px |
| 7 | original → traducción → firma | Tinta | R1 close kept · seam band drawn on entry | Arrows draw in amber |
| 8 | Cuéntenos qué necesita | Bruma | Contact block (unchanged content) | none |

Ground sequence: white · Bruma · white · Tinta · Bruma · blue · white · Tinta · Bruma ✓

## Traducción certificada beats

| # | Beat | Ground | Composition (dominant object · layers) | Move |
| --- | --- | --- | --- | --- |
| 0 | Arrival: *Traducción certificada de sus documentos* | white | R1 monument H1 · fact sheet with seal | Sheet parallax on first scroll |
| 1 | Fiel al original. | **Tinta** | **Crossed word**: the monument *Fiel al original.* crossed by a band carrying *Faithful to the original.* (decorative, `aria-hidden`) · the **before/after slider** below it, de-boxed: two white sheets on Tinta, amber trail | **Signature moment**: R1 slider kept (intro sweep, handle, tap-to-reveal). The band slides in from the side as the chapter enters |
| 2 | Qué es y cuándo se pide | white | **Index tabs**: *Notarías · Consulados · Universidades · Migración* as folder tabs on a stack; the open tab shows its text (ARIA tabs; without JS every panel is listed) · the definition paragraph | The tab stack compresses slightly as it scrolls (parallax) |
| 3 | Documentos que traducimos | Bruma | **Type wall** (lab A): document names at 6vw, each with a target-language name and the trail · "Si el suyo no está…" line | Rows reveal on reading (rise on phones) |
| 4 | Sin tarifa única. | **blue** | Monument in white · the four price factors as a white ledger · a white CTA button | Ledger rows rise with the rule |
| 5 | Your crossing | white | The language checker with the live pair monument (same as Home beat 1) | Same as Home |
| 6 | Preguntas frecuentes | Bruma | **Active-row list**: questions at h2 scale; the open one is ink, the others grey · the answer under it | Native `<details>` behaviour kept |
| 7 | Servicios relacionados | white | Two monument rows (*Legal* · *Notariada*) with a one-line description and an arrow, not cards | Row shift on hover/focus |
| 8 | Cómo funciona | Bruma | **Sticky sheet** (lab B): the birth-certificate sheet gains translated lines and the seal while *01–04* scroll | As Home beat 4 |
| 9 | original → traducción → firma | Tinta | R1 close kept · seam band | As Home |
| 10 | Contact | white | Contact block | none |

Ground sequence: white · Tinta · white · Bruma · blue · white · Bruma · white · Bruma · Tinta · white ✓

## Growth test

| What grows | Beat | Verdict | Rule |
| --- | --- | --- | --- |
| More translation services | Home 2 | Holds | The active-row list takes 3–6 rows; more go to the hub page |
| More interpreting services | Home 3 | Holds | Numbered rows, same cap of 6 |
| More languages | Home 1, Cert 5 | Grows by itself | The pair comes from `languages.json` (later the CMS); long names hyphenate per §3 |
| More document types | Cert 3 | Needs a rule | The wall shows at most 8, chosen by sort order; the full list is on its own page |
| More institutions | Cert 2 | Needs a rule | 3–6 tabs; on phones the tab row scrolls horizontally with a visible edge |
| More FAQs | Cert 6 | Holds | The list grows; above 8, link to the FAQ page |
| More guides | Home 6 | Holds | Home shows the 3 newest |
| Real booth photos arrive | Home 3 | Holds | The same halftone pipeline applies to any photo; the caption drops "provisional" |
| Real document photos arrive | Cert 1, 8 | Weak spot (intended) | Sheets stay HTML; a redacted photo could replace the slider's source sheet only with a design pass |
| English site | all monuments | Needs a rule | Monument clamp keeps a 288 px minimum fit; the crossed word swaps direction (EN monument, ES band) |

## Content rules

1. Monument text is the chapter's real heading in the CMS, never a decorative copy; crossed bands are the only decorative duplicates and are `aria-hidden`.
2. Lists render from data; caps above, never hand-placed.
3. No number typed into a template: years, counts and prices stay `[por confirmar]` until Settings holds them.
4. The halftone is generated from the source photo at build time; the source stays untouched in `assets/photo/`.
5. The blue ground appears at most once per page; amber never on blue.
6. Seam bands and decorations live inside their own section (`section > .seam`), never positioned against the page (R1 lesson).

## Owner gate

Approve this story (or name the beats to change). After approval: brand docs first, then the BRG-81 spec with its failing tests, then the build.
