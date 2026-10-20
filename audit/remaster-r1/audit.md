# BRG-68 current-prototype baseline audit

**Pages:** home and certified translation

**Viewports:** 1440×900 and 390×844

**Evidence:** `before/home/` and `before/certified-translation/`

## Diagnosis by eye

The prototype is competent and usable, but its visual language stops at a polished component system. The largest type is 54.88 px, only 3.8vw at desktop, so the words never become a compositional object. Text, the document simulation and the single booth photograph occupy separate boxes instead of sharing depth. Most chapters alternate white and pale grey horizontal bands with the same container, heading-above-grid rhythm; even the dark Cabina passage stays a conventional list beside a picture. Image arrangements do not vary because Documento has no honest production photography and Home uses the one booth image once. Arrival is a normal header plus two-column hero, transitions are hard colour edges without a designed hand-off, and both pages close through the same contact strip and oversized footer. The result is clear and accessible, but it does not make Bridge's invisible act—meaning crossing accurately from source to destination—feel memorable.

## What is already strong and must survive

- The first viewport explains both services and keeps certified translation legible as the default.
- Documento/Cabina modes, the source-to-target dotted trail and the one-signature-moment rule are coherent with Bridge's service.
- Copy is specific, in Spanish, and avoids unsupported claims; placeholders remain visible.
- Semantic controls, focus treatment and touch sizes survive the automated baseline: 0 axe violations, no overflow and no console errors at both target viewports.
- The 390 px layouts preserve reading order and keep primary actions visible.

## Page observations

| Page | Evidence | Observation |
| --- | --- | --- |
| Home, arrival | `before/home/intro-2500.png`, `full-1440.png` | The 7/5 hero grid reads as text plus widget. The signature stage is useful, but its rounded raised panel makes the product demonstration secondary. |
| Home, chapters | `before/home/scroll-01.png`–`scroll-09.png` | Every section returns to a horizontal band and regular grid. The Cabina switch is the only strong field change, but it has no visual hand-off from Documento. |
| Home, close | `before/home/scroll-10.png`–`scroll-15.png` | Contact and footer are complete but generic; repeated footer frames show no designed final beat beyond scale of the outline wordmark. |
| Home, mobile | `before/home/full-390.png` | Clear and usable, but the hero consumes a long vertical run before the live stage begins. Type remains page heading rather than scene. |
| Certified, arrival | `before/certified-translation/intro-2500.png`, `full-1440.png` | H1 and summary are a familiar service-page split. Nothing visually demonstrates certification until the next chapter. |
| Certified, body | `before/certified-translation/scroll-01.png`–`scroll-10.png` | Good information architecture, but repeated lists, rules and pale panels flatten the hierarchy; the before/after signature sits inside the same card vocabulary. |
| Certified, mobile | `before/certified-translation/full-390.png` | The title and actions fit cleanly. The fixed WhatsApp action competes with summary content near the fold but does not obscure the primary CTA. |

## Baseline gate

| Check | Home | Certified translation |
| --- | --- | --- |
| Axe at 1440 / 390 | 0 / 0 violations | 0 / 0 violations |
| Horizontal overflow | none / none | none / none |
| Console errors | 0 / 0 | 0 / 0 |
| Reduced-motion context | captured | captured |

This is a visual-remaster problem, not a broken usability baseline. The remaster must retain these green checks and earn distinction through hierarchy, layering, field changes and a designed close.
