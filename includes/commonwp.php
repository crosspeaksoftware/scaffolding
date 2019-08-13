<?php
/**
 * CommonWP support
 *
 * Adds support for the assets from this package to be loaded through cdn.jsdelivr.net
 * if you have the commonWP plugin installed https://wordpress.org/plugins/commonwp/
 *
 * @package Scaffolding
 */

/**
 * Filter scripts and their data available for replacement.
 *
 * @param array $scripts Scripts and their data available for replacement.
 * @return array
 */
function scaffolding_commonwp_npm_packages_scripts( $scripts ) {
	$scripts['scaffolding-retinajs'] = [
		'package'  => 'retinajs',
		'file'     => 'dist/retina',
		'minified' => '.min',
	];
	$scripts['scaffolding-doubletaptogo-js'] = [
		'package'  => 'jquery-doubletaptogo',
		'file'     => 'dist/jquery.dcd.doubletaptogo',
		'minified' => '.min',
	];
	$scripts['scaffolding-magnific-popup-js'] = [
		'package'  => 'magnific-popup',
		'file'     => 'dist/jquery.magnific-popup',
		'minified' => '.min',
	];
	return $scripts;
}
add_filter( 'npm_packages_scripts', 'scaffolding_commonwp_npm_packages_scripts', 10, 1 );

