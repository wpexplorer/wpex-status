<?php
/**
 * Featured Post
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

// Disable via url param
if ( isset( $_GET['disable_featured_post'] ) ) {
	return;
}

// Get global query
global $wp_query;
$featured_post = st_get_first_post_with_thumb( $wp_query );

if ( $featured_post ) :

	// Get items to display
	if ( st_get_theme_mod( 'entry_meta', true ) ) {
		$meta_items = array( 'date', 'author', 'comments', 'rating' );
		$meta_items	= array_combine( $meta_items, $meta_items );
		if ( ! st_get_theme_mod( 'entry_date', true ) ) {
			unset( $meta_items['date'] );
		}
	} else {
		$meta_items = '';
	}

	// You can tweak the meta output via a function, yay!
	$meta_items = apply_filters( 'st_meta_items', $meta_items, 'featured' );

	// Get first post data
	$post = get_post( $featured_post );

	// Display featured post
	if ( ! empty( $post ) ) :

		// Check if embeds are allowed
		$allow_embeds =  st_get_theme_mod( 'entry_embeds', false ); ?>

		<div class="st-featured-entry st-clr<?php if ( ! has_post_thumbnail() ) echo ' st-featured-entry-no-thumb'; ?>">
		
			<div class="st-featured-entry-media st-clr">

				<?php
				// Display postvideo
				if ( $allow_embeds && st_has_post_video( $post->ID ) ) : ?>

					<div class="st-featured-entry-video"><?php st_post_video(); ?></div>

				<?php
				// Display post audio
				elseif ( $allow_embeds && st_has_post_audio( $post->ID ) ) :

					get_template_part( 'partials/entry/audio' );


				// Display post thumbnail
				elseif ( has_post_thumbnail() ) : ?>

					<div class="st-featured-entry-thumbnail st-clr">
						<a href="<?php the_permalink(); ?>" title="<?php st_esc_title(); ?>" class="st-loop-entry-media-link"><?php the_post_thumbnail( st_get_featured_entry_image_size() ); ?></a>
					</div><!-- .st-featured-entry-thumbnail -->

				<?php endif; ?>

			</div><!-- .st-featured-entry-media -->

			<header class="st-featured-entry-header st-clr">

				<?php
				// Display category tab
				if ( st_get_theme_mod( 'entry_category', true ) ) : ?>
					<?php get_template_part( 'partials/entry/category' ); ?>
				<?php endif; ?>
				<h2 class="st-featured-entry-title">
					<a href="<?php the_permalink(); ?>" title="<?php st_esc_title(); ?>"><?php
						// Show play icon
						if ( ! $allow_embeds && st_has_post_video() ) {
							echo '<span class="fa fa-youtube-play st-video-icon"></span>';
						}
						// Show music icon
						if ( ! $allow_embeds && st_has_post_audio() ) {
							echo '<span class="fa fa-music st-music-icon"></span>';
						}
					// Show title
					the_title(); ?></a>
				</h2>

				<?php
				// Display meta
				if ( $meta_items ) : ?>
					<ul class="st-meta st-featured-entry-meta st-clr">
						<?php
						// Loop through meta options
						foreach ( $meta_items as $meta_item ) :
							// Display date
							if ( 'date' == $meta_item ) : ?>
								<li class="st-date"><span class="fa fa-clock-o" aria-hidden="true"></span><?php echo get_the_date(); ?></li>
							<?php
							// Display author
							elseif ( 'author' == $meta_item && is_object( $post ) ) :
								// Get post author
								$author = $post->post_author;
								$author = get_user_by( 'id', $author ); ?>
								<li class="st-author"><a href="<?php echo esc_url( get_author_posts_url( $author->ID ), $author->user_nicename ); ?>"><span class="fa fa-user"></span><?php echo esc_html( $author->display_name ); ?></a></li>
							<?php
							// Display category
							elseif ( 'category' == $meta_item && isset( $terms ) ) : ?>
								<li class="st-categories"><span class="fa fa-folder"></span><?php echo st_sanitize( $terms, 'html' ); ?></li>
							<?php
							// Comments meta
							elseif ( 'comments' == $meta_item && comments_open() && st_has_comments() && ! post_password_required() ) :
								$icon = '<span class="fa fa-comments" aria-hidden="true"></span>'; ?>
								<li class="st-comments"><?php comments_popup_link( $icon . esc_html__( '0 Comments', 'status' ), $icon . esc_html__( '1 Comment',  'status' ), $icon . esc_html__( '% Comments', 'status' ), 'comments-link' ); ?></li>
							<?php
							// Ratings meta
							elseif ( 'rating' == $meta_item && $rating = get_post_meta( get_the_ID(), 'st_post_rating', true ) ) : ?>
								<li class="st-rating"><span></span> <?php echo st_star_rating( $rating ); ?><span class="st-rating-number"><?php echo esc_html( $rating ); ?></span></li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

			</header>

			<div class="st-featured-entry-excerpt st-entry st-clr"><?php

				// Custom excerpt
				if ( st_has_custom_excerpt( 'featured_post' ) ) :

					$length = apply_filters( 'st_featured_entry_excerpt_length', st_get_theme_mod( 'st_featured_entry_excerpt_length', '40' ) );

					st_excerpt( $length, false );

				// The full content
				else :

					the_content();

				endif;

			?></div><!-- .st-featured-entry-excerpt -->

			<?php
			// Readmore button
			if ( st_entry_as_readmore() ) :

				get_template_part( 'partials/entry/readmore' );

			endif; ?>

		</div><!-- .st-featured-entry -->

	<?php endif; ?>

<?php endif; ?>