<?php get_header(); ?>

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

						<header class="single-header">

							<h1 class="single-title" itemprop="headline"><?php the_title(); ?></h1>

							<p class="byline vcard"><?php printf(__('Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time>', 'scaffolding'), get_the_time('Y-m-j'), get_the_time(get_option('date_format'))); ?></p>

						</header><?php // end article header ?>

						<section class="single-content clearfix" itemprop="articleBody">
							<?php the_content(); ?>
							<?php wp_link_pages( array(
								'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'scaffolding' ) . '</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
							) ); ?>
						</section><?php // end article section ?>

						<footer class="single-footer" role="contentinfo">

							<?php if( !empty(get_the_category_list()) ): ?>
								<p class="categories"><span class="categories-title">Categories:</span> <?php echo get_the_category_list(', ') ?></p>
							<?php endif;?>

							<?php the_tags('<p class="tags"><span class="tags-title">Tags:</span> ', ', ', '</p>'); ?>

						</footer><?php // end article footer ?>

						<?php
							// If comments are open or we have at least one comment, load up the comment template
							if ( comments_open() || '0' != get_comments_number() ) :
								comments_template();
							endif;
						?>

					</article><?php // end article ?>

				<?php endwhile; ?>

			<?php else : ?>

			<?php get_template_part('includes/template','error'); // WordPress template error message ?>

			<?php endif; ?>

<?php get_footer();