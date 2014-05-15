<?php get_header(); ?>

			<?php // Load in the content of a static blog page if set in the back end
			if ( 'page' == get_option('show_on_front') && get_option('page_for_posts') && is_home() && !is_paged() ) :
				the_post();
				$page_for_posts_id = get_option('page_for_posts');
				$post = get_post($page_for_posts_id);
				setup_postdata($post);
				?>

			<article id="post-<?php the_ID(); ?>" <?php post_class('static-blog-page clearfix'); ?> role="article">

				<header class="page-header">

					<h1 class="page-title"><?php the_title(); ?></h1>

				</header>

				<section class="page-content clearfix">

					<?php the_content(); ?>

				</section>

				<footer class="page-footer">

				</footer>

			</article>

			<?php
				rewind_posts();
				wp_reset_postdata();
			endif; //continue the loop as normal ?>

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

						<header class="entry-header">

							<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

							<p class="byline vcard"><?php printf(__('Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time>', 'scaffolding'), get_the_time('Y-m-j'), get_the_time(get_option('date_format'))); ?></p>

						</header>

						<section class="entry-content clearfix">
							<?php the_content('Read More...'); ?>
						</section>

						<footer class="entry-footer">

							<?php if( !empty(get_the_category_list()) ): ?>
								<p class="categories"><span class="categories-title">Categories:</span> <?php echo get_the_category_list(', ') ?></p>
							<?php endif;?>

							<?php the_tags('<p class="tags"><span class="tags-title">Tags:</span> ', ', ', '</p>'); ?>

						</footer>

					</article>

				<?php endwhile; ?>

				<?php get_template_part('includes/template','pager'); //wordpress template pager/pagination ?>

			<?php else : ?>

			<?php get_template_part('includes/template','error'); //wordpress template error message ?>

			<?php endif; ?>

<?php get_footer();