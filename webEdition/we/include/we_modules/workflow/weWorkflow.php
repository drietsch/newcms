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


// Document-Type/Category based Workflow Type
define ("WE_WORKFLOW_DOCTYPE_CATEGORY", 0);
// Directory based Workflow Type
define ("WE_WORKFLOW_FOLDER", 1);
// Object based Workflow Type
define ("WE_WORKFLOW_OBJECT", 2);

define ("WE_WORKFLOW_STATE_INACTIVE", 0);
define ("WE_WORKFLOW_STATE_ACTIVE", 1);

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/workflow.inc.php");
include_once(WE_WORKFLOW_MODULE_DIR."weWorkflowStep.php");
include_once(WE_WORKFLOW_MODULE_DIR."weWorkflowTask.php");

/**
* General Definition of WebEdition Workflow
*
*/
class weWorkflow extends weWorkflowBase{
	//properties
	var $ID;
	var $Text;
	var $Type;
	var $Folders;
	var $DocType;
	var $Objects;
	var $Categories;
	var $ObjCategories;
	var $Status=0;


	/**
	* steps for WorkFlow Definition
	* this is array of weWorkflowStep objects
	*/
	var $steps = array();
	// default document object
	var $documentDef;
	// documents array; format document[documentID]=document_name
	// don't create array of objects 'cos whant to save some memory
	var $documents = array();

	/**
	* Default Constructor
	* Can load or create new Workflow Definition depends of parameter
	*/

	function weWorkflow($workflowID = 0)
	{
	    global $l_workflow;
        parent::weWorkflowBase();
        $this->table=WORKFLOW_TABLE;

		$this->persistents[]="ID";
		$this->persistents[]="Text";
		$this->persistents[]="Type";
		$this->persistents[]="DocType";
		$this->persistents[]="Folders";
		$this->persistents[]="Objects";
		$this->persistents[]="Categories";
		$this->persistents[]="ObjCategories";
		$this->persistents[]="Status";


		$this->ID = 0;
		$this->Text = $l_workflow["new_workflow"];
		$this->Type = WE_WORKFLOW_FOLDER;
		$this->Folders = ",0,";
		$this->FolderPath = "";
		$this->DocType = 0;
		$this->Objects = "";
		$this->Categories = "";
		$this->ObjCategories = "";
		$this->Status = WE_WORKFLOW_STATE_INACTIVE;
		$this->steps = array();

		$this->AddNewStep();
		$this->AddNewTask();

		if ($workflowID)
		{
			$this->ID=$workflowID;
			$this->load($workflowID);
		}
	}

	/**
	* Load workflow definition from database
	*/
	function load($id=0)
	{
		if($id) $this->ID=$id;
		if ($this->ID){

			parent::load();

			// get steps for workflow
			$this->steps = weWorkflowStep::getAllSteps($this->ID);
			$this->loadDocuments();
			return true;

		}
		else
		{
			return false;
		}

	}

	/**
	* get all documents for workflow from database
	*/
	function loadDocuments(){
			$db_tmp = new DB_WE();
			$this->db->query("SELECT ID,documentID FROM ".WORKFLOW_DOC_TABLE." WHERE workflowID=".abs($this->ID)." AND Status=0");
			$docTable=($this->Type==WE_WORKFLOW_OBJECT ? OBJECT_FILES_TABLE : FILE_TABLE );
			while($this->db->next_record()){
				$db_tmp->query("SELECT ID,Text,Icon FROM $docTable WHERE ID='".$this->db->f("documentID")."'");
				if($db_tmp->next_record()){
					$newdoc=array();
					$newdoc["ID"]=$this->db->f("ID");
					$newdoc["Text"]=$db_tmp->f("Text");
					$newdoc["Icon"]=$db_tmp->f("Icon");
					$this->documents[]=$newdoc;
				}
			}
	}

