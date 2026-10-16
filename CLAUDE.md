> **UNFILLED TEMPLATE (2026-10-16).** This file was copied from `~/Projects/sdd-kit/plantilla/` and is not filled yet. Start every session by reading `docs/global/handoffs/HANDOFF_v1.md`; its §8 step 2 fills this file with the kit's `PROMPT-RELLENADO.md`. Delete this banner when the fill is done.

# CLAUDE.md — Manual del agente ({{PROYECTO}})

Este archivo se carga en cada sesión. Le dice al agente **cómo comportarse**, no qué construir. **Léelo completo al inicio de cada sesión.**

<!-- SI TOPOLOGIA=monorepo -->
Es un monorepo con reglas por capa: además de este archivo raíz, cada carpeta de capa (`{{CAPA}}/`) tiene su `CLAUDE.md`, que Claude Code carga **automáticamente cuando el trabajo ocurre en esa carpeta**. Este archivo raíz manda sobre lo común; el de la capa, sobre su stack.
<!-- /SI -->
<!-- SI TOPOLOGIA=solo-backend|solo-frontend -->
Es un repo de una sola capa. Las reglas del stack están en §7 de este mismo archivo.
<!-- /SI -->
<!-- SI TOPOLOGIA=multirepo -->
Es uno de varios repos del proyecto. Los documentos globales (metodología, reglas de git, ADR, ERD, backlog, handoffs) viven en **{{REPO_DOCS}}** y aquí se enlazan, no se copian. Las reglas del stack de este repo están en §7.
<!-- /SI -->

---

## 0. Reglas duras (no negociables)

1. **Git:** <!-- SI MODO_ROLES=A|C -->no ejecuto escritura de git (`commit`, `push`, `merge`, `branch`, `checkout`, `reset`, `tag`, `stash`). **Sí leo** (`git status/branch/log/diff`). Entrego los comandos de escritura ya rellenados y me detengo.<!-- /SI --><!-- SI MODO_ROLES=B -->solo escribo en mi rama de trabajo y nunca en `{{RAMA_PRINCIPAL}}` ni en `{{RAMA_INTEGRACION}}`.<!-- /SI --> → `docs/global/reglas-git.md`.
2. **Quién escribe el código de aplicación:** modo **{{MODO_ROLES}}** de `docs/global/metodologia-sdd-tdd.md` §2. <!-- RELLENAR: resume el modo en una frase. Ejemplo (Track Studio, modo A): "No tecleo el código de aplicación. Mi trabajo es escribir la spec, escribir los tests en rojo y auditar el diff que teclea el humano. Excepción: si el humano me lo pide para una acción puntual, la excepción es por tarea, no permanente." -->
3. **Un cambio a la vez y una tarea a la vez.** No toco "de paso" nada fuera del diff de la tarea.
4. **La fuente de verdad manda.** Historias y AC → {{TRACKER}}. Decisiones técnicas → ADR (por número: `D3.1`…). Si el código debe diferir de la spec, **primero se actualiza la spec**, en la misma sesión.
5. **Los secretos nunca van al repo ni al cliente.** El repo es **{{VISIBILIDAD_REPO}}**: nunca secretos ni datos reales del cliente en código, configuración o historial. `.env` siempre en `.gitignore`; `.env.example` versionado sin valores reales.
6. **No toco infraestructura a mano** ({{SERVICIOS_EXTERNOS}}). Si una tarea lo requiere, la señalo como dependencia y me detengo.

---

## 1. Verificación previa a cualquier cambio (obligatoria)

Antes de escribir una spec o un test, o de proponer una implementación:

1. **¿Toca algo `ABIERTO` en el ADR?** Si sí, no lo trabajo todavía: señalo la decisión pendiente. La lista viva está al final del ADR ("Resumen de puntos abiertos priorizados"); no la copio aquí, la consulto.
2. **¿Cae en "Qué NO hacer todavía" (§5)?** Si sí, no lo hago aunque parezca razonable.
3. **¿Afecta a una convención** (nombres, commits, ramas, formato de error, zona horaria, capas)? La verifico contra el documento que la posee antes de aplicarla.

---

## 2. Ritual de sesión

**Al arrancar**, leo en este orden:

1. Este `CLAUDE.md`<!-- SI TOPOLOGIA=monorepo --> y el `CLAUDE.md` de la capa donde voy a trabajar<!-- /SI -->.
2. `docs/global/metodologia-sdd-tdd.md`: el ciclo, las compuertas y el reparto de roles.
3. El último `docs/global/handoffs/HANDOFF_vN.md`: estado, decisiones y trampas de la sesión anterior.
4. La **spec de la HU** en `docs/specs/…` y sus criterios de aceptación en {{TRACKER}}.
5. Busco en el código con `{{HERRAMIENTA_BUSQUEDA}}` antes de escribir tests o proponer código, para reutilizar en vez de reescribir.

**Al cerrar una tarea**, reporto: qué hice, qué archivos toqué, qué falta y los hallazgos del review (§5 de la metodología), y **entrego el bloque de comandos git**. Luego me detengo.

**Al cerrar la sesión**, escribo el siguiente `HANDOFF_vN.md` con `docs/global/PLANTILLA-HANDOFF.md`.

---

## 3. Estructura del repo

<!-- RELLENAR: deja solo el árbol de tu topología. -->

<!-- SI TOPOLOGIA=monorepo -->
Monorepo con carpetas hermanas por capa.

