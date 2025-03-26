<?php
$tab_footer = themesflat_get_opt('tab_footer'); 
if (themesflat_get_opt('show_footer') == 1):
?> 
    <footer id="footer" class="footer <?php (themesflat_meta( 'footer_class' ) != "" ? esc_attr( themesflat_meta( 'footer_class' ) ):'') ;?>">
        <div class="footer-widgets <?php echo esc_attr($tab_footer == 1 ? 'menu-tab-footer' : '');  ?>">
            <div class="container">                
                <div class="row">
                    <?php                            
                    $footer_widget_areas = themesflat_get_opt('footer_widget_areas');
                    $columns = themesflat_widget_layout($footer_widget_areas); 
                    $key = 0;
                        foreach ($columns as $key => $column) {
                            $key = $key +1;
                            ?>
                            <div class="col-lg-<?php  echo esc_attr($column);?> col-md-6 widgets-areas areas-<?php  echo esc_attr($key);?>">
                                <div class="wrap-widgets wrap-widgets-<?php  echo esc_attr($key);?>">
                                <?php                                         
                                    $widget = themesflat_get_opt("footer".$key);
                                    if ( is_active_sidebar($widget) ) {
                                        themesflat_dynamic_sidebar($widget);       
                                    } else {
                                        echo'<a class="widgets-fallback" href="' . esc_url(admin_url('widgets.php')) . '">' . esc_html__( "Please Add Items in Widget Area", 'autodeal' ) . '</a>';
                                    }
                                ?>
                                </div>
                            </div>
                    <?php } ?> 

                </div><!-- /.row -->                  
            </div><!-- /.container --> 
        </div><!-- /.footer-widgets -->
    </footer>
<?php endif; ?>
