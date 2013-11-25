		</div> <!-- end #main -->

	<?php if ( is_active_sidebar( 'left-sidebar' ) ) : ?>

		<div id="left-sidebar" class="sidebar threecol first clearfix" role="complementary">

			<?php dynamic_sidebar( 'left-sidebar' ); ?>

		</div>

	<?php endif; ?>

	<?php if ( is_active_sidebar( 'right-sidebar' ) ) : ?>

		<div id="right-sidebar" class="sidebar threecol last clearfix" role="complementary">

			<?php dynamic_sidebar( 'right-sidebar' ); ?>

		</div>

	<?php endif; ?>

		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

	<footer class="footer" role="contentinfo">

		<div id="inner-footer" class="wrap clearfix">

			<nav role="navigation">
				<?php scaffolding_footer_nav(); ?>
			</nav>

			<p class="source-org copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.</p>

		</div> <!-- end #inner-footer -->

	</footer> <!-- end footer -->
	
	<p id="back-top">
        <a href="#top"><i class="fa fa-angle-up"></i></a>
    </p>

</div> <!-- end #container -->

<!-- all js scripts are loaded in scaffolding.php -->
<?php wp_footer(); ?>

</body>

</html> <!-- end page. what a ride! -->