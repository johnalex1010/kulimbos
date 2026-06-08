<?php
/**
 * inc/helpers.php — Funciones reutilizables del tema.
 *
 * Solo funciones puras de presentación y utilidad.
 * Sin consultas complejas ni lógica de negocio.
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;

/**
 * Devuelve el extracto del post con longitud configurable.
 *
 * @param int $length Número de palabras del extracto.
 * @return string Extracto escapado.
 */
function kulimbos_get_excerpt( int $length = 30 ): string {
	$excerpt = has_excerpt()
		? get_the_excerpt()
		: wp_trim_words( get_the_content(), $length, '&hellip;' );

	return esc_html( $excerpt );
}

/**
 * Muestra la URL de la imagen destacada o una imagen de placeholder.
 *
 * @param string $size Tamaño de imagen registrado en WordPress.
 * @return string URL de la imagen, escapada.
 */
function kulimbos_get_thumbnail_url( string $size = 'thumbnail' ): string {
	if ( has_post_thumbnail() ) {
		$url = get_the_post_thumbnail_url( null, $size );
		return esc_url( $url ?: '' );
	}

	return esc_url( get_template_directory_uri() . '/assets/img/placeholder.jpg' );
}

/**
 * Imprime la metainformación de fecha y autor de un post.
 * Incluye microdata compatible con SEO.
 */
function kulimbos_post_meta(): void {
	$time_string = sprintf(
		'<time class="post-meta__date" datetime="%1$s" itemprop="datePublished">%2$s</time>',
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() )
	);

	$author_link = sprintf(
		'<a class="post-meta__author" href="%1$s" rel="author" itemprop="author" itemscope itemtype="https://schema.org/Person"><span itemprop="name">%2$s</span></a>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() )
	);

	printf(
		'<p class="post-meta">%1$s &middot; %2$s</p>',
		$time_string, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — ya escapado arriba.
		$author_link  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — ya escapado arriba.
	);
}

/**
 * Imprime la navegación entre entradas anteriores y siguientes.
 *
 * @param array $args Argumentos para get_the_post_navigation().
 */
function kulimbos_post_navigation( array $args = array() ): void {
	$defaults = array(
		'prev_text'          => sprintf(
			'<span class="nav-subtitle">%s</span><span class="nav-title">%%title</span>',
			esc_html__( 'Entrada anterior', 'kulimbos' )
		),
		'next_text'          => sprintf(
			'<span class="nav-subtitle">%s</span><span class="nav-title">%%title</span>',
			esc_html__( 'Entrada siguiente', 'kulimbos' )
		),
		'class'              => 'post-navigation',
		'aria_label'         => __( 'Navegación entre entradas', 'kulimbos' ),
		'in_same_term'       => false,
	);

	the_post_navigation( wp_parse_args( $args, $defaults ) );
}

/**
 * Imprime la paginación de archivos y listados de posts.
 *
 * @param array $args Argumentos para the_posts_pagination().
 */
function kulimbos_posts_pagination( array $args = array() ): void {
	$defaults = array(
		'mid_size'           => 2,
		'prev_text'          => esc_html__( '&laquo; Anterior', 'kulimbos' ),
		'next_text'          => esc_html__( 'Siguiente &raquo;', 'kulimbos' ),
		'screen_reader_text' => esc_html__( 'Navegación de entradas', 'kulimbos' ),
		'aria_label'         => __( 'Entradas', 'kulimbos' ),
		'class'              => 'pagination',
	);

	the_posts_pagination( wp_parse_args( $args, $defaults ) );
}

/**
 * Renderiza un componente de template-part y le pasa argumentos.
 *
 * Wrapper semántico sobre get_template_part() que documenta
 * el contrato de datos que recibe cada componente.
 *
 * @param string $component Ruta relativa dentro de template-parts/components/.
 * @param array  $args      Datos que recibe el componente.
 */
function kulimbos_component( string $component, array $args = array() ): void {
	get_template_part( 'template-parts/components/' . $component, null, $args );
}

