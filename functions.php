<?php
/*
Author: Hall Internet Marketing
URL: https://github.com/hallme/scaffolding

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

/******************************************

TABLE OF CONTENTS

1. Include Files
2. Scripts & Enqueueing
3. Theme Support
4. Custom Page Headers
5. Thumbnail Size Options
6. Change Name of Post Types in Admin Backend
7. Menus & Navigation
8. Active Sidebars
9. Related Posts Function
10. Comment Layout
11. Search Functions
12. Add First and Last Classes to Menu & Sidebar
13. Add First and Last Classes to Posts
14. Custom Functions

******************************************/

//Set up the content width value based on the theme's design.
if ( ! isset( $content_width ) ) {
	$content_width = 474;
}

//Adjust content_width value for image attachment template.
function scaffolding_content_width() {
	if ( is_attachment() && wp_attachment_is_image() ) {
		$GLOBALS['content_width'] = 810;
	}
}
add_action( 'template_redirect', 'scaffolding_content_width' );

/*********************
1. INCLUDE FILES
*********************/
define('SCAFFOLDING_INCLUDE_PATH', dirname(__FILE__).'/includes/');
require_once(SCAFFOLDING_INCLUDE_PATH.'base-functions.php');


/*********************
2. SCRIPTS & ENQUEUEING
*********************/

function scaffolding_scripts_and_styles() {
	global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way

	// modernizr (without media query polyfill)
	wp_enqueue_script( 'scaffolding-modernizr', '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.7.1/modernizr.min.js', false, null );

	// respondjs
	wp_enqueue_script( 'scaffolding-respondjs', '//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js', false, null );

	// register main stylesheet
	wp_enqueue_style( 'scaffolding-stylesheet', get_stylesheet_directory_uri() . '/css/style.css', array(), '', 'all' );

	// ie-only style sheet
	wp_enqueue_style( 'scaffolding-ie-only', get_stylesheet_directory_uri() . '/css/ie.css', array(), '' );
	$wp_styles->add_data( 'scaffolding-ie-only', 'conditional', 'lt IE 9' ); // add conditional wrapper around ie stylesheet

	//Magnific Popups (LightBox)
	wp_enqueue_script( 'scaffolding-magnific-popup-js', '//cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/0.9.9/jquery.magnific-popup.min.js', array( 'jquery' ), '0.9.9', true );

	//Font Awesome (icon set)
	wp_enqueue_style( 'scaffolding-font-awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.min.css', array(), '4.0.3' );

	// iCheck (better radio and checkbox inputs)
	wp_enqueue_script( 'scaffolding-icheck', '//cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.1/icheck.min.js', array( 'jquery' ), '1.0.1', true );

	//Chosen - http://harvesthq.github.io/chosen/
    wp_enqueue_script( 'chosen-js', '//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.jquery.min.js', array( 'jquery' ), '1.1.0', true );

	// comment reply script for threaded comments
	if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
		wp_enqueue_script( 'comment-reply' );
	}

	//adding scripts file in the footer
	wp_enqueue_script( 'scaffolding-js', get_stylesheet_directory_uri() . '/js/scripts.js', array( 'jquery' ), '', true );
}


/*********************
3. THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function scaffolding_theme_support() {

	add_theme_support( 'post-thumbnails' ); // wp thumbnails (sizes handled in functions.php)

	set_post_thumbnail_size( 125, 125, true ); // default thumb size

	/*  Feature Currently Disabled
	// wp custom background (thx to @bransonwerner for update)
	add_theme_support( 'custom-background',
		array(
		'default-image' => '',  // background image default
		'default-color' => '', // background color default (dont add the #)
		'wp-head-callback' => '_custom_background_cb',
		'admin-head-callback' => '',
		'admin-preview-callback' => ''
		)
	);
	*/

	add_theme_support( 'automatic-feed-links' ); // rss thingy

	// to add header image support go here: http://themble.com/support/adding-header-background-image-support/
	//adding custome header suport
	add_theme_support( 'custom-header', array(
		'default-image'=> '%s/images/headers/default.jpg',
		'random-default'=> false,
		'width'=> 1140,  // Make sure to set this
		'height'=> 250, // Make sure to set this
		'flex-height'=> false,
		'flex-width'=> false,
		'default-text-color'=> 'ffffff',
		'header-text'=> false,
		'uploads'=> true,
		'wp-head-callback'=> 'scaffolding_custom_headers_callback',
		'admin-head-callback'=> '',
		'admin-preview-callback'=> '',
		)
	);

/* Feature Currently Disabled
	// adding post format support
	add_theme_support( 'post-formats',
		array(
			'aside',			// title less blurb
			'gallery',			// gallery of images
			'link',			  	// quick link to other site
			'image',			// an image
			'quote',			// a quick quote
			'status',			// a Facebook like status update
			'video',			// video
			'audio',			// audio
			'chat'				// chat transcript
		)
	);
*/

	// wp menus
	add_theme_support( 'menus' );

	// registering wp3+ menus
	register_nav_menus(
		array(
			'main-nav' => __( 'Main Menu', 'scaffolding' ),	// main nav in header
			'footer-nav' => __( 'Footer Menu', 'scaffolding' ) // secondary nav in footer
		)
	);
} /* end scaffolding theme support */


