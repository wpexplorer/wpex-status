<?php
/**
 * Returns the page layout components
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
} ?>

<article class="st-page-article st-clr"><?php

	// Display title
	if ( ! get_post_meta( get_the_ID(), 'st_hide_title', true ) ) :

		get_template_part( 'partials/page/header' );
	
	endif;

	// Display content
	get_template_part( 'partials/page/content' );

	// Display comments
	if ( st_get_theme_mod( 'comments_on_pages', true ) ) :

		comments_template();

	endif;

	// Page edit link
	get_template_part( 'partials/global/edit' );

?></article><!-- .st-page-article -->