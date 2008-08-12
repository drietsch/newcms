<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


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