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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_textDocument.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_temporaryDocument.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_live_tools.inc.php");

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_versions/weVersions.class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_hook/class/weHook.class.php");

if(defined("WORKFLOW_TABLE")) {
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/workflow/"."weWorkflowUtility.php");
}

if(!isset($GLOBALS["WE_IS_DYN"])){
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/"."we_button.inc.php");
}
class we_textContentDocument extends we_textDocument{

	/* Name of the class => important for reconstructing the class from outside the class */
	var $ClassName="we_textContentDocument";


	var $EditPageNrs = array(WE_EDITPAGE_PROPERTIES,WE_EDITPAGE_INFO,WE_EDITPAGE_CONTENT,WE_EDITPAGE_PREVIEW,WE_EDITPAGE_VALIDATION);


	/* Doc-Type of the document */
	var $DocType="";

	var $PublWhenSave = 0;

	var $Table = FILE_TABLE;

	var $IsTextContentDoc = true;

	var $schedArr = array();

	function we_textContentDocument(){
		$this->we_textDocument();
		array_push($this->persistent_slots,"DocType");
		if(defined("SCHEDULE_TABLE")){
			array_push($this->persistent_slots,"FromOk","ToOk","From","To");
		}
		array_push($this->EditPageNrs,WE_EDITPAGE_SCHEDULER);
		
	}

	function editor($baseHref=true){
		$port = (defined("HTTP_PORT")) ? (":".HTTP_PORT) : "";
		$prot = getServerProtocol();
		$GLOBALS["we_baseHref"] = $baseHref ? $prot."://".SERVER_NAME.$port.$this->Path : "";
		switch($this->EditPageNr){
			case WE_EDITPAGE_SCHEDULER:
				return "we_modules/schedule/we_editor_schedpro.inc.php";
            case WE_EDITPAGE_VALIDATION:
				return "we_templates/validateDocument.inc.php";
				break;
			default:
				return parent::editor($baseHref);
		}
	}

	function makeSameNew(){
		$Category = $this->Category;
		$ContentType = $this->ContentType;
		$DocType = $this->DocType;
		$IsSearchable = $this->IsSearchable;
		$Extension = $this->Extension;
		we_root::makeSameNew();
		$this->DocType = $DocType;
		$this->changeDoctype();
		$this->Category = $Category;
		$this->ContentType = $ContentType;
		$this->IsSearchable = $IsSearchable;
		$this->Extension = $Extension;

	}

	function insertAtIndex(){
		$text = "";
		if(isset($GLOBALS["INDEX_TYPE"]) && $GLOBALS["INDEX_TYPE"]=="PAGE"){
			$text = $this->i_getDocument();
		}else{

			if ($this->ContentType == "text/webedition") {
				// dont save not needed fields in index-table: @bugfix 8798
				$fieldTypes = we_webEditionDocument::getFieldTypes($this->getTemplateCode());
				$fieldTypes["Title"] = "txt";
				$fieldTypes["Description"] = "txt";
				$fieldTypes["Keywords"] = "txt";
			}

			$this->resetElements();
			while(list($k,$v) = $this->nextElement("")){
				$_dat = (isset($v["dat"]) && is_string($v["dat"]) && substr($v["dat"],0,2) == "a:") ? unserialize($v["dat"]) : (isset($v["dat"]) ? $v["dat"] : "");
				if ((!is_array($_dat) || (isset($_dat['text']) && $_dat['text'])) && isset($fieldTypes) && is_array($fieldTypes)) {
					foreach($fieldTypes as $name=>$val) {
						if(eregi('^'.$name.'$',$k)) {
							if(!is_array($_dat) && $v["type"] == "txt" && ($k != "Charset")){
								$text .= " ".$_dat;
							} else if (is_array($_dat)) {
								$text .= " ".$_dat['text'];
							}
							break;
						}
					}
				} else if (!is_array($_dat)) {
					if(isset($v["type"]) && $v["type"] == "txt" && ($k != "Charset")){
						$text .= " ".(isset($v["dat"]) ? $v["dat"] : "");
					}
				}
			}
		}
		$text = trim(strip_tags($text));

		$maxDB = getMaxAllowedPacket($this->DB_WE) - 1024;
		$maxDB = min(1000000,$maxDB);
		if(strlen($text) > $maxDB){
			$text = substr($text,0,$maxDB);
		}
		$text = addslashes($text);

		$this->DB_WE->query("DELETE FROM " . INDEX_TABLE . " WHERE DID=".abs($this->ID));
		if($this->IsSearchable && $this->Published){
			return $this->DB_WE->query("INSERT INTO " . INDEX_TABLE . " (DID,Text,BText,Workspace,WorkspaceID,Category,Doctype,Title,Description,Path) VALUES('".abs($this->ID)."','".mysql_real_escape_string($text)."','".mysql_real_escape_string($text)."','".mysql_real_escape_string($this->ParentPath)."','".abs($this->ParentID)."','".mysql_real_escape_string($this->Category)."','".mysql_real_escape_string($this->DocType)."','".mysql_real_escape_string($this->getElement("Title"))."','".mysql_real_escape_string($this->getElement("Description"))."','".mysql_real_escape_string($this->Path)."')");
		}
		return true;

	}


