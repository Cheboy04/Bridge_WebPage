# Guía de estilo de los documentos

Reglas comunes a todos los documentos del kit. Las aplica el agente al rellenar las plantillas y al escribir specs, handoffs o entradas del ADR.

## 1. Cabecera

Todo documento vivo abre con un bloque que dice **qué es, en qué estado está y quién manda**:

```markdown
# <Tipo> — <Tema> (<Proyecto>)

**Estado:** <borrador | aprobado | oficial | implementado> desde AAAA-MM-DD.
**Dueño de:** <qué materia gobierna>. **Lo referencian:** <quién lo usa>.
```

Las specs y los ERD usan una cita (`>`) con ticket, sprint, cobertura RF/RNF, contraparte y casillas de estado `[ ] borrador · [ ] aprobada · [ ] implementada`.

## 2. Un dueño por dato (anti-drift)

- Cada valor concreto (código de error, versión, criterio de aceptación, veto, lista de puntos abiertos) se escribe en **un solo** documento. Los demás lo enlazan o lo citan por número (`D3.1`, `HU-05`, `§5`).
- Si dos documentos se contradicen, se corrige el que **no** es dueño, y se anota el drift en el handoff.
- Cuando cambia un acuerdo, **primero cambia el documento**, y después el código o el tablero.
- Al referenciar en lugar de copiar, se dice dónde está: _"La lista vigente vive en el ADR, «Resumen de puntos abiertos»; no se copia aquí."_

## 3. Fechas y tiempo

- Siempre fechas absolutas ISO: `2026-10-13`. Nunca "ayer", "la semana pasada" ni "el próximo sprint" sin fecha.
- Los cambios de estado llevan fecha: `**Actualizado el AAAA-MM-DD:** …`, `cerrado AAAA-MM-DD`.
- Las decisiones no se reescriben: se amplían con `> **Ampliación de AAAA-MM-DD (TICKET):** …` o se marcan como superadas, con un enlace a la que las sustituye.
- Lo cerrado se tacha y conserva su rastro: `~~**9.3 Observabilidad**~~ — **cerrado AAAA-MM-DD** (D9.3)`.

## 4. Alcance explícito

- Toda lista de "dentro" va acompañada de una lista de **"Fuera / diferido (con motivo)"**, y cada exclusión dice dónde se hará (ticket o HU) o por qué no se hace (decisión ABIERTA, fuera del RF).
- Lo que es temporal se dice: _"apaño temporal que HU-11 debe sustituir"_.
- Lo que no se sabe se dice: _"sin investigar"_, _"supuesto, pendiente de confirmar"_. No se rellena con suposiciones.

## 5. Tablas y listas

- Se usan tablas cuando hay dos o más atributos por fila (decisiones, tickets, tests, riesgos, campos). Las columnas habituales son estas:
  - Decisiones: `# | Punto | Estado | Decisión`.
  - Tests: `# | Test (archivo::caso) | Qué afirma | Cómo se prueba que FALLA`.
  - Riesgos: `Riesgo | Señal | Respuesta`.
  - Casillas: `Casilla | Trabajo | Hecho cuando`.
- Las listas numeradas se reservan para orden real (pasos, prioridad). El resto de listas va con viñetas.
- Diagramas en `mermaid` dentro del markdown (secuencia de tickets, ERD), no como imágenes.

## 6. Redacción

- Idioma: {{IDIOMA_DOCS}}. Los identificadores de código van entre comillas invertidas y en su idioma original.
- Frases cortas y en voz activa. Primero la regla y después el porqué, en una frase: _"`.env` siempre en `.gitignore`: el repo es público."_
- Se escribe en negrita la palabra que decide (**nunca**, **solo**, **primero**), no frases enteras.
- Sin relleno ni promesas. "0 hallazgos" es un resultado válido y se dice tal cual.
- Las trampas siguen el patrón **síntoma → causa real (reproducida) → qué hacer**.

## 7. Comentarios de guía

- Las plantillas usan `<!-- RELLENAR: … -->` para guiar y `<!-- SI VAR=valor -->…<!-- /SI -->` para variantes. Un documento no está listo mientras quede alguno.
- Los ejemplos del proyecto de origen van como `> Ejemplo (Track Studio): …` y se borran o se sustituyen por uno propio.

## 8. Seguridad

- Nunca secretos, tokens, credenciales ni datos reales del cliente o de sus usuarios, ni en los documentos ni en el tablero. Se dice **dónde** están ("gestor de contraseñas del equipo"), nunca **qué** son.
- Las URLs de entornos y los correos de cuentas de servicio pueden figurar si el repo es privado; si es público, se valora caso por caso y se decide en el ADR.

## 9. Registro de cambios

- Las specs y los ERD terminan con un **registro de cambios**, con lo más reciente arriba, una línea por hito, fecha y evidencia (recuento de la suite, mutaciones de C3, quién aprobó).
- Los documentos de sprint terminan con **"Sincronización con el tablero ejecutada"**: una lista fechada de lo que se aplicó.
