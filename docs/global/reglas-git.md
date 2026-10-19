# Git rules (Bridge Traducciones website)

**Status:** official since 2026-10-16.
**Owns:** the branch model, naming of branches and commits, and what the agent may do with git. **Referenced by:** `CLAUDE.md` §0.1, the methodology §2, the PR template. **Mode C since 2026-10-19** (ADR D1.2).

**Source of truth for the ID that names branches and commits:** the issue number in **GitHub Issues** (`BRG-<n>`, where `<n>` is the issue number; ADR D2.4). This document defines the _format_; the real ID comes from the board.

---

## 1. What the agent does with git

### Mode C: the agent runs git up to the PR; the owner merges (ADR D1.2, since 2026-10-19)

| The agent **DOES** | The agent **NEVER** does |
| --- | --- |
| Read commands (`status`, `log`, `diff`, `show`, `gh … view`) | Push to `main` or `develop`, or merge into them (`git merge`, `gh pr merge`) |
| `git switch` / `switch -c`, `add`, `commit`, `stash` | `push --force` or any rewrite of a branch already pushed (`rebase`, `reset`, `commit --amend` after push) |
| `push` its own `feature/*`, `docs/*`, `fix/*` branches | `git tag`, `hotfix/*` work, deleting remote branches someone else owns |
| `gh pr create` (base `develop`), `gh pr comment`, `gh pr edit` on its own PRs | Repo settings, rulesets, secrets, deploy keys (`CLAUDE.md` §0.6) |
| `gh issue comment`, `gh issue close`, `gh issue edit` (labels, milestone) after a merge or to record evidence | `gh issue create` in bulk, or deleting issues |
| Delete its own local branches after the owner merges | Commit `.env`, secrets or real client data (public repo, D2.2) |

**Asking the owner:** the agent asks only for what it can't do: merging a PR, an infrastructure action, or a business decision. It sends the PR link (or the exact action) and continues with other Ready work meanwhile.

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

## 4. Branch and PR routine (mandatory)

- **Before touching anything:** check the branch (`git branch --show-current`). Work never happens on `develop` or `main`: create the branch from an up-to-date `develop`, named with the real `BRG-<n>` from the board. If the ID isn't known, look it up in `docs/backlog/key-map.md`; never invent one.
- **When done:** show `git diff --stat`, confirm there are no secrets or real client data in it, commit per §3, push, and open the PR to `develop` with the evidence the methodology §2 requires. Then report the PR link to the owner and ask for the merge.
- **After the owner merges:** switch to `develop`, pull, delete the local branch, and close the issue with a comment linking the PR (`Closes #N` only fires on `main`).

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

The agent runs these blocks itself (§1); the remote-branch delete only for its own branches.

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