```
/
├── CLAUDE.md                       ← reglas globales del agente
├── docs/
│   ├── global/
│   │   ├── metodologia-sdd-tdd.md
│   │   ├── reglas-git.md
│   │   ├── lecciones-transversales.md
│   │   ├── PLANTILLA-HANDOFF.md
│   │   └── handoffs/HANDOFF_vN.md
│   ├── adr/decisiones-tecnicas.md  ← fuente de verdad técnica
│   ├── erd/
│   ├── backlog/                    ← roadmap, catálogo, sprints, mapa de claves
│   └── specs/
│       ├── PLANTILLA-SPEC.md
│       ├── {{CAPA}}/HU-XX.md       ← una carpeta por capa
│       └── HU-XX.md                ← specs transversales (si aplica)
└── {{CAPA}}/
    ├── CLAUDE.md                   ← reglas de la capa
    └── docs/nomenclatura.md
```
<!-- /SI -->
<!-- SI TOPOLOGIA=solo-backend|solo-frontend -->
```
/
├── CLAUDE.md                       ← reglas del agente (incluye el stack, §7)
├── docs/
│   ├── global/                     ← metodología, git, lecciones, handoffs
│   ├── adr/decisiones-tecnicas.md
│   ├── erd/                        ← (si el repo tiene persistencia)
│   ├── backlog/
│   ├── specs/HU-XX.md
│   └── nomenclatura.md
└── src/ …
```
<!-- /SI -->
<!-- SI TOPOLOGIA=multirepo -->
```
/                                   (este repo)
├── CLAUDE.md                       ← reglas del agente (incluye el stack, §7)
├── docs/
│   ├── specs/HU-XX.md              ← specs de la capa de este repo
│   └── nomenclatura.md
└── src/ …

{{REPO_DOCS}}                       (repo de documentación global)
└── docs/global, docs/adr, docs/erd, docs/backlog, docs/global/handoffs
```
<!-- /SI -->

---

## 4. Índice de documentos

| Documento                                  | Qué contiene                          | Manda sobre                      |
| ------------------------------------------ | ------------------------------------- | -------------------------------- |
| `CLAUDE.md` (raíz)                         | Reglas duras, ritual, estructura      | Comportamiento común del agente  |
| `{{CAPA}}/CLAUDE.md` (monorepo) o §7 de este archivo | Reglas y convenciones del stack | El stack de esa capa |
| `docs/global/metodologia-sdd-tdd.md`       | Ciclo SDD/TDD, compuertas, roles      | Cómo se trabaja cada tarea       |
| `docs/global/reglas-git.md`                | Ramas, commits, entrega de comandos   | Todo lo de git                   |
| `docs/global/lecciones-transversales.md`   | Trampas aprendidas que siguen vigentes | Qué no repetir                  |
| `docs/adr/decisiones-tecnicas.md`          | Decisiones cerradas (`Dx.y`)          | Lo técnico decidido              |
| `docs/erd/…`                               | Modelo de datos                       | Tablas, columnas, restricciones  |
| `docs/backlog/…`                           | Roadmap, catálogo, sprints            | Planificación                    |
| `docs/specs/…`                             | Contrato y tests por HU               | El "cómo" de cada historia       |
| `docs/global/handoffs/HANDOFF_vN.md`       | Estado entre sesiones                 | Memoria de continuidad           |

---

## 5. Qué NO hacer todavía (alcance vigente del Sprint {{SPRINT_ACTUAL}})

<!-- RELLENAR: los vetos vigentes. Es el ÚNICO sitio donde viven: los CLAUDE.md de capa y la metodología los referencian. Cada cambio lleva fecha y motivo en una nota. Ejemplo de forma (Track Studio):
> **Actualizado el 2026-10-13:** `TS-21` (HU-10) se adelanta de S3 a S2. Se levanta el veto de `songs` **solo para TS-21**.
- No crear migraciones de `versions`, `comments`… (esperan su sprint).
- No implementar el hash de integridad todavía; corresponde a S4.
- No construir interfaces funcionales fuera de artistas y producciones.
-->

- …

---

## 6. Decisiones de infraestructura cerradas

<!-- RELLENAR: solo lo que el agente necesita a mano y no cambia: dueño del repo y visibilidad, dominio, correo del proyecto, región de la nube, gestor de paquetes y tablero. Si algo se reconcilia (drift entre un documento externo y la realidad), anótalo aquí con fecha y dónde queda pendiente de corregir. -->

- **Repositorio:** …
- **Tablero:** {{TRACKER}}, proyecto `{{PREFIJO_TICKET}}`.

---

<!-- SI TOPOLOGIA=solo-backend|solo-frontend|multirepo -->
## 7. Stack de este repo

<!-- RELLENAR: copia aquí las secciones 0-5 de plantilla/{{CAPA}}/CLAUDE.md (baseline, comandos, cadena de calidad, arquitectura por referencia al ADR, reglas del lenguaje, pruebas) y borra esa carpeta. La nomenclatura va en docs/nomenclatura.md. -->
<!-- /SI -->

## Búsqueda en el código

<!-- RELLENAR: herramienta y comandos (o borra la sección si no usas ninguna). Ejemplo (Track Studio): grafo de conocimiento en `graphify-out/`. `graphify query "<pregunta>"`, `graphify path "<A>" "<B>"` y `graphify explain "<concepto>"` antes de usar grep o leer el repo entero. Tras cualquier cambio de código, `graphify update .`. -->

Es memoria **del código**, no de la conversación. La memoria entre sesiones la cargan las specs y los handoffs.
