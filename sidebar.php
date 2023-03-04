<?php
/**
 * Sidebar Template
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package scaffolding
 */

if ( is_active_sidebar( 'footer-area-one' ) || is_active_sidebar( 'footer-area-two' ) || is_active_sidebar( 'footer-area-three' ) ) :
	?>

	<div id="footer-widgets">

		<div class="row footer-widgets__row">

			<?php
			if ( is_active_sidebar( 'footer-area-one' ) ) :
				?>

				<div class="footer-widgets__col col-md">
					<?php dynamic_sidebar( 'footer-area-one' ); ?>
				</div>

				<?php
			endif;

			if ( is_active_sidebar( 'footer-area-two' ) ) :
				?>

				<div class="footer-widgets__col col-md">
					<?php dynamic_sidebar( 'footer-area-two' ); ?>
				</div>

				<?php
			endif;

			if ( is_active_sidebar( 'footer-area-three' ) ) :
				?>

				<div class="footer-widgets__col col-md">
					<?php dynamic_sidebar( 'footer-area-three' ); ?>
				</div>

				<?php
			endif;
			?>

		</div>

	</div>

	<?php
endif;
?>
