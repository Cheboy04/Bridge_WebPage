Story: As an editor, I want to work leads in one inbox, so that every request is answered and tracked.

Scope: Filament resource for `Lead`: list, filters by type and status, status changes, notes, attachment downloads.

Acceptance criteria:
- Editors and admins can list, filter and update the status and notes of leads.
- Attachments download only through signed, time-limited URLs.
- A guest following an expired download link gets 403.

References: RF-12, RNF-05; ADR D4.2, D7.1.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-24, brg-02.

Execution checklist:
- [ ] `brg-27.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-27.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-27.01.
- [ ] `brg-27.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-27.02.
- [ ] `brg-27.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-27.03.
- [ ] `brg-27.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-27.04.
