Story: As a visitor, I want every contact channel in one place, so that I use the one I prefer.

Scope: `/contacto` (same URL as the old site): contact block, address, hours. The quick form arrives in HU-23.

Acceptance criteria:
- The page shows WhatsApp, phone, email and the quote link in that order, from Settings.
- Unanswered Settings fields show their placeholder label, never an empty row.

References: RF-01, RF-14.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-01, brg-09.

Execution checklist:
- [ ] `brg-16.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-16.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-16.01.
- [ ] `brg-16.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-16.02.
- [ ] `brg-16.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-16.03.
- [ ] `brg-16.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-16.04.
