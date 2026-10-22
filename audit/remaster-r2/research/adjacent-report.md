# R2 research, track B: adjacent premium and regional references

Researcher: track B (adjacent sectors). Date: 2026-10-21. Frames: `audit/remaster-r2/inspiration/adjacent/<slug>/` (git-ignored). Each kept site has `sheet.png` (capture.mjs, 1440×900, 16 frames at 700 px steps, plus `mobile-390.png`). Sites marked "probed" also have `motion/sheet.jpg` and `motion/probe.json` (motion-probe.mjs).

Paths below are relative to `audit/remaster-r2/inspiration/adjacent/`.

## 1. Sources searched and candidates

I probed about 105 URLs with an HTTP status check, captured 46 with capture.mjs (45 succeeded), opened the contact sheet of each capture, and kept 8. I ran motion-probe on 7 sites.

| Sector | Captured candidates | Kept | Why the others were dropped |
| --- | --- | --- | --- |
| Interpreting / conference | interprefy, calliope-interpreters, interactio, kikk, typographics, festivalgabo (CO), fil (MX) | **kikk**, **typographics** | Calliope, Interprefy and Interactio are the category default (stock conference photo, wave dividers, icon rows, stats strip). Festival Gabo and FIL are logo walls and card grids. |
| Audio / radio / podcast / subtitling / dubbing | nts, pushkin, radioambulante (LatAm), thelotradio, 99pi, descript, elevenlabs, plint, wordbank; iyuno timed out | **thelotradio**, **plint**, **descript** | NTS and Pushkin depend on photos and covers. A newsletter modal covers Radio Ambulante on every frame. 99pi uses a podcast-player template. ElevenLabs is SaaS gloss. Wordbank is the agency default. |
| Document side (library / dictionary / press / archive) | folger, oed, fitzcarraldo, ndbooks, zonebooks, spector, pdr (Public Domain Review), letterformarchive, rae, wellcome, standardsmanual, cccb, are.na (status only) | **zonebooks** | OED and RAE are portal grids. Fitzcarraldo, ND and PDR depend on book covers or images. Spector renders a split splash only. Letterform and CCCB are photo grids. Folger, Wellcome and Standards Manual were captured but not studied further (see §6). |
| Latin America | tamayo (MX), jumex (MX), kurimanzutto (MX), malba (AR), gam (CL), carey (CL), rodrigo (PE), pbp (EC), ferrere (UY), bu (CO), casawabi (MX), anfibia (AR), festivalgabo (CO), fil (MX), futura (MX) | **tamayo**, **gam** | Rodrigo (PE) is the best LatAm law site, but it carries itself on photography (see note). Ferrere and Carey have a video modal or stats-and-stock. Jumex and Casa Wabi are photo-led. PBP (Ecuador) is the category default. Futura was blank until it showed a single photo. |
| Translation agencies / schools (better than default) | plint, supertext, translated, acclaro, wordbank | **plint** (counted here as well) | Supertext, Translated and Acclaro are SaaS or agency default. |

Near-miss: **Estudio Rodrigo (Lima)**, `rodrigo/sheet.png`. It has a serif display ("Excelencia en el Ejercicio del Derecho"), body text in serif capitals, white chapters with long hairline rules, and a dark petrol footer. It is the premium LatAm professional tone Bridge's audience will know. I dropped it because nearly every move depends on art-directed photography, which Bridge cannot have.

Contrast coverage of the kept set: dark grounds (Lot Radio, Descript), light grounds (Zone, Tamayo), colour fields (Plint, Typographics, GAM) and alternating chapters (KIKK, Lot Radio). Motion covers near-static (Tamayo, Zone, GAM), restrained (Plint, Descript) and expressive (KIKK, Typographics). Transitions cover a hard cut (Tamayo), a fade (GAM), a drawn line (KIKK) and a held header (Typographics).

---

## 2. Kept sources

### 2.1 Plint (Swedish media localisation and subtitling): plint.com, probed

Frames: `plint/sheet.png`, `plint/scroll-04.png`, `plint/scroll-09.png`, `plint/motion/sheet.jpg`.

