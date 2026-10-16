# Lecciones transversales

Trampas que costaron tiempo en proyectos anteriores y que **no dependen del stack**. Vienen precargadas del primer proyecto que usó este kit (Track Studio, 25 handoffs). Cada proyecto añade las suyas al consolidar handoffs (`PLANTILLA-HANDOFF.md`, regla de consolidación) y borra las que no apliquen.

Formato: la trampa, el síntoma y qué hacer.

---

## Tests que no pueden fallar (C3)

- **Un test tiene que fallar por lo que afirma, no de rebote.** Un test de "404 si el recurso no existe" nace verde si la ruta tampoco existe, porque una ruta inexistente también da 404. Antes de afirmar el 404 de negocio, se comprueba que la ruta existe (un helper tipo `exigirRuta()`).
- **Un test que nace verde** sin implementación se borra, o se justifica como guardarraíl con un comentario en el archivo.
- **Un simulador que responde a cualquier petición esconde errores de destino.** Si el mock de la API devuelve 200 a todo `GET`, una navegación a un id equivocado pasa. Se afirma también la URL exacta de la petición siguiente.
- **Para probar que la UI pinta la respuesta del servidor, la respuesta tiene que diferir de lo que se escribió.** Si son iguales, quitar la actualización con la respuesta no se detecta.
- **Una mutación que solo toca una capa puede sobrevivir porque otra capa la tapa** (p. ej. el controlador deja pasar un campo, pero el servicio lo vuelve a filtrar). En C3 se mutan todas las capas implicadas.
- **Mutaciones equivalentes:** `count()+1` y `max+1` coinciden mientras no hay huecos. El dato de prueba debe tener huecos para distinguirlas.
- **Desempates de orden:** si los ids se generan ordenados por tiempo, la base "acierta" el desempate por azar. Se fijan los ids a mano y se usan varios empatados.
- **Un componente que se desmonta oculta estado colgado.** En diálogos y estados controlados se prueba el ciclo de ida y vuelta (abrir → cerrar → reabrir).
- **Una aserción sobre un valor nulo puede dar *error* en lugar de *fallo*.** Se afirma el tipo primero.
- **El runner puede clasificar como "error" lo que el script de C3 busca como "failed".** El script que cuenta mutaciones en rojo debe contar los dos estados.
- **El resumen compacto del runner puede ocultar qué tests fallaron.** Para el review de C3 se usa un reporte detallado (JUnit o similar) en una ruta ignorada por git.

## Contratos y fronteras (C4)

- **El CI tiene que correr contra el mismo motor de base de datos que producción.** Si `.env.example` apunta a un motor en memoria, el CI prueba otra cosa.
- **Variables de entorno vacías en el CI** pueden romper el SDK de un proveedor externo con un 500 que en local no aparece. Todo test que use la frontera configura explícitamente su entorno de prueba. Para reproducirlo, se corre la suite con esas variables vacías.
- **Los tests leen el `.env` local.** Si la configuración de tests no fija un valor (idioma, zona horaria), la suite pasa en el CI y falla en una máquina concreta, o al revés. Se fija en la configuración de tests.
- **Errores que dependen de cabeceras** (p. ej. un 401 frente a un redirect según `Accept`): los tests de "sin credenciales" también prueban sin la cabecera.

## Datos y migraciones

