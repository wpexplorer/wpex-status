<?php
/**
 * The post entry rating
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

// Display Rating
if ( $rating = get_post_meta( get_the_ID(), 'st_post_rating', true ) ) : ?>

	<div class="st-loop-entry-rating st-clr">
		<div class="st-rating"><?php echo st_star_rating( $rating ); ?> <span class="st-rating-number"><?php echo floatval( $rating ); ?></span></div>
	</div><!-- .st-loop-entry-rating -->

<?php endif; ?>