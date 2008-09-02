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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_live_tools.inc.php");
include_once(WE_OBJECT_MODULE_DIR . "we_object.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."we_webEditionDocument.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."we_template.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_editor.inc.php");

protect();

$we_transaction=$_REQUEST["we_cmd"][3];

$nr = $_REQUEST["we_cmd"][2];

$GLOBALS['we_doc'] = new we_template();
$GLOBALS['we_doc']->Table = TEMPLATES_TABLE;
$GLOBALS['we_doc']->we_new();

$filename = "we_" . $_REQUEST["SID"] . "_Filename";
$filename = $_REQUEST[$filename];

$ParentID = "we_" . $_REQUEST["SID"] . "_ParentID";
$ParentID  = $_REQUEST[$ParentID];


$GLOBALS['we_doc']->Filename = $filename;
$GLOBALS['we_doc']->Extension =  ".tmpl";
$GLOBALS['we_doc']->Icon="prog.gif";
$GLOBALS['we_doc']->setParentID($ParentID);
$GLOBALS['we_doc']->Path = $GLOBALS['we_doc']->ParentPath.(($GLOBALS['we_doc']->ParentPath != "/") ? "/" : "").$filename.".tmpl";
$GLOBALS['we_doc']->ContentType = "text/weTmpl";

$GLOBALS['we_doc']->Table = TEMPLATES_TABLE;


//$GLOBALS['we_doc']->ID = 61;

//  $_SESSION["content"] is only used for generating a default template, it is
//  set in WE_OBJECT_MODULE_DIR\we_object_createTemplate.inc.php
$GLOBALS['we_doc']->elements["data"]["dat"] = $_SESSION["content"];
$GLOBALS['we_doc']->elements["data"]["type"] = "txt";
unset($_SESSION["content"]);

if($GLOBALS['we_doc']->i_filenameEmpty()){
	$we_responseText = $l_we_editor[$GLOBALS['we_doc']->ContentType]["filename_empty"];
}else if($GLOBALS['we_doc']->i_sameAsParent()){
	$we_responseText = $l_we_editor["folder_save_nok_parent_same"];
}else if($GLOBALS['we_doc']->i_filenameNotValid()){
	$we_responseText = sprintf($l_we_editor[$GLOBALS['we_doc']->ContentType]["we_filename_notValid"],$GLOBALS['we_doc']->Path);
}else if($GLOBALS['we_doc']->i_filenameNotAllowed()){
	$we_responseText = sprintf($l_we_editor[$GLOBALS['we_doc']->ContentType]["we_filename_notAllowed"],$GLOBALS['we_doc']->Path);
}else if($GLOBALS['we_doc']->i_filenameDouble()){
	$we_responseText = sprintf($l_we_editor[$GLOBALS['we_doc']->ContentType]["response_path_exists"],$GLOBALS['we_doc']->Path);
}
if(isset($we_responseText)){
	echo '<script language="JavaScript" type="text/javascript">' . we_message_reporting::getShowMessageCall($we_responseText, WE_MESSAGE_ERROR) . '</script>
';
	include_once(WE_OBJECT_MODULE_DIR."we_object_createTemplate.inc.php");
}else{
	if($GLOBALS['we_doc']->we_save()){
		$we_responseText = sprintf($l_we_editor[$GLOBALS['we_doc']->ContentType]["response_save_ok"],$GLOBALS['we_doc']->Path);
		echo '<script language="JavaScript" type="text/javascript">
		' . we_message_reporting::getShowMessageCall( $we_responseText, WE_MESSAGE_NOTICE,false,true) . '
opener.we_cmd("changeTempl_ob",'.$nr.','.$GLOBALS['we_doc']->ID.');
self.close();
</script>
';
	}else{
		$we_responseText = sprintf($l_we_editor[$GLOBALS['we_doc']->ContentType]["response_save_notok"],$GLOBALS['we_doc']->Path);
	echo '<script language="JavaScript" type="text/javascript">' . we_message_reporting::getShowMessageCall( $we_responseText, WE_MESSAGE_ERROR) . '</script>
';
		include_once(WE_OBJECT_MODULE_DIR."we_object_createTemplate.inc.php");
	}
}
?>