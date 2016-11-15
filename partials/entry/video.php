<?php
/**
 * Displays the entry video
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

// Display video if defined
if ( st_has_post_video() ) : ?>

	<div class="st-loop-entry-video st-loop-entry-media st-responsive-embed st-clr"><?php st_post_video(); ?></div>
	
<?php endif; ?>