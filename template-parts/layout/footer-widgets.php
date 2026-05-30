<?php
/**
 * template-parts/layout/footer-widgets.php
 *
 * Zona de widgets del pie de página.
 * Solo se renderiza si al menos uno de los sidebars tiene widgets activos.
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;

$has_footer_widgets = is_active_sidebar( 'footer-col-1' )
	|| is_active_sidebar( 'footer-col-2' )
	|| is_active_sidebar( 'footer-col-3' );

if ( ! $has_footer_widgets ) {
	return;
}
?>

<div class="site-footer__widgets">
	<div class="container">
		<div class="footer-widgets-grid">

			<?php if ( is_active_sidebar( 'footer-col-1' ) ) : ?>
				<div class="footer-widgets-grid__col">
					<?php dynamic_sidebar( 'footer-col-1' ); ?>
				</div>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'footer-col-2' ) ) : ?>
				<div class="footer-widgets-grid__col">
					<?php dynamic_sidebar( 'footer-col-2' ); ?>
				</div>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'footer-col-3' ) ) : ?>
				<div class="footer-widgets-grid__col">
					<?php dynamic_sidebar( 'footer-col-3' ); ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</div>
