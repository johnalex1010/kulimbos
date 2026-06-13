<?php
/**
 * Template automático para la página Favoritos.
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main-content" class="site-main site-main--favorites" role="main">
	<section class="favorites-page" aria-labelledby="favorites-page-title" data-favorites-page>
		<div class="container">
			<header class="favorites-page__header">
				<div>
					<p class="favorites-page__eyebrow"><?php esc_html_e( 'Tus listas', 'kulimbos' ); ?></p>
					<h1 id="favorites-page-title"><?php esc_html_e( 'Lista de compras', 'kulimbos' ); ?></h1>
				</div>
				<a class="favorites-page__continue" href="<?php echo esc_url( home_url( '/categorias/' ) ); ?>">
					<?php esc_html_e( 'Agregar productos', 'kulimbos' ); ?>
				</a>
			</header>

			<div class="favorites-page__layout">
				<aside class="favorites-sidebar" aria-label="<?php esc_attr_e( 'Listas de favoritos', 'kulimbos' ); ?>">
					<strong><?php esc_html_e( 'Lista de compras', 'kulimbos' ); ?></strong>
					<span><?php esc_html_e( 'Lista predeterminada', 'kulimbos' ); ?></span>
					<small><?php esc_html_e( 'Privada', 'kulimbos' ); ?></small>
				</aside>

				<div class="favorites-panel">
					<div class="favorites-panel__top">
						<div>
							<h2><?php esc_html_e( 'Lista de compras', 'kulimbos' ); ?> <span><?php esc_html_e( 'Privada', 'kulimbos' ); ?></span></h2>
							<p><span data-favorites-summary-count>0</span> <?php esc_html_e( 'productos guardados', 'kulimbos' ); ?></p>
						</div>
						<button type="button" data-favorites-clear><?php esc_html_e( 'Vaciar lista', 'kulimbos' ); ?></button>
					</div>

					<div class="favorites-panel__tools">
						<label>
							<span class="screen-reader-text"><?php esc_html_e( 'Buscar en favoritos', 'kulimbos' ); ?></span>
							<input type="search" placeholder="<?php esc_attr_e( 'Buscar en esta lista', 'kulimbos' ); ?>" data-favorites-search>
						</label>
						<label>
							<span class="screen-reader-text"><?php esc_html_e( 'Ordenar favoritos', 'kulimbos' ); ?></span>
							<select data-favorites-sort>
								<option value="recent"><?php esc_html_e( 'Agregados más recientemente', 'kulimbos' ); ?></option>
								<option value="name"><?php esc_html_e( 'Nombre A-Z', 'kulimbos' ); ?></option>
								<option value="price-desc"><?php esc_html_e( 'Mayor precio', 'kulimbos' ); ?></option>
								<option value="price-asc"><?php esc_html_e( 'Menor precio', 'kulimbos' ); ?></option>
							</select>
						</label>
					</div>

					<ul class="favorites-list" role="list" data-favorites-items></ul>

					<div class="favorites-empty" data-favorites-empty>
						<h2><?php esc_html_e( 'Aún no tienes favoritos', 'kulimbos' ); ?></h2>
						<p><?php esc_html_e( 'Usa el corazón de los productos para guardar aquí tu lista de compras.', 'kulimbos' ); ?></p>
						<a href="<?php echo esc_url( home_url( '/categorias/' ) ); ?>">
							<?php esc_html_e( 'Ver categorías', 'kulimbos' ); ?>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>
