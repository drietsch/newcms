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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_db_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_forms.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlElement.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlSelect.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/thumbnails.inc.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_message_reporting/we_message_reporting.class.php");

protect();

$uniqid = md5(uniqid(time()));


$we_transaction = $_REQUEST["we_cmd"][1];

// init document
$we_dt = isset($_SESSION["we_data"][$we_transaction]) ? $_SESSION["we_data"][$we_transaction] : "";
include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_editors/we_init_doc.inc.php");


if(isset($we_doc->ClassName) && $we_doc->ClassName == "we_imageDocument"){

	htmlTop();

	print '<script type="text/javascript" src="/webEdition/js/we_showMessage.js"></script>
<script language="JavaScript" type="text/javascript">

document.onkeyup = function(e) {
	var e = (typeof(event) != "undefined") ? event : e;
	if (e.keyCode == 13) {
		doOK();
	} else if(e.keyCode == 27) {
		top.close();
	}
}

'."\nself.focus();\n";

	switch($_REQUEST["we_cmd"][0]){
		case "image_resize":
			print we_getImageResizeDialogJS();
			break;
		case "image_convertJPEG":
			print we_getImageConvertDialogJS();
			break;
		case "image_rotate":
			print we_getImageRotateDialogJS();
			break;
	}

	print "</script>\n";


	print STYLESHEET . "</head>";


	switch($_REQUEST["we_cmd"][0]){
		case "image_resize":
			$_dialog = we_getImageResizeDialog();
			break;
		case "image_convertJPEG":
			$_dialog = we_getImageConvertDialog();
			break;
		case "image_rotate":
			$_dialog = we_getImageRotateDialog();
			break;
		default:
			$_dialog = "";
	}

	$_dialog = we_htmlElement::htmlForm(array("name"=>"we_form"),$_dialog);

	print we_htmlElement::htmlBody(array("class"=>"weDialogBody"), $_dialog) . "</html>";

}else{
	exit("ERROR: Couldn't initialize we_imageDocument object");
}



function we_getImageResizeDialogJS(){
	list($width,$height) = $GLOBALS["we_doc"]->getOrigSize();

	return 'var width = '.$width.';
var height = '.$height.';
var ratio_wh = width / height;
var ratio_hw = height / width;

function IsDigit(e,inp) {
	var key;
	if (navigator.product == \'Gecko\') {
		if(e.metaKey || e.altKey || e.ctrlKey){
			return true;
		}
		key = e.charCode;
	} else {
		key = event.keyCode;
	}

	return (((key >= 48) && (key <= 57)) || isSpecialKey(key) || (key == 46 && (inp.value.indexOf(".") == -1)));
}

function isSpecialKey(key) {
	return (key >= 63232 && key <= 63235) || key == 8 || key == 63272 || key == 0 || key == 13;
}

function we_switchPixelPercent(inp,sel){

	if(sel.options[sel.selectedIndex].value == "pixel"){
		if(inp.name=="width"){
			inp.value = Math.round((width / 100) * inp.value);
		}else{
			inp.value = Math.round((height / 100) * inp.value);
		}
	}else{
		if(inp.name=="width"){
			inp.value = Math.round(100 * (100/width) * inp.value) / 100.0;
		}else{
			inp.value = Math.round(100 * (100/height) * inp.value) / 100.0;
		}
	}

}

function we_keep_ratio(inp,sel){
	var _newVal;
	
	if(inp.value){
		if(sel.options[sel.selectedIndex].value == "pixel"){
			_newVal = Math.round(inp.value);
		}else{
			_newVal = Math.round(100 * inp.value) / 100.0;
		}
		if (_newVal != inp.value) {
			inp.value = _newVal;
		}
	}
	
	if(inp.form.ratio.checked){
		var inp_change = null;
		var sel_change = null;
		var ratio = null;
		var org = null

		if(inp.name=="width"){
			ratio = ratio_hw;
			inp_change = inp.form.height;
			sel_change = inp.form.heightSelect;
			org = width;
		}else{
			ratio = ratio_wh;
			inp_change = inp.form.width;
			sel_change = inp.form.widthSelect;
			org = height;
		}
		if(sel_change.options[sel_change.selectedIndex].value == "pixel"){
			if(sel.options[sel.selectedIndex].value == "pixel"){
				_newVal = Math.round(inp.value * ratio);
			}else{
				_newVal = Math.round((org/100) * inp.value * ratio);
			}
		}else{
			if(sel.options[sel.selectedIndex].value == "percent"){
				_newVal = inp.value;
			}else{
				_newVal = Math.round(100 * (100/org) * inp.value * ratio) / 100.0;
			}
		}
		if (inp_change.value != _newVal) {
			inp_change.value = _newVal;
		}
	}
}

function doOK(){
	var f = document.we_form;
	var qual = 8;

	if (f.width.value == 0 || f.height.value == 0 || f.width.value == "0%" || f.height.value == "0%") {
		' . we_message_reporting::getShowMessageCall($GLOBALS["l_we_class"]["image_edit_null_not_allowed"], WE_MESSAGE_ERROR) . '
		return;
	}
	var newWidth = (f.widthSelect.options[f.widthSelect.selectedIndex].value == "pixel") ? f.width.value : Math.round((width/100) * f.width.value);
	var newHeight = (f.heightSelect.options[f.heightSelect.selectedIndex].value == "pixel") ? f.height.value : Math.round((height/100) * f.height.value);
	'.(($GLOBALS["we_doc"]->getGDType() == "jpg") ? "\nqual = f.quality.options[f.quality.selectedIndex].value;\n" : '').'
	top.opener._EditorFrame.setEditorIsHot(true);
	top.opener.we_cmd("resizeImage",newWidth,newHeight,qual);
	top.close();
}

';
}

