# Audit C: Positioning, palette, type, naming

Method: ui-ux-pro-max `--domain color` / `--domain typography` (queries run: professional services legal, B2B corporate trust, conference events, translation localization [0 hits], professional corporate, elegant legal, modern multilingual), filtered with gpt-taste (no Inter, no generic gradients, restraint). WebSearch returned only vendor-comparison pages (Smartling, Lilt, RWS, Translated); nothing on branding or LatAm firms. Competitor notes below are from general knowledge, not verified in this run. Font script coverage is from memory of Google Fonts specimens: verify on fonts.google.com before locking.

## 1) Category codes
- Competitors (RWS, Lilt, Smartling, Translated, TransPerfect; LatAm agencies): SaaS-blue or navy, globe or world-map arcs, speech-bubble or "A/文" glyphs, flag rows, language-count stats ("119 languages"), stock headset or handshake photos. Local agencies are weaker: clip-art flags, flyers with mixed fonts, stock hand-holding-globe (exactly Bridge's current flyers).
- Cliché (avoid): flag grids, bubbles, handshake, hand-holds-globe, map-arc-on-navy hero, AI renders with invented logos (the inventory shows three such files; none should ship).
- Generic vs differentiating: blue and a globe are generic. Differentiating: a real bridge idea, 16+ years of continuity, certified/notarial rigor, live booths.
- Owning the globe: use it ONCE as the mark, never as decoration. Turn the dotted trail into a system device: a dotted line that connects sections, language switcher states, and process steps (source -> target). Crop the globe large and partial as a brand "window" for photography. No second globe, no map backdrops. Keep B-in-globe and the blue; drop the radial black-gradient lettering for flat ink.

## 2) Positioning candidates
1. ES: "Puentes entre idiomas, con validez legal y voz en vivo." / EN: "Bridges between languages, legally valid and live." (dual audience in one line)
2. ES: "Traducción certificada e interpretación simultánea, desde Quito hacia el mundo." / EN: "Certified translation and simultaneous interpreting, from Quito to the world." (proof of place, plain)
3. ES: "Lo que se dice, dicho con exactitud. Donde importa." / EN: "Said exactly. Where it matters." (precision angle; strongest tone, riskiest for SEO, so pair with a literal subline)
Recommend 2 as H1/descriptor, 1 as tagline. Replace the demo's "agencia global con sistema de gestión", which is not credible for a 16-year Quito firm.

## 3) Palette candidates (all keep #1C61AD as hero blue)
Source refs: ui-ux-pro-max colors.csv rows Legal Services (#1E3A8A, gold #B45309), B2B Service (#0F172A, #0369A1), Conference/Symposium (#1E3A5F, #A16207), Government/Civic (#EFF6FF bg).

**A. Notary Navy + Ochre (legal-forward, warm)**
#1C61AD brand; #0F2A4A ink/dark surface; #12489F hover/links; #B45309 seal accent (Legal Services row; use sparingly: stamps, one CTA); #F7F6F2 warm paper bg; #DCE3EC border; #808285 muted text.

**B. Clean Cobalt (corporate/events-forward, cooler)**
#1C61AD brand; #0B1F3A deep surface (near Conference row #1E3A5F, darker); #0060B6 bright accent for interactive; #00608D teal secondary (from logo stroke); #F8FAFC bg (B2B row); #E2E8F0 border; #475569 body muted.

**C. Duotone Signal (most distinctive)**
#12489F primary; #1C61AD globe; #EAF1FA tint surface; #0A1A2F ink; #E8A33D dotted-trail highlight (the trail becomes the only warm element); #808285 grey; #FFFFFF.
Check contrast: #1C61AD on white is ~6:1 (passes AA body); #B45309 and #E8A33D on white fail for small text, use on dark or as fills with dark text only.
Taste call: A for the site (paper warmth separates it from SaaS blue), C's trail highlight can be added to A.

## 4) Font pairs (free, Google Fonts)
1. **Fraunces (headings, optical-size variable) + Manrope (body/UI).** Manrope: Latin, Latin-ext, Cyrillic, Greek. Fraunces: Latin, Latin-ext only; Cyrillic/Greek titles fall back to Manrope bold (acceptable, set explicit fallback). Personality: warm-serif authority plus modern sans.
2. **Source Serif 4 + Source Sans 3.** Both: Latin, Latin-ext, Cyrillic, Greek, Vietnamese. Safest full multilingual coverage; sober and legal-friendly (db has Source Sans 3 under "Corporate Trust"). Least distinctive.
3. **Plus Jakarta Sans (headings) + IBM Plex Sans (body).** Plex (db "Financial Trust"): Latin, Latin-ext, Cyrillic, Greek. Jakarta: Latin, Latin-ext, Cyrillic-ext, no Greek. Fully sans, closest to the current geometric Century Gothic wordmark feel.
Taste filter dropped: Inter, Playfair+Inter (db "Classic Elegant", luxury mood), Poppins+Open Sans (generic SaaS), Lexend (no Cyrillic), Lato (Latin only). Recommend pair 1 if Greek/Cyrillic titles are rare, else pair 2.

## 5) Naming and lockup
System: fixed "Bridge" + localized descriptor in a fixed second line/slot.
- ES: Bridge Traducciones | EN: Bridge Translations | FR: Bridge Traductions | PT: Bridge Traduções | DE: Bridge Übersetzungen
- Mark + "Bridge" are never translated or re-typeset; the descriptor is set in the body sans, caps, tracked, in #808285/#1C61AD, in one master lockup (descriptor under, left-aligned to the B). Original file already has "TRANSLATIONS" and "Your Language Partners", so this extends existing structure.
- Primary lockup: ES (Quito is the base; legal name stays "Bridge Traducciones"). Ship all five as separate SVGs from one template; test descriptor width for "Übersetzungen" (longest, with umlaut) so the slot is sized for it. Tagline slot is optional and localized the same way.
- Domain/legal name unchanged; language switcher swaps only descriptor and tagline.
