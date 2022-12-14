<?php
/**
 * Initiating Theme
 *
 * @package Scaffolding
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
	add_action( 'widgets_init', 'scaffolding_register_sidebars' );                    // adding sidebars to WordPress (these are created in functions.php).
	add_filter( 'excerpt_more', 'scaffolding_excerpt_more' );                         // cleaning up excerpt.
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

/**
 * Add rel and title attribute to next pagination link
 *
 * @since Scaffolding 1.0
 *
 * @param string $attr Previous "Next Page" rel attribute.
 * @return string New "Next Page rel attribute.
 */
function scaffolding_get_next_posts_link_attributes( $attr ) {
	$attr = 'rel="next" title="View the Next Page"';
	return $attr;
}
add_filter( 'next_posts_link_attributes', 'scaffolding_get_next_posts_link_attributes' );

/**
 * Add rel and title attribute to prev pagination link
 *
 * @since Scaffolding 1.0
 *
 * @param string $attr Previous "Previous Page" rel attribute.
 * @return string New "Previous Page rel attribute.
 */
function scaffolding_get_previous_posts_link_attributes( $attr ) {
	$attr = 'rel="prev" title="View the Previous Page"';
	return $attr;
}
add_filter( 'previous_posts_link_attributes', 'scaffolding_get_previous_posts_link_attributes' );

/**
 * Add page title attribute to wp_list_pages link tags
 *
 * @since Scaffolding 1.0
 *
 * @param string $output Output from wp_list_pages.
 * @return string Modified output.
 */
function scaffolding_wp_list_pages_filter( $output ) {
	$output = preg_replace( '/<a(.*)href="([^"]*)"(.*)>(.*)<\/a>/', '<a$1 title="$4" href="$2"$3>$4</a>', $output );
	return $output;
}
add_filter( 'wp_list_pages', 'scaffolding_wp_list_pages_filter' );

/**
 * Custom login page CSS
 *
 * @since Scaffolding 1.0
 */
function scaffolding_login_css() {
	$login_css_version = filemtime( get_theme_file_path( '/css/login.css' ) );
	wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/css/login.css', array(), $login_css_version, 'screen' );
}
add_action( 'login_enqueue_scripts', 'scaffolding_login_css' );

/**
 * Change logo link from wordpress.org to your site
 *
 * @since Scaffolding 1.0
 */
function scaffolding_login_url() {
	return home_url();
}
add_filter( 'login_headerurl', 'scaffolding_login_url' );

/**
 * Change the link text of the header logo to show your site name
 *
 * @since Scaffolding 1.0
 */
function scaffolding_login_title() {
	return get_option( 'blogname' );
}
add_filter( 'login_headertext', 'scaffolding_login_title' );
