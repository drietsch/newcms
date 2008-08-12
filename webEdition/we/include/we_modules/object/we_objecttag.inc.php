<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_db.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_db_tools.inc.php");
include_once( WE_OBJECT_MODULE_DIR ."we_listview_object.class.php");



class we_objecttag{

	var $DB_WE;
	var $class = "";
	var $id = 0;
	var $triggerID = 0;
	var $ClassName = "we_objecttag";
	var $object = "";
	var $avail = false;

	function we_objecttag($class="", $id=0, $triggerID=0, $searchable=true, $condition=""){
		$this->DB_WE = new DB_WE;
		$this->id = $id;
		$this->class = $class;

		$this->triggerID = $triggerID;
		$unique = md5(uniqid(rand()));

		if($this->id){
			$foo = getHash("SELECT TableID,ObjectID FROM ".OBJECT_FILES_TABLE." WHERE ID='".abs($this->id)."'",$this->DB_WE);
			if(count($foo) > 0 ){
				$this->object = new we_listview_object($unique,1,0,"",0,$foo["TableID"],"","","(" . OBJECT_X_TABLE.$foo["TableID"].".ID='".abs($foo["ObjectID"])."')" .  ($condition ? " AND $condition" : ""),$this->triggerID,"","",$searchable);
				if($this->object->next_record()){
					$this->avail = true;
				}
			}
		}
 	}

	function f($key){
		if($this->id){
			return $this->object->f($key);
		}else{
			return "";
		}
	}

}

?>