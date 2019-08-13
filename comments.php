<?php
/**
 * Comments Template
 *
 * The area of the page that contains both current comments and the comment form.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Scaffolding
 */

/**
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>

		<h3 class="h2 comments-title">
			<?php
			$sc_comment_count = get_comments_number();
			if ( '1' === $sc_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One comment on &ldquo;%1$s&rdquo;', 'scaffolding' ),
					'<span>' . get_the_title() . '</span>' // phpcs:ignore
				);
			} else {
				printf(
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', $sc_comment_count, 'comments title', 'scaffolding' ) ),
					number_format_i18n( $sc_comment_count ), // phpcs:ignore
					'<span>' . get_the_title() . '</span>' // phpcs:ignore
				);
			}
			?>
		</h3>

		<?php
		the_comments_navigation(
			array(
				'prev_text' => '&larr; Older Comments',
				'next_text' => '&rarr; Newer Comments',
			)
		);
		?>

		<ol class="commentlist">
			<?php
			wp_list_comments(
				array(
					'type'     => 'comment',
					'style'    => 'ol',
					'callback' => 'scaffolding_comments',
				)
			);
			?>
		</ol>

		<?php
		the_comments_navigation(
			array(
				'prev_text' => '&larr; Older Comments',
				'next_text' => '&rarr; Newer Comments',
			)
		);
		?>

		<?php
		// this is displayed if there are no comments so far.
	else :
		?>

		<?php if ( ! comments_open() && '0' !== get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

			<p class="nocomments"><?php esc_html_e( 'Comments are closed.', 'scaffolding' ); ?></p>

		<?php endif; ?>

		<?php
	endif;
	?>

	<?php
	// if you delete this the sky will fall on your head.
	if ( comments_open() ) :
		?>

		<section class="respond-form">

			<?php
			// If registration required and not logged in.
			if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) :
				?>

				<div class="alert help">
					<?php /* translators: 1: login opening tag, 2: login closing tag */ ?>
					<p><?php printf( esc_html__( 'You must be %1$slogged in%2$s to post a comment.', 'scaffolding' ), '<a href="<?php echo wp_login_url( get_permalink() ); ?>">', '</a>' ); ?></p>
				</div>

			<?php else : ?>

				<?php comment_form(); ?>

			<?php endif; ?>

		</section>

		<?php
	endif;
	?>

</div>
