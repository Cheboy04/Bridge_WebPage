# Git rules (Bridge Traducciones website)

**Status:** official since 2026-10-16.
**Owns:** the branch model, naming of branches and commits, and what the agent may do with git. **Referenced by:** `CLAUDE.md` §0.1, the methodology §2, the PR template.

**Source of truth for the ID that names branches and commits:** the issue number in **GitHub Issues** (`BRG-<n>`, where `<n>` is the issue number; ADR D2.4). This document defines the _format_; the real ID comes from the board.

---

## 1. What the agent does with git

### Hard rule: the agent reads, it doesn't write

Mode B (ADR D1.2) lets the agent write code, but version control belongs **only to the human**. Every commit is a point where a person read a diff and said yes. Frequent commits are also the safety net to revert if something slips through, which matters more in a **public** repo: a secret that enters the history isn't removed by one more commit.

| The agent **DOES** (read only) | The agent **NEVER** does (writes) |
| --- | --- |
| `git status`, `git branch`, `git log`, `git diff`, `git show` | `git commit`, `git add` |
| Read the current branch to fill in the hand-over commands | `git push` |
| Inspect the history to guide better | `git checkout` / `switch` / `checkout -b` |
| `gh` read commands (`gh issue view`, `gh pr view`, `gh repo view`) | `git merge`, `git rebase`, `git reset` |
| | `git tag`, `git branch -d/-D`, `git stash` |
| | `gh pr create/merge`, `gh issue create/edit` without the owner's approval for that batch |

If the agent thinks a write is needed, it **doesn't run it**: it hands over the command block (§4) and stops.

---

## 2. Branch model: simplified git-flow

`feature/* → develop (staging) → main (production, with manual approval)`.

| Branch | Role | Born from | Goes back to |
| --- | --- | --- | --- |
| `main` | Production. | — | Only by PR from `develop`, with manual approval |
| `develop` | Integration / staging. A merge here deploys to staging (ADR 9.6). | `main` | — |
| `feature/BRG-<n>-<slug>` | One story or task. | `develop` | `develop` by **Pull Request** |
| `docs/<slug>` | Documentation-only work not tied to a single issue (e.g. the kit fill). | `develop` | `develop` by PR |
| `fix/<slug>` | Minor fix not tied to a story. | `develop` | `develop` by PR |
| `hotfix/<slug>` | Production emergency. | `main` | `main` **and** `develop` |

- **Never a direct `push` to `main` or `develop`.** Everything goes in by PR with CI green. Both branches get protection (rulesets) once CI exists (P1). The owner is the only reviewer, so the review is the owner reading the diff.

---

## 3. Naming convention

**Branches:** `feature/BRG-<n>-<slug>`, with a short `kebab-case` `<slug>`.

**Commits:**

```
<type>(<scope>): BRG-<n> <short imperative description>
```

- `<type>`: `feat` · `fix` · `test` · `docs` · `ci` · `chore`
- `<scope>`: the functional module (`leads`, `services`, `admin`, `brand`, `prototype`, `deploy`…), or omit it along with the parentheses.
- `BRG-<n>`: the issue number in GitHub Issues. Work with no issue (like the kit fill) omits it.
- Message language: English. It stays that way across the history.
- Trailer: commits end with the attribution line `Co-Authored-By: Claude Opus 5.5 <noreply@anthropic.com>` when the agent wrote the change.

> Example: `feat(leads): BRG-23 store consent timestamp on quote submit`, on branch `feature/BRG-23-lead-consent`.

This is the **only place** where the convention lives. The PR template and `CLAUDE.md` reference it; they don't repeat it.

---

## 4. Hand-over rule (mandatory)

Because the agent doesn't run git writes, **every time it starts and every time it closes a task it hands over a ready-to-copy command block**, filled in with the real branch and ID (read with `git branch` / `git status` and from the board). Without that block, the task isn't delivered.

- **Before touching anything:** say which branch the work must be on and how to create it. If the base branch doesn't exist or **the real `BRG-<n>` isn't known**, say so and **stop**: don't start on the wrong branch and don't invent the ID.
- **When done:** the closing block (`add`, the commit written per §3, `push`, and opening the PR to `develop`).
- Before the closing block, the agent shows `git diff --stat` and confirms there are no secrets or real client data in the diff.

### 4.1 Command blocks

**Start a task:**

```bash
git switch develop && git pull
git switch -c feature/BRG-<n>-<slug>
```

**Close a task:**

```bash
git add -A
git commit -m "<type>(<scope>): BRG-<n> <imperative description>"
git push -u origin feature/BRG-<n>-<slug>
gh pr create --base develop --fill
```

**I started working without a branch** (uncommitted changes travel with `switch -c`):

```bash
git status                                  # confirm there are NO commits, only unstaged changes
git switch -c feature/BRG-<n>-<slug>        # takes the work with it
```

**Park half-done work to switch context:**

```bash
git stash push -m "BRG-<n> wip"
git stash list
git stash pop
```

**Clean up after the PR is merged:**

```bash
git switch develop && git pull
git branch -d feature/BRG-<n>-<slug>
git push origin --delete feature/BRG-<n>-<slug>
git remote prune origin
```

**Initial repo bootstrap** (once; done on 2026-10-16):

```bash
git switch main && git pull
git switch -c develop
git push -u origin develop
```

---

## 5. When to commit and when to push

| Moment | Action |
| --- | --- |
| Red tests written and seen failing (Red phase) | `commit` the red (`test(…)`): it stays as C2 evidence |
| Tests green and one logical unit finished | `commit` (one per coherent unit, not one giant at the end) |
| End of the task, or a remote backup or review is wanted | `push` |
| Task complete, AC covered, tests green and **proven red** (C3) | `push` and **PR to `develop`** |
| Never | Direct `push` to `main` or `develop` |

---

## 6. Recorded traps

- **The board ID, not the import file ID.** If the backlog is loaded from a local list, the local ID (`brg-05`) is **not** the issue number GitHub assigns. Naming branches with the local ID causes collisions. Current keys are in [`docs/backlog/key-map.md`](../backlog/key-map.md) and are checked before creating a branch.
- **CI may not run without a PR.** If workflows listen to `pull_request` on the protected branches, a push to a feature branch with no PR leaves no evidence. To keep the red in CI, open the PR (as a draft) **before** pushing the red commit.
- **A commit that doesn't build on its own** (imports something that arrives in the next commit) breaks `bisect`. When a file mixes changes from two commits, use `git add -p`.
- **Public repo:** before every PR, check the diff doesn't carry `.env`, secrets or real client data. `.env` always in `.gitignore`.
- **Code generators** (`artisan make:*`, `filament:*`, scaffolding CLIs) can add dependencies or extra files. After each one, review the diff of the dependency manifests.
- **The shell is zsh-compatible, not fish**, even though the environment reports fish (HANDOFF_v1 trap 2). Command blocks are written in POSIX syntax.
