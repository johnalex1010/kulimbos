<?php
/**
 * Template automático para la página Carrito.
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main-content" class="site-main site-main--cart" role="main">
	<section class="cart-page" aria-labelledby="cart-page-title" data-cart-page>
		<div class="container">
			<header class="cart-page__header">
				<div>
					<p class="cart-page__eyebrow"><?php esc_html_e( 'Carrito de compras', 'kulimbos' ); ?></p>
					<h1 id="cart-page-title"><?php esc_html_e( 'Revisa tus productos', 'kulimbos' ); ?></h1>
				</div>
				<a class="cart-page__continue" href="<?php echo esc_url( home_url( '/categorias/' ) ); ?>">
					<?php esc_html_e( 'Seguir comprando', 'kulimbos' ); ?>
				</a>
			</header>

			<div class="cart-page__layout">
				<aside class="cart-summary" aria-labelledby="cart-summary-title">
					<h2 id="cart-summary-title"><?php esc_html_e( 'Resumen de compra', 'kulimbos' ); ?></h2>
					<dl class="cart-summary__rows">
						<div>
							<dt><?php esc_html_e( 'Productos', 'kulimbos' ); ?> <span data-cart-summary-count>(0)</span></dt>
							<dd data-cart-summary-subtotal>$0</dd>
						</div>
						<div>
							<dt><?php esc_html_e( 'Envío', 'kulimbos' ); ?></dt>
							<dd data-cart-summary-shipping>$0</dd>
						</div>
						<div class="cart-summary__total">
							<dt><?php esc_html_e( 'Total', 'kulimbos' ); ?></dt>
							<dd data-cart-summary-total>$0</dd>
						</div>
					</dl>
					<p class="cart-summary__note"><?php esc_html_e( 'El valor de envío es fijo y se suma al total de productos.', 'kulimbos' ); ?></p>
					<a class="cart-summary__checkout" href="#" target="_blank" rel="noopener noreferrer" aria-disabled="true" data-cart-checkout>
						<?php esc_html_e( 'Continuar compra', 'kulimbos' ); ?>
					</a>
				</aside>

				<div class="cart-products" aria-live="polite">
					<div class="cart-products__toolbar">
						<h2><?php esc_html_e( 'Productos agregados', 'kulimbos' ); ?></h2>
						<button type="button" data-cart-clear><?php esc_html_e( 'Vaciar carrito', 'kulimbos' ); ?></button>
					</div>
					<ul class="cart-products__list" role="list" data-cart-items></ul>
					<div class="cart-products__empty" data-cart-empty>
						<h2><?php esc_html_e( 'Tu carrito está vacío', 'kulimbos' ); ?></h2>
						<p><?php esc_html_e( 'Agrega productos desde el catálogo para verlos aquí.', 'kulimbos' ); ?></p>
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
