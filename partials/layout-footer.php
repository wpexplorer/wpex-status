<?php
/**
 * Footer Layout
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

<?php get_template_part( 'partials/footer/footer-instagram' ); ?>

<?php get_template_part( 'partials/footer/footer-divider' ); ?>

<footer class="st-site-footer"<?php st_schema_markup( 'footer' ); ?>>

	<?php if ( st_has_footer_widgets() ) : ?>
		<?php get_template_part( 'partials/footer/footer-widgets' ); ?>
	<?php endif; ?>

	<?php if ( st_get_theme_mod( 'footer_bottom', true  ) ) : ?>

		<div class="st-footer-bottom">
			<?php st_ad_region( 'footer-bottom' ); ?>
			<div class="st-container st-clr"><?php
				get_template_part( 'partials/footer/footer-copyright' );
			?></div><!-- .st-container -->
		</div><!-- .st-footer-bottom -->

	<?php endif; ?>

</footer><!-- .st-site-footer -->