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
 * Estrategia de CSS por entorno:
 *   WP_DEBUG true  → assets/css/main.css          (expandido, legible, filemtime)
 *   WP_DEBUG false → assets/production/mincss/main.min.css  (minificado, versión estática)
 *
 * Ambos archivos los genera Gulp. Nunca editar manualmente.
 */
function kulimbos_enqueue_assets(): void {

	$is_debug = defined( 'WP_DEBUG' ) && WP_DEBUG;

	// Selecciona la hoja de estilos según el entorno.
	$css_relative = $is_debug
		? '/assets/css/main.css'
		: '/assets/production/mincss/main.min.css';

	$css_path = get_template_directory() . $css_relative;
	$css_uri  = get_template_directory_uri() . $css_relative;
	$dist_js  = get_template_directory() . '/assets/production/minjs/main.min.js';

	// CSS conserva la estrategia por entorno; JS usa filemtime para invalidar caché al compilar.
	$css_version = file_exists( $css_path )
		? ( $is_debug ? filemtime( $css_path ) : KULIMBOS_VERSION )
		: KULIMBOS_VERSION;

	$js_version = file_exists( $dist_js )
		? filemtime( $dist_js )
		: KULIMBOS_VERSION;

	// Estilo principal compilado por Gulp.
	wp_enqueue_style(
		'kulimbos-main',
		$css_uri,
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

/**
 * Inyecta hints <link rel="preload"> para las fuentes críticas.
 *
 * Se precargan Baloo2-Bold (h1–h6 usan font-weight 700) y Nunito-Regular
 * (cuerpo de texto). El resto de pesos se cargan bajo demanda por el browser.
 * Priority 1 para que aparezca antes del <link> del CSS en el <head>.
 */
function kulimbos_preload_fonts(): void {
	$fonts_uri = get_template_directory_uri() . '/assets/fonts/';

	$critical_fonts = array(
		'Baloo2-Bold.woff2',   // h1–h6 con font-weight: 700
		'Nunito-Regular.woff2', // cuerpo de texto base
	);

	foreach ( $critical_fonts as $filename ) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin="anonymous">' . "\n",
			esc_url( $fonts_uri . $filename )
		);
	}
}
add_action( 'wp_head', 'kulimbos_preload_fonts', 1 );
