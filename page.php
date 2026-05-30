<?php
/**
 * page.php — Template para páginas estáticas de WordPress.
 *
 * @package Kulimbos
 */

get_header();
?>

<main id="main-content" class="site-main" role="main">
	<div class="container">

		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content/content', 'page' );

			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		endwhile;
		?>

	</div>
</main>

<?php get_footer(); ?>
