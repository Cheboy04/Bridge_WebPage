# Methodology — SDD + TDD (Bridge Traducciones website)

**Status:** official since 2026-10-16.
**Owns:** how every task is worked (cycle, gates, roles). **Referenced by:** `CLAUDE.md`, specs, handoffs.

This document is **global**: it applies to all work in the repo. It defines **how we work with the agent**, not what gets built. The "what" lives in the stories (GitHub Issues) and their specs (`docs/specs/`). Closed technical decisions live in the ADR (`docs/adr/decisiones-tecnicas.md`).

**Read it in full at the start of every session.**

---

## 0. Sources of truth (and who owns what)

Every statement has a single owner. If two documents contradict each other, the owner of that subject wins:

| Subject | Source of truth |
| --- | --- |
| What gets built (stories, acceptance criteria) | **GitHub Issues**. Specs reference them, they don't copy them. |
| Closed technical decisions (stack, deploy, privacy, i18n…) | **ADR** (`docs/adr/decisiones-tecnicas.md`), by number: `D3.1`… |
| Design (tokens, components, logo, voice) | **Brand docs**: `brand/DIRECTION.md`, `brand/SIGNATURE-COMPONENTS.md`, `brand/logo/LOGO.md`, the brand book (ADR D3.8) |
| Technical contract and tests of a story | **The story's spec** in `docs/specs/HU-XX.md` |
| Data model | **ERD** (`docs/erd/`) |
| Agent behaviour rules | `CLAUDE.md` |
| Naming conventions | `docs/nomenclatura.md` |
| Git rules | `docs/global/reglas-git.md` |
| Planning (phases, gates) | `docs/backlog/roadmap.md` and `docs/backlog/sprints/` (phase docs) |
| What Bridge must supply | The placeholder register (P0, ADR §12) |
| State between sessions | `docs/global/handoffs/HANDOFF_vN.md` |

**Anti-drift rule:** a concrete value (a colour, a timing, a version, an acceptance criterion) is written in **one file only**. The others reference it. Duplicating it is a bug waiting for the two copies to drift apart silently.

---

## 1. The problem this method attacks

It isn't "AI codes fast". It's this:

> **The agent produces correct code and tests almost always, and when it's wrong, it's wrong with the suite green.**

A test that can't fail proves nothing. A spec the code no longer meets stops being a source of truth. A value the agent invented spreads without anything turning red. Everything below exists to force verification that **can fail** and intent that is **written down**, not remembered.

---

## 2. Roles

**Current mode: `B`** (ADR D1.2). Changing mode is an ADR decision (block 1), not a session decision.

### Mode B — The agent implements, the human reviews

Speed matters and code authorship is not a requirement. The human approves the intent and the result.

| Cycle step | Who |
| --- | --- |
| Spec | **Agent** (the human approves it **before** anything else) |
| Red tests | **Agent** (shows the red) |
| Code until green | **Agent** |
| Review with C3 (§5) | **Agent** (self-review), then **the human** reads the diff |
| Commit / push / PR | **Human**. The agent hands over the filled-in commands and stops (`reglas-git.md` §1). |

**Mandatory counterweight:** the agent can't approve its own spec or sign off its own C3 without showing the evidence (the red of each mutation).

**Parallel workers:** when work is split across subagents, each worker gets **strict file ownership** (named files, no overlap). Shared stubs are created before anyone starts, so the build never breaks mid-run. The orchestrating agent integrates and reviews; a worker's report is a claim, not evidence, until the orchestrator re-checks it.

### Permissions

**What the agent MAY run without asking:** read-only tools (read, search, query the code graph, `git status/branch/log/diff`), writing and running test files, application code inside the approved spec's scope, and the quality chain (`CLAUDE.md` §7.2).

**What the agent does NOT run:** git writes, infrastructure configuration (`CLAUDE.md` §0.6), and anything outside the approved spec. If it thinks one is needed, it **explains it in steps** and stops.

---

## 3. SDD — Spec-Driven Development (spec-anchored)

The spec lives next to the code and evolves with it. Its job is to prevent *intent drift*: the agent (or the human) moving away from the agreed intent.

**What a "spec" is.** One file per story in `docs/specs/HU-XX.md`. It does **not** rewrite the story or its acceptance criteria, which live in GitHub Issues. It elaborates:

1. **Scope** of the story, and what stays out or is deferred, with the reason.
2. **Technical contract**: routes, Blade components and props, models, validation, states, anchored to the ADR by number without copying it.
3. **Acceptance criteria** translated into **concrete tests**: test name, what it asserts and how it is proven to fail.
4. **Dependencies**: which stories, tasks or OPEN ADR decisions block this one.

**The spec stays alive.** If something the spec didn't foresee appears during implementation (an edge case, a contract change), the `.md` is updated **in the same session**. An outdated spec is worse than none. Operating rule: **when the agreement changes, the document changes first.**

---

## 4. The cycle per task

The order is fixed. Each task of a story goes through:

