Story: As the owner, I want Bridge's team to sign in with limited rights, so that they edit content without touching settings or users.

Scope: Filament login at `/admin`, `role` column, policies. Out: password reset by email (uses the mailer, P5).

Acceptance criteria:
- A guest requesting any `/admin` page is redirected to the login.
- An `editor` can open content and lead resources but gets 403 on Settings and Users.
- An `admin` can open every resource.
- Login attempts are rate limited.

References: RF-08, RNF-05; ADR D4.2, 4.5.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-35.

Execution checklist:
- [ ] `brg-02.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-02.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-02.01.
- [ ] `brg-02.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-02.02.
- [ ] `brg-02.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-02.03.
- [ ] `brg-02.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-02.04.
