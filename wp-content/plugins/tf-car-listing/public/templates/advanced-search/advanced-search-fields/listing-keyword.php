<?php
/**
 * @var $css_class_field
 * @var $value_keyword
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$keyword_field = tfcl_get_option( 'search_criteria_keyword_field', 'criteria_title' );
if ( $keyword_field == 'criteria_title' ) {
	$keyword_placeholder = esc_html__( 'Enter keyword...', 'tf-car-listing' );
} else {
	$keyword_placeholder = esc_html__( 'Enter Location...', 'tf-car-listing' );
}
?>
<div class="form-group form-item">
		<?php if ( $keyword_field == 'criteria_title' ) : ?>
			<label for="search_keyword"><?php esc_html_e( 'Keyword', 'tf-car-listing' ); ?></label>
		<?php else : ?>
			<label for="search_keyword"><?php esc_html_e( "Location", 'tf-car-listing' ); ?></label>
		<?php endif; ?>
	<input type="text" class="form-control search-field" id="search_keyword" data-default-value=""
		value="<?php echo esc_attr( $value_keyword ); ?>" name="keyword"
		placeholder="<?php echo esc_attr( $keyword_placeholder ) ?>">
</div>