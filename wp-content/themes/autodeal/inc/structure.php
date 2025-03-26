<?php
if ( ! function_exists( 'themesflat_body_classes' ) ) {
	add_filter( 'body_class', 'themesflat_body_classes' );

	function themesflat_body_classes( $classes ) {	
		$custom_page_class = themesflat_meta('custom_page_class');

		$classes[] = $custom_page_class;


		return $classes;
	}
}