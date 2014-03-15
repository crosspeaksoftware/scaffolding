<?php
/**
 * The template for displaying 404 pages (Not Found).
 */

get_header(); ?>

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'test' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php _e( 'It looks like nothing was found at this location. This may be due to the page being moved, renamed or deleted.<ul><li>Check the URL in the address bar above</li><li>Look for the page in the main navigation above or on the <a href="/site-map/" title="Site Map Page">Site Map</a> page</li><li>Try using the Search below.</li></ul>'); ?></p>

					<?php get_search_form(); ?>

				</div>
			</section>

<?php get_footer();
