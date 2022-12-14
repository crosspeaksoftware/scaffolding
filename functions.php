<?php
/**
 * Scaffolding Main Functions
 *
 * Add custom functions and edit thumbnail sizes, header images, sidebars, menus, etc.
 *
 * @link https://github.com/hallme/scaffolding
 * @link http://scaffolding.io
 * @link https://codex.wordpress.org/Theme_Development
 *
 * @package Scaffolding
 *
 * @todo language support, customizer functions
 *
 * Table of Contents
 *
 * 4.0 - Menus & Navigation
 * 5.0 - Images & Headers
 * 6.0 - Sidebars
 * 7.0 - Search Functions
 * 8.0 - Comment Layout
 * 9.0 - Utility Functions
 *    9.1 - Removes […] from read more
 *    9.2 - Modified author post link
 *    9.3 - Posted on meta
 * 10.0 - Admin Customization
 *    10.1 - Set content width
 *    10.2 - Set image attachment width
 *    10.3 - Disable default dashboard widgets
 *    10.4 - Change name of "Posts" in admin menu
 * 11.0 - Custom/Additional Functions
 */

// Useful global constants.
define( 'SCAFFOLDING_VERSION', '4.0.0' );
define( 'SCAFFOLDING_TEMPLATE_URL', get_template_directory_uri() );
define( 'SCAFFOLDING_PATH', get_template_directory() . '/' );
define( 'SCAFFOLDING_DIST_PATH', SCAFFOLDING_PATH . 'dist/' );
define( 'SCAFFOLDING_DIST_URL', SCAFFOLDING_TEMPLATE_URL . '/dist/' );
define( 'SCAFFOLDING_INC', SCAFFOLDING_PATH . 'includes/' );

// Add additional include files.
require_once SCAFFOLDING_INC . 'base-functions.php';
require_once SCAFFOLDING_INC . 'styles-scripts.php';
require_once SCAFFOLDING_INC . 'class-scaffolding-walker-nav-menu.php';

/************************************
 * 4.0 - MENUS & NAVIGATION
 ************************************/

/**
 * Two menus included - main menu in header and footer menu
 *
 * Add any additional menus here. Register new menu in scaffolding_theme_support() above.
 *
 * @since Scaffolding 1.0
 */

/**
 * Main navigation menu
 *
 * @see Scaffolding_Walker_Nav_Menu
 * @return void
 */
function scaffolding_main_nav() {
	wp_nav_menu(
		array(
			'container'       => '',                                     // remove nav container.
			'container_class' => '',                                     // class of container (should you choose to use it).
			'menu'            => '',                                     // nav name.
			'menu_class'      => 'menu main-menu',                       // adding custom nav class.
			'theme_location'  => 'main-nav',                             // where it's located in the theme.
			'before'          => '',                                     // before the menu.
			'after'           => '',                                     // after the menu.
			'link_before'     => '',                                     // before each link.
			'link_after'      => '',                                     // after each link.
			'depth'           => 0,                                      // limit the depth of the nav.
			'fallback_cb'     => '',                                     // fallback function.
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'walker'          => new Scaffolding_Walker_Nav_Menu(),
		)
	);
} // end scaffolding_main_nav()

/**
 * Footer menu (should you choose to use one)
 *
 * @return void
 */
function scaffolding_footer_nav() {
	wp_nav_menu(
		array(
			'container'       => '',
			'container_class' => '',
			'menu'            => '',
			'menu_class'      => 'menu footer-menu',
			'theme_location'  => 'footer-nav',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'depth'           => 1,                  // only display top level items.
			'fallback_cb'     => '__return_false',
		)
	);
} // end scaffolding_footer_nav()


/************************************
 * 5.0 - IMAGES & HEADERS
 ************************************/

/**
 * Add additional image sizes
 *
 * Function called in scaffolding_build() in base-functions.php.
 * Ex. add_image_size( 'scaffolding-thumb-600', 600, 150, true );
 *
 * @since Scaffolding 1.0
 */
function scaffolding_add_image_sizes() {}

/**
 * Register custom image headers
 *
 * @since Scaffolding 1.0
 */
register_default_headers(
	array(
		'default' => array(
			'url'           => get_template_directory_uri() . '/images/headers/default.jpg',
			'thumbnail_url' => get_template_directory_uri() . '/images/headers/default.jpg',
			'description'   => __( 'default', 'scaffolding' ),
		),
	)
);

/**
 * Set header image as a BG
 *
 * This is a callback function defined in scaffolding_theme_support() 'custom-header'.
 *
 * @since Scaffolding 1.0
 */
function scaffolding_custom_headers_callback() {
	if ( has_header_image() ) {
		?>
<style type="text/css">#banner { display: block; background-image: url(<?php header_image(); ?>); }</style>
		<?php
	}
} // end scaffolding_custom_headers_callback()


/************************************
 * 6.0 - SIDEBARS
 ************************************/

