<?php
/**
 * inc/widgets.php — Registro de áreas de widgets del tema.
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registra las áreas de widgets disponibles.
 */
function kulimbos_register_widget_areas(): void {

	// Barra lateral principal.
	register_sidebar(
		array(
			'name'          => __( 'Barra lateral', 'kulimbos' ),
			'id'            => 'sidebar-main',
			'description'   => __( 'Widgets para la barra lateral del blog.', 'kulimbos' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget__title">',
			'after_title'   => '</h3>',
		)
	);

	// Área 1 del pie de página.
	register_sidebar(
		array(
			'name'          => __( 'Pie de página — Columna 1', 'kulimbos' ),
			'id'            => 'footer-col-1',
			'description'   => __( 'Primera columna del pie de página.', 'kulimbos' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget__title">',
			'after_title'   => '</h4>',
		)
	);

	// Área 2 del pie de página.
	register_sidebar(
		array(
			'name'          => __( 'Pie de página — Columna 2', 'kulimbos' ),
			'id'            => 'footer-col-2',
			'description'   => __( 'Segunda columna del pie de página.', 'kulimbos' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget__title">',
			'after_title'   => '</h4>',
		)
	);

	// Área 3 del pie de página.
	register_sidebar(
		array(
			'name'          => __( 'Pie de página — Columna 3', 'kulimbos' ),
			'id'            => 'footer-col-3',
			'description'   => __( 'Tercera columna del pie de página.', 'kulimbos' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget__title">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'kulimbos_register_widget_areas' );
