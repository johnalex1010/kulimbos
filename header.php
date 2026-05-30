<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class( kulimbos_extra_body_classes() ); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main-content">
	<?php esc_html_e( 'Ir al contenido principal', 'kulimbos' ); ?>
</a>

<header class="site-header" role="banner" itemscope itemtype="https://schema.org/WPHeader">

	<div class="site-header__inner container">

		<div class="site-header__branding">
			<?php if ( has_custom_logo() ) : ?>
				<div class="site-header__logo">
					<?php the_custom_logo(); ?>
				</div>
			<?php else : ?>
				<a class="site-header__site-name" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url">
					<?php bloginfo( 'name' ); ?>
				</a>
				<?php
				$tagline = get_bloginfo( 'description', 'display' );
				if ( $tagline ) :
				?>
					<p class="site-header__tagline"><?php echo esc_html( $tagline ); ?></p>
				<?php endif; ?>
			<?php endif; ?>
		</div>

		<?php get_template_part( 'template-parts/layout/header-navigation' ); ?>

	</div>

</header>
