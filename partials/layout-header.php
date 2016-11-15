<?php
/**
 * The main header layout
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

<div class="st-site-header-wrap st-clr"<?php st_schema_markup( 'header' ); ?>>
	<header class="st-site-header st-container st-clr">
		<div class="st-site-branding st-clr"><?php
			// Display header logo
			get_template_part( 'partials/header/header-logo' );
			// Display header description
			get_template_part( 'partials/header/header-description' );
		?></div><!-- .st-site-branding -->
		<?php
		// Display header advertisement
		st_ad_region( 'header' ); ?>
	</header><!-- .st-site-header -->
	<?php
	// Display header menu
	get_template_part( 'partials/header/header-nav' ); ?>
</div><!-- .st-site-header-wrap -->