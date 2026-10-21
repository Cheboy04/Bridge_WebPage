# Bridge Traducciones: Direction "Puente"

Status: direction spec, not tokens or brand book. Logo is a separate workstream. All contrast ratios below were computed (WCAG 2.x relative luminance), not estimated.

## 1. Brand idea and lines

**Idea.** Bridge makes two sides understand each other exactly, on paper and in the room. The brand shows this as one blue and one dotted trail that travels from a source to a target. Everything else is restraint: flat surfaces, a serif for headlines, a geometric sans for everything functional. Two surfaces, Documento (light) and Cabina (dark), let certified documents and live interpreting each feel at home without splitting the brand.

| | ES | EN |
|---|---|---|
| Positioning | Traducción certificada e interpretación simultánea, desde Quito. | Certified translation and simultaneous interpreting, from Quito. |
| Tagline | Documentos exactos. Voz en vivo. | Exact documents. Live voice. |

The positioning line is the H1/descriptor (literal, good for search). The tagline maps one phrase to each mode and makes no promise it cannot keep. It replaces audit C's "Puentes entre idiomas, con validez legal y voz en vivo", which is longer and leans on "validez legal", a claim that needs care (section 10). Retire "agencia global con sistema de gestión".

## 2. Modes

**Documento (light)** applies to: Traducción certificada, notarial/legal, apostilla and legalization pages; Cotizar and Contacto; Nosotros; FAQ, blog, legal pages; every form, on every page. **Cabina (dark)** applies to: Interpretación simultánea, equipment, congresses and events pages, and the interpreting section on Home. The footer is Tinta in both modes and belongs to neither.

**Home** gives both services equal mass: a Documento section and a Cabina section of similar height, same heading level, same CTA. Which comes first is OPEN QUESTION 3.

**Crossing.** May cross: Bridge blue, both typefaces, trail, radii, spacing, icons, CTA vocabulary, motion. May not cross: surface colors, photo grade, amber on a light surface, the certification stamp (Documento only), body text color.

**Transitions.** Section-level only, with a hard edge (no gradient, no fade, no diagonal). The trail crosses the boundary vertically and changes color exactly at it (blue above Documento, amber below in Cabina, or the reverse). Never mix modes inside a card, a form, a modal or a nav item. A modal or drawer takes the mode of the page that opened it, except the quote form, which is always Documento. The header follows the mode of the section under it only on service pages; on Home it stays Documento.

### Color roles

| Role | Documento | Cabina |
|---|---|---|
| surface | #FFFFFF | #0E2440 (Tinta) |
| surface-raised | #F4F6F9 (Bruma) | #17325A |
| text | #0E2440 | #F4F6F9 |
| text-muted | #556274 (Grafito) | #A9B8CC |
| border (decorative) | #D8E0EA | #2B4A75 |
| border-strong (controls) | #7C8A9C | #5C7BA6 |
| accent (button fill) | #1C61AD | #6BA6E8 |
| on-accent (label) | #FFFFFF | #0E2440 |
| accent-hover | #12489F (Profundo) | #8DBBF0 |
| focus ring | #1C61AD | #F4F6F9 |
| link | #12489F | #8DBBF0 |
| trail | #1C61AD | #E3A148 (Rastro) |
| success | #1B7A4B | #5FD08F |
| warning | #8A5300 | #F2B84B |
| error | #B3261E | #FF8A80 |

Cabina needs a lighter accent because Bridge blue on Tinta is only 2.50:1. Raised surfaces separate by tone step (1.22:1 in Cabina) plus border-strong where an edge matters, never by shadow. Semantic colors always travel with an icon and text, never alone.

### Verified pairs (all text pairs at least 4.5:1; UI and large at least 3:1)

