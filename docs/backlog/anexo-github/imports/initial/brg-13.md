Story: As a visitor, I want to know who Bridge is, so that I trust them with my documents or event.

Scope: `/nosotros`: body from Page, ATA text, trust strip, permitted client logos.

Acceptance criteria:
- The client logo row renders only when at least one client has logo permission.
- No unsourced number appears (claims policy, DIRECTION §8).

References: RF-01, RF-05.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-01, brg-07, brg-08.

Execution checklist:
- [ ] `brg-13.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-13.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-13.01.
- [ ] `brg-13.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-13.02.
- [ ] `brg-13.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-13.03.
- [ ] `brg-13.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-13.04.
