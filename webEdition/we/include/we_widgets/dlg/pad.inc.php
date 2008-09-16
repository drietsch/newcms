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

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_classes/html/we_htmlSelect.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/cockpit.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_widgets/dlg/prefs.inc.php");

$jsCode = "
var _oCsv_;
var _sInitCsv_;
var _sInitTitle;
var _sInitBin;
var _sPadInc='pad/pad';
var _oSctDate;
var _aRdo=['sort','display','date','prio'];
var _lastPreviewCsv='';

function init(){
	_fo=document.forms[0];
	_oCsv_=opener.gel(_sObjId+'_csv');
	_sInitCsv_=_oCsv_.value;
	var aCsv=_sInitCsv_.split(',');
	_sInitTitle=opener.base64_decode(aCsv[0]);
	_sInitBin=aCsv[1];
	for(var i=0;i<_aRdo.length;i++){
		_fo.elements['rdo_'+_aRdo[i]][_sInitBin.charAt(i)].checked=true;
	}
	_fo.elements['sct_valid'].options[_sInitBin.charAt(4)].selected=true;
	var oSctTitle=_fo.elements['sct_title'];
	for(var i=oSctTitle.length-1;i>=0;i--){
		oSctTitle.options[i].selected=(oSctTitle.options[i].text==_sInitTitle)?true:false;
	}
	initPrefs();
}

function getRdoChecked(sType){
	var oRdo=_fo.elements['rdo_'+sType];
	var iRdoLen=oRdo.length;
	for(var i=0;iRdoLen>i;i++){
		if(oRdo[i].checked==true) return i;
	}
}

function getBitString(){
	var sBit='';
	for(var i=0;i<_aRdo.length;i++){
		var iCurr=getRdoChecked(_aRdo[i]);
		sBit+=(typeof iCurr!='undefined')?iCurr:'0';
	}
	sBit+=_fo.elements['sct_valid'].selectedIndex;
	return sBit;
}

function getTitle(){
	var oSctTitle=_fo.elements['sct_title'];
	return oSctTitle[oSctTitle.selectedIndex].value;
}

function save(){
	var oCsv_=opener.gel(_sObjId+'_csv');
	var sTitleEnc=opener.base64_encode(getTitle());
	var sBit=getBitString();
	oCsv_.value=sTitleEnc.concat(','+sBit);
	if((_lastPreviewCsv!=''&&sTitleEnc.concat(','+sBit)!=_lastPreviewCsv)||
		(_lastPreviewCsv==''&&(_sInitTitle!=getTitle()||_sInitBin!=getBitString()))){
		var sTitleEsc=escape(sTitleEnc);
		opener.rpc(sTitleEsc.concat(','+sBit),'','','',sTitleEsc,_sObjId,_sPadInc);
	}
	opener.setPrefs(_sObjId,sBit,sTitleEnc);
	opener.saveSettings();
	savePrefs();
	" . we_message_reporting::getShowMessageCall(
		$l_cockpit['prefs_saved_successfully'], 
		WE_MESSAGE_NOTICE) . "
	opener.top.weNavigationHistory.navigateReload();
	self.close();
}

function preview(){
	var sTitleEnc=opener.base64_encode(getTitle());
	var sTitleEsc=escape(sTitleEnc);
	var sBit=getBitString();
	opener.rpc(sTitleEsc.concat(','+sBit),'','','',sTitleEsc,_sObjId,_sPadInc);
	previewPrefs();
	_lastPreviewCsv=sTitleEnc.concat(','+sBit);
}

function exit_close(){
	if(_lastPreviewCsv!=''&&(_sInitTitle!=getTitle()||_sInitBin!=getBitString())){
		opener.rpc(_sInitCsv_,'','','',escape(opener.base64_encode(_sInitTitle)),_sObjId,_sPadInc);
	}
	exitPrefs();
	self.close();
}
";

$we_button = new we_button();
$parts = array();

$oRdoSort[0] = we_forms::radiobutton(
		$value = 0, 
		$checked = 0, 
		$name = "rdo_sort", 
		$text = $l_cockpit['by_pubdate'], 
		$uniqid = true, 
		$class = "defaultfont", 
		$onClick = "", 
		$disabled = false, 
		$description = "", 
		$type = 0, 
		$onMouseUp = "");
$oRdoSort[1] = we_forms::radiobutton(
		$value = 1, 
		$checked = 0, 
		$name = "rdo_sort", 
		$text = $l_cockpit['by_valid_from'], 
		$uniqid = true, 
		$class = "defaultfont", 
		$onClick = "", 
		$disabled = false, 
		$description = "", 
		$type = 0, 
		$onMouseUp = "");
$oRdoSort[2] = we_forms::radiobutton(
		$value = 2, 
		$checked = 0, 
		$name = "rdo_sort", 
		$text = $l_cockpit['by_valid_until'], 
		$uniqid = true, 
		$class = "defaultfont", 
		$onClick = "", 
		$disabled = false, 
		$description = "", 
		$type = 0, 
		$onMouseUp = "");
