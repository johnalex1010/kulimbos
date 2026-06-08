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
	kulimbos_register_cpt_producto();
}
add_action( 'init', 'kulimbos_register_post_types', 1 );

/**
 * Registra todas las taxonomías personalizadas.
 */
function kulimbos_register_taxonomies(): void {
	kulimbos_register_tax_categoria_producto();
}
add_action( 'init', 'kulimbos_register_taxonomies', 0 );

/**
 * Registra el CPT de productos del catálogo Kulimbos.
 */
function kulimbos_register_cpt_producto(): void {
	$labels = array(
		'name'               => __( 'Productos', 'kulimbos' ),
		'singular_name'      => __( 'Producto', 'kulimbos' ),
		'menu_name'          => __( 'Productos', 'kulimbos' ),
		'add_new'            => __( 'Añadir nuevo', 'kulimbos' ),
		'add_new_item'       => __( 'Añadir nuevo producto', 'kulimbos' ),
		'edit_item'          => __( 'Editar producto', 'kulimbos' ),
		'new_item'           => __( 'Nuevo producto', 'kulimbos' ),
		'view_item'          => __( 'Ver producto', 'kulimbos' ),
		'search_items'       => __( 'Buscar productos', 'kulimbos' ),
		'not_found'          => __( 'No se encontraron productos', 'kulimbos' ),
		'not_found_in_trash' => __( 'No hay productos en la papelera', 'kulimbos' ),
		'all_items'          => __( 'Todos los productos', 'kulimbos' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'query_var'          => true,
		'rewrite'            => array(
			'slug'       => 'productos/%categoria_producto%',
			'with_front' => false,
		),
		'capability_type'    => 'post',
		'has_archive'        => 'productos',
		'hierarchical'       => false,
		'menu_position'      => 6,
		'menu_icon'          => 'dashicons-products',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
		'taxonomies'         => array( 'categoria_producto' ),
	);

	register_post_type( 'producto', $args );
}

/**
 * Registra categorías jerárquicas para productos.
 */
function kulimbos_register_tax_categoria_producto(): void {
	$labels = array(
		'name'              => __( 'Categorías de producto', 'kulimbos' ),
		'singular_name'     => __( 'Categoría de producto', 'kulimbos' ),
		'search_items'      => __( 'Buscar categorías', 'kulimbos' ),
		'all_items'         => __( 'Todas las categorías', 'kulimbos' ),
		'parent_item'       => __( 'Categoría superior', 'kulimbos' ),
		'parent_item_colon' => __( 'Categoría superior:', 'kulimbos' ),
		'edit_item'         => __( 'Editar categoría', 'kulimbos' ),
		'update_item'       => __( 'Actualizar categoría', 'kulimbos' ),
		'add_new_item'      => __( 'Añadir nueva categoría', 'kulimbos' ),
		'new_item_name'     => __( 'Nombre de la nueva categoría', 'kulimbos' ),
		'menu_name'         => __( 'Categorías', 'kulimbos' ),
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'         => 'categoria',
			'with_front'   => false,
			'hierarchical' => true,
		),
	);

	register_taxonomy( 'categoria_producto', array( 'producto' ), $args );
}

/**
 * Registra metadatos reutilizables del producto.
 */
function kulimbos_register_product_meta(): void {
	$meta_fields = array(
		'kulimbos_product_price',
		'kulimbos_product_rating',
		'kulimbos_product_reviews',
		'kulimbos_product_age',
		'kulimbos_product_size',
		'kulimbos_product_color',
		'kulimbos_product_material',
	);

	foreach ( $meta_fields as $meta_key ) {
		register_post_meta(
			'producto',
			$meta_key,
			array(
				'type'              => 'string',
				'single'            => true,
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_text_field',
				'auth_callback'     => static function (): bool {
					return current_user_can( 'edit_posts' );
				},
			)
		);
	}
}
add_action( 'init', 'kulimbos_register_product_meta', 2 );

/**
 * Registra reglas de rewrite adicionales para el catálogo.
 */
