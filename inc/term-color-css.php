<?php
/**
 * Generates CSS for categories
 *
 * @package   Status WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.stplorer.com
 * @since     1.0.0
 */

function st_category_inline_css() {
	$css = '';
	// Get all term colors
	$category_colors = st_get_category_colors();
	if ( ! empty( $category_colors ) ) {
		foreach ( $category_colors as $term_id => $color ) {
			if ( $color ) {

				// Background
				$css .= '.st-term-'. $term_id .'.st-accent-bg{ background-color: '. $color .'; }';

				// Color
				$css .= '.st-site-nav .st-dropdown-menu li a.st-term-'. $term_id .':hover{ background-color: '. $color .'; color: #fff; }';

			}
		}
	}
	// Category Archives
	if ( is_category() ) {
		$obj   = get_queried_object();
		$color = st_get_category_color( $obj->term_id );
		if ( $color ) {

			// Backgrounds
			$css .= '.st-site-nav .st-dropdown-menu > li.current-menu-item > a, .st-site-nav .st-dropdown-menu > li.parent-menu-item > a, .st-site-nav .st-dropdown-menu > li.current-menu-ancestor > a {background: '. $color .'; color:#fff; }';

			// Borders
			$css .= '.st-archive-title span { border-color: '. $color .'; }';
		}
	}
	return $css;
}