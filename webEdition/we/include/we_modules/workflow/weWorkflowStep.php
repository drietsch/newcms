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
include_once(WE_WORKFLOW_MODULE_DIR."weWorkflowTask.php");

/**
* Workflow Task Type OR Flag
* only one task from current step has to be done
*
*/
define("WE_WORKFLOW_TASK_OR",0);

/**
* Workflow Task Type AND Flag
* all tasks from current step has to be done
*
* @see weWorkflowStep::$taskType
* @access public
*/
define("WE_WORKFLOW_TASK_AND",1);

/**
* General Definition of WebEdition Workflow Step
*/
class weWorkflowStep extends weWorkflowBase{

	var $ID;
	var $workflowID;
	var $Worktime;
	var $timeAction;
	var $stepCondition;
	var $tasks = array();	# array of weWorkflowTask objects


	/**
	* Default Constructor
	*
	* Can load or create new Workflow Step Definition depends of parameter
	*/
	function weWorkflowStep($stepID = 0){
		parent::weWorkflowBase();
		$this->table=WORKFLOW_STEP_TABLE;

		$this->persistents[]="ID";
		$this->persistents[]="Worktime";
		$this->persistents[]="timeAction";
		$this->persistents[]="stepCondition";

		$this->persistents[]="workflowID";

		$this->ID = 0;
		$this->workflowID = 0;
		$this->Worktime = 10;
		$this->timeAction = 0;
		$this->stepCondition = 0;

		$this->tasks = array();

		if ($stepID>0)
		{
			$this->ID=$stepID;
			$this->load();
		}

	}



	/**
	* get all workflow steps from database (STATIC)
	*/
	function getAllSteps($workflowID){
		$db = new DB_WE;

		$db->query("SELECT ID FROM ".WORKFLOW_STEP_TABLE." WHERE workflowID ='$workflowID' ORDER BY ID");

		$steps = array();

		while ($db->next_record())
		{
			$steps[] = new weWorkflowStep($db->f("ID"));
		}
		return $steps;
	}

	/**
	* Load step from database
	*/
	function load($id=0){
		if($id) $this->ID=$id;
		if ($this->ID){
			parent::load();
			## get tasks for step
			$this->tasks = weWorkflowTask::getAllTasks($this->ID);
			return true;
		}
		else{
			return false;
		}
	}


	/**
	* save complete workflow step definition in database
	*/
	function save(){
		$db = new DB_WE();

		parent::save();

		## save all steps also ##

		$tasksList = array();
		for ($i=0; $i<count($this->tasks); $i++)
		{
			$this->tasks[$i]->stepID = $this->ID;
			$this->tasks[$i]->save();

			$tasksList[] = $this->tasks[$i]->ID;
		}

		// !!! here we have to delete all other tasks in database except this in array
		if ( count($tasksList) >0 ){
			$deletequery = 'DELETE FROM '.WORKFLOW_TASK_TABLE.' WHERE stepID=' . $this->ID . ' AND ID NOT IN (' . join(",",$tasksList) . ')';
			$afectedRows = $db->query($deletequery);
		}
	}

	/**
	* delete workflow step from database
	*/
	function delete(){
		if ($this->ID){
			foreach($this->tasks as $key=>$val){
				$this->tasks[$key]->delete();
			}
			parent::delete();
			return true;
		}
		else return false;
	}

}




?>