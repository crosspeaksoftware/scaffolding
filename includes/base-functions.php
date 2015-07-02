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
 * @since Scaffolding 1.0
 *
 * Table of Contents
 *
 * 1.0 - Initiating Scaffolding
 * 2.0 - Cleaning Up wp_head
 * 3.0 - Front-End Improvements
 *    3.1 - Add classes to menus
 *    3.2 - Add classes to widgets
 *    3.3 - Add classes to posts
 *    3.4 - Add attributes to next post link
 *    3.5 - Add attributes to previous post link
 *    3.6 - Add title attribute to wp_list_pages
 *    3.7 - Allow for blank search
 * 4.0 - Page Navi
 * 5.0 - Client UX Functions
 *    5.1 - Extend user role capabilities
 *    5.2 - Remove powered by WPEngine Widget
 *    5.3 - Remove select admin bar links
 *	  5.4 - Remove theme/plugin editor pages from menu
 * 6.0 - Custom Login
 *    6.1 - Add styles to login page
 *    6.2 - Change logo link
 *    6.3 - Change alt attribute on logo
 * 7.0 - Visitor UX Functions
 *    7.1 - Filter hard coded dimensions on images
 *    7.2 - Remove p tags from images
 *    7.3 - Fix tabindex for Gravity Forms
 *    7.4 - Filter hard coded dimensions on captions
 * 8.0 - Recommended/Required Plugin Activation
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
	add_action( 'init', 'scaffolding_head_cleanup' );                                   // launching operation cleanup
	add_filter( 'the_generator', 'scaffolding_rss_version' );						    // remove WP version from RSS
	add_filter( 'wp_head', 'scaffolding_remove_wp_widget_recent_comments_style', 1 );	// remove pesky injected css for recent comments widget
	add_action( 'wp_head', 'scaffolding_remove_recent_comments_style', 1 );				// clean up comment styles in the head
	add_filter( 'gallery_style', 'scaffolding_gallery_style' );							// clean up gallery output in wp
	add_action( 'wp_enqueue_scripts', 'scaffolding_scripts_and_styles', 999 );			// enqueue base scripts and styles
	//scaffolding_add_image_sizes();													// add additional image sizes
	scaffolding_theme_support();														// launching this stuff after theme setup
	add_action( 'widgets_init', 'scaffolding_register_sidebars' );						// adding sidebars to Wordpress (these are created in functions.php)
	add_filter( 'get_search_form', 'scaffolding_wpsearch' ); 							// adding the scaffolding search form (created in functions.php)
	add_filter( 'the_content', 'scaffolding_filter_ptags_on_images' ); 					// cleaning up random code around images
	add_filter( 'excerpt_more', 'scaffolding_excerpt_more' );						    // cleaning up excerpt
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
	//remove_action( 'wp_head', 'feed_links_extra', 3 );						        // category feeds
	//remove_action( 'wp_head', 'feed_links', 2 );								        // post and comment feeds
	remove_action( 'wp_head', 'rsd_link' );										        // EditURI link
	remove_action( 'wp_head', 'wlwmanifest_link' );								        // windows live writer
	remove_action( 'wp_head', 'index_rel_link' );								        // index link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );					        // previous link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );					        // start link
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );		        // links for adjacent posts
	remove_action( 'wp_head', 'wp_generator' );									        // WP version
	add_filter( 'style_loader_src', 'scaffolding_remove_wp_ver_css_js', 9999 );	        // remove WP version from css
	add_filter( 'script_loader_src', 'scaffolding_remove_wp_ver_css_js', 9999 );        // remove WP version from scripts
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
 * Remove WP version from scripts
 *
 * This function is called in scaffolding_head_cleanup().
 *
 * @since Scaffolding 1.0
 */
function scaffolding_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
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
 * Remove injected CSS from gallery
 *
 * This function is called in scaffolding_build().
 *
 * @since Scaffolding 1.0
 */
function scaffolding_gallery_style( $css ) {
	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}


