<?php
/**
 * The default template for displaying post entries.
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

// Base classes for entry
$classes = array( 'st-loop-entry', 'st-col', 'st-clr' );

// Counter
global $st_count;

// Check if embeds are allowed
$allow_embeds =  st_get_theme_mod( 'entry_embeds', false );

// Check for media
$has_video = st_has_post_video();
$has_audio = st_has_post_audio();

// Left/right style
$entry_style = st_get_blog_entry_style();
if ( 'left_right' == $entry_style && ( has_post_thumbnail() || ( $allow_embeds && ( $has_video || $has_audio ) ) ) ) {
	$classes[] = 'st-left-right';
}

// Entry columns
$columns   = ( 'grid' == $entry_style ) ? st_get_loop_columns() : '1';
$classes[] = 'st-col-'. $columns;
$classes[] = 'st-count-'. $st_count;

// Check if meta is enabled
$has_meta = st_get_theme_mod( 'entry_meta', true );
if ( ! $has_meta ) {
	$classes[] = 'st-meta-disabled';
}

// Add column class
$classes[] = 'st-col-'. $columns; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	<div class="st-loop-entry-inner st-clr"><?php

		// Display video embed
		if ( $allow_embeds && $has_video ) :

			get_template_part( 'partials/entry/video' );

		// Display audio embed
		elseif ( $allow_embeds && $has_audio ) :

			get_template_part( 'partials/entry/audio' );

		// Display thumbnail
		elseif ( st_get_theme_mod( 'entry_thumbnail', true )  && has_post_thumbnail() ) :

			get_template_part( 'partials/entry/thumbnail' );

		endif;

	?><div class="st-loop-entry-content st-clr"><?php

			// Display category tab
			if ( st_get_theme_mod( 'entry_category', true ) ) :

				get_template_part( 'partials/entry/category' );

			endif;

			// Display title
			get_template_part( 'partials/entry/title' );

			// Display entry meta
			if ( $has_meta ) :

				get_template_part( 'partials/entry/meta' );

			endif;

			// Display entry excerpt/content
			get_template_part( 'partials/entry/content' );

			// Display entry readmore button
			if ( st_entry_as_readmore() ) :

				get_template_part( 'partials/entry/readmore' );

			endif;

		?></div><!-- .st-loop-entry-content -->
	</div><!-- .st-boxed-container -->
</article><!-- .st-loop-entry -->

<?php
// Reset counter
if ( $st_count == $columns ) {
	$st_count = 0;
} ?>