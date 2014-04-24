<?php
/**
 * The Header for our theme.
 */
?><!DOCTYPE html><?php
// <IE7 Class ?><!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]--><?php
// IE7 Class ?><!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]--><?php
// IE8 Class ?><!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]--><?php
// >IE8 Class ?><!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<title><?php wp_title(''); ?></title>
<meta name="HandheldFriendly" content="True">
<meta name="MobileOptimized" content="320">
<meta name="viewport" content="width=device-width, initial-scale=1"/>

<?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/apple-icon-touch.png">
<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
<!--[if IE]><link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico"><![endif]-->
<meta name="msapplication-TileColor" content="#f01d4f">
<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/images/win8-tile-icon.png">

<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

<!--[if lt IE 9]>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv-printshiv.min.js"></script>
<![endif]-->

<?php wp_head(); ?>

<?php // Add Google Analytics Code Here ?>

</head>

<body <?php body_class(); ?>>
	<div id="container">

		<header id="masthead" class="header" role="banner">

			<div id="inner-header" class="wrap clearfix">

				<?php // to use a image just replace the bloginfo('name') with your img src and remove the surrounding <p> ?>
				<div id="logo" class="h1"><a href="<?php  echo esc_url( home_url( '/' ) ); ?>" rel="home" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></div>

				<?php // if you'd like to use the site description you can un-comment it below
				// echo '<p class="site-description">'. bloginfo( "description" ) .'</p>' ?>

			</div><?php // #inner-header ?>

		</header><?php // #masthead ?>

		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'test' ); ?></a>
		<nav id="main-navigation" class="clearfix" role="navigation">

			<?php scaffolding_main_nav(); ?>

		</nav><?php // #main-navigation ?>

		<?php // Interior Header Image ?>
        <div class="banner-wrap">
            <div id="banner">
                <div class="spacer"></div>
            </div>
        </div>

		<div id="content">

			<div id="inner-content" class="wrap clearfix">

				<?php // Test for active sidebars to set the main content width
					if(is_active_sidebar( 'left-sidebar' ) && is_active_sidebar( 'right-sidebar' )) { //both sidebars
						$main_class = 'col-sm-6';
					}
					elseif(is_active_sidebar( 'left-sidebar' ) && !is_active_sidebar( 'right-sidebar' )) { //left sidebar
						$main_class = 'col-sm-9 col-md-push-3';
					}
					elseif(!is_active_sidebar( 'left-sidebar' ) && is_active_sidebar( 'right-sidebar' )) { //right sidebar
						$main_class = 'col-sm-9';
					}
					else { //no sidebar
						$main_class = 'col-sm-12';
					}
				?>

				<div id="main" class="<?php echo $main_class;?> clearfix" role="main">