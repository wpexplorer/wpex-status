<?php
/**
 * Creates a gallery metabox for WordPress
 *
 * http://wordpress.org/plugins/easy-image-gallery/
 * https://github.com/woothemes/woocommerce
 *
 * @author      Alexander Clarke
 * @copyright   Copyright (c) 2015, WPExplorer.com
 * @link        http://www.stplorer.com
 * @version     1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'STATUS_Gallery_Metabox' ) ) {
	class STATUS_Gallery_Metabox {

		/**
		 * Vars
		 *
		 * @since 1.6.0
		 */
		protected $dir = '';

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since	1.0.0
		 */
		public function __construct() {
			add_action( 'add_meta_boxes', array( $this, 'add_meta' ) );
			add_action( 'save_post', array( $this, 'save_meta' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
			$this->dir = get_template_directory_uri() .'/inc/classes/gallery-metabox/';
			$this->dir = apply_filters( 'st_gallery_metabox_dir_uri', $this->dir );
		}

		/**
		 * Adds the gallery metabox
		 *
		 * @link	http://codex.wordpress.org/Function_Reference/add_meta_box
		 * @since	1.0.0
		 */
		public function add_meta() {
			$types = array( 'post' );
			$types = apply_filters( 'st_gallery_metabox_post_types', $types );
			foreach ( $types as $type ) {
				add_meta_box(
					'st-gallery-metabox',
					esc_html__( 'Image Gallery', 'status' ),
					array( $this, 'render' ),
					$type,
					'normal',
					'high'
				);
			}
		}

		/**
		 * Render the gallery metabox
		 *
		 * @since 1.0.0
		 */
		public function render() {
			global $post; ?>
			<div id="st_gallery_images_container">
				<ul class="st_gallery_images">
					<?php
					$image_gallery = get_post_meta( $post->ID, '_easy_image_gallery', true );
					$attachments = array_filter( explode( ',', $image_gallery ) );
					if ( $attachments ) {
						foreach ( $attachments as $attachment_id ) {
							if ( wp_attachment_is_image ( $attachment_id  ) ) {
								echo '<li class="image" data-attachment_id="' . $attachment_id . '"><div class="attachment-preview"><div class="thumbnail">
											' . wp_get_attachment_image( $attachment_id, 'thumbnail' ) . '</div>
											<a href="#" class="st-gmb-remove" title="' . esc_html__( 'Remove image', 'status' ) . '"><div class="media-modal-icon"></div></a>
										</div></li>';
							}
						}
					} ?>
				</ul>
				<input type="hidden" id="image_gallery" name="image_gallery" value="<?php echo esc_attr( $image_gallery ); ?>" />
				<?php wp_nonce_field( 'easy_image_gallery', 'easy_image_gallery' ); ?>
			</div>
			<p class="add_st_gallery_images hide-if-no-js">
				<a href="#" class="button-primary"><?php esc_html_e( 'Add/Edit Images', 'status' ); ?></a>
			</p>
			<?php
			// options don't exist yet, set to checked by default
			if ( ! get_post_meta( get_the_ID(), '_easy_image_gallery_link_images', true ) ) {
				$checked = ' checked="checked"';
			} else {
				$checked = checked( get_post_meta( get_the_ID(), '_easy_image_gallery_link_images', true ), 'on', false );
			} ?>

		<?php
		}

		/**
		 * Save gallery items
		 *
		 * @since 1.0.0
		 */
		public function save_meta( $post_id ) {
			// Check nonce
			if ( ! isset( $_POST[ 'easy_image_gallery' ] ) || ! wp_verify_nonce( $_POST[ 'easy_image_gallery' ], 'easy_image_gallery' ) ) {
				return;
			}
			// Check auto save
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
			// Check user permissions
			$post_types = array( 'post' );
			if ( isset( $_POST['post_type'] ) && 'post' == $_POST['post_type'] ) {
				if ( !current_user_can( 'edit_page', $post_id ) ) {
					return;
				}
			} else {
				if ( !current_user_can( 'edit_post', $post_id ) ) {
					return;
				}
			}
			if ( isset( $_POST[ 'image_gallery' ] ) && !empty( $_POST[ 'image_gallery' ] ) ) {
				$attachment_ids = sanitize_text_field( $_POST['image_gallery'] );

				// Turn comma separated values into array
				$attachment_ids = explode( ',', $attachment_ids );

				// Clean the array
				$attachment_ids = array_filter( $attachment_ids  );

				// Return back to comma separated list with no trailing comma. This is common when deleting the images
				$attachment_ids =  implode( ',', $attachment_ids );
				update_post_meta( $post_id, '_easy_image_gallery', $attachment_ids );

			} else {

				// Delete gallery
				delete_post_meta( $post_id, '_easy_image_gallery' );

			}

			// Add action
			do_action( 'st_save_gallery_metabox', $post_id );
			
		}

		/**
		 * Load custom scripts
		 *
		 * @since 1.0.0
		 */
		public function scripts( $hook ) {

			if ( $hook != 'edit.php' && $hook != 'post.php' && $hook != 'post-new.php' ) {
				return;
			}

			wp_enqueue_style( 'st-gmb-css', $this->dir .'gallery-metabox.css' );
			wp_enqueue_script( 'st-gmb-js', $this->dir .'gallery-metabox.js', array( 'jquery' ), false, true );
			wp_localize_script( 'st-gmb-js', 'stGmb', array(
				'title'  => esc_html__( 'Add Images to Gallery', 'status' ),
				'button' => esc_html__( 'Add to gallery', 'status' ),
				'remove' => esc_html__( 'Remove image', 'status' ),
			) );

		}

	}
}

// Class needed only in the admin
if ( is_admin() ) {
	$st_gallery_metabox = new STATUS_Gallery_Metabox;
}


/**
 * Retrieve attachment IDs
 *
 * @since	1.0.0
 * @return	bool
 */
if ( ! function_exists ( 'st_get_gallery_ids' ) ) {
	function st_get_gallery_ids( $post_id = '' ) {
		$post_id = $post_id ? $post_id : get_the_ID();
		$attachment_ids = get_post_meta( $post_id, '_easy_image_gallery', true );
		$attachment_ids = explode( ',', $attachment_ids );
		return array_filter( $attachment_ids );
	}
}

/**
 * Retrieve attachment data
 *
 * @since	1.0.0
 * @return	array
 */
if ( ! function_exists ( 'st_get_attachment' ) ) {
	function st_get_attachment( $id ) {
		$attachment = get_post( $id );
		return array(
			'alt'         => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
			'caption'     => $attachment->post_excerpt,
			'description' => $attachment->post_content,
			'href'        => get_permalink( $attachment->ID ),
			'src'         => $attachment->guid,
			'title'       => $attachment->post_title,
		);
	}
}

/**
 * Return gallery count
 *
 * @since	1.0.0
 * @return	bool
 */
if ( ! function_exists ( 'st_gallery_count' ) ) {
	function st_gallery_count() {
		$ids = st_get_gallery_ids();
		return count( $ids );
	}
}