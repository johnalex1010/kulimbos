<?php
/**
 * template-parts/home/newsletter.php
 *
 * Sección de suscripción al newsletter.
 * El form envía por AJAX cuando se implemente la integración de email.
 * Por ahora hace POST al endpoint de WordPress.
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="newsletter-section" aria-labelledby="newsletter-title">
	<div class="container">
		<div class="newsletter-section__inner">

			<div class="newsletter-section__icon" aria-hidden="true">
				<?php kulimbos_the_icon( 'mail', '', 48 ); ?>
			</div>

			<div class="newsletter-section__content">
				<h2 class="newsletter-section__title" id="newsletter-title">
					<?php esc_html_e( '¡Suscríbete y recibe lo mejor!', 'kulimbos' ); ?>
				</h2>
				<p class="newsletter-section__desc">
					<?php esc_html_e( 'Ofertas exclusivas, novedades y tips para tu bebé.', 'kulimbos' ); ?>
				</p>
			</div>

			<form
				class="newsletter-section__form"
				id="newsletter-form"
				method="post"
				action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"
				novalidate
			>
				<input type="hidden" name="action" value="kulimbos_newsletter">
				<?php wp_nonce_field( 'kulimbos_newsletter_nonce', 'newsletter_nonce' ); ?>

				<label class="screen-reader-text" for="newsletter-email">
					<?php esc_html_e( 'Tu correo electrónico', 'kulimbos' ); ?>
				</label>

				<input
					class="newsletter-section__input"
					id="newsletter-email"
					type="email"
					name="email"
					placeholder="<?php esc_attr_e( 'Ingresa tu correo electrónico', 'kulimbos' ); ?>"
					required
					autocomplete="email"
				>

				<button class="btn btn--primary newsletter-section__btn" type="submit">
					<?php esc_html_e( 'Suscribirme', 'kulimbos' ); ?>
				</button>

				<p class="newsletter-section__feedback" id="newsletter-feedback" aria-live="polite" hidden></p>

			</form>

		</div>
	</div>
</section>
