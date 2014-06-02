<?php

function scaffolding_theme_customizer( $wp_customize ) {

	// Logo upload
    $wp_customize->add_section( 'scaffolding_logo_section' , array(
	    'title'       => __( 'Logo', 'scaffolding' ),
	    'priority'    => 30,
	    'description' => 'Upload a logo to replace the default site name and description in the header',
	) );

	$wp_customize->add_setting( 'scaffolding_logo', array(
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'scaffolding_logo', array(
		'label'    => __( 'Logo', 'scaffolding' ),
		'section'  => 'scaffolding_logo_section',
		'settings' => 'scaffolding_logo',
	) ) );

}
add_action('customize_register', 'scaffolding_theme_customizer');