<?php

/**
 * template-parts/home/featured-products.php
 *
 * Sección "Productos destacados" — grid de 4 product cards.
 *
 * Datos: hardcoded como placeholder. Cuando WooCommerce esté activo,
 * reemplazar con WP_Query sobre 'product' post type con meta 'featured'.
 *
 * Tamaño de imagen de producto:
 *   400 × 400 px (cuadrado 1:1). Formato png + fallback JPG.
 *   Carpeta: /assets/img/products/
 *   Nombre:  product-[slug].png
 *
 * @package Kulimbos
 */

defined('ABSPATH') || exit;

$theme_uri = get_template_directory_uri();

$products = array(
	array(
		'image'    => $theme_uri . '/assets/img/products/oso-peluche.png',
		'alt'      => __('Oso de peluche suave para bebé', 'kulimbos'),
		'name'     => __('Oso de peluche', 'kulimbos'),
		'rating'   => 4.5,
		'reviews'  => 128,
		'price'    => '$79.900',
		'url'      => home_url('/productos/oso-de-peluche/'),
	),
	array(
		'image'    => $theme_uri . '/assets/img/products/torre-apilable.png',
		'alt'      => __('Torre apilable de colores para bebé', 'kulimbos'),
		'name'     => __('Torre apilable', 'kulimbos'),
		'rating'   => 4.5,
		'reviews'  => 96,
		'price'    => '$49.900',
		'url'      => home_url('/productos/torre-apilable/'),
	),
	array(
		'image'    => $theme_uri . '/assets/img/products/body-basico.png',
		'alt'      => __('Body básico para bebé en algodón', 'kulimbos'),
		'name'     => __('Body básico', 'kulimbos'),
		'rating'   => 4.5,
		'reviews'  => 72,
		'price'    => '$24.900',
		'url'      => home_url('/productos/body-basico/'),
	),
	array(
		'image'    => $theme_uri . '/assets/img/products/set-aseo.png',
		'alt'      => __('Set de aseo suave para bebé', 'kulimbos'),
		'name'     => __('Set de aseo', 'kulimbos'),
		'rating'   => 4.5,
		'reviews'  => 51,
		'price'    => '$59.900',
		'url'      => home_url('/productos/set-de-aseo/'),
	),
);
?>

<section class="home-section featured-products" aria-labelledby="featured-products-title">
	<div class="container">

		<div class="home-section__header">
			<h2 class="home-section__title" id="featured-products-title">
				<?php esc_html_e('Productos destacados', 'kulimbos'); ?>
			</h2>
			<a class="home-section__link" href="<?php echo esc_url(home_url('/productos/')); ?>">
				<?php esc_html_e('Ver todos', 'kulimbos'); ?>
				<?php kulimbos_the_icon('chevron-right', '', 16); ?>
			</a>
		</div>

		<ul class="product-grid" role="list">
			<?php foreach ($products as $product) : ?>
				<li class="product-card">

					<div class="product-card__image-wrap">
						<!-- Reemplazar src con el asset real -->
						<img
							class="product-card__image"
							src="<?php echo esc_url($product['image']); ?>"
							alt="<?php echo esc_attr($product['alt']); ?>"
							width="400"
							height="400"
							loading="lazy">
						<button
							class="product-card__wishlist"
							aria-label="<?php echo esc_attr(sprintf(__('Agregar %s a favoritos', 'kulimbos'), $product['name'])); ?>">
							<?php kulimbos_the_icon('heart', '', 25); ?>
						</button>
					</div>

					<div class="product-card__body">
						<h3 class="product-card__name">
							<a href="<?php echo esc_url($product['url']); ?>">
								<?php echo esc_html($product['name']); ?>
							</a>
						</h3>

						<div class="product-card__rating" aria-label="<?php echo esc_attr(sprintf(__('Calificación: %s de 5', 'kulimbos'), $product['rating'])); ?>">
							<?php
							$full_stars  = (int) floor($product['rating']);
							$half_star   = ($product['rating'] - $full_stars) >= 0.5;
							for ($i = 0; $i < 5; $i++) :
								$cls = $i < $full_stars ? 'star--full' : ($i === $full_stars && $half_star ? 'star--half' : 'star--empty');
							?>
								<span class="star <?php echo esc_attr($cls); ?>" aria-hidden="true">
									<?php kulimbos_the_icon('star', '', 24); ?>
								</span>
							<?php endfor; ?>
							<span class="product-card__reviews">(<?php echo absint($product['reviews']); ?>)</span>
						</div>

						<div class="product-card__footer">
							<span class="product-card__price"><?php echo esc_html($product['price']); ?></span>
							<button
								class="product-card__add-to-cart"
								aria-label="<?php echo esc_attr(sprintf(__('Agregar %s al carrito', 'kulimbos'), $product['name'])); ?>">
								<?php kulimbos_the_icon('shopping-cart', '', 25); ?>
							</button>
						</div>
					</div>

				</li>
			<?php endforeach; ?>
		</ul>

	</div>
</section>