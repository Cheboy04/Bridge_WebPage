# Nomenclatura — {{CAPA}} ({{PROYECTO}})

<!-- RELLENAR: en solo-* y multirepo este archivo va en docs/nomenclatura.md. Recoge lo que el código ya hace o lo que dicta el framework; no inventes reglas que nadie va a seguir. -->

Convenciones de **nombres y estructura** del código de {{CAPA}}.

---

## 0. Quién manda sobre qué (para no duplicar herramientas)

- **{{FORMATEADOR}}** manda sobre el **formato** (sangría, llaves, comillas, orden de imports). No se formatea a mano.
- **{{ANALIZADOR}}** manda sobre los **tipos**.
- **Este documento** manda sobre los **nombres y la estructura**.
- Los nombres de objetos de base de datos los gobierna el ADR (`D6.x`) y el ERD, no este documento.

## 1. Idioma de los identificadores

**Código en {{IDIOMA_CODIGO}}. Contenido de cara al usuario en {{IDIOMA_UI}}.**

<!-- RELLENAR: qué va en cada idioma (identificadores, columnas, mensajes visibles, comentarios, descripciones de los tests, datos de seed, rutas del navegador) y un diccionario de dominio para los términos clave. Ejemplo (Track Studio): artista → `Artist`, producción → `Production`, canción → `Song`. Los valores de rol (`productor`, `artista`) son datos, no identificadores. -->

| Dominio ({{IDIOMA_UI}}) | Identificador ({{IDIOMA_CODIGO}}) |
| ----------------------- | --------------------------------- |
|                         |                                   |

## 2. Tabla de casing

| Elemento                       | Convención | Ejemplo |
| ------------------------------ | ---------- | ------- |
| Archivo de clase / componente  |            |         |
| Clase / tipo / interface       |            |         |
| Función / método               |            |         |
| Variable / propiedad           |            |         |
| Constante                      |            |         |
| Caso de enum                   |            |         |
| Ruta (API o navegador)         |            |         |
| Variable de entorno            |            |         |

## 3. Tipos de artefacto y sufijos

<!-- RELLENAR: un sufijo por responsabilidad (Controller, Service, Request, Resource, Policy, Page, Form, hook use*…), con un ejemplo del dominio real. El sufijo dice qué capa arquitectónica es. -->

| Tipo | Convención | Ejemplo |
| ---- | ---------- | ------- |
|      |            |         |

## 4. Funciones y métodos

- Verbo primero. Booleanos con prefijo `is`/`has`/`can`.
- Los métodos estándar del framework (p. ej. los verbos de un controlador de recurso) no se renombran.
- Los servicios usan verbos de negocio del dominio, no un CRUD anémico que solo reenvía.

## 5. Variables

- Descriptivas; nada de `data`, `tmp` o `a` a secas.
- Colecciones en plural y entidades en singular.
- Sin abreviaturas, salvo las universales del dominio (`id`, `url`).

## 6. Estructura de carpetas

| Carpeta | Qué va |
| ------- | ------ |
|         |        |

## 7. Migraciones / esquema (si aplica)

- Nombre del archivo: acción en `snake_case`, verbo al inicio (`create_x_table`, `add_y_to_x_table`).
- **Una intención por migración.**
- **Nunca se edita una migración ya aplicada en algún entorno**: se crea una nueva.

## 8. Tests

- Archivo: …
- Descripción del caso: una frase en {{IDIOMA_DOCS}} que describe el comportamiento observable, idéntica a la columna "Test" de la spec.
- **Un comportamiento por test.** Si el nombre necesita una "y", probablemente son dos tests.
- Datasets con clave descriptiva, no con índices numéricos.
- El test afirma la **forma** del resultado (campos, códigos), no solo el estado, y se prueba en rojo (C3).

## 9. Interfaces de frontera (si aplica)

Solo en los límites externos del sistema (almacenamiento, correo, pagos…): `{Capacidad}Contract` o la convención del lenguaje, con una implementación nombrada por la tecnología. No se crean interfaces para el dominio propio con una sola implementación.

## Fuentes

<!-- RELLENAR: guía de estilo oficial del lenguaje, documentación del framework y números del ADR. -->
