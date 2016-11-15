<?php
/**
 * Scroll to top button
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

<a href="#" title="<?php esc_html_e( 'Top', 'status' ); ?>" class="st-site-scroll-top"><span class="fa fa-arrow-up"></span></a>