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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/alert.inc.php");
protect();
protect();

htmlTop($l_global["question"]);


// we_cmd[0] => exit_doc_question
// we_cmd[1] => multiEditFrameId
// we_cmd[2] => content-type of the document
// we_cmd[3] => nextCommand -> as JS-String


$editorFrameId	= $_REQUEST['we_cmd']['1'];
if (!preg_match('/^multiEditFrame_[0-9]+$/', $editorFrameId)) {
	exit('cmd[1] is not valid at we_exit_doc_question!');
}

$exitDocCt		= $_REQUEST['we_cmd']['2'];
$nextCmd		= isset($_REQUEST['we_cmd']['3']) ? $_REQUEST['we_cmd']['3'] : ""; // close_all, logout, open_document, new_document(seeMode) etc.

$isOpenDocCmd = preg_match('/^top\.weEditorFrameController\.openDocument\("[^"]*"\s*,\s*"[^"]*"\s*,\s*"[^"]*"\s*,\s*"[^"]*"\s*,\s*"[^"]*"\s*,\s*"[^"]*"\s*,\s*"[^"]*"\s*,\s*"[^"]*"\s*,\s*"[^"]*"\s*\)\s*;\s*$/', $nextCmd);
$isDoLogoutCmd = preg_match('/^top\.we_cmd\("dologout"\)\s*;\s*$/',$nextCmd);
$isCloseAllCmd = preg_match('/^top\.we_cmd\("close_all_documents"\)\s*;\s*$/',$nextCmd);
$isCloseAllButActiveDocumentCmd = preg_match('/^top\.we_cmd\("close_all_but_active_document"\s*,\s*"[^"]*"\s*\)\s*;\s*$/',$nextCmd);

$nextCmdOk = ($nextCmd === "")  
		|| $isOpenDocCmd  
		|| $isDoLogoutCmd  
		|| $isCloseAllCmd  
		|| $isCloseAllButActiveDocumentCmd;


if (!$nextCmdOk) {
	exit('cmd[3] (nextCmd) is not valid at we_exit_doc_question!');
}

switch ($exitDocCt) {
	case "text/weTmpl":
		$_documentTable = TEMPLATES_TABLE;
		break;
	case "object":
		if( defined("OBJECT_TABLE") ){
			$_documentTable = OBJECT_TABLE;
		}
		break;
	case "objectFile":
		if( defined("OBJECT_FILES_TABLE") ){
			$_documentTable = OBJECT_FILES_TABLE;
		}
		break;
	case "folder":
	case "text/webedition":
	case "text/html":
	case "text/css":
	case "text/js":
	case "image/*":
	case "application/*":
	default:
		$_documentTable = FILE_TABLE;
	break;
}


print "
<script type=\"text/javascript\" src=\"" . JS_DIR . "keyListener.js\"></script>
<script type=\"text/javascript\">
	
	var _nextCmd = null;
	var _EditorFrame = top.opener.top.weEditorFrameController.getEditorFrame('$editorFrameId');
	self.focus();
	
	// functions for keyBoard Listener
	function applyOnEnter() {
		pressed_yes();
	
	}
	
	// functions for keyBoard Listener
	function closeOnEscape() {
		pressed_cancel();
		
	}
	
	function pressed_yes() {
		_EditorFrame.getDocumentReference().frames[3].we_save_document('" . str_replace("'","\\'", "top.weEditorFrameController.closeDocument('$editorFrameId');" .  ($nextCmd ? "top.setTimeout('$nextCmd', 1000);" : "" ) ) . "');
		window_closed();
		self.close();
	}
	
	function pressed_no() {
		_EditorFrame.setEditorIsHot(false);
		opener.top.weEditorFrameController.closeDocument('$editorFrameId');
		" . ($nextCmd ? "opener.top.setTimeout('$nextCmd', 1000);" : "" ) . "
		window_closed();
		self.close();
		
	}
	
	function pressed_cancel() {
		window_closed();
		self.close();
		
	}
	
	function window_closed() {
		_EditorFrame.EditorExitDocQuestionDialog = false;
		
	}
	
</script>
";

// $yesCmd: $_REQUEST["we_cmd"][6] => next-EditCommand, JS-Function Call !! after save document.
$yesCmd = "pressed_yes();";
$noCmd = "pressed_no();";
$cancelCmd = "pressed_cancel();";



print STYLESHEET;
?>
</head>

<body onUnload="window_closed();" class="weEditorBody" onload="self.focus();" onBlur="self.focus();">
	<?php print htmlYesNoCancelDialog($l_alert["exit_doc_question_$_documentTable"],IMAGE_DIR."alert.gif",true,true,true,$yesCmd,$noCmd,$cancelCmd); ?>
</body>

</html>