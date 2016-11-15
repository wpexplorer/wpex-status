<?php
/**
 * Theme functions and definitions.
 *
 * Sets up the theme and provides some helper functions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package   Status WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.stplorer.com
 * @since     1.0.0
 */

class Status_Theme {

	/**
	 * Start things up
	 *
     * @since  1.0.0
     * @access public
	 */
	public function __construct() {

		// Add Filters
		add_filter( 'st_gallery_metabox_post_types', array( 'Status_Theme', 'gallery_metabox_post_types' ) );
		add_filter( 'excerpt_more', array( 'Status_Theme', 'excerpt_more' ) );
		add_filter( 'embed_oembed_html', array( 'Status_Theme', 'embed_oembed_html' ), 99, 4 );
		add_filter( 'pre_get_posts', array( 'Status_Theme', 'pre_get_posts' ) );
		add_filter( 'manage_post_posts_columns', array( 'Status_Theme', 'posts_columns' ), 10 );
		add_filter( 'manage_page_posts_columns', array( 'Status_Theme', 'posts_columns' ), 10 );
		add_filter( 'mce_buttons_2', array( 'Status_Theme', 'mce_font_size_select' ) );
		add_filter( 'tiny_mce_before_init', array( 'Status_Theme', 'fontsize_formats' ) );
		add_filter( 'mce_buttons', array( 'Status_Theme', 'formats_button' ) );
		add_filter( 'tiny_mce_before_init', array( 'Status_Theme', 'formats' ) );
		add_filter( 'use_default_gallery_style', array( 'Status_Theme', 'remove_gallery_styles' ) );
		add_filter( 'user_contactmethods', array( 'Status_Theme', 'user_fields' ) );
		add_filter( 'body_class', array( 'Status_Theme', 'body_classes' ) );
		add_action( 'wp_head', array( 'Status_Theme', 'theme_meta_generator' ), 9999 );
		add_filter( 'wp_nav_menu_items', array( 'Status_Theme', 'menu_add_items' ), 11, 2 );
		add_filter( 'comment_form_fields', array( 'Status_Theme', 'move_comment_form_fields' ) );
		add_filter( 'the_author_posts_link', array( 'Status_Theme', 'the_author_posts_link' ) );
		add_filter( 'wpseo_breadcrumb_output', array( 'Status_Theme', 'yoast_breadcrumbs_fixes' ) );
		add_filter( 'http_request_args', array( 'Status_Theme', 'disable_wporg_request' ), 5, 2 );

		// Actions
		add_action( 'after_setup_theme', array( 'Status_Theme', 'constants' ), 1 );
		add_action( 'after_setup_theme', array( 'Status_Theme', 'load_files' ), 2 );
		add_action( 'after_setup_theme', array( 'Status_Theme', 'setup' ), 3 );
		add_action( 'wp_enqueue_scripts', array( 'Status_Theme', 'theme_css' ) );
		add_action( 'wp_enqueue_scripts', array( 'Status_Theme', 'theme_js' ) );
		add_action( 'widgets_init', array( 'Status_Theme', 'register_sidebars' ) );
		add_action( 'manage_posts_custom_column', array( 'Status_Theme', 'posts_custom_columns' ), 10, 2 );
		add_action( 'manage_pages_custom_column', array( 'Status_Theme', 'posts_custom_columns' ), 10, 2 );
		add_action( 'wp_footer', array( 'Status_Theme', 'mobile_alternative' ) );
		add_action( 'template_redirect', array( 'Status_Theme', 'random_redirect' ) );

		// Custom Widgets
		self::load_custom_widgets();

	}

	/**
	 * Define constants
	 *
     * @since  1.0.0
     * @access public
	 */
	public static function constants() {
		define( 'STATUS_WOOCOMMERCE_ACTIVE', class_exists( 'WooCommerce' ) );
	}

	/**
	 * Include functions and classes
	 *
     * @since  1.0.0
     * @access public
	 */
	public static function load_files() {

		$dir = get_template_directory();

		// Include Theme Functions
		require_once( $dir .'/inc/core-functions.php' );
		require_once( $dir .'/inc/conditionals.php' );
		require_once( $dir .'/inc/customizer-config.php' );
		require_once( $dir .'/inc/accent-config.php' );
		require_once( $dir .'/inc/meta-pages.php' );
		require_once( $dir .'/inc/meta-posts.php' );
		require_once( $dir .'/inc/term-color-css.php' );
		require_once( $dir .'/inc/schema.php' );

		// Include Classes
		require_once( $dir .'/inc/classes/accent.php' );
		require_once( $dir .'/inc/classes/term-colors.php' );
		require_once( $dir .'/inc/classes/customizer/customizer.php' );
		require_once( $dir .'/inc/classes/gallery-metabox/gallery-metabox.php' );

		// WPML/Polilang config
		require_once( $dir .'/inc/translators-config.php' );

	}

