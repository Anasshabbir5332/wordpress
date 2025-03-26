<?php
/**
 * @var $listing_data
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$show_hide_listing_fields = tfcl_get_option( 'show_hide_listing_fields', array() );
$features_checked_by_slug   = $features_terms_slug = $parents_items = $child_items = array();
if ( isset( $listing_data ) ) {
	$features_by_slug = get_the_terms( $listing_data->ID, 'features' );
	if ( $features_by_slug && ! is_wp_error( $features_by_slug ) ) {
		foreach ( $features_by_slug as $feature ) {
			$features_checked_by_slug[] = $feature->slug;
		}
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

$listing_features = get_categories(
	array(
		'taxonomy'   => 'features',
		'hide_empty' => 0,
		'orderby'    => 'term_id',
		'order'      => 'ASC'
	)
);

if ( $listing_features ) {
	foreach ( $listing_features as $term ) {
		$features_terms_slug[] = $term->slug;
		if ( 0 == $term->parent )
			$parents_items[] = $term;
		if ( $term->parent )
			$child_items[] = $term;
	}
	?>
	<?php if ( $show_hide_listing_fields['features'] == 1 ) : ?>
		<div class="tfcl-field-wrap tfcl-amenities">
			<div class="tfcl-field-title">
				<h4><?php esc_html_e( 'Safety features', 'tf-car-listing' ); ?></h4>
			</div>
			<div class="tfcl-field tfcl-listing-feature row">
				<?php
				foreach ( $all_features_type as $key => $features_type ) {
					$check_features_type_has_item = tfcl_check_features_type_has_item_by_slug( $features_type->slug, $features_terms_slug );
					if ( is_taxonomy_hierarchical( 'features' ) && ( count( $child_items ) > 0 ) ) {
						echo '<div class="wrap-listing-features">';
						foreach ( $parents_items as $parent_item ) {
							echo '<div class="listing-fields listing-feature cl-5">';
							echo '<h6 class="listing-feature-name">' . esc_html( $parent_item->name ) . '</h6>';
							foreach ( $child_items as $child_item ) {
								$feature_type_term_slug = get_term_meta( $child_item->term_id, 'type_of_features', true );
								if ( $features_type->slug == $feature_type_term_slug ) {
									if ( $child_item->parent == $parent_item->slug ) {
										echo '<div class="children-item group-checkbox checkbox">';
										if ( in_array( $child_item->slug, $features_checked_by_slug ) ) {
											echo '<input id="' . esc_attr( $child_item->name ) . '" class="form-check-input" type="checkbox" name="features[]" value="' . esc_attr( $child_item->name ) . '" checked />';
										} else {
											echo '<input id="' . esc_attr( $child_item->name ) . '" class="form-check-input" type="checkbox" name="features[]" value="' . esc_attr( $child_item->name ) . '" />';
										}
										echo '<label for="' . esc_attr( $child_item->name ) . '">' . esc_html( $child_item->name );
										echo '</label></div>';
									}
								}
							}
							echo '</div>';
						}
						echo '</div>';
					} else {
						if ( $check_features_type_has_item ) {
							echo '<div class="listing-fields listing-feature col-xl-3 col-lg-6 col-md-6">';
							?>
							<h4 class="features-type-title"><?php echo $features_type->name; ?></h4>
							<?php
						}
						foreach ( $parents_items as $parent_item ) {
							$feature_type_term_slug = get_term_meta( $parent_item->term_id, 'type_of_features', true );
							if ( $features_type->slug == $feature_type_term_slug ) {
								echo '<div class="parent-item group-checkbox">';
								if ( in_array( $parent_item->slug, $features_checked_by_slug ) ) {
									echo '<input id="' . esc_attr( $parent_item->name ) . '" class="form-check-input" type="checkbox" name="features[]" value="' . esc_attr( $parent_item->name ) . '" checked />';
								} else {
									echo '<input id="' . esc_attr( $parent_item->name ) . '" class="form-check-input" type="checkbox" name="features[]" value="' . esc_attr( $parent_item->name ) . '" />';
								}
								echo '<label for="' . esc_attr( $parent_item->name ) . '">' . esc_html( $parent_item->name );
								echo '</label></div>';
							}
						}
						if ( $check_features_type_has_item ) echo '</div>';
					}
				}
				?>
			</div>
		</div>
	<?php endif; ?>
<?php } ?>