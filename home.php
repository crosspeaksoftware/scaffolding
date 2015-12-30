<?php
/**
 * Page for Posts Template as defined in Settings->Reading
 *
 * Used to display blog archive.
 *
 * @see http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Scaffolding
 * @since Scaffolding 1.0
 */

get_header(); ?>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article">

				<header class="article-header">

					<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

					<p class="byline vcard"><?php printf( __( 'Posted <time class="updated" datetime="%1$s"><a href="%5$s" title="%6$s">%2$s</a></time> by <span class="author">%3$s</span> <span class="amp">&amp;</span> filed under %4$s.', 'scaffolding' ), get_the_time( 'Y-m-d' ), get_the_time( get_option( 'date_format' ) ), scaffolding_get_the_author_posts_link(), get_the_category_list( ', ' ), get_permalink(), the_title_attribute( array( 'echo' => false ) ) ); ?></p>

				</header>

				<section class="entry-content clearfix">

					<?php the_content('Read More...'); ?>

				</section>

				<footer class="article-footer">

					<?php if ( get_the_tag_list() ) :
						echo get_the_tag_list( '<p class="tags"><span class="meta-title">Tags:</span> ', ', ', '</p>' );
					endif; ?>

				</footer>

			</article>

		<?php endwhile; ?>

		<?php get_template_part( 'template-parts/pager' ); // WordPress template pager/pagination ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/error' ); // WordPress template error message ?>

	<?php endif; ?>

<?php get_footer();
