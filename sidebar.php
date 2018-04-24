<?php
/**
 * Sidebar Template
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Scaffolding
 */

// Test for active sidebars to set sidebar classes
if ( is_active_sidebar( 'left-sidebar' ) && is_active_sidebar( 'right-sidebar' ) ) {
	$left_class = 'col-md-6 order-md-1 col-lg-3';
	$right_class = 'col-md-6 order-md-3 col-lg-3';
} elseif ( is_active_sidebar( 'left-sidebar' ) && ! is_active_sidebar( 'right-sidebar' ) ) {
	$left_class = 'col-md-3 order-md-1';
} elseif ( ! is_active_sidebar( 'left-sidebar' ) && is_active_sidebar( 'right-sidebar' ) ) {
	$right_class = 'col-md-3 order-md-2';
}
?>

<?php if ( is_active_sidebar( 'left-sidebar' ) ) : ?>

	<div id="left-sidebar" class="sidebar <?php echo $left_class; ?>" role="complementary">
		<?php dynamic_sidebar( 'left-sidebar' ); ?>
	</div>

<?php endif; ?>

<?php if ( is_active_sidebar( 'right-sidebar' ) ) : ?>

	<div id="right-sidebar" class="sidebar <?php echo $right_class; ?>" role="complementary">
		<?php dynamic_sidebar( 'right-sidebar' ); ?>
	</div>

<?php endif;
