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
//	case "edit_schedule_ifthere":
//	case "edit_schedule":
//		$mod="schedule";
//		$INCLUDE = "we_modules/show_frameset.php";
//		break;

	case "add_schedule":
	case "del_schedule":
	case "add_schedcat":
	case "delete_all_schedcats":
	case "delete_schedcat":
		$INCLUDE = "we_editors/we_editor.inc.php";
		break;

}

?>