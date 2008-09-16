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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/fileselector.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/newfile.inc.php");

protect();

htmlTop();

print STYLESHEET;

$we_button = new we_button();

$cpat=ereg_replace("//","/",$_SERVER["DOCUMENT_ROOT"].$_REQUEST["pat"]);

function weFile($f){
    global $DB_WE;
    $DB_WE->query("SELECT ID FROM ".FILE_TABLE." WHERE Path='".$f."'");
    if($DB_WE->next_record()) return true;
    return false;
}

$we_alerttext = "";

if (isset($_FILES['we_uploadFile'])) {
	$overwrite = $_REQUEST["overwrite"];
	$tempName = TMP_DIR."/".md5(uniqid(rand(),1));
	move_uploaded_file($_FILES['we_uploadFile']["tmp_name"],$tempName);
	if(file_exists($cpat."/".$_FILES['we_uploadFile']["name"])){
		if($overwrite=="yes"){
			if(weFile($_REQUEST["pat"]."/".$_FILES['we_uploadFile']["name"])){
				$we_alerttext = $GLOBALS["l_fileselector"]["can_not_overwrite_we_file"];
			}
		}else{
			$z=0;

			if(ereg('^(.+)(\.[^\.]+)$',$_FILES['we_uploadFile']["name"],$regs)){
				$extension = $regs[2];
				$filename = $regs[1];
			}else{
				$extension = "";
				$filename = $_FILES['we_uploadFile']["name"];
			}

			$footext = $filename."_".$z.$extension;
			while(file_exists($cpat."/".$footext)){
				$z++;
				$footext = $filename."_".$z.$extension;
			}
			$_FILES['we_uploadFile']["name"] = $footext;
		}
	}
	if(!$we_alerttext){
		copy($tempName,str_replace("\\","/",str_replace("//","/",$cpat."/".$_FILES['we_uploadFile']["name"])));
	}
	deleteLocalFile($tempName);
}
$maxsize = getUploadMaxFilesize(false);


$yes_button = $we_button->create_button("upload", "javascript:if(!document.forms['we_form'].elements['we_uploadFile'].value) { " . we_message_reporting::getShowMessageCall($l_fileselector["edit_file_nok"], WE_MESSAGE_ERROR) . "} else document.forms['we_form'].submit();");
$cancel_button = $we_button->create_button("cancel", "javascript:self.close();");
$buttons = we_button::position_yes_no_cancel($yes_button, null, $cancel_button);

$content = '<table border="0" cellpadding="0" cellspacing="0">'.
($maxsize ? ('<tr><td>'.htmlAlertAttentionBox(
							sprintf($GLOBALS["l_newFile"]["max_possible_size"],round($maxsize / (1024*1024),3)."MB"),
							1,390).'</td></tr><tr><td>'.getPixel(2,10).'</td></tr>') : '').'
			<tr><td><input name="we_uploadFile" TYPE="file" size="35">'.'</td></tr><tr><td>'.getPixel(2,10).'</td></tr>
			<tr><td class="defaultfont">'.$GLOBALS["l_newFile"]["caseFileExists"].'</td></tr><tr><td>'.
			we_forms::radiobutton("yes", true, "overwrite", $GLOBALS["l_newFile"]["overwriteFile"]).
			we_forms::radiobutton("no", false, "overwrite", $GLOBALS["l_newFile"]["renameFile"]).'</td></tr></table>';

$content = htmlDialogLayout($content,$l_newFile["import_File_from_hd_title"],$buttons);


?>
<script language="JavaScript" type="text/javascript"><!--
self.focus();
<?php if(isset($_FILES['we_uploadFile']) && (!$we_alerttext)):?>
 opener.top.fscmd.selectFile('<?php print $_FILES['we_uploadFile']["name"]; ?>');
   opener.top.fscmd.selectDir();
 self.close();
<?php elseif($we_alerttext):
	print we_message_reporting::getShowMessageCall($we_alerttext, WE_MESSAGE_ERROR);
endif ?>
//-->
</script>
</head>
<body class="weDialogBody" onload="self.focus();"><center>
<input type="hidden" name="pat" value="<?php print $_REQUEST["pat"]; ?>">
<form method="post" enctype="multipart/form-data" name="we_form">
	<?php print $content; ?>
</form>
</center>
</body>
</html>
