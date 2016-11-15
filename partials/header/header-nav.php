<?php
/**
 * Top header navigation
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

// Check to make sure menu isn't empty
if ( has_nav_menu( 'main' ) ) : ?>
	
	<div class="st-site-nav-wrap st-clr">
		<nav class="st-site-nav st-container st-clr"<?php st_schema_markup( 'site_navigation' ); ?>>
			<?php
			// Display menu
			wp_nav_menu( array(
				'theme_location'  => 'main',
				'fallback_cb'     => false,
				'container_class' => 'st-site-nav-container',
				'menu_class'      => 'st-dropdown-menu',
				'walker'          => new STATUS_Dropdown_Walker_Nav_Menu,
			) ); ?>
			<a href="#" title="<?php esc_html_e( 'Search', 'status' ); ?>" class="st-menu-search-toggle"><span class="fa fa-search"></span></a>
		</nav><!-- .st-container -->
	</div><!-- .st-site-nav -->

<?php endif; ?>