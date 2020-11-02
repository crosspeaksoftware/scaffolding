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

		<div itemscope itemtype="http://schema.org/SearchResultsPage">

			<?php
			if ( have_posts() ) :
				?>

				<header class="page-header">

					<?php /* translators: search results */ ?>
					<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'scaffolding' ), '<span>' . get_search_query() . '</span>' ); ?></h1>

					<?php get_search_form(); ?>

				</header>

				<?php
				while ( have_posts() ) :
					the_post();
					?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article">

						<header class="entry-header clearfix">

							<h2 class="entry-title search-title h3"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

							<?php echo scaffolding_post_meta(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

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

					<?php
				endwhile;

				get_template_part( 'template-parts/pager' ); // WordPress template pager/pagination.

			else :

				get_template_part( 'template-parts/error' ); // WordPress template error message.

			endif;
			?>

		</div>

	</div><?php // END #main. ?>

</div><?php // END #inner-content. ?>

<?php
get_footer();
