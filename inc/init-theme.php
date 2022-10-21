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
