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


define ("WORKFLOWDOC_STEP_STATUS_UNKNOWN", 0);
define ("WORKFLOWDOC_STEP_STATUS_APPROVED", 1);
define ("WORKFLOWDOC_STEP_STATUS_CANCELED", 2);

include_once(WE_WORKFLOW_MODULE_DIR."weWorkflowBase.php");
include_once(WE_WORKFLOW_MODULE_DIR."weWorkflowDocumentTask.php");

/**
* WorkfFlow Document Step definition
* This class describe document step in workflow process
*/
class weWorkflowDocumentStep extends weWorkflowBase{


	var $ID;
	var $workflowStepID;
	var $startDate;
	var $finishDate;
	var $workflowDocID;

	/**
	* list of document tasks
	*/
	var $tasks = array();


	/**
	* Default Constructor
	*
	* Can load or create new Workflow Step Definition depends of parameter
	*/
	function weWorkflowDocumentStep($wfDocumentStep=0)
	{
		parent::weWorkflowBase();
		$this->table=WORKFLOW_DOC_STEP_TABLE;
		$this->ClassName="weWorkflowDocumentStep";

		$this->persistents[]="ID";
		$this->persistents[]="workflowDocID";
		$this->persistents[]="workflowStepID";
		$this->persistents[]="startDate";
		$this->persistents[]="finishDate";
		$this->persistents[]="Status";

		$this->ID = 0;
		$this->workflowDocID = 0;
		$this->workflowStepID=0;
		$this->startDate=0;
		$this->finishDate=0;
		$this->Status=0;

		$this->tasks = array();
		if($wfDocumentStep){
			$this->ID = $wfDocumentStep;
			$this->load();
		}
	}



	/**
	* Load data from database
	*
	*/
	function load($id=0)
	{
		if ($id) $this->ID=$id;

		if($this->ID)
		{
			parent::load();
			## get tasks for workflow
			$this->tasks = weWorkflowDocumentTask::__getAllTasks($this->ID);
			return true;
		}
		else return false;

	}


	/**
	* Start step, activate it
	*
	*/
	function start($desc=""){
		global $l_workflow;
		$this->startDate = time();


		$workflowDoc = new weWorkflowDocument($this->workflowDocID);
		$workflowStep = new weWorkflowStep($this->workflowStepID);
		$deadline=$this->startDate+($workflowStep->Worktime*3600);

		// set all tasks to pending
		for ($i = 0; $i < count($this->tasks); $i++)
		{
			$workflowTask = new weWorkflowTask($this->tasks[$i]->workflowTaskID);
			if($workflowTask->userID){
				//send todo to next user
				$path = "<b>".$l_workflow[($workflowDoc->document->ContentType=='objectFile') ? OBJECT_FILES_TABLE : FILE_TABLE]["messagePath"].':</b>&nbsp;<a href="javascript:top.opener.top.weEditorFrameController.openDocument(\''.$workflowDoc->document->Table.'\',\''.$workflowDoc->document->ID.'\',\''.$workflowDoc->document->ContentType.'\');");" >'.$workflowDoc->document->Path.'</a>';
				$mess="<p><b>".$l_workflow["todo_next"]."</b></p><p>".$desc."</p>";
				
				$this->tasks[$i]->todoID=$this->sendTodo($workflowTask->userID,$l_workflow["todo_subject"],$mess."<p>".$path."</p>",$deadline);
				if($workflowTask->Mail){					
					$foo=f("SELECT Email FROM ".USER_TABLE." WHERE ID=".abs($workflowTask->userID),"Email",$this->db);
					$this_user=getHash("SELECT First,Second,Email FROM ".USER_TABLE." WHERE ID='".$_SESSION["user"]["ID"]."'",$this->db);					
					//if($foo) we_mail($foo,correctUml($l_workflow["todo_next"]),$desc,(isset($this_user["Email"]) && $this_user["Email"]!="" ? "From: ".$this_user["First"]." ".$this_user["Second"]." <".$this_user["Email"].">\n":"")."Content-Type: text/html; charset=iso-8859-1");
					if($foo) we_mail($foo,correctUml($l_workflow["todo_next"]),$desc,(isset($this_user["Email"]) && $this_user["Email"]!="" ? $this_user["First"]." ".$this_user["Second"]." <".$this_user["Email"].">":""));
				}


			}
		}
		return true;
	}

	function finish(){
		$this->finishDate = time();
		return true;
	}
	


	/**
	* create all tasks for step
	*/
	function createAllTasks(){
		$this->tasks = weWorkflowDocumentTask::__createAllTasks($this->workflowStepID);
		return true;
	}


	/**
	* save workflow step in database
	*
	*/
	function save(){
		$db = new DB_WE();

		parent::save();

		## save all tasks also ##
		foreach ($this->tasks as $k=>$v)
		{
			$this->tasks[$k]->documentStepID = $this->ID;
			$this->tasks[$k]->save();
		}
	}

	function delete(){
		foreach($this->tasks as $v) $v->delete();
		parent::delete();
	}


