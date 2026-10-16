# Handoff v1 — Bridge Traducciones

**Date:** 2026-10-16 · **Sprint:** none yet (pre-roadmap) · **Repo:** <https://github.com/Cheboy04/Bridge_WebPage> (public, empty, nothing pushed yet)
**Session focus:** brand kit → design direction → final logo → architecture → clickable prototype v2 with six signature components. Stopped right before **Phase 0 (lock)** of the build plan.

> First handoff, so there is no predecessor. The session ran 2026-10-15 → 2026-10-16 with Opus as planner/reviewer and Sonnet/Haiku subagents as workers. Local folder: `~/Projects/Bridge`. **Nothing is committed and git is not initialised** (see §8 step 1).
> Docs language: this handoff is in English because every project doc so far is in English. The sdd-kit templates are in Spanish. `IDIOMA_DOCS` is decided in the kit's Phase 0 interview (§8 step 2).

---

## 1. Executive state

- **Brand direction "Puente" is chosen** (light Documento mode for legal/certified work, dark Cabina mode for interpreting). The system spec is written in `brand/DIRECTION.md`.
- **Final logo is produced:** M1 refresh plus the M5 app icon, with 7 language lockups and the favicon set (`brand/logo/`). **The certification stamp is still open.**
- **Architecture is decided:** Laravel 12 + Filament 5 on Hostinger Business, Spanish-only MVP that is i18n-ready (`docs/ARCHITECTURE.md`). The deploy approach was refined after Hostinger research (§3, D12).
- **Prototype v2 is built and published:** 8 static pages in Spanish, all six signature components, 0 axe violations, no horizontal overflow at 390 or 1440, and 0 console errors on every page. The client liked it: "the site has way more life to it", "it does feel like one brand".
- **Next:** adopt the sdd-kit (fill its templates from this handoff), then Phase 0: lock the components (design, behavior and code contracts) into a brand book.

## 2. Tracker

No tracker yet. The GitHub repo exists, so GitHub Issues/Projects is the natural candidate. That is decided in the kit interview (§8 step 2). Nothing was written to any board.

## 3. Decisions of the session

Each decision names its **owner document**. When the kit's ADR is filled, these become numbered `Dx.y` entries. Until then the owner doc rules. "Accepted by default" means I proposed it, said it was the default, and the client went on without objecting. Confirm those once.

