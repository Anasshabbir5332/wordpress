<?php
/**
 * @var $listing
 * @var $max_num_pages
 * @var $list_post_status
 * @var $selected_post_status
 * @var $title_search
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! is_user_logged_in() ) {
	tfcl_get_template_with_arguments( 'global/access-permission.php', array( 'type' => 'not_login' ) );
	return;
}
wp_enqueue_script( 'dashboard-js' );
wp_enqueue_style( 'dashboard-css' );
$listing_public = new Car_Listing();
$new_listing_id = isset( $_GET['new_listing_id'] ) ? wp_unslash( $_GET['new_listing_id'] ) : '';
$submit_mode    = isset( $_GET['submit_mode'] ) ? wp_unslash( $_GET['submit_mode'] ) : '';
if ( ! empty( $new_listing_id ) ) {
	tfcl_get_template_with_arguments( 'listing/alert-handle-listing.php', array( 'listing' => get_post( $new_listing_id ), 'submit_mode' => $submit_mode ) );
}
?>
<div class="tfcl_message"></div>
<h1 class="admin-title mb-4"><?php esc_html_e( 'My listing', 'tf-car-listing' ); ?></h1>

<div class="tfcl-dashboard">

	<div class="tfcl-dashboard-listing">
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
								<select name="post_status" id="post_status" class="form-control filter-my-listing"
						title="<?php esc_attr_e( 'Post Status', 'tf-car-listing' ) ?>">
						<option value="<?php echo $listing_public->tfcl_get_link_filter_post_status( 'default' ) ?>" <?php selected( 'default', $selected_post_status ); ?>>
							<?php esc_html_e( 'Listing Status', 'tf-car-listing' ); ?>
						</option>
						<?php foreach ( $list_post_status as $post_status ) : ?>
							<option value="<?php echo $listing_public->tfcl_get_link_filter_post_status( $post_status ) ?>"
								<?php selected( $post_status, $selected_post_status ); ?>>
								<?php printf( __( $post_status, 'tf-car-listing' ) ); ?>
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
																	$car_enable_short_price_unit = tfcl_get_option( 'enable_short_price_unit', 0 ) == 1 ? true : false;
																	
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
															<span class="tfcl-listing-status status-<?php echo esc_attr( $listing->post_status ); ?>">
															<?php
											switch ( $listing->post_status ) {
												case 'publish':
													esc_html_e( 'Published', 'tf-car-listing' );
													break;
												case 'expired':
													esc_html_e( 'Expired', 'tf-car-listing' );
													break;
												case 'pending':
													esc_html_e( 'Pending', 'tf-car-listing' );
													break;
												case 'hidden':
													esc_html_e( 'Hidden', 'tf-car-listing' );
													break;
												default:
													echo esc_html( $listing->post_status );
													break;
											}
											?>
															</span>
														</td>
														<td class="column-date">
														<div class="tfcl-listing-date"><?php echo esc_html(date_i18n(get_option('date_format'), strtotime($listing->post_date))) ; ?></div>
														</td>
														<td class="column-controller">
														<ul class="controller">
												<?php
												$actions = array();
												switch ( $listing->post_status ) {
													case 'publish':
														$actions['hide'] = array( 'label' => __( '<i class="icon-autodeal-hide"></i> Hide', 'tf-car-listing' ), 'tooltip' => __( 'Hide listing', 'tf-car-listing' ), 'nonce' => true, 'type_page_link' => 'my-listing', 'confirm' => esc_html__( 'Are you sure want to hide this listing?', 'tf-car-listing' ) );
	
														$actions['edit'] = array( 'label' => __( '<i class="icon-autodeal-edit"></i> Edit', 'tf-car-listing' ), 'tooltip' => __( 'Edit listing', 'tf-car-listing' ), 'nonce' => false, 'type_page_link' => 'save-listing', 'confirm' => '' );
	
														break;
													case 'hidden':
														$actions['show'] = array( 'label' => __( '<i class="icon-autodeal-view"></i> Show', 'tf-car-listing' ), 'tooltip' => __( 'Show listing', 'tf-car-listing' ), 'nonce' => true, 'type_page_link' => 'my-listing', 'confirm' => esc_html__( 'Are you sure want to show this listing?', 'tf-car-listing' ) );
	
														break;
													case 'pending':
														$actions['edit'] = array( 'label' => __( '<i class="icon-autodeal-edit"></i> Edit', 'tf-car-listing' ), 'tooltip' => __( 'Edit listing', 'tf-car-listing' ), 'nonce' => false, 'type_page_link' => 'save-listing', 'confirm' => '' );
	
														break;
													default:
														# code...
														break;
												}
	
												$actions['delete'] = array( 'label' => __( '<i class="icon-autodeal-trash"></i> Delete', 'tf-car-listing' ), 'tooltip' => __( 'Delete listing', 'tf-car-listing' ), 'nonce' => true, 'type_page_link' => 'my-listing', 'confirm' => esc_html__( 'Are you sure want to delete this listing?', 'tf-car-listing' ) );
												foreach ( $actions as $action => $value ) {
													$page_link              = '';
													$my_listing_page_link   = tfcl_get_permalink( 'my_listing_page' );
													$save_listing_page_link = tfcl_get_permalink( 'add_listing_page' );
													if ( $value['type_page_link'] !== 'my-listing' ) {
														$page_link = $save_listing_page_link;
													} else {
														$page_link = $my_listing_page_link;
													}
													$action_url = add_query_arg( array( 'action' => $action, 'listing_id' => $listing->ID ), $page_link );
													if ( $value['nonce'] ) {
														$action_url = wp_nonce_url( $action_url, 'tfcl_my_listing_actions' );
													}
													?>
													<li>
														<a <?php if ( ! empty( $value['confirm'] ) ) : ?>
																onclick="return confirm('<?php echo esc_html( $value['confirm'] ); ?>')"
															<?php endif; ?> href="<?php echo esc_url( $action_url ); ?>"
															data-toggle="tooltip" data-placement="bottom"
															data-action="<?php echo esc_attr( $action ); ?>"
															data-listing-id="<?php echo esc_attr( $listing->ID ); ?>"
															class="btn-action tfcl-dashboard-action-<?php echo esc_attr( $action ); ?>"><?php echo wp_kses( $value['label'], 'tf-car-listing' ); ?>
														</a>
													</li>
													<?php
												}
												?>
											</ul>
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
</div>