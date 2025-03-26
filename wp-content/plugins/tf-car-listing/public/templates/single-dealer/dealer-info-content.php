<?php
$width          = 872;
$height         = 496;
$no_poster_src  = TF_PLUGIN_URL . 'includes/elementor-widget/assets/images/no-image.jpg';
$default_avatar = tfcl_get_option( 'default_user_avatar', '' );
if ( is_array( $default_avatar ) && $default_avatar['url'] != '' ) {
	$no_poster_src = tfcl_image_resize_url( $default_avatar['url'], $width, $height, true )['url'];
}
$poster_id  = get_post_thumbnail_id( $dealer_id );
$poster_src = tfcl_image_resize_id( $poster_id, $width, $height, true );
?>

<div class="dealer-author">
	<?php if ( ! empty( $poster_src ) ) : ?>
		<div class="dealer-author-avatar">
			<img loading="lazy" width="<?php echo esc_attr( $width ) ?>" height="<?php echo esc_attr( $height ) ?>"
				src="<?php echo esc_url( $poster_src ) ?>" onerror="this.src = '<?php echo esc_url( $no_poster_src ) ?>';"
				alt="<?php echo esc_attr( $dealer_full_name ) ?>" title="<?php echo esc_attr( $dealer_full_name ) ?>">
		</div>
	<?php endif; ?>
</div>
<?php if ( ! empty( $dealer_description ) ) : ?>
	<div class="dealer-description">
		<h3 class="dealer-title"><?php echo sprintf( '%1s %2s',esc_html__( 'About', 'tf-car-listing' ), $dealer_full_name  ); ?></h3>
		<p><?php echo wp_kses_post( $dealer_description ) ?></p>
	</div>
<?php endif; ?>
