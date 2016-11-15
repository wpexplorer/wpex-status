<?php
/**
 * Topbar Layout
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

// Check display
$display = apply_filters( 'st_topbar_enable', st_get_theme_mod( 'topbar_enable', true ) );

// Show topbar if enabled
if ( $display ) : ?>

	<div class="st-topbar-wrap st-clr">

		<div class="st-topbar st-container st-clr">

			<div class="st-topbar-left st-clr">
				<?php get_template_part( 'partials/topbar/topbar-nav' ); ?>
			</div><!-- .st-topbar-left -->

			<div class="st-topbar-right st-clr">
				<?php get_template_part( 'partials/topbar/topbar-social' ); ?>
			</div><!-- .st-topbar-right -->

		</div><!-- .st-topbar -->

	</div><!-- .st-topbar-wrap -->

<?php endif; ?>