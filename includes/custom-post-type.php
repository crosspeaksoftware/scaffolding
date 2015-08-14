<?php
/**
 * Custom Post Type Example
 *
 * This page walks you through creating a custom post type and taxonomies.
 * You should copy this to a new file to create your custom type. Make sure to include it in functions.php.
 * For custom meta boxes, use the Advanced Custom Fields plugin from http://www.advancedcustomfields.com.
 *
 * @link http://codex.wordpress.org/Post_Types
 *
 * @package Scaffolding
 * @since Scaffolding 1.0
 */

// Registered handles for Custom Post Type and Custom Taxonomies
define( 'CUSTOM_POST_TYPE', 'custom_type' );
define( 'CUSTOM_TAXONOMY_CAT', 'custom_cat' );
define( 'CUSTOM_TAXONOMY_TAG', 'custom_tag' );

// Register handles for Labels, Messages, and Help Tabs
define( 'CUSTOM_POST_NAME', 'Custom Post Name' );
define( 'CUSTOM_POST_SINGULAR', 'Custom Post Singular' );
define( 'CUSTOM_CAT_NAME', 'Custom Cat Name' );
define( 'CUSTOM_CAT_SINGULAR', 'Custom Cat Singular' );
define( 'CUSTOM_TAG_NAME', 'Custom Tag Name' );
define( 'CUSTOM_TAG_SINGULAR', 'Custom Tag Singular' );

/**
 * Register Custom Post Type (CPT)
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function scaffolding_custom_post_example() {
    
    $labels = array(
        'name'                      => __( CUSTOM_POST_NAME, 'Post type general name', 'scaffolding' ),
        'singular_name'             => __( CUSTOM_POST_SINGULAR, 'Post type singular name', 'scaffolding' ),
        'menu_name'                 => __( CUSTOM_POST_NAME, 'Admin menu', 'scaffolding' ),
        'name_admin_bar'            => __( CUSTOM_POST_SINGULAR, 'Add new on admin bar', 'scaffolding' ),
        'all_items'                 => __( 'All '.CUSTOM_POST_NAME, 'scaffolding' ),
        'add_new'                   => __( 'Add New', 'scaffolding' ),
        'add_new_item'              => __( 'Add New '.CUSTOM_POST_SINGULAR, 'scaffolding' ),
        'edit'                      => __( 'Edit', 'scaffolding' ),
        'edit_item'                 => __( 'Edit '.CUSTOM_POST_SINGULAR, 'scaffolding' ),
        'new_item'                  => __( 'New '.CUSTOM_POST_SINGULAR, 'scaffolding' ),
        'view_item'                 => __( 'View '.CUSTOM_POST_SINGULAR, 'scaffolding' ),
        'search_items'              => __( 'Search '.CUSTOM_POST_NAME, 'scaffolding' ),
        'not_found'                 => __( 'Nothing found in the Database.', 'scaffolding' ),
        'not_found_in_trash'        => __( 'Nothing found in Trash.', 'scaffolding' ),
        'parent_item_colon'         => __( 'Parent Item:', 'scaffolding' ),
    );
    
    $supports = array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky', );
    
    $taxonomies = array( /*'category', 'post_tag',*/ CUSTOM_TAXONOMY_CAT, CUSTOM_TAXONOMY_TAG, );
    
    $rewrite = array(
        'slug'                      => __( 'custom-type', 'scaffolding' ),  //
        'with_front'                => false,                               //
    );
    
    $args = array(
        'description'               => __( CUSTOM_POST_NAME.' custom post type.', 'scaffolding' ),
        'labels'                    => $labels,
        'supports'                  => $supports,
        'taxonomies'                => $taxonomies,
        'hierarchical'              => false,                       //
        'public'                    => true,                        //
        'show_ui'                   => true,                        //
        'show_in_menu'              => true,                        //
        'show_in_nav_menus'         => true,                        //
        'show_in_admin_bar'         => true,                        //
        'menu_position'             => 8,                           //
        'can_export'                => true,                        //
        'has_archive'               => 'custom_type',               //
        'exclude_from_search'       => false,                       //
        'publicly_queryable'        => true,                        //
        'capability_type'           => 'post',                 	    //	       	
        'menu_icon'                 => 'dashicons-portfolio',       //
        'capability_type'           => 'post',                      //
        'hierarchical'              => false,                       //
        'has_archive'               => 'custom-type',               //
        'rewrite'                   => $rewrite,                    
        'query_var'                 => true,                        //
    );
    
    register_post_type( CUSTOM_POST_TYPE, $args );
    
}
add_action ( 'init', 'scaffolding_custom_post_example', 0 );


/**
 * Register Custom Category Taxonomy
 * 
 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
 */
