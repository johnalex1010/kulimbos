<?php
/**
 * index.php — Template de reserva (fallback).
 *
 * WordPress usa este archivo cuando no encuentra un template más
 * específico en la jerarquía (home.php, archive.php, etc.).
 *
 * @package Kulimbos
 */

get_header();
?>

<main id="main-content" class="site-main" role="main">
	<div class="container">

		<?php if ( have_posts() ) : ?>

			<header class="archive-header">
				<?php
				if ( is_home() && ! is_front_page() ) {
					printf( '<h1 class="archive-header__title">%s</h1>', esc_html( single_post_title() ) );
				}
				?>
			</header>

			<div class="posts-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content/content', 'post' );
				endwhile;
				?>
			</div>

			<?php kulimbos_posts_pagination(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content/content', 'none' ); ?>

		<?php endif; ?>

	</div>
</main>

<?php get_footer(); ?>
