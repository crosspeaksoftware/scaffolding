<?php
/**
 * Footer Template
 *
 * Contains the closing of the "main" div and all content after.
 *
 * @package scaffolding
 */

?>
			<?php do_action( 'scaffolding_before_content_end' ); ?>

		</div><?php // END #content. ?>

		<footer id="colophon" class="footer" role="contentinfo">

			<?php get_sidebar(); ?>

			<div id="inner-footer" class="container py-3">

				<?php if ( has_nav_menu( 'footer-nav' ) ) : ?>

					<nav role="navigation" aria-label="<?php esc_attr_e( 'Footer Navigation', 'scaffolding' ); ?>">
						<?php scaffolding_footer_nav(); ?>
					</nav>

				<?php endif; ?>

				<p class="source-org copyright mb-0"><?php echo esc_html( '&copy; ' . gmdate( 'Y' ) . ' ' . get_bloginfo( 'name' ) ); ?></p>

			</div>

		</footer>

		<p id="back-top">
			<a href="#top"><i class="fas fa-angle-up"></i></a>
		</p>

	</div><?php // END #container. ?>

<?php wp_footer(); ?>

</body>
</html>
