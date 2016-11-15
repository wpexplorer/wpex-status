<?php
/**
 * Breadcrumbs support via Yoast SEO
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

if ( st_get_theme_mod( 'breadcrumbs', true )
	&& function_exists( 'yoast_breadcrumb' )
	&& ( ! is_home() && ! is_front_page() )
)  :

	// Before content
	$before = '<nav class="st-breadcrumbs st-clr"><div class="st-container st-clr"><span class="fa fa-home"></span>';
	
	// After content
	if ( st_get_theme_mod( 'random_post_link', true ) ) {
		$rtext = st_get_theme_mod( 'random_post_link_txt' );
		$rtext = $rtext ? $rtext : esc_html__( 'Random', 'status' );
		$after = '<a href="'. home_url( '/' ) .'?st_random=1&exclude='. intval( get_the_ID() ) .'" class="st-random-post"><span class="fa fa-random" aria-hidden="true"></span><span class="st-txt">'. esc_html( $rtext ) .'</span></a></div></nav>';
	} else {
		$after = '</div></nav>';
	}

	// Output breadcrumbs
	yoast_breadcrumb( $before, $after );

endif; ?>