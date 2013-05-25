
			<?php get_sidebar(); ?>

		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

	<footer class="footer" role="contentinfo">

		<div id="inner-footer" class="wrap clearfix">

			<nav role="navigation">
				<?php scaffolding_footer_links(); ?>
			</nav>

			<p class="source-org copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.</p>

		</div> <!-- end #inner-footer -->

	</footer> <!-- end footer -->

</div> <!-- end #container -->

<!-- all js scripts are loaded in scaffolding.php -->
<?php wp_footer(); ?>

</body>

</html> <!-- end page. what a ride! -->