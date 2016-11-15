<?php
/**
 * Archives header
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

// Only used for archives and search results
if ( ! is_archive() && ! is_search() ) {
	return;
}

// Define vars
$is_author = is_author();
if ( $is_author ) {
	global $author;
	$curauth = ( isset( $_GET['author_name'] ) ) ? get_user_by( 'slug', $author_name ) : get_userdata( intval( $author ) );
} ?>

<header class="st-archive-header st-clr">

	<h1 class="st-archive-title">

		<?php if ( $custom_archive_title = apply_filters( 'st_archive_title', null ) ) : ?>

			<?php echo st_sanitize( $custom_archive_title, 'html' ); ?>

		<?php elseif ( is_search() ) : ?>

			<?php esc_html_e( 'Search Results ', 'status' ); ?>

		<?php elseif ( $is_author ) : ?>

			<?php esc_html_e( 'Posts written by', 'status' ); ?> <?php echo ucfirst( esc_html( $curauth->nickname ) ); ?>

		<?php elseif ( is_tax() || is_category() || is_tag() ) : ?>

			<?php single_term_title(); ?>

		<?php else : ?>

			<?php the_archive_title(); ?>

		<?php endif; ?>

	</h1>

	<?php
	// Show search query
	if ( is_search() ) : ?>

		<div class="st-header-tagline st-clr">
			<?php printf( esc_html__( 'You searched for: %s', 'status' ), '<span>'. get_search_query() .'</span>' ); ?>
		</div><!-- .st-header-tagline -->

	<?php
	// Author description
	elseif ( $is_author ) : ?>

		<div class="st-header-tagline st-clr">
			<?php
			$count = count_user_posts( get_query_var( 'author' ) );
			printf( esc_html__( 'This author has written %d articles', 'status' ), $count ); ?>
		</div><!-- .st-header-tagline -->

	<?php
	// Display archive description
	elseif ( term_description() ) : ?>

		<div class="st-header-tagline st-clr">
			<?php echo term_description(); ?>
		</div><!-- .st-header-tagline -->

	<?php endif; ?>

	<?php if ( $is_author ) : ?>

		<div class="st-header-author-avatar st-clr">
			<?php echo get_avatar( $curauth->ID, 60 ); ?>
		</div><!-- .st-header-author-avatar -->

	<?php endif; ?>

</header><!-- .st-archive-header -->