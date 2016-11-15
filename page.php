<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package   Status WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.stplorer.com
 * @since     1.0.0
 */

get_header(); ?>

	<?php get_template_part( 'partials/page/thumbnail' ); ?>

	<div class="st-content-area st-clr">

		<main class="st-site-main st-clr">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'partials/layout-page' ); ?>

			<?php endwhile; ?>

		</main><!-- .st-site-main -->

	</div><!-- .st-content-area -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>