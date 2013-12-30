<?php get_header(); ?>


			<?php if (is_category()) { ?>
				<h1 class="archive-title">
					<span><?php _e("Posts Categorized:", "scaffoldingtheme"); ?></span> <?php single_cat_title(); ?>
				</h1>

			<?php } elseif (is_tag()) { ?>
				<h1 class="archive-title">
					<span><?php _e("Posts Tagged:", "scaffoldingtheme"); ?></span> <?php single_tag_title(); ?>
				</h1>

			<?php } elseif (is_author()) {
				global $post;
				$author_id = $post->post_author;
			?>
				<h1 class="archive-title">

					<span><?php _e("Posts By:", "scaffoldingtheme"); ?></span> <?php the_author_meta('display_name', $author_id); ?>

				</h1>
			<?php } elseif (is_day()) { ?>
				<h1 class="archive-title">
					<span><?php _e("Daily Archives:", "scaffoldingtheme"); ?></span> <?php the_time('l, F j, Y'); ?>
				</h1>

			<?php } elseif (is_month()) { ?>
				<h1 class="archive-title">
					<span><?php _e("Monthly Archives:", "scaffoldingtheme"); ?></span> <?php the_time('F Y'); ?>
				</h1>

			<?php } elseif (is_year()) { ?>
				<h1 class="archive-title">
					<span><?php _e("Yearly Archives:", "scaffoldingtheme"); ?></span> <?php the_time('Y'); ?>
				</h1>
			<?php } ?>

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

						<header class="article-header">

							<h3 class="entry-title h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>

							<?php
							/* Hidden by default
							<?php printf(__('Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span> <span class="amp">&</span> filed under %4$s.', 'scaffoldingtheme'), get_the_time('Y-m-j'), get_the_time(get_option('date_format')), scaffolding_get_the_author_posts_link(), get_the_category_list(', ')); ?></p>
							*/ ?>

						</header> <!-- end article header -->

						<section class="entry-content clearfix">

							<?php the_post_thumbnail( 'scaffolding-thumb-300' ); ?>

							<?php the_excerpt(); ?>

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