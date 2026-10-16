Story: As a client, I want to request a translation quote with my documents, so that Bridge can price it.

Scope: Livewire form on `/cotizacion/traduccion`: service, language pair, certified/notarised, deadline, up to 5 files of 20 MB.

Acceptance criteria:
- `origen`, `destino` and `servicio` from the query string preselect the fields; unknown values are ignored.
- Files beyond 5, over 20 MB or of another type are rejected with a Spanish message.
- Accepted files are stored on the private disk and are reachable only through signed URLs.
- A valid submit creates a `translation` Lead with its attachments.

References: RF-10, RNF-04; ADR D7.1.

External dependency: ADR 4.3 OPEN.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-36, brg-19.

Execution checklist:
- [ ] `brg-24.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-24.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-24.01.
- [ ] `brg-24.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-24.02.
- [ ] `brg-24.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-24.03.
- [ ] `brg-24.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-24.04.
