<?php

/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
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