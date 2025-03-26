<?php 
// ADD SECTION FOOTER
$wp_customize->add_section('section_footer',array(
    'title'         => 'Footer',
    'priority'      => 1,
    'panel'         => 'footer_panel',
));
require THEMESFLAT_DIR . "inc/customizer/footer/footer.php";

// ADD SECTION BOTTOM
$wp_customize->add_section('section_bottom',array(
    'title'         => 'Bottom',
    'priority'      => 2,
    'panel'         => 'footer_panel',
)); 
require THEMESFLAT_DIR . "inc/customizer/footer/bottom.php";

// ADD SECTION ICON INFORMATION
$wp_customize->add_section('section_icon_infor',array(
    'title'         => 'Icon Information',
    'priority'      => 3,
    'panel'         => 'footer_panel',
));
require THEMESFLAT_DIR . "inc/customizer/footer/icon-information.php";