<?php
/**
 * template-parts/components/hero.php
 *
 * Componente de sección hero de ancho completo.
 *
 * Uso:
 *   kulimbos_component( 'hero', array(
 *       'title'    => 'Título principal',
 *       'subtitle' => 'Descripción de apoyo.',
 *       'cta_text' => 'Comenzar ahora',
 *       'cta_url'  => '/contacto',
 *       'image'    => 'https://...url-imagen-de-fondo...',
 *       'image_alt' => 'Descripción de la imagen de fondo',
 *       'overlay'  => true,
 *   ) );
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;

$title     = isset( $args['title'] ) ? $args['title'] : get_bloginfo( 'name' );
$subtitle  = isset( $args['subtitle'] ) ? $args['subtitle'] : get_bloginfo( 'description' );
$cta_text  = isset( $args['cta_text'] ) ? $args['cta_text'] : '';
$cta_url   = isset( $args['cta_url'] ) ? $args['cta_url'] : '';
$image     = isset( $args['image'] ) ? $args['image'] : '';
$image_alt = isset( $args['image_alt'] ) ? $args['image_alt'] : esc_attr( $title );
$overlay   = isset( $args['overlay'] ) ? (bool) $args['overlay'] : true;

// Construye el atributo de estilo inline solo si hay imagen.
// Se construye como string seguro; no proviene de input de usuario.
$hero_style = '';
if ( $image ) {
	$hero_style = sprintf(
		' style="background-image: url(\'%s\')"',
		esc_url( $image )
	);
}

$hero_classes = 'hero';
if ( $overlay ) {
	$hero_classes .= ' hero--overlay';
}
if ( $image ) {
	$hero_classes .= ' hero--has-bg';
}
?>

<section class="<?php echo esc_attr( $hero_classes ); ?>"<?php echo $hero_style; // phpcs:ignore — construido con esc_url. ?> role="banner">

	<?php if ( $image ) : ?>
		<img
			class="hero__bg-image"
			src="<?php echo esc_url( $image ); ?>"
			alt="<?php echo esc_attr( $image_alt ); ?>"
			loading="eager"
			decoding="async"
			aria-hidden="true"
		>
	<?php endif; ?>

	<div class="hero__inner container">

		<div class="hero__content">

			<?php if ( $title ) : ?>
				<h1 class="hero__title"><?php echo esc_html( $title ); ?></h1>
			<?php endif; ?>

			<?php if ( $subtitle ) : ?>
				<p class="hero__subtitle"><?php echo esc_html( $subtitle ); ?></p>
			<?php endif; ?>

			<?php if ( $cta_text && $cta_url ) : ?>
				<div class="hero__cta">
					<?php
					kulimbos_component(
						'button',
						array(
							'text'  => $cta_text,
							'url'   => $cta_url,
							'class' => 'btn--primary btn--lg',
						)
					);
					?>
				</div>
			<?php endif; ?>

		</div>

	</div>

</section>
