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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/workflow.inc.php");
include_once(WE_MESSAGING_MODULE_DIR."messaging_interfaces.inc.php");
include_once(WE_WORKFLOW_MODULE_DIR."weWorkflowLog.php");

/**
* Document Definition base class
*/

class weWorkflowBase{
	var $uid;

	var $db;

	var $persistents=array();

	var $table="";

	var $ClassName;
	
	var $Log;

	function weWorkflowBase()
	{
		$this->uid = "wf_".md5(uniqid(rand()));
		$this->db = new DB_WE();
		$this->Log = new weWorkflowLog();
		$this->ClassName="weWorkflowBase";
	}



	function load(){
		$tableInfo = $this->db->metadata($this->table);
		$this->db->query("SELECT * FROM ".mysql_real_escape_string($this->table)." WHERE ID=".abs($this->ID));
		if($this->db->next_record())
		for($i=0;$i<sizeof($tableInfo);$i++){
				$fieldName = $tableInfo[$i]["name"];
				if(in_array($fieldName,$this->persistents)){
					$foo = $this->db->f($fieldName);
					eval('$this->'.$fieldName.'=$foo;');
				}
		}
	}

	function save(){
		$sets=array();
		$wheres=array();
		foreach($this->persistents as $key=>$val){
			if($val=="ID") eval('$wheres[]="'.$val.'=\'".$this->'.$val.'."\'";');
			eval('$sets[]="'.$val.'=\'".$this->'.$val.'."\'";');
		}
		$where=implode(",",$wheres);
		$set=implode(",",$sets);

		if ($this->ID==0){

			$query = 'INSERT INTO '.mysql_real_escape_string($this->table).' SET '.$set;
			$this->db->query($query);
			# get ID #
			$this->db->query("SELECT LAST_INSERT_ID()");
			$this->db->next_record();
			$this->ID = $this->db->f(0);
		}
		else{
			$query = 'UPDATE '.mysql_real_escape_string($this->table).' SET '.$set.' WHERE '.$where;
			$this->db->query($query);

		}

	}

	function delete(){
		if ($this->ID){
			$this->db->query('DELETE FROM '.mysql_real_escape_string($this->table).' WHERE ID=' . abs($this->ID));
			return true;
		}
		else return false;

	}

	function sendMessage($userID,$subject,$description){
		$errs = array();
		$foo=f("SELECT username FROM ".USER_TABLE." WHERE ID=".abs($userID),"username",$this->db);
		$rcpts = array($foo); /* user names */
		$res = msg_new_message($rcpts,$subject,$description,$errs);

	}

	function sendMail($userID,$subject,$description,$contecttype='text/plain'){
		global $l_workflow;
		$errs = array();
		$foo=f("SELECT Email FROM ".USER_TABLE." WHERE ID=".abs($userID),"Email",$this->db);
		if(!empty($foo) && we_check_email($foo)){
			$this_user=getHash("SELECT First,Second,Email FROM ".USER_TABLE." WHERE ID=".abs($_SESSION["user"]["ID"]),$this->db);
			we_mail($foo,correctUml($subject),$description,(isset($this_user["Email"]) && $this_user["Email"]!="" ? $this_user["First"]." ".$this_user["Second"]." <".$this_user["Email"].">":""));
		}
	}

	function sendTodo($userID,$subject,$description,$deadline){
		$errs = array();
		$foo=f("SELECT username FROM ".USER_TABLE." WHERE ID=".abs($userID),"username",$this->db);
		$rcpts = array($foo); /* user names */
		return msg_new_todo($rcpts,$subject,$description,$errs,"html",$deadline);

	}

	function doneTodo($id){
		$errs = "";
		return msg_done_todo($id,$errs);
	}

	function removeTodo($id){
		return msg_rm_todo($id);
	}
	
	function rejectTodo($id){
		return msg_reject_todo($id);
	}

}

?>