Scope: Settings (single row) and Lead (+ attachments) with enums per docs/nomenclatura.md.

Acceptance criteria:
- The ERD slice is approved; migrations run in CI and on staging.
- Lead type and status use the `LeadType` and `LeadStatus` enums.

References: RF-07, RF-12; ADR D4.1, D7.1.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-34.

Execution checklist:
- [ ] `brg-36.01` Plan or spec. Done when: Plan or spec approved by the owner.
- [ ] `brg-36.02` Execute. Done when: The work in Scope is done. Internal order: brg-36.01.
- [ ] `brg-36.03` Verify. Done when: Each acceptance criterion checked, with evidence. Internal order: brg-36.02.
- [ ] `brg-36.04` Integration and close. Done when: PR to develop with CI green (if code); handoff updated. Internal order: brg-36.03.
