<?php
/**
 * inc/cart.php — Ruta ligera del carrito local.
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;

/**
 * Determina si la solicitud actual corresponde a /carrito/.
 */
function kulimbos_is_cart_request(): bool {
	$request_path = isset( $_SERVER['REQUEST_URI'] )
		? trim( (string) wp_parse_url( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ), PHP_URL_PATH ), '/' )
		: '';

	$site_path = trim( (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );
	$cart_path = trim( $site_path . '/carrito', '/' );

	return $request_path === $cart_path;
}

/**
 * Carga el template de carrito aunque no exista una página en el admin.
 *
 * @param string $template Template resuelto por WordPress.
 * @return string
 */
function kulimbos_cart_template_include( string $template ): string {
	if ( ! kulimbos_is_cart_request() ) {
		return $template;
	}

	global $wp_query;

	if ( $wp_query instanceof WP_Query ) {
		$wp_query->is_404 = false;
	}

	status_header( 200 );

	$cart_template = get_template_directory() . '/page-carrito.php';

	return file_exists( $cart_template ) ? $cart_template : $template;
}
add_filter( 'template_include', 'kulimbos_cart_template_include' );
