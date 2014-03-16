<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */

get_header(); ?>

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="archive-title">
					<?php
						if ( is_category() ) :
							single_cat_title();

						elseif ( is_tag() ) :
							single_tag_title();

						elseif ( is_author() ) :
							printf( __( 'Author Archive: %s', 'test' ), '<span class="vcard">' . get_the_author() . '</span>' );

						elseif ( is_day() ) :
							printf( __( 'Daily Archives: %s', 'test' ), '<span>' . get_the_date() . '</span>' );

						elseif ( is_month() ) :
							printf( __( 'Monthly Archives: %s', 'test' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'test' ) ) . '</span>' );

						elseif ( is_year() ) :
							printf( __( 'Yearly Archives: %s', 'test' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'test' ) ) . '</span>' );

						elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
							_e( 'Asides', 'test' );

						elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
							_e( 'Galleries', 'test');

						elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
							_e( 'Images', 'test');

						elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
							_e( 'Videos', 'test' );

						elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
							_e( 'Quotes', 'test' );

						elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
							_e( 'Links', 'test' );

						elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
							_e( 'Statuses', 'test' );

						elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
							_e( 'Audios', 'test' );

						elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
							_e( 'Chats', 'test' );

						else :
							_e( 'Archives', 'test' );

						endif;
					?>
				</h1>
				<?php
					// Show an optional term description.
					$term_description = term_description();
					if ( ! empty( $term_description ) ) :
						printf( '<div class="taxonomy-description">%s</div>', $term_description );
					endif;
				?>
			</header><!-- .page-header -->

			<?php while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

						<header class="article-header">

							<h3 class="entry-title h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>

							<?php
							/* Hidden by default
							<?php printf(__('Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span> <span class="amp">&</span> filed under %4$s.', 'scaffolding'), get_the_time('Y-m-j'), get_the_time(get_option('date_format')), scaffolding_get_the_author_posts_link(), get_the_category_list(', ')); ?></p>
							*/ ?>

						</header> <!-- end article header -->

						<section class="entry-content clearfix">

							<?php the_post_thumbnail( 'scaffolding-thumb-300' ); ?>

							<?php the_excerpt(); ?>

						</section> <!-- end article section -->

						<footer class="article-footer">

						</footer> <!-- end article footer -->

					</article> <!-- end article -->

				<?php endwhile; ?>

				<?php include_once('includes/template-pager.php'); //wordpress template pager/pagination ?>

			<?php else : ?>

			<?php include_once('includes/template-error.php'); //wordpress template error message ?>

			<?php endif; ?>


<?php get_footer();