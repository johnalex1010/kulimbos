<?php
/**
 * template-parts/components/button.php
 *
 * Componente de botón reutilizable.
 *
 * Uso:
 *   kulimbos_component( 'button', array(
 *       'text'    => 'Ver más',
 *       'url'     => get_permalink(),
 *       'class'   => 'btn--primary',
 *       'target'  => '_blank',
 *       'aria'    => 'Ver más sobre el proyecto X',
 *       'element' => 'a',   // 'a' o 'button'
 *   ) );
 *
 * @package Kulimbos
 */

defined( 'ABSPATH' ) || exit;

// Valores por defecto del componente.
$text    = isset( $args['text'] ) ? $args['text'] : __( 'Ver más', 'kulimbos' );
$url     = isset( $args['url'] ) ? $args['url'] : '#';
$class   = isset( $args['class'] ) ? $args['class'] : 'btn--primary';
$target  = isset( $args['target'] ) ? $args['target'] : '_self';
$aria    = isset( $args['aria'] ) ? $args['aria'] : '';
$element = isset( $args['element'] ) && 'button' === $args['element'] ? 'button' : 'a';

// Atributos extra del elemento según su tipo.
$rel         = '_blank' === $target ? 'rel="noopener noreferrer"' : '';
$aria_label  = $aria ? sprintf( 'aria-label="%s"', esc_attr( $aria ) ) : '';
$type_attr   = 'button' === $element ? 'type="button"' : '';

if ( 'a' === $element ) :
?>
<a
	href="<?php echo esc_url( $url ); ?>"
	class="btn <?php echo esc_attr( $class ); ?>"
	target="<?php echo esc_attr( $target ); ?>"
	<?php echo $rel; // phpcs:ignore — solo contiene rel= sin datos externos. ?>
	<?php echo $aria_label; // phpcs:ignore — escapado con esc_attr arriba. ?>
>
	<?php echo esc_html( $text ); ?>
</a>
<?php else : ?>
<button
	class="btn <?php echo esc_attr( $class ); ?>"
	<?php echo $type_attr; // phpcs:ignore — valor hardcoded seguro. ?>
	<?php echo $aria_label; // phpcs:ignore — escapado con esc_attr arriba. ?>
>
	<?php echo esc_html( $text ); ?>
</button>
<?php
endif;
