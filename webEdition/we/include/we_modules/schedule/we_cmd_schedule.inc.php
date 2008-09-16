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