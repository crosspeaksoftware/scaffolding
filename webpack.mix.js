const mix = require('laravel-mix');

mix.sass('scss/style.scss', 'css')
	.sass('scss/login.scss', 'css')
	.sass('scss/editor-styles.scss', 'css')
	.sass('scss/plugins/woocommerce/global.scss', 'css/plugins/woocommerce')
	.sass('scss/plugins/woocommerce/product.scss', 'css/plugins/woocommerce')
	.sass('scss/plugins/woocommerce/cart.scss', 'css/plugins/woocommerce')
	.sass('scss/plugins/woocommerce/checkout.scss', 'css/plugins/woocommerce')
	.sass('scss/plugins/woocommerce/myaccount.scss', 'css/plugins/woocommerce')
	.sass('scss/plugins/woocommerce/blocks.scss', 'css/plugins/woocommerce')
	.sass('scss/libs/fontawesome/all.scss', 'css/libs/fontawesome')
	.sass('scss/libs/fontawesome/brands.scss', 'css/libs/fontawesome')
	.sass('scss/libs/fontawesome/fontawesome.scss', 'css/libs/fontawesome')
	.sass('scss/libs/fontawesome/regular.scss', 'css/libs/fontawesome')
	.sass('scss/libs/fontawesome/solid.scss', 'css/libs/fontawesome')
	.sass('scss/libs/fontawesome/v4-shims.scss', 'css/libs/fontawesome')
	.options({
		processCssUrls: false
	});
