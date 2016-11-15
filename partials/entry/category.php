<?php
/**
 * Displays the entry category(ies)
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

// Show only when needed
if ( 'post' != get_post_type() || is_category() ) {
	return;
}

// Get category
if ( st_get_theme_mod( 'entry_category_first_only', true ) ) {
	$category = st_get_post_terms( 'category', true, 'st-accent-bg' );
} else {
	$category = st_get_post_terms( 'category', false, 'st-accent-bg' );
}

// Display category
if ( $category ) : ?>

	<div class="st-entry-cat st-clr st-button-typo"><?php
		echo st_sanitize( $category, 'link' );
	?></div><!-- .st-entry-cat -->

<?php endif; ?>