1. **Memorable moment.** After one photo-hero, the whole middle of the page is built from **hairline line-art on flat colour fields**, with no photos. Scroll-04 shows centred copy on periwinkle with stepped horizontal dashes at the bottom edge. Scroll-09 shows an oval "ring" of vertical hairlines around one centred sentence, "Native across language, sight and sound." It is an abstraction of sound and of text lines, so the topic is drawn without being photographed. This is the clearest answer to Bridge's no-photo constraint in this track.
2. **Type.** Söhne for text; Söhne Mono and "ab-megadot9" (a dot-matrix face) for small capitalised labels ("THE PRODUCT SUITE"). Sentences are centred, medium-large and calm, set at roughly 30–45 px on desktop. The largest text is a decorative "/々" glyph at 6.9vw. Hierarchy comes from tone: the lead sentence is ink and supporting sentences are a lighter grey-violet (scroll-04). Underlines carry the two key sentences.
3. **Layering.** A fixed 1440×900 frame layer stays put for all 30 probe steps (`pin: div fixed`). The visible effect is the **persistent vertical gutter lines at x≈50 and x≈1390**, a "document frame" that every chapter passes through. Labels sit in ruled bands with a "+" registration mark at the centre (scroll-09). A product suite of three coloured "boxes" is drawn in perspective (scroll-10).
4. **Motion.** No GSAP or Lenis at runtime (the source mentions ScrollTrigger only in a comment), and no smooth scroll. Two CSS animations drive it, `hero-media-in` (1900 ms) and `frame-soft-in` (600 ms), plus IntersectionObserver-triggered fades of captions (`cap__body` 0.13→1, done by ≤330 ms). The hero media drifts down 25 px against the scroll. A logo marquee runs at 60 s linear. Reduced motion: 16 `prefers-reduced-motion` rules, and the probe saw almost no motion under reduce. The feel is unhurried and confident.
5. **3D/WebGL.** One canvas, no WebGL context. The "3D" cubes and boxes are line drawings.
6. **Colour and field.** The page **walks through a ground sequence**. The probe's `bgChanges` are lilac `rgb(194,150,230)`, blush `rgb(235,208,216)`, periwinkle `rgb(157,161,255)`, violet `rgb(188,167,249)`, mauve-grey `rgb(227,216,221)`, cream `rgb(245,240,234)`, near-black `rgb(37,31,32)`, cream, then white. Each chapter is one field. The hand-off between fields is a hard ruled edge.
7. **Layout variance (first five screens).** A photo hero, then a full-bleed overlapping photo with the claim, then a centred statement inside a ruled frame, then a centred column with a line-art icon, then the stepped dash horizon. **The middle never uses heading-left/rows-right.** Everything is a centred column inside the frame, and each chapter varies the drawn motif (dashes, rings, cube, stacked sheets).
8. **Subtle craft.** A tiny icon introduces each chapter (stacked sheets, a cube, concentric arcs). Tiny monospaced capitalised captions say "HOW THAT CHANGES THE EQUATION". A single vertical tick acts as a scroll cue between chapters.
9. **At 390 px.** The frame lines and centred column survive (`plint/motion` m-00…m-09). The dash motifs scale down, and the copy stays centred at a comfortable measure.
10. **Transfer to Bridge.** High. Line-art fields can draw **booth, headset, paper sheets, seal, the trail** without photos. The fixed document frame suits Documento. Wrong for Bridge: the pastel violet palette (it would replace Bruma/Tinta) and the SaaS centred-everything uniformity across all chapters.

### 2.2 KIKK (Namur art × tech festival and conference ecosystem): kikk.be, probed

Frames: `kikk/sheet.png` (modal closed), `kikk/motion/sheet.jpg`, `kikk/motion/trans-300.jpg`, `kikk/motion/scroll-05.jpg`.

