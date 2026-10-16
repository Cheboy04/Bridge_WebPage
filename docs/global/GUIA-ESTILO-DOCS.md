# Documentation style guide

Rules shared by all kit documents. The agent applies them when filling templates and when writing specs, handoffs or ADR entries.

## 1. Header

Every living document opens with a block that says **what it is, what state it is in and who has authority**:

```markdown
# <Type> — <Topic> (<Project>)

**Status:** <draft | approved | official | implemented> since YYYY-MM-DD.
**Owns:** <what subject it governs>. **Referenced by:** <who uses it>.
```

Specs and ERDs use a quote block (`>`) with the ticket, phase, RF/RNF coverage, counterpart and status boxes `[ ] draft · [ ] approved · [ ] implemented`.

## 2. One owner per fact (anti-drift)

- Each concrete value (error code, version, acceptance criterion, veto, list of open points) is written in **one** document only. The others link to it or cite it by number (`D3.1`, `HU-05`, `§5`).
- If two documents contradict each other, fix the one that is **not** the owner, and note the drift in the handoff.
- When an agreement changes, **the document changes first**, then the code or the board.
- When you reference instead of copy, say where it lives: _"The current list lives in the ADR, 'Summary of prioritized open points'; it is not copied here."_

## 3. Dates and time

- Always absolute ISO dates: `2026-10-13`. Never "yesterday", "last week" or "next phase" without a date.
- Status changes carry a date: `**Updated on YYYY-MM-DD:** …`, `closed YYYY-MM-DD`.
- Decisions are not rewritten. They are extended with `> **Extension of YYYY-MM-DD (TICKET):** …` or marked as superseded, with a link to the one that replaces them.
- Closed items are struck through and keep their trail: `~~**9.3 Observability**~~ — **closed YYYY-MM-DD** (D9.3)`.

## 4. Explicit scope

- Every "in" list comes with an **"Out / deferred (with reason)"** list. Each exclusion says where it will be done (ticket or HU) or why it is not done (OPEN decision, outside the RF).
- Say what is temporary: _"temporary workaround that HU-11 must replace"_.
- Say what is not known: _"not investigated"_, _"assumption, pending confirmation"_. Do not fill gaps with guesses.

## 5. Tables and lists

- Use tables when each row has two or more attributes (decisions, tickets, tests, risks, fields). The usual columns are:
  - Decisions: `# | Point | Status | Decision`.
  - Tests: `# | Test (file::case) | What it asserts | How we prove it FAILS`.
  - Risks: `Risk | Signal | Response`.
  - Checklist items: `Item | Work | Done when`.
- Numbered lists are reserved for real order (steps, priority). All other lists use bullets.
- Diagrams are `mermaid` inside the markdown (ticket sequence, ERD), not images.

## 6. Writing

- Language: English. Code identifiers go in backticks and keep their original language.
- Short sentences in active voice. Rule first, then the reason, in one sentence: _"`.env` always in `.gitignore`: the repo is public."_
- Bold the word that decides (**never**, **only**, **first**), not whole sentences.
- No filler and no promises. "0 findings" is a valid result and is stated as is.
- Traps follow the pattern **symptom → real cause (reproduced) → what to do**.

## 7. Guidance comments

- Templates use `<!-- RELLENAR: … -->` as guidance (RELLENAR means "fill in"). A document is not ready while any remain.
- Variant blocks in the templates are resolved when the kit is filled. A filled project has none left.
- Examples from the origin project appear as `> Example (Track Studio): …`. Delete them or replace them with your own.

## 8. Security

- Never secrets, tokens, credentials or real data of the client or its users, neither in documents nor on the board. Say **where** they are ("the team password manager"), never **what** they are.
- Environment URLs and service-account emails may appear if the repo is private. If it is public, decide case by case and record the decision in the ADR.

## 9. Change log

- Specs and ERDs end with a **change log**: newest first, one line per milestone, with date and evidence (suite count, gate C3 mutations, who approved).
- Phase documents end with **"Board sync executed"**: a dated list of what was applied.
