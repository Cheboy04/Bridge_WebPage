# Mapa vigente de claves de {{TRACKER}}

**Fuente de verdad:** {{TRACKER}}, proyecto `{{PREFIJO_TICKET}}`.
**Última verificación:** AAAA-MM-DD.

Este mapa evita confundir los IDs locales del backlog (y las claves de tableros anteriores) con las claves actuales. {{TRACKER}} manda: si una fila difiere del tablero, se corrige aquí **después** de corregir el tablero. Antes de crear una rama, la clave se verifica aquí o en el tablero, nunca se deduce.

## Baseline cargada

| Alcance           | ID local                                  | Clave actual                                   |
| ----------------- | ----------------------------------------- | ---------------------------------------------- |
| Épicas            | `{{PREFIJO_LOCAL}}-epic-…`                | `{{PREFIJO_TICKET}}-1` … `{{PREFIJO_TICKET}}-N` |
| HU-01 … HU-NN     | `{{PREFIJO_LOCAL}}-01` … `{{PREFIJO_LOCAL}}-NN` | …                                         |
| Tasks del backlog | …                                         | …                                              |

<!-- Si la correspondencia dentro de cada rango es consecutiva, dilo con un ejemplo (HU-01 = X-12, HU-02 = X-13). Si no, una fila por ticket. -->

## Trabajo creado después de la carga

| Clave | Tipo | Título | Origen (sesión, handoff) |
| ----- | ---- | ------ | ------------------------ |
|       |      |        |                          |

## Claves históricas que no se reutilizan

<!-- Claves de un tablero anterior que aparecen en commits o ramas antiguas. Quedan como historial y no se reescriben. -->
