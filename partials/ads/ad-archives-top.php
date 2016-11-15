<?php
/**
 * Archives top advertisement region
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

// Get ad
if ( is_home() || is_front_page() ) {
	$ad = st_get_theme_mod(
		'ad_homepage_top',
		'<a href="#" title="WPExplorer"><img src="'. get_template_directory_uri() .'/images/medium-banner-1.png" alt="'. esc_html__( 'Banner', 'status' ) .'" /></a>'
	);
} else {
	$ad = st_get_theme_mod(
		'ad_archives_top',
		'<a href="#" title="WPExplorer"><img src="'. get_template_directory_uri() .'/images/medium-banner-1.png" alt="'. esc_html__( 'Banner', 'status' ) .'" /></a>'
	);
}

// Display
if ( $ad ) : ?>

	<div class="st-ad-region st-archives-top st-clr"><?php
		echo do_shortcode( st_sanitize( $ad, 'advertisement' ) );
	?></div><!-- .st-ad-region -->

<?php endif; ?>