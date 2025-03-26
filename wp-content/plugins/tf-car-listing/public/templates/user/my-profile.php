<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
wp_enqueue_script( 'dashboard-js' );
wp_enqueue_style( 'dashboard-css' );
wp_enqueue_style( 'shortcode-listing-css' );
if ( ! is_user_logged_in() ) {
	tfcl_get_template_with_arguments( 'global/access-permission.php', array( 'type' => 'not_login' ) );
	return;
}

$is_dealer                = tfcl_is_dealer();
$user_can_become_dealer   = tfcl_get_option( 'user_can_become_dealer', 'y' );
$show_hide_profile_fields = tfcl_get_option( 'show_hide_profile_fields', array() );
?>

<div class="tfcl-my-profile">
	<h1><?php esc_html_e( 'Edit profile', 'tf-car-listing' ); ?></h1>
    <div class="tfcl_profile-form">
        <form class="tfcl_profile" method="post" enctype="multipart/form-data" id="tfcl_profile-form">
            <div class="error_message tfcl_message"></div>
            <div class="tfcl_become_dealer">
                <h3 class="form-title"><?php esc_html_e( 'Become Dealer', 'tf-car-listing' ); ?></h3>
                <div class="error_message tfcl_dealer_message"></div>
                <?php
				$message       = '';
				$dealer_id     = get_the_author_meta( 'author_dealer_id', $user_data['user_id'] );
				$dealer_status = get_post_status( $dealer_id );
	
				if ( ! $is_dealer && ! $dealer_id ) {
					$message = esc_html__( 'Your current account type is normal. If you want to become a dealer, please click on button Become a Dealer', 'tf-car-listing' );
				} else {
					if ( $dealer_status == 'publish' ) {
						$message = esc_html__( 'Your current account type is set to dealer, if you want to remove your dealer account, and return to normal account, you must click the button below', 'tf-car-listing' );
					} else {
						$message = esc_html__( 'Your account need to be approved by admin to become a dealer, if you want to return to normal account, you must click the button below', 'tf-car-listing' );
					}
				}
				?>

                <div class="tfcl-message alert alert-warning" role="alert"><?php echo wp_kses_post( $message ); ?></div>
                <?php if ( ! $is_dealer && ! $dealer_id ) : ?>
                <button type="button" class="btn_become_dealer" id="tfcl_become_dealer">
                    <span><?php esc_html_e( 'Become a Dealer', 'tf-car-listing' ); ?></span>
                </button>
                <?php else : ?>
                <button type="button" class="btn_remove_dealer" id="tfcl_remove_dealer">
                    <span>
                        <?php esc_html_e( 'Remove dealer account', 'tf-car-listing' ); ?>
                    </span>
                </button>
                <?php endif; ?>
            </div>
            <h3 class="form-title"><?php esc_html_e( 'Avatar', 'tf-car-listing' ); ?></h3>
            <div class="tfcl_choose_avatar">
                <div class="avatar">
                    <div class="form-group">
                        <?php
						$width             = tfcl_get_option( 'avatar_size_w', '158' );
						$height            = tfcl_get_option( 'avatar_size_h', '138' );
						$image_src         = $user_data['user_avatar'];
						$no_avatar         = get_avatar_url( $user_data['user_id'] );
						$default_image_src = tfcl_get_option( 'default_user_avatar', '' )['url'] != '' ? tfcl_get_option( 'default_user_avatar', '' )['url'] : $no_avatar;
						?>
                        <img loading="lazy" width="<?php echo esc_attr( $width ); ?>"
                            height="<?php echo esc_attr( $height ); ?>" id="tfcl_avatar_thumbnail"
                            src="<?php echo $image_src; ?>"
                            onerror="this.src = '<?php echo esc_url( $default_image_src ) ?>';"
                            alt="<?php esc_attr_e( 'avatar', 'tf-car-listing' ); ?>">
                    </div>
                    <div class="choose-box">
                        <label><?php esc_html_e( 'Upload a new Avatar', 'tf-car-listing' ); ?></label>
                        <div class="form-group">
                            <input type="file" hidden class="form-control" id="tfcl_avatar" name="profile_image"
                                value="<?php echo $user_data['user_avatar'] ?>">
                            <button id="btnBrowse" type="button"
                                onclick="document.getElementById('tfcl_avatar').click();">
                                <?php esc_html_e( 'Choose file', 'tf-car-listing' ); ?></button>
                            <input type="text" id="txtPath"
                                placeholder="<?php esc_html_e( 'No file Choose', 'tf-car-listing' ); ?>"
                                value="<?php echo $user_data['user_avatar_name'] ?>" />
                        </div>
                        <span
                            class="notify-avatar"><?php esc_html_e( 'PNG, JPG, SVG dimension (400 * 400) max file not more then size 4 mb', 'tf-car-listing' ); ?></span>
                    </div>
                </div>
            </div>

            <?php if ( $user_data['dealer_id'] != '' && tfcl_is_dealer() ) : ?>
            <h3 class="form-title"><?php esc_html_e( 'Dealer Poster', 'tf-car-listing' ); ?></h3>
            <div class="tfcl_choose_dealer_poster">
                <div class="dealer_poster">
                    <div class="form-group">
                        <?php
							$poster_width          = '350';
							$poster_height         = '200';
							$no_avatar             = get_avatar_url( $user_data['user_id'] );
							$default_poster        = tfcl_get_option( 'default_user_avatar', '' )['url'] != '' ? tfcl_get_option( 'default_user_avatar', '' )['url'] : $no_avatar;
							$default_dealer_poster = '';
							if ( ! empty( $default_poster ) ) {
								$default_dealer_poster = tfcl_image_resize_url( $default_poster, $width, $height, true )['url'];
							}
							$dealer_poster_src = $user_data['dealer_poster'] != '' ? $user_data['dealer_poster'] : $default_dealer_poster;
							?>
                        <img loading="lazy" width="<?php echo esc_attr( $poster_width ); ?>"
                            height="<?php echo esc_attr( $poster_height ); ?>" id="tfcl_dealer_poster_thumb"
                            src="<?php echo $dealer_poster_src; ?>"
                            onerror="this.src = '<?php echo esc_url( $default_dealer_poster ) ?>';"
                            alt="<?php esc_attr_e( 'Poster', 'tf-car-listing' ); ?>">
                    </div>
                </div>
                <div class="choose-box">
                    <label><?php esc_html_e( 'Upload dealer poster:', 'tf-car-listing' ); ?></label>
                    <div class="form-group">
                        <input type="file" class="form-control" id="tfcl_dealer_poster" name="dealer_poster"
                            value="<?php echo $user_data['dealer_poster'] ?>">
							<button id="btnBrowse" type="button"
                                onclick="document.getElementById('tfcl_dealer_poster').click();">
                                <?php esc_html_e( 'Choose file', 'tf-car-listing' ); ?></button>
                    </div>
                    <span
                        class="notify-dealer-poster"><?php esc_html_e( 'JPG dimension (300 * 350)', 'tf-car-listing' ); ?></span>
                </div>
            </div>
            <?php endif; ?>

            <h3 class="form-title"><?php esc_html_e( 'User Information', 'tf-car-listing' ); ?></h3>
            <div class="tfcl-form-group user-form row">
                <?php if ( $show_hide_profile_fields["first_name"] == 1 ) : ?>
                <div class="inner-form col-lg-6 col-md-12">
                    <label
                        for="first_name"><?php echo esc_html_e( 'First name ', 'tf-car-listing' ) . tfcl_required_field( 'first_name', 'require_profile_fields' ); ?></label>
                    <input type="text" class="form-control" name="first_name" id="first_name"
                        value="<?php echo $user_data['first_name'] ?>"
                        placeholder="<?php esc_html_e( 'First name', 'tf-car-listing' ) ?>">
                </div>
                <?php endif; ?>
                <?php if ( $show_hide_profile_fields["last_name"] == 1 ) : ?>
                <div class="inner-form col-lg-6 col-md-12">
                    <label
                        for="last_name"><?php echo esc_html_e( 'Last name ', 'tf-car-listing' ) . tfcl_required_field( 'last_name', 'require_profile_fields' ); ?></label>
                    <input type="text" class="form-control" name="last_name" id="last_name"
                        value="<?php echo $user_data['last_name'] ?>"
                        placeholder="<?php esc_html_e( 'Last name', 'tf-car-listing' ) ?>">
                </div>
                <?php endif; ?>

                <?php if ( $show_hide_profile_fields["user_description"] == 1 ) : ?>
                <div class="inner-form col-md-12 description">
                    <label
                        for="description"><?php echo esc_html_e( 'Description ', 'tf-car-listing' ) . tfcl_required_field( 'user_description', 'require_profile_fields' ); ?></label>
                    <textarea id="description"
                        name="user_description"><?php echo $user_data['user_description'] ?></textarea>
                </div>
                <?php endif; ?>

                <?php if ( $show_hide_profile_fields["user_phone"] == 1 ) : ?>
                <div class="inner-form col-xl-3 col-lg-6 col-md-6">
                    <label
                        for="user_phone"><?php echo esc_html_e( 'Phone ', 'tf-car-listing' ) . tfcl_required_field( 'user_phone', 'require_profile_fields' ); ?></label>
                    <input type="text" class="form-control" name="user_phone" id="user_phone"
                        value="<?php echo $user_data['user_phone'] ?>"
                        placeholder="<?php esc_html_e( '+8801739495504', 'tf-car-listing' ) ?>">
                </div>
                <?php endif; ?>

                <?php if ( $is_dealer ) : ?>
                <?php if ( $show_hide_profile_fields["user_sales_phone"] == 1 ) : ?>
                <div class="inner-form col-xl-3 col-lg-6 col-md-6">
                    <label
                        for="user_sales_phone"><?php echo esc_html_e( 'Sales Phone ', 'tf-car-listing' ) . tfcl_required_field( 'user_sales_phone', 'require_profile_fields' ); ?></label>
                    <input type="text" class="form-control" name="user_sales_phone" id="user_sales_phone"
                        value="<?php echo $user_data['user_sales_phone'] ?>"
                        placeholder="<?php esc_html_e( '+8801739495504', 'tf-car-listing' ) ?>">
                </div>
                <?php endif; ?>
                <?php endif; ?>

                <?php if ( $show_hide_profile_fields["user_email"] == 1 ) : ?>
                <div class="inner-form col-xl-3 col-lg-6 col-md-6">
                    <label
                        for="user_email"><?php echo esc_html_e( 'Email address ', 'tf-car-listing' ) . tfcl_required_field( 'user_email', 'require_profile_fields' ); ?></label>
                    <input type="text" class="form-control" name="user_email" id="user_email"
                        value="<?php echo $user_data['user_email'] ?>"
                        placeholder="<?php esc_html_e( 'Useronly@gmail.com', 'tf-car-listing' ) ?>">
                </div>
                <?php endif; ?>

                <?php if ( $is_dealer ) : ?>
                <?php if ( $show_hide_profile_fields["user_company"] == 1 ) : ?>
                <div class="inner-form col-xl-3 col-lg-6 col-md-6">
                    <label
                        for="user_company"><?php echo esc_html_e( 'Company ', 'tf-car-listing' ) . tfcl_required_field( 'user_company', 'require_profile_fields' ); ?></label>
                    <input type="text" class="form-control" name="user_company" id="user_company"
                        value="<?php echo $user_data['user_company'] ?>">
                </div>
                <?php endif; ?>
                <?php if ( $show_hide_profile_fields["user_position"] == 1 ) : ?>
                <div class="inner-form col-xl-3 col-lg-6 col-md-6">
                    <label
                        for="user_position"><?php echo esc_html_e( 'Position ', 'tf-car-listing' ) . tfcl_required_field( 'user_position', 'require_profile_fields' ); ?></label>
                    <input type="text" class="form-control" name="user_position" id="user_position"
                        value="<?php echo $user_data['user_position'] ?>">
                </div>
                <?php endif; ?>
                <?php endif; ?>

				<?php if ( $show_hide_profile_fields["user_location"] == 1 ) : ?>
                <div class="inner-form col-lg-12">
                    <label
                        for="description"><?php echo esc_html_e( 'Location ', 'tf-car-listing' ) . tfcl_required_field( 'user_location', 'require_profile_fields' ); ?></label>
                    <input type="text" class="form-control" name="user_location" id="location"
                        value="<?php echo $user_data['user_location'] ?>">
                </div>
                <?php endif; ?>

				<?php if ( $show_hide_profile_fields["user_website"] == 1 ) : ?>
                <div class="inner-form col-lg-12">
                    <label
                        for="user_website"><?php echo esc_html_e( 'Website ', 'tf-car-listing' ) . tfcl_required_field( 'user_website', 'require_profile_fields' ); ?></label>
                    <input type="text" class="form-control" name="user_website" id="user_website"
                        value="<?php echo $user_data['user_website'] ?>">
                </div>
                <?php endif; ?>

                <?php if ( $is_dealer ) : ?>
                <?php if ( $show_hide_profile_fields["user_sales_hour"] == 1 ) : ?>
                <div class="inner-form col-md-12">
                    <label
                        for="user_sales_hour"><?php echo esc_html_e( 'Business Hours', 'tf-car-listing' ) . tfcl_required_field( 'user_sales_hour', 'require_profile_fields' ); ?></label>
                    <textarea type="text" name="user_sales_hour" id="user_sales_hour">
                    <?php echo $user_data['user_sales_hour'] ?>
                    </textarea>
                </div>
                <?php endif; ?>
                <?php endif; ?>

            </div>

            <h3 class="form-title"><?php esc_html_e( 'Social Profile Link', 'tf-car-listing' ); ?></h3>
            <div class="tfcl-form-group user-form row">
                <?php if ( $show_hide_profile_fields["user_facebook"] == 1 ) : ?>
                <div class="inner-form col-lg-6 col-md-12">
                    <label
                        for="user_facebook"><?php echo esc_html_e( 'Facebook', 'tf-car-listing' ) . tfcl_required_field( 'user_facebook', 'require_profile_fields' ); ?></label>
                    <input type="text" class="form-control" name="user_facebook" id="user_facebook"
                        value="<?php echo $user_data['user_facebook'] ?>"
                        placeholder="<?php esc_html_e( 'www.facebook.com/username', 'tf-car-listing' ) ?>">
                </div>
                <?php endif; ?>
                <?php if ( $show_hide_profile_fields["user_instagram"] == 1 ) : ?>
                <div class="inner-form col-lg-6 col-md-12">
                    <label
                        for="user_instagram"><?php echo esc_html_e( 'Instagram', 'tf-car-listing' ) . tfcl_required_field( 'user_instagram', 'require_profile_fields' ); ?></label>
                    <input type="text" class="form-control" name="user_instagram" id="user_instagram"
                        value="<?php echo $user_data['user_instagram'] ?>"
                        placeholder="<?php esc_html_e( 'www.instagram.com/username', 'tf-car-listing' ) ?>">
                </div>
                <?php endif; ?>
                <?php if ( $show_hide_profile_fields["user_twitter"] == 1 ) : ?>
                <div class="inner-form col-lg-6 col-md-12">
                    <label
                        for="user_twitter"><?php echo esc_html_e( 'Twitter', 'tf-car-listing' ) . tfcl_required_field( 'user_twitter', 'require_profile_fields' ); ?></label>
                    <input type="text" class="form-control" name="user_twitter" id="user_twitter"
                        value="<?php echo $user_data['user_twitter'] ?>"
                        placeholder="<?php esc_html_e( 'www.twitter.com/username', 'tf-car-listing' ) ?>">
                </div>
                <?php endif; ?>
                <?php if ( $show_hide_profile_fields["user_dribble"] == 1 ) : ?>
                <div class="inner-form col-lg-6 col-md-12">
                    <label
                        for="user_dribble"><?php echo esc_html_e( 'Dribble', 'tf-car-listing' ) . tfcl_required_field( 'user_dribble', 'require_profile_fields' ); ?></label>
                    <input type="text" class="form-control" name="user_dribble" id="user_dribble"
                        value="<?php echo $user_data['user_dribble'] ?>"
                        placeholder="<?php esc_html_e( 'www.dribble.com/username', 'tf-car-listing' ) ?>">
                </div>
                <?php endif; ?>
                <?php if ( $show_hide_profile_fields["user_linkedin"] == 1 ) : ?>
                <div class="inner-form col-lg-6 col-md-12">
                    <label
                        for="user_linkedin"><?php echo esc_html_e( 'Linkedin', 'tf-car-listing' ) . tfcl_required_field( 'user_linkedin', 'require_profile_fields' ); ?></label>
                    <input type="text" class="form-control" name="user_linkedin" id="user_linkedin"
                        value="<?php echo $user_data['user_linkedin'] ?>"
                        placeholder="<?php esc_html_e( 'www.linkedin.com/username', 'tf-car-listing' ) ?>">
                </div>
                <?php endif; ?>
                <?php if ( $show_hide_profile_fields["user_skype"] == 1 ) : ?>
                <div class="inner-form col-lg-6 col-md-12">
                    <label
                        for="user_skype"><?php echo esc_html_e( 'Skype', 'tf-car-listing' ) . tfcl_required_field( 'user_skype', 'require_profile_fields' ); ?></label>
                    <input type="text" class="form-control" name="user_skype" id="user_skype"
                        value="<?php echo $user_data['user_skype'] ?>"
                        placeholder="<?php esc_html_e( '@skype.me/username', 'tf-car-listing' ) ?>">
                </div>
                <?php endif; ?>
                <?php if ( $show_hide_profile_fields["user_youtube"] == 1 ) : ?>
                <div class="inner-form col-lg-6 col-md-12">
                    <label
                        for="user_youtube"><?php echo esc_html_e( 'Youtube', 'tf-car-listing' ) . tfcl_required_field( 'user_youtube', 'require_profile_fields' ); ?></label>
                    <input type="text" class="form-control" name="user_youtube" id="user_youtube"
                        value="<?php echo $user_data['user_youtube'] ?>"
                        placeholder="<?php esc_html_e( 'www.youtube.com/username', 'tf-car-listing' ) ?>">
                </div>
                <?php endif; ?>
                <?php if ( $show_hide_profile_fields["user_vimeo"] == 1 ) : ?>
                <div class="inner-form col-lg-6 col-md-12">
                    <label
                        for="user_vimeo"><?php echo esc_html_e( 'Vimeo', 'tf-car-listing' ) . tfcl_required_field( 'user_vimeo', 'require_profile_fields' ); ?></label>
                    <input type="text" class="form-control" name="user_vimeo" id="user_vimeo"
                        value="<?php echo $user_data['user_vimeo'] ?>"
                        placeholder="<?php esc_html_e( 'www.vimeo.com/username', 'tf-car-listing' ) ?>">
                </div>
                <?php endif; ?>
                <?php if ( $show_hide_profile_fields["user_pinterest"] == 1 ) : ?>
                <div class="inner-form col-lg-6 col-md-12">
                    <label
                        for="user_pinterest"><?php echo esc_html_e( 'Pinterest', 'tf-car-listing' ) . tfcl_required_field( 'user_pinterest', 'require_profile_fields' ); ?></label>
                    <input type="text" class="form-control" name="user_pinterest" id="user_pinterest"
                        value="<?php echo $user_data['user_pinterest'] ?>"
                        placeholder="<?php esc_html_e( 'www.pinterest.com/username', 'tf-car-listing' ) ?>">
                </div>
                <?php endif; ?>
                <?php if ( $show_hide_profile_fields["user_tiktok"] == 1 ) : ?>
                <div class="inner-form col-lg-6 col-md-12">
                    <label
                        for="user_tiktok"><?php echo esc_html_e( 'TikTok', 'tf-car-listing' ) . tfcl_required_field( 'user_tiktok', 'require_profile_fields' ); ?></label>
                    <input type="text" class="form-control" name="user_tiktok" id="user_tiktok"
                        value="<?php echo $user_data['user_tiktok'] ?>"
                        placeholder="<?php esc_html_e( 'www.tiktok.com/username', 'tf-car-listing' ) ?>">
                </div>
                <?php endif; ?>
            </div>

            <button id="tfcl_profile_submit" type="submit"
                class="button">
                <span><?php esc_html_e( 'Save & Update', 'tf-car-listing' ); ?></span>
            </button>
            <button id="tfcl_profile_reset" type="reset"
                class="button"><?php esc_html_e( 'Reset All', 'tf-car-listing' ); ?></button>
        </form>
        <?php tfcl_get_template_with_arguments( 'user/change-password.php' ); ?>
    </div>
</div>