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
if ( ! class_exists( 'STATUS_Popular_Posts' ) ) {
	class STATUS_Popular_Posts extends WP_Widget {
		
		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			parent::__construct(
				'st_popular_posts',
				esc_html__( 'Popular Posts', 'status' )
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
			$title    = isset( $instance['title'] ) ? $instance['title'] : '';
			$title    = apply_filters( 'widget_title', $title );
			$number   = isset( $instance['number'] ) ? $instance['number'] : '';
			$order    = isset( $instance['order'] ) ? $instance['order'] : 'DESC';
			$orderby  = isset( $instance['orderby'] ) ? $instance['orderby'] : '';
			$category = isset( $instance['category'] ) ? $instance['category'] : 'all';

			// Before widget hook
			echo st_sanitize( $before_widget, 'html' );

			// Display widget title
			if ( $title ) {
				echo st_sanitize( $before_title . $title . $after_title, 'html' );
			}
			
			// Category
			if ( ! empty( $category ) && 'all' != $category ) {
				$taxonomy = array ( array (
					'taxonomy' => 'category',
					'field'    => 'id',
					'terms'    => $category,
				) );
			} else {
				$taxonomy = NUll;
			}

			// Query Posts
			global $post; // IMPORTANT !!!
			$args = array(
				'post_type'           => 'post',
				'posts_per_page'      => $number,
				'order'               => $order,
				'no_found_rows'       => true,
				'tax_query'           => $taxonomy,
				'ignore_sticky_posts' => 1
			);
			if ( $orderby ) {
				$args['orderby'] = $orderby;
			} elseif ( class_exists( 'Post_Views_Counter' ) ) {
				$args['orderby'] = 'post_views';
			} else {
				$args['orderby'] = 'comment_count';
			}

			// Apply filters
			$args = apply_filters( 'st_popular_posts_widget_args', $args );

			// Query posts
			$popular_query = new WP_Query( $args );

			// Loop through posts
			if ( $popular_query->have_posts() ) { ?>

				<ul class="st-widget-popular-posts st-clr">

					<?php
					$count = 0;
					foreach( $popular_query->posts as $post ) : setup_postdata( $post );
						$count++; ?>
						<li class="st-clr">
							<span class="st-count"><?php echo intval( $count ); ?></span><a href="<?php the_permalink(); ?>" title="<?php st_esc_title(); ?>"><?php the_title(); ?></a>
							<?php if ( apply_filters( 'st_popular_posts_widget_show_views', false )
								&& function_exists( 'pvc_get_post_views' )
							) :
								$views = number_format_i18n( pvc_get_post_views( get_the_ID() ) ); ?>
								<div class="st-views">
									<?php if ( $views == 1  ) { ?>
										<span class="fa fa-eye"></span><?php echo intval( $views ); ?> <?php esc_html_e( 'Post view', 'status' ); ?>
									<?php } else { ?>
										<span class="fa fa-eye"></span><?php echo intval( $views ); ?> <?php esc_html_e( 'Post views', 'status' ); ?>
									<?php } ?>
								</div>
							<?php else : ?>
								<div class="st-date"><span class="fa fa-clock-o"></span><?php echo get_the_date(); ?></div>
							<?php endif; ?>
						</li><!-- .st-most-viewed-post -->
					<?php endforeach; ?>

				</ul>

			<?php }

			// Reset post data
			wp_reset_postdata();

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
			$instance             = $old_instance;
			$instance['title']    = strip_tags( $new_instance['title'] );
			$instance['number']   = strip_tags( $new_instance['number'] );
			$instance['orderby']  = strip_tags( $new_instance['orderby'] );
			$instance['order']    = strip_tags( $new_instance['order'] );
			$instance['category'] = strip_tags( $new_instance['category'] );
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

			extract( wp_parse_args( ( array ) $instance, array(
				'title'          => esc_html__( 'Popular Posts','status' ),
				'number'         => '5',
				'order'          => 'DESC',
				'orderby'        => '',
				'date'           => '',
				'category'       => 'all',
				'excerpt_length' => '10',
			) ) ); ?>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'status' ); ?>:</label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title','status' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number to Show', 'status' ); ?>:</label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php esc_html_e( 'Order By', 'status' ); ?>:</label>
				<br />
				<select class='st-select' name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>">
					<?php
					// Orderby options
					$options = array(
						''              => esc_html__( 'Default', 'total'),
						'date'          => esc_html__( 'Date', 'total'),
						'title'         => esc_html__( 'Title', 'total'),
						'name'          => esc_html__( 'Name', 'total'),
						'modified'      => esc_html__( 'Modified', 'total'),
						'author'        => esc_html__( 'Author', 'total'),
						'rand'          => esc_html__( 'Random', 'total'),
						'parent'        => esc_html__( 'Parent', 'total'),
						'type'          => esc_html__( 'Type', 'total'),
						'ID'            => esc_html__( 'ID', 'total'),
						'comment_count' => esc_html__( 'Comment Count', 'total'),
					);
					foreach ( $options as $key => $label ) { ?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $orderby ); ?>><?php echo esc_html( $label ); ?></option>
					<?php } ?>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php esc_html_e( 'Order', 'status' ); ?>:</label>
				<br />
				<select class='st-select' name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>">
				<option value="DESC" <?php selected( $order, 'DESC' ); ?>><?php esc_html_e( 'Descending', 'status' ); ?></option>
				<option value="ASC" <?php selected( $order, 'ASC' ); ?>><?php esc_html_e( 'Ascending', 'status' ); ?></option>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Category', 'status' ); ?>:</label>
				<br />
				<select class='st-select' name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>">
				<option value="all" <?php if($category == 'all' ) { ?>selected="selected"<?php } ?>><?php esc_html_e( 'All', 'status' ); ?></option>
				<?php
				$terms = get_terms( 'category' );
				foreach ( $terms as $term ) { ?>
					<option value="<?php echo esc_attr( $term->term_id ); ?>" <?php if( $category == $term->term_id ) { ?>selected="selected"<?php } ?>><?php echo esc_attr( $term->name ); ?></option>
				<?php } ?>
				</select>
			</p>

			<?php
		}
	}
}

// Register the STATUS_Tabs_Widget custom widget
if ( ! function_exists( 'st_register_popular_posts_widget' ) ) {
	function st_register_popular_posts_widget() {
		register_widget( 'STATUS_Popular_Posts' );
	}
}
add_action( 'widgets_init', 'st_register_popular_posts_widget' );