/************************************
 * 3.0 - FRONT-END IMPROVEMENTS
 *    3.1 - Add classes to menus
 *    3.2 - Add classes to widgets
 *    3.3 - Add classes to posts
 *    3.4 - Add attributes to next post link
 *    3.5 - Add attributes to previous post link
 *    3.6 - Add title attribute to wp_list_pages
 *    3.7 - Allow for blank search
*************************************/

/**
 * Add first and last menu classes
 *
 * This now works with nested uls.
 *
 * @since Scaffolding 1.0
 */
function scaffolding_first_last_menu_classes( $objects, $args ) {

    // Add first/last classes to nested menu items.
    $ids        = array();
    $parent_ids = array();
    $top_ids    = array();

	if ( ! empty( $objects ) ) {

		foreach ( $objects as $i => $object ) {
			// If there is no menu item parent, store the ID and skip over the object.
			if ( 0 == $object->menu_item_parent ) {
				$top_ids[ $i ] = $object;
				continue;
			}

			// Add first item class to nested menus.
			if ( ! in_array( $object->menu_item_parent, $ids ) ) {
				$objects[ $i ]->classes[] = 'first-item';
				$ids[] = $object->menu_item_parent;
			}

			// If we have just added the first menu item class, skip over adding the ID.
			if ( in_array( 'first-item', $object->classes ) ) {
				continue;
			}

			// Store the menu parent IDs in an array.
			$parent_ids[ $i ] = $object->menu_item_parent;
		}

		// Remove any duplicate values and pull out the last menu item.
		$sanitized_parent_ids = array_unique( array_reverse( $parent_ids, true ) );

		// Loop through the IDs and add the last menu item class to the appropriate objects.
		foreach ( $sanitized_parent_ids as $i => $id ) {
			$objects[ $i ]->classes[] = 'last-item';
		}

		// Finish it off by adding classes to the top level menu items.
		$objects[1]->classes[] = 'first-item'; // We can be assured 1 will be the first item in the menu. :-)
		$keys = array_keys( $top_ids );
		$objects[end( $keys )]->classes[] = 'last-item';

		// Return the menu objects.
		return $objects;
	}
}
add_filter( 'wp_nav_menu_objects', 'scaffolding_first_last_menu_classes', 10, 2 );

/**
 * Add classes on widgets
 *
 * Add first and last classes to dynamic sidebar widgets. Also adds numeric index class for each widget (widget-1, widget-2, etc.)
 *
 * @since Scaffolding 1.0
 */
function scaffolding_widget_classes( $params ) {

	global $my_widget_num; // Global a counter array
	$this_id = $params[0]['id']; // Get the id for the current sidebar we're processing
	$arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets

	if ( ! $my_widget_num ) {// If the counter array doesn't exist, create it
		$my_widget_num = array();
	}

	if ( ! isset( $arr_registered_widgets[ $this_id ] ) || ! is_array( $arr_registered_widgets[ $this_id ] ) ) { // Check if the current sidebar has no widgets
		return $params; // No widgets in this sidebar... bail early.
	}

	if ( isset( $my_widget_num[ $this_id ] ) ) { // See if the counter array has an entry for this sidebar
		$my_widget_num[ $this_id ] ++;
	} else { // If not, create it starting with 1
		$my_widget_num[ $this_id ] = 1;
	}

	$class = 'class="widget-' . $my_widget_num[ $this_id ] . ' '; // Add a widget number class for additional styling options

	if ( 1 == $my_widget_num[ $this_id ] && $my_widget_num[ $this_id ] == count( $arr_registered_widgets[ $this_id ] ) ) { // If this is the first widget
		$class .= 'only-widget ';
	} elseif ( 1 == $my_widget_num[ $this_id ] && $my_widget_num[ $this_id ] != count( $arr_registered_widgets[ $this_id ] ) ) {
		$class .= 'first-widget ';
	} elseif ( $my_widget_num[ $this_id ] == count( $arr_registered_widgets[ $this_id ] ) ) { // If this is the last widget
		$class .= 'last-widget ';
	}

	$params[0]['before_widget'] = str_replace( 'class="', $class, $params[0]['before_widget'] ); // Insert our new classes into "before widget"

	return $params;
}
add_filter( 'dynamic_sidebar_params', 'scaffolding_widget_classes' );

