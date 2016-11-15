<?php
/**
 * Template Name: Authors
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

			<?php if ( ! get_post_meta( get_the_ID(), 'st_hide_title', true ) ) : ?>

				<header class="st-authors-template-header st-clr">
					<h1><?php the_title(); ?></h1>
					<?php if ( $link = st_get_theme_mod( 'authors_template_join_link' ) ) :
						$text = st_get_theme_mod( 'authors_template_join_link_txt' );
						$text = $text ? $text : esc_html__( 'Join the team', 'status' ); ?>
						<a href="<?php echo esc_url( get_permalink( $link ) ); ?>" title=""><span class="fa fa-users"></span><?php echo esc_html( $text ); ?></a>
					<?php endif; ?>
				</header>

			<?php endif; ?>

			<?php if ( get_the_content() ) : ?>

				<div class="st-entry st-page-content st-page-article st-authors-template-content st-clr">

					<?php while ( have_posts() ) : the_post(); ?>

						<?php the_content(); ?>

					<?php endwhile; ?>

				</div><!-- .st-entry -->

			<?php endif; ?>

			<?php
			// Get a list of users
			$users = get_users( array(
				'orderby'  => 'post_count',
				'order'    => 'DESC',
				'role__in' => array( 'contributor', 'administrator', 'author' )
			) ); ?>

			<div class="st-authors-listing st-row st-gap-60 st-clr">

				<?php
				$count = 0;
				foreach( $users as $st_author ) :
					$count++;

					$user_id			= $st_author->ID;
					if ( ! count_user_posts( $user_id ) ) return;
					$display_name		= $st_author->display_name;
					$author_profile_url	= get_author_posts_url( $user_id ); ?>

					<article class="st-author-entry st-col st-col-2 st-clr st-count-<?php echo esc_html( $count ); ?>">

						<div class="st-author-entry-inner st-clr">

							<div class="st-author-entry-avatar">

								<a href="<?php echo esc_url( $author_profile_url ); ?>" title="<?php esc_html_e( 'Posts by', 'status' ); ?> <?php echo esc_attr( $display_name ); ?>">
									<?php echo get_avatar( $user_id , '80' ); ?>
								</a>

							</div><!-- .st-author-entry-avatar -->

							<div class="st-author-entry-desc">

								<h2 class="st-author-entry-title">
									<a href="<?php echo esc_url( $author_profile_url ); ?>" title="<?php esc_html_e( 'Posts by', 'status' ); ?> <?php echo esc_attr( $display_name ); ?>">
										<?php echo esc_html( $display_name ); ?>
										<?php if ( $count = count_user_posts( $user_id ) ) {
											echo '('. $count .' '. esc_html__( 'articles', 'status' ) .')';
										} ?>
									</a>
								</h2><!-- .st-author-entry-title -->

								<p><?php echo get_user_meta( $user_id, 'description', true ); ?></p>

								<?php
								// If any social option is defined display the social links
								if ( st_author_has_social( $user_id ) ) : ?>

									<div class="st-author-entry-social st-clr">

										<?php
										// Display twitter url
										if ( $url = get_the_author_meta( 'wpex_twitter', $user_id ) ) { ?>
											<a href="<?php echo esc_url( $url ); ?>" title="Twitter" class="st-twitter"><span class="fa fa-twitter"></span></a>
										<?php }

										// Display facebook url
										if ( $url = get_the_author_meta( 'wpex_facebook', $user_id ) ) { ?>
											<a href="<?php echo esc_url( $url ); ?>" title="Facebook" class="st-facebook"><span class="fa fa-facebook"></span></a>
										<?php }

										// Display google plus url
										if ( $url = get_the_author_meta( 'wpex_googleplus', $user_id ) ) { ?>
											<a href="<?php echo esc_url( $url ); ?>" title="Google Plus" class="st-google-plus"><span class="fa fa-google-plus"></span></a>
										<?php }

										// Display Linkedin url
										if ( $url = get_the_author_meta( 'wpex_linkedin', $user_id ) ) { ?>
											<a href="<?php echo esc_url( $url ); ?>" title="Facebook" class="st-linkedin"><span class="fa fa-linkedin"></span></a>
										<?php }

										// Display pinterest plus url
										if ( $url = get_the_author_meta( 'wpex_pinterest', $user_id ) ) { ?>
											<a href="<?php echo esc_url( $url ); ?>" title="Pinterest" class="st-pinterest"><span class="fa fa-pinterest"></span></a>
										<?php }

										// Display instagram plus url
										if ( $url = get_the_author_meta( 'wpex_instagram', $user_id ) ) { ?>
											<a href="<?php echo esc_url( $url ); ?>" title="Instagram" class="st-instagram"><span class="fa fa-instagram"></span></a>
										<?php }
										
										// Website URL
										if ( $url = get_the_author_meta( 'url', $post->post_author ) ) { ?>

											<a href="<?php echo esc_url( $url ); ?>" title="<?php echo esc_attr( get_the_author() ); ?>" target="_blank"><span class="fa fa-link"></span></a>

										<?php } ?>

									</div><!-- .author-bio-social -->
									
								<?php endif; ?>

							</div><!-- .st-author-entry-desc -->

						</div><!-- .st-author-entry-inner -->

					</article><!-- .st-author-entry -->

				<?php
				if ( 2 == $count ) {
					$count = 0;
				}
				endforeach; ?>

			</div><!-- .st-authors-listing -->

			<?php comments_template(); ?>

		</main><!-- .st-main -->

	</div><!-- .st-content-area -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>