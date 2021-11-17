== Responsive Design Scaffolding for WordPress ==

Contributors: Hall
Tags: translation-ready, microformats, rtl-language-support

Requires at least: 4.0
Tested up to: 5.5.1
Stable tag: 3.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Scaffolding is designed to make the life of developers easier. It is built using HTML5 & has a strong semantic foundation. It is developed with the goal of providing a starting point for every responsive WordPress theme that we build.

== Installation ==

1. In your admin panel, go to Appearance > Themes and click the Add New button.
2. Click Upload and Choose File, then select the theme's .zip file. Click Install Now.
3. Click Activate to use your new theme right away.

== Get Started ==

Our theme uses SCSS for our styles located in the /scss/ folder and these get compiled into the /css/ folder.
https://sass-lang.com/

Our SCSS is compiled using Laravel Mix, an API for defining Webpack build steps.
https://laravel-mix.com/

1. Requires NPM/Node.js to be installed
2. Run `npm install` to install dependencies
3. Compile SCSS with one of the following commands:
   a) `npm run watch` - continually runs in the terminal, watching for files changes, and then automatically recompiles
   b) `npm run production` - runs all Mix tasks and minifies the output
