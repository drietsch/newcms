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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_forms.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlTable.inc.php");

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/alert.inc.php");

if(defined("WORKFLOW_TABLE")) {
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/workflow/weWorkflowUtility.php");
}
protect();

$we_transaction = isset($_REQUEST["we_cmd"][1]) ? $_REQUEST["we_cmd"][1] : $we_transaction;

// init document
$we_dt = $_SESSION["we_data"][$we_transaction];
include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_editors/we_init_doc.inc.php");

function getControlElement($type, $name){

	global $we_doc;

	if(isset($we_doc->controlElement) && is_array($we_doc->controlElement) ){

		if(isset($we_doc->controlElement[$type][$name])){

			return $we_doc->controlElement[$type][$name];

		} else {
			return false;
		}
	} else {
		return false;
	}
}

switch ($we_doc->userHasAccess()){

	case  1 : 	//	all is allowed, creator or owner
		break;

	case -1 :	//	file is not in workspace of user
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_editors/file_in_workspace_footer.inc.php");
		exit();
		break;

	case -2 :	//	access is restricted and user has no permission
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_editors/file_restricted_footer.inc.php");
		exit;
		break;

	case -3 :	//	file is locked by another user
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_editors/file_locked_footer.inc.php");
		exit;
		break;

	case -4 :	//	user has not the right to save the file.
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_editors/file_no_save_footer.inc.php");
		exit;
		break;
}


//	preparations of needed vars
htmlTop();

$showPubl = we_hasPerm("PUBLISH") && $we_doc->userCanSave() && $we_doc->IsTextContentDoc;
$reloadPage = ($showPubl && (!$we_doc->ID)) ? true : false;
$haspermNew = false;

//	Check permissions for buttons
switch($we_doc->ContentType) {
	case "text/html":
		$haspermNew = we_hasPerm("NEW_HTML");
		break;
	case "text/webedition":
		$haspermNew = we_hasPerm("NEW_WEBEDITIONSITE");
		break;
	case "objectFile":
		$haspermNew = we_hasPerm("NEW_OBJECTFILE");
		break;
}

//	########################	required javascript functions
//	########################	function we_save_document	######################################

// ---> Glossary Check
//
// load Glossary Settings
$showGlossaryCheck = 0;

if(		isset($_SESSION['prefs']['force_glossary_check'])
	&&	$_SESSION['prefs']['force_glossary_check']==1
	&& (
				$we_doc->ContentType == "text/webedition"
			||	$we_doc->ContentType == "objectFile"
		)
	) {
	$showGlossaryCheck = 1;
} else {
	$showGlossaryCheck = 0;
}

$_js_we_save_document = "
    var _showGlossaryCheck = $showGlossaryCheck;
	var countSaveLoop = 0;
	function we_save_document(){
		try{
			var contentEditor = top.weEditorFrameController.getVisibleEditorFrame();
			if (contentEditor && contentEditor.fields_are_valid && !contentEditor.fields_are_valid()) {
				return;
	
			}
		}
		catch(e) {
			// Nothing
		}
		
		if (  _EditorFrame.getEditorPublishWhenSave() && _showGlossaryCheck) {
			we_cmd('check_glossary', '', '".$we_transaction."');

		} else {

			acStatus = '';
			invalidAcFields = false;
			try{
				if(parent && parent.frames[1] && parent.frames[1].YAHOO && parent.frames[1].YAHOO.autocoml) {
					 acStatus = parent.frames[1].YAHOO.autocoml.checkACFields();
				}
			}
			catch(e) {
				// Nothing
			}
			acStatusType = typeof acStatus;
			if(parent && parent.weAutoCompetionFields && parent.weAutoCompetionFields.length>0) {
				for(i=0; i<parent.weAutoCompetionFields.length; i++) {
					if(parent.weAutoCompetionFields[i] && parent.weAutoCompetionFields[i].id && !parent.weAutoCompetionFields[i].valid) invalidAcFields = true;
				}
			}
			if (countSaveLoop > 10) {
				" . we_message_reporting::getShowMessageCall($l_alert['save_error_fields_value_not_valid'],WE_MESSAGE_ERROR) . ";
				countSaveLoop = 0;
			}
			else if(acStatusType.toLowerCase() == 'object' && acStatus.running) {
				countSaveLoop++;
				setTimeout('we_save_document()',100);
			} else if(invalidAcFields) {
				" . we_message_reporting::getShowMessageCall($l_alert['save_error_fields_value_not_valid'],WE_MESSAGE_ERROR) . ";
				countSaveLoop=0;
			} else {
				countSaveLoop=0;
";
if($we_doc->userCanSave()){
	$_js_we_save_document .= "
			var addCmd = arguments[0] ? arguments[0] : '';
		";

	$_js_we_save_document .= "
		we_cmd('save_document','','','',''," . ($showPubl ? " _EditorFrame.getEditorPublishWhenSave() " : "''") . ",addCmd);
	" . ($reloadPage ? "self.location='" . $we_doc->url(WEBEDITION_DIR . 'we_cmd.php?we_cmd[0]=load_edit_footer') . "';" : "");

}

	$_js_we_save_document .= "
			_showGlossaryCheck = $showGlossaryCheck;
		}
	}
}";