1. **Specify.** The agent reads the story in GitHub Issues, its acceptance criteria, the relevant ADR and the existing code (searching first, §7). It writes or updates the spec. The human approves it.
2. **Red.** The agent writes the tests derived from the acceptance criteria. **They must fail** when run, because there's no implementation yet, and the agent shows that red.
3. **Green.** The agent writes the code until the tests pass.
4. **Ping-pong (if needed).** If a test clashes with a better design, the agent says so and justifies it, adjusts the test and confirms it still covers the acceptance criterion. Tests aren't untouchable, but they're never relaxed silently.
5. **Review.** With the suite green, the agent audits the diff (§5) and verifies that each test **can fail**.
6. **Commit.** Per `reglas-git.md`: the agent hands over the command block and **stops**.

Small iterations: one reviewable diff at a time, one task at a time. Nothing else gets touched "while we're at it".

---

## 5. The TDD gates (non-negotiable)

**C1 — No tests without an approved spec.** If the spec is missing, it is written first (§3).

**C2 — No implementation without a test that already fails.** The red is seen before writing application code. If a test is born green without implementation, it's badly written (or it's a guard rail declared as such in a comment).

**C3 — Every new test is proven by breaking it.** This is the half almost nobody does, and the reason the method exists. In the **Review**, for each test that asserts something non-trivial, what it asserts is broken on purpose (revert the fix or mutate the value), and it must **turn red**. A test that stays green with the code broken gets fixed or deleted. The report says: _"proven red by reverting X"_, with the count of mutations and how many survived.

**C4 — When the contract is external, test against the real boundary.** A test that simulates the dependency tests our code, not the contract. Unit tests simulate external interfaces, but at least one integration test exercises the real boundary (the real MySQL in CI, a real mail render, the real private disk driver…).

**C5 — No tests, no finished task.** A task isn't finished without tests that cover it. "0 findings" in review is a valid result and is said as is; no work is invented to look diligent.

**Visual work** (Blade components, pages): the tests are the parity and a11y checks (0 axe violations, no overflow at 390 and 1440, the component's states from its contract), plus feature tests for the data each component renders. "Looks right" is evidence only after a fresh screenshot is compared with the prototype.

### What the Review looks for (step 5 of §4), limited to the task's diff

- **Dead or surplus code**: exports, props or constants nobody uses, and one-use abstractions.
- **The same thing written twice**: the worst case, because copies drift apart without turning red (anti-drift, §0).
- **Static bugs**: unhandled nulls, swallowed errors, unvalidated input at the boundary, and client-side work that the server should do.
- **Tests that can't fail** (C3).
- **Drift between docs and code**: if the spec, the ADR or the handoff claims something the implementation contradicts, it's fixed in the same pass.

The agent delivers the list of findings with `file:line`. Each one is **fixed** or **justified in writing**.

---

## 6. Tools

| | `site/` |
| --- | --- |
| Test runner | Pest (`php artisan test`) |
| Types / static analysis | Larastan (`vendor/bin/phpstan analyse`) |
| Format | Pint (`vendor/bin/pint --test`) |
| User-flow test | Browser run against the site: axe-core + overflow + interaction scripts (instrument OPEN, ADR 11.3; `prototype/check.mjs` is the current model) |
| CI install | `composer install` + `npm ci` (lockfiles respected) |

Common rule: the real pin comes from the versioned lockfiles, and CI installs respecting them (never a command that updates them).

---

## 7. Search before writing

Before writing a test or proposing an implementation, the agent queries the existing code with **codebase-memory-mcp**. It's for **reusing instead of rewriting** (does this helper, service or component already exist?) and so tests reference real symbols, not invented ones. Commands and when to re-index: `CLAUDE.md` §8. For the public UI, the prototype (`prototype/src/components/`) is searched too: it's the reference implementation.

It is memory **of the code**, not of the conversation. Memory between sessions is carried by versioned files: the specs and `HANDOFF_vN.md`.

---

## 8. What this method does NOT change

- **OPEN ADR decisions still block.** If a task touches a point marked `OPEN`, neither its implementation spec nor its tests are written yet: the pending decision is flagged. The live list is at the end of the ADR, not here; copying it would be the drift §0 forbids.
- **An OPEN decision doesn't always block.** If the implementation is compatible with **every** possible outcome of the decision, the point is noted and work proceeds. What's not allowed is silently picking one outcome and saying it "doesn't block".
  > Example: the attachment retention period is OPEN (ADR D7.1). The cleanup job reads the period from config, so it works with 90 days or any other value Bridge picks.
- **"What NOT to do yet"** in `CLAUDE.md` §5 overrides this cycle. Even if the method allows writing tests, they aren't written for modules vetoed there.
- The project's **Definition of Done** (ADR, block 1) is still the closing criterion. This method is how you get there, not a substitute.

---

## 9. "Ready" and "Done" for the agent

**Ready (a task can enter the cycle) if:** its story has acceptance criteria in GitHub Issues; the ADR decisions it depends on are `DECIDED` (or compatible with every outcome, §8); the ERD slice it needs is approved (if it touches data); and it isn't under "What NOT to do yet".

**Done (the agent can hand over the commit block) if:** the spec is written or updated; tests are green; each test was proven red (C3); the review has no open findings; the story's acceptance criteria are covered; and the docs have no drift. Without this, the task isn't delivered even if "it works".
