<?php

/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


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