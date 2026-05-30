# AGENTS.md

Gobernanza obligatoria para cualquier agente de IA, asistente de desarrollo, entorno automatizado o sistema de generación de código que trabaje sobre este tema WordPress de UniVirtual.

Este archivo define el comportamiento operativo, el flujo de trabajo, las restricciones críticas, las prioridades de decisión, las validaciones obligatorias, las reglas transversales, el manejo de ambigüedad, la clasificación de cambios y la Definition of Done del proyecto.

---

# 0. Gobernanza del Proyecto

## Autoridad principal

Este `AGENTS.md` es la autoridad principal para el tema ubicado en:

`C:\xampp\htdocs\uniVirtual\web_local\wp-content\themes\uniVirtual`

Las reglas globales de Codex o de cualquier agente actúan únicamente como fallback cuando no contradigan este archivo.

## Jerarquía documental

Ante contradicción, respetar este orden:

1. `AGENTS.md` local del proyecto.
2. `README.md` del proyecto, cuando exista.
3. Documentación interna del proyecto, si existe.
4. Configuración real del código.
5. Reglas globales de Codex o IA.

## Regla de cercanía

Gana siempre la definición más cercana al proyecto. Nunca asumir comportamiento fuera de la documentación real ni de la evidencia del código.

---

# 1. Principios Globales

## Prioridad máxima

Todo cambio debe proteger, en este orden:

1. Seguridad.
2. Estabilidad WordPress.
3. Arquitectura existente del tema.
4. SEO / GEO / AEO.
5. Performance y Core Web Vitals.
6. Accesibilidad.
7. Mantenibilidad.
8. Consistencia visual y funcional.

## Reglas absolutas

- No escribir código sin comprender el requerimiento.
- No implementar funcionalidad sin SPEC previa.
- No asumir lógica de negocio no documentada.
- No asumir estructura ACF no verificada.
- No inventar endpoints, hooks, campos, CPTs, taxonomías, shortcodes, APIs, tablas, modelos, schemas, servicios ni plugins.
- No modificar manualmente archivos generados por Gulp.
- No romper compatibilidad con WordPress ni Yoast SEO.
- No degradar SEO, GEO, AEO, accesibilidad, responsive, performance ni seguridad.
- No introducir dependencias nuevas sin justificación técnica y confirmación.
- No eliminar código existente sin validar impacto y rollback.
- No hacer refactors amplios si el requerimiento es puntual.
- No dejar código temporal, `console.log`, `var_dump`, `print_r`, `die`, debugging, logs temporales, comentarios basura, mocks accidentales ni código muerto.
- No hardcodear secretos, tokens, credenciales, rutas sensibles ni datos privados.
- No asumir estructura del proyecto sin evidencia real.

## Comportamiento esperado del agente

El agente debe:

- Actuar con criterio conservador.
- Priorizar arquitectura existente.
- Mantener cambios mínimos, trazables y reversibles.
- Documentar riesgos relevantes.
- Validar antes de finalizar.
- Explicar incertidumbres.
- Solicitar confirmación cuando exista ambigüedad, riesgo alto o impacto no claro.
- Evitar sobreingeniería.
- Mantener consistencia estructural, visual y funcional.
- Reportar qué cambió, dónde cambió, cómo se validó y qué queda pendiente.

## Estándar de código limpio

Todo cambio debe favorecer código limpio, mantenible y escalable. La referencia visual de "código limpio vs código sucio" se adopta como criterio operativo del proyecto:

- Usar nombres descriptivos para variables, funciones, clases, hooks, handles de assets y archivos.
- Mantener funciones pequeñas, enfocadas en una sola responsabilidad y fáciles de probar manualmente.
- Separar consulta, normalización de datos, lógica de negocio y marcado HTML cuando el alcance lo permita.
- Reducir duplicación real antes de agregar nuevas ramas de código parecidas.
- Preferir estructuras claras y explícitas sobre abreviaturas crípticas o lógica compactada.
- Mantener comentarios solo cuando expliquen decisiones, restricciones, riesgos o contexto que el código no expresa por sí mismo.
- Manejar errores, estados vacíos y datos inesperados de forma explícita.
- Evitar side effects ocultos, dependencias globales innecesarias y acoplamiento entre templates.
- Diseñar cambios para crecer con el proyecto sin introducir abstracciones prematuras.
- Escribir código que otro desarrollador pueda leer, modificar y reutilizar sin reconstruir el contexto desde cero.

