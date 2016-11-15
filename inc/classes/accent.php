<?php
/**
 * Adds custom CSS to the site to tweak the main accent colors
 *
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.stplorer.com
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'STATUS_Accent_Class' ) ) {
	
	class STATUS_Accent_Class {

		/**
		 * Main constructor
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function __construct() {
			// Nothing needed here
		}

		/**
		 * Generates arrays of elements to target
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public static function arrays( $return, $accent ) {

			// Define arrays
			$texts       = apply_filters( 'st_accent_texts', array() );
			$backgrounds = apply_filters( 'st_accent_backgrounds', array() );
			$borders     = apply_filters( 'st_accent_borders', array() );

			// Return array
			if ( 'texts' == $return && isset( $texts[$accent] ) ) {
				return $texts[$accent];
			} elseif ( 'backgrounds' == $return && isset( $backgrounds[$accent] ) ) {
				return $backgrounds[$accent];
			} elseif ( 'borders' == $return && isset( $borders[$accent] ) ) {
				return $borders[$accent];
			}

		}

		/**
		 * Generates the CSS output
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public static function generate( $accent, $default ) {

			// Get custom accent
			$color = st_get_theme_mod( $accent .'_accent_color' );
			$color = ( $color != $default ) ? $color : '';
			
			// Check url params
			if ( ! empty( $_GET['accent_'. $accent] ) ) {
				$color = esc_html( $_GET['accent_'. $accent] );
			}

			// Return if there isn't any accent
			if ( ! $color ) {
				return;
			}

			// Sanitize
			$color = str_replace( '#', '', $color );
			$color = '#'. $color;

			// Define css var
			$css = '';

			// Get arrays
			$texts       = self::arrays( 'texts', $accent );
			$backgrounds = self::arrays( 'backgrounds', $accent );
			$borders     = self::arrays( 'borders', $accent );

			// Texts
			if ( ! empty( $texts ) ) {
				$css .= implode( ',', $texts ) .'{color:'. $color .';}';
			}

			// Backgrounds
			if ( ! empty( $backgrounds ) ) {
				$css .= implode( ',', $backgrounds ) .'{background-color:'. $color .';}';
			}

			// Borders
			if ( ! empty( $borders ) ) {
				foreach ( $borders as $key => $val ) {
					if ( is_array( $val ) ) {
						$css .= $key .'{';
						foreach ( $val as $key => $val ) {
							$css .= 'border-'. $val .'-color:'. $color .';';
						}
						$css .= '}'; 
					} else {
						$css .= $val .'{border-color:'. $color .';}';
					}
				}
			}
			
			// Return CSS
			if ( ! empty( $css ) ) {
				return st_sanitize( $css, 'css' );
			}

		}

		/**
		 * Output CSS to head
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public static function generate_css() {
			$accents = apply_filters( 'st_accents', null );
			if ( ! empty( $accents ) && is_array( $accents ) ) {
				$add_css = '';
				if ( is_array( $accents ) ) {
					foreach ( $accents as $accent => $default ) {
						$add_css .= self::generate( $accent, $default );
					}
				}
				if ( $add_css ) {
					return $add_css;
				}
			}
		}

	}

}
new STATUS_Accent_Class();