	/* publish a document */

	function getMetas($code){
		if(eregi('< ?title[^>]*>(.*)< ?/ ?title[^>]*>',$code,$regs)){
			$title = $regs[1];
		}else{
			$title = "";
		}
		$tempname = TMP_DIR."/".uniqid(md5(time()));
		$fp=fopen($tempname,"wb");
		fputs($fp,$code);
		fclose($fp);
		$metas = get_meta_tags($tempname);
		unlink($tempname);
		$metas["title"] = $title;
		return $metas;
	}

	function changeDoctype($dt="",$force=false){
		if((!$this->ID) || $force){
			if($dt){
				$this->DocType=$dt;
			}
			$db = new DB_WE();
			$db->query("SELECT * FROM " . DOC_TYPES_TABLE . " WHERE ID ='".abs($this->DocType)."'");
			if($db->next_record()){
				$this->Extension = $db->f("Extension");
				if($db->f("ParentPath") != ""){
					$this->ParentPath = $db->f("ParentPath");
					$this->ParentID = $db->f("ParentID");
				}
				if($this->ContentType == "text/webedition"){
					// only switch template, when current template is not in Templates
					$_templates = explode(",", $db->f("Templates"));
					if ( !in_array($this->TemplateID, $_templates) ) {
						$this->setTemplateID($db->f("TemplateID"));

					}
					$this->IsDynamic = $db->f("IsDynamic");
				}
				$this->IsSearchable = $db->f("IsSearchable");
				$this->Category = $db->f("Category");
				$this->Language = $db->f("Language");
				$_pathFirstPart = substr($this->ParentPath,-1) == "/" ? "" : "/";
				switch($db->f("SubDir")){
					case SUB_DIR_YEAR:
						$this->ParentPath .= $_pathFirstPart.date("Y");
						break;
					case SUB_DIR_YEAR_MONTH:
						$this->ParentPath .= $_pathFirstPart.date("Y")."/".date("m");
						break;
					case SUB_DIR_YEAR_MONTH_DAY:
						$this->ParentPath .= $_pathFirstPart.date("Y")."/".date("m")."/".date("d");
						break;
				}
				$this->i_checkPathDiffAndCreate();
				$this->Text = $this->Filename.$this->Extension;

				// get Customerfilter of parent
				if (defined("CUSTOMER_TABLE") && isset($this->documentCustomerFilter)) {
					$_tmpFolder = new we_folder();
					$_tmpFolder->initByID($this->ParentID, $this->Table);
					$this->documentCustomerFilter = $_tmpFolder->documentCustomerFilter;
					unset($_tmpFolder);

				}
			}
		}
	}


	function formDocType2($width = 300) {
		global $l_we_class;

		$q = getDoctypeQuery($this->DB_WE);

		$we_button = new we_button();

		return $this->formSelect2("", $width, "DocType", DOC_TYPES_TABLE, "ID", "DocType", $l_we_class["doctype"], $q, 1, $this->DocType, false,
								  (($this->DocType !== "") ?
								  	"if(confirm('".$GLOBALS['l_we_class']['doctype_changed_question']."')){we_cmd('doctype_changed');};" :
								  	"we_cmd('doctype_changed');") .
								  	"_EditorFrame.setEditorIsHot(true);", "", "left", "defaultfont", "", $we_button->create_button("edit", "javascript:top.we_cmd('doctypes')", false, -1, -1, "", "", (!we_hasPerm("EDIT_DOCTYPE"))),
		 						  ((we_hasPerm("NO_DOCTYPE") || ($this->ID && $this->DocType == "") ) && !(defined('ISP_VERSION') && ISP_VERSION)) ? array("", $l_we_class["nodoctype"])  : "");
	}

