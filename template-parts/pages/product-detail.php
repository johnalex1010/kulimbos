<?php

/**
 * Contenido de la plantilla "Detalle de producto Kulimbos".
 *
 * @package Kulimbos
 */

defined('ABSPATH') || exit;

$theme_uri = get_template_directory_uri();
$theme_dir = get_template_directory();

$main_product = array(
	'image'       => 'oso-peluche.png',
	'name'        => __('Oso de peluche', 'kulimbos'),
	'alt'         => __('Oso de peluche cafe para bebé', 'kulimbos'),
	'price'       => '$79.900',
	'rating'      => 4.9,
	'reviews'     => 128,
	'stock'       => 10,
	'description' => __('Suave, tierno y perfecto para abrazar. Acompaña a tu pequeño en todas sus aventuras y momentos especiales.', 'kulimbos'),
);

$product_categories = array(
	array(
		'name' => __('Juguetes', 'kulimbos'),
		'url'  => home_url('/categoria/juguetes/'),
	),
	array(
		'name' => __('Peluches', 'kulimbos'),
		'url'  => home_url('/categoria/peluches/'),
	),
);

if (is_singular('producto')) {
	$product_id    = get_queried_object_id();
	$product_price = get_post_meta($product_id, 'kulimbos_product_price', true);
	$product_stock = function_exists('kulimbos_get_product_stock') ? kulimbos_get_product_stock($product_id) : (int) get_post_meta($product_id, 'kulimbos_product_stock', true);
	$review_summary = function_exists('kulimbos_get_product_review_summary')
		? kulimbos_get_product_review_summary($product_id)
		: array(
			'rating'  => 0,
			'reviews' => 0,
		);
	$product_image = get_the_post_thumbnail_url($product_id, 'kulimbos-product');
	$product_desc  = has_excerpt($product_id)
		? get_the_excerpt($product_id)
		: wp_trim_words(wp_strip_all_tags(get_post_field('post_content', $product_id)), 32);

	$main_product = array(
		'image'       => '',
		'image_url'   => $product_image ?: '',
		'name'        => get_the_title($product_id),
		'alt'         => get_the_title($product_id),
		'price'       => $product_price ? '$' . number_format((int) preg_replace('/[^\d]/', '', $product_price), 0, ',', '.') : __('Consultar precio', 'kulimbos'),
		'rating'      => (float) $review_summary['rating'],
		'reviews'     => (int) $review_summary['reviews'],
		'stock'       => $product_stock,
		'description' => $product_desc ?: __('Producto disponible en Kulimbos.', 'kulimbos'),
	);

	$product_categories = array();
	$assigned_terms = get_the_terms($product_id, 'categoria_producto');

	if (! empty($assigned_terms) && ! is_wp_error($assigned_terms)) {
		$category_map = array();

		foreach ($assigned_terms as $assigned_term) {
			foreach (array_reverse(get_ancestors($assigned_term->term_id, 'categoria_producto')) as $ancestor_id) {
				$ancestor = get_term($ancestor_id, 'categoria_producto');

				if ($ancestor instanceof WP_Term) {
					$category_map[$ancestor->term_id] = $ancestor;
				}
			}

			$category_map[$assigned_term->term_id] = $assigned_term;
		}

		foreach ($category_map as $category_term) {
			$category_link = get_term_link($category_term);

			if (! is_wp_error($category_link)) {
				$product_categories[] = array(
					'name' => $category_term->name,
					'url'  => $category_link,
				);
			}
		}
	}
}

$feature_taxonomies = array(
	'edad_producto'     => array(
		'icon'  => 'smile',
		'title' => __('Edad recomendada', 'kulimbos'),
		'color' => 'coral',
	),
	'tamano_producto'   => array(
		'icon'  => 'tag',
		'title' => __('Tamaño', 'kulimbos'),
		'color' => 'mint',
	),
	'color_producto'    => array(
		'icon'  => 'sparkles',
		'title' => __('Color', 'kulimbos'),
		'color' => 'purple',
	),
	'material_producto' => array(
		'icon'  => 'package',
		'title' => __('Material', 'kulimbos'),
		'color' => 'sage',
	),
);

$features = array();

