<?php

/**
 * template-parts/home/benefits-bar.php
 *
 * Barra intermedia de beneficios debajo del hero.
 *
 * @package Kulimbos
 */

defined('ABSPATH') || exit;

$benefits = array(
	array(
		'icon'  => 'heart',
		'title' => __('Hecho con ', 'kulimbos'),
		'mark'  => __('amor', 'kulimbos'),
		'desc'  => __('para cada etapa de su crecimiento', 'kulimbos'),
		'color' => 'primary',
	),
	array(
		'icon'  => 'smile',
		'title' => __('Productos de calidad', 'kulimbos'),
		'mark'  => '',
		'desc'  => __('para los momentos que importan', 'kulimbos'),
		'color' => 'accent',
	),
	array(
		'icon'  => 'star',
		'title' => __('Para bebés y niños', 'kulimbos'),
		'mark'  => '',
		'desc'  => __('desde 0 hasta 6 años', 'kulimbos'),
		'color' => 'secondary',
	),
);
?>

<section class="benefits-bar" aria-label="<?php esc_attr_e('Beneficios de Kulimbos', 'kulimbos'); ?>">
	<div class="benefits-bar__inner container">
		<ul class="benefits-bar__list" role="list">
			<?php foreach ($benefits as $benefit) : ?>
				<li class="benefits-bar__item benefits-bar__item--<?php echo esc_attr($benefit['color']); ?>">
					<span class="benefits-bar__icon" aria-hidden="true">
						<?php kulimbos_the_icon($benefit['icon'], '', 80); ?>
					</span>
					<p class="benefits-bar__text">
						<strong class="benefits-bar__title">
							<?php echo esc_html($benefit['title']); ?>
							<?php if ('' !== $benefit['mark']) : ?>
								<span><?php echo esc_html($benefit['mark']); ?></span>
							<?php endif; ?>
						</strong>
						<span class="benefits-bar__desc"><?php echo esc_html($benefit['desc']); ?></span>
					</p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>