Story: As an editor, I want to manage the language list, so that the checker and quote forms offer the pairs Bridge really works.

Scope: Filament resource for `Language`: name, ISO code, featured, sort, services offered. Out: the checker UI (HU-19).

Acceptance criteria:
- An editor can add, edit, reorder and unpublish a language and pick its services.
- ISO codes are unique and validated.
- The checker's JSON payload (COMPONENT-CONTRACTS LangChecker) is built from published languages only.

References: RF-03; ADR D4.1.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-35, brg-02.

Execution checklist:
- [ ] `brg-04.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-04.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-04.01.
- [ ] `brg-04.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-04.02.
- [ ] `brg-04.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-04.03.
- [ ] `brg-04.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-04.04.