if (is_singular('producto')) {
	$product_id = get_queried_object_id();

	foreach ($feature_taxonomies as $taxonomy => $feature_data) {
		$terms = get_the_terms($product_id, $taxonomy);

		if (empty($terms) || is_wp_error($terms)) {
			continue;
		}

		$term_names = wp_list_pluck($terms, 'name');

		$features[] = array(
			'icon'  => $feature_data['icon'],
			'title' => $feature_data['title'],
			'text'  => implode(', ', array_map('sanitize_text_field', $term_names)),
			'color' => $feature_data['color'],
		);
	}
} else {
	$features = array(
		array(
			'icon'  => 'smile',
			'title' => __('Edad recomendada', 'kulimbos'),
			'text'  => __('0 a 1 años', 'kulimbos'),
			'color' => 'coral',
		),
		array(
			'icon'  => 'tag',
			'title' => __('Tamaño', 'kulimbos'),
			'text'  => __('Mediano (20 a 35 cm)', 'kulimbos'),
			'color' => 'mint',
		),
		array(
			'icon'  => 'sparkles',
			'title' => __('Color', 'kulimbos'),
			'text'  => __('Café', 'kulimbos'),
			'color' => 'purple',
		),
		array(
			'icon'  => 'package',
			'title' => __('Material', 'kulimbos'),
			'text'  => __('Felpa suave', 'kulimbos'),
			'color' => 'sage',
		),
	);
}

$default_thumbs = array(
	array(
		'image' => 'oso-peluche.png',
		'label' => __('Vista principal del oso de peluche', 'kulimbos'),
	),
	array(
		'image' => 'torre-apilable.png',
		'label' => __('Imagen secundaria de prueba del producto', 'kulimbos'),
	),
	array(
		'image' => 'body-basico.png',
		'label' => __('Imagen alternativa de prueba del producto', 'kulimbos'),
	),
	array(
		'image' => 'set-aseo.png',
		'label' => __('Detalle de prueba del producto', 'kulimbos'),
	),
	array(
		'image' => 'oso-peluche.png',
		'label' => __('Imagen principal de prueba del producto', 'kulimbos'),
	),
);

$thumbs = $default_thumbs;

if (is_singular('producto')) {
	$product_id  = get_queried_object_id();
	$gallery_ids = function_exists('kulimbos_sanitize_product_gallery_ids')
		? kulimbos_sanitize_product_gallery_ids(get_post_meta($product_id, 'kulimbos_product_gallery_ids', true))
		: array();

	$thumbs = array();

	if (! empty($main_product['image_url'])) {
		$thumbs[] = array(
			'image_url' => $main_product['image_url'],
			'label'     => $main_product['alt'],
		);
	}

	foreach ($gallery_ids as $gallery_attachment_id) {
		$gallery_image_url = wp_get_attachment_image_url($gallery_attachment_id, 'kulimbos-product');

		if (! $gallery_image_url) {
			continue;
		}

		$gallery_image_alt = get_post_meta($gallery_attachment_id, '_wp_attachment_image_alt', true);

		$thumbs[] = array(
			'image_url' => $gallery_image_url,
			'label'     => $gallery_image_alt ? $gallery_image_alt : $main_product['name'],
		);
	}

	if (empty($main_product['image_url']) && ! empty($thumbs[0]['image_url'])) {
		$main_product['image_url'] = $thumbs[0]['image_url'];
		$main_product['alt']       = $thumbs[0]['label'];
	}
}

$related_products = array(
	array(
		'image'   => 'oso-peluche.png',
		'alt'     => __('Conejo de peluche para bebé', 'kulimbos'),
		'name'    => __('Conejo de peluche', 'kulimbos'),
		'rating'  => 5,
		'reviews' => 96,
		'price'   => '$69.900',
		'url'     => home_url('/productos/conejo-de-peluche/'),
	),
	array(
		'image'   => '',
		'alt'     => __('Espacio reservado para elefante de peluche', 'kulimbos'),
		'name'    => __('Elefante de peluche', 'kulimbos'),
		'rating'  => 4.5,
		'reviews' => 74,
		'price'   => '$79.900',
		'url'     => home_url('/productos/elefante-de-peluche/'),
	),
	array(
		'image'   => '',
		'alt'     => __('Espacio reservado para león de peluche', 'kulimbos'),
		'name'    => __('León de peluche', 'kulimbos'),
		'rating'  => 4.5,
		'reviews' => 81,
		'price'   => '$74.900',
		'url'     => home_url('/productos/leon-de-peluche/'),
	),
	array(
		'image'   => '',
		'alt'     => __('Espacio reservado para panda de peluche', 'kulimbos'),
		'name'    => __('Panda de peluche', 'kulimbos'),
		'rating'  => 4.5,
		'reviews' => 63,
		'price'   => '$79.900',
		'url'     => home_url('/productos/panda-de-peluche/'),
	),
	array(
		'image'   => '',
		'alt'     => __('Espacio reservado para jirafa de peluche', 'kulimbos'),
		'name'    => __('Jirafa de peluche', 'kulimbos'),
		'rating'  => 5,
		'reviews' => 55,
		'price'   => '$69.900',
		'url'     => home_url('/productos/jirafa-de-peluche/'),
	),
);

