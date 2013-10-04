<?php
/*
Author: Hall Internet Marketing
URL: https://github.com/hallme/scaffolding

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

// we're firing all out initial functions at the start
add_action('after_setup_theme','scaffolding_build', 16);
function scaffolding_build() {

	// launching operation cleanup
	add_action('init', 'scaffolding_head_cleanup');
	// remove WP version from RSS
	add_filter('the_generator', 'scaffolding_rss_version');
	// remove pesky injected css for recent comments widget
	add_filter( 'wp_head', 'scaffolding_remove_wp_widget_recent_comments_style', 1 );
	// clean up comment styles in the head
	add_action('wp_head', 'scaffolding_remove_recent_comments_style', 1);
	// clean up gallery output in wp
	add_filter('gallery_style', 'scaffolding_gallery_style');

	// enqueue base scripts and styles
	add_action('wp_enqueue_scripts', 'scaffolding_scripts_and_styles', 999);

	// launching this stuff after theme setup
	scaffolding_theme_support();

	// adding sidebars to Wordpress (these are created in functions.php)
	add_action( 'widgets_init', 'scaffolding_register_sidebars' );
	// adding the scaffolding search form (created in functions.php)
	add_filter( 'get_search_form', 'scaffolding_wpsearch' );

	// cleaning up random code around images
	add_filter('the_content', 'scaffolding_filter_ptags_on_images');
	// cleaning up excerpt
	add_filter('excerpt_more', 'scaffolding_excerpt_more');

} /* end scaffolding ahoy */

/*********************
WP_HEAD GOODNESS
The default wordpress head is
a mess. Let's clean it up by
removing all the junk we don't
need.
*********************/

function scaffolding_head_cleanup() {
	// category feeds
	// remove_action( 'wp_head', 'feed_links_extra', 3 );
	// post and comment feeds
	// remove_action( 'wp_head', 'feed_links', 2 );
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// index link
	remove_action( 'wp_head', 'index_rel_link' );
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
	// remove WP version from css
	add_filter( 'style_loader_src', 'scaffolding_remove_wp_ver_css_js', 9999 );
	// remove Wp version from scripts
	add_filter( 'script_loader_src', 'scaffolding_remove_wp_ver_css_js', 9999 );

} /* end scaffolding head cleanup */

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
// loading modernizr and jquery, and reply script
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

		/*
		I recommend using a plugin to call jQuery
		using the google cdn. That way it stays cached
		and your site will load faster.
		*/
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'scaffolding-js' );

	}
}

/*************
 INCLUDE NEEDED FILES
 ***************/
//require_once('custom-post-type.php'); // include your custom post type files here

