<?php
/**
 * Template Name: Site Map Page
 *
 * @package scaffolding
 */

get_header();

/**
 * Return array of excluded term IDs
 * Yoast settings - term meta set to noindex
 *
 * @param string $tax Taxonomy name.
 */
function scaffolding_excluded_terms( $tax ) {
	$excluded_term_ids = array();

	// Get yoast taxonomy meta.
	$yoast_tax_meta = get_option( 'wpseo_taxonomy_meta', array() );

	if ( ! empty( $yoast_tax_meta ) ) {
		// Check if taxonomy exists in yoast meta.
		if ( array_key_exists( $tax, $yoast_tax_meta ) ) {
			// Collect all term ids for the taxonomy.
			$terms = get_terms( $tax, array( 'fields' => 'ids' ) );

			foreach ( $terms as $term ) {
				if ( isset( $yoast_tax_meta[ $tax ] ) && ! empty( $yoast_tax_meta[ $tax ][ $term ] ) ) {
					$term_seo = $yoast_tax_meta[ $tax ][ $term ];
					// Check if each term exists in array and is excluded from sitemap.
					if ( isset( $term_seo['wpseo_sitemap_include'] ) && 'never' === $term_seo['wpseo_sitemap_include'] ) {
						$excluded_term_ids[] = $term;
					}
					if ( isset( $term_seo['wpseo_noindex'] ) && 'noindex' === $term_seo['wpseo_noindex'] ) {
						$excluded_term_ids[] = $term;
					}
				}
			}
		}
	}
	return $excluded_term_ids;
}

/**
 * Return array of excluded post IDs
 * Yoast settings - post meta set to noindex
 *
 * @param string $post_type Post type name.
 */
function scaffolding_excluded_posts( $post_type ) {
	$excluded_post_ids = array();
	$args              = array(
		'posts_per_page' => -1, // get all.
		'meta_key'       => '_yoast_wpseo_meta-robots-noindex', // remove post with noindex.
		'meta_compare'   => 'EXISTS',
		'post_type'      => $post_type,
		'post_status'    => 'publish',
	);
	$posts             = get_posts( $args );

	foreach ( $posts as $post ) {
		$excluded_post_ids[] = $post->ID;
	}

	// Add the current sitemap page id.
	$excluded_post_ids[] = get_the_ID();

	// Convert to a comma (,) separated string.
	return implode( ',', $excluded_post_ids );
}

/**
 * Build display for taxonomy terms
 *
 * @param string $tax  Taxonomy name.
 * @param array  $args Array of arguments.
 */
function scaffolding_list_terms( $tax, $args = array() ) {

	// Get our terms.
	if ( ! array_key_exists( 'sort_column', $args ) ) {
		$args['sort_column'] = 'title';
	}
	if ( ! array_key_exists( 'parent', $args ) ) {
		$args['parent'] = 0;
	}
	// Get list of terms to exclude via Yoast settings.
	if ( ! array_key_exists( 'exclude', $args ) ) {
		$excluded_term_ids = scaffolding_excluded_terms( $tax );
		if ( ! empty( $excluded_term_ids ) ) {
			$args['exclude'] = $excluded_term_ids;
		}
	}
	$terms = get_terms( $tax, $args );

	// Display our terms.
	if ( $terms ) {
		echo '<ul>';
		foreach ( $terms as $term ) {
			echo '<li><a href="' . esc_url( get_term_link( $term->slug, $tax ) ) . '" title="';
			echo esc_attr( $term->name );
			echo '">';
			echo esc_html( $term->name );
			echo '</a>';
			$args['parent']       = $term->term_id;
			$args['hierarchical'] = 0;
			scaffolding_list_terms( $tax, $args );
			echo '</li>';
		}
		echo '</ul>';
	}

}

/**
 * Build display for posts by post type
 *
 * @param string $post_type Post type we are dealing with.
 * @param array  $args      Options passed in.
 * @return void
 */
