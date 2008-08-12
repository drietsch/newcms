<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");

/**
* Definition of webEdition Base Model
*
*/
class weModelBase{

	var $db;
	var $table="";
	var $persistent_slots=array();
	var $keys=array("ID");
	var $isnew=true;
   /**
	* Default Constructor
	*/

	function weModelBase($table)
	{
		$this->db=new DB_WE();
		$this->table=$table;
		$this->loadPresistents();

	}

	function loadPresistents(){
		$this->persistent_slots=array();
		$tableInfo = $this->db->metadata($this->table);
		for($i=0;$i<sizeof($tableInfo);$i++){
				$fname=$tableInfo[$i]["name"];
				$this->persistent_slots[] = $fname;
				if(!isset($this->$fname)) $this->$fname="";
		}
	}

	/**
	* Load entry from database
	*/
	function load($id="0")
	{
		$ids=explode(",",$id);
		foreach($ids as $k=>$v){
			eval('$this->'.$this->keys[$k].'="'.addslashes($v).'";');
		}

		if ($this->isKeyDefined()){
			$tableInfo = $this->db->metadata($this->table);
			$this->db->query("SELECT * FROM ".$this->table." WHERE ".$this->getKeyWhere().";");
			if($this->db->next_record()){
				for($i=0;$i<sizeof($tableInfo);$i++){
					$fieldName = $tableInfo[$i]["name"];
					if(in_array($fieldName,$this->persistent_slots)){
						$foo = $this->db->f($fieldName);
						eval('$this->'.$fieldName.'=$foo;');
					}
				}
				$this->isnew=false;
				return true;
			}
			else return false;
		}
		else
		{
			return false;
		}

	}

	/**
	* save entry in database
   */
	function save($force_new=false){
		$sets=array();
		$wheres=array();
		if($force_new) $this->isnew=true;
		foreach($this->persistent_slots as $key=>$val){
			//if(!in_array($val,$this->keys))
				eval('if(isset($this->'.$val.')) $sets[]="'.$val.'=\'".addslashes($this->'.$val.')."\'";');
		}
		$where=$this->getKeyWhere();
		$set=implode(",",$sets);

	  if ($this->isKeyDefined() && $this->isnew){
			$this->db->query('SELECT * FROM '.$this->table.' WHERE '.$where.';');
			if($this->db->next_record()) $this->db->query('DELETE FROM '.$this->table.' WHERE '.$where.';');
			$query = 'INSERT INTO '.$this->table.' SET '.$set;

			$this->db->query($query);
			# get ID #
			$this->db->query("SELECT LAST_INSERT_ID()");
			$this->db->next_record();
			$this->ID = $this->db->f(0);
			$this->isnew=false;
			return true;
		}
		else if($this->isKeyDefined()){
			$query = 'UPDATE '.$this->table.' SET '.$set.' WHERE '.$where;
			$this->db->query($query);
			return true;
		}

		return false;
	}


	/**
	* delete entry from database
	*/
	function delete(){
		if (!$this->isKeyDefined()){
			return false;
		}
	  	$this->db->query('DELETE FROM '.$this->table.' WHERE '.$this->getKeyWhere(). ';');
		return true;
	}

	function getKeyWhere(){
			$wheres=array();
			foreach($this->keys as $f){
				eval('$wheres[]="'.$f.'=\'".addslashes($this->'.$f.')."\'";');
			}
			return implode(" AND ",$wheres);
	}

	function isKeyDefined(){
		$defined=true;
		foreach($this->keys as $prim) eval('if(!isset($this->'.$prim.')) $defined=false;');
		return $defined;
	}

	function setKeys($keys){
		$this->keys=$keys;
	}

}

?>