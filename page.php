<?php get_header(); ?>


			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

						<header class="article-header">

							<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>

							<?php
							/* Hidden by default
							<p class="byline vcard"><?php _e("Posted", "scaffoldingtheme"); ?> <time class="updated" datetime="<?php echo the_time('Y-m-j'); ?>" pubdate><?php the_time('F jS, Y'); ?></time> <?php _e("by", "scaffoldingtheme"); ?> <span class="author"><?php the_author_posts_link(); ?></span>.</p>
							*/ ?>

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