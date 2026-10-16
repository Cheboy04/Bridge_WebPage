Story: As a visitor, I want every page in the Bridge layout, so that I always know whose site I'm on and how to reach them.

Scope: `<x-header>`, `<x-footer>`, `<x-whatsapp>` and the base layout with `mode-documento` / `mode-cabina`. Contact data from Settings. Out: page content.

Acceptance criteria:
- Every public page renders the header, footer and WhatsApp button per COMPONENT-CONTRACTS (Header, Footer, WhatsApp), with phone, email and WhatsApp number read from Settings.
- The WhatsApp button is absent on `quote.*` routes and its link pre-fills the page's message.
- The footer descriptor cycles through the seven names with the timings and pause rules of SIGNATURE-COMPONENTS §6; with reduced motion it shows the static list.
- The mobile menu traps focus, closes with Esc and returns focus to the toggle; 0 axe violations and no overflow at 390 and 1440.

References: RF-14, RF-15, RNF-01, RNF-03, RNF-08, RNF-09; ADR D3.6, D3.7, D3.8; brand/COMPONENT-CONTRACTS.md.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-36, brg-39.

Execution checklist:
- [ ] `brg-01.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-01.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-01.01.
- [ ] `brg-01.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-01.02.
- [ ] `brg-01.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-01.03.
- [ ] `brg-01.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-01.04.
