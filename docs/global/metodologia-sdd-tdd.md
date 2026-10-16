# Metodología — SDD + TDD ({{PROYECTO}})

<!-- RELLENAR: este documento es casi todo sustancia reutilizable. Solo se rellenan los marcadores, la tabla de §0, el modo de roles de §2 y la tabla de herramientas de §6. No reescribas las compuertas C1-C5: son el núcleo del método. -->

Documento **global**: aplica igual a todas las capas o repos del proyecto. Define **cómo trabajamos con el agente**, no qué se construye. El "qué" vive en las historias de usuario ({{TRACKER}}) y en sus specs (`docs/specs/`). Las decisiones técnicas cerradas viven en el ADR (`docs/adr/decisiones-tecnicas.md`).

**Léelo completo al inicio de cada sesión.**

---

## 0. Fuentes de verdad (y quién manda sobre qué)

Cada afirmación tiene un único dueño. Si dos documentos se contradicen, gana el dueño de esa materia:

| Materia                                                          | Fuente de verdad                                                     |
| ---------------------------------------------------------------- | -------------------------------------------------------------------- |
| Qué se construye (historias, criterios de aceptación)            | **{{TRACKER}}**. Las specs lo referencian, no lo copian.             |
| Decisiones técnicas cerradas (formato de error, auth, capas…)    | **ADR** (`docs/adr/decisiones-tecnicas.md`), por número: `D3.1`…     |
| Contrato técnico y tests de una HU                               | **Spec de la HU** en `docs/specs/…` (ubicación según la topología, §3) |
| Modelo de datos                                                  | **ERD** (`docs/erd/`)                                                |
| Reglas de comportamiento del agente                              | `CLAUDE.md` (raíz, más el de cada capa si es monorepo)               |
| Convenciones de nombres                                          | `nomenclatura.md` (uno por capa o uno en `docs/`)                    |
| Reglas de git                                                    | `docs/global/reglas-git.md`                                          |
| Planificación (releases, sprints, capacidad)                     | `docs/backlog/roadmap.md` y `docs/backlog/sprints/`                  |
| Estado entre sesiones                                            | `docs/global/handoffs/HANDOFF_vN.md`                                 |

<!-- SI TOPOLOGIA=multirepo -->
**Multirepo:** los documentos globales (ADR, ERD, backlog, metodología, reglas de git) viven solo en el repo **{{REPO_DOCS}}**. Los demás repos los enlazan por URL y no los copian.
<!-- /SI -->

**Regla anti-drift:** un valor concreto (un código de error, el nombre de un claim, una versión, un criterio de aceptación) se escribe en **un solo archivo**. Los demás lo referencian. Duplicarlo es un bug esperando a que las dos copias se separen en silencio.

---

## 1. El problema que este método ataca

No es "la IA programa rápido". Es esto:

> **El agente produce código y pruebas correctos casi siempre, y cuando se equivoca lo hace con la suite en verde.**

Un test que no puede fallar no prueba nada. Una spec que el código ya no cumple deja de ser fuente de verdad. Un valor inventado por el agente se propaga sin que nada se ponga rojo. Todo lo que sigue existe para forzar que la verificación **pueda fallar** y que la intención **quede escrita**, no recordada.

---

## 2. Reparto de roles

**Modo vigente: `{{MODO_ROLES}}`.** <!-- RELLENAR: A, B o C. Conserva solo la tabla del modo elegido y borra las otras dos. Cambiar de modo es una decisión del ADR (bloque 1), no de una sesión. -->

### Modo A — El humano implementa (híbrido SDD)

Para cuando la autoría humana del código es un requisito (proyecto académico, formación, código crítico). El agente es socio de SDD/TDD y mentor, no implementador.

| Paso del ciclo                                    | Quién                                        |
| ------------------------------------------------- | -------------------------------------------- |
| Redactar o actualizar la **spec**                 | **Agente** (el humano aprueba)               |
| Escribir los **tests** que fallan (fase roja)     | **Agente**                                   |
| Escribir el **código de aplicación** hasta verde  | **Humano**                                   |
| **Ping-pong**: ajustar un test si el diseño lo justifica | **El humano propone, el agente revalida** |
| **Review** del diff (§5)                          | **Agente** (el humano decide qué acepta)     |
| **Commit / push / PR**                            | **Humano** (el agente entrega los comandos)  |

**Excepción explícita:** si el humano lo pide para una acción puntual ("hazlo tú esta vez"), el agente puede escribir ese código. La excepción vale para esa tarea, no es permanente.

### Modo B — El agente implementa, el humano revisa

Para cuando la velocidad importa y la autoría no es un requisito. El humano aprueba la intención y el resultado.