| # | Decision | Why | Owner doc | Status |
|---|---|---|---|---|
| 1 | **Brand direction "Puente".** Two modes joined by one blue and one dotted trail. *Documento* (light) covers certified/legal, quote, contact, about, FAQ and every form. *Cabina* (dark) covers interpreting, events and equipment. | Client weights legal and event audiences **equally**. Rejected alternatives were "Sello" (legal-forward) and "Cabina" (event-forward). | `brand/DIRECTION.md` §1–2 | Client chose C |
| 2 | **Logo = M1 "Refresh fiel" plus M5 monogram as app icon/favicon.** The globe-B is still the first letter of "Bridge", the wordmark is Manrope 800 outlined, the trail is **white in every version**, and the dark-surface disc is `#2B76C6` (3.35:1 on Tinta). | The client asked for a refresh, not a reinvention. Amber dots on a blue disc fail contrast (2.1:1), so the trail stays white. | `brand/logo/LOGO.md` | Approved |
| 3 | **Certification stamp is OPEN.** Five options exist (S1 dotted ring, S2 classic circular seal, S3 rectangular notarial with fields, S4 monoline, S5 arch). The recommendation is S2 as the official seal plus S3 as the working stamp. The prototype uses a provisional S1-based seal. | Client: "leave it open but I like those ideas". | `brand/explore/logo-options.html` | **Open** |
| 4 | **Naming.** "Bridge" is fixed and the descriptor localizes: Traducciones / Translations / Traductions / Traduções / Übersetzungen / Переводы / Μεταφράσεις. The slot is sized for "Übersetzungen". | Spanish-primary Ecuadorian business whose name must work in many languages. | `brand/logo/LOGO.md` | Approved |
| 5 | **Palette and contrast rules.** Bridge blue `#1C61AD`, Profundo `#12489F`, Tinta `#0E2440`, Bruma `#F4F6F9`, Rastro amber `#E3A148` (**only on dark surfaces**, 2.2:1 on white), Grafito `#556274` (replaces logo grey `#808285`, which fails at 3.85:1). Cabina buttons use `#6BA6E8` with a Tinta label, because Bridge blue on Tinta is 2.5:1. Every text pair is at least 4.5:1. | Computed WCAG ratios; full tables in the owner doc. | `brand/DIRECTION.md` §2 | Approved with the direction |
| 6 | **Type: Literata (display, h1–h3) + Manrope (everything else).** | Verified via the Google Fonts CSS API that both ship Latin-ext, Cyrillic and Greek. **Fraunces was rejected** because it has no Cyrillic or Greek. | `brand/DIRECTION.md` §3 | Approved |
| 7 | **Voice:** usted in prose, infinitive verbs on buttons. Primary CTA "Solicitar cotización". Tagline "Documentos exactos. Voz en vivo." **Hero hook H1:** "Del original a la firma. Del orador al oído.", with the keyword line "Traducción certificada e interpretación simultánea en Quito" inside the h1 at a smaller size. Claims policy: only verifiable numbers. | Legal and corporate Ecuadorian audience. The hook maps onto the two hero states. | `brand/DIRECTION.md` §8, `brand/SIGNATURE-COMPONENTS.md` §1 | **Accepted by default.** The two alternative hooks were "Que nada se pierda entre idiomas." and "Su documento, válido en otro idioma. Su evento, entendido en todos." |
| 8 | **Shape revised to be "less square":** radius tokens are sm 8, md 14, lg 24 and full (buttons, chips, WhatsApp, segmented controls). "Fewer boxes" rule: at most one boxed card grid per page. | Client found the components "closed and common". The brand is built on circles (globe, dots). | `brand/DIRECTION.md` §5 | Approved |
| 9 | **Six signature components** that "make the invisible service visible": (1) dual hero Documento/Evento, (2) language-pair checker that pre-fills the quote form, (3) event planner that feeds the event quote form, (4) before/after certified-document slider, (5) living scroll trail, (6) multilingual footer with a cycling descriptor and an outline wordmark. One signature moment per page. Complete at rest. Reduced-motion fallbacks. No animation libraries. | Client wanted a hook and storytelling, inspired by expertweb.com.ec. Only its principles are borrowed, not its look. It is also a Quito company with navy + amber branding. | `brand/SIGNATURE-COMPONENTS.md` | Client: "I like all 6" |
| 10 | **Footer outline wordmark** is a decorative variant: footer only, on Tinta, never the identifying logo. | Reviewed and kept. | `brand/logo/LOGO.md` (last section) | Approved by the lead |
| 11 | **Stack:** a single Laravel 12 app with Filament 5 at `/admin` (needs PHP 8.2+, Laravel 11.28+, Tailwind 4.1+, verified on context7). Blade + Tailwind 4 + Livewire + Alpine. MySQL. Minimal packages: `spatie/laravel-translatable` and `spatie/laravel-sitemap`. | The client builds the site; the Bridge team edits content (blog, clients, services) in a CMS. | `docs/ARCHITECTURE.md` §2 | Approved |
| 12 | **Hosting: Hostinger Business (shared).** Deploy option **A**: GitHub Actions runs tests, `composer install --no-dev` and the Vite build, uploads a release folder over SSH, swaps a symlink, then runs `migrate --force` and `optimize`. The database queue is driven by an every-minute cron (`schedule:run` → `queue:work --stop-when-empty`). A staging subdomain comes first. | Researched 2026-10-16. Restricted SSH (no root). hPanel Git auto-deploy **only pulls code** and does not run Composer, the build or migrations. `npm` **cannot run over SSH**. Node.js apps on Business are irrelevant to us. Approximate limits: 2 CPU, 3 GB RAM, 600k inodes, 360 s PHP execution. | `docs/ARCHITECTURE.md` §9 (**needs updating with option A details**, see §7 Drift) | Client: "I like the plan" |
| 13 | **i18n:** Spanish-only MVP, but nothing may block more languages. Translatable JSON columns from day one. Spanish URLs at the root with no prefix; future locales get a prefix (`/en/...`). | Client first said "English MVP". When asked, they chose **Spanish only**, because local clients search in Spanish. | `docs/ARCHITECTURE.md` §5 | Approved |
| 14 | **Leads:** floating WhatsApp button (plain `wa.me` link with a pre-filled message per page, hidden on quote forms). Phone and email always visible. Three forms: quick contact, translation quote with upload, interpreting quote. Uploads go to a private disk, are never emailed, and are deleted after **90 days** (period to be confirmed by Bridge). | Clients quote today by WhatsApp, email and phone. Ecuador's LOPDP applies. | `docs/ARCHITECTURE.md` §6–7 | Approved, retention period open |
| 15 | **Build plan:** Phase 0 Lock → 1 Skeleton → 2 Data → 3 Admin → 4 Public site (visual parity with the prototype) → 5 Leads (TDD on the planner and language rules) → 6 Hardening → 7 Ship to staging, then live with 301s. | Agreed 2026-10-16. | This handoff §8. Moves to `docs/backlog/roadmap.md` at the kit fill. | Approved |
| 16 | **"Locked" means three layers:** design (tokens plus component anatomy and states, in a brand book built with the claude.ai "Design System" artifact type), behavior (exact timings, a11y and rules in `SIGNATURE-COMPONENTS.md`), and code (a component contract: params become Blade props, plus the data source and events/query params). The prototype stays the reference implementation, and production Blade is written once in Laravel. Also a **placeholder register** listing everything Bridge must supply. | Answer to the client's question "design? or animations/code too?" | This handoff | Approved |
| 17 | **Workflow:** Opus plans, writes specs, integrates and reviews visually. Sonnet workers build in parallel with **strict file ownership**. Haiku does mechanical work. Adopt **sdd-kit** (`~/Projects/sdd-kit`) as the methodology. The recommended roles mode is **B** (agent implements, human approves the spec and reviews the diff), to be confirmed in the kit interview. | The client asked for orchestration from the start and uses sdd-kit. | `CLAUDE.md` + `docs/global/metodologia-sdd-tdd.md` once filled | Approved, mode to confirm |
| 18 | **The repo is public,** so the kit's "no real client data" rule applies. `.gitignore` keeps raw client material, research captures and anything with real phones, addresses or identifiable people local. | `GUIA-ESTILO-DOCS.md` §8. | `.gitignore` | Applied. **The client should consider making the repo private** (see §8 step 1). |

