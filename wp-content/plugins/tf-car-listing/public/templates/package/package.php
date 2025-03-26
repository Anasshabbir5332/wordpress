<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
wp_enqueue_style( 'tf-pricetable' );
wp_enqueue_style( 'dashboard-css' );
$package_currency_sign     = tfcl_get_option( 'package_currency_sign', '$' );
$package_currency_position = tfcl_get_option( 'package_currency_sign_position', 'before' );
?>
<div class="package-wrap-table">
	<div class="package-wrap row">
		<?php
		$args          = array(
			'post_type'      => 'package',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'meta_value_num',
			'meta_key'       => 'package_order_display',
			'order'          => 'ASC',
			'meta_query'     => array(
				array(
					'key'     => 'package_visible',
					'value'   => '0',
					'compare' => '='
				)
			)
		);
		$packages      = new WP_Query( $args );
		$total_records = $packages->found_posts;
		if ( $total_records == 4 ) {
			$css_class = 'col-md-3 col-sm-6';
		} else if ( $total_records == 3 ) {
			$css_class = 'col-md-4 col-sm-6';
		} elseif ( $total_records == 2 ) {
			$css_class = 'col-md-4 col-sm-6';
		} elseif ( $total_records == 1 ) {
			$css_class = 'col-md-4 col-sm-12';
		} else {
			$css_class = 'col-md-3 col-sm-6';
		}
		while ( $packages->have_posts() ) {
			$packages->the_post();
			$package_id    = get_the_ID();
			$package_price = get_post_meta( $package_id, 'package_price', true );
			$package_free  = get_post_meta( $package_id, 'package_free', true );
			if ( $package_free == 1 ) {
				$package_price = 0;
			}
			if ( $package_currency_position == 'before' ) {
				$package_price = '<span class="price-type">' . esc_html( $package_currency_sign ) . '</span><span class="price">' . tfcl_get_format_number( floatval( $package_price ) ) . '</span>';
			} else {
				$package_price = '<span class="price">' . tfcl_get_format_number( floatval( $package_price ) ) . '</span><span class="price-type">' . esc_html( $package_currency_sign ) . '</span>';
			}
			$package_unlimited_listing = get_post_meta( $package_id, 'package_unlimited_listing', true );
			$package_number_listing    = get_post_meta( $package_id, 'package_number_listing', true );
			$package_unlimited_time    = get_post_meta( $package_id, 'package_unlimited_time', true );
	
			if ( $package_unlimited_time == 1 ) {
				$package_time_unit         = esc_html__('Never Expires', 'tf-car-listing');
				$package_time_unit_content = $package_time_unit;
			} else {
				$package_time_unit        = get_post_meta( $package_id, 'package_time_unit', true );
				$package_number_time_unit = get_post_meta( $package_id, 'package_number_time_unit', true );
				if ( $package_number_time_unit > 1 ) {
					$package_time_unit .= 's';
				}
				$package_time_unit_content = ( ! empty( $package_number_time_unit ) ? $package_number_time_unit : 0 ) . ' ' . $package_time_unit;
			}
	
			if ( $package_unlimited_listing == 1 ) {
				$package_number_listing = esc_html__('Unlimited', 'tf-car-listing');
			} else {
				$package_number_listing = ( ! empty( $package_number_listing ) && $package_number_listing > 0 ) ? $package_number_listing : 0;
			}
	
			$package_number_listing_content = $package_number_listing;
	
			$package_popular       = get_post_meta( $package_id, 'package_popular', true );
			$package_visible       = get_post_meta( $package_id, 'package_visible', true );
			$package_order_display = get_post_meta( $package_id, 'package_order_display', true );
	
			if ( $package_popular == 1 ) {
				$is_popular = 'setactive';
			} else {
				$is_popular = 'noactive';
			}
	
			$payment_link         = tfcl_get_permalink( 'payment_invoice_page' );
			$payment_process_link = add_query_arg( 'package_id', $package_id, $payment_link );
			?>
			<div class="<?php echo esc_attr( $css_class ); ?>">
				<div class="tf-pricetable <?php echo esc_attr( $is_popular ); ?>">
					<div class="header-price">
						<div class="title">
							<?php esc_html_e( get_the_title( $package_id ) ); ?>
						</div>
						<div class="content-price">
							<?php echo __( $package_price ); ?>
						</div>
					</div>
					<div class=" content-list">
						<div class="inner-content-list">
							<div class="item">
								<span class="wrap-icon"><i class="icon-autodeal-icon-144"></i></span>
								<span class="text"><?php echo sprintf( __( 'Active Listing Quota: <strong>%s</strong>', 'tf-car-listing' ), $package_number_listing_content );
								?></span>
							</div>
							<div class="item">
								<span class="wrap-icon"><i class="icon-autodeal-icon-144"></i></span>
								<span
									class="text"><?php echo sprintf( __( 'Expiration Date: <strong>%s</strong>', 'tf-car-listing' ), $package_time_unit_content ); ?></span>
							</div>
						</div>
					</div>
					<div class="wrap-button">
						<a href="<?php echo esc_url( $payment_process_link ); ?>"
							class="tf-btn"><?php esc_html_e( 'Get Started', 'tf-car-listing' ); ?></a>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php wp_reset_postdata(); ?>
	</div>
</div>