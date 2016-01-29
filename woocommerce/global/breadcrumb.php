<?php
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

if ( ! empty( $breadcrumb ) ) {

	echo $wrap_before;
	
	/**
	 * SCAFFOLDING EDIT
	 * highly customized
	 * add referer url for single product pages
	 */
	
	// Update breadcrumb on product pages
	if ( is_product() ) {

		// Get referring url
		$referer = wp_get_referer();

		// Make sure referrer url is coming from a category
		if ( strpos( $referer, 'product-category' ) !== false ) {

			// Strip forward slash from end of url
			$referer_rtrim = rtrim( $referer, '/' );

			// Strip front of url including and before product-category 
			$referer_trim_front = substr( strstr( $referer_rtrim, '/product-category/'), strlen('/product-category/') );

			// Strip end of url including pagination
			$referer_trim_end = ( strpos( $referer_trim_front, '/page/' ) ) ? substr( $referer_trim_front, 0, strpos( $referer_trim_front, '/page/' ) ) : $referer_trim_front;

			// Put remaining slugs in url into an array
			$referer_array = explode( '/', $referer_trim_end );

			$breadcrumb_size = sizeof( $breadcrumb ) - 1; // offset 0 index
			$breadcrumb_update = array();
			$relevant_terms = array();
			$int = 0;

			$breadcrumb_update[] = $breadcrumb[0]; // push home link

			$reverse_referer_array = array_reverse( $referer_array );

			$child_term = get_term_by( 'slug', $reverse_referer_array[ $int ], 'product_cat' );

			if ( $child_term ) {
				$ancestors = get_ancestors( $child_term->term_id, 'product_cat' );
				$reverse_ancestors = array_reverse( $ancestors );

				if ( $reverse_ancestors ) {
					foreach( $reverse_ancestors as $ancestor ) {
						$term = get_term( $ancestor, 'product_cat' );
						$relevant_terms[] = array( $term->name, get_term_link( $term->term_id, 'product_cat' ) );
					}
				}

				$relevant_terms[] = array( $child_term->name, get_term_link( $child_term->term_id, 'product_cat' ) );
			}

			$breadcrumb_update = array_merge( $breadcrumb_update, $relevant_terms ); // merge our referrer links

			$breadcrumb_update[] = $breadcrumb[$breadcrumb_size]; // push current product

			$breadcrumb = $breadcrumb_update; // use our updated array for breadcrumb

		}
		
	}
	
	// Override breadcrumb on category pages
	if ( is_singular( 'post' ) ) {
		$breadcrumb = array();
		$blog_id = get_option( 'page_for_posts' );
		$breadcrumb[] = array( 'Home', get_home_url() );
		$breadcrumb[] = array( get_the_title( $blog_id ), get_permalink( $blog_id ) );
		$breadcrumb[] = array( get_the_title( $post->ID ), '' );
	}
	
	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

	foreach ( $breadcrumb as $key => $crumb ) {

		echo $before;
		
		if ( $key == 0 ) {
			$class = ' class="crumb-first"';
		} else {
			$class = '';
		}

		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			echo '<a href="' . esc_url( $crumb[1] ) . '" title="' . esc_attr( $crumb[0] ) . '"' . $class . '>' . esc_html( $crumb[0] ) . '</a>';
		} else {
			echo '<span class="crumb-current">' . esc_html( $crumb[0] ) . '</span>';
		}

		echo $after;

		if ( sizeof( $breadcrumb ) !== $key + 1 ) {
			echo $delimiter;
		}

	}

	echo $wrap_after;

}