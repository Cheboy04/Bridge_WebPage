# R2 track C: layout and identity galleries

**Date:** 2026-10-21 · **Track:** C (galleries) · **Frames:** `audit/remaster-r2/inspiration/gallery/<slug>/` (git-ignored)
**Numbered contact sheets:** `inspiration/gallery/00-layout-sheet.png` (L1–L8), `inspiration/gallery/00-identity-sheet.png` (I1–I8).

Researcher's evidence only. No decisions; no product files touched.

## 1. Sources searched

| Source | Query / page | Result |
| --- | --- | --- |
| Godly | `godly.website/?types=["typography"]` | **Redirects to recent.design** (a design-post feed). No site listing reachable. Failed. |
| SiteInspire | Typographic p1–3, Unusual Layout, Minimal, home | ~175 listings scanned (35/page, overlapping). `search?q=law|translation` returned nothing. |
| Land-book | search `law`, `legal`, `translation` | 24 listings. Mostly legal-AI SaaS (Harvey, V7, Flank) and Webflow templates. |
| Fonts In Use | `translation` (40), `law firm` (30), `notary` (3) | 73 uses scanned. Best identity source of the round. |
| Behance | `translation agency branding`, `interpreting brand identity`, `law firm identity serif` | ~65 projects; most off-topic (travel, food, portfolios). |
| Dribbble | `translation-branding` | ~25 shots; mostly app UI. |
| Minimal Gallery, Typewolf SOTD | home | Client-rendered; scan returned no site links. Not used. |
| the-brandidentity.com | `?s=law/translation/language` | Search ignored the query (same 12 recent projects). Not used. |
| Web search | 4 queries | Leads only (Translated dot logo, Tilde, Knorz); not opened. |

**Scanned ≈ 410 listings. Opened and captured: 30** (16 live sites with `capture.mjs`, 14 identity pages). Motion-probed: 4.

### Candidates kept / dropped

| Candidate | Source | Verdict |
| --- | --- | --- |
| stripe.press/poor-charlies-almanack | SiteInspire typographic | **L1** |
| quinngtl.com | Land-book `law` | **L2** (photo-heavy; keep the line and stat moves only) |
| bjorkhemlaw.com | Fonts In Use `law firm` | **L3** + **I3** |
| gt-standard.com | SiteInspire typographic | **L4** + **I8** |
| of.domains (Openfield) | SiteInspire typographic | **L5** |
| stripe.dev | SiteInspire typographic | **L6** |
| lifestories.org | SiteInspire minimal | **L7** (photo-heavy; keep one section) |
| area17.com | SiteInspire typographic | **L8** |
| alexandraperles.com | Land-book `translation` | **Dropped as live site: the domain now serves an unrelated Chinese novel site** (`alexandraperles/sheet.png`). Identity kept from Fonts In Use as **I1**. |
| harvey.ai | Land-book `legal` | Dropped: SaaS gloss, dashboard mock hero, logo wall, stats band (warning set). |
| ambarpartners.com | Land-book `legal` | Dropped: category default (centred serif hero, yellow CTA, cards, world map, stats). |
| veritas-partners.co.uk | Land-book `legal` | Dropped: stock office photos + 3D renders; numbered service rows are the R1 baseline again (`veritas/scroll-02.png`). |
| royalsites.ie | SiteInspire minimal | Dropped as layout (drone photography carries it); mark kept as **I7**. |
| displaay.net | SiteInspire typographic | Dropped: foundry merch photography; colour-field tiles noted only. |
| haavind.no | Fonts In Use | Dropped as layout (cookie wall, photo bands); identity kept as **I2**. |
| nonfiction.cc | SiteInspire typographic | Dropped: magazine index, not transferable. |
| kunsthallebasel.ch | SiteInspire typographic | **Capture failed** (node error, exit 1); not retried for time. |
| Transferendi (Behance) | Behance | **I4** |
| Surte & Co. (Behance) | Behance | **I5** (mockup-heavy, flagged) |
| InkTree Translations (Dribbble) | Dribbble | **I6** (thin; flagged) |
| 1-StopAsia, Transvoca, Tomo | Behance / Dribbble | Dropped: invented symbols, gradient/stock/SaaS imagery, laptop and phone mockups. Warning set. |
| Doniec Górecki, Seraj, Byland, Roots Law | Fonts In Use | Dropped: richness lives in photographed print mockups; nothing survives on screen. |
| Mueller Wagner Advocates | Behance | Dropped: **synthetic** CGI buildings and glowing chess piece. Warning. |

