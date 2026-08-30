<?php
/**
 * Template automático para archivo de productos.
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main-content" class="site-main site-main--plushies" role="main">
	<?php get_template_part( 'template-parts/pages/plushies', null, array( 'catalog_mode' => 'all-products' ) ); ?>
</main>

<?php
get_footer();
