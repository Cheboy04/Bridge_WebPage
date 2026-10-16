Story: As a legal or corporate client, I want a page per translation service, so that I understand it and request a quote.

Scope: `/traduccion` and `/traduccion/{servicio}` from published Documento services; FAQs, contact block, before/after on the certified page.

Acceptance criteria:
- The hub lists published Documento services in sort order.
- A service page shows its copy, turnaround, FAQs and the contact block linking `quote.translation`.
- An unknown or unpublished slug returns the 404 page.
- Parity with `traduccion-certificada.html`; 0 axe violations.

References: RF-01, RF-02; ADR D3.6.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-01, brg-03, brg-05.

Execution checklist:
- [ ] `brg-11.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-11.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-11.01.
- [ ] `brg-11.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-11.02.
- [ ] `brg-11.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-11.03.
- [ ] `brg-11.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-11.04.
