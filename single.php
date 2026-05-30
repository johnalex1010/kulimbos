<?php
/**
 * single.php — Template para entradas individuales del blog.
 *
 * @package Kulimbos
 */

get_header();
?>

<main id="main-content" class="site-main" role="main">
	<div class="container">
		<div class="single-layout">

			<article class="single-layout__content">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content/content', 'post' );
					kulimbos_post_navigation();

					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile;
				?>
			</article>

			<?php if ( is_active_sidebar( 'sidebar-main' ) ) : ?>
				<aside class="single-layout__sidebar" role="complementary" aria-label="<?php esc_attr_e( 'Barra lateral', 'kulimbos' ); ?>">
					<?php dynamic_sidebar( 'sidebar-main' ); ?>
				</aside>
			<?php endif; ?>

		</div>
	</div>
</main>

<?php get_footer(); ?>
