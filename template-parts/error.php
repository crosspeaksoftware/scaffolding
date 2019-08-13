<?php
/**
 * Error Messages
 *
 * @package Scaffolding
 */

?>
<section class="post-not-found clearfix">

	<header class="page-header">

		<h1><?php esc_html_e( 'Nothing Found', 'scaffolding' ); ?></h1>

	</header>

	<div class="page-content">

		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( wp_kses_post( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'scaffolding' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'scaffolding' ); ?></p>

			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'scaffolding' ); ?></p>

			<?php get_search_form(); ?>

		<?php endif; ?>

	</div>

</section>