/*********************
4. CUSTOM PAGE HEADERS
*********************/

register_default_headers( array(
	'default' => array(
		'url' => get_template_directory_uri().'/images/headers/default.jpg',
		'thumbnail_url' => get_template_directory_uri().'/images/headers/default.jpg',
		'description' => __( 'default', 'scaffolding' )
	)
));

//Set header image as a BG
function scaffolding_custom_headers_callback() {
	?><style type="text/css">#banner {background-image: url(<?php header_image(); ?>);}</style><?php
}


/*********************
5. THUMBNAIL SIZE OPTIONS
*********************/

// Thumbnail sizes
//add_image_size( 'scaffolding-thumb-600', 600, 150, true );


/*********************
6. CHANGE NAME OF POSTS TYPE IN ADMIN BACKEND
*********************/

/* //Currently commented out. This is useful for improving UX in the WP backend
function scaffolding_change_post_menu_label() {
	global $menu;
	global $submenu;
	$menu[5][0] = 'News';
	$submenu['edit.php'][5][0] = 'All News Entries';
	$submenu['edit.php'][10][0] = 'Add News Entries';
	$submenu['edit.php'][15][0] = 'Categories'; // Change name for categories
	$submenu['edit.php'][16][0] = 'Tags'; // Change name for tags
	echo '';
}

function scaffolding_change_post_object_label() {
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
add_action( 'init', 'scaffolding_change_post_object_label' );
add_action( 'admin_menu', 'scaffolding_change_post_menu_label' );
*/


/*********************
7. MENUS & NAVIGATION
*********************/

// the main menu
function scaffolding_main_nav() {
	// display the wp3 menu if available
	wp_nav_menu(array(
		'container' => '',						 	 // remove nav container
		'container_class' => '',		 				 // class of container (should you choose to use it)
		'menu' => '',							 	 	 // nav name
		'menu_class' => 'menu main-menu wrap clearfix',  // adding custom nav class
		'theme_location' => 'main-nav',			 		 // where it's located in the theme
		'before' => '',								 	 // before the menu
		'after' => '',								 	 // after the menu
		'link_before' => '',						 	 // before each link
		'link_after' => '',							 	 // after each link
		'depth' => 0,								 	 // limit the depth of the nav
		'fallback_cb' => '',	 // fallback function
		'items_wrap' => '<a href="#" class="menu-button" title="Click to open menu"><i class="fa fa-reorder"></i> Menu</a><ul id="%1$s" class="%2$s">%3$s</ul>',
		'walker'=> new scaffolding_walker_nav_menu
	));
} /* end scaffolding main nav */

// the footer menu (should you choose to use one)
function scaffolding_footer_nav() {
	wp_nav_menu(array(
		'container' => '',
		'container_class' => '',
		'menu' => '',
		'menu_class' => 'menu footer-menu clearfix',
		'theme_location' => 'footer-nav',
		'before' => '',
		'after' => '',
		'link_before' => '',
		'link_after' => '',
		'depth' => 0,
		'fallback_cb' => '__return_false'
	));
} /* end scaffolding footer link */

//Custom walker to build main menu
class scaffolding_walker_nav_menu extends Walker_Nav_Menu {
	// add classes to ul sub-menus
	function start_lvl(&$output, $depth = 0, $args = Array()) {
		// depth dependent classes
		$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
		$display_depth = ( $depth + 1); // because it counts the first submenu as 0
		$classes = array(
				'sub-menu',
				( $display_depth % 2 ? 'menu-odd' : 'menu-even' ),
				'menu-depth-' . $display_depth
			);
		$class_names = implode( ' ', $classes );
		// build html
		$output .= "\n" . $indent . '<ul class="' . $class_names . '"><li><a class="menu-back-button" title="Click to Go Back a Menu"><i class="fa fa-chevron-left"></i> Back</a></li>' . "\n";
	}

	function start_el(&$output, $item, $depth = 0, $args = Array(), $id = 0) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		//set <li> classes
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		if( $args->has_children ){ $classes[] = 'menu-has-children'; }
		if( !$args->has_children ){ $classes[] = 'menu-item-no-children'; }
		//combine the class array into a string
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		//set <li> id
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

		//set outer <li> and it's attributes
		$output .= $indent . '<li' . $id . $value . $class_names .'>';

		//set <a> attributes
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : ' title="' . esc_attr( strip_tags($item->title) ) . '"';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="'	. esc_attr( $item->xfn ) . '"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';

		//Add menu button links to items with children
		if ( $args->has_children ) {
			$menu_pull_link = '<a class="menu-button" title="Click to Open Menu"><i class="fa fa-chevron-right"></i></a>';
		}else{
			$menu_pull_link = '';
		}

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $menu_pull_link.$args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	function end_el(&$output, $item, $depth=0, $args=array()) {
		$output .= "</li>\n";
	}

