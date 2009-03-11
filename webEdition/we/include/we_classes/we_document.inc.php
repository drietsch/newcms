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
 * @package    webEdition_class
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."we_root.inc.php");

if(!isset($GLOBALS["WE_IS_DYN"])){
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_live_tools.inc.php");
}
if(!isset($GLOBALS["WE_IS_IMG"])){
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/charsetHandler.class.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."we_folder.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_tag.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/date.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/weModuleInfo.class.php");
	if (defined("CUSTOMER_FILTER_TABLE")) {
		include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_modules/customer/weDocumentCustomerFilter.class.php');
	}
}
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_versions/weVersions.class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_hook/class/weHook.class.php");

/* the parent class for documents */
class we_document extends we_root {

	/*
	* Variables
	*/

	/* Name of the class => important for reconstructing the class from outside the class */
	var $ClassName="we_document";

	/* Extension of the document */
	var $Extension="";

	/* Array of possible extensions for the document */
	var $Extensions;
	var $Published=0;

	var $Language="";

	/* If the file should only be saved in the db */
	var $IsDynamic=0;
	var $Table=FILE_TABLE;
	var $schedArr = array();

	/* Categories of the document */
	var $Category="";

	var $IsSearchable = "";
	
	var $InGlossar = 0;

	var $NavigationItems='';

	/*
	* Functions
	*/

	// Constructor
	function we_document() {
		$this->we_root();
		array_push($this->persistent_slots,"Extension","IsDynamic","Published","Category","IsSearchable","InGlossar","Language");
		array_push($this->persistent_slots,"schedArr");
	}

	function copyDoc($id) {
		if($id) {
			eval('$doc = new '.$this->ClassName.'();');
			$doc->InitByID($id,$this->Table);
			$parentIDMerk=$doc->ParentID;
			if($this->ID==0) {
				for($i=0;$i<sizeof($this->persistent_slots);$i++) {
					if($this->persistent_slots[$i] != "elements") {
						if(in_array($this->persistent_slots[$i], array_keys(get_object_vars($doc)))) {
							eval('$this->'.$this->persistent_slots[$i].'=$doc->'.$this->persistent_slots[$i].';');
						}
					}
				}
				$this->Published=0;
				if(isset($doc->Category)) {
					$this->Category = $doc->Category;
				}
				$this->CreationDate=time();
				$this->CreatorID=$_SESSION["user"]["ID"];

				$this->ID=0;
				$this->OldPath="";
				$this->Filename .= "_copy";
				$this->Text=$this->Filename.$this->Extension;
				$this->setParentID($parentIDMerk);
				$this->Path=$this->ParentPath.$this->Text;
				$this->OldPath=$this->Path;
			}
			$this->elements = $doc->elements;
			foreach($this->elements as $n=>$e){
				$this->elements[$n]["cid"] = 0;
			}
			$this->EditPageNr = 0;
			$this->InWebEdition=1;
			if (isset($this->documentCustomerFilter)) {
				$this->documentCustomerFilter = $doc->documentCustomerFilter;
			}
		}
	}

	/* gets the filesize of the document */
	function getFilesize(){
		return strlen($this->elements["data"]["dat"]);
	}

	// returns the whole document Alias - don't remove
	function getDocument($we_editmode="0",$baseHref="0",$we_transaction="") {
		return $this->i_getDocument();
	}


	function initLanguageFromParent() {
		$ParentID = $this->ParentID;
		$i = 0;
		while($this->Language == "") {
			if($ParentID == 0 || $i > 20) {
				we_loadLanguageConfig();
				$this->Language = we_document::getDefaultLanguage();
				if($this->Language == "") {
					$this->Language = "de_DE";
				}
			} else {
				$Query = "SELECT Language, ParentID FROM " . mysql_real_escape_string($this->Table) . " WHERE ID = " . abs($ParentID);
				$this->DB_WE->query($Query);

				while($this->DB_WE->next_record()) {
					$ParentID = $this->DB_WE->f("ParentID");
					$this->Language = $this->DB_WE->f("Language");

				}

			}
			$i++;

		}
	}

	function getDefaultLanguage() {
		// get interface languae of user
		$_userLanguage = isset($_SESSION["prefs"]["Language"]) ? $_SESSION["prefs"]["Language"] : "";
		$_parts = explode("_", $_userLanguage);
		$_userLanguage = $_parts[0];

		// trying to get locale string out of interface languae
		$_key = "";
		foreach ($GLOBALS["WE_LANGS"] as $_k=>$_v) {
			if ($_v == $_userLanguage) {
				$_key = $_k;
				break;
			}
		}

		$_defLang = $GLOBALS['weDefaultFrontendLanguage'];

		// if default language is not equal with frontend language
		if (substr($_defLang,0,strlen($_key)) !== $_key) {
			// get first language that fits
			foreach($GLOBALS["weFrontendLanguages"] as $_k=>$_v) {
				$_parts = explode("_", $_k);
				if ($_parts[0] === $_key) {
					$_defLang = $_k;
				}
			}
		}
		return $_defLang;
	}

	/*
	* Form Functions
	*/


	function formLanguage($withHeadline = true) {

		we_loadLanguageConfig();

		$_defLang = we_document::getDefaultLanguage();


		$value = ($this->Language!=""?$this->Language:$_defLang);

		$inputName = "we_".$this->Name."_Language";

		$_languages = $GLOBALS['weFrontendLanguages'];

		$_headline = '';

		if($withHeadline){
			$_headline = '
				<tr>
					<td class="defaultfont">' . $GLOBALS["l_we_class"]["language"] . '</td>
				</tr>
			';
		}
		$content = '
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						'.getPixel(2,4).'</td>
				</tr>
				'. $_headline . '
				<tr>
					<td>
						' . $this->htmlSelect($inputName, $_languages, 1, $value, false, " onblur=\"_EditorFrame.setEditorIsHot(true);\" onchange=\"_EditorFrame.setEditorIsHot(true);\"", "value", 508) . '</td>
				</tr>
			</table>';
		return $content;

	}
	
	function formInGlossar($leftwidth=100){
		global $l_we_class;
		$n = "we_".$this->Name."_InGlossar";
		
		$glossarActivated = we_getModuleNameByContentType('glossary');

		if($glossarActivated=='glossary') {
			$v = $this->InGlossar;
			return we_forms::checkboxWithHidden($v ? true : false, $n, $l_we_class["InGlossar"],false,"defaultfont","_EditorFrame.setEditorIsHot(true);");
		}
		else {
			return''; 
		}
	}

	function formIsSearchable($leftwidth=100){
		global $l_we_class;
		$n = "we_".$this->Name."_IsSearchable";

		if( (defined('ISP_VERSION') && ISP_VERSION) && ISP_TYPE == 'small' ){
		    return '<input type="hidden" name="' . $n . '" value="1">';
		}


		$v = $this->IsSearchable;
 		return we_forms::checkboxWithHidden($v ? true : false, $n, $l_we_class["IsSearchable"],false,"defaultfont","_EditorFrame.setEditorIsHot(true);");
 	}

