<?php
/**
 * Core functions used for the theme
 *
 * @package   Status WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.stplorer.com
 * @since     1.0.0
 */

/**
 * Returns theme mod
 *
 * @since 1.0.0
 */
function st_get_theme_mod( $key, $default = '' ) {
	return get_theme_mod( 'st_'. $key, $default );
}

/**
 * Echos theme mod
 *
 * @since 1.0.0
 */
function st_theme_mod( $key, $default = '' ) {
	echo st_get_theme_mod( $key, $default );
}


/**
 * Returns meta prefix - so if you switch to another WPExplorer theme
 * you can keep your meta settings via simple filter
 *
 * @since 1.0.0
 */
function st_meta_prefix() {
	$prefix = st_get_theme_mod( 'meta_prefix' );
	$prefix = $prefix ? $prefix : 'st_';
	return apply_filters( 'st_meta_prefix', $prefix );
}

/**
 * Returns theme image sizes
 *
 * @since 3.1.1
 */
function st_get_image_sizes() {
	return apply_filters( 'st_get_image_sizes', array(
		'entry_featured'   => esc_html__( 'Featured Entry', 'status' ),
		'entry_grid'       => esc_html__( 'Grid Entries', 'status' ),
		'entry_left_right' => esc_html__( 'Left/Right Entries', 'status' ),
		'entry_full'       => esc_html__( 'Fullwidth Entries', 'status' ),
		'entry_related'    => esc_html__( 'Related Entries', 'status' ),
		'post'             => esc_html__( 'Single Post', 'status' ),
	) );
}

/**
 * Returns correct ID for any object
 * Used to fix issues with translation plugins such as WPML
 *
 * @since 3.1.1
 */
function st_parse_obj_id( $id = '', $type = 'page' ) {
	if ( $id && function_exists( 'icl_object_id' ) ) {
		$id = icl_object_id( $id, $type );
	}
	return $id;
}

/**
 * Array of image crop locations
 *
 * @link 2.0.0
 */
function st_image_crop_locations() {
	return array(
		' '             => esc_html__( 'Default', 'status' ),
		'left-top'      => esc_html__( 'Top Left', 'status' ),
		'right-top'     => esc_html__( 'Top Right', 'status' ),
		'center-top'    => esc_html__( 'Top Center', 'status' ),
		'left-center'   => esc_html__( 'Center Left', 'status' ),
		'right-center'  => esc_html__( 'Center Right', 'status' ),
		'center-center' => esc_html__( 'Center Center', 'status' ),
		'left-bottom'   => esc_html__( 'Bottom Left', 'status' ),
		'right-bottom'  => esc_html__( 'Bottom Right', 'status' ),
		'center-bottom' => esc_html__( 'Bottom Center', 'status' ),
	);
}

/**
 * Parse image crop option and returns correct value for add_image_size
 *
 * @link 2.0.0
 */
function st_parse_image_crop( $crop = 'true' ) {
	$return = true;
	if ( $crop && is_string( $crop ) && array_key_exists( $crop, st_image_crop_locations() ) ) {
		$return = explode( '-', $crop );
	}
	$return = $return ? $return : true;
	return $return;
}

/**
 * Get first post with featured image in current query
 *
 * @since 1.0.0
 */
function st_get_first_post_with_thumb( $query = '' ) {
	if ( ! $query ) {
		global $wp_query;
		$query = $wp_query;
	}
	$posts = $query->posts;
	$posts_count = count( $posts );
	if ( $posts_count == 0 ) {
		return;
	}
	$post_with_thumb = 0;
	foreach ( $posts as $post ) {
		if ( has_post_thumbnail( $post->ID ) ) {
			$post_with_thumb = $post->ID;
			break;
		}
	}
	return $post_with_thumb;
}

/**
 * Returns correct header logo src
 *
 * @since 1.0.0
 */
