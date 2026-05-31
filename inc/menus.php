<?php
/**
 * inc/menus.php — Registro de zonas de navegación del tema.
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registra las ubicaciones de menú disponibles en el tema.
 */
function kulimbos_register_menus(): void {
	register_nav_menus(
		array(
			'primary'            => __( 'Menú principal', 'kulimbos' ),
			'footer'             => __( 'Menú de pie de página', 'kulimbos' ),
			'footer_information' => __( 'Footer - Información', 'kulimbos' ),
			'footer_account'     => __( 'Footer - Mi cuenta', 'kulimbos' ),
			'footer_help'        => __( 'Footer - Ayuda', 'kulimbos' ),
			'social'             => __( 'Redes sociales', 'kulimbos' ),
			'secondary'          => __( 'Menú secundario', 'kulimbos' ),
		)
	);
}
add_action( 'after_setup_theme', 'kulimbos_register_menus' );
