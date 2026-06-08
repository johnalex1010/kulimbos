<?php
/**
 * Template Name: Categorías Kulimbos
 * Template Post Type: page
 *
 * Plantilla asignable para la página de categorías.
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main-content" class="site-main site-main--categories" role="main">
	<?php get_template_part( 'template-parts/pages/categories' ); ?>
</main>

<?php
get_footer();
