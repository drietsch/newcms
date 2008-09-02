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

$we_transaction = $_REQUEST["we_cmd"][1] ? $_REQUEST["we_cmd"][1] : $we_transaction;

// init document
$we_dt = $_SESSION["we_data"][$we_transaction];
include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_editors/we_init_doc.inc.php");
include( WE_OBJECT_MODULE_DIR . "we_objectFile.inc.php");

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");

protect();

switch($_REQUEST["we_cmd"][0]) {
	case "toggleExtraWorkspace":
		$oid = $_REQUEST["we_cmd"][2];
		$wsid = $_REQUEST["we_cmd"][3];
		$wsPath = id_to_path($wsid,FILE_TABLE,$DB_WE);
		$tableID = $_REQUEST["we_cmd"][4];
		$ofID = f("SELECT ID FROM ".OBJECT_FILES_TABLE." WHERE ObjectID='$oid' AND TableID='$tableID'","ID",$DB_WE);
		$foo = f("SELECT OF_ExtraWorkspacesSelected FROM ".OBJECT_X_TABLE . $tableID . " WHERE ID='".$oid."'","OF_ExtraWorkspacesSelected",$DB_WE);
		if(strstr($foo,",".$wsid.",")) {
			$ews = str_replace(",".$wsid,",","",$foo);
			if($ews == ",")
				$ews = "";
			$check = 0;
		}
		else{
			$ews = ($foo ? $foo : ",").$wsid.",";
			$check = 1;
		}
		$DB_WE->query("UPDATE " . OBJECT_X_TABLE .$tableID." SET OF_ExtraWorkspacesSelected='".$ews."' WHERE ID='".$oid."'");
		$DB_WE->query("UPDATE " .OBJECT_FILES_TABLE. " SET ExtraWorkspacesSelected='".$ews."' WHERE ID='".$ofID."'");
		$of = new we_objectFile();
		$of->initByID($ofID,OBJECT_FILES_TABLE);
		$of->insertAtIndex();
		print '
			<script language="JavaScript" type="text/javascript"><!--
				top.we_cmd("reload_editpage");
			//-->
			</script>';
		break;
	case "obj_search":
		$we_doc->Search = $_REQUEST["we_cmd"][2];
		$we_doc->SearchField = $_REQUEST["we_cmd"][3];
		$we_doc->EditPageNr = WE_EDITPAGE_WORKSPACE;
		$_SESSION["EditPageNr"] = WE_EDITPAGE_WORKSPACE;
		$we_doc->saveInSession($_SESSION["we_data"][$we_transaction]);
		print '
			<script language="JavaScript" type="text/javascript"><!--
				top.we_cmd("switch_edit_page",'.WE_EDITPAGE_WORKSPACE.',"'.$_REQUEST["we_cmd"][1].'");
			//-->
			</script>';
		break;
}

?>