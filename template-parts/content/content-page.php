<?php
/**
 * template-parts/content/content-page.php
 *
 * Contenido de una página estática de WordPress.
 * Se usa dentro del loop en page.php.
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'page-article' ); ?>
	itemscope itemtype="https://schema.org/WebPage">

	<header class="page-article__header">
		<?php if ( ! is_front_page() ) : ?>
			<h1 class="page-article__title" itemprop="headline">
				<?php the_title(); ?>
			</h1>
		<?php endif; ?>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="page-article__thumbnail">
				<?php
				the_post_thumbnail(
					'kulimbos-hero',
					array(
						'class'    => 'page-article__image',
						'itemprop' => 'image',
						'loading'  => 'eager',
						'decoding' => 'async',
					)
				);
				?>
			</div>
		<?php endif; ?>
	</header>

	<div class="page-article__content entry-content" itemprop="text">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<nav class="page-links"><span class="page-links__label">' . esc_html__( 'Páginas:', 'kulimbos' ) . '</span>',
				'after'  => '</nav>',
			)
		);
		?>
	</div>

</article>