## Reglas de mantenibilidad y escalabilidad

- Antes de crear un archivo nuevo, validar si existe un módulo, helper, `template-part`, componente o asset fuente donde encaje naturalmente.
- Antes de ampliar un template grande, evaluar si el bloque debe vivir en `template-parts/` o `inc/components/`.
- Toda función PHP nueva debe usar un prefijo del tema o una convención local verificable para evitar colisiones en WordPress.
- Todo dato externo, de ACF, request, API o configuración debe validarse antes de usarse.
- Todo HTML generado desde PHP debe escapar salida según contexto.
- Todo JS nuevo debe validar existencia de nodos antes de operar y debe degradar de forma segura si el DOM esperado no existe.
- Todo SCSS nuevo debe mantener responsive, evitar selectores excesivamente específicos y no depender de estilos inline.
- Las decisiones que afecten varias páginas deben documentarse en SPEC y, si cambian operación o arquitectura, también en `README.md`.

---

# 2. Idioma, Encoding y Contenido

## Idioma oficial

Todo contenido textual del proyecto debe mantenerse en Español Colombia (`es-CO`), salvo que el proyecto defina explícitamente otro idioma para una pieza concreta.

## Encoding obligatorio

Todo archivo debe mantenerse en UTF-8.

## Restricciones

- No romper acentos.
- No romper caracteres especiales.
- No introducir mojibake.
- No guardar archivos como ASCII ni en codificaciones distintas a UTF-8.
- No guardar archivos en encoding incompatible.
- No mezclar formatos inconsistentes de salto de línea sin necesidad.
- No introducir Spanglish innecesario.
- No usar traducciones literales incorrectas.
- No agregar textos ambiguos, redundantes o fuera de tono.

## Revisión de contenido

Antes de finalizar cambios textuales, validar:

- Ortografía.
- Gramática.
- Consistencia semántica.
- Puntuación.
- Tono profesional.
- Terminología técnica consistente.
- Claridad, precisión, escaneabilidad y coherencia con marca y producto.

---

# 3. Detección Tecnológica Obligatoria

Antes de modificar código, el agente debe identificar con evidencia real:

- Framework o CMS.
- Runtime.
- Package manager.
- Sistema de build.
- Arquitectura.
- Estructura modular.
- Linters.
- Formatters.
- Test runners.
- CI/CD, si existe.
- Convenciones internas.
- Estrategia de rendering.
- SSR / CSR / SSG / ISR si aplica.

## Stack observado del tema

Con la evidencia actual del repositorio, este proyecto es un tema WordPress con:

- PHP para templates del tema.
- WordPress como CMS.
- Yoast SEO como compatibilidad crítica declarada por gobernanza.
- ACF como dependencia posible que nunca debe asumirse sin `function_exists( 'get_field' )` y validación de estructura.
- Node.js y npm por `package.json` y `package-lock.json`.
- Gulp 5 como flujo de build.
- Sass / SCSS fuente en `assets/scss/**/*.scss`.
- JavaScript fuente en `assets/js/**/*.js`.
- CSS y JS minificados generados en `assets/production/mincss/**` y `assets/production/minjs/**`.

## Regla estricta

Nunca asumir stack tecnológico, estructura ACF, plugins, endpoints, scripts o convenciones sin evidencia dentro del proyecto.

---

# 4. README Obligatorio

Todo proyecto debe mantener actualizado su `README.md`.

## Contenido mínimo del README

El `README.md` debe incluir como mínimo:

- Descripción del proyecto.
- Stack tecnológico.
- Requisitos.
- Instalación.
- Variables de entorno, si aplican.
- Scripts disponibles.
- Flujo de desarrollo.
- Flujo de build.
- Estructura principal.
- Convenciones relevantes.
- Ejecución de pruebas.
- Despliegue.
- Troubleshooting básico.
- Riesgos conocidos.

