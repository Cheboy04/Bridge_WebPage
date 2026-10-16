# Reglas de Git ({{PROYECTO}})

<!-- RELLENAR: elige la variante de §1 según el modo de roles de metodologia-sdd-tdd.md §2, y los scopes de §3 según la topología. -->

Documento **global**. Define el modelo de ramas y **qué puede y qué no puede hacer el agente** con el control de versiones.

**Fuente de verdad del ID que nombra ramas y commits:** la clave de la historia o tarea en **{{TRACKER}}** (`{{PREFIJO_TICKET}}-<n>`). Este documento define el _formato_; el ID real sale del tablero.

---

## 1. Qué hace el agente con git

<!-- SI MODO_ROLES=A|C -->
### Regla dura: el agente lee, no escribe

El control de versiones lo ejerce **exclusivamente el equipo humano**. Cada commit es un punto en el que una persona leyó un diff y dijo que sí. Los commits frecuentes son además la red para revertir si algo se cuela, algo todavía más importante si el repo es **público**: un secreto que entra al historial no se borra con un commit más.

| El agente **SÍ** (solo lectura)                               | El agente **NUNCA** (escritura)               |
| ------------------------------------------------------------- | --------------------------------------------- |
| `git status`, `git branch`, `git log`, `git diff`, `git show` | `git commit`, `git add`                       |
| Leer la rama actual para rellenar los comandos de entrega     | `git push`                                    |
| Inspeccionar el historial para guiar mejor                    | `git checkout` / `switch` / `checkout -b`     |
|                                                               | `git merge`, `git rebase`, `git reset`        |
|                                                               | `git tag`, `git branch -d/-D`, `git stash`    |

Si el agente cree que hace falta una operación de escritura, **no la ejecuta**: entrega el bloque de comandos (§4) y se detiene.
<!-- /SI -->
<!-- SI MODO_ROLES=B -->
### El agente escribe en ramas de trabajo, nunca en las protegidas

| El agente **SÍ**                                                    | El agente **NUNCA**                                               |
| ------------------------------------------------------------------- | ----------------------------------------------------------------- |
| Leer (`status`, `log`, `diff`, `show`)                              | Push, merge, rebase o reset sobre `{{RAMA_PRINCIPAL}}` o `{{RAMA_INTEGRACION}}` |
| Crear la rama `feature/…` de la tarea                               | `push --force`, `reset --hard`, borrar ramas remotas              |
| `add` y `commit` en esa rama, con el formato de §3                  | Mergear su propia PR                                              |
| `push` de esa rama y abrir la PR <!-- RELLENAR: borra esta fila si el push lo hace el humano --> | Commitear sin haber revisado el diff en busca de secretos |
<!-- /SI -->

---

## 2. Modelo de ramas: git-flow simplificado

`feature/* → {{RAMA_INTEGRACION}} (staging) → {{RAMA_PRINCIPAL}} (producción, con aprobación manual)`.

| Rama                                       | Rol                                                         | Nace de                 | Vuelve a                                       |
| ------------------------------------------ | ----------------------------------------------------------- | ----------------------- | ---------------------------------------------- |
| `{{RAMA_PRINCIPAL}}`                       | Producción.                                                 | —                       | Solo por PR desde `{{RAMA_INTEGRACION}}`, con aprobación manual |
| `{{RAMA_INTEGRACION}}`                     | Integración / staging. Un merge aquí despliega a staging.   | `{{RAMA_PRINCIPAL}}`    | —                                              |
| `feature/{{PREFIJO_TICKET}}-<id>-<slug>`   | Una historia o tarea.                                       | `{{RAMA_INTEGRACION}}`  | `{{RAMA_INTEGRACION}}` por **Pull Request**    |
| `fix/<slug>`                               | Corrección menor no atada a una historia.                   | `{{RAMA_INTEGRACION}}`  | `{{RAMA_INTEGRACION}}` por PR                  |
| `hotfix/<slug>`                            | Urgencia en producción.                                     | `{{RAMA_PRINCIPAL}}`    | `{{RAMA_PRINCIPAL}}` **y** `{{RAMA_INTEGRACION}}` |

- **Nunca hay `push` directo a `{{RAMA_PRINCIPAL}}` ni a `{{RAMA_INTEGRACION}}`.** Todo entra por PR con al menos 1 review y el CI en verde. Ambas ramas tienen protección (rulesets) con esos requisitos.

<!-- SI TOPOLOGIA=multirepo -->
**Multirepo:** cada repo tiene su propio flujo con los mismos nombres de rama. Una historia que cruza repos usa **el mismo nombre de rama en cada repo** y una PR por repo. Cada PR enlaza a las otras en su descripción.
<!-- /SI -->

---

## 3. Convención de nombres

**Ramas:** `feature/{{PREFIJO_TICKET}}-<id>-<slug>`, con `<slug>` corto en `kebab-case`.

**Commits:**

```
<tipo>(<scope>): {{PREFIJO_TICKET}}-<id> <descripción imperativa breve>
```

- `<tipo>`: `feat` · `fix` · `test` · `docs` · `ci` · `chore`
- `<scope>`: <!-- SI TOPOLOGIA=monorepo -->la capa (`backend` · `frontend` · …), o `docs` para cambios solo de documentación<!-- /SI --><!-- SI TOPOLOGIA=solo-backend|solo-frontend|multirepo -->el módulo funcional (p. ej. `auth`, `artists`), o se omite junto con los paréntesis<!-- /SI -->
- `{{PREFIJO_TICKET}}-<id>`: clave de la historia o tarea en {{TRACKER}}
- Idioma del mensaje: {{IDIOMA_DOCS}}. Se mantiene en todo el historial.

