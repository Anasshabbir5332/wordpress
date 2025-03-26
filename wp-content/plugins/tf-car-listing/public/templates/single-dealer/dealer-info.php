<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
wp_enqueue_style( 'dealer-style' );
wp_enqueue_script( 'dealer-script' );
?>
<div class="single-dealer-element dealer-single">
	<div class="dealer-single-inner row">
		<div class="col-md-12">
			<div class="dealer-single-info-top">
				<div class="info-top-left">
					<h2 class="dealer-heading"><?php esc_html_e( $dealer_full_name, 'tf-car-listing' ); ?></h2>
					<div class="dealer-address">
						<i class="icon-autodeal-pin1"></i>
						<span>
							<?php esc_html_e( ! empty( $dealer_office_address ) ? $dealer_office_address : 'no data', 'tf-car-listing' ); ?>
						</span>
					</div>
				</div>
				<?php if ( ! empty( $dealer_logo ) ) : ?>
					<div class="info-top-right">
						<?php
						$dealer_logo     = json_decode( $dealer_logo, true );
						$dealer_logo_src = tfcl_image_resize_id( $dealer_logo[0], 236, 60, true );
						?>
						<img loading="lazy" src="<?php echo esc_attr( $dealer_logo_src ); ?>" alt="<?php esc_attr_e( 'logo', 'tf-car-listing' ); ?>">
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>