   function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {

		//Set custom arg to tell if item has children
		$id_field = $this->db_fields['id'];
		if ( is_object( $args[0] ) ) {
			$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
		}

		return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
}


/*********************
8. ACTIVE SIDEBARS
*********************/

// Sidebars & Widgetizes Areas
function scaffolding_register_sidebars() {
	register_sidebar(array(
		'id' => 'left-sidebar',
		'name' => __('Left Sidebar', 'scaffolding'),
		'description' => __('The Left (primary) sidebar used for the interior menu.', 'scaffolding'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	register_sidebar(array(
		'id' => 'right-sidebar',
		'name' => __('Right Sidebar', 'scaffolding'),
		'description' => __('The Right sidebar used for the interior call to actions.', 'scaffolding'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
} // don't remove this bracket!


/*********************
9. RELATED POSTS FUNCTION
*********************/

// Related Posts Function (call using scaffolding_related_posts(); )
function scaffolding_related_posts() {
	echo '<ul id="scaffolding-related-posts">';
	global $post;
	$tags = wp_get_post_tags($post->ID);
	if($tags) {
		foreach($tags as $tag) {
			$tag_arr .= $tag->slug . ',';
		}
		$args = array(
			'tag' => $tag_arr,
			'numberposts' => 5, /* you can change this to show more */
			'post__not_in' => array($post->ID)
	 	);
		$related_posts = get_posts($args);
		if($related_posts) {
			foreach ($related_posts as $post) :
				setup_postdata($post); ?>
				<li class="related_post"><a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
			<?php
			endforeach;
		}
		else {
			echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'scaffolding' ) . '</li>';
		}
	}
	wp_reset_query();
	echo '</ul>';
} /* end scaffolding related posts function */


/*********************
10. COMMENT LAYOUT
*********************/

// Comment Layout
function scaffolding_comments($comment, $args, $depth) {
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
				<?php printf(__('<cite class="fn">%s</cite>', 'scaffolding'), get_comment_author_link()) ?>
				<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__('F jS, Y', 'scaffolding')); ?> </a></time>
				<?php edit_comment_link(__('(Edit)', 'scaffolding'),'  ','') ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
	   			<div class="alert info">
		  			<p><?php _e('Your comment is awaiting moderation.', 'scaffolding') ?></p>
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


/*********************
11. SEARCH FUNCTIONS
*********************/

// Search Form
function scaffolding_wpsearch($form) {
	$form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	<label class="screen-reader-text" for="s">' . __('Search for:', 'scaffolding') . '</label>
	<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="'.esc_attr__('Search the Site...','scaffolding').'" />
	<input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
	</form>';
	return $form;
} // don't remove this bracket!

/*********************
12. ADD FIRST AND LAST CLASSES TO MENU & SIDEBAR
*********************/

function scaffolding_add_first_and_last($output) {
	$output = preg_replace('/class="menu-item/', 'class="first-item menu-item', $output, 1);
	$last_pos = strripos($output, 'class="menu-item');
	if($last_pos !== false) {
		$output = substr_replace($output, 'class="last-item menu-item', $last_pos, 16 /* 16 = hardcoded strlen('class="menu-item') */);
	}
	return $output;
}
add_filter('wp_nav_menu', 'scaffolding_add_first_and_last');

// Add "first" and "last" CSS classes to dynamic sidebar widgets. Also adds numeric index class for each widget (widget-1, widget-2, etc.)
function scaffolding_widget_first_last_classes($params) {

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
add_filter( 'dynamic_sidebar_params', 'scaffolding_widget_first_last_classes' );


/*********************
13. ADD FIRST AND LAST CLASSES TO POSTS
*********************/

function scaffolding_post_classes( $classes ) {
	global $wp_query;
	if($wp_query->current_post == 0) {
		$classes[] = 'first-post';
	} elseif(($wp_query->current_post + 1) == $wp_query->post_count) {
		$classes[] = 'last-post';
	}

	return $classes;
}
add_filter( 'post_class', 'scaffolding_post_classes' );


/*********************
14. CUSTOM FUNCTIONS
*********************/

// This removes the annoying […] to a Read More link
function scaffolding_excerpt_more($more) {
	global $post;
	// edit here if you like
	return '...  <a href="'. get_permalink($post->ID) . '" title="'. __('Read', 'scaffolding') . get_the_title($post->ID).'">'. __('Read more &raquo;', 'scaffolding') .'</a>';
}

//This is a modified the_author_posts_link() which just returns the link.
//This is necessary to allow usage of the usual l10n process with printf().
function scaffolding_get_the_author_posts_link() {
	global $authordata;
	if ( !is_object( $authordata ) ) {
		return false;
	}
	$link = sprintf(
		'<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
		get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
		esc_attr( sprintf( __( 'Posts by %s' ), get_the_author() ) ), // No further l10n needed, core will take care of this one
		get_the_author()
	);
	return $link;
}
