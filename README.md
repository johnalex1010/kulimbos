# Kulimbos — Tema WordPress

Tema WordPress modular y personalizado para el proyecto Kulimbos. Construido sin page builders, con arquitectura por responsabilidades, sistema de build Gulp 5, tipografía propia y convenciones estrictas de seguridad, accesibilidad y SEO.

---

## Descripción

El tema implementa una separación clara entre templates, partials, componentes reutilizables, helpers, assets y configuración. El archivo `functions.php` actúa exclusivamente como cargador de módulos; toda la lógica reside en `inc/`. Los estilos se escriben en SCSS y los scripts en JS vanilla; Gulp los compila en dos variantes: CSS expandido para desarrollo y CSS minificado para producción. WordPress carga el archivo correcto según `WP_DEBUG`.

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
| Tipografía titulares | Baloo 2 (autoalojada, pesos 400/500/700/800) |
| Tipografía cuerpo | Nunito (autoalojada, pesos 400/500/600/700) |
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

Esto genera los tres archivos que WordPress encola:

| Archivo | Uso |
|---------|-----|
| `assets/css/main.css` | CSS expandido — cargado con `WP_DEBUG true` |
| `assets/production/mincss/main.min.css` | CSS minificado — cargado en producción |
| `assets/production/minjs/main.min.js` | JS minificado — cargado siempre |

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
| `WP_DEBUG true` | Carga `assets/css/main.css` con versión `filemtime()`. Permite inspeccionar el CSS sin ofuscar. |
| `WP_DEBUG false` | Carga `assets/production/mincss/main.min.css` con versión `filemtime()`. |
| JS principal | Carga `assets/production/minjs/main.min.js` con versión `filemtime()` para invalidar caché después de cada build. |

---

## Scripts disponibles

```bash
npm run dev     # Build completo + modo watch (desarrollo diario)
npm run build   # Build completo sin watch (CI / antes de desplegar)
npm run watch   # Solo watch, sin build previo
npm run css     # Compilar solo SCSS (expandido + minificado)
npm run js      # Compilar solo JS
```

---

## Flujo de desarrollo

1. Iniciar el servidor local (XAMPP, LocalWP, etc.) con WordPress activo.
2. Asegurarse de que `wp-config.php` tiene `define('WP_DEBUG', true);`.
3. Ejecutar `npm run dev` en la raíz del tema. Gulp compila y queda en modo watch.
4. Editar archivos fuente en `assets/scss/` o `assets/js/`. Gulp recompila automáticamente.
5. Editar templates PHP en la raíz o en `template-parts/`. No requiere recompilación.
6. Editar módulos en `inc/`. Verificar en el navegador tras guardar.

> **Nunca editar** `assets/css/`, `assets/production/mincss/` ni `assets/production/minjs/`. Son artefactos generados que se sobreescriben en cada build.

---

## Flujo de build

```
assets/scss/main.scss
  └─ @import _fonts        ← @font-face (Baloo 2 + Nunito, 8 archivos)
  └─ @import _variables    ← Design tokens: --font-heading, --font-primary, colores, etc.
  └─ @import _reset        ← Reset moderno
  └─ @import _typography   ← h1–h6 (Baloo 2), body/p/a/table (Nunito)
  └─ @import _layout       ← Container, header, footer, grids, paginación
  └─ @import components/*  ← _button, _card, _hero
        ↓
        ├─ gulp-sass (Dart Sass) → autoprefixer
        │       ↓
        │  ┌─── expandido ──────────────────────────────────────────────────────┐
        │  │  assets/css/main.css          1 049 líneas  ~27 KB   (WP_DEBUG)   │
        │  └────────────────────────────────────────────────────────────────────┘
        │       ↓ gulp-clean-css (nivel 2)
        │  ┌─── minificado ─────────────────────────────────────────────────────┐
        │  │  assets/production/mincss/main.min.css   ~19 KB  (producción)     │
        │  └────────────────────────────────────────────────────────────────────┘
        │
assets/js/main.js
        ↓ gulp-concat → gulp-terser (drop_console: true)
        └─ assets/production/minjs/main.min.js   ~2 KB
```

