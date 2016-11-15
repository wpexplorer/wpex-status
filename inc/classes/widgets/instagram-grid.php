<?php
/**
 * Instagram Slider Widget
 *
 */

// Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

// Start widget class
if ( ! class_exists( 'STATUS_Instagram_Grid_Widget' ) ) {
	class STATUS_Instagram_Grid_Widget extends WP_Widget {
		
		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			parent::__construct(
				'st_insagram_grid',
				esc_html__( 'Instagram', 'status' )
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
			$title        = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
			$username     = empty( $instance['username'] ) ? '' : $instance['username'];
			$number       = empty( $instance['number'] ) ? 9 : $instance['number'];
			$size         = empty( $instance['size'] ) ? 'thumbnail' : $instance['size'];
			$columns      = empty( $instance['columns'] ) ? '4' : $instance['columns'];
			$target_blank = ( isset( $instance['target'] ) && 'blank' == $instance['target'] ) ? true : false;

			// Prevent size issues
			if ( ! in_array( $size, array( 'thumbnail', 'small', 'large', 'original' ) ) ) {
				$size = 'thumbnail';
			}

			// Before widget hook
			echo st_sanitize( $before_widget, 'html' );

			// Display widget title
			if ( $title ) {
				$title = '<span class="fa fa-instagram"></span>'. $title; ?>
				<div class="st-container st-clr">
					<?php echo st_sanitize( $before_title . $title . $after_title, 'html' ); ?>
					<a href="https://www.instagram.com/<?php echo esc_html( $username ); ?>/" title="<?php esc_html_e( 'visit profile', 'status' ); ?>" class="st-instagram-grid-widget-more"><span class="fa fa-th"></span><span class="st-txt"><?php esc_html_e( 'View all', 'status' ); ?></span></a>
				</div>
			<?php }

			// Display notice for username not added
			if ( ! $username ) {

				echo '<p>'. esc_html__( 'Please enter an instagram username for your widget.', 'status' ) .'</p>';

			} else {

				// Get instagram images
				$media_array = $this->scrape_instagram( $username, $number );

				// Display error message
				if ( is_wp_error( $media_array ) ) {

					echo esc_html( $media_array->get_error_message() );

				}

				// Display instagram slider
				elseif ( is_array( $media_array ) ) {
					//print_r( $media_array ); ?>

					<div class="st-instagram-grid-widget st-clr">

						<ul class="st-clr st-row-nr st-gap-6">

						<?php
						$count = 0;
						foreach ( $media_array as $item ) {
							$image = isset( $item['display_src'] ) ? $item['display_src'] : '';

							// Get correct image size
							if ( 'thumbnail' == $size ) {
								$image = ! empty( $item['thumbnail_src'] ) ? $item['thumbnail_src'] : $image;
								$image = ! empty( $item['thumbnail'] ) ? $item['thumbnail'] : $image;
							} elseif ( 'small' == $size ) {
								$image = ! empty( $item['small'] ) ? $item['small'] : $image;
							} elseif ( 'large' == $size ) {
								$image = ! empty( $item['large'] ) ? $item['large'] : $image;
							} elseif ( 'original' == $size ) {
								$image = ! empty( $item['original'] ) ? $item['original'] : $image;
							}
							
							if ( $image ) {
								$count++;
								if ( strpos( $item['link'], 'http' ) === false ) {
									$item['link'] = str_replace( '//instagram', 'https://instagram', $item['link'] );
								}
								echo '<li class="st-col st-clr st-col-'. $columns .' st-count-'. $count .'">
										<a href="'. esc_url( $item['link'] ) .'" title="'. esc_attr( $item['description'] ) .'"'. st_get_target_blank( $target_blank ) .'>
											<img src="'. esc_url( $image ) .'"  alt="'. esc_attr( $item['description'] ) .'" />
										</a>
									</li>';
								if ( $columns == $count ) {
									$count = 0;
								}
							}
						} ?>

						</ul>
						
					</div>

			<?php }

			}

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

			// Get instance
			$instance             = $old_instance;
			$instance['title']    = strip_tags( $new_instance['title'] );
			$instance['size']     = isset( $new_instance['size'] ) ? strip_tags( $new_instance['size'] ) : 'thumbnail';
			$instance['username'] = trim( strip_tags( $new_instance['username'] ) );
			$instance['number']   = ! absint( $new_instance['number'] ) ? 9 : $new_instance['number'];
			$instance['target']   = strip_tags( $new_instance['target'] );
			$instance['columns']  =isset( $new_instance['columns'] ) ?   strip_tags( $new_instance['columns'] ) : '3';

			// Delete transient
			if ( ! empty( $instance['username'] ) ) {
				$sanitized_username = sanitize_title_with_dashes( $instance['username'] );
				$transient_name     = 'st-instagram-widget-new-'. $sanitized_username;
				delete_transient( $transient_name );
			}

			// Return instance
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
				'title'    => esc_html__( 'Instagram', 'status' ),
				'username' => '',
				'number'   => '9',
				'columns'  => '4',
				'target'   => '_self',
				'size'     => 'thumbnail',
			) );
			$title    = $instance['title'];
			$username = $instance['username'];
			$size     = $instance['size'];
			$number   = absint( $instance['number'] );
			$columns  = absint( $instance['columns'] );
			$target   = $instance['target']; ?>
			
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'status' ); ?>: <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></label></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"><?php esc_html_e( 'Username', 'status' ); ?>: <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" type="text" value="<?php echo esc_attr( $username ); ?>" /></label></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>"><?php esc_html_e( 'Size', 'status' ); ?>:</label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'size' ) ); ?>" class="widefat">
					<option value="1" <?php selected( 'thumbnail', $size ) ?>><?php esc_html_e( 'Thumbnail', 'status' ); ?></option>
					<option value="small" <?php selected( 'small', $size ) ?>><?php esc_html_e( 'Small', 'status' ); ?></option>
					<option value="large" <?php selected( 'large', $size ) ?>><?php esc_html_e( 'Large', 'status' ); ?></option>
					<option value="original" <?php selected( 'original', $size ) ?>><?php esc_html_e( 'Original', 'status' ); ?></option>
				</select>
			</p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>"><?php esc_html_e( 'Columns', 'status' ); ?>:</label>
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

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of photos', 'status' ); ?>: <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" /></label></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><?php esc_html_e( 'Open links in', 'status' ); ?>:</label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>" class="widefat">
					<option value="_self" <?php selected( '_self', $target ) ?>><?php esc_html_e( 'Current window', 'status' ); ?></option>
					<option value="_blank" <?php selected( '_blank', $target ) ?>><?php esc_html_e( 'New window', 'status' ); ?></option>
				</select>
			</p>

			<p>
				<strong><?php esc_html_e( 'Cache Notice', 'status' ); ?></strong>:<?php esc_html_e( 'The instagram feed is refreshed every 2 hours. However, you can click the save button below to clear the transient and refresh it instantly.', 'status' ); ?>
			</p>

			<?php
		}

		/**
		 * Get instagram items
		 *
		 * @since 1.0.0
		 * @link  https://gist.github.com/cosmocatalano/4544576
		 */
		function scrape_instagram( $username, $slice = 4 ) {

			$username           = strtolower( $username );
			$sanitized_username = sanitize_title_with_dashes( $username );
			$transient_name     = 'st-instagram-widget-new-'. $sanitized_username;
			$instagram          = get_transient( $transient_name );

			if ( ! empty( $_GET['st_clear_transients'] ) ) {
				$instagram = delete_transient( $transient_name );
			}

			if ( ! $instagram ) {

				$remote = wp_remote_get( 'http://instagram.com/'. trim( $username ) );

				if ( is_wp_error( $remote ) ) {
					return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'status' ) );
				}

				if ( 200 != wp_remote_retrieve_response_code( $remote ) ) {
					return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'status' ) );
				}

				$shards      = explode( 'window._sharedData = ', $remote['body'] );
				$insta_json  = explode( ';</script>', $shards[1] );
				$insta_array = json_decode( $insta_json[0], TRUE );

				if ( ! $insta_array ) {
					return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'status' ) );
				}

				// Old style
				if ( isset( $insta_array['entry_data']['UserProfile'][0]['userMedia'] ) ) {
					$images = $insta_array['entry_data']['UserProfile'][0]['userMedia'];
					$type = 'old';

				}

				// New style
				elseif ( isset( $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'] ) ) {
					$images = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
					$type = 'new';
				}

				// Invalid json data
				else {
					return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'status' ) );
				}

				// Invalid data
				if ( ! is_array( $images ) ) {
					return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'status' ) );
				}

				$instagram = array();

				switch ( $type ) {

					case 'old':

						foreach ( $images as $image ) {

							if ( $image['user']['username'] == $username ) {
								$image['link'] = preg_replace( "/^http:/i", "", $image['link'] );
								$image['images']['thumbnail'] = preg_replace( "/^http:/i", "", $image['images']['thumbnail'] );
								$image['images']['standard_resolution'] = preg_replace( "/^http:/i", "", $image['images']['standard_resolution'] );
								$image['images']['low_resolution'] = preg_replace( "/^http:/i", "", $image['images']['low_resolution'] );
								$instagram[] = array(
									'description' => $image['caption']['text'],
									'link'        => $image['link'],
									'time'        => $image['created_time'],
									'comments'    => $image['comments']['count'],
									'likes'       => $image['likes']['count'],
									'thumbnail'   => $image['images']['thumbnail'],
									'large'       => $image['images']['standard_resolution'],
									'small'       => $image['images']['low_resolution'],
									'type'        => $image['type'],
								);
							}
						}

					break;

					default:

						foreach ( $images as $image ) {

							$image['thumbnail_src'] = preg_replace( '/^https?\:/i', '', $image['thumbnail_src'] );
							$image['display_src'] = preg_replace( '/^https?\:/i', '', $image['display_src'] );

							$image['thumbnail_src'] = preg_replace( '/^https?\:/i', '', $image['thumbnail_src'] );
							$image['display_src'] = preg_replace( '/^https?\:/i', '', $image['display_src'] );

							// handle both types of CDN url
							if ( (strpos( $image['thumbnail_src'], 's640x640' ) !== false ) ) {
								$image['thumbnail'] = str_replace( 's640x640', 's160x160', $image['thumbnail_src'] );
								$image['small'] = str_replace( 's640x640', 's320x320', $image['thumbnail_src'] );
							} else {
								$urlparts = wp_parse_url( $image['thumbnail_src'] );
								$pathparts = explode( '/', $urlparts['path'] );
								array_splice( $pathparts, 3, 0, array( 's160x160' ) );
								$image['thumbnail'] = '//' . $urlparts['host'] . implode('/', $pathparts);
								$pathparts[3] = 's320x320';
								$image['small'] = '//' . $urlparts['host'] . implode('/', $pathparts);
							}

							$image['large'] = $image['thumbnail_src'];

							if ( $image['is_video'] == true ) {
								$type = 'video';
							} else {
								$type = 'image';
							}

							$instagram[] = array(
								'description'   => esc_html__( 'Instagram Image', 'status' ),
								'link'		    => '//instagram.com/p/' . $image['code'],
								'time'		    => $image['date'],
								'comments'	    => $image['comments']['count'],
								'likes'		    => $image['likes']['count'],
								'thumbnail_src' => isset( $image['thumbnail_src'] ) ? $image['thumbnail_src'] : '',
								'display_src'   => $image['display_src'],
								'thumbnail'	 	=> $image['thumbnail'],
								'small'         => $image['small'],
								'large'         => $image['large'],
								'original'      => $image['display_src'],
								'type'          => $type,
							);

						}

					break;

				}

				// Set transient if not empty
				if ( ! empty( $instagram ) ) {
					$instagram = serialize( $instagram );
					set_transient(
						$transient_name,
						$instagram,
						apply_filters( 'st_instagram_widget_cache_time', HOUR_IN_SECONDS*2 )
					);
				}

			}

			// Return array
			if ( ! empty( $instagram )  ) {
				$instagram = unserialize( $instagram );
				return array_slice( $instagram, 0, $slice );
			}

			// No images returned
			else {

				return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'status' ) );

			}

		}


	}
}

// Register the STATUS_Tabs_Widget custom widget
if ( ! function_exists( 'st_register_st_instagram_grid_widget' ) ) {
	function st_register_st_instagram_grid_widget() {
		register_widget( 'STATUS_Instagram_Grid_Widget' );
	}
}
add_action( 'widgets_init', 'st_register_st_instagram_grid_widget' );