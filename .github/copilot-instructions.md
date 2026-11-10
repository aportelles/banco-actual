# Instrucciones de desarrollo para Copilot

## Contexto del proyecto
- Este proyecto es un sitio web de WordPress que está siendo modernizado y mejorado.
- El objetivo principal es refactorizar el código heredado hacia estándares modernos de WordPress, mejorar el rendimiento y reforzar las buenas prácticas de seguridad.

## Objetivos de calidad
- Mantener un código limpio, mantenible y consistente con los estándares actuales del proyecto.
- Priorizar rendimiento, legibilidad, escalabilidad y seguridad.
- Evitar soluciones obsoletas o deprecadas de WordPress.
- Mantener un estilo visual coherente en toda la interfaz.

## Reglas de trabajo y aprobación
- Antes de aplicar cualquier cambio en el código, se debe pedir aprobación explícita del usuario.
- No se deben hacer modificaciones automáticas ni por iniciativa propia sin confirmación previa.
- Los cambios deben ser claros, específicos y limitados al alcance solicitado por el usuario.
- Si se detecta un problema o mejora útil, se debe comunicar y esperar la aprobación antes de implementarla.
- La modificación de archivos existentes debe mantenerse dentro del contexto pedido y evitar cambios no solicitados.

## Estándares visuales
- La tipografía debe mantenerse uniforme con fuentes del proyecto, priorizando "The Sans" y "The Serif".
- Los encabezados deben respetar una jerarquía clara y consistente para H1 a H6.
- Los párrafos, listas, botones y componentes deben seguir una escala tipográfica y un espaciado consistente.
- La paleta oficial del proyecto debe definirse y centralizarse para su uso en todo el código y en los estilos CSS.
- Los colores no deben repetirse de forma aislada ni hardcodearse en distintos archivos; deben reutilizarse desde una definición central de tokens o variables CSS.
- El diseño debe ser responsive y adaptable a distintos tamaños de pantalla y dispositivos.
- Se debe mantener coherencia visual en colores, márgenes, tipografías, sombras, bordes y espaciados.

## Seguridad y buenas prácticas
- Se deben usar funciones modernas y seguras de WordPress.
- Todo dato recibido del usuario o proveniente de formularios debe sanitizarse adecuadamente con funciones como `sanitize_text_field()`, `sanitize_email()`, `sanitize_url()`, etc.
- Todo contenido impreso en la interfaz debe escaparse con funciones adecuadas como `esc_html()`, `esc_attr()`, `esc_url()`, etc.
- No se deben usar consultas SQL directas si existe una alternativa segura con WordPress.
- Se debe validar y sanitizar cualquier entrada antes de almacenarla o mostrarla.
- Se debe evitar código inseguro, duplicado o poco mantenible.

## PHP y WordPress
- Se deben utilizar funciones nativas y modernas de WordPress siempre que sea posible.
- Se recomienda seguir las prácticas actuales de desarrollo de WordPress y evitar patrones obsoletos.
- Se debe mantener una separación clara entre lógica de negocio, presentación y configuración.
- El código debe ser fácil de mantener y reutilizable en futuras ampliaciones del sitio.

## Gutenberg y desarrollo visual
- Cuando se creen nuevos elementos visuales, se debe priorizar la API moderna de bloques de Gutenberg.
- Para componentes visuales complejos, se recomienda usar React y la librería `@wordpress/blocks`.
- Se deben evitar shortcodes y maquetadores antiguos salvo que exista una justificación técnica clara.
- Los bloques creados deben seguir una estructura clara, reutilizable y consistente con el resto del proyecto.

## Accesibilidad
- Se deben respetar buenas prácticas de accesibilidad visual y funcional.
- Los contrastes de color deben ser adecuados para una lectura cómoda.
- Los elementos interactivos deben tener estados visuales claros y accesibles.
- El contenido debe mantenerse legible y usable en distintos dispositivos y tamaños de pantalla.
- Se deben priorizar experiencias inclusivas para usuarios con diferentes necesidades.

## Comentarios en el código
- Los comentarios deben usarse solo cuando aportan valor real y clarifican decisiones complejas.
- No se deben añadir comentarios redundantes ni explicaciones obvias del código.
- Evitar comentarios genéricos que repitan lo que el propio código ya expresa claramente.
- Cuando se incluya un comentario, debe ser breve, preciso y útil para futuras mantenedoras o mantenedores.

## No hacer
- No hacer cambios sin previa aprobación del usuario.
- No introducir cambios no solicitados ni ampliar el alcance de una tarea sin confirmación.
- No duplicar estilos, reglas CSS o componentes visuales si ya existen soluciones reutilizables.
- No dejar código obsoleto, pruebas temporales o console.log() en producción.
- No crear comentarios innecesarios ni documentación redundante dentro del código.
- No introducir dependencias nuevas sin justificar su necesidad y sin aprobación previa.

## Buenas prácticas de código
- Mantener un código legible, consistente y fácil de mantener.
- Preferir soluciones simples y directas frente a soluciones complejas o poco claras.
- Organizar el código por responsabilidades y reutilizar lógica cuando sea posible.
- Mantener nombres de variables, funciones y clases claros, descriptivos y consistentes.
- Evitar duplicación de lógica y favorecer la reutilización de componentes y utilidades.
- Aplicar buenas prácticas de rendimiento sin sacrificar claridad ni mantenibilidad.

## Paleta oficial del proyecto
- La paleta oficial del proyecto debe definirse de forma centralizada y reutilizable en todo el código y en los estilos CSS.
- Se debe evitar el uso de colores sueltos o hardcodeados en varios archivos si ya existen variables o tokens definidos para el proyecto.
- Los colores deben organizarse por función semántica, por ejemplo: primario, secundario, fondo, texto, éxito, advertencia, error, borde y hover.
- Toda nueva paleta o modificación del proyecto debe comunicarse y aprobarse antes de aplicarse.
- Cuando se trabaje con CSS, se recomienda usar variables CSS o tokens para mantener consistencia y facilitar futuras actualizaciones.

## Cambios recientes del proyecto (últimas 72 horas)
- Se debe mantener un registro actualizado de los cambios realizados en el proyecto durante las últimas 72 horas.
- Cada entrada debe incluir la fecha, una descripción breve del cambio y, si aplica, la referencia al archivo o módulo afectado.
- El registro debe actualizarse con cada cambio relevante y eliminarse o archivarse automáticamente cuando supere las 72 horas.
- Los cambios antiguos deben mantenerse fuera del registro activo para evitar información desactualizada o redundante.
- El objetivo es que el historial reciente sea claro, útil y fácilmente revisable para quien continúe el trabajo.
- El registro activo debe ubicarse en `.github/CHANGELOG-72H.md` y debe mantenerse como archivo separado del documento de instrucciones.

## Mantenimiento y consistencia
- Los cambios deben respetar la estructura general del proyecto y no introducir inconsistencias visuales o de código.
- Los estilos deben mantenerse centralizados y reutilizables.
- Se debe evitar duplicar lógica, CSS o patrones visuales en múltiples ubicaciones.
- Siempre que sea posible, se debe favorecer la reutilización de componentes y estilos ya existentes.