Los tres archivos son encolados por `inc/assets.php` mediante `wp_enqueue_style` / `wp_enqueue_script`.

---

## Tipografía

### Fuentes

| Familia | Rol | Pesos disponibles | Variable CSS |
|---------|-----|-------------------|--------------|
| **Baloo 2** | Titulares `h1–h6` | 400, 500, 700, 800 | `--font-heading` |
| **Nunito** | Cuerpo, `p`, `a`, `li`, `table`, inputs, botones | 400, 500, 600, 700 | `--font-primary` |

### Archivos en `assets/fonts/`

```
assets/fonts/
├── Baloo2-Regular.woff2       → font-weight: 400
├── Baloo2-Medium.woff2        → font-weight: 500
├── Baloo2-Bold.woff2          → font-weight: 700  ← preload crítico (h1–h6)
├── Baloo2-ExtraBold.woff2     → font-weight: 800
├── Nunito-Regular.woff2       → font-weight: 400  ← preload crítico (body)
├── Nunito-Medium.woff2        → font-weight: 500
├── Nunito-SemiBold.woff2      → font-weight: 600
└── Nunito-Bold.woff2          → font-weight: 700
```

Los archivos `Baloo2-Bold.woff2` y `Nunito-Regular.woff2` se precargan con `<link rel="preload">` en el `<head>` (gestionado por `inc/assets.php`) para reducir el tiempo de primer render.

### Aplicación tipográfica

| Elemento | Fuente | Peso por defecto |
|----------|--------|-----------------|
| `h1` | Baloo 2 | 700 |
| `h2` – `h6` | Baloo 2 | 700 |
| `body`, `p`, `li` | Nunito | 400 |
| `a` | Nunito | 400 |
| `table`, `td`, `th` | Nunito | 400 (th: 600) |
| `blockquote p` | Nunito | 400 itálica |
| `.btn` | Nunito | 600 |
| `code`, `pre` | JetBrains Mono (sistema) | 400 |

---

## Estructura principal

```
kulimbos/
├── assets/
│   ├── fonts/                         ← Fuentes autoalojadas (.woff2)
│   │   ├── Baloo2-Regular.woff2
│   │   ├── Baloo2-Medium.woff2
│   │   ├── Baloo2-Bold.woff2
│   │   ├── Baloo2-ExtraBold.woff2
│   │   ├── Nunito-Regular.woff2
│   │   ├── Nunito-Medium.woff2
│   │   ├── Nunito-SemiBold.woff2
│   │   └── Nunito-Bold.woff2
│   ├── scss/
│   │   ├── main.scss                  ← Punto de entrada del build
│   │   ├── _fonts.scss                ← @font-face (8 declaraciones)
│   │   ├── _variables.scss            ← Design tokens (CSS custom properties)
│   │   ├── _reset.scss                ← Reset moderno
│   │   ├── _typography.scss           ← Tipografía base + .entry-content
│   │   ├── _layout.scss               ← Container, header, footer, grids
│   │   └── components/
│   │       ├── _button.scss
│   │       ├── _card.scss
│   │       └── _hero.scss
│   ├── js/
│   │   └── main.js                    ← Namespace Kulimbos (menú, skip link, lazy, scroll)
│   ├── img/                           ← Imágenes estáticas del tema
│   ├── css/                           ← ⚠️ Generado por Gulp — NO editar (WP_DEBUG)
│   │   └── main.css
│   └── production/                    ← ⚠️ Generado por Gulp — NO editar
│       ├── mincss/
│       │   └── main.min.css
│       └── minjs/
│           └── main.min.js
├── inc/
│   ├── setup.php                      ← add_theme_support, image sizes, textdomain
│   ├── assets.php                     ← wp_enqueue_scripts, preload fuentes, wp_localize_script
│   ├── menus.php                      ← register_nav_menus
│   ├── widgets.php                    ← register_sidebar
│   ├── helpers.php                    ← Funciones de presentación reutilizables
│   └── custom-post-types.php          ← CPTs y taxonomías personalizadas
├── template-parts/
│   ├── components/
│   │   ├── button.php                 ← Botón reutilizable (acepta $args)
│   │   ├── card.php                   ← Tarjeta de contenido (acepta $args o post global)
│   │   └── hero.php                   ← Sección hero (acepta $args)
│   ├── layout/
│   │   ├── header-navigation.php      ← Menú principal + toggle móvil
│   │   └── footer-widgets.php         ← Área de widgets del pie
│   └── content/
│       ├── content-page.php           ← Loop de páginas estáticas
│       ├── content-post.php           ← Loop de entradas (listado + single)
│       └── content-none.php           ← Estado vacío
├── functions.php                      ← Solo cargador de inc/
├── style.css                          ← Solo encabezado del tema (metadatos)
├── index.php                          ← Template de reserva
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
- Design tokens exclusivamente como CSS custom properties en `_variables.scss`.
- Fuentes tipográficas referenciadas siempre con `var(--font-heading)` o `var(--font-primary)`.

### JavaScript

- Todo el código bajo el namespace `Kulimbos` (IIFE). Sin contaminación de `window`.
- Validar existencia del elemento en el DOM antes de operar.
- Sin `console.log` en el código fuente (Terser los elimina en build).
- Datos de PHP accesibles en `window.kulimbosData` (inyectados con `wp_localize_script`).

### Componentes

Llamar a componentes reutilizables mediante el helper `kulimbos_component()`:

```php
// Forma corta (recomendada):
kulimbos_component( 'button', array(
    'text'  => __( 'Ver más', 'kulimbos' ),
    'url'   => get_permalink(),
    'class' => 'btn--primary',
) );