	function formDocTypeTempl(){
		global $l_we_class;
		$content = '<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>'.$this->formDocType2(388).'</td>
	</tr>
	<tr>
		<td>'.getPixel(2,6).'</td>
	</tr>
	<tr>
		<td>'.$this->formIsSearchable().'</td>
	</tr>
	<tr>
		<td>'.$this->formInGlossar().'</td>
	</tr>
</table>
';
		return $content;
	}


### neu

## public ###
	function we_new(){
		we_textDocument::we_new();
		$this->Filename=$this->i_getDefaultFilename();

	}
	function we_load($from=LOAD_MAID_DB){
		switch($from){
			case LOAD_MAID_DB:
				parent::we_load($from);
				break;
			case LOAD_TEMP_DB:
				$sessDat = we_temporaryDocument::load($this->ID, $this->Table, $this->DB_WE);
				if(is_array($sessDat)){
					$this->i_initSerializedDat($sessDat);
					$this->i_getPersistentSlotsFromDB("Path,Text,Filename,Extension,ParentID,Published,ModDate,CreatorID,ModifierID,Owners,RestrictOwners,WebUserID");
					$this->OldPath = $this->Path;
				}else{
					$this->we_load(LOAD_MAID_DB);
				}
				break;
			case LOAD_REVERT_DB:
				$sessDat = we_temporaryDocument::revert($this->ID, $this->Table, $this->DB_WE);
				if($sessDat){
					$this->i_initSerializedDat($sessDat,false);
					$this->i_getPersistentSlotsFromDB("Path,Text,Filename,Extension,ParentID,Published,ModDate,CreatorID,ModifierID,Owners,RestrictOwners,WebUserID");
					$this->OldPath = $this->Path;
				}else{
					$this->we_load(LOAD_TEMP_DB);
				}
				break;
			case LOAD_SCHEDULE_DB :
				$sessDat = unserialize(f("SELECT SerializedData FROM " . SCHEDULE_TABLE . " WHERE DID='".$this->ID."' AND ClassName='".$this->ClassName."' AND Was='".SCHEDULE_FROM."'","SerializedData",$this->DB_WE));

				if($sessDat) {
					$this->i_initSerializedDat($sessDat);
					$this->i_getPersistentSlotsFromDB("Path,Text,Filename,Extension,ParentID,Published,ModDate,CreatorID,ModifierID,Owners,RestrictOwners,WebUserID");
					$this->OldPath = $this->Path;
					break;
				} else {	// take tmp db, when doc not in schedule db
					$this->we_load(LOAD_TEMP_DB);
				}
				break;
		}
		$this->OldPath = $this->Path;
		$this->loadSchedule();
		if($this->Category){ // Category-Fix!
			$this->Category = $this->i_fixCSVPrePost($this->Category);
		}
	}

	function we_load_and_resave($id,$resaveTmp=false,$resaveMain=false){
		$this->initByID($id,FILE_TABLE);

		if($resaveTmp){
			$saveArr = array();
			$this->saveInSession($saveArr);
			if(!we_temporaryDocument::isInTempDB($this->ID, $this->Table, $this->DB_WE)){
				if(!we_temporaryDocument::save($this->ID, $this->Table, $saveArr, $this->DB_WE)) return false;
			}else{
				if(!we_temporaryDocument::resave($this->ID, $this->Table, $saveArr, $this->DB_WE)) return false;
			}
		}

		//resave the document in main-table and write it in site dir
		we_textDocument::we_save();
	}

	function we_save($resave=0){
		$this->i_setText();
		if(!$this->ID){  // when no ID, then allways save before in main table
			if(!we_root::we_save(0)) return false;
		}
		if($resave==0){
			$this->ModifierID = isset($_SESSION["user"]["ID"]) ? $_SESSION["user"]["ID"] : 0;
			$this->ModDate = time();
			$this->wasUpdate=1;
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_history.class.php");
			we_history::insertIntoHistory($this);
			$this->resaveWeDocumentCustomerFilter();
		}

		/* version */
		$version = new weVersions();

		// allways store in temp-table
		$ret = $this->i_saveTmp(!$resave);
		$this->OldPath = $this->Path;
		
		if($this->ContentType=="text/webedition" || $this->ContentType=="text/html") {
			$version->save($this);
		}
		
		/* hook */
		$hook = new weHook($this, 'save');
		$hook->executeHook();
		
		return $ret;
	}

	function we_publish($DoNotMark=false,$saveinMainDB=true){
		if($saveinMainDB){
			if(!we_root::we_save(1)) return false; // calls the root function, so the document will be saved in main-db but it will not be written!
		}

		$_oldPublished = $this->Published;

		$this->Published=time();

		if(!$this->i_writeDocWhenPubl()){
			$this->Published=$_oldPublished;
			return false;
		}

		if($DoNotMark==false){
			if(!$this->DB_WE->query("UPDATE ".mysql_real_escape_string($this->Table)." SET Published='".abs($this->Published)."' WHERE ID='".abs($this->ID)."'")) return false; // mark the document as published;
		}

		if($saveinMainDB) {
			$this->rewriteNavigation();
		}
		if(isset($_SESSION["Versions"]['fromScheduler']) && $_SESSION["Versions"]['fromScheduler'] && ($this->ContentType=="text/webedition" || $this->ContentType=="text/html")) {
			$version = new weVersions();
			$version->save($this, "published");
		}
		/* hook */
		$hook = new weHook($this, 'publish');
		$hook->executeHook();

		return $this->insertAtIndex();
	}

