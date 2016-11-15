<?php
/**
 * Recent Posts w/ Thumbnails
 *
 */

// Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

// Start widget class
if ( ! class_exists( 'STATUS_Mailchimp_Widget' ) ) {
	class STATUS_Mailchimp_Widget extends WP_Widget {
		
		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			parent::__construct(
				'st_mailchimp',
				esc_html__( 'Mailchimp Newsletter', 'status' )
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
			$title            = isset( $instance['title'] ) ? $instance['title'] : '';
			$title            = apply_filters( 'widget_title', $title );
			$heading          = isset( $instance['heading'] ) ? $instance['heading'] : '';
			$email_holder_txt = ! empty( $instance['placeholder_text'] ) ? $instance['placeholder_text'] : '';
			$email_holder_txt = $email_holder_txt ? $email_holder_txt : esc_html__( 'Your email address', 'status' );
			$name_field       = ! empty( $instance['name_field'] ) ? true : false;
			$name_holder_txt  = ! empty( $instance['name_placeholder_text'] ) ? $instance['name_placeholder_text'] : '';
			$name_holder_txt  = $name_holder_txt ? $name_holder_txt : esc_html__( 'First name', 'status' );
			$button_text      = ! empty( $instance['button_text'] ) ? $instance['button_text'] : esc_html__( 'Subscribe', 'status' );
			$form_action      = isset( $instance['form_action'] ) ? $instance['form_action'] : '';
			$description      = isset( $instance['description'] ) ? $instance['description'] : '';

			// Before widget hook
			echo st_sanitize( $before_widget, 'html' ); ?>

				<?php
				// Display widget title
				if ( $title ) {
					echo st_sanitize( $before_title . $title . $after_title, 'html' );
				} ?>

				<?php if ( $form_action ) { ?>

					<div class="st-newsletter-widget st-clr">

						<?php
						// Display the heading
						if ( $heading ) { ?>

							<h4 class="st-newsletter-widget-heading">
								<?php echo st_sanitize( $heading, 'html' ); ?>
							</h4>

						<?php } ?>

						<?php
						// Display the description
						if ( $description ) { ?>

							<div class="st-newsletter-widget-description">
								<?php echo st_sanitize( $description, 'html' ); ?>
							</div>

						<?php } ?>

							<form action="<?php echo esc_url( $form_action ); ?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
								<?php if ( $name_field ) : ?>
									<input type="text" value="<?php echo esc_attr( $name_holder_txt ); ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" name="FNAME" id="mce-FNAME" autocomplete="off">
								<?php endif; ?>
								<input type="email" value="<?php echo esc_attr( $email_holder_txt ); ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" name="EMAIL" id="mce-EMAIL" autocomplete="off">
								<?php echo apply_filters( 'st_mailchimp_widget_form_extras', null ); ?>
								<button type="submit" value="" name="subscribe"><?php echo esc_attr( $button_text ); ?></button>
							</form>

					</div><!-- .mailchimp-widget -->

				<?php } else { ?>

					<?php esc_html_e( 'Please enter your Mailchimp form action link.', 'status' ); ?>

				<?php } ?>

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
			$instance                     = $old_instance;
			$instance['title']            = strip_tags( $new_instance['title'] );
			$instance['heading']          = strip_tags( $new_instance['heading'] );
			$instance['description']      = esc_html( $new_instance['description'] );
			$instance['form_action']      = strip_tags( $new_instance['form_action'] );
			$instance['placeholder_text'] = strip_tags( $new_instance['placeholder_text'] );
			$instance['button_text']      = strip_tags( $new_instance['button_text'] );
			$instance['name_field']       = $new_instance['name_field'] ? 1 : 0;
			$instance['name_holder_txt']  = strip_tags( $new_instance['name_placeholder_text'] );
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
				'title'                 => '',
				'heading'               => esc_html__( 'Newsletter','status' ),
				'description'           => '',
				'form_action'           => 'http://stplorer.us1.list-manage1.com/subscribe/post?u=9b7568b7c032f9a6738a9cf4d&id=7056c37ddf',
				'placeholder_text'      => esc_html__( 'Your email address', 'status' ),
				'button_text'           => esc_html__( 'Subscribe', 'status' ),
				'name_placeholder_text' => esc_html__( 'First name', 'status' ),
				'name_field'            => 0

			) );
			extract( $instance ) ?>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'status' ); ?>:</label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title','status' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'heading' ) ); ?>"><?php esc_html_e( 'Heading', 'status' ); ?>:</label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'heading' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'heading','status' ) ); ?>" type="text" value="<?php echo esc_attr( $heading ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'form_action' ) ); ?>"><?php esc_html_e( 'Form Action', 'status' ); ?>:</label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'form_action' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'form_action' ) ); ?>" type="text" value="<?php echo esc_attr( $form_action ); ?>" />
				<span style="display:block;padding:5px 0" class="description">
					<a href="//docs.shopify.com/support/configuration/store-customization/where-do-i-get-my-mailchimp-form-action?ref=stplorer" target="_blank"><?php esc_html_e( 'Learn more', 'status' ); ?>&rarr;</a>
				</span>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e( 'Description:','status' ); ?></label>
				<textarea class="widefat" rows="5" cols="20" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"><?php echo esc_attr( $instance['description'] ); ?></textarea>
			</p>
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'name_field' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'name_field','status' ) ); ?>" <?php checked( $name_field, 1, true ); ?> type="checkbox" />
				<label for="<?php echo esc_attr( $this->get_field_id( 'name_field' ) ); ?>"><?php esc_html_e( 'Display Name Field?', 'status' ); ?></label>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'name_placeholder_text' ) ); ?>"><?php esc_html_e( 'Name Input Placeholder Text', 'status' ); ?>:</label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'name_placeholder_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'name_placeholder_text','status' ) ); ?>" type="text" value="<?php echo esc_attr( $name_placeholder_text ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'placeholder_text' ) ); ?>"><?php esc_html_e( 'Email Input Placeholder Text', 'status' ); ?>:</label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'placeholder_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'placeholder_text','status' ) ); ?>" type="text" value="<?php echo esc_attr( $placeholder_text ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"><?php esc_html_e( 'Button Text', 'status' ); ?>:</label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_text','status' ) ); ?>" type="text" value="<?php echo esc_attr( $button_text ); ?>" />
			</p>
			<?php
		}
	}
}

// Register the STATUS_Tabs_Widget custom widget
if ( ! function_exists( 'st_register_mailchimp_widget' ) ) {
	function st_register_mailchimp_widget() {
		register_widget( 'STATUS_Mailchimp_Widget' );
	}
}
add_action( 'widgets_init', 'st_register_mailchimp_widget' );