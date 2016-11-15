<?php
/**
 * Outputs the post content
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

<div class="st-post-content st-entry st-clr"<?php st_schema_markup( 'entry_content' ); ?>>
	<?php the_content(); ?>
</div><!-- .st-post-content -->