<?php
get_header();
?>

<div id="content">

	<div id="inner-content" class="wrap clearfix">

		 <div id="main" class="eightcol first clearfix" role="main">

			<?php
			//load in the content of a static blog page if set in the back end
			if ( 'page' == get_option('show_on_front') && get_option('page_for_posts') && is_home() ) :
				the_post();
				$page_for_posts_id = get_option('page_for_posts');
				setup_postdata(get_page($page_for_posts_id));
			?>

			<div id="post<?php the_ID(); ?>" <?php post_class('static-blog-page clearfix'); ?>>

				<div class="post-content">
					<?php the_content(); ?>
				</div>

			</div>

			<?php
				rewind_posts();
			endif; //continue the loop as normal
			?>

			<?php
			if (have_posts()) :
				while (have_posts()) :
					the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

						<header class="article-header">

							<h1 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>

							<p class="byline vcard"><?php _e('Posted', 'bonestheme'); ?> <time class="updated" datetime="<?php echo the_time('Y-m-j'); ?>" pubdate><?php the_time(get_option('date_format')); ?></time> <?php _e('by', 'bonestheme'); ?> <span class="author"><?php the_author_posts_link(); ?></span> <span class="amp">&</span> <?php _e('filed under', 'bonestheme'); ?> <?php the_category(', '); ?>.</p>

						</header> <!-- end article header -->

						<section class="entry-content clearfix">
							<?php the_content(); ?>
						</section> <!-- end article section -->

						<footer class="article-footer">

							<p class="tags"><?php the_tags('<span class="tags-title">Tags:</span> ', ', ', ''); ?></p>

						</footer> <!-- end article footer -->

						<?php // comments_template(); // uncomment if you want to use them ?>

					</article> <!-- end article -->

				<?php endwhile; ?>

				<?php
				if (function_exists('bones_page_navi')) {
					bones_page_navi();
				}
				else {
				?>
					<nav class="wp-prev-next">
						<ul class="clearfix">
							<li class="prev-link"><?php next_posts_link(__('&laquo; Older Entries', "bonestheme")) ?></li>
							<li class="next-link"><?php previous_posts_link(__('Newer Entries &raquo;', "bonestheme")) ?></li>
						</ul>
					</nav>
				<?php
				}
				?>

			<?php else : ?>

				<article id="post-not-found" class="hentry clearfix">
					<header class="article-header">
						<h1><?php _e("Oops, Post Not Found!", "bonestheme"); ?></h1>
					</header>
					<section class="entry-content">
						<p><?php _e("Uh Oh. Something is missing. Try double checking things.", "bonestheme"); ?></p>
					</section>
					<footer class="article-footer">
						<p><?php _e("This is the error message in the index.php template.", "bonestheme"); ?></p>
					</footer>
				</article>

			<?php endif; ?>

		</div> <!-- end #main -->

		<?php get_sidebar(); ?>

	</div> <!-- end #inner-content -->

</div> <!-- end #content -->

<?php
get_footer();
