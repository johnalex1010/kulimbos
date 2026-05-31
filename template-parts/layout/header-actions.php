<?php
/**
 * template-parts/layout/header-actions.php
 *
 * Acciones del header: Mi cuenta, Favoritos y Carrito.
 * Los contadores de favoritos y carrito se actualizan por JS.
 * WooCommerce puede reemplazar estos enlaces cuando esté activo.
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;

$account_url    = function_exists( 'wc_get_account_endpoint_url' )
	? esc_url( wc_get_account_endpoint_url( 'dashboard' ) )
	: esc_url( home_url( '/mi-cuenta/' ) );

$cart_url       = function_exists( 'wc_get_cart_url' )
	? esc_url( wc_get_cart_url() )
	: esc_url( home_url( '/carrito/' ) );

$cart_count     = function_exists( 'WC' )
	? absint( WC()->cart->get_cart_contents_count() )
	: 0;
?>

<div class="header-actions" role="navigation" aria-label="<?php esc_attr_e( 'Acciones de cuenta', 'kulimbos' ); ?>">

	<a class="header-actions__item" href="<?php echo $account_url; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — ya escapado. ?>">
		<?php kulimbos_the_icon( 'user', 'header-actions__icon', 22 ); ?>
		<span class="header-actions__label"><?php esc_html_e( 'Mi cuenta', 'kulimbos' ); ?></span>
	</a>

	<a class="header-actions__item" href="<?php echo esc_url( home_url( '/favoritos/' ) ); ?>" aria-label="<?php esc_attr_e( 'Favoritos', 'kulimbos' ); ?>">
		<?php kulimbos_the_icon( 'heart', 'header-actions__icon', 22 ); ?>
		<span class="header-actions__label"><?php esc_html_e( 'Favoritos', 'kulimbos' ); ?></span>
		<span class="header-actions__badge header-actions__badge--favorites" id="favorites-count" aria-live="polite">0</span>
	</a>

	<a class="header-actions__item" href="<?php echo $cart_url; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — ya escapado. ?>" aria-label="<?php esc_attr_e( 'Carrito de compras', 'kulimbos' ); ?>">
		<?php kulimbos_the_icon( 'shopping-cart', 'header-actions__icon', 22 ); ?>
		<span class="header-actions__label"><?php esc_html_e( 'Carrito', 'kulimbos' ); ?></span>
		<span class="header-actions__badge header-actions__badge--cart" id="cart-count" aria-live="polite"><?php echo absint( $cart_count ); ?></span>
	</a>

</div>