## Regla obligatoria

Si un cambio afecta arquitectura, instalación, comandos, infraestructura, dependencias, variables de entorno, CI/CD, flujos operativos, build o testing, el `README.md` debe actualizarse obligatoriamente.

Si el `README.md` no existe y el cambio requiere documentación operativa, el agente debe reportarlo y proponer su creación antes de cerrar el cambio.

---

# 5. Flujo Obligatorio SDD

Todo desarrollo debe seguir Spec-Driven Development.

## Flujo operativo

1. Comprender el requerimiento.
2. Identificar impacto técnico.
3. Definir SPEC proporcional al cambio.
4. Validar riesgos.
5. Definir Acceptance Criteria.
6. Validar SEO / GEO / AEO.
7. Solicitar confirmación si existe incertidumbre, riesgo alto o ambigüedad.
8. Implementar cambios únicamente en archivos fuente permitidos.
9. Validar resultado.
10. Confirmar cumplimiento del DoD.

## Regla estricta

Si no existe SPEC clara, no se debe escribir código funcional.

Para cambios menores, la SPEC puede ser breve, pero debe existir y cubrir alcance, impacto, riesgos, validación y rollback.

---

# 6. SPEC Obligatoria

Toda funcionalidad, corrección o ajuste estructural debe partir de una especificación clara.

## 1. Contexto

Definir:

- Problema actual.
- Necesidad de negocio.
- Objetivo esperado.

## 2. Objetivo funcional

Definir con precisión:

- Qué debe ocurrir.
- Qué debe mostrarse.
- Qué debe calcularse.
- Qué comportamiento debe existir.
- Qué debe mantenerse igual.
- Qué comportamiento cambia.

## 3. Alcance

Definir:

- Qué incluye.
- Qué no incluye.
- Qué archivos o componentes pueden tocarse.
- Qué áreas quedan fuera del cambio.

## 4. Impacto técnico

Identificar cuando aplique:

- Templates afectados.
- `template-parts`.
- Componentes.
- Layouts.
- Hooks.
- Funciones PHP.
- Queries.
- ACF.
- APIs.
- Servicios.
- Base de datos.
- Frontend.
- Backend.
- JS involucrado.
- SCSS / CSS fuente.
- Gulp.
- Assets.
- Performance.
- Accesibilidad.
- Seguridad.
- SEO / GEO / AEO.
- Compatibilidad con Yoast.

## 5. Riesgos

Evaluar:

- Riesgo de regresión.
- Riesgo de seguridad.
- Riesgo SEO.
- Riesgo GEO / AEO.
- Riesgo de performance.
- Riesgo de accesibilidad.
- Riesgo responsive.
- Riesgo de compatibilidad WordPress.
- Riesgo de compatibilidad con plugins.
- Riesgo de integraciones.

## 6. Acceptance Criteria

Definir condiciones verificables de éxito.

Cada criterio debe poder responderse con sí o no.

## 7. Validación

Definir cómo comprobar:

- Funcionamiento.
- Responsive.
- Accesibilidad.
- Performance.
- SEO / GEO / AEO.
- Ausencia de errores JS.
- Ausencia de errores backend o warnings PHP visibles.
- Encoding UTF-8 y acentos.
- Ortografía.

## 8. Rollback

Definir cómo revertir si falla:

- Archivos afectados.
- Cambios a deshacer.
- Comandos o pasos seguros.
- Riesgos posteriores al rollback.

---

# 7. Clasificación de Cambios

## Cambio trivial

Ejemplos:

- Corrección de typo.
- Ajuste de copy sin impacto SEO.
- Ajuste visual menor en fuente SCSS.

Requiere:

- SPEC breve.
- Validación puntual.
- Confirmar que no toca archivos generados.

## Cambio funcional

Ejemplos:

- Nueva sección.
- Cambio de comportamiento JS.
- Ajuste de template.
- Cambio de query.
- Cambio de campos ACF.
- Cambio UI.
- Nueva API o integración no crítica.

Requiere:

- SPEC completa.
- Validación técnica.
- Validación SEO / GEO / AEO.
- Validación responsive.
- Rollback claro.

