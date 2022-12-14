<?php
/**
 * Initiating Theme
 *
 * @package scaffolding
 */

/**
 * Scaffolding Setup
 *
 * All of these functions are defined below or in functions.php.
 *
 * @since Scaffolding 1.0
 */
function scaffolding_build() {
	add_action( 'init', 'scaffolding_head_cleanup' );                                 // launching operation cleanup.
	add_filter( 'the_generator', 'scaffolding_rss_version' );                         // remove WP version from RSS.
	add_filter( 'wp_head', 'scaffolding_remove_wp_widget_recent_comments_style', 1 ); // remove pesky injected css for recent comments widget.
	add_action( 'wp_head', 'scaffolding_remove_recent_comments_style', 1 );           // clean up comment styles in the head.
	scaffolding_theme_support();                                                      // launching this stuff after theme setup.
}
add_action( 'after_setup_theme', 'scaffolding_build', 16 );

/**
 * Clean up wp_head() output
 *
 * This function is called in scaffolding_build().
 *
 * @since Scaffolding 1.0
 */
function scaffolding_head_cleanup() {
	// phpcs:ignore Squiz.PHP.CommentedOutCode.Found
	// remove_action( 'wp_head', 'feed_links_extra', 3 );                 // category feeds.
	// remove_action( 'wp_head', 'feed_links', 2 );                       // post and comment feeds.
	remove_action( 'wp_head', 'rsd_link' );                               // EditURI link.
	remove_action( 'wp_head', 'wlwmanifest_link' );                       // windows live writer.
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); // links for adjacent posts.
	remove_action( 'wp_head', 'wp_generator' );                           // WP version.
}

/**
 * Remove WP version from RSS
 *
 * This function is called in scaffolding_build().
 *
 * @since Scaffolding 1.0
 */
function scaffolding_rss_version() {
	return '';
}

/**
 * Remove injected CSS for recent comments widget
 *
 * This function is called in scaffolding_build().
 *
 * @since Scaffolding 1.0
 */
function scaffolding_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}

/**
 * Remove injected CSS from recent comments widget
 *
 * This function is called in scaffolding_build().
 *
 * @since Scaffolding 1.0
 */
function scaffolding_remove_recent_comments_style() {
	global $wp_widget_factory;
	if ( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) ) {
		remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
	}
}

/**
 * Add WP3+ functions and theme support
 *
 * Function called in scaffolding_build() in base-functions.php.
 *
 * @see scaffolding_custom_headers_callback
 * @since Scaffolding 1.0
 */
function scaffolding_theme_support() {

	// Make theme available for translation.
	load_theme_textdomain( 'scaffolding', get_template_directory() . '/languages' );

	// Support for RSS.
	add_theme_support( 'automatic-feed-links' );

	// Switch default core markup for search form, comment form, and comments to output valid HTML5.
	add_theme_support(
		'html5',
		array(
			'caption',
			'comment-list',
			'comment-form',
			'gallery',
			'navigation-widgets',
			'search-form',
			'script',
			'style',
		)
	);

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a hard-coded <title> tag in the document head, and expect WordPress to provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	* Enable support for Post Thumbnails on posts and pages.
	*
	* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	*/
	add_theme_support( 'post-thumbnails' );

	/*
	 * Support for custom logo.
	 * @link https://developer.wordpress.org/themes/functionality/custom-logo/.
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 100,   // Make sure to set this.
			'width'       => 216,   // Make sure to set this.
			'flex-width'  => false,
			'flex-height' => false,
		)
	);

	/**
	 * Gutenberg Support
	 *
	 * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/.
	 */

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for responsive embedded content.
	add_theme_support( 'responsive-embeds' );

	// Enable editor styles for use in Gutenberg and classic editors.
	add_theme_support( 'editor-styles' );

}

// Set up the content width value based on the theme's design.
if ( ! isset( $content_width ) ) {
	$content_width = 1170; // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
}

/**
 * Adjust content_width value for image attachment template
 *
 * @since Scaffolding 1.0
 */
function scaffolding_content_width() {
	if ( is_attachment() && wp_attachment_is_image() ) {
		$GLOBALS['content_width'] = 810; // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	}
}
add_action( 'template_redirect', 'scaffolding_content_width' );

/**
 * Enqueue scripts and styles in wp_head() and wp_footer()
 *
 * This function is called in scaffolding_build() in base-functions.php.
 *
 * @since Scaffolding 1.0
 */
function scaffolding_scripts_and_styles() {

	/**
	 * Theme Styles
	 */

	// Main stylesheet.
	$theme_css_version = filemtime( get_theme_file_path( '/css/style.css' ) );
	wp_enqueue_style( 'scaffolding-stylesheet', get_stylesheet_directory_uri() . '/css/style.css', array(), $theme_css_version );

	/**
	 * Third-Party Libraries
	 */

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
