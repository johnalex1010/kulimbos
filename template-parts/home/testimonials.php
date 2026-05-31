<?php

/**
 * template-parts/home/testimonials.php
 *
 * Sección de testimonios de la homepage.
 *
 * Para reemplazar avatares, agregar imágenes en:
 * assets/img/avatars/avatar-[slug].png
 *
 * @package Kulimbos
 */

defined('ABSPATH') || exit;

$testimonials = array(
	array(
		'avatar'  => 'maria',
		'name'    => 'María G.',
		'initial' => 'M',
		'rating'  => 5,
		'text'    => __('Excelente calidad y atención. Mi bebé ama su nuevo oso de peluche.', 'kulimbos'),
		'theme'   => 'purple',
	),
	array(
		'avatar'  => 'john',
		'name'    => 'Juan P.',
		'initial' => 'J',
		'rating'  => 3,
		'text'    => __('Llegó súper rápido y todo en perfecto estado. 100% recomendados.', 'kulimbos'),
		'theme'   => 'mint',
	),
	array(
		'avatar'  => 'carolina',
		'name'    => 'Carolina M.',
		'initial' => 'C',
		'rating'  => 5,
		'text'    => __('La tienda tiene todo lo que necesito para mi bebé, ¡me facilita la vida!', 'kulimbos'),
		'theme'   => 'rose',
	),
	array(
		'avatar'  => 'andres',
		'name'    => 'Andrés R.',
		'initial' => 'A',
		'rating'  => 5,
		'text'    => __('Compré ropa y productos de aseo. Todo llegó bien empacado y muy bonito.', 'kulimbos'),
		'theme'   => 'yellow',
	),
	array(
		'avatar'  => 'laura',
		'name'    => 'Laura V.',
		'initial' => 'L',
		'rating'  => 4,
		'text'    => __('Me encantó encontrar varias categorías en un solo lugar. Muy práctico para la familia.', 'kulimbos'),
		'theme'   => 'blue',
	),
);
?>

<section class="testimonials-section" aria-labelledby="testimonials-title">
	<div class="testimonials-section__inner container">
		<div class="testimonials-section__header">
			<h2 class="testimonials-section__title" id="testimonials-title">
				<?php esc_html_e('Lo que dicen nuestras mamás y papás', 'kulimbos'); ?>
				<?php kulimbos_the_icon('heart', 'testimonials-section__heart', 20); ?>
			</h2>
		</div>

		<div class="testimonials-slider" data-testimonials-slider>
			<div class="testimonials-slider__viewport" data-testimonials-viewport>
				<div class="testimonials-slider__track" data-testimonials-track>
					<?php foreach ($testimonials as $testimonial) : ?>
						<?php
						$avatar_filename = 'avatar-' . sanitize_file_name($testimonial['avatar']) . '.png';
						$avatar_path     = get_template_directory() . '/assets/img/testimonials/' . $avatar_filename;
						$avatar_url      = get_template_directory_uri() . '/assets/img/testimonials/' . $avatar_filename;
						?>
						<article class="testimonial-card testimonial-card--<?php echo esc_attr($testimonial['theme']); ?>">
							<div class="testimonial-card__quote" aria-hidden="true">“</div>

							<blockquote class="testimonial-card__text">
								<p><?php echo esc_html($testimonial['text']); ?></p>
							</blockquote>

							<footer class="testimonial-card__footer">
								<div class="testimonial-card__author">
									<span class="testimonial-card__avatar" aria-hidden="true">
										<?php if (file_exists($avatar_path)) : ?>
											<img
												src="<?php echo esc_url($avatar_url); ?>"
												alt=""
												width="56"
												height="56"
												loading="lazy"
												decoding="async">
										<?php else : ?>
											<span><?php echo esc_html($testimonial['initial']); ?></span>
										<?php endif; ?>
									</span>

									<div class="testimonial-card__meta">
										<div class="testimonial-card__rating" aria-label="<?php echo esc_attr(sprintf(__('%d de 5 estrellas', 'kulimbos'), $testimonial['rating'])); ?>">
											<?php for ($i = 0; $i < $testimonial['rating']; $i++) : ?>
												<?php kulimbos_the_icon('star', '', 25); ?>
											<?php endfor; ?>
										</div>
										<cite class="testimonial-card__name"><?php echo esc_html($testimonial['name']); ?></cite>
									</div>
								</div>
							</footer>
						</article>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="testimonials-slider__controls" aria-label="<?php esc_attr_e('Controles de testimonios', 'kulimbos'); ?>">
				<button class="testimonials-slider__arrow testimonials-slider__arrow--prev" type="button" data-testimonials-prev aria-label="<?php esc_attr_e('Testimonios anteriores', 'kulimbos'); ?>">
					<?php kulimbos_the_icon('chevron-left', '', 24); ?>
				</button>
				<button class="testimonials-slider__arrow testimonials-slider__arrow--next" type="button" data-testimonials-next aria-label="<?php esc_attr_e('Testimonios siguientes', 'kulimbos'); ?>">
					<?php kulimbos_the_icon('chevron-right', '', 24); ?>
				</button>
			</div>
		</div>
	</div>
</section>