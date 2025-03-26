<?php 

    $show_icon_information = themesflat_get_opt('show_icon_information');
    if ($show_icon_information == 1) : 
?>
    <div class="footer-information-icon-box">
        <div class="container">
            <div class="row">
            <?php if ( !empty(themesflat_get_opt( 'footer_info_text' )) && !empty(themesflat_get_opt( 'footer_info_description' ))): ?>
                <div class="col-lg-3 col-md-6 col-6 mobi-mgt30">
                    <div class="icon-infor-box">
                        <div class="icon"> <img src="<?php echo esc_url(themesflat_get_opt('footer_info_image')) ?>" alt="images"></div>
                        <div class="content">
                            <div class="title"><?php echo themesflat_get_opt('footer_info_text'); ?></div>
                            <p><?php echo themesflat_get_opt('footer_info_description'); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif;?>
            <?php if ( !empty(themesflat_get_opt( 'footer_info_text2' )) && !empty(themesflat_get_opt( 'footer_info_description2' ))): ?>
                <div class="col-lg-3 col-md-6 col-6 mobi-mgt30">
                    <div class="icon-infor-box">
                        <div class="icon"> <img src="<?php echo esc_url(themesflat_get_opt('footer_info_image2')) ?>" alt="images"></div>
                        <div class="content">
                            <div class="title"><?php echo themesflat_get_opt('footer_info_text2'); ?></div>
                            <p><?php echo themesflat_get_opt('footer_info_description2'); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif;?>
            <?php if ( !empty(themesflat_get_opt( 'footer_info_text3' )) && !empty(themesflat_get_opt( 'footer_info_description3' ))): ?>
                <div class="col-lg-3 col-md-6 col-6 mobi-mgt30">
                    <div class="icon-infor-box">
                        <div class="icon"> <img src="<?php echo esc_url(themesflat_get_opt('footer_info_image3')) ?>" alt="images"></div>
                        <div class="content">
                            <div class="title"><?php echo themesflat_get_opt('footer_info_text3'); ?></div>
                            <p><?php echo themesflat_get_opt('footer_info_description3'); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif;?>
            <?php if ( !empty(themesflat_get_opt( 'footer_info_text4' )) && !empty(themesflat_get_opt( 'footer_info_description4' ))): ?>
                <div class="col-lg-3 col-md-6 col-6 mobi-mgt30">
                    <div class="icon-infor-box">
                        <div class="icon"> <img src="<?php echo esc_url(themesflat_get_opt('footer_info_image4')) ?>" alt="images"></div>
                        <div class="content">
                            <h5><?php echo themesflat_get_opt('footer_info_text4'); ?></h5>
                            <p><?php echo themesflat_get_opt('footer_info_description4'); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif;?>
                <div class="col-md-12">
                    <div class="divide"></div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
