Scope: One workflow on pull requests to `develop` and `main`: install from lockfiles, Pint, Larastan, Pest against a MySQL service, Vite build.

Acceptance criteria:
- A PR runs the chain in the order of CLAUDE.md §7.2 and fails on any step.
- Tests run against MySQL, not SQLite.
- `develop` and `main` require the check (owner sets the ruleset).

References: ADR D9.1, 11.1; CLAUDE.md §7.2.

External dependency: Branch rulesets (owner).

Blocked by (local IDs, see docs/backlog/key-map.md): brg-31.

Execution checklist:
- [ ] `brg-32.01` Plan or spec. Done when: Plan or spec approved by the owner.
- [ ] `brg-32.02` Execute. Done when: The work in Scope is done. Internal order: brg-32.01.
- [ ] `brg-32.03` Verify. Done when: Each acceptance criterion checked, with evidence. Internal order: brg-32.02.
- [ ] `brg-32.04` Integration and close. Done when: PR to develop with CI green (if code); handoff updated. Internal order: brg-32.03.
