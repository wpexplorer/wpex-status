<?php
/**
 * Outputs pagination
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

// Get pagination style
$style = st_get_theme_mod( 'pagination_style', 'numbered' );

// Get global query
global $wp_query, $st_query;

// Get total pages based on query
if ( $st_query ) {
	$total = $st_query->max_num_pages;
} else {
	$total = $wp_query->max_num_pages;
}

// Show only if there are more then 1 post
if ( $total > 1 ) :

	// Numbered pagination
	if ( 'numbered' == $style ) : ?>

		<div class="st-page-numbers st-clr"> 

			<?php
			// Get current page
			if ( ! $current_page = get_query_var( 'paged' ) ) {
				$current_page = 1;
			}

			// Get correct permalink structure
			if ( get_option( 'permalink_structure' ) ) {
				$format = 'page/%#%/';
			} else {
				$format = '&paged=%#%';
			}

			// Args
			$args = apply_filters( 'st_pagination_args', array(
				'base'      => str_replace( 999999999, '%#%', html_entity_decode( get_pagenum_link( 999999999 ) ) ),
				'format'    => $format,
				'current'   => max( 1, get_query_var( 'paged') ),
				'status'    => $total,
				'mid_size'  => 3,
				'type'      => 'list',
				'prev_text' => esc_html__( 'Previous', 'status' ),
				'next_text' => esc_html__( 'Next', 'status' ),
			) );

			// Output pagination
			echo paginate_links( $args ); ?>

		 </div><!-- .page-numbers -->

	<?php else : 

		$next = get_previous_posts_link( esc_html__( 'Newer Entries', 'status' ) .'<span class="fa fa-chevron-right"></span>' );
		$prev = get_next_posts_link( '<span class="fa fa-chevron-left"></span>'. esc_html__( 'Older Entries', 'status' ) ); ?>

		<div class="st-next-prev-nav st-clr">
			<?php if ( $prev ) : ?>
				<div class="nav-next"><?php echo st_sanitize( $prev, 'html' ); ?></div>
			<?php endif; ?>
			<?php if ( $next ) : ?>
				<div class="nav-previous"><?php echo st_sanitize( $next, 'html' ); ?></div>
			<?php endif; ?>
		</div>

	<?php endif; ?>

<?php endif; ?>