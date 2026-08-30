<?php

/**
 * template-parts/home/featured-products.php
 *
 * Sección "Productos destacados" con los últimos productos publicados.
 *
 * @package Kulimbos
 */

defined('ABSPATH') || exit;

$products_query = new WP_Query(
	array(
		'post_type'           => 'producto',
		'post_status'         => 'publish',
		'posts_per_page'      => 4,
		'orderby'             => 'date',
		'order'               => 'DESC',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);

$products = array();

if ($products_query->have_posts()) {
	while ($products_query->have_posts()) {
		$products_query->the_post();

		$product_id             = get_the_ID();
		$product_name           = get_the_title();
		$product_price          = function_exists('kulimbos_get_product_price_data')
			? kulimbos_get_product_price_data($product_id)
			: array(
				'effective' => (int) preg_replace('/[^\d]/', '', (string) get_post_meta($product_id, 'kulimbos_product_price', true)),
				'label'     => get_post_meta($product_id, 'kulimbos_product_price', true) ? '$' . number_format((int) preg_replace('/[^\d]/', '', (string) get_post_meta($product_id, 'kulimbos_product_price', true)), 0, ',', '.') : __('Consultar precio', 'kulimbos'),
				'has_price' => '' !== get_post_meta($product_id, 'kulimbos_product_price', true),
			);
		$product_has_price      = (bool) $product_price['has_price'];
		$product_stock          = function_exists('kulimbos_get_product_stock') ? kulimbos_get_product_stock($product_id) : (int) get_post_meta($product_id, 'kulimbos_product_stock', true);
		$product_review_summary = function_exists('kulimbos_get_product_review_summary')
			? kulimbos_get_product_review_summary($product_id)
			: array(
				'rating'  => 0,
				'reviews' => 0,
			);

		$products[] = array(
			'id'        => $product_id,
			'image_url' => get_the_post_thumbnail_url($product_id, 'kulimbos-product') ?: '',
			'alt'       => $product_name,
			'name'      => $product_name,
			'rating'    => (float) $product_review_summary['rating'],
			'reviews'   => (int) $product_review_summary['reviews'],
			'price'     => (int) $product_price['effective'],
			'price_label' => $product_price['label'],
			'has_price' => $product_has_price,
			'stock'     => $product_stock,
			'url'       => get_permalink(),
		);
	}

	wp_reset_postdata();
}

?>

<section class="home-section featured-products" aria-labelledby="featured-products-title">
	<div class="container">

		<div class="home-section__header">
			<h2 class="home-section__title" id="featured-products-title">
				<?php esc_html_e('Productos destacados', 'kulimbos'); ?>
			</h2>
			<a class="home-section__link" href="<?php echo esc_url(get_post_type_archive_link('producto') ?: home_url('/productos/')); ?>">
				<?php esc_html_e('Ver todos', 'kulimbos'); ?>
				<?php kulimbos_the_icon('chevron-right', '', 16); ?>
			</a>
		</div>

		<?php if (empty($products)) : ?>
			<p class="featured-products__empty"><?php esc_html_e('Aún no hay productos publicados. Cuando cargues productos en WordPress aparecerán aquí automáticamente.', 'kulimbos'); ?></p>
		<?php else : ?>
			<ul class="product-grid" role="list">
				<?php foreach ($products as $product) : ?>
				<li class="product-card">

					<div class="product-card__image-wrap">
						<?php if (! empty($product['image_url'])) : ?>
							<img
								class="product-card__image"
								src="<?php echo esc_url($product['image_url']); ?>"
								alt="<?php echo esc_attr($product['alt']); ?>"
								width="400"
								height="400"
								loading="lazy"
								decoding="async">
						<?php else : ?>
							<div class="product-card__image plushies-card__placeholder" role="img" aria-label="<?php echo esc_attr($product['alt']); ?>">
								<span><?php echo esc_html($product['name']); ?></span>
							</div>
						<?php endif; ?>
						<button
							class="product-card__wishlist"
							type="button"
							data-favorite-toggle
							data-favorite-product-id="<?php echo esc_attr((string) $product['id']); ?>"
							data-favorite-product-name="<?php echo esc_attr($product['name']); ?>"
							data-favorite-product-price="<?php echo esc_attr((string) absint($product['price'])); ?>"
							data-favorite-product-url="<?php echo esc_url($product['url']); ?>"
							data-favorite-product-image="<?php echo esc_url($product['image_url']); ?>"
							data-favorite-product-stock="<?php echo esc_attr((string) absint($product['stock'])); ?>"
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
							$full_stars = (int) floor($product['rating']);
							$half_star  = ($product['rating'] - $full_stars) >= 0.5;
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
							<span class="product-card__price">
								<?php
								echo $product['has_price']
									? esc_html($product['price_label'])
									: esc_html__('Consultar precio', 'kulimbos');
								?>
							</span>
							<button
								class="product-card__add-to-cart"
								type="button"
								data-cart-add
								data-cart-product-id="<?php echo esc_attr((string) $product['id']); ?>"
								data-cart-product-name="<?php echo esc_attr($product['name']); ?>"
								data-cart-product-price="<?php echo esc_attr((string) absint($product['price'])); ?>"
								data-cart-product-url="<?php echo esc_url($product['url']); ?>"
								data-cart-product-image="<?php echo esc_url($product['image_url']); ?>"
								data-cart-product-stock="<?php echo esc_attr((string) absint($product['stock'])); ?>"
								aria-label="<?php echo esc_attr(sprintf(__('Agregar %s al carrito', 'kulimbos'), $product['name'])); ?>">
								<?php kulimbos_the_icon('shopping-cart', '', 25); ?>
							</button>
						</div>
					</div>

				</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

	</div>
</section>
