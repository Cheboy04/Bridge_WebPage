Scope: Deploy from `main`, point DNS, smoke-test every route and form.

Acceptance criteria:
- Production serves the canonical domain over HTTPS; the other domain 301s to it.
- A test lead reaches the inbox and both emails arrive.

References: RNF-07; ADR D9.1.

External dependency: Owner: DNS, production database, cron, secrets.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-44, brg-46.

Execution checklist:
- [ ] `brg-45.01` Plan or spec. Done when: Plan or spec approved by the owner.
- [ ] `brg-45.02` Execute. Done when: The work in Scope is done. Internal order: brg-45.01.
- [ ] `brg-45.03` Verify. Done when: Each acceptance criterion checked, with evidence. Internal order: brg-45.02.
- [ ] `brg-45.04` Integration and close. Done when: PR to develop with CI green (if code); handoff updated. Internal order: brg-45.03.
