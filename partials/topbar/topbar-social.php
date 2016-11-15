<?php
/**
 * Topbar Social
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

// Display topbar social
if ( st_get_theme_mod( 'topbar_social_enable', true )
		&& $social_options = st_topbar_social_options_array()
) : ?>

	<div class="st-topbar-social st-clr">
		<?php foreach ( $social_options as $key => $val ) :
			if ( $url = esc_url( st_get_theme_mod( 'topbar_social_'. $key ) ) ) :
			$target_blank = st_get_theme_mod( 'topbar_social_target_blank' ) ? true : false; ?>
				<div class="st-topbar-social-item"><a href="<?php echo esc_url( $url ); ?>" title="<?php echo esc_attr( $val['label'] ); ?>" class="st-social-bg st-<?php echo esc_attr( $key ); ?>"<?php st_target_blank( $target_blank ); ?>><span class="<?php echo esc_attr( $val['icon_class'] ); ?>"></span></a></div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div><!-- .st-topbar-social -->
	
<?php endif; ?>