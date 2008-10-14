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

$jsCode = "
var _sPlgInc='plg/plg';
var _oCsv_;
var _sInitCsv_;
var _oSctDns;
var _iSctDnsLen;
var _sLastPrev='';
function init(){
	_fo=document.forms[0];
	_oCsv_=opener.gel(_sObjId+'_csv');
	_sInitCsv_=_oCsv_.value;
	_oSctDns=_fo.elements['sct_dns'];
	_iSctDnsLen=_oSctDns.length;
	var aCsv=_sInitCsv_.split(';');
	var sInitBn=aCsv[0];
	var oChbxChart=_fo.elements['chbx_chart'];
	var iChbxChartLen=oChbxChart.length;
	for(var i=iChbxChartLen-1;i>=0;i--){
		oChbxChart[i].checked=(parseInt(sInitBn.charAt(i)))?true:false;
	}
	if(aCsv[1]!=''){
		var sInitDn=opener.base64_decode(aCsv[1]);
		for(var i=_iSctDnsLen-1;i>=0;i--){
			_oSctDns.options[i].selected=(_oSctDns.options[i].text==sInitDn)?true:false;
		}
	}
	initPrefs();
}
function bn(){
	var _bn='';
	var oChbxChart=_fo.elements['chbx_chart'];
	var iChbxChartLen=oChbxChart.length;
	for(var i=0;i<iChbxChartLen;i++){
		_bn+=(oChbxChart[i].checked)?'1':'0';
	}
	return _bn;
}
function dn(){
	return _oSctDns.options[_oSctDns.selectedIndex].text;
}
function dn64(){
	return opener.base64_encode(dn());
}
function cs(){
	return bn()+';'+dn64();
}
function updateView(){
	var _cs=cs();
	if((_sLastPrev!=''&&_sLastPrev!=_cs)||(_sLastPrev==''&&_sInitCsv_!=_cs)){
		_sLastPrev=_cs;
		opener.rpc(_cs,'','','','',_sObjId,_sPlgInc);
	}
}
function resetView(){
	if(_sLastPrev!=''&&_sLastPrev!=_sInitCsv_){
		opener.rpc(_sInitCsv_,'','','','',_sObjId,_sPlgInc);
	}
}
function save(){
	updateView();
	_oCsv_.value=cs();
	savePrefs();
	" . we_message_reporting::getShowMessageCall(
		$l_cockpit['prefs_saved_successfully'], 
		WE_MESSAGE_NOTICE) . "
	self.close();
}
function preview(){
	updateView();
	previewPrefs();
}
function exit_close(){
	resetView();
	exitPrefs();
	self.close();
}";

