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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_db.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_db_tools.inc.php");
include_once( WE_CUSTOMER_MODULE_DIR ."we_listview_customer.class.php");



class we_customertag{

	var $DB_WE;
	var $class = "";
	var $id = 0;
	var $ClassName = "we_customertag";
	var $object = "";
	var $avail = false;

	function we_customertag($id=0, $condition=""){
		$this->DB_WE = new DB_WE;
		$this->id = $id;

		$unique = md5(uniqid(rand()));

		if($this->id){
			$this->object = new we_listview_customer($unique, 1, 0, "", 0, "(ID='".abs($this->id)."')" .  ($condition ? " AND $condition" : ""));
			if($this->object->next_record()){
				$this->avail = true;
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