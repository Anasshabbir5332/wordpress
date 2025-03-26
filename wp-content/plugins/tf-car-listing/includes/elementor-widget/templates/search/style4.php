<?php 
$css_col_class = isset( $css_col_class ) ? $css_col_class : '';
$text_custom_search_label    = tfcl_get_option( 'text_custom_search_label', 'Car');
$text_button = $settings['text_button'];
?>
<div data-href="<?php echo esc_attr( tfcl_get_permalink( 'advanced_search_page' ) ); ?>" class="search-listing-form">
    <h3><?php echo esc_html($settings['text_heading']); ?></h3>
	<?php if ( $settings['show_status'] == 'yes' ) : ?>
	<div class="tf-search-condition-tab">
		<input type="hidden" class="search-field" name="condition" id="condition" value="" data-default-value="">
		<?php
		$condition = tfcl_get_taxonomies( 'condition' );
		$allNumber = tfcl_get_all_car_listing();
		if ( ! empty( $condition ) ) : ?>
			<a data-value="all" id="btn-condition-filter-all" data-number="<?php echo esc_attr( $allNumber ); ?>"
				class="btn-condition-filter active"><?php esc_html_e( 'All', 'tf-car-listing' ); ?></a>
			<?php foreach ( $condition as $key => $cond ) : ?>
				<a data-value="<?php echo esc_attr( $key ) ?>"
					class="btn-condition-filter <?php echo esc_attr( $cond == $key ? 'active' : '' ); ?>">
					<?php echo esc_html( $cond ); ?>
				</a>
				<?php
			endforeach;
		endif;
		?>
	</div>
	<?php endif; ?>
	<div class="search-form-content">
		<?php if ( isset( $settings['search_advanced_top'] ) && is_array( $settings['search_advanced_top'] ) && ! empty( $settings['search_advanced_top'] ) ) : ?>
			<div class="tfcl-search-form-top desktop">
                <div class="group-radio-select">
                    <div class="inner">
                        <input type="radio" id="by_budget" name="selectSearch" value="budget" checked>
                        <label for="by_budget"><?php esc_html_e( 'By Budget', 'tf-car-listing' ); ?></label>
                    </div>
                    <div class="inner">
                        <input type="radio" id="by_brand" name="selectSearch" value="brand">
                        <label for="by_brand"><?php esc_html_e( 'By Brand', 'tf-car-listing' ); ?></label>
                    </div>
                </div>
                <div class="by-budget-option active">
				    <?php render_search_fields_widget_elementor( 'search_advanced_top_budget', $settings, true ); ?>
                </div>
                <div class="by-brand-option">
				    <?php render_search_fields_widget_elementor( 'search_advanced_top_brand', $settings, true ); ?>
                </div>
				<div class="wrap-search-form-btn">
                    <div class="form-item submit-search-form">
						<?php if ( tfcl_get_option('enable_custom_search_label_button') == 'y' ) : ?>
							<a class="tf-advanced-search-btn">
								<?php echo esc_html($text_custom_search_label); ?>
								<i class="icon-autodeal-icon-1"></i>
							</a>
						<?php else: ?>
							<a class="tf-advanced-search-btn filter">
								<?php esc_html_e( $text_button ) ?>
								<i class="icon-autodeal-icon-1"></i>
							</a>
						<?php endif; ?>
					</div>
					<?php if ( $settings['show_filter'] == 'yes' ) : ?>
						<div class="tf-wrap-search-more-btn">
							<a class="tf-search-more-btn">
                                <?php esc_html_e( 'Advanced search', 'tf-car-listing' ); ?>
                                <i class="icon-autodeal-icon-89"></i>
							</a>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="tfcl-search-form-top mobile">
				<div class="form-group input-group w-100">
					<?php if ( $settings['show_filter_mobile'] == 'yes' ) : ?>
						<div class="tf-wrap-search-more-btn">
							<a class="tf-search-more-btn">
								<i class="icon-autodeal-icon-89"></i>
							</a>
						</div>
					<?php endif; ?>
					<input class="form-control search-input search-field" value="" name="keyword" type="text"
						placeholder="<?php echo esc_attr( 'Enter Keyword...', 'tf-car-listing' ); ?>">
					<div class="form-item submit-search-form">
						<a class="tf-advanced-search-btn">
							<i class="icon-autodeal-icon-1"></i>
						</a>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
	<?php if ( isset( $settings['search_advanced_mobile'] ) && is_array( $settings['search_advanced_mobile'] ) && ! empty( $settings['search_advanced_mobile'] ) ) : ?>
		<div class="search-more-options mobile form-wrap" style="display:none;">
			<div class="row"><?php render_search_fields_widget_elementor( 'search_advanced_mobile', $settings ); ?></div>
		</div>
	<?php endif; ?>
	<?php if ( isset( $settings['search_advanced_bottom'] ) && is_array( $settings['search_advanced_bottom'] ) && ! empty( $settings['search_advanced_bottom'] ) ) : ?>
		<div class="search-more-options desktop" style="display:none;">
			<div class="row">
				<?php render_search_fields_widget_elementor( 'search_advanced_bottom', $settings, 'true' ); ?>
			</div>
		</div>
	<?php endif; ?>
</div>