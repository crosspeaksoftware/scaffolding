<?php
/* Welcome to scaffolding :)
Thanks to the fantastic work by scaffolding users, we've now
the ability to translate scaffolding into different languages.

Developed by: Eddie Machado
*/



// Adding Translation Option
load_theme_textdomain( 'scaffoldingtheme', get_template_directory() .'/translation' );
	$locale = get_locale();
	$locale_file = get_template_directory() ."/translation/$locale.php";
if ( is_readable($locale_file) ) require_once($locale_file);








?>