// Equivalente largo:
get_template_part( 'template-parts/components/button', null, $args );
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

## Catálogo de productos

El tema registra el CPT `producto`, la taxonomía jerárquica `categoria_producto` y taxonomías internas para filtros: `edad_producto`, `tamano_producto`, `color_producto`, `material_producto`, `marca_producto` y `tipo_producto`.

### Rutas recomendadas

- Archivo general: `/productos/`
- Categoría padre: `/categoria/juguetes/`
- Subcategoría: `/categoria/juguetes/peluches/`
- Producto: `/productos/categoria-padre/subcategoria/slug-del-producto/`

La miga de pan recomendada para un producto es:

```text
Inicio / Categorías / Categoría padre / Subcategoría / Nombre del producto
```

### Flujo en WordPress

1. Ir a **Productos → Categorías** y crear categorías jerárquicas, por ejemplo `Juguetes` y dentro `Peluches`.
2. Editar cada categoría que necesite visual propio y configurar **Imagen de categoría**. El campo usa la biblioteca de medios nativa de WordPress y guarda el ID del adjunto en `kulimbos_category_image_id`; si no se configura, el catálogo usa la imagen visual por defecto.
3. Ir a **Productos → Añadir nuevo**.
4. Asignar una o más categorías de producto.
5. Agregar imagen destacada. Esta imagen se usa como imagen principal del detalle y como primera miniatura de la galería.
6. Configurar imágenes adicionales desde la caja **Galería del producto**. El campo usa la biblioteca de medios nativa de WordPress y guarda los IDs ordenados en `kulimbos_product_gallery_ids`.
7. Configurar filtros desde los paneles del producto o desde el menú **Productos**:
   - **Edades** (`edad_producto`)
   - **Tamaños** (`tamano_producto`)
   - **Colores** (`color_producto`)
   - **Materiales** (`material_producto`)
   - **Marcas** (`marca_producto`)
   - **Tipos** (`tipo_producto`)
8. Configurar **Precio** y **Stock** desde la caja **Datos comerciales**.
   - `kulimbos_product_price`
   - `kulimbos_product_stock`
   - `kulimbos_product_regular_price`
   - `kulimbos_product_sale_price`
   - `kulimbos_product_sku`
9. Completar la caja **Ficha técnica del producto** cuando el producto requiera datos como marca, EAN, INVIMA, presentación, etapa/edad, origen, capacidad, dimensiones, estampado o material técnico.
10. Completar la caja **Contenido comercial y validación** para características, cuidados, personalización, modo de preparación, advertencias, ingredientes explicados, notas de verificación, pendientes y fuentes internas.
11. Completar la caja **Variantes, diseños y tablas técnicas** cuando el producto tenga diseños, tallas, combinaciones, presentaciones o precios por variante.

