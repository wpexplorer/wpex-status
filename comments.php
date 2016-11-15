 <?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments and the comment
 * form. The actual display of comments is handled by a callback to
 * st_comment() which is located at functions/comments-callback.php
 *
 * @package   Status WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.stplorer.com
 * @since     1.0.0
 */

// Return if not needed
if ( post_password_required() || ( ! comments_open() && get_comment_pages_count() == 0 ) ) {
	return;
}

// Return if comments disabled
if ( ! st_has_comments() ) {
	return;
} ?>

<div id="comments" class="comments-area st-clr">

	<?php
	// Display comments if we have some
	if ( have_comments() ) :

		// Get comments title
		$comments_number = number_format_i18n( get_comments_number() );
		if ( '1' == $comments_number ) {
			$comments_title = esc_html__( 'This Post Has One Comment', 'status' );
		} else {
			$comments_title = sprintf( esc_html__( 'This Post Has %s Comments', 'status' ), $comments_number );
		}
		$comments_title = apply_filters( 'st_comments_title', $comments_title );?>

		<h2 class="st-comments-title st-heading"><span class="fa fa-comments"></span><span class="st-txt"><?php echo esc_html( $comments_title ); ?></span></h2>

		<ol class="commentlist"><?php
			// Display comments
			wp_list_comments( array(
				'callback'	=> 'st_comment',
			) );
		?></ol><!-- .commentlist -->

		<?php
		// Display comment pagination
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>

			<nav class="navigation comment-navigation row st-clr" role="navigation">
				<h3 class="assistive-text st-heading">
					<span><?php esc_html_e( 'Comment navigation', 'status' ); ?></span>
				</h3>
				<div class="st-clr">
					<div class="st-nav-previous"><?php
						previous_comments_link( esc_html__( '&larr; Older Comments', 'status' ) );
					?></div>
					<div class="st-nav-next"><?php
						next_comments_link( esc_html__( 'Newer Comments &rarr;', 'status' ) );
					?></div>
				</div><!-- .st-clr -->
			</nav>

		<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php
	// Display comments closed notice
	if ( ! comments_open() ) : ?>

		<div class="comments-closed-notice st-clr"><?php
			esc_html_e( 'Comments are now closed.', 'status' );
		?></div><!-- .comments-closed-notice -->

	<?php endif; ?>

	<?php
	// Display comment submission form
	$args = array();
	if ( st_get_theme_mod( 'disable_comment_form_notes' ) ) {
		$args['comment_notes_after'] = null;
	}
	comment_form( $args ); ?>

</div><!-- #comments -->