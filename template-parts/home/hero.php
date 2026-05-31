<?php

/**
 * template-parts/home/hero.php
 *
 * Hero principal estático de la homepage.
 *
 * @package Kulimbos
 */

defined('ABSPATH') || exit;

$hero_image_url = get_template_directory_uri() . '/assets/img/hero/hero.png';
?>

<section class="home-hero" aria-labelledby="home-hero-title">
	<div class="home-hero__inner container">
		<div class="home-hero__content">
			<p class="home-hero__eyebrow" aria-hidden="true">
				<span class="home-hero__spark home-hero__spark--purple"></span>
				<span class="home-hero__spark home-hero__spark--pink"></span>
			</p>

			<h1 class="home-hero__title" id="home-hero-title">
				<span><?php esc_html_e('¡Bienvenidos!', 'kulimbos'); ?></span>
			</h1>

			<p class="home-hero__subtitle">
				<?php esc_html_e('La tienda virtual que hace', 'kulimbos'); ?>
				<strong><?php esc_html_e('todo más fácil', 'kulimbos'); ?></strong>
				<?php esc_html_e('para ti y tu bebé', 'kulimbos'); ?>
			</p>

			<ul class="home-hero__benefits" aria-label="<?php esc_attr_e('Beneficios de comprar en Kulimbos', 'kulimbos'); ?>">
				<li class="home-hero__benefit home-hero__benefit--purple">
					<span class="home-hero__benefit-icon" aria-hidden="true">
						<?php kulimbos_the_icon('shopping-bag', '', 26); ?>
					</span>
					<span class="home-hero__benefit-text">
						<strong><?php esc_html_e('TODO', 'kulimbos'); ?></strong>
						<?php esc_html_e('en un solo lugar', 'kulimbos'); ?>
					</span>
				</li>
				<li class="home-hero__benefit home-hero__benefit--teal">
					<span class="home-hero__benefit-icon" aria-hidden="true">
						<span class="home-hero__clock"></span>
					</span>
					<span class="home-hero__benefit-text">
						<strong><?php esc_html_e('RÁPIDO', 'kulimbos'); ?></strong>
						<?php esc_html_e('y práctico', 'kulimbos'); ?>
					</span>
				</li>
				<li class="home-hero__benefit home-hero__benefit--gold">
					<span class="home-hero__benefit-icon" aria-hidden="true">
						<?php kulimbos_the_icon('shield-check', '', 26); ?>
					</span>
					<span class="home-hero__benefit-text">
						<strong><?php esc_html_e('CONFIABLE', 'kulimbos'); ?></strong>
						<?php esc_html_e('y seguro', 'kulimbos'); ?>
					</span>
				</li>
				<li class="home-hero__benefit home-hero__benefit--coral">
					<span class="home-hero__benefit-icon" aria-hidden="true">
						<?php kulimbos_the_icon('truck', '', 26); ?>
					</span>
					<span class="home-hero__benefit-text">
						<strong><?php esc_html_e('ENVÍOS', 'kulimbos'); ?></strong>
						<?php esc_html_e('a todo Colombia', 'kulimbos'); ?>
					</span>
				</li>
			</ul>

			<a class="home-hero__cta" href="<?php echo esc_url(home_url('/productos/')); ?>">
				<span><?php esc_html_e('¡Ver productos!', 'kulimbos'); ?></span>
				<?php kulimbos_the_icon('arrow-right', '', 20); ?>
			</a>
		</div>

		<div class="home-hero__visual" aria-hidden="true">
			<img
				class="home-hero__image"
				src="<?php echo esc_url($hero_image_url); ?>"
				alt=""
				width="1536"
				height="1024"
				fetchpriority="high"
				decoding="async">
		</div>
	</div>
</section>