La calificación no se edita manualmente en el producto. Se calcula desde comentarios aprobados que tengan `kulimbos_comment_rating` entre 1 y 5.

Los metadatos heredados `kulimbos_product_age`, `kulimbos_product_size`, `kulimbos_product_color` y `kulimbos_product_material` se mantienen como fallback para no romper productos antiguos, pero la configuración recomendada es por taxonomías.

Los filtros por edad, tamaño, color, material, marca y tipo aceptan múltiples términos por producto. En el frontend el producto se muestra si coincide con cualquiera de los términos seleccionados. Si un producto no tiene configurado un filtro, no se le asigna un valor por defecto inventado y no aparece al seleccionar esa opción.

En **Productos → Colores**, cada término tiene el campo **Color visual** (`kulimbos_color_hex`). Ese valor hexadecimal controla el swatch mostrado en el frontend. Si se crea un color nuevo, configurar ese campo antes de usarlo en productos.

### Fichas técnicas de producto

El CPT `producto` soporta fichas técnicas ampliadas para productos simples, productos personalizados, sets por combinación, prendas con tablas de tallas, termos personalizados, fórmulas infantiles, alimentos lácteos y nutrición especializada.

Campos escalares registrados:

| Campo | Uso |
|-------|-----|
| `kulimbos_product_regular_price` | Precio regular en COP |
| `kulimbos_product_sale_price` | Precio oferta en COP |
| `kulimbos_product_sku` | SKU o referencia interna |
| `kulimbos_product_ean` | Código EAN |
| `kulimbos_product_invima` | Registro INVIMA |
| `kulimbos_product_brand` | Marca visible como fallback |
| `kulimbos_product_presentation` | Presentación del producto |
| `kulimbos_product_stage_age` | Etapa o edad visible |
| `kulimbos_product_origin` | País de origen |
| `kulimbos_product_capacity` | Capacidad |
| `kulimbos_product_dimensions` | Dimensiones generales |
| `kulimbos_product_print_method` | Técnica de estampado o impresión |
| `kulimbos_product_material_detail` | Material técnico completo |

Campos de texto largo:

- `kulimbos_product_care_instructions`
- `kulimbos_product_personalization_instructions`
- `kulimbos_product_usage_occasions`
- `kulimbos_product_preparation_mode`
- `kulimbos_product_warnings`
- `kulimbos_product_key_ingredients`
- `kulimbos_product_competitive_angle`
- `kulimbos_product_verification_note`
- `kulimbos_product_pending_verification`
- `kulimbos_product_source_notes`

Campos estructurados:

- `kulimbos_product_features`: lista de características, una por línea en el admin.
- `kulimbos_product_reference_images`: lista de nombres, rutas o notas de imágenes de referencia.
- `kulimbos_product_designs`: JSON con `id`, `label`, `description` y `status`.
- `kulimbos_product_variants`: JSON con `id`, `label`, `design`, `size`, `color`, `presentation`, `regular_price`, `sale_price`, `stock` y `status`.
- `kulimbos_product_size_tables`: JSON con `title`, `source_note`, `columns` y `rows`.
- `kulimbos_product_market_prices`: JSON con `source`, `location`, `price_type`, `price_label`, `conditions` y `url_or_note`.

Estados permitidos para diseños y variantes:

- `active`
- `draft`
- `pending`
- `unavailable`

Ejemplo de variante:

```json
[
  {
    "id": "familiar-100x150",
    "label": "Familiar · 100 x 150 cm",
    "design": "Familiar",
    "size": "100 x 150 cm",
    "color": "",
    "presentation": "",
    "regular_price": "",
    "sale_price": "",
    "stock": "",
    "status": "pending"
  }
]
```

Ejemplo de tabla técnica:

```json
[
  {
    "title": "Camiseta cuello redondo mujer",
    "source_note": "Ref. 804037, dato suministrado por el usuario",
    "columns": ["Talla", "Pecho (cm)", "Largo (cm)"],
    "rows": [
      ["S", "40", "58"],
      ["M", "42", "59.5"],
      ["L", "44", "61"],
      ["XL", "47", "62.5"]
    ]
  }
]
```

