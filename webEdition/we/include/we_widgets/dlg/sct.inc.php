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
include_once ($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/cockpit.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_widgets/dlg/prefs.inc.php");

$_disableNew = true;
$_cmdNew = "javascript:top.we_cmd('new','" . FILE_TABLE . "','','text/webedition');";
if (we_hasPerm("NEW_WEBEDITIONSITE")) {
	if (we_hasPerm("NO_DOCTYPE")) {
		$_disableNew = false;
	} else {
		$q = "ORDER BY DocType";
		$paths = array();
		$ws = get_ws(FILE_TABLE);
		if ($ws) {
			$b = makeArrayFromCSV($ws);
			foreach ($b as $k => $v) {
				$DB_WE->query("SELECT ID,Path FROM " . FILE_TABLE . " WHERE ID='" . $v . "'");
				while ($DB_WE->next_record())
					array_push(
							$paths, 
							"(ParentPath = '" . $DB_WE->f("Path") . "' || ParentPath like '" . $DB_WE->f("Path") . "/%')");
			}
		}
		if (is_array($paths) && count($paths) > 0) {
			$q = "WHERE (" . implode(" OR ", $paths) . ") OR ParentPath='' ORDER BY DocType";
		}
		$DB_WE->query("SELECT ID,DocType FROM " . DOC_TYPES_TABLE . " $q");
		if ($DB_WE->next_record()) {
			$_disableNew = false;
			$_cmdNew = "javascript:top.we_cmd('new','" . FILE_TABLE . "','','text/webedition','" . $DB_WE->f("ID") . "')";
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

if (defined('FILE_TABLE') && we_hasPerm('CAN_SEE_DOCUMENTS')) {
	$shortcuts[0]['open_document'] = $l_button['open_document']['value'];
}
if (defined('FILE_TABLE') && we_hasPerm('CAN_SEE_DOCUMENTS') && !$_disableNew) {
	$shortcuts[0]['new_document'] = $l_button['new_document']['value'];
}
if (defined('TEMPLATES_TABLE') && we_hasPerm('NEW_TEMPLATE')) {
	$shortcuts[0]['new_template'] = $l_button['new_template']['value'];
}
if (we_hasPerm('NEW_DOC_FOLDER')) {
	$shortcuts[0]['new_directory'] = $l_button['new_directory']['value'];
}
if (defined('FILE_TABLE') && we_hasPerm('CAN_SEE_DOCUMENTS')) {
	$shortcuts[0]['unpublished_pages'] = $l_button['unpublished_pages']['value'];
}
if (defined('OBJECT_FILES_TABLE') && we_hasPerm('CAN_SEE_OBJECTFILES') && !$_disableObjects) {
	$shortcuts[1]['unpublished_objects'] = $l_button['unpublished_objects']['value'];
}
if (defined('OBJECT_FILES_TABLE') && we_hasPerm('NEW_OBJECTFILE') && !$_disableObjects) {
	$shortcuts[1]['new_object'] = $l_button['new_object']['value'];
}
if (defined('OBJECT_TABLE') && we_hasPerm('NEW_OBJECT')) {
	$shortcuts[1]['new_class'] = $l_button['new_class']['value'];
}
if (we_hasPerm("EDIT_SETTINGS")) {
	$shortcuts[1]['preferences'] = $l_button['preferences']['value'];
}

$jsLang = "";
foreach ($shortcuts as $aLang) {
	foreach ($aLang as $k => $v) {
		$jsLang .= "_aLang['" . $k . "']='" . $v . "';\n";
	}
}

$parts = array();
$jsCode = "
var _sSctInc='sct/sct';
var _sCsvInit_;
var _bPrev=false;
_aLang=new Object();\n" . $jsLang . "
function init(){
	_fo=document.forms[0];
	_sCsvInit_=opener.gel(_sObjId+'_csv').value;
	var aCsv=_sCsvInit_.split(';');
	for(var i=0;i<aCsv.length;i++){
		var aVals=aCsv[i].split(',');
		var iOpt=0;
		while(iOpt<aVals.length){
			if(typeof(_aLang[aVals[iOpt]])!='undefined'){
				deleteEntry(aVals[iOpt]);
				addOption(_fo['list'+(i+1)+'1'],_aLang[aVals[iOpt]],aVals[iOpt],false);
			}
			iOpt++;
		}
	}
	initPrefs();
}

function addEntry(sText,sValue){
	var oSctPool=_fo.elements['sct_pool'];
	oSctPool.options[0].text='';
	oSctPool.options[oSctPool.options.length]=new Option(sText,sValue,false,false);
}

function deleteEntry(sValue){
	var oSctPool=_fo.elements['sct_pool'];
	for(var i=1;i<oSctPool.length;i++){
		if(oSctPool.options[i].value==sValue){
			oSctPool.options[i]=null;
			if(oSctPool.length==1){
				oSctPool.options[0].text='" . $l_cockpit['all_selected'] . "';
			}
			oSctPool.selectedIndex=0;
			break;
		}
	}
}

function addBtn(obj,text,value,selected){
	if(obj!=null&&obj.options!=null){
		obj.options[obj.options.length]=new Option(text,value,false,selected);
		deleteEntry(value);
	}
}

function hasOptions(obj){
	if(obj!=null&&obj.options!=null){ return true; }
	return false;
}

function selectUnselectMatchingOptions(obj,regex,which,only){
	if(window.RegExp){
		if(which=='select'){
			var bSel1=true;
			var bSel2=false;
		}else if(which=='unselect'){
			var bSel1=false;
			var bSel2=true;
		}else{
			return;
		}
		var re=new RegExp(regex);
		if(!hasOptions(obj)){ return; }
		for(var i=0;i<obj.options.length;i++){
			if(re.test(obj.options[i].text)){
				obj.options[i].selected=bSel1;
			}else{
				if(only==true){
					obj.options[i].selected=bSel2;
				}
			}
		}
	}
}

function selectMatchingOptions(obj,regex){
	selectUnselectMatchingOptions(obj,regex,'select',false);
}

function selectOnlyMatchingOptions(obj,regex){
	selectUnselectMatchingOptions(obj,regex,'select',true);
}

function unSelectMatchingOptions(obj,regex){
	selectUnselectMatchingOptions(obj,regex,'unselect',false);
}

function sortSelect(obj){
	var o=new Array();
	if(!hasOptions(obj)){ return; }
	for(var i=0;i<obj.options.length;i++){
		o[o.length]=new Option(obj.options[i].text,obj.options[i].value,obj.options[i].defaultSelected,obj.options[i].selected);
	}
	if(o.length==0){ return; }
	o=o.sort( 
		function(a,b){ 
			if((a.text+'')<(b.text+'')){ return -1; }
			if((a.text+'')>(b.text+'')){ return 1; }
			return 0;
		}
	);
	for(var i=0;i<o.length;i++){
		obj.options[i]=new Option(o[i].text,o[i].value,o[i].defaultSelected,o[i].selected);
	}
}

function selectAllOptions(obj){
	if(!hasOptions(obj)){ return; }
	for(var i=0;i<obj.options.length;i++){
		obj.options[i].selected=true;
	}
}

function moveSelectedOptions(from,to){
	if(arguments.length>3){
		var regex=arguments[3];
		if (regex!='') {
			unSelectMatchingOptions(from,regex);
		}
	}
	if(!hasOptions(from)){ return; }
	for(var i=0;i<from.options.length;i++){
		var o=from.options[i];
		if(o.selected){
			if(!hasOptions(to)){
				var index=0;
			}else{
				var index=to.options.length;
			}
			to.options[index]=new Option(o.text,o.value,false,false);
		}
	}
	for(var i=(from.options.length-1);i>=0;i--){
		var o=from.options[i];
		if(o.selected){
			from.options[i]=null;
		}
	}
	if((arguments.length<3)||(arguments[2]==true)){
		sortSelect(from);
		sortSelect(to);
	}
	from.selectedIndex=-1;
	to.selectedIndex=-1;
}

function copySelectedOptions(from,to){
	var options=new Object();
	if(hasOptions(to)){
		for(var i=0;i<to.options.length;i++){
			options[to.options[i].value]=to.options[i].text;
		}
	}
	if(!hasOptions(from)){ return; }
	for (var i=0;i<from.options.length;i++){
		var o=from.options[i];
		if(o.selected){
			if(options[o.value]==null||options[o.value]=='undefined'||options[o.value]!=o.text){
				if(!hasOptions(to)){
					var index = 0;
				}else{
					var index=to.options.length;
				}
				to.options[index]=new Option(o.text,o.value,false,false);
			}
		}
	}
	if((arguments.length<3)||(arguments[2]==true)){
		sortSelect(to);
	}
	from.selectedIndex=-1;
	to.selectedIndex=-1;
}

function moveAllOptions(from,to){
	selectAllOptions(from);
	if(arguments.length==2){
		moveSelectedOptions(from,to);
	}else if(arguments.length==3){
		moveSelectedOptions(from,to,arguments[2]);
	}else if(arguments.length==4){
		moveSelectedOptions(from,to,arguments[2],arguments[3]);
	}
}

function copyAllOptions(from,to){
	selectAllOptions(from);
	if(arguments.length==2){
		copySelectedOptions(from,to);
	}else if(arguments.length==3){
		copySelectedOptions(from,to,arguments[2]);
	}
}

function swapOptions(obj,i,j){
	var o=obj.options;
	var i_selected=o[i].selected;
	var j_selected=o[j].selected;
	var temp=new Option(o[i].text,o[i].value,o[i].defaultSelected,o[i].selected);
	var temp2=new Option(o[j].text,o[j].value,o[j].defaultSelected,o[j].selected);
	o[i]=temp2;
	o[j]=temp;
	o[i].selected=j_selected;
	o[j].selected=i_selected;
}

function moveOptionUp(obj){
	if(!hasOptions(obj)){ return; }
	for(i=0;i<obj.options.length;i++){
		if(obj.options[i].selected){
			if(i!=0&&!obj.options[i-1].selected){
				swapOptions(obj,i,i-1);
				obj.options[i-1].selected=true;
			}
		}
	}
}

function moveOptionDown(obj){
	if(!hasOptions(obj)){ return; }
	for(i=obj.options.length-1;i>=0;i--){
		if(obj.options[i].selected){
			if(i!=(obj.options.length-1)&&!obj.options[i+1].selected){
				swapOptions(obj,i,i+1);
				obj.options[i+1].selected=true;
			}
		}
	}
}

function removeSelectedOptions(from){
	if(!hasOptions(from)){ return; }
	if(from.type=='select-one'){
		from.options[from.selectedIndex]=null;
	}else{
		for(var i=(from.options.length-1);i>=0;i--){ 
			var o=from.options[i];
			if(o.selected){ 
				from.options[i]=null; 
			}
		}
	}
	from.selectedIndex=-1; 
}

function removeAllOptions(from){ 
	if(!hasOptions(from)){ return; }
	for(var i=(from.options.length-1);i>=0;i--){ 
		from.options[i]=null;
	}
	from.selectedIndex=-1; 
}

function addOption(obj,text,value,selected){
	if(obj!=null&&obj.options!=null){
		obj.options[obj.options.length]=new Option(text,value,false,selected);
	}
}

function removeOption(obj){
	var selIndex=obj.selectedIndex;
	if(selIndex!=-1) {
		for(i=obj.length-1;i>=0;i--){
			if(obj.options[i].selected){
				addEntry(obj.options[i].text,obj.options[i].value);
				obj.options[i]=null;
			}
		}
		if(obj.length>0){
			obj.selectedIndex=selIndex==0?0:selIndex-1;
		}
	}
}

function getCsv(){
	aSct=new Array();
	aSctLen=new Array()
	aSct[0]=_fo['list11'];
	aSctLen[0]=aSct[0].length;
	aSct[1]=_fo['list21'];
	aSctLen[1]=aSct[1].length;
	aValue=new Array();
	aValue[0]=aValue[1]='';
	for(var i=0;i<2;i++){
		for(var k=0;k<aSctLen[i];k++){
			aValue[i]+=aSct[i].options[k].value;
			if(k!=aSctLen[i]-1) aValue[i]+=',';
		}
	}
	return aValue[0]+';'+aValue[1];
}

function save(){
	var sCsv=getCsv();
	var oCsv_=opener.gel(_sObjId+'_csv');
	oCsv_.value=sCsv;
	savePrefs();
	if(_sCsvInit_!=sCsv){
		opener.rpc(sCsv,'','','','',_sObjId,_sSctInc);
	}
	" . we_message_reporting::getShowMessageCall(
		$l_cockpit['prefs_saved_successfully'], 
		WE_MESSAGE_NOTICE) . "
	self.close();
}

function preview(){
	_bPrev=true;
	previewPrefs();
	opener.rpc(getCsv(),'','','','',_sObjId,_sSctInc);
}

function exit_close(){
	if(_sCsvInit_!=getCsv()&&_bPrev){
		opener.rpc(_sCsvInit_,'','','','',_sObjId,_sSctInc);
	}
	exitPrefs();
	self.close();
}
";

$aPopulate = array_merge($shortcuts[0], $shortcuts[1]);

$oSctPool = new we_htmlSelect(
		array(
			
				"name" => "sct_pool", 
				"size" => "1", 
				"class" => "defaultfont", 
				"onChange" => "addBtn(_fo['list11'],this.options[this.selectedIndex].text,this.options[this.selectedIndex].value,true);this.options[0].selected=true;"
		));
$oSctPool->insertOption(0, " ", "");
$iCurrOpt = 1;
foreach ($aPopulate as $key => $value) {
	$oSctPool->insertOption($iCurrOpt, $key, $value);
	$iCurrOpt++;
}

$oSctList11 = new we_htmlSelect(
		array(
			
				"multiple" => "multiple", 
				"name" => "list11", 
				"size" => "10", 
				"style" => "width:200px;", 
				"class" => "defaultfont", 
				"onDblClick" => "moveSelectedOptions(this.form['list11'],this.form['list21'],false);"
		));
$oSctList21 = new we_htmlSelect(
		array(
			
				"multiple" => "multiple", 
				"name" => "list21", 
				"size" => "10", 
				"style" => "width:200px;", 
				"class" => "defaultfont", 
				"onDblClick" => "moveSelectedOptions(this.form['list21'],this.form['list11'],false);"
		));

$we_button = new we_button();
$oBtnDelete = $we_button->create_button(
		"delete", 
		"javascript:removeOption(document.forms[0]['list11']);removeOption(document.forms[0]['list21']);", 
		false, 
		-1, 
		-1, 
		"", 
		"", 
		false, 
		false);
$oShortcutsRem = htmlAlertAttentionBox($l_cockpit['sct_rem'], 2, 420);

$oPool = new we_htmlTable(array(
	"border" => "0", "width" => 420, "cellpadding" => "0", "cellspacing" => "0"
), 3, 3);
$oPool->setCol(0, 0, null, $oSctList11->getHTMLCode());
$oPool->setCol(
		0, 
		1, 
		array(
			"align" => "center", "valign" => "middle"
		), 
		we_htmlElement::htmlA(
				array(
					
						"href" => "#", 
						"onClick" => "moveOptionUp(document.forms[0]['list11']);moveOptionUp(document.forms[0]['list21']);return false;"
				), 
				we_htmlElement::htmlImg(array(
					"src" => IMAGE_DIR . "pd/arrow_up.gif", "border" => 0
				))) . we_htmlElement::htmlBr() . we_htmlElement::htmlBr() . we_htmlElement::htmlA(
				array(
					
						"href" => "#", 
						"onClick" => "moveSelectedOptions(document.forms[0]['list11'],document.forms[0]['list21'],false);return false;"
				), 
				we_htmlElement::htmlImg(array(
					"src" => IMAGE_DIR . "pd/arrow_right.gif", "border" => 0
				))) . we_htmlElement::htmlBr() . we_htmlElement::htmlBr() . we_htmlElement::htmlA(
				array(
					
						"href" => "#", 
						"onClick" => "moveSelectedOptions(document.forms[0]['list21'],document.forms[0]['list11'],false);return false;"
				), 
				we_htmlElement::htmlImg(array(
					"src" => IMAGE_DIR . "pd/arrow_left.gif", "border" => 0
				))) . we_htmlElement::htmlBr() . we_htmlElement::htmlBr() . we_htmlElement::htmlA(
				array(
					
						"href" => "#", 
						"onClick" => "moveOptionDown(document.forms[0]['list11']);moveOptionDown(document.forms[0]['list21']);return false;"
				), 
				we_htmlElement::htmlImg(array(
					"src" => IMAGE_DIR . "pd/arrow_down.gif", "border" => 0
				))));
$oPool->setCol(0, 2, null, $oSctList21->getHTMLCode());
$oPool->setCol(1, 0, null, getPixel(1, 5));
$oPool->setCol(2, 0, array(
	"align" => "right", "colspan" => 3
), $oBtnDelete);

$content = $oShortcutsRem . getPixel(1, 5) . we_htmlElement::htmlBr() . htmlFormElementTable(
		$oSctPool->getHTMLCode(), 
		$l_cockpit['select_buttons'], 
		"left", 
		"defaultfont") . getPixel(1, 5) . we_htmlElement::htmlBr() . $oPool->getHTMLCode();

$we_button = new we_button();
array_push($parts, array(
	"headline" => "", "html" => $content, "space" => 0
));
array_push($parts, array(
	"headline" => "", "html" => $oSelCls->getHTMLCode(), "space" => 0
));

$save_button = $we_button->create_button("save", "javascript:save();", false, -1, -1);
$preview_button = $we_button->create_button("preview", "javascript:preview();", false, -1, -1);
$cancel_button = $we_button->create_button("close", "javascript:exit_close();");
$buttons = $we_button->position_yes_no_cancel($save_button, $preview_button, $cancel_button);

$sTblWidget = we_multiIconBox::getJS() . we_multiIconBox::getHTML(
		"sctProps", 
		"100%", 
		$parts, 
		30, 
		$buttons, 
		-1, 
		"", 
		"", 
		"", 
		$l_cockpit['shortcuts']);

print 
		we_htmlElement::htmlHtml(
				we_htmlElement::htmlHead(
						we_htmlElement::htmlTitle($l_cockpit['shortcuts']) . STYLESHEET . we_htmlElement::cssElement(
								"select,textarea{border:#AAAAAA solid 1px}") . we_htmlElement::jsElement(
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
