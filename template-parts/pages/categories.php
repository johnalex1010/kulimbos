<?php

/**
 * Contenido de la plantilla "Categorías Kulimbos".
 *
 * @package Kulimbos
 */

defined('ABSPATH') || exit;

$theme_uri = get_template_directory_uri();
$theme_dir = get_template_directory();

$hero_image = array(
	'src'    => $theme_uri . '/assets/img/hero/hero.png',
	'path'   => $theme_dir . '/assets/img/hero/hero.png',
	'alt'    => __('Productos para bebé organizados por categorías', 'kulimbos'),
	'width'  => 1536,
	'height' => 1024,
);

$categories = array(
	array(
		'image' => 'diaper',
		'label' => __('Pañales', 'kulimbos'),
		'url'   => home_url('/categoria/panales/'),
		'color' => 'teal',
	),
	array(
		'image' => 'baby-shirt',
		'label' => __('Ropa', 'kulimbos'),
		'url'   => home_url('/categoria/ropa/'),
		'color' => 'orange',
	),
	array(
		'image' => 'teddy-bear',
		'label' => __('Juguetes', 'kulimbos'),
		'url'   => home_url('/categoria/juguetes/'),
		'color' => 'warm',
	),
	array(
		'image' => 'cleaning',
		'label' => __('Aseo', 'kulimbos'),
		'url'   => home_url('/categoria/aseo/'),
		'color' => 'mint',
	),
	array(
		'image' => 'baby-bottle',
		'label' => __('Alimentación', 'kulimbos'),
		'url'   => home_url('/categoria/alimentacion/'),
		'color' => 'coral',
	),
	array(
		'image' => 'stroller',
		'label' => __('Paseo', 'kulimbos'),
		'url'   => home_url('/categoria/paseo/'),
		'color' => 'sage',
	),
	array(
		'image' => 'crib',
		'label' => __('Dormitorio', 'kulimbos'),
		'url'   => home_url('/categoria/dormitorio/'),
		'color' => 'rose',
	),
	array(
		'image' => 'baby-lock',
		'label' => __('Seguridad', 'kulimbos'),
		'url'   => home_url('/categoria/seguridad/'),
		'color' => 'purple',
	),
);

$products = array(
	array(
		'image'   => 'oso-peluche.png',
		'alt'     => __('Oso de peluche suave para bebé', 'kulimbos'),
		'name'    => __('Oso de peluche', 'kulimbos'),
		'rating'  => 4.5,
		'reviews' => 128,
		'price'   => '$79.900',
		'url'     => home_url('/productos/oso-de-peluche/'),
	),
	array(
		'image'   => 'torre-apilable.png',
		'alt'     => __('Torre apilable de colores para bebé', 'kulimbos'),
		'name'    => __('Torre apilable arcoíris', 'kulimbos'),
		'rating'  => 4.5,
		'reviews' => 96,
		'price'   => '$49.900',
		'url'     => home_url('/productos/torre-apilable/'),
	),
	array(
		'image'   => 'body-basico.png',
		'alt'     => __('Body básico manga corta para bebé', 'kulimbos'),
		'name'    => __('Body básico manga corta', 'kulimbos'),
		'rating'  => 4.5,
		'reviews' => 72,
		'price'   => '$24.900',
		'url'     => home_url('/productos/body-basico/'),
	),
	array(
		'image'   => 'set-aseo.png',
		'alt'     => __('Set de aseo completo para bebé', 'kulimbos'),
		'name'    => __('Set de aseo completo', 'kulimbos'),
		'rating'  => 4.5,
		'reviews' => 51,
		'price'   => '$59.900',
		'url'     => home_url('/productos/set-de-aseo/'),
	),
	array(
		'image'   => '',
		'alt'     => __('Espacio reservado para imagen de pañales premium', 'kulimbos'),
		'name'    => __('Pañales Premium Talla G', 'kulimbos'),
		'rating'  => 4.5,
		'reviews' => 210,
		'price'   => '$54.900',
		'url'     => home_url('/productos/panales-premium-talla-g/'),
	),
	array(
		'image'   => '',
		'alt'     => __('Espacio reservado para imagen de vaso entrenador', 'kulimbos'),
		'name'    => __('Vaso entrenador antiderrame', 'kulimbos'),
		'rating'  => 4.5,
		'reviews' => 83,
		'price'   => '$36.900',
		'url'     => home_url('/productos/vaso-entrenador-antiderrame/'),
	),
	array(
		'image'   => '',
		'alt'     => __('Espacio reservado para imagen de coche paseador', 'kulimbos'),
		'name'    => __('Coche paseador ligero', 'kulimbos'),
		'rating'  => 4.5,
		'reviews' => 67,
		'price'   => '$349.900',
		'url'     => home_url('/productos/coche-paseador-ligero/'),
	),
	array(
		'image'   => '',
		'alt'     => __('Espacio reservado para imagen de monitor de bebé', 'kulimbos'),
		'name'    => __('Monitor de bebé con cámara', 'kulimbos'),
		'rating'  => 4.5,
		'reviews' => 44,
		'price'   => '$259.900',
		'url'     => home_url('/productos/monitor-de-bebe-con-camara/'),
	),
);
?>

