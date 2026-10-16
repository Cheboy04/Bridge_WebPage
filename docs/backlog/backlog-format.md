# Formato común del backlog

**Estado:** convención oficial de granularidad y trazabilidad desde AAAA-MM-DD. Que el backlog sea oficial no autoriza a implementar ni sustituye a Ready (`docs/global/metodologia-sdd-tdd.md` §9).

Este formato es **agnóstico al gestor de tareas**. El mapeo a Jira y la importación por CSV están en [`anexo-jira/`](anexo-jira/README.md). <!-- RELLENAR: si usas otro tracker (Linear, GitHub Projects, Azure Boards…), crea su anexo con la misma estructura y borra el de Jira. -->

## Archivos y autoridad

- [Roadmap](roadmap.md): sprints, releases y capacidad; horizonte y control.
- [Backlog](backlog.md): catálogo de épicas, Story y Task, y cobertura HU ↔ RF/RNF.
- `sprints/sprint-NN.md`: desglose por sprint, con tickets, checklists y dependencias ([plantilla](sprints/PLANTILLA-SPRINT.md)).
- [Mapa de claves](key-map.md): `local_id` → clave real en {{TRACKER}}.
- [Metodología SDD/TDD](../global/metodologia-sdd-tdd.md): ciclo, roles, compuertas C1-C5, Ready y Done.
- [Reglas de git](../global/reglas-git.md): ramas, commits y entrega de comandos.
- ADR (`docs/adr/decisiones-tecnicas.md`): decisiones técnicas por número (`Dx.y`) y bloques ABIERTOS.
- Specs (`docs/specs/…`): contrato técnico y tests de cada historia.

Este formato no reemplaza a las specs ni al ADR. **Regla anti-drift:** los criterios de aceptación de una historia se escriben una sola vez, en {{TRACKER}}. Las specs y los documentos de sprint los referencian, no los copian.

## Jerarquía

```text
Epic
  Story (una HU) o Task (técnica, infraestructura, decisión o documentación)
    Checklist detallada dentro de la Description
    Sub-task solo si necesita seguimiento propio
Bug enlazado a la entrega afectada
```

Release y sprint son atributos de planificación, no padres. Una épica puede abarcar varios sprints. Una Task es hermana de las Story bajo la épica; nunca se anida una Task bajo una Story.

<!-- SI TOPOLOGIA=monorepo|multirepo -->
Cada HU que cruza capas o repos es **una sola Story**. El trabajo de cada capa o repo se refleja en su checklist, no en tickets separados.
<!-- /SI -->

## Identificadores

| Elemento   | local_id                       | Ejemplo                            |
| ---------- | ------------------------------ | ---------------------------------- |
| Epic       | `{{PREFIJO_LOCAL}}-epic-<slug>` | `{{PREFIJO_LOCAL}}-epic-usuarios`  |
| Story (HU) | `{{PREFIJO_LOCAL}}-<NN>`       | `{{PREFIJO_LOCAL}}-05` ↔ HU-05     |
| Task       | `{{PREFIJO_LOCAL}}-<NN>`       | `{{PREFIJO_LOCAL}}-29`             |
| Bug        | `{{PREFIJO_LOCAL}}-<NN>`       | `{{PREFIJO_LOCAL}}-38`             |

Contador único: `{{PREFIJO_LOCAL}}-01`..`{{PREFIJO_LOCAL}}-NN` son HU-01..HU-NN; las Task y los Bug toman el siguiente número libre después de la última HU.

- Los IDs son estables y nunca se reutilizan. Mover una historia a otro sprint no cambia su ID.
- La clave real del tablero (`{{PREFIJO_TICKET}}-<n>`) **no** coincide con el `local_id`; la correspondencia vive solo en [key-map.md](key-map.md).
- Las casillas de una checklist no tienen clave, tipo, estado ni fila de importación. Un Sub-task excepcional se declara expresamente como ticket.

## Description mínima

Una Epic contiene un único párrafo:

```text
Resultado y límites: <resultado acotado>. La épica agrupa alcance aprobado; cada entrega requiere spec y tests en rojo antes de implementar.
```

Una Story o Task contiene:

```text
Historia: Como <rol>, quiero <funcionalidad>, para <beneficio>.   # Solo Story.

Alcance: <incluido y exclusiones relevantes>.

Criterios de aceptación:
- <criterio verificable del resultado completo>

Referencias: <RF/RNF, ADR Dx.y, docs/specs/…/HU-NN.md, roadmap>.

Dependencia externa: <infraestructura humana, bloque ABIERTO del ADR o persona>.   # Solo si aplica.

Checklist de ejecución:
<casillas con ID, trabajo, Hecho cuando y orden interno>
```

