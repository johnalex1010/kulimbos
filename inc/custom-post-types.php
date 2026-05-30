<?php
/**
 * inc/custom-post-types.php — Tipos de contenido y taxonomías personalizadas.
 *
 * Registra CPTs y taxonomías del proyecto.
 * Cada tipo de contenido tiene su propia función para claridad y fácil desactivación.
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registra todos los CPTs del tema.
 * Descomenta o añade según las necesidades del proyecto.
 */
function kulimbos_register_post_types(): void {
	// kulimbos_register_cpt_proyecto();
	// kulimbos_register_cpt_servicio();
}
add_action( 'init', 'kulimbos_register_post_types' );

/**
 * Registra todas las taxonomías personalizadas.
 */
function kulimbos_register_taxonomies(): void {
	// kulimbos_register_tax_categoria_proyecto();
}
add_action( 'init', 'kulimbos_register_taxonomies' );

/**
 * Ejemplo de CPT: Proyecto.
 * Descomenta kulimbos_register_cpt_proyecto() arriba para activarlo.
 */
function kulimbos_register_cpt_proyecto(): void {
	$labels = array(
		'name'               => __( 'Proyectos', 'kulimbos' ),
		'singular_name'      => __( 'Proyecto', 'kulimbos' ),
		'menu_name'          => __( 'Proyectos', 'kulimbos' ),
		'add_new'            => __( 'Añadir nuevo', 'kulimbos' ),
		'add_new_item'       => __( 'Añadir nuevo proyecto', 'kulimbos' ),
		'edit_item'          => __( 'Editar proyecto', 'kulimbos' ),
		'new_item'           => __( 'Nuevo proyecto', 'kulimbos' ),
		'view_item'          => __( 'Ver proyecto', 'kulimbos' ),
		'search_items'       => __( 'Buscar proyectos', 'kulimbos' ),
		'not_found'          => __( 'No se encontraron proyectos', 'kulimbos' ),
		'not_found_in_trash' => __( 'No hay proyectos en la papelera', 'kulimbos' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true, // Habilita el editor de bloques para este CPT.
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'proyectos' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-portfolio',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
	);

	register_post_type( 'proyecto', $args );
}