$oRdoSort[3] = we_forms::radiobutton(
		$value = 3, 
		$checked = 0, 
		$name = "rdo_sort", 
		$text = $l_cockpit['by_priority'], 
		$uniqid = true, 
		$class = "defaultfont", 
		$onClick = "", 
		$disabled = false, 
		$description = "", 
		$type = 0, 
		$onMouseUp = "");
$oRdoSort[4] = we_forms::radiobutton(
		$value = 4, 
		$checked = 1, 
		$name = "rdo_sort", 
		$text = $l_cockpit['alphabetic'], 
		$uniqid = true, 
		$class = "defaultfont", 
		$onClick = "", 
		$disabled = false, 
		$description = "", 
		$type = 0, 
		$onMouseUp = "");

$sort = new we_htmlTable(array(
	"cellpadding" => "0", "cellspacing" => "0", "border" => "0"
), 3, 3);
$sort->setCol(0, 0, array(
	"width" => 145
), $oRdoSort[0]);
$sort->setCol(0, 1, null, getPixel(10, 1));
$sort->setCol(0, 2, array(
	"width" => 145
), $oRdoSort[3]);
$sort->setCol(1, 0, null, $oRdoSort[1]);
$sort->setCol(1, 2, null, $oRdoSort[4]);
$sort->setCol(2, 0, null, $oRdoSort[2]);

array_push($parts, array(
	"headline" => $l_cockpit['sorting'], "html" => $sort->getHTMLCode(), "space" => 100
));

$oRdoDisplay[0] = we_forms::radiobutton(
		$value = 0, 
		$checked = 1, 
		$name = "rdo_display", 
		$text = $l_cockpit['all_notes'], 
		$uniqid = true, 
		$class = "defaultfont", 
		$onClick = "", 
		$disabled = false, 
		$description = "", 
		$type = 0, 
		$onMouseUp = "");
$oRdoDisplay[1] = we_forms::radiobutton(
		$value = 1, 
		$checked = 0, 
		$name = "rdo_display", 
		$text = $l_cockpit['only_valid'], 
		$uniqid = true, 
		$class = "defaultfont", 
		$onClick = "", 
		$disabled = false, 
		$description = "", 
		$type = 0, 
		$onMouseUp = "");

$display = new we_htmlTable(array(
	"cellpadding" => "0", "cellspacing" => "0", "border" => "0"
), 1, 3);
$display->setCol(0, 0, array(
	"width" => 145
), $oRdoDisplay[0]);
$display->setCol(0, 1, null, getPixel(10, 1));
$display->setCol(0, 2, array(
	"width" => 145
), $oRdoDisplay[1]);

array_push($parts, array(
	"headline" => $l_cockpit['display'], "html" => $display->getHTMLCode(), "space" => 100
));

$oRdoDate[0] = we_forms::radiobutton(
		$value = 0, 
		$checked = 1, 
		$name = "rdo_date", 
		$text = $l_cockpit['by_pubdate'], 
		$uniqid = true, 
		$class = "defaultfont", 
		$onClick = "", 
		$disabled = false, 
		$description = "", 
		$type = 0, 
		$onMouseUp = "");
$oRdoDate[1] = we_forms::radiobutton(
		$value = 1, 
		$checked = 0, 
		$name = "rdo_date", 
		$text = $l_cockpit['by_valid_from'], 
		$uniqid = true, 
		$class = "defaultfont", 
		$onClick = "", 
		$disabled = false, 
		$description = "", 
		$type = 0, 
		$onMouseUp = "");
$oRdoDate[2] = we_forms::radiobutton(
		$value = 2, 
		$checked = 0, 
		$name = "rdo_date", 
		$text = $l_cockpit['by_valid_until'], 
		$uniqid = true, 
		$class = "defaultfont", 
		$onClick = "", 
		$disabled = false, 
		$description = "", 
		$type = 0, 
		$onMouseUp = "");

$date = new we_htmlTable(array(
	"cellpadding" => "0", "cellspacing" => "0", "border" => "0"
), 3, 1);
$date->setCol(0, 0, array(
	"width" => 145
), $oRdoDate[0]);
$date->setCol(1, 0, null, $oRdoDate[1]);
$date->setCol(2, 0, null, $oRdoDate[2]);

array_push($parts, array(
	"headline" => $l_cockpit['display_date'], "html" => $date->getHTMLCode(), "space" => 100
));

$oRdoPrio[0] = we_forms::radiobutton(
		$value = 0, 
		$checked = 0, 
		$name = "rdo_prio", 
		$text = $l_cockpit['high'], 
		$uniqid = true, 
		$class = "defaultfont", 
		$onClick = "", 
		$disabled = false, 
		$description = "", 
		$type = 0, 
		$onMouseUp = "");
