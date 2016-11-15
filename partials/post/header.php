<?php
/**
 * Outputs the post header
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

<header class="st-post-header st-clr">
	<h1 class="st-post-title"><?php the_title(); ?></h1>
	<?php if ( st_get_theme_mod( 'post_meta', true ) ) : ?>
		<?php get_template_part( 'partials/post/meta' ); ?>
	<?php endif; ?>
</header><!-- .st-post-header -->