<?php get_header(); ?>

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

						<header class="article-header">

							<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>

							<p class="byline vcard"><?php printf(__('Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span> <span class="amp">&amp;</span> filed under %4$s.', 'scaffoldingtheme'), get_the_time('Y-m-j'), get_the_time(get_option('date_format')), scaffolding_get_the_author_posts_link(), get_the_category_list(', ')); ?></p>

						</header> <!-- end article header -->

						<section class="entry-content clearfix" itemprop="articleBody">
							<?php the_content(); ?>
						</section> <!-- end article section -->

						<footer class="article-footer">

							<?php the_tags('<p class="tags"><span class="tags-title">Tags:</span> ', ', ', '</p>'); ?>

						</footer> <!-- end article footer -->

						<?php comments_template(); ?>

					</article> <!-- end article -->

				<?php endwhile; ?>

			<?php else : ?>

			<?php include_once('includes/template-error.php'); //wordpress template error message ?>

			<?php endif; ?>

<?php get_footer();