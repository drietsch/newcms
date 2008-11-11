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

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_classes/html/we_htmlSelect.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/cockpit.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_widgets/dlg/prefs.inc.php");
protect();

list($sType, $iDate, $iAmountEntries, $sDisplayOpt, $sUsers) = explode(";", $_REQUEST["we_cmd"][1]);

$parts = array();
$jsCode = "
var _oCsv_;
var _sInitCsv_;
var _sUsers='" . $sUsers . "';
var _sMfdInc='mfd/mfd';
var _oSctDate;
var _oSctNumEntries;
var _bPrev=false;
var _sLastPreviewCsv='';

function init(){
	_fo=document.forms[0];
	_oCsv_=opener.gel(_sObjId+'_csv')
	_sInitCsv_=_oCsv_.value;
	_oSctDate=_fo.elements['sct_date'];
	_oSctNumEntries=_fo.elements['sct_amount_entries'];
	initPrefs();
}

function getBinary(postfix){
	var sBinary='';
	var oChbx=_fo.elements['chbx_'+postfix];
	var iChbxLen=oChbx.length;
	for(var i=0;i<iChbxLen;i++){
		sBinary+=(oChbx[i].checked)?'1':'0';
	}
	return sBinary;
}

function addUserToField(){
	var iNewUsrId=_fo.elements['UserIDTmp'].value;
	var aUsers=_sUsers.split(',');
	var iUsersLen=aUsers.length;
	var bUsrExists=false;
	for(var i=0;i<iUsersLen;i++){
		if(aUsers[i]==iNewUsrId){
			bUsrExists=true;
			break;
		}
	}
	if(!bUsrExists){
		_fo.action='" . WEBEDITION_DIR . "we/include/we_widgets/dlg/mfd.inc.php?we_cmd[0]='+
			_sObjId+'&we_cmd[1]='+getBinary('type')+';'+_oSctDate.selectedIndex+';'+
				_oSctNumEntries.selectedIndex+';'+getBinary('display_opt')+';'+_sUsers+','+iNewUsrId;
		_fo.method='post';
		_fo.submit();
	}
}

function delUser(iUsrId){
	var sUsers='';
	if(iUsrId!=-1){
		var aUsers=_sUsers.split(',');
		var iUsersLen=aUsers.length;
		for(var i=0;i<iUsersLen;i++){
			if(aUsers[i]==iUsrId){
				aUsers.splice(i,1);
				iUsersLen--;
				break;
			}
		}
		for(var i=0;i<iUsersLen;i++){
			sUsers+=aUsers[i];
			if(i!=iUsersLen-1) sUsers+=',';
		}
	}
	_fo.action='" . WEBEDITION_DIR . "we/include/we_widgets/dlg/mfd.inc.php?we_cmd[0]='+
		_sObjId+'&we_cmd[1]='+getBinary('type')+';'+_oSctDate.selectedIndex+';'+_oSctNumEntries.selectedIndex+
			';'+getBinary('display_opt')+';'+sUsers;
	_fo.method='post';
	_fo.submit();
}

function getCsv(){
	return getBinary('type')+';'+_oSctDate.selectedIndex+';'+_oSctNumEntries.selectedIndex+
		';'+getBinary('display_opt')+';'+_sUsers;
}

function refresh(bRender){
	if(bRender)_sLastPreviewCsv=getCsv();
	opener.rpc(getBinary('type'),_oSctDate.selectedIndex,_oSctNumEntries.selectedIndex,
		getBinary('display_opt'),_sUsers,_sObjId,_sMfdInc);
}

function save(){
	if(isNoError()) {
		var sCsv=getCsv();
		_oCsv_.value=sCsv;
		savePrefs();
		if((!_bPrev&&sCsv!=_sInitCsv_)||(_bPrev&&sCsv!=_sLastPreviewCsv)){
			refresh(false);
		}
		" . we_message_reporting::getShowMessageCall(
		$l_cockpit['prefs_saved_successfully'], 
		WE_MESSAGE_NOTICE) . "
		self.close();
	} else {
		" . we_message_reporting::getShowMessageCall(
		$l_cockpit['no_type_selected'], 
		WE_MESSAGE_ERROR) . "
	}
}