/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function scaffolding_theme_support() {

	// wp thumbnails (sizes handled in functions.php)
	add_theme_support('post-thumbnails');

	// default thumb size
	set_post_thumbnail_size(125, 125, true);

/* Feature Currently Disabled
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

	// rss thingy
	add_theme_support('automatic-feed-links');

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

/*********************
PAGE NAVI
*********************/

// Numeric Page Navi (built into the theme by default)
function scaffolding_page_navi($before = '', $after = '') {
    global $wpdb, $wp_query;
    $request = $wp_query->request;
    $posts_per_page = intval(get_query_var('posts_per_page'));
    $paged = intval(get_query_var('paged'));
    $numposts = $wp_query->found_posts;
    $max_page = $wp_query->max_num_pages;
    if ( $numposts <= $posts_per_page ) { return; }
    if(empty($paged) || $paged == 0) {
        $paged = 1;
    }
    $pages_to_show = 7;
    $pages_to_show_minus_1 = $pages_to_show-1;
    $half_page_start = floor($pages_to_show_minus_1/2);
    $half_page_end = ceil($pages_to_show_minus_1/2);
    $start_page = $paged - $half_page_start;
    if($start_page <= 0) {
        $start_page = 1;
    }
    $end_page = $paged + $half_page_end;
    if(($end_page - $start_page) != $pages_to_show_minus_1) {
        $end_page = $start_page + $pages_to_show_minus_1;
    }
    if($end_page > $max_page) {
        $start_page = $max_page - $pages_to_show_minus_1;
        $end_page = $max_page;
    }
    if($start_page <= 0) {
        $start_page = 1;
    }
    echo $before.'<nav class="page-navigation"><ol class="scaffolding_page_navi clearfix">'."";
    if ($start_page >= 2 && $pages_to_show < $max_page) {
        $first_page_text = __( "First", 'scaffoldingtheme' );
        echo '<li class="bpn-first-page-link"><a rel="prev" href="'.get_pagenum_link().'" title="'.$first_page_text.'">'.$first_page_text.'</a></li>';
    }
    echo '<li class="bpn-prev-link">';
    previous_posts_link('<<');
    echo '</li>';
    for($i = $start_page; $i  <= $end_page; $i++) {
        if( $i == $paged ) {
            echo '<li class="bpn-current">'.$i.'</li>';
        }elseif( $i == ($paged - 1) ) {
            echo '<li><a rel="prev" href="'.get_pagenum_link($i).'" title="View Page '.$i.'">'.$i.'</a></li>';
        }elseif( $i == ($paged + 1) ) {
            echo '<li><a rel="next" href="'.get_pagenum_link($i).'" title="View Page '.$i.'">'.$i.'</a></li>';
        }else {
            echo '<li><a href="'.get_pagenum_link($i).'" title="View Page '.$i.'">'.$i.'</a></li>';
        }
    }
    echo '<li class="bpn-next-link">';
    next_posts_link('>>');
    echo '</li>';
    if ($end_page < $max_page) {
        $last_page_text = __( "Last", 'scaffoldingtheme' );
        echo '<li class="bpn-last-page-link"><a rel="next" href="'.get_pagenum_link($max_page).'" title="'.$last_page_text.'">'.$last_page_text.'</a></li>';
    }
    echo '</ol></nav>'.$after."";
} /* end page navi */

//add rel and title attribute to next pagination link
function get_next_posts_link_attributes($attr){
    $attr = 'rel="next" title="View the Next Page"';
    return $attr;
}
add_filter('next_posts_link_attributes', 'get_next_posts_link_attributes');

//add rel and title attribute to prev pagination link
function get_previous_posts_link_attributes($attr){
    $attr = 'rel="prev" title="View the Previous Page"';
    return $attr;
}
add_filter('previous_posts_link_attributes', 'get_previous_posts_link_attributes');

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

/************* WYSIWYG CLEANUP FUNCTIONS *****************/
//Apply styles to the visual editor
function scaffolding_mcekit_editor_style($url) {
	if ( !empty($url) )
		$url .= ',';
	// Retrieves the plugin directory URL and adds editor stylesheet
	// Change the path here if using different directories
	$url .= trailingslashit( get_template_directory_uri() ) . 'css/editor-styles.css';
	return $url;
}
add_filter('mce_css', 'scaffolding_mcekit_editor_style');

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

//Filter out hard-coded width, height attributes on all images in WordPress. - https://gist.github.com/4557917 - for more information
function scaffolding_remove_img_dimensions($html) {
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
add_filter('post_thumbnail_html', 'scaffolding_remove_img_dimensions', 10);
//add_filter('the_content', 'scaffolding_remove_img_dimensions', 10); //Options - This has been removed from the content filter so that clients can still edit image sizes in the editor
add_filter('get_avatar','scaffolding_remove_img_dimensions', 10);


// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function scaffolding_filter_ptags_on_images($content){
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

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

/************* CLIENT UX FUNCTIONS *****************/
function increase_editor_permissions(){
	$role = get_role('editor');
	$role->add_cap('gform_full_access'); // Gives editors access to Gravity Forms
	$role->add_cap('edit_theme_options'); // Gives editors access to widgets & menus
}
add_action('admin_init','increase_editor_permissions');

// Removes the Powered By WPEngine widget
wp_unregister_sidebar_widget( 'wpe_widget_powered_by' );

//Remove some of the admin bar links to keep from confusing client admins
function remove_admin_bar_links() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo'); // Remove Wordpress Logo From Admin Bar
	$wp_admin_bar->remove_menu('wpseo-menu'); // Remove SEO from Admin Bar
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

// Custom Backend Footer
function scaffolding_custom_admin_footer() {
	echo '<span id="footer-thankyou">Developed by <a href="http://www.hallme.com/" target="_blank">Hall Internet Marketing</a></span>. Built using <a href="https://github.com/hallme/scaffolding" target="_blank">scaffolding</a> a fork of <a href="http://themble.com/bones" target="_blank">bones</a>.';
}
add_filter('admin_footer_text', 'scaffolding_custom_admin_footer');

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
function scaffolding_login_css() {
	/* I couldn't get wp_enqueue_style to work :( */
	echo '<link rel="stylesheet" href="' . get_stylesheet_directory_uri() . '/css/login.css">';
}

// changing the logo link from wordpress.org to your site
function scaffolding_login_url() {  return home_url(); }

// changing the alt text on the logo to show your site name
function scaffolding_login_title() { return get_option('blogname'); }

// calling it only on the login page
add_action('login_head', 'scaffolding_login_css');
add_filter('login_headerurl', 'scaffolding_login_url');
add_filter('login_headertitle', 'scaffolding_login_title');


//Add page title attribute to a tags
function wp_list_pages_filter($output) {
    $output = preg_replace('/<a(.*)href="([^"]*)"(.*)>(.*)<\/a>/','<a$1 title="$4" href="$2"$3>$4</a>',$output);
    return $output;
}
add_filter('wp_list_pages', 'wp_list_pages_filter');