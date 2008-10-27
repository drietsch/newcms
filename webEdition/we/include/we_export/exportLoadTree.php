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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/"."we_htmlElement.inc.php");
protect();
if(isset($_REQUEST["we_cmd"][5])){
    $_SESSION["prefs"]["FileFilter"] = $_REQUEST["we_cmd"][5];
}

if(isset($_REQUEST["we_cmd"][4])){
	$topFrame=$_REQUEST["we_cmd"][4];
}
else $topFrame = "top"; 

$table = isset($_REQUEST["we_cmd"][1]) ? $_REQUEST["we_cmd"][1] : FILE_TABLE;

if($table==FILE_TABLE && !we_hasPerm("CAN_SEE_DOCUMENTS")){
	if(we_hasPerm("CAN_SEE_TEMPLATES")) $table=TEMPLATES_TABLE;	
	else if(defined('OBJECT_FILES_TABLE') && we_hasPerm("CAN_SEE_OBJECTFILES")) $table=OBJECT_FILES_TABLE;
	else if(defined('OBJECT_TABLE') && we_hasPerm("CAN_SEE_OBJECTS")) $table=OBJECT_TABLE;
}

$parentFolder = isset($_REQUEST["we_cmd"][2]) ? $_REQUEST["we_cmd"][2] : 0;

$GLOBALS["OBJECT_FILES_TREE_COUNT"] = 20;
$counts=array();
$parents=array();
$childs=array();
$parentlist = "";
$childlist = "";
$wsQuery = "";

$parentpaths = array();

if($ws = get_ws($table)) {
	$wsPathArray = id_to_path($ws,$table,$DB_WE,false,true);
	foreach($wsPathArray as $path){
		$wsQuery .= " Path like '$path/%' OR ".getQueryParents($path). " OR ";
		while($path != "/" && $path){
			array_push($parentpaths,$path);
			$path = dirname($path);
		}
	}

}else if(defined("OBJECT_FILES_TABLE") && $table==OBJECT_FILES_TABLE && (!$_SESSION["perms"]["ADMINISTRATOR"])){
	$ac = getAllowedClasses($DB_WE);
	foreach($ac as $cid){
		$path = id_to_path($cid,OBJECT_TABLE);
		$wsQuery .= " Path like '".mysql_real_escape_string($path)."/%' OR Path='".mysql_real_escape_string($path)."' OR ";
	}
}

if($wsQuery){
	$wsQuery = substr($wsQuery,0,strlen($wsQuery)-3);
	$wsQuery = " AND ($wsQuery) ";
}

$openFolders = array();

if(isset($_REQUEST["we_cmd"][3])) {
	$openFolders = explode(",",$_REQUEST["we_cmd"][3]);
}



function getQueryParents($path){

	$out = "";
	while($path != "/" && $path){
		$out .= "Path='$path' OR ";
		$path = dirname($path);
	}
	if($out){
		return substr($out,0,strlen($out)-3);
	}else{
		return "";
	}
}