| Paso del ciclo                                    | Quién                                                   |
| ------------------------------------------------- | ------------------------------------------------------- |
| Spec                                              | **Agente** (el humano aprueba **antes** de seguir)      |
| Tests en rojo                                     | **Agente** (muestra el rojo)                            |
| Código hasta verde                                | **Agente**                                              |
| Review con C3 (§5)                                | **Agente** (autorrevisión), y después **el humano** lee el diff |
| Commit / push / PR                                | <!-- RELLENAR: humano, o agente con permiso explícito en reglas-git.md --> |

**Contrapeso obligatorio:** en este modo el agente no puede aprobar su propia spec ni dar por buena su propia C3 sin mostrar la evidencia (el rojo de cada mutación).

### Modo C — Mixto por tarea

Cada ticket declara en su checklist quién implementa (`impl: humano` o `impl: agente`). Por defecto implementa el humano (modo A). El agente escribe código solo en tickets marcados `impl: agente`.

### Permisos comunes a los tres modos

**Lo que el agente SÍ puede ejecutar sin pedir permiso:** herramientas de solo lectura (leer, buscar, consultar el grafo del código, `git status/branch/log/diff`) y **escribir y correr archivos de test**.

**Lo que el agente NO ejecuta (salvo que el modo lo permita):** código de aplicación, configuración de infraestructura y comandos de escritura de git. Si cree que hace falta, lo **explica en pasos** y se detiene.

---

## 3. SDD — Spec-Driven Development (spec-anchored)

La spec vive junto al código y evoluciona con él. Su objetivo es evitar el _intent drift_: que el agente (o el humano) se aleje de la intención acordada.

**Qué es una "spec".** Un archivo por HU <!-- SI TOPOLOGIA=monorepo -->y por capa: `docs/specs/{capa}/HU-XX.md`<!-- /SI --><!-- SI TOPOLOGIA=solo-backend|solo-frontend|multirepo -->en `docs/specs/HU-XX.md` del repo que la implementa<!-- /SI -->. **No** reescribe la historia ni sus criterios de aceptación, que viven en {{TRACKER}}. Elabora, para su capa:

1. **Alcance** de la HU en esa capa, y lo que queda fuera o diferido, con motivo.
2. **Contrato técnico**: endpoints, formas de request y response, tipos, componentes y estados, anclado al ADR por número y sin copiarlo.
3. **Criterios de aceptación de la capa** traducidos a **tests concretos**: nombre del test, qué afirma y cómo se prueba que falla.
4. **Dependencias**: qué HU, tareas o decisiones ABIERTAS del ADR bloquean esta.
5. **Enlace a la contraparte** en la otra capa o repo, si la HU cruza.

**Anclaje sin duplicación.** Una HU que cruza capas se describe en dos specs enlazadas. El criterio a nivel de historia ("un usuario sin rol recibe 403…") vive en {{TRACKER}}. Cada spec tiene **sus** criterios de capa (backend: forma del 403; frontend: qué pantalla muestra). Nada se repite entre las dos.

**La spec se mantiene viva.** Si al implementar aparece algo que la spec no contemplaba (un caso borde, un cambio de contrato), el `.md` se actualiza **en la misma sesión**. Una spec desactualizada es peor que no tenerla. Regla operativa: **cuando cambia el acuerdo, cambia primero el documento.**

---

## 4. El ciclo por tarea

El orden es fijo. Cada tarea de una HU recorre:

1. **Specify.** El agente lee la HU en {{TRACKER}}, sus criterios de aceptación, el ADR relevante y el código existente (buscando primero, §7). Redacta o actualiza la spec. El humano la aprueba.
2. **Red.** El agente escribe los tests derivados de los criterios de aceptación. **Deben fallar** al correrlos, porque aún no hay implementación, y el agente muestra ese rojo.
3. **Green.** Quien implementa según el modo (§2) escribe el código hasta que los tests pasan.
4. **Ping-pong (si aplica).** Si un test choca con un diseño mejor, se dice y se justifica. El agente ajusta el test y confirma que sigue cubriendo el criterio de aceptación. Los tests no son intocables, pero no se relajan en silencio.
5. **Review.** Con la suite en verde, el agente audita el diff (§5) y verifica que cada test **puede fallar**.
6. **Commit.** Según `reglas-git.md`. Si el agente no tiene permiso de escritura en git, entrega el bloque de comandos y **se detiene**.

Iteraciones pequeñas: un diff revisable cada vez y una tarea cada vez. No se tocan otras cosas "de paso".

---

## 5. Las compuertas TDD (no negociables)

**C1 — No hay tests sin spec aprobada.** Si falta la spec, se escribe primero (§3).

**C2 — No hay implementación sin un test que ya falle.** El rojo se ve antes de escribir código de aplicación. Si un test nace verde sin implementación, está mal escrito (o es un guardarraíl declarado como tal en un comentario).