function scaffolding_list_posts( $post_type, $args = array() ) {

	$pt              = get_post_type_object( $post_type ); // Get post type object for name label.
	$count_posts     = wp_count_posts( $post_type );       // Count number of posts in db.
	$published_posts = $count_posts->publish;              // Count number of published posts, only show those.
	$num_posts       = 20;                                 // Number of posts to display per page.

	// Get archive url to add "View all" link.
	if ( 'post' === $post_type ) {
		$archive_link = get_permalink( get_option( 'page_for_posts' ) );
	} else {
		$archive_link = get_post_type_archive_link( $post_type );
	}

	// Get our posts.
	if ( ! array_key_exists( 'post_type', $args ) ) {
		$args['post_type'] = $post_type;
	}
	if ( ! array_key_exists( 'posts_per_page', $args ) ) {
		$args['posts_per_page'] = $num_posts;
	}
	if ( ! array_key_exists( 'sort_column', $args ) ) {
		$args['sort_column'] = 'title';
	}

	// Get list of ids to exclude via Yoast settings.
	if ( ! array_key_exists( 'exclude', $args ) ) {
		$excluded_post_ids = scaffolding_excluded_posts( $post_type );
		if ( ! empty( $excluded_post_ids ) ) {
			$args['exclude'] = $excluded_post_ids;
		}
	}
	$posts = get_posts( $args );

	// Display our posts.
	if ( $published_posts > 0 ) {
		echo '<ul>';
		foreach ( $posts as $post ) {
			echo '<li><a href="' . esc_url( get_permalink( $post->ID ) ) . '" title="';
				echo esc_attr( $post->post_title );
				echo '">';
				echo esc_html( $post->post_title );
				echo '</a>';
			echo '</li>';
		}
		if ( $published_posts > $num_posts ) {
			echo '<li><a href="' . esc_url( $archive_link ) . '" title="';
				/* translators: View all link title */
				echo esc_attr( sprintf( __( 'View All %s', 'scaffolding' ), $pt->labels->name ) );
				echo '">';
				/* translators: View all link text */
				echo esc_attr( sprintf( __( 'View All %s', 'scaffolding' ), $pt->labels->name ) );
				echo '</a>';
			echo '</li>';
		}
		echo '</ul>';
	} else {
		/* translators: No posts text */
		echo esc_html( sprintf( __( 'There are currently no %s.', 'scaffolding' ), $pt->labels->name ) );
	}

}
?>

<div id="inner-content">

	<div id="main" class="clearfix sitemap" role="main">

		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article">

					<header class="page-header">

						<h1 class="page-title"><?php the_title(); ?></h1>

					</header>

					<section class="page-content clearfix">

						<?php
						the_content();

						wp_link_pages(
							array(
								'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'scaffolding' ) . '</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
							)
						);
						?>

						<div class="sitemap__row">

							<div class="sitemap__col">

								<h3><?php esc_html_e( 'Pages', 'scaffolding' ); ?></h3>
								<ul>
									<?php
									$scaffolding_page_args         = array(
										'sort_column' => 'post_title',
										'title_li'    => '',
									);
									$scaffolding_excluded_page_ids = scaffolding_excluded_posts( 'page' );
									if ( ! empty( $scaffolding_excluded_page_ids ) ) {
										$scaffolding_page_args['exclude'] = $scaffolding_excluded_page_ids;
									}
									wp_list_pages( $scaffolding_page_args );
									?>
								</ul>

							</div>

							<div class="sitemap__col">

								<h3><?php esc_html_e( 'Blog Posts', 'scaffolding' ); ?></h3>
								<?php scaffolding_list_posts( 'post' ); ?>

								<?php
								/*
								// Example with term list.
								<h3><?php _e( 'Blog Categories', 'scaffolding' ); ?></h3>
								<?php scaffolding_list_terms('category'); ?>
								*/
								?>

							</div>

						</div

					</section>

				</article>

				<?php
			endwhile;

		else :

			get_template_part( 'template-parts/error' ); // WordPress template error message.

		endif;
		?>

	</div><?php // END #main. ?>

</div><?php // END #inner-content. ?>

<?php
get_footer();
