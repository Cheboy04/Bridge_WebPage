# R2 synthesis: from a strong hero and close to a page that is designed all the way through

*Direction lead, 2026-10-21 (`BRG-81`). Sources: `../r1-review.md`, `../research/library-shortlist.md`, the three research reports (`awards-report.md`, `adjacent-report.md`, `gallery-report.md`) and the lab (`r2-lab-report.md`). Frames are under `../inspiration/` (git-ignored). Every frame cited here was opened by the lead.*

## 1. Why ours still reads as "didn't change much"

R1 gave Bridge a strong hero, a Cabina monument and a designed close. Everything between them is unchanged: a heading on the left, rows on the right, body-scale type, on white or Bruma, nothing overlapping, nothing moving (`../before/home/scroll-03`–`17`, `../before/certified-translation/scroll-02`–`20`). All three research tracks named the same gaps on their own:

- Middle headings are labels, not objects.
- Lists are rows, not things.
- Grounds barely change: two light fields and one dark.
- The dotted trail decorates but never does anything.
- No motion responds to reading.

Here "didn't change much" means the visitor meets the brand at the top and the bottom, and a competent template in between.

## 2. What the great ones do (ranked, with proof)

1. **A list becomes an object.** Stripe Press sets its table of contents as ~10vw serif numerals (`gallery/stripe-press`, `awards/poor-charlie`). Mosby's Files turns a list into a filing stack with coloured tabs (`awards/mosby/scroll-00`, `mobile-390`). Ario makes practice areas numbered record cards (`awards/ario-law/scroll-06`–`08`). AREA 17 uses a large grey list where the active line turns black (`gallery/area17`). *For Bridge:* document types, institutions, steps and FAQs are lists. They become the chapter's image, at no photographic cost.
2. **A new ground per chapter.** Plint runs nine flat grounds through its middle (`adjacent/plint/scroll-02`–`10`). GT Standard gives each chapter its own colour (`gallery/gt-standard`). The Lot Radio alternates light and dark. *For Bridge:* add Bridge blue as a full chapter ground (lab D, 6.25:1), so a page rotates white, Bruma, blue and Tinta.
3. **The section word as a stateful object.** a-lign's "Work" and "Process" are giant hatched words that fill with the accent as you read (`awards/a-lign/scroll-04`–`12`). Typographics crosses its upright wordmark with an italic copy of the same word on a band (`adjacent/typographics/scroll-00`). *For Bridge:* a word and its translation, crossed. That is literally the service.
4. **Sticky stage, scrolling story.** Mosby and AREA 17 pin a stage while the content scrolls past. Tamayo pins a column of agenda cards (`adjacent/tamayo`). *For Bridge:* the process holds one document that fills in step by step (lab B).
5. **The brand module as pattern and punctuation.** Björkhem repeats its bar-and-circle mark as a band between chapters and as punctuation in serif statements (`gallery/bjorkhem`, `identity/I3`). GT Standard draws letters with dots on their anchor points (`I8`). *For Bridge:* the trail dot becomes a pattern band at seams and the full stop of monument lines. The dotted seal ring already exists.
6. **Line-art or dots instead of photos.** Plint's whole middle is hairline drawing (`plint/scroll-03`–`09`). Openfield draws its landscape in dots and ASCII (`gallery/openfield`). *For Bridge:* the halftone booth (lab E) and HTML document sheets.
7. **A drawn transition.** KIKK draws one diagonal stroke across an empty page before the next page arrives (`adjacent/kikk/motion/trans-150`, `trans-300`; a solid gradient line, not dotted). *For Bridge:* the trail draws between chapters, scoped to each seam (lab C showed a page-long fixed trail fails across grounds).
8. **Reveals tied to reading.** Lifeworld sharpens text from blur word by word; a-lign fills as you read. *For Bridge:* `animation-timeline: view()` (CSS only, static fallback), as proven in lab A.

**Where the great sites break our rules, and whether we need it:** loaders and intros of 2 s or more (no); WebGL and 3D cubes (no); scroll-jacking and smooth-scroll libraries (no); content that never appears under reduced motion (never). Every move above is css-only or small-js (all four reports agree), so ADR D3.7 (no animation library) holds.

## 3. Lab: what the constraint allows

| Exp. | Verdict | Proof |
| --- | --- | --- |
| A Type wall (document types at 6vw with target-language names) | Production-ready; on phones the reveal rises rather than slides | `inspiration/lab-proof/scroll-00`, `mobile-390` |
| B Sticky sheet filling with the steps | Usable with care; the sheet needs source material from step 1 | `lab-proof/scroll-02`–`05` |
| C One page-long scroll trail | Rejected as built (crosses grounds and vanishes); do it per seam | all lab frames |
| D Bridge blue chapter ground | Production-ready (white 6.25:1; no amber on blue, 2.81:1) | `lab-proof/scroll-05`–`08` |
| E Halftone booth (the real photo as trail dots) | Production-ready; words crossing the image stay Bruma, never amber | `lab/booth-ht-amber-v2.png`, `lab-proof/scroll-07`–`11` |

