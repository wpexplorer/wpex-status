<?php
/**
 * Easily add colors to your categories
 *
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.stplorer.com
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Function required
if ( ! function_exists( 'get_term_meta' ) ) {
	return;
}

// Start Class
if ( ! class_exists( 'STATUS_Term_Colors' ) ) {
	
	class STATUS_Term_Colors {

		/**
		 * Main constructor
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function __construct() {

			// Scripts
			add_action( 'admin_enqueue_scripts', array( 'STATUS_Term_Colors', 'admin_enqueue_scripts' ) );

			// Register metadata
			add_action( 'init', array( 'STATUS_Term_Colors', 'register_meta' ) );

			add_action ( 'edit_category_form_fields', array( 'STATUS_Term_Colors', 'edit_category_form_fields' ) );
			add_action ( 'edited_category', array( 'STATUS_Term_Colors', 'edited_category' ) );

			add_filter( 'manage_edit-category_columns', array( 'STATUS_Term_Colors', 'admin_columns' ) );
			add_filter( 'manage_category_custom_column', array( 'STATUS_Term_Colors', 'admin_column' ), 10, 3 );

		}

		/**
		 * Loads color picker scripts
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public static function admin_enqueue_scripts( $hook ) {
			if ( 'term.php' != $hook ) {
				return;
			}
			wp_enqueue_script( 'jquery' );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
			$js = self::color_picker_js();
			wp_add_inline_script( 'wp-color-picker', $js );
		}

		/**
		 * Color picker js
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public static function color_picker_js() {
			return 'jQuery(function($){$(".st-colorpicker").wpColorPicker();});';
		}

		/**
		 * Adds new category meta data
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public static function register_meta() {
			register_meta( 'term', 'wpex_color', array( 'STATUS_Term_Colors', 'sanitize_meta' ) );
		}

		/**
		 * Sanitize meta input
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public static function sanitize_meta( $color ) {
			$color = ltrim( $color, '#' );
			return preg_match( '/([A-Fa-f0-9]{3}){1,2}$/', $color ) ? $color : '';
		}

		/**
		 * Adds new category fields
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public static function edit_category_form_fields( $tag ) {

			// Nonce
			wp_nonce_field( 'st_category_color_nonce', 'st_category_color_nonce' );

			// Get term id
			$term_id = $tag->term_id;

			// Category Color
			$color = st_get_category_color( $term_id ); ?>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="wpex_color"><?php _e( 'Color', 'status' ); ?></label></th>
				<td><input type="text" name="wpex_color" id="wpex_color" value="<?php echo esc_attr( $color ); ?>" class="st-colorpicker"></td>
			</tr>

		<?php  }

		/**
		 * Saves new category fields
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public static function edited_category( $term_id ) {

			// Make sure everything is secure
			if ( ! isset( $_POST['wpex_color'] ) || ! wp_verify_nonce( $_POST['st_category_color_nonce'], 'st_category_color_nonce' ) ) {
				return;
			}

			// Get color
			$color = isset( $_POST['wpex_color'] ) ? st_sanitize_hex( $_POST['wpex_color'] ) : '';

			// Save color
			if ( $color ) {
				update_term_meta( $term_id, 'wpex_color', $color );
			}

			// Delete color
			else {
				delete_term_meta( $term_id, 'wpex_color' );
			}
			
		}

		/**
		 * Thumbnail column added to category admin.
		 *
		 * @access public
		 * @since  2.1.0
		 */
		public static function admin_columns( $columns ) {
			$columns['st-category-color-col'] = __( 'Color', 'status' );
			return $columns;
		}

		/**
		 * Thumbnail column value added to category admin.
		 *
		 * @access public
		 * @since  2.1.0
		 */
		public static function admin_column( $columns, $column, $id ) {

			if ( 'st-category-color-col' == $column ) {

				// Get colors
				$color = st_get_category_color( $id );

				// Display color
				if ( $color ) {
					echo '<div style="background:'. $color .';height:20px;width:20px;"></div>';
				} else {
					echo '&ndash;';
				}

			}

			// Return columns
			return $columns;

		}

	}

}
new STATUS_Term_Colors();

/**
 * Helper function used to sanize hex values
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'st_sanitize_hex' ) ) {
	function st_sanitize_hex( $color ) {
		if ( $color && preg_match('|([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
			return $color;
		}

	}
}

/**
 * Helper function returns term color
 *
 * @since 1.0.0
 */
function st_get_category_color( $term_id, $hash = true ) {
	$color = get_term_meta( $term_id, 'wpex_color', true );
	$color = st_sanitize_hex( $color );
	if ( $hash ) {
		$color = ltrim( $color, '#' );
		if ( $color ) {
			$color = '#'. $color;
		}
	}
	return $color;
}

/**
 * Returns an array of all category colors
 *
 * @since 1.0.0
 */
function st_get_category_colors() {
	$colors = array();
	$cats = get_terms( 'category' );
	if ( $cats ) {
		foreach ( $cats as $cat ) {
			$id = $cat->term_id;
			if ( $color = st_get_category_color( $id ) ) {
				$colors[$id] = $color;
			}
		}
	}
	return $colors;
}

/**
 * Helper function generates correct inline CSS for term color
 *
 * @since 1.0.0
 */
function st_term_color_inline_css( $term_id, $target = '', $add_style = true ) {
	$color = st_get_category_color( $term_id );
	if ( $color ) {
		if ( $add_style ) {
			return ' style="'. $target .':'.$color.';"';
		} else {
			return $target .':'.$color.'\;';
		}
	}
}

/**
 * Adds data attribute to menu items with category color
 *
 * @since 1.0.0
 */
function st_add_menu_category_color_data( $atts, $item, $args ) {
	if ( 'category' == $item->object ) {
		$atts['class'] = 'st-is-cat st-term-'. $item->object_id;
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'st_add_menu_category_color_data', 10, 3 );