	function we_unpublish(){
		if(!$this->ID) return false;
		if($this->i_isMoved()) {
			if(!deleteLocalFile($this->getRealPath())) {
				return false;
			}
		} else {
			if(!deleteLocalFile($this->getRealPath(true))) {
				return false;
			}
		}
		if(!$this->DB_WE->query("UPDATE ".mysql_real_escape_string($this->Table)." SET Published='0' WHERE ID='".abs($this->ID)."'")) {
			return false;
		}
		$this->Published=0;

		$this->rewriteNavigation();
		
		/* version */
		if($this->ContentType=="text/webedition" || $this->ContentType=="text/html") {
			$version = new weVersions();
			$version->save($this, "unpublished");
		}
		
		$hook = new weHook($this, 'unpublish');
		$hook->executeHook();

		$this->DB_WE->query('SELECT DID FROM ' . INDEX_TABLE . ' WHERE DID=' . abs($this->ID));
		if($this->DB_WE->next_record()) {
			return $this->DB_WE->query("DELETE FROM " . INDEX_TABLE . " WHERE DID=".abs($this->ID));
		}
		

		return true;
	}

	function we_republish($rebuildMain=true){
		if($this->Published){
			return $this->we_publish(true,$rebuildMain);
		}else{
			return $this->DB_WE->query("DELETE FROM " . INDEX_TABLE . " WHERE DID=".abs($this->ID));
		}
	}


	function we_resaveTemporaryTable(){
		$saveArr = array();
		$this->saveInSession($saveArr);
		if(!we_temporaryDocument::isInTempDB($this->ID, $this->Table, $this->DB_WE)){
			if(!we_temporaryDocument::save($this->ID, $this->Table, $saveArr, $this->DB_WE)) return false;
		}else{
			if(!we_temporaryDocument::resave($this->ID, $this->Table, $saveArr, $this->DB_WE)) return false;
		}
		return true;
	}


	function ModifyPathInformation($parentID){
		$this->setParentID($parentID);
		$this->Path = $this->getPath();
		$this->wasUpdate = 1;
		$this->i_savePersistentSlotsToDB("Filename,Extension,Text,Path,ParentID");
		$this->we_resaveTemporaryTable();
		$this->insertAtIndex();
		$this->modifyChildrenPath(); // only on folders, because on other classes this function is empty
	}
### private ####

	function i_saveTmp($write=true){
		$saveArr = array();
		$this->saveInSession($saveArr);
		if(!we_temporaryDocument::save($this->ID, $this->Table, $saveArr, $this->DB_WE)) return false;	
		if(!$this->i_savePersistentSlotsToDB("Path,Text,Filename,Extension,ParentID,CreatorID,ModifierID,RestrictOwners,Owners,Published,ModDate,temp_template_id,temp_category,temp_doc_type,WebUserID")) return false;
		if($write){
			return $this->i_writeDocument();
		}else{
			return true;
		}
	}

	function i_writeMainDir($doc){
		return true; // do nothing!
	}

	function i_writeDocWhenPubl(){
		if(!$this->ID) return false;
		$realPath = $this->getRealPath();
		$parent = dirname($realPath);
        $parent = str_replace("\\","/",$parent);
		$cf = array();
		while( !checkAndMakeFolder($parent) ){
			array_push($cf,$parent);
			$parent = dirname($parent);
        	$parent = str_replace("\\","/",$parent);
		}
		for($i=(sizeof($cf)-1);$i>=0;$i--){
			createLocalFolder($cf[$i]);
		}
		$doc = $this->i_getDocumentToSave();
		if(!we_document::i_writeMainDir($doc)) return false;
		return true;
	}

	function revert_published() {
		we_temporaryDocument::delete($this->ID);
		$this->initByID($this->ID);
		$this->ModDate = $this->Published;
		$this->we_save();
		$this->we_publish();
		if(defined("WORKFLOW_TABLE") && $this->ContentType == "text/webedition") {
			if(weWorkflowUtility::inWorkflow($this->ID,$this->Table)){
				weWorkflowUtility::removeDocFromWorkflow($this->ID,$this->Table,$_SESSION["user"]["ID"],"");
			}
		}
	}

}

?>