function isNoError(){
	chbx_type_checked = false;
	for( var chbx_type_i = 0; chbx_type_i < document.we_form.chbx_type.length; chbx_type_i++) {
		if(document.we_form.chbx_type[chbx_type_i].checked) chbx_type_checked = true;
	}
	return chbx_type_checked;
}
function preview(){
	if(isNoError()) {
		_bPrev=true;
		previewPrefs();
		refresh(true);
	} else {
		" . we_message_reporting::getShowMessageCall(
		$l_cockpit['no_type_selected'], 
		WE_MESSAGE_ERROR) . "
	}
}

function exit_close(){
	if(_bPrev&&_sInitCsv_!=_sLastPreviewCsv){
		var aCsv=_sInitCsv_.split(';');
		opener.rpc(aCsv[0],aCsv[1],aCsv[2],aCsv[3],aCsv[4],_sObjId,_sMfdInc);
	}
	exitPrefs();
	self.close();
}

";

$we_button = new we_button();
$textname = 'UserNameTmp';
$idname = 'UserIDTmp';
$users = makeArrayFromCSV($sUsers);

$delallbut = $we_button->create_button(
		"delete_all", 
		"javascript:delUser(-1)", 
		true, 
		-1, 
		-1, 
		"", 
		"", 
		(count($users)) ? false : true);
$addbut = $we_button->create_button(
		"add", 
		"javascript:opener.getUser('browse_users','top.weEditorFrameController.getActiveDocumentReference()._propsDlg[\\'" . $_REQUEST["we_cmd"][0] . "\\'].document.forms[0].elements[\\'UserIDTmp\\'].value','top.weEditorFrameController.getActiveDocumentReference()._propsDlg[\\'" . $_REQUEST["we_cmd"][0] . "\\'].document.forms[0].elements[\\'UserNameTmp\\'].value','','','opener.top.weEditorFrameController.getActiveDocumentReference()._propsDlg[\\'" . $_REQUEST["we_cmd"][0] . "\\'].addUserToField()','','',1);");

$content = '<table border="0" callpadding="0" cellspacing="0" width="300">';
$content .= '<tr><td>' . getPixel(20, 2) . '</td><td>' . getPixel(254, 2) . '</td><td>' . getPixel(26, 2) . '</td></tr>' . "\n";

if (sizeof($users)) {
	$db = new DB_WE();
	for ($i = 0; $i < sizeof($users); $i++) {
		$foo = getHash("SELECT ID,Path,Icon from " . USER_TABLE . " WHERE ID='" . abs($users[$i]) . "'", $db);
		$content .= '<tr><td><img src="' . ICON_DIR . $foo["Icon"] . '" width="16" height="18"></td><td class="defaultfont">' . $foo["Path"] . '</td>' . '<td>' . $we_button->create_button(
				"image:btn_function_trash", 
				"javascript:delUser('" . $users[$i] . "');") . '</td></tr>' . "\n";
	}
} else {
	$content .= '<tr><td><img src="' . ICON_DIR . "user.gif" . '" width="16" height="18"></td><td class="defaultfont">' . $l_cockpit['all_users'] . '</td><td></td><td></td></tr>' . "\n";
}
$content .= '<tr><td>' . getPixel(20, 2) . '</td><td>' . getPixel(254, 2) . '</td><td>' . getPixel(26, 2) . '</td></tr></table>' . "\n";

$sUsrContent = '<table border="0" cellpadding="0" cellspacing="0" width="300"><tr><td>' . we_htmlElement::htmlDiv(
		array(
			"class" => "multichooser"
		), 
		$content) . we_htmlElement::htmlHidden(array(
	"name" => "UserNameTmp", "value" => ""
)) . we_htmlElement::htmlHidden(array(
	"name" => "UserIDTmp", "value" => ""
)) . '</td></tr><tr><td align="right">' . getPixel(2, 8) . we_htmlElement::htmlBr() . $we_button->create_button_table(
		array(
			$delallbut, $addbut
		)) . '</td></tr></table>';

