<?php
/*
Author: Eddie Machado
URL: htp://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

/************* INCLUDE NEEDED FILES ***************/

/*
1. bones.php
	- head cleanup (remove rsd, uri links, junk css, ect)
	- enqueueing scripts & styles
	- theme support functions
	- custom menu output & fallbacks
	- related post function
	- page-navi function
	- removing <p> from around images
	- customizing the post excerpt
	- custom google+ integration
	- adding custom fields to user profiles
*/
require_once('bones.php'); // if you remove this, bones will break
/*
2. custom-post-type.php
	- an example custom post type
	- example custom taxonomy (like categories)
	- example custom taxonomy (like tags)
*/
require_once('custom-post-type.php'); // you can disable this if you like

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'bones-thumb-600', 600, 150, true );
add_image_size( 'bones-thumb-300', 300, 100, true );
/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

// Relative root the urls for the media uploader
function root_relative_urls($html) {
	if(defined('WP_SITEURL')) {
		$url = WP_SITEURL;
	}
	else {
		$url = 'http://' . $_SERVER['HTTP_HOST'];
	}
	return str_ireplace($url, '', $html);
}
add_filter('image_send_to_editor', 'root_relative_urls',100);
add_filter('media_send_to_editor', 'root_relative_urls',100);

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __('Sidebar 1', 'bonestheme'),
		'description' => __('The first (primary) sidebar.', 'bonestheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
} // don't remove this bracket!

/************* COMMENT LAYOUT *********************/

// Comment Layout
function bones_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<header class="comment-author vcard">
				<?php
				/*
					this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
					echo get_avatar($comment,$size='32',$default='<path_to_url>' );
				*/
				?>
				<!-- custom gravatar call -->
				<?php
					// create variable
					$bgauthemail = get_comment_author_email();
				?>
				<img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5($bgauthemail); ?>?s=32" class="load-gravatar avatar avatar-48 photo" height="32" width="32" src="<?php echo get_template_directory_uri(); ?>/images/nothing.gif" />
				<!-- end custom gravatar call -->
				<?php printf(__('<cite class="fn">%s</cite>', 'bonestheme'), get_comment_author_link()) ?>
				<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__('F jS, Y', 'bonestheme')); ?> </a></time>
				<?php edit_comment_link(__('(Edit)', 'bonestheme'),'  ','') ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
	   			<div class="alert info">
		  			<p><?php _e('Your comment is awaiting moderation.', 'bonestheme') ?></p>
		  		</div>
			<?php endif; ?>
			<section class="comment_content clearfix">
				<?php comment_text() ?>
			</section>
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</article>
	<!-- </li> is added by WordPress automatically -->
<?php
} // don't remove this bracket!

/************* SEARCH FORM LAYOUT *****************/

// Search Form
function bones_wpsearch($form) {
	$form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	<label class="screen-reader-text" for="s">' . __('Search for:', 'bonestheme') . '</label>
	<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="'.esc_attr__('Search the Site...','bonestheme').'" />
	<input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
	</form>';
	return $form;
} // don't remove this bracket!


/************* CUSTOM PAGE HEADERS *****************/

register_default_headers( array(
	'default' => array(
		'url' => get_template_directory_uri().'/images/interior-headers/default.jpg',
		'thumbnail_url' => get_template_directory_uri().'/images/interior-headers/default.jpg',
		'description' => __( 'default', 'bones' )
	)
));

//Set header image as a BG
function bones_custom_headers_callback(){
    ?><style type="text/css">#banner {background-image: url(<?php header_image(); ?>);}</style><?php
}

/************* ADD FIRST AND LAST CLASSES TO MENU & SIDEBAR *****************/
function add_first_and_last($output) {
	$output = preg_replace('/class="menu-item/', 'class="first-item menu-item', $output, 1);
	$last_pos = strripos($output, 'class="menu-item');
	if($last_pos !== false) {
		$output = substr_replace($output, 'class="last-item menu-item', $last_pos, 16 /* 16 = hardcoded strlen('class="menu-item') */);
	}
	return $output;
}
add_filter('wp_nav_menu', 'add_first_and_last');

// Add "first" and "last" CSS classes to dynamic sidebar widgets. Also adds numeric index class for each widget (widget-1, widget-2, etc.)
function widget_first_last_classes($params) {

	global $my_widget_num; // Global a counter array
	$this_id = $params[0]['id']; // Get the id for the current sidebar we're processing
	$arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets

	if(!$my_widget_num) {// If the counter array doesn't exist, create it
		$my_widget_num = array();
	}

	if(!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) { // Check if the current sidebar has no widgets
		return $params; // No widgets in this sidebar... bail early.
	}

	if(isset($my_widget_num[$this_id])) { // See if the counter array has an entry for this sidebar
		$my_widget_num[$this_id] ++;
	}
	else { // If not, create it starting with 1
		$my_widget_num[$this_id] = 1;
	}

	$class = 'class="widget-' . $my_widget_num[$this_id] . ' '; // Add a widget number class for additional styling options

	if($my_widget_num[$this_id] == 1) { // If this is the first widget
		$class .= 'first-widget ';
	}
	elseif($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) { // If this is the last widget
		$class .= 'last-widget ';
	}

	$params[0]['before_widget'] = str_replace('class="', $class, $params[0]['before_widget']); // Insert our new classes into "before widget"

	return $params;

}
add_filter('dynamic_sidebar_params','widget_first_last_classes');