//	########################	function for workflow	###########################################
$_js_workflow_functions = "";
if(defined("WORKFLOW_TABLE")){

	$_js_workflow_functions = "
	function put_in_workflow() {

		if( _EditorFrame.getEditorIsHot() ) {
			if(confirm('" . $l_alert[$we_doc->Table]["in_wf_warning"] . "')) {
				we_cmd('save_document','','','','',0,0,1);
			}
		}
		else {
			top.we_cmd('in_workflow','$we_transaction'," . ( ($we_doc->IsTextContentDoc && $haspermNew && (!inWorkflow($we_doc))) ? "( _EditorFrame.getEditorMakeSameDoc() ? 1 : 0 )" : "0"  ) . ");
		}
	}

	function pass_workflow() {
		we_cmd('pass','" . $we_transaction . "');
	}

	function finish_workflow() {
		we_cmd('finish_workflow','" . $we_transaction . "');
	}

	function decline_workflow() {
		we_cmd('decline','" . $we_transaction . "');
	}
";
}
//	########################	function variable cansave	###########################################
$_js_weCanSave = "
	var weCanSave=" . ($we_doc->userCanSave() ? "true" : "false") .";
";

//	added for we:controlElement type="button" name="save" hide="true"
$_ctrlElem = getControlElement('button', 'save');

if($_ctrlElem && $_ctrlElem['hide']){
	$_js_weCanSave .= '
	weCanSave=false;	//	we:controlElement
	';
}


if(defined("WORKFLOW_TABLE")){
	if(inWorkflow($we_doc)){
		if(!weWorkflowUtility::canUserEditDoc($we_doc->ID,$we_doc->Table,$_SESSION["user"]["ID"])){
			$_js_weCanSave .= "
	weCanSave=false;
";
		}
	}
}


//	########################	toggleBusy call	#########################################################
$_js_toggleBusy = "
	top.toggleBusy(0);";


//	########################	function we_cmd	#########################################################

