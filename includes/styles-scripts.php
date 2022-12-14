<?php
/**
 * Styles & Scripts
 *
 * @package scaffolding
 */

/**
 * Enqueue scripts and styles in wp_head() and wp_footer()
 *
 * This function is called in scaffolding_build() in base-functions.php.
 *
 * @since Scaffolding 1.0
 */
function scaffolding_scripts_and_styles() {

	/**
	 * Fonts
	 */

	// Font Awesome (icon set) - https://fontawesome.com/.
	// this may be updated to include only specific icon sets: brands, solid, regular.
	wp_enqueue_style( 'scaffolding-fontawesome-all', get_stylesheet_directory_uri() . '/css/libs/fontawesome/all.css', array(), '5.15.1' );

	/**
	 * Theme Styles
	 */

	// Main stylesheet.
	$theme_css_version = filemtime( get_theme_file_path( '/css/style.css' ) );
	wp_enqueue_style( 'scaffolding-stylesheet', get_stylesheet_directory_uri() . '/css/style.css', array(), $theme_css_version );

	/**
	 * Third-Party Libraries
	 */

	// Modernizr - http://modernizr.com/.
	// update this to include only what you need to test.
	wp_enqueue_script( 'scaffolding-modernizr', get_stylesheet_directory_uri() . '/libs/js/custom-modernizr.min.js', array(), '3.6.0', false );

	// Retina.js - http://imulus.github.io/retinajs/.
	wp_enqueue_script( 'scaffolding-retinajs', get_stylesheet_directory_uri() . '/libs/js/retina.min.js', array(), '2.1.2', true );

	// Doubletaptogo (dropdown nav tapping for touch devices) - https://github.com/dachcom-digital/jquery-doubletaptogo.
	wp_enqueue_script( 'scaffolding-doubletaptogo-js', get_stylesheet_directory_uri() . '/libs/js/jquery.dcd.doubletaptogo.min.js', array( 'jquery' ), '3.0.2', true );

	// Magnific Popup (lightbox) - http://dimsemenov.com/plugins/magnific-popup/.
	wp_enqueue_script( 'scaffolding-magnific-popup-js', get_stylesheet_directory_uri() . '/libs/js/jquery.magnific-popup.min.js', array( 'jquery' ), '1.1.0', true );

	// SelectWoo - https://github.com/woocommerce/selectWoo.
	wp_enqueue_script( 'scaffolding-selectwoo', get_stylesheet_directory_uri() . '/libs/js/selectWoo.full.min.js', array( 'jquery' ), '1.0.8', true );

	// Comment reply script for threaded comments.
	if ( is_singular() && comments_open() && ( 1 === get_option( 'thread_comments' ) ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/**
	 * Theme Scripts
	 */

	// Add Scaffolding scripts file in the footer.
	$theme_js_version = filemtime( get_theme_file_path( '/js/scripts.js' ) );
	wp_enqueue_script( 'scaffolding-js', get_stylesheet_directory_uri() . '/js/scripts.js', array( 'jquery' ), $theme_js_version, true );

	// Navigation scripts.
	$theme_nav_js_version = filemtime( get_theme_file_path( '/js/navigation.js' ) );
	wp_enqueue_script( 'scaffolding-nav', get_stylesheet_directory_uri() . '/js/navigation.js', array( 'jquery', 'scaffolding-js' ), $theme_nav_js_version, true );

	// Responsive iFrames, Embeds and Objects - http://css-tricks.com/NetMag/FluidWidthVideo/Article-FluidWidthVideo.php.
	// Fallback for elements outside the Gutenberg blocks (ie. using the Classic Editor).
	wp_enqueue_script( 'scaffolding-responsive-iframes', get_stylesheet_directory_uri() . '/js/responsive-iframes.js', array( 'jquery' ), '1.0.0', true );

}
add_action( 'wp_enqueue_scripts', 'scaffolding_scripts_and_styles' );
