/**
 * Scripts
 *
 * @package scaffolding
 *
 * This file should contain any js scripts you want to add to the site.
 * Instead of calling it in the header or throwing it inside wp_head()
 * this file will be called automatically in the footer so as not to
 * slow the page load.
 */

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
