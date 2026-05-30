<?php
/**
 * inc/assets.php — Carga de CSS y JS mediante la API de WordPress.
 *
 * Los archivos fuente viven en assets/scss/ y assets/js/.
 * Gulp los compila y minifica a assets/production/mincss/ y minjs/.
 * Solo se encolan los archivos compilados.
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;

/**
 * Encola los estilos y scripts del tema.
 *
 * Se usa filemtime() como versión en entornos de desarrollo para
 * invalidar la caché automáticamente al compilar con Gulp.
 * En producción se reemplaza con KULIMBOS_VERSION.
 */
function kulimbos_enqueue_assets(): void {

	$dist_css = get_template_directory() . '/assets/production/mincss/main.min.css';
	$dist_js  = get_template_directory() . '/assets/production/minjs/main.min.js';

	// Versión dinámica en desarrollo, estática en producción.
	$css_version = file_exists( $dist_css )
		? ( defined( 'WP_DEBUG' ) && WP_DEBUG ? filemtime( $dist_css ) : KULIMBOS_VERSION )
		: KULIMBOS_VERSION;

	$js_version = file_exists( $dist_js )
		? ( defined( 'WP_DEBUG' ) && WP_DEBUG ? filemtime( $dist_js ) : KULIMBOS_VERSION )
		: KULIMBOS_VERSION;

	// Estilo principal compilado por Gulp.
	wp_enqueue_style(
		'kulimbos-main',
		get_template_directory_uri() . '/assets/production/mincss/main.min.css',
		array(),
		$css_version
	);

	// Script principal compilado por Gulp.
	// Se carga en el footer (true) para no bloquear el render.
	wp_enqueue_script(
		'kulimbos-main',
		get_template_directory_uri() . '/assets/production/minjs/main.min.js',
		array(),
		$js_version,
		true
	);

	// Pasa datos de PHP al JS para evitar hardcodear URLs en el frontend.
	wp_localize_script(
		'kulimbos-main',
		'kulimbosData',
		array(
			'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
			'siteUrl'   => esc_url( home_url( '/' ) ),
			'themeUrl'  => esc_url( get_template_directory_uri() ),
			'nonce'     => wp_create_nonce( 'kulimbos_nonce' ),
			'isLoggedIn' => is_user_logged_in(),
		)
	);

	// Hoja de comentarios solo donde se necesita.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'kulimbos_enqueue_assets' );

/**
 * Añade atributos de precarga al CSS principal para mejorar LCP.
 * Solo aplica al estilo del tema (kulimbos-main).
 *
 * @param string $tag    Etiqueta <link> generada.
 * @param string $handle Handle del estilo.
 * @return string
 */
function kulimbos_add_preload_to_main_style( string $tag, string $handle ): string {
	if ( 'kulimbos-main' !== $handle ) {
		return $tag;
	}

	return str_replace( "rel='stylesheet'", "rel='preload' as='style' onload=\"this.onload=null;this.rel='stylesheet'\"", $tag );
}
add_filter( 'style_loader_tag', 'kulimbos_add_preload_to_main_style', 10, 2 );
