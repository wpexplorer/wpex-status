<?php
/**
 * Displays the post tags
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

// Return if post tags shouldn't display
if ( post_password_required() ) {
	return;
} 

the_tags(
	'<div class="st-post-tags st-clr"><span class="st-post-tags-title"><span class="fa fa-tags"></span>'. esc_html__( 'More Under:', 'status' ) .'</span> ',
	', ',
	'</div>'
); ?>