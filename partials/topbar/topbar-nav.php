<?php
/**
 * Topbar Nav Menu
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

// Display menu
wp_nav_menu( array(
	'theme_location' => 'topbar',
	'fallback_cb'    => false,
	'container'      => 'false',
	'menu_class'     => 'st-dropdown-menu',
	'walker'         => new STATUS_Dropdown_Walker_Nav_Menu,
	'items_wrap'     => '<nav class="st-topbar-nav st-clr" '. st_get_schema_markup( 'navigation' ) .'><ul id="%1$s" class="%2$s">%3$s</ul></nav>',
) );