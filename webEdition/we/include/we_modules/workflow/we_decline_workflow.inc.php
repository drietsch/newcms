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

protect();
if($cmd == "ok") {
	$wf_text = $_REQUEST["wf_text"];
	$wf_select = isset($_REQUEST["wf_select"]) ? $_REQUEST["wf_select"] : "";
	$force = (!weWorkflowUtility::isUserInWorkflow($we_doc->ID,$we_doc->Table,$_SESSION["user"]["ID"]));

	$ok = weWorkflowUtility::decline($we_doc->ID,$we_doc->Table,$_SESSION["user"]["ID"],$wf_text,$force);

	if($ok) {

		$msg = $l_workflow[$we_doc->Table]["decline_workflow_ok"];
		$msgType = WE_MESSAGE_NOTICE;

		//	in SEEM-Mode back to Preview page
		if($_SESSION["we_mode"] == "seem"){

			$script = "opener.top.we_cmd('switch_edit_page'," .WE_EDITPAGE_PREVIEW . ",'" . $we_transaction . "');";
		} else if($_SESSION["we_mode"] == "normal"){
			
			$script = 'opener.top.weEditorFrameController.getActiveDocumentReference().frames[3].location.reload();';
		}

		if(($we_doc->EditPageNr == WE_EDITPAGE_PROPERTIES || $we_doc->EditPageNr == WE_EDITPAGE_INFO)) {
			$script .= 'opener.top.we_cmd("switch_edit_page","'.$we_doc->EditPageNr.'","'.$we_transaction.'");'; // will be inserted into the template
		}
	}
	else {
		$msg = $l_workflow[$we_doc->Table]["decline_workflow_notok"];
		$msgType = WE_MESSAGE_ERROR;
		//	in SEEM-Mode back to Preview page
		if($_SESSION["we_mode"] == "seem"){

			$script = "opener.top.we_cmd('switch_edit_page'," .WE_EDITPAGE_PREVIEW . ",'" . $we_transaction . "');";
		} else if($_SESSION["we_mode"] == "normal"){
			
			$script = '';
		}
	}
	print '
		<script language="JavaScript" type="text/javascript"><!--
			'.$script.'
			' . we_message_reporting::getShowMessageCall($msg, $msgType) . '
			self.close();
		//-->
		</script>';
}
?>
<?php print STYLESHEET; ?>
</head>

<body class="weDialogBody">
	<center>
		<?php if($cmd!="ok"): ?>
			<form action="<?php print WEBEDITION_DIR; ?>we_cmd.php" method="post">
				<?php
					$we_button = new we_button();
					$okbut     = $we_button->create_button("ok", "javascript:document.forms[0].submit()");
					$cancelbut = $we_button->create_button("cancel", "javascript:top.close()");
					$content = '<table border="0" cellpadding="0" cellspacing="0">';
					$wf_textarea = '<textarea name="wf_text" rows="7" cols="50" style="width:360;height:190"></textarea>';
					$content .= '
						<tr>
							<td class="defaultfont">
								'.$l_workflow["message"].'</td>
						</tr>
						<tr>
							<td>
								'.$wf_textarea.'</td>
						</tr>
					</table>';
					
					$_button = $we_button->position_yes_no_cancel(	$okbut,
																	"",
																	$cancelbut);
					$frame = htmlDialogLayout($content,$l_workflow["decline_workflow"], $_button);
					print $frame;
					print '
						<input type="hidden" name="cmd" value="ok">
						<input type="hidden" name="we_cmd[0]" value="'.$_REQUEST["we_cmd"][0].'">
						<input type="hidden" name="we_cmd[1]" value="'.$we_transaction.'">';
				?>
			</form>
		<?php endif ?>
	</center>

</body>

</html>