Story: As Bridge, I want search engines to understand every page, so that clients find us.

Scope: Per-page title and description with fallbacks, OG images, `sitemap.xml`, `robots.txt`, JSON-LD ProfessionalService and Article.

Acceptance criteria:
- Every public page has a unique title and description.
- `sitemap.xml` lists every public URL and no unpublished one.
- Staging serves `noindex`; production does not.

References: RF-16; ARCHITECTURE §4.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-10, brg-11, brg-12, brg-14.

Execution checklist:
- [ ] `brg-29.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-29.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-29.01.
- [ ] `brg-29.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-29.02.
- [ ] `brg-29.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-29.03.
- [ ] `brg-29.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-29.04.
