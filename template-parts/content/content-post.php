<?php
/**
 * template-parts/content/content-post.php
 *
 * Contenido de una entrada del blog.
 * Funciona tanto en listados (index, archive) como en vista individual (single).
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;

$is_singular = is_singular( 'post' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>
	itemscope itemtype="https://schema.org/BlogPosting">

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="post-card__thumbnail">
			<a href="<?php echo esc_url( get_permalink() ); ?>" tabindex="<?php echo $is_singular ? '-1' : '0'; ?>" aria-hidden="<?php echo $is_singular ? 'true' : 'false'; ?>">
				<?php
				the_post_thumbnail(
					$is_singular ? 'kulimbos-hero' : 'post-thumbnail',
					array(
						'class'    => 'post-card__image',
						'itemprop' => 'image',
						'loading'  => $is_singular ? 'eager' : 'lazy',
						'decoding' => 'async',
					)
				);
				?>
			</a>
		</div>
	<?php endif; ?>

	<div class="post-card__body">

		<header class="post-card__header">
			<?php
			// En la vista individual usamos h1; en listados, h2.
			$heading_tag = $is_singular ? 'h1' : 'h2';
			printf(
				'<%1$s class="post-card__title" itemprop="headline">%2$s</%1$s>',
				esc_attr( $heading_tag ),
				$is_singular
					? esc_html( get_the_title() )
					: sprintf(
						'<a href="%s" rel="bookmark">%s</a>',
						esc_url( get_permalink() ),
						esc_html( get_the_title() )
					)
			);
			?>

			<?php kulimbos_post_meta(); ?>
		</header>

		<div class="post-card__content entry-content" itemprop="articleBody">
			<?php
			if ( $is_singular ) {
				the_content();
				wp_link_pages(
					array(
						'before' => '<nav class="page-links"><span class="page-links__label">' . esc_html__( 'Páginas:', 'kulimbos' ) . '</span>',
						'after'  => '</nav>',
					)
				);
			} else {
				echo '<p>' . kulimbos_get_excerpt( 25 ) . '</p>';
			}
			?>
		</div>

		<?php if ( ! $is_singular ) : ?>
			<footer class="post-card__footer">
				<?php
				kulimbos_component(
					'button',
					array(
						'text'  => __( 'Leer más', 'kulimbos' ),
						'url'   => get_permalink(),
						'class' => 'btn--secondary btn--sm',
						'aria'  => sprintf(
							/* translators: %s: Post title */
							__( 'Leer más sobre %s', 'kulimbos' ),
							get_the_title()
						),
					)
				);
				?>
			</footer>
		<?php endif; ?>

	</div>

</article>
