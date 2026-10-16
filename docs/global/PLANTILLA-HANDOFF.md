# TEMPLATE — Handoff between sessions

Copy to `docs/global/handoffs/HANDOFF_vN.md` (N increments; **the previous one is not overwritten**). It is **memory between sessions**, not a spec. Specs live in `docs/specs/`; closed decisions live in the ADR.

**Why versioned and why detailed:** chat context does not persist and an agent session restarts. Everything that matters lives in files. Each handoff records not only what was done but **the trap that cost time**, so the next session does not repeat it.

**Consolidation rule:** every 10 handoffs, create `HANDOFF_v<a>-v<b>_consolidado.md`, which unifies the previous 10 and nothing else (template at the end). Traps that are still valid and do not depend on the project move up to `lecciones-transversales.md`.

---

# Handoff vN — Bridge Traducciones (website)

**Date:** YYYY-MM-DD · **Phase:** N (YYYY-MM-DD → YYYY-MM-DD) · **Layer:** site
**Session focus:** <one sentence: ticket, HU and the step of the cycle where it stopped>

> Continues [`HANDOFF_v(N-1).md`](HANDOFF_v(N-1).md). Branch `feature/…`, head `<hash>`. <!-- Is there a PR? Is everything committed? -->

## 1. Executive status

<!-- 2-4 bullets: where the work stands, what is green, what is missing to close, what was tested by hand and by whom. -->

## 2. GitHub Issues

<!-- What was written to the board in this session. If it could not be done (connector down, no permission), what remains pending on the human side. -->

## 3. Decisions of the session

<!-- Numbered, each with its reason. If it closes or opens an ADR decision, say so with its number (Dx.y). If the agreement changed, the owner document must have changed first (anti-drift rule). Mark temporary solutions as such and say which ticket replaces them. -->

1. …

## 4. Evidence

<!-- Suite count per layer, linters, C3 (N mutations, M survived and what was hardened), CI status. -->

## 5. Files of the session

<!-- Grouped by layer and by author (human / agent). -->

## 6. Operational traps

<!-- The concrete bug, the real cause (reproduced, not assumed) and how to avoid it. This is the section that saves the most time for the next session. At the end, one line with the traps from earlier handoffs that are still valid. -->

1. …

## 7. Detected drift

<!-- Contradictions between documents, or between a document and the code: which one is the owner and what must be fixed. Never leave it unrecorded. Omit the section if there is none. -->

## 8. Ordered next steps

<!-- The first thing the next session would do, in dependency order. Include inherited pending items that are still open. -->

1. …

## 9. How to resume the environment (only if it changed)

<!-- Only if something in the setup changed since the previous handoff. If not, delete the section. -->

---

# TEMPLATE — Consolidated handoff

# Consolidated handoff v<a>–v<b> — Bridge Traducciones (website)

**Covers:** YYYY-MM-DD → YYYY-MM-DD · **Replaces reading:** `HANDOFF_v<a>.md` … `HANDOFF_v<b>.md` (kept as history).

## 1. Executive summary
## 2. What was done (chronology)
## 3. Current decisions (with their owner document)
## 4. Traps and findings that are still useful (grouped: tests, libraries, environment/CI, shell and git, management)
## 5. Drift: status at the close of v<b>
## 6. Blockers and pending items at the close of v<b>
## 7. Next steps (as left in v<b>)
## 8. How to resume the environment
## 9. Rule

Every 10 handoffs, a new one is created that unifies the previous 10 and nothing else. **The next consolidation is due when v<b+10> closes and covers v<b+1>–v<b+10>.**
