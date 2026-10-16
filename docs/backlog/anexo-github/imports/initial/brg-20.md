Story: As an event organiser, I want to see what my event needs, so that I request a quote with the right numbers.

Scope: `<x-sig-event-planner>` per COMPONENT-CONTRACTS EventPlanner; rules from `config('planner')`.

Acceptance criteria:
- The server renders the default output (presencial, jornada, 1 language, 120 attendees) so it is complete at rest.
- The four documented cases give the shipped results (e.g. hybrid, 2 days, 2 languages, 300 attendees → 6 interpreters, 2 booths, 330 receivers, platform, 1 technician).
- The CTA links `quote.interpreting` with the query contract.
- The example-rule label stays until Bridge confirms the rules.

References: RF-11, RF-15; SIGNATURE-COMPONENTS §3.

External dependency: Planner rules to confirm (register #19–20).

Blocked by (local IDs, see docs/backlog/key-map.md): brg-01.

Execution checklist:
- [ ] `brg-20.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-20.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-20.01.
- [ ] `brg-20.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-20.02.
- [ ] `brg-20.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-20.03.
- [ ] `brg-20.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-20.04.
