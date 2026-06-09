<?php

/**
 * Contenido de la plantilla "Peluches Kulimbos".
 *
 * @package Kulimbos
 */

defined('ABSPATH') || exit;

$catalog_mode         = isset($args['catalog_mode']) ? sanitize_key($args['catalog_mode']) : '';
$is_all_products_view = 'all-products' === $catalog_mode;

$theme_uri = get_template_directory_uri();
$theme_dir = get_template_directory();

$hero_image = array(
	'src'  => $theme_uri . '/assets/img/products/oso-peluche.png',
	'path' => $theme_dir . '/assets/img/products/oso-peluche.png',
	'alt'  => __('Peluches suaves para bebés y niños', 'kulimbos'),
);

$page_title       = $is_all_products_view ? __('Categorías', 'kulimbos') : __('Peluches', 'kulimbos');
$page_description = __('Compañeros suaves y tiernos para abrazar, jugar y crear momentos inolvidables.', 'kulimbos');
$current_term     = (! $is_all_products_view && is_tax('categoria_producto')) ? get_queried_object() : null;

if ($is_all_products_view) {
	$page_description = __('Explora todos los productos disponibles en Kulimbos sin importar su categoría.', 'kulimbos');
}

if ($current_term instanceof WP_Term) {
	$page_title       = $current_term->name;
	$page_description = term_description($current_term, 'categoria_producto') ?: $page_description;
}

$feature_items = array(
	array(
		'icon'  => 'heart',
		'title' => __('Suaves y seguros', 'kulimbos'),
		'text'  => __('Materiales de calidad', 'kulimbos'),
		'color' => 'coral',
	),
	array(
		'icon'  => 'shield-check',
		'title' => __('Hipoalergénicos', 'kulimbos'),
		'text'  => __('Ideales para bebés', 'kulimbos'),
		'color' => 'mint',
	),
	array(
		'icon'  => 'package',
		'title' => __('Fáciles de lavar', 'kulimbos'),
		'text'  => __('A mano o en lavadora', 'kulimbos'),
		'color' => 'purple',
	),
	array(
		'icon'  => 'sparkles',
		'title' => __('Regalos perfectos', 'kulimbos'),
		'text'  => __('Para cualquier ocasión', 'kulimbos'),
		'color' => 'rose',
	),
);

