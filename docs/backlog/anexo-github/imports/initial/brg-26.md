Story: As Bridge, I want an email for every new lead, and the client wants a confirmation, so that nothing gets lost.

Scope: Queued mailables: one to Bridge with a link to the lead, one confirmation to the client in Spanish.

Acceptance criteria:
- Every new lead queues one email to the Settings address with a link to the lead in Filament and no attachments.
- The client receives a confirmation when they gave an email.
- Emails are queued (database queue, D9.1) and render in Spanish.

References: RF-13; ADR D7.1, D9.1.

External dependency: Mail provider OPEN (ADR summary #7).

Blocked by (local IDs, see docs/backlog/key-map.md): brg-23.

Execution checklist:
- [ ] `brg-26.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-26.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-26.01.
- [ ] `brg-26.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-26.02.
- [ ] `brg-26.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-26.03.
- [ ] `brg-26.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-26.04.
