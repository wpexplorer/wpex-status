<?php
/**
 * Google Map
 *
 * Learn more: http://codex.wordpress.org/Widgets_API
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start class
class STATUS_Google_Map extends WP_Widget {
	
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {

		parent::__construct(
			'st_gmap_widget',
			esc_html__( 'Google Map', 'status' )
		);

	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	function widget( $args, $instance ) {

		// Extract args
		extract( $args );

		// Set vars for widget usage
		$title       = isset( $instance['title'] ) ? $instance['title'] : '';
		$title       = apply_filters( 'widget_title', $title );
		$description = isset( $instance['description'] ) ? $instance['description'] : '';
		$embed_code  = isset( $instance['embed_code'] ) ? $instance['embed_code'] : '';
		$height      = isset( $instance['height'] ) ? intval( $instance['height'] ) : '';

		// Before widget WP hook
		echo st_sanitize( $before_widget, 'html' );

		// Display title if defined
		if ( $title ) {
			echo st_sanitize( $before_title . $title . $after_title, 'html' );
		} ?>

		<div class="st-gmap-widget st-clr">

			<?php if ( $description ) : ?>

				<div class="st-gmap-widget-description st-clr">
					<?php echo wpautop( $description ); ?>
				</div><!-- .st-gmap-widget-description -->

			<?php endif; ?>

			<?php if ( $embed_code ) :

				// Parse size
				if ( is_numeric( $height ) ) {
					$embed_code = preg_replace( '/height="[0-9]*"/', 'height="' . $height . '"', $embed_code );
				} ?>

				<div class="st-gmap-widget-embed st-clr">
					<?php echo st_sanitize( $embed_code, 'embed' ); ?>
				</div><!-- .st-gmap-widget-embed -->

			<?php endif; ?>

		</div><!-- .st-info-widget -->

		<?php
		// After widget WP hook
		echo st_sanitize( $after_widget, 'html' ); ?>
		
	<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	function update( $new_instance, $old_instance ) {
		$instance                = $old_instance;
		$instance['title']       = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? $new_instance['description'] : '';
		$instance['embed_code']  = ( ! empty( $new_instance['embed_code'] ) ) ? $new_instance['embed_code'] : '';
		$instance['height']      = ( ! empty( $new_instance['height'] ) ) ? intval( $new_instance['height'] ) : '';
		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		$instance = wp_parse_args( ( array ) $instance, array(
			'title'        => esc_html__( 'Google Map', 'status' ),
			'description'  => '',
			'embed_code'   => '',
			'height'       => '',
		) );

		// Extract
		extract( $instance ); ?>

		<?php /* Title */ ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'status' ); ?></label>
			<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<?php /* Description */ ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>">
			<?php esc_html_e( 'Description', 'status' ); ?></label>
			<textarea rows="5" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>" type="text"><?php echo stripslashes( $instance['description'] ); ?></textarea>
		</p>

		<?php /* Embed code */ ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'embed_code' ) ); ?>">
			<?php esc_html_e( 'Embed Code', 'status' ); ?></label>
			<textarea rows="5" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'embed_code' ) ); ?>" type="text"><?php echo stripslashes( $instance['embed_code'] ); ?></textarea>
		</p>

		<?php /* Height */ ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>"><?php esc_html_e( 'Height', 'status' ); ?></label>
			<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>" type="text" value="<?php echo esc_attr( $height ); ?>" />
		</p>

		
	<?php
	}
}

// Register the widget
function st_register_google_map_widget() {
	register_widget( 'STATUS_Google_Map' );
}
add_action( 'widgets_init', 'st_register_google_map_widget' );