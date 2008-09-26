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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/workflow.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/workflow/weWorkflowUtility.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

protect();

$_REQUEST["we_cmd"] = isset($_REQUEST["we_cmd"]) ? $_REQUEST["we_cmd"] : "";
$cmd = isset($_REQUEST["cmd"]) ? $_REQUEST["cmd"] : "";
$we_transaction = isset($_REQUEST["we_cmd"][1]) ? $_REQUEST["we_cmd"][1] : (isset($_REQUEST["we_transaction"]) ? $_REQUEST["we_transaction"] : "");

$wf_select = isset($_REQUEST["wf_select"]) ? $_REQUEST["wf_select"] : "";
$wf_text = isset($_REQUEST["wf_select"]) ? $_REQUEST["wf_text"] : "";

###### init document #########
$we_dt = $_SESSION["we_data"][$we_transaction];
include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_editors/we_init_doc.inc.php");


htmlTop();

$we_button = new we_button();
switch($_REQUEST["we_cmd"][0]){

	case "in_workflow":
		include(WE_WORKFLOW_MODULE_DIR."we_in_workflow.inc.php");
		break;
	case "pass":
		include(WE_WORKFLOW_MODULE_DIR."we_pass_workflow.inc.php");
		break;
	case "decline":
		include(WE_WORKFLOW_MODULE_DIR."we_decline_workflow.inc.php");
		break;
}
?>