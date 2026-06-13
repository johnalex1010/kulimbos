<?php
/**
 * functions.php — Punto de entrada del tema. Solo carga módulos.
 *
 * No contiene lógica funcional directa. Toda la lógica está
 * delegada en archivos de inc/ con responsabilidad única.
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;

// Constante de versión usada en assets.php para caché-busting.
define( 'KULIMBOS_VERSION', '1.0.0' );

// Carga de módulos en orden de dependencia.
require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/menus.php';
require_once get_template_directory() . '/inc/widgets.php';
require_once get_template_directory() . '/inc/assets.php';
require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/custom-post-types.php';
require_once get_template_directory() . '/inc/cart.php';
