<?php
/**
 * Default Page Template
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

			<?php while ( have_posts() ) : ?>

				<?php the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article">

					<header class="page-header">

						<h1 class="page-title"><?php the_title(); ?></h1>

					</header>

					<section class="page-content clearfix">

						<?php the_content(); ?>

						<?php
						// Displays page links for paginated posts (i.e. including the <!--nextpage--> Quicktag one or more times). This tag must be within The Loop.
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

					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || '0' !== get_comments_number() ) :
						comments_template();
					endif;
					?>

				</article>

			<?php endwhile; ?>

			<?php get_template_part( 'template-parts', 'pager' ); // WordPress template pager/pagination. ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts', 'error' ); // WordPress template error message. ?>

		<?php endif; ?>

	</div><?php // END #main. ?>

</div><?php // END #inner-content. ?>

<?php
get_footer();
