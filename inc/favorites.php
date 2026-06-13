<?php
/**
 * inc/favorites.php — Ruta ligera de favoritos locales.
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;

/**
 * Determina si la solicitud actual corresponde a /favoritos/.
 */
function kulimbos_is_favorites_request(): bool {
	$request_path = isset( $_SERVER['REQUEST_URI'] )
		? trim( (string) wp_parse_url( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ), PHP_URL_PATH ), '/' )
		: '';

	$site_path = trim( (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );
	$favorites_path = trim( $site_path . '/favoritos', '/' );

	return $request_path === $favorites_path;
}

/**
 * Carga el template de favoritos aunque no exista una página en el admin.
 *
 * @param string $template Template resuelto por WordPress.
 * @return string
 */
function kulimbos_favorites_template_include( string $template ): string {
	if ( ! kulimbos_is_favorites_request() ) {
		return $template;
	}

	global $wp_query;

	if ( $wp_query instanceof WP_Query ) {
		$wp_query->is_404 = false;
	}

	status_header( 200 );

	$favorites_template = get_template_directory() . '/page-favoritos.php';

	return file_exists( $favorites_template ) ? $favorites_template : $template;
}
add_filter( 'template_include', 'kulimbos_favorites_template_include' );