$_js_we_cmd = "
	function we_cmd() {
	var url = '" . WEBEDITION_DIR . "we_cmd.php?';
	for(var i = 0; i < arguments.length; i++) {
		url += \"we_cmd[\"+i+\"]=\"+escape(arguments[i]);
		if(i < (arguments.length - 1))
			url += \"&\";
	}
";
if($we_doc->Table == TEMPLATES_TABLE){	//	Its a template
	$_js_we_cmd .= "
		if(arguments[0] == \"save_document\") {	// its a folder
	" . ( $we_doc->ContentType=="folder"
			?
		  "
			top.we_cmd(\"save_document\",'" . $we_transaction . "',0,1,'','',arguments[6] ? arguments[6] : '',arguments[7] ? arguments[7] : '');"
		: "
			top.we_cmd(\"save_document\",'" . $we_transaction . "',0,0,'','',arguments[6] ? arguments[6] : '',arguments[7] ? arguments[7] : '');
" ) . "
			return;
		}";

} else {	//	Its not a template

	$_js_we_cmd .= "
		switch(arguments[0]) {
			case \"check_glossary\":
				new jsWindow(url,\"check_glossary\",-1,-1,730,400,true,false,true);
				return;
			case \"save_document\":
				top.we_cmd(\"save_document\",'" . $we_transaction . "',0,1," . ( ($we_doc->IsTextContentDoc && $haspermNew && (!inWorkflow($we_doc))) ?  "( _EditorFrame.getEditorMakeSameDoc() ? 1 : 0 )" : "0" ) . ",arguments[5] ? arguments[5] : '',arguments[6] ? arguments[6] : '',arguments[7] ? arguments[7] : '');
				return;
";
	if( isset($we_doc->IsClassFolder) ){
		$_js_we_cmd .= "
			case \"obj_search\":
				top.we_cmd(\"obj_search\",'" . $we_transaction . "',document.we_form.obj_search.value,document.we_form.obj_searchField[document.we_form.obj_searchField.selectedIndex].value);
				return;
";
	}

	$_js_we_cmd .= "
		}";
}

$_js_we_cmd .= "
		var args = '';
		for(var i = 0; i < arguments.length; i++) {
			args += 'arguments['+i+']' + ( (i < (arguments.length-1)) ? ',' : '');
		}
		eval('top.we_cmd('+args+')');
	}
";

$_js_we_submitForm = "

	function we_submitForm(target, url){

		var f = self.document.we_form;
		f.target = target;
		f.action = url;
		f.method = 'post';
		f.submit();
	}
";
//	########################	build complete JS-Source #########################################################
$_js_code = "
<!--
var _EditorFrame = top.weEditorFrameController.getEditorFrameByTransaction(\"" . $we_transaction ."\");

$_js_we_save_document
$_js_workflow_functions
$_js_weCanSave
$_js_toggleBusy
$_js_we_cmd
$_js_we_submitForm
//-->
";

//	########################	print javascript src	#########################################################
print we_htmlElement::jsElement($_js_code);
print we_htmlElement::jsElement("", array("src" => JS_DIR . "windows.js"));
print STYLESHEET;

?>
</head>

<?php
//	Document is in workflow
if(inWorkflow($we_doc)) {
	include(WE_WORKFLOW_MODULE_DIR . "we_workflow_doc_footer.inc.php");
	exit();
}

	$we_button = new we_button();

   /**
	* @return void
	* @desc Prints the footer for the normal mode
 	*/
	function showEditFooterForNormalMode() {

		global $we_doc, $we_transaction, $l_global, $haspermNew, $showPubl, $we_button;

		$_normalTable = new we_htmlTable(	array(	"cellpadding" => 0,
													"cellspacing" => 0,
													"border"      => 0),
												1,
												1);
		$_pos = 0;
		$_normalTable->setColContent(0, $_pos++, getPixel(10,20));

		if($we_doc->ID) {
			if($we_doc->ContentType == "text/weTmpl") {
				$_normalTable->addCol(2);
				$_normalTable->setColContent(0, $_pos++, $we_button->create_button("make_new_document", "javascript:top.we_cmd('new','".FILE_TABLE."','','text/webedition','','".$we_doc->ID."');_EditorFrame.setEditorMakeNewDoc(false);"));
				$_normalTable->setColContent(0, $_pos++, getPixel(10,20));
			} elseif($we_doc->ContentType == "object") {
				$_normalTable->addCol(2);
				$_normalTable->setColContent(0, $_pos++, $we_button->create_button("make_new_object", "javascript:top.we_cmd('new','".OBJECT_FILES_TABLE."','','objectFile','".$we_doc->ID."');_EditorFrame.setEditorMakeNewDoc(false);"));
				$_normalTable->setColContent(0, $_pos++, getPixel(10,20));
			}
		}

		if(defined("WORKFLOW_TABLE") && $we_doc->IsTextContentDoc && $we_doc->ID) {

			//	Workflow button
			$_ctrlElem = getControlElement('button', 'workflow');	//	look tag we:controlElement for details

			if( !$_ctrlElem || !$_ctrlElem['hide'] ){
				$_normalTable->addCol(2);
				$_normalTable->setColContent(0, $_pos++, $we_button->create_button("in_workflow", "javascript:put_in_workflow();"));
				$_normalTable->setColContent(0, $_pos++, getPixel(10,20));
			}
		}

		if($showPubl && $we_doc->ID && $we_doc->Published) {

			//	Park button
			$_ctrlElem = getControlElement('button', 'unpublish');	//	look tag we:controlElement for details

			if( !$_ctrlElem || !$_ctrlElem['hide'] ){
				$_normalTable->addCol(2);
				$_normalTable->setColContent(0, $_pos++, $we_button->create_button("unpublish", "javascript:we_cmd('unpublish', '" . $we_transaction . "');"));
				$_normalTable->setColContent(0, $_pos++, getPixel(10,20));
			}
		}

		if($we_doc->ContentType != "text/webedition" && $we_doc->ContentType != "object" && $we_doc->ContentType != "objectFile" && $we_doc->ContentType != "folder") {

			$_edit_source = '<script language="JavaScript" type="text/javascript">
					function editSource(){
						if(top.plugin.editSource){
							top.plugin.editSource("'.$we_doc->Path.'","'.$we_doc->ContentType.'");
						}
						else{
							we_cmd("initPlugin","top.plugin.editSource(\''.$we_doc->Path.'\',\''.$we_doc->ContentType.'\')");
						}
					}
					function editFile(){
						if(top.plugin.editFile){
							top.plugin.editFile();
						}
						else{
							we_cmd("initPlugin","top.plugin.editFile();");
						}
					}
				</script>
			';


			$_normalTable->addCol(2);

			if(eregi('text/',$we_doc->ContentType)) {
				$_normalTable->setColContent(0, $_pos++, $we_button->create_button("startEditor", "javascript:editSource();"));
			} else {
				$_normalTable->setColContent(0, $_pos++, $we_button->create_button("startEditor", "javascript:editFile();"));
			}

			$_normalTable->setColContent(0, $_pos++, $_edit_source . getPixel(10,20));

		}

		//	Save Button
		$_ctrlElem = getControlElement('button', 'save');	//	look tag we:controlElement for details
		if( !$_ctrlElem || !$_ctrlElem['hide'] ){

			// show save button also for class_folder, if customer_filters are defined
			if ( isset($we_doc->IsClassFolder) && $we_doc->IsClassFolder ) {

				if (defined("CUSTOMER_TABLE")) {
					$_normalTable->addCol(2);
					$_normalTable->setColContent(0, $_pos++, $we_button->create_button("save", "javascript:_EditorFrame.setEditorPublishWhenSave(false);we_save_document();"));
					$_normalTable->setColContent(0, $_pos++, getPixel(10,20));

				}

			} else {
				$_normalTable->addCol(2);
				$_normalTable->setColContent(0, $_pos++, $we_button->create_button("save", "javascript:_EditorFrame.setEditorPublishWhenSave(false);we_save_document();"));
				$_normalTable->setColContent(0, $_pos++, getPixel(10,20));

			}

		}

		if($we_doc->ContentType == "text/weTmpl") {

			$_normalTable->addCol(2);
			$_normalTable->setColContent(0, $_pos++, we_forms::checkbox("autoRebuild", false, "autoRebuild", $l_global["we_rebuild_at_save"], false, "defaultfont", " _EditorFrame.setEditorAutoRebuild( (this.checked) ? true : false );"));
			$_normalTable->setColContent(0, $_pos++, getPixel(10,20));

		} else if($showPubl) {

			$_ctrlElem = getControlElement('button','publish');

			if( !$_ctrlElem || !$_ctrlElem['hide'] ){

				$_normalTable->addCol(2);
				$_normalTable->setColContent(0, $_pos++, $we_button->create_button("publish", "javascript:_EditorFrame.setEditorPublishWhenSave(true);we_save_document();"));
				$_normalTable->setColContent(0, $_pos++, getPixel(10,20));
			}
		}

		if($we_doc->IsTextContentDoc && $haspermNew) {

			$_ctrlElem = getControlElement('checkbox','makeSameDoc');

			if( !$_ctrlElem || !$_ctrlElem['hide'] ){

				$_normalTable->addCol(2);
				$_normalTable->setCol(0, $_pos++, ( ($_ctrlElem && $_ctrlElem['hide'] ) ? ( array('style' => 'display:none') ) : array('style' => 'display:block') ) , we_forms::checkbox("makeSameDoc", ( $_ctrlElem ? $_ctrlElem['checked'] : false ), "makeSameDoc", $l_global["we_make_same"][$we_doc->ContentType], false, "defaultfont", " _EditorFrame.setEditorMakeSameDoc( (this.checked) ? true : false );", ( $_ctrlElem ? $_ctrlElem['readonly'] : false ) ));
				$_normalTable->setColContent(0, $_pos++, getPixel(10,20));
			}
		}

		if($we_doc->ContentType == "text/weTmpl") {
            if(we_hasPerm("NEW_WEBEDITIONSITE") || we_hasPerm("ADMINISTRATOR")) {
				$_normalTable->addCol(2);
				$_normalTable->setColContent(0, $_pos++, we_forms::checkbox("makeNewDoc", false, "makeNewDoc", $GLOBALS["l_global"]["we_new_doc_after_save"], false, "defaultfont", "_EditorFrame.setEditorMakeNewDoc( (this.checked) ? true : false );"));
				$_normalTable->setColContent(0, $_pos++, getPixel(10,20));
            }
		} else if($we_doc->ContentType == "object") {
            if(we_hasPerm("NEW_OBJECTFILE") || we_hasPerm("ADMINISTRATOR")) {
				$_normalTable->addCol(2);
				$_normalTable->setColContent(0, $_pos++, we_forms::checkbox("makeNewDoc", false, "makeNewDoc", $GLOBALS["l_object"]["we_new_doc_after_save"], false, "defaultfont", "_EditorFrame.setEditorMakeNewDoc( (this.checked) ? true : false );"));
				$_normalTable->setColContent(0, $_pos++, getPixel(10,20));
            }
		}

		print $_normalTable->getHtmlCode();
	}

   /**
	* @return void
	* @desc prints the footer for the See-Mode
 	*/
	function showEditFooterForSEEMMode() {
		global $we_doc, $we_transaction, $l_global, $haspermNew, $showPubl, $we_button, $l_alert, $_we_active_modules;

		$_seeModeTable = new we_htmlTable(	array(	"cellpadding" => 0,
													"cellspacing" => 0,
													"border"      => 0),
											1,
											1);
		$_pos = 0;
		$_seeModeTable->setColContent(0, $_pos++, getPixel(10,20));

		//##############################	First buttons which are always needed
		//	Always button preview
		if ( in_array(WE_EDITPAGE_PREVIEW, $GLOBALS['we_doc']->EditPageNrs) && $GLOBALS['we_doc']->EditPageNr != WE_EDITPAGE_PREVIEW){	// first button is always - preview, when exists

			$_seeModeTable->addCol(2);
			$_seeModeTable->setCol(0, $_pos++, array("valign" => "top"), $we_button->create_button("preview", "javascript:parent.editHeader.we_cmd('switch_edit_page', " . WE_EDITPAGE_PREVIEW . ",'" . $GLOBALS["we_transaction"] . "');"));
			$_seeModeTable->setColContent(0, $_pos++, getPixel(10,20));
		}

		// shop variants
		if (defined('SHOP_TABLE')) {

			if ($GLOBALS['we_doc']->EditPageNr == WE_EDITPAGE_CONTENT && in_array(WE_EDITPAGE_VARIANTS, $GLOBALS['we_doc']->EditPageNrs) && $GLOBALS['we_doc']->canHaveVariants(true) && $GLOBALS['we_doc']->EditPageNr != WE_EDITPAGE_VARIANTS){	// first button is always - preview, when exists

				$_seeModeTable->addCol(2);
				$_seeModeTable->setCol(0, $_pos++, array("valign" => "top"), $we_button->create_button("shopVariants", "javascript:parent.editHeader.we_cmd('switch_edit_page', " . WE_EDITPAGE_VARIANTS . ",'" . $GLOBALS["we_transaction"] . "');"));
				$_seeModeTable->setColContent(0, $_pos++, getPixel(10,20));
			}
		}


		//	image-documents have no preview but thumbnailview instead ...
		if( (!defined("ISP_VERSION") || !ISP_VERSION) && $GLOBALS['we_doc']->EditPageNr != WE_EDITPAGE_THUMBNAILS && in_array(WE_EDITPAGE_THUMBNAILS, $GLOBALS['we_doc']->EditPageNrs)){

			$_seeModeTable->addCol(2);
			$_seeModeTable->setCol(0, $_pos++, array("valign" => "top"), $we_button->create_button("thumbnails", "javascript:parent.editHeader.we_cmd('switch_edit_page', " . WE_EDITPAGE_THUMBNAILS . ",'" . $GLOBALS["we_transaction"] . "');"));
			$_seeModeTable->setColContent(0, $_pos++, getPixel(10,20));
		}

		//	Button edit !!!
		if ($GLOBALS['we_doc']->EditPageNr != WE_EDITPAGE_CONTENT && in_array(WE_EDITPAGE_CONTENT, $GLOBALS['we_doc']->EditPageNrs)){	// then button "edit"


			$_seeModeTable->addCol(2);
			$_seeModeTable->setCol(0, $_pos++, array("valign" => "top"), $we_button->create_button("edit", "javascript:parent.editHeader.we_cmd('switch_edit_page', " . WE_EDITPAGE_CONTENT . ", '" . $GLOBALS["we_transaction"] . "');"));
			$_seeModeTable->setColContent(0, $_pos++, getPixel(10,20));

		}
		//	Button properties
		if ( in_array(WE_EDITPAGE_PROPERTIES, $GLOBALS['we_doc']->EditPageNrs) && ($GLOBALS['we_doc']->EditPageNr == WE_EDITPAGE_CONTENT || $GLOBALS['we_doc']->EditPageNr == WE_EDITPAGE_SCHEDULER) ){
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/permissionhandler/"."permissionhandler.class.php");
			if (permissionhandler::isUserAllowedForAction("switch_edit_page","WE_EDITPAGE_PROPERTIES")) {
				$_seeModeTable->addCol(2);
				$_seeModeTable->setCol(0, $_pos++, array("valign" => "top"), $we_button->create_button("properties", "javascript:parent.editHeader.we_cmd('switch_edit_page', " . WE_EDITPAGE_PROPERTIES . ", '" . $GLOBALS["we_transaction"] . "');"));
				$_seeModeTable->setColContent(0, $_pos++, getPixel(10,20));
			}
		}

		// Button workspace
		if ( in_array(WE_EDITPAGE_WORKSPACE, $GLOBALS['we_doc']->EditPageNrs) && ($GLOBALS['we_doc']->EditPageNr == WE_EDITPAGE_CONTENT || $GLOBALS['we_doc']->EditPageNr == WE_EDITPAGE_PROPERTIES) ){

			$_seeModeTable->addCol(2);
			$_seeModeTable->setCol(0, $_pos++, array("valign" => "top"), $we_button->create_button("workspace_button", "javascript:parent.editHeader.we_cmd('switch_edit_page', " . WE_EDITPAGE_WORKSPACE . ", '" . $GLOBALS["we_transaction"] . "');"));
			$_seeModeTable->setColContent(0, $_pos++, getPixel(10,20));
		}


		//	Button scheduler
		if ( in_array(WE_EDITPAGE_SCHEDULER, $GLOBALS['we_doc']->EditPageNrs) && ($GLOBALS['we_doc']->EditPageNr == WE_EDITPAGE_CONTENT || $GLOBALS['we_doc']->EditPageNr == WE_EDITPAGE_PROPERTIES) ){
			if(defined("SCHEDULE_TABLE") && we_hasPerm( "CAN_SEE_SCHEDULER" )){
				$_seeModeTable->addCol(2);
				$_seeModeTable->setCol(0, $_pos++, array("valign" => "top"), $we_button->create_button("schedule_button", "javascript:parent.editHeader.we_cmd('switch_edit_page', " . WE_EDITPAGE_SCHEDULER . ", '" . $GLOBALS["we_transaction"] . "');"));
				$_seeModeTable->setColContent(0, $_pos++, getPixel(10,20));
			}
		}

		//	Button put in workflow
		if ( $GLOBALS['we_doc']->EditPageNr != WE_EDITPAGE_PROPERTIES && $GLOBALS['we_doc']->EditPageNr != WE_EDITPAGE_SCHEDULER){	// then button "workflow"
			if (defined("WORKFLOW_TABLE") && $we_doc->IsTextContentDoc && $we_doc->ID){

				$_ctrlElem = getControlElement('button', 'workflow');	//	look tag we:controlElement for details

				if( !$_ctrlElem || !$_ctrlElem['hide'] ){
					$_seeModeTable->addCol(2);
					$_seeModeTable->setCol(0, $_pos++, array("valign" => "top"), $we_button->create_button("in_workflow", "javascript:put_in_workflow();"));
					$_seeModeTable->setColContent(0, $_pos++, getPixel(10,20));
				}
			}
		}

		//###########################	Special buttons for special EDITPAGE
		//
		//	1. ONLY in PROPERTY page we need the button unpublish
		//
		if($GLOBALS['we_doc']->EditPageNr == WE_EDITPAGE_PROPERTIES && $showPubl && $we_doc->ID && $we_doc->Published){

			//	button unpublish
			$_ctrlElem = getControlElement('button', 'unpublish');	//	look tag we:controlElement for details
			if( !$_ctrlElem || !$_ctrlElem['hide'] ){
				$_seeModeTable->addCol(2);
				$_seeModeTable->setCol(0, $_pos++, array("valign" => "top"), $we_button->create_button("unpublish", "javascript:we_cmd('unpublish', '" . $we_transaction . "');"));
				$_seeModeTable->setColContent(0, $_pos++, getPixel(10,20));
			}
		}

		//
		//	2. we always need the buttons -> save and publish
		//
		$_ctrlElem = getControlElement('button', 'save');	//	look tag we:controlElement for details
		if( !$_ctrlElem || !$_ctrlElem['hide'] ){

			$_seeModeTable->addCol(2);
			$_seeModeTable->setCol(0, $_pos++, array("valign" => "top"), $we_button->create_button("save", "javascript:_EditorFrame.setEditorPublishWhenSave(false);we_save_document();"));
			$_seeModeTable->setColContent(0, $_pos++, getPixel(10,20));
		}


		//
		// 3. public when save and make same doc new.
		//
			$showPubl_makeSamNew = '';
			if ($showPubl) {

				$_ctrlElem = getControlElement('button', 'publish');	//	look tag we:controlElement for details

				if (!($_ctrlElem && $_ctrlElem['hide'])) {

					$_seeModeTable->addCol(2);
					$_seeModeTable->setCol(0, $_pos++, array("valign" => "top"), $we_button->create_button("publish", "javascript:_EditorFrame.setEditorPublishWhenSave(true);we_save_document();"));
					$_seeModeTable->setColContent(0, $_pos++, getPixel(10,20));
				}
			}

			if($GLOBALS['we_doc']->EditPageNr == WE_EDITPAGE_CONTENT || $GLOBALS['we_doc']->EditPageNr == WE_EDITPAGE_PREVIEW || $GLOBALS['we_doc']->EditPageNr == WE_EDITPAGE_THUMBNAILS ){

				if ($we_doc->IsTextContentDoc && $haspermNew) {

					//	makesamedoc only when not in edit_include-window
					$_ctrlElem = getControlElement('checkbox','makeSameDoc');

					if ($_ctrlElem && $_ctrlElem['hide'] ) {
						$showPubl_makeSamNew .= '<div style="display: hidden;">';
					}

					$showPubl_makeSamNew .= '<script language="JavaScript" type="text/javascript">
								<!--
								if(!top.opener || !top.opener.win){
									document.writeln("<!--");
								}
							//-->
							</script>' .
							we_forms::checkbox("makeSameDoc", ( $_ctrlElem ? $_ctrlElem['checked'] : false ), "makeSameDoc", $l_global["we_make_same"][$we_doc->ContentType], false, "defaultfont", " _EditorFrame.setEditorMakeSameDoc( (this.checked) ? true : false );", ( $_ctrlElem ? $_ctrlElem['readonly'] : false ))
							.
						'<script language="JavaScript" type="text/javascript">
								<!--
								if(!top.opener || !top.opener.win){
									document.writeln(\'-\' + \'-\' + \'>\');
								}
							//--></script>';
					if ($_ctrlElem && $_ctrlElem['hide'] ) {
						$showPubl_makeSamNew .= '</div>';
					}
				}
			}

			if ($showPubl_makeSamNew) {

				$_seeModeTable->addCol(2);
				$_seeModeTable->setCol(0, $_pos++, array("valign" => "top"), $showPubl_makeSamNew);
				$_seeModeTable->setColContent(0, $_pos++, getPixel(10,20));
			}

		//
		//	4. show delete button to delete this document, not in edit_include-window
		//
		$canDelete = ( (!isset($_REQUEST['SEEM_edit_include']) || $_REQUEST['SEEM_edit_include'] == 'false') && (($we_doc->ClassName == "we_objectFile") ? we_hasPerm("DELETE_OBJECTFILE") : we_hasPerm("DELETE_DOCUMENT")));
		if( $canDelete){
			$_ctrlElem = getControlElement('button', 'delete');	//	look tag we:controlElement for details
			if( !$_ctrlElem || !$_ctrlElem['hide'] ){
				$_seeModeTable->addCol(2);

				$_seeModeTable->setColContent(0, $_pos++, getPixel(10,20));
				$_seeModeTable->setCol(0, $_pos++, array('valign' => 'top'), $we_button->create_button("image:btn_function_trash", "javascript:if(confirm('" . $l_alert['delete_single']['confirm_delete'] . "')){we_cmd('delete_single_document','','" . $we_doc->Table . "','1');}"));
			}
		}
		print $_seeModeTable->getHtmlCode();
	}

?>

<body bgcolor="#f0f0f0"  background="<?php print EDIT_IMAGE_DIR ?>editfooterback.gif" marginwidth="0" marginheight="10" leftmargin="0" topmargin="10">
	<form name="we_form"<?php if(isset($we_doc->IsClassFolder) && $we_doc->IsClassFolder){ ?> onSubmit="sub();return false;"<?php } ?>>
	<input type="hidden" name="sel" value="<?php print $we_doc->ID; ?>">
		<?php
		$_SESSION['seemForOpenDelSelector']['ID'] = $we_doc->ID;
		$_SESSION['seemForOpenDelSelector']['Table'] = $we_doc->Table;
		
				if($we_doc->userCanSave()){

					if($_SESSION["we_mode"] == "normal"){		// open footer for NormalMode

						showEditFooterForNormalMode();

					} else if ($_SESSION["we_mode"] == "seem"){	// open footer for SeeMode

						showEditFooterForSEEMMode();
					}
				} else {

					if ($_SESSION["we_mode"] == "seem"){

						$_noPermTable = new we_htmlTable(	array(	"cellpadding" => 0,
																	"cellspacing" => 0,
																	"border"      => 0),
															1,
															4);

						$_noPermTable->setColContent( 0, 0, getPixel(20,2));
						$_noPermTable->setColContent( 0, 1, we_htmlElement::htmlImg(array("src" => IMAGE_DIR . "alert.gif")));
						$_noPermTable->setColContent( 0, 2, getPixel(10,2));
						$_noPermTable->setColContent( 0, 3, $GLOBALS["l_we_SEEM"]["no_permission_to_edit_document"]);


						print $_noPermTable->getHtmlCode();

					}

				}
			?>
	</form>
	<?php
	$_js_tmpl = "";
	$_js_publish = "";
	$_js_permnew = "";

	if($we_doc->ContentType == "text/weTmpl"){	// a template

		$_js_tmpl = "
		if( _EditorFrame.getEditorAutoRebuild() ) {
			self.document.we_form.autoRebuild.checked = true;
		}
		else {
			self.document.we_form.autoRebuild.checked = false;
		}
		if( _EditorFrame.getEditorMakeNewDoc() ) {
			self.document.we_form.makeNewDoc.checked = true;
		}
		else {
			self.document.we_form.makeNewDoc.checked = false;
		}
		";
	}

	if($we_doc->IsTextContentDoc && $haspermNew){	//	$_js_permnew

		if($_SESSION["we_mode"] != "seem" || $GLOBALS['we_doc']->EditPageNr == WE_EDITPAGE_CONTENT){	// not in SeeMode or in editmode

			$_ctrlElem = getControlElement('checkbox','makeSameDoc');
			if( !$_ctrlElem ){	//	changes for we:controlElement

				if($we_doc->ID){
					$_js_permnew = "
			if(self.document.we_form && self.document.we_form.makeSameDoc){
				self.document.we_form.makeSameDoc.checked = false;
			}
			";
				} else {
					$_js_permnew = "
			if( _EditorFrame.getEditorMakeSameDoc() ) {
				if(self.document.we_form && self.document.we_form.makeSameDoc){
					self.document.we_form.makeSameDoc.checked = true;
				}
			} else {
				if(self.document.we_form && self.document.we_form.makeSameDoc){
					self.document.we_form.makeSameDoc.checked = false;
				}
			}
			";
				}
			} else {	//	$_ctrlElement determines values
				if($we_doc->ID){
					$_js_permnew = "
			if(self.document.we_form && self.document.we_form.makeSameDoc){
				self.document.we_form.makeSameDoc.checked = " . ($_ctrlElem["checked"] ? "true" : "false") . ";
				_EditorFrame.setEditorMakeSameDoc(" . $_ctrlElem["checked"] ? "true" : "false" . ");
			}
			";
				} else {
					$_js_permnew = "
				if(self.document.we_form && self.document.we_form.makeSameDoc){
					self.document.we_form.makeSameDoc.checked = " . ($_ctrlElem["checked"] ? "true" : "false") . ";
					_EditorFrame.setEditorMakeSameDoc(" . $_ctrlElem["checked"] ? "true" : "false" . ");
				}
			";
				}
			}
		}
	}

	$_js_code_bottom = "
	<!--
	$_js_tmpl
	$_js_publish
	$_js_permnew
	//-->
	";

	print we_htmlElement::jsElement($_js_code_bottom);

?>
</body>
</html>