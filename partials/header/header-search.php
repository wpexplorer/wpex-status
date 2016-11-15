<?php
/**
 * Outputs the header navigation
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

if ( st_has_header_search() ) : ?>

	<div class="st-header-searchform st-clr">
		<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
			<input type="search" name="s" placeholder="<?php esc_html_e( 'Search', 'status' ); ?>&hellip;" onfocus="this.placeholder = ''" />
			<button type="submit" class="st-header-searchform-submit"><span class="fa fa-search"></span></button>
		</form>
	</div><!-- .st-header-searchform -->

<?php endif; ?>