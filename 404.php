<?php get_header(); ?>

		<div id="main" class="eightcol first clearfix" role="main">

			<article id="post-not-found" class="hentry clearfix">

				<header class="article-header">

					<h1 class="entry-title"><?php _e("404 Error - Page Not Found", "scaffoldingtheme"); ?></h1>

				</header> <!-- end article header -->

				<section class="entry-content">

					<p><?php _e('The page you were looking for was not found. This may be due to the page being moved, renamed or deleted.<ul><li>Check the URL in the address bar above</li><li>Look for the page in the main navigation above or on the <a href="/site-map/" title="Site Map Page">Site Map</a> page</li><li>Try using the Search below.</li></ul>', "bonestheme"); ?></p>

				</section> <!-- end article section -->

				<section class="search">

					<p><?php get_search_form(); ?></p>

				</section> <!-- end search section -->

			</article> <!-- end article -->

		</div> <!-- end #main -->

<?php get_footer();
