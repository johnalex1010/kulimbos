# Kulimbos — Tema WordPress

Tema WordPress modular y personalizado para el proyecto Kulimbos. Construido sin page builders, con arquitectura por responsabilidades, sistema de build Gulp 5 y convenciones estrictas de seguridad, accesibilidad y SEO.

---

## Descripción

El tema implementa una separación clara entre templates, partials, componentes reutilizables, helpers, assets y configuración. El archivo `functions.php` actúa exclusivamente como cargador de módulos; toda la lógica reside en `inc/`. Los estilos se escriben en SCSS y los scripts en JS vanilla; ambos son compilados, autoprefijados y minificados por Gulp antes de ser encolados en WordPress.

---

## Stack tecnológico

| Capa | Tecnología |
|------|-----------|
| CMS | WordPress 6.x |
| Lenguaje servidor | PHP 8.1+ |
| Estilos fuente | SCSS (Dart Sass) |
| Scripts fuente | JavaScript ES2020 (sin transpiler) |
| Build | Gulp 5 |
| Package manager | npm |
| Compatibilidad SEO | Yoast SEO (no duplicar meta ni schema) |
| Campos personalizados | ACF (opcional; siempre validar con `function_exists`) |
| Encoding | UTF-8 |
| Idioma de contenido | Español Colombia (es-CO) |

---

## Requisitos

- **PHP** 8.1 o superior
- **WordPress** 6.4 o superior
- **Node.js** 18.0 o superior
- **npm** 9.0 o superior
- Servidor local: XAMPP, LocalWP, Lando o similar

---

## Instalación

### 1. Clonar o copiar el tema

```bash
# Si el proyecto usa control de versiones:
git clone <repo-url> wp-content/themes/kulimbos

# O copiar la carpeta manualmente a:
# wp-content/themes/kulimbos/
```

### 2. Instalar dependencias Node

```bash
cd wp-content/themes/kulimbos
npm install
```

### 3. Compilar los assets por primera vez

```bash
npm run build
```

Esto genera `assets/production/mincss/main.min.css` y `assets/production/minjs/main.min.js`, que son los archivos que WordPress encola.

### 4. Activar el tema

Ir a **WordPress Admin → Apariencia → Temas** y activar **Kulimbos**.

### 5. Configurar menús y widgets (opcional)

- **Apariencia → Menús**: asignar un menú a la ubicación `Menú principal`.
- **Apariencia → Widgets**: configurar los sidebars `Barra lateral` y `Pie de página — Columna 1/2/3`.

---

## Variables de entorno

El tema no requiere variables de entorno propias. Usa las constantes nativas de WordPress definidas en `wp-config.php`:

| Constante | Efecto en el tema |
|-----------|-------------------|
| `WP_DEBUG true` | Los assets se encolan con versión `filemtime()` para invalidar caché automáticamente |
| `WP_DEBUG false` | Los assets se encolan con la versión `KULIMBOS_VERSION` definida en `functions.php` |

---

## Scripts disponibles

```bash
npm run dev     # Build completo + modo watch (desarrollo diario)
npm run build   # Build completo sin watch (CI / antes de desplegar)
npm run watch   # Solo watch, sin build previo
npm run css     # Compilar solo SCSS
npm run js      # Compilar solo JS
```

---

## Flujo de desarrollo

1. Iniciar el servidor local (XAMPP, LocalWP, etc.) con WordPress activo.
2. Ejecutar `npm run dev` en la raíz del tema. Gulp compila los assets y queda en modo watch.
3. Editar archivos fuente en `assets/scss/` o `assets/js/`. Gulp recompila automáticamente.
4. Editar templates PHP en la raíz o en `template-parts/`. No requiere recompilación.
5. Editar módulos de configuración en `inc/`. Verificar en el navegador tras guardar.

> **Nunca editar** los archivos dentro de `assets/production/`. Son artefactos generados y se sobreescriben en cada build.

---

## Flujo de build

```
assets/scss/main.scss
  └─ @import parciales (_variables, _reset, _typography, _layout, components/*)
        ↓ gulp-sass (Dart Sass)
        ↓ gulp-autoprefixer
        ↓ gulp-clean-css (nivel 2)
        → assets/production/mincss/main.min.css

assets/js/main.js
        ↓ gulp-concat
        ↓ gulp-terser (drop_console: true en producción)
        → assets/production/minjs/main.min.js
```

