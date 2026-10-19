# R1 synthesis: from component library to a visible act of translation

**Direction lead:** 2026-10-19. Sources: baseline audit, live-reference contact sheets, shared-library query, `brand/DIRECTION.md`, accessibility and frontend-direction lenses.

## 1. Why the current prototype reads as generic

Bridge already has a good idea—the dotted trail carrying meaning from source to target—but the page treats it as a small decorative component. At 3.8vw, the largest words stay headings; document simulations stay inside rounded panels; pale horizontal bands repeat; and the final contact/footer pattern is shared by every page. The direct translation competitors show where this leads: stock hero, badges, cards and floating widgets (`inspiration/translations-in-london/sheet.png`, `inspiration/bromberg/sheet.png`). Here “generic” means the interface is correct but the service's transformation is not the composition.

## 2. Ranked principles with proof

1. **One truthful phrase becomes the scene.** Lex Politica, `inspiration/lex-politica/scroll-00.png` and `mobile-390.png`; Axinn, `inspiration/axinn/scroll-00.png`.
2. **The brand device must shape the page.** Axinn's cut repeats from arrival to close, `scroll-00.png`, `scroll-03.png`, `scroll-07.png`. Bridge uses the existing trail and source/target axis instead of inventing a new motif.
3. **A new chapter deserves a new field.** Lex Politica, `scroll-00.png`–`scroll-07.png`; Axinn, `scroll-00.png`–`scroll-07.png`; Quastels, `scroll-01.png`–`scroll-07.png`.
4. **Proof is visual material.** Axinn practices and people, `scroll-02.png`–`scroll-05.png`; Lex Politica practice/result rows, `scroll-02.png`–`scroll-06.png`.
5. **The close completes the story.** Axinn, `scroll-07.png`–`scroll-11.png`; Lex Politica, `scroll-10.png`–`scroll-11.png`.

The proposal does not import WebGL, smooth-scroll libraries, chat widgets, glow, luxury sales language or photographic claims. Those either break the approved stack/register or add no value to Bridge's job.

## 3. Lab verdict: the real constraint is enough

Bridge can build the remaster from material it already owns: verified Spanish copy, source/target language pairs, document structure, the approved logo, dotted trail, seal, colour modes and one real booth image. HTML/CSS document sheets, folio lines and translated phrases are honest representations of the service, not fabricated documents. No enhancement or synthetic material is proposed, so no disclosure language is needed in this slice.

## 4. Proposed direction changes

**Keep:** the “Puente” idea, Bridge logo, Documento/Cabina colours and contrast pairs, Literata plus Manrope, Spanish-first voice, source-to-target trail, one signature moment per page, existing content order, native controls, 44 px targets and reduced-motion completion.

| # | Area | Current rule | R1 proposal | Evidence |
| --- | --- | --- | --- | --- |
| 1 | Type | Display max 54.9 px / 3.8vw | Add one responsive monument role, roughly 10–12vw desktop and 14–16vw phone, used once per chapter; body and UI scales stay. | Lex Politica `scroll-00.png`; direct peers stay small and generic. |
| 2 | Scale | Signature component is secondary to a conventional hero | The source phrase, target phrase and signed result are the hero composition; controls remain subordinate and usable. | Axinn `scroll-00.png`; Lex Politica `mobile-390.png`. |
| 3 | Grounds | Documento alternates white and Bruma; Cabina is one dark band | Rotate white, Bruma and one Tinta proof/close field with hard edges; amber remains dark-only. | Axinn `scroll-00.png`–`scroll-07.png`; approved mode rules. |
| 4 | Layering | Text and simulation occupy separate boxes | Allow document sheets and trail to cross large type or a field edge without covering meaning; no overlap on body copy or controls. | Lex Politica hero; Axinn repeated cut. |
| 5 | Components | Rounded raised stages and repeated service cards | Keep radii for controls; de-box the signature stages and use ruled/open evidence rows. Max one conventional card grid remains unchanged. | Direct-peer warning sheets; current `before/` sheets. |
| 6 | Imagery | One booth photo; no honest document photo | Home may use the booth image once. Certified Translation is intentionally type/document-led and uses no invented photograph. | Material inventory and feasibility verdict. |
| 7 | Motion | Polite in-component motion only | Keep transform/opacity and existing durations; add one source→target arrival and one field hand-off. Reduced motion shows the signed end state immediately. | Existing motion contract; no reference library copied. |
| 8 | Close | Contact strip directly into common footer | Add a final “original → traducción → firma” composition, then the existing contact/footer content. | Axinn `scroll-07.png`–`scroll-11.png`. |

## 5. Risks

- **Register:** giant type can become fashion/editorial theatre. Limit it to verified service language and one role per chapter.
- **Accessibility:** layering can cover meaning or reorder content. DOM order remains linear; crossings are decorative and disappear safely under reduced motion/zoom.
- **Performance:** no new library, font or image is proposed. The existing booth asset remains responsive.
- **Honesty:** the seal stays provisional and document copy stays clearly demonstrative; no credential or legal-validity claim is added.
- **Scope:** shared components may visually affect unapproved pages. Implementation must scope new composition classes to the two pages until a later gate.

## 6. Decisions the owner owns

### A. Direction strength — recommendation: full composition

Approve the full change table above: monumental service language, document/type layering, three hard fields and a designed close. Tradeoff: it is the clearest departure from the current prototype and needs careful mobile composition.

Alternative: apply only larger type and spacing while retaining the current bands and boxes. It is lower risk but does not answer the evidence-backed root cause.

**Decision:** pending.

### B. Home balance — recommendation: translation leads, Cabina remains equal in the page

Let the first transformation be original → certified document, then use the existing booth image and Cabina field as the second full chapter. This matches the current default tab and gives the no-photo constraint a coherent answer. Tradeoff: interpretation is not visible in the very first visual object, though it stays in the H1 and first viewport copy.

Alternative: preserve a 50/50 split in the hero. It keeps service parity immediate but recreates the two-widget composition the audit found weak.

**Decision:** pending.

### C. Certified-page finish — recommendation: document-led, no stock image

Use type, real service copy, sheet geometry, folio and provisional seal only. Tradeoff: the page must earn warmth through typography and rhythm until Bridge supplies redacted real-document photography.

Alternative: use the existing pen-on-document stock image. It adds imagery but weakens honesty and distinctiveness.

**Decision:** pending.

## 7. Gate and next step

No prototype source changes have started. After A–C are approved or revised, the next committed artifact is the BRG-68 story/spec and story beat document. Then tests are written and proven red before the smallest two-page implementation. Every other page stays unchanged.
