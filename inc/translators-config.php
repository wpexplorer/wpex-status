<?php
/**
 * Configures Translators (WPMl, Polylang, etc)
 *
 * @package   Status WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.stplorer.com
 * @since     1.0.0
 */

/**
 * Strings to translate
 *
 * @since 2.1.0
 */
function st_register_theme_mod_strings() {
	return apply_filters( 'st_register_theme_mod_strings', array(
		'st_logo'                    => false,
		'st_logo_retina'             => false,
		'st_logo_retina_height'      => false,
		'st_post_related_heading'    => null,
		'st_footer_copyright'        => '<a href="http://www.wordpress.org" title="WordPress" target="_blank">WordPress</a> Theme Designed &amp; Developed by <a href="http://www.stplorer.com/" target="_blank" title="WPExplorer">WPExplorer</a>',
		'st_ad_header'               => null,
		'st_ad_homepage_top'         => null,
		'st_ad_homepage_bottom'      => null,
		'st_ad_archives_top'         => null,
		'st_ad_archives_bottom'      => null,
		'st_ad_single_top'           => null,
		'st_ad_single_bottom'        => null,
		'st_sitenav_mm_txt'          => null,
		'st_trending_bar_txt'        => null,
	) );
}

/**
 * Registers strings
 *
 * @since 1.0.0
 */
function st_wpml_register_strings( $key, $default = null ) {

	// Get strings
	$strings = st_register_theme_mod_strings();

	// Register strings for WPMl
	if ( function_exists( 'icl_register_string' ) ) {
		foreach( $strings as $string => $default ) {
			icl_register_string( 'Theme Mod', $string, st_get_theme_mod( $string, $default ) );
		}
	}

	// Register strings for Polylang
	if ( function_exists( 'pll_register_string' ) ) {
		foreach( $strings as $string => $default ) {
			pll_register_string( $string, st_get_theme_mod( $string, $default ), 'Theme Mod', true );
		}
	}

}
add_action( 'admin_init', 'st_wpml_register_strings' );