function st_get_header_logo_src() {
	return apply_filters( 'st_header_logo_src', st_get_theme_mod( 'logo' ) );
}

/**
 * Returns escaped post title
 *
 * @since 1.0.0
 */
function st_get_esc_title() {
	return esc_attr( the_title_attribute( 'echo=0' ) );
}

/**
 * Outputs escaped post title
 *
 * @since 1.0.0
 */
function st_esc_title() {
	echo st_get_esc_title();
}

/**
 * Returns current page or post ID
 *
 * @since 1.0.0
 */
function st_get_the_id() {

	// If singular get_the_ID
	if ( is_singular() ) {
		return get_the_ID();
	}

	// Get ID of WooCommerce product archive
	elseif ( is_post_type_archive( 'product' ) && class_exists( 'Woocommerce' ) && function_exists( 'wc_get_page_id' ) ) {
		$shop_id = wc_get_page_id( 'shop' );
		if ( isset( $shop_id ) ) {
			return wc_get_page_id( 'shop' );
		}
	}

	// Posts page
	elseif ( is_home() && $page_for_posts = get_option( 'page_for_posts' ) ) {
		return $page_for_posts;
	}

	// Return nothing
	else {
		return NULL;
	}

}

/**
 * Returns entry style
 *
 * @since 1.0.0
 */
function st_get_blog_entry_style() {
	if ( ! empty( $_GET['entry_style'] ) ) {
		return esc_html( $_GET['entry_style'] );
	}
	$style = st_get_theme_mod( 'entry_style' );
	$style = $style ? $style : 'grid';
	return esc_html( apply_filters( 'st_get_blog_entry_style', $style ) );
}

/**
 * Returns entry image size
 *
 * @since 1.0.0
 */
function st_get_entry_image_size() {
	$entry_style = st_get_blog_entry_style();
	if ( 'left_right' == $entry_style ) {
		$size = 'st_entry_left_right';
	} elseif ( 'grid' == $entry_style ) {
		$size = 'st_entry_grid';
	} else {
		$size = 'st_entry_full';
	}
	return esc_html( apply_filters( 'st_get_entry_image_size', $size ) );
}

/**
 * Returns featured entry image size
 *
 * @since 1.0.0
 */
function st_get_featured_entry_image_size() {
	return esc_html( apply_filters( 'st_get_featured_entry_image_size', 'st_post' ) );
}

/**
 * Returns current page or post layout
 *
 * @since 1.0.0
 */
function st_get_loop_columns() {

	// Check URL
	if ( ! empty( $_GET['columns'] ) ) {
		return intval( $_GET['columns'] );
	}

	// Get post ID
	$post_id = st_get_the_id();

	// Get theme mod setting
	$columns = st_get_theme_mod( 'entry_columns' );

	// Apply filters
	$columns = apply_filters( 'st_loop_columns', $columns );

	// Sanitize
	$columns = $columns ? $columns : 2;

	// Return layout
	return intval( $columns );

}

/**
 * Returns current page or post layout
 *
 * @since 1.0.0
 */
function st_get_post_layout() {

	// Check URL
	if ( ! empty( $_GET['layout'] ) ) {
		return esc_html( $_GET['layout'] );
	}

	// Get post ID
	$post_id = st_get_the_id();

	// Set default layout
	$layout = 'right-sidebar';

	// Posts
	if ( is_page() ) {
		$layout = st_get_theme_mod( 'page_layout' );
	}

	// Posts
	elseif ( is_singular() ) {
		$layout = st_get_theme_mod( 'post_layout' );
	}

	// Full-width pages
	if ( is_404() ) {
		$layout = 'full-width';
	}

	// Homepage
	elseif ( is_home() || is_front_page() ) {
		$layout = st_get_theme_mod( 'home_layout' );
	}

	// Search
	elseif ( is_search() ) {
		$layout = st_get_theme_mod( 'search_layout' );
	}

	// Archive
	elseif ( is_archive() ) {
		$layout = st_get_theme_mod( 'archives_layout' );
	}

	// Apply filters
	$layout = apply_filters( 'st_post_layout', $layout );

	// Check meta
	$mprefix = st_meta_prefix();
	if ( $meta = get_post_meta( st_get_the_id(), $mprefix .'post_layout', true ) ) {
		$layout = $meta;
	}

	// Sanitize
	$layout = $layout ? $layout : 'right-sidebar';

	// Return layout
	return $layout;

}

