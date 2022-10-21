<?php
/**
 * Initiating Scaffolding Theme
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

	// Support for thumbnails.
	add_theme_support( 'post-thumbnails' );

	// Support for RSS.
	add_theme_support( 'automatic-feed-links' );

	// Support for custom logo.
	// @link https://developer.wordpress.org/themes/functionality/custom-logo/.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 100,   // Make sure to set this.
			'width'       => 216,   // Make sure to set this.
			'flex-width'  => false,
			'flex-height' => false,
		)
	);

	// HTML5.
	add_theme_support(
		'html5',
		array(
			'navigation-widgets',
			'comment-list',
			'comment-form',
			'search-form',
			'gallery',
			'caption',
		)
	);

	// Title Tag.
	add_theme_support( 'title-tag' );

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

/**
 * Add additional image sizes
 *
 * Function called in scaffolding_build() in base-functions.php.
 * Ex. add_image_size( 'scaffolding-thumb-600', 600, 150, true );
 *
 * @since Scaffolding 1.0
 */
function scaffolding_add_image_sizes() {}
