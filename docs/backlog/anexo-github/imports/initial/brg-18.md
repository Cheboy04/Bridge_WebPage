Story: As a visitor, I want to see the service happen, so that I understand what Bridge does in seconds.

Scope: `<x-sig-hero>` per COMPONENT-CONTRACTS HeroStage and SIGNATURE-COMPONENTS §1 (timings in 'Shipped behaviour').

Acceptance criteria:
- Without JS both panels show in their final state.
- Tabs follow the ARIA tabs pattern; the chosen tab persists in sessionStorage.
- Channel buttons set `aria-pressed` and the live region announces only user changes.
- Animations match the shipped timings; reduced motion shows the final state.

References: RF-15, RNF-08.

External dependency: Hero translations need translator sign-off (register #23).

Blocked by (local IDs, see docs/backlog/key-map.md): brg-01, brg-09.

Execution checklist:
- [ ] `brg-18.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-18.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-18.01.
- [ ] `brg-18.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-18.02.
- [ ] `brg-18.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-18.03.
- [ ] `brg-18.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-18.04.
