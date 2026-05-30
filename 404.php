<?php
/**
 * 404.php — Template para páginas no encontradas.
 *
 * @package Kulimbos
 */

get_header();
?>

<main id="main-content" class="site-main site-main--404" role="main">
	<div class="container">

		<section class="error-404">
			<header class="error-404__header">
				<h1 class="error-404__title">
					<?php esc_html_e( 'Página no encontrada', 'kulimbos' ); ?>
				</h1>
				<p class="error-404__message">
					<?php esc_html_e( 'La página que buscas no existe o fue movida. Prueba usando el buscador o navega desde el inicio.', 'kulimbos' ); ?>
				</p>
			</header>

			<div class="error-404__actions">
				<?php
				kulimbos_component(
					'button',
					array(
						'text'  => __( 'Volver al inicio', 'kulimbos' ),
						'url'   => home_url( '/' ),
						'class' => 'btn--primary',
					)
				);
				?>

				<div class="error-404__search">
					<?php get_search_form(); ?>
				</div>
			</div>
		</section>

	</div>
</main>

<?php get_footer(); ?>
