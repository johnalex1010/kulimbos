# Plan de adaptación del CPT de productos a fichas técnicas

Fecha: 2026-08-30  
Alcance de este documento: planificar la modificación futura de `inc/custom-post-types.php` y módulos relacionados para que el CPT `producto` soporte las nuevas fichas técnicas ubicadas en `docs/`.  
Estado: propuesta técnica, sin implementación de código.

## 1. Contexto

El tema Kulimbos ya registra el CPT `producto`, la taxonomía jerárquica `categoria_producto`, taxonomías internas de filtros (`edad_producto`, `tamano_producto`, `color_producto`, `material_producto`), metadatos básicos (`kulimbos_product_price`, `kulimbos_product_stock`, galería) y lógica de comentarios con calificación.

Las nuevas fichas técnicas en Excel amplían el modelo de producto. Ya no basta con un producto de precio único y cuatro filtros generales. Hay productos simples, productos personalizables, sets con combinaciones, productos con tablas de tallas, productos con variantes por color/diseño/tamaño, productos con fuentes de precio, productos con advertencias regulatorias y productos con campos pendientes de verificación.

El cambio debe hacerse sin romper:

- Rutas existentes de productos: `/productos/%categoria_producto%/%postname%/`.
- Archivo `/productos/` y taxonomía `/categoria/...`.
- Productos existentes que usan precio, stock, galería y filtros actuales.
- Carrito y favoritos locales, que hoy consumen `id`, `name`, `price`, `url`, `image` y `stock`.
- Compatibilidad WordPress, REST y Yoast SEO.

## 2. Stack y evidencia técnica

Evidencia revisada:

- `README.md`
- `package.json`
- `inc/custom-post-types.php`
- `template-parts/pages/product-detail.php`
- `template-parts/pages/plushies.php`
- `template-parts/home/featured-products.php`
- Fichas `.xlsx` dentro de `docs/`

Stack confirmado:

- CMS: WordPress.
- Backend del tema: PHP 8.1+.
- Frontend: templates PHP, SCSS y JavaScript vanilla.
- Build: npm + Gulp 5.
- Assets fuente: `assets/scss/**`, `assets/js/**`, `assets/admin/**`.
- Assets generados que no se deben editar manualmente: `assets/css/**`, `assets/production/mincss/**`, `assets/production/minjs/**`.
- ACF: opcional; no debe asumirse activo sin `function_exists( 'get_field' )`.

## 3. Inventario de información detectada en las fichas

### 3.1 Campos comunes

Campos presentes en varias fichas:

- Nombre del producto.
- Categoría.
- Descripción corta.
- Descripción larga.
- Características principales.
- Material.
- Estampado / impresión.
- Colores disponibles.
- Tamaños disponibles.
- Precio de venta Kulimbos.
- Precio regular / precio oferta.
- Cuidados recomendados.
- Cómo personalizar.
- Ideas de uso / ocasiones.
- Imágenes de referencia.
- Nota de verificación.
- Pendientes por verificar.

### 3.2 Productos personalizados

Fichas detectadas:

- `Ficha_Producto_Cobija_Piel_Conejo.xlsx`
- `Ficha_Producto_Set_Papa_Hijo.xlsx`
- `Ficha_Producto_Set_Personalizado_Mama_Bebe.xlsx`
- `Ficha_Producto_Termo_Digital.xlsx`

Variables necesarias:

- Diseños disponibles.
- Texto personalizable.
- Fotos requeridas.
- Combinaciones de set.
- Color de prenda o tapa.
- Tallas por tipo de prenda.
- Tabla de medidas.
- Técnica de estampado.
- Parámetros de sublimación cuando aplique.
- Confirmación de diseño antes de imprimir.
- Cuidados por tipo de material.
- Estado de datos pendientes con proveedor.

### 3.3 Leches, fórmulas y nutrición

Ficha detectada:

- `Fichas_Producto_Leches.xlsx`

Campos necesarios:

