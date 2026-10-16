# Roadmap de desarrollo

**Estado:** baseline <!-- borrador | oficial --> aprobada el AAAA-MM-DD.

## Propósito y autoridad

Este documento ordena el desarrollo de {{PROYECTO}} en {{NUM_SPRINTS}} sprints de {{DURACION_SPRINT}}, agrupados en releases, y gobierna su secuencia en {{TRACKER}}. No reemplaza al ADR, al `CLAUDE.md` ni a la metodología. Ante una contradicción, prevalecen esos documentos.

El alcance proviene de <!-- RELLENAR: documento fuente (requisitos, tesis, contrato) -->: RF-01..RF-NN, RNF-01..RNF-NN y NN historias. Las historias y sus criterios de aceptación viven en {{TRACKER}}; este roadmap solo las asigna a una ventana objetivo.

## Supuestos de planificación

- Inicio: {{FECHA_INICIO}}. Fecha límite: <!-- AAAA-MM-DD -->. Zona horaria: <!-- … -->.
- {{NUM_SPRINTS}} sprints de {{DURACION_SPRINT}}. Si un sprint cumple su objetivo antes, se continúa con el siguiente sin esperar al calendario (flujo continuo).
- Estimación Fibonacci (1, 2, 3, 5) sin traducción directa a horas. Backlog: NN HU y NN SP.
- Capacidad: <!-- personas × horas por sprint -->. Specs, tests, revisión, integración, correcciones, documentación e infraestructura humana consumen esa misma capacidad. No se contabilizan horas de agentes ni se asume un multiplicador.
- Ciclo SDD/TDD en modo {{MODO_ROLES}} (metodología §2).
- Cada sprint cierra con un incremento demostrable en staging (merge a `{{RAMA_INTEGRACION}}`). Solo el último release se despliega a producción.

## Hitos de avance

| Hito | Semana | Fecha límite | Condición |
| ---- | -----: | ------------ | --------- |
|      |        |              |           |

## Releases

| Release | Sprints | Semanas | Resultado esperado | Ambiente |
| ------- | ------- | ------- | ------------------ | -------- |
| R1 —    |         |         |                    | Staging  |

Un release es liberable solo cuando todas sus historias cumplen la Definition of Done.

## Distribución de alcance y capacidad

| Sprint    | Ventana | HU principales | SP de HU | Reserva transversal | Capacidad objetivo |
| --------- | ------- | -------------- | -------: | ------------------: | -----------------: |
| S1        |         |                |          |                     |                    |
| **Total** |         |                |          |                     |                    |

<!-- RELLENAR: si hay historias transversales de calidad (pruebas integrales, RNF, aceptación), reserva SP equivalentes en cada sprint y ciérralas en el último. Así QA no se concentra al final. Los SP se cuentan una sola vez. -->

## Secuencia objetivo por sprint

| Sprint | Historias y trabajo transversal | Demostrable al cierre | Riesgo o dependencia principal |
| ------ | ------------------------------- | --------------------- | ------------------------------ |
|        |                                 |                       |                                |

### Cobertura de requerimientos

| Requerimiento | Historias | Sprint(s) |
| ------------- | --------- | --------- |
|               |           |           |

## Flujo continuo y control de capacidad

- La ventana de cada sprint es un máximo. Si todas sus historias cumplen Done antes, se inicia el siguiente con historias Ready.
- Nunca se adelanta una historia bloqueada por un punto ABIERTO del ADR o por infraestructura imprescindible.
- En cada corte de mitad y fin de sprint se compara la velocidad real con la meta. Dos cortes consecutivos por debajo obligan a decidir entre aumentar capacidad, reducir esperas externas o renegociar la fecha. <!-- RELLENAR: ¿el alcance es una palanca autorizada? -->
- Todo arrastre se registra con la capacidad reasignada y su efecto sobre los gates. No se absorbe de forma invisible.

## Reglas de alcance

- Lo que no se recorta para cumplir la fecha: <!-- seguridad, pruebas, aceptación… -->
- Fuera del alcance: <!-- lista explícita -->
- Elementos de prototipos sin respaldo en RF: no entran al roadmap hasta una decisión formal.

## Track paralelo: ADR, infraestructura y documentación

| Periodo | Entregable |
| ------- | ---------- |
|         |            |

## Gates y dependencias externas

- **SN:** <!-- qué debe estar decidido o configurado antes de qué historia -->
- {{SERVICIOS_EXTERNOS}} los configura el equipo humano. El agente documenta la dependencia y se detiene.

## Discrepancias a reconciliar

| Discrepancia | Dónde | Acción |
| ------------ | ----- | ------ |
|              |       |        |

## Gobierno en {{TRACKER}}

{{TRACKER}} es la fuente de verdad operativa; el mapa vigente de claves está en [`key-map.md`](key-map.md). Una replanificación se aplica moviendo los tickets existentes, nunca reimportando un lote.

## Siguiente paso

1. …