> Ejemplo (Track Studio): `feat(backend): TS-34 responder 403 FORBIDDEN en formato D3.1`, en la rama `feature/TS-34-forbidden-formato-d3-1`.

Este es el **único sitio** donde vive la convención. La plantilla de PR y los `CLAUDE.md` la referencian, no la repiten.

---

## 4. Regla de entrega (obligatoria)

<!-- SI MODO_ROLES=A|C -->
Como el agente no ejecuta git, **cada vez que arranca y cada vez que cierra una tarea entrega un bloque de comandos listo para copiar**, rellenado con la rama y el ID reales (leídos con `git branch` / `git status` y del tablero). Sin ese bloque, la tarea no está entregada.
<!-- /SI -->
<!-- SI MODO_ROLES=B -->
El agente ejecuta los bloques siguientes él mismo y **pega la salida** en su reporte. Antes de cada commit muestra `git diff --stat` y confirma que no hay secretos.
<!-- /SI -->

- **Antes de tocar nada:** informar en qué rama debe estar el trabajo y cómo crearla. Si la rama base no existe o **no se conoce el `{{PREFIJO_TICKET}}-<id>` real**, se dice y se **frena**: no se empieza en la rama equivocada ni se inventa el ID.
- **Al terminar:** bloque de cierre (`add`, `commit` redactado según §3, `push` y apertura de la PR hacia `{{RAMA_INTEGRACION}}`).

### 4.1 Bloques de comandos

**Arrancar una tarea:**

```bash
git checkout {{RAMA_INTEGRACION}} && git pull
git checkout -b feature/{{PREFIJO_TICKET}}-<id>-<slug>
```

**Cerrar una tarea:**

```bash
git add -A
git commit -m "<tipo>(<scope>): {{PREFIJO_TICKET}}-<id> <descripción imperativa>"
git push -u origin feature/{{PREFIJO_TICKET}}-<id>-<slug>
# abrir la PR hacia {{RAMA_INTEGRACION}}
```

**Empecé a trabajar sin rama** (los cambios sin commitear viajan con el `checkout -b`):

```bash
git status                                                # confirmar que NO hay commits, solo cambios sin stage
git checkout -b feature/{{PREFIJO_TICKET}}-<id>-<slug>    # se lleva el trabajo consigo
```

**Guardar trabajo a medias para cambiar de contexto:**

```bash
git stash push -m "{{PREFIJO_TICKET}}-<id> wip"
git stash list
git stash pop
```

**Limpiar después de fusionar la PR:**

```bash
git checkout {{RAMA_INTEGRACION}} && git pull
git branch -d feature/{{PREFIJO_TICKET}}-<id>-<slug>
git push origin --delete feature/{{PREFIJO_TICKET}}-<id>-<slug>
git remote prune origin
```

**Arranque inicial del repo** (una sola vez):

```bash
git checkout {{RAMA_PRINCIPAL}} && git pull
git checkout -b {{RAMA_INTEGRACION}}
git push -u origin {{RAMA_INTEGRACION}}
```

---

## 5. Cuándo commitear y cuándo hacer push

| Momento                                                                              | Acción                                                                |
| ------------------------------------------------------------------------------------ | --------------------------------------------------------------------- |
| Tests en rojo escritos y vistos fallar (fase Red)                                    | `commit` del rojo (`test(…)`): queda como evidencia de C2             |
| Tests en verde y una unidad lógica terminada                                         | `commit` (uno por unidad coherente, no uno gigante al final)          |
| Fin de la tarea, o se quiere respaldo o revisión remota                              | `push`                                                                |
| Tarea completa, AC cubiertos, tests en verde y **probados en rojo** (C3)             | `push` y **PR hacia `{{RAMA_INTEGRACION}}`**                          |
| Nunca                                                                                | `push` directo a `{{RAMA_PRINCIPAL}}` o `{{RAMA_INTEGRACION}}`        |

---

## 6. Trampas registradas

- **ID del tablero, no del archivo de importación.** Si el backlog se importa por CSV, el ID de la fila **no** es la clave que asigna el tablero. Nombrar ramas con el ID del CSV produce colisiones. Las claves vigentes están en [`docs/backlog/key-map.md`](../backlog/key-map.md) y se verifican antes de crear una rama.
- **El CI puede no correr sin PR.** Si los workflows escuchan `pull_request` hacia las ramas protegidas, un push a una feature sin PR no deja evidencia. Para conservar el rojo en el CI, se abre la PR (en borrador) **antes** de empujar el commit rojo.
- **Un commit que no compila por sí solo** (importa algo que llega en el commit siguiente) rompe `bisect`. Cuando un archivo mezcla cambios de dos commits, se usa `git add -p`.
- **Repo {{VISIBILIDAD_REPO}}:** antes de cada PR se revisa que el diff no arrastre `.env`, secretos ni datos reales del cliente. `.env` siempre en `.gitignore`.
- **Generadores de código** (CLIs de scaffolding y de componentes) pueden añadir dependencias o archivos de más. Después de cada uno, se revisa el diff de los manifiestos de dependencias.

<!-- RELLENAR: añade aquí las trampas de git propias del proyecto según aparezcan en los handoffs. -->