- Marca.
- Producto.
- Presentación.
- Etapa / edad.
- Descripción corta.
- Descripción larga.
- Características principales.
- Ingredientes clave explicados.
- Modo de preparación.
- Información importante / advertencias.
- Ficha técnica.
- Registro INVIMA cuando exista.
- EAN cuando exista.
- Origen cuando exista.
- Precio referencia mercado.
- Precio de venta Kulimbos.
- Fuentes de precio.
- Cómo superar a la competencia.
- Pendiente de verificar en empaque físico.
- Imagen de referencia.

Riesgo especial: estas fichas incluyen afirmaciones nutricionales, advertencias de lactancia materna, alimentos con fines médicos especiales y posibles requisitos de fórmula médica. No deben publicarse claims médicos sin validación editorial/legal.

## 4. Objetivo funcional

Adaptar el CPT `producto` para que pueda almacenar, validar y exponer fichas técnicas completas con una estructura mantenible, segura y escalable.

El producto debe poder representar:

- Producto simple con precio y stock únicos.
- Producto con variantes por diseño, talla, color, presentación o combinación.
- Producto personalizable con instrucciones para el cliente.
- Producto regulado o sensible con advertencias, fuentes y pendientes de verificación.
- Tablas técnicas reutilizables, especialmente tallas, medidas, presentaciones y precios por variante.

Debe mantenerse:

- CPT `producto`.
- Taxonomía principal `categoria_producto`.
- Metadatos existentes como fallback.
- Galería actual.
- Cálculo de reseñas desde comentarios aprobados.
- Flujo de carrito/favoritos mientras no exista selección avanzada de variantes.

## 5. Clasificación del cambio

Cambio funcional con puntos críticos.

Es funcional porque agrega una estructura de datos nueva para productos y cambia el flujo editorial del admin.

Tiene puntos críticos porque puede afectar:

- Guardado de metadatos.
- Sanitización de entradas del admin.
- REST API.
- Carrito/favoritos.
- SEO del detalle de producto.
- Claims legales/regulatorios en productos nutricionales.

## 6. Propuesta de arquitectura

### 6.1 Mantener el CPT, no crear CPTs nuevos

No crear un CPT separado para leches, termos o productos personalizados. La entidad sigue siendo `producto`.

Razón:

- El catálogo ya consulta `post_type => producto`.
- Las rutas y templates ya están acoplados a `producto`.
- Carrito, favoritos, destacados, archivo y taxonomías ya dependen de este CPT.
- Separar por CPT duplicaría lógica de catálogo sin necesidad.

### 6.2 Separar atributos filtrables de ficha técnica

Usar taxonomías para atributos que el usuario filtra o navega:

- `categoria_producto`
- `edad_producto`
- `tamano_producto`
- `color_producto`
- `material_producto`

Evaluar agregar taxonomías nuevas solo si se usarán como filtros reales:

- `marca_producto`: útil para Nestlé, Abbott, Enfamil/Enfagrow.
- `tipo_producto`: útil para fórmula infantil, alimento lácteo, nutrición médica, ropa personalizada, accesorio personalizado, cobija.
- `presentacion_producto`: solo si se filtrará por 800 g, 1400 g, 1800 g, 500 ml, set x2, set x3. Si no se filtra, dejar como metadato.

No convertir cada dato técnico en taxonomía. Datos como EAN, INVIMA, modo de preparación, advertencias, fuentes o parámetros de sublimación deben ser metadatos.

### 6.3 Usar metadatos registrados para ficha técnica

Agregar registros con `register_post_meta()` para campos nuevos, con `show_in_rest`, sanitización y `auth_callback` adecuados.

Campos escalares recomendados:

