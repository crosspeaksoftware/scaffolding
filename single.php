<?php
/**
 * Single Posts Template
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Scaffolding
 * @since Scaffolding 1.0
 */

get_header(); ?>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

				<header class="article-header clearfix">

					<h1 class="single-title" itemprop="headline"><?php the_title(); ?></h1>

					<p class="byline vcard"><?php printf(__('Posted <time class="updated" datetime="%1$s">%2$s</time> by <span class="author">%3$s</span> <span class="amp">&amp;</span> filed under %4$s.', 'scaffolding'), get_the_time('Y-m-d'), get_the_time(get_option('date_format')), scaffolding_get_the_author_posts_link(), get_the_category_list(', ')); ?></p>

				</header><?php // END .article-header ?>

				<section class="entry-content clearfix" itemprop="articleBody">

					<?php the_content(); ?>

					<?php wp_link_pages( array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'scaffolding' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
					) ); ?>

				</section><?php // END .entry-content ?>

				<footer class="article-footer clearfix">

					<?php if ( get_the_tag_list() ) :
						echo get_the_tag_list( '<p class="tags"><span class="meta-title">Tags:</span> ', ', ', '</p>' );
					endif; ?>

				</footer><?php // END .article-footer ?>

				<?php // If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) :
					comments_template();
				endif; ?>

			</article>

		 <?php endwhile; ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/error' ); // WordPress template error message ?>

	<?php endif; ?>

<?php get_footer();
