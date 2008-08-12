<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/newfile.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/metadata.inc.php");

protect();

// init document
$we_alerttext = "";
$we_button = new we_button();
$allowedContentTypes = "";
$error = false;

$maxsize = getUploadMaxFilesize(false);
$we_maxfilesize_text = sprintf($GLOBALS["l_newFile"]["max_possible_size"],round($maxsize / (1024*1024),3)."MB");


htmlTop($l_newFile["import_File_from_hd_title"]);

print STYLESHEET;

if(!isset($_SESSION["we_data"][$we_transaction])){
	$we_alerttext = $we_maxfilesize_text;
	$error = true;
}else{

	$we_dt = $_SESSION["we_data"][$we_transaction];
	include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_editors/we_init_doc.inc.php");

	switch ($we_doc->ContentType) {
		case "image/*";
			$allowedContentTypes = IMAGE_CONTENT_TYPES;
			break;
		case "application/*";
			break;
		default:
			$allowedContentTypes = $we_doc->ContentType;
	}

	if(isset($_FILES["we_File"]) && $_FILES["we_File"]["name"] != "" && $_FILES['we_File']["type"] && (($allowedContentTypes == "") || (!(strpos($allowedContentTypes,$_FILES['we_File']["type"]) === false)))) {
		$we_File = TMP_DIR."/".md5(uniqid(rand(),1));
		move_uploaded_file($_FILES["we_File"]["tmp_name"],$we_File);
		if((!$we_doc->Filename) || (!$we_doc->ID)) {
			// Bug Fix #6284
			$we_doc->Filename = preg_replace("/[^A-Za-z0-9._-]/", "", $_FILES["we_File"]["name"]);
			$we_doc->Filename = eregi_replace('^(.+)\..+$',"\\1",$we_doc->Filename);
		}

		$foo = explode("/",$_FILES["we_File"]["type"]);
		$we_doc->setElement("data",$we_File,$foo[0]);
		if ($we_doc->ContentType == "image/*") {
			$we_size = $we_doc->getimagesize($we_File);
			$we_doc->setElement("width",$we_size[0],"attrib");
			$we_doc->setElement("height",$we_size[1],"attrib");
			$we_doc->setElement("origwidth",$we_size[0]);
			$we_doc->setElement("origheight",$we_size[1]);
		}

		$we_doc->Extension = (strpos($_FILES["we_File"]["name"],".") > 0) ? eregi_replace('^.+(\..+)$',"\\1",$_FILES["we_File"]["name"]) : "";
		$we_doc->Text = $we_doc->Filename.$we_doc->Extension;
		$we_doc->Path = $we_doc->getPath();
		$we_doc->DocChanged = true;

		$_SESSION["we_data"]["tmpName"] = $we_File;
		if(isset($_REQUEST["import_metadata"]) && !empty($_REQUEST["import_metadata"])) {
			$we_doc->importMetaData();
		}
		$we_doc->saveInSession($_SESSION["we_data"][$we_transaction]); // save the changed object in session
	} else if(isset($_FILES['we_File']['name']) && !empty($_FILES['we_File']['name'])) {
		$we_alerttext=$l_alert["wrong_file"][$we_doc->ContentType];
	} else if(isset($_FILES['we_File']['name']) && empty($_FILES['we_File']['name'])) {
		$we_alerttext=$l_alert["no_file_selected"];
	}

}

$content = '<table border="0" cellpadding="0" cellspacing="0">'.
($maxsize ? ('<tr><td>'.htmlAlertAttentionBox(
								$we_maxfilesize_text,
								1,390).'</td></tr><tr><td>'.getPixel(2,10).'</td></tr>') : '').'
				<tr><td><input name="we_File" TYPE="file"'.($allowedContentTypes ? ' ACCEPT="'.$allowedContentTypes.'"' : '').' size="35">'.'</td></tr>
				<tr><td>'.getPixel(2,10).'</td></tr>
';
								if 	($we_doc->ContentType=="image/*") {
									$content .= '<tr><td>'.we_forms::checkbox("1", true, "import_metadata", $l_metadata["import_metadata_at_upload"]).'</td></tr>
';
								}
								$content .= '</table>';


$_buttons = $we_button->position_yes_no_cancel(	$we_button->create_button("upload", "javascript:document.forms[0].submit();"),
												"",
												$we_button->create_button("cancel", "javascript:self.close();")
												);

?>


<script language="JavaScript" type="text/javascript"><!--
	<?php if($we_alerttext): ?>
	<?php print we_message_reporting::getShowMessageCall($we_alerttext, WE_MESSAGE_ERROR); ?>
		<?php if($error): ?>
		top.close();
		<?php endif ?>
	<?php endif ?>

	<?php if(isset($we_File) && (!$we_alerttext)) : ?>
		opener.we_cmd("update_file");
		_EditorFrame = opener.top.weEditorFrameController.getActiveEditorFrame();
		_EditorFrame.getDocumentReference().frames[0].we_setPath("<?php print $we_doc->Path; ?>","<?php print $we_doc->Text; ?>");
		self.close();
	<?php endif ?>
//-->
</script>
</head>

<body class="weDialogBody" onload="self.focus();">
	<center>
		<form method="post" enctype="multipart/form-data">
			<input type="hidden" name="we_transaction" value="<?php print $we_transaction ?>">
			<?php print htmlDialogLayout($content,$l_newFile["import_File_from_hd_title"], $_buttons); ?>
		</form>
	</center>
</body>

</html>