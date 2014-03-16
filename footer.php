<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 */
?>
		</div> <?php #main ?>

	<?php if ( is_active_sidebar( 'left-sidebar' ) ) : ?>
		<div id="left-sidebar" class="sidebar col-sm-3 col-md-pull-9 clearfix" role="complementary">
			<?php dynamic_sidebar( 'left-sidebar' ); ?>
		</div>
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'right-sidebar' ) ) : ?>
		<div id="right-sidebar" class="sidebar col-sm-3 clearfix" role="complementary">
			<?php dynamic_sidebar( 'right-sidebar' ); ?>
		</div>
	<?php endif; ?>

		</div><?php #inner-content ?>

	</div><?php #content ?>

	<footer class="footer" role="contentinfo">

		<div id="inner-footer" class="wrap clearfix">

			<nav role="navigation">
				<?php scaffolding_footer_nav(); ?>
			</nav>

			<p class="source-org copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.</p>

		</div> <?php #inner-footer ?>

	</footer> <?php // footer ?>
	
	<p id="back-top">
        <a href="#top"><i class="fa fa-angle-up"></i></a>
    </p>

</div> <?php  #container ?>

<?php // all js scripts are loaded in functions.php ?>
<?php wp_footer(); ?>

</body>
</html>