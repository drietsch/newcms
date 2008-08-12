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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/cockpit.inc.php");

$aCols = explode(";",isset($aProps)? $aProps[3] : $_REQUEST["we_cmd"][0]);
$_disableNew = true;
$_cmdNew = "javascript:top.we_cmd('new','" . FILE_TABLE . "','','text/webedition');";
if (we_hasPerm("NEW_WEBEDITIONSITE")) {
	if (we_hasPerm("NO_DOCTYPE")) {
		$_disableNew = false;
	} else {
		$q = "ORDER BY DocType";
		$paths=array();
		$ws = get_ws(FILE_TABLE);
		if ($ws) {
			$b = makeArrayFromCSV($ws);
			foreach ($b as $k=>$v) {
				$DB_WE->query("SELECT ID,Path FROM " . FILE_TABLE . " WHERE ID='".$v."'");
				while ($DB_WE->next_record()) array_push($paths,"(ParentPath = '".$DB_WE->f("Path")."' || ParentPath like '".$DB_WE->f("Path")."/%')");
			}
		}
		if (is_array($paths) && count($paths)>0) {
			$q = "WHERE (".implode(" OR ",$paths).") OR ParentPath='' ORDER BY DocType";
		}
		$DB_WE->query("SELECT ID,DocType FROM " . DOC_TYPES_TABLE . " $q");
		if ($DB_WE->next_record()) {
			$_disableNew = false;
			$_cmdNew = "javascript:top.we_cmd('new','".FILE_TABLE."','','text/webedition','".$DB_WE->f("ID")."')";
		} else {
			$_disableNew = true;
		}
	}
} else {
	$_disableNew = true;
}

$_disableObjects = false;
if (defined("OBJECT_TABLE")) {
	$allClasses = getAllowedClasses();
	if (sizeof($allClasses) == 0) {
		$_disableObjects = true;
	}
}

$js = array();

if (defined('FILE_TABLE') && we_hasPerm("CAN_SEE_DOCUMENTS")) {
	$js["open_document"] = "top.we_cmd('open_document');";
}
if (defined('FILE_TABLE') && we_hasPerm("CAN_SEE_DOCUMENTS") && !$_disableNew) {
	$js["new_document"] = $_cmdNew;
}
if (defined('TEMPLATES_TABLE') && we_hasPerm("NEW_TEMPLATE") && $_SESSION["we_mode"] == "normal") {
	$js["new_template"] = "top.we_cmd('new','" . TEMPLATES_TABLE . "','','text/weTmpl');";
}
if (we_hasPerm("NEW_DOC_FOLDER")) {
	$js["new_directory"] = "top.we_cmd('new','" . FILE_TABLE . "','','folder')";
}
if (defined('FILE_TABLE') && we_hasPerm("CAN_SEE_DOCUMENTS")) {
	$js["unpublished_pages"] = "top.we_cmd('openUnpublishedPages');";
}
if (defined('OBJECT_FILES_TABLE') && we_hasPerm("CAN_SEE_OBJECTFILES") && !$_disableObjects) {
	$js["unpublished_objects"] = "top.we_cmd('openUnpublishedObjects');";
}
if (defined('OBJECT_FILES_TABLE') && we_hasPerm("NEW_OBJECTFILE") && !$_disableObjects) {
	$js["new_object"] = "top.we_cmd('new_objectFile');";
}
if (defined('OBJECT_TABLE') && we_hasPerm("NEW_OBJECT") && $_SESSION["we_mode"] == "normal") {
	$js["new_class"] = "top.we_cmd('new_object');";
}
if (we_hasPerm("EDIT_SETTINGS")) {
	$js["preferences"] = "top.we_cmd('openPreferences');";
}

$shortcuts = array();
foreach ($aCols as $sCol) {
	$shortcuts[] = explode(",",$sCol);
}

$sSctOut = '';
$_col = 0;

foreach ($shortcuts as $sctCol) {
	$sSctOut .= '<div class="sct_row" style="display: block; width: 100%; float: left;"><table border="0" cellpadding="0" cellspacing="0" width="100%">';
	$iCurrSctRow = 0;
	foreach ($sctCol as $_label) {
		if (isset($js[$_label])) {
			$sSctOut .= '<tr><td width="34" height="34">'.we_htmlElement::htmlA(array("href"=>"javascript:".$js[$_label]),
				we_htmlElement::htmlImg(array("src"=>IMAGE_DIR.'pd/sct/'.$_label.'.gif',"width"=>34,"height"=>34,"border"=>0))).'</td>';
			$sSctOut .= '<td width="5">'.getpixel(5,1).'</td>';
			$sSctOut .= '<td valign="middle">'.
				we_htmlElement::htmlA(array("href"=>"javascript:".$js[$_label],"class"=>"middlefont","style"=>"font-weight:bold;text-decoration:none;"),
					$l_button[$_label]["value"]).'</td></tr>';
			$sSctOut .= '<tr><td height="3">'.getpixel(1,3).'</td></tr>';
		}
		$iCurrSctRow++;
	}
	$sSctOut .= '</table></div>';
	$_col++;
}

$sc = new we_htmlTable(array("width"=>"100%","border"=>"0","cellpadding" =>"0","cellspacing"=>"0"),1,1);
$sc->setCol(0,0,array("align"=>"center", "valign" =>"top"), $sSctOut);

if (!isset($aProps)) {
	protect();
	
	$sJsCode = "
	var _sObjId='".$_REQUEST["we_cmd"][5]."';
	var _sType='sct';
	var _sTb='".$l_cockpit['shortcuts']."';
	function init(){
		parent.rpcHandleResponse(_sType,_sObjId,document.getElementById(_sType),_sTb);
	}
	";
	
	print we_htmlElement::htmlHtml(
		we_htmlElement::htmlHead(
			we_htmlElement::htmlTitle($l_cockpit['shortcuts']).
			STYLESHEET.
			we_htmlElement::jsElement($sJsCode)
		).
		we_htmlElement::htmlBody(array(
			"marginwidth" => "15",
			"marginheight" => "10",
			"leftmargin" => "15",
			"topmargin" => "10",
			"onload" => "if(parent!=self)init();"
			),we_htmlElement::htmlDiv(array("id"=>"sct"),$sc->getHtmlCode())
		)
	);
}

?>