| Meta key | Tipo | Uso |
|---|---:|---|
| `kulimbos_product_regular_price` | string | Precio regular en COP |
| `kulimbos_product_sale_price` | string | Precio oferta en COP |
| `kulimbos_product_sku` | string | Referencia interna o SKU si se define |
| `kulimbos_product_ean` | string | Código EAN |
| `kulimbos_product_invima` | string | Registro INVIMA |
| `kulimbos_product_brand` | string | Marca como fallback si no se crea taxonomía |
| `kulimbos_product_presentation` | string | Presentación visible |
| `kulimbos_product_stage_age` | string | Etapa o edad visible |
| `kulimbos_product_origin` | string | País de origen |
| `kulimbos_product_capacity` | string | Capacidad, por ejemplo 500 ml |
| `kulimbos_product_dimensions` | string | Dimensiones generales |
| `kulimbos_product_print_method` | string | DTF, sublimación, técnica mixta |
| `kulimbos_product_material_detail` | string | Material técnico completo |
| `kulimbos_product_care_instructions` | string | Cuidados recomendados |
| `kulimbos_product_personalization_instructions` | string | Cómo personalizar |
| `kulimbos_product_usage_occasions` | string | Ideas de uso |
| `kulimbos_product_preparation_mode` | string | Modo de preparación |
| `kulimbos_product_warnings` | string | Advertencias importantes |
| `kulimbos_product_key_ingredients` | string | Ingredientes explicados |
| `kulimbos_product_competitive_angle` | string | Cómo superar competencia |
| `kulimbos_product_verification_note` | string | Nota de verificación |
| `kulimbos_product_pending_verification` | string | Pendientes antes de publicar |
| `kulimbos_product_source_notes` | string | Fuentes resumidas |

Campos estructurados recomendados:

| Meta key | Tipo REST | Uso |
|---|---|---|
| `kulimbos_product_features` | array de strings | Características principales |
| `kulimbos_product_designs` | array de objetos | Diseños disponibles |
| `kulimbos_product_variants` | array de objetos | Variantes comerciales |
| `kulimbos_product_size_tables` | array de objetos | Tablas de tallas/medidas |
| `kulimbos_product_market_prices` | array de objetos | Precios de referencia por proveedor |
| `kulimbos_product_reference_images` | array de strings | Notas o rutas de imágenes de referencia |

### 6.4 Mantener precio principal compatible

El campo actual `kulimbos_product_price` debe seguir existiendo como precio principal para:

- Cards.
- Destacados.
- Listados.
- Carrito.
- Favoritos.
- WhatsApp.

Regla propuesta:

- `kulimbos_product_price` sigue siendo el precio efectivo base.
- `kulimbos_product_regular_price` y `kulimbos_product_sale_price` agregan contexto comercial.
- Si existen variantes con precios, el frontend puede mostrar “Desde $X” en una fase posterior.
- Mientras no se implemente selección de variantes en carrito, no se debe enviar una variante implícita ni inventada.

### 6.5 Estructura sugerida de variantes

Guardar `kulimbos_product_variants` como array validado de objetos:

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

Estados permitidos:

- `active`
- `draft`
- `pending`
- `unavailable`

No usar variantes para reemplazar taxonomías. Las variantes describen compra/presentación; las taxonomías describen navegación/filtro.

### 6.6 Estructura sugerida de tablas técnicas

Guardar `kulimbos_product_size_tables` como array validado:

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

Validaciones:

- `title`, `columns` y `rows` sanitizados.
- Límite máximo de columnas y filas para evitar payloads enormes.
- Salida escapada al renderizar.
- No permitir HTML arbitrario.

### 6.7 Estructura sugerida para fuentes y precios de mercado

Guardar `kulimbos_product_market_prices` como array:

```json
[
  {
    "source": "SubliFly",
    "location": "Bogotá",
    "price_type": "Mayorista",
    "price_label": "$24.000 COP c/u",
    "conditions": "Insumo en blanco, IVA incluido",
    "url_or_note": "sublifly.co"
  }
]
```

Estos datos deben ser internos o visibles solo si se define una sección editorial. No deben mezclarse con precio público sin criterio comercial.

## 7. Cambios propuestos en `inc/custom-post-types.php`

### Fase 1: refuerzo del modelo de metadatos

Modificar `kulimbos_register_product_meta()` para:

- Mantener metadatos actuales.
- Agregar campos escalares con callbacks de sanitización específicos.
- Agregar campos estructurados con schema REST explícito.
- Usar `auth_callback` con `current_user_can( 'edit_posts' )` o, idealmente, `current_user_can( 'edit_post', $post_id )` si se implementa callback con contexto.

