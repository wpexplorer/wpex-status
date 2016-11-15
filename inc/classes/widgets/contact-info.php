<?php
/**
 * Contact Info Widget
 *
 * Learn more: http://codex.wordpress.org/Widgets_API
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start class
class STATUS_Info_Widget extends WP_Widget {
	
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {

		parent::__construct(
			'st_info_widget',
			esc_html__( 'Contact Info', 'status' )
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
		$title        = isset( $instance['title'] ) ? $instance['title'] : '';
		$title        = apply_filters( 'widget_title', $title );
		$address      = isset( $instance['address'] ) ? $instance['address'] : '';
		$phone_number = isset( $instance['phone_number'] ) ? $instance['phone_number'] : '';
		$fax_number   = isset( $instance['fax_number'] ) ? $instance['fax_number'] : '';
		$email        = isset( $instance['email'] ) ? $instance['email'] : '';

		// Before widget WP hook
		echo st_sanitize( $before_widget, 'html' );

		// Display title if defined
		if ( $title ) {
			echo st_sanitize( $before_title . $title . $after_title, 'html' );
		} ?>

		<div class="st-info-widget st-clr">

			<?php if ( $address ) : ?>

				<div class="st-info-widget-address st-clr">
					<span class="fa fa-map-marker"></span>
					<?php echo wpautop( st_sanitize( $address, 'html' ) ); ?>
				</div><!-- .st-info-widget-address -->

			<?php endif; ?>

			<?php if ( $phone_number ) : ?>

				<div class="st-info-widget-phone st-clr">
					<span class="fa fa-phone"></span>
					<?php echo strip_tags( $phone_number ); ?>
				</div><!-- .st-info-widget-address -->

			<?php endif; ?>

			<?php if ( $fax_number ) : ?>

				<div class="st-info-widget-fax st-clr">
					<span class="fa fa-fax"></span>
					<?php echo strip_tags( $fax_number ); ?>
				</div><!-- .st-info-widget-address -->

			<?php endif; ?>

			<?php if ( $email ) : ?>

				<div class="st-info-widget-email st-clr">
					<span class="fa fa-envelope"></span>
					<?php if ( is_email( $email ) ) : ?>
						<a href="mailto:<?php echo sanitize_email( $email ); ?>" title="<?php esc_html_e( 'Email Us', 'status' ); ?>"><?php echo sanitize_email( $email ); ?></a>
					<?php else : ?>
						<?php echo st_sanitize( $email, 'html' ); ?>
					<?php endif; ?>
				</div><!-- .st-info-widget-address -->

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
		$instance                 = $old_instance;
		$instance['title']        = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['address']      = ( ! empty( $new_instance['address'] ) ) ? $new_instance['address'] : '';
		$instance['phone_number'] = ( ! empty( $new_instance['phone_number'] ) ) ? $new_instance['phone_number'] : '';
		$instance['fax_number']   = ( ! empty( $new_instance['fax_number'] ) ) ? $new_instance['fax_number'] : '';
		$instance['email']        = ( ! empty( $new_instance['email'] ) ) ? $new_instance['email'] : '';
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
			'title'        => esc_html__( 'Contact Info', 'status' ),
			'address'      => '',
			'phone_number' => '',
			'fax_number'   => '',
			'email'        => '',
		) );

		// Extract
		extract( $instance ); ?>

		<?php /* Title */ ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'status' ); ?></label>
			<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<?php /* Address */ ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>">
			<?php esc_html_e( 'Address', 'status' ); ?></label>
			<textarea rows="5" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'address' ) ); ?>" type="text"><?php echo stripslashes( $instance['address'] ); ?></textarea>
		</p>

		<?php /* Phone Number */ ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'phone_number' ) ); ?>"><?php esc_html_e( 'Phone Number', 'status' ); ?></label>
			<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'phone_number' ) ); ?>" type="text" value="<?php echo esc_attr( $phone_number ); ?>" />
		</p>

		<?php /* Fax Number */ ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'fax_number' ) ); ?>"><?php esc_html_e( 'Fax Number', 'status' ); ?></label>
			<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'fax_number' ) ); ?>" type="text" value="<?php echo esc_attr( $fax_number ); ?>" />
		</p>

		<?php /* Email */ ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>"><?php esc_html_e( 'Email', 'status' ); ?></label>
			<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>" type="text" value="<?php echo esc_attr( $email ); ?>" />
		</p>

		
	<?php
	}
}

// Register the widget
function st_register_info_widget() {
	register_widget( 'STATUS_Info_Widget' );
}
add_action( 'widgets_init', 'st_register_info_widget' );