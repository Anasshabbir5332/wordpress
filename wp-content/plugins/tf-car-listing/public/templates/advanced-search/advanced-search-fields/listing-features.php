<?php
/**
 * @var $css_class_field
 * @var $enable_search_features
 * @var $enable_toggle_listing_features
 * @var $value_features
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$custom_name_features = get_option('custom_name_features');
?>
<div class="col-md-12 col-sm-12 col-xs-12 features-wrap clearfix">
	<?php if ( $enable_toggle_listing_features == 'y' ) : ?>
		<div class="enable-features">
			<?php $class_enable_search_features = ( ! empty( $enable_search_features ) && $enable_search_features == '1' ) ? 'show' : ''; ?>
			<a href="javascript:void(0)" class="btn-enable-features <?php echo esc_attr( $class_enable_search_features ); ?>">
				<?php esc_html_e( $custom_name_features, 'tf-car-listing' ); ?><i class="icon-autodeal-icon-81"></i>
			</a>
			<input type="hidden" name="enable-search-features" class="search-field" data-default-value="0"
				value="<?php echo esc_attr( ( ! empty( $enable_search_features ) && $enable_search_features == '1' ) ? '1' : '0' ); ?>">
		</div>
	<?php else : ?>
		<div class="features">
			<label><?php esc_html_e( $custom_name_features, 'tf-car-listing' ); ?></label>
		</div>
	<?php endif; ?>
	<div class="features-list"
		style="display: <?php echo esc_attr( ( ! empty( $enable_search_features ) && $enable_search_features == '1' ) ? 'block' : 'none' ); ?>;">
		<?php
		$listing_features = get_categories(
			array(
				'taxonomy'   => 'features',
				'hide_empty' => 0,
				'orderby'    => 'term_id',
				'order'      => 'ASC'
			)
		);
		$parents_items    = $child_items = array();
		if ( $listing_features ) {
			foreach ( $listing_features as $term ) {
				if ( 0 == $term->parent )
					$parents_items[] = $term;
				if ( $term->parent )
					$child_items[] = $term;
			}
			if ( is_taxonomy_hierarchical( 'listing-feature' ) && count( $child_items ) > 0 ) {
				foreach ( $parents_items as $parents_item ) {
					echo '<h4 class="listing-feature-name">' . esc_html( $parents_item->name ) . '</h4>';
					echo '<div class="wrap-checkbox">';
					foreach ( $child_items as $child_item ) {
						if ( $child_item->parent == $parents_item->term_id ) {
							echo '<div class="checkbox-item"><div class="checkbox"><label>';
							if ( ! empty( $value_features ) && in_array( $child_item->slug, $value_features ) ) {
								echo '<input type="checkbox" name="features" value="' . esc_attr( $child_item->slug ) . '" checked/>';
							} else {
								echo '<input type="checkbox" name="features" value="' . esc_attr( $child_item->slug ) . '" />';
							}
							echo esc_html( $child_item->name );
							echo '</label></div></div>';
						}
					}
					echo '</div>';
				}
			} else {
				echo '<div class="wrap-checkbox">';
				foreach ( $parents_items as $parents_item ) {
					echo '<div class="checkbox-item"><div class="checkbox"><label>';
					if ( ! empty( $value_features ) && in_array( $parents_item->slug, $value_features ) ) {
						echo '<input type="checkbox" name="features" value="' . esc_attr( $parents_item->slug ) . '" checked/>';
					} else {
						echo '<input type="checkbox" name="features" value="' . esc_attr( $parents_item->slug ) . '" />';
					}
					echo esc_html( $parents_item->name );
					echo '</label></div></div>';
				}
				echo '</div>';
			}
		}
		?>
	</div>
</div>