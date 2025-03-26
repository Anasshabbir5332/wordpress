<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package autodeal
 */


/**
 * Prints HTML with meta information for the current post-date/time, post categories and author.
 */

 function themesflat_widget_layout($columns) {
	$layout = array();
	switch ($columns) {
		case 2:
			$layout = array(6,6);
			break;
		case 3:
			$layout = array(4,4,4);
			break;
		case 4:
			$layout = array(3,3,3,3);
			break;
		default:
			$layout = array(3,3,3,3);
			break;
		
	}
	return $layout;
}

if ( ! function_exists( 'themesflat_posted_category' ) ) :
function themesflat_posted_category( $layout = '' ) { 	
	if ( has_category() ) {
		echo '<div class="post-categories">'.esc_html__("In - ",'autodeal');
			the_category( ', ' );
		echo '</div>';
	}	
}
endif;

if ( ! function_exists( 'themesflat_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function themesflat_entry_footer() {
	// Hide category and tag text for pages.
	$tags_links = '';
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', ' ' );
		if ( $tags_list && is_single() ) {
			$tags_links = sprintf( '<div class="tags-links"><h5>' . esc_html__( 'Tags: ', 'autodeal' ) . '</h5>' . esc_html__( ' %1$s', 'autodeal' ) . '</div>', $tags_list  );

		}			
	}

	?>
	<div class="entry-footer">
		<?php 
			printf($tags_links); 
			themesflat_social_single();
		?>
	</div>
	<?php

}
endif;