function getItems($ParentID) {
	global $prefs,$table,$openFolders,$parentpaths,$wsQuery,$treeItems,$Tree,$_isp_hide_files;

	if($table == ""){
		$table = isset($_REQUEST["we_cmd"][1]) ? $_REQUEST["we_cmd"][1] : FILE_TABLE;
	}

	if($table==FILE_TABLE && !we_hasPerm("CAN_SEE_DOCUMENTS"))
	return 0;
	if($table==TEMPLATES_TABLE && !we_hasPerm("CAN_SEE_TEMPLATES"))
	return 0;	
	if(defined('OBJECT_FILES_TABLE') && $table==OBJECT_FILES_TABLE && !we_hasPerm("CAN_SEE_OBJECTFILES"))
	return 0;
	if(defined('OBJECT_TABLE') && $table==OBJECT_TABLE && !we_hasPerm("CAN_SEE_OBJECTS"))
	return 0;

	$DB_WE = new DB_WE;
	$where = " WHERE ";

	$where .= " ParentID=$ParentID ";
	$where .= makeOwnersSql();
	$where .= $wsQuery;
	//if($table==FILE_TABLE) $where .= " AND (ClassName='we_webEditionDocument' OR ClassName='we_folder')";
	$elem = "ID,ParentID,Path,Text,Icon,IsFolder,ModDate".(($table==FILE_TABLE || (defined("OBJECT_FILES_TABLE") && $table==OBJECT_FILES_TABLE)) ? ",Published" : "").((defined("OBJECT_FILES_TABLE") && $table==OBJECT_FILES_TABLE) ? ",IsClassFolder,IsNotEditable" : "");

	//	ISP_VERSION dont show -> files, folders in $_isp_hide_files
	if($table==FILE_TABLE && defined("ISP_VERSION") && ISP_VERSION){
		$where .= ( (is_array($_isp_hide_files) && sizeof($_isp_hide_files) > 0) ? ' AND Path NOT IN (\'' . implode("','", $_isp_hide_files) . '\') ' : '');
	}

	if($table == FILE_TABLE || $table == TEMPLATES_TABLE || (defined("OBJECT_TABLE") && $table==OBJECT_TABLE) || (defined("OBJECT_FILES_TABLE") && $table==OBJECT_FILES_TABLE)){
		$elem .= ",ContentType";
	}

	$DB_WE->query("SELECT $elem, abs(text) as Nr, (text REGEXP '^[0-9]') as isNr from ".mysql_real_escape_string($table)." $where ORDER BY isNr DESC,Nr,Text");

	while($DB_WE->next_record()) {

		$ID = $DB_WE->f("ID");
		$ParentID = $DB_WE->f("ParentID");
		$Text = $DB_WE->f("Text");
		$Path = $DB_WE->f("Path");
		$IsFolder = $DB_WE->f("IsFolder");
		$ContentType = $DB_WE->f("ContentType");
		$Icon = $DB_WE->f("Icon");
		$published = ($table==FILE_TABLE || (defined("OBJECT_FILES_TABLE") && $table==OBJECT_FILES_TABLE)) ? ((($DB_WE->f("Published") != 0) && ($DB_WE->f("Published") < $DB_WE->f("ModDate"))) ? -1 : $DB_WE->f("Published")) : 1;
		$IsClassFolder = $DB_WE->f("IsClassFolder");
		$IsNotEditable = $DB_WE->f("IsNotEditable");

		$checked=0;
		if($table==FILE_TABLE && isset($_SESSION["exportVars"]["selDocs"])){
			if(in_array($ID,makeArrayFromCSV($_SESSION["exportVars"]["selDocs"]))) $checked=1;
		}
		else if(defined("OBJECT_FILES_TABLE") && $table==OBJECT_FILES_TABLE && isset($_SESSION["exportVars"]["selObjs"])){
			if(in_array($ID,makeArrayFromCSV($_SESSION["exportVars"]["selObjs"]))) $checked=1;
		}

		if(in_array($ID,$openFolders)) $OpenCloseStatus=1; else $OpenCloseStatus=0;
		$disabled = in_array($Path,$parentpaths) ? 1 : 0;

		$typ= $IsFolder ? "group" : "item";

		$treeItems[]=array(
										"icon"=>"$Icon",
										"id"=>"$ID",
										"parentid"=>$ParentID,
										"text"=>"$Text",
										"contenttype"=>$ContentType,
										"isclassfolder"=>$IsClassFolder,
										"isnoteditable"=>$IsNotEditable,
										"table"=>$table,
										"checked"=>$checked,
										"typ"=>$typ,
										"open"=>$OpenCloseStatus,
										"published"=>$published,
										"disabled"=>$disabled,
										"tooltip"=>"$ID"
							);

		if($typ=="group" && $OpenCloseStatus==1) getItems($ID);

	}
}

protect();

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_export/"."weExportTree.inc.php");

$Tree = new weExportTree(	"export_frameset.php",
							$topFrame,
							$topFrame.".body",
							$topFrame.".cmd");

$treeItems=array();

getItems($parentFolder,$treeItems);

$js='
	if(!'.$Tree->topFrame.'.treeData) {
		' . we_message_reporting::getShowMessageCall("A fatal error occured", WE_MESSAGE_ERROR) . '
	}';

if(!$parentFolder)
		$js.='
		'.$Tree->topFrame.'.treeData.clear();
		'.$Tree->topFrame.'.treeData.add(new '.$Tree->topFrame.'.rootEntry(\''.$parentFolder.'\',\'root\',\'root\'));
';

$js.=$Tree->getJSLoadTree($treeItems);

$body=we_htmlElement::htmlBody(array("bgcolor"=>"#ffffff"));

$head=WE_DEFAULT_HEAD. "\n".we_htmlElement::jsElement($js);

print we_htmlElement::htmlHtml(
			we_htmlElement::htmlHead($head).
			$body
);

?>