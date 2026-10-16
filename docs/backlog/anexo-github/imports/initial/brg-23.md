Story: As a visitor, I want to send a short message, so that Bridge contacts me.

Scope: Livewire form on `/contacto` and service pages: name, email or phone, message, consent.

Acceptance criteria:
- Submitting without email and phone, or without consent, shows the error summary focused and inline errors.
- A valid submit creates a `contact` Lead with `consent_at` and shows the thank-you state.
- The honeypot and the per-IP rate limit reject bots without creating a lead.
- The visitor's IP is not stored on the lead.

References: RF-09, RNF-04, RNF-05; ADR D3.1, D8.4, D8.5.

External dependency: ADR 4.3 validation approach OPEN.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-36, brg-16.

Execution checklist:
- [ ] `brg-23.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-23.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-23.01.
- [ ] `brg-23.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-23.02.
- [ ] `brg-23.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-23.03.
- [ ] `brg-23.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-23.04.
