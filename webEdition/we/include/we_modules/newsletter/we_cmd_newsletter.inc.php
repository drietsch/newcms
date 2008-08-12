<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


switch ($_REQUEST["we_cmd"][0]) {
	case "edit_newsletter":
	case "edit_newsletter_ifthere":
		$mod="newsletter";
		$INCLUDE = "we_modules/show_frameset.php";
		break;
}

?>