| Pair | Ratio |
|---|---|
| D text on surface / raised | 15.61 / 14.42 |
| D muted on surface / raised | 6.20 / 5.73 |
| D on-accent on accent / hover | 6.25 / 8.56 |
| D link on surface / raised | 8.56 / 7.91 |
| D focus ring on surface / raised (UI) | 6.25 / 5.77 |
| D border-strong on surface / raised (UI) | 3.52 / 3.25 |
| D success / warning / error on surface | 5.34 / 6.33 / 6.54 |
| D success / warning / error on raised | 4.93 / 5.85 / 6.04 |
| C text on surface / raised | 14.42 / 11.83 |
| C muted on surface / raised | 7.74 / 6.35 |
| C on-accent on accent / hover | 6.13 / 7.81 |
| C link on surface / raised | 7.81 / 6.40 |
| C focus ring on surface (UI) | 14.42 |
| C border-strong on surface (UI) | 3.60 (only 2.95 on raised: use text-muted-weight icons, not border, to identify controls there) |
| C trail amber on surface / raised | 7.03 / 5.77 |
| C success / warning / error on surface | 8.11 / 8.72 / 6.84 |
| C success / warning / error on raised | 6.65 / 7.15 / 5.61 |

Amber on white is 2.22:1 and amber on Bridge blue is 2.81:1, so amber never appears on a light or blue surface.

**Bridge ground (R2 pages, `.mode-bridge`, approved 2026-10-21, `BRG-81`).** On Home and Traducción certificada one chapter per page may sit on Bridge blue as a whole ground. Roles: surface #1C61AD; text #FFFFFF (6.25:1); text-muted #F4F6F9 (5.77:1); accent (button fill) #FFFFFF with on-accent #1C61AD (6.25:1); focus ring and trail #FFFFFF; border #FFFFFF at 40% (decorative only). Tinta on blue is 2.50:1 and amber 2.81:1: neither is used on it. Forms never sit on blue. Border-strong on Cabina raised fails 3:1, so controls in Cabina sit on surface, not on raised.

## 3. Typography

**Literata** (variable, optical size) for display and h1 to h3: it carries the legal, documentary voice and covers Latin-ext, Cyrillic and Greek, so multilingual titles keep one voice. **Manrope** for wordmark, h4, UI, body, labels and all numerals: it is geometric, continuous with the current logo, and its tabular figures suit folios, dates and prices. Keep Literata off anything below 22px.

Scale: mobile 16px base, ratio 1.2; desktop 18px base, ratio 1.25. Display and h1 are intentionally steps above body so two or three sizes do the visible work.

| Role | Face / weight | Mobile px (rem) | Desktop px (rem) | Line-height | Tracking |
|---|---|---|---|---|---|
| monument (R1 pages only, see below) | Literata 600 | clamp(3.2rem, 11vw, 10rem) | up to 160 (10) | 0.84 | -0.055em |
| display (home hero only) | Literata 600 | 39.8 (2.49) | 54.9 (3.43) | 1.10 | -0.01em |
| h1 | Literata 600 | 33.2 (2.07) | 43.9 (2.75) | 1.15 | -0.01em |
| h2 | Literata 600 | 27.6 (1.73) | 35.2 (2.20) | 1.2 | 0 |
| h3 | Literata 500 | 23.0 (1.44) | 28.1 (1.76) | 1.25 | 0 |
| h4 | Manrope 700 | 19.2 (1.20) | 22.5 (1.41) | 1.3 | 0 |
| body | Manrope 400 | 16 (1.00) | 18 (1.125) | 1.6 | 0 |
| small | Manrope 400 | 14 (0.875) | 14 (0.875) | 1.5 | 0.01em |
| label | Manrope 600 | 14 (0.875) | 14 (0.875) | 1.3 | 0.01em |
| numerals (stats, folio) | Manrope 700, `tnum` | 33.2 | 43.9 | 1.1 | 0 |

Label and eyebrow are the same role: sentence case, never uppercase-tracked, at most one per section, only to name a mode or service ("Interpretación simultánea"). No weight above 700 in the UI (800 is the wordmark only); never 900. Minimum text is 14px.

