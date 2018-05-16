<?php
/**
 * Sidebar Template
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Scaffolding
 */

global $sc_sidebar_class;
?>

<?php if ( is_active_sidebar( 'left-sidebar' ) ) : ?>

	<div id="left-sidebar" class="sidebar <?php echo $sc_sidebar_class['left']; ?>" role="complementary">
		<?php dynamic_sidebar( 'left-sidebar' ); ?>
	</div>

<?php endif; ?>

<?php if ( is_active_sidebar( 'right-sidebar' ) ) : ?>

	<div id="right-sidebar" class="sidebar <?php echo $sc_sidebar_class['right']; ?>" role="complementary">
		<?php dynamic_sidebar( 'right-sidebar' ); ?>
	</div>

<?php endif;
