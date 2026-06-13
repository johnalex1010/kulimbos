<?php
/**
 * template-parts/layout/header-actions.php
 *
 * Acciones del header: Favoritos y Carrito.
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;

$cart_url = function_exists( 'wc_get_cart_url' )
	? esc_url( wc_get_cart_url() )
	: esc_url( home_url( '/carrito/' ) );

$cart_count = function_exists( 'WC' )
	? absint( WC()->cart->get_cart_contents_count() )
	: 0;
?>

<div class="header-actions" role="navigation" aria-label="<?php esc_attr_e( 'Acciones de compra', 'kulimbos' ); ?>">

	<a class="header-actions__item" href="<?php echo esc_url( home_url( '/favoritos/' ) ); ?>" aria-label="<?php esc_attr_e( 'Favoritos', 'kulimbos' ); ?>">
		<?php kulimbos_the_icon( 'heart', 'header-actions__icon', 22 ); ?>
		<span class="header-actions__label"><?php esc_html_e( 'Favoritos', 'kulimbos' ); ?></span>
		<span class="header-actions__badge header-actions__badge--favorites" id="favorites-count" aria-live="polite" data-count="0">0</span>
	</a>

	<a class="header-actions__item" href="<?php echo $cart_url; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- ya escapado. ?>" aria-label="<?php esc_attr_e( 'Carrito de compras', 'kulimbos' ); ?>" data-cart-link>
		<?php kulimbos_the_icon( 'shopping-cart', 'header-actions__icon', 22 ); ?>
		<span class="header-actions__label"><?php esc_html_e( 'Carrito', 'kulimbos' ); ?></span>
		<span class="header-actions__badge header-actions__badge--cart" id="cart-count" aria-live="polite" data-count="<?php echo absint( $cart_count ); ?>"><?php echo absint( $cart_count ); ?></span>
	</a>

</div>