/**
 * Returns target blank
 *
 * @since 1.0.0
 */
function st_get_target_blank( $display = false ) {
	if ( $display ) {
		return ' target="_blank"';
	}
}

/**
 * Echos target blank
 *
 * @since 1.0.0
 */
function st_target_blank( $display = false ) {
	echo st_get_target_blank( $display );
}

/**
 * Sanitizes data
 *
 * @since 1.0.0
 */
function st_sanitize( $data = '', $type = null ) {

	// Advertisement
	if ( 'advertisement' == $type ) {
		return $data;
	}

	// URL
	elseif ( 'url' == $type ) {
		$data = esc_url( $data );
	}

	// CSS
	elseif ( 'css' == $type ) {
		$data = $data; // nothing yet
	}

	// Image
	elseif ( 'img' == $type || 'image' == $type ) {
		$data = wp_kses( $data, array(
			'img'       => array(
				'src'   => array(),
				'alt'   => array(),
				'title' => array(),
				'data'  => array(),
				'id'    => array(),
				'class' => array(),
			),
		) );
	}

	// Link
	elseif ( 'link' == $type ) {
		$data = wp_kses( $data, array(
			'a'         => array(
				'href'  => array(),
				'title' => array(),
				'rel'   => array(),
				'class' => array(),
				'data'  => array(),
				'id'    => array(),
			),
		) );
	}

	// HTML
	elseif ( 'html' == $type ) {
		$data = htmlspecialchars_decode( wp_kses_post( $data ) );
	}

	// Videos
	elseif ( 'video' == $type || 'audio' == $type || 'embed' ) {
		$data = wp_kses( $data, array(
			'iframe' => array(
				'src'               => array(),
				'type'              => array(),
				'allowfullscreen'   => array(),
				'allowscriptaccess' => array(),
				'height'            => array(),
				'width'             => array()
			),
			'embed' => array(
				'src'               => array(),
				'type'              => array(),
				'allowfullscreen'   => array(),
				'allowscriptaccess' => array(),
				'height'            => array(),
				'width'             => array()
			),
		) );
	}

	// Apply filters and return
	return apply_filters( 'st_sanitize', $data );

}

/**
 * Checks a custom field value and returns the type (embed, oembed, etc )
 *
 * @since 1.0.0
 */
function st_check_meta_type( $value ) {
	if ( strpos( $value, 'embed' ) ) {
		return 'embed';
	} elseif ( strpos( $value, 'iframe' ) ) {
		return 'iframe';
	} else {
		return 'url';
	}
}

/**
 * Custom menu walker
 * 
 * @link  http://codex.wordpress.org/Class_Reference/Walker_Nav_Menu
 * @since 1.0.0
 */
if ( ! class_exists( 'STATUS_Dropdown_Walker_Nav_Menu' ) ) {
	class STATUS_Dropdown_Walker_Nav_Menu extends Walker_Nav_Menu {
		function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
			$id_field = $this->db_fields['id'];
			if ( ! empty( $children_elements[$element->$id_field] ) && ( $depth == 0 ) ) {
				$element->title .= ' <span class="fa fa-caret-down st-dropdown-arrow-down"></span>';
			}
			if ( ! empty( $children_elements[$element->$id_field] ) && ( $depth > 0 ) ) {
				$element->title .= ' <span class="fa fa-caret-right st-dropdown-arrow-side"></span>';
			}
			Walker_Nav_Menu::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		}
	}
}