if (is_singular('producto') && function_exists('kulimbos_get_primary_product_category')) {
	$related_products = array();
	$product_id = get_queried_object_id();
	$term       = kulimbos_get_primary_product_category($product_id);

	if ($term instanceof WP_Term) {
		$related_query = new WP_Query(
			array(
				'post_type'      => 'producto',
				'posts_per_page' => 5,
				'post__not_in'   => array($product_id),
				'tax_query'      => array(
					array(
						'taxonomy' => 'categoria_producto',
						'field'    => 'term_id',
						'terms'    => array($term->term_id),
					),
				),
			)
		);

		if ($related_query->have_posts()) {
			$related_products = array();

			while ($related_query->have_posts()) {
				$related_query->the_post();
				$related_id    = get_the_ID();
				$related_price = get_post_meta($related_id, 'kulimbos_product_price', true);
				$related_review_summary = function_exists('kulimbos_get_product_review_summary')
					? kulimbos_get_product_review_summary($related_id)
					: array(
						'rating'  => 0,
						'reviews' => 0,
					);

				$related_products[] = array(
					'image'     => '',
					'image_url' => get_the_post_thumbnail_url($related_id, 'kulimbos-product') ?: '',
					'alt'       => get_the_title(),
					'name'      => get_the_title(),
					'rating'    => (float) $related_review_summary['rating'],
					'reviews'   => (int) $related_review_summary['reviews'],
					'price'     => $related_price ? '$' . number_format((int) preg_replace('/[^\d]/', '', $related_price), 0, ',', '.') : __('Consultar precio', 'kulimbos'),
					'url'       => get_permalink(),
				);
			}

			wp_reset_postdata();
		}
	}
}

$reviews = array(
	array(
		'name' => __('María G.', 'kulimbos'),
		'text' => __('Es hermosísimo y súper suave. A mi hijo le encanta dormir con su osito todas las noches. Excelente calidad.', 'kulimbos'),
		'date' => __('Hace 2 días', 'kulimbos'),
	),
	array(
		'name' => __('Juan P.', 'kulimbos'),
		'text' => __('El tamaño es perfecto y los materiales se sienten de muy buena calidad. Llegó muy rápido y bien empacado.', 'kulimbos'),
		'date' => __('Hace 1 semana', 'kulimbos'),
	),
	array(
		'name' => __('Carolina M.', 'kulimbos'),
		'text' => __('Lo compré para regalar y fue un éxito. Viene en una bolsa muy linda, ideal para regalo.', 'kulimbos'),
		'date' => __('Hace 2 semanas', 'kulimbos'),
	),
);

$benefits = array(
	array(
		'icon'  => 'heart',
		'title' => __('Hecho con amor', 'kulimbos'),
		'text'  => __('para cada etapa de su crecimiento', 'kulimbos'),
	),
	array(
		'icon'  => 'smile',
		'title' => __('Productos de calidad', 'kulimbos'),
		'text'  => __('para los momentos que importan', 'kulimbos'),
	),
	array(
		'icon'  => 'star',
		'title' => __('Para bebés y niños', 'kulimbos'),
		'text'  => __('desde 0 hasta 6 años', 'kulimbos'),
	),
	array(
		'icon'  => 'truck',
		'title' => __('Envíos a todo Colombia', 'kulimbos'),
		'text'  => __('Rápidos y confiables', 'kulimbos'),
	),
);

