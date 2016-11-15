<?php
/**
 * Add metabox to posts
 *
 * @package   Status WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.stplorer.com
 * @since     1.0.0
 */

// Only needed for the admin side
if ( ! is_admin() ) {
	return;
}

/** 
 * The Class.
 */
class STATUS_Post_Meta_Settings {

	/**
	 * Hook into the appropriate actions when the class is constructed.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_css' ) );
	}

	/**
	 * Adds the meta box container.
	 */
	public function add_meta_box( $post_type ) {
		if ( 'post' == $post_type ) {
			add_meta_box(
				'st_post_settings_metabox',
				esc_html__( 'Post Settings', 'status' ),
				array( $this, 'render_meta_box_content' ),
				'post',
				'advanced',
				'high'
			);
		}
	}

	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_meta_box_content( $post ) {

		// Get meta prefix
		$prefix = st_meta_prefix();
	
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'wpe_page_meta_settings_action', 'wpe_page_meta_settings_nonce' );

		// Open metabox
		echo '<table class="form-table st-metabox-table"><tbody>';

			/**** POST LAYOUT ****/
			$post_layouts = array(
				''              => esc_html__( 'Default', 'status' ),
				'right-sidebar' => esc_html__( 'Right Sidebar', 'status' ),
				'left-sidebar'  => esc_html__( 'Left Sidebar', 'status' ),
				'full-width'    => esc_html__( 'No Sidebar', 'status' ),
			);
			$value = get_post_meta( $post->ID, $prefix .'post_layout', true );
			echo '<tr>';
				echo '<th><p><label for="st_post_layout">'. esc_html__( 'Layout', 'status' ) .'</label></p></th>';
				echo '<td><select type="text" id="st_post_layout" name="st_post_layout">';
					foreach( $post_layouts as $key => $val ) {
						echo '<option value="'. esc_attr( $key ) .'" '. selected( $value, $key ) .'>'. esc_attr( $val ) .'</option>';
					}
				echo '</select></td>';
			echo '</tr>';

			/**** POST Rating ****/
			$value = get_post_meta( $post->ID, $prefix .'post_rating', true );
			$value = $value ? floatval( $value ) : '';
			echo '<tr>';
				echo '<th><p><label for="st_post_layout">'. esc_html__( 'Rating', 'status' ) .'</label></p></th>';
				echo '<td><input type="text" id="st_post_rating" name="st_post_rating" value="' . $value . '" />';
				echo '<br /><small>'. esc_html__( 'Enter a number between 1-5', 'status' ) .'</small>';
				echo '</td>';
			echo '</tr>';

			/**** POST Video ****/
			$value = htmlspecialchars_decode( stripslashes( get_post_meta( $post->ID, $prefix .'post_video', true ) ) );
			echo '<tr>';
				echo '<th><p><label for="st_post_layout">'. esc_html__( 'Video', 'status' ) .'</label></p></th>';
				echo '<td><pre><textarea cols="30" rows="3" type="text" id="st_post_video" name="st_post_video"">'. $value .'</textarea></pre>';
				echo '<small>'. esc_html__( 'Enter your embed code or enter in a URL that is compatible with WordPress\'s built-in oEmbed function or self-hosted video function.', 'status' ) .'</small>';
				echo '</td>';
			echo '</tr>';

			/**** POST Audio ****/
			$value = htmlspecialchars_decode( stripslashes( get_post_meta( $post->ID, $prefix .'post_audio', true ) ) );
			echo '<tr>';
				echo '<th><p><label for="st_post_layout">'. esc_html__( 'Audio', 'status' ) .'</label></p></th>';
				echo '<td><pre><textarea cols="30" rows="3" type="text" id="st_post_audio" name="st_post_audio"">'. $value .'</textarea></pre>';
				echo '<small>'. esc_html__( 'Enter your embed code or enter in a URL that is compatible with WordPress\'s built-in oEmbed function or self-hosted video function.', 'status' ) .'</small>';
				echo '</td>';
			echo '</tr>';


		// Close metabox
		echo '</tbody></table>';

	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save( $post_id ) {

		// Get type
		$type = isset( $_POST['post_type'] ) ? $_POST['post_type'] : '';

		// Return if not post
		if ( 'post' != $_POST['post_type'] ) {
			return;
		}
	
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['wpe_page_meta_settings_nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['wpe_page_meta_settings_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'wpe_page_meta_settings_action' ) ) {
			return $post_id;
		}

		// If this is an autosave, our form has not been submitted,
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Check the user's permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		/* OK, its safe for us to save the data now. */

			// Get meta prefix
			$prefix = st_meta_prefix();

			// Save Post Layout
			$val = isset( $_POST[$prefix .'post_layout'] ) ? strip_tags( $_POST[$prefix .'post_layout'] ) : '';
			if ( $val ) {
				update_post_meta( $post_id, $prefix .'post_layout', $val );
			} else {
				delete_post_meta( $post_id, $prefix .'post_layout' );
			}

			// Save Post Rating
			$val = isset( $_POST[$prefix .'post_rating'] ) ? floatval( $_POST[$prefix .'post_rating'] ) : '';
			if ( $val ) {
				update_post_meta( $post_id, $prefix .'post_rating', $val );
			} else {
				delete_post_meta( $post_id, $prefix .'post_rating' );
			}

			// Save Post Video
			$val = isset( $_POST[$prefix .'post_video'] ) ? htmlspecialchars_decode( stripslashes( $_POST[$prefix .'post_video'] ) ) : '';
			if ( $val ) {
				update_post_meta( $post_id, $prefix .'post_video', $val );
			} else {
				delete_post_meta( $post_id, $prefix .'post_video' );
			}

			// Save Post Audio
			$val = isset( $_POST[$prefix .'post_audio'] ) ? htmlspecialchars_decode( stripslashes( $_POST[$prefix .'post_audio'] ) ) : '';
			if ( $val ) {
				update_post_meta( $post_id, $prefix .'post_audio', $val );
			} else {
				delete_post_meta( $post_id, $prefix .'post_audio' );
			}

	}

	/**
	 * Adds metabox CSS
	 */
	public function load_css( $hook ) {
		if ( $hook == 'post.php' || $hook == 'post-new.php' ) {
			wp_enqueue_style( 'st-metaboxes', get_template_directory_uri() .'/css/metaboxes.css' );
		}
	}

}
new STATUS_Post_Meta_Settings();