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
if ( ! class_exists( 'STATUS_Recent_Posts_Thumb_Widget' ) ) {
	class STATUS_Recent_Posts_Thumb_Widget extends WP_Widget {
		
		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			parent::__construct(
				'st_recent_posts_thumb',
				esc_html__( 'Posts With Thumbnails', 'status' )
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
			$orderby  = isset( $instance['orderby'] ) ? $instance['orderby'] : 'date';
			$category = isset( $instance['category'] ) ? $instance['category'] : 'all';
			$img_size = isset( $instance['img_size'] ) ? $instance['img_size'] : 'thumbnail';

			// Exclude current post
			if ( is_singular() ) {
				$exclude = array( get_the_ID() );
			} else {
				$exclude = NULL;
			}

			// Before widget hook
			echo st_sanitize( $before_widget, 'html' );

			// Display widget title
			if ( $title ) {
				echo st_sanitize( $before_title . $title . $after_title, 'html' );
			}
			
			// Category
			if ( ! empty( $category ) && 'all' != $category ) {
				$taxonomy = array (
					array (
						'taxonomy' => 'category',
						'field'    => 'id',
						'terms'    => $category,
					)
				);
			} else {
				$taxonomy = NUll;
			}

			// Query Posts
			global $post; // IMPORTANT !!!
			$st_query = new WP_Query( array(
				'post_type'           => 'post',
				'posts_per_page'      => $number,
				'orderby'             => $orderby,
				'order'               => $order,
				'no_found_rows'       => true,
				'meta_key'            => '_thumbnail_id',
				'post__not_in'        => $exclude,
				'tax_query'           => $taxonomy,
				'ignore_sticky_posts' => 1
			) );

			// Loop through posts
			if ( $st_query->have_posts() ) { ?>

				<ul class="st-widget-recent-posts widget-recent-list st-clr">

					<?php foreach( $st_query->posts as $post ) : setup_postdata( $post );

						if ( has_post_thumbnail() ) { ?>

							<li>
								<a href="<?php the_permalink(); ?>" title="<?php st_esc_title(); ?>" class="st-thumbnail st-clr">
									<?php the_post_thumbnail( $img_size ); ?>
								</a>

								<div class="st-details st-clr">

									<h4 class="st-title">
										<a href="<?php the_permalink(); ?>" title="<?php st_esc_title(); ?>"><?php the_title(); ?></a>
									</h4><!-- .st-title -->

									<div class="st-date">
										<span class="fa fa-clock-o" aria-hidden="true"></span>
										<?php echo get_the_date(); ?>
									</div><!-- .st-date -->

								</div><!-- .st-details -->

							</li>

						<?php } ?>

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
			$instance['number']   = intval( $new_instance['number'] ) ? intval( $new_instance['number'] ) : '5';
			$instance['order']    = strip_tags( $new_instance['order'] );
			$instance['orderby']  = strip_tags( $new_instance['orderby'] );
			$instance['category'] = strip_tags( $new_instance['category'] );
			$instance['img_size'] = strip_tags( $new_instance['img_size'] );
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
				'title'          => esc_html__( 'Recent Posts','status' ),
				'number'         => '5',
				'order'          => 'DESC',
				'orderby'        => 'date',
				'date'           => '',
				'category'       => 'all',
				'excerpt_length' => '10',
				'img_size'       => 'thumbnail',

			) );
			extract( $instance ); ?>
			
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'status' ); ?>:</label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title','status' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number to Show', 'status' ); ?>:</label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( intval( $number ) ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php esc_html_e( 'Order', 'status' ); ?>:</label>
				<br />
				<select class='st-select' name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>">
				<option value="DESC" <?php selected( $order, 'DESC' ) ?>><?php esc_html_e( 'Descending', 'status' ); ?></option>
				<option value="ASC" <?php selected( $order, 'ASC' ) ?>><?php esc_html_e( 'Ascending', 'status' ); ?></option>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php esc_html_e( 'Order By', 'status' ); ?>:</label>
				<br />
				<select class='st-select' name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>">
				<?php $orderby_array = array (
					'date'          => esc_html__( 'Date', 'status' ),
					'title'         => esc_html__( 'Title', 'status' ),
					'modified'      => esc_html__( 'Modified', 'status' ),
					'author'        => esc_html__( 'Author', 'status' ),
					'rand'          => esc_html__( 'Random', 'status' ),
					'comment_count' => esc_html__( 'Comment Count', 'status' ),
				);
				if ( class_exists( 'Post_Views_Counter' ) ) {
					$orderby_array['post_views'] = esc_html__( 'Post Views', 'status' );
				}
				foreach ( $orderby_array as $key => $value ) { ?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php if( $orderby == $key ) { ?>selected="selected"<?php } ?>>
						<?php echo esc_attr( $value ); ?>
					</option>
				<?php } ?>
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

			<?php /* Image Size */ ?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'img_size' ) ); ?>"><?php esc_html_e( 'Image Size', 'status' ); ?></label>
				<br />
				<select class='st-select' name="<?php echo esc_attr( $this->get_field_name( 'img_size' ) ); ?>" style="width:100%;">
					<?php $get_img_sizes = st_get_thumbnail_sizes(); ?>
					<?php foreach ( $get_img_sizes as $key => $val ) { ?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php if ( $img_size == $key ) { ?>selected="selected"<?php } ?>><?php echo esc_attr( $key ); ?></option>
					<?php } ?>
					
				</select>
			</p>

			<?php
		}
	}
}

// Register the STATUS_Tabs_Widget custom widget
if ( ! function_exists( 'st_register_recet_posts_thumb_widget' ) ) {
	function st_register_recet_posts_thumb_widget() {
		register_widget( 'STATUS_Recent_Posts_Thumb_Widget' );
	}
}
add_action( 'widgets_init', 'st_register_recet_posts_thumb_widget' );