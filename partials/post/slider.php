<?php
/**
 * Outputs the post slider
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

// Get gallery image ids
$imgs             = st_get_gallery_ids();
$lightbox_enabled = true;

// Post vars
global $post;
$post_id = $post->ID;

// Show slider if there are images to display
if ( $imgs ) : ?>

	<div class="st-post-media st-post-slider-wrap st-clr">
	
		<?php
		// Get first image to display as a placeholder while the slider simplexml_load_string(
		$first_img      = $imgs[0];
		$first_img      = wp_get_attachment_image_src( $first_img, 'st_post', false );
		$first_img_alt  = strip_tags( get_post_meta( $first_img, '_wp_attachment_image_alt', true ) );
		if ( isset( $first_img[0] ) ) : ?>
			<div class="slider-first-image-holder">
				<img src="<?php echo esc_url( $first_img[0] ); ?>" alt="<?php echo esc_attr( $first_img_alt ); ?>" width="<?php echo esc_attr( $first_img[1] ); ?>" height="<?php echo esc_attr( $first_img[2] ); ?>" />
			</div><!-- .slider-first-image-holder -->
		<?php endif; ?>

		<div class="st-post-slider st-lightbox-gallery lightslider">

			<?php
			// Loop through each attachment ID
			foreach ( $imgs as $img ) :
				
				// Get image alt tag
				$img_url         = wp_get_attachment_image_src( $img, 'full', false );
				$img_url         = $img_url[0];
				$cropped_img_url = wp_get_attachment_image_src( $img, 'st_post', false );
				$img_alt         = strip_tags( get_post_meta( $img, '_wp_attachment_image_alt', true ) );
				$caption         = get_post_field( 'post_excerpt', $img );

				if ( $cropped_img_url ) : ?>

					<div class="st-post-slider-slide">
						<?php
						// Display image with lightbox
						if ( 'on' == $lightbox_enabled ) : ?>

							<a href="<?php echo esc_url( $img_url ); ?>" title="<?php echo esc_attr( $img_alt ); ?>" class="st-lightbox-item"><img src="<?php echo esc_url( $cropped_img_url[0] ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>" width="<?php echo esc_attr( $cropped_img_url[1] ); ?>" height="<?php echo esc_attr( $cropped_img_url[2] ); ?>" /></a>

						<?php
						// Lightbox is disabled, only show image
						else : ?>

							<img src="<?php echo esc_url( $cropped_img_url[0] ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>" width="<?php echo esc_attr( $cropped_img_url[1] ); ?>" height="<?php echo esc_attr( $cropped_img_url[2] ); ?>" />

						<?php endif; ?>

						<?php if ( $caption ) : ?>

							<div class="st-post-slider-caption st-clr"><?php
								echo st_sanitize( $caption, 'html' );
							?></div><!-- .st-post-slider-caption -->

						<?php endif; ?>

					</div><!-- .st-post-slider-slide -->

				<?php endif; ?>
				
			<?php endforeach; ?>

		</div><!-- .st-post-slider -->

	</div><!-- .st-post-slider-wrap -->
	
<?php endif; ?>