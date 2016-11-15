<?php
/**
 * Useful conditionals for this theme
 *
 * @package   Status WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.stplorer.com
 * @since     1.0.0
 */

/**
 * Check if scripts are minified
 *
 * @since 1.0.0
 */
function st_has_minified_scripts() {
	return apply_filters( 'st_minified_scripts', true );
}

/**
 * Check if responsiveness is enabled
 *
 * @since 1.0.0
 */
function st_is_responsive() {
	return st_get_theme_mod( 'responsive', true );
}

/**
 * Check if page titles should be over featured images
 *
 * @since 1.0.0
 */
function st_has_page_featured_image_overlay_title() {
	if ( true == apply_filters( 'st_has_page_featured_image_overlay_title', false ) ) {
		return true;
	}
}

/**
 * Check if the header search is enabled
 *
 * @since 1.0.0
 */
function st_has_header_search() {
	return st_get_theme_mod( 'header_search', true );
}

/**
 * Check if comments are enabled
 *
 * @since 1.0.0
 */
function st_has_comments( $bool = true ) {
	if ( 'page' == get_post_type() && ! st_get_theme_mod( 'page_comments', true ) ) {
		$bool = false;
	}
	return apply_filters( 'st_has_comments', $bool );
}

/**
 * Check if post has a video
 *
 * @since 1.0.0
 */
function st_has_post_video( $post_id = '' ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$bool = false;
	$mprefix = st_meta_prefix();
	if ( get_post_meta( $post_id, $mprefix . 'post_video', true ) ) {
		$bool = true;
	}
	return apply_filters( 'st_has_post_video', $bool );
}

/**
 * Check if post has a audio
 *
 * @since 1.0.0
 */
function st_has_post_audio( $post_id = '' ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$bool = false;
	$mprefix = st_meta_prefix();
	if ( get_post_meta( $post_id, $mprefix .'post_audio', true ) ) {
		$bool = true;
	}
	return apply_filters( 'st_has_post_audio', $bool );
}

/**
 * Check if woocommerce is active
 *
 * @since 1.0.0
 */
function st_is_woocommerce_active() {
	return STATUS_WOOCOMMERCE_ACTIVE;
}

/**
 * Check if social share is enabled
 *
 * @since 1.0.0
 */
function st_has_social_share() {
	$bool = ( is_singular( 'post' ) && st_get_theme_mod( 'social_share', true ) ) ? true : false;
	return apply_filters( 'st_has_social_share', $bool );
}

/**
 * Check if social share is enabled
 *
 * @since 1.0.0
 */
function st_has_author_bio( $bool = true ) {
	$bool = st_get_theme_mod( 'post_author_info', true );
	$bool = apply_filters( 'st_has_author_bio', $bool );
	return $bool;
}

/**
 * Check if footer widgets are enabled
 *
 * @since 1.0.0
 */
function st_has_footer_widgets( $bool = true ) {
	$columns = st_get_theme_mod( 'footer_widget_columns', 4 );
	if ( ! $columns || '0' == $columns || 'disable' == $columns ) {
		$bool = false;
	}
	if ( $bool ) {
		if ( is_active_sidebar( 'footer-one' )
			|| is_active_sidebar( 'footer-two' )
			|| is_active_sidebar( 'footer-three' )
			|| is_active_sidebar( 'footer-four' )
		) {
			$bool = true;
		} else {
			$bool = false;
		}
	}
	$bool = apply_filters( 'st_has_footer_widgets', $bool );
	return $bool;
}

/**
 * Check if custom excerpt is enabled
 *
 * @since 1.0.0
 */
function st_has_custom_excerpt() {
	$display = st_get_theme_mod( 'entry_content_display', 'excerpt' );
	$length  = st_get_theme_mod( 'entry_excerpt_length', 45 );
	if ( 'excerpt' == $display && $length > 0 ) {
		$bool = true;
	} else {
		$bool = false;
	}
	$bool = apply_filters( 'st_has_custom_excerpt', $bool );
	return $bool;
}

/**
 * WooCommerce Check
 *
 * @since 1.0.0
 */
function st_is_woocommerce() {
	if ( ! STATUS_WOOCOMMERCE_ACTIVE ) {
		return false;
	}
	if ( is_woocommerce() || is_cart() || is_checkout() ) {
		return true;
	}
}

/**
 * Checks if a user has social options defined
 *
 * @since 1.0.0
 */

function st_author_has_social( $user_id = NULL ) {
	if ( get_the_author_meta( 'wpex_twitter', $user_id ) ) {
		return true;
	} elseif ( get_the_author_meta( 'wpex_facebook', $user_id ) ) {
		return true;
	} elseif ( get_the_author_meta( 'wpex_googleplus', $user_id ) ) {
		return true;
	} elseif ( get_the_author_meta( 'wpex_linkedin', $user_id ) ) {
		return true;
	} elseif ( get_the_author_meta( 'wpex_instagram', $user_id ) ) {
		return true;
	} elseif ( get_the_author_meta( 'wpex_pinterest', $user_id ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Entry readmore button check
 *
 * @since 1.0.0
 */
function st_entry_as_readmore() {
	if ( isset( $_GET['st_readmore'] ) && '1' == $_GET['st_readmore'] ) {
		return true;
	}
	return apply_filters( 'st_entry_as_readmore', st_get_theme_mod( 'entry_readmore', false ) );
}