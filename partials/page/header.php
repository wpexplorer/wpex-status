<?php
/**
 * Outputs the page title
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

// Display the page header if it's not the front-page
if ( ! is_front_page() ) : ?>
	<header class="page-header st-clr"><h1 class="st-page-header-title"><?php the_title(); ?></h1></header>
<?php endif; ?>