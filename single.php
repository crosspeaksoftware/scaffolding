<?php get_header(); ?>

		 <div id="main" class="eightcol first clearfix" role="main">

		<!--Header/Banner Image-->
        <div class="banner-wrap">
            <div id="banner">
                <div class="spacer"></div>
            </div>
        </div>

		<div id="main" class="eightcol first clearfix" role="main">

			<?php
			if (have_posts()) :
				while (have_posts()) :
					the_post(); ?>

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

				<article id="post-not-found" class="hentry clearfix">
					<header class="article-header">
						<h2><?php _e("Oops, Post Not Found!", "scaffoldingtheme"); ?></h2>
					</header>
					<section class="entry-content">
						<p><?php _e("Uh Oh. Something is missing. Please contact the site administrator.", "scaffoldingtheme"); ?></p>
					</section>
					<footer class="article-footer">
					</footer>
				</article>

			<?php endif; ?>

		</div> <!-- end #main -->

<?php get_footer();