## 4. Evidence

- **Prototype v2** (`prototype/`): `npm run build` passes, then `node check.mjs index traduccion-certificada interpretacion-simultanea cotizacion cotizacion-traduccion cotizacion-interpretacion cotizacion-gracias componentes`.
  - Results: 16/16 page×width runs with axe-core 4.10.2 at **0 violations**, scrollWidth equal to the viewport, and 0 console errors.
  - Known noise: "small target" warnings on 24px native checkboxes. Their labels are 44px tall.
- **Scripted interaction tests** were run by the workers. All passed:
  - Hero: arrow-key tabs, channel caption plus `aria-pressed`, tab restored after reload.
  - Checker: supported, unlisted and same-language states, swap, CTA href.
  - Slider: keyboard and End/Home.
  - Planner: 4 hand-computed cases, e.g. hybrid, 2 days, 2 languages, 300 attendees gives 6 interpreters, 2 booths, 330 receivers, platform and 1 technician.
  - Both quote forms: empty submit focuses the error summary, a valid submit reaches the thank-you page, pre-fill works and junk values are ignored.
  - **These test scripts lived in the session scratchpad and are gone.** Only `prototype/check.mjs` (axe, overflow, console and screenshots) is in the project.
- **Logo:** every SVG passes xmllint and svgo 3.3.2. There is no live `<text>`; everything is outlined from Manrope.
- **Hero translations checked by the lead:** EN "The parties agree to the terms of this contract." / FR "Les parties conviennent des termes du présent contrat." / PT "As partes concordam com os termos do presente contrato." Bridge's translators still need to sign them off.
- **Not done:** no C3 mutation testing (no production code exists yet), no CI, and no Laravel code.

## 5. Files of the session

All files were written by agents. The client wrote none.