Los archivos de producción son encolados por `inc/assets.php` mediante `wp_enqueue_style` y `wp_enqueue_script`.

---

## Estructura principal

```
kulimbos/
├── assets/
│   ├── scss/
│   │   ├── main.scss              ← Punto de entrada del build
│   │   ├── _variables.scss        ← Design tokens (CSS custom properties)
│   │   ├── _reset.scss            ← Reset moderno
│   │   ├── _typography.scss       ← Tipografía base + .entry-content
│   │   ├── _layout.scss           ← Container, header, footer, grids
│   │   └── components/
│   │       ├── _button.scss
│   │       ├── _card.scss
│   │       └── _hero.scss
│   ├── js/
│   │   └── main.js                ← Namespace Kulimbos (menú, skip link, lazy, scroll)
│   ├── img/                       ← Imágenes estáticas del tema
│   └── production/                ← ⚠️ Generado por Gulp — NO editar manualmente
│       ├── mincss/
│       └── minjs/
├── inc/
│   ├── setup.php                  ← add_theme_support, image sizes, textdomain
│   ├── assets.php                 ← wp_enqueue_scripts, wp_localize_script
│   ├── menus.php                  ← register_nav_menus
│   ├── widgets.php                ← register_sidebar
│   ├── helpers.php                ← Funciones de presentación reutilizables
│   └── custom-post-types.php      ← CPTs y taxonomías personalizadas
├── template-parts/
│   ├── components/
│   │   ├── button.php             ← Botón reutilizable (acepta $args)
│   │   ├── card.php               ← Tarjeta de contenido (acepta $args o post global)
│   │   └── hero.php               ← Sección hero (acepta $args)
│   ├── layout/
│   │   ├── header-navigation.php  ← Menú principal + toggle móvil
│   │   └── footer-widgets.php     ← Área de widgets del pie
│   └── content/
│       ├── content-page.php       ← Loop de páginas estáticas
│       ├── content-post.php       ← Loop de entradas (listado + single)
│       └── content-none.php       ← Estado vacío
├── functions.php                  ← Solo cargador de inc/
├── style.css                      ← Solo encabezado del tema (metadatos)
├── index.php                      ← Template de reserva
├── header.php / footer.php
├── page.php / single.php / archive.php / 404.php
├── gulpfile.js
├── package.json
└── .gitignore
```

---

## Convenciones relevantes

### PHP

- Prefijo obligatorio `kulimbos_` en todas las funciones, hooks, handles y constantes del tema.
- Guard de acceso directo en todos los archivos PHP: `defined('ABSPATH') || exit;`
- Toda salida escapada según contexto: `esc_html()`, `esc_attr()`, `esc_url()`, `wp_kses_post()`.
- Toda entrada sanitizada antes de usarse: `sanitize_text_field()`, `absint()`, `wp_unslash()`.
- Validar `function_exists('get_field')` antes de cualquier llamada a ACF.
- Restaurar el estado global tras queries personalizadas con `wp_reset_postdata()`.

### SCSS

- Mobile-first: breakpoints con `min-width`.
- Naming BEM: `.bloque__elemento--modificador`.
- Sin `!important` salvo casos críticos documentados.
- Sin estilos inline en templates PHP. Toda regla visual va en SCSS.
- Variables de diseño exclusivamente como CSS custom properties en `_variables.scss`.

### JavaScript

- Todo el código bajo el namespace `Kulimbos` (IIFE). Sin contaminación de `window`.
- Validar existencia del elemento en el DOM antes de operar.
- Sin `console.log` en el código fuente (Terser los elimina en build, pero no deben quedar en fuente).
- Datos de PHP accesibles en `window.kulimbosData` (inyectados con `wp_localize_script`).

### Componentes

Llamar a componentes reutilizables mediante el helper `kulimbos_component()`:

```php
// Forma larga equivalente:
get_template_part( 'template-parts/components/button', null, $args );

// Forma corta con helper:
kulimbos_component( 'button', array(
    'text'  => __( 'Ver más', 'kulimbos' ),
    'url'   => get_permalink(),
    'class' => 'btn--primary',
) );
```

### Templates personalizados de página

Crear en la raíz del tema con la cabecera:

```php
<?php
/**
 * Template Name: Nombre del template
 */
```

---

## Agregar un nuevo CPT