## Cambio crítico

Ejemplos:

- Cambios en `functions.php`.
- Hooks globales.
- Queries principales.
- Formularios.
- Autenticación.
- Pagos.
- Seguridad.
- Schema.
- Metadata SEO.
- Build Gulp.
- Infraestructura.
- CI/CD.
- Base de datos.

Requiere:

- SPEC completa.
- Confirmación obligatoria si existe incertidumbre.
- Validación profunda.
- Revisión de seguridad.
- Plan de rollback explícito.

---

# 8. Arquitectura del Proyecto

## WordPress

- Mantener arquitectura modular.
- Priorizar `get_template_part()`.
- Evitar templates monolíticos.
- Mantener separación entre lógica y presentación.
- Mantener lógica reusable en helpers cuando corresponda.
- Evitar side effects globales.
- Evitar acoplamiento innecesario.
- Evitar modificar el loop principal sin necesidad.
- Restaurar estado global después de queries personalizadas con `wp_reset_postdata()`.

## Componentes

- Todo componente debe tener responsabilidad única.
- Todo componente debe ser reutilizable cuando tenga sentido.
- Mantener naming consistente con el proyecto.
- Evitar duplicación estructural.
- Evitar mezclar consulta, normalización de datos y markup complejo en el mismo bloque.
- Agregar abstracciones solo si reducen complejidad real, duplicación significativa o siguen un patrón local ya establecido.

## Queries

- Minimizar consultas repetidas.
- Evitar `WP_Query` innecesarios.
- Usar argumentos explícitos y seguros.
- Limitar cantidad de posts cuando aplique.
- Priorizar caching cuando aplique.
- No usar SQL directo salvo necesidad justificada.
- Si se usa SQL directo, debe pasar por `$wpdb`, preparar consultas con `$wpdb->prepare()` y validar entradas.

## Hooks

- Priorizar hooks nativos WordPress.
- Evitar sobrecargar hooks globales.
- Evitar callbacks anónimos cuando dificulten mantenimiento o remoción.
- Nombrar funciones con prefijo del tema o namespace equivalente.

## PHP

- Escapar salida según contexto.
- Sanitizar entrada.
- Validar tipos, formatos, rangos y valores permitidos.
- Validar existencia de funciones externas.
- Evitar lógica compleja en templates.
- Evitar errores fatales si un plugin está desactivado.
- Evitar acceso directo a archivos PHP cuando aplique.

---

# 9. Reglas WordPress

## Seguridad WordPress

- Escapar toda salida con funciones adecuadas:
  - `esc_html()`
  - `esc_attr()`
  - `esc_url()`
  - `wp_kses_post()`
  - `esc_js()` cuando aplique
- Sanitizar toda entrada con funciones adecuadas:
  - `sanitize_text_field()`
  - `sanitize_email()`
  - `sanitize_key()`
  - `absint()`
  - `intval()`
  - `wp_unslash()` antes de sanitizar datos de request
- Validar nonces en formularios, acciones AJAX y procesos mutables.
- Validar permisos con `current_user_can()` antes de acciones sensibles.
- Evitar acceso directo a PHP con guardas como:

```php
defined( 'ABSPATH' ) || exit;
```

## ACF

- Validar `function_exists( 'get_field' )` antes de depender de ACF.
- Validar existencia y tipo de campos.
- No asumir estructura de repeater, flexible content, relationship, image o link.
- Escapar campos ACF según contexto.
- No hardcodear estructuras complejas sin confirmación o evidencia en el código.

## Templates

- Evitar lógica compleja en templates.
- Priorizar helpers y `template-parts`.
- Mantener HTML semántico.
- Mantener jerarquía correcta de headings.
- Evitar duplicar bloques grandes.
- Evitar duplicar `h1` sin justificación.

## Compatibilidad

- Mantener compatibilidad con WordPress.
- Mantener compatibilidad con Yoast SEO.
- Mantener compatibilidad responsive.
- No duplicar metadata, canonicales o schema que Yoast ya controle.
- Validar funciones externas antes de usarlas cuando dependan de plugins.

---

