<?php
/**
 * The post entry title
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

<div class="st-loop-entry-excerpt st-entry st-clr"><?php
	if ( post_password_required() ) : ?>
		<?php esc_html_e( 'This post is password protected you will need a password to access the article.', 'status' ); ?>
	<?php elseif ( st_has_custom_excerpt( 'entry' ) ) : ?>
		<?php st_excerpt(); ?>
	<?php else : ?>
		<?php the_content(); ?>
	<?php endif;
?></div><!--.st-loop-entry-excerpt -->