/**
 * Site Name:
 * Author:
 *
 * Name: Scaffolding Scripts
 *
 * @package scaffolding
 *
 * This file should contain any js scripts you want to add to the site.
 * Instead of calling it in the header or throwing it inside wp_head()
 * this file will be called automatically in the footer so as not to
 * slow the page load.
 */

// Calculate the width of the scroll bar so css media queries and js widow.width match.
function getScrollBarWidth () {
	var inner          = document.createElement( 'p' );
	inner.style.width  = "100%";
	inner.style.height = "200px";

	var outer              = document.createElement( 'div' );
	outer.style.position   = "absolute";
	outer.style.top        = "0px";
	outer.style.left       = "0px";
	outer.style.visibility = "hidden";
	outer.style.width      = "200px";
	outer.style.height     = "150px";
	outer.style.overflow   = "hidden";
	outer.appendChild( inner );

	document.body.appendChild( outer );
	var w1               = inner.offsetWidth;
	outer.style.overflow = 'scroll';
	var w2               = inner.offsetWidth;
	if (w1 == w2) {
		w2 = outer.clientWidth;
	}

	document.body.removeChild( outer );

	return (w1 - w2);
};

// As the page loads, call these scripts.
jQuery( document ).ready(
	function($) {

		// hide #back-top first.
		$( "#back-top" ).hide();

		// fade in #back-top.
		$(
			function () {
				$( window ).scroll(
					function () {
						if ($( this ).scrollTop() > 300) {
							$( '#back-top' ).fadeIn();
						} else {
							$( '#back-top' ).fadeOut();
						}
					}
				);

				// scroll body to 0px on click.
				$( '#back-top a' ).click(
					function () {
						$( 'body,html' ).animate(
							{
								scrollTop: 0
							},
							800
						);
						return false;
					}
				);
			}
		);

	}
);
