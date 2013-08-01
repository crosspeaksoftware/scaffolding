/*
scaffolding Scripts File
Author: Eddie Machado

This file should contain any js scripts you want to add to the site.
Instead of calling it in the header or throwing it inside wp_head()
this file will be called automatically in the footer so as not to
slow the page load.

*/

// IE8 ployfill for GetComputed Style (for Responsive Script below)
if (!window.getComputedStyle) {
	window.getComputedStyle = function(el, pseudo) {
		this.el = el;
		this.getPropertyValue = function(prop) {
			var re = /(\-([a-z]){1})/g;
			if (prop == 'float') prop = 'styleFloat';
			if (re.test(prop)) {
				prop = prop.replace(re, function () {
					return arguments[2].toUpperCase();
				});
			}
			return el.currentStyle[prop] ? el.currentStyle[prop] : null;
		}
		return this;
	}
}

//Caculate the width of the scroll bar so css media queries and js widow.width match
function getScrollBarWidth () {
	var inner = document.createElement('p');
	inner.style.width = "100%";
	inner.style.height = "200px";

	var outer = document.createElement('div');
	outer.style.position = "absolute";
	outer.style.top = "0px";
	outer.style.left = "0px";
	outer.style.visibility = "hidden";
	outer.style.width = "200px";
	outer.style.height = "150px";
	outer.style.overflow = "hidden";
	outer.appendChild (inner);

	document.body.appendChild (outer);
	var w1 = inner.offsetWidth;
	outer.style.overflow = 'scroll';
	var w2 = inner.offsetWidth;
	if (w1 == w2) w2 = outer.clientWidth;

	document.body.removeChild (outer);

	return (w1 - w2);
};

// as the page loads, call these scripts
jQuery(document).ready(function($) {

	/*
	Responsive jQuery is a tricky thing.
	There's a bunch of different ways to handle
	it, so be sure to research and find the one
	that works for you best.
	*/

	/* getting viewport width */
	var responsive_viewport = $(window).width() + getScrollBarWidth();

	// RESPONSIVE NAV
	var menu = $('#main-navigation > ul');
	$('.menu-button').on('click', function(e) {
		e.preventDefault();
		$(this).next('ul').slideToggle();
		$(this).toggleClass('menu-open');
	});

	$(window).resize(function() {
		responsive_viewport = $(window).width() + getScrollBarWidth();
		if(responsive_viewport >= 768 && menu.is(':hidden')) {
			menu.removeAttr('style');
		}else if(responsive_viewport < 768 && !menu.is(':hidden')){
			menu.css('display','none');
		}
	});
	// END RESPONSIVE NAV

	// make sure font stays on refesh in ie7 & 8
	/* Uncomment this if you are using custom fonts, not needed if you arn't
	if ($("html").hasClass("lt-ie9")) {
		$("#scaffolding-stylesheet-css")[0].href = $("#scaffolding-stylesheet-css")[0].href;
	}
	*/

	/* if is below 481px */
	if (responsive_viewport < 481) {
		//if mobile device scroll to the content on page load
		var new_position = jQuery('#main').offset();
		if (typeof new_position != 'undefined'){
			jQuery('html, body').animate({scrollTop:new_position.top}, 2000);
		}
	} /* end smallest screen */

	/* if is smaller than 481px */
	if (responsive_viewport < 481) {}
	/* if is larger than 481px */
	if (responsive_viewport > 481){}

	/* if is smaller to 768px */
	if (responsive_viewport < 768) {
		menu.css({"display":"none"});
	}
	/* if is larger to 768px */
	if (responsive_viewport > 768) {
		/* load gravatars */
		$('.comment img[data-gravatar]').each(function(){
			$(this).attr('src',$(this).attr('data-gravatar'));
		});
	}

	/* off the bat smaller screen actions */
	if (responsive_viewport < 1030) {}
	/* off the bat large screen actions */
	if (responsive_viewport > 1030) {}

}); /* end of as page load scripts */


/*! A fix for the iOS orientationchange zoom bug.
 Script by @scottjehl, rebound by @wilto.
 MIT License.
*/
(function(w){
	// This fix addresses an iOS bug, so return early if the UA claims it's something else.
	if( !( /iPhone|iPad|iPod/.test( navigator.platform ) && navigator.userAgent.indexOf( "AppleWebKit" ) > -1 ) ) {
		return;
	}
	var doc = w.document;
	if( !doc.querySelector ) {
		return;
	}
	var meta = doc.querySelector( "meta[name=viewport]" ),
		initialContent = meta && meta.getAttribute( "content" ),
		disabledZoom = initialContent + ",maximum-scale=1",
		enabledZoom = initialContent + ",maximum-scale=10",
		enabled = true,
		x, y, z, aig;
	if( !meta ) {
		return;
	}
	function restoreZoom() {
		meta.setAttribute( "content", enabledZoom );
		enabled = true;
	}
	function disableZoom() {
		meta.setAttribute( "content", disabledZoom );
		enabled = false;
	}
	function checkTilt( e ) {
		aig = e.accelerationIncludingGravity;
		x = Math.abs( aig.x );
		y = Math.abs( aig.y );
		z = Math.abs( aig.z );
		// If portrait orientation and in one of the danger zones
		if( !w.orientation && ( x > 7 || ( ( z > 6 && y < 8 || z < 8 && y > 6 ) && x > 5 ) ) ) {
			if( enabled ){
				disableZoom();
			}
		}
		else if( !enabled ) {
			restoreZoom();
		}
	}
	w.addEventListener( "orientationchange", restoreZoom, false );
	w.addEventListener( "devicemotion", checkTilt, false );
})( this );