/**
 * Add first and last classes to posts
 *
 * Useful on archive and search pages.
 *
 * @since Scaffolding 1.0
 */
function scaffolding_post_classes( $classes ) {
	global $wp_query;
	if ( 0 == $wp_query->current_post && 1 == $wp_query->post_count ) {
		$classes[] = 'only-post';
	} elseif ( 0 == $wp_query->current_post && 1 != $wp_query->post_count ) {
		$classes[] = 'first-post';
	} elseif ( ( 1 + $wp_query->current_post ) == $wp_query->post_count ) {
		$classes[] = 'last-post';
	}

	return $classes;
}
add_filter( 'post_class', 'scaffolding_post_classes' );

/**
 * Add rel and title attribute to next pagination link
 *
 * @since Scaffolding 1.0
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
 */
function scaffolding_wp_list_pages_filter( $output ) {
	$output = preg_replace( '/<a(.*)href="([^"]*)"(.*)>(.*)<\/a>/', '<a$1 title="$4" href="$2"$3>$4</a>', $output );
	return $output;
}
add_filter( 'wp_list_pages', 'scaffolding_wp_list_pages_filter' );

/**
 * Return the search results page even if the query is empty
 *
 * @link http://vinayp.com.np/how-to-show-blank-search-on-wordpress
 *
 * @since Scaffolding 1.0
 */
function scaffolding_make_blank_search( $query ) {
	if ( ! is_admin() ) {
		global $wp_query;
		if ( isset( $_GET['s'] ) && '' == $_GET['s'] ) {  // if search parameter is blank, do not return false
			$wp_query->set( 's', ' ' );
			$wp_query->is_search = true;
		}
		return $query;
	}
}
add_action( 'pre_get_posts', 'scaffolding_make_blank_search' );


/************************************
 4.0 - PAGE NAVI
 ************************************/

/**
 * Numeric Page Navi
 *
 * This is built into the theme by default. Call it using scaffolding_page_navi().
 *
 * @since Scaffolding 1.0
 */
function scaffolding_page_navi( $before = '', $after = '', $query ) {
	$request           = $query->request;
	$posts_per_page    = intval( get_query_var( 'posts_per_page' ) );
	$paged             = intval( get_query_var( 'paged' ) );
	$numposts          = $query->found_posts;
	$max_page          = $query->max_num_pages;
    
	if ( $numposts <= $posts_per_page ) { 
        return; 
    }
    
	if ( empty( $paged ) || 0 == $paged ) {
		$paged = 1;
	}
    
	$pages_to_show         = 7;
	$pages_to_show_minus_1 = $pages_to_show-1;
	$half_page_start       = floor($pages_to_show_minus_1/2);
	$half_page_end         = ceil($pages_to_show_minus_1/2);
	$start_page            = $paged - $half_page_start;
    
	if ( $start_page <= 0 ) {
		$start_page = 1;
	}
    
	$end_page = $paged + $half_page_end;
    
	if ( ( $end_page - $start_page ) != $pages_to_show_minus_1 ) {
		$end_page = $start_page + $pages_to_show_minus_1;
	}
    
	if ( $end_page > $max_page ) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = $max_page;
	}
    
	if ( $start_page <= 0 ) {
		$start_page = 1;
	}
	
	echo $before.'<nav class="page-navigation"><ol class="scaffolding_page_navi wrap clearfix">'."";
    
	if ( 2 >= $start_page && $pages_to_show < $max_page ) {
		$first_page_text = __( "First", 'scaffolding' );
		echo '<li class="bpn-first-page-link"><a rel="prev" href="'.get_pagenum_link().'" title="'.$first_page_text.'">'.$first_page_text.'</a></li>';
	}
    
	echo '<li class="bpn-prev-link">';
    
	previous_posts_link('<i class="fa fa-angle-double-left"></i> Previous Page');
    
	echo '</li>';
    
	for ( $i = $start_page; $i <= $end_page; $i++ ) {
		if ( $i == $paged ) {
			echo '<li class="bpn-current">' . $i . '</li>';
		} elseif ( $i == ( $paged - 1 ) ) {
			echo '<li><a rel="prev" href="' . get_pagenum_link( $i ) . '" title="View Page ' . $i . '">' . $i . '</a></li>';
		} elseif ( $i == ( $paged + 1 ) ) {
			echo '<li><a rel="next" href="' . get_pagenum_link( $i ) . '" title="View Page ' . $i . '">' . $i . '</a></li>';
		} else {
			echo '<li><a href="' . get_pagenum_link( $i ) . '" title="View Page ' . $i . '">' . $i . '</a></li>';
		}
	}
    
	echo '<li class="bpn-next-link">';
    
	next_posts_link( 'Next Page <i class="fa fa-angle-double-right"></i>' );
    
	echo '</li>';
    
	if ( $end_page < $max_page ) {
		$last_page_text = __( "Last", 'scaffolding' );
		echo '<li class="bpn-last-page-link"><a rel="next" href="' . get_pagenum_link( $max_page ) . '" title="' . $last_page_text . '">' . $last_page_text . '</a></li>';
	}
    
	echo '</ol></nav>' . $after . "";
    
} // end scaffolding_page_navi()


