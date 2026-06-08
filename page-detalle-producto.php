<?php
/**
 * Template Name: Detalle de producto Kulimbos
 * Template Post Type: page
 *
 * Plantilla asignable para una página de detalle de producto.
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main-content" class="site-main site-main--product-detail" role="main">
	<?php get_template_part( 'template-parts/pages/product-detail' ); ?>
</main>

<?php
get_footer();
