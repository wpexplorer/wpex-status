<?php
/**
 * Font Awesome social widget
 *
 * Learn more: http://codex.wordpress.org/Widgets_API
 *
 */

// Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

// Start widget class
if ( ! class_exists( 'STATUS_Social_Profiles_Widget' ) ) {
	class STATUS_Social_Profiles_Widget extends WP_Widget {
		private $social_services_array = array();

		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		function __construct() {

			// Declare social services array
			$this->social_services_array = apply_filters( 'st_social_widget_profiles', array(
				'twitter' => array(
					'name' => 'Twitter',
					'url' => ''
				),
				'facebook' => array(
					'name' => 'Facebook',
					'url' => ''
				),
				'google-plus' => array(
					'name' => 'Google',
					'url' => ''
				),
				'instagram' => array(
					'name' => 'Instagram',
					'url' => ''
				),
				'bloglovin' => array(
					'name' => 'Bloglovin\'',
					'url' => '',
				),
				'linkedin' => array(
					'name' => 'LinkedIn',
					'url' => ''
				),
				'pinterest' => array(
					'name' => 'Pinterest',
					'url' => ''
				),
				'dribbble' => array(
					'name' => 'Dribbble',
					'url' => ''
				),
				'flickr' => array(
					'name' => 'Flickr',
					'url' => ''
				),
				'vimeo-square' => array(
					'name' => 'Vimeo',
					'url' => ''
				),
				'youtube' => array(
					'name' => 'Youtube',
					'url' => '',
				),
				'vk' => array(
					'name' => 'VK',
					'url' => ''
				),
				'github' => array(
					'name' => 'GitHub',
					'url' => ''
				),
				'tumblr' => array(
					'name' => 'Tumblr',
					'url' => ''
				),
				'skype' => array(
					'name' => 'Skype',
					'url' => ''
				),
				'trello' => array(
					'name' => 'Trello',
					'url' => ''
				),
				'foursquare' => array(
					'name' => 'Foursquare',
					'url' => ''
				),
				'renren' => array(
					'name' => 'RenRen',
					'url' => ''
				),
				'xing' => array(
					'name' => 'Xing',
					'url' => ''
				),
				'rss' => array(
					'name' => 'RSS',
					'url' => ''
				),
				'email' => array(
					'name' => esc_html__( 'Email', 'status' ),
					'url' => ''
				),
			) );

			// Start widget class
			parent::__construct(
				'st_social_profiles',
				esc_html__( 'Social Profiles', 'status' )
			);

			// Load scripts
			add_action( 'admin_enqueue_scripts', array( 'STATUS_Social_Profiles_Widget', 'scripts' ) );

		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 * @since 1.0.0
		 *
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {
			extract( $args );
			$title           = isset( $instance['title'] ) ? $instance['title'] : '';
			$title           = apply_filters( 'widget_title', $title );
			$description     = isset( $instance['description'] ) ? $instance['description'] : '';
			$target_blank    = ( isset( $instance['target'] ) && 'blank' == $instance['target'] ) ? true : false;
			$social_services = isset( $instance['social_services'] ) ? $instance['social_services'] : ''; ?>
			<?php echo st_sanitize( $before_widget, 'html' ); ?>
				<?php if ( $title ) echo st_sanitize( $before_title . $title . $after_title, 'html' ); ?>
				<div class="st-social-profiles-widget st-clr">
					<?php
					// Description
					if ( $description ) { ?>
						<div class="desc st-clr">
							<?php echo st_sanitize( $description, 'html' ); ?>
						</div>
					<?php } ?>
					<ul class="st-clr">
						<?php
						// Original Array
						$social_services_array = $this->social_services_array;

						// Loop through each item in the array
						foreach( $social_services as $key => $val ) {
							$link     = ! empty( $val['url'] ) ? esc_url( $val['url'] ) : null;
							$name     = $social_services_array[$key]['name'];
							$nofollow = isset( $social_services_array[$key]['nofollow'] ) ? ' rel="nofollow"' : '';
							if ( $link ) {
								$key  = 'vimeo-square' == $key ? 'vimeo' : $key;
								$icon = 'youtube' == $key ? 'youtube-play' : $key;
								$icon = 'bloglovin' == $key ? 'heart' : $icon;
								$icon = 'email' == $key ? 'envelope' : $icon;
								$icon = 'vimeo-square' == $key ? 'vimeo' : $icon;
								echo '<li>
										<a href="'. esc_url( $link ) .'" title="'. esc_attr( $name ) .'" class="st-social-bg st-'. $key .'"'. st_get_target_blank( $target_blank ) . $nofollow .'><span class="fa fa-'. $icon .'"></span></a>
									</li>';
							}
						} ?>
					</ul>
				</div>
			<?php echo st_sanitize( $after_widget, 'html' ); ?>
			<?php
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 * @since 1.0.0
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = ! empty( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['description'] = ! empty( $new_instance['description'] ) ? esc_html( $new_instance['description'] ) : '';
			$instance['target'] = ! empty( $new_instance['target'] ) ? strip_tags( $new_instance['target'] ) : '';
			$instance['social_services'] = ! empty( $new_instance['social_services'] ) ? $new_instance['social_services'] : array();
			return $instance;
		}

		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 * @since 1.0.0
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {
			$defaults = array(
				'title'           => esc_html__( 'Follow Us', 'status' ),
				'description'     => '',
				'font_size'       => '',
				'border_radius'   => '',
				'target'          => 'blank',
				'size'            => '',
				'social_services' => $this->social_services_array
			);
			$instance = wp_parse_args( ( array ) $instance, $defaults );  ?>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'status' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e( 'Description:','status' ); ?></label>
				<textarea class="widefat" rows="5" cols="20" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"><?php echo esc_html( $instance['description'] ); ?></textarea>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><?php esc_html_e( 'Link Target:', 'status' ); ?></label>
				<br />
				<select class='st-widget-select' name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>">
					<option value="blank" <?php if ( $instance['target'] == 'blank' ) { ?>selected="selected"<?php } ?>><?php esc_html_e( 'Blank', 'status' ); ?></option>
					<option value="self" <?php if ( $instance['target'] == 'self' ) { ?>selected="selected"<?php } ?>><?php esc_html_e( 'Self', 'status' ); ?></option>
				</select>
			</p>

			<?php
			$field_id_services   = $this->get_field_id( 'social_services' );
			$field_name_services = $this->get_field_name( 'social_services' ); ?>
			<h3 style="margin-top:20px;margin-bottom:0;"><?php esc_html_e( 'Social Links','status' ); ?></h3> 
			<small style="display:block;margin-bottom:10px;"><?php esc_html_e( 'Drag and drop to re-order items.', 'status' ); ?></small>
			<ul id="<?php echo esc_attr( $field_id_services ); ?>" class="st-services-list">
				<input type="hidden" id="<?php echo esc_attr( $field_name_services ); ?>" value="<?php echo esc_attr( $field_name_services ); ?>">
				<input type="hidden" id="<?php echo wp_create_nonce( 'st_fontawesome_social_widget_nonce' ); ?>">
				<?php
				// Social array
				$social_services_array = $this->social_services_array;
				// Get current services display
				$display_services = isset ( $instance['social_services'] ) ? $instance['social_services']: '';
				// Loop through social services to display inputs
				foreach( $display_services as $key => $val ) {
					$url  = ! empty( $val['url'] ) ? esc_url( $val['url'] ) : null;
					$name = $social_services_array[$key]['name']; ?>
					<li id="<?php echo esc_attr( $field_id_services ); ?>_0<?php echo esc_attr( $key ); ?>">
						<p>
							<label for="<?php echo esc_attr( $field_id_services ); ?>-<?php echo esc_attr( $key ); ?>-name"><?php echo esc_attr( $name ); ?>:</label>
							<input type="hidden" id="<?php echo esc_attr( $field_id_services ); ?>-<?php echo esc_attr( $key ); ?>-url" name="<?php echo esc_attr( $field_name_services .'['.$key.'][name]' ); ?>" value="<?php echo esc_attr( $name ); ?>">
							<input type="url" class="widefat" id="<?php echo esc_attr( $field_id_services ); ?>-<?php echo esc_attr( $key ) ?>-url" name="<?php echo esc_attr( $field_name_services .'['.$key.'][url]' ); ?>" value="<?php echo esc_attr( $url ); ?>" />
						</p>
					</li>
				<?php } ?>
			</ul>
			
		<?php
		}

		/**
		 * Load scripts for this widget
		 *
		 */
		public static function scripts( $hook ) {

			if ( $hook != 'widgets.php' ) {
				return;
			}

			$dir = get_template_directory_uri() .'/inc/classes/widgets/assets/';

			wp_enqueue_style( 'st-social-widget', $dir .'st-social-widget.css' );
			wp_enqueue_script( 'st-social-widget', $dir .'st-social-widget.js', array( 'jquery' ), false, true );

		}

	}
}

// Register the STATUS_Tabs_Widget custom widget
if ( ! function_exists( 'st_register_social_profiles_widget' ) ) {
	function st_register_social_profiles_widget() {
		register_widget( 'STATUS_Social_Profiles_Widget' );
	}
}
add_action( 'widgets_init', 'st_register_social_profiles_widget' );