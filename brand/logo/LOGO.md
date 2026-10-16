# Bridge Traducciones: logo

Main logo: M1 "Refresh fiel". App icon and favicon: M5 "Monograma". All text in every SVG is converted to outlines (Manrope, SIL OFL). Live reference: `logo-sheet.html`.

## 1. Construction

Unit `u` = 1/112 of the disc diameter. All coordinates sit on a 0.5 u grid (B, disc, meridians on whole units).

| Element | Spec |
|---|---|
| Disc | circle, diameter 112 u, centre (56,56) |
| Meridians | ellipses rx 24 and 46, ry 55, plus one parallel `M3 44 Q56 34 109 44`; stroke 1.7 u, white 30% (mono: 1.4 u true knockout) |
| B | custom drawn, 44 x 60 u, stem 12 u, at x 56, y 26 (vertically centred in the disc); counters 17.5 x 11 and 20.5 x 16 u; white (mono: knockout) |
| Trail | 5 round dots, radii 3, 3.5, 4, 4.5, 5 u, centres on the quadratic (14,84) (26,64) (46,57) at (14,84) (19.75,75.75) (27.25,68) (36,61.5) (46,57), gaps 3.6 / 3.3 / 2.4 / 1.5 u (tightening toward the B); first dot 2.5 u inside the disc edge, last dot 5 u from the B. White in every colour version. **Strengthened 2026-10-16** (P0 polish): each radius +0.5 u, matching the app icon trail; was 2.5–4.5 u |
| "ridge" | Manrope 800, 83.33 u (cap height = B height = 60 u), baseline y 86, tracking -1.2 u, hand-fit: "r" stem at x 116.8 (4.8 u clear of the disc, 16.8 u from the B), "ri" kern 0 |
| Descriptor | Manrope 700, 13 u (cap 9.4 u), tracking 0.16 em, caps, baseline y 122, ink-left on the "r" stem. Slot = width of ÜBERSETZUNGEN (135 u); the other six words are shorter, same size and tracking |
| Lockup | viewBox 317 x 126 for all 7 languages (112 for the wordmark), tight to the artwork, no built-in padding |

Descriptors: ES TRADUCCIONES, EN TRANSLATIONS, FR TRADUCTIONS, PT TRADUÇÕES, DE ÜBERSETZUNGEN, RU ПЕРЕВОДЫ, EL ΜΕΤΑΦΡΑΣΕΙΣ (Greek caps carry no accents).

App icon grid (120 u tile, rx 28): B at (62,28), 5-dot trail radii 3 to 5 u on (18,90) (32,66) (52,58). Maskable: same artwork scaled 0.85 about the centre inside a full-bleed square, so everything falls within the 80% safe circle (radius 48 u). Favicon: separate 32 u drawing, rx 7, B scale 0.28, 3 dots (r 1.4, 1.9, 2.4).

## 2. Clear space

Clear space = **½ disc radius = 28 u** on every side of the lockup, wordmark or symbol, measured from the outermost ink (disc edge, descender, descriptor). In practice: one quarter of the disc diameter. App icons need no clear space of their own; keep 1 tile-corner radius from other elements.

## 3. Minimum sizes

| Asset | Screen | Print |
|---|---|---|
| Lockup with descriptor | 180 px wide (descriptor cap about 5.3 px) | 45 mm |
| Wordmark (no descriptor) | 96 px wide | 25 mm |
| Symbol (M1 globe) | 24 px | 8 mm |
| App icon | 48 px (use `favicon.svg` at 16 and 32 px) | n/a |

Below these, switch asset: lockup to wordmark, wordmark to symbol, symbol to the monogram favicon. At 16 px always use the favicon drawing.

## 4. Colour and contrast (WCAG 2.x, computed)