# 10. Capas de Seguridad

La seguridad se valida por capas. Ninguna capa sustituye a otra.

## Capa 1: Entrada

- Toda entrada de usuario debe ser tratada como no confiable.
- Sanitizar `$_GET`, `$_POST`, `$_REQUEST`, cookies, payloads AJAX y datos externos.
- Usar `wp_unslash()` antes de sanitizar datos provenientes de WordPress request globals.
- Validar tipos, rangos, formatos y valores permitidos.
- Rechazar valores inesperados en lugar de corregir silenciosamente cuando el riesgo sea alto.

## Capa 2: Autorización

- Validar permisos antes de cualquier acción mutable.
- Usar capabilities específicas, no supuestos por rol.
- Validar ownership cuando aplique.
- No exponer información privada a usuarios no autorizados.
- No confiar en validaciones solo del frontend.

## Capa 3: Nonces y CSRF

- Todo formulario mutable debe tener nonce.
- Toda acción AJAX mutable debe validar nonce.
- Todo endpoint personalizado debe validar intención y permisos.
- Los nonces no reemplazan autorización.

## Capa 4: Persistencia

- Sanitizar antes de guardar.
- Validar campos requeridos y formatos.
- No guardar HTML arbitrario salvo necesidad explícita.
- Si se permite HTML, usar allowlists con `wp_kses()`.
- Evitar serializar datos inseguros o estructuras no validadas.

## Capa 5: Salida

- Escapar siempre según contexto.
- URLs con `esc_url()`.
- Atributos con `esc_attr()`.
- Texto plano con `esc_html()`.
- HTML permitido con `wp_kses_post()` o `wp_kses()` con allowlist.
- JSON con APIs WordPress o `wp_json_encode()`.

## Capa 6: Base de datos

- Preferir APIs WordPress.
- Evitar SQL directo.
- Si SQL directo es inevitable, usar `$wpdb->prepare()`.
- Nunca concatenar inputs en SQL.
- Limitar resultados.
- Considerar índices y performance.

## Capa 7: AJAX / REST / Integraciones

- Validar nonce o autenticación.
- Validar capabilities.
- Sanitizar payload.
- Escapar respuesta.
- No revelar paths internos, tokens, errores crudos o datos sensibles.
- Manejar errores con respuestas controladas.
- Manejar timeouts y estados vacíos cuando aplique.

## Capa 8: Frontend

- No confiar en el frontend para seguridad.
- Evitar insertar HTML con datos no confiables.
- Evitar `innerHTML` salvo contenido controlado y sanitizado.
- Evitar exponer claves, tokens o datos internos en JS.
- Evitar listeners globales innecesarios.

## Capa 9: Archivos y uploads

- Validar tipo MIME.
- Validar extensión.
- Validar tamaño.
- Usar APIs WordPress para uploads.
- No ejecutar archivos subidos.
- No construir rutas con input sin normalización.

## Capa 10: Secretos y configuración

- No hardcodear secretos.
- No exponer credenciales en templates, JS, CSS o HTML.
- No registrar tokens en logs.
- No subir archivos `.env`, backups, dumps, llaves privadas, tokens ni credenciales.

---

# 11. SEO / GEO / AEO

## Principio

Todo cambio debe preservar o mejorar la capacidad del sitio para ser entendido por buscadores, asistentes de IA y motores de respuesta.

## SEO técnico

- Mantener jerarquía de headings correcta.
- No duplicar `h1` sin justificación.
- Mantener canonicales gestionados por Yoast cuando aplique.
- No duplicar metadata de Yoast.
- Preservar crawlability e indexabilidad.
- Mantener enlaces internos relevantes.
- Evitar contenido oculto engañoso.
- Evitar cambios que generen thin content.
- Validar slugs, títulos, breadcrumbs y estructura semántica cuando aplique.

## GEO

- Hacer contenido interpretable por IA.
- Usar contexto explícito.
- Nombrar entidades claramente.
- Evitar textos ambiguos que dependan solo de diseño visual.
- Mantener estructura lógica de secciones.
- Priorizar información verificable y completa.

## AEO

