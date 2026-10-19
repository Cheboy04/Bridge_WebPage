# TEMPLATE — HU spec

Copy this file and fill it in. **Where the spec lives:**

- `docs/specs/HU-XX.md`. No counterpart.

**Rules when filling it in:**

- **Do not copy** the story's acceptance criteria: they live in GitHub Issues. Here go the criteria **of this layer**, turned into tests.
- **Reference the ADR by number** (`D3.1`…). Do not paste its content.
- A concrete value (error code, version, claim name) is written in its owner and referenced here; it is not duplicated.
- Delete the `<!-- … -->` guidance comments before calling the spec ready.
- Expected depth: enough that whoever implements does not have to invent anything (routes, fields, error codes, visible texts) and that each test has a clear way to fail.

---

# HU-XX (site) — <short story title>

> **GitHub Issues:** `BRG-XXX` · **Phase:** N · **Covers:** RF-0X, RNF-0X
> **Counterpart:** — (does not cross layers)
> **Status:** `[ ]` draft · `[ ]` approved · `[ ]` implemented

<!-- One or two sentences: which AC of the story (summarized, not copied) this spec translates. -->

## 1. Scope in this layer

**In:**

- …

**Out / deferred (with reason):**

- … → `BRG-YYY` (HU-YY) <!-- each exclusion says WHERE it will be done or WHY it is not done: "depends on ADR 8.4, OPEN; this API is compatible with any later decision" -->

## 2. Dependencies

- **GitHub Issues:** tickets that must be finished.
- **Data model:** the ERD section that is the single source of columns and constraints (if it touches data).
- **Vetoes:** if a veto from `CLAUDE.md` §5 was lifted for this HU, cite it with the date.
- **ADR (DECIDED):** `Dx.y`, …
- **OPEN items that do not block:** `Dx.y` and why this implementation is compatible with every possible outcome.
- **External:** domain, tenant, bucket… or "none".

## 3. Technical contract

<!-- The "how" of this layer, anchored to the ADR. Use the subsections that apply and delete the rest. -->

<!-- API / server layer:
### 3.1 Routes            method + path + who can + response
### 3.2 Authorization     policy / permissions per role (ref. ADR matrix)
### 3.3 Input             field-by-field validation
### 3.4 Business rules
### 3.5 Service           what it orchestrates, transactions, effects
### 3.6 Persistence       tables, relations (ref. ERD)
### 3.7 Output            exact response shape, per role
### 3.8 Errors            table status → code → when (ref. D3.1)
-->

<!-- UI / client layer:
### 3.1 Routes            browser route → page → role guard
### 3.2 Screens and texts   exact visible texts (the tests will assert them)
### 3.3 Client-side validation   only what runs ahead of the server
### 3.4 Data              queries/mutations, cache keys, invalidations
### 3.5 Errors            code → what the user sees (ref. D3.1)
-->

<!-- Data / job / CLI layer: inputs, outputs, idempotency, retries, scheduling. -->

## 4. Acceptance criteria of this layer → tests

<!-- Each row is a test the agent will write in red. Before the table, one line with the runner, the real boundary (C4) and the helpers that are reused.
"How we prove it FAILS" is mandatory: it is gate C3. Describe the concrete mutation that turns it red. -->

| #   | Test (file::case) | What it asserts | How we prove it FAILS (C3) |
| --- | ----------------- | --------------- | -------------------------- |
| 1   | `…`               | …               | …                          |
| 2   | `…`               | …               | …                          |

## 5. Implementation notes

<!-- Hints for the Green phase: which helper to reuse (found by searching the code), which order to follow, which trap to avoid (see lecciones-transversales.md). It is NOT the code. -->

## 6. Spec change log

<!-- Newest first. Each time the implementation reveals something unforeseen, note it here and fix the affected section in the same session. Also record the cycle milestones with their evidence:
- `YYYY-MM-DD` — review with C3: N mutations, M survive; #X is hardened because… 
- `YYYY-MM-DD` — implemented: suite N green; linters clean.
- `YYYY-MM-DD` — spec committed (C1). Tests in red: N cases fail for <right reason>.
- `YYYY-MM-DD` — draft created. Human decisions: …
-->

- `YYYY-MM-DD` — created.
