<?php
/**
 * About widget
 *
 */

// Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

// Start widget class
if ( ! class_exists( 'STATUS_About_Widget' ) ) {

	class STATUS_About_Widget extends WP_Widget {
		
		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			parent::__construct(
				'st_about',
				esc_html__( 'About', 'status' )
			);
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

			// Extract args
			extract( $args );

			// Args
			$title       = isset( $instance['title'] ) ? $instance['title'] : '';
			$title       = apply_filters( 'widget_title', $title );
			$image       = isset( $instance['image'] ) ? esc_url( $instance['image'] ) : '';
			$description = isset( $instance['description'] ) ? $instance['description'] : '';

			// Before widget hook
			echo st_sanitize( $before_widget, 'html' ); ?>

				<?php
				// Display widget title
				if ( $title ) {
					echo st_sanitize( $before_title . $title . $after_title, 'html' );
				} ?>

				<div class="st-about-widget st-clr">

					<?php
					// Display the image
					if ( $image ) : ?>

						<div class="st-about-widget-image">
							<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>" />
						</div><!-- .st-about-widget-description -->

					<?php endif; ?>

					<?php
					// Display the description
					if ( $description ) : ?>

						<div class="st-about-widget-description">
							<?php echo st_sanitize( $description, 'html' ); ?>
						</div><!-- .st-about-widget-description -->

					<?php endif; ?>

				</div><!-- .mailchimp-widget -->

			<?php
			// After widget hook
			echo st_sanitize( $after_widget, 'html' );
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
			$instance                = $old_instance;
			$instance['title']       = strip_tags( $new_instance['title'] );
			$instance['image']       = esc_url( $new_instance['image'] );
			$instance['description'] = esc_html( $new_instance['description'] );
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
			$instance = wp_parse_args( ( array ) $instance, array(
				'title'       => esc_html__( 'About Me', 'status' ),
				'image'       => '',
				'description' => '',

			) ); ?>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'status' ); ?>:</label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title','status' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php esc_html_e( 'Image URL', 'status' ); ?>:</label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image','status' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['image'] ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e( 'Description:','status' ); ?></label>
				<textarea class="widefat" rows="5" cols="20" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"><?php echo st_sanitize( $instance['description'] ); ?></textarea>
			</p>
			<?php
		}
	}
}

// Register the STATUS_Tabs_Widget custom widget
if ( ! function_exists( 'st_register_about_widget' ) ) {
	function st_register_about_widget() {
		register_widget( 'STATUS_About_Widget' );
	}
}
add_action( 'widgets_init', 'st_register_about_widget' );