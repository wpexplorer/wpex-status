<?php
/**
 * Single post layout
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

// Check password protection
$pass_protected = post_password_required(); ?>

<article class="st-post-article st-clr"<?php st_schema_markup( 'blog_post' ); ?>>

	<?php
	// Entry media should display only if not protected
	if ( ! $pass_protected ) :

		// Display post video
		if ( st_has_post_video() ) :

			get_template_part( 'partials/post/video' );

		// Display post audio
		elseif ( st_has_post_audio() ) :

			get_template_part( 'partials/post/audio' );

		// Display post slider
		elseif ( st_get_gallery_ids() ) :

			get_template_part( 'partials/post/slider' );

		// Display post thumbnail
		elseif ( has_post_thumbnail() && st_get_theme_mod( 'post_thumbnail', true ) ) :

			get_template_part( 'partials/post/thumbnail' );

		endif;

	endif;

	// Display category tag
	if ( st_get_theme_mod( 'post_category', true ) ) :

		get_template_part( 'partials/post/category' );
		
	endif;

	// Display post header
	get_template_part( 'partials/post/header' );

	// Display entry rating
	get_template_part( 'partials/post/rating' );

	// Display post content
	get_template_part( 'partials/post/content' );

	// Display post edit link
	get_template_part( 'partials/global/edit' );

	// Display post links
	get_template_part( 'partials/global/link-pages' );

	// Display post tags
	if ( ! $pass_protected && st_get_theme_mod( 'post_tags', true ) ) :

		get_template_part( 'partials/post/tags' );

	endif;

	echo '<div class="st-post-endspace"></div>';

	// Display post nav (next/prev)
	if ( st_get_theme_mod ( 'post_next_prev', true ) ) {
		get_template_part( 'partials/post/navigation' );
	}

	// Display post author
	if ( ! $pass_protected && st_has_author_bio() ) :

		get_template_part( 'partials/post/author' );

	endif;

	// Display related posts
	if ( ! $pass_protected && st_get_theme_mod( 'post_related', true ) ) :

		get_template_part( 'partials/post/related' );

	endif;

	// Display comments
	if ( st_get_theme_mod( 'comments_on_posts', true ) ) :
		comments_template();
	endif;

	// Ad region
	st_ad_region( 'single-bottom' ); ?>

</article><!-- .st-port-article -->