$products = array(
	array(
		'image'    => 'oso-peluche.png',
		'alt'      => __('Oso de peluche suave', 'kulimbos'),
		'name'     => __('Oso de peluche', 'kulimbos'),
		'category' => 'osos',
		'age'      => '0-1',
		'size'     => 'mediano',
		'color'    => 'cafe',
		'material' => 'felpa',
		'rating'   => 4.5,
		'reviews'  => 128,
		'price'    => 79900,
		'url'      => home_url('/productos/oso-de-peluche/'),
	),
	array(
		'image'    => '',
		'alt'      => __('Espacio reservado para conejo rosado de peluche', 'kulimbos'),
		'name'     => __('Conejo rosado', 'kulimbos'),
		'category' => 'conejos',
		'age'      => '0-1',
		'size'     => 'pequeno',
		'color'    => 'rosado',
		'material' => 'algodon',
		'rating'   => 5,
		'reviews'  => 96,
		'price'    => 69900,
		'url'      => home_url('/productos/conejo-rosado/'),
	),
	array(
		'image'    => '',
		'alt'      => __('Espacio reservado para elefante de peluche', 'kulimbos'),
		'name'     => __('Elefante de peluche', 'kulimbos'),
		'category' => 'selva',
		'age'      => '1-3',
		'size'     => 'grande',
		'color'    => 'gris',
		'material' => 'hipoalergenico',
		'rating'   => 4.5,
		'reviews'  => 74,
		'price'    => 79900,
		'url'      => home_url('/productos/elefante-de-peluche/'),
	),
	array(
		'image'    => '',
		'alt'      => __('Espacio reservado para león de peluche', 'kulimbos'),
		'name'     => __('León de peluche', 'kulimbos'),
		'category' => 'selva',
		'age'      => '3-6',
		'size'     => 'mediano',
		'color'    => 'naranja',
		'material' => 'felpa',
		'rating'   => 4.5,
		'reviews'  => 81,
		'price'    => 74900,
		'url'      => home_url('/productos/leon-de-peluche/'),
	),
	array(
		'image'    => '',
		'alt'      => __('Espacio reservado para panda de peluche', 'kulimbos'),
		'name'     => __('Panda de peluche', 'kulimbos'),
		'category' => 'selva',
		'age'      => '1-3',
		'size'     => 'mediano',
		'color'    => 'gris',
		'material' => 'felpa',
		'rating'   => 4.5,
		'reviews'  => 63,
		'price'    => 79900,
		'url'      => home_url('/productos/panda-de-peluche/'),
	),
	array(
		'image'    => '',
		'alt'      => __('Espacio reservado para jirafa de peluche', 'kulimbos'),
		'name'     => __('Jirafa de peluche', 'kulimbos'),
		'category' => 'selva',
		'age'      => '3-6',
		'size'     => 'grande',
		'color'    => 'amarillo',
		'material' => 'algodon',
		'rating'   => 5,
		'reviews'  => 55,
		'price'    => 69900,
		'url'      => home_url('/productos/jirafa-de-peluche/'),
	),
	array(
		'image'    => '',
		'alt'      => __('Espacio reservado para dinosaurio de peluche', 'kulimbos'),
		'name'     => __('Dinosaurio de peluche', 'kulimbos'),
		'category' => 'personajes',
		'age'      => '3-6',
		'size'     => 'grande',
		'color'    => 'verde',
		'material' => 'hipoalergenico',
		'rating'   => 4.5,
		'reviews'  => 18,
		'price'    => 89900,
		'url'      => home_url('/productos/dinosaurio-de-peluche/'),
	),
	array(
		'image'    => '',
		'alt'      => __('Espacio reservado para ballena de peluche', 'kulimbos'),
		'name'     => __('Ballena de peluche', 'kulimbos'),
		'category' => 'marinos',
		'age'      => '0-1',
		'size'     => 'pequeno',
		'color'    => 'azul',
		'material' => 'algodon',
		'rating'   => 4.5,
		'reviews'  => 42,
		'price'    => 59900,
		'url'      => home_url('/productos/ballena-de-peluche/'),
	),
	array(
		'image'    => '',
		'alt'      => __('Espacio reservado para perezoso de peluche', 'kulimbos'),
		'name'     => __('Perezoso de peluche', 'kulimbos'),
		'category' => 'selva',
		'age'      => '6-mas',
		'size'     => 'extra',
		'color'    => 'cafe',
		'material' => 'felpa',
		'rating'   => 5,
		'reviews'  => 27,
		'price'    => 69900,
		'url'      => home_url('/productos/perezoso-de-peluche/'),
	),
	array(
		'image'    => '',
		'alt'      => __('Espacio reservado para vaca de peluche', 'kulimbos'),
		'name'     => __('Vaca de peluche', 'kulimbos'),
		'category' => 'granja',
		'age'      => '1-3',
		'size'     => 'mediano',
		'color'    => 'gris',
		'material' => 'felpa',
		'rating'   => 5,
		'reviews'  => 31,
		'price'    => 69900,
		'url'      => home_url('/productos/vaca-de-peluche/'),
	),
	array(
		'image'    => '',
		'alt'      => __('Espacio reservado para perro de peluche', 'kulimbos'),
		'name'     => __('Perro de peluche', 'kulimbos'),
		'category' => 'personajes',
		'age'      => '1-3',
		'size'     => 'grande',
		'color'    => 'cafe',
		'material' => 'hipoalergenico',
		'rating'   => 4.5,
		'reviews'  => 68,
		'price'    => 74900,
		'url'      => home_url('/productos/perro-de-peluche/'),
	),
	array(
		'image'    => '',
		'alt'      => __('Espacio reservado para pulpo reversible', 'kulimbos'),
		'name'     => __('Pulpo reversible', 'kulimbos'),
		'category' => 'marinos',
		'age'      => '6-mas',
		'size'     => 'pequeno',
		'color'    => 'azul',
		'material' => 'algodon',
		'rating'   => 5,
		'reviews'  => 39,
		'price'    => 59900,
		'url'      => home_url('/productos/pulpo-reversible/'),
	),
);

