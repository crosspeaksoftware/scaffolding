<?php
/**
 * Search Results Template
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Scaffolding
 */

get_header();
?>

<div id="inner-content" class="container">

	<div id="main" class="clearfix" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">

					<?php /* translators: search results */ ?>
					<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'scaffolding' ), '<span>' . get_search_query() . '</span>' ); ?></h1>

					<?php get_search_form(); ?>

				</header>

				<?php while ( have_posts() ) : ?>

					<?php the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article">

						<header class="entry-header clearfix">

							<h2 class="entry-title search-title h3"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

							<?php scaffolding_post_meta(); ?>

						</header>

						<div class="entry-content clearfix" itemprop="description">

							<?php the_excerpt(); ?>

						</div>

						<?php if ( 'post' === get_post_type() && get_the_tag_list() ) : ?>

							<footer class="entry-footer clearfix">

								<?php the_tags( '<p class="tags"><span class="tags-title">Tags:</span> ', ', ', '</p>' ); ?>

							</footer>

						<?php endif; ?>

					</article>

			<?php endwhile; ?>

			<?php get_template_part( 'template-parts/pager' ); // Template pager/pagination. ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/error' ); // Template error message. ?>

		<?php endif; ?>

	</div><?php // END #main. ?>

</div><?php // END #inner-content. ?>

<?php
get_footer();
