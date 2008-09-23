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
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/export.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_widgets/dlg/prefs.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_widgets/dlg/tree.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/" . "weSuggest.class.inc.php");

$yuiSuggest = new weSuggest();
$showAC = false;
$yuiSuggest->setAutocompleteField(
		"yuiAcInputDoc", 
		"yuiAcContainerDoc", 
		FILE_TABLE, 
		"folder,text/webEdition,text/html", 
		"docSelector", 
		14, 
		1, 
		"yuiAcLayerDoc", 
		array(
			"yuiAcIdDoc"
		), 
		1, 
		"296px");

list($sTitle, $selBinary, $sCsv) = explode(";", $_REQUEST["we_cmd"][1]);
$_title = base64_decode($sTitle);
$_selection = (bool)$selBinary{0};
$_selType = (bool)$selBinary{1};

$_selTable = FILE_TABLE;

if ($_selection) {
	$selType = ($_selType) ? "selObjs" : "selDocs";
	if (defined("OBJECT_FILES_TABLE")) {
		$_selTable = ($_selType) ? OBJECT_FILES_TABLE : FILE_TABLE;
	}
	
	$_SESSION["exportVars"][$selType] = $sCsv;
}
$jsTree = "

function startInit() { // this function is called onload!
	startTree();
	var _sCsv='" . $sCsv . "';
	var aCsv=_sCsv.split(',');
	var aCsvLen=aCsv.length;
	for(var i=0;i<aCsvLen;i++){
		SelectedItems['" . $_selTable . "'][i]=aCsv[i];
	}
}	
	";

function getHTMLDirSelector($_selType)
{
	global $l_cockpit, $showAC, $yuiSuggest;
	$showAC = true;
	$we_button = new we_button();
	$rootDirID = 0;
	$folderID = 0;
	
	$_button_doc = $we_button->create_button(
			"select", 
			"javascript:we_cmd('openDirselector',document.we_form.elements['FolderID'].value,'" . FILE_TABLE . "','document.we_form.elements[\\'FolderID\\'].value','document.we_form.elements[\\'FolderPath\\'].value','','" . session_id() . "','$rootDirID')");
	$_button_obj = defined('OBJECT_TABLE') ? $we_button->create_button(
			"select", 
			"javascript:we_cmd('openDirselector',document.we_form.elements['FolderID'].value,'" . OBJECT_FILES_TABLE . "','document.we_form.elements[\\'FolderID\\'].value','document.we_form.elements[\\'FolderPath\\'].value','','" . session_id() . "','$rootDirID')") : '';
	
	$_buttons = '<div id="docFolder" style="display: ' . (!$_selType ? "inline" : "none") . '">' . $_button_doc . "</div>" . '<div id="objFolder" style="display: ' . ($_selType ? "inline" : "none") . '">' . $_button_obj . "</div>";
	$_path = id_to_path($folderID, (!$_selType ? FILE_TABLE : (defined("OBJECT_FILES_TABLE") ? OBJECT_FILES_TABLE : "")));
	
	return we_htmlElement::htmlDiv(
			array(
				"style" => "margin-top:10px;"
			), 
			htmlFormElementTable(
					"<div id=\"yuiAcLayerDoc\" class=\"yuiAcLayer\">" . $yuiSuggest->getErrorMarkPlaceHolder(
							"yuiAcErrorMarkDoc") . htmlTextInput(
							"FolderPath", 
							58, 
							$_path, 
							"", 
							'onchange="" id="yuiAcInputDoc"', 
							"text", 
							(420 - 120), 
							0) . "<div id=\"yuiAcContainerDoc\"></div></div>", 
					$l_cockpit["dir"], 
					"left", 
					"defaultfont", 
					getPixel(300, 20), 
					we_htmlElement::htmlHidden(array(
						"name" => "FolderID", "value" => $folderID, "id" => "yuiAcIdDoc"
					)), 
					getPixel(20, 4), 
					$_buttons));
}

