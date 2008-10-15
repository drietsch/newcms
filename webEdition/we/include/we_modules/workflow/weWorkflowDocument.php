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


define ("WORKFLOWDOC_STATUS_UNKNOWN", 0);
define ("WORKFLOWDOC_STATUS_FINISHED", 1);
define ("WORKFLOWDOC_STATUS_CANCELED", 2);

include_once(WE_WORKFLOW_MODULE_DIR."weWorkflow.php");
include_once(WE_WORKFLOW_MODULE_DIR."weWorkflowDocumentStep.php");

class weWorkflowDocument extends weWorkflowBase{
	//properties
	var $ID;
	var $workflowID;
	var $documentID;
	var $userID;
	var $Status;

	//accossiations
	var $workflow;
	var $document;
	var $steps = array();

	/**
	* Default Constructor
	*
	*/
	function weWorkflowDocument($wfDocument=0){
		weWorkflowBase::weWorkflowBase();
		$this->table=WORKFLOW_DOC_TABLE;
		$this->ClassName="weWorkflowDocument";
		$this->persistents[]="ID";
		$this->persistents[]="workflowID";
		$this->persistents[]="documentID";
		$this->persistents[]="userID";
		$this->persistents[]="Status";

		$this->ID = 0;
		$this->workflowID = 0;
		$this->documentID = 0;
		$this->userID = 0;
		$this->Status=0;
		$this->steps = array();
		$this->document = false;
		$this->workflow = false;

		if($wfDocument){
			$this->ID=$wfDocument;
			$this->load($wfDocument);
		}


	}

	/**
	* Load data from database
	*/
	function load($id=0){
		if ($id) $this->ID=$id;

		if($this->ID)
		{
			parent::load();
			$this->workflow = new weWorkflow($this->workflowID);

			$docTable=$this->workflow->Type==WE_WORKFLOW_OBJECT ? OBJECT_FILES_TABLE : FILE_TABLE;
			$this->db->query("SELECT * FROM $docTable WHERE ID=".abs($this->documentID));
			if($this->db->next_record())
				if($this->db->f("ClassName")){
					if($this->workflow->Type==WE_WORKFLOW_OBJECT)
						include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/object/".$this->db->f("ClassName").".inc.php");
					else
						include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/".$this->db->f("ClassName").".inc.php");
					eval('$this->document=new '.$this->db->f("ClassName").'();');
					if($this->document){
						$this->document->initByID($this->documentID,$docTable);
						$this->document->we_load(LOAD_TEMP_DB);
					}
				}

			$this->steps = weWorkflowDocumentStep::__getAllSteps($this->ID);

		}

	}

	function approve($uID,$desc,$force=false){
		$i=$this->findLastActiveStep();
		if($i<0 && !$force){
			return false;
		}
		$ret=$this->steps[$i]->approve($uID,$desc,$force);
		if($this->steps[$i]->Status==WORKFLOWDOC_STEP_STATUS_APPROVED){
			$this->nextStep($i,$desc,$uID);
		}
		return $ret;
	}

	function decline($uID,$desc,$force=false){
		global $l_workflow;
		$i=$this->findLastActiveStep();
		if($i<0 && !$force) return false;
		$ret=$this->steps[$i]->decline($uID,$desc,$force);
		if($this->steps[$i]->Status==WORKFLOWDOC_STEP_STATUS_CANCELED){
			$this->finishWorkflow(1,$uID);

			$path = "<b>".$l_workflow[($this->workflow->Type==2) ? OBJECT_FILES_TABLE : FILE_TABLE]["messagePath"].':</b>&nbsp;<a href="javascript:top.opener.top.weEditorFrameController.openDocument(\''.$this->document->Table.'\',\''.$this->document->ID.'\',\''.$this->document->ContentType.'\');");" >'.$this->document->Path.'</a>';
			$mess="<p><b>".$l_workflow["todo_returned"]."</b></p><p>".$desc."</p><p>".$path."</p>";
			$deadline=time()+3600;
			$this->sendTodo($this->userID,$l_workflow["todo_returned"],$mess,$deadline,1);

			$mess = $l_workflow["todo_returned"]."\n\n".$desc."\n\n".$this->document->Path;
			$this->sendMail($this->userID,$l_workflow["todo_returned"],$mess);
		}
		return $ret;
	}

	function restartWorkflow($desc){
		foreach($this->steps as $k=>$v) $this->steps[$k]->delete();
		$this->steps=weWorkflowDocumentStep::__createAllSteps($this->workflowID);
		$this->steps[0]->start($desc);
	}


