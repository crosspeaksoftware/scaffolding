<?php
/**
 * Add custom styles to the wysiwyg editor
 *
 * These functions also handle backwards compatibility with WordPress as TinyMCE 3 and TinyMCE 4 handle this differently.
 * 
 */
 
// Add new styles to the TinyMCE "formats" menu dropdown
function scaffolding_styles_dropdown( $settings ) {

	// Create array of new styles
	$new_styles = array(
		array(
			'title'	=> __( 'Buttons', 'scaffolding' ), // This is the title of the dropdown
			'items'	=> array( // Define the items
				array(
					'title'		=> __('Button','scaffolding'),
					'selector'	=> 'a',
					'classes'	=> 'btn',
					'exact'		=> true
				),
			),
		),
	);

	// Merge old & new styles
	$settings['style_formats_merge'] = true;

	// Add new styles
	$settings['style_formats'] = json_encode( $new_styles );

	// Return New Settings
	return $settings;

}
add_filter( 'tiny_mce_before_init', 'scaffolding_styles_dropdown' );