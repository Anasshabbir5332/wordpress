<?php
/**
 * @var $search_form_position
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$search_fields                        = tfcl_get_option( 'search_filter_fields' );
$archive_listing_search_form_position = ! empty( $search_form_position ) ? $search_form_position : tfcl_get_option( 'archive_listing_search_form_position' );
if ( $archive_listing_search_form_position == 'side' ) :
	?>
	<div class="search-filter-wrap">
		<div class="search-filter-inner">
			<?php if ( !empty(tfcl_get_option( 'text_title_sidebar_form')) ) : ?>
			<h4 class="search-filter-title"><?php echo tfcl_get_option( 'text_title_sidebar_form'); ?></h4>
			<?php endif; ?>
			<form method="get" action="" id="search_filter_form" class="search-listing-form">
				<div class="btn-close-popup"><i class="icon-autodeal-close"></i></div>
				<div class="search-form-content">
					<?php render_search_filter_fields( $search_fields, true ); ?>
				</div>
			</form>
		</div>
	</div>
<?php endif; ?>