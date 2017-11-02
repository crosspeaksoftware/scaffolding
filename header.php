<?php
/**
 * Header Template
 *
 * @see http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Scaffolding
 *
 */ ?><!DOCTYPE html>
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

<!--[if lt IE 9]>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv-printshiv.min.js"></script>
<![endif]-->

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<div id="container">
		
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'scaffolding' ); ?></a>

		<header id="masthead" class="header" role="banner">

			<div id="inner-header" class="wrap clearfix">

				<?php // to use an image just replace the bloginfo('name') with <img> ?>
				<div id="logo" class="h1">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" title="<?php bloginfo( 'name' ); ?>">
						<?php bloginfo( 'name' ); ?>
					</a>
				</div>

				<?php 
					/* if you'd like to use the site description you can un-comment this block
					<p class="site-description"><?php bloginfo( 'description' ); ?></p>
					*/
				?>
				
				<button id="mobile-menu-button"><?php esc_html_e( 'Menu', 'scaffolding' ); ?></button>

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

			<div id="inner-content" class="wrap clearfix">

				<?php // Test for active sidebars to set the main content width
					if ( is_active_sidebar( 'left-sidebar' ) && is_active_sidebar( 'right-sidebar' ) ) { // both sidebars
						$main_class = 'col-sm-6 col-sm-push-3 has-both-sidebars';
					} elseif ( is_active_sidebar( 'left-sidebar' ) && ! is_active_sidebar( 'right-sidebar' ) ) { // left sidebar
						$main_class = 'col-sm-9 col-sm-push-3 has-left-sidebar';
					} elseif ( ! is_active_sidebar( 'left-sidebar' ) && is_active_sidebar( 'right-sidebar' ) ) { // right sidebar
						$main_class = 'col-sm-9 has-right-sidebar';
					} else { // no sidebar
						$main_class = 'col-xs-12 no-sidebars';
					}
				?>

				<div class="row row-main">

					<div id="main" class="<?php echo $main_class; ?> clearfix" role="main">
