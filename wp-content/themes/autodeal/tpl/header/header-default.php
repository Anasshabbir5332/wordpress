<?php 
$topbar = themesflat_get_opt('topbar_show');
if (themesflat_get_opt_elementor('topbar_show') != '') {
    $topbar = themesflat_get_opt_elementor('topbar_show');
}
$topbar_email = themesflat_get_opt('information_email');
$topbar_phone = themesflat_get_opt('information_phone');
$topbar_address = themesflat_get_opt('information_address');
$topbar_datetime = themesflat_get_opt('information_datetime');
$topbar_label_address = themesflat_get_opt('topbar_label_address');
$social_topbar = themesflat_get_opt('social_topbar');
$topbar_address_active = themesflat_get_opt('topbar_address_active');
$topbar_date_active = themesflat_get_opt('topbar_date_active');
$topbar_phone_active = themesflat_get_opt('topbar_phone_active');
$header_search_box = themesflat_get_opt('header_search_box');
$header_button = themesflat_get_opt('header_button');
$header_button_text = themesflat_get_opt('header_button_text');
$header_button_url = themesflat_get_opt('header_button_url');
$infor_menu_mobile_show = themesflat_get_opt('infor_menu_mobile_show');

global $current_user;
wp_get_current_user();
$user_first 		= !empty($current_user->first_name) ? $current_user->first_name : '';
$user_last 		    = !empty($current_user->last_name) ? $current_user->last_name : '';
$user_fullname = $user_first.' '.$user_last;
?>

<?php if ($topbar == 1) : ?>
<!-- Topbar -->
<div class="themesflat-top style-01">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="container-inside">
                            <div class="content-left">
                                <?php if ($topbar_address_active == 1 || $topbar_phone_active || $topbar_date_active == 1) : ?>
                                    <div class="infor-topbar">
                                        <ul class="list-infor-topbar">
                                            <?php if ($topbar_address_active == 1):?>
			                                    <li><i class="icon-autodeal-map"></i><?php echo esc_html($topbar_address); ?></li>
                                            <?php endif; ?>
                                            <?php if ($topbar_date_active == 1 ):?>
			                                    <li><i class="icon-autodeal-date"></i><?php echo esc_html($topbar_datetime); ?></li>
                                            <?php endif; ?>
                                            <?php if ($topbar_phone_active == 1 ):?>
			                                    <li><a href="tel:<?php echo esc_attr($topbar_phone); ?>"><i class="icon-autodeal-mobile"></i><?php echo esc_html($topbar_phone); ?></a></li>
                                            <?php endif; ?>
		                                </ul>
                                    </div>
                                <?php endif; ?>
                            </div><!-- content-left -->
                            <div class="content-right">
                                <div class="social-topbar">
                                    <?php
                                    if ($social_topbar == 1) :?>
                                        <span><?php esc_html_e('Follow us:', 'autodeal'); ?></span>
                                       <?php themesflat_render_social(); ?>
                                   <?php endif;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.container -->
</div><!-- /.topbar -->
<?php endif; ?>

<header id="header" class="header header-default <?php echo themesflat_get_opt_elementor('extra_classes_header'); ?>">
    <div class="inner-header">  
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="header-wrap clearfix">
                        <div class="header-ct-left">
                            <?php get_template_part( 'tpl/header/brand'); ?>
                        </div>
                        <div class="header-ct-center">
                            <div class="inner-center">
                                <?php get_template_part( 'tpl/header/navigator'); ?>
                            </div>
                        </div>
                    <?php if( $header_search_box == 1 || $header_button == 1 || themesflat_get_opt('header_user')): ?>
                        <div class="header-ct-right">
                        <?php if ( $header_search_box == 1 ) :?>
                                <div class="show-search">
                                    <a href="#"><i class="icon-autodeal-icon-1"></i></a>        
                                </div> 
                        <?php endif;?>

                    <?php if (themesflat_get_opt('header_favorite') == 1): ?>
                        <?php if (class_exists('Widget_Login_Menu')): ?>
                            <a href="<?php echo esc_url(tfcl_get_permalink( 'my_favorites_page' )); ?>" class="tfcl-header-favorite"><i class="icon-autodeal-icon-130"></i></a>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if (themesflat_get_opt('header_user') == 1): ?>
                        <?php if (is_user_logged_in()): ?>
                            <?php if (class_exists('Widget_Login_Menu')): ?>
                                <?php the_widget('Widget_Login_Menu'); ?>
                            <?php endif; ?>
                        <?php else: ?>
                        <div class="login-header">
                            <ul>
                                <li><span class="display-pop-login register"><?php esc_html_e('Register', 'autodeal'); ?></span></li>
                                <li><span class="display-pop-login login"><?php esc_html_e('Login', 'autodeal'); ?></span></li>
                            </ul>
                        </div>
                        <?php endif; ?>
                    <?php endif;?>
                        <?php if ( $header_button == 1 ) :?>
                            <a href="<?php echo get_permalink ( get_theme_mod ( 'header_button_url' )); ?>" class="tf-btn <?php if(!is_user_logged_in()) echo 'display-pop-login'; ?>"><?php echo wp_kses($header_button_text, themesflat_kses_allowed_html()); ?><span></span></a> 
                        <?php endif;?>
                                                          
                            </div>
                    <?php endif; ?>
                    <div class="btn-menu">
                        <span class="line-1"></span>
                    </div><!-- //mobile menu button -->
                    </div>                
                </div><!-- /.col-md-12 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div>

    <div class="canvas-nav-wrap">
        <div class="overlay-canvas-nav"><div class="canvas-menu-close"><span></span></div></div>
        <div class="inner-canvas-nav">
            <div class="group-header-logo">
                <?php get_template_part( 'tpl/header/brand-mobile'); ?>
            </div>

            <div class="bottom-canvas-nav">
                <nav id="mainnav_canvas" class="mainnav_canvas" role="navigation">
                    <?php
                        wp_nav_menu( array( 'theme_location' => 'primary', 'fallback_cb' => 'themesflat_menu_fallback', 'container' => false ) );
                    ?>
                </nav><!-- #mainnav_canvas -->
                <?php if ( $infor_menu_mobile_show == 1 ) :?>
                <div class="information-menu-mobile">
                    <h5><?php esc_html_e('Contact Us', 'autodeal'); ?></h5>
                    <ul>
                        <li>
                            <div class="icon"><i class="icon-autodeal-icon-145"></i></div>
                            <div class="content">
                                <p><?php esc_html_e('Call us:', 'autodeal'); ?></p>
                                <a href="tel:<?php echo esc_attr($topbar_phone); ?>"><?php echo esc_html($topbar_phone); ?></a>
                            </div>
                        </li>
                        <li>
                            <div class="icon"><i class="icon-autodeal-icon-146"></i></div>
                            <div class="content">
                                <p><?php esc_html_e('Email:', 'autodeal'); ?></p>
                                <?php echo esc_html($topbar_email); ?>
                            </div>
                        </li>
                    </ul>
                </div>
                <?php endif;?>
            </div>


        </div>
    </div><!-- /.canvas-nav-wrap --> 
</header><!-- /.header --> 

