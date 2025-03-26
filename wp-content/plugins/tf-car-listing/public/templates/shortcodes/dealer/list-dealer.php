<?php
wp_enqueue_style( 'dealer-style' );
wp_enqueue_script( 'dealer-script' );

$list_order = array(
	'date_esc'  => esc_html__( 'Sort by (Defaut)', 'tf-car-listing' ),
	'name_desc' => esc_html__( 'Sort by name (Z-A)', 'tf-car-listing' ),
	'name_asc'  => esc_html__( 'Sort by name (A-Z)', 'tf-car-listing' ),
);

tfcl_get_template_with_arguments(
	'shortcodes/dealer/list-dealer-elements/list-dealer-content.php',
	array(
		'heading'       => $heading,
		'list_dealer'   => $list_dealer,
		'list_order'    => $list_order,
		'max_num_pages' => $max_num_pages
	)
);