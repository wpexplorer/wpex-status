<?php
/**
 * The template for displaying Author bios.
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

// Author description required
if ( $description = get_the_author_meta( 'description' ) ) : ?>

	<section class="st-author-info st-clr">

		<?php if ( apply_filters( 'st_author_box_bio', true ) ) : ?>

			<h4 class="st-heading"><span class="fa fa-pencil-square"></span><?php esc_html_e( 'Article written by', 'status' ); ?> <?php echo strip_tags( get_the_author() ); ?></h4>

			<div class="st-author-info-inner st-clr">

				<div class="st-author-info-avatar">
					<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php esc_attr( esc_html_e( 'Visit Author Page', 'status' ) ); ?>"><?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'st_author_bio_avatar_size', 130 ) ); ?></a>
				</div><!-- .st-author-info-avatar -->

				<div class="st-author-info-content st-entry st-clr">
					<p><?php echo st_sanitize( $description, 'html' ); ?></p>
				</div><!-- .st-author-info-content -->

				<div class="st-author-info-social st-clr">
					<?php
					// Display twitter url
					if ( $url = get_the_author_meta( 'wpex_twitter', $post->post_author ) ) { ?>
						<a href="<?php echo esc_url( $url ); ?>" title="Twitter" class="st-twitter" target="_blank"><span class="fa fa-twitter"></span></a>
					<?php }
					// Display facebook url
					if ( $url = get_the_author_meta( 'wpex_facebook', $post->post_author ) ) { ?>
						<a href="<?php echo esc_url( $url ); ?>" title="Facebook" class="st-facebook" target="_blank"><span class="fa fa-facebook"></span></a>
					<?php }
					// Display google plus url
					if ( $url = get_the_author_meta( 'wpex_googleplus', $post->post_author ) ) { ?>
						<a href="<?php echo esc_url( $url ); ?>" title="Google Plus" class="st-google-plus" target="_blank"><span class="fa fa-google-plus"></span></a>
					<?php }
					// Display Linkedin url
					if ( $url = get_the_author_meta( 'wpex_linkedin', $post->post_author ) ) { ?>
						<a href="<?php echo esc_url( $url ); ?>" title="LinkedIn" class="st-linkedin" target="_blank"><span class="fa fa-linkedin"></span></a>
					<?php }
					// Display pinterest plus url
					if ( $url = get_the_author_meta( 'wpex_pinterest', $post->post_author ) ) { ?>
						<a href="<?php echo esc_url( $url ); ?>" title="Pinterest" class="st-pinterest" target="_blank"><span class="fa fa-pinterest"></span></a>
					<?php }
					// Display instagram plus url
					if ( $url = get_the_author_meta( 'wpex_instagram', $post->post_author ) ) { ?>
						<a href="<?php echo esc_url( $url ); ?>" title="Instagram" class="st-instagram" target="_blank"><span class="fa fa-instagram"></span></a>
					<?php }

					// Website URL
					if ( $url = get_the_author_meta( 'url', $post->post_author ) ) { ?>

						<a href="<?php echo esc_url( $url ); ?>" title="<?php echo esc_attr( get_the_author() ); ?>" target="_blank"><span class="fa fa-link"></span></a>

					<?php } ?>
				</div><!-- .st-author-info-social -->

			</div><!-- .st-author-info-inner -->

		<?php endif; ?>

		<?php if ( apply_filters( 'st_author_box_related', true ) ) :

			$args = apply_filters( 'st_author_box_related_args', array(
				'posts_per_page' => '5',
				'post__not_in'   => array( get_the_ID() ),
				'no_found_rows'  => true,
				'author'         => get_the_author_meta( 'ID' ),
			) );
			$author_posts = new wp_query( $args );

			if ( $author_posts->have_posts() ) : ?>

				<div class="st-author-info-recent st-clr">
					<h5 class="st-heading"><span class="fa fa-th-list"></span><?php esc_html_e( 'Latest from this author', 'status' ); ?><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php esc_attr( esc_html_e( 'view all', 'status' ) ); ?>" class="st-more"><?php esc_html_e( 'view all', 'status' ); ?></a></h5>
					<ul>
					<?php foreach( $author_posts->posts as $post ) : setup_postdata( $post ); ?>
						<li><a href="<?php the_permalink(); ?>" title="<?php st_esc_title(); ?>"><?php the_title(); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>

			<?php endif; ?>

			<?php wp_reset_postdata(); ?>

		<?php endif; ?>

	</section><!-- .st-author-info -->

<?php endif; ?>