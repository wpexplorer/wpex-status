<?php
/**
 * Displays the post thumbnail
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
} ?>

<?php if ( has_post_thumbnail() ) : ?>

	<div class="st-post-media st-post-thumbnail st-clr">

		<?php the_post_thumbnail( 'st_post' ); ?>

	</div><!-- .st-post-media -->

<?php endif; ?>