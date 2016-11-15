<?php
/**
 * The template for displaying the footer and closing elements starting in header.php
 *
 * @package   Status WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.stplorer.com
 * @since     1.0.0
 */ ?>

	</div><!-- .st-site-content -->

	<?php get_template_part( 'partials/layout-footer' ); ?>

</div><!-- .st-site-wrap -->

<?php get_template_part( 'partials/global/scrolltop' ); ?>

<?php
// Search overlay
if ( st_get_theme_mod( 'menu_search', true ) ) :
	get_template_part( 'partials/global/search-overlay' );
endif; ?>

<?php
// Display post share above post
if ( st_has_social_share() ) :
	get_template_part( 'partials/global/share' );
endif; ?>

<?php wp_footer(); ?>
</body>
</html>