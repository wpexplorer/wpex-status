<?php
/**
 * Outputs a read more link for entries / Not used by default but available if you want to add it.
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

// Define text
$text = st_get_theme_mod( 'entry_readmore_text' );
$text = $text ? $text : esc_html__( 'Read more', 'status' );
$text = apply_filters( 'st_entry_readmore_text', $text ); ?>


<?php if ( $text ) : ?>

	<div class="st-loop-entry-readmore st-clr">
		<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( $text ); ?>" class="st-readmore st-theme-button"><?php echo st_sanitize( $text, 'html' ); ?> <span class="st-readmore-arrow">&raquo;</span></a>
	</div><!-- .st-loop-entry-readmore -->

<?php endif; ?>