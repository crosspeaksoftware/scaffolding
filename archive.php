<?php
/**
 * Archive Template
 *
 * Default template for displaying archives (categories, tags, taxonomies, dates, authors, etc.).
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Scaffolding
 * @since Scaffolding 1.0
 */

get_header(); ?>

	<?php if ( have_posts() ) : ?>

		<header class="page-header">

			<h1 class="archive-title">
				<?php
				if ( is_category() ) :
					$current_category = single_cat_title( '', false );
					printf( __( 'Category: %s', 'scaffolding' ), $current_category );

				elseif ( is_tag() ) :
					$current_tag = single_tag_title( '', false );
					printf( __( 'Tag: %s', 'scaffolding' ), $current_tag );

				elseif ( is_author() ) :
					printf( __( 'Author Archive: %s', 'scaffolding' ), '<span class="vcard">' . get_the_author() . '</span>' );

				elseif ( is_day() ) :
					printf( __( 'Daily Archives: %s', 'scaffolding' ), '<span>' . get_the_date() . '</span>' );

				elseif ( is_month() ) :
					printf( __( 'Monthly Archives: %s', 'scaffolding' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'scaffolding' ) ) . '</span>' );

				elseif ( is_year() ) :
					printf( __( 'Yearly Archives: %s', 'scaffolding' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'scaffolding' ) ) . '</span>' );

				/* Currently commented out, uncomment if post formats are supported
				elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
					_e( 'Asides', 'scaffolding' );

				elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
					_e( 'Galleries', 'scaffolding' );

				elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
					_e( 'Images', 'scaffolding' );

				elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
					_e( 'Videos', 'scaffolding' );

				elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
					_e( 'Quotes', 'scaffolding' );

				elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
					_e( 'Links', 'scaffolding' );

				elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
					_e( 'Statuses', 'scaffolding' );

				elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
					_e( 'Audios', 'scaffolding' );

				elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
					_e( 'Chats', 'scaffolding' );
				*/

				elseif ( is_tax() ) :
					$current_taxonomy = single_term_title( '', false );
					printf( __( 'Term: %s', 'scaffolding' ), $current_taxonomy );

				else :
					_e( 'Archives', 'scaffolding' );

				endif;
				?>
			</h1>

		<?php
			// Show an optional term description.
			$term_description = term_description();
			if ( ! empty( $term_description ) ) {
				printf( '<div class="taxonomy-description">%s</div>', $term_description );
			}
		?>

		</header><?php // END .page-header ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article">

				<header class="article-header">

					<h3 class="entry-title h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>


					<p class="byline"><?php printf( __( 'Posted <time class="updated" datetime="%1$s">%2$s</time> by <span class="author">%3$s</span> <span class="amp">&amp;</span> filed under %4$s.', 'scaffolding' ), get_the_time( 'Y-m-d' ), get_the_time( get_option( 'date_format' ) ), scaffolding_get_the_author_posts_link(), get_the_category_list( ', ' ) ); ?></p>

				</header><?php // END .article-header ?>

				<section class="entry-content clearfix">

					<?php //the_post_thumbnail(); ?>

					<?php the_excerpt(); ?>

				</section><?php // END .entry-content ?>

				<?php /* Hidden By Default - no content
				<footer class="article-footer">
				</footer><?php // END .article-footer ?>
				*/ ?>

			</article><?php // END post article ?>

		<?php endwhile; ?>

		<?php get_template_part( 'template-parts/pager' ); // WordPress template pager/pagination ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/error' ); // WordPress template error message ?>

	<?php endif; ?>

<?php get_footer();
