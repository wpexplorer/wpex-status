<?php
/**
 * Defines all settings for the customizer class
 *
 * @package   Status WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.stplorer.com
 * @since     1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'STATUS_Accent_Config' ) ) {
	
	class STATUS_Accent_Config {

		/**
		 * Main constructor
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function __construct() {
			add_filter( 'st_accents', array( 'STATUS_Accent_Config', 'accents' ) );
			add_filter( 'st_accent_backgrounds', array( 'STATUS_Accent_Config', 'backgrounds' ) );
			add_filter( 'st_accent_texts', array( 'STATUS_Accent_Config', 'texts' ) );
		}

		/**
		 * Define default accent
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public static function accents() {
			return array(
				'primary'   => '#fab442',
				'secondary' => '#222',
			);
		}

		/**
		 * Create array of backgrounds with accent color
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public static function backgrounds( $array ) {
			$array['primary'] = array(
				'body .widget_tag_cloud a',
				'.st-site-searchform button',
				'.st-widget-popular-posts li .st-count',
				'.st-newsletter-widget button',
				'.st-newsletter-widget button:hover',
				'button',
				'.st-theme-button',
				'.theme-button',
				'input[type="button"]',
				'input[type="submit"]',
				'.st-entry-cat a',
				'.st-post-cat a',
				'.st-topbar-nav .st-dropdown-menu .sub-menu',
				'#wp-calendar caption',
				'.st-topbar-nav .slicknav_nav',
				'.st-topbar-nav .slicknav_nav ul',
				'.st-author-info-social a:hover',
				'.st-author-entry-social a',
			);
			return $array;
		}

		/**
		 * Create array of texts with accent color
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public static function texts( $array ) {
			$array['secondary'] = array(
				'body .widget_tag_cloud a',
				'.st-site-searchform button',
				'.st-widget-popular-posts li .st-count',
				'.st-newsletter-widget button',
				'.st-newsletter-widget button:hover',
				'button',
				'.st-theme-button',
				'.theme-button',
				'input[type="button"]',
				'input[type="submit"]',
				'.st-entry-cat a',
				'.st-post-cat a',
				'.st-topbar-nav .st-dropdown-menu .sub-menu a',
				'#wp-calendar caption',
				'.st-topbar-nav .slicknav_nav a',
				'.st-topbar-nav .slicknav_nav ul a',
				'.st-footer-widgets .tagcloud a',
				'.st-author-info-social a:hover',
				'.st-author-entry-social a',
			);
			return $array;
		}

	}

}
new STATUS_Accent_Config();