Crear callbacks nuevos:

- `kulimbos_sanitize_product_money_meta()`
- `kulimbos_sanitize_product_plain_text_meta()`
- `kulimbos_sanitize_product_long_text_meta()`
- `kulimbos_sanitize_product_string_list_meta()`
- `kulimbos_sanitize_product_variants_meta()`
- `kulimbos_sanitize_product_size_tables_meta()`
- `kulimbos_sanitize_product_market_prices_meta()`

### Fase 2: taxonomías nuevas, solo si se confirman como filtros

Evaluar dentro de `kulimbos_register_tax_producto_filtros()`:

- Agregar `marca_producto`.
- Agregar `tipo_producto`.

No agregar `presentacion_producto` todavía salvo que el diseño de filtros lo necesite.

Seed inicial sugerido si se implementan:

- Marcas: Nestlé, Abbott, Enfamil/Enfagrow.
- Tipos: Fórmula infantil, alimento lácteo, nutrición médica, ropa personalizada, accesorio personalizado, cobija personalizada.

Actualizar versión interna del seed para no reinsertar datos existentes.

### Fase 3: metaboxes de ficha técnica

Agregar metaboxes separados para no sobrecargar la caja lateral actual:

- **Datos comerciales**: precio base, precio regular, precio oferta, stock, SKU/EAN si aplica.
- **Ficha técnica**: presentación, etapa/edad, material, estampado, dimensiones/capacidad, origen, INVIMA.
- **Contenido comercial**: características, ingredientes explicados, cuidados, preparación, personalización, ocasiones.
- **Variantes y tallas**: diseños, variantes, tablas de tallas o medidas.
- **Validación editorial**: advertencias, fuentes, pendientes de verificación, nota interna.

La caja actual **Datos del producto** puede mantenerse para precio/stock en la primera fase y ampliarse solo con precio regular/oferta. Para campos largos y tablas, usar cajas `normal` y no `side`.

### Fase 4: guardado seguro

Extender o separar `kulimbos_save_product_data_meta_box()`:

- Mantener verificación de nonce.
- Mantener `DOING_AUTOSAVE`.
- Mantener `current_user_can( 'edit_post', $post_id )`.
- Sanitizar cada campo según tipo.
- Borrar metadatos vacíos para evitar basura.
- Validar arrays estructurados con allowlist de claves.
- No aceptar HTML en campos estructurados.
- No guardar datos de formularios frontend; esto aplica solo al admin.

Para evitar una función enorme, separar guardado por grupo:

- `kulimbos_save_product_commercial_meta_box()`
- `kulimbos_save_product_technical_meta_box()`
- `kulimbos_save_product_content_meta_box()`
- `kulimbos_save_product_variants_meta_box()`
- `kulimbos_save_product_editorial_meta_box()`

### Fase 5: helpers de lectura

Agregar helpers de lectura en `inc/custom-post-types.php` o moverlos después a un módulo dedicado si crecen demasiado:

- `kulimbos_get_product_price_data( int $post_id ): array`
- `kulimbos_get_product_technical_sheet( int $post_id ): array`
- `kulimbos_get_product_variants( int $post_id ): array`
- `kulimbos_get_product_size_tables( int $post_id ): array`
- `kulimbos_get_product_public_warnings( int $post_id ): string`
- `kulimbos_product_has_pending_verification( int $post_id ): bool`

Estos helpers deben centralizar fallbacks y evitar que los templates lean metadatos crudos en muchos lugares.

## 8. Cambios posteriores fuera de `custom-post-types.php`

Aunque la solicitud futura se enfoque en el CPT, la adaptación completa tocará otros archivos.

### Templates

Actualizar `template-parts/pages/product-detail.php` para mostrar:

- Ficha técnica.
- Características principales.
- Variantes visibles.
- Tablas de tallas.
- Cuidados.
- Modo de preparación en leches.
- Advertencias visibles en productos nutricionales.
- Personalización en productos personalizados.

