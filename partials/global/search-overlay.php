<?php
/**
 * Search Overlay
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

<div class="st-search-overlay st-clr">
	<form method="get" class="st-site-searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="search" class="field" name="s" placeholder="<?php esc_html_e( 'To search type and hit enter', 'status' ); ?>&hellip;" />
		<button type="submit"><span class="fa fa-search"></span></button>
	</form>
</div>