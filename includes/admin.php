<?php
/**
 * Admin Customizations
 *
 * @package scaffolding
 */

/**
 * Disable Default Dashboard Widgets
 *
 * @since Scaffolding 1.0
 */
function scaffolding_disable_default_dashboard_widgets() {
	global $wp_meta_boxes;
	// phpcs:ignore Squiz.PHP.CommentedOutCode.Found
	// unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity'] );        // Activity.
	// unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );       // At a Glance.
	// unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments'] ); // Recent Comments.
	// unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'] );  // Incoming Links.
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'] );
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'] );
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'] );
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );          // Quick Press.
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts'] );        // Recent Drafts.
	// unset( $wp_meta_boxes['dashboard']['normal']['core']['bbp-dashboard-right-now'] );   // BBPress.
	// unset( $wp_meta_boxes['dashboard']['normal']['core']['yoast_db_widget''] );          // Yoast SEO.
	// unset( $wp_meta_boxes['dashboard']['normal']['core']['rg_forms_dashboard'] );        // Gravity Forms.
}
add_action( 'wp_dashboard_setup', 'scaffolding_disable_default_dashboard_widgets', 999 );

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

/**
 * Custom login page CSS
 *
 * @since Scaffolding 1.0
 */
function scaffolding_login_css() {
	$login_css_version = filemtime( get_theme_file_path( '/dist/css/login.css' ) );
	wp_enqueue_style( 'scaffolding-login', get_stylesheet_directory_uri() . '/dist/css/login.css', array(), $login_css_version, 'screen' );
}
add_action( 'login_enqueue_scripts', 'scaffolding_login_css' );