$fallback_image_filename = 'oso-peluche.png';
$fallback_image_path     = $theme_dir . '/assets/img/products/' . $fallback_image_filename;
$fallback_image_url      = $theme_uri . '/assets/img/products/' . $fallback_image_filename;
$main_image_path         = ! empty($main_product['image']) ? $theme_dir . '/assets/img/products/' . sanitize_file_name($main_product['image']) : $fallback_image_path;
$main_image_url          = ! empty($main_product['image_url']) ? $main_product['image_url'] : (! empty($main_product['image']) ? $theme_uri . '/assets/img/products/' . sanitize_file_name($main_product['image']) : $fallback_image_url);
$product_stock   = max(0, (int) $main_product['stock']);
$quantity_min    = $product_stock > 0 ? 1 : 0;
$quantity_value  = $product_stock > 0 ? 1 : 0;
$product_url     = get_permalink() ?: home_url('/productos/oso-de-peluche/');
$whatsapp_message = sprintf(
	__(
		"Hola, estoy interesado en este producto:\n\nProducto: %1\$s\nPrecio: %2\$s COP\nURL: %3\$s\nCantidad: %4\$s",
		'kulimbos'
	),
	$main_product['name'],
	$main_product['price'],
	$product_url,
	$quantity_value
);
$whatsapp_url = 'https://wa.me/?text=' . rawurlencode($whatsapp_message);
?>