$oShowUser = htmlFormElementTable($sUsrContent, $l_cockpit['following_users'], "left", "defaultfont");

// Typ block
while (strlen($sType) < 4) {
	$sType .= "0";
}
if ($sType{0} == "0" && $sType{1} == "0" && $sType{2} == "0" && $sType{3} == "0") {
	$sType = "1111";
}
if (we_hasPerm('CAN_SEE_DOCUMENTS')) {
	$oChbxDocs = we_forms::checkbox(
			$value = 0, 
			$checked = $sType{0}, 
			$name = "chbx_type", 
			$text = $l_cockpit['documents'], 
			$uniqid = true, 
			$class = "defaultfont", 
			$onClick = "", 
			$disabled = !(defined('FILE_TABLE') && we_hasPerm("CAN_SEE_DOCUMENTS")), 
			$description = "", 
			$type = 0, 
			$width = 0);
} else {
	$oChbxDocs = "";
}
if (we_hasPerm('CAN_SEE_TEMPLATES') && $_SESSION["we_mode"] != "seem") {
	$oChbxTmpl = we_forms::checkbox(
			$value = 0, 
			$checked = $sType{1}, 
			$name = "chbx_type", 
			$text = $l_cockpit['templates'], 
			$uniqid = true, 
			$class = "defaultfont", 
			$onClick = "", 
			$disabled = !(defined("TEMPLATES_TABLE") && we_hasPerm('CAN_SEE_TEMPLATES')), 
			$description = "", 
			$type = 0, 
			$width = 0);
} else {
	$oChbxTmpl = "";
}
if (we_hasPerm('CAN_SEE_OBJECTS')) {
	$oChbxObjs = we_forms::checkbox(
			$value = 0, 
			$checked = $sType{2}, 
			$name = "chbx_type", 
			$text = $l_cockpit['objects'], 
			$uniqid = true, 
			$class = "defaultfont", 
			$onClick = "", 
			$disabled = !(defined("OBJECT_FILES_TABLE") && we_hasPerm('CAN_SEE_OBJECTFILES')), 
			$description = "", 
			$type = 0, 
			$width = 0);
} else {
	$oChbxObjs = "";
}
if (we_hasPerm('CAN_SEE_CLASSES') && $_SESSION["we_mode"] != "seem") {
	$oChbxCls = we_forms::checkbox(
			$value = 0, 
			$checked = $sType{3}, 
			$name = "chbx_type", 
			$text = $l_cockpit['classes'], 
			$uniqid = true, 
			$class = "defaultfont", 
			$onClick = "", 
			$disabled = !(defined("OBJECT_TABLE") && we_hasPerm('CAN_SEE_OBJECTS')), 
			$description = "", 
			$type = 0, 
			$width = 0);
} else {
	$oChbxCls = "";
}

$oDbTableType = new we_htmlTable(array(
	"border" => "0", "cellpadding" => "0", "cellspacing" => "0"
), 1, 3);
$oDbTableType->setCol(0, 0, null, $oChbxDocs . $oChbxTmpl);
$oDbTableType->setCol(0, 1, null, getPixel(10, 1));
$oDbTableType->setCol(0, 2, null, $oChbxObjs . $oChbxCls);

$oSctDate = new we_htmlSelect(array(
	"name" => "sct_date", "size" => "1", "class" => "defaultfont", "onChange" => ""
));
$aLangDate = array(
	
		$l_cockpit['all'], 
		$l_cockpit['today'], 
		$l_cockpit['last_week'], 
		$l_cockpit['last_month'], 
		$l_cockpit['last_year']
);
foreach ($aLangDate as $k => $v) {
	$oSctDate->insertOption($k, $k, $v);
}
$oSctDate->selectOption($iDate);

