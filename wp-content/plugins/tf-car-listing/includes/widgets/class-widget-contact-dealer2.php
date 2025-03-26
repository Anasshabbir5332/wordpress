<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Widget_Contact_Dealer2' ) ) {
	class Widget_Contact_Dealer2 extends WP_Widget {
		public function __construct() {
			parent::__construct(
				'dealer_contact_widget2',
				esc_html__( 'Dealer Contact Single Dealer', 'tf-car-listing' ),
				array(
					'description' => esc_html__( 'Widget for display Dealer infomation contact', 'tf-car-listing' )
				)
			);
		}

		public function widget( $args, $instance ) {
			$args['title_form_1']                               = ! empty( $instance['title_form_1'] ) ? __( $instance['title_form_1'], 'tf-car-listing' ) : __( '' );
			$args['title_form_2']                               = ! empty( $instance['title_form_2'] ) ? __( $instance['title_form_2'], 'tf-car-listing' ) : __( '' );
			$args['form_short_code_1']           = ! empty( $instance['form_short_code_1'] ) ? $instance['form_short_code_1'] : __( '' );
			$args['form_short_code_2']           = ! empty( $instance['form_short_code_2'] ) ? $instance['form_short_code_2'] : __( '' );

			echo $args['before_widget'];
			echo tfcl_get_template_with_arguments( 'widgets/dealer/dealer-contact-2.php', array( 'args' => $args, 'instance' => $instance ) );
            if ( ! empty( $args['form_short_code_1'] ) ) {
			echo '<div class="form-sc-1"><div class="overlay-form"></div><div class="inner"><i class="button-close icon-autodeal-close"></i>';
                echo do_shortcode( $args['form_short_code_1'] );    
            echo '</div></div>';
			}
            if ( ! empty( $args['form_short_code_2'] ) ) {
            echo '<div class="form-sc-2"><div class="overlay-form"></div><div class="inner"><i class="button-close icon-autodeal-close"></i>';
                echo do_shortcode( $args['form_short_code_2'] );
            echo '</div></div>';
			}
			echo $args['after_widget'];
		}

		public function form( $instance ) {
			$form_short_code_1           = ! empty( $instance['form_short_code_1'] ) ? $instance['form_short_code_1'] : __( '' );
			$form_short_code_2           = ! empty( $instance['form_short_code_2'] ) ? $instance['form_short_code_2'] : __( '' );
			$title_form_1                     = ! empty( $instance['title_form_1'] ) ? __( $instance['title_form_1'], 'tf-car-listing' ) : __( 'Get quote', 'tf-car-listing' );
			$title_form_2                     = ! empty( $instance['title_form_2'] ) ? __( $instance['title_form_2'], 'tf-car-listing' ) : __( 'Request test drive', 'tf-car-listing' );
			?>
			<p>
				<label
					for="<?php echo esc_attr( $this->get_field_name( 'title_form_1' ) ); ?>"><?php _e( 'Text Button Form 1:', 'tf-car-listing' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_form_1' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'title_form_1' ) ); ?>" type="text"
					value="<?php echo esc_attr( $title_form_1 ); ?>" />
			</p>
			<p>
				<label
					for="<?php echo esc_attr( $this->get_field_name( 'title_form_2' ) ); ?>"><?php _e( 'Text Button Form 2:', 'tf-car-listing' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_form_2' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'title_form_2' ) ); ?>" type="text"
					value="<?php echo esc_attr( $title_form_2 ); ?>" />
			</p>
			<p>
				<label
					for="<?php echo esc_attr( $this->get_field_name( 'form_short_code_1' ) ); ?>"><?php _e( 'Shortcode Contact Form 1:', 'tf-car-listing' ); ?></label>
				<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'form_short_code_1' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'form_short_code_1' ) ); ?>" type="text" cols="20"
					rows="3"><?php echo esc_attr( $form_short_code_1 ); ?></textarea>
			</p>
			<p>
				<label
					for="<?php echo esc_attr( $this->get_field_name( 'form_short_code_2' ) ); ?>"><?php _e( 'Shortcode Contact Form 2:', 'tf-car-listing' ); ?></label>
				<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'form_short_code_2' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'form_short_code_2' ) ); ?>" type="text" cols="20"
					rows="3"><?php echo esc_attr( $form_short_code_2 ); ?></textarea>
			</p>
			<?php
		}

		public function update( $new_instance, $old_instance ) {
			$instance                         = array();
			$instance['form_short_code_1']           = ( ! empty( $new_instance['form_short_code_1'] ) ) ? strip_tags( $new_instance['form_short_code_1'] ) : '';
			$instance['form_short_code_2']           = ( ! empty( $new_instance['form_short_code_2'] ) ) ? strip_tags( $new_instance['form_short_code_2'] ) : '';
			$instance['title_form_1']                     = ( ! empty( $new_instance['title_form_1'] ) ) ? wp_kses_post( $new_instance['title_form_1'] ) : '';
			$instance['title_form_2']                     = ( ! empty( $new_instance['title_form_2'] ) ) ? wp_kses_post( $new_instance['title_form_2'] ) : '';
			return $instance;
		}
	}
}
?>