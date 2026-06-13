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
	kulimbos_register_tax_producto_filtros();
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
		'taxonomies'         => array( 'categoria_producto', 'edad_producto', 'tamano_producto', 'color_producto', 'material_producto' ),
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
 * Registra taxonomías internas para los filtros del catálogo.
 */
function kulimbos_register_tax_producto_filtros(): void {
	$taxonomies = array(
		'edad_producto'     => array(
			'name'          => __( 'Edades recomendadas', 'kulimbos' ),
			'singular_name' => __( 'Edad recomendada', 'kulimbos' ),
			'menu_name'     => __( 'Edades', 'kulimbos' ),
		),
		'tamano_producto'   => array(
			'name'          => __( 'Tamaños de producto', 'kulimbos' ),
			'singular_name' => __( 'Tamaño de producto', 'kulimbos' ),
			'menu_name'     => __( 'Tamaños', 'kulimbos' ),
		),
		'color_producto'    => array(
			'name'          => __( 'Colores de producto', 'kulimbos' ),
			'singular_name' => __( 'Color de producto', 'kulimbos' ),
			'menu_name'     => __( 'Colores', 'kulimbos' ),
		),
		'material_producto' => array(
			'name'          => __( 'Materiales de producto', 'kulimbos' ),
			'singular_name' => __( 'Material de producto', 'kulimbos' ),
			'menu_name'     => __( 'Materiales', 'kulimbos' ),
		),
	);

	foreach ( $taxonomies as $taxonomy => $labels_data ) {
		$labels = array(
			'name'              => $labels_data['name'],
			'singular_name'     => $labels_data['singular_name'],
			'search_items'      => sprintf( __( 'Buscar %s', 'kulimbos' ), strtolower( $labels_data['name'] ) ),
			'all_items'         => sprintf( __( 'Todos los %s', 'kulimbos' ), strtolower( $labels_data['name'] ) ),
			'parent_item'       => __( 'Elemento superior', 'kulimbos' ),
			'parent_item_colon' => __( 'Elemento superior:', 'kulimbos' ),
			'edit_item'         => sprintf( __( 'Editar %s', 'kulimbos' ), strtolower( $labels_data['singular_name'] ) ),
			'update_item'       => sprintf( __( 'Actualizar %s', 'kulimbos' ), strtolower( $labels_data['singular_name'] ) ),
			'add_new_item'      => sprintf( __( 'Añadir nuevo %s', 'kulimbos' ), strtolower( $labels_data['singular_name'] ) ),
			'new_item_name'     => sprintf( __( 'Nombre del nuevo %s', 'kulimbos' ), strtolower( $labels_data['singular_name'] ) ),
			'menu_name'         => $labels_data['menu_name'],
		);

		register_taxonomy(
			$taxonomy,
			array( 'producto' ),
			array(
				'labels'            => $labels,
				'hierarchical'      => true,
				'public'            => false,
				'publicly_queryable' => false,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_rest'      => true,
				'query_var'         => false,
				'rewrite'           => false,
			)
		);
	}
}

/**
 * Registra metadatos reutilizables del producto.
 */