<section class="product-detail-page" aria-labelledby="product-detail-title">
	<div class="container">
		<nav class="product-breadcrumb" aria-label="<?php esc_attr_e('Miga de pan', 'kulimbos'); ?>">
			<ol class="product-breadcrumb__list" role="list">
				<li>
					<a href="<?php echo esc_url(home_url('/')); ?>">
						<?php kulimbos_the_icon('home', '', 24); ?>
						<span><?php esc_html_e('Inicio', 'kulimbos'); ?></span>
					</a>
				</li>
				<?php if (is_singular('producto') && function_exists('kulimbos_get_primary_product_category')) : ?>
					<?php $product_term = kulimbos_get_primary_product_category(get_queried_object_id()); ?>
					<?php if ($product_term instanceof WP_Term) : ?>
						<?php foreach (array_reverse(get_ancestors($product_term->term_id, 'categoria_producto')) as $ancestor_id) : ?>
							<?php $ancestor = get_term($ancestor_id, 'categoria_producto'); ?>
							<?php if ($ancestor instanceof WP_Term) : ?>
								<li><a href="<?php echo esc_url(get_term_link($ancestor)); ?>"><?php echo esc_html($ancestor->name); ?></a></li>
							<?php endif; ?>
						<?php endforeach; ?>
						<li><a href="<?php echo esc_url(get_term_link($product_term)); ?>"><?php echo esc_html($product_term->name); ?></a></li>
					<?php endif; ?>
				<?php else : ?>
					<li><a href="<?php echo esc_url(home_url('/categoria/juguetes/')); ?>"><?php esc_html_e('Juguetes', 'kulimbos'); ?></a></li>
					<li><a href="<?php echo esc_url(home_url('/categoria/peluches/')); ?>"><?php esc_html_e('Peluches', 'kulimbos'); ?></a></li>
				<?php endif; ?>
				<li aria-current="page"><?php echo esc_html($main_product['name']); ?></li>
			</ol>
		</nav>

		<div class="product-detail">
			<div class="product-gallery" data-product-gallery>
				<div class="product-gallery__main">
					<span class="product-gallery__badge"><?php esc_html_e('¡Nuevo!', 'kulimbos'); ?></span>
					<?php if (($main_image_path && file_exists($main_image_path)) || ! empty($main_product['image_url'])) : ?>
						<img
							class="product-gallery__image"
							data-product-gallery-image
							src="<?php echo esc_url($main_image_url); ?>"
							alt="<?php echo esc_attr($main_product['alt']); ?>"
							width="400"
							height="400"
							fetchpriority="high"
							decoding="async">
					<?php endif; ?>
					<button class="product-gallery__zoom" type="button" aria-label="<?php esc_attr_e('Ampliar imagen del producto', 'kulimbos'); ?>">
						<?php kulimbos_the_icon('search', '', 22); ?>
					</button>
				</div>

				<div class="product-gallery__thumb-row" aria-label="<?php esc_attr_e('Miniaturas del producto', 'kulimbos'); ?>">
					<button class="product-gallery__nav" type="button" data-product-gallery-prev aria-label="<?php esc_attr_e('Imagen anterior', 'kulimbos'); ?>">
						<?php kulimbos_the_icon('chevron-left', '', 18); ?>
					</button>
					<ul class="product-gallery__thumbs" role="list">
						<?php foreach ($thumbs as $index => $thumb) : ?>
							<?php
							$thumb_path = ! empty($thumb['image']) ? $theme_dir . '/assets/img/products/' . sanitize_file_name($thumb['image']) : '';
							$thumb_url  = ! empty($thumb['image_url'])
								? $thumb['image_url']
								: (! empty($thumb['image']) ? $theme_uri . '/assets/img/products/' . sanitize_file_name($thumb['image']) : '');
							?>
							<?php if (empty($thumb_url)) : ?>
								<?php continue; ?>
							<?php endif; ?>
							<li>
								<button
									class="product-gallery__thumb <?php echo 0 === $index ? 'is-active' : ''; ?>"
									type="button"
									data-product-gallery-thumb
									data-gallery-index="<?php echo absint($index); ?>"
									data-gallery-image="<?php echo esc_url($thumb_url); ?>"
									data-gallery-alt="<?php echo esc_attr($thumb['label']); ?>"
									aria-label="<?php echo esc_attr($thumb['label']); ?>"
									aria-current="<?php echo 0 === $index ? 'true' : 'false'; ?>">
									<?php if (! empty($thumb['image_url']) || ($thumb_path && file_exists($thumb_path))) : ?>
										<img src="<?php echo esc_url($thumb_url); ?>" alt="" width="72" height="72" loading="lazy" decoding="async">
									<?php endif; ?>
								</button>
							</li>
						<?php endforeach; ?>
					</ul>
					<button class="product-gallery__nav" type="button" data-product-gallery-next aria-label="<?php esc_attr_e('Imagen siguiente', 'kulimbos'); ?>">
						<?php kulimbos_the_icon('chevron-right', '', 18); ?>
					</button>
				</div>
			</div>

			<div class="product-summary">
				<h1 class="product-summary__title" id="product-detail-title"><?php echo esc_html($main_product['name']); ?></h1>

				<?php if (! empty($product_categories)) : ?>
					<nav class="product-summary__categories" aria-label="<?php esc_attr_e('Categorías del producto', 'kulimbos'); ?>">
						<?php foreach ($product_categories as $category) : ?>
							<a href="<?php echo esc_url($category['url']); ?>"><?php echo esc_html($category['name']); ?></a>
						<?php endforeach; ?>
					</nav>
				<?php endif; ?>

				<div class="product-summary__rating" aria-label="<?php echo esc_attr(sprintf(__('Calificación: %s de 5', 'kulimbos'), $main_product['rating'])); ?>">
					<?php for ($i = 0; $i < 5; $i++) : ?>
						<span class="star <?php echo esc_attr($i < floor($main_product['rating']) ? 'star--full' : 'star--empty'); ?>" aria-hidden="true"><?php kulimbos_the_icon('star', '', 24); ?></span>
					<?php endfor; ?>
					<span class="product-summary__reviews">(<?php echo absint($main_product['reviews']); ?>)</span>
				</div>

				<div class="product-summary__price-row">
					<p class="product-summary__price"><?php echo esc_html($main_product['price']); ?></p>
					<span class="product-summary__stock">
						<?php echo (int) $main_product['stock'] > 0 ? esc_html__('En stock', 'kulimbos') : esc_html__('Agotado', 'kulimbos'); ?>
					</span>
				</div>

				<p class="product-summary__description"><?php echo esc_html($main_product['description']); ?></p>

				<?php if (! empty($features)) : ?>
					<ul class="product-summary__features" role="list">
						<?php foreach ($features as $feature) : ?>
							<li class="product-feature product-feature--<?php echo esc_attr($feature['color']); ?>">
								<span class="product-feature__icon" aria-hidden="true">
									<?php kulimbos_the_icon($feature['icon'], '', 38); ?>
								</span>
								<strong><?php echo esc_html($feature['title']); ?></strong>
								<span><?php echo esc_html($feature['text']); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<div class="product-actions" aria-label="<?php esc_attr_e('Compra del producto', 'kulimbos'); ?>">
					<div class="product-quantity">
						<span>
							<?php esc_html_e('Cantidad:', 'kulimbos'); ?>
							<small><?php echo esc_html(sprintf(_n('%s disponible', '%s disponibles', $product_stock, 'kulimbos'), number_format_i18n($product_stock))); ?></small>
						</span>
						<div class="product-quantity__control" data-product-quantity>
							<button type="button" data-product-quantity-decrease aria-label="<?php esc_attr_e('Disminuir cantidad', 'kulimbos'); ?>" <?php disabled(0 === $product_stock); ?>>−</button>
							<input
								type="number"
								value="<?php echo esc_attr($quantity_value); ?>"
								min="<?php echo esc_attr($quantity_min); ?>"
								max="<?php echo esc_attr($product_stock); ?>"
								inputmode="numeric"
								data-product-quantity-input
								aria-label="<?php esc_attr_e('Cantidad del producto', 'kulimbos'); ?>"
								<?php disabled(0 === $product_stock); ?>>
							<button type="button" data-product-quantity-increase aria-label="<?php esc_attr_e('Aumentar cantidad', 'kulimbos'); ?>" <?php disabled(0 === $product_stock); ?>>+</button>
						</div>
					</div>
					<button class="product-actions__cart" type="button" <?php disabled(0 === $product_stock); ?>>
						<?php kulimbos_the_icon('shopping-cart', '', 24); ?>
						<span><?php esc_html_e('Agregar al carrito', 'kulimbos'); ?></span>
					</button>
					<a
						class="product-actions__whatsapp"
						href="<?php echo esc_url($whatsapp_url); ?>"
						target="_blank"
						rel="noopener noreferrer"
						data-product-whatsapp
						data-whatsapp-message="<?php echo esc_attr($whatsapp_message); ?>">
						<?php kulimbos_the_icon('message-circle', '', 24); ?>
						<span><?php esc_html_e('WhatsApp', 'kulimbos'); ?></span>
					</a>
				</div>
			</div>

			<div class="product-shipping">
				<?php kulimbos_the_icon('truck', '', 34); ?>
				<div>
					<strong><?php esc_html_e('Envíos rápidos a todo Colombia', 'kulimbos'); ?></strong>
					<span><?php esc_html_e('Recíbelo entre 1 y 3 días hábiles', 'kulimbos'); ?></span>
				</div>
				<a href="<?php echo esc_url(home_url('/envios/')); ?>"><?php esc_html_e('Ver métodos de envío', 'kulimbos'); ?></a>
			</div>
		</div>

		<ul class="product-trust-bar" role="list" aria-label="<?php esc_attr_e('Beneficios de compra', 'kulimbos'); ?>">
			<li>
				<?php kulimbos_the_icon('shield-check', '', 42); ?>
				<strong><?php esc_html_e('Compra segura', 'kulimbos'); ?></strong>
				<span><?php esc_html_e('Protegemos tus datos', 'kulimbos'); ?></span>
			</li>
			<li>
				<?php kulimbos_the_icon('sparkles', '', 42); ?>
				<strong><?php esc_html_e('Devoluciones fáciles', 'kulimbos'); ?></strong>
				<span><?php esc_html_e('Tienes 30 días para devolver', 'kulimbos'); ?></span>
			</li>
			<li>
				<?php kulimbos_the_icon('package', '', 42); ?>
				<strong><?php esc_html_e('Empaque especial', 'kulimbos'); ?></strong>
				<span><?php esc_html_e('Ideal para regalar', 'kulimbos'); ?></span>
			</li>
			<li>
				<?php kulimbos_the_icon('smile', '', 42); ?>
				<strong><?php esc_html_e('¿Necesitas ayuda?', 'kulimbos'); ?></strong>
				<span><?php esc_html_e('Escríbenos por WhatsApp', 'kulimbos'); ?></span>
			</li>
		</ul>
	</div>
