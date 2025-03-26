<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package autodeal
 */
?>        
        </div><!-- #content -->
    </div><!-- #main-content -->

    <!-- Start Footer -->   
    <div class="footer_background <?php echo themesflat_get_opt_elementor('extra_classes_footer'); ?>">
        <div class="overlay-footer"></div>

        <!-- Footer infomation box -->
        <?php get_template_part( 'tpl/icon-information'); ?>

        <!-- Footer Widget -->
        <?php get_template_part( 'tpl/footer/footer-widgets'); ?>

        <!-- Bottom -->
        <?php get_template_part( 'tpl/footer/bottom'); ?>
        
    </div> <!-- Footer Background Image --> 
    <!-- End Footer --> 

</div><!-- /#boxed -->
<?php wp_footer(); ?>
</body>
</html>