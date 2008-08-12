<?php
	define("CSS_DIR", "/webEdition/css/");
	define("SCRIPT_BUTTONS_ONLY",'<script type="text/javascript" src="' . JS_DIR . 'weButton.js"></script>');
	define("STYLESHEET_BUTTONS_ONLY", '<link href="'.CSS_DIR.'we_button.css" rel="styleSheet" type="text/css">');
	define("STYLESHEET", '<link href="'.CSS_DIR.'global.php?WE_LANGUAGE=' . $GLOBALS["WE_LANGUAGE"] . '" rel="styleSheet" type="text/css">'.STYLESHEET_BUTTONS_ONLY . SCRIPT_BUTTONS_ONLY);
	define("STYLESHEET_SCRIPT", '<link href="'.CSS_DIR.'global.php?WE_LANGUAGE=' . $GLOBALS["WE_LANGUAGE"] . '" rel="styleSheet" type="text/css">'.STYLESHEET_BUTTONS_ONLY);
?>