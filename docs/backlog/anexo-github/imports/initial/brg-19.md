Story: As a visitor, I want to check my language pair instantly, so that I know Bridge can help before I write.

Scope: `<x-sig-lang-checker>` per COMPONENT-CONTRACTS LangChecker; data from published languages.

Acceptance criteria:
- A supported pair (one side Spanish, both listed) shows the shared services and links `quote.translation` with `origen` and `destino`.
- Any other pair shows the WhatsApp link with the pair in the message.
- The same language on both sides shows the inline error.
- Without JS the static es → en result shows.

References: RF-03, RF-15; SIGNATURE-COMPONENTS §2.

Blocked by (local IDs, see docs/backlog/key-map.md): brg-04, brg-01.

Execution checklist:
- [ ] `brg-19.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-19.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-19.01.
- [ ] `brg-19.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-19.02.
- [ ] `brg-19.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-19.03.
- [ ] `brg-19.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-19.04.