/**
 * Custom comments callback
 * 
 * @link  http://codex.wordpress.org/Function_Reference/wp_list_comments
 * @since 1.0.0
 */
if ( ! function_exists( 'st_comment' ) ) {
	function st_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
				// Display trackbacks differently than normal comments. ?>
				<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
				<p><strong><?php esc_html_e( 'Pingback:', 'status' ); ?></strong> <?php comment_author_link(); ?></p>
			<?php
			break;
			default :
				// Proceed with normal comments. ?>
				<li id="li-comment-<?php comment_ID(); ?>">
					<div id="comment-<?php comment_ID(); ?>" <?php comment_class( 'st-clr' ); ?>>
						<div class="comment-author vcard">
							<?php
							// Display avatar
							$avatar_size = apply_filters( 'st_comments_avatar_size', 45 );
							echo get_avatar( $comment, $avatar_size ); ?>
						</div><!-- .comment-author -->
						<div class="comment-details st-clr">
							<header class="comment-meta">
								<cite class="fn"><?php comment_author_link(); ?></cite>
								<span class="comment-date"><?php
									printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
										esc_url( get_comment_link( $comment->comment_ID ) ),
										get_comment_time( 'c' ),
										sprintf( _x( '%1$s', '1: date', 'status' ), get_comment_date() )
								); ?></span><!-- .comment-date -->
								<?php
								// Comment reply link
								if ( '0' != $comment->comment_approved ) {
									comment_reply_link( array_merge( $args, array(
										'reply_text'    => esc_html__( 'Reply', 'status' ) . '',
										'depth'         => $depth,
										'max_depth'     => $args['max_depth']
									) ) );
								} ?>
							</header><!-- .comment-meta -->
							<?php if ( '0' == $comment->comment_approved ) : ?>
								<p class="comment-awaiting-moderation">
									<?php esc_html_e( 'Your comment is awaiting moderation.', 'status' ); ?>
								</p><!-- .comment-awaiting-moderation -->
							<?php endif; ?>
							<div class="comment-content st-entry st-clr">
								<?php comment_text(); ?>
							</div><!-- .comment-content -->
							<footer class="comment-footer st-clr">
								<?php
								// Edit comment link
								edit_comment_link( esc_html__( 'Edit', 'status' ), '<div class="edit-comment">', '</div>' ); ?>
							</footer>
						</div><!-- .comment-details -->
					</div><!-- #comment-## -->
			<?php
			break;
		endswitch;
	}
}

/**
 * Returns correct entry excerpt length
 * 
 * @since 1.0.0
 */
function st_get_entry_excerpt_length() {
	if ( isset( $_GET['excerpt_length'] ) ) {
		return esc_html( $_GET['excerpt_length'] );
	}
	return st_get_theme_mod( 'entry_excerpt_length', 20 );
}

/**
 * Custom excerpts based on wp_trim_words
 * Created for child-theming purposes
 * 
 * @link  http://codex.wordpress.org/Function_Reference/wp_trim_words
 * @since 1.0.0
 */
function st_get_excerpt( $length = '', $readmore = false ) {

	// Get excerpt length
	$length = $length ? $length : st_get_entry_excerpt_length();

	// Get global post data
	global $post;

	// Check for custom excerpt
	if ( has_excerpt( $post->ID ) ) {
		$output = $post->post_excerpt;
	}

	// No custom excerpt...so lets generate one
	else {

		// Redmore text
		$readmore_text = st_get_theme_mod( 'entry_readmore_text', esc_html__( 'read more', 'status' ) );

		// Readmore link
		$readmore_link = '<a href="'. get_permalink( $post->ID ) .'" title="'. $readmore_text .'">'. $readmore_text .'<span class="st-readmore-rarr">&rarr;</span></a>';

		// Check for more tag and return content if it exists
		if ( ! st_get_theme_mod( 'disable_more_tag', false ) && strpos( $post->post_content, '<!--more-->' ) ) {
			$output = apply_filters( 'the_content', get_the_content() );
		}

		// No more tag defined so generate excerpt using wp_trim_words
		else {

			// Generate excerpt
			$output = wp_trim_words( strip_shortcodes( get_the_content( $post->ID ) ), $length );

			// Add readmore to excerpt if enabled
			if ( $readmore == true ) {
				$output .= apply_filters( 'st_readmore_link', $readmore_link );
			}

		}

	}

	// Apply filters and echo
	return apply_filters( 'st_get_excerpt', $output );

}

