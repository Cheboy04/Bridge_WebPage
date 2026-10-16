Story: As an editor, I want to manage services, so that the hubs, navigation and quote forms always show what Bridge offers.

Scope: Filament resource for `Service`: title, slug, mode, summary, body, icon, image, turnaround, featured, sort, published, SEO fields, all translatable (es). Out: public pages (P4).

Acceptance criteria:
- An editor can create, edit, reorder, publish and unpublish a service.
- The mode is one of documento / cabina and is required.
- Slugs are unique per mode; a duplicate shows a validation error in Spanish.
- Unpublished services never appear in public queries.

References: RF-02, RNF-06; ADR D4.1, D3.6.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-35, brg-02.

Execution checklist:
- [ ] `brg-03.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-03.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-03.01.
- [ ] `brg-03.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-03.02.
- [ ] `brg-03.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-03.03.
- [ ] `brg-03.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-03.04.