/**
 * Devuelve el SVG inline de un ícono Lucide por nombre.
 *
 * Los paths SVG corresponden a Lucide v0.383 (stroke-based, 24×24).
 * Se usa aria-hidden="true" porque los íconos son siempre decorativos;
 * el texto alternativo debe estar en el elemento padre.
 *
 * @param string $name  Nombre del ícono (ej. 'search', 'heart').
 * @param string $class Clases CSS adicionales para el <svg>.
 * @param int    $size  Tamaño en px (width y height).
 * @return string SVG escapado listo para echo con wp_kses().
 */
function kulimbos_icon( string $name, string $class = '', int $size = 24 ): string {
	$paths = array(
		'search'        => '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>',
		'home'          => '<path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2v-5H9v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>',
		'user'          => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
		'heart'         => '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>',
		'shopping-cart' => '<circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>',
		'shopping-bag'  => '<path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/>',
		'menu'          => '<line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>',
		'x'             => '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>',
		'star'          => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>',
		'chevron-right' => '<polyline points="9 18 15 12 9 6"/>',
		'chevron-left'  => '<polyline points="15 18 9 12 15 6"/>',
		'chevron-down'  => '<polyline points="6 9 12 15 18 9"/>',
		'mail'          => '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>',
		'check'         => '<polyline points="20 6 9 17 4 12"/>',
		'shield-check'  => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/>',
		'truck'         => '<rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>',
		'smile'         => '<circle cx="12" cy="12" r="10"/><path d="M8 13s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/>',
		'package'       => '<line x1="16.5" y1="9.4" x2="7.5" y2="4.21"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/>',
		'tag'           => '<path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/>',
		'sparkles'      => '<path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/><path d="M5 3v4"/><path d="M19 17v4"/><path d="M3 5h4"/><path d="M17 19h4"/>',
		'arrow-right'   => '<line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>',
		'quote'         => '<path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"/><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/>',
	);

	if ( ! isset( $paths[ $name ] ) ) {
		return '';
	}

	$css_class = 'icon icon--' . esc_attr( $name );
	if ( $class ) {
		$css_class .= ' ' . esc_attr( $class );
	}

	return sprintf(
		'<svg class="%s" xmlns="http://www.w3.org/2000/svg" width="%d" height="%d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">%s</svg>',
		esc_attr( $css_class ),
		absint( $size ),
		absint( $size ),
		$paths[ $name ] // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — paths son constantes internas, no datos de usuario.
	);
}

/**
 * Imprime el SVG inline de un ícono Lucide.
 *
 * @param string $name  Nombre del ícono.
 * @param string $class Clases CSS adicionales.
 * @param int    $size  Tamaño en px.
 */
function kulimbos_the_icon( string $name, string $class = '', int $size = 24 ): void {
	$allowed_svg = array(
		'svg'      => array( 'class' => true, 'xmlns' => true, 'width' => true, 'height' => true, 'viewBox' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true, 'aria-hidden' => true, 'focusable' => true ),
		'path'     => array( 'd' => true, 'fill' => true, 'stroke' => true ),
		'circle'   => array( 'cx' => true, 'cy' => true, 'r' => true ),
		'line'     => array( 'x1' => true, 'y1' => true, 'x2' => true, 'y2' => true ),
		'polyline' => array( 'points' => true ),
		'polygon'  => array( 'points' => true ),
		'rect'     => array( 'x' => true, 'y' => true, 'width' => true, 'height' => true, 'rx' => true, 'ry' => true ),
	);

	echo wp_kses( kulimbos_icon( $name, $class, $size ), $allowed_svg );
}

/**
 * Devuelve la clase CSS de body para el contexto actual.
 * Complementa body_class() con clases propias del tema.
 *
 * @return string Clases adicionales separadas por espacio, escapadas.
 */
function kulimbos_extra_body_classes(): string {
	$classes = array();

	if ( is_front_page() ) {
		$classes[] = 'is-front-page';
	}

	if ( is_singular( 'post' ) ) {
		$classes[] = 'is-single-post';
	}

	return esc_attr( implode( ' ', $classes ) );
}
