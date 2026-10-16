Scope: Crawl bridge-traducciones.com (bot challenge: HANDOFF_v1 trap 4) and map every indexed URL.

Acceptance criteria:
- Every indexed old URL has a 301 target; `/contacto` and `/preguntas-frecuentes` keep their paths.

References: RF-16; ARCHITECTURE §4.

External dependency: Canonical domain (ADR summary #4).

Blocked by (local IDs, see docs/backlog/key-map.md): brg-29.

Execution checklist:
- [ ] `brg-44.01` Plan or spec. Done when: Plan or spec approved by the owner.
- [ ] `brg-44.02` Execute. Done when: The work in Scope is done. Internal order: brg-44.01.
- [ ] `brg-44.03` Verify. Done when: Each acceptance criterion checked, with evidence. Internal order: brg-44.02.
- [ ] `brg-44.04` Integration and close. Done when: PR to develop with CI green (if code); handoff updated. Internal order: brg-44.03.
