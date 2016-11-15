<?php
/**
 * Outputs social sharing links for single posts
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

<div class="st-post-share st-clr">
	<div class="st-container st-clr">
		<ul class="st-clr">
			<li class="st-twitter">
				<a href="http://twitter.com/share?text=<?php echo urlencode( esc_attr( the_title_attribute( 'echo=0' ) ) ); ?>&amp;url=<?php echo urlencode( get_permalink( get_the_ID() ) ); ?>" title="<?php esc_html_e( 'Share on Twitter', 'status' ); ?>" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
					<span class="fa fa-twitter"></span><?php esc_html_e( 'Tweet', 'status' ); ?>
				</a>
			</li>
			<li class="st-facebook">
				<a href="http://www.facebook.com/share.php?u=<?php echo urlencode( get_permalink( get_the_ID() ) ); ?>" title="<?php esc_html_e( 'Share on Facebook', 'status' ); ?>" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
					<span class="fa fa-facebook"></span><?php esc_html_e( 'Share', 'status' ); ?>
				</a>
			</li>
			<li class="st-pinterest">
				<a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode( get_permalink( get_the_ID() ) ); ?>&amp;media=<?php echo urlencode( wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ) ); ?>&amp;description=<?php echo urlencode( st_sanitize( get_the_excerpt(), 'html' ) ); ?>" title="<?php esc_html_e( 'Share on Pinterest', 'status' ); ?>" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
					<span class="fa fa-pinterest"></span><?php esc_html_e( 'Pin it', 'status' ); ?>
				</a>
			</li>
			<li class="st-comment">
				<a href="#comments" title="<?php esc_html_e( 'Comment', 'status' ); ?>" rel="nofollow">
					<span class="fa fa-commenting-o"></span><?php esc_html_e( 'Comment', 'status' ); ?>
				</a>
			</li>
		</ul>
	</div><!-- .st-container -->
</div><!-- .st-post-share -->