- Incluir respuestas directas cuando aplique.
- Usar FAQs solo si son reales y útiles.
- Mantener tablas semánticas cuando correspondan.
- Favorecer fragmentos claros y escaneables.
- Evitar contenido redundante o inflado.

## Schema

- Usar schema cuando aplique.
- Evitar duplicados con Yoast.
- Validar que el schema represente contenido visible.
- No inventar entidades, ratings, precios, fechas o disponibilidad.
- Mantener consistencia entre schema y contenido visible.

## Performance SEO

- Optimizar LCP.
- Evitar CLS.
- Cuidar INP.
- Usar lazy loading donde corresponda.
- Definir dimensiones de imágenes.
- Evitar JS innecesario para contenido crítico indexable.

---

# 12. Frontend Rules

## HTML

- HTML semántico obligatorio.
- Accesibilidad obligatoria.
- Usar landmarks cuando aplique.
- Usar `aria-label`, `aria-labelledby` o texto visible cuando sea necesario.
- No usar elementos interactivos incorrectos.
- Usar botones para acciones.
- Usar enlaces para navegación.
- Mantener jerarquía adecuada.

## CSS / SCSS

- Evitar CSS inline.
- Mantener naming consistente.
- Reutilizar componentes.
- Evitar selectores excesivamente específicos.
- Evitar `!important` salvo casos críticos documentados.
- No romper responsive.
- Evitar overflow horizontal.
- Mantener mobile-first cuando el patrón existente lo permita.

## JS

- Evitar lógica global.
- Usar namespacing cuando el proyecto lo permita.
- Evitar contaminación de `window`.
- Evitar dependencias innecesarias.
- Evitar bloqueos de render.
- Minimizar listeners globales.
- Validar existencia de elementos antes de operar.
- No dejar `console.log`.
- Manejar estados vacíos y errores.
- Evitar `innerHTML` inseguro.

## Responsive

- Validar mobile, tablet y desktop cuando el cambio afecte UI.
- Evitar textos cortados.
- Evitar elementos superpuestos.
- Evitar cambios de layout inesperados.
- Mantener targets táctiles adecuados.
- Evitar overflow horizontal.

---

# 13. Gulp, Build y Archivos Generados

Los archivos ubicados en las siguientes rutas son artefactos generados automáticamente por el proceso de build de Gulp:

- `assets/production/mincss/**`
- `assets/production/minjs/**`

## Restricciones obligatorias

- Nunca modificar manualmente archivos dentro de `assets/production/mincss`.
- Nunca modificar manualmente archivos dentro de `assets/production/minjs`.
- Nunca aplicar sobre esos archivos:
  - Refactors.
  - Fixes.
  - Optimizaciones.
  - Formateos.
  - Cambios de lógica.
  - Cambios de estilos.
  - Eliminación de código.
  - Análisis correctivos.

Estos archivos son únicamente resultados de compilación y pueden ser sobrescritos en cualquier ejecución de Gulp.

## Rutas fuente permitidas

Todos los cambios deben realizarse exclusivamente sobre archivos fuente originales, por ejemplo:

- `assets/scss/**`
- `assets/js/**`
- `components/**`
- `template-parts/**`
- `inc/**`
- Templates PHP fuente del tema.
- Cualquier otro directorio fuente real del proyecto.

## Build

- Si el cambio requiere compilar assets, ejecutar el flujo Gulp correspondiente.
- No editar archivos minificados para simular un build.
- No falsificar builds.
- Si no se puede ejecutar Gulp, reportarlo explícitamente.

---

# 14. Performance Rules

## Frontend

- Evitar render blocking innecesario.
- Reducir JS no crítico.
- Evitar recalcular layout en loops.
- Evitar listeners duplicados.
- Evitar inicializaciones repetidas.

## Imágenes

- Definir dimensiones cuando sea posible.
- Usar `loading="lazy"` fuera del contenido crítico.
- No aplicar lazy loading al posible LCP sin análisis.
- Usar formatos modernos cuando el proyecto lo soporte.
- Mantener `alt` descriptivo o vacío si la imagen es decorativa.

## DOM

