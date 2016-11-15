<?php
/**
 * Footer divider created via category colors
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

// Loop through categories and get colors
$colors = st_get_category_colors();

// Display copyright
if ( $colors ) :
	
	$count = count( $colors );
	$width = 100/$count; ?>

	<div class="st-footer-divider st-shuffle st-clr"><?php
		foreach ( $colors as $term_id => $color ) :
			if ( $color ) {
				echo'<div style="background:'. esc_html( $color ) .';width:'. esc_html( $width ) .'%;"></div>';
			}
		endforeach;
	?></div><!-- .st-footer-divider -->

<?php endif; ?>