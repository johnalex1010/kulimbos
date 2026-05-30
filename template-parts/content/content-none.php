<?php
/**
 * template-parts/content/content-none.php
 *
 * Estado vacío: se muestra cuando no hay resultados en el loop.
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="no-results">
	<header class="no-results__header">
		<h1 class="no-results__title">
			<?php esc_html_e( 'No se encontró contenido', 'kulimbos' ); ?>
		</h1>
	</header>

	<div class="no-results__content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			<p>
				<?php
				printf(
					wp_kses(
						/* translators: %s: URL para crear una nueva entrada */
						__( '¿Listo para publicar? <a href="%s">Crea tu primera entrada</a>.', 'kulimbos' ),
						array( 'a' => array( 'href' => array() ) )
					),
					esc_url( admin_url( 'post-new.php' ) )
				);
				?>
			</p>
		<?php elseif ( is_search() ) : ?>
			<p><?php esc_html_e( 'No encontramos resultados para tu búsqueda. Prueba con otras palabras clave.', 'kulimbos' ); ?></p>
			<?php get_search_form(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Parece que no hay contenido disponible en este momento.', 'kulimbos' ); ?></p>
		<?php endif; ?>
	</div>
</section>