---

## 2. Layout picks (live sites)

### L1 · Stripe Press — Poor Charlie's Almanack (`stripe-press-almanack/`)
https://www.stripe.press/poor-charlies-almanack/

1. **Moment:** the table of contents *is* the page. `01/02/03`, `01 / 02 / 03 / 04 / 05 / 06 / 07 / 08 / 09 / 10 / Eleven` set as monuments in a condensed high-contrast serif; on the right, "Foreword *by* John B. Collison" etc. stepped diagonally down and right (`scroll-00.png`). Works because numbers and names are the only content, and they are set at 8–10vw.
2. **Type:** one serif family (roman + italic) for everything; italic only on the joining word (*by*, *and*, *of*, *Eleven*). Small caps-like underlined labels (CHAPTERS, BACK MATTER). Monospace UI chrome (`[▸] AUDIOBOOK [1.5X]`). Measure is irrelevant: it is a list.
3. **Layering:** none; a fixed 1px frame with a dashed centre gutter like a book spread.
4. **Motion:** wheel scroll does not move the page (all 16 frames identical); the composition is one viewport. Intro 600 ms shows a faint ghost before type resolves (`intro-600.png`): not determinable beyond a fade.
6. **Colour:** warm grey paper `~#ECECEC`, black ink, no accent.
7. **Variance:** left column = stacked numerals; right column = a staircase of attributions. Same list, two rhythms.
9. **390 px:** stacks to one column, numerals still ~25vw (`mobile-390.png`). Survives.
10. **Transfer:** Bridge's *Cómo trabajamos* (3 steps) and the certified-translation document types are short, nameable lists. Set "01 / 02 / 03" as a monument with Literata, italic only on the connective ("del original *a* la firma"). Wrong: a book cover's preciousness on every chapter.
**Technique:** css-only.

### L2 · Quinn Global Tax Law (`quinngtl/`, motion `quinngtl/motion/`)
https://www.quinngtl.com/

1. **Moment:** thin orange route lines with rounded 90° corners drawn on the dark-brown half of the contact chapter ("Every angle, every path, airtight answers.", `scroll-05.png`); the same lines run over the aerial hero. A path device used as the brand's metaphor, exactly Bridge's trail problem.
2. **Type:** light transitional/grotesk display (~3.5vw), brown ink on cream; numerals in stat cards ~4vw.
3. **Layering:** stat cards staircase: four white cards with coloured left rules, each top offset ~80px lower than the previous (`scroll-04.png`). Hero ends in stepped coloured tabs (cream / mint / orange / brown) like file-folder tabs (`intro-1200.png`).
4. **Motion (runtime confirmed):** GSAP 3.15 + ScrollTrigger + SplitText (Webflow). 12 triggers; split-line text fades in as you scroll (38 split events); `opacity+y+scale, 1s, power2.out` ×14; a "folder" `autoAlpha+y 0.6s` custom ease; a scrubbed (`scrub: 2`) section. No smooth scroll. Ground changes cream → cream-pink → brown `rgb(67,49,45)` → cream. Reduced motion: still animates (no `prefers-reduced-motion` rule).
6. **Colour:** cream `#FEF6F1`, brown `#43312D`, orange, mint. Aerial photos are duotone-graded navy/bronze with a **stochastic dot (stipple) screen** (`scroll-05.png` bottom).
7. **Variance:** services as a big numbered list on brown (motion `scroll-03`), staircase stats, split cream/brown contact. Not heading-left-rows-right.
9. **390 px:** stat staircase collapses; numbered list becomes stacked cards (motion `m-04`–`m-06`).
10. **Transfer:** (a) route lines with rounded corners as an SVG trail between chapters; (b) staircase offset for 3–4 facts (Bridge has no stats: use it for *steps* or *document types*); (c) folder tabs as the ground transition (documents!). Wrong: fake stats ("$100 Million+"); aerial photography.
**Technique:** lines/staircase css-only; line draw-on-scroll small-js (IntersectionObserver + `stroke-dashoffset`) or css scroll-driven `animation-timeline: view()`; split-line reveals small-js (no SplitText needed for 2–3 headings).

