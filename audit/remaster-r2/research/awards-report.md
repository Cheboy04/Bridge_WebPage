# R2 research, track A: award-recognised sites without photography

Researcher: track A (awards). Date: 2026-10-21. Frames: `audit/remaster-r2/inspiration/awards/<slug>/` (git-ignored). Every move described below was seen in a frame or is backed by runtime/source evidence. Anything else is marked `not determinable`.

## 1. Sources searched, candidates, kept/dropped

**Listings scanned (about 95 entries):**
- Awwwards "Typography Honors" winners, pages 1–2: https://www.awwwards.com/inspiration_search/winner_category_typography/ (33 entries, 2023-11 → 2026-08)
- Awwwards "typography" websites tag: https://www.awwwards.com/websites/typography/ (31 entries, mostly unawarded, Oct 2026)
- Awwwards "law" websites tag, page 1: https://www.awwwards.com/websites/law/ (31 entries; 6 Honorable Mentions 2023–2026)
- Web searches for CSSDA / Webby / FWA law and consulting winners. They found no confirmed CSSDA WOTD or FWA for a law or consulting firm from 2023–2026. The only hit was Robins Kaplan's CSSDA "Special Kudos" in 2025, which was not captured. Lovers Magazine was not searched (time).

**Shortlisted and captured (17):**

| Slug | Site | Award (from Awwwards) | Result |
| --- | --- | --- | --- |
| poor-charlie | https://www.stripe.press/poor-charlies-almanack | SOTD 2024-01-04, Typography Honors | **Kept** |
| mosby | https://www.mosbyfiles.com/ | SOTD 2026-08-13, Typography Honors | **Kept** |
| a-lign | https://www.a-lign.studio | Typography Honors 2026-08 | **Kept** |
| lifeworld | https://lifeworld.wetransfer.com | SOTD 2024-11-25, Typography Honors | **Kept** |
| exat | https://exat.hottype.co/ | SOTD 2025-04-03, Typography Honors | **Kept** |
| neue-montreal | https://neuemontreal.com/ | SOTD 2026-07-13, Typography Honors | **Kept** (for the middle-section list device only) |
| blimp | https://www.blimp.gr/ | SOTD 2024-09-09, Typography Honors | **Kept** |
| ario-law | https://ario.law/en/ | Honorable Mention 2026-05-25 | **Kept** (the only law-firm site with a composed middle) |
| free-speech | https://freespeech.gubrica.com/ | SOTD 2024-08-08 | Dropped: capture timed out twice (WebGL/heavy page). Only intro frames exist. |
| pendragon | https://pendragoncycle.com/ | SOTD 2026-01-03 | Dropped: capture timed out twice. Partial frames exist. |
| stripe-press | https://press.stripe.com/ | — | Dropped: timed out once. poor-charlie already covers this publisher. |
| structure-eng | https://structureengineering.com.au/ | Nominee 2026-10-13 | Dropped: page.goto timed out at 60 s. |
| joseph-law | https://www.forthetimes.law | HM 2025-04-02 | Dropped: Cloudflare 522, host down. |
| roeh-law | https://www.roeh.com/en | HM 2025-01-07 | Dropped: a standard 3-column service grid, with nothing to learn. |
| hafnia-law | https://hafnialaw.com/ | HM 2024-02-09 | Dropped: photo-led (people walking, libraries). |
| elicyon | https://elicyon.com | Typography Honors 2025-11 | Dropped: luxury interiors and photo-led. The scattered letters spelling RESIDENTIAL over a photo are luxury theatre. |
| seasoned | https://seasoned.koto.studio | SOTD 2025-03-21 | Dropped: retro-food 3D props and video, which is wrong for Bridge. |

---

## 2. Kept sites

### 2.1 Poor Charlie's Almanack (Stripe Press): the table of contents *is* the page
Frames: `poor-charlie/scroll-00.png`, `sheet.png`, `mobile-390.png`

