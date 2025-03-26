;(function($) {
    "use strict";

    jQuery(document).ready(function(){
        //Header
        elementor.settings.page.addChangeCallback( 'style_header', handleReloadPreview );
        elementor.settings.page.addChangeCallback( 'style_topbar', handleReloadPreview );
        elementor.settings.page.addChangeCallback( 'site_logo', handleReloadPreview );
        elementor.settings.page.addChangeCallback( 'topbar_show', handleReloadPreview );
        elementor.settings.page.addChangeCallback( 'header_absolute', handleReloadPreview );
        elementor.settings.page.addChangeCallback( 'header_sticky', handleReloadPreview );
        elementor.settings.page.addChangeCallback( 'header_sidebar_toggler', handleReloadPreview );

        //Page
        elementor.settings.page.addChangeCallback( 'sidebar_layout', handleReloadPreview );
        
    });

    function handleReloadPreview ( newValue ) {
        elementor.saver.saveEditor({
            status: elementor.settings.page.model.get('post_status'),
            onSuccess: () => {
                elementor.reloadPreview();

                elementor.once("preview:loaded", function() {
                    elementor.getPanelView().setPage("page_settings");
                });
            }
        })
    }

})(jQuery);