	/**
	* get all workflows from database (STATIC)
	*/
	function getAllWorkflows() {

		$this->db->query("SELECT ID FROM " .WORKFLOW_TABLE. " ORDER BY Text");

		$wfs = array();
		while ($this->db->next_record())
		{
			$wfs[] = new weWorkflow($this->db->f("ID"));
		}
		return $wfs;
	}

	/**
	* get all workflows from database
	*
	*/
	function getAllWorkflowsInfo($status=WE_WORKFLOW_STATE_ACTIVE,$type=WE_WORKFLOW_DOCTYPE_CATEGORY){
		
		$db=new DB_WE();

		$db->query("SELECT ID,Text FROM " . WORKFLOW_TABLE . " WHERE Status IN (".$status.") AND Type IN (".$type.") ORDER BY Text");
		$wfs = array();
		while ($db->next_record())
		{
			$wfs[$db->f("ID")] = $db->f("Text") ;
		}
		return $wfs;
	}


	/**
	* save complete workflow definition in database
	* saving also all steps and tasks for current workflow
	*/
	function save()
	{
		parent::save();

		// save all steps also

		$stepsList = array();

		reset($this->steps);
		for ($i=0; $i<count($this->steps); $i++)
		{
			$this->steps[$i]->workflowID = $this->ID;
			$this->steps[$i]->save();

			$stepsList[] = $this->steps[$i]->ID;
		}


		// !!! here we have to delete all other steps in database except this in array
		if ( count($stepsList) >0 )
		{
			$deletequery = 'DELETE FROM '.WORKFLOW_STEP_TABLE.' WHERE workflowID=' . abs($this->ID) . ' AND ID NOT IN (' . join(",",$stepsList) . ')';
			$afectedRows = $this->db->query($deletequery);
		}
		
		//remove all documents from workflow
		foreach($this->documents as $k=>$val){
			$this->documentDef=new weWorkflowDocument($val["ID"]);
			$this->documentDef->finishWorkflow(1);
			$this->documentDef->save();
		}


	}



	/**
	* delete workflow from database
	* delete also all steps and tasks for current workflow
	*/
	function delete()
	{
		if (!$this->ID)
		{
			return false;
		}

		foreach ($this->steps as $key=>$val)
		{
			$this->steps[$key]->delete();
		}

		foreach($this->documents as $key=>$val){
			$this->documentDef = new weWorkflowDocument($val["ID"]);
			$this->documentDef->delete();
		}

		parent::delete();

		return true;

		//$this->ID = -2; # status deleted
	}

	
	function isDocInWorkflow($docID,$type){
		$db = new DB_WE;
		$db->query('SELECT ID FROM '.WORKFLOW_DOC_TABLE.' WHERE documentID=' . abs($docID) . '" AND Type IN(0,1) AND Status=0');
		if($db->next_record()) return $db->f("ID");
		else false;
	}

	function isObjectInWorkflow($docID){
		$db = new DB_WE;
		$db->query('SELECT ID FROM '.WORKFLOW_DOC_TABLE.' WHERE documentID=' . abs($docID) . '" AND Type=2 AND Status=0');
		if($db->next_record()) return $db->f("ID");
		else false;
	}


