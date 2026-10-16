#!/usr/bin/env bash
# Stages the prototype for the claude.ai Artifact publish (same URL every time).
# Why: the Artifact's main page must have no <!doctype>/<html>/<head>/<body> skeleton,
# so the real home (dist/index.html, a full document) is renamed to inicio.html and
# publish/cover.html (skeleton-less) becomes the main page.
# Usage: cd prototype && npm run build && bash publish/build-publish.sh <out-dir>
# Then publish <out-dir>/index.html with `root=<out-dir>` and every other file in `files`.
set -euo pipefail
out="${1:?usage: build-publish.sh <out-dir>}"
rm -rf "$out" && mkdir -p "$out"
cp -r dist/. "$out/"
mv "$out/index.html" "$out/inicio.html"
cp publish/cover.html "$out/index.html"
for f in "$out"/*.html; do
  [ "$(basename "$f")" = index.html ] && continue
  sed -i 's/href="index.html"/href="inicio.html"/g; s/href="traduccion.html"/href="#" title="No incluido en el prototipo"/g' "$f"
done
(cd "$out" && find . -type f ! -name index.html | sed 's|^\./||' | sort)
