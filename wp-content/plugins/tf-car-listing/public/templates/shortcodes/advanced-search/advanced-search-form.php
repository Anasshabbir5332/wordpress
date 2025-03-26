<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$search_fields               = tfcl_get_option( 'advanced_search_fields' );
$enable_advanced_search_form = tfcl_get_option( 'enable_advanced_search_form', 'y' );
$enable_condition            = tfcl_get_option( 'enable_condition_search' );
$value_condition             = isset( $_GET['condition'] ) ? ( wp_unslash( $_GET['condition'] ) ) : 'all';
$text_custom_search_label    = tfcl_get_option( 'text_custom_search_label', 'Search');
?>
<?php if ( $enable_advanced_search_form == 'y' ) : ?>
	<div class="tfcl-advanced-search-wrap <?php echo esc_attr( tfcl_get_option( 'map_position' ) ); ?>">
		<div class="form-search-wrap">
			<div id="tfcl-advanced-search-form-content" data-href="<?php echo esc_attr( tfcl_get_permalink( 'advanced_search_page' ) ); ?>" class="search-listing-form">
				<div class="form-search-inner">
						<div class="condition-tab-wrap tf-search-condition-tab <?php echo $enable_condition == 'y' ? esc_attr('enable-show') : 'disable-show'; ?>">
							<?php
							$condition       = tfcl_get_taxonomies( 'condition' );
							$value_condition = ! empty( $value_condition ) ? $value_condition : '';
							if ( is_tax() ) {
								$current_term  = get_queried_object();
								$taxonomy_name = get_query_var( 'taxonomy' );
								if ( $taxonomy_name == 'condition' ) {
									$value_condition = $current_term->slug;
								}
							}
							if ( ! empty( $condition ) ) :
								?>
								<input type="hidden" class="search-field" name="condition" id="condition"
									value="<?php echo esc_attr( $value_condition ); ?>" data-default-value="">
								<a data-value="all" class="btn-condition-filter <?php echo esc_attr( $value_condition == 'all' ? 'active' : '' ); ?>">
									<?php echo esc_html( 'All', 'tf-car-listing' ); ?>
								</a>
								<?php foreach ( $condition as $key => $cond ) : ?>
									<a data-value="<?php echo esc_attr( $key ) ?>"
										class="btn-condition-filter <?php echo esc_attr( $value_condition == $key ? 'active' : '' ); ?>">
										<?php echo esc_html( $cond ); ?>
									</a>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>
					<div class="tfcl-form-top search-form-content tfcl-search-group-input">
						<?php render_search_fields( array_slice( $search_fields, 0, 4 ), true ); ?>
					</div>
					<?php if ( tfcl_get_option( 'enable_button_avanced_search' ) == 'y' ) : ?>
					<div class="form-group tf-wrap-search-more-btn">
						<a class="tf-search-more-btn">
							<i class="icon-autodeal-icon-89"></i>
						</a>
					</div>
					<?php endif; ?>
					<div class="form-group submit-search-form">
						<a class="tf-advanced-search-btn">
							<?php echo esc_html($text_custom_search_label); ?> <i class="fa fa-search"></i>
						</a>
					</div>
					<div class="tfcl-form-bottom search-more-options" style="display:none">
						<div class="row">
							<?php render_search_fields( array_slice( $search_fields, 4 ) ); ?>

							<div class="col-md-12">
								<div class="wrap-action-filter-search">
									<span class="btn-apply-filter"><i class="icon-autodeal-icon-1"></i> <?php esc_html_e( 'Apply Filters', 'tf-car-listing' ) ?></span>
									<span class="btn-clear-filter"><i class="icon-autodeal-reload"></i> <span><?php esc_html_e( 'Clear Filters', 'tf-car-listing' ) ?></span></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>