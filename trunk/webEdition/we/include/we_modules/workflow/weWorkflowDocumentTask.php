<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


define ("WORKFLOWDOC_TASK_STATUS_UNKNOWN", 0);
define ("WORKFLOWDOC_TASK_STATUS_APPROVED", 1);
define ("WORKFLOWDOC_TASK_STATUS_CANCELED", 2);

include_once(WE_WORKFLOW_MODULE_DIR."weWorkflowBase.php");

/**
* WorkfFlow Document Task definition
*
* This class describe document task in workflow process
*
*/
class weWorkflowDocumentTask extends weWorkflowBase{

	// workflow document task ID
	var $ID;
	// workflow document step ID
	var $documentStepID;
	// workflow task ID
	var $workflowTaskID;
	// date when task is done
	var $Date;
	// todo id
	var $todoID;
	// Status of document task
	var $Status;

	/**
	* Default Constructor
	*/
	function weWorkflowDocumentTask($wfDocumentTask=0){
		parent::weWorkflowBase();
		$this->table=WORKFLOW_DOC_TASK_TABLE;
		$this->ClassName="weWorkflowDocumentTask";

		$this->persistents[]="ID";
		$this->persistents[]="documentStepID";
		$this->persistents[]="workflowTaskID";
		$this->persistents[]="Date";
		$this->persistents[]="todoID";
		$this->persistents[]="Status";

		$this->ID = 0;
		$this->documentStepID=0;
		$this->workflowTaskID = 0;
		$this->Date = 0;
		$this->todoID = 0;
		$this->Status = WORKFLOWDOC_TASK_STATUS_UNKNOWN;

		if($wfDocumentTask){
			$this->ID = $wfDocumentTask;
			$this->load();
		}
	}


	function approve(){
		$this->Status=WORKFLOWDOC_TASK_STATUS_APPROVED;
		$this->Date=time();
		$this->doneTodo();
	}

	function decline(){
		$this->Status=WORKFLOWDOC_TASK_STATUS_CANCELED;
		$this->Date=time();
		$this->rejectTodo();
	}

	function removeTodo(){
		if($this->todoID) parent::removeTodo($this->todoID);
	}

	function doneTodo(){
		if($this->todoID) parent::doneTodo($this->todoID);
	}
	
	function rejectTodo(){
		if($this->todoID) {
			parent::rejectTodo($this->todoID);
		}
		
	}
	


	//--------------------------------STATIC FUNCTIONS ------------------------------
	/**
	* returns all tasks for workflow step
	*
	*/
	function __getAllTasks($workflowDocumentStep){

		$db = new DB_WE();


		$db->query("SELECT ID FROM ".WORKFLOW_DOC_TASK_TABLE." WHERE documentStepID ='$workflowDocumentStep' ORDER BY ID");

		$docTasks = array();

		while ($db->next_record()){
			$docTasks[] = new weWorkflowDocumentTask($db->f("ID"));
		}
		return $docTasks;
	}

	/**
	* creates all tasks for workflow step
	*
	*/
	function __createAllTasks($workflowStepID){
		$db = new DB_WE();

		$db->query("SELECT ID FROM ".WORKFLOW_TASK_TABLE." WHERE stepID='$workflowStepID' ORDER BY ID");
		$docTasks = array();
		while ($db->next_record()){
			$docTasks[] = weWorkflowDocumentTask::__createTask($db->f("ID"));
		}
		return $docTasks;
	}

	/**
	* Create task
	*/
	function __createTask($WorkflowTask){
		if (is_array($WorkflowTask)) return weWorkflowDocumentTask::__createTaskFromHash($WorkflowTask);

		$db = new DB_WE;

		$db->query("SELECT * FROM ".WORKFLOW_TASK_TABLE." WHERE ID='$WorkflowTask' ORDER BY ID");
		if (!$db->next_record()){
			return false;
		}
		return weWorkflowDocumentTask::__createTaskFromHash($db->Record);
	}

	/**
	* Create task from hash
	*/
	function __createTaskFromHash($WorkflowTaskArray){
		$docTask = new weWorkflowDocumentTask();
		$docTask->workflowTaskID = $WorkflowTaskArray["ID"];
		return $docTask;
	}

	//--------------------------------STATIC FUNCTIONS END ------------------------------
}

?>