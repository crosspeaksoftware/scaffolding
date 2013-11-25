<?php get_header(); ?>

		<div id="main" class="eightcol first clearfix" role="main">

			<h1 class="archive-title"><span>Search Results for:</span> <?php echo esc_attr(get_search_query()); ?></h1>

			<?php
			if (have_posts()) :
				while (have_posts()) :
					the_post(); ?>

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

				<?php
				if (function_exists('scaffolding_page_navi')) {
					scaffolding_page_navi();
				}
				else {
				?>
					<nav class="wp-prev-next">
						<ul class="clearfix">
							<li class="prev-link"><?php next_posts_link(__('&laquo; Older Entries', "scaffoldingtheme")) ?></li>
							<li class="next-link"><?php previous_posts_link(__('Newer Entries &raquo;', "scaffoldingtheme")) ?></li>
						</ul>
					</nav>
				<?php
				}
				?>

			<?php else : ?>

			<?php include_once('error.php'); //wordpress template error message ?>

			<?php endif; ?>

		</div> <!-- end #main -->

<?php get_footer();