$oChbxShowMfdBy = we_forms::checkbox(
		$value = 0, 
		$checked = $sDisplayOpt{0}, 
		$name = "chbx_display_opt", 
		$text = $l_cockpit['modified_by'], 
		$uniqid = true, 
		$class = "defaultfont", 
		$onClick = "", 
		$disabled = false, 
		$description = "", 
		$type = 0, 
		$width = 0);
$oChbxShowDate = we_forms::checkbox(
		$value = 0, 
		$checked = $sDisplayOpt{1}, 
		$name = "chbx_display_opt", 
		$text = $l_cockpit['date_last_modification'], 
		$uniqid = true, 
		$class = "defaultfont", 
		$onClick = "", 
		$disabled = false, 
		$description = "", 
		$type = 0, 
		$width = 0);
$oSctNumEntries = new we_htmlSelect(array(
	"name" => "sct_amount_entries", "size" => "1", "class" => "defaultfont"
));
$oSctNumEntries->insertOption(0, 0, $l_cockpit['all']);
for ($iCurrEntry = 1; $iCurrEntry <= 50; $iCurrEntry++) {
	$oSctNumEntries->insertOption($iCurrEntry, $iCurrEntry, $iCurrEntry);
	if ($iCurrEntry >= 10) {
		$iCurrEntry += ($iCurrEntry == 25) ? 24 : 4;
	}
}
$oSctNumEntries->selectOption($iAmountEntries);

$oSelMaxEntries = new we_htmlTable(array(
	"height" => "100%", "border" => "0", "cellpadding" => "0", "cellspacing" => "0"
), 1, 3);
$oSelMaxEntries->setCol(0, 0, array(
	"valign" => "middle", "class" => "defaultfont"
), $l_cockpit['max_amount_entries']);
$oSelMaxEntries->setCol(0, 1, null, getPixel(5, 1));
$oSelMaxEntries->setCol(0, 2, array(
	"valign" => "middle"
), $oSctNumEntries->getHTMLCode());

$show = $oSelMaxEntries->getHTMLCode() . getPixel(1, 5) . $oChbxShowMfdBy . $oChbxShowDate . getPixel(1, 5) . we_htmlElement::htmlBr() . $oShowUser;

array_push($parts, array(
	"headline" => $l_cockpit['type'], "html" => $oDbTableType->getHTMLCode(), "space" => 80
));
array_push($parts, array(
	"headline" => $l_cockpit['date'], "html" => $oSctDate->getHtmLCode(), "space" => 80
));
array_push($parts, array(
	"headline" => $l_cockpit['display'], "html" => $show, "space" => 80
));
array_push($parts, array(
	"headline" => "", "html" => $oSelCls->getHTMLCode(), "space" => 0
));

$save_button = $we_button->create_button("save", "javascript:save();", false, -1, -1);
$preview_button = $we_button->create_button("preview", "javascript:preview();", false, -1, -1);
$cancel_button = $we_button->create_button("close", "javascript:exit_close();");
$buttons = $we_button->position_yes_no_cancel($save_button, $preview_button, $cancel_button);

$sTblWidget = we_multiIconBox::getHTML(
		"mfdProps", 
		"100%", 
		$parts, 
		30, 
		$buttons, 
		-1, 
		"", 
		"", 
		"", 
		$l_cockpit['last_modified'], 
		"", 
		390);

print 
		we_htmlElement::htmlHtml(
				we_htmlElement::htmlHead(
						we_htmlElement::htmlTitle($l_cockpit['last_modified']) . STYLESHEET . we_htmlElement::cssElement(
								"select{border:#AAAAAA solid 1px}") . we_htmlElement::jsElement(
								"", 
								array(
									"src" => JS_DIR . "we_showMessage.js"
								)) . we_htmlElement::jsElement(
								$jsPrefs . $jsCode . $we_button->create_state_changer(false))) . we_htmlElement::htmlBody(
						array(
							"class" => "weDialogBody", "onload" => "init();"
						), 
						we_htmlElement::htmlForm("", $sTblWidget)));

?>
