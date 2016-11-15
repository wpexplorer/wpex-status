;(function( $ ){

  'use strict';

		if ( ( 'ontouchstart' in window )
				|| (navigator.MaxTouchPoints > 0)
				|| (navigator.msMaxTouchPoints > 0)
		) {

		var $dropdownParents = $( '.st-dropdown-menu li.menu-item-has-children > a' );

		$dropdownParents.each( function() {

			var $this = $( this ),
				$parent = $this.parent( 'li' );

			$( this ).on( 'click', function( event ) {
				if ( ! $parent.hasClass( 'st-active' ) ) {
					$parent.addClass( 'st-active' );
					return false;
				} else {
					$parent.removeClass( 'st-active' );
				}
			} );

			$( document ).on( 'click touchstart MSPointerDown', function( event ) {

				$parent.removeClass( 'st-active' );

			} );

		} );

	  }

} ) ( jQuery );