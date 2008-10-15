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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."we_document.inc.php");
if(!isset($GLOBALS["WE_IS_DYN"])){
	include_once(WE_USERS_MODULE_DIR . "we_users_util.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."we_temporaryDocument.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/object.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/thumbnails.inc.php");
}
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/date.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/cache/weCacheHelper.class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/object/we_class_folder.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/we_thumbnail.class.php");

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_versions/weVersions.class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_hook/class/weHook.class.php");

/* a class for handling templates */
class we_objectFile extends we_document
{
	//######################################################################################################################################################
	//##################################################################### Variables ######################################################################
	//######################################################################################################################################################

	/* Name of the class => important for reconstructing the class from outside the class */
	var $ClassName="we_objectFile";

	/* Icon which is shown at the tree-menue  */
	var $Icon="objectFile.gif";
	var $Published=0;
	var $TableID = 0;
	var $ObjectID = 0;
	var $Category = "";
	var $Table=OBJECT_FILES_TABLE;
	var $rootDirID = 0;
	var $RootDirPath="/";
	var $Workspaces = "";
	var $ExtraWorkspaces = "";
	var $ExtraWorkspacesSelected = "";
	var $AllowedWorkspaces = array();
	var $AllowedClasses = "";
	var $CSS = "";
	var $IsSearchable;
	var $Charset;
	var $Language;

	var $EditPageNrs = array(WE_EDITPAGE_PROPERTIES,WE_EDITPAGE_INFO,WE_EDITPAGE_CONTENT,WE_EDITPAGE_WORKSPACE, WE_EDITPAGE_PREVIEW, WE_EDITPAGE_VARIANTS);

	var $InWebEdition = false;
	var $Templates = "";
	var $ExtraTemplates = "";
	var $DefArray = array();

	var $PublWhenSave = 0;
	var $ContentType = "objectFile";

	var $IsTextContentDoc = true;

	var $documentCustomerFilter = ""; // DON'T SET TO NULL !!!!


	//######################################################################################################################################################
	//##################################################################### FUNCTIONS ######################################################################
	//######################################################################################################################################################


	//##################################################################### INIT FUNCTIONS ######################################################################

	/* Constructor */
	function we_objectFile()
	{
		$this->we_document();
		array_push($this->persistent_slots,"CSS","DefArray","Text","AllowedClasses","Templates","ExtraTemplates","Workspaces","ExtraWorkspaces","ExtraWorkspacesSelected","RootDirPath","rootDirID","TableID","ObjectID","Category","IsSearchable","Charset","Language");
		if(defined("SCHEDULE_TABLE")){
			array_push($this->persistent_slots,"FromOk","ToOk","From","To");
		}
		array_push($this->EditPageNrs,WE_EDITPAGE_SCHEDULER);
		if(!isset($GLOBALS["WE_IS_DYN"])){
			$ac = $this->getAllowedClasses();
			$this->AllowedClasses = makeCSVFromArray($ac);
		}
		if (defined("CUSTOMER_TABLE")) {
			array_push($this->EditPageNrs, WE_EDITPAGE_WEBUSER);
		}
		array_push($this->EditPageNrs, WE_EDITPAGE_VERSIONS);
	}

	function makeSameNew(){
		$Category = $this->Category;
		$TableID = $this->TableID;
		$rootDirID = $this->rootDirID;
		$RootDirPath = $this->RootDirPath;
		$Workspaces = $this->Workspaces;
		$ExtraWorkspaces = $this->ExtraWorkspaces;
		$ExtraWorkspacesSelected = $this->ExtraWorkspacesSelected;
		$IsSearchable = $this->IsSearchable;
		$Charset = $this->Charset;
		we_root::makeSameNew();
		$this->Category = $Category;
		$this->TableID = $TableID;
		$this->rootDirID = $rootDirID;
		$this->RootDirPath = $RootDirPath;
		$this->DefaultInit=false;

		$this->i_objectFileInit(true);

		$this->Workspaces = $Workspaces;
		$this->ExtraWorkspaces = $ExtraWorkspaces;
		$this->ExtraWorkspacesSelected = $ExtraWorkspacesSelected;
		$this->IsSearchable = $IsSearchable;
		$this->Charset = $Charset;
	}

	function formCopyDocument(){

		$we_button = new we_button();
		$idname = 'we_'.$this->Name.'_CopyID';
		$rootDirId = getObjectRootPathOfObjectWorkspace($this->RootDirPath, $this->rootDirID);
		$but = $we_button->create_button("select", "javascript:we_cmd('openDocselector',document.forms[0].elements['$idname'].value,'".$this->Table."','document.forms[\\'we_form\\'].elements[\\'$idname\\'].value','','opener._EditorFrame.setEditorIsHot(true);opener.top.we_cmd(\\'copyDocument\\',currentID);','".session_id()."','".$rootDirId."','".$this->ContentType."');");
		$content = $this->htmlHidden($idname,$this->CopyID).$but;
		return $content;

	}

	function formLanguage() {

		we_loadLanguageConfig();
		
		$value = (isset($this->Language) ? $this->Language : $GLOBALS['weDefaultFrontendLanguage']);

		$inputName = "we_".$this->Name."_Language";

		$_languages = $GLOBALS['weFrontendLanguages'];

		$content = '
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						' . $this->htmlSelect($inputName, $_languages, 1, $value, false, " onblur=\"_EditorFrame.setEditorIsHot(true);\" onchange=\"_EditorFrame.setEditorIsHot(true);\"", "value", 508) . '</td>
				</tr>
			</table>';
		return $content;

	}

	function copyDoc($id){
		if($id){
			$doc = new we_objectFile();
			$doc->InitByID($id,$this->Table, LOAD_TEMP_DB);
			$doc->setRootDirID(true);
			if($this->ID==0){
				for($i=0;$i<sizeof($this->persistent_slots);$i++){
					eval('$this->'.$this->persistent_slots[$i].'= isset($doc->'.$this->persistent_slots[$i].') ? $doc->'.$this->persistent_slots[$i].' : "";');
				}
				$this->ObjectID=0;
				$this->CreationDate=time();
				$this->CreatorID=$_SESSION["user"]["ID"];
				$this->DefaultInit = true;
				$this->rootDirID=$doc->rootDirID;
				$this->RootDirPath=$doc->RootDirPath;
				$this->ID=0;
				$this->OldPath="";
				$this->Published=0;
				$this->Text .= "_copy";
				$this->Path=$this->ParentPath.$this->Text;
				$this->OldPath=$this->Path;
			}
			$this->elements = $doc->elements;
			foreach($this->elements as $n=>$e){
				$this->elements[$n]["cid"] = 0;
			}
			$this->EditPageNr=0;
			$this->Category = $doc->Category;
			$this->documentCustomerFilter = $doc->documentCustomerFilter;
		}
	}

	function restoreWorkspaces(){
		if (!$this->TableID) {  // WORKARROUND for bug 4631
			$ac = makeCSVFromArray(getAllowedClasses($this->DB_WE));
			$this->TableID = count($ac) ? $ac[0] : 0;
		}
		$ws = get_ws();
		$foo = getHash("SELECT Workspaces,DefaultWorkspaces,Templates FROM " .OBJECT_TABLE . " WHERE ID='".$this->TableID."'",$this->DB_WE);
		$def_ws = isset($foo["DefaultWorkspaces"]) ? $foo["DefaultWorkspaces"] : "";
		$owsCSV = isset($foo["Workspaces"]) ? $foo["Workspaces"] : "";
		$otmplsCSV = isset($foo["Templates"]) ? $foo["Templates"] : "";
		$owsCSVArray = makeArrayFromCSV($owsCSV);
		$defwsCSVArray = makeArrayFromCSV($def_ws);
		$otmplsCSVArray = makeArrayFromCSV($otmplsCSV);
		$this->Workspaces = "";
		$this->Templates = "";
		$this->ExtraWorkspaces = "";
		$this->ExtraTemplates = "";
		$processedWs = array();

		// loop throgh all default workspaces
		foreach($defwsCSVArray as $_defWs){
			// loop through each object workspace
			foreach($owsCSVArray as $i=>$ows){
				if((!in_array($_defWs,$processedWs)) && in_workspace($_defWs,$ows,FILE_TABLE,$this->DB_WE)){ // if default workspace is within object workspace
					$processedWs = array($_defWs);
					$this->Workspaces .= $_defWs.",";
					$this->Templates .= $otmplsCSVArray[$i].",";
				}
			}

		}
		unset($processedWs);

		/*
		foreach($owsCSVArray as $i=>$ows){
			if($def_ws && in_workspace($def_ws,$ows,FILE_TABLE,$this->DB_WE)){
				$this->Workspaces .= $def_ws.",";
				$this->Templates .= $otmplsCSVArray[$i].",";
			}

		}*/
		// not sure if this is needed
		/*
		if(!$this->Workspaces){
			foreach($owsCSVArray as $i=>$ows){
				if(abs($ws) == 0 || in_workspace($ows,$ws,FILE_TABLE,$this->DB_WE)){
					$this->Workspaces .= $owsCSVArray[$i].",";
					$this->Templates .= $otmplsCSVArray[$i].",";
					break;
				}

			}
		}
		*/

		if($this->Workspaces) $this->Workspaces = ",".$this->Workspaces;
		if($this->Templates) $this->Templates = ",".$this->Templates;

	}

	function setRootDirID($doit=false){
		if($this->InWebEdition || $doit){
			$foo = f("SELECT Path FROM " .OBJECT_TABLE . " WHERE ID=".$this->TableID,"Path",$this->DB_WE);
			$folder = new we_folder();
			$folderID = f("SELECT ID FROM " .OBJECT_FILES_TABLE . " WHERE Path='".$foo."'","ID",$this->DB_WE);
			$this->RootDirPath = $foo;
			$this->rootDirID = $folderID;
		}
	}

	function resetParentID(){
		$len = strlen($this->RootDirPath."/");
		if(substr($this->ParentPath."/",0,$len) != substr($this->RootDirPath."/",0,$len)){
			$this->setParentID($this->rootDirID);
		}
		// adjust to bug #376 regarding workspace
		$workspaceRootDirId = getObjectRootPathOfObjectWorkspace($this->RootDirPath, $this->rootDirID);
		$this->ParentPath = id_to_path($workspaceRootDirId, OBJECT_FILES_TABLE);
		$this->ParentID = $workspaceRootDirId;
	}

	function restoreDefaults(){
		$this->DefaultInit = true;
		$this->Owners = "";
		$this->OwnersReadOnly = "";
		$this->RestrictOwners = "";
		$this->Category = "";
		$this->Text = "";
		$this->IsSearchable = 1;
		$this->Charset = '';
		$this->restoreWorkspaces();
		$this->elements = array();
		$this->DB_WE->query("SELECT Users,UsersReadOnly,RestrictUsers,DefaultCategory,DefaultText,DefaultValues FROM " .OBJECT_TABLE . " WHERE ID='".$this->TableID."'");
		if($this->DB_WE->next_record()){
			// fix - the class access permissions should not be applied
			/*if($this->DB_WE->f("Users")){
				$this->Owners = $this->DB_WE->f("Users");
			}
			if($this->DB_WE->f("UsersReadOnly")){
				$this->OwnersReadOnly = $this->DB_WE->f("UsersReadOnly");
			}
			if($this->DB_WE->f("RestrictUsers")){
				$this->RestrictOwners = $this->DB_WE->f("RestrictUsers");
			}*/

			if($this->DB_WE->f("DefaultCategory")){
				$this->Category = $this->DB_WE->f("DefaultCategory");
			}
			if($this->DB_WE->f("DefaultText")){
				$text = $this->DB_WE->f("DefaultText");
				if(ereg('%unique([^%]*)%',$text,$regs)){
					if(!$regs[1]){
						$anz = 16;
					}else{
						$anz = abs($regs[1]);
					}
					$unique = substr(md5(uniqid(rand(),1)),0,min($anz,32));
					$text = ereg_replace('%unique[^%]*%',$unique,$text);
				}
				if(ereg('%ID%',$text)){
					$id = 1 + abs(f("SELECT max(ID) as ID FROM " . OBJECT_FILES_TABLE ,"ID",new DB_WE()));
					$text = ereg_replace('%ID%',"".$id,$text);
				}
				if(ereg('%d%',$text,$regs)){
					$text = ereg_replace('%d%',date("d"),$text);
				}
				if(ereg('%m%',$text,$regs)){
					$text = ereg_replace('%m%',date("m"),$text);
				}
				if(ereg('%y%',$text,$regs)){
					$text = ereg_replace('%y%',date("y"),$text);
				}
				if(ereg('%Y%',$text,$regs)){
					$text = ereg_replace('%Y%',date("Y"),$text);
				}
				if(ereg('%n%',$text,$regs)){
					$text = ereg_replace('%n%',date("n"),$text);
				}
				if(ereg('%h%',$text,$regs)){
					$text = ereg_replace('%h%',date("h"),$text);
				}
				$this->Text=$text;
			}

			if($this->DB_WE->f("DefaultValues")){
				$vals = unserialize($this->DB_WE->f("DefaultValues"));
				if(isset($vals["WE_CSS_FOR_CLASS"])){
					$this->CSS = $vals["WE_CSS_FOR_CLASS"];
				}
				if(is_array($vals)){
					foreach($vals as $name=>$field){
						if(is_array($field)){
							$foo = explode("_",$name);
							$type = $foo[0];
							unset($foo[0]);
							$name = implode("_", $foo);
							if($type == "object") {
								$n = "we_object_".$name;
							} elseif(isset($name)) {
								$n = $name;
							} else {
								$n = "";
							}
							$this->setElement($n,isset($field["default"]) ? $field["default"] : "",$type,0,(isset($field["autobr"]) && $field["autobr"]=="on") ? "on" : "off");
							if($type == "multiobject") {
								$temp = array(
									'class' => $field['class'],
									'max' => $field['max'],
									'objects' => array(),
								);
								if(is_array($field['meta'])) {
									foreach($field['meta'] as $key => $val) {
										array_push($temp['objects'], $val);
									}
								}
								$this->setElement($name, serialize($temp));
							}
						}
					}
				}
			}

		}
		$this->setTypeAndLength();

	}


	function i_check_requiredFields(){
		foreach($this->DefArray as $n=>$v){
			if(is_array($v) && isset($v["required"]) && $v["required"]){
				$foo = explode("_",$n);
				$type = $foo[0];unset($foo[0]);
				$name = implode("_", $foo);
				if($type=="object"){
					$val = $this->getElement("we_object_$name");
				} elseif($type=="multiobject"){
					$temp = @unserialize($this->getElement($name));
					$_array = isset($temp['objects']) ? $temp['objects'] : array();
					if (count($_array) === 0) {
						$val = 0;
					} else {
						$_empty = true;
						for ($i=0; $i<count($_array); $i++) {
							if ($_array[$i]) {
								$_empty = false;
								break;
							}
						}
						if ($_empty) {
							$val = 0;
						} else {
							$val = 1;
						}
					}

				}elseif($type=="checkbox"){
					$val = $this->getElement($name);
				}else if($type=="meta"){
					$val = $this->getElement($name);
				}else{
					$val = $this->geFieldValue($name,$type);
				}
				if((strlen($val) == 0) || (($type=="object" || $type=="multiobject" || $type=="checkbox" || $type=="img") && ($val == "0"))){
					if($type=="object"){
						$name = f("SELECT Text FROM " .OBJECT_TABLE . " WHERE ID='$name'","Text",$this->DB_WE);
					}
					return $name;
				}
			}
		}
		return "";
	}

	function i_areVariantNamesValid() {

		if (defined("SHOP_TABLE")) {

			require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_modules/shop/weShopVariants.inc.php');
			$variationFields = weShopVariants::getAllVariationFields($this);

			if (sizeof($variationFields)) {

				$i=0;
				while (isset($this->elements[WE_SHOP_VARIANTS_PREFIX . "" . $i])) {

					if (!trim($this->elements[WE_SHOP_VARIANTS_PREFIX . "" . $i++]["dat"])) {
						return false;
					}
				}
			}
		}
		return true;
	}

	function getPath(){
		$ParentPath = $this->getParentPath();
		$ParentPath .= ($ParentPath != "/") ? "/" : "";
		return $ParentPath.$this->Text;
	}


	//##################################################################### EDITOR FUNCTION ######################################################################

	/* must be called from the editor-script. Returns a filename which has to be included from the global-Script */
	function editor()
	{
		global $l_object,$we_responseText,$we_JavaScript;
		switch($this->EditPageNr){
			case WE_EDITPAGE_PROPERTIES:
			case WE_EDITPAGE_WORKSPACE:
				return "we_templates/we_editor_properties.inc.php";
				break;
			case WE_EDITPAGE_INFO:
				return "we_modules/object/we_editor_info_objectFile.inc.php";
				break;
			case WE_EDITPAGE_CONTENT:
				return "we_modules/object/we_editor_contentobjectFile.inc.php";
				break;
			case WE_EDITPAGE_PREVIEW:
				return "we_modules/object/we_object_showDocument.inc.php";
				break;
			case WE_EDITPAGE_SCHEDULER:
				return "we_modules/schedule/we_editor_schedpro.inc.php";
				break;
			case WE_EDITPAGE_VARIANTS:
				return 'we_templates/we_editor_variants.inc.php';
			break;
			case WE_EDITPAGE_WEBUSER:
				return "we_modules/customer/editor_weDocumentCustomerFilter.inc.php";
			break;
			case WE_EDITPAGE_VERSIONS:
				return "we_versions/we_editor_versions.inc.php";
			break;

			default:
				$this->EditPageNr = WE_EDITPAGE_PROPERTIES;
				$_SESSION["EditPageNr"] = WE_EDITPAGE_PROPERTIES;
				return "we_templates/we_editor_properties.inc.php";
		}
	}

	function publishFromInsideDocument(){
		$this->publish();
		if($this->EditPageNr == WE_EDITPAGE_PROPERTIES || $this->EditPageNr == WE_EDITPAGE_INFO){
			$_REQUEST["we_cmd"][5] = 'top.we_cmd("switch_edit_page",'.$this->EditPageNr.',"'.$GLOBALS["we_transaction"].'");';
		}
		$GLOBALS["we_JavaScript"] = "_EditorFrame.setEditorDocumentId(".$this->ID.");\n".$this->getUpdateTreeScript();
	}
	function unpublishFromInsideDocument(){
		$this->unpublish();
		if($this->EditPageNr == WE_EDITPAGE_PROPERTIES || $this->EditPageNr == WE_EDITPAGE_INFO){
			$_REQUEST["we_cmd"][5] = 'top.we_cmd("switch_edit_page",'.$this->EditPageNr.',"'.$GLOBALS["we_transaction"].'");';
		}
		$GLOBALS["we_JavaScript"] = "_EditorFrame.setEditorDocumentId(".$this->ID.");\n".$this->getUpdateTreeScript();
	}

	function formPath(){
		global $l_object,$l_we_class;
		$rootDirId = getObjectRootPathOfObjectWorkspace($this->RootDirPath, $this->rootDirID);
		if($this->ParentID=="") {
			$this->ParentID = $rootDirId;
			$this->ParentPath = id_to_path($rootDirId, OBJECT_FILES_TABLE);
		}

		$content =  '<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>'.$this->formInputField("","Text",$l_object["objectname"],30,388,255,'onChange="_EditorFrame.setEditorIsHot(true);pathOfDocumentChanged();"').'</td><td></td><td></td>
	</tr>
	<tr>
		<td>'.getPixel(20,4).'</td><td>'.getPixel(20,2).'</td><td>'.getPixel(100,2).'</td>
	</tr>
	<tr>
		<td colspan="3">'.$this->formDirChooser(388, $rootDirId).'</td>
	</tr>
	<tr>
		<td>
			'.getPixel(20,4).'</td>
		<td>
			'.getPixel(20,2).'</td>
		<td>
			'.getPixel(100,2).'</td>
	</tr>
	<tr>
		<td colspan="3">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						'.$this->formIsSearchable().'</td>
					<td class="defaultfont">
						&nbsp;</td>
					<td>
						&nbsp;</td>
				</tr>
			</table></td>
	</tr>
</table>
';
		return $content;
	}

	function formIsSearchable(){
		global $l_we_class;
		$n = "we_".$this->Name."_IsSearchable";

		$v = $this->IsSearchable;
 		return we_forms::checkboxWithHidden($v ? true : false, $n, $l_we_class["IsSearchable"],false,"defaultfont","_EditorFrame.setEditorIsHot(true);");
 	}

 	/**
	 * returns	a select menu within a html table. to ATTENTION this function is also used in classes object and objectFile !!!!
	 *			when $withHeadline is true, a table with headline is returned, default is false
	 * @return	select menue to determine charset
	 * @param	boolean
	 */
	function formCharset($withHeadline = false){

		global $l_we_class;

		$_charsetHandler = new charsetHandler();

		$_charsets = $_charsetHandler->getCharsetsForTagWizzard();
		$_charsets[""] = "";
		asort($_charsets);
		reset($_charsets);

		$name = "Charset";

		$inputName = "we_".$this->Name."_Charset";

		$_headline = '';

		if($withHeadline){
			$_headline = '
			<tr>
				<td class="defaultfont">' . $GLOBALS["l_we_class"]["Charset"] . '</td>
			</tr>
			';
		}
		$content = '
			<table border="0" cellpadding="0" cellspacing="0">
				' . $_headline . '
				<tr>
					<td>
						' . $this->htmlTextInput($inputName, 24, $this->Charset) . '</td>
					<td></td>
					<td>
						' . $this->htmlSelect("we_tmp_" . $this->Name . "_select[" . $name . "]", $_charsets, 1, $this->Charset, false, "  onblur=_EditorFrame.setEditorIsHot(true);document.forms[0].elements['" . $inputName. "'].value=this.options[this.selectedIndex].value;top.we_cmd(\"reload_editpage\"); onchange=_EditorFrame.setEditorIsHot(true);document.forms[0].elements['" . $inputName. "'].value=this.options[this.selectedIndex].value;top.we_cmd(\"reload_editpage\");","value",330) . '</td>
				</tr>
			</table>';
		return $content;
	}

	function formClass(){
		global $l_object;

		if($this->ID){
			$content = '<span class="defaultfont">'.f("SELECT Text FROM " .OBJECT_TABLE . " WHERE ID='".$this->TableID."'","Text",$this->DB_WE)."</span>";
		}else{
			$content = $this->formSelect2("",388,"TableID",OBJECT_TABLE,"ID","Text","","WHERE IsFolder=0".($this->AllowedClasses ? " AND ID IN(".$this->AllowedClasses.")" : "")." ORDER BY Path ",1,$this->TableID,false,"if(_EditorFrame.getEditorDocumentId() != 0){we_cmd('reload_editpage');}else{we_cmd('restore_defaults');};_EditorFrame.setEditorIsHot(true);");
		}
		return $content;
	}

	function formClassId(){
		global $l_object;
		return '<span class="defaultfont">' . $this->TableID . "</span>";
	}

	function getSortedTableInfo($tableID,$contentOnly=false,$db=""){
		if(!$tableID) return array();
		if(!$db) $db = new DB_WE();

		$ctable = OBJECT_X_TABLE.$tableID;
		$tableInfo = $db->metadata($ctable);
		$tableInfo2 = array();
		foreach($tableInfo as $i=>$arr){
			if(	$arr["name"] != "input_" &&
				$arr["name"] != "text_" &&
				$arr["name"] != "int_" &&
				$arr["name"] != "float_" &&
				$arr["name"] != "date_" &&
				$arr["name"] != "img_" &&
				$arr["name"] != "object_" &&
				$arr["name"] != "multiobject_" &&
				$arr["name"] != "meta_" &&
				(!defined('WE_SHOP_VARIANTS_ELEMENT_NAME') || $arr["name"] != 'variant_' . WE_SHOP_VARIANTS_ELEMENT_NAME)
				){
					array_push($tableInfo2,$arr);
			}
		}
		if($contentOnly==false){
			return $tableInfo2;
		}
		$tableInfo_sorted = array();

		$foo = f("SELECT strOrder FROM " .OBJECT_TABLE . " WHERE ID='".$tableID."'","strOrder",$db);
		$order = makeArrayFromCSV($foo);
		$start = we_objectFile::getFirstTableInfoEntry($tableInfo2);
		foreach($order as $o){
			array_push($tableInfo_sorted,$tableInfo2[$start+$o]);
		}

		return $tableInfo_sorted;
	}

	function getFirstTableInfoEntry($tableInfo){
		foreach($tableInfo as $nr=>$field){
			if($field["name"] != "ID" && substr($field["name"],0,3) != "OF_"){
				return $nr;
			}
		}
		return 0;
	}


	function getFieldHTML($name,$type,$attribs,$editable=true,$variant=false){
		switch($type){
			case "input":
			return $this->getInputFieldHTML($name,$attribs,$editable,$variant);
			case "href":
			return $this->getHrefFieldHTML($name,$attribs,$editable);
			case "link":
			return $this->htmlLinkInput($name,$attribs,$editable);
			case "text":
			return $this->getTextareaHTML($name,$attribs,$editable,$variant);
			case "img":
			return $this->getImageHTML($name,$attribs,$editable,$variant);
			case "binary":
			return $this->getBinaryHTML($name,$attribs,$editable);
			case "date":
			return $this->getDateFieldHTML($name,$attribs,$editable);
			case "checkbox":
			return $this->getCheckboxFieldHTML($name,$attribs,$editable,$variant);
			case "int":
			return $this->getIntFieldHTML($name,$attribs,$editable,$variant);
			case "float":
			return $this->getFloatFieldHTML($name,$attribs,$editable,$variant);
			case "object":
			return $this->getObjectFieldHTML($name,$attribs,$editable);
			case "multiobject":
			return $this->getMultiObjectFieldHTML($name,$attribs,$editable);
			case "meta":
			return $this->getMetaFieldHTML($name,$attribs,$editable,$variant);
			case 'shopVat':
			return $this->getShopVatFieldHtml($name, $attribs, $editable);
			break;
		}
	}

	function getElementByType($name,$type,$attribs){
		switch($type){
			case "text":
			case "input":
				return $this->getElement($name);
			case "href":
				$hrefArr = $this->getElement($name) ? unserialize($this->getElement($name)) : array();
				if(!is_array($hrefArr)){
					$hrefArr= array();
				}
				return we_document::getHrefByArray($hrefArr);
			case "link":
				return $this->htmlLinkInput($name,$attribs,false,false);
			case "date":
				return $this->getElement($name);
			case "float":
			case "int":
				return strlen($this->getElement($name)) ?  abs($this->getElement($name)) :  "";
			case "meta":
				return $this->getElement($name);
			break;
		}
		
		
		return $this->getElement($name);
	}

	function getFieldsHTML($editable,$asString=false){
		$foo = getHash("SELECT strOrder,DefaultValues FROM " .OBJECT_TABLE . " WHERE ID='".$this->TableID."'",$this->DB_WE);

		$dv = $foo["DefaultValues"] ? unserialize($foo["DefaultValues"]) : array();
		if(!is_array($dv)) $dv = array();
		$tableInfo_sorted = $this->getSortedTableInfo($this->TableID,true,$this->DB_WE);
		$fields = array();
		for($i=0;$i<sizeof($tableInfo_sorted);$i++){
			if(ereg('^(.+)_(.+)$',$tableInfo_sorted[$i]["name"])){
				$foo = explode("_", $tableInfo_sorted[$i]["name"]);
				$type = $foo[0];
				unset($foo[0]);
				$name = implode("_", $foo);
				array_push($fields,array("name"=>$name,"type"=>$type));
			}
		}

		$c = "";
		$parts = array();
		for($i=0;$i<sizeof($fields);$i++){

			$realName = $fields[$i]["type"]."_".$fields[$i]["name"];
			$edMerk = $editable;
			if(!((!$dv[$realName]["users"]) || $_SESSION["perms"]["ADMINISTRATOR"] || isUserInUsers($_SESSION["user"]["ID"],$dv[$realName]["users"]))){
				$editable=false;
			}

			if($asString){
				$c2 =  $this->getFieldHTML($fields[$i]["name"],$fields[$i]["type"],$dv[$realName],$editable);
				if($c2){
					$c .=  $c2."<br>".getPixel(2,5)."<br>";
				}
			}else{
				$c2 =  $this->getFieldHTML($fields[$i]["name"] ,$fields[$i]["type"],$dv[$realName],$editable);
				array_push($parts,array(
							"headline"=>"",
							"html"=>$c2,
							"space"=>0,
							"name"=>$realName)
							);
			}

			$editable = $edMerk;
		}
		return $asString ? $c : $parts;
	}

	function getMetaFieldHTML($name,$attribs,$editable=true,$variant=false){

		if ($variant) {
			$vals = $attribs['meta'];
		} else {
			$vals = $this->DefArray["meta_".$name]["meta"];
		}

		if($editable){
			if ($variant) {
				$fname = 'we_'.$this->Name.'_meta['.$name.']';
				return $this->htmlSelect($fname, $vals, 1, $this->getElement($name));
			} else {
				return $this->formSelectFromArray("meta",$name,$vals,'<span class="weObjectPreviewHeadline">'.$name.($this->DefArray["meta_".$name]["required"] ? "*" : "")."</span>" . ( isset($this->DefArray["meta_$name"]['editdescription']) && $this->DefArray["meta_$name"]['editdescription'] ? '<div class="objectDescription">' . $this->DefArray["meta_$name"]['editdescription'] . '</div>' : '<br />' ),1,'',false,'onChange="_EditorFrame.setEditorIsHot(true);"', 'left', 'defaultfont', '', '', '', $variant);
			}

		}else{
			return $this->getPreviewView($name,$vals[$this->getElement($name)]);
		}
	}

	function getObjectFieldHTML($ObjectID,$attribs,$editable=true){
		$db = new DB_WE();
		$we_button = new we_button();

		$foo = getHash("SELECT Text,Path FROM " .OBJECT_TABLE . " WHERE ID=".abs($ObjectID),$db) ;
		$name = isset($foo["Text"]) ? $foo["Text"] : '';
		$classPath = isset($foo["Path"]) ? $foo["Path"] : '';
		$pid = f("SELECT ID FROM " . OBJECT_FILES_TABLE . " WHERE Path='$classPath'","ID",$db);
		$textname = 'we_'.$this->Name.'_txt[we_object_'.$ObjectID.'_path]';
		$idname = 'we_'.$this->Name."_object[we_object_$ObjectID]";
		$myid = $this->getElement("we_object_".$ObjectID);
		$path = $this->getElement("we_object_".$ObjectID."_path");
		$path = f("SELECT Path FROM " . OBJECT_FILES_TABLE . " WHERE ID='$myid'","Path",$db);
		if($myid){
			$ob = new we_objectFile();
			$ob->initByID($myid,OBJECT_FILES_TABLE);
			$ob->DefArray = $ob->getDefaultValueArray();
		} else {
			$ob = new we_objectFile();
		}
		$table = OBJECT_FILES_TABLE;

		//	editObjectFile Button
		if(isset($_SESSION["we_mode"]) && $_SESSION["we_mode"] == "seem"){
			$editObjectButton = $we_button->create_button("image:btn_edit_object", "javascript:top.doClickDirect('" . $myid . "','objectFile','" . OBJECT_FILES_TABLE . "');");
			$editObjectButtonDis = $we_button->create_button("image:btn_edit_object", "", true, 44, 22, "", "", true);
			$inputWidth = 443;

			$uniq = uniqid("");
			$openCloseButton = we_multiIconBox::_getButton($uniq,"weToggleBox('$uniq','','')","down",$GLOBALS["l_global"]["openCloseBox"]);
			$openCloseButtonDis = getPixel(21, 1);

			$objectpreview = "<div id=\"text_".$uniq."\"></div><div id=\"table_".$uniq."\" style=\"display:block; padding: 10px 0px 20px 30px;\">";
			$objectpreview .= $myid ? $ob->getFieldsHTML(0,true) : "";
			$objectpreview .= "</div>";

		} else {
			$editObjectButton = "";
			$editObjectButtonDis = "";
			$openCloseButton = "";
			$openCloseButtonDis = "";
			$inputWidth = 508;
			$objectpreview = "";

		}

		if($editable){

			$_buttons = array();
			$_buttons[] = $we_button->create_button("select", "javascript:we_cmd('openDocselector',document.forms['we_form'].elements['$idname'].value,'$table','document.forms[\\'we_form\\'].elements[\\'$idname\\'].value','document.forms[\\'we_form\\'].elements[\\'$textname\\'].value','opener._EditorFrame.setEditorIsHot(true);opener.top.we_cmd(\'change_objectlink\',\'".$GLOBALS['we_transaction']."\',\'object_".$pid."\');','".session_id()."','$pid','objectFile',".(we_hasPerm("CAN_SELECT_OTHER_USERS_OBJECTS") ? 0 : 1).")");

			$_but = $myid?$editObjectButton:$editObjectButtonDis;

			if ($_but) {
				$_buttons[] = $_but;
			}

			$_but = $myid?$openCloseButton:$openCloseButtonDis;

			if ($_but) {
				$_buttons[] = $_but;
			}

			$_buttons[] = $we_button->create_button("image:btn_function_trash", "javascript:document.forms['we_form'].elements['$idname'].value=0;document.forms['we_form'].elements['$textname'].value='';_EditorFrame.setEditorIsHot(true);top.we_cmd('reload_entry_at_object','".$GLOBALS['we_transaction']."','object_".$pid."')");


			$button = $we_button->create_button_table($_buttons,5);




			return $this->htmlFormElementTable(
				$this->htmlTextInput($textname,30,$path,"",' readonly',"text",$inputWidth,0),
				'<span class="weObjectPreviewHeadline">'.$name.($this->DefArray["object_".$ObjectID]["required"] ? "*" : "") . '</span>' . ( isset($this->DefArray["object_$ObjectID"]['editdescription']) && $this->DefArray["object_$ObjectID"]['editdescription'] ? '<div class="objectDescription">' . $this->DefArray["object_$ObjectID"]['editdescription'] . '</div>' : '<br />' ),
				"left",
				"defaultfont",
				$this->htmlHidden($idname,$myid),
				getPixel(5,4),
				$button ).
				$objectpreview;


		}else{

			$content = 	'';
			$uniq = uniqid("");
			$txt = $ob->Text ? $ob->Text : $name;
			$but = we_multiIconBox::_getButton($uniq,"weToggleBox('$uniq','".$txt."','".$txt."')","down",$GLOBALS["l_global"]["openCloseBox"]);
			$content .= $we_button->create_button_table(
										array(
											$but,
												'<span style="cursor: pointer;-moz-user-select: none;" class="weObjectPreviewHeadline" id="text_'.$uniq.'" onClick="weToggleBox(\''.$uniq.'\',\''.$txt.'\',\''.$txt.'\');" unselectable="on">'.$txt.'</span>'
											)
										);

			$content .= "<div id=\"table_".$uniq."\" style=\"display:block; padding: 10px 0px 20px 30px;\">";

			$content .= $myid ? $ob->getFieldsHTML(0,true) : "";

			$content .= "</div>";

			return $content;

		}
	}

	function getMultiObjectFieldHTML($name,$attribs,$editable=true){
		$db = new DB_WE();
		$we_button = new we_button();

		$table = OBJECT_FILES_TABLE;
		$temp = unserialize($this->getElement($name, "dat"));
		$objects = isset($temp['objects'])?$temp['objects']:array();
		$classid = $this->DefArray['multiobject_'.$name]['class'];
		$max = $this->DefArray['multiobject_'.$name]['max'];

		if($max == "" || $max == 0) {
			$show = sizeof($objects);
		} elseif($max >= sizeof($objects)) {
			$show = sizeof($objects);
		} else {
			$show = $max;
		}

		if($editable){

			$content = "";

			$f=1;

			$text = '<span class="weObjectPreviewHeadline">'.$name.($this->DefArray["multiobject_".$name]["required"] ? "*" : ""). '</span>'.( isset($this->DefArray["multiobject_$name"]['editdescription']) && $this->DefArray["multiobject_$name"]['editdescription'] ? '<div class="objectDescription">' . $this->DefArray["multiobject_$name"]['editdescription'] . '</div>' : '<br />' );
			$content .= $this->htmlFormElementTable("",	$text);

			for($f = 0; $f < $show; $f++) {
				$myid = $objects[$f];

				$classPath = f("SELECT Path FROM " . OBJECT_TABLE . " WHERE ID='".$classid."'","Path",$db) ;

				$textname = 'we_'.$this->Name.'_txt['.$name.'_path'.$f.']';
				$idname = 'we_'.$this->Name."_multiobject[".$name."_default".$f."]";

				$path = $this->getElement("we_object_".$name."_path");
				$path = $path ? $path : f("SELECT Path FROM " . OBJECT_FILES_TABLE . " WHERE ID='$myid'","Path",$db);
				$rootDir = f("SELECT ID FROM " . OBJECT_FILES_TABLE . " WHERE Path='$classPath'","ID",$db);


				if(isset($_SESSION["we_mode"]) && $_SESSION["we_mode"] == "seem"){

					$ob = new we_objectFile();
					$ob->initByID($myid,OBJECT_FILES_TABLE);
					$ob->DefArray = $ob->getDefaultValueArray();
					$uniq = uniqid("");

					$editObjectButton = $we_button->create_button("image:btn_edit_object", "javascript:top.doClickDirect('" . $myid . "','objectFile','" . OBJECT_FILES_TABLE . "');");
					$editObjectButtonDis = $we_button->create_button("image:btn_edit_object", "", true, 44, 22, "", "", true);

					$inputWidth = 346;

					$uniq = uniqid("");

					$openCloseButton = we_multiIconBox::_getButton($uniq,"weToggleBox('$uniq','','')","right",$GLOBALS["l_global"]["openCloseBox"]);
					$openCloseButtonDis = getPixel(21, 1);

					$reloadEntry = "opener.top.we_cmd(\'change_objectlink\',\'".$GLOBALS['we_transaction']."\',\'multiobject_".$name."\');";

				} else {
					$editObjectButton = "";
					$editObjectButtonDis = "";
					$inputWidth = 411;

					$openCloseButton = "";
					$openCloseButtonDis = "";

					$reloadEntry = "";
				}

				$selectObject = $we_button->create_button("select", "javascript:we_cmd('openDocselector',document.forms['we_form'].elements['$idname'].value,'$table','document.forms[\\'we_form\\'].elements[\\'$idname\\'].value','document.forms[\\'we_form\\'].elements[\\'$textname\\'].value','opener._EditorFrame.setEditorIsHot(true);".$reloadEntry."','".session_id()."','$rootDir','objectFile',".(we_hasPerm("CAN_SELECT_OTHER_USERS_OBJECTS") ? 0 : 1).")");

				$upbut       = $we_button->create_button("image:btn_direction_up", "javascript:_EditorFrame.setEditorIsHot(true);we_cmd('up_meta_at_object','".$GLOBALS['we_transaction']."','multiobject_".$name."','".($f)."')");
				$upbutDis    = $we_button->create_button("image:btn_direction_up", "#", true, 21, 22, "", "", true);
				$downbut     = $we_button->create_button("image:btn_direction_down", "javascript:_EditorFrame.setEditorIsHot(true);we_cmd('down_meta_at_object','".$GLOBALS['we_transaction']."','multiobject_".$name."','".($f)."')");
				$downbutDis  = $we_button->create_button("image:btn_direction_down", "#", true, 21, 22, "", "", true);

				$plusbut     = $we_button->create_button("image:btn_add_listelement", "javascript:_EditorFrame.setEditorIsHot(true);we_cmd('insert_meta_at_object','".$GLOBALS['we_transaction']."','multiobject_".$name."','".($f)."')");
				$plusbutDis  = $we_button->create_button("image:btn_add_listelement", "#", true, 21, 22, "", "", true);
				$trashbut    = $we_button->create_button("image:btn_function_trash", "javascript:_EditorFrame.setEditorIsHot(true);we_cmd('delete_meta_at_object','".$GLOBALS['we_transaction']."','multiobject_".$name."','".($f)."')");

				$buttontable =	$we_button->create_button_table(
															array(
																$selectObject,
																($myid?$editObjectButton:$editObjectButtonDis),
																($myid?$openCloseButton:$openCloseButtonDis),
																$this->htmlHidden($idname,$myid),
																((sizeof($objects)<$max||$max==""||$max==0) ?$plusbut:$plusbutDis),
																($f>0 ? $upbut : $upbutDis ),
																($f<sizeof($objects)-1 ? $downbut : $downbutDis),
																$trashbut
															),
															5
														);

				$content .= $this->htmlFormElementTable(
					$this->htmlTextInput($textname,30,$path,255,'onChange="_EditorFrame.setEditorIsHot(true);" readonly ',"text",$inputWidth),
					"",
					"left",
					"defaultfont",
					getPixel(20,4),
					$buttontable);

				if(isset($_SESSION["we_mode"]) && $_SESSION["we_mode"] == "seem" && $myid){
					$ob = new we_objectFile();
					$ob->initByID($myid,OBJECT_FILES_TABLE);
					$ob->DefArray = $ob->getDefaultValueArray();

					$content .= "<div id=\"text_".$uniq."\"></div><div id=\"table_".$uniq."\" style=\"display:none; padding: 10px 0px 20px 30px;\">";
					$content .= $ob->getFieldsHTML(0,true);
					$content .= "</div>";
				}

			}

			if(sizeof($objects)<$max||$max==""||$max==0) {
				$content .= $we_button->create_button("image:btn_add_listelement", "javascript:_EditorFrame.setEditorIsHot(true);we_cmd('insert_meta_at_object','".$GLOBALS['we_transaction']."','multiobject_".$name."','".($f-1)."')");
			} else {
				$content .= $we_button->create_button("image:btn_add_listelement", "#", true, 21, 22, "", "", true);
			}

			$new = array(
				'class' => $classid,
				'max' => $max,
				'objects' => $objects,
			);
			$this->setElement($name, serialize($new));

			return $content;

		}else{

			$content = '';
			if ($show) {
				for($f = 0; $f < $show; $f++) {
					$myid = $objects[$f];
					if($myid){
						$uniq = uniqid("");
						$ob = new we_objectFile();
						$ob->initByID($myid,OBJECT_FILES_TABLE);
						$ob->DefArray = $ob->getDefaultValueArray();
						$txt = $ob->Text;

						$but = we_multiIconBox::_getButton($uniq,"weToggleBox('$uniq','".$txt."','".$txt."')","right",$GLOBALS["l_global"]["openCloseBox"]);
						$content .= $we_button->create_button_table(
													array(
														$but,
															'<span style="cursor: pointer;-moz-user-select: none;" class="weObjectPreviewHeadline" id="text_'.$uniq.'" onClick="weToggleBox(\''.$uniq.'\',\''.$txt.'\',\''.$txt.'\');" unselectable="on">'.$txt.'</span>'
														)

													);

						$content .= "<div id=\"table_".$uniq."\" style=\"display:none; padding: 10px 0px 20px 30px;\">";
						$content .= $ob->getFieldsHTML(0,true);
						$content .= "</div>";
					} else {
						$content .= "";
					}
				}

				$new = array(
					'class' => $classid,
					'max' => $max,
					'objects' => $objects,
				);
				$this->setElement($name, serialize($new));

				return $content;
			} else {
				return $this->getPreviewView($name,$content);
			}
		}

		return "";
	}

	function getShopVatFieldHtml($name, $attribs, $we_editmode = true) {

		require_once(WE_SHOP_MODULE_DIR . 'weShopVats.class.php');

		if ($we_editmode) {

			$shopVats = weShopVats::getAllShopVATs();

			$values = array();
			foreach ($shopVats as $shopVat) {
				$values[$shopVat->id] = $shopVat->vat . '% - ' . $shopVat->text;
			}

			$val = $this->getElement($name) ? $this->getElement($name) : $attribs['default'];

			return '
			<table class="defaultfont">
				<tr>
					<td><span class="weObjectPreviewHeadline">' . $name	 . '</span>' .( isset($this->DefArray["shopVat_shopvat"]['editdescription']) && $this->DefArray["shopVat_shopvat"]['editdescription'] ? '<div class="objectDescription">' . $this->DefArray["shopVat_shopvat"]['editdescription'] . '</div>' : '' ) . '</td>
				</tr>
				<tr>
					<td>' . we_class::htmlSelect("we_".$this->Name."_shopVat[$name]", $values, 1, $val) . '</td>
				</tr>
			</table>
			';

		} else {

			$val = $this->getElement($name);
			$vat = '';

			$weShopVat = weShopVats::getShopVATById($val);

			if ($weShopVat) {
				$vat =  $weShopVat->vat;
			} else {
				$weShopVat = weShopVats::getStandardShopVat();
				$vat = $weShopVat->vat;
			}
			return $this->getPreviewView($name,$vat);

		}


	}

	function getHrefFieldHTML($n,$attribs,$we_editmode=true){
		global $l_global,$we_doc;
		$type = isset($attribs["hreftype"]) ?
		$attribs["hreftype"] :
		"";
		$directory = (isset($attribs["hrefdirectory"]) && $attribs["hrefdirectory"] == "true") ? true : false;
		$file = (isset($attribs["hreffile"]) && $attribs["hreffile"] == "false") ? false : true;
		$hrefArr = $this->getElement($n) ? unserialize($this->getElement($n)) : array();
		if(!is_array($hrefArr)) $hrefArr= array();
		if($we_editmode){
			$nint = $n."_we_jkhdsf_int";
			$nintID = $n."_we_jkhdsf_intID";
			$nintPath = $n."_we_jkhdsf_intPath";
			$nextPath = $n."_we_jkhdsf_extPath";

			$attr = ' size="20" ';

			$int = isset($hrefArr["int"]) ? $hrefArr["int"] : false;
			$intID = (isset($hrefArr["intID"]) && $hrefArr["intID"]) ? $hrefArr["intID"] : '';
			$intPath = $intID ? id_to_path($intID) : "";
			$extPath = isset($hrefArr["extPath"]) ? $hrefArr["extPath"] : "";
			$objID = isset($hrefArr["objID"]) ? $hrefArr["objID"] : 0;
			$objPath = $objID ? id_to_path($objID,OBJECT_FILES_TABLE) : "";
			$int_elem_Name = 'we_'.$this->Name.'_href['.$nint.']';
			$intPath_elem_Name = 'we_'.$this->Name.'_href['.$nintPath.']';
			$intID_elem_Name = 'we_'.$this->Name.'_href['.$nintID.']';
			$ext_elem_Name = 'we_'.$this->Name.'_href['.$nextPath.']';
			switch($type){
				case "int":
				$out = $this->hrefRow($intID_elem_Name,
				$intID,
				$intPath_elem_Name,
				$intPath,
				$attr,
				$int_elem_Name,false,true,"",$file,$directory);
				break;
				case "ext":
				$out = $this->hrefRow("",
				"",
				$ext_elem_Name,
				$extPath,
				$attr,
				$int_elem_Name,false,true,"",$file,$directory);
				break;
				default:
				$out = $this->hrefRow($intID_elem_Name,
				$intID,
				$intPath_elem_Name,
				$intPath,
				$attr,
				$int_elem_Name,
				true,
				$int,"",$file,$directory) .
				$this->hrefRow("",
				"",
				$ext_elem_Name,
				$extPath,
				$attr,
				$int_elem_Name,
				true,
				$int,"",$file,$directory);
			}
			$out = '<table border="0" cellpadding="0" cellspacing="0" background="' . IMAGE_DIR . 'backgrounds/aquaBackground.gif">'.$out.'</table>';
			return '<span class="weObjectPreviewHeadline"><b>'.$n.($this->DefArray["href_".$n]["required"] ? "*" : ""). "</b>".'</span>' .  (isset($this->DefArray["href_".$n]['editdescription']) && $this->DefArray["href_".$n]['editdescription'] ? '<div class="objectDescription">' . $this->DefArray["href_".$n]['editdescription'] . '</div>' : '<br/>' ) . $out;
		}else{
			$out = we_document::getHrefByArray($hrefArr);
			return $this->getPreviewView($n,$out);
		}
	}

	function htmlLinkInput($n,$attribs,$we_editmode=true,$headline=true){
		global $l_global;
		$attribs["name"]=$n;
		$we_button = new we_button();
		$out = "";
		$link = $this->getElement($n) ? unserialize($this->getElement($n)) : array();
		if(is_array($link)){
			if(!sizeof($link)){
				$link = array("ctype"=>"text","type"=>"ext","href"=>"#","text"=>$GLOBALS["l_global"]["new_link"]);
			}
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_imageDocument.inc.php");
			$img = new we_imageDocument();
			$content = we_document::getLinkContent($link,$this->ParentID,$this->Path,$GLOBALS["DB_WE"],$img);

			$startTag = $this->getLinkStartTag($link, array(),$this->ParentID,$this->Path,$GLOBALS["DB_WE"],$img);

			$editbut = $we_button->create_button("edit", "javascript:we_cmd('edit_link_at_object','".$n."')");
			$delbut  = $we_button->create_button("image:btn_function_trash", "javascript:we_cmd('delete_link_at_object','".$GLOBALS['we_transaction']."', 'link_".$n."')");
			$buttons = $we_button->create_button_table(array(	$editbut,
																$delbut));
			if(!$content) $content = $GLOBALS["l_global"]["new_link"];
			if($startTag){
				$out = $startTag.$content.'</a>'.($we_editmode ? ($buttons) : "");
			}else{
				$out = $content.($we_editmode ? ($buttons) : "");
			}
		}
		if($headline){
			return '<span class="weObjectPreviewHeadline">'.$n.'</span>' . ( $we_editmode && isset($this->DefArray["link_".$n]['editdescription']) && $this->DefArray["link_".$n]['editdescription'] ? '<div class="objectDescription">' . $this->DefArray["link_".$n]['editdescription'] . '</div>' : '<br />' ) . $out;
		}else{
			return $out;
		}
	}

	function getPreviewView($name,$content) {
		if($content !== ""){
				return '<div class="weObjectPreviewHeadline">'.$name. '</div><div class="defaultfont">'.$content.'</div>';
		}else{
				return '<div class="weObjectPreviewHeadline">'.$name. '</div>';
		}
	}

	function getInputFieldHTML($name,$attribs,$editable=true,$variant=false){

		if($editable){

			$content = $this->htmlTextInput("we_".$this->Name."_input[$name]",40,$this->getElement($name),$this->getElement($name,"len"),'onChange="_EditorFrame.setEditorIsHot(true);"',"text",620);
			if ($variant) {
				return $content;
			}

			return '<span class="weObjectPreviewHeadline">'.$name.($this->DefArray["input_".$name]["required"] ? "*" : "")."</span>" .  (isset($this->DefArray["input_".$name]['editdescription']) && $this->DefArray["input_".$name]['editdescription'] ? '<br /><div class="objectDescription">' . $this->DefArray["input_".$name]['editdescription'] . '</div>' : '<br />' ) . $content;
		}else{
			return $this->getPreviewView($name,$this->getElement($name));
		}
	}
	function getCheckboxFieldHTML($name,$attribs,$editable=true){
		if($editable){
			$content = we_forms::checkboxWithHidden(($this->getElement($name)?true:false), "we_".$this->Name."_checkbox[$name]", "", false, "defaultfont", "_EditorFrame.setEditorIsHot(true);");
			return '<span class="weObjectPreviewHeadline"><b>'.$name.($this->DefArray["checkbox_".$name]["required"] ? "*" : "")."</b></span>" . ( isset($this->DefArray["checkbox_".$name]['editdescription']) && $this->DefArray["checkbox_".$name]['editdescription'] ? '<div class="objectDescription">' . $this->DefArray["checkbox_".$name]['editdescription'] . '</div>' : '<br />' ) .$content;
		}else{
			$content = ($this->getElement($name) ?  $GLOBALS["l_global"]["yes"] : $GLOBALS["l_global"]["no"]);
			return $this->getPreviewView($name,$content);
		}
	}
	function getIntFieldHTML($name,$attribs,$editable=true,$variant=false){
		if($editable){
			$content = $this->htmlTextInput("we_".$this->Name."_int[$name]",40,strlen($this->getElement($name)) ?  abs($this->getElement($name)) :  "",$this->getElement($name,"len"),'onChange="_EditorFrame.setEditorIsHot(true);"',"text",620);
			if ($variant) {
				return $content;
			}
			return '<span class="weObjectPreviewHeadline">'.$name.($this->DefArray["int_".$name]["required"] ? "*" : "")."</span>" . ( isset($this->DefArray["int_".$name]['editdescription']) && $this->DefArray["int_".$name]['editdescription'] ? '<div class="objectDescription">' . $this->DefArray["int_".$name]['editdescription'] . '</div>' : '<br />' ) .$content;
		}else{
			$content =strlen($this->getElement($name)) ?  abs($this->getElement($name)) :  "";
			return $this->getPreviewView($name,$content);
		}
	}
	function getFloatFieldHTML($name,$attribs,$editable=true,$variant=false){
		if($editable){
			$content = $this->htmlTextInput("we_".$this->Name."_float[$name]",40,strlen($this->getElement($name)) ?  abs($this->getElement($name)) :  "",$this->getElement($name,"len"),'onChange="_EditorFrame.setEditorIsHot(true);"',"text",620);

			if ($variant) {
				return $content;
			}

			return '<span class="weObjectPreviewHeadline"><b>'.$name.($this->DefArray["float_".$name]["required"] ? "*" : "")."</b></span>" . ( isset($this->DefArray["float_".$name]['editdescription']) && $this->DefArray["float_".$name]['editdescription'] ? '<div class="objectDescription">' . $this->DefArray["float_".$name]['editdescription'] . '</div>' : '<br />' ) .$content;
		}else{
			$content = strlen($this->getElement($name)) ?  abs($this->getElement($name)) :  "";
			return $this->getPreviewView($name,$content);
		}
	}
	function getDateFieldHTML($name,$attribs,$editable=true){
		if($editable){
			$d =abs($this->getElement($name));
			$content = getDateInput2("we_".$this->Name."_date[".$name."]",($d ? $d : time()),true);
			return '<span class="weObjectPreviewHeadline">'.$name.($this->DefArray["date_".$name]["required"] ? "*" : "")."</span>" . ( isset($this->DefArray["date_$name"]['editdescription']) && $this->DefArray["date_$name"]['editdescription'] ? '<div class="objectDescription">' . $this->DefArray["date_$name"]['editdescription'] . '</div>' : '<br />' ) .getPixel(2,2) . '<br />'.$content;
		}else{
			$d =abs($this->getElement($name));
			$content = date($GLOBALS["l_global"]["date_format"],$d);
			return $this->getPreviewView($name,$content);
		}
	}
	function getTextareaHTML($name,$attribs,$editable=true,$variant=false){
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_forms.inc.php");
		if($editable){

			if ( isset($this->Charset) ) {	//	send charset which might be determined in template
				$charset = $this->Charset;
			} else {
				$charset = $GLOBALS["_language"]["charset"];
			}

			$value = $this->getElement($name);
			$attribs["width"] = isset($attribs["width"]) ? $attribs["width"] : 620;
			$attribs["height"] = isset($attribs["height"]) ? $attribs["height"] : 200;
			$attribs["rows"] = 10;
			$attribs["cols"] = 60;
			$attribs["bgcolor"] = "white";
			if(isset($attribs["cssClasses"])){
				$attribs["classes"] = $attribs["cssClasses"];
			}

			$removefirstparagraph = ((!isset($attribs["removefirstparagraph"])) || ($attribs["removefirstparagraph"] == "on")) ? true : false;
			$xml = (isset($attribs["xml"]) && ($attribs["xml"] == "on")) ? true : false;

			$autobr = $this->getElement($name,"autobr") ? $this->getElement($name,"autobr") : (isset($attribs["autobr"]) ? $attribs["autobr"] : "");
			$autobrName = 'we_'.$this->Name.'_text['.$name.'#autobr]';
			$textarea = we_forms::weTextarea('we_'.$this->Name.'_text['.$name.']',$value,$attribs,$autobr,$autobrName,true,"",(isset($attribs["classes"]) && $attribs["classes"]) ? false : true,false,$xml,$removefirstparagraph,$charset);

			if ($variant) {
				return $textarea;
			}

			return '<span class="weObjectPreviewHeadline">'.$name.($this->DefArray["text_".$name]["required"] ? "*" : "")."</span>" . ( isset($this->DefArray["text_".$name]['editdescription']) && $this->DefArray["text_".$name]['editdescription'] ? '<div class="objectDescription">' . $this->DefArray["text_".$name]['editdescription'] . '</div>' : '<br />' ) .$textarea;
		}else{
			$content = $this->getFieldByVal($this->getElement($name),"txt",$attribs);
			return $this->getPreviewView($name,$content);
		}
	}
	function getImageHTML($name,$attribs,$editable=true, $variant=false){
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_imageDocument.inc.php");
		$we_button = new we_button();
		$img = new we_imageDocument();
		$id = $this->getElement($name);
		if(!id_to_path($id)){
			$id = 0;
			$this->setElement($name,0);
		}
		$img->initByID($id,FILE_TABLE,false);
		
		// handling thumbnails for this image
		// identifying default thumbnail of class:
		$defvals = $this->getDefaultValueArray();
		$thumbID = isset($defvals["img_".$name]["defaultThumb"]) ? $defvals["img_".$name]["defaultThumb"] : "";
		$thumbID;
		// creating thumbnail only if it really exists:
		$thumbdb = new DB_WE();
		$thumbdb->query("SELECT ID,Name FROM ".THUMBNAILS_TABLE);
		$thumbs = $thumbdb->getAll();
		array_unshift($thumbs,"");
		if(!empty($thumbID) && isset($thumbs[$thumbID]["ID"]) &&  $thumbID <= count($thumbs)){
			if($img->ID>0){
				$thumbObj = new we_thumbnail();
				$thumbObj->initByThumbID($thumbs[$thumbID]["ID"],$img->ID,$img->Filename,$img->Path,$img->Extension,$img->getElement("origwidth"),$img->getElement("origheight"),$img->getDocument());
				$thumbObj->createThumb();
				$_imgSrc    = $thumbObj->getOutputPath();
				$_imgHeight = $thumbObj->getOutputHeight();
				$_imgWight  = $thumbObj->getOutputWidth();
			} else {
				$_imgSrc    = IMAGE_DIR . 'icons/no_image.gif';
				$_imgHeight = 64;
				$_imgWight  = 64;
			}
		} else {
			$thumbID = "";
		}

		$content = "";
		if($editable){
			$fname = 'we_'.$this->Name.'_img['.$name.']';
			$content .= '<input type=hidden name="'.$fname.'" value="'.$this->getElement($name).'">';
			// show thumbnail of image if there exists one: 
			if(!empty($thumbID)) {
				$content .= '<img src="'.$_imgSrc.'" height="'.$_imgHeight.'" width="'.$_imgWight.'" />';
			} else {
				$content .= $img->getHtml();
			}
			$content .= $we_button->create_button_table( array(	$we_button->create_button("edit", "javascript:we_cmd('openDocselector','".($id!=0?$id:(isset($this->DefArray["img_$name"]['defaultdir'])?$this->DefArray["img_$name"]['defaultdir']:0))."','".FILE_TABLE."','document.forms[\\'we_form\\'].elements[\\'".$fname."\\'].value','','opener.top.we_cmd(\\'reload_entry_at_object\\',\\'".$GLOBALS['we_transaction']."\\',\\'img_".$name."\\');opener._EditorFrame.setEditorIsHot(true);opener.setScrollTo();','".session_id()."', ".(isset($this->DefArray["img_$name"]['rootdir'])&&$this->DefArray["img_$name"]['rootdir']!=""?$this->DefArray["img_$name"]['rootdir']:0).",'image/*')"),
																$we_button->create_button("image:btn_function_trash", "javascript:we_cmd('remove_image_at_object','".$GLOBALS['we_transaction']."','img_".$name."');setScrollTo();")));

			if ($variant) {
				return $content;
			}
			return '<span class="weObjectPreviewHeadline"><b>'.$name.($this->DefArray["img_".$name]["required"] ? "*" : "")."</b></span>" . ( isset($this->DefArray["img_$name"]['editdescription']) && $this->DefArray["img_$name"]['editdescription'] ? '<div class="objectDescription">' . $this->DefArray["img_$name"]['editdescription'] . '</div>' : '<br />' ) . "".$content;
		}else{
			$content .= $img->getHtml();
			return $this->getPreviewView($name,$content);
		}
	}

	function getBinaryHTML($name,$attribs,$editable=true){
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_otherDocument.inc.php");
		$we_button = new we_button();
		$img = new we_otherDocument();
		$id = $this->getElement($name);
		$img->initByID($id,FILE_TABLE,false);

		$content = "";

		if($editable){
			$content = "";
			$fname = 'we_'.$this->Name.'_img['.$name.']';
			$content .= '<input type=hidden name="'.$fname.'" value="'.$this->getElement($name).'">';
			$content .= $img->getHtml();
			$content .= $we_button->create_button_table(array(	$we_button->create_button("edit", "javascript:we_cmd('openDocselector','".$id."','".FILE_TABLE."','document.forms[\\'we_form\\'].elements[\\'".$fname."\\'].value','','opener.top.we_cmd(\\'reload_entry_at_object\\',\\'".$GLOBALS['we_transaction']."\\',\\'binary_".$name."\\');opener._EditorFrame.setEditorIsHot(true);','".session_id()."',0,'application/*')"),
																$we_button->create_button("image:btn_function_trash", "javascript:we_cmd('remove_image_at_object','".$GLOBALS['we_transaction']."','binary_".$name."')")));
			return '<span class="weObjectPreviewHeadline">'.$name.($this->DefArray["binary_".$name]["required"] ? "*" : "")."</span>" . ( isset($this->DefArray["binary_$name"]['editdescription']) && $this->DefArray["binary_$name"]['editdescription'] ? '<div class="objectDescription">' . $this->DefArray["binary_$name"]['editdescription'] . '</div>' : '<br />' ) . $content;
		}else{
			$content .= $img->getHtml();
			return $this->getPreviewView($name,$content);
		}
	}

	function getDefaultValueArray(){
		if($this->TableID){
			$foo = f("SELECT DefaultValues FROM " .OBJECT_TABLE . " WHERE ID='".$this->TableID."'","DefaultValues",$this->DB_WE);
			if($foo){
				return unserialize($foo);
			}else{
				return array();
			}
		}
	}
	function getContentData($loadBinary=0){
		if(!$this->TableID) return;
		$ID = $this->ObjectID;
		$DataTable = OBJECT_X_TABLE.$this->TableID;
		$db = $this->DB_WE;
		$tableInfo = $this->getSortedTableInfo($this->TableID,false,$db);

		$db->query("SELECT * FROM $DataTable WHERE ID='$ID'");
		if($db->next_record()){
			for($i=0;$i<sizeof($tableInfo);$i++){
				if(ereg('^(.+)_(.+)$',$tableInfo[$i]["name"],$regs)){
					if($regs[1] != "OF"){
						$temp = explode("_", $tableInfo[$i]["name"]);
						unset($temp[0]);
						$name = implode("_", $temp);
						if($regs[1] == "object"){
							$name = "we_object_".$name;
						}
//						if($regs[1] == "multiobject"){
//							$this->elements[$name]["class"] = $db->f($tableInfo[$i]["name"]);
//						}
						if($regs[1] == "img"){
							$this->elements[$name]["bdid"] = $db->f($tableInfo[$i]["name"]);
						}
						$this->elements[$name]["dat"] = $db->f($tableInfo[$i]["name"]);
						$this->elements[$name]["type"] = $regs[1];
						$this->elements[$name]["len"] = $tableInfo[$i]["len"];
					}
				}
			}
		}
	}

	function canMakeNew(){
		if($_SESSION["perms"]["ADMINISTRATOR"]) return true;
		$ac = $this->getAllowedClasses();
		return sizeof($ac);
	}

	function getPossibleWorkspaces($ClassWs,$all=false){
		if(!$ClassWs) $ClassWs = f("SELECT Workspaces FROM " .OBJECT_TABLE . " WHERE ID='".$this->TableID."'","Workspaces",$this->DB_WE);
		$userWs = get_ws(FILE_TABLE);
		// wenn User Admin ist oder keine Workspaces zugeteilt wurden
		if($_SESSION["perms"]["ADMINISTRATOR"] || ((!$userWs) && $all)){
			// alle ws, welche in Klasse definiert wurden und deren Unterordner zur?ckgeben
			$foo = makeArrayFromCSV($ClassWs);
			$paths = id_to_path($ClassWs,FILE_TABLE,$this->DB_WE,false,true);
			if(count($paths) > 0){
				$where = "";
				if(is_array($paths)) {
					foreach($paths as $path){
						if($path!="/"){
							$where .= "Path like '$path/%' OR Path = '$path' OR ";
						}
					}
				}
				$where = ereg_replace("(.*) OR $",'\1',$where);
				if($where){
					$where = "($where)";
				}
				$this->DB_WE->query("SELECT ID FROM ".FILE_TABLE." WHERE IsFolder=1".($where ? " AND $where" : "")." ORDER BY Path");
				while($this->DB_WE->next_record()){
					$ClassWs .= $this->DB_WE->f("ID").",";
				}
				if($ClassWs && substr($ClassWs,0,1) != ","){
					$ClassWs = ",".$ClassWs;
				}
			}
			//$foo = pushChildsFromArr($foo,FILE_TABLE,1);
			//return makeCSVFromArray($foo);
		}else{
			// alle UserWs, welche sich in einem der ClassWs befinden zur�ckgeben
			$userWsArr = makeArrayFromCSV($userWs);
			$out = array();
			foreach($userWsArr as $ws){
				if(in_workspace($ws,$ClassWs,FILE_TABLE,$this->DB_WE)){
					array_push($out,$ws);
				}
			}
			$paths = id_to_path($out,FILE_TABLE,$this->DB_WE,false,true);
			if(count($paths) > 0){
                $ClassWs = "";
				$where = "";
				foreach($paths as $path){
					if($path!="/"){
						$where .= "Path like '".mysql_real_escape_string($path)."/%' OR Path = '".mysql_real_escape_string($path)."' OR ";
					}
				}
				$where = ereg_replace("(.*) OR $",'\1',$where);
				if($where){
					$where = "($where)";
				}
				$this->DB_WE->query("SELECT ID FROM ".FILE_TABLE." WHERE IsFolder=1".($where ? " AND $where" : "")." ORDER BY Path");
				while($this->DB_WE->next_record()){
					$ClassWs .= $this->DB_WE->f("ID").",";
				}
				if($ClassWs && substr($ClassWs,0,1) != ","){
					$ClassWs = ",".$ClassWs;
				}
			}

		}
		return $ClassWs;
	}

	function formWorkspaces(){
		global $l_we_class;
		$foo = getHash("SELECT Workspaces,Templates FROM " .OBJECT_TABLE . " WHERE ID='".$this->TableID."'",$this->DB_WE);
		$ws = $foo["Workspaces"];
		$ts = $foo["Templates"];
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirAndTemplateChooser.inc.php");

		$values = getHashArrayFromCSV($this->getPossibleWorkspaces($ws),"",$this->DB_WE);
		foreach($values as $id=>$val){
			if(!weFileExists($id)) unset($values[$id]);
		}
		//    remove not existing workspaces and templates
		$arr   = makeArrayFromCSV($this->Workspaces);
		$tmpls = makeArrayFromCSV($this->Templates);

		$newArr = array();
		$newTmpls = array();
		$newDefaultArr = array();
		foreach($arr as $nr=>$id){
			if(weFileExists($id)){
                array_push($newArr,$id);
                array_push($newTmpls, (isset($tmpls[$nr]) ? $tmpls[$nr] : ''));
			}
		}

		$this->Workspaces = makeCSVFromArray($newArr,true);
		$this->Templates  = makeCSVFromArray($newTmpls,true);

		$arr = makeArrayFromCSV($this->ExtraWorkspaces);
		$newArr = array();
		foreach($arr as $nr=>$id){
			if(weFileExists($id)) array_push($newArr,$id);
		}
		$this->ExtraWorkspaces = makeCSVFromArray($newArr,true);

		$arr = makeArrayFromCSV($this->Workspaces);
		foreach($arr as $nr=>$id){
			if(isset($values[$id])) unset($values[$id]);
		}
		if(sizeof($values) < 1){
			$addbut = "";
		}else{
			$textname = md5(uniqid(rand(),1));
			$idname = md5(uniqid(rand(),1));
			$foo = array(""=>$GLOBALS["l_global"]["add_workspace"]);
			foreach($values as $key=>$val){
				$foo[$key]=$val;
			}
			$addbut = htmlSelect($textname,$foo,1,"",false,'onChange="_EditorFrame.setEditorIsHot(true);we_cmd(\'add_workspace\',this.options[this.selectedIndex].value);"');
		}
		$obj = new MultiDirAndTemplateChooser(450,$this->Workspaces,"del_workspace",$addbut,get_ws(FILE_TABLE),$this->Templates,"we_".$this->Name."_Templates",$ts,get_ws(TEMPLATES_TABLE));

		// Bug Fix #207
		$obj->isEditable=true;//$this->userIsCreator();

		$content = $obj->get();
		return $content;
	}

	function getTemplateFromWs($wsID){
		$foo = getHash("SELECT Templates,Workspaces FROM " .OBJECT_TABLE . " WHERE ID='".$this->TableID."'",$this->DB_WE);

		$db = new DB_WE();
		$mwsp = id_to_path($wsID,FILE_TABLE,$db);

		$tarr = makeArrayFromCSV($foo["Templates"]);
		$warr = makeArrayFromCSV($foo["Workspaces"]);
		$pos = getArrayKey($wsID,$warr);
		if($pos ==""){
			foreach($warr as $wsi){
				$wsp = id_to_path($wsi,FILE_TABLE,$db);
				if(substr($mwsp,0,strlen($wsp)) == $wsp){
					$pos = getArrayKey($wsi,$warr);
					break;
				}
			}
		}
		return $tarr[$pos];
	}

	function add_workspace($id){
		$ExtraWorkspaces = makeArrayFromCSV($this->ExtraWorkspaces);
		$workspaces = makeArrayFromCSV($this->Workspaces);
		$templates = makeArrayFromCSV($this->Templates);
		$extraTemplates = makeArrayFromCSV($this->ExtraTemplates);

		if(!in_array($id,$workspaces)){
			array_push($workspaces,$id);
			$tid=$this->getTemplateFromWs($id);
			array_push($templates,$tid);
			$this->Workspaces = makeCSVFromArray($workspaces,true);
			$this->Templates = makeCSVFromArray($templates,true);
		}

	}

	function del_workspace($id){
		$workspaces = makeArrayFromCSV($this->Workspaces);
		$Templates = makeArrayFromCSV($this->Templates);
		for($i=0;$i<sizeof($workspaces);$i++){
			if($workspaces[$i] == $id){
				unset($workspaces[$i]);
				unset($Templates[$i]);
				break;
			}
		}
		$tempArr = array();

		foreach($workspaces as $ws){
			array_push($tempArr,$ws);
		}

		$this->Workspaces = makeCSVFromArray($tempArr,true);

		$tempArr = array();

		foreach($Templates as $t){
			array_push($tempArr,$t);
		}

		$this->Templates = makeCSVFromArray($tempArr,true);
	}

	function ws_from_class(){
		$foo = getHash("SELECT Workspaces,Templates FROM " .OBJECT_TABLE . " WHERE ID='".$this->TableID."'",$this->DB_WE);
		$this->Workspaces = $foo["Workspaces"];
		$this->Templates = $foo["Templates"];
		$this->ExtraTemplates = "";
		$this->ExtraWorkspaces = "";
		$this->ExtraWorkspacesSelected = "";
	}

	function formExtraWorkspaces(){
		global $l_we_class;
		$foo = getHash("SELECT Workspaces,Templates FROM " .OBJECT_TABLE . " WHERE ID='".$this->TableID."'",$this->DB_WE);
		$ws = $foo["Workspaces"];
		$ts = $foo["Templates"];

		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirAndTemplateChooser.inc.php");

		// values bekommen aller workspaces, welche hinzugef�gt werden d�rfen.
		$values = getHashArrayFromCSV($this->getPossibleWorkspaces($ws,true),"",$this->DB_WE);
		foreach($values as $id=>$val){
			if(!weFileExists($id)) unset($values[$id]);
		}

		$arr = makeArrayFromCSV($this->ExtraWorkspaces);
		foreach($arr as $nr=>$id){
			if(isset($values[$id]) || (!weFileExists($id))) unset($values[$id]);
		}

		if(sizeof($values) < 1){
			$addbut = "";
		}else{
			$textname = md5(uniqid(rand(),1));
			$idname = md5(uniqid(rand(),1));
			$foo = array(""=>$GLOBALS["l_global"]["add_workspace"]);
			foreach($values as $key=>$val){
				$foo[$key]=$val;
			}
			$addbut = htmlSelect($textname,$foo,1,"",false,'onChange="_EditorFrame.setEditorIsHot(true);we_cmd(\'add_extraworkspace\',this.options[this.selectedIndex].value);"');
		}

		$obj = new MultiDirAndTemplateChooser(450,$this->ExtraWorkspaces,"del_extraworkspace",$addbut,get_ws(FILE_TABLE),$this->ExtraTemplates,"we_".$this->Name."_ExtraTemplates",$ts,get_ws(TEMPLATES_TABLE));
		$obj->CanDelete=true;
		$content = $obj->get();

		return $content;
	}

	function add_extraWorkspace($id){
		$ExtraWorkspaces = makeArrayFromCSV($this->ExtraWorkspaces);
		$workspaces = makeArrayFromCSV($this->Workspaces);
		$templates = makeArrayFromCSV($this->Templates);
		$extraTemplates = makeArrayFromCSV($this->ExtraTemplates);

		if(!in_array($id,$ExtraWorkspaces)){
			array_push($ExtraWorkspaces,$id);
			$tid=$this->getTemplateFromWs($id);
			array_push($extraTemplates,$tid);
			$this->ExtraWorkspaces = makeCSVFromArray($ExtraWorkspaces,true);
			$this->ExtraTemplates = makeCSVFromArray($extraTemplates,true);
		}

	}

	function del_extraWorkspace($id){
		$ExtraWorkspaces = makeArrayFromCSV($this->ExtraWorkspaces);
		$ExtraTemplates = makeArrayFromCSV($this->ExtraTemplates);
		for($i=0;$i<sizeof($ExtraWorkspaces);$i++){
			if($ExtraWorkspaces[$i] == $id){
				unset($ExtraWorkspaces[$i]);
				unset($ExtraTemplates[$i]);
				break;
			}
		}
		$tempArr = array();

		foreach($ExtraWorkspaces as $ws){
			array_push($tempArr,$ws);
		}

		$this->ExtraWorkspaces = makeCSVFromArray($tempArr,true);

		$tempArr = array();

		foreach($ExtraTemplates as $t){
			array_push($tempArr,$t);
		}

		$this->ExtraTemplates = makeCSVFromArray($tempArr,true);

	}

	function getAllowedClasses(){
		return getAllowedClasses($this->DB_WE);
	}

	function getTemplateFromWorkspace($wsArr,$tmplArr,$parentID,$mode=0){
		for($i=0;$i<sizeof($wsArr);$i++){
			if($mode){
				if($wsArr[$i] == $parentID){
					return $tmplArr[$i];
				}
			}else{
				if(in_workspace($parentID,$wsArr[$i])){
					return $tmplArr[$i];
				}
			}
		}
		return 0;
	}

	function getTemplateID($parentID){
		$wsArr = makeArrayFromCSV($this->Workspaces);
		$tmplArr = makeArrayFromCSV($this->Templates);
		$wsArrExtra = makeArrayFromCSV($this->ExtraWorkspaces);
		$tmplArrExtra = makeArrayFromCSV($this->ExtraTemplates);


		$tid = $this->getTemplateFromWorkspace($wsArr,$tmplArr,$parentID,1);
		if(!$tid){
			$tid = $this->getTemplateFromWorkspace($wsArrExtra,$tmplArrExtra,$parentID,1);
		}
		if(!$tid){
			$tid = $this->getTemplateFromWorkspace($wsArr,$tmplArr,$parentID,0);
		}
		if(!$tid){
			$tid = $this->getTemplateFromWorkspace($wsArrExtra,$tmplArrExtra,$parentID,0);
		}
		if(!$tid){
			if(sizeof($tmplArr)){
				$tid = $tmplArr[0];
			}
		}
		if(!$tid){
			$foo = makeArrayFromCSV(f("SELECT Templates FROM " .OBJECT_TABLE . " WHERE ID='".$this->TableID."'","Templates",new DB_WE()));
			if(sizeof($foo)){
				$tid = $foo[0];
			}
		}
		return $tid;
	}


	function geFieldValue($t,$f){
		$elem = $this->getElement($t);
		switch($f){
			case "href":
				$hrefArr = $elem ? unserialize($elem) : array();
				if(!is_array($hrefArr)) $hrefArr= array();
				$elem = we_document::getHrefByArray($hrefArr);
				break;
			case "link":
				$link = $elem ? unserialize($elem) : array();
				if(is_array($link)){
					include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_imageDocument.inc.php");
					$img = new we_imageDocument();
					$elem = we_document::getLinkContent($link,0,"",$this->DB_WE,$img);
				}else{
					return "";
				}
				break;
			case "meta":
				if(!$this->DefArray) {
					$this->DefArray = $this->getDefaultValueArray();
				}
				$vals = $this->DefArray["meta_".$t]["meta"];
				$elem = $vals[$this->getElement($t)];
				break;
		}
		return $elem;
	}

	function setTitleAndDescription(){
		$foo = getHash("SELECT DefaultDesc,DefaultTitle,DefaultKeywords FROM " .OBJECT_TABLE . " WHERE ID='".$this->TableID."'",$this->DB_WE);

		if (isset($foo["DefaultTitle"]) && $foo["DefaultTitle"] && strpos($foo["DefaultTitle"], '_')) {
			list($f,$t) = explode("_", $foo["DefaultTitle"]);
			if ($f !== '' && isset($d) && $d !== '') {
				$elem = $this->geFieldValue($t, $f);
				$this->setElement("Title", $elem);
			}
		}

		if (isset($foo["DefaultDesc"]) && $foo["DefaultDesc"]) {
			list($f,$d) = explode("_", $foo["DefaultDesc"]);
			if ($f !== '' && $d !== '') {
				$elem = $this->geFieldValue($d, $f);
				$this->setElement("Description", $elem);
			}
		}

		if (isset($foo["DefaultKeywords"]) && $foo["DefaultKeywords"]) {
			list($f,$d) = explode("_", $foo["DefaultKeywords"]);
			if ($f !== '' && $d !== '') {
				$elem = $this->geFieldValue($d, $f);
				$this->setElement("Keywords", $elem);
			}	
		}
	}


	function insertAtIndex(){
		$this->setTitleAndDescription();
		$this->resetElements();
		$text = "";
		while(list($k,$v) = $this->nextElement("")){
			if(isset($v["dat"])){ $text .= " ".$v["dat"]; }
		}
		$text = mysql_real_escape_string(trim(strip_tags($text)));
		if(!$this->DB_WE->query("DELETE FROM " . INDEX_TABLE . " WHERE OID=".$this->ID)) return false;
		if(!$this->IsSearchable) {
			return true;
		}
		$ws = makeArrayFromCSV($this->Workspaces);
		$ws2 = makeArrayFromCSV($this->ExtraWorkspacesSelected);
		foreach($ws2 as $w){
			array_push($ws,$w);
		}

		$ws = array_unique($ws);
		foreach($ws as $w){
			$wsPath = id_to_path($w,FILE_TABLE,$this->DB_WE);
			if( (strlen($wsPath) > 0) || ($w == "0") ){
				if($w == "0"){
					$wsPath = "/";
				}
				if(!$this->DB_WE->query("INSERT INTO " . INDEX_TABLE . " (OID,Text,BText,Workspace,WorkspaceID,Category,ClassID,Title,Description,Path) VALUES(".$this->ID.",'$text','$text','$wsPath','".addslashes($w)."','".mysql_real_escape_string($this->Category)."',".$this->TableID.",'".mysql_real_escape_string($this->getElement("Title"))."','".mysql_real_escape_string($this->getElement("Description"))."','".mysql_real_escape_string($this->Text)."')")) return false;
			}
		}
		return true;
	}

	function markAsPublished(){
		$this->Published=time();
		$this->DB_WE->query("UPDATE " . OBJECT_FILES_TABLE . " SET Published='".$this->Published."' WHERE ID=".$this->ID);
		$this->DB_WE->query("UPDATE ".OBJECT_X_TABLE.$this->TableID." SET OF_Published='".$this->Published."' WHERE OF_ID=".$this->ID);
	}

	function markAsUnPublished(){
		$this->Published=0;
		$this->DB_WE->query("UPDATE " . OBJECT_FILES_TABLE . " SET Published='0' WHERE ID=".$this->ID);
		$this->DB_WE->query("UPDATE ".OBJECT_X_TABLE.$this->TableID." SET OF_Published=0 WHERE OF_ID=".$this->ID);
	}

	function i_convertElemFromRequest($type,&$v,$k){
		if(!$type){
			foreach($this->DefArray as $n=>$foo){
				if(ereg('^([^_]+)_'.$k,$n,$regs)){
					$type = $regs[1];
				}
			}
		}
		if(strlen($v)){
			if($type=="float") $v= str_replace(",",".",$v);
			if($type=="float" || $type=="int") $v = abs($v);
			if($type=="int") $v=floor($v);
		}
		if($type == "text" || $type=="input"){
			if($this->DefArray[$type."_".$k]["forbidphp"] == "on"){
				$v = removePHP($v);
			}
			if($this->DefArray[$type."_".$k]["forbidhtml"] == "on"){
				$v = removeHTML($v);
			}
		}else if($type == "float"){
			$v = we_util::std_numberformat($v);
		}
	}

	function we_initSessDat($sessDat){
		we_document::we_initSessDat($sessDat);
		$this->DefArray = $this->getDefaultValueArray();
		$this->i_objectFileInit();

	}


	function we_ImportSave(){
		$this->Icon="objectFile.gif";
		if(!we_document::we_save(1)) return false;
		if(!$this->ObjectID) return false;
		$this->wasUpdate=1;
		return $this->i_saveTmp();
	}

	function correctWorkspaces(){

		if($this->Workspaces){
			$ws = makeArrayFromCSV($this->Workspaces);
			$newWs = array();
			foreach($ws as $wsID){
				if(f("SELECT ID FROM ".FILE_TABLE." WHERE ID=$wsID	AND IsFolder=1","ID",$this->DB_WE)){
					array_push($newWs,$wsID);
				}else if($wsID==0 && strlen($wsID) == 1){
					array_push($newWs,$wsID);
				}
			}
			$this->Workspaces = makeCSVFromArray($newWs,true);
		}
		if($this->ExtraWorkspaces){
			$ws = makeArrayFromCSV($this->ExtraWorkspaces);
			$newWs = array();
			foreach($ws as $wsID){
				if(f("SELECT ID FROM ".FILE_TABLE." WHERE ID=$wsID	AND IsFolder=1","ID",$this->DB_WE)){
					array_push($newWs,$wsID);
				}
			}
			$this->ExtraWorkspaces = makeCSVFromArray($newWs,true);
		}
		if($this->ExtraWorkspacesSelected){
			$ws = makeArrayFromCSV($this->ExtraWorkspacesSelected);
			$newWs = array();
			foreach($ws as $wsID){
				if(f("SELECT ID FROM ".FILE_TABLE." WHERE ID=$wsID	AND IsFolder=1","ID",$this->DB_WE)){
					array_push($newWs,$wsID);
				}
			}
			$this->ExtraWorkspacesSelected = makeCSVFromArray($newWs,true);
		}
	}

	function we_save($resave=0){
				
		$foo = getHash("SELECT strOrder,DefaultValues FROM " .OBJECT_TABLE . " WHERE ID='".$this->TableID."'",$this->DB_WE);
		$dv = $foo["DefaultValues"] ? unserialize($foo["DefaultValues"]) : array();

		foreach($this->elements as $n=>$elem){
			if(isset($elem["type"]) && $elem["type"] == "text") {
				if(isset($dv["text_$n"]["xml"]) && $dv["text_$n"]["xml"] == "on"){
					//$elem["dat"] = we_xhtmlConverter::correct_HTML_source($elem["dat"],true);
					$this->elements[$n] = $elem;
				}
			}

		}
		if ($this->canHaveVariants()) {

			include_once($_SERVER['DOCUMENT_ROOT'] .'/webEdition/we/include/we_modules/shop/weShopVariants.inc.php');
			weShopVariants::correctModelFields($this);
		}

		$_resaveWeDocumentCustomerFilter = true;
		$this->correctWorkspaces();
		if((!$this->ID || $resave)){
			$_resaveWeDocumentCustomerFilter = false;
			if(!we_document::we_save($resave)) return false;
			if(!$this->ObjectID) return false;
			if($resave){
				if(!$this->we_republish()) return false;
			}
		}
		$this->ModDate = time();
		$this->ModifierID = isset($_SESSION["user"]["ID"]) ? $_SESSION["user"]["ID"] : 0;
		$this->wasUpdate=1;

		if($resave==0 && $this->ID) {
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_history.class.php");
			we_history::insertIntoHistory($this);

		}
		if ($resave==0 && $_resaveWeDocumentCustomerFilter) {
			$this->resaveWeDocumentCustomerFilter();

		}
		
		$a = $this->i_saveTmp();
		
		/* version */
		if($this->ContentType=="objectFile") {
			$version = new weVersions();
			$version->save($this);
			
		}

		$hook = new weHook($this, 'save');
		$hook->executeHook();

		return $a;
	}

	function ModifyPathInformation($parentID){
		$this->setParentID($parentID);
		$this->Path = $this->getPath();
		$this->wasUpdate = 1;
		$this->i_savePersistentSlotsToDB("Text,Path,ParentID");
		$this->i_saveTmp();
		$this->insertAtIndex();
		$this->modifyChildrenPath(); // only on folders, because on other classes this function is empty
	}

	function hasWorkspaces(){
		return f("SELECT Workspaces FROM " .OBJECT_TABLE . " WHERE ID='".$this->TableID."'","Workspaces",$this->DB_WE);
	}

	function setTypeAndLength(){
		if($this->TableID){
			$DataTable = OBJECT_X_TABLE.$this->TableID;
			$db = $this->DB_WE;
			$tableInfo = $db->metadata($DataTable);
			for($i=0;$i<sizeof($tableInfo);$i++){
				if(ereg('^(.+)_(.+)$',$tableInfo[$i]["name"],$regs)){
					if($regs[1] != "OF"){
						$foo = explode("_",$tableInfo[$i]["name"]);
						unset($foo[0]);
						$name = implode("_", $foo);
						$this->elements[$name]["type"] = $regs[1];
						$this->elements[$name]["len"] = $tableInfo[$i]["len"];
					}
				}
			}
		}
	}

	function we_load($from=LOAD_MAID_DB){
		switch($from){
			case LOAD_SCHEDULE_DB:
			$sessDat = unserialize(f("SELECT SerializedData FROM ".SCHEDULE_TABLE." WHERE DID=".$this->ID." AND ClassName='".$this->ClassName."' AND Was='".SCHEDULE_FROM."'","SerializedData",$this->DB_WE));

			if($sessDat){
				$this->i_initSerializedDat($sessDat);
				$this->i_getPersistentSlotsFromDB("Path,Text,ParentID,CreatorID,Published,ModDate,Owners,ModifierID,RestrictOwners,OwnersReadOnly,IsSearchable,Charset");
				$this->i_getUniqueIDsAndFixNames();
				break;
			}else{
				$from = LOAD_MAID_DB;
			}
			case LOAD_MAID_DB:
			we_document::we_load($from);
			break;
			case LOAD_TEMP_DB:
			$sessDat = we_temporaryDocument::load($this->ID, $this->Table, $this->DB_WE);
			if($sessDat){
				$this->i_initSerializedDat($sessDat,false);
				$this->i_getPersistentSlotsFromDB("Path,Text,ParentID,CreatorID,Published,ModDate,Owners,ModifierID,RestrictOwners,OwnersReadOnly,IsSearchable,Charset");
				$this->i_getUniqueIDsAndFixNames();
			}else{
				$this->we_load(LOAD_MAID_DB);
			}
			$this->setTypeAndLength();
			break;
			case LOAD_REVERT_DB:
			$sessDat = we_temporaryDocument::revert($this->ID, $this->Table, $this->DB_WE);
			if($sessDat){
				$this->i_initSerializedDat($sessDat,false);
				$this->i_getPersistentSlotsFromDB("Path,Text,ParentID,CreatorID,Published,ModDate,Owners,ModifierID,RestrictOwners,OwnersReadOnly,IsSearchable,Charset");
				$this->i_getUniqueIDsAndFixNames();
			}else{
				$this->we_load(LOAD_TEMP_DB);
			}
			$this->setTypeAndLength();
			break;
		}
		$this->loadSchedule();
		$this->setTitleAndDescription();
		$this->i_getLinkedObjects();
		$this->initVariantDataFromDb();
		// init Customer Filter !!!!
		if ( isset($this->documentCustomerFilter) && defined( 'CUSTOMER_TABLE' ) ) {
			$this->initWeDocumentCustomerFilterFromDB();

		}
	}

	function i_getUniqueIDsAndFixNames(){
		if(sizeof($this->DefArray)){
			$newDefArr = $this->getDefaultValueArray();
			foreach($newDefArr as $n=>$v){
				if(is_array($v) && isset($v["uniqueID"])){
					if($oldName = $this->i_DefArrayNameNotEqual($n,$v["uniqueID"])){
						$foo = explode("_",$n);
						unset($foo[0]);
						$nn = implode("_", $foo);
						$foo = explode("_",$oldName);
						unset($foo[0]);
						$no = implode("_", $foo);
						$this->elements[$nn] = isset($this->elements[$no]) ? $this->elements[$no] : '';
						unset($this->elements[$no]);
					}
				}
			}
		}
	}

	function i_DefArrayNameNotEqual($name,$uniqueID){
		foreach($this->DefArray as $n=>$v){
			if(is_array($v)  && isset($v["uniqueID"])){
				if($v["uniqueID"] == $uniqueID){
					if($n == $name) return "";
					else return $n;
				}
			}
		}
		return "";
	}

	function we_publish($DoNotMark=false,$saveinMainDB=true){
		if($saveinMainDB){
			if(!we_root::we_save(1)) return false;
		}
		if($DoNotMark==false){
			$this->Published=time();
			if(!$this->DB_WE->query("UPDATE ".$this->Table." SET Published='".$this->Published."' WHERE ID='".$this->ID."'")) return false; // mark the document as published;
			if(!$this->DB_WE->query("UPDATE ".OBJECT_X_TABLE.$this->TableID." SET OF_Published='".$this->Published."' WHERE OF_ID='".$this->ID."'")) return false;
			$this->we_clearCache($this->ID);
		}
		
		$hook = new weHook($this, 'publish');
		$hook->executeHook();

		return $this->insertAtIndex();
	}

	function we_unpublish(){
		if(!$this->ID) return false;
		if(!$this->DB_WE->query("UPDATE ".$this->Table." SET Published='0' WHERE ID='".$this->ID."'")) return false;
		if(!$this->DB_WE->query("UPDATE ".OBJECT_X_TABLE.$this->TableID." SET OF_Published=0 WHERE OF_ID='".$this->ID."'")) return false;
		$this->Published=0;
		$this->we_clearCache($this->ID);
		
		/* version */
		if($this->ContentType=="objectFile") {
			$version = new weVersions();
			$version->save($this, "unpublished");
		}
		
		$hook = new weHook($this, 'unpublish');
		$hook->executeHook();
		
		return $this->DB_WE->query("DELETE FROM " . INDEX_TABLE . " WHERE OID=".$this->ID);
	}

	function we_delete() {
		if(!$this->ID) return false;
		$this->we_clearCache($this->ID);
		return we_document::we_delete();
	}

	function we_republish($rebuildMain=true){
		if($this->Published){
			return $this->we_publish(true,$rebuildMain);
		}else{
			return $this->DB_WE->query("DELETE FROM " . INDEX_TABLE . " WHERE OID=".$this->ID);
		}
	}

	function we_clearCache($id) {

		// Clear cache for this document
		$cacheDir = weCacheHelper::getObjectCacheDir($id);
		weCacheHelper::clearCache($cacheDir);
	}

	function i_objectFileInit($makeSameNewFlag=false){

		if($this->ID){

			$this->setRootDirID();
			$oldTableID = f("SELECT TableID FROM " . OBJECT_FILES_TABLE . " WHERE ID=".$this->ID,"TableID",$this->DB_WE);
			if($oldTableID != $this->TableID){
				$this->resetParentID();
			}
			$this->DB_WE->query("SELECT DefaultValues FROM " .OBJECT_TABLE . " WHERE ID=".$this->TableID);
			if($this->DB_WE->next_record()){
				if($this->DB_WE->f("DefaultValues")){
					$vals = unserialize($this->DB_WE->f("DefaultValues"));
					if(isset($vals["WE_CSS_FOR_CLASS"])){
						$this->CSS = $vals["WE_CSS_FOR_CLASS"];
					}
				}
			}
		}else if(isset($GLOBALS["we_EDITOR"]) && $GLOBALS["we_EDITOR"] && $this->DefaultInit==false && (!$this->ID)){
			if(!$this->TableID){
				$ac = $this->getAllowedClasses();
				$this->AllowedClasses = makeCSVFromArray($ac);
				$this->TableID = $ac[0];

			}
			if($this->TableID){
				$this->setRootDirID();
				if (!$makeSameNewFlag) {
					$this->resetParentID();
				}
				$this->restoreDefaults();
			}
		}else if(isset($GLOBALS["we_EDITOR"]) && $GLOBALS["we_EDITOR"] && (!$this->ID)){
			$_initWeDocumentCustomerFilter = false;
			if (!$this->ParentID) {
				$_initWeDocumentCustomerFilter = true;
			}

			if ($this->Charset == "" && isset($this->DefArray['elements']['Charset'])) {
				$this->Charset = $this->DefArray['elements']['Charset']['dat'];
			}

			$this->setRootDirID();
			if(!isset($this->ParentID)) {
				$this->resetParentID();
			}

			if ($_initWeDocumentCustomerFilter) {
				// get customerFilter of parent Folder
				$_tmpFolder = new we_class_folder();
				$_tmpFolder->initByID($this->rootDirID, $this->Table);
				$this->documentCustomerFilter = $_tmpFolder->documentCustomerFilter;
				unset($_tmpFolder);

			}
		}
	}

	function i_set_PersistentSlot($name,$value){
		if(in_array($name,$this->persistent_slots)){
			eval('$this->'.$name.'=$value;');
		}else{
			if($name == "Templates_0"){

				$this->Templates="";
				for($i=0;$i<sizeof(makeArrayFromCSV($this->Workspaces));$i++){
					$this->Templates .= $_REQUEST["we_".$this->Name."_Templates_".$i].",";
				}
				if($this->Templates) $this->Templates = ",".$this->Templates;
			}else if($name == "we_".$this->Name."_ExtraTemplates_0"){
				$this->ExtraTemplates="";
				for($i=0;$i<sizeof(makeArrayFromCSV($this->ExtraWorkspaces));$i++){
					$this->ExtraTemplates .= $_REQUEST["we_".$this->Name."_ExtraTemplates_".$i].",";
				}
				if($this->ExtraTemplates) $this->ExtraTemplates = ",".$this->ExtraTemplates;
			}

		}
	}

	function i_getLinkedObjects(){
		if($this->TableID){
			$linkObjects = array();
			$tableInfo = $this->getSortedTableInfo($this->TableID,false,$this->DB_WE);

			for($i=0;$i<sizeof($tableInfo);$i++){
				if(ereg('^(.+)_(.+)$',$tableInfo[$i]["name"],$regs)){
					if($regs[1] != "OF"){
						if($regs[1] == "object"){
							$id=$this->getElement("we_".$tableInfo[$i]["name"]);
							if($id) array_push($linkObjects,$id);
						}
					}
				}
			}
			foreach($linkObjects as $id){
				$tmpObj = new we_objectFile();
				$tmpObj->initByID($id,OBJECT_FILES_TABLE,0);
				foreach($tmpObj->elements as $n=>$elem){
					if($elem["type"] != "object" &&  $n != "Title" && $n != "Description"){
						$this->elements[$n] = $elem;
					}
				}
			}
		}
	}

	function i_getContentData($loadBinary=0){

		if(!$this->TableID) return;
		$ID = $this->ObjectID;
		$DataTable = OBJECT_X_TABLE.$this->TableID;
		$db = $this->DB_WE;
		$tableInfo = $this->getSortedTableInfo($this->TableID,false,$db);

		$db->query("SELECT * FROM $DataTable WHERE ID='$ID'");
		if($db->next_record()){
			for($i=0;$i<sizeof($tableInfo);$i++){
				if(ereg('^(.+)_(.+)$',$tableInfo[$i]["name"],$regs)){
					if($regs[1] != "OF"){

						$foo = explode("_",$tableInfo[$i]["name"]);
						unset($foo[0]);
						$realname = implode("_", $foo);
						if($regs[1] == "object"){
							$name = "we_object_".$realname;
						}else{
							$name = $realname;
						}
//						if($regs[1] == "multiobject"){
//							$this->elements[$name]["class"] = $db->f($tableInfo[$i]["name"]);
//						}
						if($regs[1] == "img"){
							$this->elements[$name]["bdid"] = $db->f($tableInfo[$i]["name"]);
						}
						$this->elements[$name]["dat"] = $db->f($tableInfo[$i]["name"]);
						$this->elements[$name]["type"] = $regs[1];
						$this->elements[$name]["len"] = $tableInfo[$i]["len"];
					}
				}
			}
			// add variant data if available
			if (defined('SHOP_TABLE')) {

				$fieldname = 'variant_' . WE_SHOP_VARIANTS_ELEMENT_NAME;
				$elementName =  WE_SHOP_VARIANTS_ELEMENT_NAME;

				if ($db->f($fieldname)) {

					$this->elements[$elementName]["dat"]  = $db->f($fieldname);
					$this->elements[$elementName]["type"] = 'variant';
					$this->elements[$elementName]["len"]  = strlen($db->f($fieldname));
				}
			}
		}
	}


	function i_setText(){
		// do nothing here!
	}

	function i_filenameEmpty(){
		return ($this->Text == "") ? true : false;
	}

	function i_filenameNotValid(){
		return eregi('[^a-z0-9\._\-]',$this->Text);
	}

	function i_filenameNotAllowed(){
		return false;
	}

	function i_filenameDouble(){
		return f("SELECT ID FROM ".$this->Table." WHERE ParentID=".$this->ParentID." AND Text='".mysql_real_escape_string($this->Text)."' AND ID!='".$this->ID."'","ID",new DB_WE());
	}


	function i_checkPathDiffAndCreate(){
		return true;
	}


	function i_scheduleToBeforeNow(){
		if(defined("SCHEDULE_TABLE")){
			if($this->To < time() && $this->ToOk){
				return true;
			}
		}
		return false;
	}

	function i_publInScheduleTable(){
		if(defined("SCHEDULE_TABLE")){
			$this->DB_WE->query("DELETE FROM ".SCHEDULE_TABLE." WHERE DID='".$this->ID."' AND ClassName='".$this->ClassName."'");
			$ok = true;
			$makeSched = false;
			foreach($this->schedArr as $s){
				if($s["task"] == SCHEDULE_FROM && $s["active"]){
					$serializedDoc = we_temporaryDocument::load($this->ID,$this->Table,$this->DB_WE);
					$makeSched = true;
				}else{
					$serializedDoc = "";
				}
				include_once(WE_SCHEDULE_MODULE_DIR."we_schedpro.inc.php");
				$Wann = we_schedpro::getNextTimestamp($s,time());

				if(!$this->DB_WE->query("INSERT INTO ".SCHEDULE_TABLE.
				" (DID,Wann,Was,ClassName,SerializedData,Schedpro,Type,Active)
						VALUES('".$this->ID."','".$Wann."','".$s["task"]."','".$this->ClassName."','".mysql_real_escape_string(serialize($serializedDoc))."','".mysql_real_escape_string(serialize($s))."','".$s["type"]."','".$s["active"]."')")) return false;
			}
			return $makeSched;
		}
		return false;
	}

	function i_writeDocument(){
		return true;// do nothing;
	}

	function isColExist($tab,$col){
			global $DB_WE;
			$DB_WE->query("SHOW COLUMNS FROM ".$tab." LIKE '$col';");
			if($DB_WE->next_record()) return true; else return false;
	}

	function addCol($tab,$col,$typ,$pos=""){
			   global $DB_WE;
			   $DB_WE->query("ALTER TABLE $tab ADD $col $typ".(($pos!="") ? " ".$pos : "").";");
	}
	
	function getContentDataFromTemporaryDocs($ObjectID,$loadBinary=0){

		$db = $this->DB_WE;

		$query = "SELECT * FROM " . TEMPORARY_DOC_TABLE . " WHERE DocumentID='$ObjectID' AND Active=1 AND  DocTable='".OBJECT_FILES_TABLE."'";

		$db->query($query);
		
		if($db->next_record()){
			
			if($db->f("DocumentObject")!="") {
				$DocumentObject = unserialize($db->f("DocumentObject"));
			}

		}
		if(isset($DocumentObject[0]["elements"]) && is_array($DocumentObject[0]["elements"])) {
			$this->elements = $DocumentObject[0]["elements"];
		}
		
	}

	function i_saveContentDataInDB(){



		$ctable = OBJECT_X_TABLE.$this->TableID;

		// updater
		if(!$this->isColExist($ctable,"OF_WebUserID")) $this->addCol($ctable,"OF_WebUserID","BIGINT DEFAULT '0' NOT NULL", "AFTER OF_Charset");

		$tableInfo = $this->DB_WE->metadata($ctable);
		$foo = f("SELECT DefaultValues FROM " .OBJECT_TABLE . " WHERE ID=".$this->TableID,"DefaultValues",$this->DB_WE);
		if($foo){
			$defVal = unserialize($foo);
		}else{
			$defVal = array();
		}
		if(!$this->wasUpdate){
			$keys = "(";
			$values = "VALUES(";
			$this->CreatorID = $this->CreatorID ? $this->CreatorID : (isset($_SESSION["user"]["ID"]) ? $_SESSION["user"]["ID"] : 0);
			for($i=0;$i<sizeof($tableInfo);$i++){
				if(ereg('^(.+)_(.+)$',$tableInfo[$i]["name"],$regs)){
					$foo = explode("_",$tableInfo[$i]["name"]);
					unset($foo[0]);
					$name = implode("_", $foo);
					if($regs[1] == "OF"){
						$keys .= $tableInfo[$i]["name"] . ",";
						eval('$values .= "\'".(isset($this->'.$name.') ? addslashes($this->'.$name.') : "")."\',";');
					}else{
						$name = ($regs[1] == "object") ? ("object_".$name) : $name;
						$keys .= $tableInfo[$i]["name"] . ",";
						$foo = $this->getElement($name);
						$values .= "'".addslashes($foo)."',";
					}
				}
			}
			$keys = ereg_replace('^(.+),$','\1',$keys) . ")";
			$values = ereg_replace('^(.+),$','\1',$values) . ")";
			if($this->DB_WE->query("INSERT INTO $ctable $keys $values")){
				$this->ObjectID = f("SELECT MAX(LAST_INSERT_ID()) as LastID FROM $ctable","LastID",$this->DB_WE);
				return true;
			}else{
				return false;
			}
		}else{
			if($this->ExtraWorkspacesSelected){
				$ews = makeArrayFromCSV($this->ExtraWorkspacesSelected);
				$ew = makeArrayFromCSV($this->ExtraWorkspaces);
				$newews = array();
				foreach($ews as $ws){
					if(in_array($ws,$ew)){
						array_push($newews,$ws);
					}
				}
				$this->ExtraWorkspacesSelected = makeCSVFromArray($newews,true);
			}
			$q = "";
			for($i=0;$i<sizeof($tableInfo);$i++){
				if(ereg('^(.+)_(.+)$',$tableInfo[$i]["name"],$regs)){
					$foo = explode("_",$tableInfo[$i]["name"]);
					unset($foo[0]);
					$name = implode("_", $foo);
					if($regs[1] == "OF"){
						$q .= $tableInfo[$i]["name"] . "=";
						eval('$q .= "\'".addslashes($this->'.$name.')."\',";');
					}else{
						if($regs[1] == "object") {
							$name = "we_object_".$name;
						}
						$q .= $tableInfo[$i]["name"] . "=";
						$foo = $this->getElement($name);
						$q .= "'".addslashes($foo)."',";
					}
				}
			}
			$q = ereg_replace('^(.+),$','\1',$q);
			return $this->DB_WE->query("UPDATE $ctable SET $q WHERE ID='".$this->ObjectID."'");
		}
		return false;
	}

	function i_saveTmp(){
		$saveArr = array();
		$this->saveInSession($saveArr);
		if(!we_temporaryDocument::save($this->ID, $this->Table, $saveArr, $this->DB_WE)) return false;
		if($this->ID) $this->DB_WE->query("UPDATE ".OBJECT_X_TABLE.$this->TableID." SET OF_TEXT='".$this->Text."',OF_PATH='".$this->Path."' WHERE OF_ID=".$this->ID);
		return $this->i_savePersistentSlotsToDB("Path,Text,ParentID,CreatorID,ModifierID,RestrictOwners,Owners,OwnersReadOnly,Published,ModDate,ObjectID,IsSearchable,Charset");
	}

	function i_getDocument($includepath="") {

		$glob = "";
		foreach($GLOBALS as $k=>$v){
			if((!ereg('^[0-9]',$k)) && (!eregi('[^a-z0-9_]',$k)) && $k != "_SESSION" && $k != "_GET" && $k != "_POST" && $k != "_REQUEST" && $k != "_SERVER" && $k != "_FILES" && $k != "_SESSION" && $k != "_ENV" && $k != "_COOKIE") $glob .= '$'.$k.",";
		}
		$glob = ereg_replace('(.*),$','\1',$glob);
		eval('global '.$glob.';');  // globalen Namensraum herstellen.

		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_webEditionDocument.inc.php");
		$we_doc = new we_webEditionDocument();
		$we_doc->elements = $this->elements;
		$we_doc->Templates = $this->Templates;
		$we_doc->ExtraTemplates = $this->ExtraTemplates;
		$we_doc->TableID = $this->TableID;
		$we_doc->CreatorID = $this->CreatorID;
		$we_doc->ModifierID = $this->ModifierID;
		$we_doc->RestrictOwners = $this->RestrictOwners;
		$we_doc->Owners = $this->Owners;
		$we_doc->OwnersReadOnly = $this->OwnersReadOnly;
		$we_doc->Category = $this->Category;
		$we_doc->ObjectID=$this->ObjectID;
		$we_doc->OF_ID=$this->ID;

		$we_doc->InWebEdition = false;
		$we_include = $includepath ? $includepath : $we_doc->TemplatePath;
   		ob_start();
    	include($we_include);
    	$contents = ob_get_contents();
    	ob_end_clean();
		return $contents;
	}

	function i_setElementsFromHTTP(){
		we_document::i_setElementsFromHTTP();
		if(sizeof($_REQUEST)){

			$hrefFields = false;

			foreach($_REQUEST as $n=>$v){
				if(ereg('^we_'.$this->Name.'_([^\[]+)$',$n,$regs)){
					if($regs[1]=="href"){
						$hrefFields = true;
						break;
					}
				}
			}

			if($hrefFields){
				$this->resetElements();
				$hrefs = array();
				while(list($k,$v) = $this->nextElement("href")){
					$realName = ereg_replace("^(.+)_we_jkhdsf_.+$",'\1',$k);
					$key = ereg_replace("^.+_we_jkhdsf_(.+)$",'\1',$k);
					if(!isset($hrefs[$realName])) $hrefs[$realName] = array();
					$hrefs[$realName][$key] = $v["dat"];
				}
				foreach($hrefs as $k=>$v){
					$this->setElement($k,serialize($v));
				}
			}

			$multiobjectFields = false;

			foreach($_REQUEST as $n=>$v){
				if(ereg('^we_'.$this->Name.'_([^\[]+)$',$n,$regs)){
					if($regs[1]=="multiobject"){
						$multiobjectFields = true;
						break;
					}
				}
			}

			if($multiobjectFields){
				$this->resetElements();
				$multiobjects = array();
				while(list($k,$v) = $this->nextElement("multiobject")){
					$realName = ereg_replace("^(.+)_default.+$",'\1',$k);
					$key = ereg_replace("^.+_default(.+)$",'\1',$k);
					if(!isset($multiobjects[$realName])) $multiobjects[$realName] = array();
					if(isset($_REQUEST['we_'.$this->Name.'_multiobject'][$k])) {
						$multiobjects[$realName][$key] = $_REQUEST['we_'.$this->Name.'_multiobject'][$k];
					}
				}
				foreach($multiobjects as $realName => $data) {
					$old = unserialize($this->getElement($realName));
					$temp = array(
						'class' => $old['class'],
						'max' => $old['max'],
						'objects' => $data,
					);
					$this->setElement($realName,serialize($temp));
				}
			}

		}
	}


	function userCanSave(){

		if(!defined("BIG_USER_MODULE") || !in_array("busers",$GLOBALS["_pro_modules"])){
			return true;
		}
		if($_SESSION["perms"]["ADMINISTRATOR"]){
			return true;
		}
		include_once(WE_USERS_MODULE_DIR . "we_users_util.php");
		if( !we_hasPerm("CAN_SEE_OBJECTFILES") ){
			return false;
		}
		if(!$this->RestrictOwners){
			return true;
		}

		$ownersReadOnly = $this->OwnersReadOnly ? unserialize($this->OwnersReadOnly) : array();
		$readers=array();
		foreach(array_keys($ownersReadOnly) as $key){
			if(isset($ownersReadOnly[$key]) && $ownersReadOnly[$key] == 1) $readers[]=$key;
		}
		return !isUserInUsers($_SESSION["user"]["ID"],$readers);
	}

	/**
	 * @return bool
	 * @desc	checks if the user has the right to see an objectfile
 	 */
	function userHasPerms(){
		if(!defined("BIG_USER_MODULE") || !in_array("busers",$GLOBALS["_pro_modules"]))
			return true;
		if($_SESSION["perms"]["ADMINISTRATOR"])
			return true;
		if(!we_hasPerm("CAN_SEE_OBJECTFILES"))
			return false;
		if(!$this->RestrictOwners)
			return true;
		if(we_isOwner($this->Owners) || we_isOwner($this->CreatorID))
			return true;
		return false;
	}

	/**
	 * checks if this object can have variants
	 *
	 * if paramter checkField is true, this function checks also, if there are
	 * already fields selected for the variants.
	 *
	 * @return boolean
	 */
	function canHaveVariants($checkFields = false) {
		if(!defined('SHOP_TABLE')) {
			return false;
		}
		if($this->TableID==0){
			return false;
		}
		require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_modules/object/we_object.inc.php');
		$object = new we_object();
		$object->initByID($this->TableID,OBJECT_TABLE);

		if ($checkFields) {
			return $object->canHaveVariants() && sizeof($object->getVariantFields());
		} else {
			return $object->canHaveVariants();
		}
	}

	function initByID($we_ID, $we_Table=OBJECT_FILES_TABLE, $from=LOAD_MAID_DB) {

		parent::initByID($we_ID, $we_Table, $from);

		if (isset($this->elements['Charset'])) {
			$this->Charset = $this->elements['Charset']['dat'];
			unset($this->elements['Charset']);
		}

		// Fix for added field OF_IsSearchable
		if($this->IsSearchable <> 1 && $this->IsSearchable <> 0) {
			$this->IsSearchable = true;
		}
	}

	function initVariantDataFromDb() {

		if (defined('WE_SHOP_VARIANTS_ELEMENT_NAME') && isset($this->elements[WE_SHOP_VARIANTS_ELEMENT_NAME])) {

			include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_modules/shop/weShopVariants.inc.php');

			if (!isset($this->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['dat']) || !is_array( $this->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['dat'] )) {
				// unserialize the variant data when loading the model
				$this->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['dat'] = unserialize($this->elements[WE_SHOP_VARIANTS_ELEMENT_NAME]['dat']);
			}
			weShopVariants::setVariantDataForModel($this);
		}
	}

	/**
	 * @return	array with the filed names as keys and attributes as values
	 */
	function getVariantFields(){
		if($this->TableID==0) return array();
		require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_modules/object/we_object.inc.php');
		$object = new we_object();
		$object->initByID($this->TableID,OBJECT_TABLE);
		return $object->getVariantFields();
	}

	function downMetaAtObject($name,$i){
		$old = unserialize($this->getElement($name));
		$objects = $old['objects'];
		$temp = $objects[($i+1)];
		$objects[($i+1)] = $objects[$i];
		$objects[$i] = $temp;
		$new = array(
			'class' => $old['class'],
			'max' => $old['max'],
			'objects' => $objects,
		);
		$this->setElement($name, serialize($new));
	}

	function upMetaAtObject($name,$i){
		$old = unserialize($this->getElement($name));
		$objects = $old['objects'];
		$temp = $objects[($i-1)];
		$objects[($i-1)] = $objects[$i];
		$objects[$i] = $temp;
		$new = array(
			'class' => $old['class'],
			'max' => $old['max'],
			'objects' => $objects,
		);
		$this->setElement($name, serialize($new));
	}

	function addMetaToObject($name,$pos) {
		$amount = 1;
		$old = unserialize($this->getElement($name));
		$objects = $old['objects'];
		for($i=sizeof($objects)+$amount-1; 0 <= $i; $i--){
			if ( ($pos + $amount) < $i  ) {
				$objects[$i] = $objects[($i-$amount)];
			} else if( $pos < $i && $i <= ($pos + $amount)  ) {
				$objects[$i] = "";
			}
		}
		$new = array(
			'class' => $old['class'],
			'max' => $old['max'],
			'objects' => $objects,
		);
		$this->setElement($name, serialize($new));
	}

	function removeMetaFromObject($name,$nr) {
		$old = unserialize($this->getElement($name));
		$objects = $old['objects'];
		for($i=0; $i < sizeof($objects)-1; $i++){
			if($i >= $nr){
				$objects[$i] = $objects[($i+1)];
			}
		}
		unset($objects[$i]);
		$new = array(
			'class' => $old['class'],
			'max' => $old['max'],
			'objects' => $objects,
		);
		$this->setElement($name, serialize($new));
	}
}
?>