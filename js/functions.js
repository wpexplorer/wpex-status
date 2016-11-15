 /**
 * Theme functions
 * Initialize all scripts and adds custom js
 *
 * @since 1.0.0
 *
 */

( function( $ ) {

	'use strict';

	var stFunctions = {

		/**
		 * Define cache var
		 *
		 * @since 1.0.0
		 */
		cache: {},

		/**
		 * Main Function
		 *
		 * @since 1.0.0
		 */
		init: function() {
			this.cacheElements();
			this.bindEvents();
		},

		/**
		 * Cache Elements
		 *
		 * @since 1.0.0
		 */
		cacheElements: function() {
			this.cache = {
				$window   : $( window ),
				$document : $( document ),
				$body     : $( 'body' ),
				$isMobile : false,
				$isRTL    : false,
			};
		},

		/**
		 * Bind Events
		 *
		 * @since 1.0.0
		 */
		bindEvents: function() {

			// Get sef
			var self = this;

			// Check RTL
			if ( self.cache.$body.hasClass( 'rtl' ) ) {
				self.cache.$isRTL = true;
			}

			// Check if touch is supported
			self.cache.$isTouch = ( ( 'ontouchstart' in window ) || ( navigator.msMaxTouchPoints > 0 ) );

			// Run on document ready
			self.cache.$document.on( 'ready', function() {
				self.responsiveEmbeds();
				self.mobileCheck();
				self.commentScrollTo();
				self.commentLastClass();
				self.menuSearchOverlay();
				self.scrollTop();
				self.lightbox();
				self.mobileMenu();
				self.socialShare();
				self.footerDivider();
			} );

			// Run on Window Load
			self.cache.$window.on( 'load', function() {
				self.cache.$body.addClass( 'st-site-loaded' );
				self.lightSliders();
			} );

		},

		/**
		 * Mobile Check
		 *
		 * @since 1.0.0
		 */
		mobileCheck: function() {
			if ( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test( navigator.userAgent ) ) {
				this.cache.$body.addClass( 'st-is-mobile-device' );
				this.cache.$isMobile = true;
				return true;
			}
		},

		/**
		 * Menu Search toggle
		 *
		 * @since 1.0.0
		 */
		menuSearchOverlay: function() {
			$( '.st-menu-search-toggle' ).click( function() {
				var $overlay = $( '.st-search-overlay' );
			 	$( this ).toggleClass( 'st-active' );
			 	$( 'html, body' ).toggleClass( 'st-prevent-scroll' );
			 	$overlay.toggleClass( 'st-show' );
			 	var $transitionDuration = $overlay.css( 'transition-duration' );
				$transitionDuration = $transitionDuration.replace( 's', '' ) * 1000;
				if ( $transitionDuration ) {
					setTimeout( function() {
						$overlay.find( 'input[type="search"]' ).focus();
					}, $transitionDuration );
				}
			 	return false;
			} );
			$( '.st-search-overlay .st-site-searchform' ).click(function( event ) {
				event.stopPropagation();
			} );
			$( '.st-search-overlay' ).click( function() {
				$( this ).removeClass( 'st-show' );
				$( 'html, body' ).removeClass( 'st-prevent-scroll' );
			} );
		},

		/**
		 * Responsive embeds
		 *
		 * @since 1.0.0
		 */
		responsiveEmbeds: function() {
			$( '.st-responsive-embed' ).fitVids( {
				ignore: '.st-fitvids-ignore'
			} );
			$( '.st-responsive-embed' ).addClass( 'st-show' );
		},

		/**
		 * Comment link scroll to
		 *
		 * @since 1.0.0
		 */
		commentScrollTo: function() {
			$( '.st-post-share .st-comment a, .single .comments-link' ).click( function() {
				var $target = $( '#comments' );
				var $offset = 30;
					if ( $target.length ) {
					if ( $( '.st-post-share' ).length ) {
						$offset = 65;
					}
					if ( $target.length ) {
						$( 'html,body' ).animate({
							scrollTop: $target.offset().top - $offset
						}, 1000 );
					}
					return false;
				}
			} );
		},

		/**
		 * Comments last class
		 *
		 * @since 1.0.0
		 */
		commentLastClass: function() {
			$( ".commentlist li.pingback" ).last().addClass( 'last' );
		},

		/**
		 * Mobile Menu
		 *
		 * @since 1.0.0
		 */
		mobileMenu: function() {
			var $closedSymbol = this.cache.$isRTL ? '&#9668;' : '&#9658;';
			if ( $.fn.slicknav != undefined ) {
				$( '.st-topbar-nav .st-dropdown-menu' ).slicknav( {
					appendTo         : '.st-topbar-nav',
					label            : '<span class="fa fa-bars"></span>'+ stLocalize.mobileTopbarMenuLabel,
					allowParentLinks : true,
					closedSymbol     : $closedSymbol
				} );
				var $mobileMenuAlt = $( '.st-mobile-menu-alt ul' );
				var $menu = $mobileMenuAlt.length ? $mobileMenuAlt : $( '.st-site-nav-container .st-dropdown-menu' );
				if ( $menu.length ) {
					$menu.slicknav( {
						appendTo         : '.st-site-nav',
						label            : '<span class="fa fa-bars"></span>'+ stLocalize.mobileSiteMenuLabel,
						allowParentLinks : true,
						closedSymbol     : $closedSymbol
					} );
				}
			}
		},

		/**
		 * Scroll top function
		 *
		 * @since 1.0.0
		 */
		scrollTop: function() {

			var $scrollTopLink = $( 'a.st-site-scroll-top' );

			this.cache.$window.scroll(function () {
				if ( $( this ).scrollTop() > 100 ) {
					$scrollTopLink.addClass( 'st-show' );
				} else {
					$scrollTopLink.removeClass( 'st-show' );
				}
			} );

			$scrollTopLink.on( 'click', function() {
				$( 'html, body' ).animate( {
					scrollTop : 0
				}, 800 );
				return false;
			} );

		},

		/**
		 * Post Slider
		 *
		 * @since 1.0.0
		 */
		lightSliders: function() {
			
			if ( $.fn.lightSlider === undefined ) {
				return;
			}
 
			// Post Slider
			var $slider = $( '.st-post-slider' );

			if ( $slider.length !== 0 ) {

				$slider.each( function() {

					var $this = $( this );

					$this.show();

					$this.lightSlider( {
						mode: 'fade',
						auto: false,
						speed: 500,
						adaptiveHeight: true,
						item: 1,
						slideMargin: 0,
						pager: false,
						loop: true,
						rtl: stLocalize.isRTL,
						prevHtml: '<span class="fa fa-angle-left"></span>',
						nextHtml: '<span class="fa fa-angle-right"></span>',
						onBeforeStart: function( el ) {
							$( '.slider-first-image-holder, .slider-preloader' ).remove();
						}
					} );

				} );

			}

		},

		/**
		 * Lightbox
		 *
		 * @since 1.0.0
		 */
		lightbox: function() {

			if ( $.fn.magnificPopup != undefined ) {

				// Gallery lightbox
				$( '.st-lightbox-gallery, .woocommerce .images' ).each( function() {
					$( this ).magnificPopup( {
						delegate    : 'a.st-lightbox-item',
						type        : 'image',
						gallery     : {
							enabled : true
						}
					} );
				} );

				// WooCommerce lightbox
				$( '.woocommerce .images .thumbnails' ).magnificPopup( {
					delegate    : 'a',
					type        : 'image',
					gallery     : {
						enabled : true
					}
				} );
				$( '.woocommerce .images .woocommerce-main-image' ).magnificPopup( {
					type : 'image'
				} );

				if ( stLocalize.wpGalleryLightbox == true ) {

					$( '.st-entry .gallery' ).each( function() {

						// Check first item and see if it's linking to an image if so add lightbox
						var firstItemHref = $( this ).find( '.gallery-item a' ).first().attr( 'href' );
						if ( /\.(jpg|png|gif)$/.test( firstItemHref ) ) {
							$( this ).magnificPopup( {
								delegate    : '.gallery-item a',
								type        : 'image',
								gallery     : {
									enabled : true
								}
							} );
						}

					} );

				}

				// Auto add lightbox to entry images
				$( '.single-post .st-entry a:has(img)' ).each( function() {

					// Define this
					var $this = $( this );

					// Not for gallery
					if ( $this.parent().hasClass( 'gallery-icon' ) ) {
						return;
					}

					// Get data
					var $img  = $this.find( 'img' ),
						$src  = $img.attr( 'src' ),
						$ref  = $this.attr( 'href' ),
						$ext  = $ref.substr( ( $ref.lastIndexOf( '.' ) +1 ) );

					// Ad lightbox
					if ( 'png' == $ext || 'jpg' == $ext || 'jpeg' == $ext || 'gif' == $ext ) {
						$this.magnificPopup( {
							type    : 'image'
						} );
					}

				} );

			}

		},

		/**
		 * Social Share
		 *
		 * @since 1.0.0
		 */
		socialShare: function() {

			var $post = $( '.st-post-article' );

			if ( ! $post.length ) return;

			var $postShare     = $( '.st-post-share' ),
				$window        = $( window ),
				$postOffset    = $post.offset().top,
				$lastScrollTop = 0;

			$( window ).scroll( function() {

				var $windowTop = $window.scrollTop();
				var $items      = $( '.st-post-share li' ),
					$itemsCount = $items.length;

				// Display 
				if ( $windowTop >= $postOffset && ! $postShare.hasClass( 'st-show' ) ) {
					$postShare.addClass( 'st-show' );
				}

				// Hide
				if ( $postShare.hasClass( 'st-show' ) ) {
					if ( $windowTop <= $postOffset || $windowTop < $lastScrollTop ) {
						$postShare.removeClass( 'st-show' );
					}
				}

				$lastScrollTop = $windowTop;

			} );

			$( '.st-post-share .st-comment a' ).click( function() {
				var $target = $( '#comments' );
				var $offset = 30;
				if ( $( '.st-post-share' ).length ) {
					$offset = 65;
				}
				if ( $target.length ) {
					$( 'html,body' ).animate({
						scrollTop: $target.offset().top - $offset
					}, 1000 );
				}
				return false;
			} );

		},

		/**
		 * Shuffle footer divider colors
		 *
		 * @since 1.0.0
		 */
		footerDivider: function() {
			var $colorDivider = $( '.st-footer-divider' );
			if ( $colorDivider.length && $colorDivider.hasClass( 'st-shuffle' ) ) {
				var $colors = $colorDivider.children();
				while ( $colors.length ) {
					$colorDivider.append( $colors.splice(Math.floor(Math.random() * $colors.length), 1)[0]);
				}
			}
		}

	}; // END stFunctions

	// Get things going
	stFunctions.init();

} ) ( jQuery );