1. Abrir `inc/custom-post-types.php`.
2. Copiar la función `kulimbos_register_cpt_proyecto()` como base.
3. Renombrar función y slug (`proyecto` → `nuevo-tipo`).
4. Descomentar la llamada dentro de `kulimbos_register_post_types()`.
5. Crear `archive-{slug}.php` y `single-{slug}.php` en la raíz del tema si el CPT necesita templates propios.

---

## Agregar estilos nuevos

1. Crear `assets/scss/components/_nuevo-componente.scss`.
2. Importarlo en `assets/scss/main.scss`:
   ```scss
   @import 'components/nuevo-componente';
   ```
3. Ejecutar `npm run css` o dejar `npm run dev` corriendo.

---

## Ejecución de pruebas

El tema no incluye suite de tests automatizados en esta versión. La validación es manual:

| Verificación | Herramienta |
|-------------|------------|
| PHP errors / warnings | `WP_DEBUG true` + log en `wp-content/debug.log` |
| Validación HTML | [validator.w3.org](https://validator.w3.org) |
| Accesibilidad | WAVE, axe DevTools |
| Core Web Vitals | PageSpeed Insights, Chrome DevTools |
| SEO on-page | Yoast SEO en el admin de WordPress |
| Schema | Google Rich Results Test |
| Responsive | Chrome DevTools (breakpoints: 375, 768, 1024, 1280px) |
| Contraste de color | WebAIM Contrast Checker |

---

## Despliegue

1. En el servidor de producción, subir la carpeta del tema completa **excepto** `node_modules/`.
2. Los archivos `assets/production/` deben estar incluidos (son los que WordPress encola).
3. Verificar que `WP_DEBUG` esté en `false` en `wp-config.php` del servidor de producción.
4. Si se usa un proceso de CI/CD, ejecutar `npm ci && npm run build` antes de empaquetar.

```bash
# Ejemplo de empaquetado para despliegue (excluye node_modules y fuentes SCSS si se desea)
npm run build
rsync -av --exclude='node_modules' --exclude='.git' ./ usuario@servidor:/ruta/tema/
```

---

## Troubleshooting

**El tema no carga estilos o scripts**
- Verificar que `npm run build` se ejecutó al menos una vez y que `assets/production/mincss/main.min.css` existe.
- Revisar la consola del navegador por errores 404 en los assets.
- Confirmar que no hay caché de plugin (LiteSpeed, W3 Total Cache, etc.) sirviendo versiones antiguas.

**Error de Gulp al compilar SCSS**
- Verificar que la versión de Node es ≥ 18: `node -v`.
- Borrar `node_modules/` y ejecutar `npm install` nuevamente.
- Revisar el error en la terminal; Gulp imprime la línea exacta del SCSS con el problema.

**La función `kulimbos_component()` no encuentra el partial**
- Confirmar que el archivo existe en `template-parts/components/{nombre}.php`.
- El parámetro no incluye la extensión `.php` ni el prefijo del directorio.

**El menú móvil no funciona**
- Confirmar que `assets/production/minjs/main.min.js` existe y se encoló (`npm run build`).
- Verificar que el elemento con `id="menu-toggle"` está presente en el DOM (requiere que el menú `primary` tenga al menos un ítem asignado en WordPress).

**ACF no devuelve campos**
- El tema nunca asume que ACF está activo. Siempre envolver llamadas en `function_exists('get_field')`.
- Verificar que el grupo de campos de ACF tiene la regla de ubicación correcta para el post type o template.

**Warnings de PHP visibles en el frontend**
- Activar `WP_DEBUG_DISPLAY false` y `WP_DEBUG_LOG true` en `wp-config.php` para mover los errores al log sin mostrarlos.

---

## Riesgos conocidos

| Riesgo | Mitigación |
|--------|-----------|
| Assets no compilados en producción | Ejecutar `npm run build` antes de cualquier despliegue |
| Colisión de nombres de función | Prefijo `kulimbos_` obligatorio en todas las funciones del tema |
| Duplicación de schema o meta con Yoast | No añadir metadatos SEO manuales; dejar que Yoast los gestione |
| Dependencia de ACF sin plugin activo | Toda llamada a `get_field()` protegida con `function_exists()` |
| CLS por imágenes sin dimensiones | Definir `width` y `height` en imágenes cuando se conozcan las dimensiones |
| Overflow horizontal en mobile | Validar con Chrome DevTools en 375px antes de publicar cambios visuales |
