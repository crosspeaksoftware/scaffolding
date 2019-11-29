(function($){

	jQuery(document).ready(function($) {

		// Responsive iFrames, Embeds and Objects - http://css-tricks.com/NetMag/FluidWidthVideo/Article-FluidWidthVideo.php
		// Fallback for elements outside the Gutenberg blocks (ie. using the Classic Editor)
		var $allVideos = $(":not(.wp-block-embed__wrapper) > iframe[src*='youtube'], :not(.wp-block-embed__wrapper) > iframe[src*='vimeo'], :not(.wp-block-embed__wrapper) > iframe[src*='dailymotion'], :not(.wp-block-embed__wrapper) > iframe[src*='funnyordie'], :not(.wp-block-embed__wrapper) > object, :not(.wp-block-embed__wrapper) > embed").wrap( "<figure></figure>" );

		$allVideos.each(function() {
			$(this)
			.wrap('<figure></figure>')
			// jQuery .data does not work on object/embed elements
			.attr('data-aspectRatio', this.height / this.width)
			.css({ 'max-width': this.width + 'px', 'max-height': this.height + 'px' })
			.removeAttr('height')
			.removeAttr('width');
		});
		$(window).resize(function() {
			$allVideos.each(function() {
				var $el = $(this);
				var newWidth = $el.closest('figure').width();
				$el
				.width(newWidth)
				.height(newWidth * $el.attr('data-aspectRatio'));
			});
		}).resize();

	});

})(jQuery);
