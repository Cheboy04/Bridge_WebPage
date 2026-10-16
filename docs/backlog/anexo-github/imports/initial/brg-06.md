Story: As an editor, I want to publish articles, so that Bridge shares expertise and ranks in search.

Scope: Filament resource for `Post`: title, slug, excerpt, body (rich text), cover, published_at, SEO fields. Out: categories (D3.9).

Acceptance criteria:
- An editor can draft, schedule (published_at in the future) and publish a post.
- A post with a future published_at is not public until that time.
- Rich text is sanitised on save.

References: RF-04; ADR D4.1.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-35, brg-02.

Execution checklist:
- [ ] `brg-06.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-06.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-06.01.
- [ ] `brg-06.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-06.02.
- [ ] `brg-06.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-06.03.
- [ ] `brg-06.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-06.04.