/**
 * Echos custom excerpt
 *
 * @since 1.0.0
 */
function st_excerpt( $length = '', $readmore = false ) {
	echo st_get_excerpt( $length, $readmore );
}

/**
 * Includes correct template part
 *
 * @since 1.0.0
 */
function st_include_template( $template ) {

	// Return if no template is defined
	if ( ! $template ) {
		return;
	}

	// Locate template
	$template = locate_template( $template, false );

	// Load template if it exists
	if ( $template ) {
		include( $template );
	}

}

/**
 * List categories for specific taxonomy
 * 
 * @link    http://codex.wordpress.org/Function_Reference/wp_get_post_terms
 * @since   1.0.0
 */
if ( ! function_exists( 'st_get_post_terms' ) ) {

	function st_get_post_terms( $taxonomy = 'category', $first_only = false, $classes = '' ) {

		// Define return var
		$return = array();

		// Get terms
		$terms = wp_get_post_terms( get_the_ID(), $taxonomy );

		// Loop through terms and create array of links
		foreach ( $terms as $term ) {

			// Add classes
			$add_classes = 'st-term-'. $term->term_id;
			if ( $classes ) {
				$add_classes .= ' '. $classes;
			}
			if ( $add_classes ) {
				$add_classes = ' class="'. $add_classes .'"';
			}

			// Get permalink
			$permalink = get_term_link( $term->term_id, $taxonomy );

			// Add term to array
			$return[] = '<a href="'. esc_url( $permalink ) .'" title="'. $term->name .'"'. $add_classes .'>'. $term->name .'</a>';

		}

		// Return if no terms are found
		if ( ! $return ) {
			return;
		}

		// Return first category only
		if ( $first_only ) {
			
			$return = $return[0];

		}

		// Turn terms array into comma seperated list
		else {

			$return = implode( '', $return );

		}

		// Return or echo
		return $return;

	}

}

/**
 * Echos the st_list_post_terms function
 * 
 * @since 1.0.0
 */
function st_post_terms( $taxonomy = 'category', $first_only = false, $classes = '' ) {
	echo st_get_post_terms( $taxonomy, $first_only, $classes );
}

/**
 * List categories for specific taxonomy without links
 * 
 * @link    http://codex.wordpress.org/Function_Reference/wp_get_post_terms
 * @since   1.0.0
 */
if ( ! function_exists( 'st_get_post_terms_list' ) ) {

	function st_get_post_terms_list( $taxonomy = 'category', $first_only = false, $classes = '' ) {

		// Define return var
		$return = array();

		// Get terms
		$terms = wp_get_post_terms( get_the_ID(), $taxonomy );

		// Loop through terms and create array of links
		foreach ( $terms as $term ) {

			// Add classes
			$add_classes = 'st-term-'. $term->term_id;
			if ( $classes ) {
				$add_classes .= ' '. $classes;
			}
			if ( $add_classes ) {
				$add_classes = ' class="'. $add_classes .'"';
			}

			// Get permalink
			$permalink = get_term_link( $term->term_id, $taxonomy );

			// Add term to array
			$return[] = '<span'. $add_classes .'>'. $term->name .'</span>';

		}

		// Return if no terms are found
		if ( ! $return ) {
			return;
		}

		// Return first category only
		if ( $first_only ) {
			
			$return = $return[0];

		}

		// Turn terms array into comma seperated list
		else {

			$return = implode( '', $return );

		}

		// Return or echo
		return $return;

	}

}

