# Backlog oficial

**Estado:** baseline oficial de alcance y trazabilidad desde AAAA-MM-DD. Que un ticket sea oficial no lo convierte en Ready ni compromete su fecha de entrega.

## Autoridad y uso

Este backlog descompone [el roadmap](roadmap.md) y sigue el [formato común](backlog-format.md). Prevalecen el ADR, el `CLAUDE.md` y la [metodología](../global/metodologia-sdd-tdd.md). El alcance proviene de <!-- documento fuente -->.

Antes de cargar el backlog en {{TRACKER}}, este catálogo es su diseño. Después, {{TRACKER}} es la fuente de verdad y aquí solo se conserva el diseño; las claves reales están en [`key-map.md`](key-map.md).

## Catálogo de épicas

| ID local | Clave | Épica | Resultado y límites | Contenido | Ventana |
| -------- | ----- | ----- | ------------------- | --------- | ------- |
| `{{PREFIJO_LOCAL}}-epic-infra` | — | Infraestructura y entornos | Repositorio, CI/CD, modelo de datos, entornos y proveedores externos configurados por el equipo. | HU-01, … | S1-SN |
| `{{PREFIJO_LOCAL}}-epic-quality` | — | Calidad y aceptación | Pruebas integrales, verificación de RNF y aceptación con el cliente. | … | S2-SN |
|  |  |  |  |  |  |

<!-- RELLENAR: una épica por módulo funcional (resultado acotado y límites claros), más las transversales de infraestructura, calidad y documentación. Toda Task de infraestructura cuelga de la épica de infraestructura, aunque bloquee a otra épica. -->

## Historias

| ID local | HU | Épica | Título | SP | Release | Sprint objetivo | Capa | Riesgo |
| -------- | -- | ----- | ------ | -: | ------- | --------------- | ---- | ------ |
| `{{PREFIJO_LOCAL}}-01` | HU-01 | | | | | | | |

## Tasks

| ID local | Épica | Título | Bloquea a | Ventana |
| -------- | ----- | ------ | --------- | ------- |
|          |       |        |           |         |

## Cobertura del alcance aprobado

| Requerimiento | Épica principal | Cobertura complementaria |
| ------------- | --------------- | ------------------------ |
| RF-01 …       |                 |                          |
| RNF-01 …      |                 |                          |

Cada RF y RNF tiene al menos una épica principal. Los elementos sin respaldo en RF quedan pendientes de decisión (ver roadmap) y no tienen ticket.