/************* DASHBOARD WIDGETS *****************/
// disable default dashboard widgets
function disable_default_dashboard_widgets() {
	//remove_meta_box('dashboard_right_now', 'dashboard', 'core');// Right Now Widget
	//remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');// Comments Widget
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');// Incoming Links Widget
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');// Plugins Widget

	remove_meta_box('dashboard_quick_press', 'dashboard', 'core');// Quick Press Widget
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');// Recent Drafts Widget
	//remove_meta_box('dashboard_primary', 'dashboard', 'core');//1st blog feed
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');//2nd blog feed

	// removing plugin dashboard boxes
	//remove_meta_box('yoast_db_widget', 'dashboard', 'normal');		 // Yoast's SEO Plugin Widget
}
// removing the dashboard widgets
add_action('admin_menu', 'disable_default_dashboard_widgets');

/************* CUSTOM LOGIN PAGE *****************/
// calling your own login css so you can style it
function bones_login_css() {
	/* I couldn't get wp_enqueue_style to work :( */
	echo '<link rel="stylesheet" href="' . get_stylesheet_directory_uri() . '/css/login.css">';
}

// changing the logo link from wordpress.org to your site
function bones_login_url() {  return home_url(); }

// changing the alt text on the logo to show your site name
function bones_login_title() { return get_option('blogname'); }

// calling it only on the login page
add_action('login_head', 'bones_login_css');
add_filter('login_headerurl', 'bones_login_url');
add_filter('login_headertitle', 'bones_login_title');

/************* CUSTOMIZE ADMIN *******************/
// Custom Backend Footer
function bones_custom_admin_footer() {
	echo '<span id="footer-thankyou">Developed by <a href="http://www.hallme.com" target="_blank">Hall Internet Marketing</a></span>. Built using <a href="https://github.com/rclations/toolkit" target="_blank">toolkit</a> a branch of <a href="http://themble.com/bones" target="_blank">Bones</a>.';
}
// adding it to the admin area
add_filter('admin_footer_text', 'bones_custom_admin_footer');


/************* REMOVE HEIGHT & WIDTH ON IMAGES *****************/
/**
* Filter out hard-coded width, height attributes on all images in WordPress.
* https://gist.github.com/4557917
*
* This version applies the function as a filter to the_content rather than send_to_editor.
* Changes made by filtering send_to_editor will be lost if you update the image or associated post
* and you will slowly lose your grip on sanity if you don't know to keep an eye out for it.
* the_content applies to the content of a post after it is retrieved from the database and is "theme-safe".
* (i.e., Your changes will not be stored permanently or impact the HTML output in other themes.)
*
* Also, the regex has been updated to catch both double and single quotes, since the output of
* get_avatar is inconsistent with other WP image functions and uses single quotes for attributes.
* [insert hate-stare here]
*
*/
function bones_remove_img_dimensions($html) {
    // Loop through all <img> tags
    if (preg_match('/<img[^>]+>/ims', $html, $matches)) {
        foreach ($matches as $match) {
            // Replace all occurences of width/height
            $clean = preg_replace('/(width|height)=["\'\d%\s]+/ims', "", $match);
            // Replace with result within html
            $html = str_replace($match, $clean, $html);
        }
    }
    return $html;
}
add_filter('post_thumbnail_html', 'bones_remove_img_dimensions', 10);
add_filter('the_content', 'bones_remove_img_dimensions', 10);
add_filter('get_avatar','bones_remove_img_dimensions', 10);


/************* CLIENT ACCESS FUNCTIONS *****************/
function increase_editor_permissions(){
    $role = get_role('editor');
    $role->add_cap('gform_full_access'); // Gives editors access to Gravity Forms
    $role->add_cap('edit_theme_options'); // Gives editors access to widgets & menus
}
add_action('admin_init','increase_editor_permissions');

wp_unregister_sidebar_widget( 'wpe_widget_powered_by' ); // Removes the Powered By WPEngine widget


/************* CUSTOM FUNCTIONS *****************/

//Apply styles to the visual editor
function bones_mcekit_editor_style($url) {
	if ( !empty($url) )
		$url .= ',';
	// Retrieves the plugin directory URL and adds editor stylesheet
	// Change the path here if using different directories
	$url .= trailingslashit( get_template_directory_uri() ) . 'css/editor-styles.css';
	return $url;
}
add_filter('mce_css', 'bones_mcekit_editor_style');

/** Remove Wordpress Logo From Admin Bar **/
function remove_admin_bar_links() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

/*Filter post with noindex set from serch results*/
function SearchFilter($query) {
	if ($query->is_search) {
		$args = array(array('key'     => '_yoast_wpseo_meta-robots-noindex	','value'   => '1','compare' => '!='));
		$query->set('meta_query', $args);
	}
	return $query;
}
add_filter('pre_get_posts','SearchFilter');