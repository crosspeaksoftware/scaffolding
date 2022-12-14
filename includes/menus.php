<?php
/**
 * Menus
 *
 * @package Scaffolding
 */

/**
 * Two menus included - main menu in header and footer menu
 *
 * Add any additional menus here.
 *
 * @since Scaffolding 1.0
 */
function scaffolding_register_nav_menu() {
	register_nav_menus(
		array(
			'main-nav'   => __( 'Main Menu', 'scaffolding' ),
			'footer-nav' => __( 'Footer Menu', 'scaffolding' ),
		)
	);
}
add_action( 'after_setup_theme', 'scaffolding_register_nav_menu', 0 );

/**
 * Main navigation menu
 *
 * @see Scaffolding_Walker_Nav_Menu
 */
function scaffolding_main_nav() {
	wp_nav_menu(
		array(
			'container'       => '',                                     // remove nav container.
			'container_class' => '',                                     // class of container (should you choose to use it).
			'menu'            => '',                                     // nav name.
			'menu_class'      => 'menu main-menu',                       // adding custom nav class.
			'theme_location'  => 'main-nav',                             // where it's located in the theme.
			'before'          => '',                                     // before the menu.
			'after'           => '',                                     // after the menu.
			'link_before'     => '',                                     // before each link.
			'link_after'      => '',                                     // after each link.
			'depth'           => 0,                                      // limit the depth of the nav.
			'fallback_cb'     => '',                                     // fallback function.
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'walker'          => new Scaffolding_Walker_Nav_Menu(),
		)
	);
}

/**
 * Footer menu (should you choose to use one)
 */
function scaffolding_footer_nav() {
	wp_nav_menu(
		array(
			'container'       => '',
			'container_class' => '',
			'menu'            => '',
			'menu_class'      => 'menu footer-menu',
			'theme_location'  => 'footer-nav',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'depth'           => 1,                  // only display top level items.
			'fallback_cb'     => '__return_false',
		)
	);
}


/**
 * Custom walker to build main navigation menu
 *
 * Adds classes for enhanced styles and support for mobile off-canvas menu.
 *
 * @since Scaffolding 1.0
 */
class Scaffolding_Walker_Nav_Menu extends Walker_Nav_Menu {
	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker::start_lvl()
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClassAfterLastUsed
		// depth dependent classes.
		$indent        = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent.
		$display_depth = ( $depth + 1 ); // because it counts the first submenu as 0.
		$classes       = array(
			'sub-menu',
			( $display_depth % 2 ? 'menu-odd' : 'menu-even' ),
			'menu-depth-' . $display_depth,
		);
		$class_names   = implode( ' ', $classes );

		// build html.
		$output .= "\n" . $indent . '<ul class="' . $class_names . '"><li><button class="menu-back-button" type="button"><i class="fa fa-chevron-left"></i> Back</button></li>' . "\n";
	}

	/**
	 * Starts the element output.
	 *
	 * @see Walker::start_el()
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int      $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		// set li classes.
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		if ( ! $args->has_children ) {
			$classes[] = 'menu-item-no-children';
		}

		// combine the class array into a string.
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		// set li id.
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

		// set outer li and its attributes.
		$output .= $indent . '<li' . $id . $class_names . '>';

		// set link attributes.
		$attributes  = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : ' title="' . esc_attr( wp_strip_all_tags( $item->title ) ) . '"';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';

		// Add menu button links to items with children.
		if ( $args->has_children ) {
			$menu_pull_link = '<button class="menu-button" type="button"><i class="fa fa-chevron-right"></i></button>';
		} else {
			$menu_pull_link = '';
		}

		$item_output  = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after; // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
		$item_output .= '</a>';
		$item_output .= $menu_pull_link . $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @see Walker::end_el()
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Page data object. Not used.
	 * @param int      $depth  Depth of page. Not Used.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClassAfterLastUsed
		$output .= "</li>\n";
	}

	/**
	 * Add additional arguments to use for building the markup.
	 *
	 * @param WP_Post  $element           Menu item data object.
	 * @param WP_Post  $children_elements Menu item data object (passed by reference).
	 * @param int      $max_depth         Max depth of page. Not used.
	 * @param int      $depth             Depth of page. Not used.
	 * @param stdClass $args              An object of wp_nav_menu() arguments.
	 * @param string   $output            Used to append additional content (passed by reference).
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {

		// Set custom arg to tell if item has children.
		$id_field = $this->db_fields['id'];
		if ( is_object( $args[0] ) ) {
			$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
		}

		return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
}
