# {{PROYECTO}} — Registro de Decisiones Técnicas (ADR)

**Proyecto:** {{PROYECTO}}: <!-- RELLENAR: una línea de qué es --> para {{CLIENTE}}
**Equipo:** {{EQUIPO}}
**Product Owner:** <!-- RELLENAR -->
**Última actualización:** AAAA-MM-DD

**Leyenda de estado:**
`DECIDIDO` decisión cerrada · `ABIERTO` requiere definición · `PENDIENTE` depende de otro bloque · `PARCIAL` decisión tomada, pero con partes que dependen de otro punto todavía abierto

<!-- RELLENAR — cómo se usa este documento:
- Cada bloque arranca con una TABLA RESUMEN (# | Punto | Estado | Decisión). Los puntos que necesitan desarrollo se amplían debajo como `### Dx.y — Título (AAAA-MM-DD)`.
- Formato de cada entrada Dx.y: la decisión en 1-3 párrafos, el porqué, las alternativas descartadas si fueron serias, y una línea final de trazabilidad:
  → *Principio (SOLID/…). Atributo de calidad (ISO 25010). Cubre: RF-0X, RNF-0X.*
- Una decisión no se reescribe: se AMPLÍA con una nota fechada (`> **Ampliación de AAAA-MM-DD (TICKET):** …`) o se marca SUPERADA por otra, enlazándola.
- Un bloque entero se puede cerrar: añade "— **CERRADO** (AAAA-MM-DD)" a su título.
- Un bloque que no aplica a la topología (p. ej. "Frontend" en solo-backend) se borra entero.
- Arranque mínimo para poder trabajar: bloques 1, 2 y 3 con las decisiones que ya conoces; todo lo demás puede quedar ABIERTO. Lo ABIERTO bloquea solo lo que lo toca (metodología §8).
-->

---

## 1. Proceso y equipo

| #   | Punto                  | Estado  | Decisión |
| --- | ---------------------- | ------- | -------- |
| 1.1 | Duración de sprint     | ABIERTO |          |
| 1.2 | Roles                  | ABIERTO | PO · SM · Devs |
| 1.3 | Cadencia de ceremonias | ABIERTO |          |
| 1.4 | Reporte a interesados  | ABIERTO |          |
| 1.5 | Historia ancla (estimación) | ABIERTO | HU-XX = N SP |
| 1.6 | Definition of Ready    | ABIERTO | Ver abajo |
| 1.7 | Modo de roles agente/humano | ABIERTO | A, B o C (metodología §2) |

**Definition of Done (vigente):** código integrado en la rama de integración sin fallos de pipeline, pruebas pasando, criterios de aceptación cumplidos, RNF aplicables verificados y revisado en la Sprint Review.

**Definition of Ready:** formato de historia; criterios de aceptación verificables; estimación contra la historia ancla; sin dependencias ABIERTAS en el ADR; entidades ya en el ERD; pantalla ya diseñada (si tiene UI); instrumento de medición definido (si evidencia un RNF). <!-- RELLENAR: si algún criterio no se puede aplicar todavía, marca 1.6 como PARCIAL y explica cuál y por qué. -->

---

## 2. Repositorio, ramas y convenciones

| #   | Punto               | Estado  | Decisión |
| --- | ------------------- | ------- | -------- |
| 2.1 | Topología           | ABIERTO | {{TOPOLOGIA}} |
| 2.2 | Visibilidad         | ABIERTO | {{VISIBILIDAD_REPO}} |
| 2.3 | Modelo de ramas     | ABIERTO | Ver `docs/global/reglas-git.md` |
| 2.4 | Versiones del stack | ABIERTO | Ver D2.1 |

### D2.1 — Versiones pinneadas del stack, linters y analizadores

<!-- RELLENAR: tabla Componente | Versión verificada | Dónde se fija (lockfile). Fecha de verificación. Si un documento externo dice otra versión, anótalo como drift. -->

<!-- SI VISIBILIDAD_REPO=público -->
### D2.2 — Repositorio público, con controles compensatorios obligatorios

<!-- RELLENAR: por qué es público y qué controles lo compensan (escaneo de secretos, `.env` ignorado, sin datos reales del cliente en seeds ni en el tablero, revisión del diff antes de cada PR). -->
<!-- /SI -->

---

## 3. Arquitectura general

| #   | Punto                  | Estado  | Decisión |
| --- | ---------------------- | ------- | -------- |
| 3.1 | Formato de error       | ABIERTO | Ver D3.1 |
| 3.2 | Zona horaria y fechas  | ABIERTO | Ver D3.2 |
| 3.3 | Versionado de API      | ABIERTO |          |
| 3.4 | Paginación y filtros   | ABIERTO |          |
| 3.5 | Tipo de clave primaria | ABIERTO |          |

### D3.1 — Formato estándar de error

<!-- RELLENAR: forma exacta del cuerpo de error (p. ej. RFC 9457 Problem Details), catálogo de `code` por estado HTTP y qué ramifica el cliente (siempre por `code`, nunca por `message`). Es la decisión que más specs referencian. -->

### D3.2 — Zona horaria

<!-- RELLENAR: persistencia (UTC recomendado), serialización (ISO 8601 con offset) y presentación. -->

---

## 4. Capa de servidor

<!-- RELLENAR: validación de entrada, serialización de salida, capas (p. ej. Controller → Service), acceso a datos (ORM directo o repositorio), borrado lógico, enums, framework de pruebas y autorización (RBAC). Borra el bloque si TOPOLOGIA=solo-frontend. -->

| #   | Punto | Estado | Decisión |
| --- | ----- | ------ | -------- |
|     |       |        |          |

---

## 5. Capa de cliente

<!-- RELLENAR: estado del servidor, estado global, formularios, cliente HTTP, rutas por rol, almacenamiento del token y componentes de UI. Borra el bloque si TOPOLOGIA=solo-backend. -->

| #   | Punto | Estado | Decisión |
| --- | ----- | ------ | -------- |
|     |       |        |          |

---

## 6. Base de datos

| #   | Punto                         | Estado  | Decisión |
| --- | ----------------------------- | ------- | -------- |
| 6.1 | Motor                         | ABIERTO |          |
| 6.2 | Convenciones de nombres       | ABIERTO |          |
| 6.3 | Estrategia de índices         | ABIERTO |          |
| 6.4 | Seeders y factories           | ABIERTO |          |
| 6.5 | Backups                       | ABIERTO |          |

### Estado del ERD — ABIERTO

<!-- RELLENAR: enlace a docs/erd/ y qué slices están aprobados. El ERD completo puede diferirse; cada historia de datos espera al slice que consume. -->

---

## 7. Almacenamiento de archivos (si aplica)

<!-- RELLENAR o borrar: subida, tamaño máximo, nombres de las claves, integridad, CORS y expiración de URLs firmadas. -->

---

## 8. Seguridad y acceso

| #   | Punto                          | Estado  | Decisión |
| --- | ------------------------------ | ------- | -------- |
| 8.1 | Matriz de permisos (rol × recurso × acción) | ABIERTO |  |
| 8.2 | Proveedor de identidad         | ABIERTO |          |
| 8.3 | CORS                           | ABIERTO |          |
| 8.4 | Rate limiting                  | ABIERTO |          |

---

## 9. CI/CD, ambientes y observabilidad

| #   | Punto                     | Estado  | Decisión |
| --- | ------------------------- | ------- | -------- |
| 9.1 | Pipeline de CI            | ABIERTO |          |
| 9.2 | Migraciones en el deploy  | ABIERTO | ¿Automáticas o manuales con aprobación? |
| 9.3 | Observabilidad (errores, uptime) | ABIERTO |   |
| 9.4 | Rollback                  | ABIERTO | Definir **antes** del primer incidente real |

---

## 10. Cuentas externas — arrancar por lead time

<!-- RELLENAR: lista de cuentas y servicios (dominio, correo transaccional, nube, identidad, hosting) en el orden en que hay que pedirlas: primero lo que tarda (DNS, verificación de dominio). Lo configura el humano; el agente lo registra como dependencia. -->

---

## 11. Pruebas y evidencia de RNF

| #    | Punto                          | Estado  | Decisión |
| ---- | ------------------------------ | ------- | -------- |
| 11.1 | Frameworks de pruebas por capa | ABIERTO |          |
| 11.2 | Plan de medición por RNF       | ABIERTO | Un instrumento por RNF |

---

## 12. Documentación y trazabilidad

<!-- RELLENAR: qué documentos externos (tesis, contrato, manual) dependen de este ADR y cómo se arrastran las correcciones. -->

---

## Resumen de puntos abiertos priorizados

<!-- RELLENAR: la lista VIVA. Es el único sitio que la contiene; CLAUDE.md y la metodología la consultan, no la copian. Formato:
1. ⚠️ **9.2 — Migraciones en el deploy.** Qué hay que decidir, por qué importa y qué bloquea.
Lo que se cierra se tacha con fecha: ~~**9.3 Observabilidad**~~ — **cerrado AAAA-MM-DD** (D9.3).
-->

1. ⚠️ …
