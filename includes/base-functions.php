<?php
/**
 * Scaffolding Stock Functions
 *
 * Included stock functions. Custom functions go in functions.php to facilitate future updates if necessary.
 *
 * @link https://github.com/hallme/scaffolding
 * @link http://scaffolding.io
 * @link https://codex.wordpress.org/Theme_Development
 *
 * @package Scaffolding
 *
 * Table of Contents
 *
 * 1.0 - Initiating Scaffolding
 * 2.0 - Cleaning Up wp_head
 * 3.0 - Front-End Improvements
 *    3.1 - Add attributes to next post link
 *    3.2 - Add attributes to previous post link
 *    3.3 - Add title attribute to wp_list_pages
 * 4.0 - Custom Login
 *    4.1 - Add styles to login page
 *    4.2 - Change logo link
 *    4.3 - Change alt attribute on logo
 * 5.0 - Visitor UX Functions
 *    5.1 - Remove p tags from images
 */

/************************************
 * 1.0 - INITIATING SCAFFOLDING
 ************************************/

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
	scaffolding_add_image_sizes();                                                    // add additional image sizes.
	scaffolding_theme_support();                                                      // launching this stuff after theme setup.
	add_action( 'widgets_init', 'scaffolding_register_sidebars' );                    // adding sidebars to WordPress (these are created in functions.php).
	add_filter( 'the_content', 'scaffolding_filter_ptags_on_images' );                // cleaning up random code around images.
	add_filter( 'excerpt_more', 'scaffolding_excerpt_more' );                         // cleaning up excerpt.
}
add_action( 'after_setup_theme', 'scaffolding_build', 16 );


/************************************
 * 2.0 - CLEANING UP WP_HEAD
 *************************************/

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

	// Support for custom headers.
	add_theme_support(
		'custom-header',
		array(
			'default-image'          => '%s/images/headers/default.jpg',
			'random-default'         => false,
			'width'                  => 1800,    // Make sure to set this.
			'height'                 => 350,     // Make sure to set this.
			'flex-height'            => false,
			'flex-width'             => false,
			'default-text-color'     => 'ffffff',
			'header-text'            => false,
			'uploads'                => true,
			'wp-head-callback'       => 'scaffolding_custom_headers_callback', // callback function.
			'admin-head-callback'    => '',
			'admin-preview-callback' => '',
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

	/* // phpcs:ignore Squiz.PHP.CommentedOutCode.Found
	// Feature Currently Disabled
	// WP custom background (thx to @bransonwerner for update)
	add_theme_support( 'custom-background', array(
		'default-color'           => '',      // background color default (dont add the #)
		'default-image'           => '',      // background image default
		'wp-head-callback'        => '_custom_background_cb',
		'admin-head-callback'     => '',
		'admin-preview-callback'  => '',
	) );
	*/

	/* // phpcs:ignore Squiz.PHP.CommentedOutCode.Found
	// Feature Currently Disabled
	// Support for post formats
	add_theme_support( 'post-formats', array(
			'aside',            // title less blurb
			'gallery',          // gallery of images
			'link',             // quick link to other site
			'image',            // an image
			'quote',            // a quick quote
			'status',           // a Facebook like status update
			'video',            // video
			'audio',            // audio
			'chat',             // chat transcript
	) );
	*/

	// Support for menus.
	add_theme_support( 'menus' );

	// Register WP3+ menus.
	register_nav_menus(
		array(
			'main-nav'   => __( 'Main Menu', 'scaffolding' ),   // main nav in header.
			'footer-nav' => __( 'Footer Menu', 'scaffolding' ), // secondary nav in footer.
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

	// Add styles for use in visual editor.
	add_editor_style( 'css/editor-styles.css' );
	add_editor_style( 'css/libs/fontawesome/fontawesome-all.css' );

}


/************************************
 * 3.0 - FRONT-END IMPROVEMENTS
 *    3.1 - Add attributes to next post link
 *    3.2 - Add attributes to previous post link
 *    3.3 - Add title attribute to wp_list_pages
 *************************************/

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


/************************************
 * 4.0 - CUSTOM LOGIN
 *    4.1 - Add styles to login page
 *    4.2 - Change logo link
 *    4.3 - Change alt attribute on logo
 *************************************/

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


/************************************
 * 5.0 - VISITOR/USER UX FUNCTIONS
 *    5.1 - Remove p tags from images
 *************************************/

/**
 * Remove the p from around imgs
 *
 * This function is called in scaffolding_build().
 *
 * @link http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/
 *
 * @since Scaffolding 1.0
 *
 * @param string $content Content to be modified.
 * @return string Modified content
 */
function scaffolding_filter_ptags_on_images( $content ) {
	return preg_replace( '/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content );
}
