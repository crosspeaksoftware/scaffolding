<?php
/**
 * Template Name: Full Width Page
 *
 * @package Scaffolding
 */

get_header(); ?>

<div id="inner-content">

	<div class="row row-main no-sidebars">

		<div id="main" class="col-12 clearfix" role="main">
			
			<div class="container">

				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

							<header class="page-header">

								<h1 class="page-title"><?php the_title(); ?></h1>

							</header>

							<section class="page-content clearfix">

								<?php the_content(); ?>

								<?php wp_link_pages( array(
										'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'scaffolding' ) . '</span>',
										'after'       => '</div>',
										'link_before' => '<span>',
										'link_after'  => '</span>',
								) ); ?>

							 </section>

							<?php
								  // If comments are open or we have at least one comment, load up the comment template
								  if ( comments_open() || '0' != get_comments_number() ) :
										comments_template();
								  endif;
							 ?>

						</article>

					<?php endwhile; ?>

				<?php else : ?>

					<?php get_template_part( 'template-parts/error' ); // WordPress template error message ?>

				<?php endif; ?>
				
			</div><?php // END .container ?>
			
		</div><?php // END #main ?>
		
	</div><?php // END .row ?>
	
</div><?php // END #inner-content ?>

<?php get_footer();