function kulimbos_register_product_rewrite_rules(): void {
	add_rewrite_rule(
		'^productos/(.+?)/([^/]+)/?$',
		'index.php?post_type=producto&name=$matches[2]',
		'top'
	);

	add_rewrite_rule(
		'^categoria/(.+?)/?$',
		'index.php?categoria_producto=$matches[1]',
		'top'
	);
}
add_action( 'init', 'kulimbos_register_product_rewrite_rules', 3 );

/**
 * Refresca reglas una sola vez cuando cambia la versión de rewrites del catálogo.
 */
function kulimbos_maybe_flush_product_rewrites(): void {
	$rewrite_version = 'producto-catalogo-v2';

	if ( get_option( 'kulimbos_product_rewrite_version' ) === $rewrite_version ) {
		return;
	}

	flush_rewrite_rules();
	update_option( 'kulimbos_product_rewrite_version', $rewrite_version, false );
}
add_action( 'init', 'kulimbos_maybe_flush_product_rewrites', 20 );

/**
 * Crea términos y productos base para que las rutas del catálogo existan.
 *
 * Solo corre una vez y únicamente para usuarios con permisos de administración,
 * evitando crear contenido durante visitas anónimas.
 */
function kulimbos_maybe_seed_catalog_content(): void {
	if ( get_option( 'kulimbos_catalog_seed_version' ) === 'v1' || ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$term_ids = kulimbos_seed_product_terms();
	kulimbos_seed_product_samples( $term_ids );

	update_option( 'kulimbos_catalog_seed_version', 'v1', false );
}
add_action( 'init', 'kulimbos_maybe_seed_catalog_content', 30 );

/**
 * Crea categorías base del catálogo.
 *
 * @return array<string,int>
 */
function kulimbos_seed_product_terms(): array {
	$term_ids = array();

	$base_terms = array(
		'juguetes' => array(
			'name'   => __( 'Juguetes', 'kulimbos' ),
			'parent' => 0,
		),
		'paseo'    => array(
			'name'   => __( 'Paseo', 'kulimbos' ),
			'parent' => 0,
		),
	);

	foreach ( $base_terms as $slug => $term_data ) {
		$term = term_exists( $slug, 'categoria_producto' );

		if ( ! $term ) {
			$term = wp_insert_term(
				$term_data['name'],
				'categoria_producto',
				array(
					'slug'   => $slug,
					'parent' => $term_data['parent'],
				)
			);
		}

		if ( ! is_wp_error( $term ) && isset( $term['term_id'] ) ) {
			$term_ids[ $slug ] = (int) $term['term_id'];
		}
	}

	$peluches = term_exists( 'peluches', 'categoria_producto' );

	if ( ! $peluches && isset( $term_ids['juguetes'] ) ) {
		$peluches = wp_insert_term(
			__( 'Peluches', 'kulimbos' ),
			'categoria_producto',
			array(
				'slug'   => 'peluches',
				'parent' => $term_ids['juguetes'],
			)
		);
	}

	if ( ! is_wp_error( $peluches ) && isset( $peluches['term_id'] ) ) {
		$term_ids['peluches'] = (int) $peluches['term_id'];
	}

	return $term_ids;
}

/**
 * Crea productos de ejemplo relacionados con las categorías base.
 *
 * @param array<string,int> $term_ids IDs de términos creados o existentes.
 */
function kulimbos_seed_product_samples( array $term_ids ): void {
	$samples = array(
		array(
			'title'    => __( 'Oso de peluche', 'kulimbos' ),
			'slug'     => 'oso-de-peluche',
			'term'     => $term_ids['peluches'] ?? 0,
			'price'    => '79900',
			'excerpt'  => __( 'Suave, tierno y perfecto para abrazar.', 'kulimbos' ),
			'age'      => '0-1',
			'size'     => 'mediano',
			'color'    => 'cafe',
			'material' => 'felpa',
		),
		array(
			'title'    => __( 'Coche de bebé', 'kulimbos' ),
			'slug'     => 'coche-de-bebe',
			'term'     => $term_ids['paseo'] ?? 0,
			'price'    => '349900',
			'excerpt'  => __( 'Coche práctico para paseos cómodos y seguros.', 'kulimbos' ),
			'age'      => '0-1',
			'size'     => 'grande',
			'color'    => 'gris',
			'material' => 'hipoalergenico',
		),
	);

	foreach ( $samples as $sample ) {
		if ( empty( $sample['term'] ) || get_page_by_path( $sample['slug'], OBJECT, 'producto' ) ) {
			continue;
		}

		$product_id = wp_insert_post(
			array(
				'post_type'    => 'producto',
				'post_status'  => 'publish',
				'post_title'   => $sample['title'],
				'post_name'    => $sample['slug'],
				'post_excerpt' => $sample['excerpt'],
				'post_content' => $sample['excerpt'],
			),
			true
		);

		if ( is_wp_error( $product_id ) ) {
			continue;
		}

		wp_set_object_terms( $product_id, array( (int) $sample['term'] ), 'categoria_producto' );
		update_post_meta( $product_id, 'kulimbos_product_price', $sample['price'] );
		update_post_meta( $product_id, 'kulimbos_product_rating', '5' );
		update_post_meta( $product_id, 'kulimbos_product_reviews', '0' );
		update_post_meta( $product_id, 'kulimbos_product_age', $sample['age'] );
		update_post_meta( $product_id, 'kulimbos_product_size', $sample['size'] );
		update_post_meta( $product_id, 'kulimbos_product_color', $sample['color'] );
		update_post_meta( $product_id, 'kulimbos_product_material', $sample['material'] );
	}
}

/**
 * Reemplaza %categoria_producto% en enlaces permanentes de productos.
 *
 * @param string  $post_link Enlace generado por WordPress.
 * @param WP_Post $post      Post actual.
 * @return string
 */
function kulimbos_product_permalink( string $post_link, WP_Post $post ): string {
	if ( 'producto' !== $post->post_type ) {
		return $post_link;
	}

	$term = kulimbos_get_primary_product_category( $post->ID );
	$slug = $term ? kulimbos_get_product_category_path( $term ) : 'sin-categoria';

	return str_replace( '%categoria_producto%', $slug, $post_link );
}
add_filter( 'post_type_link', 'kulimbos_product_permalink', 10, 2 );

/**
 * Devuelve la categoría principal del producto, priorizando la más profunda.
 *
 * @param int $post_id ID del producto.
 * @return WP_Term|null
 */
function kulimbos_get_primary_product_category( int $post_id ): ?WP_Term {
	$terms = get_the_terms( $post_id, 'categoria_producto' );

	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return null;
	}

	usort(
		$terms,
		static function ( WP_Term $term_a, WP_Term $term_b ): int {
			return count( get_ancestors( $term_b->term_id, 'categoria_producto' ) ) <=> count( get_ancestors( $term_a->term_id, 'categoria_producto' ) );
		}
	);

	return $terms[0];
}

/**
 * Devuelve el path jerárquico de una categoría de producto.
 *
 * @param WP_Term $term Término de categoría.
 * @return string
 */
function kulimbos_get_product_category_path( WP_Term $term ): string {
	$ancestors = array_reverse( get_ancestors( $term->term_id, 'categoria_producto' ) );
	$slugs     = array();

	foreach ( $ancestors as $ancestor_id ) {
		$ancestor = get_term( $ancestor_id, 'categoria_producto' );
		if ( $ancestor instanceof WP_Term ) {
			$slugs[] = $ancestor->slug;
		}
	}

	$slugs[] = $term->slug;

	return implode( '/', array_map( 'sanitize_title', $slugs ) );
}

/**
 * Actualiza reglas de enlaces al activar o cambiar al tema.
 */
function kulimbos_flush_product_rewrites(): void {
	kulimbos_register_tax_categoria_producto();
	kulimbos_register_cpt_producto();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'kulimbos_flush_product_rewrites' );

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
