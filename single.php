<?php
/**
 * The Template for displaying all single posts.
 *
 * @package   Status WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.stplorer.com
 * @since     1.0.0
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<div class="st-content-area st-clr">

			<main class="st-site-main st-clr">

				<?php st_ad_region( 'single-top' ); ?>

				<div class="site-main-inner st-clr">

					<?php get_template_part( 'partials/layout-post' ); ?>

				</div><!-- .site-main-inner -->

			</main><!-- .st-main -->

		</div><!-- .st-content-area -->

	<?php endwhile; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>