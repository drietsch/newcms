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

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/modules/weModelBase.php');

class weToolModel extends weModelBase {
	
	var $ID=0;
	var $Text;
	var $ParentID=0;
	var $Path;
	var $Icon;
	var $IsFolder;
	
	var $ModelClassName = 'weToolModel';
	var $toolName = '';
	
	var $requiredFields = array();
	
	function weToolModel($table){

		weModelBase::weModelBase($table);
		
	}
	
	function saveInSession() {
		$_SESSION[$this->toolName . '_session'] = serialize($this);
	}
	
	function clearSessionVars(){
		if(!empty($this->toolName) && isset($_SESSION[$this->toolName . '_session'])){
				unset($_SESSION[$this->toolName . '_session']);
			}
	}
	
	function filenameNotValid() {
		return false;
	}

	function isRequiredField($fieldname) {
		return in_array($fieldname,$this->requiredFields);
	}
	
	function hasRequiredFields(&$failed) {
		foreach ($this->requiredFields as $_req) {
			if(empty($this->$_req)) {
				$failed[] = $_req;
			}
		}
		return empty($failed);
	}
	
	function setPath(){
		$ppath = f('SELECT Path FROM ' . mysql_real_escape_string($this->table) . ' WHERE ID=' . abs($this->ParentID) . ';','Path',$this->db);
		$this->Path=$ppath."/".$this->Text;
	}
	
	function pathExists($path){
		$this->db->query('SELECT * FROM '.mysql_real_escape_string($this->table).' WHERE Path = \''.mysql_real_escape_string($path).'\' AND ID <> \''.abs($this->ID).'\';');
		if($this->db->next_record()) return true;
		else return false;
	}	

	function isSelf(){
		if($this->ID) {
			$_count = 0;
			$_parentid = $this->ParentID;
			while($_parentid!=0) {
				if($_parentid==$this->ID) return true;
				$_parentid = f('SELECT ParentID FROM ' . mysql_real_escape_string($this->table) .' WHERE ID=' . abs($_parentid),'ParentID',$this->db);
				$_count++;
				if($_count==9999) {
					return false;
				}
			}
			return false;
		} else {
			return false;
		}
	}

	function isAllowedForUser(){
		return true;
	}

	function evalPath($id=0) {
		$db_tmp=new DB_WE();
		$path = '';
		if($id==0) {
			$id=$this->ParentID;
			$path=$this->Text;
		}

		$foo=getHash("SELECT Text,ParentID FROM ".mysql_real_escape_string($this->table)." WHERE ID='".abs($id)."';",$db_tmp);
		$path='/'. (isset($foo['Text']) ? $foo['Text'] : '') .$path;

		$pid=isset($foo['ParentID']) ? $foo['ParentID'] : '';
		while($pid > 0) {
				$db_tmp->query("SELECT Text,ParentID FROM ".mysql_real_escape_string($this->table)." WHERE ID='".abs($pid)."'");
				while($db_tmp->next_record()) {
					$path = '/' . $db_tmp->f('Text') . $path;
					$pid = $db_tmp->f('ParentID');
				}
		}
		return $path;
	}

	function updateChildPaths($oldpath) {
		if($this->IsFolder && $oldpath!='' && $oldpath!='/' && $oldpath!=$this->Path) {
			$db_tmp = new DB_WE();
			$this->db->query('SELECT ID FROM ' . mysql_real_escape_string($this->table) . ' WHERE Path LIKE \'' . mysql_real_escape_string($oldpath) . '%\' AND ID<>\''.abs($this->ID).'\';');
			while($this->db->next_record()) {
				$db_tmp->query('UPDATE ' . mysql_real_escape_string($this->table) . ' SET Path=\'' . mysql_real_escape_string($this->evalPath($this->db->f("ID"))) . '\' WHERE ID=\'' . abs($this->db->f("ID")) . '\';');
			}
		}
	}

	function setIsFolder($value) {
		$this->IsFolder = $value;
		if($value) {
			$this->Icon = 'folder.gif';
		} else {
			$this->Icon = 'link.gif';
		}
	}
	
	function deleteChilds(){
		$this->db->query('SELECT ID FROM '. mysql_real_escape_string($this->table) . ' WHERE ParentID="'.abs($this->ID).'"');
		while($this->db->next_record()){
			$child=new $this->ModelClassName($this->db->f("ID"));
			$child->delete();
		}
	}
	
	function delete() {

		if (!$this->ID) return false;
		
		if($this->IsFolder) $this->deleteChilds();
		
		parent::delete();
		
		return true;
	}

}
?>