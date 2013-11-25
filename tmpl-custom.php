<?php
/*
Template Name: Custom Page Example
*/
?>

<?php get_header(); ?>

		<div id="main" class="eightcol first clearfix" role="main">

			<?php
			if (have_posts()) :
				while (have_posts()) :
					the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

						<header class="article-header">

							<h1 class="page-title"><?php the_title(); ?></h1>

							<?php
							/* Hidden by default
							<p class="byline vcard"><?php _e("Posted", "scaffoldingtheme"); ?> <time class="updated" datetime="<?php echo the_time('Y-m-j'); ?>" pubdate><?php the_time('F jS, Y'); ?></time> <?php _e("by", "scaffoldingtheme"); ?> <span class="author"><?php the_author_posts_link(); ?></span>.</p>
							*/ ?>

						</header> <!-- end article header -->

						<section class="entry-content">
							<?php the_content(); ?>
						</section> <!-- end article section -->

						<footer class="article-footer">

							<p class="clearfix"><?php the_tags('<span class="tags">Tags: ', ', ', '</span>'); ?></p>

						</footer> <!-- end article footer -->

						<?php comments_template(); ?>

					</article> <!-- end article -->

				<?php endwhile; ?>

			<?php else : ?>

			<?php include_once('error.php'); //wordpress template error message ?>

			<?php endif; ?>

		</div> <!-- end #main -->

<?php get_footer();