$docTypes = array(
	0 => $l_cockpit["no_entry"]
);
$q = getDoctypeQuery($DB_WE);
$DB_WE->query("SELECT ID,DocType FROM " . DOC_TYPES_TABLE . " $q");
while ($DB_WE->next_record()) {
	$docTypes[$DB_WE->f("ID")] = $DB_WE->f("DocType");
}
$doctypeElement = htmlFormElementTable(
		htmlSelect(
				"DocTypeID", 
				$docTypes, 
				1, 
				0, 
				false, 
				'onChange="" style="width:420px; border: #AAAAAA solid 1px;"', 
				'value'), 
		$l_cockpit["doctype"]);

$cls = new we_htmlSelect(
		array(
			
				"name" => "classID", 
				"size" => "1", 
				"class" => "defaultfont", 
				"style" => "width:420px; border: #AAAAAA solid 1px"
		));
$optid = 0;
$cls->insertOption($optid, 0, $l_cockpit["no_entry"]);
$ac = makeCSVFromArray(getAllowedClasses($DB_WE));
if ($ac) {
	$DB_WE->query("SELECT ID,Text FROM " . OBJECT_TABLE . " " . ($ac ? " WHERE ID IN($ac) " : "") . "ORDER BY Text");
	while ($DB_WE->next_record()) {
		$optid++;
		$cls->insertOption($optid, $DB_WE->f("ID"), $DB_WE->f("Text"));
		if ($DB_WE->f("ID") == -1)
			$cls->selectOption($DB_WE->f("ID"));
	}
}