function scaffolding_custom_tax_cat_example () {
    
    $labels = array(
        'name'                      => _x( CUSTOM_CAT_NAME, 'Taxonomy General Name', 'scaffolding' ),
        'singular_name'             => _x( CUSTOM_CAT_SINGULAR, 'Taxonomy Singular Name', 'scaffolding '),
        'menu_name'                 => __( CUSTOM_CAT_NAME, 'scaffolding' ),  
        'all_items'                 => __( 'All Items', 'scaffolding' ),                               
        'parent_item'               => __( 'Parent Item', 'scaffolding' ),
        'parent_item_colon'         => __( 'Parent Item:', 'scaffolding' ),
        'new_item_name'             => __( 'New Item Name', 'scaffolding' ),
        'add_new_item'              => __( 'Add New Item', 'scaffolding' ),
        'edit_item'                 => __( 'Edit Item', 'scaffolding' ),
        'update_item'               => __( 'Update Item', 'scaffolding' ),
        'separate_items_with_commas'=> __( 'Separate items with commas', 'scaffolding' ),
        'search_items'              => __( 'Search Items', 'scaffolding' ),
        'add_or_remove_items'       => __( 'Add or remove items', 'scaffolding' ),
        'choose_from_most_used'     => __( 'Choose from the most used items', 'scaffolding' ),
        'not_found'                 => __( 'Not Found', 'scaffolding' ),
    );
    
    $args = array(
        'labels'                    => $labels,
        'hierarchical'              => true,        // Acts as categories
        'public'                    => true,        //
        'show_ui'                   => true,        //
        'show_admin_column'         => true,        //
        'show_in_nav_menus'         => true,        //
        'show_tagcloud'             => false,       //
    );
    
    register_taxonomy ( CUSTOM_TAXONOMY_CAT, CUSTOM_POST_TYPE, $args );
    
}
add_action ( 'init', 'scaffolding_custom_tax_cat_example', 0 );

/**
 * Register Custom Tag Taxonomy
 * 
 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
 */
function scaffolding_custom_tax_tag_example () {
    
    $labels = array(
        'name'                      => _x( CUSTOM_TAG_NAME, 'Taxonomy General Name', 'scaffolding' ),
        'singular_name'             => _x( CUSTOM_TAG_SINGULAR, 'Taxonomy Singular Name', 'scaffolding '),
        'menu_name'                 => __( CUSTOM_TAG_NAME, 'scaffolding' ),  
        'all_items'                 => __( 'All Items', 'scaffolding' ),                               
        'parent_item'               => __( 'Parent Item', 'scaffolding' ),
        'parent_item_colon'         => __( 'Parent Item:', 'scaffolding' ),
        'new_item_name'             => __( 'New Item Name', 'scaffolding' ),
        'add_new_item'              => __( 'Add New Item', 'scaffolding' ),
        'edit_item'                 => __( 'Edit Item', 'scaffolding' ),
        'update_item'               => __( 'Update Item', 'scaffolding' ),
        'separate_items_with_commas'=> __( 'Separate items with commas', 'scaffolding' ),
        'search_items'              => __( 'Search Items', 'scaffolding' ),
        'add_or_remove_items'       => __( 'Add or remove items', 'scaffolding' ),
        'choose_from_most_used'     => __( 'Choose from the most used items', 'scaffolding' ),
        'not_found'                 => __( 'Not Found', 'scaffolding' ),
    );
    
    $args = array(
        'labels'                    => $labels,
        'hierarchical'              => false,       // Acts as tags
        'public'                    => true,        //
        'show_ui'                   => true,        //
        'show_admin_column'         => true,        //
        'show_in_nav_menus'         => true,        //
        'show_tagcloud'             => true,        //
    );
    
    register_taxonomy ( CUSTOM_TAXONOMY_TAG, CUSTOM_POST_TYPE, $args );
    
}
add_action ( 'init', 'scaffolding_custom_tax_tag_example', 0 );

/**
 * Customize Interaction Messages
 *
 * @link http://premium.wpmudev.org/blog/create-wordpress-custom-post-types/
 */
function scaffolding_custom_post_updated_messages( $messages ) {
	global $post, $post_ID;
	$messages[CUSTOM_POST_TYPE] = array(
		0 	=> '',
		1 	=> sprintf( __( '%1$s updated <a href="%2$s">View %1$s</a>' ), CUSTOM_POST_SINGULAR, esc_url( get_permalink( $post_ID ) ) ),
		2 	=> __( CUSTOM_POST_SINGULAR.' updated.' ),
		3 	=> __( CUSTOM_POST_SINGULAR.' deleted.' ),
		4 	=> __( CUSTOM_POST_SINGULAR.' updated.' ),
		5 	=> isset( $_GET['revision'] ) ? sprintf( __( '%s restored to revision from %s' ), CUSTOM_POST_SINGULAR,  wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 	=> sprintf( __( '%1$s published. <a href="%2$s">View %1$s</a>' ), CUSTOM_POST_SINGULAR, esc_url( get_permalink( $post_ID ) ) ),
		7 	=> __( CUSTOM_POST_SINGULAR.' saved.' ),
		8 	=> sprintf( __( '%1$s submitted. <a target="_blank" href="%2$s">Preview %1$s</a>' ), CUSTOM_POST_SINGULAR, esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 	=> sprintf( __( '%3$s scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview %3$s</a>' ), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ), CUSTOM_POST_SINGULAR ),
		10 	=> sprintf( __( '%1$s draft updated. <a target="_blank" href="%2$s">Preview %2$s</a>' ), CUSTOM_POST_SINGULAR, esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) )
	);
	return $messages;
}
add_filter( 'post_updated_messages', 'scaffolding_custom_post_updated_messages' );

/**
 * Contextual Help Tabs
 * 
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function scaffolding_cpt_custom_help_tab() {
    
    $screen = get_current_screen();

    // Return early if we're not in the post type
    if ( CUSTOM_POST_TYPE != $screen->post_type )
        return;

    // Setup help tab args
    $args = array(
        'id'      => 'cpt_custom_id',                           // unique id for the tab
        'title'   => 'Custom Help',                             // unique visible title for the tab
        'content' => '<h3>Help Title</h3><p>Help content</p>',  // actual help text
    );
  
    // Add the help tab
    $screen->add_help_tab( $args );
    
}
add_action( 'admin_head', 'scaffolding_cpt_custom_help_tab' );

/**
 * Flush Rewrite Rules
 * 
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function scaffolding_rewrite_flush() {
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'scaffolding_rewrite_flush' );