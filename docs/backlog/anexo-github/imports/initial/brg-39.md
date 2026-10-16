Scope: Decide ADR 11.3 and port `prototype/check.mjs` (axe, overflow, console, screenshots) to run against the site locally and in CI.

Acceptance criteria:
- ADR 11.3 is DECIDED.
- One command checks a list of routes at 390 and 1440 and fails on any axe violation, overflow or console error.

References: RNF-01, RNF-03; ADR 11.2, 11.3.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-31.

Execution checklist:
- [ ] `brg-39.01` Plan or spec. Done when: Plan or spec approved by the owner.
- [ ] `brg-39.02` Execute. Done when: The work in Scope is done. Internal order: brg-39.01.
- [ ] `brg-39.03` Verify. Done when: Each acceptance criterion checked, with evidence. Internal order: brg-39.02.
- [ ] `brg-39.04` Integration and close. Done when: PR to develop with CI green (if code); handoff updated. Internal order: brg-39.03.
