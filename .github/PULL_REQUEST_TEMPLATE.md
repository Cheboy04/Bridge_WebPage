<!--
  Plantilla de PR de {{PROYECTO}}.
  Título = mensaje de commit, según docs/global/reglas-git.md §3.
  Rama: feature/{{PREFIJO_TICKET}}-<id>-<slug> (o fix/* / hotfix/*), hacia {{RAMA_INTEGRACION}}.
-->

## Historia / tarea

- Ticket: {{PREFIJO_TICKET}}-
- Spec: `docs/specs/…`
<!-- SI TOPOLOGIA=multirepo -->
- PR relacionadas en otros repos:
<!-- /SI -->

## Qué cambia

<!-- Qué se añadió, modificó o quitó, y por qué. Las decisiones nuevas deben estar ya en la spec o en el ADR. -->

## Cómo se probó

<!-- Qué tests cubren el cambio y cómo verificarlo a mano. Un criterio de aceptación que no se puede verificar no cuenta como probado. -->

- [ ] Tests añadidos o actualizados y vistos en rojo antes de la implementación (C2)
- [ ] Cada test no trivial probado rompiéndolo (C3): N mutaciones, M sobrevivieron y quedaron justificadas en la spec
- [ ] Verificado en local

## Checklist de review

- [ ] La spec está actualizada y sin drift con el código
- [ ] Sin secretos, `.env` ni datos reales del cliente en el diff
- [ ] Lockfiles commiteados si cambiaron las dependencias
- [ ] Nombres según la nomenclatura y el ADR
- [ ] Handoff actualizado

### Captura (si cambia algo visible)

## CI

- [ ] Pipeline en verde

## Notas para quien revisa

<!-- Contexto, decisiones de diseño, sitios donde quieres atención específica, soluciones temporales y qué ticket las sustituye. -->
