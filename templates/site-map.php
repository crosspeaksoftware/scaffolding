<?php
/**
 * Template Name: Site Map Page
 *
 * @package Scaffolding
 * @since Scaffolding 1.1
 */

get_header();

// Add post types to include in site map
$types = array( 'page', 'post' );

// Add taxonomies to include in site map
$taxes = array();

// Collect all term ids for the listed taxonomies
$terms = get_terms( $taxes, array('fields' => 'ids') );

// Collect all the excluded term ids
$excluded_term_IDs = array();

// Collect all excluded terms by taxonomy
foreach( $taxes as $tax ) {
	// Get yoast taxonomy meta
	$yoast_tax_meta = get_option('wpseo_taxonomy_meta');

	// Check if taxonomy exists in array
	if ( is_array( $yoast_tax_meta[ $tax ] ) ) {
		foreach( $terms as $term ) {
			// Check if each term exists in array and is excluded from sitemap
			if ( is_array( $yoast_tax_meta[ $tax ][ $term ] ) && 'never' == $yoast_tax_meta[ $tax ][ $term ]['wpseo_sitemap_include'] ) {
				$excluded_term_IDs[] = $term;
			}
		}
	}
}

// Collect all excluded posts for the listed post types
foreach( $types as $type ) {
	$args = array(
		'numberposts'  => -1, // get all
		'meta_key'     => '_yoast_wpseo_meta-robots-noindex', // remove post with noindex
		'meta_compare' => 'EXISTS',
		'post_type'    => $type,
		'post_status'  => 'publish',
	);
	$excluded_{$type} = get_posts( $args );
}

// Collect all the excluded post ids
$excluded_posts_IDs = array();

// Collect all the ids of posts with noindex to exclude from site map
foreach( $types as $type ) {
	foreach ( $excluded_{$type} as $excluded ) {
		$excluded_posts_IDs[] = $excluded->ID;
	}
}

// Add the current sitemap page id
$excluded_posts_IDs[] = get_the_ID();

// Convert to a comma (,) separated string
$excluded_IDs = implode( ',', $excluded_posts_IDs );

// Get number of posts per page in settings
$read_settings_num_posts = get_option('posts_per_page');

/**
 * Build display for taxonomy terms
 */
function scaffolding_list_terms( $param, $tax ) {

	// Collect our excluded term ids
	$excluded_term_IDs = $param['exclude'];

	// Get our terms
	$terms = get_terms( $tax, $param );

	if ( $terms ) {
		echo '<ul>';
		foreach ( $terms as $term ) {
			echo '<li><a href="' . get_term_link( $term->slug, $tax ) . '" title="';
			echo esc_attr( $term->name );
			echo '">';
			echo $term->name;
			echo '</a>';
			scaffolding_list_terms( array(
				'sort_column'	=> 'title',
				'parent'	=> $term->term_id,
				'hierarchical'	=> 0,
				'exclude'	=> $excluded_term_IDs
			), $tax );
			echo '</li>';
		}
		echo '</ul>';
	}

}

/**
 * Build display for posts by post type
 */
function scaffolding_list_posts( $param, $post_type ) {

	$pt = get_post_type_object( $post_type ); // Get post type object for name label
	$count_posts = wp_count_posts( $post_type ); // Count number of posts in db
	$published_posts = $count_posts->publish; // Count number of published posts, only show those
	$read_settings_num_posts = get_option('posts_per_page'); // Get number of posts per page in settings

	// Get archive link to add "View all" link
	if ( 'post' == $post_type ) {
		$archive_link = get_permalink( get_option('page_for_posts') );
	} else {
		$archive_link = get_post_type_archive_link( $post_type );
	}

	// Collect our excluded ids
	$excluded_IDs = $param['exclude'];

	// Get our posts
	$posts = get_posts( $param );

	if ( $published_posts > 0 ) {
		echo '<ul>';
		foreach ( $posts as $post ) {
			echo '<li><a href="' . get_permalink( $post->ID ) . '" title="';
				echo esc_attr( $post->post_title );
				echo '">';
				echo $post->post_title;
				echo '</a>';
			echo '</li>';
		}
		if ( $published_posts > $read_settings_num_posts ) {
			echo '<li><a href="' . $archive_link . '" title="';
				echo sprintf( __( 'View all %s', 'scaffolding' ), $pt->labels->name );
				echo '">';
				echo sprintf( __( 'View all %s', 'scaffolding' ), $pt->labels->name );
				echo '</a>';
			echo '</li>';
		}
		echo '</ul>';
	} else {
		echo sprintf( __( 'There are currently no %s.', 'scaffolding' ), $pt->labels->name );
	}

}


	if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

				<header class="page-header">

					<h1 class="page-title"><?php the_title(); ?></h1>

				</header>

				<section class="page-content clearfix">

					<?php the_content(); ?>

					<?php wp_link_pages(
						array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'scaffolding' ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
						)
					); ?>

					<div class="row">

						<div id="pages" class="col-sm-6">

							<h3><?php _e( 'Pages', 'scaffolding' ); ?></h3>
							<ul>
								<?php // List Pages
								wp_list_pages( array(
									'sort_column'	=> 'post_title',
									'title_li'	=> '',
									'exclude'	=> $excluded_IDs
								) ); ?>
							</ul>

						</div><?php // END #pages ?>

						<div id="posts" class="col-sm-6">

							<h3><?php _e( 'Blog Posts', 'scaffolding' ); ?></h3>
							<?php
							// List Posts
							$params = array(
								'numberposts'	=> $read_settings_num_posts,
								'sort_column'	=> 'title',
								'exclude' 	=> $excluded_IDs,
								'post_type'	=> 'post'
							);
							scaffolding_list_posts( $params, 'post' );
							?>

							<?php
							/* Example: List Product Categories
							$params = array(
								'sort_column'	=> 'title',
								'exclude'	=> $excluded_term_IDs,
								'parent' 	=> 0
							);
							scaffolding_list_terms( $params, 'product_cat' );
							*/ ?>

						</div><?php // END #posts ?>

					</div><?php // END .row ?>

				</section>

			</article>

		<?php endwhile; ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/error' ); // WordPress template error message ?>

	<?php endif; ?>

<?php get_footer();
