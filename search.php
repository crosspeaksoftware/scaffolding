<?php get_header(); ?>

		<div itemscope itemtype="http://schema.org/SearchResultsPage">

			<h1 class="archive-title"><span>Search Results for:</span> <?php echo esc_attr(get_search_query()); ?></h1>

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

						<header class="article-header">

							<h3 class="entry-title search-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>

							<?php
							/* Hidden by default
							<p class="byline vcard"><?php _e("Posted", "scaffolding"); ?> <time class="updated" datetime="<?php echo the_time('Y-m-j'); ?>" pubdate><?php the_time('F jS, Y'); ?></time> <?php _e("by", "scaffolding"); ?> <span class="author"><?php the_author_posts_link(); ?></span> <span class="amp">&</span> <?php _e("filed under", "scaffolding"); ?> <?php the_category(', '); ?>.</p>
							*/ ?>

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