El campo `kulimbos_product_price` sigue siendo el precio efectivo base para listados, carrito, favoritos y WhatsApp. Si hay variantes activas con precio y no hay precio base suficiente, el frontend puede mostrar un precio tipo “Desde $X”. El carrito todavía no selecciona variantes avanzadas; no se debe asumir talla, color, diseño o presentación sin una selección explícita del cliente.

Para productos de fórmulas, alimentos lácteos o nutrición médica, usar siempre los campos de advertencias, modo de preparación, INVIMA/EAN y pendientes de verificación. No publicar claims médicos o regulatorios como definitivos cuando estén marcados como pendientes o dependan de revisión legal/editorial.

WordPress selecciona automáticamente:

- `single-producto.php` para el detalle del producto.
- `taxonomy-categoria_producto.php` para categorías como `/categoria/juguetes/peluches/`.
- `archive-producto.php` para `/productos/`.
- `page-carrito.php` para `/carrito/`. Si no existe una página creada en WordPress, el tema carga este template mediante `inc/cart.php`.
- `page-favoritos.php` para `/favoritos/`. Si no existe una página creada en WordPress, el tema carga este template mediante `inc/favorites.php`.

### Carrito local

El carrito del tema funciona sin WooCommerce y guarda productos anónimos en `localStorage` con la llave `kulimbos_cart_v1`.

- El botón **Agregar al carrito** del detalle respeta la cantidad seleccionada.
- Los botones de cards agregan 1 unidad.
- El contador del header muestra la suma total de unidades.
- La página `/carrito/` muestra los productos agregados, permite ajustar cantidades y elimina productos del almacenamiento local.
- El resumen usa subtotal de productos + envío fijo de `12800` COP. No hay regla de envío gratis.

### Favoritos locales

Favoritos funciona sin login y guarda productos anónimos en `localStorage` con la llave `kulimbos_favorites_v1`.

- El header muestra el total de productos favoritos.
- Los botones de corazón agregan o quitan productos de favoritos.
- La página `/favoritos/` muestra una lista de compras privada, permite buscar, ordenar, eliminar productos y agregarlos al carrito.
- No hay listas múltiples reales ni sincronización con usuarios.

El tema refresca las reglas de rewrite una sola vez mediante una versión interna. Si aun así alguna ruta antigua queda en caché, ir a **Ajustes → Enlaces permanentes** y guardar una vez.

Para facilitar la carga posterior desde WordPress, el tema puede crear una vez, solo para administradores, términos base (`Juguetes`, `Peluches`, `Paseo`) y términos de filtros (`0 a 1 años`, `Pequeño`, `Café`, `Algodón`, etc.) si todavía no existen. El tema no crea productos de ejemplo: si no hay productos publicados, el catálogo muestra un mensaje de vacío.

---

## Agregar estilos nuevos

1. Crear `assets/scss/components/_nuevo-componente.scss`.
2. Importarlo en `assets/scss/main.scss`:
   ```scss
   @import 'components/nuevo-componente';
   ```
3. Ejecutar `npm run css` o dejar `npm run dev` corriendo.

---

## Agregar fuentes nuevas

1. Colocar el archivo `.woff2` en `assets/fonts/`.
2. Declarar el `@font-face` en `assets/scss/_fonts.scss`.
3. Si es una familia nueva, añadir el token en `assets/scss/_variables.scss`:
   ```scss
   --font-nueva: 'Nombre Fuente', fallback, sans-serif;
   ```
4. Ejecutar `npm run css`.

---

## Ejecución de pruebas

El tema no incluye suite de tests automatizados en esta versión. La validación es manual:

