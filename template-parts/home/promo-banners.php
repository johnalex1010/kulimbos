<?php

/**
 * template-parts/home/promo-banners.php
 *
 * Banners promocionales de la homepage.
 *
 * Imágenes reemplazables:
 * - assets/img/banners/ofertas.png
 * - assets/img/banners/novedades.png
 *
 * @package Kulimbos
 */

defined('ABSPATH') || exit;

$banners = array(
	array(
		'image'    => 'ofertas',
		'theme'    => 'offers',
		'title'    => __('Ofertas especiales', 'kulimbos'),
		'desc'     => __('Descuentos increíbles en tus productos favoritos', 'kulimbos'),
		'cta_text' => __('¡Ver ofertas!', 'kulimbos'),
		'cta_url'  => home_url('/categorias/'),
	),
	array(
		'image'    => 'novedades',
		'theme'    => 'new',
		'title'    => __('Novedades', 'kulimbos'),
		'desc'     => __('Descubre los productos más nuevos para tu pequeño', 'kulimbos'),
		'cta_text' => __('¡Ver novedades!', 'kulimbos'),
		'cta_url'  => home_url('/categorias/'),
	),
);
?>

<section class="promo-banners" aria-label="<?php esc_attr_e('Promociones destacadas', 'kulimbos'); ?>">
	<div class="promo-banners__inner container">
		<div class="promo-banners__grid">
			<?php foreach ($banners as $banner) : ?>
				<?php
				$image_filename = sanitize_file_name($banner['image']) . '.png';
				$image_path     = get_template_directory() . '/assets/img/promo/' . $image_filename;
				$image_url      = get_template_directory_uri() . '/assets/img/promo/' . $image_filename;
				?>
				<article class="promo-banner promo-banner--<?php echo esc_attr($banner['theme']); ?>">
					<div class="promo-banner__content">
						<h2 class="promo-banner__title"><?php echo esc_html($banner['title']); ?></h2>
						<p class="promo-banner__desc"><?php echo esc_html($banner['desc']); ?></p>
						<a class="promo-banner__cta" href="<?php echo esc_url($banner['cta_url']); ?>">
							<span><?php echo esc_html($banner['cta_text']); ?></span>
							<?php kulimbos_the_icon('arrow-right', '', 25); ?>
						</a>
					</div>

					<div class="promo-banner__media" aria-hidden="true">
						<?php if (file_exists($image_path)) : ?>
							<img
								src="<?php echo esc_url($image_url); ?>"
								alt=""
								width="260"
								height="190"
								loading="lazy"
								decoding="async">
						<?php else : ?>
							<span class="promo-banner__placeholder"></span>
						<?php endif; ?>
					</div>

					<span class="promo-banner__decor promo-banner__decor--one" aria-hidden="true"></span>
					<span class="promo-banner__decor promo-banner__decor--two" aria-hidden="true"></span>
					<span class="promo-banner__decor promo-banner__decor--three" aria-hidden="true"></span>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>