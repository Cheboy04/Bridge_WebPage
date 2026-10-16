Story: As a visitor, I want all common questions on one page, so that I find answers fast.

Scope: `/preguntas-frecuentes` (same URL as the old site) with global FAQs.

Acceptance criteria:
- The page lists global FAQs in sort order as accordions.
- The page emits FAQPage JSON-LD from the same records.

References: RF-01, RF-06, RF-16.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-01, brg-05.

Execution checklist:
- [ ] `brg-15.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-15.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-15.01.
- [ ] `brg-15.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-15.02.
- [ ] `brg-15.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-15.03.
- [ ] `brg-15.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-15.04.