/**
 * Echos the st_get_post_terms_list function
 * 
 * @since 1.0.0
 */
function st_post_terms_list( $taxonomy = 'category', $first_only = false, $classes = '' ) {
	echo st_get_post_terms( $taxonomy, $first_only, $classes );
}

/**
 * Returns correct ad region template part
 *
 * @since 1.0.0
 */
function st_ad_region( $location ) {
	if ( ! empty( $_GET['disable_ads'] ) ) {
		return;
	}
	$location = 'partials/ads/ad-'. $location;
	get_template_part( $location );
}

/**
 * Returns thumbnail sizes
 *
 * @since 1.0.0
 * @link  http://codex.wordpress.org/Function_Reference/get_intermediate_image_sizes
 */
function st_get_thumbnail_sizes( $size = '' ) {

	global $_wp_additional_image_sizes;

	$sizes = array(
		'full'  => array(
		'width'  => '9999',
		'height' => '9999',
		'crop'   => 0,
		),
	);
	$get_intermediate_image_sizes = get_intermediate_image_sizes();

	// Create the full array with sizes and crop info
	foreach( $get_intermediate_image_sizes as $_size ) {

		if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {

			$sizes[ $_size ]['width']   = get_option( $_size . '_size_w' );
			$sizes[ $_size ]['height']  = get_option( $_size . '_size_h' );
			$sizes[ $_size ]['crop']    = (bool) get_option( $_size . '_crop' );

		} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {

			$sizes[ $_size ] = array( 
				'width'     => $_wp_additional_image_sizes[ $_size ]['width'],
				'height'    => $_wp_additional_image_sizes[ $_size ]['height'],
				'crop'      => $_wp_additional_image_sizes[ $_size ]['crop']
			);

		}

	}

	// Get only 1 size if found
	if ( $size ) {
		if ( isset( $sizes[ $size ] ) ) {
			return $sizes[ $size ];
		} else {
			return false;
		}
	}

	// Return sizes
	return $sizes;
}

/**
 * Topbar Social Options array
 *
 * @since 1.0.0
 */
function st_topbar_social_options_array() {
	return apply_filters( 'st_topbar_social_options_array', array(
		'twitter' => array(
			'label'      => 'Twitter',
			'icon_class' => 'fa fa-twitter',
		),
		'facebook' => array(
			'label'      => 'Facebook',
			'icon_class' => 'fa fa-facebook',
		),
		'googleplus' => array(
			'label'      => 'Google Plus',
			'icon_class' => 'fa fa-google-plus',
		),
		'pinterest' => array(
			'label'      => 'Pinterest',
			'icon_class' => 'fa fa-pinterest',
		),
		'dribbble' => array(
			'label'      => 'Dribbble',
			'icon_class' => 'fa fa-dribbble',
		),
		'vk' => array(
			'label'      => 'Vk',
			'icon_class' => 'fa fa-vk',
		),
		'instagram' => array(
			'label'      => 'Instagram',
			'icon_class' => 'fa fa-instagram',
		),
		'linkedin' => array(
			'label'      => 'LinkedIn',
			'icon_class' => 'fa fa-linkedin',
		),
		'tumblr' => array(
			'label'      => 'Tumblr',
			'icon_class' => 'fa fa-tumblr',
		),
		'github' => array(
			'label'      => 'Github',
			'icon_class' => 'fa fa-github-alt',
		),
		'flickr' => array(
			'label'      => 'Flickr',
			'icon_class' => 'fa fa-flickr',
		),
		'skype' => array(
			'label'      => 'Skype',
			'icon_class' => 'fa fa-skype',
		),
		'youtube' => array(
			'label'      => 'Youtube',
			'icon_class' => 'fa fa-youtube-play',
		),
		'vimeo' => array(
			'label'      => 'Vimeo',
			'icon_class' => 'fa fa-vimeo-square',
		),
		'vine' => array(
			'label'      => 'Vine',
			'icon_class' => 'fa fa-vine',
		),
		'xing' => array(
			'label'      => 'Xing',
			'icon_class' => 'fa fa-xing',
		),
		'yelp' => array(
			'label'      => 'Yelp',
			'icon_class' => 'fa fa-yelp',
		),
		'email' => array(
			'label'      => esc_html__( 'Email', 'status' ),
			'icon_class' => 'fa fa-envelope',
		),
		'rss' => array(
			'label'      => esc_html__( 'RSS', 'status' ),
			'icon_class' => 'fa fa-rss',
		),
	) );
}

