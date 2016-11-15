<?php
/**
 * Authors Widget
 *
 * Learn more: http://codex.wordpress.org/Widgets_API
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start class
class STATUS_Authors_Widget extends WP_Widget {
	
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {

		parent::__construct(
			'st_authors',
			esc_html__( 'Authors/Contributors', 'status' )
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
		$title            = isset( $instance['title'] ) ? $instance['title'] : '';
		$title            = apply_filters( 'widget_title', $title );
		$admins           = isset( $instance['admins'] ) ? $instance['admins'] : false;
		$authors          = isset( $instance['authors'] ) ? $instance['authors'] : false;
		$contributors     = isset( $instance['contributors'] ) ? $instance['contributors'] : false;
		$avatar_size      = isset( $instance['avatar_size'] ) ? intval( $instance['avatar_size'] ) : 150;
		$columns          = isset( $instance['columns'] ) ? intval( $instance['columns'] ) : 4;
		$number           = isset( $instance['number'] ) ? intval( $instance['number'] ) : 8;
		$authors_page     = isset( $instance['authors_page'] ) ? $instance['authors_page'] : '';
		$authors_page     = $authors_page ? get_permalink( $authors_page ) : '';
		$authors_page_txt = isset( $instance['authors_page_txt'] ) ? $instance['authors_page_txt'] : esc_html__( 'view all authors', 'status' );

		// Before widget WP hook
		echo st_sanitize( $before_widget, 'html' );

		// Display title if defined
		if ( $title ) {
			echo st_sanitize( $before_title . $title . $after_title, 'html' );
		}

		// Query users
		$args = array(
			'orderby' => 'post_count',
			'order'   => 'DESC',
			'number'  => $number,
		);
		$role_in = array();
		if ( $admins ) {
			$role_in[] = 'administrator';
		}
		if ( $authors ) {
			$role_in[] = 'author';
		}
		if ( $contributors ) {
			$role_in[] = 'contributor';
		}
		if ( $role_in ) {
			$args['role__in'] = $role_in;
		}
		$users = get_users( $args );

		if ( $users ) :

			echo '<div class="st-authors-widget st-clr">';

				echo '<div class="st-row-nr st-gap-6 st-clr">';

					$count = '';

					foreach( $users as $user ) :

						$user_id   = $user->ID;
						$nice_name = isset( $user->user_nicename ) ? $user->user_nicename : '';
						$email     = isset( $user->user_email ) ? $user->user_email : '';
						$avatar    = get_avatar( $user->user_email, $avatar_size );

						if ( $avatar && count_user_posts( $user_id ) ) {
							$count++;
							echo '<div class="st-col st-col-'. $columns .' st-count-'. $count .'">';
								echo '<a href="'. get_author_posts_url( $user_id ) .'" title="'. $nice_name .'">';
									echo wp_kses_post( $avatar );
								echo '</a>';
							echo '</div>';
						}

						if ( $count == $columns ) {
							$count = 0;
						}

					endforeach;

				echo '</div>';

				if ( $authors_page = esc_url( $authors_page ) ) {
					echo '<div class="st-authors-widget-more st-clr">';
						echo '<a href="'. $authors_page .'" title="'. $authors_page_txt .'">'. $authors_page_txt .'&rarr;</a>';
					echo '</div>';
				}

			echo '</div>';

		endif;

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
		$instance['admins']       = ( ! empty( $new_instance['admins'] ) ) ? 'on' : null;
		$instance['authors']      = ( ! empty( $new_instance['authors'] ) ) ? 'on' : null;
		$instance['contributors'] = ( ! empty( $new_instance['contributors'] ) ) ? 'on' : null;
		$instance['columns']      = ( ! empty( $new_instance['columns'] ) ) ? intval( $new_instance['columns'] ) : '4';
		$instance['avatar_size']  = ( ! empty( $new_instance['avatar_size'] ) ) ? intval( $new_instance['avatar_size'] ) : '150';
		$instance['number']       = ( ! empty( $new_instance['number'] ) ) ? intval( $new_instance['number'] ) : '8';
		$instance['authors_page'] = ( ! empty( $new_instance['authors_page'] ) ) ? intval( $new_instance['authors_page'] ) : null;
		$instance['authors_page_txt'] = ( ! empty( $new_instance['authors_page_txt'] ) ) ? strip_tags( $new_instance['authors_page_txt'] ) : esc_html__( 'view all authors', 'status' );
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
			'title'            => esc_html__( 'Authors', 'status' ),
			'admins'           => 'on',
			'authors'          => 'on',
			'contributors'     => 'on',
			'columns'          => '4',
			'avatar_size'      => '150',
			'number'           => '8',
			'authors_page'     => '',
			'authors_page_txt' => esc_html__( 'view all authors', 'status' ),
		) );

		// Extract
		extract( $instance ); ?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'status' ); ?></label>
			<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'avatar_size' ) ); ?>"><?php esc_html_e( 'Avatar Size', 'status' ); ?></label>
			<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'avatar_size' ) ); ?>" type="text" value="<?php echo esc_attr( $avatar_size ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number', 'status' ); ?></label>
			<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
		</p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>"><?php esc_html_e( 'Columns', 'status' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'columns' ) ); ?>" class="widefat">
				<option value="1" <?php selected( '1', $columns ) ?>>1</option>
				<option value="2" <?php selected( '2', $columns ) ?>>2</option>
				<option value="3" <?php selected( '3', $columns ) ?>>3</option>
				<option value="4" <?php selected( '4', $columns ) ?>>4</option>
				<option value="5" <?php selected( '5', $columns ) ?>>5</option>
				<option value="6" <?php selected( '6', $columns ) ?>>6</option>
				<option value="8" <?php selected( '8', $columns ) ?>>8</option>
				<option value="10" <?php selected( '10', $columns ) ?>>10</option>
			</select>
		</p>

		<p>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'admins' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'admins' ) ); ?>" type="checkbox" <?php checked( 'on', $admins, 'on' ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'admins' ) ); ?>"><?php esc_html_e( 'Show admins', 'status' ); ?></label>
		</p>

		<p>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'authors' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'authors' ) ); ?>" type="checkbox" <?php checked( 'on', $authors, 'on' ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'authors' ) ); ?>"><?php esc_html_e( 'Show authors', 'status' ); ?></label>
		</p>

		<p>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'contributors' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'contributors' ) ); ?>" type="checkbox" <?php checked( 'on', $contributors, 'on' ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'contributors' ) ); ?>"><?php esc_html_e( 'Show contributors', 'status' ); ?></label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'author_page' ) ); ?>"><?php esc_html_e( 'Authors Page', 'status' ); ?></label>
			<br />
			<small><?php esc_html_e( 'Select your authors page if you want to add a "see all" link.', 'status' ); ?></small>
			<br />
			<?php wp_dropdown_pages( array(
				'show_option_none' => esc_html__( 'None', 'status' ),
				'echo'             => true,
				'selected'         => $authors_page,
				'name'             => esc_attr( $this->get_field_name( 'authors_page' ) ),
				'id'               => 'authors_page',
			) ); ?>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'authors_page_txt' ) ); ?>"><?php esc_html_e( 'View All Label', 'status' ); ?></label>
			<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'authors_page_txt' ) ); ?>" type="text" value="<?php echo esc_attr( $authors_page_txt ); ?>" />
		</p>
		
	<?php
	}
}

// Register the widget
function st_register_authors_widget() {
	register_widget( 'STATUS_Authors_Widget' );
}
add_action( 'widgets_init', 'st_register_authors_widget' );