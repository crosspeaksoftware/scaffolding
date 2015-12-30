<?php
/**
 * Customize the wysiwyg editor
 *
 * These functions also handle backwards compatibility with WordPress as TinyMCE 3 and TinyMCE 4
 * handle this differently.
 *
 * http://www.kevinleary.net/customizing-tinymce-wysiwyg-editor-wordpress/
 */

// TinyMCE: First line toolbar customizations
if ( ! function_exists( 'scaffolding_extended_editor_mce_buttons' ) ) {
	function scaffolding_extended_editor_mce_buttons ( $buttons ) {
		// The settings are returned in this array. Customize to suite your needs.
		return array(
			'bold', 'italic', 'strikethrough', 'bullist', 'numlist', 'blockquote', 'hr',
			'alignleft', 'aligncenter', 'alignright', 'link', 'unlink', 'wp_more',
			'spellchecker', 'wp_fullscreen', 'wp_adv'
		);
		/* WordPress Default
		return array(
			'bold', 'italic', 'strikethrough', bullist', 'numlist', 'blockquote', 'hr',
			'alignleft', 'aligncenter', 'alignright', 'link', 'unlink', 'wp_more',
			'spellchecker', 'wp_fullscreen', 'wp_adv'
		); */
	}
	add_filter( 'mce_buttons', 'scaffolding_extended_editor_mce_buttons', 0 );
}

// TinyMCE: Second line toolbar customizations
if ( ! function_exists( 'scaffolding_extended_editor_mce_buttons_2' ) ) {
	function scaffolding_extended_editor_mce_buttons_2 ( $buttons ) {
		// The settings are returned in this array. Customize to suite your needs. An empty array is used here because I remove the second row of icons.
		return array(
			'styleselect', 'underline', 'alignull', 'forecolor', 'pastetext', 'pasteword', 'removeformat', 'media', 'charmap',
			'outdent', 'indent', 'undo', 'redo', 'wp_help'
		);
		/* WordPress Default
		return array(
			'formatselect', 'underline', 'alignfull', 'pastetext', 'pasteword', 'removeformat', 'charmap',
			'outdent', 'indent', 'undo', 'redo', 'wp_help'
		); */
	}
	add_filter( 'mce_buttons_2', 'scaffolding_extended_editor_mce_buttons_2', 0 );
}

// Add new styles to the 'styleselect'
add_filter( 'tiny_mce_before_init', 'scaffolding_styles_dropdown' );
function scaffolding_styles_dropdown( $settings ) {

	// Create array of new styles
	$new_styles = array(
		array(
			'title'	=> __( 'Buttons', 'scaffolding' ), // This is the title of the dropdown
			'items'	=> array( // Define the items
				array(
					'title'    => __( 'Orange Button', 'scaffolding' ),
					'selector' => 'a',
					'classes'  => 'orange-btn',
					'exact'    => true
				),
				array(
					'title'    => __( 'Blue Button', 'scaffolding' ),
					'selector' => 'a',
					'classes'  => 'blue-btn',
					'exact'    => true
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

// Add custom colors to TinyMCE "colors" dropdown
add_filter( 'tiny_mce_before_init', 'scaffolding_change_tinymce_colors' );
function scaffolding_change_tinymce_colors( $init ) {
	$default_colours = '
		"000000", "Black",
		"993300", "Burnt orange",
		"333300", "Dark olive",
		"003300", "Dark green",
		"003366", "Dark azure",
		"000080", "Navy Blue",
		"333399", "Indigo",
		"333333", "Very dark gray",
		"800000", "Maroon",
		"FF6600", "Orange",
		"808000", "Olive",
		"008000", "Green",
		"008080", "Teal",
		"0000FF", "Blue",
		"666699", "Grayish blue",
		"808080", "Gray",
		"FF0000", "Red",
		"FF9900", "Amber",
		"99CC00", "Yellow green",
		"339966", "Sea green",
		"33CCCC", "Turquoise",
		"3366FF", "Royal blue",
		"800080", "Purple",
		"999999", "Medium gray",
		"FF00FF", "Magenta",
		"FFCC00", "Gold",
		"FFFF00", "Yellow",
		"00FF00", "Lime",
		"00FFFF", "Aqua",
		"00CCFF", "Sky blue",
		"993366", "Brown",
		"C0C0C0", "Silver",
		"FF99CC", "Pink",
		"FFCC99", "Peach",
		"FFFF99", "Light yellow",
		"CCFFCC", "Pale green",
		"CCFFFF", "Pale cyan",
		"99CCFF", "Light sky blue",
		"CC99FF", "Plum",
		"FFFFFF", "White"
	';
	$custom_colours = '';
	$init['textcolor_map'] = '['.$default_colours.','.$custom_colours.']';
	$init['textcolor_rows'] = 6; // expand colour grid to 6 rows
	return $init;
}
