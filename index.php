<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package   Status WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.stplorer.com
 * @since     1.0.0
 */

get_header();

// Check if we have posts
$have_posts = have_posts() ? true : false;

// Check if featured post is enabled
$featured_post_enabled = st_get_theme_mod( 'archive_featured_entry', true );
$featured_post_enabled = apply_filters( 'st_archive_featured_entry', $featured_post_enabled );

if ( is_search() ) {
	$featured_post_enabled = false;
} ?>

	<div class="st-content-area st-clr">

		<main class="st-site-main st-clr">

			<?php
			// Archive ad
			st_ad_region( 'archives-top' );

			// Display page header
			get_template_part( 'partials/archives/header' ); ?>

			<?php
			// Check if posts exist
			if ( $have_posts ) : ?>

				

				<?php
				// Featured Post
				if ( $featured_post_enabled ) : ?>

					<?php get_template_part( 'partials/layout-entry-featured' ); ?>

				<?php endif; ?>

				<div class="st-entries st-row st-clr">   

					<?php
					// Set counter
					$st_count = 0;

					// Get query
					global $wp_query;

					// Get featured post ID
					$featured_post = st_get_first_post_with_thumb( $wp_query );

					// Loop through posts
					while ( have_posts() ) : the_post();

						// Exclude featured post
						if ( $featured_post == get_the_ID() && $featured_post_enabled ) {
							continue;
						}

						// Add to counter
						$st_count++;

						// Display post entry
						get_template_part( 'partials/layout-entry' );

					// End loop
					endwhile; ?>

				</div><!-- .st-entries -->

				<?php
				// Include pagination template part
				st_include_template( 'partials/global/pagination.php' ); ?>

			<?php
			// Display no posts found message
			else : ?>

				<?php get_template_part( 'partials/entry/none' ); ?>

			<?php endif; ?>

		</main><!-- .st-main -->

		<?php
		// Ad region
		if ( $have_posts ) {
			st_ad_region( 'archives-bottom' );
		} ?>

	</div><!-- .st-content-area -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>