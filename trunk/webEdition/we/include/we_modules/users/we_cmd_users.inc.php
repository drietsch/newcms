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
	case "edit_users":
	case "edit_users_ifthere":
		$mod="users";
		$INCLUDE = "we_modules/show_frameset.php";
		break;

	case "unlock":
		$INCLUDE = "we_modules/users/we_users_unlock.inc.php";
		break;

	case "browse_users":
		$INCLUDE = "we_modules/users/browse_users_frameset.inc.php";
		break;

	case "add_owner":
	case "del_owner":
	case "del_user":
	case "del_all_owners":
	case "add_user":
		$INCLUDE = "we_editors/we_editor.inc.php";
		break;

	case "changeR":
		$INCLUDE = "we_modules/users/changeRec_users.inc.php";
		break;

}

?>