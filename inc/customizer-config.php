<?php
/**
 * Defines all settings for the customizer class
 *
 * @package Status WordPress Theme
 * @author Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link http://www.stplorer.com
 * @since 1.0.0
 */

if ( ! function_exists( 'st_customizer_config' ) ) {

	function st_customizer_config( $panels ) {

		/*-----------------------------------------------------------------------------------*/
		/* - Useful vars
		/*-----------------------------------------------------------------------------------*/

		// Columns
		$columns = array(
			'' => esc_html__( 'Default', 'status' ),
			1 => 1,
			2 => 2,
			3 => 3,
			4 => 4,
		);

		// Accents
		$accents = array(
			'' => esc_html__( 'Default', 'status' ),
			'#27ae60' => esc_html__( 'Green', 'status' ),
			'#e67e22' => esc_html__( 'Orange', 'status' ),
			'#2980b9' => esc_html__( 'Blue', 'status' ),
			'#2c3e50' => esc_html__( 'Navy', 'status' ),
			'#c0392b' => esc_html__( 'Red', 'status' ),
			'#8e44ad' => esc_html__( 'Purple', 'status' ),
			'#16a085' => esc_html__( 'Teal', 'status' ),
			'#1abc9c' => esc_html__( 'Turquoise', 'status' ),
			'#7f8c8d' => esc_html__( 'Gray', 'status' ),
		);

		// Layouts
		$layouts = array(
			'' => esc_html__( 'Default', 'status' ),
			'right-sidebar' => esc_html__( 'Right Sidebar', 'status' ),
			'left-sidebar' => esc_html__( 'Left Sidebar', 'status' ),
			'full-width' => esc_html__( 'No Sidebar', 'status' ),
		);
		
		// Font Weights
		$font_weights = array(
			'' => esc_html__( 'Default', 'status' ),
			'100' => '100',
			'200' => '200',
			'300' => '300',
			'400' => '400',
			'500' => '500',
			'600' => '600',
			'700' => '700',
			'800' => '800',
			'900' => '900',
		);

		// Categories
		$categories = array();
		$get_categories = get_categories( array(
			'orderby' => 'name'
		) );
		if ( ! empty( $get_categories ) ) {
			foreach ( $get_categories as $cat ) {
				$categories[$cat->term_id] = $cat->name;
			}
		}

		/*-----------------------------------------------------------------------------------*/
		/* - General Panel
		/*-----------------------------------------------------------------------------------*/
		$panels['general'] = array(
			'title' => esc_html__( 'General Theme Settings', 'status' ),
			'sections' => array()
		);

		// Meta
		$panels['general']['sections']['site-meta'] = array(
			'id' => 'st_meta_prefix',
			'title' => esc_html__( 'Meta Settings', 'status' ),
			'settings' => array(
				array(
					'id' => 'meta_prefix',
					'control' => array(
						'label' => esc_html__( 'Meta Prefix', 'status' ),
						'type' => 'text',
						'desc' => esc_html__( 'Enter a prefix for your old meta options if you are switching from another WPExplorer theme and wish to keep your pre-defined videos, audio, ratings, etc. An example value may be wpex_', 'status' ),
					),
				),
			),
		);

		// Site Widths
		$panels['general']['sections']['site-widths'] = array(
			'id' => 'st_site_widths',
			'title' => esc_html__( 'Site Widths', 'status' ),
			'settings' => array(
				array(
					'id' => 'layout_container_width',
					'control' => array(
						'label' => esc_html__( 'Container Width', 'status' ),
						'type' => 'text',
						'desc' => esc_html__( 'Default:', 'status' ) .' 1080px',
					),
				),
				array(
					'id' => 'layout_container_max_width',
					'control' => array(
						'label' => esc_html__( 'Container Max Width Percent', 'status' ),
						'type' => 'text',
						'active_callback' => 'st_is_responsive',
						'desc' => esc_html__( 'Default:', 'status' ) .' 85%',
					),
				),
				array(
					'id' => 'layout_content_width',
					'control' => array(
						'label' => esc_html__( 'Content Area Width', 'status' ),
						'type' => 'text',
						'desc' => esc_html__( 'Default:', 'status' ) .' 69%',
					),
				),
				array(
					'id' => 'layout_sidebar_width',
					'control' => array(
						'label' => esc_html__( 'Sidebar Width', 'status' ),
						'type' => 'text',
						'desc' => esc_html__( 'Default:', 'status' ) .' 28%',
					),
				),
			),
		);

		// Layouts
		$panels['general']['sections']['layouts'] = array(
			'id' => 'st_layouts',
			'title' => esc_html__( 'Layouts', 'status' ),
			'settings' => array(
				array(
					'id' => 'home_layout',
					'control' => array(
						'label' => esc_html__( 'Homepage Layout', 'status' ),
						'type' => 'select',
						'choices' => $layouts,
					),
				),
				array(
					'id' => 'archives_layout',
					'control' => array(
						'label' => esc_html__( 'Archives Layout', 'status' ),
						'type' => 'select',
						'choices' => $layouts,
						'desc' => esc_html__( 'Categories, tags, author...etc', 'status' ),
					),
				),
				array(
					'id' => 'search_layout',
					'transport' => 'postMessage',
					'control' => array(
						'label' => esc_html__( 'Search Layout', 'status' ),
						'type' => 'select',
						'choices' => $layouts,
					),
				),
				array(
					'id' => 'post_layout',
					'control' => array(
						'label' => esc_html__( 'Post Layout', 'status' ),
						'type' => 'select',
						'choices' => $layouts,
					),
				),
				array(
					'id' => 'page_layout',
					'control' => array(
						'label' => esc_html__( 'Page Layout', 'status' ),
						'type' => 'select',
						'choices' => $layouts,
					),
				),
			),
		);

		// Responsive
		$panels['general']['sections']['responsive'] = array(
			'id' => 'st_responsive',
			'title' => esc_html__( 'Responsiveness', 'status' ),
			'settings' => array(
				array(
					'id' => 'responsive',
					'default' => true,
					'control' => array(
						'label' => esc_html__( 'Enable', 'status' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'sitenav_mm_txt',
					'control' => array(
						'label' => esc_html__( 'Main Menu Mobile Toggle Text', 'status' ),
						'type' => 'text',
						'active_callback' => 'st_is_responsive',
					),
				),
			),
		);

		// Header Section
		$panels['general']['sections']['general'] = array(
			'id' => 'st_general',
			'title' => esc_html__( 'Header', 'status' ),
			'settings' => array(
				array(
					'id' => 'site_description',
					'default' => true,
					'control' => array(
						'label' => esc_html__( 'Display description?', 'status' ),
						'type' => 'checkbox'
					),
				),
				array(
					'id' => 'logo_top_padding',
					'control' => array(
						'label' => esc_html__( 'Logo Top Padding', 'status' ),
						'type' => 'text',
					),
					'inline_css' => array(
						'target' => '.st-site-branding',
						'alter' => 'padding-top',
					),
				),
				array(
					'id' => 'logo',
					'control' => array(
						'label' => esc_html__( 'Custom Logo', 'status' ),
						'type' => 'upload',
					),
				),
				array(
					'id' => 'logo_retina',
					'control' => array(
						'label' => esc_html__( 'Custom Retina Logo', 'status' ),
						'type' => 'upload',
					),
				),
				array(
					'id' => 'logo_retina_height',
					'control' => array(
						'label' => esc_html__( 'Standard Logo Height', 'status' ),
						'desc' => esc_html__( 'Enter the standard height for your logo. Used to set your retina logo to the correct dimensions', 'status' ),
					),
				),
			),
		);

		// Topbar Social
		$social_options = st_topbar_social_options_array();
		
		if ( $social_options ) {

			$panels['general']['sections']['topbar'] = array(
				'id' => 'st_social_header',
				'title' => esc_html__( 'Topbar', 'status' ),
				'desc' => esc_html__( 'Enter the full URL to your social media profile.', 'status' ),
				'settings' => array(
					array(
						'id' => 'topbar_enable',
						'default' => true,
						'control' => array(
						'label' => esc_html__( 'Enable Topbar', 'status' ),
						'type' => 'checkbox',
						),
					),
				),
			);

			$panels['general']['sections']['topbar']['settings']['topbar_social_enable'] = array(
				'id' => 'topbar_social_enable',
				'default' => true,
				'control' => array(
				'label' => esc_html__( 'Enable Social', 'status' ),
				'type' => 'checkbox',
				),
			);

			$panels['general']['sections']['topbar']['settings']['topbar_social_target_blank'] = array(
				'id' => 'topbar_social_target_blank',
				'transport' => 'postMessage',
				'control' => array(
					'label' => esc_html__( 'Open Social Links In New Tab?', 'status' ),
					'type' => 'checkbox',
					'active_callback' => 'st_active_callback_topbar_social',
				),
			);

			foreach ( $social_options as $key => $val ) {

				$panels['general']['sections']['topbar']['settings']['topbar_social_'. $key] = array(
					'id' => 'topbar_social_'. $key,
					'control' => array(
						'label' => $val['label'] .' - '. esc_html__( 'URL', 'status' ),
						'active_callback' => 'st_active_callback_topbar_social'
					),
				);


			}

		}

		// Entries
		$panels['general']['sections']['trending_breads_bar'] = array(
			'id' => 'st_trending_breads_bar',
			'title' => esc_html__( 'Trending/Breadcrumbs Bar', 'status' ),
			'settings' => array(
				array(
					'id' => 'trending_bar',
					'default' => true,
					'control' => array(
						'label' => esc_html__( 'Enable', 'status' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'trending_bar_txt',
					'control' => array(
						'label' => esc_html__( 'Label', 'status' ),
						'type' => 'textfield',
					),
				),
				array(
					'id' => 'breadcrumbs',
					'default' => true,
					'control' => array(
						'label' => esc_html__( 'Breadcrumbs', 'status' ),
						'type' => 'checkbox',
						'desc' => esc_html__( 'When enabled it will override the trending bar everywhere except the homepage. You must have the WordPress SEO by Yoast plugin active in order to display breadcrumbs.', 'status' ),
					),
				),
				array(
					'id' => 'random_post_link',
					'default' => true,
					'control' => array(
						'label' => esc_html__( 'Enable Random Post Link', 'status' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'random_post_link_txt',
					'control' => array(
						'label' => esc_html__( 'Random Post Link text', 'status' ),
						'type' => 'textfield',
					),
				),
			)
		);

		// Entries
		$panels['general']['sections']['entries'] = array(
			'id' => 'st_entries',
			'title' => esc_html__( 'Entries', 'status' ),
			'settings' => array(
				array(
					'id' => 'archive_featured_entry',
					'default' => true,
					'control' => array(
						'label' => esc_html__( 'Display First Post Large?', 'status' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'pagination_style',
					'default' => 'numbered',
					'control' => array(
						'label' => esc_html__( 'Pagination Style', 'status' ),
						'type' => 'select',
						'choices' => array(
							'numbered' => esc_html__( 'Numbered', 'status' ),
							'next_prev' => esc_html__( 'Next/Prev Links', 'status' ),
						),
					),
				),
				array(
					'id' => 'entry_style',
					'default' => 'grid',
					'control' => array(
						'label' => esc_html__( 'Entry Style', 'status' ),
						'type' => 'select',
						'choices' => array(
							'grid' => esc_html__( 'Grid', 'status' ),
							'full' => esc_html__( 'Full Thumbnail', 'status' ),
							'left_right' => esc_html__( 'Left Thumbnail & Right Content', 'status' ),
						),
					),
				),
				array(
					'id' => 'entry_columns',
					'default' => '2',
					'control' => array(
						'label' => esc_html__( 'Grid Columns', 'status' ),
						'type' => 'select',
						'choices' => array(
							'1' => '1',
							'2' => '2',
							'3' => '3',
							'4' => '4',
						),
						'active_callback' => 'st_active_callback_has_grid',
					),
				),
				array(
					'id' => 'entry_content_display',
					'default' => 'excerpt',
					'control' => array(
						'label' => esc_html__( 'Entry Displays?', 'status' ),
						'type' => 'select',
						'choices' => array(
							'excerpt' => esc_html__( 'Custom Excerpt', 'status' ),
							'content' => esc_html__( 'Full Content', 'status' ),
						),
					),
				),
				array(
					'id' => 'entry_excerpt_length',
					'default' => 20,
					'control' => array(
						'label' => esc_html__( 'Entry Excerpt Length', 'status' ),
						'type' => 'text',
						'desc' => esc_html__( 'How many words to display per excerpt', 'status' ),
						'active_callback' => 'st_has_custom_excerpt'
					),
				),
				array(
					'id' => 'entry_thumbnail',
					'default' => true,
					'control' => array(
						'label' => esc_html__( 'Entry Thumbnail', 'status' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'entry_embeds',
					'control' => array(
						'label' => esc_html__( 'Entry Embeds', 'status' ),
						'type' => 'checkbox',
						'desc' => esc_html__( 'Display\'s your video/audio embed on the homepage and archives instead of the featured image.', 'status' ),
					),
				),
				array(
					'id' => 'entry_category',
					'default' => true,
					'control' => array(
						'label' => esc_html__( 'Entry Category Tag', 'status' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'entry_category_first_only',
					'default' => true,
					'control' => array(
						'label' => esc_html__( 'Display First Category Only', 'status' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'entry_meta',
					'default' => true,
					'control' => array(
						'label' => esc_html__( 'Entry Meta', 'status' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'entry_date',
					'default' => true,
					'control' => array(
						'label' => esc_html__( 'Entry Date', 'status' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'entry_readmore',
					'default' => false,
					'control' => array(
						'label' => esc_html__( 'Entry Readmore', 'status' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'entry_readmore_text',
					'control' => array(
						'label' => esc_html__( 'Entry Readmore Text', 'status' ),
						'type' => 'text',
						'active_callback' => 'st_customizer_has_entry_readmore',
					),
				),
			),
		);

		// Posts
		$panels['general']['sections']['posts'] = array(
			'id' => 'st_posts',
			'title' => esc_html__( 'Posts', 'status' ),
			'settings' => array(
				array(
					'id' => 'post_thumbnail',
					'default' => true,
					'control' => array(
						'label' => esc_html__( 'Post Thumbnail', 'status' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'post_category',
					'default' => true,
					'control' => array(
						'label' => esc_html__( 'Post Category Tag', 'status' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'post_category_first_only',
					'default' => true,
					'control' => array(
						'label' => esc_html__( 'Display First Category Only', 'status' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'post_meta',
					'default' => true,
					'control' => array(
						'label' => esc_html__( 'Post Meta', 'status' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'post_meta_date',
					'default' => true,
					'control' => array(
						'label' => esc_html__( 'Post Date', 'status' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'post_tags',
					'default' => true,
					'control' => array(
						'label' => esc_html__( 'Post Tags', 'status' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'social_share',
					'default' => true,
					'control' => array(
						'label' => esc_html__( 'Post Social Share', 'status' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'post_author_info',
					'default' => true,
					'control' => array(
						'label' => esc_html__( 'Post Author Box', 'status' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'post_next_prev',
					'default' => true,
					'control' => array(
						'label' => esc_html__( 'Post Next/Previous', 'status' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'post_related',
					'default' => true,
					'control' => array(
						'label' => esc_html__( 'Post Related', 'status' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'post_related_displays',
					'default' => 'related_tags',
					'control' => array(
						'label' => esc_html__( 'Relate Posts by', 'status' ),
						'type' => 'select',
						'choices' => array(
							'related_tags' => esc_html__( 'Tags', 'status' ),
							'related_category' => esc_html__( 'Category', 'status' ),
							'random' => esc_html__( 'Random', 'status' ),
						),
						'active_callback' => 'st_customizer_has_related_posts',
					),
				),
				array(
					'id' => 'post_related_heading',
					'control' => array(
						'label' => esc_html__( 'Post Related: Heading', 'status' ),
						'type' => 'text',
						'active_callback' => 'st_customizer_has_related_posts',
					),
				),
				array(
					'id' => 'post_related_count',
					'default' => '3',
					'control' => array(
						'label' => esc_html__( 'Post Related: Count', 'status' ),
						'type' => 'number',
						'active_callback' => 'st_customizer_has_related_posts',
					),
				),
			),
		);

		// Footer
		$panels['general']['sections']['footer'] = array(
			'id' => 'st_footer',
			'title' => esc_html__( 'Footer', 'status' ),
			'settings' => array(
				array(
					'id' => 'footer_widget_columns',
					'default' => 4,
					'control' => array(
						'label' => esc_html__( 'Footer Widgets Columns', 'status' ),
						'type' => 'select',
						'choices' => array(
							'disable' => esc_html__( 'None - Disable', 'status' ),
							1 => 1,
							2 => 2,
							3 => 3,
							4 => 4,
						)
					),
				),
				array(
					'id' => 'footer_bottom',
					'default' => true,
					'control' => array(
						'label' => esc_html__( 'Enable Footer Bottom Area', 'status' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'footer_copyright',
					'default' => '<a href="http://www.wordpress.org" title="WordPress" target="_blank">WordPress</a> Theme Designed &amp; Developed by <a href="http://www.stplorer.com/" target="_blank" title="WPExplorer">WPExplorer</a>',
					'control' => array(
						'label' => esc_html__( 'Footer Copyright', 'status' ),
						'type' => 'textarea',
					),
				),
			),
		);

		// Advertisement
		$panels['general']['sections']['ads'] = array(
			'id' => 'st_ads',
			'title' => esc_html__( 'Advertisements', 'status' ),
			'settings' => array(
				array(
					'id' => 'ad_header',
					'default' => '<a href="#" title="WPExplorer"><img src="'. get_template_directory_uri() .'/images/banner-white.png" alt="'. esc_html__( 'Banner', 'status' ) .'" /></a>',
					'control' => array(
						'label' => esc_html__( 'Header', 'status' ),
						'type' => 'textarea',
					),
				),
				array(
					'id' => 'ad_homepage_top',
					'default' => '<a href="#" title="WPExplorer"><img src="'. get_template_directory_uri() .'/images/medium-banner-1.png" alt="'. esc_html__( 'Banner', 'status' ) .'" /></a>',
					'control' => array(
						'label' => esc_html__( 'Homepage: Top', 'status' ),
						'type' => 'textarea',
					),
				),
				array(
					'id' => 'ad_homepage_bottom',
					'default' => '<a href="#" title="WPExplorer"><img src="'. get_template_directory_uri() .'/images/medium-banner-2.png" alt="'. esc_html__( 'Banner', 'status' ) .'" /></a>',
					'control' => array(
						'label' => esc_html__( 'Homepage: Bottom', 'status' ),
						'type' => 'textarea',
					),
				),
				array(
					'id' => 'ad_archives_top',
					'default' => '<a href="#" title="WPExplorer"><img src="'. get_template_directory_uri() .'/images/medium-banner-1.png" alt="'. esc_html__( 'Banner', 'status' ) .'" /></a>',
					'control' => array(
						'label' => esc_html__( 'Archives: Top', 'status' ),
						'type' => 'textarea',
					),
				),
				array(
					'id' => 'ad_archives_bottom',
					'default' => '<a href="#" title="WPExplorer"><img src="'. get_template_directory_uri() .'/images/medium-banner-2.png" alt="'. esc_html__( 'Banner', 'status' ) .'" /></a>',
					'control' => array(
						'label' => esc_html__( 'Archives: Bottom', 'status' ),
						'type' => 'textarea',
					),
				),
				array(
					'id' => 'ad_single_top',
					'default' => '<a href="#" title="WPExplorer"><img src="'. get_template_directory_uri() .'/images/medium-banner-1.png" alt="'. esc_html__( 'Banner', 'status' ) .'" /></a>',
					'control' => array(
						'label' => esc_html__( 'Post: Top', 'status' ),
						'type' => 'textarea',
					),
				),
				array(
					'id' => 'ad_single_bottom',
					'default' => '<a href="#" title="WPExplorer"><img src="'. get_template_directory_uri() .'/images/medium-banner-2.png" alt="'. esc_html__( 'Banner', 'status' ) .'" /></a>',
					'control' => array(
						'label' => esc_html__( 'Post: Bottom', 'status' ),
						'type' => 'textarea',
					),
				),
				array(
					'id' => 'ad_footer_bottom',
					'default' => '<a href="#" title="WPExplorer"><img src="'. get_template_directory_uri() .'/images/banner-white.png" alt="'. esc_html__( 'Banner', 'status' ) .'" /></a>',
					'control' => array(
						'label' => esc_html__( 'Footer', 'status' ),
						'type' => 'textarea',
					),
				),
			),
		);

		// Discussion
		$panels['general']['sections']['discussion'] = array(
			'id' => 'st_site_discussion',
			'title' => esc_html__( 'Discussion', 'status' ),
			'settings' => array(
				array(
					'id' => 'comments_on_pages',
					'default' => true,
					'control' => array(
						'label' => esc_html__( 'Comments For Pages', 'status' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'comments_on_posts',
					'default' => true,
					'control' => array(
						'label' => esc_html__( 'Comments For Posts', 'status' ),
						'type' => 'checkbox',
					),
				),
			)
		);

		// Search
		$panels['general']['sections']['search'] = array(
			'id' => 'st_search',
			'title' => esc_html__( 'Search Results', 'status' ),
			'settings' => array(
				array(
					'id' => 'search_posts_only',
					'default' => true,
					'control' => array(
						'label' => esc_html__( 'Search posts only.', 'status' ),
						'type' => 'checkbox',
					),
				),
			)
		);

		// Search
		$panels['general']['sections']['authors_template'] = array(
			'id' => 'st_authors_template',
			'title' => esc_html__( 'Authors Template', 'status' ),
			'settings' => array(
				array(
					'id' => 'authors_template_join_link',
					'control' => array(
						'label' => esc_html__( 'Join link.', 'status' ),
						'desc' => esc_html__( 'Select a page for your authors template join link.', 'status' ),
						'type' => 'dropdown-pages',
					),
				),
				array(
					'id' => 'authors_template_join_link_txt',
					'control' => array(
						'label' => esc_html__( 'Join link text.', 'status' ),
						'type' => 'text',
					),
				),
			)
		);

		/*-----------------------------------------------------------------------------------*/
		/* - Typography
		/*-----------------------------------------------------------------------------------*/
		$panels['typography'] = array(
			'title' => esc_html__( 'Typography', 'status' ),
			'description' => esc_html__( 'It is highly recommended that you do NOT use more then a couple custom Google fonts on the site because it could greatly slow things down.', 'status' ),
			'sections' => array(

				// Body Typography
				array(
					'id' => 'body',
					'title' => esc_html__( 'Body', 'status' ),
					'settings' => array(
						array(
							'id' => 'body_font_family',
							'default' => 'Open Sans',
							'control' => array(
								'label' => esc_html__( 'Font Family', 'status' ),
								'type' => 'google_font',
							),
							'inline_css' => array(
								'target' => 'body',
								'alter' => 'font-family',
							),
						),
						array(
							'id' => 'body_font_weight',
							'control' => array(
								'label' => esc_html__( 'Font Weight', 'status' ),
								'type' => 'select',
								'choices' => $font_weights,
							),
							'inline_css' => array(
								'target' => 'body',
								'alter' => 'font-weight',
							),
						),
						array(
							'id' => 'body_font_size',
							'control' => array(
								'label' => esc_html__( 'Font Size', 'status' ),
							),
							'inline_css' => array(
								'target' => 'body',
								'alter' => 'font-size',
								'sanitize' => 'px',
							),
						),
						array(
							'id' => 'body_letter_spacing',
							'control' => array(
								'label' => esc_html__( 'Letter Spacing', 'status' ),
							),
							'inline_css' => array(
								'target' => 'body',
								'alter' => 'letter-spacing',
								'sanitize' => 'px',
							),
						),
					),
				),

				// Topbar Menu Typography
				array(
					'id' => 'st_topbar_typography',
					'title' => esc_html__( 'Topbar Menu', 'status' ),
					'settings' => array(
						array(
							'id' => 'topbar_font_family',
							'control' => array(
								'label' => esc_html__( 'Font Family', 'status' ),
								'type' => 'google_font',
							),
							'inline_css' => array(
								'target' => '.st-topbar-nav',
								'alter' => 'font-family',
							),
						),
						array(
							'id' => 'topbar_font_weight',
							'control' => array(
								'label' => esc_html__( 'Font Weight', 'status' ),
								'type' => 'select',
								'choices' => $font_weights,
							),
							'inline_css' => array(
								'target' => '.st-topbar-nav .st-dropdown-menu a',
								'alter' => 'font-weight',
							),
						),
						array(
							'id' => 'topbar_font_size',
							'control' => array(
								'label' => esc_html__( 'Font Size', 'status' ),
							),
							'inline_css' => array(
								'target' => '.st-topbar-nav .st-dropdown-menu a',
								'alter' => 'font-size',
								'sanitize' => 'px',
							),
						),
						array(
							'id' => 'topbar_letter_spacing',
							'control' => array(
								'label' => esc_html__( 'Letter Spacing', 'status' ),
							),
							'inline_css' => array(
								'target' => '.st-topbar-nav .st-dropdown-menu a',
								'alter' => 'letter-spacing',
								'sanitize' => 'px',
							),
						),
					),
				),

				// Logo Typography
				array(
					'id' => 'st_logo_typography',
					'title' => esc_html__( 'Logo', 'status' ),
					'settings' => array(
						array(
							'id' => 'logo_font_family',
							'control' => array(
								'label' => esc_html__( 'Font Family', 'status' ),
								'type' => 'google_font',
							),
							'inline_css' => array(
								'target' => '.st-site-logo',
								'alter' => 'font-family',
							),
						),
						array(
							'id' => 'logo_font_weight',
							'control' => array(
								'label' => esc_html__( 'Font Weight', 'status' ),
								'type' => 'select',
								'choices' => $font_weights,
							),
							'inline_css' => array(
								'target' => '.st-site-logo .site-text-logo',
								'alter' => 'font-weight',
							),
						),
						array(
							'id' => 'logo_size',
							'control' => array(
								'label' => esc_html__( 'Font Size', 'status' ),
							),
							'inline_css' => array(
								'target' => '.st-site-logo .site-text-logo',
								'alter' => 'font-size',
								'sanitize' => 'px',
							),
						),
						array(
							'id' => 'logo_letter_spacing',
							'control' => array(
								'label' => esc_html__( 'Letter Spacing', 'status' ),
							),
							'inline_css' => array(
								'target' => '.st-site-logo .site-text-logo',
								'alter' => 'letter-spacing',
								'sanitize' => 'px',
							),
						),
					),
				),

				// Menu Typography
				array(
					'id' => 'st_menu_typography',
					'title' => esc_html__( 'Menu', 'status' ),
					'settings' => array(
						array(
							'id' => 'menu_font_family',
							'control' => array(
								'label' => esc_html__( 'Font Family', 'status' ),
								'type' => 'google_font',
							),
							'inline_css' => array(
								'target' => '.st-site-nav,.st-mobile-nav',
								'alter' => 'font-family',
							),
						),
						array(
							'id' => 'menu_font_weight',
							'control' => array(
								'label' => esc_html__( 'Font Weight', 'status' ),
								'type' => 'select',
								'choices' => $font_weights,
							),
							'inline_css' => array(
								'target' => '.st-site-nav .st-dropdown-menu a',
								'alter' => 'font-weight',
							),
						),
						array(
							'id' => 'menu_font_size',
							'control' => array(
								'label' => esc_html__( 'Font Size', 'status' ),
							),
							'inline_css' => array(
								'target' => '.st-site-nav .st-dropdown-menu a',
								'alter' => 'font-size',
								'sanitize' => 'px',
							),
						),
						array(
							'id' => 'menu_letter_spacing',
							'control' => array(
								'label' => esc_html__( 'Letter Spacing', 'status' ),
							),
							'inline_css' => array(
								'target' => '.st-site-nav .st-dropdown-menu a',
								'alter' => 'letter-spacing',
								'sanitize' => 'px',
							),
						),
					),
				),

				// Headings Typography
				array(
					'id' => 'st_headings_typography',
					'title' => esc_html__( 'Headings', 'status' ),
					'desc' => 'h1,h2,h3,h4,h5,h6,thead',
					'settings' => array(
						array(
							'id' => 'headings_font_family',
							'control' => array(
								'label' => esc_html__( 'Font Family', 'status' ),
								'type' => 'google_font',
							),
							'inline_css' => array(
								'target' => 'h1,h2,h3,h4,h5,h6,.st-heading-font-family,.st-heading,.st-loop-entry-social-share-list a,.st-social-profiles-widget,thead, tfoot th,.cart-collaterals .cart_totals th',
								'alter' => 'font-family',
							),
						),
						array(
							'id' => 'headings_font_weight',
							'control' => array(
								'label' => esc_html__( 'Font Weight', 'status' ),
								'type' => 'select',
								'choices' => $font_weights,
							),
							'inline_css' => array(
								'target' => 'h1,h2,h3,h4,h5,h6,.st-heading-font-family,.st-heading,.st-loop-entry-social-share-list a,.st-social-profiles-widget',
								'alter' => 'font-weight',
							),
						),
						array(
							'id' => 'headings_letter_spacing',
							'control' => array(
								'label' => esc_html__( 'Letter Spacing', 'status' ),
							),
							'inline_css' => array(
								'target' => 'h1,h2,h3,h4,h5,h6,.st-heading-font-family,.st-heading,.st-loop-entry-social-share-list a,.st-social-profiles-widget',
								'alter' => 'letter-spacing',
								'sanitize' => 'px',
							),
						),
					),
				),

				// Buttons Typography
				array(
					'id' => 'st_buttons_typography',
					'title' => esc_html__( 'Buttons', 'status' ),
					'settings' => array(
						array(
							'id' => 'buttons_font_family',
							'control' => array(
								'label' => esc_html__( 'Font Family', 'status' ),
								'type' => 'google_font',
							),
							'inline_css' => array(
								'target' => '.button, button, input[type="submit"],.onsale,.st-shop-orderby-button,.st-theme-button',
								'alter' => 'font-family',
								'important' => true,
							),
						),
						array(
							'id' => 'buttons_font_weight',
							'control' => array(
								'label' => esc_html__( 'Font Weight', 'status' ),
								'type' => 'select',
								'choices' => $font_weights,
							),
							'inline_css' => array(
								'target' => '.button, button, input[type="submit"],.onsale,.st-shop-orderby-button',
								'alter' => 'font-weight',
							),
						),
						array(
							'id' => 'buttons_letter_spacing',
							'control' => array(
								'label' => esc_html__( 'Letter Spacing', 'status' ),
							),
							'inline_css' => array(
								'target' => '.button, button, input[type="submit"],.onsale,.st-shop-orderby-button',
								'alter' => 'letter-spacing',
								'sanitize' => 'px',
							),
						),
					),
				),

				// Entry Category
				array(
					'id' => 'st_entry_cat_typography',
					'title' => esc_html__( 'Category Tag', 'status' ),
					'settings' => array(
						array(
							'id' => 'entry_cat_font_family',
							'control' => array(
								'label' => esc_html__( 'Font Family', 'status' ),
								'type' => 'google_font',
							),
							'inline_css' => array(
								'target' => '.st-entry-cat',
								'alter' => 'font-family',
							),
						),
						array(
							'id' => 'entry_cat_font_weight',
							'control' => array(
								'label' => esc_html__( 'Font Weight', 'status' ),
								'type' => 'select',
								'choices' => $font_weights,
							),
							'inline_css' => array(
								'target' => '.st-entry-cat',
								'alter' => 'font-weight',
							),
						),
						array(
							'id' => 'entry_cat_size',
							'control' => array(
								'label' => esc_html__( 'Font Size', 'status' ),
							),
							'inline_css' => array(
								'target' => '.st-entry-cat',
								'alter' => 'font-size',
								'sanitize' => 'px',
							),
						),
						array(
							'id' => 'entry_cat_letter_spacing',
							'control' => array(
								'label' => esc_html__( 'Letter Spacing', 'status' ),
							),
							'inline_css' => array(
								'target' => '.st-entry-cat',
								'alter' => 'letter-spacing',
								'sanitize' => 'px',
							),
						),
					),
				),

				// Entry Title Typography
				array(
					'id' => 'st_entry_title_typography',
					'title' => esc_html__( 'Entry Title', 'status' ),
					'settings' => array(
						array(
							'id' => 'entry_title_font_family',
							'control' => array(
								'label' => esc_html__( 'Font Family', 'status' ),
								'type' => 'google_font',
							),
							'inline_css' => array(
								'target' => '.st-loop-entry-title,.st-featured-entry-title',
								'alter' => 'font-family',
							),
						),
						array(
							'id' => 'entry_title_font_weight',
							'control' => array(
								'label' => esc_html__( 'Font Weight', 'status' ),
								'type' => 'select',
								'choices' => $font_weights,
							),
							'inline_css' => array(
								'target' => '.st-loop-entry-title,.st-featured-entry-title',
								'alter' => 'font-weight',
							),
						),
						array(
							'id' => 'entry_title_size',
							'control' => array(
								'label' => esc_html__( 'Font Size', 'status' ),
							),
							'inline_css' => array(
								'target' => '.st-loop-entry-title,.st-featured-entry-title',
								'alter' => 'font-size',
								'sanitize' => 'px',
							),
						),
						array(
							'id' => 'entry_title_color',
							'control' => array(
								'label' => esc_html__( 'Text Color', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-loop-entry-title a,.st-featured-entry-title a',
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'entry_title_letter_spacing',
							'control' => array(
								'label' => esc_html__( 'Letter Spacing', 'status' ),
							),
							'inline_css' => array(
								'target' => '.st-loop-entry-title,.st-featured-entry-title',
								'alter' => 'letter-spacing',
								'sanitize' => 'px',
							),
						),
						array(
							'id' => 'entry_title_text_transform',
							'control' => array(
								'label' => esc_html__( 'Text Transform', 'status' ),
								'type' => 'select',
								'choices' => array(
									'' => esc_html__( 'Default', 'status' ),
									'none' => esc_html__( 'None', 'status' ),
									'uppercase' => esc_html__( 'Uppercase', 'status' ),
									'lowercase' => esc_html__( 'Lowercase', 'status' ),
								),
							),
							'inline_css' => array(
								'target' => '.st-loop-entry-title,.st-featured-entry-title',
								'alter' => 'text-transform',
							),
						),
					),
				),

				// Post Title Typography
				array(
					'id' => 'st_post_title_typography',
					'title' => esc_html__( 'Post Title', 'status' ),
					'settings' => array(
						array(
							'id' => 'post_title_font_family',
							'control' => array(
								'label' => esc_html__( 'Font Family', 'status' ),
								'type' => 'google_font',
							),
							'inline_css' => array(
								'target' => '.st-post-title',
								'alter' => 'font-family',
							),
						),
						array(
							'id' => 'post_title_font_weight',
							'control' => array(
								'label' => esc_html__( 'Font Weight', 'status' ),
								'type' => 'select',
								'choices' => $font_weights,
							),
							'inline_css' => array(
								'target' => '.st-post-title',
								'alter' => 'font-weight',
							),
						),
						array(
							'id' => 'post_title_size',
							'control' => array(
								'label' => esc_html__( 'Font Size', 'status' ),
							),
							'inline_css' => array(
								'target' => '.st-post-title',
								'alter' => 'font-size',
								'sanitize' => 'px',
							),
						),
						array(
							'id' => 'post_title_color',
							'control' => array(
								'label' => esc_html__( 'Text Color', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-post-title',
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'post_title_letter_spacing',
							'control' => array(
								'label' => esc_html__( 'Letter Spacing', 'status' ),
							),
							'inline_css' => array(
								'target' => '.st-post-title',
								'alter' => 'letter-spacing',
								'sanitize' => 'px',
							),
						),
						array(
							'id' => 'post_title_text_transform',
							'control' => array(
								'label' => esc_html__( 'Text Transform', 'status' ),
								'type' => 'select',
								'choices' => array(
									'' => esc_html__( 'Default', 'status' ),
									'none' => esc_html__( 'None', 'status' ),
									'uppercase' => esc_html__( 'Uppercase', 'status' ),
									'lowercase' => esc_html__( 'Lowercase', 'status' ),
								),
							),
							'inline_css' => array(
								'target' => '.st-post-title',
								'alter' => 'text-transform',
							),
						),
					),
				),

				// Post Typography
				array(
					'id' => 'st_post_typography',
					'title' => esc_html__( 'Main Content', 'status' ),
					'settings' => array(
						array(
							'id' => 'post_font_family',
							'control' => array(
								'label' => esc_html__( 'Font Family', 'status' ),
								'type' => 'google_font',
							),
							'inline_css' => array(
								'target' => '.st-entry',
								'alter' => 'font-family',
							),
						),
						array(
							'id' => 'post_font_weight',
							'control' => array(
								'label' => esc_html__( 'Font Weight', 'status' ),
								'type' => 'select',
								'choices' => $font_weights,
							),
							'inline_css' => array(
								'target' => '.st-entry',
								'alter' => 'font-weight',
							),
						),
						array(
							'id' => 'post_size',
							'control' => array(
								'label' => esc_html__( 'Font Size', 'status' ),
							),
							'inline_css' => array(
								'target' => '.st-entry',
								'alter' => 'font-size',
								'sanitize' => 'px',
							),
						),
						array(
							'id' => 'post_color',
							'control' => array(
								'label' => esc_html__( 'Text Color', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-entry',
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'post_letter_spacing',
							'control' => array(
								'label' => esc_html__( 'Letter Spacing', 'status' ),
							),
							'inline_css' => array(
								'target' => '.st-entry',
								'alter' => 'letter-spacing',
								'sanitize' => 'px',
							),
						),
					),
				),

				// Sidebar Widget Titles Typography
				array(
					'id' => 'st_sidebar_heading_typography',
					'title' => esc_html__( 'Sidebar Widget Titles', 'status' ),
					'settings' => array(
						array(
							'id' => 'sidebar_heading_font_family',
							'control' => array(
								'label' => esc_html__( 'Font Family', 'status' ),
								'type' => 'google_font',
							),
							'inline_css' => array(
								'target' => '.st-sidebar .widget-title',
								'alter' => 'font-family',
							),
						),
						array(
							'id' => 'sidebar_heading_font_weight',
							'control' => array(
								'label' => esc_html__( 'Font Weight', 'status' ),
								'type' => 'select',
								'choices' => $font_weights,
							),
							'inline_css' => array(
								'target' => '.st-sidebar .widget-title',
								'alter' => 'font-weight',
							),
						),
						array(
							'id' => 'sidebar_heading_size',
							'control' => array(
								'label' => esc_html__( 'Font Size', 'status' ),
							),
							'inline_css' => array(
								'target' => '.st-sidebar .widget-title',
								'alter' => 'font-size',
								'sanitize' => 'px',
							),
						),
						array(
							'id' => 'sidebar_heading_color',
							'control' => array(
								'label' => esc_html__( 'Color', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-sidebar .widget-title',
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'sidebar_heading_letter_spacing',
							'control' => array(
								'label' => esc_html__( 'Letter Spacing', 'status' ),
							),
							'inline_css' => array(
								'target' => '.st-sidebar .widget-title',
								'alter' => 'letter-spacing',
								'sanitize' => 'px',
							),
						),
						array(
							'id' => 'sidebar_heading_text_transform',
							'control' => array(
								'label' => esc_html__( 'Text Transform', 'status' ),
								'type' => 'select',
								'choices' => array(
									'' => esc_html__( 'Default', 'status' ),
									'none' => esc_html__( 'None', 'status' ),
									'uppercase' => esc_html__( 'Uppercase', 'status' ),
									'lowercase' => esc_html__( 'Lowercase', 'status' ),
								),
							),
							'inline_css' => array(
								'target' => '.st-sidebar .widget-title',
								'alter' => 'text-transform',
							),
						),
					),
				),

				// Footer Titles Typography
				array(
					'id' => 'st_footer_heading_typography',
					'title' => esc_html__( 'Footer Widget Titles', 'status' ),
					'settings' => array(
						array(
							'id' => 'footer_heading_font_family',
							'control' => array(
								'label' => esc_html__( 'Font Family', 'status' ),
								'type' => 'google_font',
							),
							'inline_css' => array(
								'target' => '.st-site-footer .widget-title',
								'alter' => 'font-family',
							),
						),
						array(
							'id' => 'footer_heading_font_weight',
							'control' => array(
								'label' => esc_html__( 'Font Weight', 'status' ),
								'type' => 'select',
								'choices' => $font_weights,
							),
							'inline_css' => array(
								'target' => '.st-site-footer .widget-title',
								'alter' => 'font-weight',
							),
						),
						array(
							'id' => 'footer_heading_size',
							'control' => array(
								'label' => esc_html__( 'Font Size', 'status' ),
							),
							'inline_css' => array(
								'target' => '.st-site-footer .widget-title',
								'alter' => 'font-size',
								'sanitize' => 'px',
							),
						),
						array(
							'id' => 'footer_heading_color',
							'control' => array(
								'label' => esc_html__( 'Color', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-site-footer .widget-title',
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'footer_heading_letter_spacing',
							'control' => array(
								'label' => esc_html__( 'Letter Spacing', 'status' ),
							),
							'inline_css' => array(
								'target' => '.st-site-footer .widget-title',
								'alter' => 'letter-spacing',
								'sanitize' => 'px',
							),
						),
						array(
							'id' => 'footer_heading_text_transform',
							'control' => array(
								'label' => esc_html__( 'Text Transform', 'status' ),
								'type' => 'select',
								'choices' => array(
									'' => esc_html__( 'Default', 'status' ),
									'none' => esc_html__( 'None', 'status' ),
									'uppercase' => esc_html__( 'Uppercase', 'status' ),
									'lowercase' => esc_html__( 'Lowercase', 'status' ),
								),
							),
							'inline_css' => array(
								'target' => '.st-site-footer .widget-title a',
								'alter' => 'text-transform',
							),
						),
					),
				),

			),
		);

		/*-----------------------------------------------------------------------------------*/
		/* - Styling Panel
		/*-----------------------------------------------------------------------------------*/
		$panels['styling'] = array(
			'title' => esc_html__( 'Styling', 'status' ),
			'sections' => array(

				// Styling > Main
				array(
					'id' => 'st_styling_main',
					'title' => esc_html__( 'Main', 'status' ),
					'settings' => array(
						array(
							'id' => 'primary_accent_color',
							'default' => '#fab442',
							'control' => array(
								'label' => esc_html__( 'Accent Color', 'status' ),
								'type' => 'color',
							),
						),
						array(
							'id' => 'secondary_accent_color',
							'default' => '#222',
							'control' => array(
								'label' => esc_html__( 'Accent Color', 'status' ),
								'type' => 'color',
							),
						),
						array(
							'id' => 'link_color',
							'control' => array(
								'label' => esc_html__( 'Links', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => 'a,.st-site-content h2 a:hover,.st-site-content h3 a:hover',
								'sanitize' => 'hex',
								'alter' => 'color',
							),
						),
					),
				),

				// Styling > Topbar
				array(
					'id' => 'st_styling_topbar',
					'title' => esc_html__( 'Topbar', 'status' ),
					'settings' => array(
						array(
							'id' => 'topbar_bg',
							'control' => array(
								'label' => esc_html__( 'Background', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-topbar-wrap',
								'alter' => 'background-color',
								'important' => true,
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'topbar_borders',
							'control' => array(
								'label' => esc_html__( 'Borders', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-topbar-wrap,.st-topbar-nav a,.st-topbar-nav',
								'alter' => 'border-color',
								'important' => true,
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'topbar_link_color',
							'control' => array(
								'label' => esc_html__( 'Links', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-topbar a',
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'topbar_link_hover_color',
							'control' => array(
								'label' => esc_html__( 'Links: Hover Color', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-topbar a:hover',
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'topbar_link_hover_bg',
							'control' => array(
								'label' => esc_html__( 'Links: Hover Background', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-topbar-nav a:hover',
								'alter' => 'background-color',
								'sanitize' => 'hex',
							),
						),
					),
				),
				
				// Styling > Header
				array(
					'id' => 'st_styling_header',
					'title' => esc_html__( 'Header', 'status' ),
					'settings' => array(
						array(
							'id' => 'header_bg',
							'control' => array(
								'label' => esc_html__( 'Background', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-site-header-wrap',
								'alter' => 'background-color',
								'important' => true,
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'header_padding',
							'description' => esc_html__( 'Use format: top right bottom left', 'status' ),
							'control' => array(
								'label' => esc_html__( 'Padding', 'status' ),
								'type' => 'text',
							),
							'inline_css' => array(
								'target' => '.st-site-header',
								'alter' => 'padding',
							),
						),
						array(
							'id' => 'logo_color',
							'control' => array(
								'label' => esc_html__( 'Logo Color', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-site-logo a',
								'alter' => array(
									'color',
									'border-color',
								),
								'important' => true,
							),
						),
						array(
							'id' => 'site_description_color',
							'control' => array(
								'label' => esc_html__( 'Site Description Color', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-site-description',
								'important' => true,
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
					),
				),

				// Styling > Menu
				array(
					'id' => 'st_styling_nav',
					'title' => esc_html__( 'Menu', 'status' ),
					'settings' => array(
						array(
							'id' => 'nav_bg',
							'control' => array(
								'label' => esc_html__( 'Menu Background', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-site-nav-wrap',
								'alter' => 'background-color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'nav_border',
							'control' => array(
								'label' => esc_html__( 'Menu Borders', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-site-nav,.st-site-nav .st-dropdown-menu a,.st-site-nav-wrap,.st-menu-search-toggle,.st-site-nav .slicknav_btn,.st-site-nav .slicknav_menu .slicknav_nav',
								'alter' => 'border-color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'nav_color',
							'control' => array(
								'label' => esc_html__( 'Menu Link Color', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-site-nav .st-dropdown-menu a,.st-menu-search-toggle',
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'nav_color_hover',
							'control' => array(
								'label' => esc_html__( 'Menu Link Hover Color', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-site-nav .st-dropdown-menu li a:hover,.st-site-nav .st-dropdown-menu > li.menu-item-has-children:hover > a',
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'nav_color_hover_bg',
							'control' => array(
								'label' => esc_html__( 'Menu Link Hover Background', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-site-nav .st-dropdown-menu li a:hover,.st-site-nav .st-dropdown-menu > li.menu-item-has-children:hover > a,.st-menu-search-toggle:hover',
								'alter' => 'background-color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'nav_color_active',
							'control' => array(
								'label' => esc_html__( 'Menu Link Active Color', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-site-nav .st-dropdown-menu > li.current-menu-item > a,.st-site-nav .st-dropdown-menu > li.parent-menu-item > a,.st-site-nav .st-dropdown-menu > li.current-menu-ancestor > a',
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'nav_color_active_bg',
							'control' => array(
								'label' => esc_html__( 'Menu Link Active Background', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-site-nav .st-dropdown-menu > li.current-menu-item > a,.st-site-nav .st-dropdown-menu > li.parent-menu-item > a,.st-site-nav .st-dropdown-menu > li.current-menu-ancestor > a',
								'alter' => 'background-color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'nav_drop_bg',
							'control' => array(
								'label' => esc_html__( 'Menu Dropdown Background', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-site-nav .st-dropdown-menu .sub-menu',
								'alter' => 'background-color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'nav_drop_borders',
							'control' => array(
								'label' => esc_html__( 'Menu Dropdown Borders', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-site-nav .st-dropdown-menu .sub-menu li',
								'alter' => 'border-color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'nav_drop_color',
							'control' => array(
								'label' => esc_html__( 'Menu Dropdown Link Color', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-site-nav .st-dropdown-menu .sub-menu a',
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'nav_drop_color_hover',
							'control' => array(
								'label' => esc_html__( 'Menu Dropdown Link Hover Color', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-site-nav .st-dropdown-menu .sub-menu a:hover',
								'alter' => 'color',
								'sanitize' => 'hex',
								'important' => true,
							),
						),
						array(
							'id' => 'nav_drop_color_hover_bg',
							'control' => array(
								'label' => esc_html__( 'Menu Dropdown Link Hover Background', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-site-nav .st-dropdown-menu .sub-menu a:hover',
								'alter' => 'background-color',
								'sanitize' => 'hex',
								'important' => true,
							),
						),
					),
				),

				// Sidebar
				array(
					'id' => 'st_styling_sidebar',
					'title' => esc_html__( 'Sidebar', 'status' ),
					'settings' => array(
						array(
							'id' => 'sidebar_text_color',
							'control' => array(
								'label' => esc_html__( 'Text', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-sidebar',
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'sidebar_links_color',
							'control' => array(
								'label' => esc_html__( 'Links', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-sidebar-widget a',
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'sidebar_links_hover_color',
							'control' => array(
								'label' => esc_html__( 'Links: Hover', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-sidebar-widget a:hover',
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
					),
				),

				// Footer
				array(
					'id' => 'st_styling_footer',
					'title' => esc_html__( 'Footer', 'status' ),
					'settings' => array(
						array(
							'id' => 'footer_bg',
							'control' => array(
								'label' => esc_html__( 'Background ', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-site-footer',
								'sanitize' => 'hex',
								'alter' => 'background-color',
							),
						),
						array(
							'id' => 'footer_borders',
							'control' => array(
								'label' => esc_html__( 'borders ', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-site-footer ul li,.st-footer-widgets .widget_archive li,.st-footer-widgets .widget_recent_entries li,.st-footer-widgets .widget_categories li,.st-footer-widgets .widget_meta li,.st-footer-widgets .widget_recent_comments li,.st-footer-widgets .widget_nav_menu li,.st-footer-widgets .widget-recent-list li,.st-site-footer #wp-calendar td',
								'sanitize' => 'hex',
								'alter' => 'border-color',
							),
						),
						array(
							'id' => 'footer_color',
							'control' => array(
								'label' => esc_html__( 'Color ', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-site-footer',
								'sanitize' => 'hex',
								'alter' => 'color',
							),
						),
						array(
							'id' => 'footer_widget_title_color',
							'control' => array(
								'label' => esc_html__( 'Widget Titles', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-footer-widgets .widget-title',
								'sanitize' => 'hex',
								'alter' => 'color',
							),
						),
						array(
							'id' => 'footer_link',
							'control' => array(
								'label' => esc_html__( 'Links', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-footer-widgets a,.st-footer-widgets .widget-recent-list .st-title a,.st-footer-widgets a,.st-footer-widgets .widget-recent-list .st-title a,.st-footer-widgets .st-widget-popular-posts li a',
								'sanitize' => 'hex',
								'alter' => 'color',
							),
						),
						array(
							'id' => 'footer_link_hover',
							'control' => array(
								'label' => esc_html__( 'Links: Hover ', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-site-footer a:hover,.st-footer-widgets .widget-recent-list .st-title a:hover,.st-footer-widgets a:hover,.st-footer-widgets .widget-recent-list .st-title a:hover,.st-footer-widgets .st-widget-popular-posts li a:hover',
								'sanitize' => 'hex',
								'alter' => 'color',
							),
						),
					),
				),

				// Footer Bottom
				array(
					'id' => 'st_styling_footer_bottom_bottom',
					'title' => esc_html__( 'Footer Bottom', 'status' ),
					'settings' => array(
						array(
							'id' => 'footer_bottom_bg',
							'control' => array(
								'label' => esc_html__( 'Background ', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-footer-bottom',
								'sanitize' => 'hex',
								'alter' => 'background-color',
							),
						),
						array(
							'id' => 'footer_bottom_border',
							'control' => array(
								'label' => esc_html__( 'Border ', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-footer-bottom',
								'sanitize' => 'hex',
								'alter' => 'border-color',
							),
						),
						array(
							'id' => 'footer_bottom_border',
							'control' => array(
								'label' => esc_html__( 'Border ', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-footer-bottom',
								'sanitize' => 'hex',
								'alter' => 'border-top-color',
							),
						),
						array(
							'id' => 'footer_bottom_color',
							'control' => array(
								'label' => esc_html__( 'Color ', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-footer-bottom',
								'sanitize' => 'hex',
								'alter' => 'color',
							),
						),
						array(
							'id' => 'footer_bottom_link',
							'control' => array(
								'label' => esc_html__( 'Links', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-footer-bottom a',
								'sanitize' => 'hex',
								'alter' => 'color',
							),
						),
						array(
							'id' => 'footer_bottom_link_hover',
							'control' => array(
								'label' => esc_html__( 'Links: Hover ', 'status' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.st-footer-bottom a:hover',
								'sanitize' => 'hex',
								'alter' => 'color',
							),
						),
					),
				),

			),
		);

		/*-----------------------------------------------------------------------------------*/
		/* - Image Sizes
		/*-----------------------------------------------------------------------------------*/
		$image_sizes = array();
		$get_image_sizes = st_get_image_sizes();
		$desc = esc_html__( 'If you alter any image sizes you will have to regenerate your thumbnails.', 'status' );
		foreach ( $get_image_sizes as $id => $label ) {
			$image_sizes[] = array(
				'id' => 'st_'. $id .'_thumbnail_sizes',
				'title' => $label,
				'desc' => $desc,
				'settings' => array(
					array(
						'id' => $id .'_thumb_width',
						'default' => '9999',
						'transport' => 'postMessage',
						'control' => array(
							'label' => esc_html__( 'Image Width', 'status' ),
							'type' => 'text',
						),
					),
					array(
						'id' => $id .'_thumb_height',
						'default' => '9999',
						'transport' => 'postMessage',
						'control' => array(
							'label' => esc_html__( 'Image Height', 'status' ),
							'type' => 'text',
						),
					),
					array(
						'id' => $id .'_thumb_crop',
						'default' => 'center-center',
						'transport' => 'postMessage',
						'control' => array(
							'label' => esc_html__( 'Crop', 'status' ),
							'type' => 'select',
							'choices' => st_image_crop_locations(),
						),
					),
				),
			);
		}

		$panels['image_sizes'] = array(
			'title' => esc_html__( 'Image Sizes', 'status' ),
			'desc' => esc_html__( 'By default this theme does not crop any images so you can customize your settings first and prevent unnecessary image cropping. Below you will find all the settings needed to crop the images on your site. Be sure to install a regenerate plugin so you can regenerate your thumbnails whenvever you alter these values.', 'status' ),
			'sections' => $image_sizes,
		);

		// Return panels array
		return $panels;

	}
}
add_filter( 'st_customizer_panels', 'st_customizer_config' );

// Callback functions
function st_active_callback_has_grid() {
	if ( 'grid' == st_get_theme_mod( 'entry_style' ) ) {
		return true;
	} else {
		return false;
	}
}
function st_active_callback_topbar_social() {
	if ( st_get_theme_mod( 'topbar_social_enable', true ) ) {
		return true;
	} else {
		return false;
	}
}
function st_customizer_has_related_posts() {
	if ( st_get_theme_mod( 'post_related', true ) && st_get_theme_mod( 'post_related_count', 6 ) ) {
		return true;
	} else {
		return false;
	}
}
function st_customizer_has_entry_readmore() {
	if ( st_get_theme_mod( 'entry_readmore', false ) ) {
		return true;
	} else {
		return false;
	}
}