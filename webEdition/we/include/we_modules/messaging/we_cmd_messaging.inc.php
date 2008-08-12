<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


	switch($_REQUEST["we_cmd"][0]) {
		case 'messaging_start':
		case 'edit_messaging_ifthere':
			$mod="messaging";
			$INCLUDE = 'we_modules/show_frameset.php';
			break;
	}
?>
