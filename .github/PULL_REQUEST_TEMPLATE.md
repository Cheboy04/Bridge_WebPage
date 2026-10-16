<!--
  PR template for Bridge Traducciones (website).
  Title = the commit message, per docs/global/reglas-git.md §3.
  Branch: feature/BRG-<n>-<slug> (or docs/* / fix/* / hotfix/*), into develop.
-->

## Story / task

- Issue: Closes #
- Spec: `docs/specs/HU-XX.md`

## What changes

<!-- What was added, changed or removed, and why. New decisions must already be in the spec or the ADR. -->

## How it was tested

<!-- Which tests cover the change and how to verify it by hand. An acceptance criterion that can't be verified doesn't count as tested. -->

- [ ] Tests added or updated and seen red before the implementation (C2)
- [ ] Each non-trivial test proven by breaking it (C3): N mutations, M survived and are justified in the spec
- [ ] Verified locally
- [ ] Public UI: 0 axe violations and no horizontal overflow at 390 and 1440 (if it changes something visible)

## Review checklist

- [ ] The spec is up to date, with no drift from the code
- [ ] No secrets, `.env` or real client data in the diff (public repo, ADR D2.2)
- [ ] Lockfiles committed if dependencies changed (and the new package has an ADR entry)
- [ ] Names follow `docs/nomenclatura.md` and the ADR
- [ ] Handoff updated

### Screenshot (if something visible changes)

<!-- Fresh screenshot next to the prototype's equivalent at 390 and 1440. -->

## CI

- [ ] Pipeline green

## Notes for the reviewer

<!-- Context, design decisions, places that need specific attention, temporary workarounds and which issue replaces them. -->
