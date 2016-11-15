<?php
/**
 * Returns the page layout components
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

<div class="st-entry st-clr">
    <?php the_content(); ?>
    <?php get_template_part( 'partials/global/link-pages' ); ?>
</div><!-- .st-entry -->