<?php
/**
 * Edit post link
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

// Not needed for these pages
if ( ( function_exists( 'is_cart' ) && is_cart() ) || ( function_exists( 'is_checkout' ) && is_checkout() ) ) {
	return;
}

// Define text
if ( is_page() ) {
	$text = esc_html__( 'Edit This Page', 'status' );
} else {
	$text = esc_html__( 'Edit This Article', 'status' );
}
$text = apply_filters( 'st_post_edit_text', $text );

// Display edit post link
edit_post_link(
	$text,
	'<div class="st-post-edit st-clr">', '</div>'
); ?>