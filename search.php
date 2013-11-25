<?php get_header(); ?>


			<h1 class="archive-title"><span>Search Results for:</span> <?php echo esc_attr(get_search_query()); ?></h1>

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

						<header class="article-header">

							<h3 class="search-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>

							<?php
							/* Hidden by default
							<p class="byline vcard"><?php _e("Posted", "scaffoldingtheme"); ?> <time class="updated" datetime="<?php echo the_time('Y-m-j'); ?>" pubdate><?php the_time('F jS, Y'); ?></time> <?php _e("by", "scaffoldingtheme"); ?> <span class="author"><?php the_author_posts_link(); ?></span> <span class="amp">&</span> <?php _e("filed under", "scaffoldingtheme"); ?> <?php the_category(', '); ?>.</p>
							*/ ?>

						</header> <!-- end article header -->

						<section class="entry-content">
							<?php the_excerpt('<span class="read-more">Read more &raquo;</span>'); ?>

						</section> <!-- end article section -->

						<footer class="article-footer">

						</footer> <!-- end article footer -->

					</article> <!-- end article -->

				<?php endwhile; ?>

				<?php include_once('includes/template-pager.php'); //wordpress template pager/pagination ?>

			<?php else : ?>

			<?php include_once('includes/template-error.php'); //wordpress template error message ?>

			<?php endif; ?>


<?php get_footer();