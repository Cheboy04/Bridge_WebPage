# PLANTILLA — Spec de HU

Copia este archivo y rellénalo. **Dónde vive la spec:**

<!-- SI TOPOLOGIA=monorepo -->
- **Por defecto, una sola spec en la carpeta de su capa:** `docs/specs/{capa}/HU-XX.md`. No es obligatorio crear una por capa.
- **Solo si la HU cruza capas de verdad** (p. ej. autorización: política en el servidor y rutas protegidas en el cliente), crea una en cada carpeta y **enlázalas** entre sí.
- **Si la spec es transversal** (no pertenece a una capa), va en `docs/specs/HU-XX.md`.
<!-- /SI -->
<!-- SI TOPOLOGIA=solo-backend|solo-frontend -->
- `docs/specs/HU-XX.md`. Sin contraparte.
<!-- /SI -->
<!-- SI TOPOLOGIA=multirepo -->
- `docs/specs/HU-XX.md` **en el repo que implementa esa capa**. Si la HU cruza repos, cada repo tiene la suya y la "Contraparte" es la URL de la spec en el otro repo.
<!-- /SI -->

**Reglas al rellenar:**

- **No copies** los criterios de aceptación de la historia: viven en {{TRACKER}}. Aquí van los criterios **de esta capa**, traducidos a tests.
- **Referencia el ADR por número** (`D3.1`…). No pegues su contenido.
- Un valor concreto (código de error, versión, nombre de claim) se escribe en su dueño y aquí se referencia; no se duplica.
- Borra los comentarios `<!-- … -->` de guía antes de dar la spec por lista.
- Profundidad esperada: la suficiente para que quien implementa no tenga que inventar nada (rutas, campos, códigos de error, textos visibles) y para que cada test tenga una forma clara de fallar.

---

# HU-XX ({{CAPA}}) — <título corto de la historia>

> **{{TRACKER}}:** `{{PREFIJO_TICKET}}-XXX` · **Sprint:** N · **Cubre:** RF-0X, RNF-0X
> **Contraparte:** [`../otra-capa/HU-XX.md`] | URL en otro repo | — (no cruza capas)
> **Estado:** `[ ]` borrador · `[ ]` aprobada · `[ ]` implementada

<!-- Una o dos frases: qué AC de la historia (resumidos, no copiados) traduce esta spec. -->

## 1. Alcance en esta capa

**Dentro:**

- …

**Fuera / diferido (con motivo):**

- … → `{{PREFIJO_TICKET}}-YYY` (HU-YY) <!-- cada exclusión dice DÓNDE se hará o POR QUÉ no se hace: "depende de 8.4 del ADR, ABIERTO; esta API es compatible con cualquier decisión posterior" -->

## 2. Dependencias

- **{{TRACKER}}:** tickets que deben estar terminados.
- **Modelo de datos:** sección del ERD que es fuente única de columnas y restricciones (si toca datos).
- **Vetos:** si se levantó un veto de `CLAUDE.md` §5 para esta HU, cítalo con fecha.
- **ADR (DECIDIDO):** `Dx.y`, …
- **ABIERTOS que no bloquean:** `Dx.y` y por qué esta implementación es compatible con todas sus salidas.
- **Externas:** dominio, tenant, bucket… o "ninguna".

## 3. Contrato técnico

<!-- El "cómo" de esta capa, anclado al ADR. Usa las subsecciones que apliquen y borra el resto. -->

<!-- Capa API / servidor:
### 3.1 Rutas            método + ruta + quién puede + respuesta
### 3.2 Autorización     política / permisos por rol (ref. matriz del ADR)
### 3.3 Entrada          validación campo a campo
### 3.4 Reglas de negocio
### 3.5 Servicio         qué orquesta, transacciones, efectos
### 3.6 Persistencia     tablas, relaciones (ref. ERD)
### 3.7 Salida           forma exacta de la respuesta, por rol
### 3.8 Errores          tabla estado → code → cuándo (ref. D3.1)
-->

<!-- Capa UI / cliente:
### 3.1 Rutas            ruta del navegador → página → guarda de rol
### 3.2 Pantallas y textos   textos visibles exactos (los afirmarán los tests)
### 3.3 Validación en el cliente   solo lo que adelanta al servidor
### 3.4 Datos            consultas/mutaciones, claves de caché, invalidaciones
### 3.5 Errores          code → qué ve el usuario (ref. D3.1)
-->

<!-- Capa de datos / job / CLI: entradas, salidas, idempotencia, reintentos, programación. -->

## 4. Criterios de aceptación de esta capa → tests

<!-- Cada fila es un test que el agente escribirá en rojo. Antes de la tabla, una línea con el runner, la frontera real (C4) y los helpers que se reutilizan.
"Cómo se prueba que FALLA" es obligatorio: es la compuerta C3. Describe la mutación concreta que lo pone rojo. -->

| #   | Test (archivo::caso) | Qué afirma | Cómo se prueba que FALLA (C3) |
| --- | -------------------- | ---------- | ----------------------------- |
| 1   | `…`                  | …          | …                             |
| 2   | `…`                  | …          | …                             |

## 5. Notas de implementación

<!-- Pistas para la fase Green: qué helper reutilizar (encontrado al buscar en el código), qué orden seguir, qué trampa evitar (ver lecciones-transversales.md). NO es el código. -->

## 6. Registro de cambios de la spec

<!-- Lo más reciente arriba. Cada vez que la implementación revela algo no previsto, se anota aquí y se corrige la sección afectada en la misma sesión. Registra también los hitos del ciclo con su evidencia:
- `AAAA-MM-DD` — review con C3: N mutaciones, M sobreviven; se endurece #X porque… 
- `AAAA-MM-DD` — implementada: suite N en verde; linters limpios.
- `AAAA-MM-DD` — aprobada por el humano. Tests en rojo: N casos fallan por <razón correcta>.
- `AAAA-MM-DD` — borrador creado. Decisiones del humano: …
-->

- `AAAA-MM-DD` — creada.
