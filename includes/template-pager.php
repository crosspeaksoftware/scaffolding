				<?php //Pagination/Pager
				if (function_exists('scaffolding_page_navi')):
					scaffolding_page_navi();
				else:
				?>
					<nav class="wp-prev-next">
						<ul class="clearfix">
							<li class="prev-link"><?php next_posts_link(__('&laquo; Older Entries', "scaffoldingtheme")) ?></li>
							<li class="next-link"><?php previous_posts_link(__('Newer Entries &raquo;', "scaffoldingtheme")) ?></li>
						</ul>
					</nav>

				<?php endif; ?>