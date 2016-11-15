<?php
/**
 * Archives bottom advertisement region
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
$ad = st_get_theme_mod(
	'ad_footer_bottom',
	'<a href="#" title="WPExplorer"><img src="'. get_template_directory_uri() .'/images/banner-white.png" alt="'. esc_html__( 'Banner', 'status' ) .'" /></a>'
);

// Display
if ( $ad ) : ?>

	<div class="st-ad-region st-footer-bottom-ad st-clr">
		<div class="st-container st-clr"><?php
			echo do_shortcode( st_sanitize( $ad, 'advertisement' ) );
		?></div>
	</div><!-- .st-ad-region -->

<?php endif; ?>