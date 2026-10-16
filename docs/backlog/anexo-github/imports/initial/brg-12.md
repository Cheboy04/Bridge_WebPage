Story: As an event organiser, I want a page per interpreting service, so that I see what my event needs and ask for a quote.

Scope: `/interpretacion` and `/interpretacion/{servicio}` from published Cabina services, in Cabina mode; the planner on the simultaneous page.

Acceptance criteria:
- The hub lists published Cabina services in sort order, in Cabina mode.
- A service page shows its copy, FAQs and the contact block linking `quote.interpreting`.
- Parity with `interpretacion-simultanea.html`; 0 axe violations.

References: RF-01, RF-02.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-01, brg-03, brg-05.

Execution checklist:
- [ ] `brg-12.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-12.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-12.01.
- [ ] `brg-12.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-12.02.
- [ ] `brg-12.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-12.03.
- [ ] `brg-12.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-12.04.
