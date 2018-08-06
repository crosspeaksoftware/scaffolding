<?php
/**
 * Pagination
 *
 * @package Scaffolding
 */

if ( function_exists( 'scaffolding_page_navi' ) ) :
	global $wp_query;
	scaffolding_page_navi( '', '', $wp_query );
else :
	?>
	<nav class="wp-prev-next">
		<ul class="clearfix">
			<li class="prev-link">
				<?php next_posts_link( __( '&laquo; Older Entries', 'scaffolding' ) ); ?>
			</li>
			<li class="next-link">
				<?php previous_posts_link( __( 'Newer Entries &raquo;', 'scaffolding' ) ); ?>
			</li>
		</ul>
	</nav>

	<?php
endif;