function getHTMLCategory()
{
	$we_button = new we_button();
	$addbut = $we_button->create_button(
			"add", 
			"javascript:we_cmd('openCatselector','','" . CATEGORY_TABLE . "','','','fillIDs();opener.addCat(top.allPaths);')", 
			false, 
			100, 
			22, 
			"", 
			"", 
			(!we_hasPerm("EDIT_KATEGORIE")));
	$del_but = addslashes(
			we_htmlElement::htmlImg(
					array(
						
							'src' => IMAGE_DIR . '/button/btn_function_trash.gif', 
							'onclick' => 'javascript:#####placeHolder#####;top.mark();', 
							'style' => 'cursor: pointer; width: 27px;-moz-user-select: none;'
					)));
	
	$js = we_htmlElement::jsElement('', array(
		'src' => JS_DIR . 'utils/multi_edit.js?' . WE_VERSION
	));
	
	$variant_js = '
		var categories_edit=new multi_edit("categories",document.we_form,0,"' . $del_but . '",390,false);
		categories_edit.addVariant();
		document.we_form.CategoriesControl.value=categories_edit.name;

	';
	$Categories = '';
	if (is_array($Categories)) {
		foreach ($Categories as $cat) {
			$variant_js .= '
				categories_edit.addItem();
				categories_edit.setItem(0,(categories_edit.itemCount-1),"' . $cat . '");
			';
		}
	}
	
	$variant_js .= '
		categories_edit.showVariant(0);
	';
	
	$js .= we_htmlElement::jsElement($variant_js);
	
	$table = new we_htmlTable(
			array(
				
					'id' => 'CategoriesBlock', 
					'style' => 'display: block;', 
					'cellpadding' => 0, 
					'cellspacing' => 0, 
					'border' => 0
			), 
			5, 
			1);
	
	$table->setColContent(0, 0, getPixel(5, 5));
	$table->setCol(1, 0, array(
		'class' => 'defaultfont'
	), "Kategorien");
	$table->setColContent(
			2, 
			0, 
			we_htmlElement::htmlDiv(
					array(
						
							'id' => 'categories', 
							'class' => 'blockWrapper', 
							'style' => 'width:420px;height:60px;border:#AAAAAA solid 1px;'
					)));
	
	$table->setColContent(3, 0, getPixel(5, 5));
	
	$table->setCol(
			4, 
			0, 
			array(
				'colspan' => '2', 'align' => 'right'
			), 
			$we_button->create_button_table(
					array(
						$we_button->create_button("delete_all", "javascript:removeAllCats()"), $addbut
					)));
	
	return $table->getHtmlCode() . $js . we_htmlElement::jsElement(
			"
function removeAllCats(){
	if(categories_edit.itemCount>0){
		while(categories_edit.itemCount>0){
			categories_edit.delItem(categories_edit.itemCount);
		}
	}
}

function addCat(paths){
	var path=paths.split(',');
	var found=false;
	var j=0;
	for(var i=0;i<path.length;i++){
		if(path[i]!=''){
			found=false;
			for(j=0;j<categories_edit.itemCount;j++){
				if(categories_edit.form.elements[categories_edit.name+'_variant0_'+categories_edit.name+'_item'+j].value==path[i]){
					found=true;
				}
			}
			if(!found){
				categories_edit.addItem();
				categories_edit.setItem(0,(categories_edit.itemCount-1),path[i]);
			}
		}
	}
	categories_edit.showVariant(0);
}
	");
}

$parts = array();
$jsCode = "
var _oCsv_;
var _sCsv;
var _sInitCsv_;
var _sInitTitle_='" . $sTitle . "';
var _sMdcInc='mdc/mdc';

var table='" . $_selTable . "';

function we_cmd(){
	var args='';
	var url='/webEdition/we_cmd.php?';
	for(var i=0;i<arguments.length;i++){
		url+='we_cmd['+i+']='+escape(arguments[i]);
		if(i<(arguments.length-1)){
			url+='&';
		}
	}
	switch(arguments[0]){
		case 'openDirselector':
			new jsWindow(url,'we_fileselector',-1,-1," . WINDOW_DIRSELECTOR_WIDTH . "," . WINDOW_DIRSELECTOR_HEIGHT . ",true,true,true,true);
			break;
		case 'openCatselector':
			new jsWindow(url,'we_catselector',-1,-1," . WINDOW_CATSELECTOR_WIDTH . "," . WINDOW_CATSELECTOR_HEIGHT . ",true,true,true,true);
			break;
		default:
			for(var i=0;i<arguments.length;i++){
				args+='arguments['+i+']'+((i<(arguments.length-1))?',':'');
			}
			eval('parent.we_cmd('+args+')');
	}
}

function we_submit(){
	var bSelection=_fo.Selection.selectedIndex;
	var bSelType=_fo.headerSwitch.selectedIndex;
	_fo.action='" . WEBEDITION_DIR . "we/include/we_widgets/dlg/mdc.inc.php?we_cmd[0]='+_sObjId+'&we_cmd[1]='+opener.base64_encode(_fo.title.value)+';'+
		(bSelection?'1':'0')+(bSelType?'1':'0')+';'+(bSelection?getTreeSelected():'');
	_fo.method='post';
	_fo.submit();
}

function toggle(id){				
	var elem=document.getElementById(id);
	if(elem){
		if(elem.style.display=='none') elem.style.display='block';
		else elem.style.display='none';
	}
}

function setVisible(id,visible){
	var elem=document.getElementById(id);
	if(elem){
		if(visible==true) elem.style.display='block';
		else elem.style.display='none';
	}
}

function setPresentation(type){" . "}
			
function closeAllSelection(){
	setVisible('dynamic',false);
	setVisible('static',false);
}

function init(){
	_fo=document.forms[0];
	initPrefs();
	_oCsv_=opener.gel(_sObjId+'_csv');
	_sInitCsv_=_oCsv_.value;
	_sInitTitle_=opener.gel(_sObjId+'_prefix').value;
	_fo.elements['title'].value=_sInitTitle_;
	var aInitCsv=_sInitCsv_.split(';');
	var dir=aInitCsv[2].split(',');
	var sBinary='" . $selBinary . "';
	var _sCsv='" . $sCsv . "';
	if(parseInt(sBinary.substr(0,1))==parseInt(aInitCsv[1].substr(0,1))){
		if(parseInt(sBinary.substr(1))==parseInt(aInitCsv[1].substr(1))){
			_fo.FolderID.value=dir[0];
			_fo.FolderPath.value=dir[1];
			if(aInitCsv[3]!=0){
				var obj=parseInt(sBinary.substr(1))?_fo.classID:_fo.DocTypeID;
				obj.value=aInitCsv[3];
			}
			if(typeof aInitCsv[4]!='undefined'&&aInitCsv[4]!='')addCat(opener.base64_decode(aInitCsv[4]));
		}
	}
}

function save(){
	var sTitle=_fo.title.value;
	var sSel=(_fo.Selection.selectedIndex)?'1':'0';
	var sSwitch=(_fo.headerSwitch.selectedIndex)?'1':'0';
	var sCsv=(parseInt(sSel))?getTreeSelected():getCsv(parseInt(sSwitch));
	opener.rpc(sSel+sSwitch,sCsv,'','',sTitle,_sObjId,_sMdcInc);
	_oCsv_.value=opener.base64_encode(sTitle)+';'+sSel+sSwitch+';'+sCsv;
	savePrefs();
	" . we_message_reporting::getShowMessageCall(
		$l_cockpit['prefs_saved_successfully'], 
		WE_MESSAGE_NOTICE) . "
	self.close();
}

