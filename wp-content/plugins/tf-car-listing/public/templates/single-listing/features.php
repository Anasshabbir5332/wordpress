<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $post;
$listing_id        = get_the_ID();
$listing_meta_data = get_post_custom( $listing_id );
$listing_features  = get_the_terms( $listing_id, 'features' );
$show_features     = is_array( tfcl_get_option( 'single_listing_panels_manager' ) ) ? tfcl_get_option( 'single_listing_panels_manager' )['features'] : false;
?>
<?php if ( $show_features == true ) :
	if ( $listing_features ) : ?>
		<div id="features" class="single-listing-element listing-info-detail tab-features">
			<div class="tfcl-listing-overview">
				<div class="tfcl-listing-header">
					<h4><?php echo esc_html__( 'Features', 'tf-car-listing' ); ?></h4>
				</div>
				<div class="tfcl-listing-info">
					<div id="tfcl-features">
						<?php
						$features_terms_slug = array();
						if ( ! is_wp_error( $listing_features ) ) {
							foreach ( $listing_features as $feature ) {
								$features_terms_slug[] = $feature->slug;
							}
						}

						$all_features_type = get_categories(
							array(
								'taxonomy'   => 'features-type',
								'hide_empty' => 0,
								'orderby'    => 'term_id',
								'order'      => 'ASC',
							)
						);

						$all_features = get_categories(
							array(
								'taxonomy'   => 'features',
								'hide_empty' => 0,
								'orderby'    => 'term_id',
								'order'      => 'ASC',
							)
						);

						foreach ( $all_features_type as $key => $features_type ) {
							$check_features_type_has_item = tfcl_check_features_type_has_item_by_slug( $features_type->slug, $features_terms_slug );
							$parents_items                = $child_items = array();
							if ( $all_features && $features_terms_slug ) {
								foreach ( $all_features as $term ) {
									if ( 0 == $term->parent && in_array( $term->slug, $features_terms_slug ) )
										$parents_items[] = $term;
									if ( $term->parent && in_array( $term->slug, $features_terms_slug ) )
										$child_items[] = $term;
								}
								if ( count( $child_items ) > 0 ) {
									foreach ( $parents_items as $parents_item ) {
										echo '<h4>' . esc_html( $parents_item->name ) . '</h4>';

										if ( $check_features_type_has_item ) {
											echo '<div class="features-item">';
											?>
											<h5 class="features-type-title"><?php echo $features_type->name; ?></h5>
											<?php
										}
										foreach ( $child_items as $child_item ) {
											$feature_type_slug = get_term_meta( $child_item->term_id, 'type_of_features', true );
											if ( $features_type->slug == $feature_type_slug ) {
												if ( $child_item->parent == $parents_item->slug ) {
													if ( in_array( $child_item->slug, $features_terms_slug ) ) {
														echo '<div class="listing-feature-wrap"><i class="icon-autodeal-icon-144"></i>' . esc_html( $child_item->name ) . '</div>';
													} else {
														echo '<div class="listing-feature-wrap"><i class="icon-autodeal-icon-144"></i>' . esc_html( $child_item->name ) . '</div>';
													}
												}
											}
										}
										if ( $check_features_type_has_item ) echo '</div>';
									}
								} else {
									if ( $check_features_type_has_item ) {
										echo '<div class="features-item">';
										?>
										<h5 class="features-type-title"><?php echo $features_type->name; ?></h5>
										<?php
									}
									echo '<div class="features-inner"><div class="inner">';
									foreach ( $parents_items as $parents_item ) {
										$term_link         = get_term_link( $parents_item, 'listing-feature' );
										$feature_type_slug = get_term_meta( $parents_item->term_id, 'type_of_features', true );

										if ( $features_type->slug == $feature_type_slug ) {
											if ( in_array( $parents_item->slug, $features_terms_slug ) ) {
												echo '<div class="listing-feature-wrap"><i class="icon-autodeal-icon-144"></i>' . esc_html( $parents_item->name ) . '</div>';
											} else {
												echo '<div class="listing-feature-wrap"><i class="icon-autodeal-icon-144"></i>' . esc_html( $parents_item->name ) . '</div>';
											}
										}
									}
									if ( $check_features_type_has_item ) echo '</div>';
									echo '</div></div>';
								}
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
	<?php endif;
endif; ?>