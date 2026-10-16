Story: As an editor, I want to record clients and testimonials, so that the site shows trust only where we have permission.

Scope: Filament resources for `Client` (name, logo, url, sector, logo_permission, sort) and `Testimonial`.

Acceptance criteria:
- An editor can manage clients and testimonials.
- `logo_permission` defaults to false and the form says a written permission is required.
- A client without permission is never returned by the public logo query.

References: RF-05; ADR D4.1; DIRECTION §10.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-35, brg-02.

Execution checklist:
- [ ] `brg-07.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-07.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-07.01.
- [ ] `brg-07.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-07.02.
- [ ] `brg-07.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-07.03.
- [ ] `brg-07.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-07.04.
