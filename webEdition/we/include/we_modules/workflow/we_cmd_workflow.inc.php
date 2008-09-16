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