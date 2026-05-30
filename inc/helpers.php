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
