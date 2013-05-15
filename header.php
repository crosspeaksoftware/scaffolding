<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

<head>
	<meta charset="utf-8">

	<title><?php wp_title(''); ?></title>

	<!-- mobile meta -->
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	<!-- icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) -->
	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/apple-icon-touch.png">
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
	<!--[if IE]>
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
	<![endif]-->
	<!-- or, set /favicon.ico for IE10 win -->
	<meta name="msapplication-TileColor" content="#f01d4f">
	<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/images/win8-tile-icon.png">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

	<!-- wordpress head functions -->
	<?php wp_head(); ?>
	<!-- end of wordpress head -->

	<!-- drop Google Analytics Here -->
	<?php if(!is_admin()): //only track anonymous users ?>

	<?php endif; ?>
	<!-- end analytics -->

</head>

<body <?php body_class('sticky-footer'); ?>>

	<div id="container">

		<header class="header" role="banner">

			<div id="inner-header" class="wrap clearfix">

				<!-- to use a image just replace the bloginfo('name') with your img src and remove the surrounding <p> -->
				<p id="logo" class="h1"><a href="<?php echo home_url(); ?>" rel="nofollow" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></p>

				<!-- if you'd like to use the site description you can un-comment it below -->
				<?php // bloginfo('description'); ?>


				<nav role="navigation">
					<?php bones_main_nav(); ?>
				</nav>

			</div> <!-- end #inner-header -->

		</header> <!-- end header -->
