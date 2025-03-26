<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $post;
$listing_id = get_the_ID();
$author_id  = $post->post_author;
$dealer_id  = ! empty( get_post_meta( $listing_id, 'listing_dealer_info', true ) ) ? get_post_meta( $listing_id, 'listing_dealer_info', true ) : get_the_author_meta( 'author_dealer_id', $author_id );
if ( isset( $dealer_id ) && ! empty( $dealer_id ) ) {
	$dealer_post_meta_data = get_post_custom( $dealer_id );
	$full_name             = get_the_title( $dealer_id );
	$email                 = isset( $dealer_post_meta_data['dealer_email'] ) ? $dealer_post_meta_data['dealer_email'][0] : '';
	$phone                 = isset( $dealer_post_meta_data['dealer_phone_number'] ) ? $dealer_post_meta_data['dealer_phone_number'][0] : '';
	$author_id             = get_post_field( 'post_author', $dealer_id );
} else {
	$first_name = get_the_author_meta( 'first_name', $author_id );
	$last_name  = get_the_author_meta( 'last_name', $author_id );
	$full_name  = $first_name . ' ' . $last_name;
	$email      = get_the_author_meta( 'user_email', $author_id );
	$phone      = get_the_author_meta( 'user_phone', $author_id );
}
$avatar = get_the_author_meta( 'profile_image_id', $author_id );
?>
<div class="contact-listing-form">
	<div class="author-contact-wrap">
		<div class="author-contact-avatar">
			<?php
			$width              = tfcl_get_option( 'avatar_size_w', '103' );
			$height             = tfcl_get_option( 'avatar_size_h', '103' );
			$avatar_src         = tfcl_image_resize_id( $avatar, '103', '103', true );
			$no_avatar          = get_avatar_url( $author_id );
			$default_avatar_src = tfcl_get_option( 'default_user_avatar', '' )['url'] != '' ? tfcl_get_option( 'default_user_avatar', '' )['url'] : $no_avatar;
			?>
			<img loading="lazy" width="<?php echo esc_attr( $width ) ?>" height="<?php echo esc_attr( $height ) ?>"
				src="<?php echo esc_attr( $avatar_src ) ?>"
				onerror="this.src = '<?php echo esc_url( $default_avatar_src ) ?>';"
				alt="<?php echo esc_attr( $full_name ); ?>" title="<?php echo esc_attr( $full_name ); ?>">
		</div>
		<div class="author-contact-info">
			<?php if ( ! empty( $full_name ) ) : ?>
				<h4 class="name"> <?php echo esc_html( $full_name ); ?> </h4>
				<p class="desc"><?php esc_html_e( 'Owner of listing', 'tf-car-listing' ); ?></p>
			<?php endif; ?>
			<?php if ( tfcl_get_option( 'show_hide_dealer_information' )['user_phone'] == 1 && ( ! empty( $phone ) ) ) : ?>
				<div class="group-phone">
					<input type="hidden" class="full_number_phone" data-fullnumber="<?php echo esc_attr( $phone ); ?>">
					<?php echo sprintf( '<i class="fas fa-phone-alt"></i> <span class="phone-number sale_phone_text">%s</span> <a href="#" class="phone show_number_btn" >(%s)</a>', esc_html__( $phone ), esc_html__( 'Show', 'tf-car-listing' ) ); ?>
				</div>
			<?php endif; ?>
			<?php if ( tfcl_get_option( 'show_hide_dealer_information' )['user_email'] == 1 && ( ! empty( $email ) ) ) : ?>
				<a href="mailto:<?php echo esc_html( $email ); ?>" class="email"> <i class="fas fa-envelope"></i>
					<?php echo esc_html( $email ); ?> </a>
			<?php endif; ?>
		</div>
	</div>
</div>