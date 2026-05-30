<?php
/**
 * template-parts/components/card.php
 *
 * Componente de tarjeta de contenido reutilizable.
 * Acepta datos del post global o datos personalizados vía $args.
 *
 * Uso con post global (dentro del loop):
 *   kulimbos_component( 'card' );
 *
 * Uso con datos personalizados:
 *   kulimbos_component( 'card', array(
 *       'title'   => 'Título del card',
 *       'excerpt' => 'Descripción breve del contenido.',
 *       'url'     => '/ruta-del-elemento',
 *       'image'   => 'https://...url-de-imagen...',
 *       'image_alt' => 'Descripción de la imagen',
 *       'tag'     => 'Categoría',
 *   ) );
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;

// Detecta si se pasaron datos externos o se usan los del post global.
$use_post_data = empty( $args );

if ( $use_post_data ) {
	$title     = get_the_title();
	$url       = get_permalink();
	$excerpt   = kulimbos_get_excerpt( 20 );
	$image_url = kulimbos_get_thumbnail_url( 'post-thumbnail' );
	$image_alt = esc_attr( get_the_title() );
	$tag       = '';
	$categories = get_the_category();
	if ( ! empty( $categories ) ) {
		$tag = esc_html( $categories[0]->name );
	}
} else {
	$title     = isset( $args['title'] ) ? $args['title'] : '';
	$url       = isset( $args['url'] ) ? $args['url'] : '#';
	$excerpt   = isset( $args['excerpt'] ) ? $args['excerpt'] : '';
	$image_url = isset( $args['image'] ) ? $args['image'] : '';
	$image_alt = isset( $args['image_alt'] ) ? $args['image_alt'] : $title;
	$tag       = isset( $args['tag'] ) ? $args['tag'] : '';
}

if ( empty( $title ) ) {
	return;
}
?>

<article class="card" itemscope itemtype="https://schema.org/Article">

	<?php if ( $image_url ) : ?>
		<a class="card__thumbnail-link" href="<?php echo esc_url( $url ); ?>" tabindex="-1" aria-hidden="true">
			<div class="card__thumbnail">
				<img
					src="<?php echo esc_url( $image_url ); ?>"
					alt="<?php echo esc_attr( $image_alt ); ?>"
					class="card__image"
					loading="lazy"
					decoding="async"
					itemprop="image"
				>
			</div>
		</a>
	<?php endif; ?>

	<div class="card__body">

		<?php if ( $tag ) : ?>
			<span class="card__tag"><?php echo esc_html( $tag ); ?></span>
		<?php endif; ?>

		<h3 class="card__title" itemprop="headline">
			<a href="<?php echo esc_url( $url ); ?>" itemprop="url">
				<?php echo esc_html( $title ); ?>
			</a>
		</h3>

		<?php if ( $excerpt ) : ?>
			<p class="card__excerpt" itemprop="description">
				<?php echo esc_html( $excerpt ); ?>
			</p>
		<?php endif; ?>

		<div class="card__footer">
			<?php
			kulimbos_component(
				'button',
				array(
					'text'  => __( 'Leer más', 'kulimbos' ),
					'url'   => $url,
					'class' => 'btn--text',
					'aria'  => sprintf(
						/* translators: %s: título del artículo */
						__( 'Leer más sobre %s', 'kulimbos' ),
						$title
					),
				)
			);
			?>
		</div>

	</div>

</article>
