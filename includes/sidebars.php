<?php
/**
 * Scaffolding Sidebars & Widgets
 *
 * @package scaffolding
 */

/**
 * Sidebars & Widgets Areas
 *
 * Two sidebars registered - left and right.
 * Define additional sidebars here.
 *
 * @since Scaffolding 1.0
 */
function scaffolding_register_sidebars() {
	register_sidebar(
		array(
			'id'            => 'footer-area-one',
			'name'          => __( 'Footer Area - One', 'scaffolding' ),
			'description'   => __( 'Left column footer area.', 'scaffolding' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<span class="widgettitle h4 d-block">',
			'after_title'   => '</span>',
		)
	);
	register_sidebar(
		array(
			'id'            => 'footer-area-two',
			'name'          => __( 'Footer Area - Two', 'scaffolding' ),
			'description'   => __( 'Center column footer area.', 'scaffolding' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<span class="widgettitle h4 d-block">',
			'after_title'   => '</span>',
		)
	);
	register_sidebar(
		array(
			'id'            => 'footer-area-three',
			'name'          => __( 'Footer Area - Three', 'scaffolding' ),
			'description'   => __( 'Right column footer area.', 'scaffolding' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<span class="widgettitle h4 d-block">',
			'after_title'   => '</span>',
		)
	);
}
add_action( 'widgets_init', 'scaffolding_register_sidebars' );
