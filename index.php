<?php get_header(); ?>

			<?php
			//load in the content of a static blog page if set in the back end
			if ( 'page' == get_option('show_on_front') && get_option('page_for_posts') && is_home() ) :
				the_post();
				$page_for_posts_id = get_option('page_for_posts');
				$post = get_post($page_for_posts_id);
				setup_postdata($post);
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class('static-blog-page clearfix'); ?> role="article">

				<header class="article-header">

					<h2 class="entry-title page-title"><?php the_title(); ?></h2>

				</header> <!-- end article header -->

				<section class="entry-content clearfix">
					<?php the_content(); ?>
				</section> <!-- end article section -->

				<footer class="article-footer">

				</footer> <!-- end article footer -->

			</article> <!-- end article -->

			<?php
				wp_reset_postdata();
			endif; //continue the loop as normal
			?>

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

						<header class="article-header">

							<h1 class="entry-title h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>

							<p class="byline vcard"><?php printf(__('Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span> <span class="amp">&</span> filed under %4$s.', 'scaffolding'), get_the_time('Y-m-j'), get_the_time(get_option('date_format')), scaffolding_get_the_author_posts_link(), get_the_category_list(', ')); ?></p>

						</header> <!-- end article header -->

						<section class="entry-content clearfix">
							<?php the_content('Read More...'); ?>
						</section> <!-- end article section -->

						<footer class="article-footer">

							<p class="tags"><?php the_tags('<span class="tags-title">' . __('Tags:', 'scaffolding') . '</span> ', ', ', ''); ?></p>

						</footer> <!-- end article footer -->

						<?php // comments_template(); // uncomment if you want to use them ?>

					</article> <!-- end article -->

				<?php endwhile; ?>

				<?php include_once('includes/template-pager.php'); //wordpress template pager/pagination ?>

			<?php else : ?>

			<?php include_once('includes/template-error.php'); //wordpress template error message ?>

			<?php endif; ?>

<?php get_footer();