#!/usr/bin/env bash
# Batch "initial" of the Bridge backlog (generated 2026-10-16 from docs/backlog/backlog.md).
# Usage:  bash initial.sh sample   -> labels, milestones, epic infra + brg-31 as its sub-issue. Check them on GitHub.
#         bash initial.sh rest     -> everything else. Safe to re-run: IDs already in keys.tsv are skipped (never re-created).
# Needs: gh authenticated with write access to the repo. Run from this folder.
set -euo pipefail
REPO="Cheboy04/Bridge_WebPage"
MODE="${1:?usage: initial.sh sample|rest}"
KEYS="keys.tsv"; touch "$KEYS"
key() { awk -F'\t' -v id="$1" '$1==id{print $2}' "$KEYS"; }
label() { gh label create "$1" --repo "$REPO" --color "$2" --force >/dev/null; }
milestone() { gh api "repos/$REPO/milestones?state=all&per_page=100" --jq '.[].title' | grep -Fxq "$1" || gh api "repos/$REPO/milestones" -f title="$1" >/dev/null; }
create() { # local_id title milestone labels
  local n; n="$(key "$1")"; if [ -n "$n" ]; then echo "skip $1 (#$n)"; return; fi
  local args=(--repo "$REPO" --title "$2" --body-file "initial/$1.md" --label "$4")
  [ -n "$3" ] && args+=(--milestone "$3")
  local url; url="$(gh issue create "${args[@]}")"; n="${url##*/}"
  printf '%s\t%s\n' "$1" "$n" >> "$KEYS"; echo "created $1 -> #$n"
}
link() { # parent_local child_local
  local p c id; p="$(key "$1")"; c="$(key "$2")"; [ -z "$p" ] || [ -z "$c" ] && return
  id="$(gh api "repos/$REPO/issues/$c" --jq .id)"
  gh api "repos/$REPO/issues/$p/sub_issues" -F sub_issue_id="$id" >/dev/null 2>&1 && echo "linked $2 under $1" || echo "link $2 under $1: already linked or failed, check by hand"
}
if [ "$MODE" = sample ]; then
  label type:epic 5319e7
  label type:story 1c61ad
  label type:task 556274
  label state:official d8e0ea
  label state:pending-decision e3a148
  label batch:initial ededed
  label release:r1 6ba6e8
  label release:r2 12489f
  label layer:site c5def5
  label layer:infra bfd4f2
  label layer:docs fef2c0
  label risk:normal ededed
  label risk:seguridad b3261e
  label risk:datos 8a5300
  label risk:archivos 8a5300
  label risk:infra 7c8a9c
  label local:brg-epic-infra f4f6f9
  label local:brg-epic-content f4f6f9
  label local:brg-epic-site f4f6f9
  label local:brg-epic-signature f4f6f9
  label local:brg-epic-leads f4f6f9
  label local:brg-epic-launch f4f6f9
  label local:brg-epic-quality f4f6f9
  label local:brg-01 f4f6f9
  label local:brg-02 f4f6f9
  label local:brg-03 f4f6f9
  label local:brg-04 f4f6f9
  label local:brg-05 f4f6f9
  label local:brg-06 f4f6f9
  label local:brg-07 f4f6f9
  label local:brg-08 f4f6f9
  label local:brg-09 f4f6f9
  label local:brg-10 f4f6f9
  label local:brg-11 f4f6f9
  label local:brg-12 f4f6f9
  label local:brg-13 f4f6f9
  label local:brg-14 f4f6f9
  label local:brg-15 f4f6f9
  label local:brg-16 f4f6f9
  label local:brg-17 f4f6f9
  label local:brg-18 f4f6f9
  label local:brg-19 f4f6f9
  label local:brg-20 f4f6f9
  label local:brg-21 f4f6f9
  label local:brg-22 f4f6f9
  label local:brg-23 f4f6f9
  label local:brg-24 f4f6f9
  label local:brg-25 f4f6f9
  label local:brg-26 f4f6f9
  label local:brg-27 f4f6f9
  label local:brg-28 f4f6f9
  label local:brg-29 f4f6f9
  label local:brg-30 f4f6f9
  label local:brg-31 f4f6f9
  label local:brg-32 f4f6f9
  label local:brg-33 f4f6f9
  label local:brg-34 f4f6f9
  label local:brg-35 f4f6f9
  label local:brg-36 f4f6f9
  label local:brg-37 f4f6f9
  label local:brg-38 f4f6f9
  label local:brg-39 f4f6f9
  label local:brg-40 f4f6f9
  label local:brg-41 f4f6f9
  label local:brg-42 f4f6f9
  label local:brg-43 f4f6f9
  label local:brg-44 f4f6f9
  label local:brg-45 f4f6f9
  label local:brg-46 f4f6f9
  label local:brg-47 f4f6f9
  milestone 'P0 Lock'
  milestone 'P1 Skeleton'
  milestone 'P2 Data'
  milestone 'P3 Admin'
  milestone 'P4 Public site'
  milestone 'P5 Leads'
  milestone 'P6 Hardening'
  milestone 'P7 Ship'
  create brg-epic-infra 'Infrastructure and delivery' '' type:epic,state:official,batch:initial,local:brg-epic-infra
  create brg-31 'Scaffold Laravel 12 + Filament 5 in site/ with the quality chain and brand tokens' 'P1 Skeleton' type:task,layer:infra,risk:infra,state:official,release:r1,batch:initial,local:brg-31
  link brg-epic-infra brg-31
