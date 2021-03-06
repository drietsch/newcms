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
	case "finish_workflow":
		$INCLUDE = "we_modules/workflow/we_finish_workflow.inc.php";
		break;

	case "in_workflow":
	case "pass":
	case "decline":
		$INCLUDE = "we_modules/workflow/we_workflow_win.inc.php";
		break;

	case "edit_workflow":
	case "edit_workflow_ifthere":
		$mod="workflow";
		$INCLUDE = "we_modules/show_frameset.php";
		break;

}

?>