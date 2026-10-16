Story: As the owner, I want contact data, claims and hero copy in one settings screen, so that placeholders are swapped without a deploy.

Scope: One `Settings` row: phones, emails, WhatsApp number and message, address, map link, socials, founding year, verified stats, ATA text, hero copy. Admin only.

Acceptance criteria:
- Only `admin` can open and save Settings.
- Phone and WhatsApp numbers are validated in international format.
- A saved change appears on the public site on the next request (cache cleared).

References: RF-07, RNF-05; ADR D4.1, D4.2; docs/placeholder-register.md.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-36, brg-02.

Execution checklist:
- [ ] `brg-09.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-09.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-09.01.
- [ ] `brg-09.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-09.02.
- [ ] `brg-09.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-09.03.
- [ ] `brg-09.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-09.04.
