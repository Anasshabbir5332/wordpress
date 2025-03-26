<?php 
add_filter( 'elementor/icons_manager/additional_tabs', 'themesflat_iconpicker_register' );

function themesflat_iconpicker_register( $icons = array() ) {
	
	$icons['theme_icon'] = array(
		'name'          => 'theme_icon',
		'label'         => esc_html__( 'Theme Icons autodeal', 'themesflat-core' ),
		'labelIcon'     => 'icon-autodeal-thumbtacks',
		'prefix'        => '',
		'displayPrefix' => '',
		'url'           => THEMESFLAT_LINK . 'css/icon-autodeal.css',
		'fetchJson'     => URL_THEMESFLAT_ADDONS_ELEMENTOR_THEME . 'assets/css/autodeal_fonts_default.json',
		'ver'           => '1.0.0',
	);

	return $icons;
}