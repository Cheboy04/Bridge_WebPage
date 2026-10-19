# BRG-68 story v1: independent gate critique

**Current recommendation:** approved. The governing Phase 2 prototype veto was reconciled after owner approval.

## Findings

### Blocker — the stated next step conflicts with the repository's active prototype veto

`story-v1.md` says approval leads to a spec, red tests and prototype source changes. `CLAUDE.md` section 5 still says `prototype/` may change only to fix drift revealed by site token tests, and BRG-68 is not listed as an exception. The owner's remaster request establishes intent, but the repository source of truth still forbids the implementation implied by this gate. Record a narrow BRG-68 exception in the governing phase/instruction document before any prototype source edit; keep it limited to Home and Certified Translation.

### Major — the one-line idea hard-codes Spanish and overstates assurance

“A source phrase becomes an assured Spanish result” is narrower than the approved source-to-target system and the story's own growth rule that language names must not be encoded into the composition. “Assured” also reads as an unverified quality or legal promise while Bridge's exact certification standing remains an open business fact in `brand/DIRECTION.md`. Recast the line around a source phrase becoming a target-language document/result, without adding a guarantee. Keep “firma” demonstrative and the seal visibly provisional.

### Major — Home's single signature moment is not identified clearly enough

The approved rules allow one signature moment per page, while Home currently names both an animated source-to-signed arrival and a moving Documento-to-Cabina field handoff. The synthesis supports both motions, but the story must declare which is the signature moment and which is only a brief section transition. Otherwise implementation can easily produce two competing set pieces and violate the evidence-led restraint. Certified Translation already identifies its before/after transformation correctly as the single signature moment.

### Moderate — beat descriptions do not consistently satisfy the story contract

The wow-direction story stage asks every beat to name ground, dominant object, layers and movement. Several beats provide a scene and job but leave one or more of those properties implicit, especially Home beats 2, 3, 5 and 6 and Certified Translation beats 2–4. Add compact explicit fields or one complete sentence per beat. For static beats, state “movement: none”; that is a valid design decision and prevents decorative motion from being invented during build.

### Moderate — responsive accessibility needs a testable edge condition

The story has the right semantic, focus, target-size, reduced-motion and decorative-layer rules. Add one concrete reflow condition for the monument/layering treatment: meaningful content and actions must remain available without two-dimensional scrolling at 320 CSS px / 400% zoom, with decorative crossings removed before they obscure or reorder content. The existing 390 px check alone does not exercise this risk.

## What already passes

- Approved A–C are faithfully represented: full composition, translation first with an equal Cabina chapter, and a document-led Certified Translation page without stock photography.
- The progression is coherent: visible translation act → relevance → document proof → interpretation handoff → accountable process → designed close.
- The live language-pair checker is retained without expanding its behavior or data contract.
- Growth rules cover more services, languages, document types, FAQs, localization and missing media without hard-coded visual exceptions.
- Honesty constraints reject invented documents, counts, credentials and outcomes; the provisional seal is retained.
- Scope is explicit and safe: page-scoped selectors, no transition framework or dependency, and no implied redesign of the remaining pages.

## Gate condition

Approve after the blocker and two major findings are reflected in the story/governing project rules. The moderate items can be resolved in the same story revision; they should be carried into the implementation spec as testable acceptance criteria.

## Resolution review — 2026-10-19

- **Resolved:** the one-line idea no longer hard-codes Spanish or uses “assured”; it now joins translation and interpretation as one Quito-team story without a new legal or quality guarantee.
- **Resolved:** Home explicitly identifies the arrival as its single signature moment and the Cabina handoff as a secondary section transition. Certified Translation retains one before/after signature moment.
- **Resolved:** every beat now names its ground, dominant object/layers and movement, including deliberate static beats.
- **Resolved:** the accessibility rules now require reflow at 320 CSS px and 400% zoom, with decorative crossings removed before they obscure, clip or reorder meaning.
- **Resolved after owner approval:** `CLAUDE.md` section 5 and the Phase 2 record now carry a narrow BRG-68 exception for Home and Certified Translation only.

**Current gate:** passed. Approved A–C fidelity, honesty, growth behavior, accessibility intent and the two-page boundary all pass this re-review.
