<?php
/**
 * @var $list_save_advanced_search
 * @var $max_num_pages
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!is_user_logged_in()) {
    tfcl_get_template_with_arguments('global/access-permission.php', array('type' => 'not_login'));
    return;
}
?>
<div class="tfcl_message"></div>
<div class="tfcl-table-listing">
    <div class="table-responsive tfcl_my_saved_advanced_search_shortcode">
        <table class="table table-mobile" id="tfcl_my_saved_advanced_search">
            <thead>
                <tr>
                    <th><?php esc_html_e('Title', 'tf-car-listing'); ?></th>
                    <th><?php esc_html_e('Parameters', 'tf-car-listing'); ?></th>
                    <th><?php esc_html_e('Email', 'tf-car-listing'); ?></th>
                    <th><?php esc_html_e('Date Published', 'tf-car-listing'); ?></th>
                    <th><?php esc_html_e('Actions', 'tf-car-listing'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$list_save_advanced_search): ?>
                    <tr>
                        <td colspan="3" class="tfcl-empty-data"> <?php esc_html_e('You don\'t have any saved advanced searchs.', 'tf-car-listing'); ?>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($list_save_advanced_search as $key => $save_search): ?>
                        <tr>
                            <td>
                                <p>
                                    <a target="_blank" title="<?php echo esc_attr($save_search->title); ?>"
                                        href="<?php echo esc_url($save_search->url_request); ?>">
                                        <?php echo esc_html($save_search->title); ?></a>
                                </p>
                            </td>
                            <td>
                                <p><?php echo base64_decode($save_search->parameters); ?></p>
                            </td>
                            <td>
                                <p><?php echo $save_search->user_email ?></p>
                            </td>
                            <td>
                                <span><?php echo esc_html(date_i18n(get_option('date_format'), strtotime($save_search->time_saved))); ?></span>
                            </td>
                            <td>
                                <?php
                                $actions['link-view'] = array( 'label' => __('View', 'tf-car-listing'), 'tooltip' => __('Link View Saved Advanced Search', 'tf-car-listing'), 'nonce' => false, 'confirm' => '', 'icon' => 'fa-link' );
                                $actions['remove']    = array( 'label' => __('Remove', 'tf-car-listing'), 'tooltip' => __('Remove Saved Advanced Search', 'tf-car-listing'), 'nonce' => true, 'confirm' => esc_html__('Are you sure want to remove this saved advanced search?', 'tf-car-listing'), 'icon' => 'fa-trash' );
    
                                foreach ($actions as $action => $value):
                                    $my_saved_advanced_search_page_link = tfcl_get_permalink('my_saved_advanced_searches_page');
                                    $action_url                         = add_query_arg(array( 'action' => $action, 'save_search_id' => $save_search->id ), $my_saved_advanced_search_page_link);
                                    if ($value['nonce']) {
                                        $action_url = wp_nonce_url($action_url, 'tfcl_my_saved_advanced_search_actions');
                                    }
                                    ?>
                                    <a  <?php if (!empty($value['confirm'])): ?>
                                        onclick="return confirm('<?php echo esc_html($value['confirm']); ?>')" 
                                        <?php endif; ?>
                                        href="<?php echo esc_url(($action === 'link-view') ? $save_search->url_request : $action_url); ?>"
                                        data-advanced-search-id="<?php echo esc_attr(intval($save_search->id)) ?>" data-toggle="tooltip"
                                        data-placement="bottom" title="<?php echo esc_attr($value['tooltip']); ?>"
                                        class="tfcl-saved-advanced-search-<?php echo esc_attr($action); ?>">
                                        <i class="fa <?php echo esc_attr($value['icon']); ?>" aria-hidden="true"></i>
                                    </a>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <?php tfcl_get_template_with_arguments('global/pagination.php', array( 'max_num_pages' => $max_num_pages )); ?>
    </div>
</div>