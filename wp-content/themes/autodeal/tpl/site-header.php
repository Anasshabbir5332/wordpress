<?php 
/**
 * @package autodeal
 */
$style_header = themesflat_get_opt('style_header');
if (themesflat_get_opt_elementor('style_header') != '') {
    $style_header = themesflat_get_opt_elementor('style_header');
}

switch ($style_header) {
    case 'header-default':
        get_template_part( 'tpl/header/header-default');
        break;
    case 'header-02':
        get_template_part( 'tpl/header/header-default');
        break;
    default:
        get_template_part( 'tpl/header/header-default');
        break;
} 