$oRdoPrio[1] = we_forms::radiobutton(
		$value = 1, 
		$checked = 0, 
		$name = "rdo_prio", 
		$text = $l_cockpit['medium'], 
		$uniqid = true, 
		$class = "defaultfont", 
		$onClick = "", 
		$disabled = false, 
		$description = "", 
		$type = 0, 
		$onMouseUp = "");
$oRdoPrio[2] = we_forms::radiobutton(
		$value = 2, 
		$checked = 1, 
		$name = "rdo_prio", 
		$text = $l_cockpit['low'], 
		$uniqid = true, 
		$class = "defaultfont", 
		$onClick = "", 
		$disabled = false, 
		$description = "", 
		$type = 0, 
		$onMouseUp = "");

$prio = new we_htmlTable(array(
	"cellpadding" => "0", "cellspacing" => "0", "border" => "0"
), 3, 3);
$prio->setCol(0, 0, array(
	"width" => 70
), $oRdoPrio[0]);
$prio->setCol(0, 1, null, getPixel(10, 1));

$prio->setCol(0, 2, array(
	"width" => 20
), we_htmlElement::htmlImg(array(
	"src" => IMAGE_DIR . "pd/prio_high.gif", "width" => 13, "height" => 14
)));
$prio->setCol(1, 0, null, $oRdoPrio[1]);
$prio->setCol(1, 2, null, we_htmlElement::htmlImg(array(
	"src" => IMAGE_DIR . "pd/prio_medium.gif", "width" => 13, "height" => 14
)));
$prio->setCol(2, 0, null, $oRdoPrio[2]);
$prio->setCol(2, 2, null, we_htmlElement::htmlImg(array(
	"src" => IMAGE_DIR . "pd/prio_low.gif", "width" => 13, "height" => 14
)));

array_push($parts, array(
	"headline" => $l_cockpit['default_priority'], "html" => $prio->getHTMLCode(), "space" => 100
));

$oSctValid = htmlSelect("sct_valid", array(
	$l_cockpit['always'], $l_cockpit['from_date'], $l_cockpit['period']
), 1, $l_cockpit['always'], false, 'style="width:120px;" onChange=""', 'value', 120);

array_push($parts, array(
	"headline" => $l_cockpit['default_validity'], "html" => $oSctValid, "space" => 100
));

list($pad_header_enc, ) = explode(',', $_REQUEST["we_cmd"][1]);
$pad_header = base64_decode($pad_header_enc);
$_sql = "SELECT	distinct(WidgetName) FROM " . NOTEPAD_TABLE . " WHERE UserID = " . $_SESSION['user']['ID'];
$DB_WE = new DB_WE();
$DB_WE->query($_sql);
$_options = array(
	$pad_header => $pad_header, $l_cockpit['change'] => $l_cockpit['change']
);
while ($DB_WE->next_record()) {
	$_options[$DB_WE->f('WidgetName')] = $DB_WE->f('WidgetName');
}
$oSctTitle = htmlSelect("sct_title", array_unique($_options), 1, "", false, 'id="title" onChange=""', 'value');
array_push($parts, array(
	"headline" => $l_cockpit['title'], "html" => $oSctTitle, "space" => 100
));
array_push($parts, array(
	"headline" => $l_cockpit['bg_color'], "html" => $oSctCls->getHTMLCode(), "space" => 100
));

$save_button = $we_button->create_button("save", "javascript:save();", false, -1, -1);
$preview_button = $we_button->create_button("preview", "javascript:preview();", false, -1, -1);
$cancel_button = $we_button->create_button("close", "javascript:exit_close();");
$buttons = $we_button->position_yes_no_cancel($save_button, $preview_button, $cancel_button);

print 
		we_htmlElement::htmlHtml(
				we_htmlElement::htmlHead(
						we_htmlElement::htmlTitle($l_cockpit['notepad']) . STYLESHEET . we_htmlElement::cssElement(
								"select{border:#AAAAAA solid 1px}") . we_htmlElement::jsElement(
								"", 
								array(
									"src" => JS_DIR . "we_showMessage.js"
								)) . we_htmlElement::jsElement("", array(
							"src" => JS_DIR . "weCombobox.js"
						)) . we_htmlElement::jsElement($jsPrefs . $jsCode)) . we_htmlElement::htmlBody(
						array(
							"class" => "weDialogBody", "onload" => "init();"
						), 
						we_htmlElement::htmlForm(
								array(
									"onsubmit" => "return false;"
								), 
								we_multiIconBox::getHTML(
										"padProps", 
										"100%", 
										$parts, 
										30, 
										$buttons, 
										-1, 
										"", 
										"", 
										"", 
										$l_cockpit['notepad']))) . we_htmlElement::jsElement(
						"ComboBox=new weCombobox();ComboBox.init('title');"));

?>
