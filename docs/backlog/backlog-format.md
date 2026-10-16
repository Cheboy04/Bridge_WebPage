# Common backlog format

**Status:** official convention for granularity and traceability since YYYY-MM-DD. An official backlog does not authorize implementation and does not replace Ready (`docs/global/metodologia-sdd-tdd.md` §9).

This format is **task-manager agnostic**. The GitHub Issues mapping and loading steps are in [`anexo-github/`](anexo-github/README.md) (ADR D2.4).

## Files and authority

- [Roadmap](roadmap.md): phases, releases and capacity; horizon and control.
- [Backlog](backlog.md): catalog of epics, Stories and Tasks, and HU ↔ RF/RNF coverage.
- `sprints/phase-NN.md`: breakdown per phase, with tickets, checklists and dependencies ([template](sprints/PLANTILLA-SPRINT.md)).
- [Key map](key-map.md): `local_id` → real key in GitHub Issues.
- [SDD/TDD methodology](../global/metodologia-sdd-tdd.md): cycle, roles, gates C1-C5, Ready and Done.
- [Git rules](../global/reglas-git.md): branches, commits and command delivery.
- ADR (`docs/adr/decisiones-tecnicas.md`): technical decisions by number (`Dx.y`) and OPEN blocks.
- Specs (`docs/specs/…`): technical contract and tests of each story.

This format does not replace the specs or the ADR. **Anti-drift rule:** the acceptance criteria of a story are written once, in GitHub Issues. Specs and phase documents reference them; they do not copy them.

## Hierarchy

```text
Epic
  Story (one HU) or Task (technical, infrastructure, decision or documentation)
    Detailed checklist inside the Description
    Sub-task only if it needs its own tracking
Bug linked to the affected delivery
```

Release and phase are planning attributes, not parents. An epic can span several phases. A Task is a sibling of the Stories under the epic; a Task is never nested under a Story.

## Identifiers

| Element    | local_id                       | Example                            |
| ---------- | ------------------------------ | ---------------------------------- |
| Epic       | `brg-epic-<slug>`              | `brg-epic-users`                   |
| Story (HU) | `brg-<NN>`                     | `brg-05` ↔ HU-05                   |
| Task       | `brg-<NN>`                     | `brg-29`                           |
| Bug        | `brg-<NN>`                     | `brg-38`                           |

Single counter: `brg-01`..`brg-NN` are HU-01..HU-NN; Tasks and Bugs take the next free number after the last HU.

- IDs are stable and never reused. Moving a story to another phase does not change its ID.
- The real board key (`BRG-<n>`, where n is the GitHub issue number) does **not** match the `local_id`; the correspondence lives only in [key-map.md](key-map.md).
- Checklist items have no key, type, status or import row. An exceptional Sub-task is declared expressly as a ticket.

## Minimal Description

An Epic contains a single paragraph:

```text
Outcome and limits: <bounded outcome>. The epic groups approved scope; each delivery requires a spec and tests in red before implementing.
```

A Story or Task contains:

```text
Story: As a <role>, I want <feature>, so that <benefit>.   # Story only.

Scope: <included and relevant exclusions>.

Acceptance criteria:
- <verifiable criterion of the complete outcome>

References: <RF/RNF, ADR Dx.y, docs/specs/…/HU-NN.md, roadmap>.

External dependency: <human infrastructure, OPEN ADR block or person>.   # Only if applicable.

Execution checklist:
<items with ID, work, Done when and internal order>
```

- Do not leave empty sections; if something does not apply, omit it.
- Type, parent, priority, story points, phase, release, owner, labels and links go in their native fields. They are not duplicated in the Description.
- The acceptance criteria section is the source of truth for AC. If the code must differ, update the ticket first.
- Never include secrets, tokens or real data of the client or its users.

## Standard checklist

Each Story starts from this template and adjusts it to its story: remove the items of the layer that does not apply and add specific items (business rules, concrete RNF). The items follow the role split of the methodology (§2).

**Block for the layer** (this project has one layer, `site`, so there is one block):

| Item  | Work                            | Done when                                                                                       |
| ----- | ------------------------------- | ----------------------------------------------------------------------------------------------- |
| `.01` | Spec site                       | Spec approved by the human, anchored to the ADR and without copying the AC.                     |
| `.02` | Tests site in red               | Tests written and seen failing for the right reason (C2).                                       |
| `.03` | Code site until green           | Tests green; the layer's quality chain is clean.                                                |
| `.04` | Review site                     | Findings with `file:line` resolved or justified; each non-trivial test proven red (C3).         |

**Final item, one per Story:**

| Item  | Work                 | Done when                                                                                                 |
| ----- | -------------------- | --------------------------------------------------------------------------------------------------------- |
| `.NN` | Integration and close | PR to the integration branch with CI green; AC verified in staging; applicable RNF checked; handoff updated. |

> Example (Track Studio, monorepo): `.01`-`.04` backend, `.05`-`.08` frontend and `.09` integration. In a backend-only HU, `.01`-`.04` and `.05` integration.

Format of each item in the Description:

```text
- [ ] `brg-05.03` Code site until green. Done when: create and edit tests green; linters clean. Internal order: brg-05.02.
```

Tasks use items of their own nature (decision, infrastructure, documentation), with the same format. Checking an item does not close the ticket or satisfy its gates.

