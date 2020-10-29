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

global $scaffolding_layout_class;
?>

<div id="inner-content" class="container">

	<div class="row <?php echo esc_attr( $scaffolding_layout_class['row'] ); ?>">

		<div id="main" class="<?php echo esc_attr( $scaffolding_layout_class['main'] ); ?> clearfix" role="main">

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

							<?php echo scaffolding_post_meta(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

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

					<?php
				endwhile;

				get_template_part( 'template-parts/pager' ); // WordPress template pager/pagination.

			else :

				get_template_part( 'template-parts/error' ); // WordPress template error message.

			endif;
			?>

		</div><?php // END #main. ?>

		<?php get_sidebar(); ?>

	</div><?php // END .row. ?>

</div><?php // END #inner-content. ?>

<?php
get_footer();
