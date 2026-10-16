Story: As a visitor, I want the dotted trail to guide me through each page, so that the brand's idea reads without words.

Scope: `<x-trail>` and `<x-process-steps>` per COMPONENT-CONTRACTS LivingTrail; CSS only.

Acceptance criteria:
- Connectors and process steps animate only inside `@supports (animation-timeline: view())` with motion allowed, using the shipped ranges.
- At rest the trail is fully drawn with solid markers.
- The trail colour follows the mode (blue on light, amber on Tinta).

References: RF-15, RNF-08; SIGNATURE-COMPONENTS §5.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-01.

Execution checklist:
- [ ] `brg-22.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-22.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-22.01.
- [ ] `brg-22.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-22.02.
- [ ] `brg-22.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-22.03.
- [ ] `brg-22.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-22.04.
