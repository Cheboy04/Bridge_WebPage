Scope: Service, Language (+ services pivot), Faq, Post, Client, Testimonial, Page, User role. Translatable JSON columns.

Acceptance criteria:
- The ERD slice is approved before migrations are written.
- Migrations run on MySQL in CI and on staging; models declare `$fillable` and translatable attributes.

References: RF-02–RF-06, RNF-06; ADR D4.1, D6.2.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-34.

Execution checklist:
- [ ] `brg-35.01` Plan or spec. Done when: Plan or spec approved by the owner.
- [ ] `brg-35.02` Execute. Done when: The work in Scope is done. Internal order: brg-35.01.
- [ ] `brg-35.03` Verify. Done when: Each acceptance criterion checked, with evidence. Internal order: brg-35.02.
- [ ] `brg-35.04` Integration and close. Done when: PR to develop with CI green (if code); handoff updated. Internal order: brg-35.03.
