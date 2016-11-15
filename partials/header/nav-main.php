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

// Location ID
$location = 'main';

// Check to make sure menu isn't empty
if ( has_nav_menu( $location ) ) : ?>
	<nav class="st-site-nav-wrap st-clr">
		<div class="st-site-nav st-container st-clr"<?php st_schema_markup( 'navigation' ); ?>>
			<?php wp_nav_menu( array(
				'theme_location'  => $location,
				'fallback_cb'     => false,
				'container_class' => null,
				'menu_class'      => 'st-dropdown-menu st-clr',
				'walker'          => new STATUS_Dropdown_Walker_Nav_Menu,
			) ); ?>
		</div><!-- .st-container -->
	</nav><!-- .st-site-nav -->
<?php endif; ?>