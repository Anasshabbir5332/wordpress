<div class="tfcl-list-dealer-shortcode">
	<div class="row">
		<div class="col-md-6">
			<h2 class="heading"><?php esc_html_e( 'Find car dealerships', 'tf-car-listing' ); ?></h2>
		</div>
		<div class="col-md-6">
			<div class="sort">
				<select id="tfcl-sort-by-order" class="form-select form-select-sm" aria-label=".form-select-sm example">
					<?php $selected_order = wp_unslash( $_REQUEST['orderBy'] ); ?>
					<?php foreach ( $list_order as $key => $value ) : ?>
						<option value="<?php echo esc_attr( tfcl_get_link_order_dealer( $key ) ); ?>" <?php selected( $key, $selected_order ); ?>><?php esc_html_e( $value, 'tf-car-listing' ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?php if ( ! empty( $list_dealer ) && is_array( $list_dealer ) ) : ?>
				<table>
					<?php
					foreach ( $list_dealer as $key => $dealer ) :
						if ( isset( $dealer['dealer_meta_data']['dealer_logo'][0] ) ) {
							$logo_dealer = ! empty( $dealer['dealer_meta_data']['dealer_logo'][0] ) ? $dealer['dealer_meta_data']['dealer_logo'][0] : '';
							if ( ! empty( $logo_dealer ) ) {
								$logo_dealer     = json_decode( $logo_dealer, true );
								$logo_dealer_src = wp_get_attachment_image_src($logo_dealer[0], 'full');
							}
						}
						extract( $dealer );
						$overall_rating = 0;
						// calculate for overall rating customer service
						$customer_service_rating = tfcl_cal_overall_rating_dealer( $dealer['ID'], 'dealer_customer_service_rating' );
						// calculate for overall rating buying process
						$buying_process_rating = tfcl_cal_overall_rating_dealer( $dealer['ID'], 'dealer_buying_rating' );
						// calculate for overall rating overall experience
						$overall_experience_rating = tfcl_cal_overall_rating_dealer( $dealer['ID'], 'dealer_overall_rating' );
						// calculate for overall rating speed
						$overall_speed_rating = tfcl_cal_overall_rating_dealer( $dealer['ID'], 'dealer_speed_rating' );
						$overall_rating       = number_format( ( $customer_service_rating['overall_rate']  ), 1 );
						$review_count  = tfcl_count_review_dealer( $dealer['ID'] );
						?>
						<tr class="dealer-item">
							<td class="dealer-logo">
								<div class="logo-dealer">
									<?php if ( ! empty( $logo_dealer_src[0] ) ) : ?>
										<img src="<?php echo esc_attr( $logo_dealer_src[0] ); ?>" alt="<?php esc_attr_e( $title ); ?>" class="logo">
									<?php else : ?>
										<img src="<?php echo TF_PLUGIN_URL . "includes/elementor-widget/assets/images/no_logo_dealer.png"; ?>" alt="<?php esc_attr_e( $title ); ?>" class="logo">
									<?php endif; ?>
								</div>
							</td>
							<td class="dealer-content">
								<div class="content-left">
									<a class="dealer-name" href="<?php echo esc_url( $permalink ); ?>">
										<?php echo esc_html( $title ); ?>
									</a>
									<div class="rating-dealer">
										<span class="count-review"><?php echo sprintf( esc_html__( '%s Reviews', 'tf-car-listing' ), $review_count ) ?></span> 
										<div class="wrap-rating">
											<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
												<i class="star disabled-click icon-autodeal-star <?php echo esc_attr( $i <= $overall_rating ? 'active' : '' ); ?>"></i>
											<?php endfor; ?>
										</div>
										<span><?php echo esc_html( $overall_rating ); ?></span>
									</div>
								</div>
								<div class="phone-number-dealer">
										<?php if ( ! empty( $dealer_meta_data['dealer_phone_number'][0] ) ) : ?>
											<input type="hidden" class="full_number_phone" data-fullnumber="<?php echo esc_attr( $dealer_meta_data['dealer_phone_number'][0] ); ?>">
											<?php echo sprintf( '<span class="phone-number sale_phone_text">%s</span> <a href="#" class="show_number_btn"><i class="icon-autodeal-mobile"></i> %s</a>', $dealer_meta_data['dealer_phone_number'][0], esc_html__( 'Show number', 'tf-car-listing' ) ); ?>
										<?php else : ?>
											<span class="phone-number"><?php esc_html_e( 'No data phone', 'tf-car-listing' ); ?></span>
										<?php endif; ?>
								</div>
								<div class="dealer-address">
									<?php if ( ! empty( $dealer_meta_data['dealer_office_address'][0] ) ) : ?>
										<?php echo themesflat_svg('location'); ?> <?php echo esc_html( $dealer_meta_data['dealer_office_address'][0] ); ?>
									<?php endif; ?>
								</div>
							</td>
							<td class="dealer-action">
								<a href="<?php echo esc_url( $permalink ); ?>"><?php esc_html_e( 'Dealer detail', 'tf-car-listing' ); ?> <i class="icon-autodeal-icon-97"></i></a>
							</td>
						</tr>
					<?php endforeach; ?>
				</table>
				<?php
				if ( tfcl_get_option( 'pagination_dealer_archive' ) == 'enable' ) {
					tfcl_get_template_with_arguments( 'global/pagination.php', array( 'max_num_pages' => $max_num_pages ) );
				}
				?>
			<?php else : ?>
				<?php esc_html_e( 'No dealer found', 'tf-car-listing' ); ?>
			<?php endif; ?>
		</div>
	</div>
</div>