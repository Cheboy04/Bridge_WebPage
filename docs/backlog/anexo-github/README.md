# GitHub annex — mapping and loading the backlog

**Status:** official since 2026-10-16.
**Owns:** how the local backlog maps to GitHub Issues and Projects on `Cheboy04/Bridge_WebPage`. **Referenced by:** ADR D2.4, `key-map.md`.

It applies the [common format](../backlog-format.md) to GitHub. It replaces the kit's Jira annex, which was deleted on 2026-10-16 (ADR D2.4).

## Field mapping

| Local field | Destination in GitHub |
| --- | --- |
| `local_id` | Label `local:<local_id>` (e.g. `local:brg-05`) |
| `issue_type` | Label `type:epic`, `type:story`, `type:task` or `type:bug`. Epics are issues too, with stories linked as **sub-issues**. |
| `summary` | Issue title. Stories start with their HU: `HU-05 <outcome>`. |
| `parent_id` | Sub-issue of the epic issue |
| `description`, `acceptance`, `checklist` | Issue body, in that order. The checklist uses Markdown task lists (`- [ ]`). |
| `release` / `target_sprint` (phase) | Milestone `P0 Lock` … `P7 Ship` (one per phase, ADR D1.1) |
| `story_points` | Project field `Points` (number), only if estimation is adopted (ADR 1.5 OPEN) |
| `priority` | Project field `Priority` (`P0` / `P1`), no new values |
| `layer` | Label `layer:site`, `layer:infra` or `layer:docs` |
| `risk` | Label `risk:<value>` |
| `definition_state` | Label `state:official`, `state:pending-decision` or `state:ready` |
| `status` | Project field `Status`: Todo → In progress → In review → Done |
| `owner` | Assignee |
| `blocked_by` | "Blocked by #n" line in the body, plus the Project's blocking relation if enabled |
| `external_blocker` | "External dependency" section in the body, plus label `blocked:external` |
| `evidence` | A comment with the PR link and CI run, no sensitive data |

Extra label per batch: `batch:<name>` (e.g. `batch:initial`), so the batch can be audited.

## Loading the backlog

1. **The owner approves the backlog** (`backlog.md`) first. Until then nothing is written to GitHub (`CLAUDE.md` §5).
2. The agent prepares the labels, milestones and issue bodies as a script of `gh` commands (`gh label create`, `gh api` for milestones, `gh issue create --label … --milestone … --body-file …`) and **hands it over**. The owner runs it; the agent doesn't write to the board (git rules §1).
3. **Run a sample first:** one epic and one story linked as a sub-issue. Record the returned numbers in [`../key-map.md`](../key-map.md) and check the labels, milestone and parent.
4. Run the rest. Record every `local_id → #n` in `key-map.md`.
5. Check the counts of issues per type and per milestone, the parents, the labels, and that there are no duplicates (`gh issue list --label batch:initial --limit 200`).

## Traps

- **Never re-run a creation script.** After a partial success, list what exists (`gh issue list --label batch:<name>`) and create only what's missing. Replanning is done by editing milestones and fields, not by recreating.
- **The local ID isn't the issue number.** Only the number recorded in `key-map.md` names branches and commits.
- **Work done before the board** is created in Todo and moved to Done by hand with its evidence (PR, CI), never created as Done directly.
- **Public repo:** issue bodies and comments are public. No real client data, phones or emails in them (ADR D2.2).

## Files

- `imports/<batch>.sh` + `imports/README.md`: each real batch script with its result (counts, returned numbers). Created when the first batch is loaded.
