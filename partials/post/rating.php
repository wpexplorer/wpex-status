<?php
/**
 * The post rating
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

// Display rating
if ( $rating = get_post_meta( get_the_ID(), 'st_post_rating', true ) ) : ?>

	<div class="st-post-rating st-clr">
		<span itemscope itemtype="http://schema.org/Review">
			<span itemprop="author" itemscope itemtype="http://schema.org/Person" style="display:none;"><span itemprop="name"><?php echo get_the_author(); ?></span></span>
			<span itemprop="itemReviewed" style="display:none;"><?php the_title(); ?></span>
			<span itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
				<span class="st-post-rating-txt st-heading-font-family"><?php esc_html_e( 'My rating', 'status' ); ?>:</span>
				<?php echo st_star_rating( $rating ); ?>
				<span class="st-post-rating-value"><span itemprop="ratingValue"><?php echo floatval( $rating ); ?></span> <?php esc_html_e( 'out of', 'status' ); ?> <span itemprop="bestRating">5</span></span> 
			</span>
		</span>
	</div><!-- .st-loop-entry-rating -->

<?php endif; ?>