**Monument role (BRG-68 remaster, approved 2026-10-19).** On the R1 pages (Home and Traducción certificada) one truthful service phrase per chapter may be set as an object: the Home H1 ("Del original a la firma.", `clamp(3.2rem, 11vw, 10rem)`), the Certified H1 (`clamp(3rem, 7vw, 7rem)`, line-height 0.94), the Cabina chapter heading (`clamp(3rem, 8vw, 7.5rem)`) and the shared close line "original → traducción → firma" (`clamp(3rem, 10vw, 9rem)`, on Tinta, arrows in the trail colour). Rules: the monument is always the section's real heading, never a decorative duplicate; at most one per chapter; never on body copy, controls or a language name; at 320px it drops to 2.8rem. **R2 (`BRG-81`, approved 2026-10-21):** on Home and Traducción certificada every chapter heading after the arrival is a monument (`clamp(2.6rem, 6.4vw, 6.5rem)`, line-height 0.95, still the chapter's real `h2`), and its final full stop may be a trail dot (the period stays in the text for screen readers). Exactly one crossed word per page at most: a monument crossed by a band carrying its translation, decorative and `aria-hidden`. Pages that have not passed a remaster gate keep the display/h1 rows above.

**Line length:** body 60 to 70ch (cap 68ch); h1 and display 24ch; lead paragraph 52ch.

**Long words.** Set `lang` on `<html>` and on every inline foreign phrase. Body and h3 and below: `hyphens:auto; hyphenate-limit-chars: 7 3 3; overflow-wrap:break-word`. Headings h1 to h2: `hyphens:manual`, `text-wrap:balance`, sized so "Interpretación" and "Übersetzungsbeglaubigung" fit a 288px column (soft hyphens inserted by hand in strings known to be long); never allow the unhyphenated mid-word break seen in the audit ("Interpretació/n"). **Cyrillic and Greek titles:** Literata, `:lang(ru), :lang(el) { hyphens:manual; letter-spacing:0; line-height:+0.05 }`, `font-synthesis:none`, no italics for emphasis (Cyrillic italics change letterforms), no uppercase transform (Greek loses accents). Fallback stack: Literata, Georgia, serif / Manrope, system-ui, sans-serif.

## 4. The dotted trail

Round dots on a straight or arced path, one direction: source to target.

