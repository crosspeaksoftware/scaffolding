<?php
/*
Author: Hall Internet Marketing
URL: https://github.com/hallme/scaffolding

All stock functions used on every scaffolding site live here.
Custom functions go in functions.php to facilitate future updates if necessary.
*/

/******************************************
TABLE OF CONTENTS

1. INITIATING SCAFFOLDING
2. CLEANING UP WP_HEAD
3. SCRIPTS & ENQUEUEING
4. 

******************************************/

/*********************
INITIATING SCAFFOLDING
*********************/
add_action('after_setup_theme','scaffolding_build', 16);

function scaffolding_build() {

	add_action('init', 'scaffolding_head_cleanup');										// launching operation cleanup
	add_filter('the_generator', 'scaffolding_rss_version');								// remove WP version from RSS
	add_filter( 'wp_head', 'scaffolding_remove_wp_widget_recent_comments_style', 1 );	// remove pesky injected css for recent comments widget
	add_action('wp_head', 'scaffolding_remove_recent_comments_style', 1);				// clean up comment styles in the head
	add_filter('gallery_style', 'scaffolding_gallery_style');							// clean up gallery output in wp
	add_action('wp_enqueue_scripts', 'scaffolding_scripts_and_styles', 999);			// enqueue base scripts and styles

	scaffolding_theme_support();														// launching this stuff after theme setup
	add_action( 'widgets_init', 'scaffolding_register_sidebars' );						// adding sidebars to Wordpress (these are created in functions.php)
	add_filter( 'get_search_form', 'scaffolding_wpsearch' ); 							// adding the scaffolding search form (created in functions.php)
	add_filter('the_content', 'scaffolding_filter_ptags_on_images'); 					// cleaning up random code around images
	add_filter('excerpt_more', 'scaffolding_excerpt_more');								// cleaning up excerpt
}

/*********************
CLEANING UP WP_HEAD
*********************/

function scaffolding_head_cleanup() {
	
	// remove_action( 'wp_head', 'feed_links_extra', 3 );						// category feeds
	// remove_action( 'wp_head', 'feed_links', 2 );								// post and comment feeds
	remove_action( 'wp_head', 'rsd_link' );										// EditURI link
	remove_action( 'wp_head', 'wlwmanifest_link' );								// windows live writer
	remove_action( 'wp_head', 'index_rel_link' );								// index link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );					// previous link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );					// start link
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );		// links for adjacent posts
	remove_action( 'wp_head', 'wp_generator' );									// WP version
	add_filter( 'style_loader_src', 'scaffolding_remove_wp_ver_css_js', 9999 );	// remove WP version from css	
	add_filter( 'script_loader_src', 'scaffolding_remove_wp_ver_css_js', 9999 );// remove WP version from scripts
}

// remove WP version from RSS
function scaffolding_rss_version() { return ''; }

// remove WP version from scripts
function scaffolding_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}

// remove injected CSS for recent comments widget
function scaffolding_remove_wp_widget_recent_comments_style() {
	if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
		remove_filter('wp_head', 'wp_widget_recent_comments_style' );
	}
}

// remove injected CSS from recent comments widget
function scaffolding_remove_recent_comments_style() {
	global $wp_widget_factory;
	if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
	}
}

// remove injected CSS from gallery
function scaffolding_gallery_style($css) {
	return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}

/*********************
SCRIPTS & ENQUEUEING
*********************/
function scaffolding_scripts_and_styles() {
	global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way
	if (!is_admin()) {

		// modernizr (without media query polyfill)
		wp_register_script( 'scaffolding-modernizr', 'http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js', array(), '', false );

		// register main stylesheet
		wp_register_style( 'scaffolding-stylesheet', get_stylesheet_directory_uri() . '/css/style.css', array(), '', 'all' );

		// ie-only style sheet
		wp_register_style( 'scaffolding-ie-only', get_stylesheet_directory_uri() . '/css/ie.css', array(), '' );

		// comment reply script for threaded comments
		if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
			wp_enqueue_script( 'comment-reply' );
		}

		//adding scripts file in the footer
		wp_register_script( 'scaffolding-js', get_stylesheet_directory_uri() . '/js/scripts.js', array( 'jquery' ), '', true );

		// enqueue styles and scripts
		wp_enqueue_script( 'scaffolding-modernizr' );
		wp_enqueue_style( 'scaffolding-stylesheet' );
		wp_enqueue_style('scaffolding-ie-only');

		$wp_styles->add_data( 'scaffolding-ie-only', 'conditional', 'lt IE 9' ); // add conditional wrapper around ie stylesheet

		// RECOMMENDATION: Load jQuery via Google CDN using http://wordpress.org/plugins/use-google-libraries/
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'scaffolding-js' );

	}
}