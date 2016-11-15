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
}

$allows_embeds = st_get_theme_mod( 'entry_embeds', false ); ?>

<header class="st-loop-entry-header st-clr">
	<h2 class="st-loop-entry-title">
		<a href="<?php the_permalink(); ?>" title="<?php st_esc_title(); ?>"><?php
		// Show play icon
		if ( ! $allows_embeds && st_has_post_video() ) {
			echo '<span class="fa fa-youtube-play st-video-icon"></span>';
		}
		// Show music icon
		if ( ! $allows_embeds && st_has_post_audio() ) {
			echo '<span class="fa fa-music st-music-icon"></span>';
		}
		// Show title
		the_title(); ?></a>
	</h2><!-- .st-loop-entry-title -->
</header><!-- .st-loop-entry-header -->