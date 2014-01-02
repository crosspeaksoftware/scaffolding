<?php
/*
Author: Hall Internet Marketing
URL: https://github.com/hallme/scaffolding

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

/*********************
INCLUDE FILES
*********************/

require_once('includes/base-functions.php');
// require_once('includes/custom-post-type.php');

/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function scaffolding_theme_support() {

	add_theme_support('post-thumbnails');						// wp thumbnails (sizes handled in functions.php)

	set_post_thumbnail_size(125, 125, true);					// default thumb size

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


	add_theme_support('automatic-feed-links');					// rss thingy

	// to add header image support go here: http://themble.com/support/adding-header-background-image-support/
	//adding custome header suport
	add_theme_support( 'custom-header', array(
		'default-image'=> '%s/images/headers/default.jpg',
		'random-default'=> false,
		'width'=> 999,  // Make sure to set this
		'height'=> 262, // Make sure to set this
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
			'main-nav' => __( 'Main Menu', 'scaffoldingtheme' ),	// main nav in header
			'footer-nav' => __( 'Footer Menu', 'scaffoldingtheme' ) // secondary nav in footer
		)
	);
} /* end scaffolding theme support */


/*********************
MENUS & NAVIGATION
*********************/

// the main menu
function scaffolding_main_nav() {
	// display the wp3 menu if available
	wp_nav_menu(array(
		'container' => false,						 	// remove nav container
		'container_class' => '',		 				// class of container (should you choose to use it)
		'menu' => '',							 	 	// nav name
		'menu_class' => 'menu main-menu wrap clearfix', // adding custom nav class
		'theme_location' => 'main-nav',			 		// where it's located in the theme
		'before' => '',								 	// before the menu
		'after' => '',								 	// after the menu
		'link_before' => '',						 	// before each link
		'link_after' => '',							 	// after each link
		'depth' => 0,								 	// limit the depth of the nav
		'fallback_cb' => 'scaffolding_main_nav_fallback'// fallback function
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
		'fallback_cb' => 'scaffolding_nav_fallback'
	));
} /* end scaffolding footer link */

// this is the fallback for header menu
function scaffolding_main_nav_fallback() {
	wp_nav_menu(array(
		'container' => false,
		'container_class' => '',
		'menu' => '',
		'menu_class' => 'menu main-menu wrap clearfix',
		'before' => '',
		'after' => '',
		'link_before' => '',
		'link_after' => '',
		'depth' => 0,
	));
}

// this is the fallback for footer menu
function scaffolding_nav_fallback() {
	/* you can put a default here if you like */
}

/*************
 ACTIVE SIDEBARS
 ***************/

// Sidebars & Widgetizes Areas
function scaffolding_register_sidebars() {
	register_sidebar(array(
		'id' => 'left-sidebar',
		'name' => __('Left Sidebar', 'scaffoldingtheme'),
		'description' => __('The Left (primary) sidebar used for the interior menu.', 'scaffoldingtheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	register_sidebar(array(
		'id' => 'right-sidebar',
		'name' => __('Right Sidebar', 'scaffoldingtheme'),
		'description' => __('The Right sidebar used for the interior call to actions.', 'scaffoldingtheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
} // don't remove this bracket!


/*************
 CUSTOM PAGE HEADERS
 *************/

register_default_headers( array(
	'default' => array(
		'url' => get_template_directory_uri().'/images/interior-headers/default.jpg',
		'thumbnail_url' => get_template_directory_uri().'/images/interior-headers/default.jpg',
		'description' => __( 'default', 'scaffolding' )
	)
));

//Set header image as a BG
function scaffolding_custom_headers_callback() {
	?><style type="text/css">#banner {background-image: url(<?php header_image(); ?>);}</style><?php
}

/*************
 THUMBNAIL SIZE OPTIONS
 **************/

// Thumbnail sizes
//add_image_size( 'scaffolding-thumb-600', 600, 150, true );

/**********************
 CHANGE NAME OF POSTS TYPE IN ADMIN BACKEND
 **********************/
/* Currently commented out. This is useful for imporving UX in the WP backend
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


/*********************
RELATED POSTS FUNCTION
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
			echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'scaffoldingtheme' ) . '</li>';
		}
	}
	wp_reset_query();
	echo '</ul>';
} /* end scaffolding related posts function */

/*******************
 COMMENT LAYOUT
 *******************/
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
				<?php printf(__('<cite class="fn">%s</cite>', 'scaffoldingtheme'), get_comment_author_link()) ?>
				<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__('F jS, Y', 'scaffoldingtheme')); ?> </a></time>
				<?php edit_comment_link(__('(Edit)', 'scaffoldingtheme'),'  ','') ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
	   			<div class="alert info">
		  			<p><?php _e('Your comment is awaiting moderation.', 'scaffoldingtheme') ?></p>
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

/************* SEARCH FUNCTIONS *****************/

// Search Form
function scaffolding_wpsearch($form) {
	$form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	<label class="screen-reader-text" for="s">' . __('Search for:', 'scaffoldingtheme') . '</label>
	<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="'.esc_attr__('Search the Site...','scaffoldingtheme').'" />
	<input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
	</form>';
	return $form;
} // don't remove this bracket!

//Filter post with noindex set from serch results
function scaffolding_search_filter($query) {
	if ($query->is_search) {
		$query->set('meta_query', array(
				'relation' => 'OR',
				// include if this key doesn't exists
				array(
					'key' => '_yoast_wpseo_meta-robots-noindex',
					'value' => '', // This is ignored, but is necessary...
					'compare' => 'NOT EXISTS'
				),
				// OR if key does exists include if it is not 1
				array(
					'key' => '_yoast_wpseo_meta-robots-noindex',
					'value' => '1',
					'compare' => '!='
				),
				// OR this key overrides it
				array(
					'key' => '_yoast_wpseo_sitemap-html-include',
					'value' => 'always',
					'compare' => '='
				)
			));
	}
	return $query;
}
add_filter('pre_get_posts','scaffolding_search_filter');

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


/************* ADD FIRST AND LAST CLASSES TO POSTS *****************/
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

/************* CUSTOM FUNCTIONS *****************/

// This removes the annoying […] to a Read More link
function scaffolding_excerpt_more($more) {
	global $post;
	// edit here if you like
	return '...  <a href="'. get_permalink($post->ID) . '" title="'. __('Read', 'scaffoldingtheme') . get_the_title($post->ID).'">'. __('Read more &raquo;', 'scaffoldingtheme') .'</a>';
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