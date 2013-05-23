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

/************* THUMBNAIL SIZE OPTIONS *************
to add more sizes, simply copy a line below
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

// Thumbnail sizes
//add_image_size( 'bones-thumb-600', 600, 150, true );

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'left-sidebar',
		'name' => __('Left Sidebar', 'bonestheme'),
		'description' => __('The Left (primary) sidebar used for the interior menu.', 'bonestheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	register_sidebar(array(
		'id' => 'right-sidebar',
		'name' => __('Right Sidebar', 'bonestheme'),
		'description' => __('The Right sidebar used for the interior call to actions.', 'bonestheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
} // don't remove this bracket!

/************* COMMENT LAYOUT *********************/

/**** CHANGE NAME OF POSTS TYPE IN ADMIN BACKEND ****/
/*
function change_post_menu_label() {
	global $menu;
	global $submenu;
	$menu[5][0] = 'News';
	$submenu['edit.php'][5][0] = 'All News Entries';
	$submenu['edit.php'][10][0] = 'Add News Entries';
	$submenu['edit.php'][15][0] = 'Categories'; // Change name for categories
	$submenu['edit.php'][16][0] = 'Tags'; // Change name for tags
	echo '';
}

function change_post_object_label() {
	global $wp_post_types;
	$labels = &$wp_post_types['post']->labels;
	$labels->name = 'News';
	$labels->singular_name = 'News';
	$labels->add_new = 'Add News Entry';
	$labels->add_new_item = 'Add News Entry';
	$labels->edit_item = 'Edit News Entry';
	$labels->new_item = 'News Entry';
	$labels->view_item = 'View Entry';
	$labels->search_items = 'Search News Entries';
	$labels->not_found = 'No News Entries found';
	$labels->not_found_in_trash = 'No News Entries found in Trash';
}
add_action( 'init', 'change_post_object_label' );
add_action( 'admin_menu', 'change_post_menu_label' );
*/

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
* https://gist.github.com/4557917 - for more information
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
//add_filter('the_content', 'bones_remove_img_dimensions', 10); //Options - This has been removed from the content filter so that clients can still edit image sizes in the editor
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


// Remove Wordpress Logo From Admin Bar
function remove_admin_bar_links() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );


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


//Filter post with noindex set from serch results
function SearchFilter($query) {
	if ($query->is_search) {
		$args = array(array('key' => '_yoast_wpseo_meta-robots-noindex', 'value' => '1', 'compare' => '!='));
		$query->set('meta_query', $args);
	}
	return $query;
}
add_filter('pre_get_posts','SearchFilter');

//Clean the formatting out of phone numbers for tel links
function clean_phone($phone){
	$phone = preg_replace('/\D+/', '', $phone); //strip all non-digits
	return $phone;
}

//Check if current page is in the a specified menu
/* Currently commented out to be worked on so a menu can be specified to test
function in_menu($post_ID=false){
	if(is_object($post_ID)){
		$post_ID = $post_ID->ID;
	}
	if($post_ID===false){
		global $post;
		$post_ID = $post->ID;
	}
	$menu_locals = get_nav_menu_locations(); //get the menus in all the locations
	$menu_items = wp_get_nav_menu_items($menu_locals['main-nav']); //return the objects in the main-nav location
	$is_in_menu = false;
	foreach ( (array) $menu_items as $menu_item ) {
		if($menu_item->object_id == $post_ID){
			$is_in_menu = true;
			break;
		}
	}
	return $is_in_menu;
}
*/

//Returns an array of all the post ID's for the posts using a specified template
function get_posts_by_template($tmpl_name){
	//if no template name us given return
	if( is_null($tmpl_name) )
		return;

	//collect all the post using specified template
	$pages = get_pages(array(
	    'meta_key' => '_wp_page_template',
	    'meta_value' => $tmpl_name,
	    'hierarchical' => 0
	));

	//load ids into array
	$tmpl_pages = array();
	foreach($pages as $page){
		$tmpl_pages[] = $page->ID;
	}

	return $tmpl_pages;
}

