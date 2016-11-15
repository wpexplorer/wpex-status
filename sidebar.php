<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package   Status WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.stplorer.com
 * @since     1.0.0
 */

// Return if it is full-width
if ( 'full-width' == st_get_post_layout() ) {
	return;
}

// Display WooSidebar as needed
if ( st_is_woocommerce_active()
	&& is_active_sidebar( 'sidebar_woocommerce' )
	&& ( is_shop() || is_cart() || is_checkout() )
) :

	get_sidebar( 'woocommerce' );
	return;

// Get correct sidebar and display
else :

	$sidebar = ( is_singular( 'page' ) && is_active_sidebar( 'sidebar_pages' ) ) ? 'sidebar_pages' : 'sidebar';

	if ( is_active_sidebar( $sidebar ) ) : ?>

		<aside class="st-sidebar st-clr"<?php st_schema_markup( 'sidebar' ); ?>>

			<div class="st-widget-area">

				<?php dynamic_sidebar( $sidebar ); ?>

			</div><!-- .st-widget-area -->

		</aside><!-- .st-sidebar -->

	<?php endif; ?>

<?php endif; ?>