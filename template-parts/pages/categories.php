<?php

/**
 * Contenido de la plantilla "Categorías Kulimbos".
 *
 * @package Kulimbos
 */

defined('ABSPATH') || exit;

get_template_part(
	'template-parts/pages/plushies',
	null,
	array(
		'catalog_mode' => 'all-products',
	)
);
