Story: As an editor, I want to manage questions and answers, so that clients find answers without writing to us.

Scope: Filament resource for `Faq`: question, answer, optional service, sort.

Acceptance criteria:
- An editor can create, edit, reorder and delete FAQs.
- An FAQ without a service is global; with one it belongs to that service's page.

References: RF-06; ADR D4.1.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-35, brg-02.

Execution checklist:
- [ ] `brg-05.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-05.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-05.01.
- [ ] `brg-05.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-05.02.
- [ ] `brg-05.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-05.03.
- [ ] `brg-05.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-05.04.