## When to split work into another ticket

| Need                                                                                | Representation                                                           |
| ----------------------------------------------------------------------------------- | ------------------------------------------------------------------------ |
| Spec, test, implementation or check within the same outcome.                        | Checklist item.                                                          |
| A layer of the story that someone else carries, with its own status, deadline or blocker. | Sub-task under that Story.                                         |
| Decision or infrastructure that blocks several stories (ERD, bucket, mail…).        | Independent Task under the epic, with Blocks links.                      |
| Two outcomes acceptable separately, or a story that does not fit in a phase.        | Two Stories under the same epic, each with its own scope and criteria.   |
| Defect found in tests, review or staging that needs tracking.                       | Bug linked to the affected delivery.                                     |

There is no fixed number of tickets per story. Layers are not split automatically, and no ticket is created per test or per step.

When splitting a story, distribute its criteria and items without omitting or duplicating scope; both parts link the same HU and RF, and dependencies, SP and target phase are updated. When promoting an item to a ticket, the item stays as a reference to the new `local_id` and is not executed twice.

## Ticket fields

| Local field        | Content and rule                                                                                      |
| ------------------ | ----------------------------------------------------------------------------------------------------- |
| `local_id`         | Unique, stable, never reused.                                                                         |
| `issue_type`       | Epic, Story, Task, Bug or justified Sub-task.                                                         |
| `summary`          | Specific title with action or outcome. In Story: `HU-NN <outcome>`.                                   |
| `parent_id`        | Epic for Story/Task; Story/Task for Sub-task; empty in Epic.                                          |
| `description`      | Story, scope and exclusions.                                                                          |
| `acceptance`       | Acceptance criteria of the complete outcome (source of truth).                                        |
| `checklist`        | ID, work, Done when and internal order of each item.                                                  |
| `release`          | R1, R2… per the roadmap; `transversal` (cross-cutting) if it applies to all.                          |
| `target_sprint`    | Target phase: P0..P7; may stay pending. (The field name keeps the kit's `sprint` for import compatibility.) |
| `story_points`     | Fibonacci 1, 2, 3 or 5 by planning poker. Story only.                                                 |
| `priority`         | P0 needed for the phase goal; P1 extra capacity.                                                      |
| `layer`            | `site`, `infra` or `docs`.                                                                            |
| `risk`             | `normal`, `seguridad` (security: auth, permissions), `datos` (data: migrations, integrity), `archivos` (files) or `infra`. |
| `adr_gate`         | ADR blocks it depends on and their status.                                                            |
| `definition_state` | `backlog-oficial`, `pendiente-decision` or `ready`.                                                   |
| `status`           | Flow: To Do → In Progress → In Review → Done.                                                         |
| `owner`            | Person, only when confirmed.                                                                          |
| `references`       | HU-NN, RF/RNF, ADR `Dx.y`, spec.                                                                      |
| `blocked_by`       | Predecessor `local_id`s and reason.                                                                   |
| `external_blocker` | Human infrastructure, decision or external person, with the next action.                              |
| `split_reason`     | Reason for creating a Sub-task or splitting a story.                                                  |
| `evidence`         | PR, CI run, staging screenshot. Empty until executed.                                                 |

All tickets enter the official backlog with no owner and no evidence. They are still not Ready until they meet the definition of Ready.

## Dependencies and gates

- `blocked_by` records delivery dependencies: the successor is not considered finished before the predecessor. Isolated specs and tests in red are allowed when the dependency does not affect that activity.
- The order between items is kept in the Description; it is not exported as Blocks links.
- The parent expresses membership, not blocking. No cycles are created between a ticket and its children.
- **ADR gate:** a story that depends on an OPEN block is not Ready.
- **Manual infrastructure:** Hostinger (hPanel, SSH, DNS, mail, cron), GitHub (repo settings, Actions secrets, deploy key), Google GA4 are configured by the human team. They are recorded as an External dependency or as a linked Task; the agent does not touch them.
- **Method gates:** C1-C5 (methodology §5). Checking items does not replace them.
- **Done:** see ADR, block 1. The release ships when all its stories meet Done.
- A documented blocker is still a blocker. The phase can close by calendar, but its goal is not declared met if criteria are missing.
- Fixes discovered by tests or reviews are resolved before delivery; if they need their own tracking, they are created as a linked Bug.

## Estimation, capacity and Ready

- Stories are estimated in story points (1, 2, 3, 5) by planning poker, considering complexity, uncertainty and volume, with no direct translation to hours. The anchor story is in the ADR (1.5).
- A story of more than 5 SP is split.
- Nominal capacity: <!-- RELLENAR: people × hours per phase -->. Specs, tests, reviews, integration, fixes, documentation and Tasks without SP consume that same capacity. External waits are recorded separately, without fictitious hours.
- **Continuous flow:** if a phase ends early, take Ready stories from the next one, never one blocked by the ADR.
- **Ready:** AC written in the ticket, the ADR blocks it depends on in DECIDED status, and work outside "What NOT to do yet". The spec is written when the story enters the cycle, not before loading the backlog.

## Work already done before the board

If earlier work exists (scaffolding, CI, auth…), its tickets are created like the others, in To Do, and then moved to Done by hand, recording the PR or the CI run as evidence. They are never loaded as Done without evidence.
