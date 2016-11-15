<?php
/**
 * Displays the page thumbnail
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

<?php if ( has_post_thumbnail() ) : ?>
	<div class="st-page-thumbnail st-clr">
		<?php if ( st_has_page_featured_image_overlay_title() ) : ?>
			<div class="st-page-thumbnail-title">
				<div class="st-page-thumbnail-title-inner">
					<h1><span><?php the_title(); ?></span></h1>
				</div><!-- .st-page-thumbnail-title-inner -->
			</div><!-- .st-page-thumbnail-title -->
		<?php endif; ?>
		<?php the_post_thumbnail( 'full' ); ?>
	</div><!-- .st-page-thumbnail -->
<?php endif; ?>