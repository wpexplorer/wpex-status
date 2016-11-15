<?php
/**
 * Used to output post meta info - date, category, comments, author...etc
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

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get items to display
$meta_items = array( 'date', 'author', 'comments' );
$meta_items	= array_combine( $meta_items, $meta_items );

// Remove date if disabled
if ( ! st_get_theme_mod( 'post_meta_date', true ) ) {
	unset( $meta_items['date'] );
}

// You can tweak the meta output via a function, yay!
$meta_items = apply_filters( 'st_meta_items', $meta_items, 'post' );

// Get taxonomy for the posted under section
if ( 'post' == get_post_type() ) {
	$taxonomy = 'category';
} else {
	$taxonomy = NULL;
}

// Get terms
if ( $taxonomy ) {
	$terms = st_get_post_terms( $taxonomy );
} else {
	$terms = NULL;
} ?>

<div class="st-meta st-post-meta st-clr">
	<ul class="st-clr">
		<?php
		// Loop through meta options
		foreach ( $meta_items as $meta_item ) :
			// Display date
			if ( 'date' == $meta_item ) : ?>
				<li class="st-date"><span class="fa fa-clock-o"></span><time class="updated" datetime="<?php esc_attr( the_date( 'Y-m-d' ) ); ?>"<?php st_schema_markup( 'publish_date' ); ?>><?php echo get_the_date(); ?></time></li>
			<?php
			// Display author
			elseif ( 'author' == $meta_item ) : ?>
				<li class="st-author"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><span class="fa fa-user"></span><?php the_author(); ?></a></li>
			<?php
			// Display category
			elseif ( 'category' == $meta_item && isset( $terms ) ) : ?>
				<li class="st-categories"><span class="fa fa-folder"></span><?php echo st_sanitize( $terms, 'html' ); ?></li>
			<?php
			// Display comments
			elseif ( 'comments' == $meta_item && comments_open() && st_has_comments() && ! post_password_required() ) :
				$icon = '<span class="fa fa-comments" aria-hidden="true"></span>'; ?>
				<li class="st-comments"><?php comments_popup_link( $icon . esc_html__( '0 Comments', 'status' ), $icon . esc_html__( '1 Comment',  'status' ), $icon . esc_html__( '% Comments', 'status' ), 'comments-link' ); ?></li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</div><!-- .st-meta -->