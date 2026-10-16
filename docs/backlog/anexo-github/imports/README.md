# Imports — creation batches

**Never re-run a batch to "fix" it** (annex § Traps). `initial.sh` is idempotent per local ID: anything already recorded in `keys.tsv` is skipped.

| Batch | Files | Contents | Status |
| --- | --- | --- | --- |
| `initial` | `initial.sh`, `initial/<local_id>.md` (issue bodies), `keys.tsv` (written by the run) | 7 epics, 30 stories (HU-01–HU-30), 17 tasks (brg-31–brg-47), 8 milestones P0–P7, 70 labels | Not run. Owner runs `bash initial.sh sample`, checks it, then `bash initial.sh rest` |

The bodies are generated from the batch data, so edit `docs/backlog/backlog.md` and the ticket on GitHub, not these files, once the batch has run. After it runs, record the result here (counts, first and last number) and copy `keys.tsv` into `../../key-map.md`.
