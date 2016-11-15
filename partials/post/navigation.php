<?php
/**
 * Displays the next/previous post links
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

// Get post navigation
$args     = apply_filters( 'st_post_navigation_args', array(
	'prev_text'	=> '<div class="st-label">'. esc_html__( 'Next Article', 'status' ) .'<span class="fa fa-caret-right"></span></div><div class="st-link">%title</div>',
	'next_text'	=> '<div class="st-label"><span class="fa fa-caret-left"></span>'. esc_html__( 'Previous Article', 'status' ) .'</div><div class="st-link">%title</div>',
) );
$post_nav = get_the_post_navigation( $args );
$post_nav = str_replace( 'role="navigation"', '', $post_nav );

// Display post navigation
if ( ! is_attachment() && $post_nav ) : ?>

	<div class="st-post-navigation st-clr"><?php echo st_sanitize( $post_nav, 'html' ); ?></div>

<?php endif; ?>