Scope: Weekly `mysqldump` and private-upload copy off-server; decide and document the database rollback (ADR 9.4).

Acceptance criteria:
- ADR 9.4 is DECIDED and a runbook (`docs/global/runbook-rollback.md`) is tested once on staging.

References: ADR 6.5, 9.4.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-33.

Execution checklist:
- [ ] `brg-46.01` Plan or spec. Done when: Plan or spec approved by the owner.
- [ ] `brg-46.02` Execute. Done when: The work in Scope is done. Internal order: brg-46.01.
- [ ] `brg-46.03` Verify. Done when: Each acceptance criterion checked, with evidence. Internal order: brg-46.02.
- [ ] `brg-46.04` Integration and close. Done when: PR to develop with CI green (if code); handoff updated. Internal order: brg-46.03.
