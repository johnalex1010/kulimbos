<footer class="site-footer" role="contentinfo" itemscope itemtype="https://schema.org/WPFooter">

	<?php get_template_part( 'template-parts/layout/footer-widgets' ); ?>

	<div class="site-footer__bottom">
		<div class="container">
			<p class="site-footer__copyright">
				&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url">
					<?php bloginfo( 'name' ); ?>
				</a>.
				<?php esc_html_e( 'Todos los derechos reservados.', 'kulimbos' ); ?>
			</p>

			<?php
			wp_nav_menu(
				array(
					'theme_location'  => 'footer',
					'container'       => 'nav',
					'container_class' => 'site-footer__nav',
					'container_id'    => 'footer-navigation',
					'menu_class'      => 'footer-nav__list',
					'depth'           => 1,
					'fallback_cb'     => false,
				)
			);
			?>
		</div>
	</div>

</footer>

<?php wp_footer(); ?>
</body>
</html>