### L3 · Björkhem (`bjorkhem/`)
https://www.bjorkhemlaw.com/

1. **Moment:** a centred all-caps serif statement (~3vw, IvyPresto per Fonts In Use) punctuated by two solid green dots, one before the first word and one after the last (`scroll-00.png`). The dot is the brand's mark-module, used as typographic punctuation.
2. **Type:** serif caps for statements, serif small for body, tiny sans for UI. Tight leading (~1.0).
3. **Layering:** the logo's bar-and-circle module becomes a full-bleed green/black pattern band between chapters and a crenellated edge above the footer (`scroll-02.png`–`scroll-04.png`).
4. **Motion:** not probed. Frames show no visible animation.
6. **Colour:** white → black chapters → green `~#00A04A` pattern → black close. Three grounds, one accent.
7. **Variance:** statement (white, centred) → services as centred serif headings + justified paragraphs on black → pattern band → footer. Middle is centred, not split.
9. **390 px:** statement goes to ~12vw serif caps and fills the phone (`mobile-390.png`); hyphenates "ENTREPRENEU-RS" badly.
10. **Transfer:** the dotted trail's dot as punctuation in Literata statements; a pattern band generated from the trail (dots + arcs) as chapter seam and close. Wrong: green; all-caps serif at length (hurts Spanish reading).
**Technique:** css-only (SVG pattern / `radial-gradient` dots).

### L4 · GT Standard (`gt-standard/`, motion `gt-standard/motion/`)
https://gt-standard.com/

1. **Moment:** "① design ② system ③ platform" over three giant "a"s: the first drawn as an outline with **round anchor-point nodes on its bezier points**, the second as stacked offset outlines, the third ringed by an arc (`intro-1200.png`). One letter, three states = three chapters.
2. **Type:** one grotesk at ~10vw display, lower-case; circled numerals as chapter marks.
3. **Layering:** sticky stage where square/circle/triangle morph step-by-step into H O A (motion `scroll-14`–`scroll-21`); green/blue/red specimen panels slide over each other (`scroll-24`–`scroll-29`).
4. **Motion (runtime):** no GSAP/Lenis/WebGL; one bundle; CSS transitions (`translate 500ms cubic-bezier(.4,0,.2,1)`), WAAPI not used, pinned stages (8 pins in reduced pass), scroll counts x-move 29 / y-move 50 / scale 24. Loader is a yellow screen with a ruler and "loading…" (`intro-0`). Smooth-scroll lag median 236 ms (custom). Reduced motion: no CSS rule; still pins.
6. **Colour:** chapter grounds orange-red → black → white → green → yellow. Ground *is* the chapter marker.
7. **Variance:** triad → about (label left, huge statement right) → black specimen → white shape morph → coloured panels. Five distinct compositions in five screens.
9. **390 px:** triad becomes a vertical sequence of one giant glyph per screen (motion `m-00`–`m-03`). Survives.
10. **Transfer:** a numbered triad where the same object shows three states (Bridge: *original → traducción → firma* as one document in three states); anchor-point nodes = the dotted trail on a glyph outline; a sticky stage that morphs one shape into another. Wrong: foundry-specimen loudness, red-orange.
**Technique:** triad css-only; sticky morph stage css scroll-driven (`position: sticky` + `animation-timeline: view()`) or small-js step switcher.

### L5 · Openfield (`openfield/`, motion `openfield/motion/`)
https://of.domains/

