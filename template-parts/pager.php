<?php
/**
 * Pagination
 *
 * @package Scaffolding
 */

global $wp_query;

if ( $wp_query->max_num_pages <= 1 ) {
	return;
}
?>

<nav class="scaffolding-page-navi">
	<?php
	echo paginate_links( // phpcs:ignore
		array(
			'base'      => esc_url_raw( str_replace( 999999999, '%#%', get_pagenum_link( 999999999, false ) ) ),
			'format'    => '',
			'add_args'  => false,
			'current'   => max( 1, get_query_var( 'paged' ) ),
			'total'     => $wp_query->max_num_pages,
			'prev_text' => '<i class="fa fa-angle-double-left"></i> Previous Page',
			'next_text' => 'Next Page <i class="fa fa-angle-double-right"></i>',
			'type'      => 'list',
			'end_size'  => 1,
			'mid_size'  => 2,
		)
	);
	?>
</nav>