	/**
	* Get workflow for document
	*/
	function getDocumentWorkflow($doctype, $categories, $folder){

		$wfIDs = array();
		$db = new DB_WE;
		$workflowID = 0;
		/**
		* find by document type (has to be together with category)
		*/

		if ($doctype){
			$db->query("SELECT ID FROM ".WORKFLOW_TABLE." WHERE DocType='".$doctype."' AND Type=".WE_WORKFLOW_DOCTYPE_CATEGORY." AND Status=".WE_WORKFLOW_STATE_ACTIVE);
			while ($db->next_record()){
				if(isset($wfIDs[$db->f("ID")])){
					$wfIDs[$db->f("ID")]++;
				}else{
					$wfIDs[$db->f("ID")] = 1;
				}
			}
		}

		/**
		* find by category
		*/
		if ($categories)
		{
			$cats=makeArrayFromCSV($categories);
			foreach($cats as $k=>$v){
				if ($doctype!="")
					$db->query("SELECT ID FROM ".WORKFLOW_TABLE." WHERE DocType=".abs($doctype)."' AND Categories LIKE '%,".mysql_real_escape_string($v).",%' AND Type=".WE_WORKFLOW_DOCTYPE_CATEGORY." AND Status=".WE_WORKFLOW_STATE_ACTIVE);
				else
					$db->query("SELECT ID FROM ".WORKFLOW_TABLE." WHERE Categories LIKE '%,".mysql_real_escape_string($v).",%' AND Type=".WE_WORKFLOW_DOCTYPE_CATEGORY." AND Status=".WE_WORKFLOW_STATE_ACTIVE);
				while ($db->next_record()){
					if(isset($wfIDs[$db->f("ID")])){
						$wfIDs[$db->f("ID")]++;
					}else{
						$wfIDs[$db->f("ID")] = 1;
					}
				}
			}
		}
		$max = 0;
		foreach($wfIDs as $wfID=>$anz){
			if($anz > $max){
				$workflowID = $wfID;
				$max = $anz;
			}
		}

		if ($workflowID)  // when we have found a document type-based workflow we can return
			return $workflowID;

		$workflowID = weWorkflow::findWfIdForFolder($folder);
		/**
		* create workflow document
		*/
		if ($workflowID)
			return $workflowID;

		return false;
	}
	
	
	function findWfIdForFolder($folderID){
		$db = new DB_WE();
		$wfID = f("SELECT ID FROM ".WORKFLOW_TABLE." WHERE Folders LIKE '%,".abs($folderID).",%' AND Type=".WE_WORKFLOW_FOLDER." AND Status=".WE_WORKFLOW_STATE_ACTIVE,"ID",$db);
		if($folderID > 0 && (!$wfID)){
			$pid = f("SELECT ParentID FROM ".FILE_TABLE." WHERE ID=".abs($folderID),"ParentID",$db);
			return weWorkflow::findWfIdForFolder($pid);
		}else{
			return $wfID;
		}
	}

	/**
	* Get workflow for object
	*/
	function getObjectWorkflow($object,$categories=""){
		$db = new DB_WE;
		$workflowID = 0;
		
		$wfIDs = array();

		$db->query("SELECT ID FROM ".WORKFLOW_TABLE." WHERE Objects LIKE '%,".mysql_real_escape_string($object).",%' AND Type=".WE_WORKFLOW_OBJECT." AND Status=".WE_WORKFLOW_STATE_ACTIVE);
		while ($db->next_record()){
			if(isset($wfIDs[$db->f("ID")])){
				$wfIDs[$db->f("ID")]++;
			}else{
				$wfIDs[$db->f("ID")] = 1;
			}
		}

		/**
		* find by category
		*/
		if ($categories)
		{
			$cats=makeArrayFromCSV($categories);
			foreach($cats as $k=>$v){
				$db->query("SELECT ID FROM ".WORKFLOW_TABLE." WHERE Objects LIKE '%,".mysql_real_escape_string($object).",%' AND ObjCategories LIKE '%,".mysql_real_escape_string($v).",%' AND Type=".WE_WORKFLOW_OBJECT." AND Status=".WE_WORKFLOW_STATE_ACTIVE);
				while ($db->next_record()){
					if(isset($wfIDs[$db->f("ID")])){
						$wfIDs[$db->f("ID")]++;
					}else{
						$wfIDs[$db->f("ID")] = 1;
					}
				}
			}
		}
		
		$max = 0;
		foreach($wfIDs as $wfID=>$anz){
			if($anz > $max){
				$workflowID = $wfID;
				$max = $anz;
			}
		}


		if ($workflowID)
			return $workflowID;

		return false;
	}


	function addNewStep(){
		$this->steps[]=new weWorkflowStep();
	}

	function addNewTask(){
		foreach($this->steps as $k=>$v) $this->steps[$k]->tasks[]=new weWorkflowTask();
	}




}


?>