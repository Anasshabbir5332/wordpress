<?php
wp_enqueue_style( 'dealer-style' );
wp_enqueue_script( 'dealer-script' );
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
get_header();
$enable_dealer_sidebar = tfcl_get_option( 'archive_dealer_sidebar' );
$sidebar_position      = tfcl_get_option( 'archive_dealer_sidebar_position' );
?>
<div class="tfcl-dealer-archive-wrap <?php echo esc_attr( $enable_dealer_sidebar == 'enable' ? 'has-sidebar ' : '' ); ?>">
	<div class="dealers-archive <?php echo esc_attr( $sidebar_position ? $sidebar_position : '' ); ?>">
		<div class="container">
			<div class="row">
				<div class="list-dealer-content <?php echo esc_attr( $enable_dealer_sidebar == 'enable' ? 'col-xl-8 col-md-12' : 'col-md-12' ); ?>">
					<?php if ( is_post_type_archive( 'dealer' ) ) : ?>
						<?php echo do_shortcode( '[list_dealer]' ); ?>
					<?php endif; ?>
				</div>
				<?php if ( $enable_dealer_sidebar == 'enable' && is_active_sidebar( 'archive-dealer-sidebar' ) ) : ?>
					<div class="col-xl-4 col-md-12 archive-dealer-sidebar">
						<?php dynamic_sidebar( 'archive-dealer-sidebar' ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php
get_footer();