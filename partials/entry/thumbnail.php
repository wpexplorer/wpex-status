<?php
/**
 * Displays the entry thumbnail.
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

// Display thumbnail
if ( has_post_thumbnail() ) : ?>

	<div class="st-loop-entry-thumbnail st-loop-entry-media st-clr">
		<a href="<?php the_permalink(); ?>" title="<?php st_esc_title(); ?>" class="st-loop-entry-media-link"><?php the_post_thumbnail( st_get_entry_image_size() ); ?></a>
	</div><!-- .st-loop-entry-thumbnail -->
	
<?php endif; ?>