 	function formExtension2() {
		global $l_we_class;
		$doctype = isset($this->DocType) ? $this->DocType : "";

		if($this->ID==0 && $_REQUEST["we_cmd"][0] == "load_editor" && $doctype == ""){	//	Neues Dokument oder Dokument ohne DocType

			if($this->ContentType=="text/html"){				//	is HTML-File
				$selected=(defined("DEFAULT_HTML_EXT") ? DEFAULT_HTML_EXT : ".html");
			} else if($this->ContentType=="text/webedition") {	//	webEdition Document
				if($this->IsDynamic==1){						//	dynamic
					$selected=(defined("DEFAULT_DYNAMIC_EXT") ? DEFAULT_DYNAMIC_EXT : ".php");
				} else {										//	static
					$selected=(defined("DEFAULT_STATIC_EXT") ? DEFAULT_STATIC_EXT : ".html");
				}
			} else {											//	no webEdition Document
				$selected=$this->Extension;
			}
		} else {	//	bestehendes Dokument oder Dokument mit DocType
            $selected=$this->Extension;
		}
		return $this->htmlFormElementTable(getExtensionPopup("we_".$this->Name."_Extension",$selected,$this->Extensions,100,'onselect="_EditorFrame.setEditorIsHot(true);"'),$l_we_class["extension"]);
	}

	function formPath() {
		global $l_we_class;

		$disable = (($this->ContentType == "text/html" || $this->ContentType == "text/webedition") && $this->Published);
		$content = $disable ? ('<span class="defaultfont">'.$this->Path.'</span>') : '
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						'.$this->formInputField("","Filename",$l_we_class["filename"],30,388,255,'onChange="_EditorFrame.setEditorIsHot(true);if(self.pathOfDocumentChanged){pathOfDocumentChanged();}"').'</td>
					<td></td>
					<td>
						'.$this->formExtension2().'</td>
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
						'.$this->formDirChooser(388).'</td>
				</tr>
			</table>';
		return $content;
	}

	function formMetaInfos() {
		global $l_we_class;

		$content = '
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="2">
						'.$this->formInputField("txt","Title",$l_we_class["Title"],40,508,"","onChange=\"_EditorFrame.setEditorIsHot(true);\"").'</td>
				</tr>
				<tr>
					<td>
						'.getPixel(2,4).'</td>
				</tr>
				<tr>
					<td colspan="2">
						'.$this->formInputField("txt","Description",$l_we_class["Description"],40,508,"","onChange=\"_EditorFrame.setEditorIsHot(true);\"").'</td>
				</tr>
				<tr>
					<td>
						'.getPixel(2,4).'</td>
				</tr>
				<tr>
					<td colspan="2">
						'.$this->formInputField("txt","Keywords",$l_we_class["Keywords"],40,508,"","onChange=\"_EditorFrame.setEditorIsHot(true);\"").'</td>
				</tr>';

			$content .= '</table>';
			if($this->ContentType == "image/*" && (isset($_REQUEST["we_cmd"][1]) && $_REQUEST["we_cmd"][1] != "1")) {
				$content .= $this->formCharset(true);

				$content .= $this->formLanguage(true);
			}
		return $content;
	}

	function formCategory() {
		global $l_global;
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirChooser.inc.php");

		$we_button = new we_button();
		$delallbut = $we_button->create_button("delete_all","javascript:we_cmd('delete_all_cats')",true,-1,-1,"","",$this->Category ? false : true);
		$addbut    = $we_button->create_button("add", "javascript:we_cmd('openCatselector','','" . CATEGORY_TABLE . "','','','opener.setScrollTo();fillIDs();opener.top.we_cmd(\\'add_cat\\',top.allIDs);')");
		$cats = new MultiDirChooser(508,$this->Category,"delete_cat", $we_button->create_button_table(array($delallbut, $addbut)),"","Icon,Path", CATEGORY_TABLE);
		$cats->extraDelFn = 'setScrollTo();';
		if(!we_hasPerm("EDIT_KATEGORIE")) {
			$cats->isEditable=false;
		}
		return $cats->get();
	}

