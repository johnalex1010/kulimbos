<?php
/**
 * archive.php — Template para archivos, categorías, etiquetas y taxonomías.
 *
 * @package Kulimbos
 */

get_header();
?>

<main id="main-content" class="site-main" role="main">
	<div class="container">

		<header class="archive-header">
			<?php
			the_archive_title( '<h1 class="archive-header__title">', '</h1>' );
			the_archive_description( '<div class="archive-header__description">', '</div>' );
			?>
		</header>

		<?php if ( have_posts() ) : ?>

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
