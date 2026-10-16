Scope: Workflow on push to `develop`: build the release, upload over SSH, swap the symlink, migrate, optimize. Cron entry for `schedule:run`.

Acceptance criteria:
- A merge to `develop` deploys to the staging subdomain without manual steps.
- A failed migration leaves the previous release serving.
- The server never runs `git pull` or `npm`.

References: ADR D9.1, 9.6; RNF-07.

External dependency: Owner: enable SSH, report `php -v; composer -V; which php`, plan limits and cron minimum, create the staging subdomain, the deploy key and the Actions secrets.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-32.

Execution checklist:
- [ ] `brg-33.01` Plan or spec. Done when: Plan or spec approved by the owner.
- [ ] `brg-33.02` Execute. Done when: The work in Scope is done. Internal order: brg-33.01.
- [ ] `brg-33.03` Verify. Done when: Each acceptance criterion checked, with evidence. Internal order: brg-33.02.
- [ ] `brg-33.04` Integration and close. Done when: PR to develop with CI green (if code); handoff updated. Internal order: brg-33.03.