	/**
	 * Include custom widgets
	 *
     * @since  1.0.0
     * @access public
	 */
	public static function load_custom_widgets() {

		// Define dir
		$dir = get_template_directory();

		// Apply filters so you can remove custom widgets via a child theme or plugin
		$widgets = apply_filters( 'st_theme_widgets', array(
			'social',
			'authors',
			'facebook-page',
			'recent-posts-thumbnails',
			'mailchimp',
			'about',
			'contact-info',
			'instagram-grid',
			'comments-avatar',
			'video',
			'google-map',
			'popular-posts',
		) );

		// Loop through and load widget files
		foreach ( $widgets as $widget ) {
			$widget_file = $dir .'/inc/classes/widgets/'. $widget .'.php';
			if ( file_exists( $widget_file ) ) {
				require_once( $widget_file );
		   }
		}

	}

	/**
	 * Functions called during each page load, after the theme is initialized
	 * Perform basic setup, registration, and init actions for the theme
	 *
     * @since  1.0.0
     * @access public
	 *
	 * @link   http://codex.wordpress.org/Plugin_API/Action_Reference/after_setup_theme
	 */
	public static function setup() {

		// Define content_width variable
		if ( ! isset( $content_width ) ) {
			$content_width = 745;
		}

		// Register navigation menus
		register_nav_menus (
			array(
				'topbar' => esc_html__( 'Topbar', 'status' ),
				'main'   => esc_html__( 'Main', 'status' ),
				'mobile' => esc_html__( 'Mobile Alternative', 'status' ),
			)
		);

		// Add editor styles
		add_editor_style( 'css/editor-style.css' );
		
		// Localization support
		load_theme_textdomain( 'status', get_template_directory() .'/languages' );
			
		// Add theme support
		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'custom-background' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'custom-header' );

		// Add image sizes
		$get_image_sizes = st_get_image_sizes();
		if ( ! empty( $get_image_sizes ) ) {
			foreach ( $get_image_sizes as $size => $label ) {
				add_image_size(
					'st_'. $size,
					st_get_theme_mod( $size .'_thumb_width', '9999' ),
					st_get_theme_mod( $size .'_thumb_height', '9999' ),
					st_parse_image_crop( st_get_theme_mod( $size .'_thumb_crop', true ) )
				);
			}
		}