1. **Memorable moment:** the home page is a single screen with no scroll (all 16 scroll frames are the same). The whole view is a typeset table of contents. Chapter numbers are set as display type ("01/02/03", "01 / 02 / 03 / 04 … 09 / 10 / *Eleven*"). On the right, the four forewords cascade diagonally, each "Foreword *by* / Name" indented further than the last. It works because the navigation is the composition: no hero, no cards.
2. **Type:** Cardinal Fruit (a high-contrast condensed serif) and Suisse Mono (source: `src/greps.txt`). The largest text is 157 px (10.9 vw) on the numerals. Italic is used only for connective words ("*by*", "*and*", "*of*", "*Eleven*", "*BACK* MATTER"). Small caps-like labels are underlined ("CHAPTERS", "FOREWORDS, REBUTTAL, *and* INTRODUCTION"). Leading is very tight on the display lines.
3. **Layering:** none. A dashed vertical gutter rule and a 1 px frame around the page make it read as a printed spread.
4. **Motion:** intro frames 600 → 1200 ms show the type fading from grey to full black (a load fade). Other motion is `not determinable`. No GSAP or Lenis was found in the source.
5. **3D/WebGL:** none found.
6. **Colour:** one warm-grey paper field (#ececec range) with black ink. A mono black pill "STRIPE PRESS" sits in the corner. There is no accent colour.
7. **Layout variance:** not applicable (one screen). The variance comes *inside* the screen: left column stacked numerals, right column diagonal cascade, bottom-right right-aligned bracketed actions "[ BUY ] [ LISTEN ] [ BERKSHIRE MODE ]".
8. **Craft:** bracketed text buttons, an audiobook player as a mono footer strip "[▸] AUDIOBOOK [1.5X]", and the label hierarchy (an underlined label over a display list).
9. **At 390 px:** the layout becomes one column. Numerals stay huge (about 85 % of the width) and the cascade keeps its indents (`mobile-390.png`).
10. **Transfer to Bridge:** a **services index set like a book's contents**, with Literata numerals for the two services and their sub-services ("01 Traducción certificada / 02 Legal / 03 Notariada"), and the "por"/"de"/"y" connectives in Literata italic. The cascading-indent list suits "Cómo trabajamos" steps or the guides list. Literata + Manrope can do this. Wrong to copy: the zero-scroll home (Bridge needs to explain itself) and the monochrome with no CTA colour.

### 2.2 Mosby's Files: a filing cabinet of coloured folder tabs
Frames: `mosby/scroll-00.png`, `scroll-01.png`, `mobile-390.png`, `motion/sheet.jpg`

1. **Memorable moment:** below the "AMERICAN MODERNISM" title, the content is a stack of filing-folder sheets. Each sheet is a full-width colour band (blue, teal, purple, red) with rounded trapezoid index tabs carrying architects' names in a serif. On scroll, the stack compresses and the front (red) folder rises to fill the viewport. That folder is slightly irregular, with edges a few pixels off-square like real card stock (`scroll-01.png`). Its text is in mono, and a row of hand-drawn north-arrow glyphs and a map scale bar ("0 4 8 16 32") sit in the footer.
2. **Type:** Signifier (serif) for the tab names, IBM Plex Mono for body and labels, and Founders Grotesk (condensed bold) for the title (source). The title is about 10 vw. Category labels on the right ("Organic & Early Modernism <") are mono.
3. **Layering:** this is the whole idea. Folders overlap like a physical stack, and each tab overlaps the band behind it. The front folder's slight skew sells the paper.
4. **Motion (probe):** Lenis smooth scroll. Page height is only 1404 px. CSS transitions on transform, opacity and height run **650 ms `cubic-bezier(0.33, 1, 0.68, 1)`** (an ease-out-cubic), with the header sliding up 61 px. `div.stack-cover` moves on scroll. Clicking a tab navigates to `/cases/frank-lloyd-wright`. The probe's transition frames did not show a visible animation, so the transition is `not determinable`.
5. **3D/WebGL:** none (probe: no canvas, no WebGL).
6. **Colour:** a near-black page (#191919) and saturated folder colours, with a red front sheet (`rgb(215,30,30)`) and a yellow tab for I. M. Pei. Each folder is one flat field.
7. **Layout variance:** effectively two screens (title, then folder). The variance is in the tab positions: tabs sit at different x offsets on each row, so the stack never reads as a list of rows.
8. **Craft:** cartographic marks (scale bar, compass roses) used as decoration tied to the subject. The tabs have chamfered shoulders, not plain pills.
9. **At 390 px:** tabs wrap two per row, the stack holds and the title stays big (`mobile-390.png`). It survives well.
10. **Transfer to Bridge:** this is the strongest document-material move for **Documento**. Bridge's document types (certificado, legal, notariado, apostilla) could be folder tabs in Bruma, white and Tinta, with the front sheet holding the service detail. The tabs are pure HTML/CSS (`clip-path` or SVG tab shapes); the stack compression on scroll is CSS `position: sticky` with staggered `top`. Wrong for Bridge: the rainbow palette. Keep it to brand fields, with amber only on a Tinta tab.

### 2.3 a-lign studio: hatched letterforms that fill in, and two sentences that realign
Frames: `a-lign/scroll-02.png`, `scroll-09.png`, `sheet.png`; motion `a-lign/motion/sheet.jpg`, `probe.json`

1. **Memorable moments:**
   - (a) Section words "Work" and "Process" are giant letterforms built from **dashes or vertical hatch strokes**, not solid glyphs. "Process" is set vertically down the left edge. As you scroll through the Process section its strokes **fill from grey to coral** top-down: about two letters are filled in `scroll-09.png` and more in later frames. It is a progress meter made of type.
   - (b) The pull quote is **two sentences interleaved word by word**: "Better process. Better collaboration. Better results. Without needing a bigger team" and "People deserve better … to get there." They sit in staggered positions across two ragged columns, flanked by staircase dash patterns. Between motion frames `scroll-03` and `scroll-04` the words slide horizontally into new alignments.
2. **Type:** Geist (Regular/Medium/Semi Bold), largest 154 px (10.7 vw). The quote is in tight-tracked large grey with coral quotation marks. Labels are uppercase in small dashed-border boxes.
3. **Layering:** dashed-outline frames around photos and boxes (`1px dashed`). A fixed bottom dock (MENU / + / `<a>` / CONTACT). A sticky "Winner" ribbon. Process step cards (Strategy → Design → Build) swap in a pinned area while the vertical word fills.
4. **Motion (probe):** GSAP 3.15.0 with ScrollTrigger, SplitText, Flip and CustomEase (`ease: "align"`), plus Lenis 1.1.14 and Barba 2.10.3 (all confirmed at runtime). 15 ScrollTriggers. `SECTION.process_wrap` is scrubbed from 4500 to 7200 px, `SECTION.work_wrap` from 1800 to 3420. The loader uses a GSAP `scrambleText` counter and a `clipPath` reveal over 0.8 s. Page transition (Barba SPA): the current page shrinks into a dark-framed card, then the next page's giant striped "Work" fills the viewport (`trans-150` → `trans-300`). Reduced motion: no `prefers-reduced-motion` rule exists in the CSS, and the scramble still runs.
5. **3D/WebGL:** none. 9 canvas mentions in the source, but the probe found no WebGL context.
6. **Colour:** off-white #f7f7f7 field, grey type, one coral accent (#e07a5f range) used only for fill progress, quotes and the CONTACT button.
7. **Layout variance:** hero (scattered framed photos around a centred headline), a full-bleed interleaved quote, a "Work" word with an asymmetric case grid, a vertical "Process" word against stacked cards, then "Craft / Honesty / Partnership" centred stacked words with photos sliding over. No two sections share a grid. The Process section avoids "heading left, rows right": the heading is a **vertical progress object**, not a label.
8. **Craft:** dashed borders echo the hatch strokes. One accent colour, used for "how far along you are".
9. **At 390 px:** the hatched words survive as full-width vertical monuments and the fill still happens. The quote keeps its stagger at small size (`motion/m-03` … `m-08`).
10. **Transfer to Bridge:** the most directly transferable site.
    - (a) **The dotted trail as the letterform material.** A display word ("Proceso", "Cabina") built from Bridge's dots, filling from Bruma-grey to Bridge blue (amber on Tinta) as the steps advance. This can be an SVG with `stroke-dasharray` and a CSS scroll-driven animation, or a CSS gradient mask with `animation-timeline: view()`.
    - (b) **Interleaved bilingual text.** A Spanish sentence and its English translation woven in staggered positions, then sliding into two clean columns. That literally performs translation. Small JS: an IntersectionObserver toggles a class and CSS transitions handle the slide. Flip is not needed if the positions are known.
    - Wrong for Bridge: the Barba page transition (needs a library) and the scramble text.

### 2.4 Lifeworld (WeTransfer × Olafur Eliasson): sliced wordmarks that assemble, and text that comes into focus
Frames: `lifeworld/scroll-01.png`…`scroll-03.png`, `scroll-06.png`, `scroll-10.png`, `motion/sheet.jpg`

1. **Memorable moments:**
   - (a) After a quiet black intro line, the wordmark "LIFEWORLD" in ultra-condensed black-on-white **assembles from horizontal slices** that scroll at different rates. `motion/scroll-01` shows only stray bars, `scroll-02` and `scroll-03` show displaced strips, and `scroll-05` shows the word whole. The same move recurs for "OLAFUR ELIASSON" and "CIRCA" at each chapter.
   - (b) A statement sentence reveals **word by word from blur to sharp** as you scroll. In `scroll-06.png`, "On display at 20:24, the" is sharp, then "spaces on WeTransfer" is half-blurred and the next line fully blurred.
2. **Type:** HelveticaCondensedBold for the monuments (width-filling, about 100 vw word width) and ActiefGrotesque for text (source). Body copy sits in a narrow right-of-centre column. The nav corner carries a **live local clock**: "London 00:54:34".
3. **Layering:** small blurred images float past the text column at different depths. Chapter monuments cross the boundary between black and white grounds.
4. **Motion (probe):** Lenis is present (`html.lenis`). No GSAP. The app is SvelteKit (`/_app/immutable/` chunks). The parallax events are SVG `g.line` / `path` elements moving at **rates 0.19–0.66**, which confirms the slices are SVG groups with per-slice scroll rates. 73 split-text events and 67 fade-ins over 30 steps. Reduced motion: no CSS rule, and the parallax still runs (12 elements).
5. **3D/WebGL:** none (probe: no WebGL contexts). The shop section's tilted discs look 3D but use CSS `matrix3d` (hover probe).
6. **Colour:** pure black and white chapters, swapping ground at each monument. Colour comes only from the small art images.
7. **Layout variance:** intro line, a monument, a city list next to a video, a large statement with a right column, the blur reveal, a monument plus floating images, a white chapter, then the shop. Big type is the separator between chapters.
8. **Craft:** a **live clock in the header** for an "art at 20:24 every day" concept, a blur reveal tied to reading, and no decorative frames.
9. **At 390 px:** the monument turns vertical-ish and the slice assembly still plays. The city list scales up, which survives well (`motion/m-01`…`m-09`).
10. **Transfer to Bridge:**
    - (a) **A slice-assembly monument** for chapter words ("Documento", "Cabina"), made of horizontal SVG strips that converge as you scroll. It reads as the original arriving at its translation. Doable with CSS scroll-driven animations (`animation-timeline: view()` with a `translate` per strip) and a static assembled fallback.
    - (b) **Blur-to-sharp word reveal** for the one key sentence per page (CSS `filter: blur()` on words, with `animation-range` per word via scroll-driven animation, or IntersectionObserver plus stagger).
    - (c) A **live Quito clock** ("Quito 14:32") in the header or footer, which is honest and local. Small JS.
    - Wrong for Bridge: art-world black/white severity everywhere, and blur on body text (accessibility).

### 2.5 Exat (Hot Type): a foundry poster wall in colour-block tiles
Frames: `exat/scroll-00.png`, `scroll-05.png`…`scroll-15.png`, `scroll-08.png`, `mobile-390.png`; motion `exat/motion/probe.json`

1. **Memorable moment:** after an orange full-bleed "Exat" wordmark (45 vw), the middle is a **wall of poster tiles**: a black tile with stacked sliced "28", a black panel holding a vertical list of artist names next to the label "modernism", a green tile with a pink "M", an orange tile of eye-dots, a pink tile, and repeated "exat" lockups (`scroll-08.png`, `scroll-09.png`). Glyph studies ("a", "s", "h") come with construction annotations (`scroll-03.png`). A grid of "S/C/U" curves changes weight (`scroll-05.png`, `scroll-06.png`).
2. **Type:** Exat in all weights, display up to 45 vw. Big paragraph headlines run full width on yellow ("EXAT 51 is the pioneering Croatian art and architecture collective of the 1950s."). Lowercase name lists are set tight.
3. **Layering:** tiles overlap section boundaries. Spinning circular text badges ("forma oblik 152") sit over tile edges.
4. **Motion (probe):** GSAP 3.12.5 with ScrollTrigger and SplitText, plus Lenis (confirmed) and 59 ScrollTriggers. Text reveals use **y + skewY, 1.5–1.7 s, `expo.out`, stagger 0.015** (from `probe.json` timings). The intro is a 15 s CSS `zoom-start` keyframe on an SVG letter wheel. Numbers (`div.number`) parallax at rates 0.92–1.06, so they drift against each other. 207 scale events. No reduced-motion rule.
5. **3D/WebGL:** none.
6. **Colour:** orange, yellow, pink, green, blue and black on off-white. A loud "Swiss poster" palette.
7. **Layout variance:** monument, two-column story with a portrait, glyph-construction collage, a full-width yellow statement, a tile wall, a stats stack ("21 weights / Latin & Cyrillic / 1715 glyphs / 431 languages" with coloured bullets, `scroll-11.png`), a numeral monument "1926", a character-set grid, then a Cyrillic list. No section repeats a grid.
8. **Craft:** the stats list uses a large **coloured dot bullet** per line, and the final dot is pink for the highlighted line "431 languages".
9. **At 390 px:** the wordmark rotates 90° to fill the portrait screen ("Exat" vertical, `mobile-390.png`). That is a bold, cheap move.
10. **Transfer to Bridge:**
    - (a) **The language list as a tile wall** of mixed-size blocks in Bridge fields (Tinta, Bruma, blue, white) instead of rows.
    - (b) The **dot-bullet stat list**: "Español → Inglés / Francés / Alemán …" with Bridge-blue dots echoing the trail. Only real facts, no invented numbers.
    - (c) **Rotate the monument word at 390 px** (CSS `writing-mode: vertical-rl` or a rotate).
    - The y+skewY reveal is reproducible with CSS transitions on an IntersectionObserver class.
    - Wrong: the poster rainbow and the 59-trigger choreography.

### 2.6 PP Neue Montreal (Pangram Pangram): a list as coloured book spines
Frames: `neue-montreal/scroll-11.png`, `scroll-04.png`, `sheet.png`

1. **Memorable moment:** the 11 weights are a row of **vertical colour spines**, like books on a shelf. Each spine shows its weight name set vertically in that weight ("Hairline" … "Black") and a big number at the bottom. One spine ("Plateau Mont-Royal") is **open**, wider, with a title and a paragraph (`scroll-11.png`). It is an accordion turned 90°.
2. **Type:** the PP Neue Montreal family (source). Specimen glyphs reach 240 px (16.7 vw). Italic display "*Must-see Attractions*" is broken mid-word ("Must-se / e") as a deliberate texture.
3. **Layering:** printed ephemera (stamps, posters, a postcard) scattered and rotated over a dark field (`scroll-04.png`, `scroll-05.png`). A pill nav floats over the content.
4. **Motion:** Lenis (source greps). Spine behaviour on hover or scroll is `not determinable` (not probed). The page has a `prefers-reduced-motion` rule (1 hit).
5. **3D/WebGL:** none found.
6. **Colour:** a cream field (#efe6d6 range) and a saturated spine rainbow. The photo chapters (Montreal aerials) are photo-led.
7. **Layout variance:** a red hero cover, a rotated-ephemera collage, a "Typeface Evolution" two-column timeline list (`scroll-04.png`, which *is* heading-plus-rows but saved by size and a vertical rule), an aerial photo, the spine shelf, then giant specimen glyphs cropped by the viewport.
8. **Craft:** the timeline list uses years as display type with a single 1 px vertical divider, nothing else.
9. **At 390 px:** the capture is black (a loader that never finished in 390 headless). `not determinable`.
10. **Transfer to Bridge:** **services or languages as spines.** Six interpreting or translation services as narrow vertical Bruma/Tinta/blue spines, one open at a time, with Literata names set vertically. This is the clearest answer to "heading left, rows right". Pure CSS with `:has()` / `details` or a few lines of JS, and flex-grow transitions. At 390 it needs a fallback to a horizontal accordion. Wrong: the rainbow and the aerial photography.

### 2.7 The Blimp: an archive index and tracked-out monuments
Frames: `blimp/scroll-02.png`, `scroll-04.png`, `sheet.png`, `mobile-390.png`

1. **Memorable moment:** "A L B U M / OF THE ↓WEEK" and "S O U N D T R A C K / FOR THE ↓DAY": heavy grotesque display **justified across the full width by letter-spacing**, so the words become rulers. A red hand-drawn arrow cuts in before "WEEK" or "DAY". Below, "EXPLORE THE ARCHIVE" opens a **mono archive table** with numbered entries (638, 637 …) in columns `artist + title / genre / label`, under corner-bracketed headers `⌐artist + title⌙` (`scroll-02.png`).
2. **Type:** HelveticaNowDisplay (heavy) for display, Helvetica Monospaced for data (source). The largest is 143 px (9.9 vw). All caps.
3. **Layering:** the featured album card overlaps the "ALBUM OF THE WEEK" monument, with letters passing behind the card (`scroll-04.png`). Corner-bracket marks frame the cards.
4. **Motion:** Lenis (source). The intro has a red line drawn across the black screen (intro-2500), then a scattered thumbnail field. Further motion is `not determinable` (not probed).
5. **3D/WebGL:** canvas mentions in the source (3). Its use is `not determinable`.
6. **Colour:** charcoal #121212, warm grey #b3b2ad, one red accent (the arrow and asterisk marks).
7. **Layout variance:** a thumbnail cloud, a three-column latest grid, the archive table, the monument with an overlapping card, a monument on black, then a footer monument. Middles alternate between **dense data** and **monument**.
8. **Craft:** "LAST UPDATED: 19/07/2026" in the mobile header. Bracket corners as the frame language. Hand-drawn accent marks.
9. **At 390 px:** the monuments collapse to a small bracketed tracked line under "THE BLIMP". Cards stack and the bracket frames survive (`mobile-390.png`).
10. **Transfer to Bridge:** (a) **justified tracked headings** for the two service names, in Manrope caps. (b) **The FAQ or guides list as an archive table**: numbered, mono-ish columns (trámite / documento / plazo), with corner-bracket headers. It reads as a register, which is native to a certified-translation office. Wrong: the music-zine grunge and hand-drawn arrows (the trail is Bridge's mark).

### 2.8 Ario Law Firm: practice areas as numbered index cards on a CSS 3D cube
Frames: `ario-law/scroll-06.png`, `scroll-07.png`, `scroll-08.png`, `sheet.png`

1. **Memorable moment:** each practice area is a white **index card** with a huge number ("01", "02", "03", "04"), the practice name in wide caps, and a tiny ruled table at the foot ("Head of Practice | Name", "Team | 5+ lawyers"). On scroll, the cards **rotate as faces of a cube**: card 03 tips away while 04 comes forward (`scroll-08.png`), with a monochrome image face beside them. Stat cards "10+" and "30+" also tilt in on 3D planes (`scroll-03.png`, `scroll-04.png`).
2. **Type:** ario-sans, wide grotesque caps, numerals up to 300 px (20.8 vw) (source). Black and white only.
3. **Layering:** 3D planes crossing each other in perspective. The source has inline `perspective: 453px` / `2005px` (from `src/index.html`). `preserve-3d` was not found in the static HTML.
4. **Motion:** GSAP and Lenis are not in the static greps (Awwwards tags it GSAP). Not probed, so the scroll-tied rotation timing is `not determinable`. The "People who / love the law / embrace challenges / aspire for more" sequence swaps one line at a time with a tilted photo card (`scroll-12.png`…`scroll-15.png`).
5. **3D/WebGL:** CSS 3D transforms (perspective found in the source). No WebGL found.
6. **Colour:** black ground, white cards, greyscale photography, with one blue gradient flash in the intro.
7. **Layout variance:** monument name "ARIO" with a partner portrait, a statement, tilted stat cards, the cube of practice cards, a giant "TEAM", a white chapter with one-line swaps.
8. **Craft:** the **ruled micro-table on each card** makes it look like a filed record.
9. **At 390 px:** the hero survives. The mobile capture stops at the hero and the cookie bar, so later sections are `not determinable`.
10. **Transfer to Bridge:** **services as numbered record cards** with a ruled foot table ("Plazo | 24–72 h [por confirmar]", "Entrega | PDF + físico"). The cube rotation is too theatrical; a **flat card deck that slides or stacks** (sticky stacking) gets 80 % of it. Wrong: the partner portraits, the "freaking awesome lawyers" bravado, and the stat cards ("10+", "30+"), which would be fake proof for Bridge.

---

## 3. Recurring techniques, ranked

1. **Type as the section's object, not its label** (`css-only` for static, `small-js` or CSS scroll-driven for the fill). The section word is a giant built object that carries state: hatch fill as progress (a-lign "Process"), slice assembly (Lifeworld), a vertical spine (Neue Montreal), a rotated wordmark at 390 (Exat), numeral TOCs (Poor Charlie). → Bridge: a "Proceso" or "Cabina" word built from trail dots that fill as steps advance.
2. **Lists turned into physical objects** (`css-only` / `small-js`): folder tabs (Mosby), book spines (Neue Montreal), index cards with ruled foot tables (Ario), archive register tables (Blimp), poster tile walls (Exat). This is the main cure for "heading left, rows right".
3. **Sticky stacking of sheets or cards** (`css-only` via `position: sticky` and staggered `top`; plus `small-js` for the fill): Mosby folders compress, a-lign process cards swap under a pinned word, Ario's practice cards replace each other.
4. **Cascading or interleaved text placement** (`css-only` layout, `small-js` for realignment): Poor Charlie's diagonal foreword cascade, a-lign's interleaved two-sentence quote that slides into alignment, Blimp's width-justified tracked words. → Bridge: interleaved ES/EN sentence that resolves into two columns.
5. **Scroll-linked reading reveals** (`small-js`, or `css-only` with `animation-timeline: view()` and a fallback): Lifeworld blur→sharp per word; Exat y+skewY 1.5–1.7 s `expo.out`, stagger 0.015 (GSAP there, reproducible with CSS transitions plus IntersectionObserver); Mosby 650 ms `cubic-bezier(0.33,1,0.68,1)` on sheet moves.
6. **One accent used only for state** (`css-only`): a-lign coral = progress, quotes and contact; Blimp red = arrows and asterisks; Exat pink = the highlighted stat line. → Bridge: amber only for "where you are" on Tinta grounds.
7. **Archival or document marks as decoration** (`css-only`): Mosby's scale bar and compass roses, Blimp's bracket corners and "LAST UPDATED", Ario's ruled micro-tables, Poor Charlie's bracketed buttons and mono strip, Lifeworld's live clock (`small-js`).
8. **Slice-assembly monuments** (`needs-library` as built at Lifeworld (SvelteKit + Lenis, SVG parallax). Reproducible as `css-only` scroll-driven animation in Chromium with a static fallback elsewhere.) Lifeworld (LIFEWORLD, OLAFUR ELIASSON, CIRCA). It appears on one site only, so it is a single example.

---

## 4. The five largest gaps against the current Bridge captures

Reference: `audit/remaster-r2/before/home/sheet.png` (scroll-02 to scroll-10).

1. **Middle-section headings are labels, not objects.** "Cómo trabajamos", "Por qué Bridge" and "Guías" are small Literata headings in the left column with rows on the right (scroll-07 to scroll-10). Every kept site makes the section word huge or turns it into a stateful object (a-lign, Lifeworld, Exat).
2. **Lists are rows, never things.** Services, "Por qué Bridge" and the guides render as text rows with thin rules. None of them is a tab, spine, card, register or tile, which is what Mosby, Neue Montreal, Ario, Blimp and Exat do. Documento especially lacks a document-material treatment (folder tabs, ruled record cards).
3. **No layering in the middle.** Nothing overlaps from scroll-02 to scroll-10: no sticky sheets, no card over monument. The kept sites stack folders (Mosby), lay cards over type (Blimp), or cross 3D planes (Ario).
4. **Ground changes are only white, Bruma and one Tinta block.** There is no colour-field rhythm. Exat, Mosby and Lifeworld alternate full-bleed grounds at every chapter. Bridge's Tinta "Voz en vivo" block (scroll-05/06) is the only shift before the footer.
5. **The trail is ornament, not mechanism.** The dotted trail appears as small dividers (scroll-07 dots, scroll-12 underline) but never *does* anything. In a-lign the equivalent material (hatch strokes) builds the letterforms and shows progress, and in Lifeworld the slices build the word. The interleaved-bilingual-sentence and dot-fill-word moves would make the trail and the translation idea perform.

## 5. Skill rules that materially changed the analysis

None loaded. The brief's lens and the rule "never describe a move not seen in a frame" shaped the write-up. Several sites' hover and transition behaviour is marked `not determinable` because of that rule.

## 6. Failed, blocked, or not done

- **Capture failures:** freespeech.gubrica.com (2× timeout, dropped), pendragoncycle.com (2× timeout, dropped), press.stripe.com (1× timeout, not retried), structureengineering.com.au (goto timeout), forthetimes.law (Cloudflare 522).
- **The motion-probe skill script ignores `CHROMIUM_PATH`** (line 156 launches the default Playwright browser, whose headless shell is not installed). The first probe run failed on all four sites. I ran an unmodified-logic copy at `/tmp/claude-1000/-home-cheboy04-Projects-Bridge/01370ea9-c54a-4efb-8bd1-cc3bb9bbcec0/scratchpad/awards-motion-probe.mjs` with only the launch line patched to use `executablePath: CHROMIUM_PATH`. The skill file is untouched. The skill owner may want that fix upstream.
- **Motion probed:** lifeworld, mosby, a-lign, exat (sheets at `<slug>/motion/sheet.jpg`). Not probed: poor-charlie (static page), neue-montreal, blimp, ario-law.
- **Not searched:** Lovers Magazine. CSSDA and FWA were checked only through web search (no listing fetch).
- **Neue Montreal at 390:** the capture is black (the loader never finished), so it is `not determinable`.
- **Shared scratchpad:** another agent overwrote my first helper script (`cap.sh`) in the shared scratchpad, and the first batch ran a wrong script. I re-ran it under a unique name (`awards-cap.sh`). No frames from that mix-up were kept.
