<?php
/**
 * Single related posts
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

// Make sure we should display related items
if ( 'post' != get_post_type()
	|| 'on' == get_post_meta( get_the_ID(), 'st_disable_related', true )
) {
	return;
}

// Get count
$posts_per_page = st_get_theme_mod( 'post_related_count', 3 );
if ( ! $posts_per_page || 0 == $posts_per_page ) {
	return;
}

// Prevent stupid shit
if ( $posts_per_page > 99 ) {
	$posts_per_page = 10;
}

// Get Current post
$post_id = get_the_ID();

// What should be displayed?
$display = st_get_theme_mod( 'post_related_displays', 'related_tags' );

// Related query arguments
$args = array(
	'posts_per_page' => $posts_per_page,
	'post__not_in'   => array( $post_id ),
	'no_found_rows'  => true,
);
if ( 'related_tags' == $display ) {
	$tags = wp_get_post_terms( $post_id, 'post_tag' );
	$tag_ids = array();  
	foreach( $tags as $tag ) {
		$tag_ids[] = $tag->term_id; 
	}
	if ( ! empty( $tag_ids ) ) {
		$args['tag__in'] = $tag_ids;
	}
} elseif ( 'related_category' == $display ) {
	$cats = wp_get_post_terms( $post_id, 'category' );
	$cats_ids = array();  
	foreach( $cats as $cat ) {
		$cats_ids[] = $cat->term_id; 
	}
	if ( ! empty( $cats_ids ) ) {
		$args['category__in'] = $cats_ids;
	}

} elseif ( 'random' == $display ) {
	$args['orderby'] = 'rand';
}

// Apply filters to the related query for child theming
$args = apply_filters( 'st_related_posts_args', $args );

// Run Query
$related_query = new wp_query( $args );

// Display related items
if ( $related_query->have_posts() ) {
	$total_posts = $related_query->posts;
	$total_posts = count( $total_posts ); ?>

	<section class="st-related-posts-wrap st-clr">

		<?php
		// Display heading
		$heading = st_get_theme_mod( 'post_related_heading' );
		$heading = $heading ? $heading : esc_html__( 'You May Also Like', 'status' );
		if ( $heading ) : ?>
			<h4 class="st-heading"><span class="fa fa-heart"></span><?php echo st_sanitize( $heading, 'html' ); ?></h4>
		<?php endif; ?>

		<div class="st-related-posts st-clr">
			<?php
			// Loop through related posts
			$count=0;
			foreach( $related_query->posts as $post ) : setup_postdata( $post );
				$count++;
				$has_thumb = has_post_thumbnail();
				$classes = 'st-related-post st-clr';
				if ( ! $has_thumb ) {
					$classes .= ' st-fullwidth';
				}
				if ( $count == $total_posts ) {
					$classes .= ' st-last';
				} ?>

				<div class="<?php echo esc_html( $classes ); ?>">
					<?php if ( $has_thumb ) : ?>
						<div class="st-related-post-thumbnail st-clr">
							<a href="<?php the_permalink(); ?>" title="<?php st_esc_title(); ?>"><?php the_post_thumbnail( 'st_entry_related' ); ?></a>
						</div><!-- .related-st-post-thumbnail -->
					<?php endif; ?>
					<div class="st-related-post-content st-clr">
						<?php
						// Category tag
						if ( 'related_category' != $display ) {
							get_template_part( 'partials/entry/category' );
						} ?>
						<h3 class="st-related-post-title">
							<a href="<?php the_permalink(); ?>" title="<?php st_esc_title(); ?>">
								<?php
								// Show play icon
								if ( st_has_post_video() ) {
									echo '<span class="fa fa-youtube-play st-video-icon"></span>';
								}
								// Show music icon
								if ( st_has_post_audio() ) {
									echo '<span class="fa fa-music st-music-icon"></span>';
								}
								// Show title
								the_title(); ?>
							</a>
						</h3>
						<ul class="st-related-post-meta st-meta st-clr">
							<li class="st-date"><span class="fa fa-clock-o" aria-hidden="true"></span><?php echo get_the_date(); ?></li>
							<?php
							// Comments
							if ( comments_open() && st_has_comments() && ! post_password_required() ) :
								$icon = '<span class="fa fa-comments" aria-hidden="true"></span>'; ?>
								<li class="st-comments"><?php comments_popup_link( $icon . esc_html__( '0 Comments', 'status' ), $icon . esc_html__( '1 Comment',  'status' ), $icon . esc_html__( '% Comments', 'status' ), 'comments-link' ); ?></li>
							<?php endif; ?>
							<?php
							// Ratings
							if ( $rating = get_post_meta( get_the_ID(), 'st_post_rating', true ) ) : ?>
								<li class="st-rating"><span><span class="fa fa-star" aria-hidden="true"></span><?php echo esc_html( $rating ); ?></span></li>
							<?php endif; ?>
						</ul><!-- .st-related-post-meta -->
						<?php if ( $length = apply_filters( 'st_post_related_excerpt_length', '18' ) ) : ?>
							<div class="st-related-post-excerpt st-clr">
							<?php st_excerpt( $length ); ?>
							</div><!-- .st-related-post-excerpt -->
						<?php endif; ?>
					</div><!-- .related-post-content -->

				</div><!-- .related-post -->

			<?php endforeach; ?>

		</div><!-- .st-related-posts -->

	</section><!-- .st-related-posts-wrap -->

<?php } // End related items

// Reset post data
wp_reset_postdata();