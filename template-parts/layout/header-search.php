<?php
/**
 * template-parts/layout/header-search.php
 *
 * Barra de búsqueda del header.
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="header-search">
	<form class="header-search__form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label class="screen-reader-text" for="header-search-input">
			<?php esc_html_e( 'Buscar productos', 'kulimbos' ); ?>
		</label>
		<input
			class="header-search__input"
			id="header-search-input"
			type="search"
			name="s"
			placeholder="<?php esc_attr_e( 'Buscar productos, marcas y más...', 'kulimbos' ); ?>"
			value="<?php echo esc_attr( get_search_query() ); ?>"
			autocomplete="off"
		>
		<button class="header-search__btn" type="submit" aria-label="<?php esc_attr_e( 'Buscar', 'kulimbos' ); ?>">
			<?php kulimbos_the_icon( 'search', '', 20 ); ?>
		</button>
	</form>
</div>
