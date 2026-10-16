# Anexo Jira — mapeo e importación del backlog

Aplica el [formato común](../backlog-format.md) a Jira Cloud. Si el tracker no es Jira, borra esta carpeta.

## Mapeo de campos

| Campo local        | Destino en Jira                                                         |
| ------------------ | ----------------------------------------------------------------------- |
| `local_id`         | Etiqueta `local-<local_id>`.                                            |
| `issue_type`       | Work type.                                                              |
| `summary`          | Summary.                                                                |
| `parent_id`        | Parent.                                                                 |
| `description`, `acceptance`, `checklist` | Description (en ese orden), sin filas CSV adicionales por casilla. |
| `release`          | Etiqueta `release-r1`… (o Fix version si está habilitada).              |
| `target_sprint`    | Sprint real si existe; si no, etiqueta `target-s3`…                     |
| `story_points`     | Story point estimate.                                                   |
| `priority`         | P0 → High, P1 → Medium, sin crear valores nuevos.                       |
| `layer`            | Etiqueta `capa-<valor>`.                                                |
| `risk`             | Etiqueta `riesgo-<valor>`.                                              |
| `definition_state` | Etiqueta `backlog-oficial`, `pendiente-decision` o `ready`.             |
| `status`           | To Do al importar; luego el workflow real.                              |
| `owner`            | Assignee; no se duplica en la Description.                              |
| `blocked_by`       | Enlace Blocks: el predecesor bloquea al sucesor.                        |
| `external_blocker` | Sección "Dependencia externa"; si afecta a varios tickets, Task + enlaces. |
| `evidence`         | Comentario o Description posterior, sin datos sensibles.                |

Etiqueta adicional por lote: `lote-<nombre>` (p. ej. `lote-inicial`), para poder auditarlo.

## Preparación del CSV

1. Confirmar Jira Cloud, el proyecto `{{PREFIJO_TICKET}}`, los tipos Epic/Story/Task/Bug, el campo Story point estimate, los valores de prioridad y los permisos de importación.
2. Generar una fila por ticket explícito: épicas, Story, Task y los Sub-task o Bug justificados. Las casillas no generan filas.
3. Asignar un `Work item ID` numérico solo para la importación (p. ej. épicas `1001+`, Story y Task `11NN` a partir de su `local_id`) y mantener la tabla `local_id → import_id → clave real` en [`../key-map.md`](../key-map.md).
4. Incluir cada checklist completa en la Description. Serializar en UTF-8 sin BOM, con separador coma, todas las celdas entre comillas dobles y saltos de línea LF dentro de la Description. Verificar que no se pierden saltos de línea ni tildes.
5. Mapear Work item ID, Work type, Summary, Description, Parent, Priority, Story point estimate y **todas** las columnas Labels (una columna `Labels` repetida por etiqueta).
6. Usar el **importador de sistemas externos**: el CSV simple de creación masiva no conserva la jerarquía.
7. En la vista previa, comprobar el número de filas y de columnas. Detenerse si aparece una sola columna o un conteo distinto.
8. **Importar primero una muestra** (una Epic y una Story con un enlace Blocks), registrar las claves devueltas y comprobar padre, casillas y dirección del bloqueo. La muestra forma parte del lote; al importar el resto, se quitan esas filas.
9. Importar el resto. Si el importador no resuelve los enlaces Blocks entre IDs locales, hacer una segunda pasada con las claves reales.
10. Verificar conteos de tickets y casillas, padres, etiquetas, SP, sprint y ausencia de duplicados.

El importador conserva las casillas como texto; no se asume que convierta Markdown en casillas nativas.

## Trampas

- **Nunca se reimporta un CSV de creación.** Ante un éxito parcial, se consulta Jira y se prepara un archivo mínimo con lo que falta. Una replanificación se aplica moviendo tickets, no reimportando.
- **El ID de importación no es la clave de Jira.** Nombrar ramas o commits con el ID del CSV produce colisiones. Solo vale la clave registrada en `key-map.md` después de importar.
- **Claves de un tablero anterior** que aparecen en commits antiguos quedan como historial; no se reutilizan ni se reescriben.
- **Un CSV importado es un artefacto histórico.** Se conserva en `imports/` con un README que dice "no reimportar" y el resultado (conteos, claves devueltas).
- **Trabajo hecho antes del tablero:** se importa en To Do y se mueve a Done a mano con su evidencia (PR, CI), nunca como Done directamente.

## Archivos

- [`plantilla-import.csv`](plantilla-import.csv): cabecera y una fila de ejemplo por tipo.
- `imports/<lote>.csv` + `imports/README.md`: cada lote real, con su resultado. <!-- RELLENAR: créalos al importar. -->
