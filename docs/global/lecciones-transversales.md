# Cross-cutting lessons

Traps that cost time in earlier projects and that **do not depend on the stack**. They come preloaded from the first project that used this kit (Track Studio, 25 handoffs). Each project adds its own when it consolidates handoffs (`PLANTILLA-HANDOFF.md`, consolidation rule) and deletes the ones that do not apply.

Format: the trap, the symptom and what to do.

---

## Tests that cannot fail (C3)

- **A test must fail for what it asserts, not by accident.** A "404 if the resource does not exist" test is born green if the route does not exist either, because a missing route also returns 404. Before asserting the business 404, check that the route exists (a helper like `exigirRuta()`).
- **A test that is born green** without an implementation is deleted, or justified as a guardrail with a comment in the file.
- **A simulator that answers any request hides destination errors.** If the API mock returns 200 to every `GET`, a navigation to the wrong id passes. Also assert the exact URL of the next request.
- **To prove the UI renders the server response, the response must differ from what was typed.** If they are equal, removing the update-from-response goes unnoticed.
- **A mutation that touches only one layer can survive because another layer covers it** (e.g. the controller lets a field through, but the service filters it again). In C3 you mutate every layer involved.
- **Equivalent mutations:** `count()+1` and `max+1` agree as long as there are no gaps. The test data must have gaps to tell them apart.
- **Ordering tie-breaks:** if ids are generated sorted by time, the database "gets" the tie-break right by chance. Fix the ids by hand and use several tied rows.
- **A component that unmounts hides dangling state.** For dialogs and controlled states, test the round trip (open → close → reopen).
- **An assertion on a null value can produce an *error* instead of a *failure*.** Assert the type first.
- **The runner may classify as "error" what the C3 script looks for as "failed".** The script that counts red mutations must count both states.
- **The runner's compact summary can hide which tests failed.** For the C3 review, use a detailed report (JUnit or similar) in a git-ignored path.

## Contracts and boundaries (C4)

- **CI must run against the same database engine as production.** If `.env.example` points to an in-memory engine, CI tests something else.
- **Empty environment variables in CI** can break an external provider's SDK with a 500 that does not appear locally. Every test that uses the boundary configures its test environment explicitly. To reproduce it, run the suite with those variables empty.
- **Tests read the local `.env`.** If the test configuration does not fix a value (language, time zone), the suite passes in CI and fails on one machine, or the other way round. Fix it in the test configuration.
- **Errors that depend on headers** (e.g. a 401 versus a redirect depending on `Accept`): "no credentials" tests also run without the header.

## Data and migrations

- **A new migration does not reach the local database by itself.** If the suite recreates the schema on every run, it passes even when nobody migrated the development database. Symptom: "relation does not exist" error when testing by hand. Before testing by hand an HU with a migration, check the migration status.
- **Never edit a migration that was already applied in any environment.** Create a new one. Editing it forces a reset of that environment, and production will fail the same way.
- **Platforms that migrate on their own on every deploy:** some hosts run migrations even if the repo does not ask for it. That is a de facto decision about "migrations on deploy"; record it in the ADR.
- **A schema method can be syntactically valid but incompatible with the engine** (e.g. a ULID FK to a UUID PK). The linter does not see it; it only fails on migrate, with 0 assertions in every test.
- **Unnamed constraints:** the engine gives them an automatic, unstable name. To translate constraint errors into a stable 422, name them explicitly.
- **A default value that exists only in the database** is not on the in-memory instance after creating it. Reload the instance before serializing it.
- **An id with an invalid format** (not a UUID) can reach the database and produce a 500. Restrict the format in the route.
- **Uniqueness races:** validating and then inserting leaves a window. The database protects the data, but the second write can produce a 500. Accept it explicitly (with its assumption) or translate the database error.
- **Test DDL against the real engine without leaving a trace:** run it inside `BEGIN … ROLLBACK`.

## Types, build and tooling

- **The test runner may not type-check.** A forgotten import or a broken type passes the tests and breaks the build. The quality chain always includes the type check.
- **A module error takes down the whole test file**, not just the new case. During the red phase, a test that imports a module from another HU that does not exist yet turns its whole file red.
- **When you move code between files, check the imports left unused:** they break lint and build, not the tests.
- **Untyped route parameters:** a misspelled name compiles, resolves to an empty string and produces URLs like `/resource//child`. Only a test that compares the exact URL detects it.
- **Generators (scaffolding, components, stubs) bring dangerous defaults:** authorization set to `false`, extra dependencies, imports from the wrong packages. Review the diff of every generator, especially dependency manifests.
- **The editor's formatter may not match the project's.** Configure the editor with the repo's formatter, or run it before every commit.
- **Pasted text in code** (markdown blocks inside a source file): review `git diff` before running the suite.
- **Tool caches with the wrong owner** (created by root inside a container) cause write errors with no apparent relation. Delete the cache.

## Environment and deployment

- **Local ports and URLs:** the app's configured URL is not always the one the container serves. Verify the real port before pointing the client at the local server.
- **The client's `.env` may point to staging** without anyone noticing. Check it before testing against the local server.
- **Debug mode in staging or production** exposes SQL and values in errors. Verify it is off in every deployed environment.
- **Per-branch deploy aliases:** they are not registered in the identity provider or in CORS. Always use the environment's canonical URL.
- **Identity-provider test tokens** (machine to machine) do not carry user claims. To test roles, use a real token copied from the browser request.
- **Non-POSIX shells** (fish, PowerShell) interpret redirection and flags after an argument differently. Put flags before the name, and read secrets with the shell's hidden-input command, never pasted on the command line.

## Management and documentation

- **The import ID is not the board key.** Use only the key verified in `key-map.md`.
- **Never re-import a batch.** After a partial success, create only what is missing.
- **Board connectors down:** if the session cannot write to the board, note in the handoff what remains pending on the human side. Do not treat it as synced.
- **Documentation merges:** compare the result with both parents, because duplicated sections can reappear.
- **Mark a temporary solution as temporary** in the spec and in the handoff, with the ticket that replaces it. Otherwise it becomes permanent.
- **External documents (thesis, contract) carry drift** when the ADR corrects a version or a tool. List what is pending to carry over in `CLAUDE.md` (§6) until it is fixed.
