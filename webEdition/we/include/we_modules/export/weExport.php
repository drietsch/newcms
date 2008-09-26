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


include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/modules/"."weModelBase.php");


/**
* General Definition of WebEdition Export
*
*/
class weExport extends weModelBase{

	//properties
	var $ID;
	var $Text;
    var $ParentID;
	var $Icon;
	var $IsFolder;
	var $Path;
	
	var $ExportTo; // local | server
	var $ServerPath;
	var $Filename; 
	var $Selection = 'auto'; // auto | manual
	var $SelectionType = 'doctype'; // doctype | classname
	var $DocType;
	var $Folder;
	var $ClassName;
	var $Categorys;
	
	var $selDocs;
	var $selTempl;
	var $selObjs;
	var $selClasses;
	
	var $HandleDefTemplates;
	var $HandleDocIncludes;
	var $HandleObjIncludes;
	var $HandleDocLinked;
	var $HandleDefClasses;
	var $HandleObjEmbeds;
	var $HandleDoctypes;
	var $HandleCategorys;
	var $HandleOwners;
	var $HandleNavigation;
	var $HandleThumbnails;
	
	var $ExportDepth;
	var $Log = array();
			
	var $ExportFilename;
	
	var $protected=array("ID","ParentID","Icon","IsFolder","Path","Text");
	
		
	/**
	* Default Constructor
	* Can load or create new Newsletter depends of parameter
	*/

	function weExport($exportID = 0){
		
		$this->table=EXPORT_TABLE;
		
		weModelBase::weModelBase(EXPORT_TABLE);
		$this->setDefaults();
		if ($exportID){
			$this->ID=$exportID;
			$this->load($exportID);
		}
		// clear expiered stuff		
		$this->selDocs = $this->clearExpiered($this->selDocs,FILE_TABLE);
		$this->selTempl = $this->clearExpiered($this->selTempl,TEMPLATES_TABLE);
		if(defined('OBJECT_TABLE')){
			$this->selObjs = $this->clearExpiered($this->selObjs,OBJECT_FILES_TABLE);
			$this->selClasses = $this->clearExpiered($this->selClasses,OBJECT_TABLE);
		} else {
			$this->selObjs = '';
			$this->selClasses = '';
		}		
	}
	
	function clearExpiered($ids,$table,$idfield='ID'){
		$idsarr = makeArrayFromCSV($ids);
		$new = array();
		foreach($idsarr as $id){
			if(f('SELECT '.$idfield.' FROM '.$table.' WHERE '.$idfield.'=\''.$id.'\';',$idfield,new DB_WE())) $new[] = $id;
		}
		return makeCSVFromArray($new);
	}
	
	function save($force_new=false){
		$this->Icon = ($this->IsFolder==1 ? 'folder.gif' : 'link.gif');
		$sets=array();
		$wheres=array();		
		foreach($this->persistent_slots as $key=>$val){
			//if(!in_array($val,$this->keys))
				eval('if(isset($this->'.$val.')) $sets[]="'.$val.'=\'".addslashes($this->'.$val.')."\'";');
		}
		$where=$this->getKeyWhere();
		$set=implode(",",$sets);
		

	  if (!$this->ID || $force_new){

			$this->db->query('SELECT * FROM '.$this->table.' WHERE '.$where.';');
			if($this->db->next_record()) $this->db->query('DELETE FROM '.$this->table.' WHERE '.$where.';');
			$query = 'INSERT INTO '.$this->table.' SET '.$set;

			$this->db->query($query);
			# get ID #
			$this->db->query("SELECT LAST_INSERT_ID()");
			$this->db->next_record();
			$this->ID = $this->db->f(0);
			return true;
		}else{
			$query = 'UPDATE '.$this->table.' SET '.$set.' WHERE '.$where;
			$this->db->query($query);
			return true;
		}

		return false;
	}

	function delete(){
		//if (!$this->ID) return false;
			if($this->IsFolder) $this->deleteChilds();
			parent::delete();
			return true;
	}
	
	/*********************************
	* delete childs from database
	*
	**********************************/	
	function deleteChilds(){		
		$this->db->query("SELECT ID FROM ".EXPORT_TABLE . " WHERE ParentID='".$this->ID."'");
		while($this->db->next_record()){
			$child=new weExport($this->db->f("ID"));
			$child->delete();
		}
	}	
	
	function clearSessionVars(){
			if(isset($_SESSION["export_session"])) unset($_SESSION["export_session"]);
			if(isset($_SESSION["ExportSession"])) unset($_SESSION["ExportSession"]);
			if(isset($_SESSION["exportVars"])) unset($_SESSION["exportVars"]);
	}
	
	function filenameNotValid($text){
			return eregi('[^a-z0-9���\._\@\ \-]',$text);
	}
	
	function exportToFilenameValid($filename) {
		
		return (eregi("p?html?", $filename) || eregi("inc", $filename) || eregi("php3?", $filename));
	}
	
	function setDefaults() {
		$this->ParentID = 0;
		$this->Text = "weExport_".time();
		$this->Icon = 'link.gif';
		$this->Selection = 'auto';
		$this->SelectionType = 'doctype';
		$this->Filename = $this->Text.".xml";
		$this->ExportDepth = 5;

		$this->HandleDefTemplates=0;
		$this->HandleDocIncludes=0;
		$this->HandleObjIncludes=0;
		$this->HandleDocLinked=0;
		$this->HandleDefClasses=0;
		$this->HandleObjEmbeds=0;
		$this->HandleDoctypes=0;
		$this->HandleCategorys=0;
		$this->HandleOwners=0;
		$this->HandleNavigation=0;
	}
	
	function setPath(){
		$ppath = f('SELECT Path FROM ' . EXPORT_TABLE . ' WHERE ID=' . $this->ParentID . ';','Path',$this->db);
		$this->Path=$ppath."/".$this->Text;
	}
	
	function pathExists($path){
		$this->db->query('SELECT * FROM '.$this->table.' WHERE Path = \''.$path.'\' AND ID <> \''.$this->ID.'\';');
		if($this->db->next_record()) return true;
		else return false;
	}
	
	function isSelf(){		
		if(ereg('/'.$this->Text.'/',clearPath(dirname($this->Path) . '/'))) return true;
		else return false;
	}
	
	function evalPath($id=0) {
		$db_tmp=new DB_WE();
		$path = "";
		if($id==0) {
			$id=$this->ParentID;
			$path=$this->Text;
		}

		$foo=getHash("SELECT Text,ParentID FROM ".EXPORT_TABLE." WHERE ID='".$id."';",$db_tmp);
		$path="/". (isset($foo["Text"]) ? $foo["Text"] : "") .$path;

		$pid=isset($foo["ParentID"]) ? $foo["ParentID"] : "";
		while($pid > 0) {
				$db_tmp->query("SELECT Text,ParentID FROM ".EXPORT_TABLE." WHERE ID='$pid'");
				while($db_tmp->next_record()) {
					$path = "/".$db_tmp->f("Text").$path;
					$pid = $db_tmp->f("ParentID");
				}
		}
		return $path;
	}	
	

}


?>