	function approve($uID,$desc,$force=false){
		global $l_workflow;
		if($force){
			foreach($this->tasks as $tk=>$tv){
				$this->tasks[$tk]->approve();
			}
			$this->Status=WORKFLOWDOC_STEP_STATUS_APPROVED;
			$this->finishDate=time();
			//insert into document Log
			$this->Log->logDocumentEvent($this->workflowDocID,$uID,LOG_TYPE_APPROVE_FORCE,$desc);
			return true;
		}
		$i=$this->findTaskByUser($uID);
		if($i>-1){
			$this->tasks[$i]->approve();

			$workflowStep = new weWorkflowStep($this->workflowStepID);
			if($workflowStep->stepCondition==0) $this->Status=WORKFLOWDOC_STEP_STATUS_APPROVED;
			else{
				$num=$this->findNumOfFinishedTasks();
				if($num==count($this->tasks)){
					$status=true;
					foreach($this->tasks as $k=>$v){
						$status=$status && ($v->Status==WORKFLOWDOC_TASK_STATUS_APPROVED ? true : false);
					}

					if($status) $this->Status=WORKFLOWDOC_STEP_STATUS_APPROVED;


				}
			}
			if($this->Status==WORKFLOWDOC_STEP_STATUS_APPROVED || $this->Status==WORKFLOWDOC_STEP_STATUS_CANCELED){
				$this->finishDate=time();
				foreach($this->tasks as $tk=>$tv){
					if($tv->Status==WORKFLOWDOC_TASK_STATUS_UNKNOWN) $this->tasks[$tk]->removeTodo();
				}

			}
			//insert into document Log
			$this->Log->logDocumentEvent($this->workflowDocID,$uID,LOG_TYPE_APPROVE,$desc);
			return true;
		}
		return false;

	}

	function decline($uID,$desc,$force=false){
		global $l_workflow;
		if($force){
			foreach($this->tasks as $tk=>$tv) $this->tasks[$tk]->decline();;
			$this->Status=WORKFLOWDOC_STEP_STATUS_CANCELED;
			$this->finishDate=time();
			//insert into document Log
			$this->Log->logDocumentEvent($this->workflowDocID,$uID,LOG_TYPE_DECLINE,$desc);
			return true;
		}
		$i=$this->findTaskByUser($uID);
		if($i>-1){
			$this->tasks[$i]->decline();
			$workflowStep = new weWorkflowStep($this->workflowStepID);
			$this->Status=WORKFLOWDOC_STEP_STATUS_CANCELED;
			if($this->Status==WORKFLOWDOC_STEP_STATUS_APPROVED || $this->Status==WORKFLOWDOC_STEP_STATUS_CANCELED) $this->finishDate=time();
			//insert into document Log
			$this->Log->logDocumentEvent($this->workflowDocID,$uID,LOG_TYPE_DECLINE,$desc);
			return true;
		}
		return false;
	}

	function findTaskByUser($uID){
		for ($i=0; $i < count($this->tasks); $i++){
			$workflowTask= new weWorkflowTask($this->tasks[$i]->workflowTaskID);
			if($workflowTask->userID==$uID) return $i;
		}
		return -1;
	}

	function findNumOfFinishedTasks(){
		$num=0;
		for ($i=0; $i < count($this->tasks); $i++){
			if($this->tasks[$i]->Status!=0) $num++;
		}
		return $num;
	}

	//---------------------------------- STATIC FUNCTIONS -------------------------------

	/**
	* return all steps for workflow document (created)
	*
	*/
	function __getAllSteps($workflowDocumentID){
		
		$db = new DB_WE();

		$db->query("SELECT ID FROM ".WORKFLOW_DOC_STEP_TABLE." WHERE workflowDocID=".abs($workflowDocumentID)." ORDER BY ID");
		$docSteps = array();
		while ($db->next_record()){
			$docSteps[] = new weWorkflowDocumentStep($db->f("ID"));
		}
		return $docSteps;
	}

	/**
	* create all steps for workflow document
	*
	*/
	function __createAllSteps($workflowID){

		$db = new DB_WE();
		$db->query("SELECT ID FROM ".WORKFLOW_STEP_TABLE." WHERE workflowID =".abs($workflowID)." ORDER BY ID");
		$docSteps = array();
		while ($db->next_record()){
			$docSteps[] = weWorkflowDocumentStep::__createStep($db->f("ID"));
		}
		return $docSteps;
	}


	/**
	* Create step
	*
	*/
	function __createStep($WorkflowStep){

		if (is_array($WorkflowStep)) return weWorkflowDocumentStep::__createStepFromHash($WorkflowStep);

		$db = new DB_WE();
		$db->query("SELECT * FROM ".WORKFLOW_STEP_TABLE." WHERE ID=".abs($WorkflowStep)." ORDER BY ID");
		if (!$db->next_record()){
			return false;
		}
		return weWorkflowDocumentStep::__createStepFromHash($db->Record);
	}


	/**
	* Create step from hash
	*
	*/
	function __createStepFromHash($WorkflowStepArray){
		$docStep = new weWorkflowDocumentStep();

		$docStep->workflowStepID = $WorkflowStepArray["ID"];
		$docStep->startDate = 0;
		$docStep->finishDate = 0;
		$docStep->Status =WORKFLOWDOC_STEP_STATUS_UNKNOWN;
		$docStep->tasks=weWorkflowDocumentTask::__createAllTasks($docStep->workflowStepID);
		return $docStep;
	}


	//-------------------------------STATIC FUNCTIONS END -----------------------------------



}




?>