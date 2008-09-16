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