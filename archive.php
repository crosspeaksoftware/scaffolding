<?php
/**
 * Archive Template
 *
 * Default template for displaying archives (categories, tags, taxonomies, dates, authors, etc.).
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Scaffolding
 */

get_header();
?>

<div id="inner-content" class="container">

	<div id="main" class="clearfix" role="main">

		<?php
		if ( have_posts() ) :
			?>

			<header class="page-header">

				<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
				<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>

			</header>

			<?php
			while ( have_posts() ) :
				the_post();
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article">

					<header class="entry-header clearfix">

						<h3 class="entry-title h2"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>

						<?php scaffolding_post_meta(); ?>

					</header>

					<div class="entry-content clearfix">

						<?php the_excerpt(); ?>

					</div>

					<?php if ( get_the_tag_list() ) : ?>

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
