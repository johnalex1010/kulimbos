<?php
/**
 * Footer del tema Kulimbos.
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;

$footer_columns = array(
	array(
		'title'    => __( 'Información', 'kulimbos' ),
		'location' => 'footer_information',
		'fallback' => array(
			array(
				'label' => __( 'Quiénes somos', 'kulimbos' ),
				'url'   => home_url( '/quienes-somos/' ),
			),
			array(
				'label' => __( 'Cómo comprar', 'kulimbos' ),
				'url'   => home_url( '/como-comprar/' ),
			),
			array(
				'label' => __( 'Envíos', 'kulimbos' ),
				'url'   => home_url( '/envios/' ),
			),
		),
	),
	array(
		'title'    => __( 'Mi cuenta', 'kulimbos' ),
		'location' => 'footer_account',
		'fallback' => array(
			array(
				'label' => __( 'Iniciar sesión', 'kulimbos' ),
				'url'   => home_url( '/mi-cuenta/' ),
			),
			array(
				'label' => __( 'Mis pedidos', 'kulimbos' ),
				'url'   => home_url( '/mi-cuenta/pedidos/' ),
			),
			array(
				'label' => __( 'Mis favoritos', 'kulimbos' ),
				'url'   => home_url( '/favoritos/' ),
			),
		),
	),
	array(
		'title'    => __( 'Ayuda', 'kulimbos' ),
		'location' => 'footer_help',
		'fallback' => array(
			array(
				'label' => __( 'Centro de ayuda', 'kulimbos' ),
				'url'   => home_url( '/ayuda/' ),
			),
			array(
				'label' => __( 'Términos y condiciones', 'kulimbos' ),
				'url'   => home_url( '/terminos-y-condiciones/' ),
			),
			array(
				'label' => __( 'Política de privacidad', 'kulimbos' ),
				'url'   => home_url( '/politica-de-privacidad/' ),
			),
		),
	),
);
?>

<footer class="site-footer" role="contentinfo" itemscope itemtype="https://schema.org/WPFooter">
	<div class="site-footer__main">
		<div class="site-footer__inner container">
			<div class="site-footer__brand">
				<?php if ( has_custom_logo() ) : ?>
					<div class="site-footer__logo" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
						<?php the_custom_logo(); ?>
					</div>
				<?php else : ?>
					<a class="site-footer__site-name" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url">
						<?php bloginfo( 'name' ); ?>
					</a>
				<?php endif; ?>

				<p class="site-footer__tagline">
					<?php esc_html_e( 'Todo para tu pequeño, en un solo lugar.', 'kulimbos' ); ?>
				</p>
			</div>

			<div class="site-footer__menus">
				<?php foreach ( $footer_columns as $column ) : ?>
					<nav class="site-footer__menu-col" aria-label="<?php echo esc_attr( $column['title'] ); ?>">
						<h2 class="site-footer__menu-title"><?php echo esc_html( $column['title'] ); ?></h2>

						<?php if ( has_nav_menu( $column['location'] ) ) : ?>
							<?php
							wp_nav_menu(
								array(
									'theme_location' => $column['location'],
									'container'      => false,
									'menu_class'     => 'site-footer__menu-list',
									'depth'          => 1,
									'fallback_cb'    => false,
								)
							);
							?>
						<?php else : ?>
							<ul class="site-footer__menu-list" role="list">
								<?php foreach ( $column['fallback'] as $item ) : ?>
									<li>
										<a href="<?php echo esc_url( $item['url'] ); ?>">
											<?php echo esc_html( $item['label'] ); ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</nav>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<div class="site-footer__bottom">
		<div class="container">
			<p class="site-footer__copyright">
				&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url">
					<?php bloginfo( 'name' ); ?>
				</a>.
				<?php esc_html_e( 'Todos los derechos reservados.', 'kulimbos' ); ?>
			</p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