	function nextStep($index=-1,$desc="",$uid=0){
		if($index>-1){
			if($index<count($this->steps)-1) $this->steps[$index+1]->start($desc);
			else $this->finishWorkflow(0,$uid);

		}
	}

	function finishWorkflow($force=0,$uID=0){
		global $l_workflow;
		if($force){
			$this->Status = WORKFLOWDOC_STATUS_CANCELED;
			foreach($this->steps as $sk=>$sv){
				if($this->steps[$sk]->Status==WORKFLOWDOC_STEP_STATUS_UNKNOWN) $this->steps[$sk]->Status=WORKFLOWDOC_STEP_STATUS_CANCELED;
				foreach($this->steps[$sk]->tasks as $tk=>$tv){
					if($this->steps[$sk]->tasks[$tk]->Status==WORKFLOWDOC_TASK_STATUS_UNKNOWN) $this->steps[$sk]->tasks[$tk]->Status=WORKFLOWDOC_TASK_STATUS_CANCELED;
				}

			}
			//insert into document Log
			$this->Log->logDocumentEvent($this->ID,$uID,LOG_TYPE_DOC_FINISHED_FORCE,"");
		}
		else{
			$this->Status = WORKFLOWDOC_STATUS_FINISHED;
			$this->Log->logDocumentEvent($this->ID,$uID,LOG_TYPE_DOC_FINISHED,"");
		}
		return true;

	}

	/**
	* Create next step or finish workflow document if last step is done
	*
	*/
	function createNextStep($stepKey,$uid=0){
		if ($stepKey >= count($this->steps)){
			// no more steps, finish workflow
			return $this->finishWorkflow(0,$uid);
		}
		$step = &$this->steps[$stepKey];
		$step->start();
		return true;
	}


	/**
	* Find last document Status step
	*
	*/
	function findLastActiveStep(){
		for ($i = count($this->steps)-1 ; $i>=0; $i--){
			if ($this->steps[$i]->startDate>0){
				return $i;
			}
		}
		return -1;
	}


	/**
	* save workflow document in database
	*
	*/
	function save(){
		if(!$this->documentID) return false;
		parent::save();
		for ($i=0; $i<count($this->steps); $i++){
			$this->steps[$i]->workflowDocID = $this->ID;
			$this->steps[$i]->save();
		}
		return true;
	}


	function delete(){
		if (!$this->ID){
			return false;
		}

		foreach($this->steps as $k=>$v) $v->delete();
		parent::delete();
		return true;
	}



	/******************* STATIC FUNCTIONS**************************
	/**
	* return workflowDocument for document
	*    return false if no workflow
	*/

	function find($documentID,$type="0,1",$status=WORKFLOWDOC_STATUS_UNKNOWN){

		$db = new DB_WE();		
		$db->query("SELECT ".WORKFLOW_DOC_TABLE.".ID FROM ".WORKFLOW_DOC_TABLE.",".WORKFLOW_TABLE." WHERE ".WORKFLOW_DOC_TABLE.".workflowID=".WORKFLOW_TABLE.".ID AND ".WORKFLOW_DOC_TABLE.".documentID=".abs($documentID)." AND ".WORKFLOW_DOC_TABLE.".Status IN (".mysql_real_escape_string($status).")".($type!="" ? " AND ".WORKFLOW_TABLE.".Type IN (".mysql_real_escape_string($type).")" : "")." ORDER BY ".WORKFLOW_DOC_TABLE.".ID DESC");
		if ($db->next_record())
		{
			return new weWorkflowDocument($db->f("ID"));
		}
		else
		{
			return false;
		}
	}

	/**
	* Create new workflow document
	*    if workflow for that document exists, function will return it
	*/

	function createNew($documentID, $type, $workflowID, $userID, $desc)
	{
		$newWfDoc = weWorkflowDocument::find($documentID,$type);

		if (isset($newWfDoc->ID))
		{
			return $newWfDoc;
		}

		$newWFDoc = new weWorkflowDocument();
		$newWFDoc->documentID = $documentID;
		$newWFDoc->userID = $userID;
		$newWFDoc->workflowID = $workflowID;
		$newWFDoc->workflow = new weWorkflow($workflowID);
		$newWFDoc->steps = weWorkflowDocumentStep::__createAllSteps($workflowID);

		return $newWFDoc;
	}

}

?>