/**
 * Displays stars for rating value
 *
 * @since 1.0.0
 */
function st_star_rating( $rating = '' ) {

	// Get Meta
	if ( ! $rating ) {
		$mprefix = st_meta_prefix();
		$rating = get_post_meta( $post_id, $mprefix .'post_rating', true );
	}

	// Return if no rating
	if ( ! $rating ) {
		return false;
	}

	// Sanitize
	else {
		$rating = abs( $rating );
	}

	$output = '';

	// Star fonts
	$full_star  = '<span class="fa fa-star"></span>';
	$half_star  = '<span class="fa fa-star-half-full"></span>';
	$empty_star = '<span class="fa fa-star-o"></span>';

	// Integers
	if ( ( is_numeric( $rating ) && ( intval( $rating ) == floatval( $rating ) ) ) ) {
		$output = str_repeat( $full_star, $rating );
		if ( $rating < 5 ) {
			$output .= str_repeat( $empty_star, 5 - $rating );
		}
		
	// Fractions
	} else {
		$rating = intval( $rating );
		$output = str_repeat( $full_star, $rating );
		$output .= $half_star;
		if ( $rating < 5 ) {
			$output .= str_repeat( $empty_star, 4 - $rating );
		}
	}

	// Return output
	return $output;

}

/**
 * Outputs post video
 *
 * @since 1.0.0
 */
function st_post_video( $post_id = '' ) {

	// Get post id
	$post_id = $post_id ? $post_id : get_the_ID();

	// Meta prefix
	$mprefix = st_meta_prefix();

	// Get video
	$video = get_post_meta( $post_id, $mprefix .'post_video', true );
	$video = apply_filters( 'st_post_video', $video );

	// Display video if defined
	if ( $video ) :

		// Check what type of video it is
		$type = st_check_meta_type( $video );

		// Standard Embeds
		if ( 'iframe' == $type || 'embed' == $type ) {
			echo st_sanitize( $video, 'video' );
		}
		// Oembeds
		else {
			echo wp_oembed_get( $video );
		}

	endif;
}

/**
 * Outputs post video
 *
 * @since 1.0.0
 */
function st_post_audio( $post_id = '' ) {

	// Get post id
	$post_id = $post_id ? $post_id : get_the_ID();

	// Meta prefix
	$mprefix = st_meta_prefix();

	// Get audio
	$audio = get_post_meta( $post_id, $mprefix .'post_audio', true );
	$audio = apply_filters( 'st_post_audio', $audio );

	// Display audio if defined
	if ( $audio ) :

		// Check what type of audio it is
		$type = st_check_meta_type( $audio );

		// Standard Embeds
		if ( 'iframe' == $type || 'embed' == $type ) {
			echo st_sanitize( $audio, 'audio' );
		}
		// Oembeds
		else {
			echo wp_oembed_get( $audio );
		}

	endif;
}

/**
 * Return correct Google font url
 *
 * @since 1.0.0
 */
