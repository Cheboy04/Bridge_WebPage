Story: As a visitor, I want the home page to show both certified translation and interpreting clearly, so that I reach my service in one click.

Scope: Hero (HU-18), a Documento section and a Cabina section of similar height, the checker (HU-19), trust strip, process steps. Order per the placeholder register #24.

Acceptance criteria:
- The h1 contains the hook and the keyword line (DIRECTION §8).
- Both service sections have the same heading level and call to action.
- Visual parity with `prototype/src/pages/index.html` at 390 and 1440; 0 axe violations.

References: RF-01, RNF-01, RNF-09; ADR D3.8.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-01, brg-18, brg-19, brg-22.

Execution checklist:
- [ ] `brg-10.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-10.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-10.01.
- [ ] `brg-10.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-10.02.
- [ ] `brg-10.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-10.03.
- [ ] `brg-10.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-10.04.