function we_getImageConvertDialogJS(){
	return 'function doOK(){
	var f = document.we_form;
	var qual = f.quality.options[f.quality.selectedIndex].value;
	top.opener._EditorFrame.setEditorIsHot(true);
	top.opener.top.we_cmd("doImage_convertJPEG", qual);
	top.close();
}
';
}

function we_getImageRotateDialogJS(){

	$imageSize = $GLOBALS["we_doc"]->getOrigSize();

	return 'function doOK(){
	var f = document.we_form;
	var qual = 8;
	var degrees = 0;
	var w = "'.$imageSize[0].'";
	var h= "'.$imageSize[1].'";


	for(var i=0; i<f.degrees.length;i++){
		if(f.degrees[i].checked){
			degrees = f.degrees[i].value;
			break;
		}
	}
	switch(parseInt(degrees)){
		case 90:
		case 270:
			w = "'.$imageSize[1].'";
			h= "'.$imageSize[0].'";
			break;
	}
	'.(($GLOBALS["we_doc"]->getGDType() == "jpg") ? "\nqual = f.quality.options[f.quality.selectedIndex].value;\n" : '').'
	top.opener._EditorFrame.setEditorIsHot(true);
	top.opener.top.we_cmd("rotateImage", w, h, degrees, qual);
	top.close();
}
';
}

