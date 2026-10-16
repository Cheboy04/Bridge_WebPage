# CLAUDE.md — Capa {{CAPA}} ({{PROYECTO}})

<!-- RELLENAR: solo en TOPOLOGIA=monorepo, una copia por capa (renombra la carpeta {{CAPA}} a backend/, frontend/, worker/…). En solo-* y multirepo, este contenido pasa a §7 del CLAUDE.md raíz y la carpeta se borra. -->

Claude Code carga este archivo **automáticamente cuando el trabajo ocurre en `{{CAPA}}/`**. Complementa el `CLAUDE.md` raíz (reglas duras, git, método SDD/TDD); aquí van las reglas propias de este stack. **No repite el ADR:** las decisiones viven en `docs/adr/decisiones-tecnicas.md` y aquí se referencian por número.

---

## 0. Baseline técnico (no asumir otras versiones)

El pin real lo da el lockfile (`{{LOCKFILE}}`). Esta tabla resume lo que importa al escribir código y tests.

<!-- RELLENAR: framework, lenguaje, librerías clave, runner de tests, linters. Una columna "Nota" para lo que sorprende (p. ej. "la versión 5 exige Node ≥ 22"). Ejemplo (Track Studio, frontend): React 19.x, TypeScript ~6.0 strict con verbatimModuleSyntax, Vite 8.x, TanStack Query 5.x, Vitest 4.1.11. -->

| Componente | Versión | Nota |
| ---------- | ------- | ---- |
|            |         |      |

## 1. Comandos (desde `{{CAPA}}/`)

<!-- RELLENAR: los que el agente realmente ejecuta. Marca los que son código de aplicación (generadores) para que, en modo A, los ejecute el humano. -->

```bash
# servidor de desarrollo
# tests, una pasada
# lint
# formato, comprobar sin modificar
# build / análisis de tipos
# instalar respetando el lockfile (nunca el comando que lo actualiza)
```

## 2. Cadena de calidad antes de pedir commit

En el **mismo orden que el job de CI** de esta capa (`.github/workflows/…`). Si el CI cambia, esta lista cambia en la misma PR.

1. Formato → sin diferencias.
2. Lint → 0 errores. Los warnings conocidos se listan con su ticket; uno nuevo se justifica o se arregla.
3. Tests → suite en verde, con los tests nuevos **probados en rojo** (C3).
4. Tipos / build → sin errores.

## 3. Arquitectura de la capa (referencia al ADR)

<!-- RELLENAR: una fila por regla arquitectónica que el agente debe respetar al escribir tests o revisar, siempre con su número del ADR. Las ABIERTAS se marcan como tales y dicen qué hacer mientras tanto ("no se introduce X hasta que se decida; si una HU lo necesita, se señala y se detiene"). Ejemplo (Track Studio, frontend):
| Errores por `code` | D3.1 | La lógica ramifica por `error.response.data.code`, nunca por `message`. |
| Estado global | 5.8 ABIERTO | No se introduce Zustand/Redux hasta que se decida. |
-->

| Regla | Fuente | En una línea |
| ----- | ------ | ------------ |
|       |        |              |

## 4. Reglas del lenguaje

<!-- RELLENAR: lo que el linter no captura y el agente suele hacer mal. Ejemplo (Track Studio, frontend): sin `any`; `import type` para tipos; sin `console.log`; las variables de entorno existen también en `.env.example` sin valores reales; el texto de usuario se renderiza siempre como texto, nunca como HTML crudo. -->

- …

## 5. Pruebas (cómo se escriben aquí)

<!-- RELLENAR: ubicación de los archivos, idioma de las descripciones, cómo se simula la red o la base de datos, helpers existentes que se reutilizan, cómo se consultan los elementos. Lo más valioso: DÓNDE se corta la simulación. Ejemplo (Track Studio, frontend): "HTTP simulado en el borde de axios (se sustituye el adapter), no se mockea api.get/post: así se ejercitan el cliente real, sus interceptores y la forma real del error." -->

- Archivo de test: …
- Descripciones de los tests en {{IDIOMA_DOCS}}; la cabecera del archivo cita la HU, la tarea y el número de test de la spec.
- Frontera de la simulación: …
- Helpers reutilizables: …

## 6. Qué NO hacer todavía

> **Dueño único: `CLAUDE.md` raíz §5.** La lista de vetos vigente vive allí y no se copia aquí.

<!-- RELLENAR: solo una regla propia de la capa, si la hay. Ejemplo (Track Studio, frontend): "una pantalla funcional solo nace de una spec frontend aprobada que enlaza su contraparte backend. El frontend no inventa endpoints ni formas de respuesta." -->

## 7. Nomenclatura

Nombres de archivos, clases, funciones, rutas y tests: **`{{CAPA}}/docs/nomenclatura.md`**. Este archivo manda sobre _cómo trabajar_; aquel, sobre _cómo nombrar_.
