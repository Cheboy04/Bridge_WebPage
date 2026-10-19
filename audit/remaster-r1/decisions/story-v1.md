# BRG-68 story v1: del original a la firma

**Status:** approved by the owner on 2026-10-19. **Scope:** Home and Certified Translation only. **Direction:** approved R1 synthesis A–C.

## One-line idea

Bridge makes its two services feel like one Quito team: the interface carries meaning from an original to a signed translation, then follows the same trail from an orator to a listener.

## Home beats

### 0. Arrival — the crossing begins

- **Ground:** Documento white.
- **Dominant object and layers:** the source-to-target phrase is dominant; the Bridge mark, dotted trail and demonstrative signed result form the supporting layers.
- **Job:** make translation—not a generic agency layout—the first impression.
- **Movement:** this is Home's single signature moment: one skippable transform/opacity sequence within the existing timing limits. Reduced motion and replayed visits show the completed state immediately.

### 1. Promise — from original to usable result

- **Ground:** white moving into Bruma at a hard boundary.
- **Dominant object and layers:** monumental, verified service language is dominant; current positioning copy, the primary contact action and one decorative document edge form the layers. The edge may cross display type, never body copy or controls.
- **Job:** state what Bridge does and who it helps before asking the visitor to inspect details.
- **Movement:** none beyond ordinary focus and hover feedback; no hero card.

### 2. Personal relevance — choose the crossing

- **Ground:** Bruma.
- **Dominant object and layers:** the native language-pair controls are dominant; label, guidance and result copy are the only layers.
- **Job:** let a visitor test whether the service fits their language pair without exposing false availability or certainty.
- **Movement:** only the existing result-state response; native controls, visible labels and focus, 44 px targets, existing fallback copy.

### 3. Document proof — translation becomes a deliverable

- **Ground:** Documento white.
- **Dominant object and layers:** a demonstrative document sheet is dominant; open ruled rows, folio lines, source/target fragments and the provisional seal form the layers. Translation leads the service sequence.
- **Job:** turn certified translation into visible, honest process evidence without presenting a fabricated client document.
- **Movement:** none. Preserve the current path to Certified Translation.

### 4. Handoff — from the page to the room

- **Ground:** a hard Tinta Cabina field.
- **Dominant object and layers:** monumental interpretation language is dominant; the dotted trail and the one existing booth image form the supporting layers.
- **Job:** give interpretation equal chapter weight without splitting the first composition in half.
- **Movement:** one brief section transition hands the trail to Cabina amber using transform/opacity only. It is not a second signature moment; the end state remains complete with reduced motion.

### 5. Proof and process — one accountable team

- **Ground:** Bruma returning to white.
- **Dominant object and layers:** the current verified process is dominant; differentiators, open evidence rows and the trail form the layers. No invented counts, credentials or client outcomes.
- **Job:** answer “why Bridge?” and “what happens next?” with concrete steps rather than decorative cards.
- **Movement:** none beyond disclosure/control feedback already present.

### 6. Close — original → traducción → firma

- **Ground:** Tinta.
- **Dominant object and layers:** “original → traducción → firma” is dominant; the returning mark, trail, existing contact action and footer content form the layers.
- **Job:** make the final action feel like the conclusion of the service story, not a reusable website strip.
- **Movement:** none beyond ordinary focus and hover feedback. Amber appears only on the dark field; the final CTA retains its accessible name and focus treatment.

## Certified Translation beats

### 0. Arrival — the document is the hero

- **Ground:** Documento white.
- **Dominant object and layers:** the document-led service title is dominant; sheet geometry, folio, source phrase and target phrase form the layers. No stock photograph.
- **Job:** immediately establish a document-led certified-translation service.
- **Movement:** none; the page reserves its single signature moment for the next beat.

### 1. Transformation — before, after, assurance

- **Ground:** Bruma.
- **Dominant object and layers:** the before/after document transformation is dominant; source/target text, trail and provisional seal form the layers.
- **Job:** show what changes and what Bridge preserves without simulating an official customer record.
- **Movement:** this is the page's single signature moment, using transform/opacity only. Meaningful text stays in DOM order; decorative crossings fall away at zoom or narrow widths.

### 2. Fit and proof — what can be handled

- **Ground:** Documento white.
- **Dominant object and layers:** verified fit guidance is dominant; document types, caveats and service details form open ruled layers rather than a new card system.
- **Job:** help visitors self-qualify while keeping claims precise.
- **Movement:** none beyond existing accordion/control feedback.

### 3. Process — a legible route to delivery

- **Ground:** Bruma.
- **Dominant object and layers:** the request-to-delivery sequence is dominant; numbered steps and the source-to-target trail form the layers. Forms and links stay native and keyboard operable.
- **Job:** remove ambiguity from the next step.
- **Movement:** none.

### 4. Close — translation reaches signature

- **Ground:** Tinta.
- **Dominant object and layers:** the shared “original → traducción → firma” line is dominant; the returning mark, trail and existing contact/footer content form the layers.
- **Job:** reinforce the approved system without copying the Home composition wholesale.
- **Movement:** none beyond ordinary focus and hover feedback.

## Between-page transition

The initial slice keeps ordinary document navigation. It adds no transition framework or dependency; continuity comes from the shared trail, field order and closing phrase. This avoids motion without feedback and leaves back/forward navigation entirely native.

## Live thing

The Home language-pair checker remains the only live feature. It is client-world interaction: visitors choose a source and target language and receive the existing honest guidance. The remaster changes its hierarchy and setting, not its data contract or behavior.

## Growth test

- **More services:** Home may add service destinations as open rows; only translation and interpretation receive full story chapters in this slice. A third chapter requires a later direction gate.
- **More languages:** the checker and language lists keep their existing data source and wrapping behavior; no language name is encoded into decorative geometry.
- **More document types or FAQs:** append within existing ruled groups/accordions. Long labels must wrap without changing reading order or hiding actions.
- **Longer or localized copy:** monument text is an accent, not the only heading. Content keeps a normal-flow heading and body equivalent, and decorative overlaps disable before they threaten meaning.
- **Missing media:** Home's booth image has existing alt/fallback treatment. Certified Translation requires no image, so it cannot collapse around a missing asset.

## Content and accessibility rules

- Use only verified copy and existing product truth; document fragments remain demonstrative and the seal remains provisional.
- Preserve linear semantic order, heading hierarchy, native controls, visible focus and at least 44 px interactive targets.
- Never place decorative layers above selectable text or controls; hide purely decorative marks from assistive technology.
- At 320 CSS px and at 400% zoom, meaningful content and actions must reflow without two-dimensional scrolling; decorative crossings disappear before they can obscure, clip or reorder meaning.
- Contrast follows Documento/Cabina pairs. Amber is not used as body text on white.
- Motion uses only transform/opacity and respects `prefers-reduced-motion`; essential meaning exists in the static end state.
- New composition selectors are page-scoped so the unapproved pages do not change.

## Gate

Approved by the owner on 2026-10-19. The next steps are the committed BRG-68 implementation spec, tests proven red, and then prototype source changes limited to the two-page slice.
