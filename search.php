<?php get_header(); ?>

		<div itemscope itemtype="http://schema.org/SearchResultsPage">

			<h1 class="archive-title"><span>Search Results for:</span> <?php echo esc_attr(get_search_query()); ?></h1>

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('post-index clearfix'); ?> role="article">

						<header class="article-header">

							<h2 class="entry-title search-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

							<?php if( 'page' != get_post_type() ): ?>
								<p class="byline vcard"><?php printf(__('Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time>', 'scaffolding'), get_the_time('Y-m-j'), get_the_time(get_option('date_format'))); ?></p>
							<?php endif; ?>

						</header><?php // end article header ?>

						<section class="entry-content" itemprop="description">

							<?php the_excerpt('<span class="read-more">Read more &raquo;</span>'); ?>

						</section><?php // end article section ?>

						<footer class="article-footer">

						</footer><?php // end article footer ?>

					</article><?php // end article ?>

				<?php endwhile; ?>

				<?php get_template_part('includes/template','pager'); // WordPress template pager/pagination ?>

			<?php else : ?>

			<?php get_template_part('includes/template','error'); // WordPress template error message ?>

			<?php endif; ?>

		</div>

<?php get_footer();