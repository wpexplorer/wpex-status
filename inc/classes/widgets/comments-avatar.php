<?php
/**
 * Recent Recent Comments With Avatars Widget
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start class
if ( ! class_exists( 'STATUS_Recent_Comments_Widget' ) ) {
	class STATUS_Recent_Comments_Widget extends WP_Widget {
		
		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			parent::__construct(
				'st_recent_comments_avatars_widget',
				esc_html__( 'Comments With Avatars', 'status' )
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
		function widget( $args, $instance ) {

			// Extract args
			extract( $args );

			// Define variables for widget usage
			$title  = isset( $instance['title'] ) ? $instance['title'] : '';
			$title  = apply_filters( 'widget_title', $title );
			$number = isset( $instance['number'] ) ? $instance['number'] : '3';

			// Before widget WP Hook
			echo st_sanitize( $before_widget, 'html' );

			// Display the title
			if ( $title ) {
				echo st_sanitize( $before_title . $title . $after_title, 'html' );
			}

			echo '<ul class="st-recent-comments-widget st-clr">';

				// Query Comments
				$comments = get_comments( array (
					'number'      => $number,
					'status'      => 'approve',
					'post_status' => 'publish',
					'type'        => 'comment',
				) );
				if ( $comments ) :

					// Loop through comments
					foreach ( $comments as $comment ) :

						// Get comment ID
						$comment_id   = $comment->comment_ID;
						$comment_link = get_permalink( $comment->comment_post_ID ) . '#comment-' . $comment_id;

						// Title alt
						$title_alt = esc_html__( 'Read Comment', 'status' );

						echo '<li class="st-clr">';
							echo '<a href="'. esc_url( $comment_link ) .'" title="'. esc_attr( $title_alt ) .'" class="st-avatar">';
								echo get_avatar( $comment->comment_author_email, '50' );
								echo '<strong>'. get_comment_author( $comment_id ) .':</strong> <span>'. wp_trim_words( $comment->comment_content, '10', '&hellip;' ) .'</span>';
							echo '</a>';
						echo '</li>';

					endforeach;

				// Display no comments notice
				else :

					echo '<li>'. esc_html__( 'No comments yet.', 'status' ) .'</li>';

				endif;

			echo '</ul>';

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
		function update( $new_instance, $old_instance ) {
			$instance           = $old_instance;
			$instance['title']  = ! empty( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['number'] = ! empty( $new_instance['number'] ) ? strip_tags( $new_instance['number'] ) : '';
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
		function form( $instance ) {

			$instance = wp_parse_args( ( array ) $instance, array(
				'title'  => esc_html__( 'Recent Comments', 'status' ),
				'number' => '3',

			) );

			// Esc attributes
			$title  = esc_attr( $instance['title'] );
			$number = esc_attr( $instance['number'] ); ?>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'status' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title', 'status' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number to Show:', 'status' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
			</p>

			<?php
		}
	}
}

// Register the STATUS_Tabs_Widget custom widget
if ( ! function_exists( 'register_st_recent_comments_widget' ) ) {
	function register_st_recent_comments_widget() {
		register_widget( 'STATUS_Recent_Comments_Widget' );
	}
}
add_action( 'widgets_init', 'register_st_recent_comments_widget' );