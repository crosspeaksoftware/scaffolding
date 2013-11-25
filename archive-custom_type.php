<?php get_header(); ?>

		<div id="main" class="eightcol first clearfix" role="main">

			<h1 class="archive-title h2"><?php post_type_archive_title(); ?></h1>

			<?php
			if (have_posts()) :
				while (have_posts()) :
					the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

						<header class="article-header">

							<h3 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>

							<?php
							/* Hidden by default
							<p class="byline vcard"><?php printf(__('Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span>.', 'scaffoldingtheme'), get_the_time('Y-m-j'), get_the_time(__('F jS, Y', 'scaffoldingtheme')), scaffolding_get_the_author_posts_link()); ?></p>
							*/ ?>

						</header> <!-- end article header -->

						<section class="entry-content clearfix">

							<?php the_excerpt(); ?>

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