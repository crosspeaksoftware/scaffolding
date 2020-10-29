<?php
/**
 * The template for displaying search forms
 *
 * @package Scaffolding
 */

global $scaffolding_search_form_index;

if ( empty( $scaffolding_search_form_index ) ) {
	$scaffolding_search_form_index = 0;
}

$scaffolding_index = $scaffolding_search_form_index++;

?>
<form method="get" class="sc-searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<label class="screen-reader-text" for="sc-searchform-field-<?php echo isset( $scaffolding_index ) ? absint( $scaffolding_index ) : 0; ?>"><?php esc_html_e( 'Search for:', 'scaffolding' ); ?></label>
	<input type="search" class="sc-searchform-field" name="s" id="sc-searchform-field-<?php echo isset( $scaffolding_index ) ? absint( $scaffolding_index ) : 0; ?>" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search the Site&hellip;', 'scaffolding' ); ?>">
	<button type="submit" value="<?php esc_attr_e( 'Search', 'scaffolding' ); ?>"><?php esc_attr_e( 'Go', 'scaffolding' ); ?></button>
</form>
