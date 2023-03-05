<?php
/**
 * Header Template
 *
 * @see http://codex.wordpress.org/Template_Hierarchy
 *
 * @package scaffolding
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js<?php echo ( is_user_logged_in() ) ? ' has-admin-bar' : ''; ?>">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class( 'sticky-footer' ); ?>>

	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
	}
	?>

	<div id="container">

		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'scaffolding' ); ?></a>

		<header id="masthead" class="header" role="banner">

			<div id="inner-header">

				<div id="header-row">

					<div id="logo">
						<?php if ( has_custom_logo() ) : ?>
							<?php the_custom_logo(); ?>
						<?php else : ?>
							<a class="logo-txt" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" itemprop="url">
								<span class="h1"><?php bloginfo( 'name' ); ?></span>
							</a>
						<?php endif; ?>
					</div>

					<div id="mobile-menu-toggle">
						<button id="mobile-menu-button" type="button"><?php esc_html_e( 'Menu', 'scaffolding' ); ?></button>
					</div>

				</div>

			</div>

		</header>

		<nav id="main-navigation" class="clearfix" role="navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'scaffolding' ); ?>">
			<?php scaffolding_main_nav(); ?>
		</nav>

		<div id="content">

			<?php do_action( 'scaffolding_after_content_begin' ); ?>