function getCsv(bTbl){
	var iFolderID=_fo.FolderID.value;
	var sFolderPath=_fo.FolderPath.value;
	var iDtOrCls=(bTbl)?_fo.classID.value:_fo.DocTypeID.value;
	var sCats='';
	for(var j=0;j<categories_edit.itemCount;j++){
		sCats+=opener.base64_encode(categories_edit.form.elements[categories_edit.name+'_variant0_'+categories_edit.name+'_item'+j].value);
		if(j<categories_edit.itemCount-1) sCats+=',';
	}
	var sCsv=iFolderID+','+sFolderPath+';'+iDtOrCls+';'+sCats;
	return sCsv;
}

function getTreeSelected(){
	var sCsvIds='';
	var iTemsLen=SelectedItems[table].length;
	for(var i=0;i<iTemsLen;i++){
		sCsvIds+=SelectedItems[table][i];
		if(i<iTemsLen-1&&typeof SelectedItems[table][i]!='undefined'&&SelectedItems[table][i]!='') sCsvIds+=',';
	}
	return sCsvIds;
}

function preview(){
	var sTitle=_fo.title.value;
	var sSel=(_fo.Selection.selectedIndex)?'1':'0';
	var sSwitch=(_fo.headerSwitch.selectedIndex)?'1':'0';
	var sCsv=(parseInt(sSel))?getTreeSelected():getCsv(parseInt(sSwitch));
	previewPrefs();
	opener.rpc(sSel+sSwitch,(sCsv)?sCsv:'','','',sTitle,_sObjId,_sMdcInc);
}

function exit_close(){
	var sTitle=_fo.elements['title'].value;
	var sSel=(_fo.Selection.selectedIndex)?'1':'0';
	var sSwitch=(_fo.headerSwitch.selectedIndex)?'1':'0';
	var sCsv=(parseInt(sSel))?getTreeSelected():getCsv(parseInt(sSwitch));
	var aInitCsv=_sInitCsv_.split(';');
	var sInitTitle=opener.base64_decode(aInitCsv[0]);
	if((sInitTitle!=''&&sInitTitle!=sTitle)||aInitCsv[1]!=sSel+sSwitch||aInitCsv[2]!=sCsv){
		opener.rpc(aInitCsv[1],aInitCsv[2],'','',sInitTitle,_sObjId,_sMdcInc);
	}
	exitPrefs();
	self.close();
}
";

$we_button = new we_button();

$_seltype = array(
	'doctype' => $l_cockpit['documents']
);
if (defined('OBJECT_TABLE')) {
	$_seltype['classname'] = $l_cockpit['objects'];
}

$tree = new weExportTree();
$tree->init('treeCmd.php', 'top', 'top', 'cmd');

$divStatic = we_htmlElement::htmlDiv(
		array(
			"id" => "static", "style" => ($_selection ? "display:block;" : "display:none;")
		), 
		we_htmlElement::htmlDiv(array(
			"id" => "treeContainer"
		), $tree->getHTMLMultiExplorer(420, 180)) . "<iframe name=\"cmd\" src=\"about:blank\" style=\"visibility:hidden; width: 0px; height: 0px;\"></iframe>");

$captions = array();
if (we_hasPerm("CAN_SEE_DOCUMENTS")) {
	$captions[FILE_TABLE] = $l_export["documents"];
}
if (defined("OBJECT_FILES_TABLE") && we_hasPerm("CAN_SEE_OBJECTFILES")) {
	$captions[OBJECT_FILES_TABLE] = $l_export["objects"];
}

