<?php
/**
 * Front Page Template
 *
 * Latest Posts or Static Front Page Template as defined in Settings->Reading. Takes precedence over home.php.
 * Recommended usage: Static Front Page Template
 *
 * @see http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Scaffolding
 */

get_header();
?>

<div id="inner-content" class="container">

	<div id="main" class="clearfix" role="main">

		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article">

					<header class="page-header">

						<h1 class="page-title"><?php the_title(); ?></h1>

					</header>

					<section class="page-content clearfix">

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

				</article>

				<?php
			endwhile;

		else :

			get_template_part( 'template-parts/error' ); // WordPress template error message.

		endif;
		?>

	</div><?php // END #main. ?>

</div><?php // END #inner-content. ?>

<?php
get_footer();
