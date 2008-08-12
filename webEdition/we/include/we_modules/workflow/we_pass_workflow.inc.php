<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_language/" . $GLOBALS["WE_LANGUAGE"] . "/we_editor.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
if($cmd == "ok"){
	$wf_text = $_REQUEST["wf_text"];
	$wf_select = isset($_REQUEST["wf_select"]) ? $_REQUEST["wf_select"] : "";	
	
	$force = (!weWorkflowUtility::isUserInWorkflow($we_doc->ID,$we_doc->Table,$_SESSION["user"]["ID"]));
	
	$ok = weWorkflowUtility::approve($we_doc->ID,$we_doc->Table,$_SESSION["user"]["ID"],$wf_text,$force);
	
	if($ok){
		$msg = $l_workflow[$we_doc->Table]["pass_workflow_ok"];
		$msgType = WE_MESSAGE_NOTICE;
		
		//	in SEEM-Mode back to Preview page
		if($_SESSION["we_mode"] == "seem"){

			$script = "opener.top.we_cmd('switch_edit_page'," .WE_EDITPAGE_PREVIEW . ",'" . $we_transaction . "');";
		} else if($_SESSION["we_mode"] == "normal"){
			
			$script = 'opener.top.weEditorFrameController.getActiveDocumentReference().frames[3].location.reload();';
		}
		
		if(($we_doc->EditPageNr == WE_EDITPAGE_PROPERTIES || $we_doc->EditPageNr == WE_EDITPAGE_INFO)){
			$script .= 'opener.top.we_cmd("switch_edit_page","'.$we_doc->EditPageNr.'","'.$we_transaction.'");'; // wird in Templ eingef�gt
		}
	}else{
		$msg = $l_workflow[$we_doc->Table]["pass_workflow_notok"];
		$msgType = WE_MESSAGE_ERROR;
				//	in SEEM-Mode back to Preview page
		if($_SESSION["we_mode"] == "seem"){

			$script = "opener.top.we_cmd('switch_edit_page'," .WE_EDITPAGE_PREVIEW . ",'" . $we_transaction . "');";
		} else if($_SESSION["we_mode"] == "normal"){
			
			$script = '';
		}
	}
	print '<script language="JavaScript" type="text/javascript"><!--
'.$script.'
' . we_message_reporting::getShowMessageCall($msg,  $msgType) . ';
top.close();
//-->
</script>
';
}
?>
<?php print STYLESHEET; ?>
</head>
<body class="weDialogBody"><center>
<?php if($cmd=="ok"): ?>
<?php else: ?>
<form action="<?php print WEBEDITION_DIR; ?>we_cmd.php" method="post">
<?php

$we_button = new we_button();

$okbut     = $we_button->create_button("ok", "javascript:document.forms[0].submit()");
$cancelbut = $we_button->create_button("cancel", "javascript:top.close()");


$content = '<table border="0" cellpadding="0" cellspacing="0">
';
$wf_textarea = '<textarea name="wf_text" rows="7" cols="50" style="width:360;height:190"></textarea>';
$content .= '<tr>
<td class="defaultfont">'.$l_workflow["message"].'</td>
</tr>
<tr>
<td>'.$wf_textarea.'</td>
</tr>
</table>
';

$_buttons = $we_button->position_yes_no_cancel(	$okbut,
												"",
												$cancelbut);
$frame = htmlDialogLayout($content,$l_workflow["pass_workflow"], $_buttons);

print $frame;

print '	<input type="hidden" name="cmd" value="ok">
		<input type="hidden" name="we_cmd[0]" value="'.$_REQUEST["we_cmd"][0].'">
		<input type="hidden" name="we_cmd[1]" value="'.$we_transaction.'">';
?>
</form>
<?php endif ?>
</center>
</body>
</html>