- **Size:** dot diameter 4px (UI), 6px (section connectors, steps), 8px (hero, seal ring). Pitch is always 3 times the diameter. The target end gets one dot at 1.5 times the size.
- **Where:** (0, R1 pages) the Home arrival connector between source and target, the Certified hero sheet's horizontal run, and one horizontal run under the close line (amber, on Tinta). Each sits inside its own composition, never positioned against the page; (1) one connector per section boundary, vertical, 48 to 96px, aligned to the text left edge; (2) process steps, linking step markers, source to target; (3) language switcher, between current and target code (ES ··· EN); (4) loaders, 5 dots lighting in sequence; (5) seal ring on the certification stamp (Documento only), dot count = circumference / pitch; (6, R2 pages) **seam bands**: one row of dots inside a chapter at a ground change, drawn left to right as it enters, in that chapter's trail colour, and the **monument full stop**.
- **Color:** blue (#1C61AD) on light surfaces; amber (#E3A148) on Tinta and #17325A only; white on Bridge blue fills and on photo scrims.
- **Must not appear:** as dividers or table rules, list bullets, form field borders, underlines, inside ordinary cards (signature stages may use it), behind body text, on more than one connector per viewport, on photos without a scrim, with a second globe or map, or as a carrier of information without a text equivalent.

## 5. Shape and space

- **Spacing:** 4px base. Scale 4, 8, 12, 16, 24, 32, 48, 64, 96, 128. Gap between sections (64 mobile / 128 desktop) is at least twice the largest gap inside one.
- **Radius (revised 2026-10-15, client asked for less boxy components):** the brand is built on circles (globe, dots), so shapes lean round. `--radius-sm` 8px inputs and tags · `--radius-md` 14px cards, dialogs, photos · `--radius-lg` 24px signature stages (see `SIGNATURE-COMPONENTS.md`) · `--radius-full` buttons, chips, the WhatsApp button and segmented controls, echoing the dots. Never mix two radii on nested edges; an inner element is the outer radius minus the padding.
- **R1 de-boxing (Home and Traducción certificada, 2026-10-19):** signature stages and service rows on these pages are square-edged paper and ruled rows (radius 0, 1px rules) instead of raised `--radius-lg` panels: the arrival crossing, the before/after stage and sheets, the Certified hero sheet and the Home service lists. Controls keep their radii. Grounds rotate hard between white, Bruma and Tinta; the close is always Tinta.
- **R2 grounds and list objects (Home and Traducción certificada, 2026-10-21):** four grounds, white, Bruma, Bridge blue (at most one chapter per page) and Tinta, and no two adjacent chapters share one. A list of four or more items takes one object form, never two of the same form adjacent: **type wall** (names at monument scale with their target-language name), **index tabs** (folder tabs, ARIA tabs, every panel listed without JS), **sticky sheet** (one document held while numbered steps scroll), **active-row list** (rows at heading scale; the focused or hovered row is ink, the rest muted, never by opacity) and **plates** (full-width rows with a serif title).
- **Fewer boxes:** a repeated grid of identical bordered cards is a last resort. Prefer open lists with dividers, sticky stage layouts, full-bleed moments and asymmetric two-column compositions. Max one boxed card grid per page.
- **Border and elevation:** 1px border or a tone step, never both on the same edge. No shadow at rest. Floating layers only (menus, dialogs): `0 8px 24px rgba(14,36,64,.14)` in Documento; in Cabina no shadow, use surface-raised plus border.
- **Grid:** 12 columns, container 1200px, margins 16 / 24 / 32 (mobile / tablet / desktop), gutters 16 / 24 / 32. Photos may bleed to 1440. Prose column 68ch. Breakpoints 640, 1024, 1280.

## 6. Imagery

| | Documento | Cabina |
|---|---|---|
| Grade | saturation 88%, contrast +4%, shadows toward #0E2440 at 10% multiply | saturation 80%, brightness 92%, #0E2440 at 18% multiply |
| Mood | natural, cool, daylight | warm glass and light of real booths, held cool |
| Text on photo | scrim as below | scrim as below |

**Scrim (text on photo):** `linear-gradient(to top, rgba(14,36,64,.88) 0%, rgba(14,36,64,.78) 45%, rgba(14,36,64,0) 100%)`. Text sits only inside the lower region where alpha is at least .70. Guarantee: #F4F6F9 over a worst-case pure-white pixel at alpha .70 is 5.43:1, at .78 about 7.2:1, at .88 more than 9:1. No text over faces; never on a photo without the scrim.

**Crops:** 3:2 and 4:5 only, plus 21:9 desktop / 4:5 mobile for hero. The one-time globe crop window is hero-only, once per page (shape owned by the logo workstream).

**Banned:** AI images with invented logos or slogans (three exist in the inventory), stock handshakes, flags, hand-holds-globe, map-arc-on-navy "call center" renders, black drop shadows, emoji, stickers on photos, third-party banners left in frame (Nature's Sunshine, FGE).

**Halftone (R2 pages, approved 2026-10-21):** on Home the booth photo is shown only as a halftone of trail dots (amber on Tinta), generated from the source by `prototype/tools/halftone.py`; every dot comes from a source pixel and nothing is invented. Caption: "Fotografía provisional tratada como trama de puntos de la marca." Words that cross the image stay Bruma, never amber. When Bridge supplies its own shoot the same treatment applies and the caption drops "provisional".

**Sourcing to-do:** commission a shoot at a real Bridge booth event (booth, receivers, interpreters at work, setup); photograph real certified documents with the stamp, redacted (names, ID numbers, folios), on a desk, for Documento parity; keep `interpeting booth 2.png` as the interim Cabina hero after removing the pasted globe; confirm the licence of `Interpreting Booth Hero image.png` or drop it.

## 7. Iconography

One set: outline, 24px grid, 1.75px stroke (1.5px at 20px), round caps and joins, 2px corner radius on shapes, no fills. Sizes 16, 20, 24, 32. Color is text or text-muted, never decorative color. Use **Lucide** (ISC license; verify at lucide.dev/license and keep the notice in the repo). It is tree-shakeable and consistent; replace the svgrepo set entirely.

Needed (about 16): file-check (certified translation), stamp (notarial), scale (legal), gavel or landmark (consulates), graduation-cap (academic), briefcase (corporate), passport or id-card (personal documents), languages (language pair), headphones (interpreting), mic (events), speaker or radio (receivers), users (congress), calendar, clock (turnaround), mail, phone, message-circle (WhatsApp), map-pin (Quito). Where Lucide has no good stamp, draw one custom in the same stroke.

## 8. Voice and tone

**ES: usted.** The audience is notaries, lawyers, consulates and corporate buyers in Ecuador, where usted signals respect in written commercial and legal contexts, and the demo already uses "Únase". Tú would suit a consumer app, not a firm that signs certified documents. Buttons use the infinitive, which sidesteps the choice. **EN:** direct, plain, formal-neutral, no idiom.

| Instead of | Write |
|---|---|
| "Get in Touch" / "Get A Quote" | "Solicitar cotización" |
| "Pricing Plans / We are Hiring / App Features" | remove; footer lists real services only |
| "estándares de calidad excepcionales" | "Cada traducción la revisa un segundo traductor." (only if true) |
| "Más de 17 años" vs "16 años" | one figure from the facts sheet, or "Desde [año]" |
| "750+ clientes" | remove until documented |
| "SABER MÁS →" (11px) | "Ver servicio de interpretación" (14px minimum) |

**CTA:** primary ES "Solicitar cotización", EN "Request a quote". Secondary "Ver servicios" / "View services". One primary per viewport. **Claims:** only numbers that appear on a signed-off facts sheet with source and date; no superlatives ("mejor", "líder"), no "global", no unsourced counts.

## 9. Motion

1. Motion explains the service: the trail draws source to target, and the signature components (`SIGNATURE-COMPONENTS.md`) show a translation, a channel or a certification happening. Nothing moves only to decorate. One signature moment per page.
2. Transform and opacity only; never animate surface color across modes.
3. Parallax and concurrent motion are allowed (owner decision, 2026-10-21, `BRG-81`), built with CSS scroll-driven animations or small vanilla JS (ADR D3.7: no animation library). No wheel or scroll hijacking, no smooth-scroll override. One *signature* moment per page still names the page's main interaction.
4. Feedback is instant, transitions are brief.
5. Everything is complete and readable at rest: without JS, without scroll-timeline support and under reduced motion. A reveal never hides text from assistive technology.

Tokens: `--dur-instant 120ms`, `--dur-base 200ms`, `--dur-slow 320ms`, `--dur-trail 600ms` (trail draw, dots staggered 40ms, max 12). Easing: `--ease-out cubic-bezier(.2,0,0,1)` for entering, `--ease-in cubic-bezier(.4,0,1,1)` for leaving. **Reduced motion:** parallax and scroll-driven reveals stop at their end state, sticky stages show their final step, trails render complete and static, loaders become static dots plus the text "Cargando…", entrances are removed (content visible immediately), no autoplay video.

## 10. Trust kit

- **ATA:** state it as text first ("Traductores certificados por la American Translators Association", only with names, pairs and certification numbers verifiable in the ATA directory). Show ATA's official member badge only if ATA's current usage rules permit a corporate member to do so; verify before use. The old logo PDF carries a raster ATA badge, so do not copy it into any new asset.
- **Legal wording:** ATA certification has no legal standing in Ecuador by itself. Verify the Ecuadorian designation (for instance, perito traductor acreditado ante el Consejo de la Judicatura, notary acceptance) before writing "validez legal" anywhere.
- **Certification stamp:** Documento only; placeholder spec (blue seal-ring of trail dots around a Bridge-blue disc, folio and date in Manrope); stamp design pending, not for production use. One-color Tinta for print.
- **Years:** one figure from the facts sheet, phrased "Desde [año]" so it never goes stale.
- **Client logos:** only with written permission, grayscale, in a fixed-height row of at least 6; no empty "Organizaciones que confían" heading; for notarial and confidential clients, use sector descriptions instead.

## 11. Open questions for the client

1. **Facts:** founding year, and which numbers (clients, languages, events) can be documented. The sources conflict (16 vs 17 years, 500+ vs 750+).
2. **Credentials:** ATA status exactly (individual certified translators, corporate membership, or both) and badge permission; the Ecuadorian legal designation behind "traducción certificada" and "notariada".
3. **Home order:** which service leads the home page, Documento or Cabina, if equal weight is split top to bottom?
4. **Client logos and booth photography:** which clients allow their logos, and whether Bridge will commission a new booth and document shoot.
