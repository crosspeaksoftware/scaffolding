<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 */

// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
	die ('Please do not load this page directly. Thanks!');
}

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) { ?>
	<div class="alert help">
	<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments.", "scaffolding"); ?></p>
	</div>
	<?php
	return;
}
?>

<?php // You can start editing here -- including this comment!
 if ( have_comments() ) : ?>
 <div id="comments" class="comments-area">

	<h3 class="h2 comments"><?php comments_number(__('<span>No</span> Responses', 'scaffolding'), __('<span>One</span> Response', 'scaffolding'), _n('<span>%</span> Response', '<span>%</span> Responses', get_comments_number(),'scaffolding') );?> to &#8220;<?php the_title(); ?>&#8221;</h3>

	<nav class="comment-nav">
		<ul class="clearfix">
	  		<li><?php previous_comments_link(); ?></li>
	  		<li><?php next_comments_link(); ?></li>
	 	</ul>
	</nav>

	<ol class="commentlist">
		<?php wp_list_comments('type=comment&callback=scaffolding_comments'); ?>
	</ol>

	<nav class="comment-nav">
		<ul class="clearfix">
	  		<li><?php previous_comments_link() ?></li>
	  		<li><?php next_comments_link() ?></li>
		</ul>
	</nav>
</div>

<?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	<?php else : // comments are closed ?>

		<!-- If comments are closed. -->
		<!--p class="nocomments"><?php _e("Comments are closed.", "scaffolding"); ?></p-->

	<?php endif; ?>

<?php endif; ?>


<?php if ( comments_open() ) : ?>

	<section class="respond-form">

		<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>

			<div class="alert help">
				<p><?php printf( __('You must be %1$slogged in%2$s to post a comment.', 'scaffolding'), '<a href="<?php echo wp_login_url( get_permalink() ); ?>">', '</a>' ); ?></p>
			</div>

		<?php else : ?>

			<!--<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">-->

			<?php comment_form(); ?>

			<!--</form>-->

		<?php endif; // If registration required and not logged in ?>

	</section>

<?php endif; // if you delete this the sky will fall on your head ?>