</section>

<?php if (! empty($related_products)) : ?>
<section class="product-related" aria-labelledby="product-related-title">
	<div class="container">
		<h2 class="product-section-title" id="product-related-title"><?php esc_html_e('Productos relacionados', 'kulimbos'); ?></h2>
		<ul class="product-related__grid" role="list">
			<?php foreach ($related_products as $product) : ?>
				<?php
				$product_image_path = ! empty($product['image']) ? $theme_dir . '/assets/img/products/' . sanitize_file_name($product['image']) : '';
				$product_image_url  = ! empty($product['image_url']) ? $product['image_url'] : (! empty($product['image']) ? $theme_uri . '/assets/img/products/' . sanitize_file_name($product['image']) : '');
				?>
				<li class="product-card">
					<div class="product-card__image-wrap">
						<?php if (($product_image_path && file_exists($product_image_path)) || ! empty($product['image_url'])) : ?>
							<img class="product-card__image" src="<?php echo esc_url($product_image_url); ?>" alt="<?php echo esc_attr($product['alt']); ?>" width="400" height="400" loading="lazy" decoding="async">
						<?php else : ?>
							<div class="product-card__image product-card__image--placeholder" role="img" aria-label="<?php echo esc_attr($product['alt']); ?>">
								<span><?php esc_html_e('Imagen del producto', 'kulimbos'); ?></span>
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
									<?php kulimbos_the_icon('star', '', 25); ?>
								</span>
							<?php endfor; ?>
							<span class="product-card__reviews">(<?php echo absint($product['reviews']); ?>)</span>
						</div>
						<div class="product-card__footer">
							<span class="product-card__price"><?php echo esc_html($product['price']); ?></span>
							<button class="product-card__add-to-cart" type="button" aria-label="<?php echo esc_attr(sprintf(__('Agregar %s al carrito', 'kulimbos'), $product['name'])); ?>">
								<?php kulimbos_the_icon('shopping-cart', '', 25); ?>
							</button>
						</div>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