$divDynamic = we_htmlElement::htmlDiv(
		array(
			"id" => "dynamic", "style" => (!$_selection ? "display:block;" : "display:none;")
		), 
		getHTMLDirSelector($_selType) . getPixel(1, 5) . we_htmlElement::htmlBr() . ((!$_selType) ? $doctypeElement : htmlFormElementTable(
				$cls->getHTMLCode(), 
				$l_cockpit["class"])) . getPixel(1, 5) . we_htmlElement::htmlBr() . getHTMLCategory());

$divContent = we_htmlElement::htmlDiv(
		array(
			"style" => "display:block;"
		), 
		htmlSelect(
				"Selection", 
				array(
					"dynamic" => $l_cockpit["dyn_selection"], "static" => $l_cockpit['stat_selection']
				), 
				1, 
				($_selection ? "static" : "dynamic"), 
				false, 
				'style="width:420px;border:#AAAAAA solid 1px;" onChange="closeAllSelection();we_submit();"', 
				'value') . we_htmlElement::htmlBr() . htmlSelect(
				"headerSwitch", 
				$captions, 
				1, 
				(!$_selType ? FILE_TABLE : OBJECT_FILES_TABLE), 
				false, 
				'style="width:420px;border:#AAAAAA solid 1px;margin-top:10px;" onChange="setHead(this.value);we_submit();"', 
				'value', 
				420) . $divStatic . $divDynamic . getPixel(1, 5) . we_htmlElement::htmlBr() . htmlFormElementTable(
				htmlTextInput(
						$name = "title", 
						$size = 55, 
						$value = $_title, 
						$maxlength = 255, 
						$attribs = "", 
						$type = "text", 
						$width = 420, 
						$height = 0), 
				$l_cockpit['title'], 
				"left", 
				"defaultfont"));

array_push($parts, array(
	"headline" => "", "html" => $divContent, "space" => 0
));
array_push($parts, array(
	"headline" => "", "html" => $oSelCls->getHTMLCode(), "space" => 0
));

$save_button = $we_button->create_button("save", "javascript:save();", false, -1, -1);
$preview_button = $we_button->create_button("preview", "javascript:preview();", false, -1, -1);
$cancel_button = $we_button->create_button("close", "javascript:exit_close();");
$buttons = $we_button->position_yes_no_cancel($save_button, $preview_button, $cancel_button);

$sTblWidget = we_multiIconBox::getHTML(
		"mdcProps", 
		"100%", 
		$parts, 
		30, 
		$buttons, 
		-1, 
		"", 
		"", 
		"", 
		$l_cockpit['my_documents']);

print 
		we_htmlElement::htmlHtml(
				we_htmlElement::htmlHead(
						we_htmlElement::htmlTitle($l_cockpit['my_documents']) . $yuiSuggest->getYuiCssFiles() . $yuiSuggest->getYuiJsFiles() . STYLESHEET . we_htmlElement::jsElement(
								"", 
								array(
									"src" => JS_DIR . "we_showMessage.js"
								)) . we_htmlElement::jsElement("", array(
							"src" => JS_DIR . "windows.js"
						)) . we_htmlElement::jsElement($jsPrefs . $jsCode)) . we_htmlElement::htmlBody(
						array(
							"class" => "weDialogBody", "onload" => "init();startInit();"
						), 
						we_htmlElement::htmlForm(
								"", 
								we_htmlElement::htmlHidden(array(
									"name" => "table", "value" => ""
								)) . we_htmlElement::htmlHidden(array(
									"name" => "FolderID", "value" => 0
								)) . we_htmlElement::htmlHidden(
										array(
											
												"name" => "CategoriesControl", 
												"value" => (isset($_REQUEST['CategoriesCount']) ? $_REQUEST['CategoriesCount'] : 0)
										)) . $sTblWidget . we_htmlElement::jsElement($jsTree))));
if ($showAC) {
	print $yuiSuggest->getYuiCss();
	print $yuiSuggest->getYuiJs();
}

?>