- Evitar DOM excesivo.
- Evitar wrappers innecesarios.
- Evitar loops costosos.
- Evitar renderizar contenido oculto pesado si no es necesario.

## Core Web Vitals

- Optimizar LCP.
- Optimizar CLS.
- Optimizar INP.
- Evitar animaciones que afecten layout.
- Preferir transform y opacity para animaciones.

---

# 15. Reglas para IA

## Código generado por IA

- Evitar sobreingeniería.
- Mantener simplicidad.
- Respetar arquitectura existente.
- No asumir lógica de negocio.
- No asumir plugins no documentados.
- No asumir estructura ACF.
- No inventar datos.
- No introducir patrones ajenos al proyecto sin necesidad.

## Consistencia

- Respetar naming conventions.
- Respetar estilo de templates.
- Respetar estructura de assets.
- Respetar compatibilidad WordPress.
- Respetar Yoast.

## Ambigüedad

Solicitar confirmación antes de implementar si:

- El requerimiento afecta SEO, metadata, schema, URLs o indexabilidad.
- El requerimiento afecta formularios, datos personales o seguridad.
- El requerimiento implica eliminar contenido o lógica existente.
- No está claro el origen de datos.
- No está clara la estructura ACF.
- El cambio requiere dependencia nueva.
- Existen varias interpretaciones funcionales con impactos diferentes.
- El cambio afecta autenticación, pagos, datos críticos, infraestructura, CI/CD o base de datos.

---

# 16. QA Rules

## Validación obligatoria

Antes de finalizar, validar según alcance:

- Funcionalidad.
- Responsive.
- Accesibilidad.
- Performance.
- SEO.
- GEO.
- AEO.
- Errores JS.
- Warnings PHP visibles.
- Compatibilidad Yoast.
- Encoding UTF-8.
- Acentos y caracteres especiales.
- Ortografía.

## Checklist final

- No se modificaron archivos generados prohibidos.
- No quedó código temporal.
- No quedaron `console.log`.
- No quedaron `var_dump`, `print_r` ni `die`.
- No quedaron secretos.
- No quedaron TODO críticos.
- Se escapó salida nueva.
- Se sanitizó entrada nueva.
- Se validaron nonces y permisos si aplica.
- Se mantuvo estructura semántica.
- Se validó responsive si aplica.
- No se rompió build.
- README actualizado cuando aplica.
- Se documentó rollback.

---

# 17. Definition of Done

Un cambio solo está terminado cuando:

- Existe SPEC proporcional al cambio.
- El alcance fue respetado.
- Los archivos modificados son correctos.
- No se tocaron manualmente assets generados.
- La implementación cumple los Acceptance Criteria.
- La salida está escapada.
- La entrada está sanitizada.
- Los permisos y nonces están validados cuando aplica.
- SEO / GEO / AEO no se degradan.
- Yoast no queda duplicado ni contradicho.
- Responsive no se rompe.
- Performance no se degrada.
- No hay errores JS introducidos.
- No hay warnings PHP visibles introducidos.
- Encoding UTF-8 correcto.
- Ortografía revisada.
- No queda código temporal.
- Build funcional o limitación reportada.
- README actualizado cuando aplica.
- Existe plan de rollback claro.
- Se reporta validación realizada.

---

# 18. Formato de Respuesta del Agente

Al finalizar un cambio, responder de forma breve con:

1. Qué se cambió.
2. Archivos modificados.
3. Validación realizada.
4. Riesgos o pendientes, si existen.
5. Estado del README.
6. Confirmación del DoD.

Si no se pudo validar algo, decirlo explícitamente.

---

# 19. Regla Final

Ante conflicto entre velocidad y seguridad, gana seguridad.

Ante conflicto entre rapidez y arquitectura, gana arquitectura.

Ante conflicto entre comodidad y SPEC, gana SPEC.

Ante conflicto entre cambio manual rápido y flujo Gulp, gana Gulp.

Ante conflicto entre solución rápida y mantenibilidad, gana mantenibilidad.

Ante conflicto entre una solución creativa y la arquitectura existente, gana la arquitectura existente.

Ante duda razonable, detenerse, explicar la incertidumbre y pedir confirmación.