Actualizar `template-parts/pages/plushies.php` o renombrar conceptualmente el parcial porque hoy funciona como listado general pero conserva nombres visuales de “peluches”.

Actualizar `template-parts/home/featured-products.php` para soportar:

- Precio “desde” si el producto tiene variantes.
- Precio oferta si existe.
- Stock derivado de variantes si aplica.

### Estilos

Agregar SCSS fuente para:

- Bloques de ficha técnica.
- Tablas responsive.
- Selector visual de variantes.
- Advertencias y notas regulatorias.
- Secciones de personalización.

Después ejecutar Gulp. No editar manualmente archivos compilados.

### JavaScript

Solo si se implementa selección de variantes en frontend:

- Capturar variante seleccionada.
- Actualizar precio/stock visible.
- Enviar `variant_id` al carrito local.
- Evitar agregar al carrito si falta elegir talla/color/diseño requerido.

Este punto no debe hacerse hasta confirmar UX y reglas de compra.

### README

Actualizar `README.md` cuando se implemente, porque cambiará:

- Flujo editorial del catálogo.
- Metadatos del producto.
- Posibles taxonomías nuevas.
- Reglas de carrito si hay variantes.
- Validaciones recomendadas.

## 9. Mapeo de fichas a estructura propuesta

### Cobija personalizada piel de conejo

Categoría sugerida:

- `categoria_producto`: Regalos personalizados > Cobijas y mantas personalizadas.
- `tipo_producto`: Cobija personalizada.

Metadatos:

- Material: tela tipo piel de conejo / peach skin.
- Estampado: sublimación o DTF, pendiente de confirmar.
- Diseños: Familiar, Infantil “El Mejor Hijo del Mundo”.
- Variantes: diseño + tamaño.
- Tamaños: 100 x 150 cm, 120 x 150 cm, 150 x 200 cm como `pending` hasta confirmar.
- Personalización: 4 a 6 fotos, frase editable, confirmación de diseño.
- Cuidados: lavado en agua fría, ciclo suave, sin blanqueador.
- Pendientes: medidas, precios, técnica exacta y nombre real del blank.

### Set personalizado familia

Categoría sugerida:

- `categoria_producto`: Ropa personalizada > Conjuntos a juego en familia.
- `tipo_producto`: Ropa personalizada.

Metadatos:

- Combinaciones: Papá + Hijo, Mamá + Hijo, Mamá + Papá + Hijo.
- Material: 100% algodón.
- Estampado: DTF full color.
- Colores: blanco, negro, rojo, verde claro, verde militar, azul rey, azul claro, rosado, fucsia, morado, lila.
- Tablas: mujer, adulto, niños.
- Diseños: temático “El Mejor...” y diseño 100% personalizable.
- Pendientes: imágenes limpias para algunas combinaciones.

### Set personalizado mamá y bebé/niño

Categoría sugerida:

- `categoria_producto`: Ropa personalizada > Conjuntos a juego mamá e hijo(a).
- `tipo_producto`: Ropa personalizada.

Metadatos:

- Material: algodón para camisetas; body pendiente por proveedor.
- Estampado: DTF full color.
- Colores: misma lista de 11 colores.
- Tablas: mujer, niños, adulto, body bebé.
- Personalización: nombres, texto, diseño temático o libre.
- Pendientes: composición real del body y medidas finales del blank usado por Kulimbos.

### Termo digital personalizado

Categoría sugerida:

- `categoria_producto`: Regalos personalizados > Accesorios para mamá y familia.
- `tipo_producto`: Accesorio personalizado.

Metadatos:

- Capacidad: 500 ml.
- Material: acero inoxidable 304, doble pared, libre de BPA.
- Dimensiones: 23 cm alto x 6,5 cm diámetro.
- Área de sublimación: 16 cm x 20 cm.
- Técnica: sublimación full color.
- Parámetros: 195 °C / 70 segundos, como referencia.
- Colores de tapa: según proveedor; marcar disponibilidad por lote.
- Proveedores/precios: SubliFly, Guiboga, referencias de mercado.
- Pendientes: batería/pila, duración frío/calor, aptitud para bebidas de bebé.