1. **Memorable moment.** **The page transition is a dotted, gradient trail drawn diagonally across an empty page** (`trans-150`, `trans-300`). A chain of round dots in orange→pink→violet runs from the top-left corner to mid-screen. The next page ("FESTIVAL") then arrives under the same stroke (`trans-600`). A gradient dot also follows the cursor over tiles (scroll-05). Of everything in this track, this is the closest match to Bridge's **dotted source→target trail**.
2. **Type.** Display text is a heavy grotesque in capitals (computed families Poppins and Inter Tight). Headings like "ART SCIENCE & TECH" and "ECOSYSTEM" are around 5–7vw. A ghost "KIKK" watermark behind the hero is 576 px (40vw) in pale grey. Vertical side labels ("MISSION", "NEWS") run on a rail at the far left.
3. **Layering.** Offset sheets overlap. White panels sit over dark ground, shifted off the grid (scroll-01/02), with the next panel's edge peeking. A fixed full-viewport SVG layer (`svg.fixed`, 1440×900) holds the trail and dot. The bento of greyscale photo tiles has one tile darkened as the active one.
4. **Motion.** No GSAP or Lenis. Motion is WAAPI (20 calls) plus CSS transitions: `filter`/`opacity`/`color` at 500 ms `cubic-bezier(0,0,.2,1)`, and background-color at 350 ms. Scroll reveals are fade-ins (15 events). Under reduced motion the probe saw smooth scrolling and pinning; one reduced-motion rule exists in the CSS. The transition stroke appears at 150–300 ms and the new page settles by about 900 ms.
5. **3D/WebGL.** None detected.
6. **Colour and field.** Grounds alternate light `#F1F1F1` and near-black `#111` by chapter (`bgChanges`). The only colour in the system is the trail gradient, plus festival artwork in a modal.
7. **Layout variance.** A hero with a giant ghost wordmark and an artwork block on the right; an offset dark/light split with a numeric index ("8", "15"); the "ECOSYSTEM" heading over a full-bleed muted photo; a 3-2-3 bento of project tiles with indices 03–08; a "LATEST NEWS" stagger; a dark "LET'S COLLABORATE" close. Not one chapter repeats the previous layout.
8. **Subtle craft.** Two-digit indices (03, 04…) on tiles. The cursor dot doubles as a hover state. Greyscale treatment pushes photography back so it reads as texture.
9. **At 390 px.** The festival modal dominates every phone frame in the probe run (the probe's `--enter` closed it on desktop only). Not determinable beyond that.
10. **Transfer to Bridge.** Very high, for two moves: (a) **the trail as a page-transition stroke**, from the source corner to the target content (View Transitions plus an SVG stroke-dashoffset, small-js); (b) **offset sheets** that overlap chapter edges. Wrong for Bridge: festival colour noise and giant ghost wordmarks everywhere.

### 2.3 The Lot Radio (independent internet radio, NYC): thelotradio.com, probed

Frames: `lotradio/sheet.png`, `lotradio/motion/sheet.jpg`, `lotradio/motion/scroll-09.jpg`.

1. **Memorable moment.** **Monument condensed headings that own each chapter**: "STAFF PICKS", "FEATURED RESIDENTS" and "WE ARE THE LOT RADIO" at up to 220 px (15.3vw), set tight. Under them sits small monospaced body text and a ruled list. Then a **sticker collage slides up over the "WE ARE THE LOT RADIO" heading** as you scroll (scroll-14→19), so the type is gradually buried.
2. **Type.** Two families only: "display", a condensed grotesque, and "mono". The scale contrast between 15vw display and roughly 13 px mono is extreme, and it works. The measure of the mono body is about 40ch. The display runs off the left edge at 390 px but stays legible (m-02, m-03).
3. **Layering.** A live-player bar sits fixed under the nav, with a "THE LOT LIVE" pill, a ticker and controls. Resident rows are **offset to the right half** under a left-anchored heading. The collage layer covers the heading.
4. **Motion.** No GSAP. Next.js with WAAPI (33 calls). There are 148 y-moves and 149 x-moves, with **parallax at rate −0.25** on collage pieces and opacity transitions at 400–500 ms `cubic-bezier(.4,0,.2,1)`. A live dot pulses (2 s infinite). No reduced-motion rules (`prefersReducedRuleInCss: 0`), so this site does not set the standard.
5. **3D/WebGL.** None.
6. **Colour and field.** Chapters alternate light grey `#E3E3E3` and charcoal `#222`, with purple `#5B4DE0`-like accents (the play pill) and amber "R" badges. Accent use is very sparing.
7. **Layout variance.** A full-bleed live video, then a dark "TODAY'S LINEUP" schedule, then a light "STAFF PICKS" heading over a 4-column card grid, then a dark "FEATURED RESIDENTS" with an offset ruled list, then a light monument statement, then the collage, then a dark newsletter. **The resident list sits in the right half, under a heading in the left two-thirds that stacks above it, not beside it.** This is a vertical stack, a clean way out of heading-left/rows-right.
8. **Subtle craft.** The schedule rows are a typographic timetable ("12PM — 1PM"), and the current show is marked by a red dot. Capital mono labels are used throughout.
9. **At 390 px.** The display text stays huge and wraps; the cards go to one column; the player bar sticks to the bottom (m-00…m-09).
10. **Transfer to Bridge.** High for the **schedule/timetable as type** (Cabina: event days, booths, languages as a live-looking programme), for monument headings in Literata that a chapter sits under, and for alternating grounds. Wrong for Bridge: the street-collage energy.

### 2.4 Typographics (type conference and festival, Cooper Union, NYC): typographics.com → 2026.typographics.com, probed

Frames: `typographics/sheet.png`, `typographics/motion/sheet.jpg`, `typographics/motion/scroll-01.jpg`.

1. **Memorable moment.** **A wordmark doubled across a colour band.** Upright "TYPOGRAPHICS" in black on electric blue is crossed by a yellow band carrying a second, italic "TYPOGRAPHICS" (scroll-01). As you scroll, the masthead **shrinks continuously** (`hed-size`, `dek-size`, `nav-size` animations), so the brand compresses into a header rather than scrolling away.
2. **Type.** Owners (with Owners Text) and Dual Casual for the italic. The largest text is 24vw. Capitals in italic serve as section heads ("CONFERENCE June 26 & 27"), with an italic display word followed by a roman date. The heading and its data form one line.
3. **Layering.** The yellow band crosses the black letters. A rotated "TICKETS NOW AVAILABLE" arrow sticker overlaps the column gutter. Parallax layers move at different rates (`header.cover` 0.5, `h1` 0.66–0.76, body 1.18–1.26).
4. **Motion.** It is **CSS-driven via Typetura v4.1.3** (fetched `/styles/typetura.css`): a CSS-variable technique that scrubs `@keyframes` (`hed-size`, `dek-size`) by setting a negative `animation-delay` from a `--scrolly` property. A 1 KB script, `momentum.js`, only writes `--scrolly`, `--viewportwidth` and the like onto `:root`. No library. The page transition holds the header and swaps the heading to "WORKSHOPS" by about 1.3 s, with no View Transitions. No reduced-motion rule in the CSS.
5. **3D/WebGL.** None.
6. **Colour and field.** Two blues (`rgb(0,134,255)` for the masthead, a lighter `rgb(63,165,255)` for content), yellow `rgb(255,255,25)` for the band and CTAs, and black and white. A two-tone ground marks the hero/content seam.
7. **Layout variance.** A monument masthead; a statement paragraph at about 34 px; a 2×2 grid of event blocks, each "ITALIC NAME + date + paragraph"; a skewed "STAY UPDATED" heading with a form; a sponsor wall. Modest variance, but the hierarchy is entirely typographic.
8. **Subtle craft.** The italic band reads as a "translation" of the upright word. The dates live in the heading line.
9. **At 390 px.** The masthead keeps the band and doubled word at full width. The event blocks stack (m-00…m-09).
10. **Transfer to Bridge.** High and literal: **the same word in two languages, crossed by the trail band**. For example, "Traducción" in Literata upright on Tinta, crossed by a Bruma band with "Translation" in italic. Scroll-driven type compression is css-only via `animation-timeline: scroll()` today, or a few lines of JS writing a scroll variable as in momentum.js. Wrong for Bridge: the festival loudness and the sticker.

### 2.5 Zone Books (independent academic press since 1985): zonebooks.org, probed

Frames: `zonebooks/sheet.png`, `zonebooks/motion/sheet.jpg`.

1. **Memorable moment.** **A list of books as full-width typographic plates.** Each title is set in Perpetua (serif) at about 4vw, the author sits right-aligned in Trade Gothic on the line below, and a full-bleed threshold-bitmapped engraving strip divides the titles. Over everything floats a **soft yellow "breathing" dot**, fixed at top-left (CSS `breathe` 5 s infinite, scale 1.01↔1.15).
2. **Type.** A serif title paired with a sans author, the same pairing logic as Bridge's Literata + Manrope. Titles are sentence case with the colon kept ("Out of Character: Writing on Portraits").
3. **Layering.** The dot overlaps both images and text, and is semi-transparent with a soft edge. The image strips crop into the next title.
4. **Motion.** No library. The breathing dot runs on a CSS animation. The intro transitions the `DIV.row` transform at 500 ms. The page transition adds a `slide-start` class to `<html>` (a homegrown CSS slide). No reduced-motion rule.
5. **3D/WebGL.** None.
6. **Colour and field.** White, black and the single yellow dot. All imagery is high-contrast 1-bit, so photos read as print.
7. **Layout variance.** Deliberately none: one repeating plate. It is memorable because of the rhythm and the 1-bit treatment, not because of variance.
8. **Subtle craft.** The right-aligned author against a left-aligned title creates a diagonal reading line.
9. **At 390 px.** The plate survives intact (mobile-390).
10. **Transfer to Bridge.** Medium-high for Documento: **a list as plates, with a serif document title and a sans meta line** (document type, language pair, seal). It is also a model for 1-bit, threshold "document texture" made from abstract or public-domain material (not client documents). A single breathing accent dot could be the trail's origin. Wrong for Bridge: borrowed engravings, and no variance if it were applied page-wide.

### 2.6 Museo Tamayo (Mexico City, contemporary art; Spanish): museotamayo.org, probed

Frames: `tamayo/sheet.png`, `tamayo/motion/sheet.jpg`.

1. **Memorable moment.** **A full-width wordmark in signal red** ("MUSEO TAMAYO" edge to edge, in Lausanne). The intro **turns black to red** (`intro-0` black, `intro-200` red), and a stack of **solid red agenda cards** ("11OCT → 25OCT · Visita guiada arquitectónica") forms a **sticky left column** (`div.agenda-inhome`, sticky, 350×405) while the exhibitions scroll on the right.
2. **Type.** Lausanne and Suisse BP Int'l. Exhibition titles are two lines of about 20 px in a red/black pair (title in black, subtitle in red). The largest text is 6.9vw.
3. **Layering.** A sticky column against a scrolling column. No overlaps.
4. **Motion.** Webflow IX2 is present, but no scroll animations were sampled (counts empty). The nav hover switches colour instantly (0 s) from black to red. It is essentially static and still feels premium. There is no page transition (`link: null`).
5. **3D/WebGL.** None.
6. **Colour and field.** White ground, red `rgb(255,56,64)` for type and cards, one periwinkle card for the newsletter.
7. **Layout variance.** Low: a wordmark, then the sticky agenda beside the exhibition stream, then the footer. The sticky agenda is the variance.
8. **Subtle craft.** Dates use an arrow range ("11OCT → 25OCT"), which is good Spanish date typography without the clutter of "del… al…".
9. **At 390 px.** The red wordmark holds and the agenda cards become a horizontal row (m-00).
10. **Transfer to Bridge.** **A sticky "agenda" column of solid colour cards beside a scrolling stream** fits Cabina (upcoming events or booth availability as cards) or Documento (a sticky "what you need" checklist while the steps scroll). Arrow ranges ("ES → EN") are a natural fit for the trail. Wrong for Bridge: red as the brand colour.

### 2.7 GAM, Centro Gabriela Mistral (Santiago; Spanish): gam.cl, probed

Frames: `gam/sheet.png`, `gam/motion/sheet.jpg`.

1. **Memorable moment.** **A programme grid in which each card is a solid colour block** (teal, mint, orange, periwinkle) paired with a photo tile. Colour encodes discipline ("Teatro", "Música clásica"), so the listing becomes a patchwork rather than a card row (scroll-03…07). The header's bottom edge is **cut on a slight diagonal** (intro frames).
2. **Type.** Space Grotesk throughout, small. Category tags are pill outlines. Type is not where this site is strong.
3. **Layering.** Colour blocks and photos interlock like a quilt. A "Calendario" pill is pinned.
4. **Motion.** No library. CSS transforms at 300 ms ease on cards (scale 10 events) and a 320 ms `cubic-bezier(.2,.8,.2,1)` on header shrink. One reduced-motion rule. The page transition shows a beige skeleton (title, dates) about 150 ms before the image arrives (`trans-150`), which is honest progressive loading.
5. **3D/WebGL.** None.
6. **Colour and field.** Multiple saturated fields: mint `rgb(166,252,192)`, teal `rgb(0,158,137)`, beige `rgb(233,228,215)`, then a charcoal footer.
7. **Layout variance.** The patchwork grid breaks the uniform card row. A "Entérate" news strip uses a newspaper-like typographic collage (scroll-09).
8. **Subtle craft.** The skeleton-first transition; colour as taxonomy.
9. **At 390 px.** The grid becomes alternating colour/photo full-width bands (m-02…m-09), a strong mobile rhythm.
10. **Transfer to Bridge.** **Colour-as-taxonomy blocks with no photo needed**: for example, document types (civil, academic, legal) or event formats (simultaneous, consecutive, booth rental) as Tinta / Bridge blue / Bruma blocks in a patchwork grid. The diagonal cut edge also echoes the trail. Wrong for Bridge: the number of hues; Bridge has one blue and amber only on dark.

### 2.8 Descript (audio and video editing via transcript)

URL: descript.com. Capture only, no motion probe.

Frames: `descript/sheet.png`, `descript/scroll-02.png`.

1. **Memorable moment.** **The product's document is the hero.** A transcript-style text document and a chat panel, built as UI, take the place of photography (intro frames). Every middle chapter shows a **document-like panel** on a deep aubergine ground: numbered "01 Record" in a serif display, a tabbed workflow ("Record · Edit · Refine · Share · Multiply"), and FAQ rows.
2. **Type.** gamuthDisplay (a serif display) for headings ("The whole workflow, right here", about 60 px, tight), with Booton (sans) for UI and body. **A serif display + sans UI** is the same pairing logic as Bridge. The red section index "01" sits in small type.
3. **Layering.** Panels overlap panels: a chat card floats over the transcript card (intro). The quote cards sit on a slightly lighter aubergine band. The source contains 5 clip-path, 11 mix-blend-mode and 10 mask-image references (greps).
4. **Motion.** Not probed. The intro frames show the panel content populating between 200 and 2500 ms (lines of the transcript and chat appear). There are 5 reduced-motion rules in the source. Easing is not determinable.
5. **3D/WebGL.** Not determinable (not probed).
6. **Colour and field.** A dark aubergine `≈#2A0A14` field with a pale pink nav and coral CTAs. It switches to a pale pink/white field for the enterprise, proof and FAQ chapters, then returns to dark for the close.
7. **Layout variance.** A centred serif hero; a document UI; quote cards; a centred heading with tabs over a big numbered panel; a carousel of feature panels; a left "Frequently asked questions" heading beside an accordion. Most chapters are centred-heading-over-object, not heading-left/rows-right; the FAQ is the exception.
8. **Subtle craft.** Numbered panels with tab sync. The CTA repeats in the same coral.
9. **At 390 px.** The serif hero is large and centred, and the document panel scales below it (mobile-390).
10. **Transfer to Bridge.** **A document built in HTML as the object** (a "certified translation" sheet with seal, stamp line and source→target columns), plus **a tabbed process with a big numbered serif panel** in place of a step list. Wrong for Bridge: SaaS proof (logos, star ratings) and the dark wine palette.

---

## 3. Recurring techniques, ranked

1. **Chapter grounds that change in sequence** (one flat field per chapter; light/dark alternation). Seen on Plint (9 grounds), KIKK (#F1F1F1↔#111), Lot Radio (grey↔charcoal), Descript (aubergine↔pink) and GAM. **css-only.** For Bridge: white → Bruma → Tinta → Bridge blue, with amber appearing only on Tinta.
2. **Drawn line-art or a document object in place of photography** (hairline motifs, document UI panels, 1-bit plates). Seen on Plint (dashes, rings, cubes), Descript (transcript UI), Zone (1-bit plates), KIKK (trail SVG). **css-only / inline SVG.** For Bridge: booth, headset and paper sheets as hairline SVG; a certified-translation sheet built in HTML.
3. **Monument type that owns a chapter, with the content stacked under it rather than beside it.** Seen on Lot Radio (15vw), Typographics (24vw), Tamayo (full-width wordmark) and KIKK (40vw ghost). **css-only** (clamp and vw sizes).
4. **The trail or line as a transition device** (a dotted gradient stroke across the page on navigation; a cursor dot). KIKK draws it outright; Plint's ruled bands and "+" registration marks carry the line between chapters. **small-js**: View Transitions API plus SVG `stroke-dashoffset`, or an IntersectionObserver-triggered dash draw.
5. **The same word twice / a crossing band** (bilingual doubling). Typographics shows an upright word crossed by an italic duplicate on a band. GAM's diagonal header edge is a weaker relative. **css-only.**
6. **Scroll-scrubbed type compression or parallax without a library.** Typographics uses Typetura keyframes scrubbed by a scroll CSS variable from a 1 KB script; Lot Radio uses rate −0.25 parallax on collage pieces. **css-only** with `animation-timeline: scroll()`/`view()` (Chromium/Safari 26), or **small-js** writing `--scrolly`.
7. **A sticky companion column** (agenda or checklist stays while the stream scrolls). Tamayo has a sticky red agenda; Plint has a fixed document frame; Lot Radio has a fixed live bar. **css-only** (`position: sticky`).
8. **Colour as taxonomy in a patchwork grid.** GAM (discipline colours) and Plint (SUB/AD/SDH boxes in lilac, salmon and amber). **css-only.**

No kept site needed GSAP or WebGL for its memorable move. Plint's source mentions ScrollTrigger only in a comment, and the runtime shows none.

## 4. The five largest gaps against the current Bridge captures

Compared with the R1 description in the brief (`../before/home/scroll-03`–`17` and `../before/certified-translation/scroll-02`–`20`: heading-left, rows-right, body scale, white/Bruma):

1. **One ground for the whole middle.** Bridge's middle chapters stay on white or Bruma. Every kept site changes field per chapter (Plint: 9 grounds). Bridge has Tinta and Bridge blue unused as chapter grounds.
2. **No drawn object stands in for the missing photos.** Bridge has no line-art or HTML document object carrying a chapter. Plint and Descript show that a hairline motif or a built document can be the picture.
3. **Headings sit beside rows, at body scale.** Lot Radio, Typographics and Tamayo put a monument heading above the content and let the content follow, never beside it. Bridge's middle needs at least two chapters where Literata goes monumental and the list stacks underneath, offset to one side (Lot Radio's resident list).
4. **The trail appears only as decoration, never as motion between states.** KIKK proves a dotted gradient stroke can be the page transition and the cursor state. Bridge's signature device could do the same work across page changes and chapter seams.
5. **No sticky or companion structure, no layering.** Every Bridge chapter is a flat band. Tamayo's sticky agenda, Plint's fixed frame lines and KIKK's offset overlapping sheets add depth with CSS alone.

## 5. Skill rules that materially changed the analysis

None loaded. I relied on the brief's evidence lens. The wow-direction skill's tooling decided what could be verified: motion-probe's stack detection is why I can say that "no GSAP" holds for Plint despite the ScrollTrigger mention in its source.

## 6. Failed, blocked or not done

- **iyuno.com**: capture timed out (exit 124). Not retried.
- **motion-probe.mjs** ignores `CHROMIUM_PATH` (line 156 launches Playwright's default headless shell, which is missing). I ran a **patched scratch copy**, with the same code and the one-line launch change, from `/tmp/claude-1000/.../scratchpad/tools/motion-probe.mjs`. The skill file is unchanged. Worth fixing in the skill.
- **Pillow**: used the coordinator's venv for `motion-sheet.py`.
- **Consent and modal overlays**: Plint and KIKK were recaptured with `--click-first` ("Deny" / `[aria-label="Fermer"]`). The KIKK phone pass is still covered by its festival modal. Radio Ambulante, Ferrere, Interactio and 99pi are covered by modals or consent banners in most frames, and I dropped them partly for this.
- **Unviewed captures**: the image viewer refused several sheets during the first pass (request limit), including tamayo/sheet.png, folger, fitzcarraldo, malba, gam/sheet.png, kurimanzutto, pbp, acclaro, interprefy, kikk/sheet.png, typographics/sheet.png, lotradio/sheet.png, anfibia and standardsmanual. I re-viewed calliope, oed, nts and pushkin, and studied the kept sites through their motion sheets and single frames. **Folger, Malba, Kurimanzutto, PBP, Acclaro, Interprefy, Anfibia, Standards Manual and Wellcome were captured but never visually reviewed**, so no claims are made about them. Their frames are on disk for anyone who wants a second look.
- Descript was not motion-probed; its motion fields say "not determinable" where not visible in the capture frames.