/************************************
 * 5.0 - CLIENT UX FUNCTIONS
 *    5.1 - Extend user role capabilities
 *    5.2 - Remove powered by WPEngine Widget
 *    5.3 - Remove select admin bar links
 *	  5.4 - Remove theme/plugin editor pages from menu
*************************************/

/**
 * Extend user role capabilities
 *
 * Intended for client account. Allows for full Gravity Form access, theme options, and WooCommerce.
 *
 * @since Scaffolding 1.0
 */
function scaffolding_increase_capabilities() {
	$editor = get_role( 'editor' );
	$shop_manager = get_role( 'shop_manager' );

    if ( ! empty( $editor ) ) {
        $editor->add_cap( 'edit_theme_options' );           // Gives editors access to themes, menus, widgets, etc.
        if ( is_plugin_active( 'gravity-forms' ) ) {
            $editor->add_cap( 'gform_full_access' );        // Gives editors access to Gravity Forms
        }
    }

    if ( ! empty( $shop_manager ) ) {
        $shop_manager->add_cap( 'edit_theme_options' );     // Gives shop managers access to themes, menus, widgets, etc.
        if ( is_plugin_active( 'gravity-forms' ) ) {
            $shop_manager->add_cap( 'gform_full_access' );  // Gives shop managers access to Gravity Forms
        }
    }
}
add_action( 'admin_head', 'scaffolding_increase_capabilities' );

// Removes the Powered By WPEngine widget
wp_unregister_sidebar_widget( 'wpe_widget_powered_by' );

/**
 * Remove select admin bar links
 *
 * Helps minimize client confusion. KISS.
 *
 * @since Scaffolding 1.0
 */
function scaffolding_remove_admin_bar_links() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'wp-logo' );       // Remove Wordpress Logo From Admin Bar
	$wp_admin_bar->remove_menu( 'wpseo-menu' );    // Remove SEO from Admin Bar
}
add_action( 'wp_before_admin_bar_render', 'scaffolding_remove_admin_bar_links' );

/**
* Remove plugin and theme editor pages from menu
*
* @since Scaffolding 1.1
*/
function scaffolding_hide_editors() {
	remove_submenu_page( 'themes.php', 'theme-editor.php' );
	remove_submenu_page( 'plugins.php', 'plugin-editor.php' );
}
add_action( 'admin_init', 'scaffolding_hide_editors' );


/************************************
 * 6.0 - CUSTOM LOGIN
 *    6.1 - Add styles to login page
 *    6.2 - Change logo link
 *    6.3 - Change alt attribute on logo
*************************************/

/**
 * Custom login page CSS
 *
 * @since Scaffolding 1.0
 */
function scaffolding_login_css() {
	echo '<link rel="stylesheet" href="' . get_stylesheet_directory_uri() . '/css/login.css">';
}
add_action( 'login_head', 'scaffolding_login_css' );

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
 * Change alt text on logo to show your site name
 *
 * @since Scaffolding 1.0
 */
