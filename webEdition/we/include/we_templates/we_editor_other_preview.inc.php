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

$prot = getServerProtocol();
$preurl = (isset($_SERVER["HTTP_HOST"]) && $_SERVER["HTTP_HOST"]) ? "$prot://".$_SERVER["HTTP_HOST"] : "";

// force the download of this document
if (isset($_REQUEST['we_cmd'][3]) && $_REQUEST['we_cmd'][3] == "download") {
	$_filename = $we_doc->Filename.$we_doc->Extension;
	$_size = filesize($_SERVER["DOCUMENT_ROOT"].$we_doc->Path);

	if (we_isHttps()) {																		// Additional headers to make downloads work using IE in HTTPS mode.
		header("Pragma: ");
		header("Cache-Control: ");
		header("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");									// HTTP 1.1
		header("Cache-Control: post-check=0, pre-check=0", false);
	} else {
		header("Cache-control: private");
	}

	header("Content-Type: application/force-download");
	header("Content-Disposition: attachment; filename=\"" . trim(htmlentities($_filename)) . "\"");
	header("Content-Description: " . trim(htmlentities($_filename)));

	$_filehandler = readfile($_SERVER["DOCUMENT_ROOT"].$we_doc->Path);
	exit;
}

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");

htmlTop();


if(isset($_REQUEST["we_cmd"][0]) && substr($_REQUEST["we_cmd"][0],0,15) == "doImage_convert"){
	print '<script language="JavaScript" type="text/javascript">parent.frames[0].we_setPath("'.$we_doc->Path.'","' . $we_doc->Text . '");</script>'."\n";
}

?>

	<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR ?>windows.js"></script>

<?php
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_editors/we_editor_script.inc.php");

	print STYLESHEET;

	$we_button = new we_button();
?>
</head>

<body class="weEditorBody">
	<form name="we_form" method="post">
		<?php $we_doc->pHiddenTrans(); ?>
<?php

	switch(strtolower($we_doc->Extension)) {
		case ".pdf":
			$previewAvailable = true;
			break;
		default:
			$previewAvailable = false;
			break;
	}

	if($previewAvailable && $we_doc->ID) {
?>
<iframe name="preview" src="<?php echo $we_doc->Path; ?>" width="100%" height="95%" frameborder="no" border="0"></iframe>
<?php
	} else {
		$parts = array();

		array_push($parts,array("headline"=>$GLOBALS["l_we_class"]["preview"],"html"=>htmlAlertAttentionBox($GLOBALS["l_we_class"]["no_preview_available"], 1),"space"=>120));

		if($we_doc->ID) {
			$link = "<a href='".$preurl.WEBEDITION_DIR."we_cmd.php?we_cmd[0]=".(isset($_REQUEST['we_cmd'][0])?$_REQUEST['we_cmd'][0]:"")."&we_cmd[1]=".(isset($_REQUEST['we_cmd'][1])?$_REQUEST['we_cmd'][1]:"")."&we_cmd[2]=".(isset($_REQUEST['we_cmd'][2])?$_REQUEST['we_cmd'][2]:"")."&we_cmd[3]=download&we_transaction=".$_REQUEST['we_transaction']."'>".$http = $we_doc->getHttpPath()."</a>";
		} else {
			$link = $GLOBALS["l_we_class"]["file_not_saved"];
		}
		array_push($parts,array("headline"=>$GLOBALS["l_we_class"]["download"],"html"=>$link,"space"=>120));

		print we_multiIconBox::getHTML("weOtherDocPrev","100%",$parts,20);

	}
?>

	</form>
</body>

</html>