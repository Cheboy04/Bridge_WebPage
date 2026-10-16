// Tiny static build: <!-- @include name key="value" --> + {{placeholders}} -> dist/
// Placeholder forms: {{k}} required | {{k|default}} | {{k?|text, @=value}} if set | {{k==v|text}} if equal
import { readFileSync, writeFileSync, readdirSync, mkdirSync, rmSync, cpSync } from 'node:fs';
import { execFileSync } from 'node:child_process';

const read = (f) => readFileSync(f, 'utf8');
const fail = (m) => { console.error('BUILD FAILED: ' + m); process.exit(1); };

function fill(html, p, where) {
  return html.replace(/\{\{([\w-]+)(?:(==|\?)([\w-]*))?(?:\|([^}]*))?\}\}/g, (_, k, op, v, rest) => {
    if (op === '==') return p[k] === v ? rest : '';
    if (op === '?') return p[k] ? rest.replaceAll('@', p[k]) : '';
    if (p[k] !== undefined) return p[k];
    if (rest !== undefined) return rest;
    return fail(`unreplaced {{${k}}} in ${where}`);
  });
}

function render(html, where, depth = 0) {
  if (depth > 6) fail('include depth exceeded in ' + where);
  return html.replace(/<!--\s*@include\s+([\w-]+)([\s\S]*?)-->/g, (_, name, attrs) => {
    const file = `src/components/${name}.html`;
    let src;
    try { src = read(file); } catch { return fail(`missing include "${name}" in ${where}`); }
    const p = {};
    for (const m of attrs.matchAll(/([\w-]+)="([^"]*)"/g)) p[m[1]] = m[2];
    return render(fill(src, p, file), file, depth + 1);
  });
}

rmSync('dist', { recursive: true, force: true });
mkdirSync('dist/assets', { recursive: true });
cpSync('src/assets', 'dist/assets', { recursive: true });
for (const f of readdirSync('src/pages').filter((f) => f.endsWith('.html'))) {
  const out = render(read('src/pages/' + f), f);
  const left = out.match(/\{\{[\w-]+[^}]*\}\}/);
  if (left) fail(`unreplaced ${left[0]} in ${f}`);
  writeFileSync('dist/' + f, out);
}
execFileSync('node_modules/.bin/tailwindcss', ['-i', 'src/styles/app.css', '-o', 'dist/assets/app.css', '--minify'], { stdio: 'inherit' });
console.log('built dist/');
