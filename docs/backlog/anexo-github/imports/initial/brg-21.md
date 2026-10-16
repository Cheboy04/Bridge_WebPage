Story: As a legal client, I want to see what a certified translation looks like, so that I know what I'll receive.

Scope: `<x-sig-before-after>` per COMPONENT-CONTRACTS BeforeAfter, on `/traduccion/certificada`.

Acceptance criteria:
- With JS and motion allowed, the range drives the reveal and is keyboard operable with the documented aria-valuetext.
- Without JS or with reduced motion both versions show side by side (desktop) or stacked (mobile).
- Every name and number in the sample is a fake placeholder.

References: RF-15; SIGNATURE-COMPONENTS §4.

External dependency: Seal stays provisional (stamp OPEN).

Blocked by (local IDs, see docs/backlog/key-map.md): brg-11.

Execution checklist:
- [ ] `brg-21.01` Spec site. Done when: Spec approved by the owner, anchored to the ADR and without copying the AC.
- [ ] `brg-21.02` Tests site in red. Done when: Tests written and seen failing for the right reason (C2). Internal order: brg-21.01.
- [ ] `brg-21.03` Code site until green. Done when: Tests green; the quality chain (CLAUDE.md §7.2) is clean. Internal order: brg-21.02.
- [ ] `brg-21.04` Review site. Done when: Findings with file:line resolved or justified; each non-trivial test proven red (C3). Internal order: brg-21.03.
- [ ] `brg-21.05` Integration and close. Done when: PR to develop with CI green; AC verified on staging; applicable RNF checked; handoff updated. Internal order: brg-21.04.
