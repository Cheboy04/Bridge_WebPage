Story: As Bridge, I want old attachments deleted automatically, so that we keep personal documents only as long as needed.

Scope: A daily scheduled job deletes lead attachments older than the configured period.

Acceptance criteria:
- Attachments older than `retention_days` are deleted from disk and their records removed; newer ones stay.
- The lead itself and its non-file data remain.
- The period comes from config; the default is 90 until Bridge confirms.

References: RF-17, RNF-04; ADR D7.1.

External dependency: Retention period to confirm (ADR summary #2).

Blocked by (local IDs, see docs/backlog/key-map.md): brg-24.

Execution checklist:
- [ ] `brg-28.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-28.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-28.01.
- [ ] `brg-28.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-28.02.
- [ ] `brg-28.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-28.03.
- [ ] `brg-28.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-28.04.
