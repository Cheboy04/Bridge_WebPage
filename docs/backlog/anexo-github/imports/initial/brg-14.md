Story: As a visitor, I want to read Bridge's articles, so that I learn about certified translation and interpreting.

Scope: `/blog` (pagination per ADR 3.4) and `/blog/{slug}`.

Acceptance criteria:
- The list shows published posts, newest first.
- A post page shows title, date, cover and body.
- Future or unpublished posts return 404.

References: RF-01, RF-04.

External dependency: ADR 3.4 pagination OPEN (decide at spec time).

Blocked by (local IDs, see docs/backlog/key-map.md): brg-01, brg-06.

Execution checklist:
- [ ] `brg-14.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-14.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-14.01.
- [ ] `brg-14.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-14.02.
- [ ] `brg-14.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-14.03.
- [ ] `brg-14.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-14.04.