| Path | What |
|---|---|
| `Design_references/` | Client-provided raw assets: 2010 logo `.ai` (PDF-compatible, true vector), PNG logos, 2019 event photos, AI images, flyers, svgrepo icons. **Git-ignored.** |
| `audit/audit-A-ux.md`, `audit-B-visual.md`, `audit-C-positioning.md` | The three audits through the requested skill lenses (impeccable + ui-ux-pro-max; high-end-visual-design + design-taste-frontend; gpt-taste + ui-ux-pro-max). |
| `audit/inventory.md`, `sites-capture.md`, `sites-computed*.json`, `screens/`, `reference/`, `logo-source.*` | Asset inventory, captures of the old and demo sites, expertweb reference screenshots, logo export. **Git-ignored** because they contain real contact data or third-party captures. |
| `audit/directions.src.html` | Source of the 3-direction comparison page (the built `directions.html` embeds a photo and is git-ignored). |
| `brand/DIRECTION.md` | **Puente system spec**: brand idea, modes, color roles with contrast tables, type, trail device, shape (revised), imagery, icons (Lucide), voice, motion (revised), trust kit, open questions. |
| `brand/SIGNATURE-COMPONENTS.md` | Spec of the six signature components, shared rules, and the file-ownership table used for the build. |
| `brand/explore/logo-options.html` (+ screenshots) | M1–M6 and S1–S5 exploration sheet. |
| `brand/logo/` | **Final logo kit:** `symbol/` (4), `lockup/` (28 language×variant + 4 wordmarks), `app/` (icons, favicons, maskable, `.ico`), `LOGO.md`, `logo-sheet.html`, previews. |
| `docs/ARCHITECTURE.md` | Site architecture: constraints, stack, sitemap, content model, i18n, leads, privacy, SEO, hosting, deferred list, prototype scope, client open items. |
| `prototype/` | Static prototype. `src/components/*.html` (include partials whose params map to future Blade props), `src/pages/*.html` (8 pages), `src/styles/app.css` (tokens and modes) + `sig-documento.css` + `sig-cabina.css`, `src/assets/js/` (`sig-hero.js`, `sig-documento.js`, `sig-cabina.js`, `quote-form.js`, `event-quote-form.js`), `src/assets/data/languages.json` (example data, also inlined in the checker component), `build.mjs` (include engine), `check.mjs` (axe and screenshots), `publish/cover.html` + `publish/build-publish.sh` (artifact staging). |
| sdd-kit templates (copied 2026-10-16, **unfilled**) | `CLAUDE.md` (with a banner), `{{CAPA}}/`, `.github/PULL_REQUEST_TEMPLATE.md`, `docs/global/*` (methodology, git rules, lessons, handoff/runbook templates, style guide), `docs/adr/decisiones-tecnicas.md`, `docs/erd/`, `docs/specs/PLANTILLA-SPEC.md`, `docs/backlog/*`. |
| `.gitignore` | Public-repo hygiene (decision 18). |
| Memory | `~/.claude/projects/-home-cheboy04-Projects-Bridge/memory/bridge-brand-decisions.md` (auto-loaded summary). |

