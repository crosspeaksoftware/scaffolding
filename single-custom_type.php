<?php
/*
This is the custom post type post template.
If you edit the post type name, you've got
to change the name of this template to
reflect that name change.

i.e. if your custom post type is called
register_post_type( 'bookmarks',
then your single template should be
single-bookmarks.php

*/
?>

<?php get_header(); ?>

		<div id="main" class="eightcol first clearfix" role="main">

			<?php
			if (have_posts()) :
				while (have_posts()) :
					the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

						<header class="article-header">

							<h1 class="single-title custom-post-type-title"><?php the_title(); ?></h1>

							<?php
							/* Hidden by default
							printf(__('Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span> <span class="amp">&</span> filed under %4$s.', 'bonestheme'), get_the_time('Y-m-j'), get_the_time(__('F js, Y', 'bonestheme')), bones_get_the_author_posts_link(), get_the_term_list( $post->ID, 'custom_cat', ' ', ', ', '' ));
							*/ ?>

						</header> <!-- end article header -->

						<section class="entry-content clearfix">

							<?php the_content(); ?>

						</section> <!-- end article section -->

						<footer class="article-header">

							<p class="tags"><?php echo get_the_term_list( get_the_ID(), 'custom_tag', '<span class="tags-title">Custom Tags:</span> ', ', ' ) ?></p>

						</footer> <!-- end article footer -->

						<?php comments_template(); ?>

					</article> <!-- end article -->

				<?php endwhile; ?>

			<?php else : ?>

				<article id="post-not-found" class="hentry clearfix">
					<header class="article-header">
						<h2><?php _e("Oops, Post Not Found!", "bonestheme"); ?></h2>
					</header>
					<section class="entry-content">
						<p><?php _e("Uh Oh. Something is missing. Please contact the site administrator.", "bonestheme"); ?></p>
					</section>
					<footer class="article-footer">
					</footer>
				</article>

			<?php endif; ?>

		</div> <!-- end #main -->

<?php get_footer();