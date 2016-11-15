<?php
/**
 * Displays the site description for the header
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

// Display description if enabled
if ( st_get_theme_mod( 'site_description', true ) && $description = get_bloginfo( 'description' ) ) : ?>

	<div class="st-site-description st-clr"><?php
		echo st_sanitize( $description, 'html' );
	?></div><!-- .st-site-description -->

<?php endif; ?>