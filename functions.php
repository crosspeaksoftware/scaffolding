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
 * 3.0 - Theme Support
 * 5.0 - Images & Headers
 * 6.0 - Sidebars
 * 7.0 - Search Functions
 * 8.0 - Comment Layout
 * 9.0 - Utility Functions
 * 10.0 - ADMIN CUSTOMIZATION
 * 11.0 CUSTOM/ADDITIONAL FUNCTIONS
 */

/**
 * Initiating Scaffolding.
 */
require get_template_directory() . '/inc/init-theme.php';

/**
 * Enqueue Scripts & Styles
 */
require get_template_directory() . '/inc/scripts-styles.php';

/************************************
 * 3.0 - THEME SUPPORT
 ************************************/

/**
 * Add rel and title attribute to next pagination link
 *
 * @since Scaffolding 1.0
 *
 * @param string $attr Previous "Next Page" rel attribute.
 * @return string New "Next Page rel attribute.
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
 *
 * @param string $attr Previous "Previous Page" rel attribute.
 * @return string New "Previous Page rel attribute.
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
 *
 * @param string $output Output from wp_list_pages.
 * @return string Modified output.
 */
function scaffolding_wp_list_pages_filter( $output ) {
	$output = preg_replace( '/<a(.*)href="([^"]*)"(.*)>(.*)<\/a>/', '<a$1 title="$4" href="$2"$3>$4</a>', $output );
	return $output;
}
add_filter( 'wp_list_pages', 'scaffolding_wp_list_pages_filter' );


/**
 * Remove the p from around imgs
 *
 * This function is called in scaffolding_build().
 *
 * @link http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/
 *
 * @since Scaffolding 1.0
 *
 * @param string $content Content to be modified.
 * @return string Modified content
 */
function scaffolding_filter_ptags_on_images( $content ) {
	return preg_replace( '/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content );
}

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
}


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
}


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
 * Custom login page CSS
 *
 * @since Scaffolding 1.0
 */
function scaffolding_login_css() {
	$login_css_version = filemtime( get_theme_file_path( '/css/login.css' ) );
	wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/css/login.css', array(), $login_css_version, 'screen' );
}
add_action( 'login_enqueue_scripts', 'scaffolding_login_css' );

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

/************************************
 * 11.0 CUSTOM/ADDITIONAL FUNCTIONS
 */

// Add your custom functions here.
