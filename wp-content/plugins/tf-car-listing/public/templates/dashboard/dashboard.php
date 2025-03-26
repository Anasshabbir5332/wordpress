<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! is_user_logged_in() ) {
	tfcl_get_template_with_arguments( 'global/access-permission.php', array( 'type' => 'not_login' ) );
	return;
}
wp_enqueue_script( 'dashboard-js' );
wp_enqueue_style( 'dashboard-css' );
wp_enqueue_script( 'chart' );
global $current_user;
$current_user_id              = $current_user->ID;
$listing_public               = new Car_Listing();
$my_listing_page              = tfcl_get_permalink( 'my_listing_page' );
$my_listing_publish_page      = $my_listing_page ? add_query_arg( array( 'post_status' => 'publish' ), $my_listing_page ) : '';
$my_listing_pending_page      = $my_listing_page ? add_query_arg( array( 'post_status' => 'pending' ), $my_listing_page ) : '';
$my_favorite_page             = tfcl_get_permalink( 'my_favorites_page' );
$my_review_page               = tfcl_get_permalink( 'my_reviews_page' );
$prop_enable_short_price_unit = tfcl_get_option( 'enable_short_price_unit', 0 ) == 1 ? true : false;
?>
<div class="tfcl-dashboard">
	<h1 class="admin-title"><?php esc_html_e( 'Dashboard', 'tf-car-listing' ); ?></h1>
	<div class="tfcl-dashboard-overview">
		<div class="row">
			<div class="col-sm-6 col-xl-3">
				<a class="tfcl-card" href="<?php echo esc_url( $my_listing_publish_page ) ?>">
					<div class="card-body">
						<div class="tfcl-icon-overview">
							<i class="icon-autodeal-checklist"></i>
						</div>
						<div class="content-overview">
							<h5><?php esc_html_e( 'My Listing', 'tf-car-listing' ); ?></h5>
							<div class="tfcl-dashboard-title">
								<div class="listing-text">
									<?php echo sprintf( __( '<b>%d</b>', 'tf-car-listing' ), $publish_listing_by_user ); ?>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-sm-6 col-xl-3">
				<a class="tfcl-card" href="<?php echo esc_url( $my_listing_pending_page ) ?>">
					<div class="card-body">
						<div class="tfcl-icon-overview">
							<i class="icon-autodeal-icon-182"></i>
						</div>
						<div class="content-overview">
							<h5><?php esc_html_e( 'Pending', 'tf-car-listing' ); ?></h5>
							<div class="tfcl-dashboard-title">
								<span><?php echo sprintf( __( '<b>%d</b>', 'tf-car-listing' ), $pending_listings ); ?></span>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-sm-6 col-xl-3">
				<a class="tfcl-card" href="<?php echo esc_url( $my_favorite_page ) ?>">
					<div class="card-body">
						<div class="tfcl-icon-overview">
							<i class="icon-autodeal-favourite"></i>
						</div>
						<div class="content-overview">
							<h5><?php esc_html_e( 'My Favorites', 'tf-car-listing' ); ?></h5>
							<div class="tfcl-dashboard-title">
								<span><?php echo sprintf( __( '<b>%d</b>', 'tf-car-listing' ), $total_favorite ) ?></span>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="col-sm-6 col-xl-3">
				<a class="tfcl-card" href="<?php echo esc_url( $my_review_page ) ?>">
					<div class="card-body">
						<div class="tfcl-icon-overview">
							<i class="icon-autodeal-chat1"></i>
						</div>
						<div class="content-overview">
							<h5><?php esc_html_e( 'My Reviews', 'tf-car-listing' ); ?></h5>
							<div class="tfcl-dashboard-title">
								<span><?php echo sprintf( __( '<b>%d</b>', 'tf-car-listing' ), $total_review ) ?></span>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>
	<div class="tfcl-dashboard-middle mt-2">
		<div class="row">
			<div class="tfcl-dashboard-middle-left col-md-12">

			<div class="tfcl-dashboard-listing">
                        <h5 class="title-dashboard-table"><?php esc_html_e( 'New listing', 'tf-car-listing' ); ?></h5>
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 mb-2">
								<div class="group-input-icon search">
                                	<input type="text" name="title_search" id="title_search" value ="<?php echo esc_attr($search) ?>"
                                	    placeholder="<?php esc_attr_e( 'Search...', 'tf-car-listing' ); ?>">
										<span class="datepicker-icon">
                                        <?php echo themesflat_svg('search-dash'); ?>
                                    </span>
								</div>
                            </div>
                            <div class="col-xl-3 col-lg-6 mb-2">
                                <div class="group-input-icon">
                                    <input type="text" id="from-date" class="datetimepicker" name="from_date" value ="<?php echo esc_attr($from_date) ?>"
                                        placeholder="<?php esc_attr_e( 'From Date', 'tf-car-listing' ); ?>">
                                    <span class="datepicker-icon">
                                        <?php echo themesflat_svg('date-dash'); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 mb-2">
                                <div class="group-input-icon">
                                    <input type="text" id="to-date" class="datetimepicker" name="to_date" value ="<?php echo esc_attr($to_date) ?>"
                                        placeholder="<?php esc_attr_e( 'To Date', 'tf-car-listing' ); ?>">
                                    <span class="datepicker-icon">
                                        <?php echo themesflat_svg('date-dash'); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 mb-2">
                                <select name="post_status" id="post_status" class="form-control"
                                    title="<?php esc_attr_e('Post Status', 'tf-car-listing') ?>">
                                    <option value="<?php echo esc_attr($listing_public->tfcl_get_link_filter_post_status('default')) ?>"  <?php selected('default', $selected_post_status); ?> ><?php esc_html_e('Select Status', 'tf-car-listing'); ?></option>
                                    <?php foreach ($list_post_status as $status_key => $post_status): ?>
                                        <option value="<?php echo esc_attr($listing_public->tfcl_get_link_filter_post_status($status_key)) ?>" <?php selected($status_key, $selected_post_status); ?>>
                                            <?php esc_html_e($post_status, 'tf-car-listing'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>           
                        </div>
                        <div class="tfcl-table-listing">
                            <?php if (!$listings): ?>
                                <div class="no-listing-found"><?php esc_html_e('You don\'t have any listing.', 'tf-car-listing'); ?></div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table">
                                        <span class="result-text"><?php echo sprintf( __('<b>%d</b> results found', 'tf-car-listing'), $total_post_listing) ?></span>
                                        <thead>
                                            <tr>
                                                <th><?php esc_html_e('Listing', 'tf-car-listing'); ?></th>
                                                <th><?php esc_html_e('Status', 'tf-car-listing'); ?></th>
                                                <th><?php esc_html_e('Posting date', 'tf-car-listing'); ?></th>
                                                <th><?php esc_html_e('Action', 'tf-car-listing'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody class="tfcl-table-content">
                                            <?php foreach ($listings as $listing) : ?>
                                                <tr>
                                                    <td class="column-listing">
                                                        <div class="tfcl-listing-product">
                                                            <?php
                                                                $prop_address = get_post_meta($listing->ID, 'listing_address', true);
																$car_price_value             = get_post_meta( $listing->ID, 'regular_price', true );
																$car_sale_price_value        = get_post_meta( $listing->ID, 'sale_price', true );
																$car_price_unit              = get_post_meta( $listing->ID, 'listing_price_unit', true );
																$car_enable_short_price_unit = tfcl_get_option( 'enable_short_price_unit', 0 ) == 1 ? true : false;
																$car_price_prefix            = get_post_meta( $listing->ID, 'price_prefix', true );
																$car_price_postfix           = get_post_meta( $listing->ID, 'price_suffix', true );
                                                                $prop_address = get_post_meta($listing->ID, 'listing_address', true);
                                                                $prop_zipcode = get_post_meta($listing->ID, 'listing_zip', true);
																$listing_features  = get_the_terms( $listing->ID, 'features' );
																$width        = get_option( 'thumbnail_width', '168px' );
																$height       = get_option( 'thumbnail_height', '95px' );
																$no_image_src = tfcl_get_option( 'default_listing_image', '' )['url'] != '' ? tfcl_get_option( 'default_listing_image', '' )['url'] : TF_PLUGIN_URL . 'includes/elementor-widget/assets/images/no-image.jpg';
						
																$attach_id = get_post_thumbnail_id( $listing );
																$image_src = wp_get_attachment_image_url( $attach_id, $width, $height, true );
                                                                 ?>

																<a target="_blank"
																	href="<?php echo esc_url( get_permalink( $listing->ID ) ); ?>">
																	<img loading="lazy" src="<?php echo esc_url( $image_src ) ?>"
																		onerror="this.src = '<?php echo esc_url( $no_image_src ) ?>';"
																		alt="<?php echo esc_attr( $listing->post_title ); ?>"
																		title="<?php echo esc_attr( $listing->post_title ); ?>">
																</a>					

                                                                <div class="tfcl-listing-summary">
																	
                                                                    <?php if ($listing->post_status === 'publish'): ?>
                                                                        <h4 class="tfcl-listing-title">
                                                                            <a target="_blank" title="<?php echo esc_attr($listing->post_title); ?>"
                                                                                    href="<?php echo get_permalink($listing->ID); ?>"><?php echo esc_html($listing->post_title); ?></a>
                                                                        </h4>
                                                                    <?php else: ?>
                                                                        <h4 class="tfcl-listing-title"><?php echo esc_html($listing->post_title); ?></h4>
                                                                    <?php endif; ?>

																	<div class="features-text">
																		<?php foreach ( $listing_features as $feature ) {
																					echo $feature->name . ', ';
																				} ?>
																	</div>

																	<div class="price">
																		<?php if ( $car_sale_price_value !== '' ) : ?>
																			<span class="inner tfcl-listing-price">
																				<?php if ( $car_price_prefix !== '' ) : ?>
																					<span class="tfcl-prop-price-postfix"><?php echo esc_html( $car_price_prefix ) ?></span>
																				<?php endif; ?>
																				<span class="tfcl-prop-price-value">
																					<?php echo tfcl_format_price( $car_sale_price_value, $car_price_unit, false, $car_enable_short_price_unit ) ?>
																				</span>
																				<?php if ( $car_price_postfix !== '' ) : ?>
																					<span class="tfcl-prop-price-postfix">
																						<?php echo esc_html( $car_price_postfix ) ?>
																					</span>
																				<?php endif; ?>
																			</span>
																		<?php endif; ?>
																		<?php if ( $car_price_value !== '' ) : ?>
																			<span class="inner tfcl-listing-price sale-price">
																				<?php if ( $car_price_prefix !== '' ) : ?>
																					<span class="tfcl-prop-price-postfix"><?php echo esc_html( $car_price_prefix ) ?></span>
																				<?php endif; ?>
																				<span class="tfcl-prop-price-value">
																					<?php echo tfcl_format_price( $car_price_value, $car_price_unit, false, $car_enable_short_price_unit ) ?>
																				</span>
																				<?php if ( $car_price_postfix !== '' ) : ?>
																					<span class="tfcl-prop-price-postfix">
																						<?php echo esc_html( $car_price_postfix ) ?>
																					</span>
																				<?php endif; ?>
																			</span>
																		<?php endif; ?>
																	</div>
                                                                   
                                                                </div>
                                                        </div>
                                                    </td>
                                                    <td class="column-status">
                                                        <span class="tfcl-listing-status status-<?php echo esc_attr($listing->post_status); ?>">
                                                            <?php
                                                            switch ($listing->post_status) {
                                                                case 'publish':
                                                                    esc_html_e('Approved','tf-car-listing');
                                                                    break;
                                                                case 'sold':
                                                                    esc_html_e('Sold','tf-car-listing');
                                                                    break;
                                                                case 'pending':
                                                                    esc_html_e('Pending','tf-car-listing');
                                                                    break;
                                                                default:
                                                                    echo esc_html($listing->post_status);
                                                            }?>
                                                        </span>
                                                    </td>
													<td class="column-date">
													<div class="tfcl-listing-date"><?php echo esc_html(date_i18n(get_option('date_format'), strtotime($listing->post_date))) ; ?></div>
													</td>
                                                    <td class="column-controller">
                                                        <?php
                                                        $actions = array();
            
                                                        $actions['edit'] = array('id' => 'edit', 'label' => __('Edit', 'tf-car-listing'), 'tooltip' => __('Edit listing', 'tf-car-listing'), 'nonce' => false, 'type_page_link' => 'save-listing', 'confirm' => '');
            
                                                        $actions['sold'] = array('id' => 'sold', 'label' => __('Sold', 'tf-car-listing'), 'tooltip' => __('Sold listing', 'tf-car-listing'), 'nonce' => true, 'type_page_link' => 'my-listing', 'confirm' => esc_html__('Are you sure you want to sold this listing?', 'tf-car-listing'));
            
                                                        $actions['delete'] = array('id' => 'delete', 'label' => __('Delete', 'tf-car-listing'), 'tooltip' => __('Delete listing', 'tf-car-listing'), 'nonce' => true, 'type_page_link' => 'my-listing', 'confirm' => esc_html__('Are you sure you want to delete this listing?', 'tf-car-listing'));
            
                                                        foreach ($actions as $action => $value) {
                                                            $page_link               = '';
                                                            $my_listing_page_link = tfcl_get_permalink('my_listing_page');
                                                            $save_listing_page_link = tfcl_get_permalink('add_listing_page');
                                                            if ($value['type_page_link'] !== 'my-listing') {
                                                                $page_link = $save_listing_page_link;
                                                            } else {
                                                                $page_link = $my_listing_page_link;
                                                            }
                                                            $action_url = add_query_arg(array( 'action' => $action, 'listing_id' => $listing->ID ), $page_link);
                                                            if ($value['nonce']) {
                                                                $action_url = wp_nonce_url($action_url, 'tfcl_my_listing_actions');
                                                            }
                                                            ?>
                                                            <div class="inner-controller">
                                                                <span class="icon">
                                                                    <?php
                                                                        switch ($action) {
                                                                            case 'edit':
                                                                                ?>
                                                                                    <?php echo themesflat_svg('pen'); ?>
                                                                                <?php
                                                                                break;
                                                                            case 'sold':
                                                                                ?>
                                                                                    <?php echo themesflat_svg('sold'); ?>

                                                                                <?php
                                                                                break;
                                                                            case 'delete':
                                                                                ?>
                                                                                    <?php echo themesflat_svg('trash'); ?>
                                                                                <?php
                                                                                break;
                                                                            default:
                                                                                ?>
                                                                                   <?php echo themesflat_svg('pen'); ?>
                                                                                <?php
                                                                    }?>
                                                                    
                                                                </span>
                                                                <?php if ($listing->post_status === 'sold' && ($action === 'sold' ||  $action === 'edit')   ) : ?>
                                                                        <a disabled="disabled" class="disabled-click"> <?php echo esc_html($value['label']); ?></a>
                                                                <?php else : ?>
                                                                    <a href="<?php echo $action != 'edit' ? 'javascript:void(0)' : esc_url($action_url); ?>"
                                                                    data-toggle="tooltip"
                                                                    data-placement="bottom"
                                                                    data-action = "<?php echo esc_attr($action); ?>"
                                                                    data-listing-id = "<?php echo esc_attr($listing->ID); ?>"
                                                                    disabled = "<?php $listing->post_status == 'publish' ? true : false  ?>"
                                                                    title="<?php echo esc_attr($value['tooltip']); ?>"
                                                                    class="btn-action tfcl-dashboard-action-<?php echo esc_attr($action); ?>"><?php esc_html_e($value['label'], 'tf-car-listing'); ?></a>
                                                                <?php endif; ?>
                                                            </div>
                                                            <?php
                                                        } ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php tfcl_get_template_with_arguments( 'global/pagination.php', array( 'max_num_pages' => $max_num_pages ) ); ?>
                            <?php endif; ?>    
                        </div>
                    </div>

				<div class="tfcl-page-insight">
					<div class="tfcl-insight-header">
						<h5 class="mb-2"><?php esc_html_e( 'Page Insights', 'tf-car-listing' ); ?></h5>
						<div class="tfcl-page-insight-filter mb-2">
							<div class="tfcl-page-insight-filter-button">
								<div class="form-group">
									<select class="form-control" name="tracking_view_day">
										<option value="7" selected><?php esc_html_e( '7 days', 'tf-car-listing' ); ?>
										</option>
										<option value="15"><?php esc_html_e( '15 days', 'tf-car-listing' ); ?>
										</option>
										<option value="30"><?php esc_html_e( '30 days', 'tf-car-listing' ); ?>
										</option>
										<option value="90"><?php esc_html_e( '90 days', 'tf-car-listing' ); ?>
										</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div id="tracking-view-chart-container">
						<canvas id="tracking-view-chart"></canvas>
					</div>
				</div>
			</div>
			<div class="tfcl-dashboard-middle-right col-md-12">
				<div class="tfcl-card tfcl-dashboard-reviews">
					<h5><?php esc_html_e( 'Recent Reviews', 'tf-car-listing' ); ?></h5>
					<?php if ( ! $reviews ) : ?>
						<span><?php esc_html_e( 'Don\'t have any reviews.', 'tf-car-listing' ); ?></span>
					<?php else : ?>
						<ul>
							<?php
							foreach ( $reviews as $review ) :
								$author_picture = get_the_author_meta( 'profile_image', $review->user_id );
								$no_avatar_src  = TF_PLUGIN_URL . 'includes/elementor-widget/assets/images/no-image.jpg';
								$width          = 56;
								$height         = 56;
								$default_avatar = tfcl_get_option( 'default_user_avatar', '' );
								if ( is_array( $default_avatar ) && $default_avatar['url'] != '' ) {
									$no_avatar_src = tfcl_image_resize_url( $default_avatar['url'], $width, $height, true )['url'];
								}
								$user_link = get_author_posts_url( $review->user_id );
								?>
								<li class="comment-by-user">
									<div class="group-author">
										<img loading="lazy" class="avatar" width="<?php echo esc_attr( $width ) ?>"
											height="<?php echo esc_attr( $height ) ?>"
											src="<?php echo esc_url( $author_picture ? $author_picture : '' ) ?>"
											onerror="this.src = '<?php echo esc_url( $no_avatar_src ) ?>';" alt="avatar">
										<?php
										$user_info = get_userdata( $review->user_id );
										?>
										<div class="group-name">
											<div class="review-name">
												<?php echo sprintf( __( '<b>%s</b>', 'tf-car-listing' ), $user_info ? $user_info->user_nicename : '' ) ?>
												<span class="review-date"><?php echo esc_html( tfcl_get_comment_time( $review->comment_ID ) ); ?></span>
											</div>
										</div>
									</div>
									<div class="content">
										<p><?php echo esc_html( $review->comment_content ); ?> </p>
									</div>
									<div class="rating-wrap">
												<div class="form-group">
													<div class="star-rating-review">
														<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
															<i class="star disabled-click icon-autodeal-star <?php echo esc_attr( $i <= get_comment_meta( $review->comment_ID, 'listing_comfort_rating', true ) ? 'active' : '' ); ?>"
																data-rating="<?php echo esc_attr( $i ); ?>"></i>
														<?php endfor; ?>
													</div>
												</div>
											</div>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>