function scaffolding_login_title() {
    return get_option( 'blogname' );
}
add_filter( 'login_headertitle', 'scaffolding_login_title' );


/************************************
 * 7.0 - VISITOR/USER UX FUNCTIONS
 *    7.1 - Filter hard coded dimensions on images
 *    7.2 - Remove p tags from images
 *    7.3 - Fix tabindex for Gravity Forms
 *    7.4 - Filter hard coded dimensions on captions
*************************************/

/**
 * Filter out hard-coded dimensions on all images in WordPress
 *
 * @link https://gist.github.com/4557917
 *
 * @since Scaffolding 1.0
 */
function scaffolding_remove_img_dimensions( $html ) {
	// Loop through all <img> tags
	if ( preg_match( '/<img[^>]+>/ims', $html, $matches ) ) {
		foreach ( $matches as $match ) {
			// Replace all occurences of width/height
			$clean = preg_replace( '/(width|height)=["\'\d%\s]+/ims', "", $match );
			// Replace with result within html
			$html = str_replace( $match, $clean, $html );
		}
	}
	return $html;
}
add_filter( 'post_thumbnail_html', 'scaffolding_remove_img_dimensions', 10 );
add_filter( 'get_avatar','scaffolding_remove_img_dimensions', 10 );
/* Currently commented out so clients can still edit image sizes in the editor
add_filter( 'the_content', 'scaffolding_remove_img_dimensions', 10 ); */

/**
 * Remove the p from around imgs
 *
 * This function is called in scaffolding_build().
 *
 * @link http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/
 *
 * @since Scaffolding 1.0
 */
