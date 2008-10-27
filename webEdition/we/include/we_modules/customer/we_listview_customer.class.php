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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/listview/"."listviewBase.class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_db.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_db_tools.inc.php");

/**
* class    we_listview_customer
* @desc    class for tag <we:listview type="banner">
*
*/

class we_listview_customer extends listviewBase {

	var $ClassName = "we_listview_customer";
	var $condition="";
	var $Path="";
	var	$docID=0;

	/**
	 * we_listview_object()
	 * @desc    constructor of class
	 *
	 * @param   $name          string - name of listview
	 * @param   $rows          integer - number of rows to display per page
	 * @param   $order         string - field name(s) to order by
	 * @param   $desc		   string - if desc order
	 * @param   $condition	   string - condition of listview
	 * @param   $cols		   string - number of cols (default = 1)
	 * @param   $docID	   	   string - id of a document where a we:customer tag is on
	 *
	 */

	function we_listview_customer($name="0", $rows=999999, $offset=0, $order="", $desc=false , $condition="", $cols="", $docID=0){

		listviewBase::listviewBase($name, $rows, $offset, $order, $desc, "", false, 0, $cols);

		$this->docID = $docID;
		$this->condition = $condition ? $condition : (isset($GLOBALS["we_lv_condition"]) ? $GLOBALS["we_lv_condition"] : "");

		if($this->docID){
			$this->Path = id_to_path($this->docID,FILE_TABLE,$this->DB_WE);
		}else{
			$this->Path = (isset($GLOBALS["we_doc"]) ? $GLOBALS["we_doc"]->Path : '');
		}

		// IMPORTANT for seeMode !!!! #5317
		$this->LastDocPath = '';
		if (isset($_SESSION['last_webEdition_document'])) {
			$this->LastDocPath = $_SESSION['last_webEdition_document']['Path'];
		}

		if($this->desc && (!eregi(".+ desc$",$this->order))){
			$this->order .= " DESC";
		}

 		if ($this->order != '') { 
			$orderstring = " ORDER BY ".$this->order." "; 
		} else { 
			$orderstring = ''; 
		}
		
		$where = $this->condition ? (' where ' . $this->condition) : '';

		$q = 'SELECT * FROM ' . CUSTOMER_TABLE . $where;
		$this->DB_WE->query($q);
		$this->anz_all = $this->DB_WE->num_rows();

		$q = 'SELECT * FROM ' . CUSTOMER_TABLE . $where . ' ' . $orderstring . ' ' . (($rows > 0) ? (' limit '.$this->start.','.$this->rows) : '');;

		$this->DB_WE->query($q);
		$this->anz = $this->DB_WE->num_rows();
	}

	function next_record(){
		$ret = $this->DB_WE->next_record();
		if ($ret) {
			$this->DB_WE->Record["wedoc_Path"] = $this->Path."?we_cid=".$this->DB_WE->Record["ID"];
			$this->DB_WE->Record["WE_PATH"] = $this->Path."?we_cid=".$this->DB_WE->Record["ID"];
			$this->DB_WE->Record["WE_TEXT"] = $this->DB_WE->Record["Username"];
			$this->DB_WE->Record["WE_ID"] = $this->DB_WE->Record["ID"];
			$this->DB_WE->Record["we_wedoc_lastPath"] = $this->LastDocPath."?we_cid=".$this->DB_WE->Record["ID"];
			$this->count++;
			return true;
		}else if($this->cols && ($this->count < $this->rows)){
			$this->DB_WE->Record = array();
			$this->DB_WE->Record["WE_PATH"] = "";
			$this->DB_WE->Record["WE_TEXT"] = "";
			$this->DB_WE->Record["WE_ID"] = "";
			$this->count++;
			return true;
		}

		return false;
	}

	function f($key){
		return $this->DB_WE->f($key);
	}

}


?>