**C3 — Todo test nuevo se prueba rompiéndolo.** Es la mitad que casi nadie hace y la razón de ser del método. En el **Review**, por cada test que afirme algo no trivial, se rompe a propósito lo que afirma (se revierte el arreglo o se muta el valor) y se comprueba que **se pone rojo**. Un test que sigue verde con el código roto se corrige o se borra. Se documenta en el reporte: _"probado en rojo revirtiendo X"_, con el recuento de mutaciones y cuántas sobrevivieron.

**C4 — Cuando el contrato es externo, se prueba contra la frontera real.** Un test que simula la dependencia prueba nuestro código, no el contrato. Los tests unitarios simulan las interfaces externas, pero al menos un test de integración ejercita la frontera real (la base de datos real del CI, el token real del proveedor de identidad, el bucket real…).

**C5 — Sin tests no hay tarea terminada.** Una tarea no está terminada sin tests que la cubran. "0 hallazgos" en el review es un resultado válido y se dice tal cual; no se inventa trabajo para parecer diligente.

### Qué busca el Review (paso 5 de §4), acotado al diff de la tarea

- **Código muerto o sobrante**: exports, props o constantes que nadie usa, y abstracciones de un solo uso.
- **Lo mismo escrito dos veces**: el peor caso, porque las copias se separan sin ponerse rojas (anti-drift de §0).
- **Bugs estáticos**: nulos sin cubrir, errores tragados, entrada sin validar en la frontera y trabajo en el cliente que debía hacer el servidor.
- **Tests que no pueden fallar** (C3).
- **Drift entre docs y código**: si la spec, el ADR o el handoff afirman algo que la implementación desmiente, se corrige en la misma pasada.

El agente entrega la lista de hallazgos con `archivo:línea`. Cada uno queda **arreglado** o **justificado por escrito**.

---

## 6. Herramientas por capa

El ciclo es el mismo; las herramientas cambian según dónde ocurre el trabajo. El `CLAUDE.md` de cada capa las detalla.

<!-- RELLENAR: una columna por capa (monorepo) o por repo (multirepo); en solo-* deja una sola columna. Ejemplo (Track Studio): Pest / Larastan nivel 5 / Pint / composer install en backend; Vitest / tsc --noEmit / ESLint + Prettier / npm ci en frontend. -->

|                           | {{CAPA}} |
| ------------------------- | -------- |
| Runner de tests           |          |
| Tipos / análisis estático |          |
| Formato                   |          |
| Test de flujo de usuario  |          |
| Instalación en CI         |          |

Regla común: el pin real lo dan los lockfiles versionados, y el CI instala respetándolos (nunca un comando que los actualice).

---

## 7. Buscar antes de escribir

Antes de escribir un test o de proponer una implementación, el agente consulta el código existente con `{{HERRAMIENTA_BUSQUEDA}}`. Sirve para **reutilizar en vez de reescribir** (¿ya existe este helper, este servicio, esta interfaz?) y para que los tests referencien símbolos reales, no inventados.

<!-- RELLENAR: si usas un grafo de conocimiento (graphify, codebase-memory…), indica sus comandos y cuándo se actualiza. Si no, borra la frase siguiente. -->

Es memoria **del código**, no de la conversación. La memoria entre sesiones la cargan archivos versionados: las specs y el `HANDOFF_vN.md`.

---

## 8. Lo que este método NO cambia

- **Las decisiones ABIERTAS del ADR siguen bloqueando.** Si una tarea toca un punto marcado `ABIERTO`, no se escriben todavía ni su spec de implementación ni sus tests: se señala la decisión pendiente. La lista viva está al final del ADR, no aquí; copiarla sería el drift que §0 prohíbe.
- **Una decisión `ABIERTA` no siempre bloquea.** Si la implementación es compatible con **todas** las salidas posibles de la decisión, el punto se anota y se avanza. Lo que no vale es elegir en silencio una de las salidas y decir que "no bloquea".
  > Ejemplo (Track Studio): el origen del `trace_id` seguía abierto. El backend genera un ULID por respuesta de error y, si mañana el frontend aporta el suyo, el manejador lo respeta sin reescribir nada.
- **"Qué NO hacer todavía"** del `CLAUDE.md` manda por encima de este ciclo. Aunque el método permita escribir tests, no se escriben para módulos vetados ahí.
- La **Definition of Done** del proyecto (ADR, bloque 1) sigue siendo el criterio de cierre. Este método es cómo se llega a ella, no un sustituto.

---

## 9. Definición de "Ready" y "Done" para el agente

**Ready (una tarea puede entrar al ciclo) si:** su HU tiene criterios de aceptación en {{TRACKER}}; las decisiones del ADR de las que depende están `DECIDIDO`; el slice del ERD que necesita está aprobado (si toca datos); y no cae en "Qué NO hacer todavía".

**Done (el agente puede entregar el bloque de commit) si:** la spec está escrita o actualizada; los tests están en verde; cada test se probó en rojo (C3); el review no tiene hallazgos abiertos; los AC de la capa están cubiertos; y los docs no tienen drift. Sin esto, la tarea no está entregada aunque "funcione".