**Published artifacts** (private to the client's claude.ai account):

| Artifact | URL |
|---|---|
| Directions + audit summary | <https://claude.ai/artifact/TqSFFmbR8vrCgp3JQuUqAB> |
| Logo and stamp options | <https://claude.ai/artifact/DiHXKekY9xTi7owU3VbUpz> |
| Final logo sheet | <https://claude.ai/artifact/7RrjAQFpaBYmUNYmxzKXYM> |
| **Prototype (v2, current)** | <https://claude.ai/artifact/CiF49DJxMLpuuL3QDxbRAm> |

## 6. Operational traps

1. **GateGuard hook (ECC).** *Symptom:* the first Bash call, and the first Edit/Write of every file, is rejected with "Fact-Forcing Gate". *Cause:* the ECC `gateguard-fact-force` hook. *What to do:* state the requested facts in plain text, then retry the same call. Facts given in the same parallel batch don't count, so send the facts first and the call after. Options to relax it: `GATEGUARD_EXEMPT_GLOBS` for `docs/**` and `prototype/**`, or `GATEGUARD_BASH_ROUTINE_DISABLED=1`. That is the client's choice.
2. **The shell is zsh, not fish,** even though the environment says fish. *Symptoms:* fish syntax (`for …; end`) fails, unmatched globs abort the command (`no matches found`), and `echo =====` fails (`=` expansion). *What to do:* use bash/zsh syntax, quote `--include=*.md` or avoid it, and don't start an echo argument with `=`.
3. **Playwright MCP can't find Chrome** (`/opt/google/chrome/chrome` is missing). *What to do:* drive the cached Chromium directly with `require('/home/cheboy04/.npm/_npx/e41f203b7505f1fb/node_modules/playwright')` and `executablePath: ~/.cache/ms-playwright/chromium-1234/chrome-linux64/chrome`. `prototype/check.mjs` already does this.
4. **The old site (bridge-traducciones.com) is behind a "Checking your browser" bot challenge.** *What to do:* `waitForFunction(() => !document.body.innerText.includes('Checking your browser'))` with a desktop user agent and `--disable-blink-features=AutomationControlled`.
5. **Google Fonts subset check:** the CSS2 API only returns `/* cyrillic */`-style subset comments to a full Chrome user agent. Short UAs return nothing.
6. **Parallel workers.** Give each one strict **file ownership** and name the files exactly. Create shared stubs (e.g. `sig-*.css` plus their `@import` lines) **before** launching anyone, so the build never breaks mid-run. Expect class-name collisions between worker CSS: `.seg` collided and W1 renamed its version to `.hseg`. Prefix component classes.
7. **Worker screenshots go stale.** A worker's last CSS tweak often lands after its last screenshot. Re-shoot before judging. The planner looked broken in a stale shot but was fine.
8. **Full-page screenshots and scroll animations.** `check.mjs` forces `prefers-reduced-motion` for full-page captures, otherwise scroll-driven elements render mid-animation. It writes one extra motion-allowed shot (`index-process-motion-1440-v2.png`).
9. **Artifact publish:** the main page must have no doctype/html/head/body, and a multi-page prototype needs relative links. Use `prototype/publish/build-publish.sh <out-dir>`, then publish `<out-dir>/index.html` with `root=<out-dir>` and every other file in `files` to the **same** URL (verified: it reproduces the v2 file set exactly). A new session must first `read` the artifact URL before republishing to it.
10. **`clip-path` handle clamping:** a knob nested inside a 2px line can't be clamped with `%`. The fix uses `container-type: inline-size` on the stage and `cqw` units (`sig-documento.css`, `.ba-knob`).
11. **Contrast traps** found by computation, not by eye: amber on white 2.2:1, amber on Bridge blue 2.8:1, Bridge blue on Tinta 2.5:1, `#808285` on white 3.85:1. Always compute the ratio.

## 7. Drift detected

| Drift | Owner | Fix |
|---|---|---|
| `docs/ARCHITECTURE.md` §9 describes the deploy only loosely ("GitHub Actions → SSH (`git pull` …)"). Decision 12 refined it: CI builds the release, uploads it, swaps a symlink, and the server never runs `git pull` or `npm`. | ADR, once filled | Write D12 in the ADR and correct ARCHITECTURE §9 or replace it with a reference. |
| `docs/ARCHITECTURE.md` vs the kit ADR (`docs/adr/decisiones-tecnicas.md`). Both will hold technical decisions. | ADR (kit rule: one owner per fact) | At the kit fill, move the decisions into the ADR as `Dx.y`. Keep ARCHITECTURE.md only as an overview that links to the ADR, or delete it. |
| `brand/DIRECTION.md` §11 open questions overlap ARCHITECTURE §12 and §3 here. | Placeholder register (Phase 0) | Merge into one register. |
| Older artifacts (directions, logo options) show the old 4/8px radius and amber trails on light surfaces. | `DIRECTION.md` (current) | Historical. Don't update them; say so if they are shown to someone. |
| The `CLAUDE.md` root template sets Spanish docs (`{{IDIOMA_DOCS}}`), but every project doc is English. | Kit interview | Decide the language, then either translate or set `IDIOMA_DOCS=English`. |

## 8. Next steps (in dependency order)

1. **Git and repo visibility (client).** The repo is **public**. `.gitignore` already keeps client raw material out. But the prototype ships the interim booth photo (`prototype/src/assets/photo/cabina-*.webp`, identifiable interpreters at a 2019 event, consent unknown), and `brand/` carries the client's logo. **Recommendation: make the repo private.** Otherwise replace the photo before the first push. Then:
   ```bash
   cd ~/Projects/Bridge
   git init -b main
   git add .
   git status   # review: no Design_references/, audit/screens/, node_modules/, dist/
   git commit -m "chore: brand kit, prototype v2 and sdd-kit templates"
   git remote add origin git@github.com:Cheboy04/Bridge_WebPage.git
   git push -u origin main
   ```
   Commit message attribution follows the client's git rules once `docs/global/reglas-git.md` is filled.
2. **Fill the sdd-kit** with `~/Projects/sdd-kit/PROMPT-RELLENADO.md` (phases 0–3 at least; phases 4–6 can follow Phase 0 Lock). Proposed answers for the interview, to be confirmed by the client:
   - **TOPOLOGIA:** `solo-backend` variant, i.e. one Laravel monolith with the stack in `CLAUDE.md` §7. **Open:** Laravel at the repo root or in `site/`. Recommendation: `site/`, keeping `brand/`, `prototype/` and `docs/` beside it, with CI `working-directory: site`.
   - **MODO_ROLES:** B. **PROYECTO:** Bridge Traducciones (website). **CLIENTE:** Bridge Traducciones (Quito). **EQUIPO:** the client (owner/dev) plus agents.
   - **TRACKER:** GitHub Issues? (ask). **VISIBILIDAD_REPO:** public or private (step 1). **RAMA_PRINCIPAL:** `main`. **RAMA_INTEGRACION:** `develop`? (ask).
   - **IDIOMA_DOCS:** ask (the project is English so far). **IDIOMA_CODIGO:** English. **IDIOMA_UI:** Spanish.
   - **Tooling:** Pest, Larastan, Pint, `composer.lock`, `package-lock.json`.
   - **SERVICIOS_EXTERNOS:** Hostinger (hPanel, DNS, mail), GitHub, Google (GA4).
   - **HERRAMIENTA_BUSQUEDA:** codebase-memory-mcp or graphify. Both are installed for the client.

   During phase 2, migrate decisions 11–14 and 16–18 into the ADR, and record the open points (stamp, retention period, hosting checks, repo layout).
3. **Phase 0: Lock.**
   - **(a)** Brand book via the Artifact tool. Run `quickstart` with intent "other" and use the **Design System** type. Contents: tokens from `prototype/src/styles/app.css`, components with live previews (from `componentes.html`), logo rules, photography, voice ES/EN.
   - **(b)** Component contracts: for each component in `prototype/src/components/`, list params → Blade props, data source (CMS model, Settings or config) and events/query params.
   - **(c)** Update `SIGNATURE-COMPONENTS.md` with the exact timings and easing from the shipped code.
   - **(d)** Placeholder register: one list of everything Bridge must supply (see below).
   - **(e)** Polish carried over: "Jornada completa" wraps inside the planner's duration control at 1440; the logo trail dots read slightly understated at large sizes (offered, no answer); the footer wordmark is very large at desktop (kept, could cap its `max-width`).
4. **Phases 1–7** per decision 15. Before Phase 7 the client must:
   - Enable SSH in hPanel.
   - Run `php -v; composer -V; which php` over SSH, so the cron command uses the exact PHP path.
   - Check the plan limits in hPanel → Details (Hostinger labels tiers inconsistently).
   - Confirm the cron minimum interval for the plan.
   - Add a deploy key.

**Placeholder register (seed list, all still unanswered by Bridge):**
- **Contact and identity:** canonical domain (`bridgetraducciones.com` vs `bridge-traducciones.com`), real phones, WhatsApp number, emails, address, office hours.
- **Claims:** founding year and verifiable stats (sources disagree: 16 vs 17+ years, 500+ vs 750+ clients).
- **Credentials:** ATA scope (individual certification or corporate membership) and badge permission.
- **Legal:** wording for certified translations (ATA alone gives no legal standing in Ecuador), privacy policy text and the attachment retention period (90 days proposed).
- **Catalogue:** launch service list per hub, language list with services per language, turnaround times.
- **Planner rules:** 2 interpreters per language, ×1.5 above 6 h, receivers = attendees + 10%, 1 technician per room, half day ≤ 6 h, full day about 8 h, booking lead time "4–6 weeks".
- **Assets and approvals:** client logo permissions, a photo shoot (real booth and redacted certified documents), translator sign-off on the hero translations, stamp choice, home order (Documento first is the current default).

## 9. How to resume the environment

- **Prototype:** `cd ~/Projects/Bridge/prototype && npm install && npm run build`. Serve with `npm run serve` (port 4173). Check with `node check.mjs <page …>`.
- **Republish the prototype:** `bash publish/build-publish.sh <tmp-dir>`, then the Artifact publish described in §6 trap 9.
- **Skills used:** taste-skill (`gpt-tasteskill`, `high-end-visual-design`, `design-taste-frontend`), `impeccable`, `ui-ux-pro-max`, `ecc:design-system`, `ecc:plan`. Load the relevant ones in briefs to workers.
- **Model routing the client asked for:** Opus thinks, plans and reviews. Sonnet builds (UI, pages, components). Haiku captures and does mechanical tasks.
