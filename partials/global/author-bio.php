<?php
/**
 * Used to display post author info
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

// Not needed here
if ( is_attachment() ) {
	return;
}

// Check for custom author section
if ( $custom_bio = apply_filters( 'st_custom_author_bio', null ) ) {
	echo do_shortcode( wp_kses_post( $custom_bio ) );
	return;
}

// Vars
$author				= get_the_author();
$author_description	= get_the_author_meta( 'description' );
$author_url			= esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
$author_avatar		= get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'st_author_bio_avatar_size', 75 ) );

// Only display if author has a description
if ( ! $author_description ) {
	return;
} ?>

<div class="author-info st-clr">
	<h4 class="heading"><span><?php printf( esc_html__( 'Written by %s', 'status' ), $author ); ?></span></h4>
	<div class="author-info-inner st-clr">
		<?php if ( $author_avatar ) { ?>
			<div class="author-avatar st-clr">
				<a href="<?php echo esc_url( $author_url ); ?>" rel="author" title="<?php esc_attr( $author ); ?>">
					<?php echo st_sanitize( $author_avatar, 'image' ); ?>
				</a>
			</div><!-- .author-avatar -->
		<?php } ?>
		<div class="author-description">
			<p><?php echo st_sanitize( $author_description, 'html' ); ?></p>
		</div><!-- .author-description -->
		<?php if ( st_author_has_social() ) : ?>
			<div class="author-social st-clr">
				<?php
				// Display twitter url
				if ( $url = get_the_author_meta( 'st_twitter', $post->post_author ) ) { ?>
					<a href="<?php echo esc_url( $url ); ?>" title="Twitter" class="twitter" target="_blank"><span class="fa fa-twitter"></span></a>
				<?php }
				// Display facebook url
				if ( $url = get_the_author_meta( 'st_facebook', $post->post_author ) ) { ?>
					<a href="<?php echo esc_url( $url ); ?>" title="Facebook" class="facebook" target="_blank"><span class="fa fa-facebook"></span></a>
				<?php }
				// Display google plus url
				if ( $url = get_the_author_meta( 'st_googleplus', $post->post_author ) ) { ?>
					<a href="<?php echo esc_url( $url ); ?>" title="Google Plus" class="google-plus" target="_blank"><span class="fa fa-google-plus"></span></a>
				<?php }
				// Display Linkedin url
				if ( $url = get_the_author_meta( 'st_linkedin', $post->post_author ) ) { ?>
					<a href="<?php echo esc_url( $url ); ?>" title="LinkedIn" class="linkedin" target="_blank"><span class="fa fa-linkedin"></span></a>
				<?php }
				// Display pinterest plus url
				if ( $url = get_the_author_meta( 'st_pinterest', $post->post_author ) ) { ?>
					<a href="<?php echo esc_url( $url ); ?>" title="Pinterest" class="pinterest" target="_blank"><span class="fa fa-pinterest"></span></a>
				<?php }
				// Display instagram plus url
				if ( $url = get_the_author_meta( 'st_instagram', $post->post_author ) ) { ?>
					<a href="<?php echo esc_url( $url ); ?>" title="Instagram" class="instagram" target="_blank"><span class="fa fa-instagram"></span></a>
				<?php } ?>
			</div><!-- .author-bio-social -->
		<?php endif; ?>
	</div><!-- .author-info-inner -->
</div><!-- .author-info -->