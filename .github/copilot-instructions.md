# Instrucciones de desarrollo para Copilot

## Contexto del Proyecto
- Este es un proyecto de WordPress antiguo que se está modernizando y mejorando.
- El objetivo es refactorizar el código antiguo hacia estándares modernos de WordPress, mejorar el rendimiento y aplicar buenas prácticas de seguridad.

## Reglas de Codificación y Estilos
- **Tipografía:** Toda la interfaz web debe estar unificada bajo las fuentes "The Sans" o "The Serif", configurando correctamente sus respectivos tamaños para encabezados (H1-H6), párrafos, listas y botones.
- **Colores:**usa la paleta de colores oficial del proyecto, asegurándote de mantener la consistencia en todos los elementos visuales.
- **Diseño:** El diseño debe ser adaptable a diferentes tamaños de pantalla y dispositivos.
- **PHP y WordPress:** Utiliza siempre funciones modernas de WordPress. Asegúrate de sanitizar y escapar todos los datos (`sanitize_text_field()`, `esc_html()`, `esc_attr()`, etc.).
- **Gutenberg:** Cuando se creen nuevos elementos visuales, prioriza la API moderna de bloques utilizando React y la biblioteca `@wordpress/blocks` en lugar de shortcodes o maquetadores antiguos.