/**
 * Sidebars & Widgets Areas
 *
 * Two sidebars registered - left and right.
 * Define additional sidebars here.
 *
 * @since Scaffolding 1.0
 */
function scaffolding_register_sidebars() {
	register_sidebar(
		array(
			'id'            => 'footer-area-one',
			'name'          => __( 'Footer Area - One', 'scaffolding' ),
			'description'   => __( 'Left column footer area.', 'scaffolding' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<span class="widgettitle h4 d-block">',
			'after_title'   => '</span>',
		)
	);
	register_sidebar(
		array(
			'id'            => 'footer-area-two',
			'name'          => __( 'Footer Area - Two', 'scaffolding' ),
			'description'   => __( 'Center column footer area.', 'scaffolding' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<span class="widgettitle h4 d-block">',
			'after_title'   => '</span>',
		)
	);
	register_sidebar(
		array(
			'id'            => 'footer-area-three',
			'name'          => __( 'Footer Area - Three', 'scaffolding' ),
			'description'   => __( 'Right column footer area.', 'scaffolding' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<span class="widgettitle h4 d-block">',
			'after_title'   => '</span>',
		)
	);
} // end scaffolding_register_sidebars()


/************************************
 * 7.0 - SEARCH FUNCTIONS
 ************************************/

/**
 * Filter posts from query that are set to 'noindex'
 *
 * This function is dependent on Yoast SEO Plugin.
 *
 * @since Scaffolding 1.1
 * @param WP_Query $query WP_Query instance.
 */
function scaffolding_noindex_filter( $query ) {
	if ( ! is_admin() && $query->is_search() && defined( 'WPSEO_VERSION' ) ) {
		$meta_query = $query->get( 'meta_query' );
		if ( is_array( $meta_query ) ) {
			$meta_query[] = array(
				'key'     => '_yoast_wpseo_meta-robots-noindex',
				'compare' => 'NOT EXISTS',
			);
			$query->set( 'meta_query', $meta_query );
		} else {
			$meta_query = array(
				array(
					'key'     => '_yoast_wpseo_meta-robots-noindex',
					'compare' => 'NOT EXISTS',
				),
			);
			$query->set( 'meta_query', $meta_query );
		}
	}
	return $query;
}
add_action( 'pre_get_posts', 'scaffolding_noindex_filter' );


/************************************
 * 8.0 - COMMENT LAYOUT
 ************************************/

/**
 * Comment Layout
 *
 * @since Scaffolding 1.0
 * @param WP_Comment $comment Comment object.
 * @param array      $args Array of arguments.
 * @param int        $depth Comment depth/nesting.
 */
function scaffolding_comments( $comment, $args, $depth ) {
	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
	?>
	<<?php echo $tag; // phpcs:ignore ?> <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="comment-body clearfix">
			<header class="comment-author vcard">
				<?php
				if ( 0 !== $args['avatar_size'] ) {
					echo get_avatar( $comment, $args['avatar_size'], '', get_comment_author() );
				}
				?>
				<cite class="fn"><?php echo get_comment_author_link(); ?></cite>
				<time datetime="<?php echo esc_attr( comment_time( 'Y-m-d' ) ); ?>">
					<a class="comment-date-link" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><?php comment_time( 'F jS, Y' ); ?></a>
					<?php edit_comment_link( __( '(Edit)', 'scaffolding' ), '<em>', '</em>' ); ?>
				</time>
			</header>
			<?php if ( '0' === $comment->comment_approved ) : ?>
				<div class="alert info">
					<p><?php esc_html_e( 'Your comment is awaiting moderation.', 'scaffolding' ); ?></p>
				</div>
			<?php endif; ?>
			<div class="comment-content clearfix"><?php comment_text(); ?></div>
			<?php
			comment_reply_link(
				array_merge(
					$args,
					array(
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
					)
				)
			);
			?>
		</article>
	<?php
	// </li> or </div> is added by WordPress automatically.
} // end scaffolding_comments()


/************************************
 * 9.0 - UTILITY FUNCTIONS
 *     9.1 - Removes […] from read more
 *     9.2 - Modified author post link
 *     9.3 - Posted on meta
 ************************************/

/**
 * Removes the annoying […] to a Read More link
 *
 * @since Scaffolding 1.0
 * @global post
 * @param  string $more Initial more text.
 * @return string new more text.
 */
function scaffolding_excerpt_more( $more ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	global $post;
	/* translators: 1: post permalink, 2: post title */
	return sprintf( __( '&hellip; <a class="read-more" href="%1$s" title="Read %2$s">Read more &raquo;</a>', 'scaffolding' ), get_permalink( $post->ID ), get_the_title( $post->ID ) );
}

/**
 * Modifies author post link which just returns the link
 *
 * This is necessary to allow usage of the usual l10n process with printf().
 *
 * @since Scaffolding 1.0
 * @global authordata
 */
function scaffolding_get_the_author_posts_link() {
	global $authordata;
	if ( ! is_object( $authordata ) ) {
		return false;
	}
	$link = sprintf(
		'<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
		get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
		/* translators: author name */
		esc_attr( sprintf( __( 'Posts by %s', 'scaffolding' ), get_the_author() ) ),
		get_the_author()
	);
	return $link;
}

/**
 * Build post meta
 */
function scaffolding_post_meta() {
	if ( 'post' !== get_post_type() ) {
		return;
	}

	// Posted on.
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$output_time_string = sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>', esc_url( get_permalink() ), $time_string );

	$posted_on = '
		<span class="posted-on">' .
		/* translators: %s: post date */
		sprintf( __( 'Posted %s', 'scaffolding' ), $output_time_string ) .
		'</span>';

	// Author.
	$author = sprintf(
		'<span class="post-author">%1$s %2$s</span>',
		__( 'by', 'scaffolding' ),
		scaffolding_get_the_author_posts_link()
	);

	// Categories.
	$categories = sprintf(
		'<span class="post-categories"><span class="amp">&amp;</span> %1$s %2$s</span>',
		__( 'filed under', 'scaffolding' ),
		get_the_category_list( __( ', ', 'scaffolding' ) )
	);

	// Comments.
	$comments = '';

	if ( ! post_password_required() && ( comments_open() || 0 !== intval( get_comments_number() ) ) ) {
		$comments_number = get_comments_number_text( __( 'Leave a comment', 'scaffolding' ), __( '1 Comment', 'scaffolding' ), __( '% Comments', 'scaffolding' ) );

		$comments = sprintf(
			'<span class="post-comments">&mdash; <a href="%1$s">%2$s</a></span>',
			esc_url( get_comments_link() ),
			$comments_number
		);
	}

	echo '<p class="entry-meta">' . wp_kses(
		sprintf( '%1$s %2$s %3$s %4$s', $posted_on, $author, $categories, $comments ),
		array(
			'span' => array(
				'class' => array(),
			),
			'a'    => array(
				'href'  => array(),
				'title' => array(),
				'rel'   => array(),
			),
			'time' => array(
				'datetime' => array(),
				'class'    => array(),
			),
		)
	) . '</p>';
}


/************************************
 * 10.0 - ADMIN CUSTOMIZATION
 *     10.1 - Set content width
 *     10.2 - Set image attachment width
 *     10.3 - Disable default dashboard widgets
 *     10.4 - Change name of "Posts" in admin menu
 */

// Set up the content width value based on the theme's design.
if ( ! isset( $content_width ) ) {
	$content_width = 1170; // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
}

/**
 * Adjust content_width value for image attachment template
 *
 * @since Scaffolding 1.0
 */
function scaffolding_content_width() {
	if ( is_attachment() && wp_attachment_is_image() ) {
		$GLOBALS['content_width'] = 810; // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	}
}
add_action( 'template_redirect', 'scaffolding_content_width' );

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
 * Change name of "Posts" menu
 *
 * This is useful for improving UX in the WP backend.
 *
 * @since Scaffolding 1.0
 * @global menu, submenu
 */

/* // phpcs:ignore Squiz.PHP.CommentedOutCode.Found
// Not currently in use.
function scaffolding_change_post_menu_label() {
	global $menu;
	global $submenu;
	$menu[5][0] = 'News';
	$submenu['edit.php'][5][0]  = 'All News Entries';
	$submenu['edit.php'][10][0] = 'Add News Entries';
	$submenu['edit.php'][15][0] = 'Categories'; // Change name for categories
	$submenu['edit.php'][16][0] = 'Tags'; // Change name for tags
	echo '';
}
add_action( 'admin_menu', 'scaffolding_change_post_menu_label' );
*/

/**
 * Change labels for "Posts"
 *
 * This is useful for improving UX in the WP backend.
 *
 * @since Scaffolding 1.0
 * @global wp_post_types
 */

/* // phpcs:ignore Squiz.PHP.CommentedOutCode.Found
// Not currently in use.
function scaffolding_change_post_object_label() {
	global $wp_post_types;
	$labels                        = &$wp_post_types['post']->labels;
	$labels->name                  = 'News';
	$labels->singular_name         = 'News';
	$labels->add_new               = 'Add News Entry';
	$labels->add_new_item          = 'Add News Entry';
	$labels->edit_item             = 'Edit News Entry';
	$labels->new_item              = 'News Entry';
	$labels->view_item             = 'View Entry';
	$labels->search_items          = 'Search News Entries';
	$labels->not_found             = 'No News Entries found';
	$labels->not_found_in_trash    = 'No News Entries found in Trash';
}
add_action( 'init', 'scaffolding_change_post_object_label' );
*/


/************************************
 * 11.0 CUSTOM/ADDITIONAL FUNCTIONS
 */

// Add your custom functions here.
