<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


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
		$this->db->query("SELECT * FROM ".$this->table." WHERE ID='".$this->ID."'");
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

			$query = 'INSERT INTO '.$this->table.' SET '.$set;
			$this->db->query($query);
			# get ID #
			$this->db->query("SELECT LAST_INSERT_ID()");
			$this->db->next_record();
			$this->ID = $this->db->f(0);
		}
		else{
			$query = 'UPDATE '.$this->table.' SET '.$set.' WHERE '.$where;
			$this->db->query($query);

		}

	}

	function delete(){
		if ($this->ID){
			$this->db->query('DELETE FROM '.$this->table.' WHERE ID="' . $this->ID . '"');
			return true;
		}
		else return false;

	}

	function sendMessage($userID,$subject,$description){
		$errs = array();
		$foo=f("SELECT username FROM ".USER_TABLE." WHERE ID='".$userID."'","username",$this->db);
		$rcpts = array($foo); /* user names */
		$res = msg_new_message($rcpts,$subject,$description,$errs);

	}

	function sendMail($userID,$subject,$description,$contecttype='text/plain'){
		global $l_workflow;
		$errs = array();
		$foo=f("SELECT Email FROM ".USER_TABLE." WHERE ID='".$userID."'","Email",$this->db);
		if(!empty($foo) && we_check_email($foo)){
			$this_user=getHash("SELECT First,Second,Email FROM ".USER_TABLE." WHERE ID='".$_SESSION["user"]["ID"]."'",$this->db);
			we_mail($foo,correctUml($subject),$description,(isset($this_user["Email"]) && $this_user["Email"]!="" ? $this_user["First"]." ".$this_user["Second"]." <".$this_user["Email"].">":""));
		}
	}

	function sendTodo($userID,$subject,$description,$deadline){
		$errs = array();
		$foo=f("SELECT username FROM ".USER_TABLE." WHERE ID='".$userID."'","username",$this->db);
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