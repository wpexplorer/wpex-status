<?php
/**
 * Trending tag - displayed on homepage only by default.
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

// Return if disabled in customizer
if ( ! st_get_theme_mod( 'trending_bar', true ) ) return;

// Display
$display = true;
if ( st_get_theme_mod( 'breadcrumbs', true ) && function_exists( 'yoast_breadcrumb' ) ) {
	$display = ( is_front_page() ) ? true : false;
}
$display = apply_filters( 'st_trending_display', $display );

// Show trending section
if ( $display ) :

	// Main args
	$args = array(
		'orderby'             => 'comment_count',
		'posts_per_page'      => '1',
		'no_found_rows'       => false,
		'ignore_sticky_posts' => true,
	);

	// Query order
	if ( class_exists( 'Post_Views_Counter' ) ) {
		$args['orderby'] = 'post_views';
	} else {
		$args['orderby'] = 'comment_count';
	}

	// Get post with most comments
	$most_commented = new WP_Query( $args );

	if ( $most_commented->have_posts() ) :

		$text = st_get_theme_mod( 'trending_bar_txt' );
		$text = $text ? $text : esc_html__( 'Trending Article', 'status' );

		while ( $most_commented->have_posts() ) : $most_commented->the_post(); ?>

			<div class="st-trending st-clr">
				<div class="st-container st-clr">
					<div class="st-trending-txt st-clr">
						<span class="st-trending-label"><span class="fa fa-bookmark"></span><?php echo esc_html( $text ); ?>:</span>
						<a href="<?php the_permalink(); ?>" title="<?php st_esc_title(); ?>"><?php the_title(); ?></a>
					</div>
					<?php if ( st_get_theme_mod( 'random_post_link', true ) ) {
						$text = st_get_theme_mod( 'random_post_link_txt' );
						$text = $text ? $text : esc_html__( 'Random', 'status' ); ?>
						<a href="<?php home_url( '/' ); ?>?st_random=1&amp;exclude=<?php intval( get_the_ID() ); ?>" class="st-random-post"><span class="fa fa-random" aria-hidden="true"></span><span class="st-txt"><?php echo esc_html( $text ) ?></span></a>
					<?php } ?>
				</div><!-- .st-container -->
			</div><!-- .st-trending -->

		<?php endwhile; ?>

		<?php wp_reset_postdata(); ?>

	<?php endif; ?>

<?php endif; ?>