Disclosure for E: "Fotografía provisional tratada como trama de puntos de la marca." Nothing is generated; every dot comes from a source pixel.

## 4. Brand proposal (changes only)

**Kept:** the "Puente" idea; logo; Literata + Manrope; every colour token and contrast pair; amber only on Tinta; the trail's geometry; R1's hero arrival, Cabina monument, close and before/after slider (owner: "I did liked it very much"); the language checker; native controls; 44 px targets; one signature moment per page; honest placeholders; ADR D3.7 (no library).

| # | Area | Current rule | Proposed rule | Evidence |
| --- | --- | --- | --- | --- |
| 1 | Grounds | white / Bruma rotation, Tinta for Cabina and the close | Four grounds: white, Bruma, **Bridge blue**, Tinta. No two adjacent chapters share a ground; at most one blue chapter per page | Principle 2; lab D |
| 2 | Lists | open rows with dividers | Every list of 4+ items takes one object form: **type wall** (documents), **index tabs** (institutions), **numbered monument** (steps), **active-row list** (FAQ, services). Not two of the same form adjacent | Principle 1; lab A |
| 3 | Monument | once per chapter, R1 chapters only | Once per chapter, **every** chapter on the R1 pages, including the middle ones; minimum ~6vw on desktop | Principles 1 and 3 |
| 4 | Crossed word | none | A service word crossed by its translation on a band (e.g. *Traducción* / *Translation*), once per page, decorative copy `aria-hidden` | Principle 3 (Typographics) |
| 5 | Trail | connectors, steps, seal, switcher | Also: **seam bands** (a dot pattern row between grounds, in that ground's trail colour) and the **monument full stop** (the period of a monument line is a trail dot) | Principle 5 |
| 6 | Imagery | one booth photo, graded | The photo is shown as a **halftone of trail dots** (amber on Tinta, blue on white). The plain photo is not used on these pages | Principle 6; lab E |
| 7 | Process | four columns with dotted connectors | **Sticky sheet**: one document held while 01–04 scroll; folio, translated lines and seal arrive with steps 2–4 | Principle 4; lab B |
| 8 | Motion | "transform/opacity only; one thing moves at a time; no scroll-jacking or parallax" | Keep transform/opacity, no scroll-jacking, one signature moment. **Add reading-paced motion:** CSS scroll-driven reveals (`view()`), sticky stages, a trail drawn across each seam. Everything is complete at rest and under reduced motion | Principles 7–8; lab A |
| 9 | Seams | hard colour edges | A hard edge **plus** a drawn trail band at the seams that matter (Documento → Cabina, into the close) | Principle 7 |

## 5. Risks

- **Register:** colour fields and monuments can tip into festival or poster theatre (KIKK, Exat). Mitigation: one blue chapter per page, the serif carries authority, no neon, no rotation or 3D.
- **Accessibility:** crossed words and the halftone must never carry meaning alone. Decorative copies are `aria-hidden`; the halftone gets real alt text; contrast is computed for every pair; reveals start at a readable state (opacity ≥ .15 is decorative only, and the text exists in the DOM).
- **Browser support:** scroll-driven animations are Chromium-only today. The fallback is the complete static state, which is designed, not degraded.
- **Performance:** the halftone PNG is about 300 KB at 1600 px. Ship 800/1600 sizes, try AVIF, lazy-load. No new fonts. An optional Literata italic for joining words (Stripe Press) costs one more font file and is not proposed.
- **Honesty:** the halftone is disclosed; document sheets stay demonstrative; ATA and the seal stay `[por confirmar]`.
- **Scope:** shared components (checker, footer, slider) must not change on the six pages outside this round. Scope the new classes to the two pages.

## 6. Decisions the owner owns

Asked and answered 2026-10-21.

- **A. Grounds:** add Bridge blue as a chapter ground (four-ground rotation). **Decision:** "Add blue ground."
- **B. Motion rule:** **Decision, beyond the recommendation:** "Yes allow reading-paced motion and also remove the rule of DIRECTION.md that prohibits parallax and animations." §4 row 8 therefore becomes: parallax and concurrent motion are allowed; motion is still transform/opacity (or scroll-driven equivalents), complete at rest, and fully static under `prefers-reduced-motion`; no wheel hijacking (accessibility, not taste); one *signature* moment per page still names the page's main interaction. ADR D3.7 (no animation library) is unaffected, so parallax is built with CSS scroll-driven animations or small vanilla JS.
- **C. Imagery:** **Decision:** "Use the halftone."
- **D. Strength:** **Decision:** "Full table," rows 1–9.

## 7. Next

Story v2 with every beat of both pages and the growth test → owner approval → brand docs (`DIRECTION.md`, `SIGNATURE-COMPONENTS.md`) updated → spec and red tests → build → independent review.