| Verificación | Herramienta |
|-------------|------------|
| PHP errors / warnings | `WP_DEBUG true` + log en `wp-content/debug.log` |
| Validación HTML | [validator.w3.org](https://validator.w3.org) |
| Accesibilidad | WAVE, axe DevTools |
| Core Web Vitals | PageSpeed Insights, Chrome DevTools |
| Carga de fuentes | Chrome DevTools → Network → filtro `Font` |
| SEO on-page | Yoast SEO en el admin de WordPress |
| Schema | Google Rich Results Test |
| Responsive | Chrome DevTools (breakpoints: 375, 768, 1024, 1280px) |
| Contraste de color | WebAIM Contrast Checker |

---

## Despliegue

1. En el servidor de producción, subir la carpeta del tema completa **excepto** `node_modules/`.
2. Los archivos `assets/fonts/`, `assets/css/` y `assets/production/` deben estar incluidos.
3. Verificar que `WP_DEBUG` esté en `false` en `wp-config.php` del servidor de producción.
4. Si se usa un proceso de CI/CD, ejecutar `npm ci && npm run build` antes de empaquetar.

```bash
# Empaquetado para despliegue (excluye node_modules)
npm run build
rsync -av --exclude='node_modules' --exclude='.git' ./ usuario@servidor:/ruta/tema/
```

---

## Troubleshooting

**El tema no carga estilos**
- Verificar que `npm run build` se ejecutó al menos una vez.
- Con `WP_DEBUG true`: confirmar que `assets/css/main.css` existe.
- Con `WP_DEBUG false`: confirmar que `assets/production/mincss/main.min.css` existe.
- Revisar la consola del navegador por errores 404 en los assets.
- Confirmar que no hay caché de plugin (LiteSpeed, W3 Total Cache, etc.) sirviendo versiones antiguas.

**Las fuentes no se muestran (texto en fuente de sistema)**
- Confirmar que los 8 archivos `.woff2` están en `assets/fonts/`.
- Abrir DevTools → Network → filtro `Font` y verificar que los `.woff2` se descargan con status 200.
- Revisar la ruta relativa en `_fonts.scss`: desde `assets/production/mincss/main.min.css` la ruta correcta es `../../fonts/`.

**Error `autoprefixer is not a function` al compilar**
- Verificar que `package.json` tiene `"gulp-autoprefixer": "^8.0.0"` (v9 es ESM y no compatible con `require()`).
- Ejecutar `npm install` para reinstalar la versión correcta.

**Error de Gulp al compilar SCSS**
- Verificar que la versión de Node es ≥ 18: `node -v`.
- Borrar `node_modules/` y ejecutar `npm install` nuevamente.
- Gulp imprime la línea exacta del SCSS con el problema.

**La función `kulimbos_component()` no encuentra el partial**
- Confirmar que el archivo existe en `template-parts/components/{nombre}.php`.
- El parámetro no incluye la extensión `.php` ni el prefijo del directorio.

**El menú móvil no funciona**
- Confirmar que `assets/production/minjs/main.min.js` existe.
- Verificar que el menú `primary` tiene al menos un ítem asignado en WordPress (sin items, el toggle no se renderiza).

**ACF no devuelve campos**
- El tema nunca asume que ACF está activo. Envolver llamadas en `function_exists('get_field')`.
- Verificar que el grupo de campos de ACF tiene la regla de ubicación correcta para el post type o template.

**Warnings de PHP visibles en el frontend**
- Activar `WP_DEBUG_DISPLAY false` y `WP_DEBUG_LOG true` en `wp-config.php` para mover los errores al log.

---

## Riesgos conocidos

| Riesgo | Mitigación |
|--------|-----------|
| Assets no compilados en producción | Ejecutar `npm run build` antes de cualquier despliegue |
| Fuentes no incluidas en el repositorio | Confirmar que `assets/fonts/*.woff2` está en el repo (no están en `.gitignore`) |
| `gulp-autoprefixer` v9 incompatible (ESM) | Usar `^8.0.0` en `package.json` (ya configurado) |
| Colisión de nombres de función | Prefijo `kulimbos_` obligatorio en todas las funciones del tema |
| Duplicación de schema o meta con Yoast | No añadir metadatos SEO manuales; dejar que Yoast los gestione |
| Dependencia de ACF sin plugin activo | Toda llamada a `get_field()` protegida con `function_exists()` |
| CLS por imágenes sin dimensiones | Definir `width` y `height` en imágenes cuando se conozcan las dimensiones |
| CLS por carga tardía de fuentes | `font-display: swap` + `<link rel="preload">` para las dos fuentes críticas |
| Overflow horizontal en mobile | Validar con Chrome DevTools en 375px antes de publicar cambios visuales |
