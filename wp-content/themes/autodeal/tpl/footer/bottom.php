<?php
if (themesflat_get_opt('show_bottom') == 1):     
    ?> 
    <div id="bottom" class="bottom">
        <div class="container">           
            <div class="row">
                <div class="col-md-12">
                    <div class="container-inside">
                        <div class="inner">
                        <div class="wrap-logo-footer">
                            <img class="logo-footer" width="225" height="45"  src="<?php echo esc_url(themesflat_get_opt('site_logo_footer')); ?>" alt="logo-footer"/>
                        </div>
                        </div> 
                        <div class="inner right">
                            <div class="copyright">                     
                                <span><?php echo wp_kses(themesflat_get_opt( 'footer_copyright'), themesflat_kses_allowed_html()); ?></span>
                            </div>
                            <?php if (themesflat_get_opt('social_bottom') == 1): ?> 
                                <div class="bottom-social">
                                    <?php themesflat_render_social();   ?>
                                </div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div>
<?php endif; ?>