<section class="categories-page-hero" aria-labelledby="categories-page-title">
	<div class="categories-page-hero__inner container">
		<nav class="categories-breadcrumb" aria-label="<?php esc_attr_e('Miga de pan', 'kulimbos'); ?>">
			<ol class="categories-breadcrumb__list" role="list">
				<li>
					<a href="<?php echo esc_url(home_url('/')); ?>">
						<?php kulimbos_the_icon('home', '', 24); ?>
						<span><?php esc_html_e('Inicio', 'kulimbos'); ?></span>
					</a>
				</li>
				<li aria-current="page"><?php esc_html_e('Categorías', 'kulimbos'); ?></li>
			</ol>
		</nav>

		<div class="categories-page-hero__grid">
			<div class="categories-page-hero__content">
				<h1 class="categories-page-hero__title" id="categories-page-title">
					<?php esc_html_e('Categorías', 'kulimbos'); ?>
				</h1>
				<p class="categories-page-hero__subtitle">
					<?php esc_html_e('Encuentra todo lo que tu', 'kulimbos'); ?>
					<strong><?php esc_html_e('pequeño', 'kulimbos'); ?></strong>
					<?php esc_html_e('necesita', 'kulimbos'); ?>
				</p>
			</div>

			<div class="categories-page-hero__visual" aria-hidden="true">
				<?php if (file_exists($hero_image['path'])) : ?>
					<img
						class="categories-page-hero__image"
						src="<?php echo esc_url($hero_image['src']); ?>"
						alt=""
						width="<?php echo absint($hero_image['width']); ?>"
						height="<?php echo absint($hero_image['height']); ?>"
						fetchpriority="high"
						decoding="async">
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<section class="categories-catalog" aria-labelledby="categories-catalog-title">
	<div class="container">
		<h2 class="screen-reader-text" id="categories-catalog-title">
			<?php esc_html_e('Listado de categorías y productos', 'kulimbos'); ?>
		</h2>

		<ul class="categories-panel-grid" role="list" aria-label="<?php esc_attr_e('Categorías principales', 'kulimbos'); ?>">
			<?php foreach ($categories as $category) : ?>
				<?php
				$image_filename = sanitize_file_name($category['image']) . '.png';
				$image_path     = $theme_dir . '/assets/img/categories/' . $image_filename;
				$image_url      = $theme_uri . '/assets/img/categories/' . $image_filename;
				?>
				<li class="categories-panel-grid__item">
					<a class="category-panel category-panel--<?php echo esc_attr($category['color']); ?>" href="<?php echo esc_url($category['url']); ?>">
						<span class="category-panel__icon" aria-hidden="true">
							<?php if (file_exists($image_path)) : ?>
								<img
									src="<?php echo esc_url($image_url); ?>"
									alt=""
									width="68"
									height="68"
									loading="lazy"
									decoding="async">
							<?php endif; ?>
						</span>
						<span class="category-panel__title"><?php echo esc_html($category['label']); ?></span>
						<span class="category-panel__link"><?php esc_html_e('Ver productos', 'kulimbos'); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>

		<form class="categories-toolbar" action="<?php echo esc_url(get_permalink()); ?>" method="get">
			<p class="categories-toolbar__label"><?php esc_html_e('Filtrar por:', 'kulimbos'); ?></p>

			<label class="categories-filter">
				<span><?php esc_html_e('Ordenar', 'kulimbos'); ?></span>
				<select name="orden">
					<option value="populares"><?php esc_html_e('Más populares', 'kulimbos'); ?></option>
					<option value="recientes"><?php esc_html_e('Más recientes', 'kulimbos'); ?></option>
				</select>
			</label>

			<label class="categories-filter">
				<span><?php esc_html_e('Rango de precios', 'kulimbos'); ?></span>
				<select name="precio">
					<option value="todos"><?php esc_html_e('Todos los precios', 'kulimbos'); ?></option>
					<option value="bajo"><?php esc_html_e('Menos de $50.000', 'kulimbos'); ?></option>
					<option value="alto"><?php esc_html_e('Más de $50.000', 'kulimbos'); ?></option>
				</select>
			</label>

			<label class="categories-filter">
				<span><?php esc_html_e('Edad recomendada', 'kulimbos'); ?></span>
				<select name="edad">
					<option value="todas"><?php esc_html_e('Todas las edades', 'kulimbos'); ?></option>
					<option value="0-12"><?php esc_html_e('0 a 12 meses', 'kulimbos'); ?></option>
					<option value="12-36"><?php esc_html_e('1 a 3 años', 'kulimbos'); ?></option>
				</select>
			</label>

			<label class="categories-filter">
				<span><?php esc_html_e('Disponibilidad', 'kulimbos'); ?></span>
				<select name="disponibilidad">
					<option value="todos"><?php esc_html_e('Todos', 'kulimbos'); ?></option>
					<option value="disponibles"><?php esc_html_e('Disponibles', 'kulimbos'); ?></option>
				</select>
			</label>

			<p class="categories-toolbar__count"><?php esc_html_e('Mostrando 1-12 de 96 productos', 'kulimbos'); ?></p>
			<div class="categories-toolbar__views" aria-label="<?php esc_attr_e('Vista del listado', 'kulimbos'); ?>">
				<button class="is-active" type="button" aria-label="<?php esc_attr_e('Ver en cuadrícula', 'kulimbos'); ?>">
					<?php kulimbos_the_icon('package', '', 20); ?>
				</button>
				<button type="button" aria-label="<?php esc_attr_e('Ver en lista', 'kulimbos'); ?>">
					<?php kulimbos_the_icon('menu', '', 20); ?>
				</button>
			</div>
		</form>

		<ul class="product-grid categories-products-grid" role="list">
			<?php foreach ($products as $product) : ?>
				<?php
				$product_image_path = $product['image'] ? $theme_dir . '/assets/img/products/' . sanitize_file_name($product['image']) : '';
				$product_image_url  = $product['image'] ? $theme_uri . '/assets/img/products/' . sanitize_file_name($product['image']) : '';
				?>
				<li class="product-card">
					<div class="product-card__image-wrap">
						<?php if ($product_image_path && file_exists($product_image_path)) : ?>
							<img
								class="product-card__image"
								src="<?php echo esc_url($product_image_url); ?>"
								alt="<?php echo esc_attr($product['alt']); ?>"
								width="400"
								height="400"
								loading="lazy"
								decoding="async">
						<?php else : ?>
							<div class="product-card__image product-card__image--placeholder" role="img" aria-label="<?php echo esc_attr($product['alt']); ?>">
								<span><?php esc_html_e('Imagen del producto', 'kulimbos'); ?></span>
							</div>
						<?php endif; ?>
						<button class="product-card__wishlist" type="button" aria-label="<?php echo esc_attr(sprintf(__('Agregar %s a favoritos', 'kulimbos'), $product['name'])); ?>">
							<?php kulimbos_the_icon('heart', '', 25); ?>
						</button>
					</div>

					<div class="product-card__body">
						<h3 class="product-card__name">
							<a href="<?php echo esc_url($product['url']); ?>">
								<?php echo esc_html($product['name']); ?>
							</a>
						</h3>

						<div class="product-card__rating" aria-label="<?php echo esc_attr(sprintf(__('Calificación: %s de 5', 'kulimbos'), $product['rating'])); ?>">
							<?php
							$full_stars = (int) floor($product['rating']);
							$half_star  = ($product['rating'] - $full_stars) >= 0.5;
							for ($i = 0; $i < 5; $i++) :
								$star_class = $i < $full_stars ? 'star--full' : ($i === $full_stars && $half_star ? 'star--half' : 'star--empty');
							?>
								<span class="star <?php echo esc_attr($star_class); ?>" aria-hidden="true">
									<?php kulimbos_the_icon('star', '', 24); ?>
								</span>
							<?php endfor; ?>
							<span class="product-card__reviews">(<?php echo absint($product['reviews']); ?>)</span>
						</div>

						<div class="product-card__footer">
							<span class="product-card__price"><?php echo esc_html($product['price']); ?></span>
							<button class="product-card__add-to-cart" type="button" aria-label="<?php echo esc_attr(sprintf(__('Agregar %s al carrito', 'kulimbos'), $product['name'])); ?>">
								<?php kulimbos_the_icon('shopping-cart', '', 25); ?>
							</button>
						</div>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="categories-help" aria-label="<?php esc_attr_e('Ayuda para elegir productos', 'kulimbos'); ?>">
	<div class="categories-help__inner container">
		<div class="categories-help__intro">
			<h2><?php esc_html_e('¿No sabes qué elegir?', 'kulimbos'); ?></h2>
			<p><?php esc_html_e('Te ayudamos a encontrar lo mejor para tu bebé.', 'kulimbos'); ?></p>
			<a class="categories-help__cta" href="<?php echo esc_url(home_url('/guia-de-compra/')); ?>">
				<span><?php esc_html_e('Ver guía de compra', 'kulimbos'); ?></span>
				<?php kulimbos_the_icon('chevron-right', '', 18); ?>
			</a>
		</div>

		<ul class="categories-help__benefits" role="list">
			<li>
				<?php kulimbos_the_icon('smile', '', 44); ?>
				<strong><?php esc_html_e('Asesoría personalizada', 'kulimbos'); ?></strong>
				<span><?php esc_html_e('Te ayudamos en lo que necesites', 'kulimbos'); ?></span>
			</li>
			<li>
				<?php kulimbos_the_icon('shield-check', '', 44); ?>
				<strong><?php esc_html_e('Compra segura', 'kulimbos'); ?></strong>
				<span><?php esc_html_e('Protegemos tus datos y tu compra', 'kulimbos'); ?></span>
			</li>
			<li>
				<?php kulimbos_the_icon('truck', '', 44); ?>
				<strong><?php esc_html_e('Envíos a todo Colombia', 'kulimbos'); ?></strong>
				<span><?php esc_html_e('Rápidos y confiables', 'kulimbos'); ?></span>
			</li>
		</ul>
	</div>
</section>