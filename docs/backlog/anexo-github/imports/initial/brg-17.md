Story: As a visitor, I want to read how my data is treated, so that I can trust the forms.

Scope: `/privacidad` from Page, with the retention period from config.

Acceptance criteria:
- The page renders the `privacidad` Page body.
- The retention period shown equals `config('leads.attachments.retention_days')`.

References: RF-01, RNF-04; ADR D8.5.

External dependency: Legal text from Bridge (placeholder register #13).

Blocked by (local IDs, see docs/backlog/key-map.md): brg-01, brg-08.

Execution checklist:
- [ ] `brg-17.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-17.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-17.01.
- [ ] `brg-17.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-17.02.
- [ ] `brg-17.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-17.03.
- [ ] `brg-17.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-17.04.