function st_get_gfont_url( $font ) {

	// Sanitize handle
	$handle = trim( $font );
	$handle = strtolower( $handle );
	$handle = str_replace( ' ', '-', $handle );

	// Sanitize font name
	$font = trim( $font );
	$font = str_replace( ' ', '+', $font );

	// Subset
	$subset = apply_filters( 'st_google_font_subsets', 'latin' );
	$subset = $subset ? $subset : 'latin';
	$subset = '&amp;subset='. $subset;

	// Weights
	$weights = array( '100', '200', '300', '400', '500', '600', '700', '800', '900' );
	$weights = apply_filters( 'wpex_google_font_enqueue_weights', $weights, $font );
	$italics = apply_filters( 'wpex_google_font_enqueue_italics', true );

	// Google URl
	$gurl = esc_url( apply_filters( 'st_get_google_fonts_url', '//fonts.googleapis.com' ) );

	// Main URL
	$url = $gurl .'/css?family='. str_replace(' ', '%20', $font ) .':';

	// Add weights to URL
	if ( ! empty( $weights ) ) {
		$url .= implode( ',' , $weights );
		$italic_weights = array();
		if ( $italics ) {
			foreach ( $weights as $weight ) {
				$italic_weights[] = $weight .'italic';
			}
			$url .= implode( ',' , $italic_weights );
		}
	}

	// Add subset to URL
	$url .= $subset;

	// Return url
	return $url;

}

/**
 * Minify CSS
 *
 * @since 1.0.0
 */
function st_minify_css( $css ) {

	// Normalize whitespace
	$css = preg_replace( '/\s+/', ' ', $css );

	// Remove ; before }
	$css = preg_replace( '/;(?=\s*})/', '', $css );

	// Remove space after , : ; { } */ >
	$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

	// Remove space before , ; { }
	$css = preg_replace( '/ (,|;|\{|})/', '$1', $css );

	// Strips leading 0 on decimal values (converts 0.5px into .5px)
	$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

	// Strips units if value is 0 (converts 0px to 0)
	$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

	// Return minified CSS
	return trim( $css );

}

/**
 * Strong password script
 *
 * @since 1.0.0
 */
function st_strong_pass_inline_script() {

	return "// <![CDATA[
	jQuery(function(){
		// Password check
		function password_strength() {
			var pass = jQuery('#st_user_pass').val();
			var pass2 = jQuery('#st_user_pass_repeat').val();
			var user = jQuery('#st_user_name').val();
			jQuery('.st-pass-strength').removeClass('st-short st-bad st-good st-strong st-empty st-mismatch');
			if ( ! pass ) {
				jQuery('#pass-strength-result').html( pwsL10n.empty );
				return;
			}
			var strength = passwordStrength(pass, user, pass2);
			if ( 2 == strength )
				jQuery('.st-pass-strength').addClass('st-bad').html( pwsL10n.bad );
			else if ( 3 == strength )
				jQuery('.st-pass-strength').addClass('st-good').html( pwsL10n.good );
			else if ( 4 == strength )
				jQuery('.st-pass-strength').addClass('st-strong').html( pwsL10n.strong );
			else if ( 5 == strength )
				jQuery('.st-pass-strength').addClass('st-mismatch').html( pwsL10n.mismatch );
			else
				jQuery('.st-pass-strength').addClass('st-short').html( pwsL10n.short );
		}
		jQuery( '#st_user_pass, #st_user_pass_repeat').val('').keyup( password_strength );
	});
	pwsL10n = {
		empty    : '". esc_html__( 'Strength indicator', 'status' ) ."',
		short    : '". esc_html__( 'Very weak', 'status' ) ."',
		bad      : '". esc_html__( 'Weak', 'status' ) ."',
		good     : '". esc_html__( 'Medium', 'status' ) ."',
		strong   : '". esc_html__( 'Strong', 'status' ) ."',
		mismatch : '". esc_html__( 'Mismatch', 'status' ) ."'
	}
	try{convertEntities(pwsL10n);}catch(e){};
	// ]]>";

}