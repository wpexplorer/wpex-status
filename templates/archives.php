<?php
/**
 * Template Name: Archives
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

			<article class="st-page-article st-clr">

				<?php if ( ! get_post_meta( get_the_ID(), 'st_hide_title', true ) ) :
					get_template_part( 'partials/page/header' );
				endif; ?>

				<?php get_template_part( 'partials/page/content' ); ?>

					<div class="st-archives-template clr">

						<div class="st-archives-template-section st-clr">

							<h2><?php esc_html_e( 'Latest Posts', 'status' ); ?></h2>
							<ul><?php
								$st_query = new WP_Query( array(
									'post_type'      => 'post',
									'posts_per_page' => '20',
									'no_found_rows'  => true,
								) );
								$count=0;
								while ( $st_query->have_posts() ) :
									$st_query->the_post();
									$count++; ?>
									<li><a href="<?php the_permalink() ?>" title="<?php st_esc_title(); ?>"><?php the_title(); ?></a></li>
								<?php endwhile; wp_reset_postdata();
							?></ul>
						</div><!-- .st-archives-template-section st-clr -->

						<div class="st-archives-template-section st-clr">
							<h2><?php esc_html_e( 'Archives by Month', 'status' ); ?></h2>
							<ul><?php wp_get_archives('type=monthly'); ?></ul>
						</div><!-- .st-archives-template-section st-clr -->

						<div class="st-archives-template-section st-clr">
							<h2><?php esc_html_e( 'Archives by Category', 'status' ); ?></h2>
							<ul><?php wp_list_categories( 'title_li=&hierarchical=0' ); ?></ul>
						</div><!-- .st-archives-template-section st-clr -->

						<div class="st-archives-template-section st-clr">
							<h2><?php esc_html_e( 'Archives by Tags', 'status' ); ?></h2>
							<ul><?php wp_tag_cloud( array(
								'smallest' => 1, 
								'largest'  => 1,
								'unit'     => 'em',
								'format'   => 'list',
							) ); ?></ul>
						</div><!-- .st-archives-template-section st-clr -->

					</div><!-- .st-archives-template -->

				<?php get_template_part( 'partials/global/edit' ); ?>

			</article><!-- .st-page-article -->

		<?php endwhile; ?>

	</main><!-- .st-site-main -->

</div><!-- .st-content-area -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>