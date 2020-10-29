<?php
/**
 * Default Template
 *
 * Used if no other suitable template is available.
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
				while ( have_posts() ) :
					the_post();
					?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

						<header class="entry-header clearfix">

							<h2 class="entry-title" itemprop="headline"><?php the_title(); ?></h2>

							<?php echo scaffolding_post_meta(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

						</header>

						<section class="entry-content clearfix" itemprop="articleBody">

							<?php
							the_content();

							wp_link_pages(
								array(
									'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'scaffolding' ) . '</span>',
									'after'       => '</div>',
									'link_before' => '<span>',
									'link_after'  => '</span>',
								)
							);
							?>

						</section>

						<?php if ( get_the_tag_list() ) : ?>

							<footer class="entry-footer clearfix">

								<?php the_tags( '<p class="tags"><span class="tags-title">Tags:</span> ', ', ', '</p>' ); ?>

							</footer>

						<?php endif; ?>

						<?php
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || '0' !== get_comments_number() ) :
							comments_template();
						endif;
						?>

					</article>

					<?php
				endwhile;

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
