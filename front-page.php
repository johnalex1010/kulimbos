<?php

/**
 * front-page.php — Template de la página de inicio.
 *
 * WordPress lo usa cuando "Tu portada muestra" está configurada
 * como "Una página estática" o como la portada del blog.
 * Tiene precedencia sobre index.php para la URL raíz del sitio.
 *
 * @package Kulimbos
 */

get_header();
?>

<main id="main-content" class="site-main site-main--home" role="main">

	<?php get_template_part('template-parts/home/hero');	?>
	<?php get_template_part('template-parts/home/benefits-bar');	?>
	<?php get_template_part('template-parts/home/featured-products'); ?>
	<?php get_template_part('template-parts/home/categories-grid'); ?>
	<?php get_template_part('template-parts/home/promo-banners'); ?>
	<?php get_template_part('template-parts/home/testimonials'); ?>
	<?php //get_template_part('template-parts/home/newsletter'); 
	?>

</main>

<?php get_footer(); ?>