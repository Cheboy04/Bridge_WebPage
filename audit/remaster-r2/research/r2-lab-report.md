# R2 feasibility lab: carrying the middle chapters without photographs

**Date:** 2026-10-21 · **Lead:** run directly, not delegated · **Proof page:** `../lab/lab.html` · **Captures:** `../inspiration/lab-proof/` (git-ignored) · **Media:** `../lab/booth-ht-*-v2.png`

Question: R1 concluded "the real constraint is enough" without testing anything. What can carry a chapter when Bridge has one real photo and no document photography?

## Method

- Halftone: `prototype/src/assets/photo/cabina-1600.webp` (the existing provisional booth photo) cropped to the people band (y 250–1150), histogram-equalised, sampled on an 8 px grid, each cell drawn as a round dot whose radius follows tone (`v^0.6`), rendered at 4× and downsampled. Pillow 13.0 in an isolated venv, CPU. No generative model; no detail invented: every dot comes from a source pixel.
- Everything else: one static HTML page with brand tokens and the existing fonts, captured with `capture.mjs` at 1440 and 390.
- Contrast computed (WCAG 2.x): white on Bridge blue `#1C61AD` 6.25:1; Bruma on blue 5.77:1; amber on Tinta 7.03:1; amber on blue 2.81:1 (fails text); Tinta on blue 2.50:1 (fails); white on Profundo `#12489F` 8.56:1.

## Verdicts

| # | Technique | Proof | Verdict | Notes |
| --- | --- | --- | --- | --- |
| A | **Type wall**: document types at 6vw Literata, each paired with a target-language name and the trail | `lab-proof/scroll-00`, `scroll-01`, `mobile-390.png` | **Production-ready** | Turns a list of 9 chips into the chapter's image; shows translation by type alone. Scroll reveal (`animation-timeline: view()`, opacity + translate) works in Chromium; static elsewhere. At 390 the leftward slide escapes the 16 px gutter: use rise/opacity on phones. |
| B | **Sticky sheet**: one document held while four steps scroll; folio, translated lines and seal arrive with steps 2–4 | `scroll-02`–`scroll-05` | **Usable with care** | Makes "Cómo funciona" a composition instead of four columns. Small JS (one IntersectionObserver). Sheet reads empty until step 3: needs more source material (rows, a heading) from the start. On phone the sheet must shrink and stick above the steps. |
| C | **Page-long trail**: one fixed dotted line drawn by root scroll | all frames | **Reject as built; keep the idea per section** | A single fixed decoration crosses every ground: blue dots on Tinta (2.5:1) and blue on blue vanish. This is R1's "decoration escapes its section" failure again. Do it per section, inside its own composition, in that ground's trail colour. |
| D | **Blue field**: Bridge blue as a whole chapter ground, white monument and facts | `scroll-05`–`scroll-08` | **Production-ready** | The palette's strongest colour has never been used as a ground. 6.25:1 for white text. No amber on it (2.81:1). Gives the page a third field after white/Bruma and Tinta. |
| E | **Halftone booth**: the real booth photo rebuilt from trail dots, monument crossing its lower edge | `lab/booth-ht-amber-v2.png`, `scroll-07`–`scroll-11` | **Production-ready** (image), **fix** (crossing) | Faces and microphones read; it is unmistakably the brand's dot. Amber dots on Tinta and blue dots on white both work. The amber words crossing the amber image lose contrast: words that cross the image stay Bruma/white; amber only off the image. PNG ~300 KB at 1600 px (lossless WebP was larger; check AVIF or an SVG of circles at build). |

## Disclosure

Halftone images are the existing provisional photograph, transformed; nothing is generated. Caption: "Fotografía provisional tratada como trama de puntos de la marca." When Bridge supplies its own booth shoot the same treatment applies to it.

## Not tested (and why)

- Generated imagery: rejected up front. The brand bans invented imagery (`DIRECTION.md` §6) and the halftone answers the constraint honestly.
- Document photography: needs real redacted documents from Bridge (open sourcing to-do).
- View Transitions between the two pages: worth testing at build time if the story asks for a page transition.