- **Una migración nueva no llega sola a la base local.** Si la suite recrea el esquema en cada ejecución, pasa aunque nadie haya migrado la base de desarrollo. Síntoma: error de "relación no existe" al probar a mano. Antes de probar a mano una HU con migración, se revisa el estado de las migraciones.
- **Nunca se edita una migración ya aplicada en algún entorno.** Se crea una nueva. Editarla obliga a resetear ese entorno, y producción fallará igual.
- **Plataformas que migran solas en cada deploy:** algunos hostings ejecutan las migraciones sin que el repo lo pida. Es una decisión de hecho sobre "migraciones en deploy"; se registra en el ADR.
- **Un método de esquema puede ser válido sintácticamente pero incompatible con el motor** (p. ej. una FK de tipo ULID hacia una PK UUID). El linter no lo ve; solo falla al migrar, con 0 aserciones en todos los tests.
- **Restricciones sin nombre:** el motor les asigna uno automático e inestable. Para traducir errores de restricción a 422 de forma estable, se nombran explícitamente.
- **Un valor por defecto que solo existe en la base de datos** no está en la instancia en memoria tras crearla. Se recarga la instancia antes de serializarla.
- **Un id con formato inválido** (no UUID) puede llegar a la base y dar 500. Se restringe el formato en la ruta.
- **Carreras en la unicidad:** validar y luego insertar deja una ventana; la base protege el dato, pero la segunda escritura puede dar 500. Se acepta explícitamente (con su supuesto) o se traduce el error de la base.
- **Probar DDL contra el motor real sin dejar rastro:** se ejecuta dentro de `BEGIN … ROLLBACK`.

## Tipos, build y herramientas

- **El runner de tests puede no comprobar tipos.** Un import olvidado o un tipo roto pasa los tests y rompe el build. La cadena de calidad incluye siempre el chequeo de tipos.
- **Un error de módulo tumba todo el archivo de test**, no solo el caso nuevo. Durante la fase roja, un test que importa un módulo de otra HU que aún no existe pone en rojo todo su archivo.
- **Al mover código entre archivos, revisa los imports que quedan sin uso:** rompen el lint y el build, no los tests.
- **Parámetros de ruta sin tipar:** un nombre mal escrito compila, se resuelve como cadena vacía y produce URLs como `/recurso//hijo`. Solo lo detecta un test que compare la URL exacta.
- **Los generadores (scaffolding, componentes, stubs) traen valores por defecto peligrosos**: autorización en `false`, dependencias de más, imports a paquetes equivocados. Se revisa el diff de cada generador, en especial los manifiestos de dependencias.
- **El formateador del editor puede no coincidir con el del proyecto.** Se configura el editor con el formateador del repo, o se corre antes de cada commit.
- **Texto pegado en el código** (bloques de markdown dentro de un archivo fuente): se revisa `git diff` antes de correr la suite.
- **Cachés de herramientas con el dueño equivocado** (creadas por root dentro de un contenedor) dan errores de escritura sin relación aparente. Se borra la caché.

## Entorno y despliegue

- **Puertos y URLs locales:** la URL configurada de la app no siempre es la que sirve el contenedor. Se verifica el puerto real antes de apuntar el cliente al servidor local.
- **El `.env` del cliente puede apuntar a staging** sin que se note. Se revisa antes de probar contra el servidor local.
- **Modo debug en staging o producción** expone SQL y valores en los errores. Se verifica que está desactivado en cada entorno desplegado.
- **Alias de despliegue por rama:** no están registrados en el proveedor de identidad ni en CORS. Se usa siempre la URL canónica del entorno.
- **Tokens de prueba del proveedor de identidad** (máquina a máquina) no traen los claims de usuario. Para probar roles, se usa un token real copiado de la petición del navegador.
- **Shells no POSIX** (fish, PowerShell) interpretan distinto la redirección y las flags tras un argumento. Las flags van antes del nombre y los secretos se leen con el comando de lectura oculta del shell, nunca pegados en la línea.

## Gestión y documentación

- **El ID de importación no es la clave del tablero.** Se usa solo la clave verificada en `key-map.md`.
- **Nunca se reimporta un lote.** Ante un éxito parcial, se crea solo lo que falta.
- **Conectores del tablero caídos:** si la sesión no puede escribir en el tablero, se anota en el handoff qué queda pendiente del lado humano. No se da por sincronizado.
- **Merges de documentación:** se compara el resultado con los dos padres, porque pueden reaparecer secciones duplicadas.
- **Una solución temporal se marca como tal** en la spec y en el handoff, con el ticket que la sustituye. Si no, se vuelve permanente.
- **Documentos externos (tesis, contrato) arrastran drift** cuando el ADR corrige una versión o una herramienta. Se lista lo pendiente de arrastrar en el `CLAUDE.md` (§6) hasta corregirlo.
