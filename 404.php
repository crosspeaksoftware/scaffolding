<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package Scaffolding
 */

get_header();

global $sc_layout_class;
?>

<div id="inner-content" class="container">

	<div class="row <?php echo esc_attr( $sc_layout_class['row'] ); ?>">

		<div id="main" class="<?php echo esc_attr( $sc_layout_class['main'] ); ?> clearfix" role="main">

			<section class="error-404 not-found clearfix">

				<header class="page-header">

					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'scaffolding' ); ?></h1>

				</header>

				<div class="page-content">

					<p><?php esc_html_e( 'It looks like nothing was found at this location. This may be due to the page being moved, renamed or deleted.', 'scaffolding' ); ?></p>

					<ul>
						<li><?php esc_html_e( 'Check the URL in the address bar above;', 'scaffolding' ); ?></li>
						<li>
							<?php
							printf(
								wp_kses(
									/* translators: 1: Site Map URL, 2: Site Map name */
									__( 'Look for the page in the main navigation above or on the <a href="%1$s">%2$s</a> page;', 'scaffolding' ),
									array(
										'a' => array(
											'href'  => array(),
											'class' => array(),
										),
									)
								),
								esc_url( home_url( '/site-map/' ) ),
								esc_html( 'Site Map' )
							);
							?>
						</li>
						<li><?php esc_html_e( 'Or try using the Search below.', 'scaffolding' ); ?></li>
					</ul>

					<?php get_search_form(); ?>

				</div>

			</section>

		</div><?php // END #main. ?>

		<?php get_sidebar(); ?>

	</div><?php // END .row. ?>

</div><?php // END #inner-content. ?>

<?php
get_footer();
