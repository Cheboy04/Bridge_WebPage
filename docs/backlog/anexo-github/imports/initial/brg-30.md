Story: As Bridge, I want visit statistics without breaking privacy law, so that we measure the site legally.

Scope: Cookie consent banner; GA4 loads only after acceptance.

Acceptance criteria:
- No GA4 request is made before consent.
- Rejecting consent keeps GA4 off for the session and the choice persists.
- The banner is keyboard accessible with 0 axe violations.

References: RNF-04; ADR 8.6.

External dependency: GA4 property (owner).

Blocked by (local IDs, see docs/backlog/key-map.md): brg-01.

Execution checklist:
- [ ] `brg-30.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-30.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-30.01.
- [ ] `brg-30.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-30.02.
- [ ] `brg-30.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-30.03.
- [ ] `brg-30.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-30.04.
