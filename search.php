<?php 
/**
 * Search Results Template
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Scaffolding
 * @since Scaffolding 1.0
 */

get_header(); ?>

		<div itemscope itemtype="http://schema.org/SearchResultsPage">

			<h1 class="archive-title"><span>Search Results for:</span> <?php echo esc_attr( get_search_query() ); ?></h1>

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article">

						<header class="article-header">

							<h2 class="entry-title search-title h3"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

							<?php
							/* Hidden by default
							<p class="byline vcard"><?php _e( 'Posted', 'scaffolding' ); ?> <time class="updated" datetime="<?php echo the_time('Y-m-j'); ?>" pubdate><?php the_time('F jS, Y'); ?></time> <?php _e( 'by', 'scaffolding' ); ?> <span class="author"><?php the_author_posts_link(); ?></span> <span class="amp">&</span> <?php _e( 'filed under', 'scaffolding' ); ?> <?php the_category(', '); ?>.</p>
							*/ ?>

						</header><?php // END .article-header ?>

						<section class="entry-content" itemprop="description">
							
							<?php the_excerpt('<span class="read-more">Read more &raquo;</span>'); ?>

						</section><?php // END .article-section ?>

						<?php /* Hidden By Default - no content
						<footer class="article-footer">
						</footer><?php // END .article-footer ?>
						*/ ?>

					</article><?php // END article ?>

				<?php endwhile; ?>

				<?php get_template_part( 'templates/include', 'pager' ); // WordPress template pager/pagination ?>

			<?php else : ?>

				<?php get_template_part( 'templates/include', 'error' ); // WordPress template error message ?>

			<?php endif; ?>

		</div>

<?php get_footer();