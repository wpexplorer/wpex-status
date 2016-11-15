<?php
/**
 * Displays the post video
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
if ( $video = get_post_meta( get_the_ID(), 'st_post_video', true ) ) :

	// Check what type of video it is
	$type = st_check_meta_type( $video ); ?>

	<div class="st-post-media st-post-video st-responsive-embed st-clr">
		<?php
		// Standard Embeds
		if ( 'iframe' == $type || 'embed' == $type ) {
			echo st_sanitize( $video, 'video' );
		}
		// Oembeds
		else {
			echo wp_oembed_get( $video );
		} ?>
	</div><!-- .st-post-video -->

<?php endif; ?>