- No se dejan secciones vacías; si algo no aplica, se omite.
- Tipo, padre, prioridad, story points, sprint, release, responsable, etiquetas y enlaces van en sus campos nativos. No se duplican en la Description.
- La sección de criterios de aceptación es la fuente de verdad de los AC. Si el código debe diferir, primero se actualiza el ticket.
- Nunca se incluyen secretos, tokens ni datos reales del cliente o de sus usuarios.

## Checklist estándar

Cada Story parte de esta plantilla y la ajusta a su historia: se quitan las casillas de la capa que no aplica y se añaden casillas específicas (reglas de negocio, RNF concretos). Las casillas siguen el reparto de roles de la metodología (§2).

**Bloque por capa** (en solo-* hay un bloque; en monorepo o multirepo, un bloque por capa o repo, numerados de forma consecutiva):

| Casilla | Trabajo                         | Hecho cuando                                                                                    |
| ------- | ------------------------------- | ----------------------------------------------------------------------------------------------- |
| `.01`   | Spec {{CAPA}}                   | Spec aprobada por el humano, anclada al ADR y sin copiar los AC.                                |
| `.02`   | Tests {{CAPA}} en rojo          | Tests escritos y vistos fallar por la razón correcta (C2).                                      |
| `.03`   | Código {{CAPA}} hasta verde     | Tests en verde; la cadena de calidad de la capa está limpia.                                    |
| `.04`   | Review {{CAPA}}                 | Hallazgos con `archivo:línea` resueltos o justificados; cada test no trivial probado en rojo (C3). |

**Casilla final, una por Story:**

| Casilla | Trabajo              | Hecho cuando                                                                                              |
| ------- | -------------------- | --------------------------------------------------------------------------------------------------------- |
| `.NN`   | Integración y cierre | PR a la rama de integración con el CI en verde; AC verificados en staging; RNF aplicables comprobados; handoff actualizado. |

> Ejemplo (Track Studio, monorepo): `.01`-`.04` backend, `.05`-`.08` frontend y `.09` integración. En una HU solo de backend, `.01`-`.04` y `.05` integración.

<!-- SI MODO_ROLES=C -->
En el modo C, cada casilla `.03` declara quién implementa: `(impl: humano)` o `(impl: agente)`.
<!-- /SI -->

Formato de cada casilla en la Description:

```text
- [ ] `{{PREFIJO_LOCAL}}-05.03` Código {{CAPA}} hasta verde. Hecho cuando: tests de alta y edición en verde; linters limpios. Orden interno: {{PREFIJO_LOCAL}}-05.02.
```

Las Task usan casillas propias de su naturaleza (decisión, infraestructura, documentación), con el mismo formato. Marcar una casilla no cierra el ticket ni satisface sus gates.

## Cuándo separar trabajo en otro ticket

| Necesidad                                                                           | Representación                                                           |
| ----------------------------------------------------------------------------------- | ------------------------------------------------------------------------ |
| Spec, test, implementación o comprobación dentro del mismo resultado.               | Casilla de la checklist.                                                 |
| Una capa de la historia que lleva otra persona, con estado, plazo o bloqueo propios. | Sub-task bajo esa Story.                                                 |
| Decisión o infraestructura que bloquea varias historias (ERD, bucket, correo…).     | Task independiente bajo la épica, con enlaces Blocks.                    |
| Dos resultados aceptables por separado, o una historia que no cabe en un sprint.    | Dos Story bajo la misma épica, cada una con alcance y criterios propios. |
| Defecto descubierto en pruebas, review o staging que necesita seguimiento.          | Bug enlazado a la entrega afectada.                                      |

No hay un número fijo de tickets por historia. No se separan automáticamente las capas, ni se crea un ticket por test o por paso.

Al dividir una historia, sus criterios y casillas se reparten sin omitir ni duplicar alcance; ambas partes enlazan la misma HU y RF, y se actualizan dependencias, SP y sprint objetivo. Al promover una casilla a ticket, la casilla queda como referencia al nuevo `local_id` y no se ejecuta dos veces.

## Campos del ticket

