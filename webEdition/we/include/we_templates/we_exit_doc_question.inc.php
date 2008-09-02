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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/alert.inc.php");

htmlTop($l_global["question"]);


// we_cmd[0] => exit_doc_question
// we_cmd[1] => multiEditFrameId
// we_cmd[2] => content-type of the document
// we_cmd[3] => nextCommand -> as JS-String


$editorFrameId	= $_REQUEST['we_cmd']['1'];
$exitDocCt		= $_REQUEST['we_cmd']['2'];
$nextCmd		= $_REQUEST['we_cmd']['3']; // close_all, logout, open_document, new_document(seeMode) etc.

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