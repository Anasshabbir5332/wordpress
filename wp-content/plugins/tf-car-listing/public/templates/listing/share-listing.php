<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$listing_id   = get_the_ID();
$sl_url       = get_permalink( $listing_id );
$facebookURL  = TF_PLUGIN_PROTOCOL . '://www.facebook.com/sharer/sharer.php?u=' . $sl_url;
$tweetURL     = TF_PLUGIN_PROTOCOL . '://twitter.com/intent/tweet?url=' . $sl_url;
$linkedinURL  = TF_PLUGIN_PROTOCOL . '://www.linkedin.com/shareArticle?mini=true&amp;url=' . $sl_url;
$pinterestURL = TF_PLUGIN_PROTOCOL . '://pinterest.com/pin/create/bookmarklet/?url=' . $sl_url;
$skypeURL     = TF_PLUGIN_PROTOCOL . '://web.skype.com/share?url=' . $sl_url;
$whatsappURL     = TF_PLUGIN_PROTOCOL . '://wa.me/?text=' . $sl_url;
$telegramURL     = TF_PLUGIN_PROTOCOL . '://telegram.me/share/url?url=' . $sl_url;
?>
<div class="dropdown">
	<a href="#" class="tfcl-listing-share hv-tool dropdown-toggle" data-toggle="dropdown"
		data-tooltip="<?php esc_attr_e('Share', 'tf-car-listing'); ?>"><i class="icon-autodeal-icon-171"></i></a>
	<div class="dropdown-menu">
		<ul>
			<li><a href="<?php echo esc_attr( $facebookURL ) ?>" class="menu-social" target="_blank"><i
						class="icon-autodeal-facebook"></i> Facebook</a></li>
			<li><a href="<?php echo esc_attr( $tweetURL ) ?>" class="menu-social" target="_blank"><i
						class="icon-autodeal-twitter"></i> Twitter</a></li>
			<li><a href="<?php echo esc_attr( $linkedinURL ) ?>" class="menu-social" target="_blank"><i
						class="icon-autodeal-linkedin"></i> Linkedin</a></li>
			<li><a href="<?php echo esc_attr( $pinterestURL ) ?>" class="menu-social" target="_blank"><i
						class="icon-autodeal-pinterest"></i> Pinterest</a></li>
			<li><a href="<?php echo esc_attr( $skypeURL ) ?>" class="menu-social" target="_blank"><i class="icon-autodeal-skype"></i>
					Skype</a></li>
		</ul>
	</div>
</div>