### Leches, fórmulas y nutrición

Categorías sugeridas:

- Fórmula infantil bebé.
- Alimento lácteo niño.
- Nutrición niños.
- Nutrición adultos.

Metadatos:

- Marca.
- Presentación.
- Etapa/edad.
- Ingredientes clave.
- Modo de preparación.
- Advertencias.
- INVIMA/EAN/origen.
- Precio de venta Kulimbos.
- Precios de referencia.
- Fuentes.
- Pendientes de empaque físico.

Regla editorial:

- Separar productos para bebés, niños y adultos con claridad.
- Mostrar avisos legales cuando aplique.
- No presentar afirmaciones médicas como absolutas; usar lenguaje atribuido cuando provenga de marca o proveedor.
- No publicar productos con `pending_verification` crítico sin revisión humana.

## 10. Acceptance Criteria

La implementación futura será aceptable si:

- El CPT `producto` sigue registrado y accesible.
- Las rutas existentes de productos y categorías siguen funcionando.
- Los productos actuales no pierden precio, stock, galería ni filtros.
- Los nuevos metadatos están registrados con `register_post_meta()`.
- Los metadatos estructurados tienen schema REST explícito.
- Todo campo guardado desde admin se sanitiza.
- Toda salida nueva se escapa según contexto.
- Los campos vacíos se borran o se ignoran de forma consistente.
- Las variantes permiten representar diseño, talla, color, presentación, precio, stock y estado.
- Las tablas técnicas permiten representar tallas y medidas sin HTML arbitrario.
- Los productos nutricionales pueden guardar advertencias, preparación, ingredientes, INVIMA/EAN y pendientes de verificación.
- El frontend no inventa variantes ni precios cuando falten datos.
- El carrito no agrega variantes sin selección explícita si estas son obligatorias.
- No se editan manualmente archivos generados por Gulp.
- El README queda actualizado si se implementan cambios de flujo editorial o build.

## 11. Validación obligatoria cuando se implemente

### Validación técnica

- `php -l inc/custom-post-types.php`
- `php -l` en todo PHP modificado.
- `git diff --check`
- Buscar ausencia de debugging: `console.log`, `var_dump`, `print_r`, `die`.
- Verificar que no se modificaron manualmente `assets/css/**`, `assets/production/mincss/**` ni `assets/production/minjs/**`.

### Validación admin WordPress

Usar navegador durante el desarrollo y pruebas.

- Crear producto simple con precio/stock.
- Crear producto con variantes.
- Crear producto con tabla de tallas.
- Crear producto nutricional con advertencias.
- Guardar, recargar y confirmar persistencia.
- Validar autosave/revisión sin pérdida de datos.
- Validar usuario sin permisos suficientes si aplica.

No enviar formularios frontend reales sin autorización.

### Validación frontend

- Producto simple mantiene diseño actual.
- Producto con ficha técnica muestra secciones completas.
- Producto con campos pendientes no muestra información no confirmada como definitiva.
- Producto nutricional muestra advertencias visibles.
- Tablas son legibles en mobile, tablet y desktop.
- Cards/listados siguen mostrando precio, stock, imagen y rating.
- Carrito/favoritos conservan comportamiento previo para productos sin variantes.
- Consola del navegador sin errores JS introducidos.

### Validación SEO / GEO / AEO

- Mantener un solo `h1`.
- No duplicar metadata ni schema de Yoast.
- Ficha técnica visible y semántica, no oculta de forma engañosa.
- Advertencias y edades visibles en productos regulados.
- Evitar thin content; no publicar fichas vacías.
- Revisar títulos, descripciones y entidades de producto.

### Validación de contenido

- Español Colombia.
- Acentos correctos.
- Sin mojibake.
- Tono profesional.
- Claims médicos revisados y atribuidos cuando aplique.
- Campos pendientes claramente identificados como pendientes, no como especificación final.

## 12. Riesgos y mitigaciones

