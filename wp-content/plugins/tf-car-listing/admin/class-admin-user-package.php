<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! class_exists( 'Admin_User_Package' ) ) {
	/**
	 * Class Admin_User_Package
	 */
	class Admin_User_Package {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function tfcl_register_custom_column_titles( $columns ) {
			$columns['cb']             = "<input type=\"checkbox\" />";
			$columns['title']          = esc_html__( 'Title', 'tf-car-listing' );
			$columns['package']        = esc_html__( 'Package', 'tf-car-listing' );
			$columns['number_listing'] = esc_html__( 'Number Listing', 'tf-car-listing' );
			$columns['activate_date']  = esc_html__( 'Activate Date', 'tf-car-listing' );
			$columns['expired_date']   = esc_html__( 'Expired Date', 'tf-car-listing' );
			$columns['user_id']        = esc_html__( 'Buyer', 'tf-car-listing' );
			$new_columns               = array();
			$custom_order              = array(
				'cb',
				'title',
				'package',
				'number_listing',
				'activate_date',
				'expired_date',
				'user_id'
			);
			foreach ( $custom_order as $colname ) {
				$new_columns[ $colname ] = $columns[ $colname ];
			}
			return $new_columns;
		}

		public function tfcl_display_column_value( $column ) {
			global $post;
			$user_id                          = get_post_meta( $post->ID, 'package_user_id', true );
			$package_id                       = get_user_meta( $user_id, 'package_id', true );
			$package_available_number_listing = get_user_meta( $user_id, 'package_number_listing', true );
			$package_activate_date            = get_user_meta( $user_id, 'package_activate_date', true );
			$package_expired_date             = User_Package_Public::tfcl_get_expired_date( $package_id, $user_id );
			$package_name                     = get_the_title( $package_id );
			$user_info                        = get_userdata( $user_id );
			switch ( $column ) {
				case 'user_id':
					if ( $user_info ) {
						echo esc_html__( $user_info->display_name );
					}
					break;
				case 'package':
					echo esc_html__( $package_name );
					break;
				case 'number_listing':
					if ( $package_available_number_listing == -1 ) {
						esc_html_e( 'Unlimited', 'tf-car-listing' );
					} else {
						echo esc_html__( $package_available_number_listing );
					}
					break;
				case 'activate_date':
					echo esc_html__( $package_activate_date );
					break;
				case 'expired_date':
					echo esc_html__( $package_expired_date );
					break;
				default:
					# code...
					break;
			}
		}

		public function tfcl_filter_restrict_manage_user_package() {
			global $typenow;

			if ( $typenow == 'user-package' ) {
				//Buyer
				$package_buyer = isset( $_GET['package_buyer'] ) ? wp_unslash( $_GET['package_buyer'] ) : '';
				?>
				<input type="text" placeholder="<?php echo esc_attr__( 'Buyer', 'tf-car-listing' ); ?>" name="package_buyer"
					value="<?php echo esc_attr( $package_buyer ); ?>">
				<?php
			}
		}

        public function tfcl_handle_filter_restrict_manage_user_package($query){
            global $pagenow;
            $query_vars = &$query->query_vars;
            $filter_array = array();
            if ( $pagenow == 'edit.php' && isset( $query_vars['post_type'] ) && $query_vars['post_type'] == 'user-package' ) {
                $package_buyer = isset( $_GET['package_buyer'] ) ? wp_unslash( $_GET['package_buyer'] ) :'';
                if($package_buyer != ''){
                    $user = get_user_by('login', $package_buyer );
                    $user_id = -1;
                    if($user){
                        $user_id = $user->ID;
                    }
                    $filter_array[] = array(
                        'key' =>  'package_user_id',
                        'value' => $user_id,
                        'compare' => 'IN'
                    );
                }

                if(!empty($filter_array)){
                    $query_vars['meta_query'] = $filter_array;
                }
            }
        }

        public function tfcl_delete_user_package($post_ID){
            $user_id = get_post_meta($post_ID,'package_user_id', true);
            delete_post_meta($post_ID,'package_user_id');
            delete_user_meta($user_id,'package_number_listing');
            delete_user_meta($user_id,'package_activate_date');
            delete_user_meta($user_id,'package_id');
            delete_user_meta($user_id,'free_package');
        }
	}
}