Scope: Factories for every model with invented data; a seeder for the public language list.

Acceptance criteria:
- `php artisan migrate:fresh --seed` builds a browsable dataset with no real client data.

References: ADR D2.2, 6.4.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-35, brg-36.

Execution checklist:
- [ ] `brg-37.01` Plan or spec. Done when: Plan or spec approved by the owner.
- [ ] `brg-37.02` Execute. Done when: The work in Scope is done. Internal order: brg-37.01.
- [ ] `brg-37.03` Verify. Done when: Each acceptance criterion checked, with evidence. Internal order: brg-37.02.
- [ ] `brg-37.04` Integration and close. Done when: PR to develop with CI green (if code); handoff updated. Internal order: brg-37.03.