	function formNavigation() {
		global $l_global;
		include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/MultiFileChooser.inc.php');
		include($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/navigation.inc.php');

		$we_button = new we_button();

		$delallbut = $we_button->create_button("delete_all","javascript:if(confirm('".$l_navigation['dellall_question']."')) we_cmd('delete_all_navi')",true,-1,-1,"","",(we_hasPerm('EDIT_NAVIGATION') && $this->NavigationItems) ? false : true);

		$addbut    = $we_button->create_button("add", "javascript:we_cmd('tool_navigation_edit_navi',0)",true,100,22,'','',(we_hasPerm('EDIT_NAVIGATION') && $this->ID && $this->Published) ? false : true,false);

		$navis = new MultiFileChooser(508,$this->NavigationItems,"delete_navi", $we_button->create_button_table(array($delallbut, $addbut)),"tool_navigation_edit_navi","Icon,Path", NAVIGATION_TABLE);
		$navis->extraDelFn = 'setScrollTo();';

		if(!we_hasPerm('EDIT_NAVIGATION')) {
			$navis->isEditable=false;
			$navis->CanDelete=false;
		}

		return 	we_htmlElement::jsElement($we_button->create_state_changer(false)) .
				$navis->get();
	}

	function addCat($id) {
		$cats = makeArrayFromCSV($this->Category);
		$ids = makeArrayFromCSV($id);
		foreach($ids as $id){
			if($id && (!in_array($id,$cats))) {
				array_push($cats,$id);
			}
		}
		$this->Category=makeCSVFromArray($cats,true);
	}

	function delCat($id) {
		$cats = makeArrayFromCSV($this->Category);
		if(in_array($id,$cats)){
			$pos = getArrayKey($id,$cats);
			if($pos != "" || $pos=="0"){
				array_splice($cats,$pos,1);
			}
		}
		$this->Category=makeCSVFromArray($cats,true);
	}

	function addNavi($id,$text,$parentid,$ordn) {
		if($this->ID) {
			require($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/class/weNavigation.class.php');

			$navis = makeArrayFromCSV($this->NavigationItems);

			if(is_numeric($ordn)){
					$ordn--;
			}
			if($ordn=='end') {
				$_ord = 10000;
			} else if(is_numeric($ordn) && $ordn>0) {
				$_ord = $ordn;
			} else {
				$_ord = 0;
			}

			$_ppath = id_to_path($parentid,NAVIGATION_TABLE);
			$_new_path = $_ppath=='/' ? $_ppath . $text : $_ppath . '/' . $text;
			$_old_path = '';

			$rename = false;
			if(empty($id)) {
				$id = path_to_id($_new_path,NAVIGATION_TABLE);
				if($id) {
					$rename = true;
				}
			}

			$_naviItem = new weNavigation($id);
			if($id) {
				$_old_path = $_naviItem->Path;
			}

			$_naviItem->Ordn = $_ord;
			$_naviItem->ParentID = $parentid;
			$_naviItem->LinkID = $this->ID;
			$_naviItem->Text = $text;
			$_naviItem->Path = $_new_path;
			$_naviItem->Selection = 'static';
			$_naviItem->SelectionType = 'docLink';

			$_naviItem->save();
			$_naviItem->setOrdn($_ord);
			// replace or set new item in the multi selector
			if($id && !$rename) {
				foreach ($navis as $_k=>$_v){
					if($_old_path==$_v){
						$navis[$_k]=$_new_path;
					}
				}
			} else {
				$navis[] = $_new_path;
			}

			$this->NavigationItems=makeCSVFromArray($navis,true);
		}
	}

	function delNavi($path) {

		require($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/class/weNavigation.class.php');
		$navis = makeArrayFromCSV($this->NavigationItems);
		if(in_array($path,$navis)){
			$pos = getArrayKey($path,$navis);
			if($pos != "" || $pos=="0"){
				array_splice($navis,$pos,1);
				$_itemid = f('SELECT ID FROM '.NAVIGATION_TABLE.' WHERE Path="'.mysql_real_escape_string($path).'" AND Selection="static" AND SelectionType="docLink" AND LinkID='.abs($this->ID).';','ID',$this->DB_WE);
				if($_itemid) {
					$_naviItem = new weNavigation($_itemid);
					$_naviItem->delete();
				}
			}
		}
		$this->NavigationItems=makeCSVFromArray($navis,true);
	}

	function delAllNavi() {
		require($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/class/weNavigation.class.php');
		$navis = makeArrayFromCSV($this->NavigationItems);
		foreach($navis as $_path) {
			$_id = path_to_id($_path,NAVIGATION_TABLE);
			$_naviItem = new weNavigation($_id);
			$_naviItem->delete();
		}

		$this->NavigationItems='';
	}

	/*
	* internal functions
	*/

	function getParentIDFromParentPath() {
		$f = new we_folder();
		if(!$f->initByPath($this->ParentPath))
			return -1;
		return $f->ID;
	}


	function addEntryToList($name,$number=1) {
		$list = $this->getElement($name);
		if($list) {
			$listarray = unserialize($list);
		}
		else {
			$listarray = array();
		}
		for($f=0;$f<$number;$f++){
			$content = $this->getElement($name,"content");

			$new_nr = $this->getMaxListArrayNr($listarray) + 1;

			// clear value
			$names = $this->getNamesFromContent($content);

			for($i=0;$i<sizeof($names);$i++) {
				$this->setElement($names[$i]."_".$new_nr,"");
			}

			array_push($listarray,"_".$new_nr);
		}
		$list = serialize($listarray);
		$this->setElement($name,$list);
	}


	function getMaxListArrayNr($la) {
		$maxnr = 0;
		for($i=0;$i<sizeof($la);$i++) {
			$nr = abs(ereg_replace("_","",$la[$i]));
			$maxnr=max($maxnr,$nr);
		}
		return $maxnr;
	}

	function insertEntryAtList($name,$nr,$number=1) {
		$list = $this->getElement($name);
		if($list) {
			$listarray = unserialize($list);
		}
		else {
			$listarray = array();
		}

		for($f=0;$f<$number;$f++){

			$content = $this->getElement($name,"content");
			$new_nr = $this->getMaxListArrayNr($listarray) + 1;
			// clear value
			$names = $this->getNamesFromContent($content);
			for($i=0;$i<sizeof($names);$i++) {
				$this->setElement($names[$i]."_".$new_nr,"");
			}

			for($i=sizeof($listarray);$i>$nr;$i--) {
				$listarray[$i] = $listarray[$i-1];
			}

			$listarray[$nr] =  "_".$new_nr;
		}

		$list = serialize($listarray);
		$this->setElement($name,$list);
	}

	function upEntryAtList($name,$nr) {
		$list = $this->getElement($name);
		if($list) {
			$listarray = unserialize($list);
		}
		$temp = $listarray[$nr-1];
		$listarray[$nr-1] = $listarray[$nr];
		$listarray[$nr] = $temp;

		$list = serialize($listarray);
		$this->setElement($name,$list);
	}

	function downEntryAtList($name,$nr) {
		$list = $this->getElement($name);
		if($list) {
			$listarray = unserialize($list);
		}
		$temp = $listarray[$nr+1];
		$listarray[$nr+1] = $listarray[$nr];
		$listarray[$nr] = $temp;
		$list = serialize($listarray);
		$this->setElement($name,$list);
	}

	function removeEntryFromList($name,$nr,$names="",$isBlock=false) {
		$list = $this->getElement($name);
		if($list) {
			$listarray = unserialize($list);
			$namesArray = $names ? explode(",",$names) : array();
			for($i=0;$i<sizeof($namesArray);$i++) {
				unset($this->elements[$namesArray[$i].($isBlock ? ("blk_".$name."_") : "").$listarray[$nr]]);
			}
		}
		array_splice($listarray,$nr,1);
		$list = serialize($listarray);
		$this->setElement($name,$list);
	}

	function addLinkToLinklist($name) {
		$linklist = $this->getElement($name);
		$ll = new we_linklist($linklist);
		$ll->addLink();
		$this->setElement($name,$ll->getString());
	}

	function upEntryAtLinklist($name,$nr) {
		$linklist = $this->getElement($name);
		$ll = new we_linklist($linklist);
		$ll->upLink($nr);
		$this->setElement($name,$ll->getString());
	}

	function downEntryAtLinklist($name,$nr) {
		$linklist = $this->getElement($name);
		$ll = new we_linklist($linklist);
		$ll->downLink($nr);
		$this->setElement($name,$ll->getString());
	}

	function insertLinkAtLinklist($name,$nr) {
		$linklist = $this->getElement($name);
		$ll = new we_linklist($linklist);
		$ll->insertLink($nr);
		$this->setElement($name,$ll->getString());
	}

	function removeLinkFromLinklist($name,$nr,$names="") {
		$linklist = $this->getElement($name);
		$ll = new we_linklist($linklist);
		$ll->removeLink($nr,$names,$name);
		$this->setElement($name,$ll->getString());
	}

	function changeLink($name) {
		$this->setElement($name,$_SESSION["WE_LINK"]);
	}

	function changeLinklist($name,$linklist) {
		$this->setElement($name,$_SESSION["WE_LINKLIST"]);
	}

	function getNamesFromContent($content) {
		preg_match_all ('/< ?we:[^>]+name="([^"]+)"[^>]*>/i', $content, $result ,PREG_SET_ORDER);
		$arr = array();
		for($i=0;$i<sizeof($result);$i++) {
			array_push($arr,$result[$i][1]);
		}
		return $arr;
	}

	function remove_image($name) {
		unset($this->elements[$name]);
		unset($this->elements[$name.'_img_custom_alt']);
		unset($this->elements[$name.'_img_custom_title']);
	}

	/*
	* public
	*/

	function we_new() {
		we_root::we_new();
		$this->i_setExtensions();
		if(is_array($this->Extensions) && sizeof($this->Extensions)) {
			$this->Extension = $this->Extensions[0];
		}
		if(!isset($GLOBALS["WE_IS_DYN"]) && ($this->Table==FILE_TABLE || $this->Table==TEMPLATES_TABLE)) {
			if($ws = get_ws($this->Table)) {
				$foo = makeArrayFromCSV($ws);
				if(sizeof($foo)) {
					$this->setParentID(abs($foo[0]));
				}
			}
		}
	}

	function i_setExtensions() {

	    if( (defined('ISP_VERSION') && ISP_VERSION) && ISP_TYPE == 'small' ){
	        $this->Extensions = array('.html');
	    } else if($this->ContentType) {
			$exts = isset($GLOBALS["WE_CONTENT_TYPES"][$this->ContentType]["Extension"]) ? $GLOBALS["WE_CONTENT_TYPES"][$this->ContentType]["Extension"] : "";
			$this->Extensions = makeArrayFromCSV($exts);
		}
	}

	function we_save($resave=0){

		/* version */
		$version = new weVersions();
		
		$this->i_setText();

		if(!we_root::we_save($resave))
			return false;
		$ret = $this->i_writeDocument();
		$this->OldPath = $this->Path;

		if($resave==0) { // NO rebuild!!!
			$this->resaveWeDocumentCustomerFilter();

		}
		
		
		if($this->ContentType=="application/x-shockwave-flash" || $this->ContentType=="image/*" 
			|| $this->ContentType=="video/quicktime" || $this->ContentType=="text/js" || $this->ContentType=="text/css" 
			|| $this->ContentType=="text/plain" || $this->ContentType=="text/xml"  || $this->ContentType=="application/*") {

				$version->save($this);
		}
		
		/* hook */
		$hook = new weHook('save', '', array($this));
		$hook->executeHook();

		return $ret;
	}

	function resaveWeDocumentCustomerFilter() {

		if (isset($this->documentCustomerFilter) && $this->documentCustomerFilter) {
			weDocumentCustomerFilter::saveForModel( $this );

		}
	}

	function we_load($from=LOAD_MAID_DB) {
		we_root::we_load($from);
		// Navigation items
		$this->i_setExtensions();
	}

	/**
	 * inits weDocumentCustomerFilter from db regarding the modelId
	 * is called from "we_textContentDocument::we_load"
	 * @see we_textContentDocument::we_load
	 */
	function initWeDocumentCustomerFilterFromDB() {
		$this->documentCustomerFilter = weDocumentCustomerFilter::getFilterOfDocument($this);
	}

	// reverse function to we_init_sessDat
	function saveInSession(&$save){
		parent::saveInSession($save);
		$save[2] = $this->NavigationItems;

	}

	// reverse function to saveInSession !!!
	function we_initSessDat($sessDat) {
		we_root::we_initSessDat($sessDat);
		if(defined("SCHEDULE_TABLE")) {
			if(
				isset($_REQUEST["we_".$this->Name."_From_day"])
				&& isset($_REQUEST["we_".$this->Name."_From_month"])
				&& isset($_REQUEST["we_".$this->Name."_From_year"])
				&& isset($_REQUEST["we_".$this->Name."_From_hour"])
				&& isset($_REQUEST["we_".$this->Name."_From_minute"]) ) {
				$this->From = mktime (
					$_REQUEST["we_".$this->Name."_From_hour"],
					$_REQUEST["we_".$this->Name."_From_minute"],
					0,
					$_REQUEST["we_".$this->Name."_From_month"],
					$_REQUEST["we_".$this->Name."_From_day"],
					$_REQUEST["we_".$this->Name."_From_year"]);
			}
			if(
				isset($_REQUEST["we_".$this->Name."_To_day"])
				&& isset($_REQUEST["we_".$this->Name."_To_month"])
				&& isset($_REQUEST["we_".$this->Name."_To_year"])
				&& isset($_REQUEST["we_".$this->Name."_To_hour"])
				&& isset($_REQUEST["we_".$this->Name."_To_minute"]) ) {
				$this->To = mktime (
					$_REQUEST["we_".$this->Name."_To_hour"],
					$_REQUEST["we_".$this->Name."_To_minute"],
					0,
					$_REQUEST["we_".$this->Name."_To_month"],
					$_REQUEST["we_".$this->Name."_To_day"],
					$_REQUEST["we_".$this->Name."_To_year"]);
			}
		}
		if(isset($sessDat[2])) {
			$this->NavigationItems = $sessDat[2];
		} else {
			$this->i_loadNavigationItems();
		}


		if ( isset( $_REQUEST["wecf_mode"] ) ) {
			$this->documentCustomerFilter = weDocumentCustomerFilter::getCustomerFilterFromRequest($this);
		} else if (isset($sessDat[3])) { // init webUser from session
			$this->documentCustomerFilter = unserialize($sessDat[3]);

		}


		$this->i_setExtensions();

		if($this->Language == "" && $this->Table != TEMPLATES_TABLE) {
			$this->initLanguageFromParent();
		}
	}

	function we_delete() {
		if(!we_root::we_delete())
			return false;
		if(!$this->i_deleteSiteDir())
			return false;
		if(!$this->i_deleteMainDir())
			return false;
		if(!$this->i_deleteNavigation())
			return false;
		return true;
	}

	function we_rewrite() {
		return $this->i_writeDocument();
	}

	/*
	* private
	*/

	function i_setText() {
		$this->Text = $this->Filename.$this->Extension;
	}

	function i_isMoved() {
		return ($this->OldPath && ($this->Path != $this->OldPath));
	}

	function i_writeSiteDir($doc) {
		if($this->i_isMoved()) {
			deleteLocalFile($this->getSitePath(1));
		}
		return saveFile($this->getSitePath(),$doc);
	}

	function i_writeMainDir($doc) {
		if($this->i_isMoved()) {
			deleteLocalFile($this->getRealPath(1));
		}
		return saveFile($this->getRealPath(),$doc);
	}

	function i_deleteSiteDir() {
		return deleteLocalFile($this->getSitePath());
	}

	function i_deleteMainDir() {
		return deleteLocalFile($this->getRealPath());
	}

	function i_writeDocument() {
		$doc = $this->i_getDocumentToSave();
		if($doc || $doc=="") {
			if(!$this->i_writeSiteDir($doc))
				return false;
			if(!$this->i_writeMainDir($doc))
				return false;

		}
		else {
			return false;
		}
		return true;
	}

	function i_getDocumentToSave() {
		$this->DocStream = $this->DocStream ? $this->DocStream : $this->i_getDocument();
		return $this->DocStream;
	}

	function i_getDocument($includepath="") {
		return isset($this->elements["data"]["dat"]) ? $this->elements["data"]["dat"] : "";
	}
	function i_setDocument($value) {
		$this->elements["data"]["dat"] = $value;
	}

	function i_filenameDouble() {
		return f("SELECT ID FROM ".mysql_real_escape_string($this->Table)." WHERE ParentID='".abs($this->ParentID)."' AND Filename='".mysql_real_escape_string($this->Filename)."' AND Extension='".mysql_real_escape_string($this->Extension)."' AND ID != '".abs($this->ID)."'","ID",new DB_WE());
	}

	function getFieldByVal(
		$val,
		$type,
		$attribs="",
		$pathOnly=false,
		$parentID=0,
		$path="",
		$db="",
		$classID="",
		$fn='$this->getElement') {

		$attribs = is_array($attribs) ? $attribs : array();
		if(!$db)
			$db = new DB_WE();
		if((!$attribs) || (!is_array($attribs)))
			$attribs = array();
		switch($type) {
			case "img":
				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_imageDocument.inc.php");
				$img = new we_imageDocument();

				if(isset($attribs["name"])) {
					$img->Name = $attribs["name"];
				}

				if(!$val && isset($attribs["id"])) {
					$val = $attribs["id"];
				}

				$img->LoadBinaryContent = false;
				$img->initByID($val,FILE_TABLE);

				$altField = $img->Name . '_img_custom_alt';
                $titleField = $img->Name . '_img_custom_title';

				if (isset($GLOBALS['lv']) && isset($GLOBALS['lv']->ClassName) && $GLOBALS['lv']->ClassName == 'we_listview_shopVariants') {

					$altField = (WE_SHOP_VARIANTS_PREFIX . $GLOBALS['lv']->Position .'_' . $altField);
					$titleField = (WE_SHOP_VARIANTS_PREFIX . $GLOBALS['lv']->Position .'_' . $titleField);
				}

            	if( !(isset($_REQUEST['we_cmd'][0]) && $_REQUEST['we_cmd'][0] == 'reload_editpage' && (isset($_REQUEST['we_cmd'][1]) && $img->Name == $_REQUEST['we_cmd'][1]) && isset($_REQUEST['we_cmd'][2]) && $_REQUEST['we_cmd'][2] == 'change_image') && isset($GLOBALS['we_doc']->elements[$altField])){
            		if (!isset($GLOBALS['lv'])) {
             	   		$attribs['alt']   = htmlspecialchars($GLOBALS['we_doc']->getElement($altField));
            	    	$attribs['title'] = htmlspecialchars($GLOBALS['we_doc']->getElement($titleField));
            		}
            	}

				//	when width or height are given, then let the browser adjust the image
				if( isset($attribs["width"]) || isset($attribs["width"])){

					unset($img->elements["height"]);
					unset($img->elements["width"]);
				}

				if(sizeof($attribs)) {
					if(isset($attribs["hyperlink"]))
						unset($attribs["hyperlink"]);
					if(isset($attribs["target"]))
						unset($attribs["target"]);
					$img->initByAttribs($attribs);
				}
				if(isset($GLOBALS["lv"])){
					if(isset($GLOBALS["lv"]->count)){
						$img->setElement("name",$img->getElement("name")."_".$GLOBALS["lv"]->count,"attrib");
						$img->Name = $img->Name."_".$GLOBALS["lv"]->count;
					} else {
						$img->setElement("name",$img->getElement("name"),"attrib");
					}
				}
				return $pathOnly ? $img->Path : $img->getHtml();
			case "binary":
				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_otherDocument.inc.php");
				$bin = new we_otherDocument();
				if(isset($attribs["name"])) {
					$bin->Name = $attribs["name"];
				}
				if(!$val && isset($attribs["id"])) {
					$val = $attribs["id"];
				}
				$bin->initByID($val,FILE_TABLE);
				return array($bin->Text,$bin->Path);
			case "flashmovie":
				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_flashDocument.inc.php");
				$fl = new we_flashDocument();
				if(isset($attribs["name"])) {
					$fl->Name = $attribs["name"];
				}
				if(!$val && isset($attribs["id"])) {
					$val = $attribs["id"];
				}
				$fl->initByID($val,FILE_TABLE);
				if(sizeof($attribs)) {
					$fl->initByAttribs($attribs);
				}
				return $pathOnly ? $fl->Path : $fl->getHtml();
			case "quicktime":
				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_quicktimeDocument.inc.php");
				$fl = new we_quicktimeDocument();
				if(isset($attribs["name"])) {
					$fl->Name = $attribs["name"];
				}
				if(!$val && isset($attribs["id"])) {
					$val = $attribs["id"];
				}
				$fl->initByID($val,FILE_TABLE);
				if(sizeof($attribs)) {
					$fl->initByAttribs($attribs);
				}
				return $pathOnly ? $fl->Path : $fl->getHtml();
			case "link":
				$link = $val ? unserialize($val) : array();

				$only = we_getTagAttribute("only",$attribs,"");

				if($pathOnly || $only == 'href'){

					$return = we_document::getLinkHref($link,$parentID,$path,$db);

				    if ((isset($GLOBALS["we_link_not_published"])) && ($GLOBALS["we_link_not_published"])) {
						unset($GLOBALS["we_link_not_published"]);
						return "";
					} else {
						return $return;
					}

				}

				if(is_array($link)) {
					include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_imageDocument.inc.php");
					$img = new we_imageDocument();
					//	set name of image for rollover ...
					$_useName = "";

					if(isset($attribs['name'])){	//	here we must change the name for a rollover-image
						$_useName = $attribs['name'] . "_img";
						$img->setElement("name", $_useName, "dat");
					}

					$xml = getXmlAttributeValueAsBoolean(we_getTagAttribute("xml",$attribs,""));
					$htmlspecialchars = we_getTagAttribute("htmlspecialchars",$attribs,"",true);
					if ($only) {
					    if($only == "content"){
					        return we_document::getLinkContent($link,$parentID,$path,$db,$img,$xml,$_useName,$htmlspecialchars);
					    } else {
					        return $link[$only];
					    }
					} else {

    					if($content = we_document::getLinkContent($link,$parentID,$path,$db,$img,$xml,$_useName,$htmlspecialchars)) {

    						if( $startTag = we_document::getLinkStartTag($link,$attribs,$parentID,$path,$db,$img,$_useName)) {
    							return $startTag.$content.'</a>';
    						}
    						else {
    							return $content;
    						}
    					}
					}
				}
				return "";
			case "date":
				// it is a date field from the customer module
				if ($val && !is_numeric($val) && strlen($val) == 19) {
					$_y = substr($val,0,4);
					$_m = substr($val,5,2);
					$_d = substr($val,8,2);
					$_h = substr($val,11,2);
					$_min = substr($val,14,2);
					$_s = substr($val,17,2);
					$val = mktime($_h,$_min,$_s,$_m,$_d,$_y);
				}

				if($val == 0) {
					$val = time();
				}
				$format = isset($attribs["format"]) ? $attribs["format"] : $GLOBALS["l_global"]["date_format"];
				return date(correctDateFormat($format,$val),$val);
			case "select":
				if(defined("OBJECT_TABLE")) {
					if(strlen($val) == 0)
						return "";
					if($classID) {
						$defVals = f("SELECT DefaultValues FROM " . OBJECT_TABLE . " WHERE ID='".abs($classID)."'","DefaultValues",$db);
						if($defVals) {
							$arr = unserialize($defVals);
							return isset($arr["meta_".$attribs["name"]]["meta"][$val]) ? $arr["meta_".$attribs["name"]]["meta"][$val] : "";
						}
					}
				}
				return "";
			case "href":
				return we_document::getHref($attribs,$db,$fn);
			default:
				parseInternalLinks($val, $parentID);
				$retval = eregi_replace('<\?xml[^>]+>',"",$val);

				if( isset($attribs["html"]) && ($attribs["html"] == "off" || $attribs["html"] == "false" || $attribs["html"] == "0") ) {
					$retval =  strip_tags($retval,'<br>,<p>');
				}

				$_htmlspecialchars = isset($attribs["htmlspecialchars"]) && ($attribs["htmlspecialchars"] == "on" || $attribs["htmlspecialchars"] == "true" || $attribs["htmlspecialchars"] == "htmlspecialchars");
				$_wysiwyg = isset($attribs["wysiwyg"]) && ($attribs["wysiwyg"] == "on" || $attribs["wysiwyg"] == "true" || $attribs["wysiwyg"] == "wysiwyg");

				if($_htmlspecialchars && (!$_wysiwyg)) {
					$retval = eregi_replace('<br([^>]*)>','#we##br\1#we##',$retval);
					$retval = htmlspecialchars($retval, ENT_QUOTES);
					$retval = str_replace('&#039;', '&apos;', $retval);
					$retval = eregi_replace('#we##br([^#]*)#we##','<br\1>',$retval);
				}

				if(!(defined("WE_PHP_DEFAULT") && WE_PHP_DEFAULT)){
					if((!isset($attribs["php"])) || ($attribs["php"] != "on" && $attribs["php"] != "true" && $attribs["php"] != "1")){
						$retval = removePHP($retval);
					}
				}else{
					if(isset($attribs["php"]) && ($attribs["php"] == "off" || $attribs["php"] == "false" || $attribs["php"] == "0")){
						$retval = removePHP($retval);
					}
				}
				if(ereg('^[0-9\.,]+$',trim($retval))) {
					$precision = isset($attribs["precision"]) ? abs($attribs["precision"]) : 2;

					if(isset($attribs["num_format"])){
					    if($attribs["num_format"]=="german") {
    						$retval =we_util::std_numberformat($retval);
						    $retval=number_format($retval,$precision,",",".");
					    }
					    else if($attribs["num_format"]=="french") {
    						$retval =we_util::std_numberformat($retval);
						    $retval=number_format($retval,$precision,","," ");
					    }
					    else if($attribs["num_format"]=="english") {
    						$retval =we_util::std_numberformat($retval);
						    $retval=number_format($retval,$precision,".","");
					    }
				    }

				}
				if(we_getTagAttribute("win2iso",$attribs,"",true)){
					$chars = array(
						128 => '&#8364;',
						130 => '&#8218;',
						131 => '&#402;',
						132 => '&#8222;',
						133 => '&#8230;',
						134 => '&#8224;',
						135 => '&#8225;',
						136 => '&#710;',
						137 => '&#8240;',
						138 => '&#352;',
						139 => '&#8249;',
						140 => '&#338;',
						142 => '&#381;',
						145 => '&#8216;',
						146 => '&#8217;',
						147 => '&#8220;',
						148 => '&#8221;',
						149 => '&#8226;',
						150 => '&#8211;',
						151 => '&#8212;',
						152 => '&#732;',
						153 => '&#8482;',
						154 => '&#353;',
						155 => '&#8250;',
						156 => '&#339;',
						158 => '&#382;',
						159 => '&#376;');

					$charset = ( isset($GLOBALS["WE_MAIN_DOC"]) && isset($GLOBALS["WE_MAIN_DOC"]->elements["Charset"]["dat"]))
						 ? $GLOBALS["WE_MAIN_DOC"]->elements["Charset"]["dat"] : "";
					if(trim(strtolower(substr($charset,0,3))) == "iso" || $charset==""){
						$retval = str_replace(array_map('chr', array_keys($chars)), $chars, $retval);
					}
				}
				$retval = str_replace("##|n##","\n",$retval);
				$retval = str_replace("##|r##","\r",$retval);
				return $retval;
		}
	}

	function getField($attribs,$type="txt",$pathOnly=false) {
		$val = "";
		switch($type) {
			case "img":
			case "flashmovie":
			case "quicktime":
				$val = $this->getElement($attribs["name"],"bdid");
				if($val)
					break;
			default:
				$val = $this->getElement(isset($attribs["name"]) ? $attribs["name"] : "");

		}
		if($type == "href" && ((isset($this->TableID) && $this->TableID) || ($this->ClassName == "we_objectFile"))) {
			$hrefArr = $val ? unserialize($val) : array();
			if(!is_array($hrefArr))
				$hrefArr= array();
			return we_document::getHrefByArray($hrefArr);
		}

		return we_document::getFieldByVal(
			$val,
			$type,
			$attribs,
			$pathOnly,
			isset($GLOBALS["WE_MAIN_DOC"]) ? $GLOBALS["WE_MAIN_DOC"]->ParentID : $this->ParentID,
			isset($GLOBALS["WE_MAIN_DOC"]) ? $GLOBALS["WE_MAIN_DOC"]->Path : $this->Path,
			$this->DB_WE,
			(isset($attribs["classid"]) && isset($attribs["type"]) && $attribs["type"]=="select") ? $attribs["classid"] : (isset($this->TableID) ? $this->TableID : ""));
	}

	function getHref($attribs,$db="",$fn='$this->getElement') {
		if(!$db)
			$db = new_DB_WE();
		$n = $attribs["name"];
		$nint = $n."_we_jkhdsf_int";
		eval('$int = ('.$fn.'($nint) == "") ? 0 : '.$fn.'($nint);');
		if($int) {
			$nintID = $n."_we_jkhdsf_intID";
			eval('$intID = '.$fn.'($nintID);');
			return f("SELECT Path FROM " . FILE_TABLE . " WHERE ID='".abs($intID)."'","Path",$db);
		}
		else {
			eval('$extPath = '.$fn.'($n);');
			return $extPath;
		}
	}

	function getHrefByArray($hrefArr) {
		$int = isset($hrefArr["int"]) ? $hrefArr["int"] : false;
		if($int) {
			$intID = isset($hrefArr["intID"]) ? $hrefArr["intID"] : 0;
			return $intID ? id_to_path($intID) : "";
		}
		else {
			return isset($hrefArr["extPath"]) ? $hrefArr["extPath"] : "";
		}
	}

	function getLinkHref($link,$parentID,$path,$db=""){
		if (!$db){
			$db = new DB_WE();
		}

		// Bug Fix 8170&& 8166
		if(isset($link['href']) && strlen($link['href'])>=7 && substr($link['href'], 0, 7) == "mailto:") {
			$link['type']="mail";
		}

		if (isset($link["type"]) && ($link["type"] == "int")) {
			$id = $link["id"];
			if($id=="") {
				return "";
			}else{
				$path = f("SELECT Path FROM " . FILE_TABLE . " WHERE ID=".abs($id)."","Path",$db);

				if (isset($GLOBALS['we_doc']) && $GLOBALS['we_doc']->InWebEdition) {

					return $path;
				} else {

					$published = f("SELECT Published FROM " . FILE_TABLE . " WHERE ID=".abs($id)."","Published",$db);
					if ($published) {
						return $path;
					} else {
						$GLOBALS["we_link_not_published"] = 1;
						return "";
					}
				}



			}
		} else if (isset($link["type"]) && ($link["type"] == "obj")) {

			return getHrefForObject($link["obj_id"],$parentID,$path,$db);
		} else if (isset($link["type"])) {

			if ($link["href"] == "http://" ) {
				$link["href"] = "";
			}
			return $link["href"];

		} else {
			return  "";
		}
	}

	function getLinkContent($link,$parentID=0,$path="",$db="",$img="",$xml="", $_useName="",$htmlspecialchars=false) {

		$l_href = we_document::getLinkHref($link,$parentID,$path,$db);

		if ( isset($GLOBALS["we_link_not_published"]) && $GLOBALS["we_link_not_published"]) {
			unset($GLOBALS["we_link_not_published"]);
			return "";
		}

		if(isset($link["ctype"]) && $link["ctype"]== "int") {
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_imageDocument.inc.php");
			if(!$img)
				$img = new we_imageDocument();
			$img->initByID($link["img_id"]);

			$img_attribs = array("width"=>$link["width"],"height"=>$link["height"],"border"=>$link["border"],"hspace"=>$link["hspace"],"vspace"=>$link["vspace"],"align"=>$link["align"],"alt"=>$link["alt"],'title'=>(isset($link["img_title"]) ? $link["img_title"]: ""));

			if($_useName){	//	rollover with links ...
			    $img_attribs['name'] = $_useName;
				$img->elements['name']['dat'] = $_useName;
			}

			if($xml){
				$img_attribs["xml"] = "true";
			}

			$img->initByAttribs($img_attribs);

			return $img->getHtml(false,false);
		}
		else if(isset($link["ctype"]) && $link["ctype"] == "ext") {

			//  set default atts
		    $img_attribs = array(    "src" => $link["img_src"],
		                             "alt" => "",
		                             "xml" => $xml
		                         );
            if(isset($link["img_title"])){
                $img_attribs['title'] = $link["img_title"];
            }
             //  deal with all remaining attribs
            $img_attList = array("width","height","border","hspace","vspace","align","alt","name");
		    foreach($img_attList AS $k){
		        if(isset($link[$k]) &&  $link[$k] != ""){
		            $img_attribs[$k] = $link[$k];
		        }
		    }
			return getHtmlTag('img', $img_attribs);
		}
		else if(isset($link["ctype"]) && $link["ctype"] == "text") {
			// Workarround => We have to find another solution
			if (getXmlAttributeValueAsBoolean($xml) ) {
				// we have to use a html_entity_decode first in case a user has set &amp, &uuml; by himself
				// as html_entity_decode is only available php > 4.3 we use a custom function
				return htmlspecialchars( unhtmlentities($link["text"]) );
			} else {
				return $htmlspecialchars ? htmlspecialchars($link["text"]) : $link["text"];
			}
		}

	}

	function getLinkStartTag($link,$attribs,$parentID=0,$path="",$db="",$img="",$_useName="") {

		if ($l_href = we_document::getLinkHref($link, $parentID, $path, $db)) {

		    include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_imageDocument.inc.php");

		    //    define some arrays to order the attribs to image, link or js-window ...
		    $_popUpAtts  = array('jswin','jscenter','jswidth','jsheight','jsposx','jsposy','jsstatus','jsscrollbars','jsmenubar','jstoolbar','jsresizable','jslocation');

		    //    attribs only for image - these are already handled
		    $_imgAtts = array('img_id','width','height','border','hspace','vspace','align','alt','img_title');

		    //    these are handled separately
		    $_dontUse = array('img_id','obj_id','ctype','anchor','params','attribs','img_src','text','type','only');

		    //    these are already handled dont get them in output
		    $_we_linkAtts = array('id');

		    $_linkAttribs = array();

			/**********************************************************/
			/* define image-if necessary - handle with image-attribs
			/**********************************************************/
			if (!$img) {
				$img = new we_imageDocument();
			}
			//   image attribs
			foreach($_imgAtts as $att){  //  take all attribs belonging to image inside content
			    $img_attribs[$att] = isset($link[$att]) ? $link[$att] : "";
			}

            $img->initByID($img_attribs["img_id"]);
            $img->initByAttribs($img_attribs);

            $rollOverScript="";
            $rollOverAttribsArr = array();

            if ($link["ctype"] == "int") {
				//	set name of image dynamically
				if($_useName){	//	we must set the name of the image -> rollover
					$img->setElement("name", $_useName, "dat");
				}
				$rollOverScript = $img->getRollOverScript();
				$rollOverAttribsArr = $img->getRollOverAttribsArr();
			}

			/*********************************************/
			/* Link-Attribs
			/*********************************************/
			//   1st attribs-string from link dialog ! These are already used in content ...
			if(isset($link["attribs"])){
                $_linkAttribs = array_merge(makeArrayFromAttribs($link["attribs"]), $_linkAttribs);
			}

			//   2nd take all atts given in link-array - from function we_tag_link()
			foreach($link AS $k => $v){  //   define all attribs - later we can remove/overwrite them
			    if($v != "" && !in_array($k,$_we_linkAtts) && !in_array($k, $_imgAtts) && !in_array($k, $_popUpAtts) && !in_array($k, $_dontUse)){
                    $_linkAttribs[$k] = $v;
			    }
			}

			//   3rd we take attribs given from we:link,
			foreach($attribs AS $k => $v){  //   define all attribs - later we can remove/overwrite them
			    if($v != "" && !in_array($k, $_imgAtts) && !in_array($k, $_popUpAtts) && !in_array($k, $_dontUse)){
                    $_linkAttribs[$k] = $v;
			    }
			}

			//   4th use Rollover attributes
			foreach($rollOverAttribsArr as $n=>$v) {
				$_linkAttribs[$n] = $v;
			}
			//   override the href at last important !!

			$linkAdds = (isset($link["params"]) ? $link["params"] : '' ). (isset($link["anchor"]) ? $link["anchor"] : '' );

			$_linkAttribs["href"] = $l_href . str_replace('&', '&amp;', $linkAdds);

			/**************************************************/
			/* The pop-up-window                              */
			/**************************************************/
			$_popUpCtrl = array();
			foreach($_popUpAtts AS $n){
			    if(isset($link[$n])){
			        $_popUpCtrl[$n] = $link[$n];
			    }
			}


			if (isset($_popUpCtrl["jswin"]) && $_popUpCtrl["jswin"]) {   //  add attribs for popUp-window
				$js = "var we_winOpts = '';";
				if (isset($_popUpCtrl["jscenter"]) && $_popUpCtrl["jscenter"] && isset($_popUpCtrl["jswidth"]) && $_popUpCtrl["jswidth"] && isset($_popUpCtrl["jsheight"]) && $_popUpCtrl["jsheight"]) {
					$js .= 'if (window.screen) {var w = ' . $_popUpCtrl["jswidth"] . ';var h = ' . $_popUpCtrl["jsheight"].';var screen_height = screen.availHeight - 70;var screen_width = screen.availWidth-10;var w = Math.min(screen_width,w);var h = Math.min(screen_height,h);var x = (screen_width - w) / 2;var y = (screen_height - h) / 2;we_winOpts = \'left=\'+x+\',top=\'+y;}else{we_winOpts=\'\';};';
				} else if ((isset($_popUpCtrl["jsposx"]) && $_popUpCtrl["jsposx"] != "") || (isset($_popUpCtrl["jsposy"]) && $_popUpCtrl["jsposy"] != "")) {
					if ($_popUpCtrl["jsposx"] != "") {
						$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'left='.$_popUpCtrl["jsposx"].'\';';
					}
					if ($_popUpCtrl["jsposy"] != "") {
						$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'top='.$_popUpCtrl["jsposy"].'\';';
					}
				}
				if (isset($_popUpCtrl["jswidth"]) && $_popUpCtrl["jswidth"] != "") {
						$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'width='.$_popUpCtrl["jswidth"].'\';';
				}
				if (isset($_popUpCtrl["jsheight"]) && $_popUpCtrl["jsheight"] != "") {
						$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'height='.$_popUpCtrl["jsheight"].'\';';
				}
				if (isset($_popUpCtrl["jsstatus"]) && $_popUpCtrl["jsstatus"]) {
					$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'status=yes\';';
				} else {
					$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'status=no\';';
				}
				if (isset($_popUpCtrl["jsscrollbars"]) && $_popUpCtrl["jsscrollbars"]) {
					$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'scrollbars=yes\';';
				} else {
					$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'scrollbars=no\';';
				}
				if (isset($_popUpCtrl["jsmenubar"]) && $_popUpCtrl["jsmenubar"]) {
					$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'menubar=yes\';';
				} else {
					$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'menubar=no\';';
				}
				if (isset($_popUpCtrl["jsresizable"]) && $_popUpCtrl["jsresizable"]) {
					$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'resizable=yes\';';
				} else {
					$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'resizable=no\';';
				}
				if (isset($_popUpCtrl["jslocation"]) && $_popUpCtrl["jslocation"]) {
					$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'location=yes\';';
				} else {
					$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'location=no\';';
				}
				if (isset($_popUpCtrl["jstoolbar"]) && $_popUpCtrl["jstoolbar"]) {
					$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'toolbar=yes\';';
				} else {
					$js .= 'we_winOpts += (we_winOpts ? \',\' : \'\')+\'toolbar=no\';';
				}
				$foo = $js."var we_win = window.open('','we_".(isset($attribs["name"]) ? $attribs["name"] : "")."',we_winOpts);";

				$_linkAttribs['target'] = 'we_'.(isset($attribs["name"]) ? $attribs["name"] : "");
				$_linkAttribs['onclick'] = $foo;
			}

			return $rollOverScript . getHtmlTag('a', $_linkAttribs, '', false, true);
		}
		else {
			if ((isset($GLOBALS["we_link_not_published"])) && ($GLOBALS["we_link_not_published"])) {
				unset($GLOBALS["we_link_not_published"]);
			}
		}
	}

	/*
	* functions for scheduler pro
	*/

	function createEmptySchedule() {
		$s = array();
		$s["task"] = 1;
		$s["type"] = 0;
		$s["months"] = array(0,0,0,0,0,0,0,0,0,0,0,0);
		$s["days"] = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
		$s["weekdays"] = array(0,0,0,0,0,0,0);
		$s["time"] = time();
		$s["CategoryIDs"] = "";
		$s["DoctypeID"] =0;
		$s["ParentID"] = 0;
		$s["active"] = 1;
		$s["doctypeAll"] = 0;
		return $s;
	}

	function add_schedule() {
		array_push($this->schedArr,$this->createEmptySchedule());
	}

	function del_schedule($nr) {
		array_splice($this->schedArr,$nr,1);
	}

	function i_setElementsFromHTTP() {
		parent::i_setElementsFromHTTP();
		if(sizeof($_REQUEST)) {
			$dates = array();
			foreach($_REQUEST as $n=>$v) {
				if(ereg('^we_schedule_([^\[]+)$',$n,$regs)) {
					$rest = $regs[1];
					$nr = ereg_replace('^.+_([0-9])+$','\1',$rest);
					if(substr($rest,0,5) == "task_") {
						$this->schedArr[$nr]["task"] = $v;
					}
					else if(substr($rest,0,5) == "type_") {
						$this->schedArr[$nr]["type"] = $v;
					}
					else if(substr($rest,0,7) == "active_") {
						$this->schedArr[$nr]["active"] = $v;
					}
					else if(substr($rest,0,8) == "doctype_") {
						$this->schedArr[$nr]["DoctypeID"] = $v;
					}
					else if(substr($rest,0,11) == "doctypeAll_") {
						$this->schedArr[$nr]["doctypeAll"] = $v;
					}
					else if(substr($rest,0,9) == "parentid_") {
						$this->schedArr[$nr]["ParentID"] = $v;
					}
					else if(substr($rest,0,5) == "month") {
						$rest = substr($rest,5);
						$m = ereg_replace('^([^_]+)_[0-9]+$','\1',$rest);
						$this->schedArr[$nr]["months"][$m-1] = $v;
					}
					else if(substr($rest,0,3) == "day") {
						$rest = substr($rest,3);
						$d = ereg_replace('^([^_]+)_[0-9]+$','\1',$rest);
						$this->schedArr[$nr]["days"][$d-1] = $v;
					}
					else if(substr($rest,0,4) == "wday") {
						$rest = substr($rest,4);
						$d = ereg_replace('^([^_]+)_[0-9]+$','\1',$rest);
						$this->schedArr[$nr]["weekdays"][$d-1] = $v;
					}
					else if(substr($rest,0,5) == "time_") {
						$rest = substr($rest,5);
						$foo = ereg_replace('^([^_]+)_[0-9]+$','\1',$rest);
						if(!(isset($dates[$nr]) && is_array($dates[$nr]))) {
							$dates[$nr] = array();
						}
						$dates[$nr][$foo] = $v;
					}
				}
			}
			foreach($dates as $nr=>$v) {
				$this->schedArr[$nr]["time"] = mktime(
					$dates[$nr]["hour"],
					$dates[$nr]["minute"],
					0,
					$dates[$nr]["month"],
					$dates[$nr]["day"],
					$dates[$nr]["year"]);
			}
		}
		$this->Path = $this->getPath();
	}

	function add_schedcat($id,$nr) {
		$cats = makeArrayFromCSV($this->schedArr[$nr]["CategoryIDs"]);
		if(!in_array($id,$cats)) {
			array_push($cats,$id);
		}
		$this->schedArr[$nr]["CategoryIDs"]=makeCSVFromArray($cats,true);
	}

	function delete_schedcat($id,$nr) {
		$cats = makeArrayFromCSV($this->schedArr[$nr]["CategoryIDs"]);
		if(in_array($id,$cats)) {
			$pos = getArrayKey($id,$cats);
			if($pos != "" || $pos=="0") {
				array_splice($cats,$pos,1);
			}
		}
		$this->schedArr[$nr]["CategoryIDs"]=makeCSVFromArray($cats,true);
	}

	// returns the next date when the document gets published
	function getNextPublishDate() {
		$times = array();
		foreach($this->schedArr as $s) {
			if($s["task"] == SCHEDULE_FROM && $s["active"]) {
				array_push($times,we_schedpro::getNextTimestamp($s,time()));
			}
		}
		if(sizeof($times)) {
			sort($times);
			return $times[0];
		}
		return 0;
	}

	function loadSchedule() {
		if(defined("SCHEDULE_TABLE")) {
			$this->DB_WE->query("SELECT * FROM ".SCHEDULE_TABLE." WHERE DID='".abs($this->ID)."' AND ClassName='".mysql_real_escape_string($this->ClassName)."'");
			if($this->DB_WE->num_rows()){
				$this->schedArr = array();
			}
			while($this->DB_WE->next_record()) {
				$s = unserialize($this->DB_WE->f("Schedpro"));
				if(is_array($s)) {
					$s["active"]=$this->DB_WE->f("Active");
					array_push($this->schedArr,$s);
				}
			}
		}
	}

	/**
	 * returns	a select menu within a html table. to ATTENTION this function is also used in classes object and objectFile !!!!
	 *			when $withHeadline is true, a table with headline is returned, default is false
	 * @return	select menue to determine charset
	 * @param	boolean
	 */
	function formCharset($withHeadline = false){

		global $l_we_class;

		$value = (isset($this->elements["Charset"]["dat"]) ? $this->elements["Charset"]["dat"] : "");

		$_charsetHandler = new charsetHandler();

		$_charsets = $_charsetHandler->getCharsetsForTagWizzard();
		$_charsets[""] = "";
		asort($_charsets);
		reset($_charsets);

		$name = "Charset";

		$inputName = "we_".$this->Name."_txt[$name]";

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
						' . $this->htmlTextInput($inputName, 24, $value) . '</td>
					<td></td>
					<td>
						' . $this->htmlSelect("we_tmp_" . $this->Name . "_select[" . $name . "]", $_charsets, 1, $value, false, "  onblur=\"_EditorFrame.setEditorIsHot(true);document.forms[0].elements['" . $inputName. "'].value=this.options[this.selectedIndex].value;top.we_cmd('reload_editpage');\" onchange=\"_EditorFrame.setEditorIsHot(true);document.forms[0].elements['" . $inputName. "'].value=this.options[this.selectedIndex].value;top.we_cmd('reload_editpage');\"", "value", 330) . '</td>
				</tr>
			</table>';
		return $content;
	}


	/**
	 * returns if document can have variants the function returns true otherwise
	 * false
	 * if paramter checkField is true, this function checks also, if there are
	 * already fields selected for the variants.
	 *
	 * @param boolean $checkFields
	 * @return boolean
	 */
	function canHaveVariants($checkFields = false){
		// overwrite
		return false;
	}

	/**
	 * @return	array with the filed names and attributes
	 * @param	none
	 */
	function getVariantFields(){
		// overwrite
		return array();
	}

	/**
	 * @desc	the function modifies document EditPageNrs set
	 */
	function checkTabs(){
		if(!$this->canHaveVariants(true)){

			$ind = array_search(WE_EDITPAGE_VARIANTS,$this->EditPageNrs);
			if(!empty($ind)) {
				array_splice($this->EditPageNrs,$ind,1);
			}
		}
	}

	function i_deleteNavigation() {
		$this->DB_WE->query('DELETE FROM '.NAVIGATION_TABLE.' WHERE ' . weNavigation::getNavCondition($this->ID, $this->Table));
		return true;
	}

}

?>