1. **Moment:** a whole landscape drawn in **ASCII characters and dots** (clouds, hills, a town, a viaduct, a plane towing a banner) inside a sticky `<pre>`; scrolling pans down through it until it hands over to "Open Field" in a slab serif (motion `scroll-00`–`scroll-26`). Illustration with zero photography, made of type.
2. **Type:** slab serif (~5vw) for statements, monospace caps for process data.
3. **Layering:** sticky 1440×972 `<pre>` pinned for all 30 steps (runtime); content scrolls inside it.
4. **Motion (runtime):** no library; no CSS animations; the pre's content is translated by script per scroll step. Plane and balloons drift. Reduced motion: unchanged (no rule).
6. **Colour:** paper `rgb(245,243,236)`, black ink, one hover accent (amber `rgb(244,187,64)` on the CTA).
7. **Variance:** after the scene, a **grid of grey cells** holds one short serif sentence each ("Not every land fits every seed" / "Not every seed grows alone" / "A domain holds potential" / "A founder brings intent"), then "How it works" as label-left + monospace steps with rules and an IF SUCCESS / IF FAILURE fork (`scroll-14.png`). Process looks composed because it is a diagram, not cards.
9. **390 px:** scene recomposes for portrait (motion `m-00`–`m-09`).
10. **Transfer:** a Quito / booth / document scene drawn in dots (the trail's material) as the one "illustration"; process as a ruled monospace diagram with a fork ("si es notarizada… / si no…"). Wrong: whimsy (planes, balloons) for a certified-document buyer; long scroll-jack.
**Technique:** dot scene small-js or pre-rendered SVG + css-only sticky; process diagram css-only.

### L6 · Stripe Dot Dev (`stripe-dev/`, motion `stripe-dev/motion/`)
https://stripe.dev/

1. **Moment:** the close: "DEVELOPERS" outlined and **stacked as hundreds of offset contour lines** receding into depth, with smaller copies cascading down the centre (`scroll-12.png`). A wordmark turned into a line field.
2. **Type:** grotesk display; monospace UI (`[B] BLOG`); one word swaps to a pixel face ("Dot *Dev*").
3. **Layering:** figure plates labelled `[ FIG. 1 ]` with line-drawn generative objects (motion `m-00`); fixed viewport for the close (pinned 26 steps).
4. **Motion (runtime):** 7 `<canvas>`, no WebGL context, WAAPI ~2.5k calls, CSS ticker 25 s linear; no GSAP. Reduced motion: 2 CSS rules present.
6. **Colour:** pale grey with a faint pastel gradient; black lines; green/blue hover fills.
7. **Variance:** hero → fig plates → dense index table → card links → line-stack close.
9. **390 px:** hero recomposes into a staggered stack (`mobile-390.png`).
10. **Transfer:** "FIG. 1"-style captions turn a drawing into a document plate (Bridge: "Fig. 1 — Acta de nacimiento, apostillada" on a CSS-built document); close with the Bridge wordmark rendered as a stack of thin offset outlines in blue on Tinta. Wrong: developer-tool tone.
**Technique:** fig plates css-only; line-stack close css-only (repeated `text-stroke` layers with `translate`) or small-js canvas.

### L7 · Life Stories (`lifestories/`)
https://lifestories.org/

1. **Moment:** Search / Discover / Ask as three coloured slabs (green, grey-blue, oxblood) that **overlap diagonally like a descending staircase**, each with a huge grotesk verb and a geometric glyph (squares, diamonds) (`scroll-03.png`).
2. **Type:** heavy grotesk verbs ~6vw; light sans body.
3. **Layering:** slab overlap ~120px; a pill scrubber floats over them.
4. **Motion:** not probed (frames show positions change between `scroll-02` and `scroll-03`; trigger not determinable).
6. **Colour:** muted green/grey-blue/oxblood on off-white.
7. **Variance:** this section breaks an otherwise photo-grid page.
9. **390 px:** not captured beyond hero.
10. **Transfer:** Bridge's three steps (Envíenos / Reciba cotización / Reciba traducción) as overlapping slabs in Tinta / Bridge blue / Bruma, each with a big Literata verb. Wrong: the rest of the site (portrait video).
**Technique:** css-only (grid with negative margins); stagger on enter small-js.

### L8 · AREA 17 (`area17/`)
https://area17.com/

1. **Moment:** the industries list set as ~3.5vw grey grotesk lines; **the active line turns black as you scroll and a side card shows that industry's client** (`scroll-04.png` "AI and technology" active → `scroll-05.png` "Arts and culture" active). Close: the A/ monogram cropped full-bleed in black/white (`scroll-11.png`).
2. **Type:** one grotesk, two weights of grey.
3. **Layering:** sticky side card swapping content.
4. **Motion:** scroll-driven highlight (observed in frames); mechanism not determinable.
7. **Variance:** list-as-type is the middle of the page; no card grid.
9. **390 px:** not captured beyond hero (cookie banner).
10. **Transfer:** Bridge's FAQ or document-type list as large Literata lines in grey, active one in Tinta, with a sticky "document" card on the right showing the answer or the document's requirements. Wrong: client logos (Bridge has none).
**Technique:** small-js (IntersectionObserver toggles `aria-current` + card content) or css scroll-driven with `view-timeline` per row.

---

## 3. Identity picks (gallery shots)

### I1 · Alexandra Perles — freelance translator, Paris (`id-alexandraperles/`)
https://fontsinuse.com/uses/47662/alexandra-perles · by Nicolas Garcia, 2022 · type: Mori (sans)

- **Mark logic:** "Aa ↳P": the monogram uses the **↳ return arrow glyph** as the hinge between source and target (`scroll-04.png`). The full lockup draws a thin L-shaped rule from "Alexandra" down and across to "→Perles" (`scroll-03.png`). No invented symbol: a typographic character carries the meaning *from → to*.
- **Type pairing:** single sans (Mori), light weight, generous tracking.
- **Palette:** dark aubergine field ~70%, cream ~20%, lilac second "a", red arrow ~5%.
- **Image treatment:** one grainy film portrait with the rule laid over it.
- **Applications:** Instagram tiles, site card with a red vertical rule on a cream panel (`scroll-00.png`).
- **Without a symbol:** yes, entirely glyph-and-rule. Closest analogue in the whole round to Bridge's source→target trail.
- **Flags:** phone mockup on concrete (`scroll-02.png`) is a mockup.

### I2 · Haavind — Norwegian law firm (`id-haavind/`)
https://fontsinuse.com/uses/63604/haavind · Neue Design Studio, 2022 · STK Bureau Serif + Diatype

- **Mark logic:** an "H" whose crossbar is replaced by **a round dot that sits at different heights between the two stems**, and the stems change weight and angle per card (`scroll-00.png`). One letter, many positions: a dot travelling between two posts = a bridge between two sides.
- **Type pairing:** serif (STK Bureau Serif) + grotesk (Diatype). Same structure as Literata + Manrope.
- **Palette:** dark teal field, pastel blue / butter / pink cards, black mark. Live site adds cream and mustard grounds (`haavind/scroll-07.png`).
- **Image treatment:** corporate portraits and industry photos (weak).
- **Applications:** business cards, flags, report covers, website.
- **Without a symbol:** yes: the letterform is the symbol.
- **Flags:** photographed print mockups.

### I3 · Björkhem — Stockholm law firm (`id-bjoerkhem/`, live `bjorkhem/`)
https://fontsinuse.com/uses/44250/bjoerkhem · Erik Herrström, 2021 · IvyPresto + Europa

- **Mark logic:** monogram "B" built from one bar and two circles; the module repeats into a full pattern (`scroll-04.png`) and a crenellated band.
- **Type pairing:** high-contrast serif caps for claims, geometric sans for UI.
- **Palette:** white / black ~85%, green ~15% (dots, pattern).
- **Facts as type:** track record as a centred serif list where years in italic hang off alternating ends: "2020 FIDES PARTNERS / SCOTTO PARTNERS 2019 / 2016 NORDEA…" (`scroll-03.png`); a phone screen with "278" as a monument numeral.
- **Without a symbol:** yes: the dot and bar are geometric primitives.
- **Flags:** phone in hand, cable mockups.

### I4 · Transferendi — translation agency (`id-transferendi/`)
https://www.behance.net/gallery/235277857/Transferendi · Ali Iz, 2025 · Aspekta + Helvetica

- **Mark logic:** abstract pigeon/flag shape (invented symbol; weak).
- **What matters:** a **stipple field of blue dots** forming a large arc/sphere edge on near-black (`scroll-00.png`), and construction lines (circle + diagonal) crossing the mark (`scroll-02.png`). Dots as texture and tone, not as icons.
- **Palette:** ultramarine `~#2A10C8` + near-black ~80%, white type, peach/grey tints in the palette grid.
- **Image treatment:** stock smiling-woman photos with blue overlay: **flag, stock imagery**.
- **Without a symbol:** the dot field and construction lines carry it; the pigeon adds nothing.

### I5 · Surte & Co. — Mumbai law firm since 1962 (`id-surte/`)
https://www.behance.net/gallery/252650903/Surte-Co-Brand-Identity-for-a-Generational-Law-Firm · Siddhi Surte · **Tiro Devanagari Marathi + Manrope**

- **Mark logic:** serif wordmark set **twice, Latin and Devanagari, at equal weight** side by side (`scroll-02.png`); a boxed "S &Co." seal.
- **Type pairing:** Manrope is Bridge's own UI face; here it plays the sans to a script-specific serif.
- **Palette:** oxblood, cream, black, gold. Formal and warm.
- **Image treatment:** **flag: mockups and staged props** (leather emboss, wax seal, gavels, bound books). Imagery would fail with real content.
- **Transfer:** bilingual equal-weight lockups (ES/EN) as a brand device.

### I6 · InkTree Translations — visual direction (`id-inktree/`)
https://dribbble.com/shots/27801773-InkTree-Translations-Visual-direction · Jordi Garcia · Cormorant Garamond + Jost

- **Logic (from the shot text):** "started from paper: a warm cream background with a subtle texture… and no accent colour at all, so her illustrations carry every bit of colour. Even the boxes are drawn with brush strokes."
- **Flags:** illustration-dependent; a laptop-frame mockup; thin evidence (one shot). Kept only as the paper-led counterpoint.

### I7 · Royal Sites of Ireland (`royalsites/logo-crop.png`)
https://royalsites.ie/

- **Mark logic:** three-line caps wordmark in an uncial-flavoured sans with **six gold asterisks scattered to the right like a constellation/map of the sites**. Dots/glyphs as a map, not a symbol.
- **Palette:** charcoal + muted gold on cream.
- **Without a symbol:** yes.
- **Flags:** site depends on drone photography.

### I8 · GT Standard — glyph with anchor points (`gt-standard/intro-1200.png`)
https://gt-standard.com/

- **Logic:** the letter "a" shown with round **anchor nodes on its outline** and offset contour copies. The construction itself is the ornament.
- **Transfer:** draw Literata's "B" or a key glyph ("→") with trail dots at its anchor points; it is Bridge's trail living on a letter.

---

## 4. Ranked techniques

| # | Technique | Examples | Class |
| --- | --- | --- | --- |
| 1 | **Mark module as punctuation and pattern** (one primitive from the logo used inline in text, as chapter seam, as full-bleed pattern) | L3/I3 Björkhem dots and bands; I2 Haavind dot H; I1 Perles ↳ | css-only |
| 2 | **Numbered index as monument** (lists and steps at 8–10vw, italic only on connectives) | L1 Almanack; L4 GT ① ② ③; I3 track-record list | css-only |
| 3 | **Path lines between chapters** (thin route with rounded corners, drawn on scroll) | L2 Quinn; I1 Perles L-rule; I4 construction lines | css-only static; small-js or css scroll-driven to draw |
| 4 | **Chapter ground as marker** (each chapter its own ground; three to five in a page) | L4 GT; L3 Björkhem; L2 Quinn | css-only |
| 5 | **Dots as material** (stipple field, ASCII/dot scene, constellation) instead of photos | L5 Openfield; I4 Transferendi; I7 Royal Sites | css-only (radial-gradient/SVG) to small-js (scene) |
| 6 | **Staircase/overlap of a short sequence** (stepped offsets for 3–4 items) | L2 Quinn stat staircase; L7 Life Stories slabs; L1 attribution staircase | css-only |
| 7 | **List-as-type with scroll-active row + sticky detail card** | L8 AREA 17; L4 GT sticky morph | small-js |
| 8 | **Wordmark close as line-field or crop** | L6 stripe.dev line-stack; L8 A/ crop; L3 crenellated band | css-only (layered `-webkit-text-stroke`) / small-js canvas |

No pick required a library for its key move. L2 Quinn uses GSAP/SplitText, but its moves (line reveals, staggered fades, one scrub) are reproducible with IntersectionObserver or `animation-timeline: view()`.

## 5. Five largest gaps against the current Bridge captures (`before/home/sheet.png`)

1. **The trail exists in only two places** (hero gutter, *Cómo trabajamos* dotted connectors). In L3, I1 and I2 the brand primitive appears in text, seams, pattern and close.
2. **Middle chapters share one composition** (heading-left, rows-right on white/Bruma, `scroll-02`–`scroll-10`). L4 changes composition and ground every screen; L1/L8 make lists monumental.
3. **Lists are body-size.** Services, steps, *Por qué Bridge*, guides all sit at ~15px in rows. Every kept pick sets at least one list at display scale.
4. **No illustration substitute for photos.** Bridge has one booth photo and nothing in its place; L5/I4/I7 show dot-built scenes and fields.
5. **The close repeats the logo outline once and then four screens of identical footer** (`scroll-14`–`scroll-23`). L6/L3/L8 make the close a designed object.

## 6. Skill rules that changed the analysis

`wow-direction` worker prompt C made the layout/identity split and the "richness without inventing a symbol" test decisive: it removed 1-StopAsia, Transvoca, Tomo and Transferendi's pigeon, and promoted Perles/Haavind/Björkhem whose marks are letters, glyphs or primitives. No other optional skill was loaded.

## 7. Failed, blocked, not done

- Godly redirects to recent.design; no gallery access.
- SiteInspire/Land-book search for `translation` returned nothing useful; the-brandidentity search ignored queries; Minimal Gallery and Typewolf listings did not render to the scanner.
- alexandraperles.com now serves an unrelated site (domain lapsed).
- kunsthallebasel.ch capture failed once (node error); not retried.
- `motion-probe.mjs` ignores `CHROMIUM_PATH`; run from an unmodified-logic copy in the scratchpad with only the launch line patched to use it. The skill file was not edited.
- Motion not probed on L1, L3, L7, L8 (L1 static; others noted as not determinable).
- Royal Sites, Area 17, Life Stories 390 px not usable (photo or cookie banner).

---

## 8. Brand-revision ideas for Bridge (tied to picks)

1. **The trail dot becomes punctuation** (L3, I3). Put a Bridge-blue dot (amber on Tinta) before the first word and after the last word of each chapter statement in Literata; the dot is the trail's unit. No new symbol.
2. **A ↳-style hinge in the wordmark system** (I1). Build a secondary lockup "original ↳ traducción" or "ES ↳ EN" from a real glyph and a thin rule; use it as the chapter label system and on certified-translation document mock-ups.
3. **The dot travels between two posts** (I2). Animate the trail's lead dot between two vertical rules (source | target) as the page's single signature moment; at rest it sits at the target (complete at rest, reduced-motion safe).
4. **Trail pattern band as chapter seam and close** (L3, I3, L6). Generate a full-bleed band of the dotted arc (from the logo's orange-dot arc) in Bridge blue on Tinta; use it twice: between Documento and Cabina, and as the close, replacing the four-screen footer repeat.
5. **Numbered index as monument** (L1, L4). Set *Cómo trabajamos* as "01 / 02 / 03" at ~10vw Literata with the step names in Manrope beside; italic Literata only on connectives ("del original *a* la firma").
6. **Route lines instead of dotted connectors** (L2, I1). Let the trail turn corners: a thin path with rounded 90° turns crossing from one chapter to the next, drawn on scroll with `stroke-dashoffset` (CSS scroll-driven), amber only on Tinta grounds.
7. **Chapter grounds with meaning** (L4, L2). Documento chapters on white/Bruma; Cabina chapters on Tinta; one Bridge-blue full field for the moment of hand-off. Five grounds across the home instead of two.
8. **Dot-built picture instead of photos** (L5, I4, I7). One stipple scene (a booth, a stamped page, or Quito's skyline) drawn in trail dots on Tinta; or a constellation of dots marking Bridge's languages. Honest and on-brand; avoid whimsy.
9. **Staircase for short sequences** (L2, L7). Document types or the three steps as overlapping slabs in Tinta / Bridge blue / Bruma, each offset ~1 step down and right, big Literata verb per slab.
10. **List-as-type FAQ with a sticky document card** (L8). FAQ questions at ~3vw Literata in grey; the active one in Tinta; a sticky CSS "document" on the right shows the answer with a seal-like trail mark.
11. **Bilingual equal-weight lockup** (I5). Spanish and English headline pairs at equal size, separated by the trail, as the hero and close device. It states the service without a photo.
12. **Trail dots on glyph anchors** (I8). Draw the "B" of the wordmark or the arrow "→" with trail dots at its anchor points for the brand book and the 404/close.