function kulimbos_register_product_meta(): void {
	$integer_meta_fields = array(
		'kulimbos_product_price',
		'kulimbos_product_stock',
	);

	foreach ( $integer_meta_fields as $meta_key ) {
		register_post_meta(
			'producto',
			$meta_key,
			array(
				'type'              => 'string',
				'single'            => true,
				'show_in_rest'      => true,
				'sanitize_callback' => 'kulimbos_sanitize_product_integer_meta',
				'auth_callback'     => static function (): bool {
					return current_user_can( 'edit_posts' );
				},
			)
		);
	}

	$meta_fields = array(
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

	register_post_meta(
		'producto',
		'kulimbos_product_gallery_ids',
		array(
			'type'              => 'array',
			'single'            => true,
			'show_in_rest'      => array(
				'schema' => array(
					'type'  => 'array',
					'items' => array(
						'type' => 'integer',
					),
				),
			),
			'sanitize_callback' => 'kulimbos_sanitize_product_gallery_ids',
			'auth_callback'     => static function (): bool {
				return current_user_can( 'edit_posts' );
			},
		)
	);
}
add_action( 'init', 'kulimbos_register_product_meta', 2 );

/**
 * Sanitiza campos numéricos enteros de producto.
 *
 * @param mixed $value Valor recibido.
 * @return string
 */
function kulimbos_sanitize_product_integer_meta( $value ): string {
	$value = is_scalar( $value ) ? (string) $value : '';
	$value = preg_replace( '/[^\d]/', '', $value );

	return (string) max( 0, (int) $value );
}

/**
 * Sanitiza la lista ordenada de IDs de imágenes de galería.
 *
 * @param mixed $value Valor recibido.
 * @return array<int>
 */
function kulimbos_sanitize_product_gallery_ids( $value ): array {
	if ( is_string( $value ) ) {
		$value = explode( ',', $value );
	}

	if ( ! is_array( $value ) ) {
		return array();
	}

	$attachment_ids = array();

	foreach ( $value as $attachment_id ) {
		$attachment_id = absint( $attachment_id );

		if ( $attachment_id > 0 && 'attachment' === get_post_type( $attachment_id ) && wp_attachment_is_image( $attachment_id ) ) {
			$attachment_ids[] = $attachment_id;
		}
	}

	return array_values( array_unique( $attachment_ids ) );
}

/**
 * Agrega la caja de datos del producto.
 */
function kulimbos_add_product_data_meta_box(): void {
	add_meta_box(
		'kulimbos-product-data',
		__( 'Datos del producto', 'kulimbos' ),
		'kulimbos_render_product_data_meta_box',
		'producto',
		'side',
		'high'
	);

	add_meta_box(
		'kulimbos-product-gallery',
		__( 'Galería del producto', 'kulimbos' ),
		'kulimbos_render_product_gallery_meta_box',
		'producto',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes_producto', 'kulimbos_add_product_data_meta_box' );

/**
 * Renderiza la caja de precio y stock.
 *
 * @param WP_Post $post Producto actual.
 */
function kulimbos_render_product_data_meta_box( WP_Post $post ): void {
	$price = kulimbos_sanitize_product_integer_meta( get_post_meta( $post->ID, 'kulimbos_product_price', true ) );
	$stock = kulimbos_sanitize_product_integer_meta( get_post_meta( $post->ID, 'kulimbos_product_stock', true ) );

	wp_nonce_field( 'kulimbos_save_product_data', 'kulimbos_product_data_nonce' );
	?>
	<p>
		<label for="kulimbos-product-price"><strong><?php esc_html_e( 'Precio', 'kulimbos' ); ?></strong></label>
		<input
			type="number"
			id="kulimbos-product-price"
			name="kulimbos_product_price"
			value="<?php echo esc_attr( $price ); ?>"
			min="0"
			step="1"
			class="widefat"
			inputmode="numeric">
		<span class="description"><?php esc_html_e( 'Valor en COP sin puntos ni símbolo. Ejemplo: 89900.', 'kulimbos' ); ?></span>
	</p>
	<p>
		<label for="kulimbos-product-stock"><strong><?php esc_html_e( 'Stock', 'kulimbos' ); ?></strong></label>
		<input
			type="number"
			id="kulimbos-product-stock"
			name="kulimbos_product_stock"
			value="<?php echo esc_attr( $stock ); ?>"
			min="0"
			step="1"
			class="widefat"
			inputmode="numeric">
		<span class="description"><?php esc_html_e( 'Unidades disponibles. Con 0 se mostrará como agotado.', 'kulimbos' ); ?></span>
	</p>
	<?php
}

/**
 * Renderiza la caja de galería del producto.
 *
 * @param WP_Post $post Producto actual.
 */
function kulimbos_render_product_gallery_meta_box( WP_Post $post ): void {
	$gallery_ids = kulimbos_sanitize_product_gallery_ids( get_post_meta( $post->ID, 'kulimbos_product_gallery_ids', true ) );

	wp_nonce_field( 'kulimbos_save_product_gallery', 'kulimbos_product_gallery_nonce' );
	?>
	<div class="kulimbos-product-gallery-field" data-product-gallery-field>
		<input
			type="hidden"
			name="kulimbos_product_gallery_ids"
			value="<?php echo esc_attr( implode( ',', $gallery_ids ) ); ?>"
			data-product-gallery-input>

		<div class="kulimbos-product-gallery-field__intro">
			<div>
				<h3><?php esc_html_e( 'Imágenes adicionales', 'kulimbos' ); ?></h3>
				<p><?php esc_html_e( 'La imagen destacada seguirá siendo la imagen principal. Estas imágenes aparecerán como miniaturas adicionales en el detalle del producto.', 'kulimbos' ); ?></p>
			</div>
			<button type="button" class="button button-primary" data-product-gallery-select>
				<span class="dashicons dashicons-format-gallery" aria-hidden="true"></span>
				<?php esc_html_e( 'Agregar imágenes', 'kulimbos' ); ?>
			</button>
		</div>

		<ul class="kulimbos-product-gallery-field__list" data-product-gallery-list>
			<?php foreach ( $gallery_ids as $attachment_id ) : ?>
				<?php
				$image_url = wp_get_attachment_image_url( $attachment_id, 'thumbnail' );

				if ( ! $image_url ) {
					continue;
				}
				?>
				<li class="kulimbos-product-gallery-field__item" data-product-gallery-item data-attachment-id="<?php echo absint( $attachment_id ); ?>">
					<div class="kulimbos-product-gallery-field__thumb">
						<img src="<?php echo esc_url( $image_url ); ?>" alt="" width="120" height="120">
					</div>
					<div class="kulimbos-product-gallery-field__actions">
						<button type="button" class="button button-small" data-product-gallery-move-up>
							<span class="dashicons dashicons-arrow-up-alt2" aria-hidden="true"></span>
							<?php esc_html_e( 'Subir', 'kulimbos' ); ?>
						</button>
						<button type="button" class="button button-small" data-product-gallery-move-down>
							<span class="dashicons dashicons-arrow-down-alt2" aria-hidden="true"></span>
							<?php esc_html_e( 'Bajar', 'kulimbos' ); ?>
						</button>
						<button type="button" class="button button-small kulimbos-product-gallery-field__remove" data-product-gallery-remove>
							<span class="dashicons dashicons-trash" aria-hidden="true"></span>
							<?php esc_html_e( 'Quitar', 'kulimbos' ); ?>
						</button>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>

		<div class="kulimbos-product-gallery-field__empty" data-product-gallery-empty <?php echo empty( $gallery_ids ) ? '' : 'hidden'; ?>>
			<span class="dashicons dashicons-images-alt2" aria-hidden="true"></span>
			<p><?php esc_html_e( 'Aún no hay imágenes adicionales en la galería.', 'kulimbos' ); ?></p>
		</div>
	</div>
	<?php
}

/**
 * Encola la biblioteca de medios y el script de galería solo al editar productos.
 *
 * @param string $hook_suffix Pantalla actual del admin.
 */
function kulimbos_enqueue_product_gallery_admin_assets( string $hook_suffix ): void {
	if ( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}

	$screen = get_current_screen();

	if ( ! $screen || 'producto' !== $screen->post_type ) {
		return;
	}

	$script_path = get_template_directory() . '/assets/admin/product-gallery.js';
	$style_path  = get_template_directory() . '/assets/admin/product-gallery.css';

	wp_enqueue_media();
	wp_enqueue_style(
		'kulimbos-product-gallery-admin',
		get_template_directory_uri() . '/assets/admin/product-gallery.css',
		array(),
		file_exists( $style_path ) ? filemtime( $style_path ) : KULIMBOS_VERSION
	);

	wp_enqueue_script(
		'kulimbos-product-gallery-admin',
		get_template_directory_uri() . '/assets/admin/product-gallery.js',
		array(),
		file_exists( $script_path ) ? filemtime( $script_path ) : KULIMBOS_VERSION,
		true
	);

	wp_localize_script(
		'kulimbos-product-gallery-admin',
		'kulimbosProductGalleryAdmin',
		array(
			'frameTitle'   => __( 'Seleccionar imágenes de galería', 'kulimbos' ),
			'buttonText'   => __( 'Usar imágenes seleccionadas', 'kulimbos' ),
			'moveUpText'   => __( 'Subir', 'kulimbos' ),
			'moveDownText' => __( 'Bajar', 'kulimbos' ),
			'removeText'   => __( 'Quitar', 'kulimbos' ),
		)
	);
}
add_action( 'admin_enqueue_scripts', 'kulimbos_enqueue_product_gallery_admin_assets' );

/**
 * Guarda los datos administrativos del producto.
 *
 * @param int $post_id ID del producto.
 */
function kulimbos_save_product_data_meta_box( int $post_id ): void {
	if ( ! isset( $_POST['kulimbos_product_data_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['kulimbos_product_data_nonce'] ) ), 'kulimbos_save_product_data' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$fields = array(
		'kulimbos_product_price',
		'kulimbos_product_stock',
	);

	foreach ( $fields as $field ) {
		if ( ! isset( $_POST[ $field ] ) ) {
			delete_post_meta( $post_id, $field );
			continue;
		}

		$value = kulimbos_sanitize_product_integer_meta( wp_unslash( $_POST[ $field ] ) );
		update_post_meta( $post_id, $field, $value );
	}
}
add_action( 'save_post_producto', 'kulimbos_save_product_data_meta_box' );

/**
 * Guarda la galería administrativa del producto.
 *
 * @param int $post_id ID del producto.
 */
function kulimbos_save_product_gallery_meta_box( int $post_id ): void {
	if ( ! isset( $_POST['kulimbos_product_gallery_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['kulimbos_product_gallery_nonce'] ) ), 'kulimbos_save_product_gallery' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$gallery_ids = isset( $_POST['kulimbos_product_gallery_ids'] )
		? kulimbos_sanitize_product_gallery_ids( wp_unslash( $_POST['kulimbos_product_gallery_ids'] ) )
		: array();

	if ( empty( $gallery_ids ) ) {
		delete_post_meta( $post_id, 'kulimbos_product_gallery_ids' );
		return;
	}

	update_post_meta( $post_id, 'kulimbos_product_gallery_ids', $gallery_ids );
}
add_action( 'save_post_producto', 'kulimbos_save_product_gallery_meta_box' );

/**
 * Muestra selector de calificación en comentarios de producto.
 */
function kulimbos_render_product_comment_rating_field(): void {
	if ( ! is_singular( 'producto' ) ) {
		return;
	}
	?>
	<p class="comment-form-rating">
		<label for="kulimbos-comment-rating"><?php esc_html_e( 'Calificación', 'kulimbos' ); ?> <span class="required">*</span></label>
		<select id="kulimbos-comment-rating" name="kulimbos_comment_rating" required>
			<option value=""><?php esc_html_e( 'Selecciona una calificación', 'kulimbos' ); ?></option>
			<option value="5"><?php esc_html_e( '5 estrellas', 'kulimbos' ); ?></option>
			<option value="4"><?php esc_html_e( '4 estrellas', 'kulimbos' ); ?></option>
			<option value="3"><?php esc_html_e( '3 estrellas', 'kulimbos' ); ?></option>
			<option value="2"><?php esc_html_e( '2 estrellas', 'kulimbos' ); ?></option>
			<option value="1"><?php esc_html_e( '1 estrella', 'kulimbos' ); ?></option>
		</select>
	</p>
	<?php
}
add_action( 'comment_form_logged_in_after', 'kulimbos_render_product_comment_rating_field' );
add_action( 'comment_form_after_fields', 'kulimbos_render_product_comment_rating_field' );

/**
 * Valida la calificación en comentarios de producto.
 *
 * @param array<string,mixed> $comment_data Datos del comentario.
 * @return array<string,mixed>
 */
function kulimbos_validate_product_comment_rating( array $comment_data ): array {
	$post_id = isset( $comment_data['comment_post_ID'] ) ? (int) $comment_data['comment_post_ID'] : 0;

	if ( ! $post_id || 'producto' !== get_post_type( $post_id ) ) {
		return $comment_data;
	}

	$rating = isset( $_POST['kulimbos_comment_rating'] ) ? (int) wp_unslash( $_POST['kulimbos_comment_rating'] ) : 0;

	if ( $rating < 1 || $rating > 5 ) {
		wp_die(
			esc_html__( 'Selecciona una calificación válida para enviar tu opinión.', 'kulimbos' ),
			esc_html__( 'Calificación requerida', 'kulimbos' ),
			array(
				'response' => 400,
				'back_link' => true,
			)
		);
	}

	return $comment_data;
}
add_filter( 'preprocess_comment', 'kulimbos_validate_product_comment_rating' );

/**
 * Guarda la calificación del comentario.
 *
 * @param int $comment_id ID del comentario.
 */
function kulimbos_save_product_comment_rating( int $comment_id ): void {
	$comment = get_comment( $comment_id );

	if ( ! $comment instanceof WP_Comment || 'producto' !== get_post_type( (int) $comment->comment_post_ID ) ) {
		return;
	}

	$rating = isset( $_POST['kulimbos_comment_rating'] ) ? (int) wp_unslash( $_POST['kulimbos_comment_rating'] ) : 0;

	if ( $rating < 1 || $rating > 5 ) {
		return;
	}

	update_comment_meta( $comment_id, 'kulimbos_comment_rating', $rating );
}
add_action( 'comment_post', 'kulimbos_save_product_comment_rating' );

/**
 * Registra metadatos para términos del catálogo.
 */
function kulimbos_register_product_term_meta(): void {
	register_term_meta(
		'color_producto',
		'kulimbos_color_hex',
		array(
			'type'              => 'string',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => 'sanitize_hex_color',
			'auth_callback'     => static function (): bool {
				return current_user_can( 'manage_categories' );
			},
		)
	);
}
add_action( 'init', 'kulimbos_register_product_term_meta', 2 );

/**
 * Muestra el campo hexadecimal al crear un color de producto.
 */
function kulimbos_add_color_product_hex_field(): void {
	?>
	<div class="form-field term-color-wrap">
		<label for="kulimbos-color-hex"><?php esc_html_e( 'Color visual', 'kulimbos' ); ?></label>
		<input type="color" id="kulimbos-color-hex" name="kulimbos_color_hex" value="#d9dce3">
		<p><?php esc_html_e( 'Selecciona el color que se mostrará en el filtro del catálogo.', 'kulimbos' ); ?></p>
	</div>
	<?php
}
add_action( 'color_producto_add_form_fields', 'kulimbos_add_color_product_hex_field' );

/**
 * Muestra el campo hexadecimal al editar un color de producto.
 *
 * @param WP_Term $term Término actual.
 */
function kulimbos_edit_color_product_hex_field( WP_Term $term ): void {
	$color_hex = get_term_meta( $term->term_id, 'kulimbos_color_hex', true );
	$color_hex = sanitize_hex_color( $color_hex ) ?: '#d9dce3';
	?>
	<tr class="form-field term-color-wrap">
		<th scope="row">
			<label for="kulimbos-color-hex"><?php esc_html_e( 'Color visual', 'kulimbos' ); ?></label>
		</th>
		<td>
			<input type="color" id="kulimbos-color-hex" name="kulimbos_color_hex" value="<?php echo esc_attr( $color_hex ); ?>">
			<p class="description"><?php esc_html_e( 'Selecciona el color que se mostrará en el filtro del catálogo.', 'kulimbos' ); ?></p>
		</td>
	</tr>
	<?php
}
add_action( 'color_producto_edit_form_fields', 'kulimbos_edit_color_product_hex_field' );

/**
 * Guarda el hexadecimal de un color de producto.
 *
 * @param int $term_id ID del término.
 */
function kulimbos_save_color_product_hex_field( int $term_id ): void {
	if ( ! current_user_can( 'manage_categories' ) ) {
		return;
	}

	if ( ! isset( $_POST['kulimbos_color_hex'] ) ) {
		return;
	}

	$color_hex = sanitize_hex_color( wp_unslash( $_POST['kulimbos_color_hex'] ) );

	if ( $color_hex ) {
		update_term_meta( $term_id, 'kulimbos_color_hex', $color_hex );
		return;
	}

	delete_term_meta( $term_id, 'kulimbos_color_hex' );
}
add_action( 'created_color_producto', 'kulimbos_save_color_product_hex_field' );
add_action( 'edited_color_producto', 'kulimbos_save_color_product_hex_field' );

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
 * Crea términos base para filtros administrables del catálogo.
 */
function kulimbos_maybe_seed_product_filter_terms(): void {
	if ( get_option( 'kulimbos_product_filter_terms_version' ) === 'v1' || ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$filter_terms = array(
		'edad_producto'     => array(
			'0-1'   => __( '0 a 1 años', 'kulimbos' ),
			'1-3'   => __( '1 a 3 años', 'kulimbos' ),
			'3-6'   => __( '3 a 6 años', 'kulimbos' ),
			'6-mas' => __( '6+ años', 'kulimbos' ),
		),
		'tamano_producto'   => array(
			'pequeno' => __( 'Pequeño (hasta 20 cm)', 'kulimbos' ),
			'mediano' => __( 'Mediano (20 a 35 cm)', 'kulimbos' ),
			'grande'  => __( 'Grande (35 a 50 cm)', 'kulimbos' ),
			'extra'   => __( 'Extra grande (50+ cm)', 'kulimbos' ),
		),
		'color_producto'    => array(
			'cafe'    => array(
				'name' => __( 'Café', 'kulimbos' ),
				'hex'  => '#e6c59b',
			),
			'rosado'  => array(
				'name' => __( 'Rosado', 'kulimbos' ),
				'hex'  => '#ffb7c7',
			),
			'gris'    => array(
				'name' => __( 'Gris', 'kulimbos' ),
				'hex'  => '#bfc1c6',
			),
			'azul'    => array(
				'name' => __( 'Azul', 'kulimbos' ),
				'hex'  => '#8dc6f6',
			),
			'verde'   => array(
				'name' => __( 'Verde', 'kulimbos' ),
				'hex'  => '#50c983',
			),
		),
		'material_producto' => array(
			'algodon'        => __( 'Algodón', 'kulimbos' ),
			'felpa'          => __( 'Felpa suave', 'kulimbos' ),
			'hipoalergenico' => __( 'Hipoalergénico', 'kulimbos' ),
		),
	);

	foreach ( $filter_terms as $taxonomy => $terms ) {
		foreach ( $terms as $slug => $term_data ) {
			$name = is_array( $term_data ) ? $term_data['name'] : $term_data;
			$term = term_exists( $slug, $taxonomy );

			if ( ! $term ) {
				$term = wp_insert_term(
					$name,
					$taxonomy,
					array(
						'slug' => $slug,
					)
				);
			}

			if ( 'color_producto' === $taxonomy && is_array( $term_data ) && ! is_wp_error( $term ) && isset( $term['term_id'] ) ) {
				update_term_meta( (int) $term['term_id'], 'kulimbos_color_hex', sanitize_hex_color( $term_data['hex'] ) );
			}
		}
	}

	update_option( 'kulimbos_product_filter_terms_version', 'v1', false );
}
add_action( 'init', 'kulimbos_maybe_seed_product_filter_terms', 29 );

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
			'stock'    => '10',
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
			'stock'    => '6',
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
		wp_set_object_terms( $product_id, array( $sample['age'] ), 'edad_producto' );
		wp_set_object_terms( $product_id, array( $sample['size'] ), 'tamano_producto' );
		wp_set_object_terms( $product_id, array( $sample['color'] ), 'color_producto' );
		wp_set_object_terms( $product_id, array( $sample['material'] ), 'material_producto' );
		update_post_meta( $product_id, 'kulimbos_product_price', $sample['price'] );
		update_post_meta( $product_id, 'kulimbos_product_stock', $sample['stock'] );
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
 * Devuelve los slugs de un filtro de producto, priorizando taxonomía y usando meta como fallback.
 *
 * @param int    $post_id  ID del producto.
 * @param string $taxonomy Taxonomía del filtro.
 * @param string $meta_key Clave meta heredada.
 * @return string[]
 */
function kulimbos_get_product_filter_slugs( int $post_id, string $taxonomy, string $meta_key ): array {
	$terms = get_the_terms( $post_id, $taxonomy );

	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		$slugs = array();

		foreach ( $terms as $term ) {
			if ( $term instanceof WP_Term ) {
				$slugs[] = sanitize_key( $term->slug );
			}
		}

		if ( ! empty( $slugs ) ) {
			return array_values( array_unique( $slugs ) );
		}
	}

	$legacy_value = sanitize_key( get_post_meta( $post_id, $meta_key, true ) );

	return $legacy_value ? array( $legacy_value ) : array();
}

/**
 * Devuelve el primer slug de un filtro de producto.
 *
 * @param int    $post_id  ID del producto.
 * @param string $taxonomy Taxonomía del filtro.
 * @param string $meta_key Clave meta heredada.
 * @return string
 */
function kulimbos_get_product_filter_slug( int $post_id, string $taxonomy, string $meta_key ): string {
	$slugs = kulimbos_get_product_filter_slugs( $post_id, $taxonomy, $meta_key );

	return $slugs[0] ?? '';
}

/**
 * Devuelve el stock numérico configurado para un producto.
 *
 * @param int $post_id ID del producto.
 * @return int
 */
function kulimbos_get_product_stock( int $post_id ): int {
	return (int) kulimbos_sanitize_product_integer_meta( get_post_meta( $post_id, 'kulimbos_product_stock', true ) );
}

/**
 * Calcula la calificación del producto desde comentarios aprobados.
 *
 * Espera que cada comentario con reseña guarde `kulimbos_comment_rating`
 * como entero entre 1 y 5.
 *
 * @param int $post_id ID del producto.
 * @return array{rating:float,reviews:int}
 */
function kulimbos_get_product_review_summary( int $post_id ): array {
	$comments = get_comments(
		array(
			'post_id' => $post_id,
			'status'  => 'approve',
			'type'    => 'comment',
			'fields'  => 'ids',
		)
	);

	if ( empty( $comments ) ) {
		return array(
			'rating'  => 0.0,
			'reviews' => 0,
		);
	}

	$total = 0;
	$count = 0;

	foreach ( $comments as $comment_id ) {
		$rating = (int) get_comment_meta( (int) $comment_id, 'kulimbos_comment_rating', true );

		if ( $rating < 1 || $rating > 5 ) {
			continue;
		}

		$total += $rating;
		$count++;
	}

	if ( 0 === $count ) {
		return array(
			'rating'  => 0.0,
			'reviews' => 0,
		);
	}

	return array(
		'rating'  => round( $total / $count, 1 ),
		'reviews' => $count,
	);
}

/**
 * Actualiza reglas de enlaces al activar o cambiar al tema.
 */
function kulimbos_flush_product_rewrites(): void {
	kulimbos_register_tax_categoria_producto();
	kulimbos_register_tax_producto_filtros();
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