$_userName = $_SESSION['user']['Username'];
@require ($_SERVER["DOCUMENT_ROOT"] . WE_TRACKER_DIR . "/includes/showme.inc.php");
//$_dns = getDomainList($_userName,$_md5passwd);
//if (defined('WE_TRACKER_DIR')) {
include_once ($_SERVER["DOCUMENT_ROOT"] . WE_TRACKER_DIR . "/includes/global.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . WE_TRACKER_DIR . "/includes/db.inc.php");
$pl_db = new stat_db();
$pl_conn = $pl_db->connect();
$pl_tables = new stat_tables();
$pl_tables->build_tables();
@$result = mysql_query("SELECT websites FROM " . mysql_real_escape_string(preg_replace("/\s/","",$pl_tables->accounttable)). " WHERE account_username = '" . mysql_real_escape_string($_userName) . "'");
$pl_object = mysql_fetch_object($result);
$websites = $pl_object->websites;
$websites = str_replace("\r", "", $websites);
$_dns = explode("\n", $websites);
//} else {


//}


$sctDns = htmlFormElementTable(
		htmlSelect("sct_dns", $_dns, 1, 0, false, 'onChange="" style="width:300px;"', 'value'), 
		$l_cockpit["domain"]);

$chbxChart[0] = we_forms::checkbox(
		$value = 0, 
		$checked = 0, 
		$name = "chbx_chart", 
		$text = $l_cockpit['visitors_data_today'], 
		$uniqid = true, 
		$class = "defaultfont", 
		$onClick = "", 
		$disabled = false, 
		$description = "", 
		$type = 0, 
		$width = 0);
$chbxChart[1] = we_forms::checkbox(
		$value = 0, 
		$checked = 0, 
		$name = "chbx_chart", 
		$text = $l_cockpit['visitors_data_yesterday'], 
		$uniqid = true, 
		$class = "defaultfont", 
		$onClick = "", 
		$disabled = false, 
		$description = "", 
		$type = 0, 
		$width = 0);
$chbxChart[2] = we_forms::checkbox(
		$value = 0, 
		$checked = 0, 
		$name = "chbx_chart", 
		$text = $l_cockpit['visitors_data_this_month'], 
		$uniqid = true, 
		$class = "defaultfont", 
		$onClick = "", 
		$disabled = false, 
		$description = "", 
		$type = 0, 
		$width = 0);
$chbxChart[3] = we_forms::checkbox(
		$value = 0, 
		$checked = 0, 
		$name = "chbx_chart", 
		$text = $l_cockpit['visitors_behaviour_today'], 
		$uniqid = true, 
		$class = "defaultfont", 
		$onClick = "", 
		$disabled = false, 
		$description = "", 
		$type = 0, 
		$width = 0);
$chbxChart[4] = we_forms::checkbox(
		$value = 0, 
		$checked = 0, 
		$name = "chbx_chart", 
		$text = $l_cockpit['Snapshot'], 
		$uniqid = true, 
		$class = "defaultfont", 
		$onClick = "", 
		$disabled = false, 
		$description = "", 
		$type = 0, 
		$width = 0);
$chbxChart[5] = we_forms::checkbox(
		$value = 0, 
		$checked = 0, 
		$name = "chbx_chart", 
		$text = $l_cockpit['top_visiting_periods'], 
		$uniqid = true, 
		$class = "defaultfont", 
		$onClick = "", 
		$disabled = false, 
		$description = "", 
		$type = 0, 
		$width = 0);
$chbxChart[6] = we_forms::checkbox(
		$value = 0, 
		$checked = 0, 
		$name = "chbx_chart", 
		$text = $l_cockpit['visitors_forecast'], 
		$uniqid = true, 
		$class = "defaultfont", 
		$onClick = "", 
		$disabled = false, 
		$description = "", 
		$type = 0, 
		$width = 0);
$chbxChart[7] = we_forms::checkbox(
		$value = 0, 
		$checked = 0, 
		$name = "chbx_chart", 
		$text = $l_cockpit['avg_amount_visitors'], 
		$uniqid = true, 
		$class = "defaultfont", 
		$onClick = "", 
		$disabled = false, 
		$description = "", 
		$type = 0, 
		$width = 0);
$chbxChart[8] = we_forms::checkbox(
		$value = 0, 
		$checked = 0, 
		$name = "chbx_chart", 
		$text = $l_cockpit['promo_value_tai'], 
		$uniqid = true, 
		$class = "defaultfont", 
		$onClick = "", 
		$disabled = false, 
		$description = "", 
		$type = 0, 
		$width = 0);

$chart = new we_htmlTable(array(
	"cellpadding" => "0", "cellspacing" => "0", "border" => "0"
), 13, 1);
$chart->setCol(0, 0, null, $sctDns);
$chart->setCol(1, 0, null, getPixel(1, 8));
$chart->setCol(2, 0, null, $chbxChart[0]);
$chart->setCol(3, 0, null, $chbxChart[1]);
$chart->setCol(4, 0, null, $chbxChart[2]);
$chart->setCol(5, 0, null, $chbxChart[3]);
$chart->setCol(6, 0, null, $chbxChart[4]);
$chart->setCol(7, 0, null, $chbxChart[5]);
$chart->setCol(8, 0, null, $chbxChart[6]);
$chart->setCol(9, 0, null, $chbxChart[7]);
$chart->setCol(10, 0, null, $chbxChart[8]);

$_pLog = $chart->getHTMLCode();

$we_button = new we_button();
$parts = array();
array_push($parts, array(
	"headline" => $l_cockpit['display'], "html" => $_pLog, "space" => 80
));
array_push($parts, array(
	"headline" => "", "html" => $oSelCls->getHTMLCode(), "space" => 0
));

$save_button = $we_button->create_button("save", "javascript:save();", false, -1, -1);
$preview_button = $we_button->create_button("preview", "javascript:preview();", false, -1, -1);
$cancel_button = $we_button->create_button("close", "javascript:exit_close();");
$buttons = $we_button->position_yes_no_cancel($save_button, $preview_button, $cancel_button);
$sMultibox = we_multiIconBox::getJS() . we_multiIconBox::getHTML(
		"plgProps", 
		"100%", 
		$parts, 
		30, 
		$buttons, 
		-1, 
		"", 
		"", 
		"", 
		$l_cockpit['pagelogger']);

$_pLogProps = new we_htmlTable(array(
	"border" => "0", "cellpadding" => "0", "cellspacing" => "0"
), 2, 1);
$_pLogProps->setCol(0, 0, null, $sMultibox);
$_pLogProps->setCol(1, 0, null, getPixel(1, 10));

print 
		we_htmlElement::htmlHtml(
				we_htmlElement::htmlHead(
						we_htmlElement::htmlTitle($l_cockpit['pagelogger']) . STYLESHEET . we_htmlElement::cssElement(
								"select{border:#AAAAAA solid 1px}") . we_htmlElement::jsElement(
								"", 
								array(
									"src" => JS_DIR . "we_showMessage.js"
								)) . we_htmlElement::jsElement($jsPrefs . $jsCode)) . we_htmlElement::htmlBody(
						array(
							"class" => "weDialogBody", "onload" => "init();"
						), 
						we_htmlElement::htmlForm("", $_pLogProps->getHTMLCode())));

?>
