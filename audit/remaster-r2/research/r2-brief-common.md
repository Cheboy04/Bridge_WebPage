# R2 research: what makes a type-and-document-led service site great

## Why this round exists

The owner on R1, Codex's run of this skill: "it didn't change much of the prototype." R1 (BRG-68) raised the hero, the Cabina heading and the close to monument type, but every middle chapter of both pages is still heading-left, rows-right at body scale on white or pale grey (`../before/home/scroll-03`–`scroll-17`, `../before/certified-translation/scroll-02`–`scroll-20`). R1's research was one track of seven sites, mostly law firms; its lab ran no experiment; its motion stayed "polite". See `../r1-review.md`.

The owner's taste, in their words on another project: "simple can be great if we have sufficient variance, taste and subtlety in the animation. Great layouts, layering, animation and coloring make a site great." Green meters do not count as success.

Client: Bridge Traducciones, Quito, Ecuador. Two services with equal weight: certified document translation (Documento) and simultaneous/consecutive interpreting with booths and equipment (Cabina). Proof is thin and mostly placeholder (ATA membership to confirm, no client logos yet). Spanish-first, multilingual audience.

Current brand: white, Bruma `#F4F6F9`, Tinta `#0E2440`, Bridge blue `#1C61AD`, amber trail `#E3A148` (dark grounds only). Literata (display serif) + Manrope (UI sans). A dotted source→target trail is the brand device. Full rules: `brand/DIRECTION.md`.

**Hard constraint:** almost no photography. One real booth photo. No real document photos (client data; public repo). No logos, no stats. Whatever wows must come from type, colour fields, layout, layering, document-like material built in HTML/CSS, the trail, motion, and possibly honestly disclosed generated/abstract imagery.

**Stack constraint for the build (not for research):** static HTML/CSS + vanilla JS; no animation library or JS framework (ADR D3.7). A move that needs GSAP is still worth recording if it can be done with CSS scroll-driven animations, View Transitions, IntersectionObserver or a few lines of JS; say which.

Project root: `/home/cheboy04/Projects/Bridge`. Skill directory: `/home/cheboy04/Projects/BridgeV2/agent-agnostic-skills/wow-direction`. Library: `/home/cheboy04/Projects/BridgeV2/agent-agnostic-skills/library`. Current captures: `audit/remaster-r2/before/{home,certified-translation}/`.

## Evidence lens

Answer for every site or shot:

1. The memorable moment and why it works.
2. Type: scale relative to viewport, contrast, identifiable faces, measure, case, tracking, and how it meets imagery.
3. Layering: overlaps, sticky sheets, crossings, cut-outs, parallax, masks, and clip paths.
4. Motion: trigger, property, duration/easing when observable, feel, arrival, transition, scrolling, cursor, and hover.
5. 3D/WebGL: only what source or runtime evidence confirms.
6. Colour and field: chapter grounds, accent, grading, grain, and texture.
7. Layout variance across the first five screens. **Especially: how the middle of the page (lists, process, proof, FAQs, services) avoids "heading left, rows right" repeated.**
8. Subtle craft: easing, stagger, reveals, crops, captions, counters, navigation, and close.
9. What survives or changes at 390 px.
10. What transfers to Bridge given no photos, a serif + sans pair, two modes and a dotted trail; what would be wrong (luxury theatre, SaaS gloss, fake proof).

Use facts visible in captures, runtime evidence, or source. Otherwise write `not determinable`. Name a library only when the fetched source or runtime confirms it.

## Capture method

Environment (set in every shell):

```bash
export PLAYWRIGHT_PATH=/home/cheboy04/.npm/_npx/e41f203b7505f1fb/node_modules/playwright
export CHROMIUM_PATH=/home/cheboy04/.cache/ms-playwright/chromium-1234/chrome-linux64/chrome
SK=/home/cheboy04/Projects/BridgeV2/agent-agnostic-skills/wow-direction
```

- `node $SK/capture.mjs <url> <outdir> --frames 16 --step 700` (add `--click "<safe selector>"` for one transition). Wrap in `timeout 240`.
- Motion: `timeout 300 node $SK/motion-probe.mjs <url> <outdir>/motion` then `python3 $SK/motion-sheet.py <outdir>/motion`. Run it on at least three sites per track whose motion matters.
- Close consent banners. Visit one relevant page; do not crawl or submit forms. Skip a site after two failed attempts and record it.
- **Look at your own frames** (open `sheet.png` and the key `scroll-NN.png`) before writing about a site. Never describe a move you have not seen in a frame.
- The shell is zsh-like: arrays and word-splitting differ; wrap loops in `bash -c '…'`.

## Optional specialist guidance

Available skills worth reading if useful: `taste-skill:design-taste-frontend`, `impeccable`, `ecc:motion-patterns`, `ecc:frontend-design-direction`. Missing skills never block research.

## Output and boundaries

- Write only beneath your assigned folder. Third-party frames go under `audit/remaster-r2/inspiration/<track>/` (git-ignored); your report goes to `audit/remaster-r2/research/<track>-report.md`.
- **No git commands. No edits to `prototype/`, `brand/`, `site/`, `docs/`, the library or the skill.** No global or privileged installs.
- Preserve source URLs. Never invent facts or URLs.
- Save the report incrementally (write it after each site), so a crash keeps evidence.

## Report

1. Sources searched; candidate list with kept/dropped reasons.
2. One section per kept source answering the lens, with frame paths.
3. Five to eight recurring techniques, ranked, with at least two examples each where available, each marked `css-only`, `small-js` or `needs-library`.
4. The five largest gaps against the current Bridge captures.
5. Optional skill rules that materially changed the analysis.
6. Failed, blocked, or not done items.