//Get the_excerpt and speciphi its size http://www.wprecipes.com/wordpress-improved-the_excerpt-function
function get_excerpt($length=100) {
	global $post;
	$text = $post->post_excerpt;
	if ( '' == $text ) {
		$text = get_the_content('');
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]>', $text);
	}
	//clean up the string
	$text = strip_shortcodes($text); // optional, recommended
	$text = strip_tags($text,'<b><strong><em><i><br><span><p>'); //remove most html tags optional, recommended

	//add read more link without interfering with excerpt length
	$excerpt_end = '... <a class="read-more-link" href="'. get_permalink($post->ID) . '" title="'. __('Read ', 'bonestheme') . get_the_title($post->ID).'">'. __('Read more', 'bonestheme') .'</a>';
	$excerpt_end_size = strlen($excerpt_end);
	$length = $length + $excerpt_end_size;

	//truncate the string while preserving remaining html tags
	$excerpt = truncateHtml($text,$length,$excerpt_end);

	//return truncated excerpt or text depending on string length
	if( strlen($text) < $length ) {
		return apply_filters('the_content', $text);
	} else {
		return apply_filters('the_content', $excerpt);
	}
}

//Truncate Text while preserving HTML
function truncateHtml($text, $length = 100, $ending = '...', $exact = false, $considerHtml = true) {
	if ($considerHtml) {
		// if the plain text is shorter than the maximum length, return the whole text
		if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
			return $text;
		}
		// splits all html-tags to scanable lines
		preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
		$total_length = strlen($ending);
		$open_tags = array();
		$truncate = '';
		foreach ($lines as $line_matchings) {
			// if there is any html-tag in this line, handle it and add it (uncounted) to the output
			if (!empty($line_matchings[1])) {
				// if it's an "empty element" with or without xhtml-conform closing slash
				if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
					// do nothing
				// if tag is a closing tag
				} else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
					// delete tag from $open_tags list
					$pos = array_search($tag_matchings[1], $open_tags);
					if ($pos !== false) {
					unset($open_tags[$pos]);
					}
				// if tag is an opening tag
				} else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
					// add tag to the beginning of $open_tags list
					array_unshift($open_tags, strtolower($tag_matchings[1]));
				}
				// add html-tag to $truncate'd text
				$truncate .= $line_matchings[1];
			}
			// calculate the length of the plain text part of the line; handle entities as one character
			$content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
			if ($total_length+$content_length> $length) {
				// the number of characters which are left
				$left = $length - $total_length;
				$entities_length = 0;
				// search for html entities
				if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
					// calculate the real length of all entities in the legal range
					foreach ($entities[0] as $entity) {
						if ($entity[1]+1-$entities_length <= $left) {
							$left--;
							$entities_length += strlen($entity[0]);
						} else {
							// no more characters left
							break;
						}
					}
				}
				$truncate .= substr($line_matchings[2], 0, $left+$entities_length);
				// maximum lenght is reached, so get off the loop
				break;
			} else {
				$truncate .= $line_matchings[2];
				$total_length += $content_length;
			}
			// if the maximum length is reached, get off the loop
			if($total_length>= $length) {
				break;
			}
		}
	} else {
		if (strlen($text) <= $length) {
			return $text;
		} else {
			$truncate = substr($text, 0, $length - strlen($ending));
		}
	}
	// if the words shouldn't be cut in the middle...
	if (!$exact) {
		// ...search the last occurance of a space...
		$spacepos = strrpos($truncate, ' ');
		if (isset($spacepos)) {
			// ...and cut the text in this position
			$truncate = substr($truncate, 0, $spacepos);
		}
	}
	// add the defined ending to the text
	$truncate .= $ending;
	if($considerHtml) {
		// close all unclosed html-tags
		foreach ($open_tags as $tag) {
			$truncate .= '</' . $tag . '>';
		}
	}
	return $truncate;
}