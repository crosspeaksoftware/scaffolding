<?php
/**
 * Template Name: Site Map Page
 *
 * @package Scaffolding
 */

get_header();

global $sc_layout_class;

/**
 * Return array of excluded term IDs
 * Yoast settings - term meta set to noindex
 */
function scaffolding_excluded_terms( $tax ) {
	
	$excluded_term_IDs = array();

	// Get yoast taxonomy meta
	$yoast_tax_meta = get_option( 'wpseo_taxonomy_meta', array() );

	if ( ! empty( $yoast_tax_meta ) ) {
		
		// Check if taxonomy exists in yoast meta
		if ( array_key_exists( $tax, $yoast_tax_meta ) ) {

			// Collect all term ids for the taxonomy
			$terms = get_terms( $tax, array('fields' => 'ids') );

			foreach( $terms as $term ) {
				$term_seo = ( array_key_exists( $term, $yoast_tax_meta[ $tax ] ) ) ? $yoast_tax_meta[ $tax ][ $term ] : '';
				
				// Check if each term exists in array and is excluded from sitemap
				if ( $term_seo && ( 'never' == $term_seo['wpseo_sitemap_include'] || 'noindex' == $term_seo['wpseo_noindex'] ) ) {
					$excluded_term_IDs[] = $term;
				}
			}

		}
		
	}
	
	return $excluded_term_IDs;
	
}

/**
 * Return array of excluded post IDs
 * Yoast settings - post meta set to noindex
 */
function scaffolding_excluded_posts( $post_type ) {
	
	$excluded_post_IDs = array();

	$args = array(
		'posts_per_page'  => -1, // get all
		'meta_key'     => '_yoast_wpseo_meta-robots-noindex', // remove post with noindex
		'meta_compare' => 'EXISTS',
		'post_type'    => $post_type,
		'post_status'  => 'publish',
	);
	$posts = get_posts( $args );

	foreach ( $posts as $post ) {
		$excluded_post_IDs[] = $post->ID;
	}

	// Add the current sitemap page id
	$excluded_post_IDs[] = get_the_ID();

	// Convert to a comma (,) separated string
	return implode( ',', $excluded_post_IDs );
	
}

/**
 * Build display for taxonomy terms
 */
function scaffolding_list_terms( $tax, $args = array() ) {

	// Get our terms
	if ( ! array_key_exists( 'sort_column', $args ) ) {
		$args['sort_column'] = 'title';
	}
	if ( ! array_key_exists( 'parent', $args ) ) {
		$args['parent'] = 0;
	}
	// Get list of terms to exclude via Yoast settings
	if ( ! array_key_exists( 'exclude', $args ) ) {
		$excluded_term_IDs = scaffolding_excluded_terms( $tax );
		if ( ! empty( $excluded_term_IDs ) ) {
			$args['exclude'] = $excluded_term_IDs;
		}
	}
	$terms = get_terms( $tax, $args );

	// Display our terms
	if ( $terms ) {
		echo '<ul>';
		foreach ( $terms as $term ) {
			echo '<li><a href="' . get_term_link( $term->slug, $tax ) . '" title="';
			echo esc_attr( $term->name );
			echo '">';
			echo $term->name;
			echo '</a>';
			$args['parent'] = $term->term_id;
			$args['hierarchical'] = 0;
			scaffolding_list_terms( $tax, $args );
			echo '</li>';
		}
		echo '</ul>';
	}

}

/**
 * Build display for posts by post type
 */
function scaffolding_list_posts( $post_type, $args = array() ) {

	$pt = get_post_type_object( $post_type ); // Get post type object for name label
	$count_posts = wp_count_posts( $post_type ); // Count number of posts in db
	$published_posts = $count_posts->publish; // Count number of published posts, only show those
	$num_posts = 20;

	// Get archive url to add "View all" link
	if ( 'post' == $post_type ) {
		$archive_link = get_permalink( get_option('page_for_posts') );
	} else {
		$archive_link = get_post_type_archive_link( $post_type );
	}

	// Get our posts
	if ( ! array_key_exists( 'post_type', $args ) ) {
		$args['post_type'] = $post_type;
	}
	if ( ! array_key_exists( 'posts_per_page', $args ) ) {
		$args['posts_per_page'] = $num_posts;
	}
	if ( ! array_key_exists( 'sort_column', $args ) ) {
		$args['sort_column'] = 'title';
	}
	// Get list of ids to exclude via Yoast settings
	if ( ! array_key_exists( 'exclude', $args ) ) {
		$excluded_post_IDs = scaffolding_excluded_posts( $post_type );
		if ( ! empty( $excluded_post_IDs ) ) {
			$args['exclude'] = $excluded_post_IDs;
		}
	}
	$posts = get_posts( $args );

	// Display our posts
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
		if ( $published_posts > $num_posts ) {
			echo '<li><a href="' . $archive_link . '" title="';
				echo sprintf( __( 'View All %s', 'scaffolding' ), $pt->labels->name );
				echo '">';
				echo sprintf( __( 'View All %s', 'scaffolding' ), $pt->labels->name );
				echo '</a>';
			echo '</li>';
		}
		echo '</ul>';
	} else {
		echo sprintf( __( 'There are currently no %s.', 'scaffolding' ), $pt->labels->name );
	}

}
?>

<div id="inner-content" class="container">

	<div class="row <?php echo $sc_layout_class['row']; ?>">

		<div id="main" class="<?php echo $sc_layout_class['main']; ?> clearfix" role="main">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

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

								<div class="col-md-6">

									<h3><?php _e( 'Pages', 'scaffolding' ); ?></h3>
									<ul>
										<?php 
										$page_args = array(
											'sort_column' 	=> 'post_title',
											'title_li'		=> ''
										);
										$excluded_page_IDs = scaffolding_excluded_posts('page');
										if ( ! empty( $excluded_page_IDs ) ) {
											$page_args['exclude'] = $excluded_page_IDs;
										}
										wp_list_pages( $page_args ); 
										?>
									</ul>

								</div>

								<div class="col-md-6">

									<h3><?php _e( 'Blog Posts', 'scaffolding' ); ?></h3>
									<?php scaffolding_list_posts('post'); ?>

									<?php 
									// Example with term list
									/*
									<h3><?php _e( 'Blog Categories', 'scaffolding' ); ?></h3>
									<?php scaffolding_list_terms('category'); ?>
									*/
									?>

								</div>

							</div><?php // END .row ?>

						</section>

					</article>

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'template-parts/error' ); // WordPress template error message ?>

			<?php endif; ?>
			
		<?php get_sidebar(); ?>
		
	</div><?php // END .row ?>
	
</div><?php // END #inner-content ?>

<?php get_footer();
