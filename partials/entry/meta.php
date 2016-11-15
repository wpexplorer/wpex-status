<?php
/**
 * Used to output entry meta info - date, category, comments, author...etc
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

// Get entry style
$entry_style = st_get_blog_entry_style();

// Get items to display
$meta_items = array( 'date', 'comments', 'rating' );
if ( 'left_right' == $entry_style ) {
	$meta_items = array( 'date', 'author', 'comments', 'rating' );
}
$meta_items	= array_combine( $meta_items, $meta_items );
if ( ! st_get_theme_mod( 'entry_date', true ) ) {
	unset( $meta_items['date'] );
}
$meta_items = apply_filters( 'st_meta_items', $meta_items, 'entry' );

// Get taxonomy for the posted under section
if ( 'post' == get_post_type() ) {
	$taxonomy = 'category';
} else {
	$taxonomy = NULL;
}

// Get terms
if ( $taxonomy ) {
	$terms = st_get_post_terms( $taxonomy, true );
} else {
	$terms = NULL;
} ?>

<div class="st-meta st-clr">
	<ul class="st-clr">
		<?php
		// Loop through meta options
		foreach ( $meta_items as $meta_item ) :
			// Display date
			if ( 'date' == $meta_item ) : ?>
				<li class="st-date"><span class="fa fa-clock-o" aria-hidden="true"></span><?php echo get_the_date(); ?></li>
			<?php
			// Display author
			elseif ( 'author' == $meta_item ) : ?>
				<li class="st-author"><span class="fa fa-user" aria-hidden="true"></span><?php the_author_posts_link(); ?></li>
			<?php
			// Display category
			elseif ( 'category' == $meta_item && isset( $terms ) ) : ?>
				<li class="st-categories"><span class="fa fa-folder" aria-hidden="true"></span><?php echo st_sanitize( $terms, 'html' ); ?></li>
			<?php
			// Display comments
			elseif ( 'comments' == $meta_item && comments_open() && st_has_comments() && ! post_password_required() ) :
				$icon = '<span class="fa fa-comments" aria-hidden="true"></span>'; ?>
				<li class="st-comments"><?php comments_popup_link( $icon . esc_html__( '0 Comments', 'status' ), $icon . esc_html__( '1 Comment',  'status' ), $icon . esc_html__( '% Comments', 'status' ), 'comments-link' ); ?></li>
			<?php
			// Rating
			elseif ( 'rating' == $meta_item && $rating = get_post_meta( get_the_ID(), 'st_post_rating', true ) ) : ?>
				<li class="st-rating"><span><span class="fa fa-star" aria-hidden="true"></span><?php echo esc_html( $rating ); ?></span></li>
			<?php endif;
		endforeach; ?>
	</ul>
</div><!-- .st-meta -->