if ($is_all_products_view || is_post_type_archive('producto') || is_tax('categoria_producto')) {
	$query_args = array(
		'post_type'      => 'producto',
		'posts_per_page' => $is_all_products_view ? -1 : 36,
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	if ($current_term instanceof WP_Term) {
		$query_args['tax_query'] = array(
			array(
				'taxonomy'         => 'categoria_producto',
				'field'            => 'term_id',
				'terms'            => array($current_term->term_id),
				'include_children' => true,
			),
		);
	}

	$products_query = new WP_Query($query_args);

	if ($products_query->have_posts()) {
		$products = array();

		while ($products_query->have_posts()) {
			$products_query->the_post();
			$product_id    = get_the_ID();
			$product_term  = function_exists('kulimbos_get_primary_product_category') ? kulimbos_get_primary_product_category($product_id) : null;
			$product_price = get_post_meta($product_id, 'kulimbos_product_price', true);
			$product_terms = get_the_terms($product_id, 'categoria_producto');
			$product_categories = array();

			if (! empty($product_terms) && ! is_wp_error($product_terms)) {
				foreach ($product_terms as $assigned_term) {
					if (! ($assigned_term instanceof WP_Term)) {
						continue;
					}

					$product_categories[] = $assigned_term->slug;

					foreach (get_ancestors($assigned_term->term_id, 'categoria_producto') as $ancestor_id) {
						$ancestor = get_term($ancestor_id, 'categoria_producto');
						if ($ancestor instanceof WP_Term) {
							$product_categories[] = $ancestor->slug;
						}
					}
				}
			}

			$product_categories = array_values(array_unique(array_map('sanitize_title', $product_categories)));

			$products[] = array(
				'image'     => '',
				'image_url' => get_the_post_thumbnail_url($product_id, 'kulimbos-product') ?: '',
				'alt'       => get_the_title(),
				'name'      => get_the_title(),
				'category'  => $product_term instanceof WP_Term ? $product_term->slug : 'sin-categoria',
				'categories' => ! empty($product_categories) ? $product_categories : array('sin-categoria'),
				'age'       => sanitize_key(get_post_meta($product_id, 'kulimbos_product_age', true) ?: '0-1'),
				'size'      => sanitize_key(get_post_meta($product_id, 'kulimbos_product_size', true) ?: 'mediano'),
				'color'     => sanitize_key(get_post_meta($product_id, 'kulimbos_product_color', true) ?: 'cafe'),
				'material'  => sanitize_key(get_post_meta($product_id, 'kulimbos_product_material', true) ?: 'felpa'),
				'rating'    => (float) (get_post_meta($product_id, 'kulimbos_product_rating', true) ?: 5),
				'reviews'   => (int) (get_post_meta($product_id, 'kulimbos_product_reviews', true) ?: 0),
				'price'     => $product_price ? (int) preg_replace('/[^\d]/', '', $product_price) : 0,
				'url'       => get_permalink(),
			);
		}

		wp_reset_postdata();
	}
}

$category_filter_terms = array();
$category_filter_label = __('Todos los peluches', 'kulimbos');

if ($is_all_products_view) {
	$category_filter_label = __('Todas las categorías', 'kulimbos');
	$top_level_terms       = get_terms(
		array(
			'taxonomy'   => 'categoria_producto',
			'parent'     => 0,
			'hide_empty' => false,
		)
	);

	if (! is_wp_error($top_level_terms) && ! empty($top_level_terms)) {
		$category_filter_terms = $top_level_terms;
	}
} elseif ($current_term instanceof WP_Term) {
	$category_filter_label = sprintf(
		/* translators: %s: category name. */
		__('Todos en %s', 'kulimbos'),
		$current_term->name
	);

	$children = get_terms(
		array(
			'taxonomy'   => 'categoria_producto',
			'parent'     => $current_term->term_id,
			'hide_empty' => false,
		)
	);

	if (! is_wp_error($children) && ! empty($children)) {
		$category_filter_terms = $children;
	}
}
?>

<section
	class="plushies-page"
	data-plushies-listing
	data-current-category="<?php echo esc_attr($current_term instanceof WP_Term ? $current_term->slug : 'all'); ?>"
	aria-labelledby="plushies-title">
	<div class="container">
		<nav class="plushies-breadcrumb" aria-label="<?php esc_attr_e('Miga de pan', 'kulimbos'); ?>">
			<ol class="plushies-breadcrumb__list" role="list">
				<li>
					<a href="<?php echo esc_url(home_url('/')); ?>">
						<?php kulimbos_the_icon('home', '', 25); ?>
						<span><?php esc_html_e('Inicio', 'kulimbos'); ?></span>
					</a>
				</li>
				<?php if ($current_term instanceof WP_Term) : ?>
					<?php foreach (array_reverse(get_ancestors($current_term->term_id, 'categoria_producto')) as $ancestor_id) : ?>
						<?php $ancestor = get_term($ancestor_id, 'categoria_producto'); ?>
						<?php if ($ancestor instanceof WP_Term) : ?>
							<li><a href="<?php echo esc_url(get_term_link($ancestor)); ?>"><?php echo esc_html($ancestor->name); ?></a></li>
						<?php endif; ?>
					<?php endforeach; ?>
					<li aria-current="page"><?php echo esc_html($current_term->name); ?></li>
				<?php elseif ($is_all_products_view) : ?>
					<li aria-current="page"><?php echo esc_html($page_title); ?></li>
				<?php else : ?>
					<li><a href="<?php echo esc_url(home_url('/categoria/juguetes/')); ?>"><?php esc_html_e('Juguetes', 'kulimbos'); ?></a></li>
					<li aria-current="page"><?php esc_html_e('Peluches', 'kulimbos'); ?></li>
				<?php endif; ?>
			</ol>
		</nav>

		<header class="plushies-hero">
			<div class="plushies-hero__content">
				<h1 id="plushies-title"><?php echo esc_html($page_title); ?></h1>
				<p><?php echo wp_kses_post($page_description); ?></p>
			</div>
			<div class="plushies-hero__visual" aria-hidden="true">
				<?php if (file_exists($hero_image['path'])) : ?>
					<img src="<?php echo esc_url($hero_image['src']); ?>" alt="" width="400" height="400" fetchpriority="high" decoding="async">
				<?php endif; ?>
			</div>
		</header>

		<div class="plushies-toolbar">
			<button class="plushies-toolbar__toggle" type="button" data-filter-toggle aria-expanded="true">
				<?php kulimbos_the_icon('menu', '', 18); ?>
				<span><?php esc_html_e('Ocultar filtros', 'kulimbos'); ?></span>
			</button>
			<p class="plushies-toolbar__count" data-filter-count>
				<?php echo esc_html(sprintf(__('Mostrando 1-12 de %d productos', 'kulimbos'), count($products))); ?>
			</p>
			<label class="plushies-toolbar__sort">
				<span><?php esc_html_e('Ordenar por:', 'kulimbos'); ?></span>
				<select data-filter-sort>
					<option value="popular"><?php esc_html_e('Más populares', 'kulimbos'); ?></option>
					<option value="price-asc"><?php esc_html_e('Menor precio', 'kulimbos'); ?></option>
					<option value="price-desc"><?php esc_html_e('Mayor precio', 'kulimbos'); ?></option>
					<option value="name-asc"><?php esc_html_e('Nombre A-Z', 'kulimbos'); ?></option>
				</select>
			</label>
			<div class="plushies-toolbar__views" aria-label="<?php esc_attr_e('Vista del listado', 'kulimbos'); ?>">
				<button type="button" class="is-active" data-view-mode="grid" aria-label="<?php esc_attr_e('Ver en cuadrícula', 'kulimbos'); ?>"><?php kulimbos_the_icon('layout-grid', '', 20); ?></button>
				<button type="button" data-view-mode="list" aria-label="<?php esc_attr_e('Ver en lista', 'kulimbos'); ?>"><?php kulimbos_the_icon('menu', '', 20); ?></button>
			</div>
		</div>

		<div class="plushies-layout">
			<aside class="plushies-filters" data-filter-panel aria-label="<?php esc_attr_e('Filtros de peluches', 'kulimbos'); ?>">
				<div class="plushies-filter-group">
					<h2><?php esc_html_e('Categorías', 'kulimbos'); ?></h2>
					<div class="plushies-category-filter" role="list">
						<button type="button" class="is-active" data-filter-category="all"><?php echo esc_html($category_filter_label); ?></button>
						<?php if (! empty($category_filter_terms)) : ?>
							<?php foreach ($category_filter_terms as $filter_term) : ?>
								<button type="button" data-filter-category="<?php echo esc_attr($filter_term->slug); ?>"><?php echo esc_html($filter_term->name); ?></button>
							<?php endforeach; ?>
						<?php elseif (! ($current_term instanceof WP_Term)) : ?>
							<button type="button" data-filter-category="osos"><?php esc_html_e('Osos', 'kulimbos'); ?></button>
							<button type="button" data-filter-category="conejos"><?php esc_html_e('Conejos', 'kulimbos'); ?></button>
							<button type="button" data-filter-category="selva"><?php esc_html_e('Animales de la selva', 'kulimbos'); ?></button>
							<button type="button" data-filter-category="granja"><?php esc_html_e('Animales de la granja', 'kulimbos'); ?></button>
							<button type="button" data-filter-category="marinos"><?php esc_html_e('Marinos', 'kulimbos'); ?></button>
							<button type="button" data-filter-category="personajes"><?php esc_html_e('Personajes', 'kulimbos'); ?></button>
						<?php endif; ?>
					</div>
				</div>

				<div class="plushies-filter-group">
					<h2><?php esc_html_e('Rango de precios', 'kulimbos'); ?></h2>
					<label class="plushies-price-filter">
						<span class="screen-reader-text"><?php esc_html_e('Precio máximo', 'kulimbos'); ?></span>
						<input type="range" min="20000" max="150000" step="1000" value="150000" data-filter-price-max>
					</label>
					<div class="plushies-price-filter__values">
						<span>$20.000</span>
						<strong data-filter-price-label>$150.000</strong>
					</div>
				</div>

				<div class="plushies-filter-group">
					<h2><?php esc_html_e('Edad recomendada', 'kulimbos'); ?></h2>
					<label><input type="checkbox" value="0-1" data-filter-checkbox="age"> <?php esc_html_e('0 a 1 años', 'kulimbos'); ?></label>
					<label><input type="checkbox" value="1-3" data-filter-checkbox="age"> <?php esc_html_e('1 a 3 años', 'kulimbos'); ?></label>
					<label><input type="checkbox" value="3-6" data-filter-checkbox="age"> <?php esc_html_e('3 a 6 años', 'kulimbos'); ?></label>
					<label><input type="checkbox" value="6-mas" data-filter-checkbox="age"> <?php esc_html_e('6+ años', 'kulimbos'); ?></label>
				</div>

				<div class="plushies-filter-group">
					<h2><?php esc_html_e('Tamaño', 'kulimbos'); ?></h2>
					<label><input type="checkbox" value="pequeno" data-filter-checkbox="size"> <?php esc_html_e('Pequeño (hasta 20 cm)', 'kulimbos'); ?></label>
					<label><input type="checkbox" value="mediano" data-filter-checkbox="size"> <?php esc_html_e('Mediano (20 a 35 cm)', 'kulimbos'); ?></label>
					<label><input type="checkbox" value="grande" data-filter-checkbox="size"> <?php esc_html_e('Grande (35 a 50 cm)', 'kulimbos'); ?></label>
					<label><input type="checkbox" value="extra" data-filter-checkbox="size"> <?php esc_html_e('Extra grande (50+ cm)', 'kulimbos'); ?></label>
				</div>

				<div class="plushies-filter-group">
					<h2><?php esc_html_e('Color', 'kulimbos'); ?></h2>
					<div class="plushies-color-filter" aria-label="<?php esc_attr_e('Filtrar por color', 'kulimbos'); ?>">
						<button type="button" data-filter-color="cafe" style="--swatch:#e6c59b;" aria-label="<?php esc_attr_e('Color café', 'kulimbos'); ?>"></button>
						<button type="button" data-filter-color="rosado" style="--swatch:#ffb7c7;" aria-label="<?php esc_attr_e('Color rosado', 'kulimbos'); ?>"></button>
						<button type="button" data-filter-color="gris" style="--swatch:#bfc1c6;" aria-label="<?php esc_attr_e('Color gris', 'kulimbos'); ?>"></button>
						<button type="button" data-filter-color="azul" style="--swatch:#8dc6f6;" aria-label="<?php esc_attr_e('Color azul', 'kulimbos'); ?>"></button>
						<button type="button" data-filter-color="verde" style="--swatch:#50c983;" aria-label="<?php esc_attr_e('Color verde', 'kulimbos'); ?>"></button>
					</div>
				</div>

				<div class="plushies-filter-group">
					<h2><?php esc_html_e('Material', 'kulimbos'); ?></h2>
					<label><input type="checkbox" value="algodon" data-filter-checkbox="material"> <?php esc_html_e('Algodón', 'kulimbos'); ?></label>
					<label><input type="checkbox" value="felpa" data-filter-checkbox="material"> <?php esc_html_e('Felpa suave', 'kulimbos'); ?></label>
					<label><input type="checkbox" value="hipoalergenico" data-filter-checkbox="material"> <?php esc_html_e('Hipoalergénico', 'kulimbos'); ?></label>
				</div>

				<button class="plushies-clear" type="button" data-filter-clear>
					<?php kulimbos_the_icon('x', '', 16); ?>
					<span><?php esc_html_e('Limpiar filtros', 'kulimbos'); ?></span>
				</button>
			</aside>

			<div class="plushies-results">
				<ul class="plushies-feature-bar" role="list">
					<?php foreach ($feature_items as $item) : ?>
						<li class="plushies-feature plushies-feature--<?php echo esc_attr($item['color']); ?>">
							<span class="plushies-feature__icon" aria-hidden="true"><?php kulimbos_the_icon($item['icon'], '', 34); ?></span>
							<strong><?php echo esc_html($item['title']); ?></strong>
							<span><?php echo esc_html($item['text']); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>

				<ul class="plushies-grid" data-filter-grid role="list">
					<?php foreach ($products as $product) : ?>
						<?php
						$image_path = ! empty($product['image']) ? $theme_dir . '/assets/img/products/' . sanitize_file_name($product['image']) : '';
						$image_url  = ! empty($product['image_url']) ? $product['image_url'] : (! empty($product['image']) ? $theme_uri . '/assets/img/products/' . sanitize_file_name($product['image']) : '');
						$product_category_slugs = ! empty($product['categories']) && is_array($product['categories']) ? $product['categories'] : array($product['category']);
						?>
						<li
							class="product-card plushies-card"
							data-filter-card
							data-category="<?php echo esc_attr($product['category']); ?>"
							data-categories="<?php echo esc_attr(implode(' ', array_map('sanitize_title', $product_category_slugs))); ?>"
							data-age="<?php echo esc_attr($product['age']); ?>"
							data-size="<?php echo esc_attr($product['size']); ?>"
							data-color="<?php echo esc_attr($product['color']); ?>"
							data-material="<?php echo esc_attr($product['material']); ?>"
							data-price="<?php echo absint($product['price']); ?>"
							data-name="<?php echo esc_attr($product['name']); ?>"
							data-popularity="<?php echo absint($product['reviews']); ?>">
							<div class="product-card__image-wrap">
								<?php if (($image_path && file_exists($image_path)) || ! empty($product['image_url'])) : ?>
									<img class="product-card__image" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($product['alt']); ?>" width="400" height="400" loading="lazy" decoding="async">
								<?php else : ?>
									<div class="product-card__image plushies-card__placeholder" role="img" aria-label="<?php echo esc_attr($product['alt']); ?>">
										<span><?php echo esc_html($product['name']); ?></span>
									</div>
								<?php endif; ?>
								<button class="product-card__wishlist" type="button" aria-label="<?php echo esc_attr(sprintf(__('Agregar %s a favoritos', 'kulimbos'), $product['name'])); ?>">
									<?php kulimbos_the_icon('heart', '', 25); ?>
								</button>
							</div>
							<div class="product-card__body">
								<h3 class="product-card__name">
									<a href="<?php echo esc_url($product['url']); ?>"><?php echo esc_html($product['name']); ?></a>
								</h3>
								<div class="product-card__rating" aria-label="<?php echo esc_attr(sprintf(__('Calificación: %s de 5', 'kulimbos'), $product['rating'])); ?>">
									<?php for ($i = 0; $i < 5; $i++) : ?>
										<span class="star <?php echo esc_attr($i < floor($product['rating']) ? 'star--full' : 'star--empty'); ?>" aria-hidden="true">
											<?php kulimbos_the_icon('star', '', 20); ?>
										</span>
									<?php endfor; ?>
									<span class="product-card__reviews">(<?php echo absint($product['reviews']); ?>)</span>
								</div>
								<div class="product-card__footer">
									<span class="product-card__price"><?php echo esc_html('$' . number_format($product['price'], 0, ',', '.')); ?></span>
									<button class="product-card__add-to-cart" type="button" aria-label="<?php echo esc_attr(sprintf(__('Agregar %s al carrito', 'kulimbos'), $product['name'])); ?>">
										<?php kulimbos_the_icon('shopping-cart', '', 25); ?>
									</button>
								</div>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>

				<p class="plushies-empty" data-filter-empty hidden><?php esc_html_e('No encontramos peluches con esos filtros.', 'kulimbos'); ?></p>

				<nav class="plushies-pagination" data-filter-pagination aria-label="<?php esc_attr_e('Paginación de peluches', 'kulimbos'); ?>">
					<button type="button" data-filter-page-prev aria-label="<?php esc_attr_e('Página anterior', 'kulimbos'); ?>"><?php kulimbos_the_icon('chevron-left', '', 18); ?></button>
					<span class="is-current">1</span>
					<button type="button" data-filter-page-next aria-label="<?php esc_attr_e('Página siguiente', 'kulimbos'); ?>"><?php kulimbos_the_icon('chevron-right', '', 18); ?></button>
				</nav>
			</div>
		</div>

		<section class="plushies-newsletter" aria-label="<?php esc_attr_e('Suscripción a novedades', 'kulimbos'); ?>">
			<div>
				<?php kulimbos_the_icon('heart', '', 54); ?>
				<div>
					<h2><?php esc_html_e('¡No te pierdas nada!', 'kulimbos'); ?></h2>
					<p><?php esc_html_e('Suscríbete y recibe novedades, ofertas y tips para tu pequeño.', 'kulimbos'); ?></p>
				</div>
			</div>
			<form action="<?php echo esc_url(home_url('/')); ?>" method="post">
				<label class="screen-reader-text" for="plushies-newsletter-email"><?php esc_html_e('Correo electrónico', 'kulimbos'); ?></label>
				<input id="plushies-newsletter-email" type="email" name="email" placeholder="<?php esc_attr_e('Ingresa tu correo electrónico', 'kulimbos'); ?>">
				<button type="submit"><?php esc_html_e('Suscribirme', 'kulimbos'); ?></button>
			</form>
		</section>
	</div>
</section>