else
  create brg-epic-content 'Content model and admin' '' type:epic,state:official,batch:initial,local:brg-epic-content
  create brg-epic-site 'Public site' '' type:epic,state:official,batch:initial,local:brg-epic-site
  create brg-epic-signature 'Signature components' '' type:epic,state:official,batch:initial,local:brg-epic-signature
  create brg-epic-leads Leads '' type:epic,state:official,batch:initial,local:brg-epic-leads
  create brg-epic-launch Launch '' type:epic,state:official,batch:initial,local:brg-epic-launch
  create brg-epic-quality 'Quality and acceptance' '' type:epic,state:official,batch:initial,local:brg-epic-quality
  create brg-01 'HU-01 Branded layout: header, footer with multilingual descriptor, WhatsApp button, modes' 'P4 Public site' type:story,layer:site,risk:normal,state:official,release:r1,batch:initial,local:brg-01
  create brg-02 'HU-02 Admin sign-in with admin and editor roles' 'P3 Admin' type:story,layer:site,risk:seguridad,state:official,release:r1,batch:initial,local:brg-02
  create brg-03 'HU-03 Editor manages services' 'P3 Admin' type:story,layer:site,risk:normal,state:official,release:r1,batch:initial,local:brg-03
  create brg-04 'HU-04 Editor manages languages and services per language' 'P3 Admin' type:story,layer:site,risk:normal,state:official,release:r1,batch:initial,local:brg-04
  create brg-05 'HU-05 Editor manages FAQs' 'P3 Admin' type:story,layer:site,risk:normal,state:official,release:r1,batch:initial,local:brg-05
  create brg-06 'HU-06 Editor manages blog posts' 'P3 Admin' type:story,layer:site,risk:normal,state:official,release:r1,batch:initial,local:brg-06
  create brg-07 'HU-07 Editor manages clients and testimonials' 'P3 Admin' type:story,layer:site,risk:normal,state:official,release:r1,batch:initial,local:brg-07
  create brg-08 'HU-08 Editor manages simple pages' 'P3 Admin' type:story,layer:site,risk:normal,state:official,release:r1,batch:initial,local:brg-08
  create brg-09 'HU-09 Admin edits site settings' 'P3 Admin' type:story,layer:site,risk:seguridad,state:official,release:r1,batch:initial,local:brg-09
  create brg-10 'HU-10 Home page gives both services equal weight' 'P4 Public site' type:story,layer:site,risk:normal,state:official,release:r1,batch:initial,local:brg-10
  create brg-11 'HU-11 Translation hub and service pages (Documento)' 'P4 Public site' type:story,layer:site,risk:normal,state:official,release:r1,batch:initial,local:brg-11
  create brg-12 'HU-12 Interpreting hub and service pages (Cabina)' 'P4 Public site' type:story,layer:site,risk:normal,state:official,release:r1,batch:initial,local:brg-12
  create brg-13 'HU-13 About page' 'P4 Public site' type:story,layer:site,risk:normal,state:official,release:r1,batch:initial,local:brg-13
  create brg-14 'HU-14 Blog list and posts' 'P4 Public site' type:story,layer:site,risk:normal,state:pending-decision,release:r1,batch:initial,local:brg-14
  create brg-15 'HU-15 FAQ page' 'P4 Public site' type:story,layer:site,risk:normal,state:official,release:r1,batch:initial,local:brg-15
  create brg-16 'HU-16 Contact page' 'P4 Public site' type:story,layer:site,risk:normal,state:official,release:r1,batch:initial,local:brg-16
  create brg-17 'HU-17 Privacy policy page' 'P4 Public site' type:story,layer:site,risk:normal,state:official,release:r1,batch:initial,local:brg-17
  create brg-18 'HU-18 Hero stage shows a translation and a live channel' 'P4 Public site' type:story,layer:site,risk:normal,state:official,release:r1,batch:initial,local:brg-18
  create brg-19 'HU-19 Language-pair checker with prefilled quote' 'P4 Public site' type:story,layer:site,risk:normal,state:official,release:r1,batch:initial,local:brg-19
  create brg-20 'HU-20 Event planner with prefilled quote' 'P4 Public site' type:story,layer:site,risk:normal,state:official,release:r1,batch:initial,local:brg-20
  create brg-21 'HU-21 Before/after certified document' 'P4 Public site' type:story,layer:site,risk:normal,state:pending-decision,release:r1,batch:initial,local:brg-21
  create brg-22 'HU-22 Living trail' 'P4 Public site' type:story,layer:site,risk:normal,state:official,release:r1,batch:initial,local:brg-22
  create brg-23 'HU-23 Quick contact form' 'P5 Leads' type:story,layer:site,risk:datos,state:pending-decision,release:r1,batch:initial,local:brg-23
  create brg-24 'HU-24 Translation quote with document upload' 'P5 Leads' type:story,layer:site,risk:archivos,state:pending-decision,release:r1,batch:initial,local:brg-24
  create brg-25 'HU-25 Interpreting quote' 'P5 Leads' type:story,layer:site,risk:datos,state:pending-decision,release:r1,batch:initial,local:brg-25
  create brg-26 'HU-26 Lead notifications' 'P5 Leads' type:story,layer:site,risk:normal,state:pending-decision,release:r1,batch:initial,local:brg-26
  create brg-27 'HU-27 Lead inbox' 'P5 Leads' type:story,layer:site,risk:seguridad,state:official,release:r1,batch:initial,local:brg-27
  create brg-28 'HU-28 Attachment retention' 'P5 Leads' type:story,layer:site,risk:archivos,state:official,release:r1,batch:initial,local:brg-28
  create brg-29 'HU-29 Metadata, sitemap, robots and structured data' 'P6 Hardening' type:story,layer:site,risk:normal,state:official,release:r1,batch:initial,local:brg-29
  create brg-30 'HU-30 Analytics only after consent' 'P6 Hardening' type:story,layer:site,risk:normal,state:official,release:r1,batch:initial,local:brg-30
  create brg-32 'CI quality pipeline on GitHub Actions against MySQL' 'P1 Skeleton' type:task,layer:infra,risk:infra,state:official,release:r1,batch:initial,local:brg-32
  create brg-33 'Release deploy to staging (D9.1 option A)' 'P1 Skeleton' type:task,layer:infra,risk:infra,state:official,release:r1,batch:initial,local:brg-33
  create brg-34 'Decide time zone and primary key type (ADR 3.2, 3.5)' 'P1 Skeleton' type:task,layer:docs,risk:normal,state:official,release:r1,batch:initial,local:brg-34
  create brg-35 'ERD slice, migrations and models: content entities' 'P2 Data' type:task,layer:site,risk:datos,state:official,release:r1,batch:initial,local:brg-35
  create brg-36 'ERD slice, migrations and models: Settings and Lead' 'P2 Data' type:task,layer:site,risk:datos,state:official,release:r1,batch:initial,local:brg-36
  create brg-37 'Factories and seeders' 'P2 Data' type:task,layer:site,risk:datos,state:official,release:r1,batch:initial,local:brg-37
  create brg-38 'Error pages 404, 419, 429, 500' 'P4 Public site' type:task,layer:site,risk:normal,state:official,release:r1,batch:initial,local:brg-38
  create brg-39 'Browser check harness for the Laravel site' 'P4 Public site' type:task,layer:site,risk:normal,state:official,release:r1,batch:initial,local:brg-39
  create brg-40 'Accessibility and parity audit of every page' 'P6 Hardening' type:task,layer:site,risk:normal,state:official,release:r1,batch:initial,local:brg-40
  create brg-41 'Performance budget audit' 'P6 Hardening' type:task,layer:site,risk:normal,state:official,release:r1,batch:initial,local:brg-41
  create brg-42 'Security hardening review' 'P6 Hardening' type:task,layer:site,risk:seguridad,state:official,release:r1,batch:initial,local:brg-42
  create brg-43 'Observability: error and uptime monitoring' 'P6 Hardening' type:task,layer:infra,risk:infra,state:official,release:r2,batch:initial,local:brg-43
  create brg-44 'Crawl the old site and write the 301 map' 'P7 Ship' type:task,layer:site,risk:normal,state:official,release:r2,batch:initial,local:brg-44
  create brg-45 'Production launch' 'P7 Ship' type:task,layer:infra,risk:infra,state:official,release:r2,batch:initial,local:brg-45
  create brg-46 'Backups and database rollback runbook' 'P7 Ship' type:task,layer:docs,risk:infra,state:official,release:r2,batch:initial,local:brg-46
  create brg-47 'P0 Lock: brand book, contracts, shipped timings, placeholder register (done before the board)' 'P0 Lock' type:task,layer:docs,risk:normal,state:official,release:r1,batch:initial,local:brg-47
  link brg-epic-site brg-01
  link brg-epic-content brg-02
  link brg-epic-content brg-03
  link brg-epic-content brg-04
  link brg-epic-content brg-05
  link brg-epic-content brg-06
  link brg-epic-content brg-07
  link brg-epic-content brg-08
  link brg-epic-content brg-09
  link brg-epic-site brg-10
  link brg-epic-site brg-11
  link brg-epic-site brg-12
  link brg-epic-site brg-13
  link brg-epic-site brg-14
  link brg-epic-site brg-15
  link brg-epic-site brg-16
  link brg-epic-site brg-17
  link brg-epic-signature brg-18
  link brg-epic-signature brg-19
  link brg-epic-signature brg-20
  link brg-epic-signature brg-21
  link brg-epic-signature brg-22
  link brg-epic-leads brg-23
  link brg-epic-leads brg-24
  link brg-epic-leads brg-25
  link brg-epic-leads brg-26
  link brg-epic-leads brg-27
  link brg-epic-leads brg-28
  link brg-epic-launch brg-29
  link brg-epic-launch brg-30
  link brg-epic-infra brg-32
  link brg-epic-infra brg-33
  link brg-epic-infra brg-34
  link brg-epic-content brg-35
  link brg-epic-content brg-36
  link brg-epic-content brg-37
  link brg-epic-site brg-38
  link brg-epic-site brg-39
  link brg-epic-quality brg-40
  link brg-epic-quality brg-41
  link brg-epic-launch brg-42
  link brg-epic-launch brg-43
  link brg-epic-launch brg-44
  link brg-epic-infra brg-45
  link brg-epic-infra brg-46
  link brg-epic-quality brg-47
fi
echo "Done. Copy keys.tsv into docs/backlog/key-map.md. Then move brg-47 to Done by hand with PR #2 as evidence."
