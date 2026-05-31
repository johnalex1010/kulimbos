<?php

/**
 * template-parts/home/categories-grid.php
 *
 * Sección "Explora por categorías" de la homepage.
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;

$categories = array(
	array(
		'image' => 'diaper',
		'label' => __( 'Pañales', 'kulimbos' ),
		'url'   => home_url( '/categoria/panales/' ),
		'color' => 'teal',
	),
	array(
		'image' => 'baby-shirt',
		'label' => __( 'Ropa', 'kulimbos' ),
		'url'   => home_url( '/categoria/ropa/' ),
		'color' => 'orange',
	),
	array(
		'image' => 'teddy-bear',
		'label' => __( 'Juguetes', 'kulimbos' ),
		'url'   => home_url( '/categoria/juguetes/' ),
		'color' => 'warm',
	),
	array(
		'image' => 'cleaning',
		'label' => __( 'Aseo', 'kulimbos' ),
		'url'   => home_url( '/categoria/aseo/' ),
		'color' => 'mint',
	),
	array(
		'image' => 'baby-bottle',
		'label' => __( 'Alimentación', 'kulimbos' ),
		'url'   => home_url( '/categoria/alimentacion/' ),
		'color' => 'coral',
	),
	array(
		'image' => 'stroller',
		'label' => __( 'Paseo', 'kulimbos' ),
		'url'   => home_url( '/categoria/paseo/' ),
		'color' => 'sage',
	),
	array(
		'image' => 'crib',
		'label' => __( 'Dormitorio', 'kulimbos' ),
		'url'   => home_url( '/categoria/dormitorio/' ),
		'color' => 'rose',
	),
	array(
		'image' => 'baby-lock',
		'label' => __( 'Seguridad', 'kulimbos' ),
		'url'   => home_url( '/categoria/seguridad/' ),
		'color' => 'purple',
	),
);
?>

<section class="categories-section" aria-labelledby="categories-title">
	<div class="categories-section__inner container">
		<div class="categories-section__header">
			<h2 class="categories-section__title" id="categories-title">
				<?php esc_html_e( 'Explora por categorías', 'kulimbos' ); ?>
			</h2>

			<a class="categories-section__link" href="<?php echo esc_url( home_url( '/categorias/' ) ); ?>">
				<span><?php esc_html_e( 'Ver todas', 'kulimbos' ); ?></span>
				<?php kulimbos_the_icon( 'chevron-right', '', 18 ); ?>
			</a>
		</div>

		<ul class="categories-grid" role="list">
			<?php foreach ( $categories as $category ) : ?>
				<?php
				$image_filename = sanitize_file_name( $category['image'] ) . '.png';
				$image_path     = get_template_directory() . '/assets/img/categories/' . $image_filename;
				$image_url      = get_template_directory_uri() . '/assets/img/categories/' . $image_filename;
				?>
				<li class="categories-grid__item">
					<a
						class="category-chip category-chip--<?php echo esc_attr( $category['color'] ); ?>"
						href="<?php echo esc_url( $category['url'] ); ?>"
						aria-label="<?php echo esc_attr( sprintf( __( 'Ver categoría %s', 'kulimbos' ), $category['label'] ) ); ?>"
					>
						<span class="category-chip__icon" aria-hidden="true">
							<?php if ( file_exists( $image_path ) ) : ?>
								<img
									src="<?php echo esc_url( $image_url ); ?>"
									alt=""
									width="58"
									height="58"
									loading="lazy"
									decoding="async"
								>
							<?php endif; ?>
						</span>
						<span class="category-chip__label"><?php echo esc_html( $category['label'] ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
