Scope: Review rate limits, security headers, debug flags, upload validation and admin policies.

Acceptance criteria:
- Findings with file:line are fixed or justified; `APP_DEBUG=false` on staging.

References: RNF-05; ADR D3.1, D8.4.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-27.

Execution checklist:
- [ ] `brg-42.01` Plan or spec. Done when: Plan or spec approved by the owner.
- [ ] `brg-42.02` Execute. Done when: The work in Scope is done. Internal order: brg-42.01.
- [ ] `brg-42.03` Verify. Done when: Each acceptance criterion checked, with evidence. Internal order: brg-42.02.
- [ ] `brg-42.04` Integration and close. Done when: PR to develop with CI green (if code); handoff updated. Internal order: brg-42.03.
