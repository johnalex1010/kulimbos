<?php
/**
 * template-parts/layout/header-navigation.php
 *
 * Navegación principal del sitio.
 * El toggle del menú móvil es controlado por assets/js/main.js.
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;
?>

<nav class="site-nav" id="site-navigation" role="navigation"
	aria-label="<?php esc_attr_e( 'Menú principal', 'kulimbos' ); ?>"
	itemscope itemtype="https://schema.org/SiteNavigationElement">

	<?php
	wp_nav_menu(
		array(
			'theme_location'  => 'primary',
			'container'       => false,
			'menu_id'         => 'primary-menu-list',
			'menu_class'      => 'site-nav__list',
			'depth'           => 2,
			'fallback_cb'     => false,
			'items_wrap'      => '<ul id="%1$s" class="%2$s" role="list">%3$s</ul>',
		)
	);
	?>

</nav>
