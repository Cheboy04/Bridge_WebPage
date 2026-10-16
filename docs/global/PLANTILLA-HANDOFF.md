# PLANTILLA — Handoff entre sesiones

Copia a `docs/global/handoffs/HANDOFF_vN.md` (N incremental; **el anterior no se sobrescribe**). Es **memoria entre sesiones**, no una spec. Las specs viven en `docs/specs/`; las decisiones cerradas, en el ADR.

**Por qué versionado y por qué detallado:** el contexto de un chat no persiste y una sesión de agente se reinicia. Todo lo que importa vive en archivos. Cada handoff anota no solo lo que se hizo, sino **la trampa que costó tiempo**, para que la siguiente sesión no la repita.

**Regla de consolidación:** cada 10 handoffs se crea `HANDOFF_v<a>-v<b>_consolidado.md`, que unifica los 10 previos y nada más (plantilla al final). Las trampas que siguen vigentes y no dependen del proyecto suben a `lecciones-transversales.md`.

---

# Handoff vN — {{PROYECTO}}

**Fecha:** AAAA-MM-DD · **Sprint:** N (AAAA-MM-DD → AAAA-MM-DD) · **Capa(s)/Repo(s):** …
**Foco de la sesión:** <una frase: ticket, HU y en qué paso del ciclo quedó>

> Continúa [`HANDOFF_v(N-1).md`](HANDOFF_v(N-1).md). Rama `feature/…`, cabeza `<hash>`. <!-- ¿Hay PR? ¿Todo commiteado? -->

## 1. Estado ejecutivo

<!-- 2-4 viñetas: dónde quedó el trabajo, qué está en verde, qué falta para cerrar, qué se probó a mano y quién lo probó. -->

## 2. {{TRACKER}}

<!-- Qué se escribió en el tablero en esta sesión. Si no se pudo (conector caído, sin permiso), qué queda pendiente del lado humano. -->

## 3. Decisiones de la sesión

<!-- Numeradas, cada una con su porqué. Si cierra o abre una decisión del ADR, dilo con su número (Dx.y). Si el acuerdo cambió, el documento dueño ya debió cambiar primero (regla anti-drift). Marca las soluciones temporales como tales y di qué ticket las sustituye. -->

1. …

## 4. Evidencia

<!-- Recuento de la suite por capa, linters, C3 (N mutaciones, M sobrevivieron y qué se endureció), estado del CI. -->

## 5. Archivos de la sesión

<!-- Agrupados por capa y por autor (humano / agente). -->

## 6. Trampas operativas

<!-- El bug concreto, la causa real (reproducida, no supuesta) y cómo evitarla. Es el apartado que más ahorra a la siguiente sesión. Al final, una línea con las trampas de handoffs anteriores que siguen vigentes. -->

1. …

## 7. Drift detectado

<!-- Contradicciones entre documentos, o entre documento y código: cuál es el dueño y qué hay que corregir. No se deja sin registrar. Omite la sección si no hay. -->

## 8. Próximos pasos ordenados

<!-- La primera cosa que haría la siguiente sesión, en orden de dependencia. Incluye los pendientes heredados que siguen abiertos. -->

1. …

## 9. Cómo retomar el entorno (solo si cambió)

<!-- Solo si algo del setup cambió respecto al handoff anterior. Si no, borra la sección. -->

---

# PLANTILLA — Handoff consolidado

# Handoff consolidado v<a>–v<b> — {{PROYECTO}}

**Cubre:** AAAA-MM-DD → AAAA-MM-DD · **Sustituye la lectura de:** `HANDOFF_v<a>.md` … `HANDOFF_v<b>.md` (se conservan como historial).

## 1. Resumen ejecutivo
## 2. Qué se hizo (cronología)
## 3. Decisiones vigentes (con su documento dueño)
## 4. Trampas y hallazgos que siguen siendo útiles (agrupadas: tests, bibliotecas, entorno/CI, shell y git, gestión)
## 5. Drift: estado al cerrar v<b>
## 6. Bloqueos y pendientes al cerrar v<b>
## 7. Próximos pasos (tal como quedaron en v<b>)
## 8. Cómo retomar el entorno
## 9. Regla

Cada 10 handoffs se crea uno nuevo que unifica los 10 previos y nada más. **La próxima consolidación toca al cerrar v<b+10> y cubre v<b+1>–v<b+10>.**
