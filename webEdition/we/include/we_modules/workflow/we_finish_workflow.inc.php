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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_editor.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");

protect();

$_REQUEST["we_cmd"] = isset($_REQUEST["we_cmd"]) ? $_REQUEST["we_cmd"] : "";
$we_transaction = isset($_REQUEST["we_cmd"][1]) ? $_REQUEST["we_cmd"][1] : (isset($_REQUEST["we_transaction"]) ? $_REQUEST["we_transaction"] : "");

// init document
$we_dt = $_SESSION["we_data"][$we_transaction];
include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_editors/we_init_doc.inc.php");

if(weWorkflowUtility::approve($we_doc->ID,$we_doc->Table,$_SESSION["user"]["ID"],"",true)) {
	if($we_doc->i_publInScheduleTable()) {
		$we_responseText = sprintf($l_we_editor[$we_doc->ContentType]["autoschedule"],date($l_global["date_format"],$we_doc->From));
		$we_responseTextType = WE_MESSAGE_NOTICE;
	}
	else{
		if($we_doc->we_publish()) {
			$we_JavaScript = "_EditorFrame.setEditorDocumentId(".$we_doc->ID.");\n".$we_doc->getUpdateTreeScript()."\n";
			$we_responseText = sprintf($l_we_editor[$we_doc->ContentType]["response_publish_ok"],$we_doc->Path);
			$we_responseTextType = WE_MESSAGE_NOTICE;
			if(($we_doc->EditPageNr == WE_EDITPAGE_PROPERTIES || $we_doc->EditPageNr == WE_EDITPAGE_INFO)) {
				$_REQUEST["we_cmd"][5] = 'top.we_cmd("switch_edit_page","'.$we_doc->EditPageNr.'","'.$we_transaction.'");'; // wird in Templ eingefügt
			}
			$we_JavaScript .= "top.weEditorFrameController.getActiveDocumentReference().frames[3].location.reload();_EditorFrame.setEditorDocumentId(".$we_doc->ID.");\n".$we_doc->getUpdateTreeScript()."\n";
		}
		else {
			$we_responseText = sprintf($l_we_editor[$we_doc->ContentType]["response_publish_notok"],$we_doc->Path);
			$we_responseTextType = WE_MESSAGE_ERROR;
		}
	}
}
else {
	$we_responseText = $l_workflow[$we_doc->Table]["pass_workflow_notok"];
	$we_responseTextType = WE_MESSAGE_ERROR;
	$we_responseText = '';
}

include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_templates/we_editor_save.inc.php");

?>