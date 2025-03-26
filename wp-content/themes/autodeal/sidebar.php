<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package autodeal
 */
?>

<?php  
	$sidebar = themesflat_get_opt( 'blog_sidebar_list' );
	if ( is_page() ) {			
		$sidebar = themesflat_get_opt( 'page_sidebar_list' );			
	}	
	if ( is_search() ) {			
		$sidebar = themesflat_get_opt( 'blog_sidebar_list' );			
	}
	
 	?>
	<div id="secondary" class="widget-area sidebar-single-listing" role="complementary">
		<div class="overlay-sidebar"></div>
		<div class="tfcl_single_sidebar">
			<span class="btn-toggle-sidebar">
				<i class="icon-autodeal-icon-157"></i>
			</span>
			<div class="inner">
				<div class="sidebar">
					<?php	  
	    			    themesflat_dynamic_sidebar ( $sidebar ); 
					?>
				</div>
			</div>
		</div>

	</div><!-- #secondary -->
	<?php
?>