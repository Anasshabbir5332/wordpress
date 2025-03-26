<?php
/**
 * @var $listing_data
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$custom_name_condition = get_option('custom_name_condition', 'condition');
$custom_name_body = get_option('custom_name_body', 'Body');
$custom_name_make = get_option('custom_name_make', 'Make');
$custom_name_model = get_option('custom_name_model', 'Model');
$custom_name_transmission = get_option('custom_name_transmission', 'transmission');
$custom_name_cylinders = get_option('custom_name_cylinders', 'cylinders');
$custom_name_drive_type = get_option('custom_name_drive_type', 'Drive Type');
$custom_name_fuel_type = get_option('custom_name_fuel_type', 'Fuel Type');
$custom_name_color = get_option('custom_name_color', 'Color');
$custom_name_features_type = get_option('custom_name_features_type', 'Features Type');
$custom_name_features = get_option('custom_name_features', 'Features');
$custom_name_stock_number = get_option('custom_name_stock_number', 'Stock Number');
$custom_name_vin_number = get_option('custom_name_vin_number', 'Vin Number');
$custom_name_city_mpg = get_option('custom_name_city_mpg', 'City Mpg');
$custom_name_highway_mpg = get_option('custom_name_highway_mpg', 'Highway Mpg');
$custom_name_year = get_option('custom_name_year', 'Year');
$custom_name_door = get_option('custom_name_door', 'Door');
$custom_name_seat = get_option('custom_name_seat', 'Seat');
$custom_name_mileage = get_option('custom_name_mileage', 'Mileage');
$custom_name_engine_size = get_option('custom_name_engine_size', 'Engine Size');
$listing_id               = $listing_data ? $listing_data->ID : null;
$listing_meta_data        = $listing_data ? get_post_meta( $listing_data->ID ) : array();
$car_title_value          = $listing_data ? $listing_data->post_title : '';
$car_year_value           = $listing_data ? get_post_meta( $listing_data->ID, 'year', true ) : '';
$car_stock_number_value   = $listing_data ? get_post_meta( $listing_data->ID, 'stock_number', true ) : '';
$car_vin_number           = $listing_data ? get_post_meta( $listing_data->ID, 'vin_number', true ) : '';
$car_mileage_value        = $listing_data ? get_post_meta( $listing_data->ID, 'mileage', true ) : '';
$car_engine_size_value    = $listing_data ? get_post_meta( $listing_data->ID, 'engine_size', true ) : '';
$car_door_value           = $listing_data ? get_post_meta( $listing_data->ID, 'door', true ) : '';
$car_seat_value           = $listing_data ? get_post_meta( $listing_data->ID, 'seat', true ) : '';
$car_city_mpg             = $listing_data ? get_post_meta( $listing_data->ID, 'city_mpg', true ) : '';
$car_highway_mpg          = $listing_data ? get_post_meta( $listing_data->ID, 'highway_mpg', true ) : '';
$car_featured             = $listing_data ? get_post_meta( $listing_data->ID, 'car_featured', true ) : '';
$car_additional_detail    = $listing_data ? get_post_meta( $listing_data->ID, 'listing_additional_detail', true ) : array();
$show_hide_listing_fields = tfcl_get_option( 'show_hide_listing_fields', array() );
?>
<div class="tfcl-field-wrap tfcl-listing-information">
	<div class="tfcl-field-title">
        <h3><?php esc_html_e('Car Details', 'tf-car-listing'); ?></h3>
    </div>
	<div class="tfcl-field tfcl-listing-title">
		<?php if ( current_user_can( 'publish_listings' ) ) : ?>
			<div class="form-group mb-3">
				<div class="checkbox-sc">
					<input type="checkbox" id="car_featured" name="car_featured" value="1" <?php checked( $car_featured, 1 ); ?> />
					<label
						for="car_featured"><?php echo esc_html__( 'Mark this car as featured ?', 'tf-car-listing' ); ?></label>
				</div>
			</div>
		<?php endif; ?>
		<div class="form-group">
			<label
				for="listing_title"><?php echo esc_html__( 'Listing Title ', 'tf-car-listing' ) . tfcl_required_field( 'listing_title', 'required_listing_fields' ); ?></label>
			<input type="text" id="listing_title" class="form-control" name="listing_title"
				placeholder="<?php esc_attr_e( 'Enter title', 'tf-car-listing' ); ?>"
				value="<?php echo esc_attr( $car_title_value ); ?>" />
		</div>
	</div>
	<div class="listing-fields listing-price row">
		<?php if ( $show_hide_listing_fields['make'] == 1 ) : ?>
			<div class="col-xl-3 col-lg-4 col-md-6">
				<div class="form-group">
					<label for="listing_make">
						<?php echo esc_html__( $custom_name_make, 'tf-car-listing' ) . tfcl_required_field( 'make', 'required_listing_fields' ); ?>
					</label>
					<select name="make[]" id="listing_make" class="form-control tfcl-listing-make-ajax add-list-make">
						<?php
						tfcl_get_multiple_taxonomy_by_post_id( $listing_id, 'make', false, true ); ?>
					</select>
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $show_hide_listing_fields['model'] == 1 ) : ?>
			<div class="col-xl-3 col-lg-4 col-md-6">
				<div class="form-group">
					<label for="listing_model">
						<?php echo esc_html__( $custom_name_model, 'tf-car-listing' ) . tfcl_required_field( 'model', 'required_listing_fields' ); ?>
					</label>
					<select name="model[]" id="listing_model" class="form-control tfcl-listing-model-ajax add-list-model">
						<?php
						tfcl_get_multiple_taxonomy_by_post_id( $listing_id, 'model', false, true ); ?>
					</select>
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $show_hide_listing_fields['body'] == 1 ) : ?>
			<div class="col-xl-3 col-lg-4 col-md-6">
				<div class="form-group">
					<label for="listing_body">
						<?php echo esc_html__( $custom_name_body, 'tf-car-listing' ) . tfcl_required_field( 'body', 'required_listing_fields' ); ?>
					</label>
					<select name="body[]" id="listing_body" class="form-control add-list-body">
						<?php
						tfcl_get_multiple_taxonomy_by_post_id( $listing_id, 'body', true, true ); ?>
					</select>
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $show_hide_listing_fields['year'] == 1 ) : ?>
			<div class="col-xl-3 col-lg-4 col-md-6">
				<div class="form-group">
					<label
						for="listing_year"><?php echo esc_html__( $custom_name_year ) . tfcl_required_field( 'year', 'required_listing_fields' ); ?></label>
					<input type="number" id="listing_year" class="form-control" name="year"
						value="<?php echo esc_attr( $car_year_value ); ?>">
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $show_hide_listing_fields['condition'] == 1 ) : ?>
			<div class="col-xl-3 col-lg-4 col-md-6">
				<div class="form-group">
					<label for="listing_condition">
						<?php echo esc_html__( $custom_name_condition, 'tf-car-listing' ) . tfcl_required_field( 'condition', 'required_listing_fields' ); ?>
					</label>
					<select name="condition[]" id="listing_condition" class="form-control">
						<?php
						tfcl_get_multiple_taxonomy_by_post_id( $listing_id, 'condition', true, true ); ?>
					</select>
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $show_hide_listing_fields['stock_number'] == 1 ) : ?>
			<div class="col-xl-3 col-lg-4 col-md-6">
				<div class="form-group">
					<label
						for="listing_stock_number"><?php echo esc_html__( $custom_name_stock_number ) . tfcl_required_field( 'stock_number', 'required_listing_fields' ); ?></label>
					<input type="text" id="listing_stock_number" class="form-control" name="stock_number"
						value="<?php echo esc_attr( $car_stock_number_value ); ?>">
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $show_hide_listing_fields['vin_number'] == 1 ) : ?>
			<div class="col-xl-3 col-lg-4 col-md-6">
				<div class="form-group">
					<label
						for="vin_number"><?php echo esc_html__( $custom_name_vin_number ) . tfcl_required_field( 'vin_number', 'required_listing_fields' ); ?></label>
					<input type="text" id="vin_number" class="form-control" name="vin_number"
						value="<?php echo esc_attr( $car_vin_number ); ?>">
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $show_hide_listing_fields['mileage'] == 1 ) : ?>
			<div class="col-xl-3 col-lg-4 col-md-6">
				<div class="form-group">
					<label
						for="listing_mileage"><?php echo esc_html__( $custom_name_mileage ) . tfcl_required_field( 'mileage', 'required_listing_fields' ); ?></label>
					<input type="number" id="listing_mileage" class="form-control" name="mileage"
						value="<?php echo esc_attr( $car_mileage_value ); ?>">
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $show_hide_listing_fields['transmission'] == 1 ) : ?>
			<div class="col-xl-3 col-lg-4 col-md-6">
				<div class="form-group">
					<label for="isting_transmission">
						<?php echo esc_html__( $custom_name_transmission, 'tf-car-listing' ) . tfcl_required_field( 'transmission', 'required_listing_fields' ); ?>
					</label>
					<select name="transmission[]" id="listing_transmission" class="form-control">
						<?php
						tfcl_get_multiple_taxonomy_by_post_id( $listing_id, 'transmission', true, true ); ?>
					</select>
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $show_hide_listing_fields['drive-type'] == 1 ) : ?>
			<div class="col-xl-3 col-lg-4 col-md-6">
				<div class="form-group">
					<label for="listing_drive_type">
						<?php echo esc_html__( $custom_name_drive_type, 'tf-car-listing' ) . tfcl_required_field( 'drive-type', 'required_listing_fields' ); ?>
					</label>
					<select name="drive-type[]" id="listing_drive_type" class="form-control">
						<?php
						tfcl_get_multiple_taxonomy_by_post_id( $listing_id, 'drive-type', true, true ); ?>
					</select>
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $show_hide_listing_fields['engine_size'] == 1 ) : ?>
			<div class="col-xl-3 col-lg-4 col-md-6">
				<div class="form-group">
					<label
						for="listing_engine_size"><?php echo esc_html__( $custom_name_engine_size ) . tfcl_required_field( 'engine_size', 'required_listing_fields' ); ?></label>
					<input type="text" id="listing_engine_size" class="form-control" name="engine_size"
						value="<?php echo esc_attr( $car_engine_size_value ); ?>">
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $show_hide_listing_fields['cylinders'] == 1 ) : ?>
			<div class="col-xl-3 col-lg-4 col-md-6">
				<div class="form-group">
					<label for="listing_cylinders">
						<?php echo esc_html__( $custom_name_cylinders, 'tf-car-listing' ) . tfcl_required_field( 'cylinders', 'required_listing_fields' ); ?>
					</label>
					<select name="cylinders[]" id="listing_cylinders" class="form-control">
						<?php
						tfcl_get_multiple_taxonomy_by_post_id( $listing_id, 'cylinders', true, true ); ?>
					</select>
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $show_hide_listing_fields['fuel-type'] == 1 ) : ?>
			<div class="col-xl-3 col-lg-4 col-md-6">
				<div class="form-group">
					<label for="listing_fuel_type">
						<?php echo esc_html__( $custom_name_fuel_type, 'tf-car-listing' ) . tfcl_required_field( 'fuel-type', 'required_listing_fields' ); ?>
					</label>
					<select name="fuel-type[]" id="listing_fuel_type" class="form-control">
						<?php
						tfcl_get_multiple_taxonomy_by_post_id( $listing_id, 'fuel-type', true, true ); ?>
					</select>
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $show_hide_listing_fields['door'] == 1 ) : ?>
			<div class="col-xl-3 col-lg-4 col-md-6">
				<div class="form-group">
					<label
						for="listing_door"><?php echo esc_html__( $custom_name_door ) . tfcl_required_field( 'door', 'required_listing_fields' ); ?></label>
					<input type="number" id="listing_door" class="form-control" name="door"
						value="<?php echo esc_attr( $car_door_value ); ?>">
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $show_hide_listing_fields['car-color'] == 1 ) : ?>
			<div class="col-xl-3 col-lg-4 col-md-6">
				<div class="form-group">
					<label for="listing_car_color">
						<?php echo esc_html__( $custom_name_color, 'tf-car-listing' ) . tfcl_required_field( 'car-color', 'required_listing_fields' ); ?>
					</label>
					<select name="car-color[]" id="listing_car_color" class="form-control" >
						<?php
						tfcl_get_multiple_taxonomy_by_post_id( $listing_id, 'car-color', true, true ); ?>
					</select>
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $show_hide_listing_fields['seat'] == 1 ) : ?>
			<div class="col-xl-3 col-lg-4 col-md-6">
				<div class="form-group">
					<label
						for="listing_seat"><?php echo esc_html__( $custom_name_seat ) . tfcl_required_field( 'seat', 'required_listing_fields' ); ?></label>
					<input type="number" id="listing_seat" class="form-control" name="seat"
						value="<?php echo esc_attr( $car_seat_value ); ?>">
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $show_hide_listing_fields['city_mpg'] == 1 ) : ?>
			<div class="col-xl-3 col-lg-4 col-md-6">
				<div class="form-group">
					<label
						for="listing_city_mpg"><?php echo esc_html__( $custom_name_city_mpg ) . tfcl_required_field( 'city_mpg', 'required_listing_fields' ); ?></label>
					<input type="number" id="listing_city_mpg" class="form-control" name="city_mpg"
						value="<?php echo esc_attr( $car_city_mpg ); ?>">
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $show_hide_listing_fields['highway_mpg'] == 1 ) : ?>
			<div class="col-xl-3 col-lg-4 col-md-6">
				<div class="form-group">
					<label
						for="listing_highway_mpg"><?php echo esc_html__( $custom_name_highway_mpg ) . tfcl_required_field( 'highway_mpg', 'required_listing_fields' ); ?></label>
					<input type="number" id="listing_highway_mpg" class="form-control" name="highway_mpg"
						value="<?php echo esc_attr( $car_highway_mpg ); ?>">
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $show_hide_listing_fields['listing_description'] == 1 ) : ?>
		<div class="tfcl-field tfcl-listing-description">

			<div class="form-group">
				<label for="listing_description"><?php echo esc_html__( 'Description ', 'tf-car-listing' ); ?></label>
				<?php
				$description = $listing_data ? $listing_data->post_content : '';
				$editor_id   = 'listing_description';
				$settings    = array(
					'wpautop'       => true,
					'media_buttons' => false,
					'textarea_name' => $editor_id,
					'textarea_rows' => get_option( 'default_post_edit_rows', 5 ),
					'teeny'         => false,
					'dfw'           => false,
					'tinymce'       => true,
					'quicktags'     => true,
					'editor_css'    => '',
					'editor_class'  => '',
				);
				wp_editor( $description, $editor_id, $settings ); ?>
			</div>
		</div>
	<?php endif; ?>
		<?php
		$get_additional_fields = tfcl_get_additional_fields();
		if ( is_array( $get_additional_fields ) && count( $get_additional_fields ) > 0 ) {

echo '<div class="col-xl-12"><div class="tfcl-field-title mb-3">' 
    . esc_html__( 'Additional Custom Fields', 'tf-car-listing' ) 
    . '</div></div>';

		


			foreach ( $get_additional_fields as $key => $field ) {
				switch ( $field['type'] ) {
					case 'text':
						?>
						<div class="col-xl-12">
							<div class="form-group">
								<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html__( $field['title'] ); ?></label>
								<input type="text" id="<?php echo esc_attr( $key ); ?>" class="form-control"
									name="<?php echo esc_attr( $key ); ?>" value="<?php if ( isset( $listing_meta_data[ $key ] ) ) {
											 echo esc_attr( $listing_meta_data[ $key ][0] );
										 } ?>" />
							</div>
						</div>
						<?php
						break;
					case 'textarea':
						?>
						<div class="col-xl-12">
							<div class="form-group">
								<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html__( $field['title'] ); ?></label>
								<textarea name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" rows="3"
									class="form-control"><?php if ( isset( $listing_meta_data[ $key ] ) ) {
										echo esc_attr( $listing_meta_data[ $key ][0] );
									} ?></textarea>
							</div>
						</div>
						<?php
						break;
					case 'select':
						?>
						<div class="col-xl-12">
							<div class="form-group">
								<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html__( $field['title'] ); ?></label>
								<select class="form-control" name="<?php echo esc_attr( $key ); ?>"
									id="<?php echo esc_attr( $key ); ?>">
									<?php foreach ( $field['choices'] as $opt_key => $opt_value ) : ?>
										<option value="<?php echo esc_attr( $opt_key ); ?>" <?php echo esc_attr( isset( $listing_meta_data[ $key ] ) ? selected( $listing_meta_data[ $key ][0], $opt_key, false ) : '' ) ?>>
											<?php echo esc_html__( $opt_value ); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<?php
						break;
					case 'radio':
						?>
						<div class="col-sm-12">
							<div class="form-group">
								<label><?php echo esc_html__( $field['title'] ); ?></label>
								<div class="field-<?php echo esc_attr( $key ); ?>">
									<?php foreach ( $field['choices'] as $opt_key => $opt_value ) : ?>
										<input type="radio" id="<?php echo esc_attr( $opt_key ); ?>" name="<?php echo esc_attr( $key ); ?>"
											value="<?php echo esc_attr( $opt_key ); ?>" <?php echo esc_attr( isset( $listing_meta_data[ $key ] ) ? checked( $listing_meta_data[ $key ][0], $opt_key ) : checked( $field['default'], $opt_key ) ); ?> />
										<label class="radio-inline"
											for="<?php echo esc_attr( $opt_key ); ?>"><?php echo esc_html__( $opt_value['label'] ); ?></label>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
						<?php
						break;
					case 'checkbox':
						?>
						<div class="col-sm-12">
							<div class="form-group">
								<label><?php echo esc_html__( $field['title'] ); ?></label>
								<div class="field-<?php echo esc_attr( $key ); ?>">
									<?php
									$arr_value_checkbox_field = $listing_data ? get_post_meta( $listing_data->ID, $key, true ) : array();
									if ( empty( $arr_value_checkbox_field ) ) {
										$arr_value_checkbox_field = array();
									}
									foreach ( $field['choices'] as $opt_key => $opt_value ) : ?>
										<input type="checkbox" id="<?php echo esc_attr( $opt_key ); ?>"
											name="<?php echo esc_attr( $key ); ?>[]" value="<?php echo esc_attr( $opt_key ); ?>" <?php echo esc_attr( in_array( $opt_key, $arr_value_checkbox_field ) ? 'checked' : '' ); ?> />
										<label for="<?php echo esc_attr( $opt_key ); ?>" class="group-checkbox">
											<?php echo esc_html__( $opt_value['label'] ); ?>
										</label>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
						<?php
						break;
						case 'date':
							?>
							<div class="col-xl-12">
								<div class="form-group">
									<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html__( $field['title'] ); ?></label>
									<input type="date" id="<?php echo esc_attr( $key ); ?>" class="form-control datetimepicker hasDatepicker"
										name="<?php echo esc_attr( $key ); ?>" value="<?php if ( isset( $listing_meta_data[ $key ] ) ) {
												 echo esc_attr( $listing_meta_data[ $key ][0] );
											 } ?>" />
								</div>
							</div>
							<?php
							break;
					default:
						# code...
						break;
				}
			}
		}
		?>
		<?php if ( $show_hide_listing_fields['listing_additional_detail'] == 1 ) : ?>
			<div class="col-sm-12">
				<div class="listing-additional-detail">
					<div class="tfcl-field-title">
        				<h4><?php esc_html_e( 'Additional Detail', 'tf-car-listing' ); ?></h4>
    				</div>
					<table class="additional-block">
						<thead>
							<tr>
								<td><label><?php esc_html_e( 'Icon SVG', 'tf-car-listing' ); ?></label></td>
								<td><label><?php esc_html_e( 'Title', 'tf-car-listing' ); ?></label></td>
								<td><label><?php esc_html_e( 'Value', 'tf-car-listing' ) ?></label></td>
								<td class="column-action"></td>
							</tr>
						</thead>
						<tbody id="tfcl_additional_detail">
							<?php if ( ! empty( $car_additional_detail ) ) {
								$row_index = 0;
								foreach ( $car_additional_detail as $index => $additional_detail ) { ?>
									<tr>
										<td>
											<input type="text" class="form-control"
												name="listing_additional_detail[<?php echo esc_attr( $index ); ?>][additional_detail_icon]"
												id="additional_detail_icon_<?php echo esc_attr( $index ); ?>"
												value="<?php echo esc_attr( $additional_detail['additional_detail_icon'] ); ?>" />
										</td>
										<td>
											<input type="text" class="form-control"
												name="listing_additional_detail[<?php echo esc_attr( $index ); ?>][additional_detail_title]"
												id="additional_detail_title_<?php echo esc_attr( $index ); ?>"
												value="<?php echo esc_attr( $additional_detail['additional_detail_title'] ); ?>" />
										</td>
										<td>
											<input type="text" class="form-control"
												name="listing_additional_detail[<?php echo esc_attr( $index ); ?>][additional_detail_value]"
												id="additional_detail_value_<?php echo esc_attr( $index ); ?>"
												value="<?php echo esc_attr( $additional_detail['additional_detail_value'] ); ?>" />
										</td>
										<td>
											<span class="remove-additional-detail"><i class="icon-autodeal-close"></i></span>
										</td>
									</tr>
									<?php $row_index++;
								}
							} else {
								?>
								<tr>
									<td>
										<input type="text" class="form-control"
											name="listing_additional_detail[0][additional_detail_icon]"
											id="additional_detail_icon_0"
											value="" />
									</td>
									<td>
										<input type="text" class="form-control"
											name="listing_additional_detail[0][additional_detail_title]"
											id="additional_detail_title_0"
											value="" />
									</td>
									<td>
										<input type="text" class="form-control"
											name="listing_additional_detail[0][additional_detail_value]"
											id="additional_detail_value_0"
											value="" />
									</td>
									<td>
										<span class="remove-additional-detail"><i class="icon-autodeal-close"></i></span>
									</td>
								</tr>
							<?php } ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="3">
									<button type="button"
										data-increment="<?php echo esc_attr( empty( $car_additional_detail ) ? 0 : ( $row_index - 1 ) ); ?>"
										class="add-additional-detail"><i
											class="fa fa-flus"></i><?php esc_html_e( 'Add New', 'tf-car-listing' ); ?></button>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>