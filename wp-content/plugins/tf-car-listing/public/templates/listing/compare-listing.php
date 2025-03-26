<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$enable_compare = tfcl_get_option( 'enable_compare', 'y' );
TFCL_Compare::tfcl_open_session();
$listing_ids = ! empty( $_SESSION['tfcl_compare_listings'] ) ? $_SESSION['tfcl_compare_listings'] : '';
?>
<?php if ( $enable_compare == 'y' ) : ?>
	<div id="compare_listing_wrap" class="<?php echo esc_attr( empty( $listing_ids ) ? 'compare-listing-hidden' : '' ) ?> ">
		<div id="tfcl-compare-listings" class="compare-listing ">
			<?php do_action( 'tfcl_show_compare' ); ?>
		</div>
	</div>
<?php endif; ?>