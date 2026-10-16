Story: As an editor, I want to edit simple pages, so that the privacy text and the about body change without a developer.

Scope: Filament resource for `Page`: title, slug, body, SEO fields.

Acceptance criteria:
- An editor can edit a page's title, body and SEO fields.
- The `privacidad` page cannot be deleted.

References: RF-01, RF-07; ADR D4.1.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-35, brg-02.

Execution checklist:
- [ ] `brg-08.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-08.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-08.01.
- [ ] `brg-08.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-08.02.
- [ ] `brg-08.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-08.03.
- [ ] `brg-08.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-08.04.
