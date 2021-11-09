const mix = require('laravel-mix');
const fs = require('fs');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

const sass_path = 'scss';
const css_path = 'css';

mix.sass(sass_path + '/style.scss', css_path)
	.sass(sass_path + '/login.scss', css_path)
	.sass(sass_path + '/editor-styles.scss', css_path)
	.sass(sass_path + '/plugins/woocommerce/global.scss', css_path + '/plugins/woocommerce')
	.sass(sass_path + '/plugins/woocommerce/product.scss', css_path + '/plugins/woocommerce')
	.sass(sass_path + '/plugins/woocommerce/cart.scss', css_path + '/plugins/woocommerce')
	.sass(sass_path + '/plugins/woocommerce/checkout.scss', css_path + '/plugins/woocommerce')
	.sass(sass_path + '/plugins/woocommerce/myaccount.scss', css_path + '/plugins/woocommerce')
	.sass(sass_path + '/plugins/woocommerce/blocks.scss', css_path + '/plugins/woocommerce')
	.sass(sass_path + '/libs/fontawesome/all.scss', css_path + '/libs/fontawesome')
	.sass(sass_path + '/libs/fontawesome/brands.scss', css_path + '/libs/fontawesome')
	.sass(sass_path + '/libs/fontawesome/fontawesome.scss', css_path + '/libs/fontawesome')
	.sass(sass_path + '/libs/fontawesome/regular.scss', css_path + '/libs/fontawesome')
	.sass(sass_path + '/libs/fontawesome/solid.scss', css_path + '/libs/fontawesome')
	.sass(sass_path + '/libs/fontawesome/v4-shims.scss', css_path + '/libs/fontawesome')
	.options({
		processCssUrls: false
	});
