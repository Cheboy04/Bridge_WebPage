Story: As an event organiser, I want to request an interpreting quote, so that Bridge plans my event.

Scope: Livewire form on `/cotizacion/interpretacion`: service, dates, city/venue, attendees, language pairs, booths/receivers, duration.

Acceptance criteria:
- The planner's query parameters prefill the form within their documented ranges; others are ignored.
- A valid submit creates an `interpreting` Lead.
- Validation errors follow D3.1.

References: RF-11; COMPONENT-CONTRACTS query contracts.

External dependency: ADR 4.3 OPEN.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-36, brg-20.

Execution checklist:
- [ ] `brg-25.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-25.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-25.01.
- [ ] `brg-25.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-25.02.
- [ ] `brg-25.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-25.03.
- [ ] `brg-25.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-25.04.