| Use | Colour | Ratio |
|---|---|---|
| Disc, light | #1C61AD | 6.25:1 on #FFFFFF, 5.77:1 on Bruma #F4F6F9 |
| B and trail on light disc | #FFFFFF | 6.25:1 on disc |
| Wordmark, light / mono ink | #0E2440 Tinta | 15.61:1 on white, 14.42:1 on Bruma |
| Descriptor, light | #556274 Grafito | 6.20:1 on white, 5.73:1 on Bruma |
| Disc, dark | **#2B76C6** | **3.35:1 on Tinta #0E2440** (non-text, needs 3:1) |
| B and trail on dark disc | #FFFFFF | 4.66:1 on disc |
| Wordmark, dark | #FFFFFF | 15.61:1 on Tinta |
| Descriptor, dark | #A9B8CC | 7.74:1 on Tinta |
| App icon tile | #1C61AD, white B and trail | 6.25:1 |

The Bridge-blue disc #1C61AD is only 2.50:1 on Tinta, hence the lighter dark disc. **Amber (#E3A148) is not used inside the logo in any version**: on the light disc it is 2.81:1 and on the dark disc 2.10:1 (it would be lower still on any disc that clears 3:1 against Tinta, so both constraints cannot hold). Amber remains the page trail colour on Tinta only. Mono ink: #0E2440 one colour. Mono white: #FFFFFF one colour; B, trail and meridians are knocked out so the surface shows through.

## 5. Which file where

| File | Use |
|---|---|
| `lockup/bridge-lockup-{lang}-light.svg` | default on white, Bruma and light photos (Documento) |
| `lockup/bridge-lockup-{lang}-dark.svg` | on Tinta and #17325A (Cabina), site footer |
| `lockup/bridge-lockup-{lang}-mono-ink.svg` | one-colour print, stamps, fax, embossing, light surfaces |
| `lockup/bridge-lockup-{lang}-mono-white.svg` | one-colour on dark or blue surfaces, photo scrims |
| `lockup/bridge-wordmark-*.svg` | when width is under 180 px, or the descriptor is redundant (header, signature) |
| `symbol/bridge-symbol*.svg` | avatars, compact spots 24 px and up, merch, watermark |
| `app/bridge-app-icon.svg` | social avatar, store listing, any rounded square use |
| `app/bridge-app-icon-square.svg`, `apple-touch-icon.png` (180) | iOS (the OS rounds it) |
| `app/bridge-app-icon-maskable.svg`, `icon-maskable-{192,512}.png` | PWA `purpose: maskable` |
| `app/icon-{192,512}.png` | PWA `purpose: any` |
| `app/favicon.svg`, `favicon.ico` (16, 32, 48) | browser tab |

Suggested head: `<link rel="icon" href="/favicon.ico" sizes="48x48"><link rel="icon" href="/favicon.svg" type="image/svg+xml"><link rel="apple-touch-icon" href="/apple-touch-icon.png">`.

Descriptor language follows the page language (ES default). Mono SVGs use an SVG `mask` for the meridian knockout; for professional print, have the vendor convert to PDF/EPS from the SVG.

## 6. Misuse

1. Do not stretch, squash or re-proportion; scale uniformly only.
2. Do not recolour: no amber, no gradient, no other blue. Use the four supplied variants.
3. Do not place on mid-tone or busy backgrounds; use the variant with verified contrast, or a scrim.
4. No shadows, glows, bevels, outlines or filters.
5. Do not rotate, skew, crop the disc, or rearrange the parts (B, trail, wordmark, descriptor).
6. Do not retype the wordmark or descriptor in any font, change tracking or kerning, or move the descriptor. Always use the supplied artwork.

## Decorative watermark (footer only)

Added 2026-10-15 with the signature components. The full lockup drawn as a 1px outline in a light tint on Tinta, at container width, with the trail dots filled amber. Decorative only: it never replaces the identifying logo, which still appears in the header. Use once per page, only in the site footer and only on Tinta. Do not use it in print, at small sizes, or on light surfaces.
