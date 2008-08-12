<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once(WE_WORKFLOW_MODULE_DIR."weWorkflowBase.php");


/**
* General Definition of WebEdition Workflow Task
*/
class weWorkflowTask extends weWorkflowBase{

	var $ID;
	var $stepID;
	var $userID;
	var $Edit;
	var $Mail;



	/**
	* Default Constructor
	*
	* Can load or create new Workflow Task Definition depends of parameter
	*/
	function weWorkflowTask($taskID = 0)
	{
		parent::weWorkflowBase();
		$this->table=WORKFLOW_TASK_TABLE;

		$this->persistents[]="ID";
		$this->persistents[]="userID";
		$this->persistents[]="Edit";
		$this->persistents[]="Mail";
		$this->persistents[]="stepID";


		$this->ID = 0;
		$this->stepID = 0;
		$this->userID = 0;
		$this->Edit = 0;
		$this->Mail = 0;

		if ($taskID>0){
			$this->load($taskID);
		}

	}

	/**
	* get all workflow tasks from database (STATIC)
	*/
	function getAllTasks($stepID)
	{
		$db = new DB_WE;

		$db->query("SELECT ID FROM ".WORKFLOW_TASK_TABLE." WHERE stepID  ='$stepID' ORDER BY ID");

		$tasks = array();

		while ($db->next_record()){
			$tasks[] = new weWorkflowTask($db->f("ID"));
		}
		return $tasks;
	}


	/**
	* Load task from database
	*/
	function load($id=0)
	{
		if($id) $this->ID=$id;
		if ($this->ID){
			parent::load();
			return true;
		}
		else{
			$this->ErrorReporter->Error("No Task with ID $taskID !");
			return false;
		}

	}

}


?>