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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/alert.inc.php");

protect();

if(!we_hasPerm("BROWSE_SERVER")) exit();

htmlTop();

print STYLESHEET;

$we_button = new we_button();
$we_fileData = "";

if(isset($_REQUEST["cmd"]) && $_REQUEST["cmd"]=="save"){
	if(isset($_REQUEST["editFile"])){
		$fh = fopen($_REQUEST["id"],"wb");
		fwrite($fh,$_REQUEST["editFile"]);
		fclose($fh);
	}
	$we_fileData=stripslashes($_REQUEST["editFile"]);
}else if(isset($_REQUEST["id"])){

	$_REQUEST["id"]=ereg_replace("//","/",$_REQUEST["id"]);
	$fh = fopen($_REQUEST["id"],"rb");
	if($fh){
		while(!feof($fh)) $we_fileData .= fread($fh,10000);
		fclose($fh);
	}else{
		$we_alerttext=sprintf($l_alert["can_not_open_file"],ereg_replace(str_replace("\\","/",dirname($_REQUEST["id"]))."/","",$_REQUEST["id"]));
	}

}

$buttons = $we_button->position_yes_no_cancel(
										$we_button->create_button("save", "javascript:document.forms[0].submit();"),
										null,
										$we_button->create_button("cancel", "javascript:self.close();")
											);
$content='<textarea name="editFile" id="editFile" style="width:540px;height:380px;overflow: auto;">'.htmlspecialchars($we_fileData).'</textarea>';

?>
<script language="JavaScript" type="text/javascript"><!--
	function setSize(){
		var ta = document.getElementById("editFile");
		ta.style.width=document.body.offsetWidth-60;
		ta.style.height=document.body.offsetHeight-118;
	}
<?php if(isset($we_alerttext)): ?>
<?php print we_message_reporting::getShowMessageCall($we_alerttext, WE_MESSAGE_ERROR); ?>
self.close();
<?php endif ?>
self.focus();
<?php if(isset($_REQUEST["editFile"]) && (!isset($we_alerttext))): ?>
    opener.top.fscmd.selectDir();
	self.close();
<?php endif ?>
//-->
</script>
</head>
<body class="weDialogBody" onresize="setSize()" style="width:100%; height:100%"><center>
<form method="post">
   <input type="hidden" name="cmd" value="save">
   <?php print htmlDialogLayout($content,$l_global["edit_file"].": <span class=\"weMultiIconBoxHeadline\">".ereg_replace(str_replace("\\","/",dirname($_REQUEST["id"]))."/","",$_REQUEST["id"]),$buttons)."</span>"; ?>
</form></center>
</body>
</html>