function scaffolding_filter_ptags_on_images( $content ){
	return preg_replace( '/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content );
}

/**
 * Fix Gravity Form Tabindex Conflicts
 *
 * @link http://gravitywiz.com/2013/01/28/fix-gravity-form-tabindex-conflicts/
 *
 * @since Scaffolding 1.0
 */
function scaffolding_gform_tabindexer() {
	$starting_index = 1000; // if you need a higher tabindex, update this number
	return GFCommon::$tab_index >= $starting_index ? GFCommon::$tab_index : $starting_index;
}
add_filter( 'gform_tabindex', 'scaffolding_gform_tabindexer' );

/**
 * Filter out hard-coded width, height attributes on all captions (wp-caption class)
 *
 * @since Scaffolding 1.0
 */
function scaffolding_fix_img_caption_shortcode( $attr, $content = null ) {
	if ( ! isset( $attr['caption'] ) ) {
		if ( preg_match( '#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches ) ) {
			$content = $matches[1];
			$attr['caption'] = trim( $matches[2] );
		}
	}
	$output = apply_filters( 'img_caption_shortcode', '', $attr, $content );
	if ( $output != '' ) return $output;
	extract( shortcode_atts( array(
		'id' => '',
		'align' => 'alignnone',
		'width' => '',
		'caption' => ''
	), $attr ) );
	if ( 1 > (int) $width || empty( $caption ) ) return $content;
	if ( $id ) $id = 'id="' . esc_attr( $id ) . '" ';
	return '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . '" >' . do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '</p></div>';
}
add_shortcode( 'wp_caption', 'scaffolding_fix_img_caption_shortcode' );
add_shortcode( 'caption', 'scaffolding_fix_img_caption_shortcode' );


/************************************
 * 8.0 RECOMMENDED/REQUIRED PLUGIN ACTIVATION
 ************************************/

if ( current_user_can( 'install_plugins' ) ) :

/**
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.5.0-alpha
 * @author     Thomas Griffin
 * @author     Gary Jones
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/thomasgriffin/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once ( SCAFFOLDING_INCLUDE_PATH.'class-tgm-plugin-activation.php' );

add_action( 'tgmpa_register', 'scaffolding_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function scaffolding_register_required_plugins() {

	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// This is an example of how to include a plugin pre-packaged with a theme.
		/*
		array(
			'name'               => 'TGM Example Plugin', // The plugin name.
			'slug'               => 'tgm-example-plugin', // The plugin slug (typically the folder name).
			'source'             => get_stylesheet_directory() . '/lib/plugins/tgm-example-plugin.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
		),
		*/

		// This is an example of how to include a plugin from an arbitrary external source in your theme.
		/*
		array(
			'name'         => 'TGM New Media Plugin', // The plugin name.
			'slug'         => 'tgm-new-media-plugin', // The plugin slug (typically the folder name).
			'source'       => 'https://s3.amazonaws.com/tgm/tgm-new-media-plugin.zip', // The plugin source.
			'required'     => true, // If false, the plugin is only 'recommended' instead of required.
			'external_url' => 'https://github.com/thomasgriffin/New-Media-Image-Uploader', // If set, overrides default API URL and points to an external URL.
		),
		*/

		// This is an example of how to include a plugin from a GitHub repository in your theme.
		// This presumes that the plugin code is based in the root of the GitHub repository
		// and not in a subdirectory ('/src') of the repository.
		/*
		array(
			'name'      => 'Adminbar Link Comments to Pending',
			'slug'      => 'adminbar-link-comments-to-pending',
			'source'    => 'https://github.com/jrfnl/WP-adminbar-comments-to-pending/archive/master.zip',
			'required'  => false,
		),
		*/

		// Include a plugin from the WordPress Plugin Repository.
		array(
			'name' 		=> 'Advanced Custom Fields', // http://wordpress.org/plugins/codepress-admin-columns/
			'slug' 		=> 'advanced-custom-fields',
			'required' 	=> false
		),

		array(
			'name' 		=> 'Codepress Admin Columns', // http://wordpress.org/plugins/codepress-admin-columns/
			'slug' 		=> 'codepress-admin-columns',
			'required' 	=> false
		),

		array(
			'name'		=> 'Mailgun for WordPress', // http://wordpress.org/plugins/mailgun/
			'slug'		=> 'mailgun',
			'required'	=> false
		),

		array(
			'name'		=> 'Relevanssi', // http://wordpress.org/plugins/relevanssi/
			'slug'		=> 'relevanssi',
			'required'	=> false
		),

		array(
			'name'		=> 'WordPress SEO', // http://wordpress.org/plugins/wordpress-seo/
			'slug'		=> 'wordpress-seo',
			'required'	=> false
		),

		array(
			'name'		=> 'SEO Editor', // http://wordpress.org/plugins/seo-editor/
			'slug'		=> 'seo-editor',
			'required'	=> false
		)

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are wrapped in a sprintf(), so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to pre-packaged plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'scaffolding' ),
			'menu_title'                      => __( 'Install Plugins', 'scaffolding' ),
			'installing'                      => __( 'Installing Plugin: %s', 'scaffolding' ), // %s = plugin name.
			'oops'                            => __( 'Something went wrong with the plugin API.', 'scaffolding' ),
			'notice_can_install_required'     => _n_noop(
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'scaffolding'
			), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop(
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'scaffolding'
			), // %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop(
				'Sorry, but you do not have the correct permissions to install the %s plugin.',
				'Sorry, but you do not have the correct permissions to install the %s plugins.',
				'scaffolding'
			), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop(
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'scaffolding'
			), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop(
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'scaffolding'
			), // %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop(
				'Sorry, but you do not have the correct permissions to activate the %s plugin.',
				'Sorry, but you do not have the correct permissions to activate the %s plugins.',
				'scaffolding'
			), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop(
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'scaffolding'
			), // %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop(
				'Sorry, but you do not have the correct permissions to update the %s plugin.',
				'Sorry, but you do not have the correct permissions to update the %s plugins.',
				'scaffolding'
			), // %1$s = plugin name(s).
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'scaffolding'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'scaffolding'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'scaffolding' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'scaffolding' ),
			'complete'                        => __( 'All plugins installed and activated successfully. %s', 'scaffolding' ), // %s = dashboard link.
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'scaffolding' ),

			'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		)
	);

	tgmpa( $plugins, $config );

}

endif; // current_user_can( 'install_plugins' )
