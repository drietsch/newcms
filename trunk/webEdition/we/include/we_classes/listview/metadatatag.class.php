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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/listview/we_listview.class.php");


class metadatatag{

	var $DB_WE;
	var $ClassName = "metadatatag";
	var $object = "";
	var $avail = false;
	var $id = 0;

	function metadatatag($name){
		$this->DB_WE = new DB_WE;
		
		if($name){
			$unique = md5(uniqid(rand()));
			if (!isset($GLOBALS["lv"])) {
				// determine the id of the element
				$_value = $GLOBALS["we_doc"]->getElement($name,"bdid");
				if (!$_value) {
					$_value = $GLOBALS["we_doc"]->getElement($name);
				}
			} else {
				$_value = $GLOBALS["lv"]->f($name);
			}
			$this->id = 0;
			if (is_numeric($_value)) {
				// it is an id
				$this->id = $_value;
			} else if($_value){
				// is this possible
				//TODO: check if this can happen
			}
			if ($this->id) {
				$this->object = new we_listview($unique,1,0,"",false,"","",false,false,0,"","",false,"","","","","","","off",true,"",$this->id);
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