		// Add support for page excerpts
		add_post_type_support( 'page', 'excerpt' );

	}

	/**
	 * Define post types for the gallery metabox
	 *
     * @since  1.0.0
     * @access public
	 */
	public static function gallery_metabox_post_types( $post_types ) {
		return array( 'post' );
	}

	/**
	 * Load custom CSS scripts in the front end
	 *
     * @since  1.0.0
     * @access public
     *
     * @link   https://codex.wordpress.org/Function_Reference/wp_enqueue_style
	 */
	public static function theme_css() {

		// Define css directory
		$css_dir_uri = get_template_directory_uri() .'/css/';

		// Define inline style handle
		$style_handle = apply_filters( 'st_style_handle', 'style' );

		// IE8 CSS
		wp_enqueue_style( 'st-ie8', $css_dir_uri .'ie8.css' );
		wp_style_add_data( 'st-ie8', 'conditional', 'lt IE 9' );

		// Font Awesome
		wp_enqueue_style( 'font-awesome', $css_dir_uri .'font-awesome.min.css' );

		// Popups
		wp_enqueue_style( 'magnific-popup', $css_dir_uri .'magnific-popup.css' );

		// Main CSS
		wp_enqueue_style( 'style', get_stylesheet_uri() );

		// Remove Contact Form 7 Styles
		if ( function_exists( 'wpcf7_enqueue_styles') ) {
			wp_dequeue_style( 'contact-form-7' );
		}

		// Advanced styles
		$advanced_styles = self::advanced_styles();
		if ( $advanced_styles ) {
			$advanced_styles = st_minify_css( $advanced_styles );
			wp_add_inline_style( $style_handle, $advanced_styles );
		}

		// Category CSS
		if ( function_exists( 'st_category_inline_css' ) ) {
			$term_styles = st_category_inline_css();
			if ( $term_styles ) {
				$term_styles = st_minify_css( $term_styles );
				wp_add_inline_style( $style_handle, $term_styles );
			}
		}

		// Customizer CSS
		if ( class_exists( 'STATUS_Customizer' ) ) {

			// Customizer loop
			$c_loop = STATUS_Customizer::loop_through_settings();

			// Google fonts
			if ( ! empty( $c_loop['fonts'] ) ) {
				$fonts = $c_loop['fonts'];
				foreach ( $fonts as $font ) {
					$url    = st_get_gfont_url( $font );
					$handle = trim( $font );
					$handle = strtolower( $font );
					$handle = str_replace( ' ', '-', $font );
					wp_enqueue_style( 'st-google-font-'. $handle, $url, false, false, 'all' );
				}
			}

			// Customizer styling CSS
			if ( ! empty( $c_loop['css'] ) ) {
				$c_loop_css = st_minify_css( $c_loop['css'] );
				wp_add_inline_style( $style_handle, $c_loop_css );
			}

		}

		// Accent CSS
		if ( class_exists( 'STATUS_Accent_Class' ) ) {

			$accent_css = STATUS_Accent_Class::generate_css();
			if ( $accent_css ) {
				$accent_css = st_minify_css( $accent_css );
				wp_add_inline_style( $style_handle, $accent_css );
			}

		}

	}

	/**
	 * Load custom JS scripts in the front end
	 *
     * @since  1.0.0
     * @access public
     *
	 * @link   https://codex.wordpress.org/Function_Reference/wp_enqueue_script
	 */
	public static function theme_js() {

		// Define js directory
		$js_dir_uri = get_template_directory_uri() .'/js/';

		// Comment reply
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// HTML5
		wp_enqueue_script( 'html5shiv', $js_dir_uri .'js/html5.js', array(), false, false );
		wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

		// Login/Register page
		if ( is_page_template( 'templates/login.php' ) ) {
			wp_enqueue_script( 'password-strength-meter' );
			wp_add_inline_script( 'password-strength-meter', st_strong_pass_inline_script() );
		}

		// Check if js should be minified
		$minify_js = st_has_minified_scripts();

		// Localize scripts
		$topbar_mm_txt  = st_get_theme_mod( 'topbar_mm_txt' );
		$sitenav_mm_txt = st_get_theme_mod( 'sitenav_mm_txt' );
		$localize  = apply_filters( 'st_localize', array(
			'wpGalleryLightbox'     => true,
			'mobileTopbarMenuLabel' => $topbar_mm_txt ? $topbar_mm_txt : '',
			'mobileSiteMenuLabel'   => $sitenav_mm_txt ? $sitenav_mm_txt : esc_html__( 'Menu', 'status' ),
		) );

		// Output minified js
		if ( $minify_js ) {
			wp_enqueue_script( 'st-js', $js_dir_uri .'theme-min.js', array( 'jquery' ), false, true );
			wp_localize_script( 'st-js', 'stLocalize', $localize );
		}

		// Non-minified js
		else {

			wp_enqueue_script( 'dropdownTouchSupport', $js_dir_uri .'plugins/dropdownTouchSupport.js', array( 'jquery' ), false, true );

			wp_enqueue_script( 'slicknav', $js_dir_uri .'plugins/jquery.slicknav.js', array( 'jquery' ), false, true );

			wp_enqueue_script( 'fitvids', $js_dir_uri .'plugins/jquery.fitvids.js', array( 'jquery' ), '1.1', true );

			wp_enqueue_script( 'magnific-popup', $js_dir_uri .'plugins/jquery.magnific-popup.js', array( 'jquery' ), '1.0.0', true );

			wp_enqueue_script( 'lightslider', $js_dir_uri .'plugins/lightslider.js', array( 'jquery' ), false, true );

			// Theme functions
			wp_enqueue_script( 'st-js', $js_dir_uri .'functions.js', array( 'jquery' ), false, true );
			wp_localize_script( 'st-js', 'stLocalize', $localize );

		}

		// Retina logo
		$retina_logo = self::retina_logo();
		if ( $retina_logo ) {
			wp_add_inline_script( 'st-js', $retina_logo, 'before' );
		}

	}

	/**
	 * Registers the theme sidebars
	 *
     * @since  1.0.0
     * @access public
	 *
	 * @link   http://codex.wordpress.org/Function_Reference/register_sidebar
	 */
	public static function register_sidebars() {

		// Sidebar
		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar - Main', 'status' ),
			'id'            => 'sidebar',
			'before_widget' => '<div class="st-sidebar-widget %2$s st-clr">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );

		// Sidebar
		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar - Pages', 'status' ),
			'id'            => 'sidebar_pages',
			'before_widget' => '<div class="st-sidebar-widget %2$s st-clr">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );

		// Instagram footer
		register_sidebar( array(
			'name'          => esc_html__( 'Instagram Footer', 'status' ),
			'id'            => 'instagram_footer',
			'before_widget' => '<div class="instagram-footer-widget %2$s st-clr">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="widget-title">',
			'after_title'   => '</h5>',
			'description'   => esc_html__( 'Drag the Instagram widget into this area for a full-width instagram grid before your site footer.', 'status' ),
		) );

		// Get footer columns
		$cols = st_get_theme_mod( 'footer_widget_columns', 4 );

		// Footer 1
		if ( $cols >= 1 ) {

			register_sidebar( array(
				'name'          => esc_html__( 'Footer 1', 'status' ),
				'id'            => 'footer-one',
				'before_widget' => '<div class="footer-widget %2$s st-clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<h6 class="widget-title">',
				'after_title'   => '</h6>',
			) );

		}

		// Footer 2
		if ( $cols > 1 ) {

			register_sidebar( array(
				'name'          => esc_html__( 'Footer 2', 'status' ),
				'id'            => 'footer-two',
				'before_widget' => '<div class="footer-widget %2$s st-clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<h6 class="widget-title">',
				'after_title'   => '</h6>',
			) );

		}

		// Footer 3
		if ( $cols > 2 ) {

			register_sidebar( array(
				'name'          => esc_html__( 'Footer 3', 'status' ),
				'id'            => 'footer-three',
				'before_widget' => '<div class="footer-widget %2$s st-clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<h6 class="widget-title">',
				'after_title'   => '</h6>',
			) );

		}

		// Footer 4
		if ( $cols > 3 ) {

			register_sidebar( array(
				'name'          => esc_html__( 'Footer 4', 'status' ),
				'id'            => 'footer-four',
				'before_widget' => '<div class="footer-widget %2$s st-clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<h6 class="widget-title">',
				'after_title'   => '</h6>',
			) );

		}

	}
	
	/**
	 * Adds classes to the body_class function
	 *
     * @since  1.0.0
     * @access public
	 *
	 * @link   http://codex.wordpress.org/Function_Reference/body_class
	 */
	public static function body_classes( $classes ) {

		// Add post layout
		$classes[] = st_get_post_layout();

		// Topbar
		if ( st_get_theme_mod( 'topbar_social_enable', true ) ) {
			$classes[] = 'st-has-topbar-social';
		}

		// Entry style
		if ( $entry_style = st_get_blog_entry_style() ) {
			$classes[] = 'st-entry-style-'. $entry_style;
		}

		// Responsive
		if ( st_is_responsive() ) {
			$classes[] = 'st-responsive';
		}

		// RTL
		if ( is_RTL() || isset( $_GET['rtl'] ) ) {
			$classes[] = 'rtl';
		}
		
		// Return classes
		return $classes;

	}

	/**
	 * Return custom excerpt more string
	 *
     * @since  1.0.0
     * @access public
	 *
	 * @link   http://codex.wordpress.org/Plugin_API/Filter_Reference/excerpt_more
	 */
	public static function excerpt_more( $more ) {
		return $more;
	}

	/**
	 * Alters the default oembed output
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @link   https://developer.wordpress.org/reference/hooks/embed_oembed_html/
	 */
	public static function embed_oembed_html( $html, $url, $attr, $post_id ) {
		return '<div class="st-responsive-embed">' . $html . '</div>';
	}

	/**
	 * Alter the main query
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @link   http://codex.wordpress.org/Plugin_API/Action_Reference/pre_get_posts
	 */
	public static function pre_get_posts( $query ) {

		// Do nothing in admin
		if ( is_admin() ) {
			return;
		}

		// Alter search results
		if ( st_get_theme_mod( 'search_posts_only', true )
			&& $query->is_main_query()
			&& is_search()
		) {
			$post_type_query_var = false;
			if ( ! empty( $_GET[ 'post_type' ] ) ) {
				$post_type_query_var = true;
			}
			if ( ! $post_type_query_var ) {
				$query->set( 'post_type', array( 'post' ) );
			}
		}

		// Alter posts per page
		if ( $query->is_main_query() && ! empty( $_GET['posts_per_page'] ) ) {
			return $query->set( 'posts_per_page', $_GET['posts_per_page'] );
		}

	}

	/**
	 * Adds new "Featured Image" column to the WP dashboard
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @link   http://codex.wordpress.org/Plugin_API/Filter_Reference/manage_posts_columns
	 */
	public static function posts_columns( $defaults ) {
		$defaults['st_post_thumbs'] = esc_html__( 'Featured Image', 'status' );
		return $defaults;
	}

	/**
	 * Display post thumbnails in WP admin
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @link   http://codex.wordpress.org/Plugin_API/Filter_Reference/manage_posts_columns
	 */
	public static function posts_custom_columns( $column_name, $id ) {
		$id = get_the_ID();
		if ( $column_name != 'st_post_thumbs' ) {
			return;
		}
		if ( has_post_thumbnail( $id ) ) {
			$img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'thumbnail', false );
			if( ! empty( $img_src[0] ) ) { ?>
					<img src="<?php echo esc_url( $img_src[0] ); ?>" alt="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" style="max-width:100%;max-height:90px;" />
				<?php
			}
		} else {
			echo '&mdash;';
		}
	}

	/**
	 * Adds js for the retina logo
	 *
	 * @since 1.0.0
	 */
	public static function retina_logo() {
		$logo_url    = esc_url( st_get_theme_mod( 'logo_retina' ) );
		$logo_height = intval( st_get_theme_mod( 'logo_retina_height' ) );
		if ( $logo_url && $logo_height ) {
			return 'jQuery(function($){if (window.devicePixelRatio >= 2) {$(".st-site-logo img").attr("src", "'. esc_url( $logo_url ) .'");$("#st-site-logo img").css("height", "'. intval( $logo_height ) .'");}});';
		}
	}

	/**
	 * Add Font size select to tinymce
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @link   http://codex.wordpress.org/Plugin_API/Filter_Reference/mce_buttons,_mce_buttons_2,_mce_buttons_3,_mce_buttons_4
	 */
	public static function mce_font_size_select( $buttons ) {
		array_unshift( $buttons, 'fontsizeselect' );
		return $buttons;
	}
	
	/**
	 * Customize default font size selections for the tinymce
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @link   http://codex.wordpress.org/Plugin_API/Filter_Reference/mce_buttons,_mce_buttons_2,_mce_buttons_3,_mce_buttons_4
	 */
	public static function fontsize_formats( $initArray ) {
		$initArray['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 18px 21px 24px 28px 32px 36px";
		return $initArray;
	}

	/**
	 * Add Formats Button
	 *
	 * @since  1.0.0
	 * @access public 
	 *
	 * @link   http://codex.wordpress.org/Plugin_API/Filter_Reference/mce_buttons,_mce_buttons_2,_mce_buttons_3,_mce_buttons_4
	 */
	public static function formats_button( $buttons ) {
		array_push( $buttons, 'styleselect' );
		return $buttons;
	}

	/**
	 * Add new formats
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @link   http://codex.wordpress.org/TinyMCE_Custom_Styles
	 */
	public static function formats( $settings ) {
		$new_formats = array(
			array(
				'title'     => esc_html__( 'Highlight', 'status' ),
				'inline'    => 'span',
				'classes'   => 'st-text-highlight'
			),
			array(
				'title' => esc_html__( 'Buttons', 'status' ),
				'items' => array(
					array(
						'title'     => esc_html__( 'Default', 'status' ),
						'selector'  => 'a',
						'classes'   => 'st-theme-button'
					),
					array(
						'title'     => esc_html__( 'Red', 'status' ),
						'selector'  => 'a',
						'classes'   => 'st-theme-button red'
					),
					array(
						'title'     => esc_html__( 'Green', 'status' ),
						'selector'  => 'a',
						'classes'   => 'st-theme-button green'
					),
					array(
						'title'     => esc_html__( 'Blue', 'status' ),
						'selector'  => 'a',
						'classes'   => 'st-theme-button blue'
					),
					array(
						'title'     => esc_html__( 'Orange', 'status' ),
						'selector'  => 'a',
						'classes'   => 'st-theme-button orange'
					),
					array(
						'title'     => esc_html__( 'Black', 'status' ),
						'selector'  => 'a',
						'classes'   => 'st-theme-button black'
					),
					array(
						'title'     => esc_html__( 'White', 'status' ),
						'selector'  => 'a',
						'classes'   => 'st-theme-button white'
					),
					array(
						'title'     => esc_html__( 'Clean', 'status' ),
						'selector'  => 'a',
						'classes'   => 'st-theme-button clean'
					),
				),
			),
			array(
				'title' => esc_html__( 'Notices', 'status' ),
				'items' => array(
					array(
						'title'     => esc_html__( 'Default', 'status' ),
						'block'     => 'div',
						'classes'   => 'st-notice'
					),
					array(
						'title'     => esc_html__( 'Info', 'status' ),
						'block'     => 'div',
						'classes'   => 'st-notice st-info'
					),
					array(
						'title'     => esc_html__( 'Warning', 'status' ),
						'block'     => 'div',
						'classes'   => 'st-notice st-warning'
					),
					array(
						'title'     => esc_html__( 'Success', 'status' ),
						'block'     => 'div',
						'classes'   => 'st-notice st-success'
					),
				),
			),
		);
		$settings['style_formats'] = json_encode( $new_formats );
		return $settings;
	}

	/**
	 * Remove gallery styles
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @link   https://developer.wordpress.org/reference/hooks/use_default_gallery_style/
	 */
	public static function remove_gallery_styles() {
		return false;
	}

	/**
	 * Add new user fields
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @link   http://codex.wordpress.org/Plugin_API/Filter_Reference/user_contactmethods
	 */
	public static function user_fields( $contactmethods ) {

		// Add Twitter
		if ( ! isset( $contactmethods['st_twitter'] ) ) {
			$contactmethods['wpex_twitter'] = 'Status - Twitter';
		}

		// Add Facebook
		if ( ! isset( $contactmethods['st_facebook'] ) ) {
			$contactmethods['wpex_facebook'] = 'Status - Facebook';
		}

		// Add GoglePlus
		if ( ! isset( $contactmethods['st_googleplus'] ) ) {
			$contactmethods['wpex_googleplus'] = 'Status - Google+';
		}

		// Add LinkedIn
		if ( ! isset( $contactmethods['st_linkedin'] ) ) {
			$contactmethods['wpex_linkedin'] = 'Status - LinkedIn';
		}

		// Add Pinterest
		if ( ! isset( $contactmethods['st_pinterest'] ) ) {
			$contactmethods['wpex_pinterest'] = 'Status - Pinterest';
		}

		// Add Pinterest
		if ( ! isset( $contactmethods['st_instagram'] ) ) {
			$contactmethods['wpex_instagram'] = 'Status - Instagram';
		}

		// Return contactmethods
		return $contactmethods;

	}

	/**
	 * Adds extra CSS to the head based on customizer settings
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 */
	public static function advanced_styles() {

		// Add css
		$css = '';

		// Container width
		$width = st_get_theme_mod( 'layout_container_width' );
		if ( $width && strpos( $width, '%' ) == false ) {
			$width = intval( $width );
			$width = $width ? $width .'px' : null;
		}
		if ( $width ) {
			$css .= '.st-container { width: '. $width .'; }.st-content-area, .st-sidebar { max-width: none; }';
		}

		// Content width
		$width = self::px_pct( st_get_theme_mod( 'layout_content_width' ) );
		if ( $width ) {
			$css .= '.st-content-area { width: '. $width .'; max-width: none; }';
		}

		// Sidebar width
		$width = self::px_pct( st_get_theme_mod( 'layout_sidebar_width' ) );
		if ( $width ) {
			$css .= '.st-sidebar { width: '. $width .'; max-width: none; }';
		}

		// Container Max Width
		if ( st_is_responsive() ) {

			$width = intval( st_get_theme_mod( 'layout_container_max_width' ) );

			if ( $width && '85' !== $width ) {
				$css .= '.st-container { max-width: '. $width .'%; }';
			}

		}

		// Sidebar heading tag
		$mod = st_get_theme_mod( 'sidebar_heading_bg' );
		if ( $mod ) {
			$css .= '.st-sidebar-widget .widget-title:after { border-top-color: '. $mod .'; }';
		}

		// Minitfy CSS
		$css = st_minify_css( $css );

		// Return css
		return $css;

	}

	/**
     * Returns a Pixel or Percent
     *
	 * @since  1.0.0
	 * @access private
	 *
     */
    private static function px_pct( $data ) {
        if ( 'none' == $data || '0px' == $data ) {
            return '0';
        } elseif ( strpos( $data, '%' ) ) {
            return $data;
        } elseif ( strpos( $data , '&#37;' ) ) {
        	return $data;
        } elseif ( $data = floatval( $data ) ) {
            return $data .'px';
        }
    }

	/**
	 * Adds meta generator for 
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 */
	public static function theme_meta_generator() {
		$theme = wp_get_theme();
		echo '<meta name="generator" content="Built With The Status WordPress Theme '. $theme->get( 'Version' ) .' by WPExplorer" />';
		echo "\r\n";
	}

	/**
	 * Adds alternative mobile menu
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 */
	public static function mobile_alternative() {
		if ( has_nav_menu( 'mobile' ) ) {
			echo wp_nav_menu( array(
				'theme_location'  => 'mobile',
				'fallback_cb'     => false,
				'container_class' => 'st-mobile-menu-alt',
				'menu_class'      => 'st-dropdown-menu',
				'walker'          => new STATUS_Dropdown_Walker_Nav_Menu,
			) );
		}
	}

	/**
	 * Adds extra items to the end of the main menu
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @link   http://codex.wordpress.org/Function_Reference/wp_get_nav_menu_items
	 */
	public static function menu_add_items( $items, $args ) {
		return $items;
	}

	/**
	 * Move Comment form field back to bottom which was altered in WP 4.4
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public static function move_comment_form_fields( $fields ) {
		$comment_field = $fields['comment'];
		unset( $fields['comment'] );
		$fields['comment'] = $comment_field;
		return $fields;
	}

	/**
	 * Redirect to a random post
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public static function random_redirect() {
		if ( ! is_admin()
			&& isset( $_GET['st_random'] )
			&& '1' == $_GET['st_random']
		) {
			$exclude = ! empty( $_GET['exclude'] ) ? intval( $_GET['exclude'] ) : '';
			$posts = get_posts('post_type=post&orderby=rand&numberposts=1&exclude='. $exclude );
			if ( ! empty( $posts[0] ) ) {
				$post_id = $posts[0]->ID;
				$link = esc_url( get_permalink( $post_id ) );
			}
			wp_redirect( $link, 307 );
			exit;
		}
	}

	/**
	 * Add schema markup to the authors post link
	 *
	 * @since 1.0.0
	 */
	public static function the_author_posts_link( $link ) {

		// Add schema markup
		$schema = st_get_schema_markup( 'author_link' );
		if ( $schema ) {
			$link = str_replace( 'rel="author"', 'rel="author"'. $schema, $link );
		}

		// Return link
		return $link;

	}

	/**
	 * Fix some validation errors with Yoast breadcrumbs
	 *
	 * @since 1.0.0
	 */
	public static function yoast_breadcrumbs_fixes( $output ) {

		$output = preg_replace( array( '#<span xmlns:v="http://rdf.data-vocabulary.org/\#">#', '#<span typeof="v:Breadcrumb"><a href="(.*?)" .*?'.'>(.*?)</a></span>#', '#<span typeof="v:Breadcrumb">(.*?)</span>#','# property=".*?"#','#</span>$#'), array('','<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="$1" itemprop="url"><span itemprop="title">$2</span></a></span>', '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">$1</span></span>', '', '' ), $output );

		return $output;

	}

	/**
	 * Disable requests to wp.org repository for this theme.
	 *
	 * @since 1.0.0
	 */
	public static function disable_wporg_request( $r, $url ) {

		// If it's not a theme update request, bail.
		if ( 0 !== strpos( $url, 'https://api.wordpress.org/themes/update-check/1.1/' ) ) {
			return $r;
		}

		// Decode the JSON response
		$themes = json_decode( $r['body']['themes'] );

		// Remove the active parent and child themes from the check
		$parent = get_option( 'template' );
		$child  = get_option( 'stylesheet' );
		unset( $themes->themes->$parent );
		unset( $themes->themes->$child );

		// Encode the updated JSON response
		$r['body']['themes'] = json_encode( $themes );

		return $r;

	}

}
new Status_Theme;