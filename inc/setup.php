<?php
/**
 * inc/setup.php — Soportes y configuración base del tema.
 *
 * Se registra en after_setup_theme para que esté disponible
 * antes de que WordPress necesite los datos del tema.
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registra los soportes del tema y carga traducciones.
 */
function kulimbos_theme_setup(): void {

	// Permite que WordPress gestione el <title> automáticamente (SEO-friendly).
	add_theme_support( 'title-tag' );

	// Habilita imágenes destacadas en posts y páginas.
	add_theme_support( 'post-thumbnails' );

	// Tamaño estándar de thumbnail usado en cards y listados.
	set_post_thumbnail_size( 800, 500, true );

	// Tamaño adicional para heroes y cabeceras.
	add_image_size( 'kulimbos-hero', 1920, 700, true );

	// Tamaño cuadrado para avatares y thumbnails compactos.
	add_image_size( 'kulimbos-square', 400, 400, true );

	// ── Tamaños para la homepage e-commerce ──────────────────────────────────

	// Hero slide: 1440×600 (ratio 12:5). Primer slide no lleva lazy-load (LCP).
	add_image_size( 'kulimbos-hero-slide', 1440, 600, true );

	// Product card: cuadrado 1:1. Se usa en el grid de productos.
	add_image_size( 'kulimbos-product', 400, 400, true );

	// Banner promocional: ratio ~2.27:1.
	add_image_size( 'kulimbos-banner', 680, 300, true );

	// Avatar de testimonio: cuadrado pequeño.
	add_image_size( 'kulimbos-avatar', 80, 80, true );

	// Salida HTML5 semántica para formularios, galerías y comentarios.
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Logo personalizable desde el Personalizador de WordPress.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 200,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	// Permite a editores cambiar el color de fondo desde el Personalizador.
	add_theme_support( 'custom-background' );

	// Habilita la etiqueta <html> con atributo correcto de idioma.
	add_theme_support( 'automatic-feed-links' );

	// Soporte para bloques de Gutenberg sin estilos propios de WordPress.
	add_theme_support( 'wp-block-styles' );

	// Alineaciones extendidas (wide/full) en el editor.
	add_theme_support( 'align-wide' );

	// Carga las traducciones del tema desde /languages/.
	load_theme_textdomain( 'kulimbos', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'kulimbos_theme_setup' );

/**
 * Define el ancho máximo de contenido para embeds y medios.
 * Se declara en $content_width siguiendo el estándar de WordPress.
 */
function kulimbos_content_width(): void {
	$GLOBALS['content_width'] = apply_filters( 'kulimbos_content_width', 1200 );
}
add_action( 'after_setup_theme', 'kulimbos_content_width', 0 );