| Campo local        | Contenido y regla                                                                                     |
| ------------------ | ----------------------------------------------------------------------------------------------------- |
| `local_id`         | Único, estable, sin reutilización.                                                                    |
| `issue_type`       | Epic, Story, Task, Bug o Sub-task justificado.                                                        |
| `summary`          | Título específico con acción o resultado. En Story: `HU-NN <resultado>`.                              |
| `parent_id`        | Epic para Story/Task; Story/Task para Sub-task; vacío en Epic.                                        |
| `description`      | Historia, alcance y exclusiones.                                                                      |
| `acceptance`       | Criterios de aceptación del resultado completo (fuente de verdad).                                    |
| `checklist`        | ID, trabajo, Hecho cuando y orden interno de cada casilla.                                            |
| `release`          | R1, R2… según el roadmap; `transversal` si aplica a todos.                                            |
| `target_sprint`    | S1..SN; puede quedar pendiente.                                                                       |
| `story_points`     | Fibonacci 1, 2, 3 o 5 por planning poker. Solo en Story.                                              |
| `priority`         | P0 necesaria para el objetivo del sprint; P1 capacidad adicional.                                     |
| `layer`            | {{CAPA}}, `ambas`, `infra` o `docs`.                                                                  |
| `risk`             | `normal`, `seguridad` (auth, permisos), `datos` (migraciones, integridad), `archivos` o `infra`.      |
| `adr_gate`         | Bloques del ADR de los que depende y su estado.                                                       |
| `definition_state` | `backlog-oficial`, `pendiente-decision` o `ready`.                                                    |
| `status`           | Flujo: To Do → In Progress → In Review → Done.                                                        |
| `owner`            | Persona, solo cuando esté confirmada.                                                                 |
| `references`       | HU-NN, RF/RNF, ADR `Dx.y`, spec.                                                                      |
| `blocked_by`       | `local_id` predecesores y motivo.                                                                     |
| `external_blocker` | Infraestructura humana, decisión o persona externa, con la siguiente acción.                          |
| `split_reason`     | Motivo para crear un Sub-task o dividir una historia.                                                 |
| `evidence`         | PR, ejecución de CI, captura de staging. Vacío hasta ejecutar.                                        |

Todos los tickets entran al backlog oficial sin responsable ni evidencia. Siguen sin estar Ready hasta cumplir la definición de Ready.

## Dependencias y gates

- `blocked_by` recoge dependencias de entrega: el sucesor no se da por terminado antes que el predecesor. Se permiten specs y tests en rojo aislados cuando la dependencia no afecta a esa actividad.
- El orden entre casillas se conserva en la Description; no se exporta como enlaces Blocks.
- El padre expresa pertenencia, no bloqueo. No se crean ciclos entre un ticket y sus hijos.
- **Gate del ADR:** una historia que depende de un bloque ABIERTO no es Ready.
- **Infraestructura manual:** {{SERVICIOS_EXTERNOS}} los configura el equipo humano. Se registran como Dependencia externa o como Task enlazada; el agente no los toca.
- **Compuertas del método:** C1-C5 (metodología §5). Marcar casillas no las sustituye.
- **Done:** ver ADR, bloque 1. El release se libera cuando todas sus historias cumplen Done.
- Un bloqueo documentado sigue siendo un bloqueo. El sprint puede cerrar por calendario, pero su objetivo no se declara cumplido si faltan criterios.
- Las correcciones que descubren las pruebas o los reviews se resuelven antes de la entrega; si necesitan seguimiento propio, se crean como Bug enlazado.

## Estimación, capacidad y Ready

- Las historias se estiman en story points (1, 2, 3, 5) por planning poker, considerando complejidad, incertidumbre y volumen, sin traducción directa a horas. La historia ancla está en el ADR (1.5).
- Una historia de más de 5 SP se divide.
- Capacidad nominal: <!-- RELLENAR: personas × horas por sprint -->. Specs, tests, reviews, integración, correcciones, documentación y Tasks sin SP consumen esa misma capacidad. Las esperas externas se registran aparte, sin horas ficticias.
- **Flujo continuo:** si un sprint termina antes, se toman historias Ready del siguiente, nunca una bloqueada por el ADR.
- **Ready:** AC escritos en el ticket, bloques del ADR de los que depende en estado DECIDIDO y trabajo fuera de "Qué NO hacer todavía". La spec se escribe al entrar al ciclo, no antes de cargar el backlog.

## Trabajo ya realizado antes del tablero

Si existe trabajo previo (scaffolding, CI, auth…), sus tickets se crean igual que los demás, en To Do, y después se mueven a Done a mano registrando como evidencia la PR o la ejecución de CI. Nunca se cargan como Done sin evidencia.