function we_getImageResizeDialog(){
	list($width,$height) = $GLOBALS["we_doc"]->getOrigSize();

	$_content = array();
	$we_button = new we_button();

	$okbut = $we_button->create_button("ok", "javascript:doOK();");
	$cancelbut = $we_button->create_button("cancel", "javascript:top.close();");

	$buttons = $we_button->position_yes_no_cancel($okbut,null,$cancelbut);

	$widthInput = htmlTextInput("width","10",$width,"",'onkeypress="return IsDigit(event,this);" onkeyup="we_keep_ratio(this,this.form.widthSelect);"',"text",60);
	$heightInput = htmlTextInput("height","10",$height,"",'onkeypress="return IsDigit(event,this);" onkeyup="we_keep_ratio(this,this.form.heightSelect);"',"text",60);

	$widthSelect = '<select class="weSelect" size="1" name="widthSelect" onchange="we_switchPixelPercent(this.form.width,this);"><option value="pixel">'.$GLOBALS["l_we_class"]["pixel"].'</option><option value="percent">'.$GLOBALS["l_we_class"]["percent"].'</option></select>';
	$heightSelect = '<select class="weSelect" size="1" name="heightSelect" onchange="we_switchPixelPercent(this.form.height,this);"><option value="pixel">'.$GLOBALS["l_we_class"]["pixel"].'</option><option value="percent">'.$GLOBALS["l_we_class"]["percent"].'</option></select>';

	$ratio_checkbox = we_forms::checkbox("1",true,"ratio",$GLOBALS["l_thumbnails"]["ratio"],false,"defaultfont","if(this.checked){we_keep_ratio(this.form.width,this.form.widthSelect);}");

	$_table = '<table border="0" cellpadding="2" cellspacing="0">
	<tr>
		<td class="defaultfont">'.$GLOBALS["l_we_class"]["width"].':</td>
		<td>'.$widthInput.'</td>
		<td>'.$widthSelect.'</td>
	</tr>
	<tr>
		<td class="defaultfont">'.$GLOBALS["l_we_class"]["height"].':</td>
		<td>'.$heightInput.'</td>
		<td>'.$heightSelect.'</td>
	</tr>
	<tr>
		<td colspan="3">'.$ratio_checkbox.'</td>
	</tr>
</table>' .
	(($GLOBALS["we_doc"]->getGDType() == "jpg") ?
		'<br><div class="defaultfont">'.$GLOBALS["l_we_class"]["quality"].'</div>'.we_qualitySelect("quality") :
		'');
	array_push($_content, array("headline" => "", "html" => $_table, "space" => 0));
	return we_multiIconBox::getHTML("", "100%", $_content,30,$buttons,-1,"","",false,$GLOBALS["l_we_class"]["resize"]);
}

function we_getImageConvertDialog(){
	$_content = array();
	$we_button = new we_button();

	$okbut = $we_button->create_button("ok", "javascript:doOK();");
	$cancelbut = $we_button->create_button("cancel", "javascript:top.close();");
	$buttons = $we_button->position_yes_no_cancel($okbut,null,$cancelbut);
	$cancelbut = $we_button->create_button("cancel", "javascript:top.close();");
	$_dialog = '<div class="defaultfont">'.$GLOBALS["l_we_class"]["quality"].'</div>'.we_qualitySelect("quality");
	array_push($_content, array("headline" => "", "html" => $_dialog, "space" => 0));


	return we_multiIconBox::getHTML("", "100%", $_content,30,$buttons,-1,"","",false,$GLOBALS["l_we_class"]["convert"]);
}

function we_getImageRotateDialog(){

	$_content = array();
	$we_button = new we_button();

	$okbut = $we_button->create_button("ok", "javascript:doOK();");
	$cancelbut = $we_button->create_button("cancel", "javascript:top.close();");

	$buttons = $we_button->position_yes_no_cancel($okbut,null,$cancelbut);

	$_radio180 = we_forms::radiobutton("180",true,"degrees",$GLOBALS["l_we_class"]["rotate180"]);
	$_radio90l = we_forms::radiobutton("90",false,"degrees",$GLOBALS["l_we_class"]["rotate90l"]);
	$_radio90r = we_forms::radiobutton("270",false,"degrees",$GLOBALS["l_we_class"]["rotate90r"]);

	$_dialog = $_radio180.$_radio90l.$_radio90r.

	(($GLOBALS["we_doc"]->getGDType() == "jpg") ?
		'<br><div class="defaultfont">'.$GLOBALS["l_we_class"]["quality"].'</div>'.we_qualitySelect("quality") :
		'');

	array_push($_content, array("headline" => "", "html" => $_dialog, "space" => 0));


	return we_multiIconBox::getHTML("", "100%", $_content,30,$buttons,-1,"","",false,$GLOBALS["l_we_class"]["rotate"]);

}


?>