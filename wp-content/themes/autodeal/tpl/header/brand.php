<?php
$logo_site = themesflat_get_opt('site_logo');
if (!empty(themesflat_get_opt_elementor('site_logo'))) {
    if (themesflat_get_opt_elementor('site_logo')['url'] != '') {
        $logo_site = themesflat_get_opt_elementor('site_logo')['url'];
    }else {
        $logo_site = themesflat_get_opt('site_logo');
    }    
}
$site_logo_fixed = themesflat_get_opt('site_logo_fixed');
if (!empty(themesflat_get_opt_elementor('site_logo_fixed'))) {
    if (themesflat_get_opt_elementor('site_logo_fixed')['url'] != '') {
        $site_logo_fixed = themesflat_get_opt_elementor('site_logo_fixed')['url'];
    }else {
        $site_logo_fixed = themesflat_get_opt('site_logo_fixed');
    }    
}
if ( $logo_site ) : ?>
    <div id="logo" class="logo" >                  
        <a href="<?php echo esc_url( home_url('/') ); ?>"  title="<?php bloginfo('name'); ?>">
            <?php if  (!empty($logo_site)) { ?>
                <img class="site-logo" width="225" height="45"  src="<?php echo esc_url($logo_site); ?>" alt="<?php bloginfo('name'); ?>"/>
                <img class="site-logo-fixed" width="225" height="45"  src="<?php echo esc_url($site_logo_fixed); ?>" alt="logo-fixed"/>
            <?php } ?>
        </a>
    </div>       
<?php endif; ?>