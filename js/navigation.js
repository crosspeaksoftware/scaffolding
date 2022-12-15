/**
 * Navigation Scripts
 *
 * @package scaffolding
 */

// as the page loads, call these scripts.
jQuery( document ).ready(
	function($) {

		// getting viewport width.
		var responsive_viewport = $( window ).width() + getScrollBarWidth();

		/*
		Mobile Navigation
		*/
		$(
			function() {
				$( '#mobile-menu-button' ).on(
					'click',
					function(e) {
						if ( ! $( 'body' ).hasClass( 'menu-open' ) ) {
							$( '#main-navigation > ul.main-menu' ).css( 'display','block' );
							$( 'body' ).toggleClass( 'menu-open' );
						} else {
							$( 'body' ).toggleClass( 'menu-open' );
							setTimeout(
								function(){
									$( '#main-navigation > ul.main-menu' ).css( 'display','none' );
								},
								500
							);
						}
					}
				);

				$( '#main-navigation .menu-item > .menu-button' ).on(
					'click',
					function(e) {
						$( this ).next( '.sub-menu' ).addClass( 'sub-menu-open' );
					}
				);

				$( '#main-navigation .sub-menu .menu-back-button' ).on(
					'click',
					function(e) {
						$( this ).parent( 'li' ).parent( 'ul' ).removeClass( 'sub-menu-open' );
					}
				);

				/*
				Fixes bug on touch devices
				opens ul on first tap
				accepts anchor and opens page on second tap
				*/
				if ($.fn.doubleTapToGo) {
					responsive_viewport = $( window ).width() + getScrollBarWidth();
					if (responsive_viewport >= 768) {
						$( '#main-navigation' ).doubleTapToGo();
					}
				}
			}
		);

		$( window ).resize(
			function(e) {
				responsive_viewport = $( window ).width() + getScrollBarWidth();
				if (responsive_viewport >= 768) {
					$( 'body' ).removeClass( 'menu-open' );
					$( '#main-navigation > ul.main-menu' ).removeAttr( 'style' );
				}
			}
		);

	}
);