<?php endif; ?>

<section class="product-reviews" aria-labelledby="product-reviews-title">
	<div class="container">
		<div class="product-reviews__header">
			<h2 class="product-section-title" id="product-reviews-title"><?php esc_html_e('Opiniones de nuestros clientes', 'kulimbos'); ?></h2>
			<div class="product-reviews__summary-stars" aria-label="<?php esc_attr_e('Promedio 4.9 de 5', 'kulimbos'); ?>">
				<?php for ($i = 0; $i < 5; $i++) : ?>
					<span class="star star--full" aria-hidden="true"><?php kulimbos_the_icon('star', '', 22); ?></span>
				<?php endfor; ?>
				<span><?php esc_html_e('4.9 (128 reseñas)', 'kulimbos'); ?></span>
			</div>
			<a class="product-reviews__write" href="<?php echo esc_url(home_url('/opiniones/')); ?>">
				<?php kulimbos_the_icon('tag', '', 18); ?>
				<span><?php esc_html_e('Escribir una opinión', 'kulimbos'); ?></span>
			</a>
		</div>

		<div class="product-reviews__grid">
			<aside class="product-score" aria-label="<?php esc_attr_e('Resumen de calificaciones', 'kulimbos'); ?>">
				<strong>4.9</strong>
				<div aria-hidden="true">
					<?php for ($i = 0; $i < 5; $i++) : ?>
						<span class="star star--full"><?php kulimbos_the_icon('star', '', 22); ?></span>
					<?php endfor; ?>
				</div>
				<p><?php esc_html_e('Basado en 128 reseñas', 'kulimbos'); ?></p>
				<ul role="list">
					<?php foreach (array(5 => 109, 4 => 15, 3 => 3, 2 => 1, 1 => 0) as $stars => $amount) : ?>
						<li>
							<span><?php echo absint($stars); ?></span>
							<meter min="0" max="109" value="<?php echo absint($amount); ?>"><?php echo absint($amount); ?></meter>
							<span><?php echo absint($amount); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			</aside>

			<?php foreach ($reviews as $review) : ?>
				<article class="review-card">
					<header>
						<div class="review-card__avatar" aria-hidden="true"><?php echo esc_html(substr($review['name'], 0, 1)); ?></div>
						<div>
							<h3><?php echo esc_html($review['name']); ?></h3>
							<span><?php esc_html_e('Compra verificada', 'kulimbos'); ?></span>
						</div>
					</header>
					<div class="review-card__stars" aria-label="<?php esc_attr_e('Calificación: 5 de 5', 'kulimbos'); ?>">
						<?php for ($i = 0; $i < 5; $i++) : ?>
							<span class="star star--full" aria-hidden="true"><?php kulimbos_the_icon('star', '', 18); ?></span>
						<?php endfor; ?>
					</div>
					<p><?php echo esc_html($review['text']); ?></p>
					<footer><?php echo esc_html($review['date']); ?></footer>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="product-benefits-strip" aria-label="<?php esc_attr_e('Beneficios de Kulimbos', 'kulimbos'); ?>">
	<div class="container">
		<ul class="product-benefits-strip__list" role="list">
			<?php foreach ($benefits as $benefit) : ?>
				<li>
					<?php kulimbos_the_icon($benefit['icon'], '', 46); ?>
					<div>
						<strong><?php echo esc_html($benefit['title']); ?></strong>
						<span><?php echo esc_html($benefit['text']); ?></span>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