| Riesgo | Mitigación |
|---|---|
| Romper productos actuales | Mantener metadatos existentes y helpers con fallback |
| Sobrecargar `custom-post-types.php` | Separar funciones por responsabilidad; evaluar módulo nuevo si crece demasiado |
| Publicar specs no confirmadas | Guardar `pending_verification` y no renderizar como dato definitivo |
| Claims médicos/regulatorios incorrectos | Campo de advertencias, revisión editorial/legal y lenguaje atribuido |
| Variantes incompletas en carrito | No activar compra por variante hasta definir UX y validación |
| Taxonomías excesivas | Crear solo las que se usen para navegación/filtro real |
| REST con estructuras inseguras | Schema explícito y sanitización por allowlist |
| Duplicar SEO con Yoast | No agregar schema/meta manual sin SPEC SEO aparte |
| Degradar responsive | Tablas con diseño responsive y QA en 375, 768, 1024 y 1280 px |

## 13. Rollback

Rollback documental para la implementación futura:

- Revertir cambios en `inc/custom-post-types.php`.
- Revertir templates modificados: `template-parts/pages/product-detail.php`, `template-parts/pages/plushies.php`, `template-parts/home/featured-products.php`, si fueron tocados.
- Revertir SCSS fuente agregado y recompilar con `npm run build`.
- No borrar metadatos nuevos de la base de datos en el rollback inicial; dejarlos inactivos evita pérdida de contenido editorial.
- Si se crearon taxonomías nuevas, mantenerlas registradas temporalmente o documentar un proceso de migración antes de retirarlas.
- Ir a **Ajustes → Enlaces permanentes** y guardar si se cambian rewrites.

Comandos seguros de validación post-rollback:

```bash
php -l inc/custom-post-types.php
npm run build
git diff --check
```

## 14. Secuencia recomendada de implementación

1. Confirmar con negocio qué campos serán públicos, internos o pendientes.
2. Confirmar si `marca_producto` y `tipo_producto` serán filtros reales.
3. Definir UX de variantes antes de tocar carrito.
4. Implementar metadatos escalares y sanitizadores.
5. Implementar metadatos estructurados y schemas REST.
6. Agregar metaboxes administrativos por grupos.
7. Agregar helpers de lectura.
8. Migrar el detalle de producto para renderizar ficha técnica.
9. Actualizar listados y destacados con precio oferta/desde.
10. Implementar selección de variantes solo si está aprobada.
11. Ejecutar build si hubo SCSS/JS.
12. Actualizar README.
13. Hacer QA con navegador en admin y frontend.

## 15. Decisiones pendientes

- ¿Las fichas técnicas serán editadas manualmente desde WordPress o importadas desde Excel?
- ¿Las fuentes de precio serán visibles al público o solo internas?
- ¿Se mostrará precio regular/oferta en el frontend?
- ¿Las variantes afectarán carrito desde esta fase o solo se mostrarán en ficha?
- ¿Se debe bloquear la compra cuando falten talla/color/diseño?
- ¿`marca_producto` y `tipo_producto` serán filtros visibles?
- ¿Qué productos nutricionales requieren revisión legal antes de publicación?
- ¿Cómo se marcará en admin un producto “listo para publicar” vs “pendiente de verificar”?

## 16. Definition of Done esperada

La adaptación futura estará terminada solo cuando:

- Exista SPEC aprobada para la fase concreta.
- Se respete el alcance acordado.
- Los campos nuevos estén registrados, sanitizados y documentados.
- Los metaboxes guarden y recuperen datos correctamente.
- El frontend renderice solo datos confirmados.
- Productos actuales sigan funcionando.
- Carrito/favoritos no tengan regresiones.
- Responsive, accesibilidad, SEO/GEO/AEO y seguridad estén validados.
- Build funcione si hubo cambios de assets.
- README esté actualizado si cambió el flujo editorial.
- Rollback esté documentado.

## 17. Sugerencia de commit futuro

Cuando se implemente el cambio funcional, la sugerencia de commit sería:

```text
feat: ampliar modelo de productos para fichas técnicas
```

Para este documento únicamente:

```text
docs: planificar adaptación del CPT de productos
```
