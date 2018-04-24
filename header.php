<?php
/**
 * Header Template
 *
 * @see http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Scaffolding
 *
 */ ?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js<?php echo ( is_user_logged_in() ) ? ' has-admin-bar' : ''; ?>">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<div id="container">
		
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'scaffolding' ); ?></a>

		<header id="masthead" class="header" role="banner">

			<div id="inner-header" class="container">
				
				<div class="row align-items-center justify-content-between">

					<?php // to use an image just replace the bloginfo('name') with <img> ?>
					<div id="logo" class="col-auto h1">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" title="<?php bloginfo( 'name' ); ?>">
							<?php bloginfo( 'name' ); ?>
						</a>
					</div>

					<?php 
						/* if you'd like to use the site description you can un-comment this block
						<p class="site-description"><?php bloginfo( 'description' ); ?></p>
						*/
					?>
					
					<div id="mobile-menu-toggle" class="col-auto">
						<button id="mobile-menu-button"><?php esc_html_e( 'Menu', 'scaffolding' ); ?></button>
					</div>
					
				</div>

			</div>

		</header>

		<nav id="main-navigation" class="clearfix" role="navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'scaffolding' ); ?>">
			<?php scaffolding_main_nav(); ?>
		</nav>

		<?php // Interior Header Image ?>
		<div class="banner-wrap">
			<div id="banner">
				<div class="spacer"></div>
			</div>
		</div>

		<div id="content">

			<div id="inner-content" class="container">

				<?php 
					// Test for active sidebars to set the main content width
					if ( is_active_sidebar( 'left-sidebar' ) && is_active_sidebar( 'right-sidebar' ) ) {
						$row_class = 'row-main has-both-sidebars';
						$main_class = 'col-lg-6 order-lg-2';
					} elseif ( is_active_sidebar( 'left-sidebar' ) && ! is_active_sidebar( 'right-sidebar' ) ) {
						$row_class = 'row-main has-left-sidebar';
						$main_class = 'col-md-9 order-md-2';
					} elseif ( ! is_active_sidebar( 'left-sidebar' ) && is_active_sidebar( 'right-sidebar' ) ) {
						$row_class = 'row-main has-right-sidebar';
						$main_class = 'col-md-9 order-md-1';
					} else {
						$row_class = 'row-main no-sidebars';
						$main_class = 'col-12';
					}
				?>

				<div class="row <?php echo $row_class; ?>">

					<div id="main" class="<?php echo $main_class; ?> clearfix" role="main">
