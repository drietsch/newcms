<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


	include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/conf/we_conf.inc.php");
	include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_modules/workflow/we_conf_workflow.inc.php");
	include_once(WE_WORKFLOW_MODULE_DIR."weWorkflowDocument.php");

	class weWorkflowUtility{

		function getTypeForTable($table){
			$type=0;
			
			if($table==FILE_TABLE) $type="0,1";
			else if(defined("OBJECT_FILES_TABLE") && $table==OBJECT_FILES_TABLE) $type="2";
			else  $type="0,1";
			
			return $type;
		}

		function insertDocInWorkflow($docID,$table,$workflowID,$userID,$desc){
			global $l_workflow;
			$desc = nl2br($desc);
			$type=weWorkflowUtility::getTypeForTable($table);
			//create new workflow document
			$doc=weWorkflowDocument::createNew($docID,$type,$workflowID,$userID,$desc);
			if(isset($doc->ID)){
				$doc->save();
				if(isset($doc->steps[0])) $doc->steps[0]->start($desc);
				//insert into document history
				$doc->Log->logDocumentEvent($doc->ID,$userID,LOG_TYPE_DOC_INSERTED,$desc);
				$doc->save();
				return true;
			}
			return false;
		}

		function approve($docID,$table,$userID,$desc,$force=false){
			/* approve step */
			$desc = nl2br($desc);
			$doc=weWorkflowUtility::getWorkflowDocument($docID,$table);
			if(isset($doc->ID)){
				if($doc->approve($userID,$desc,$force)){
					$doc->save();
					return true;
				}
			}
			return false;
		}

		/*

		*/
		function decline($docID,$table,$userID,$desc,$force=false){
			/* decline step */
			$desc = nl2br($desc);
			$doc=weWorkflowUtility::getWorkflowDocument($docID,$table);
			if(isset($doc->ID)){
				if($doc->decline($userID,$desc,$force)){
					$doc->save();
					return true;
				}
			}
			return false;
		}

		/*
			This function can be used to force removal
			of document from workflow.
		*/
		function removeDocFromWorkflow($docID,$table,$userID,$desc){
			$desc = nl2br($desc);
			$doc=weWorkflowUtility::getWorkflowDocument($docID,$table);
			if(isset($doc->ID))
			if($doc->finishWorkflow(1,$userID)){
				$doc->save();
				//insert into document history
				$doc->Log->logDocumentEvent($doc->ID,$userID,LOG_TYPE_DOC_REMOVED,$desc);
				return true;
			}
			return false;
		}


		/*
			Function returns workflow document object for defined docID
			If workflow documnet is not defined for that document false
			will be returned
		*/
		function getWorkflowDocument($docID,$table,$status=WORKFLOWDOC_STATUS_UNKNOWN){
			$type=weWorkflowUtility::getTypeForTable($table);
			return weWorkflowDocument::find($docID,$type,$status);
		}
		/*
			Same like getWorkflowDocument but returns
			workflow document id (not object)
		*/
		function getWorkflowDocumentID($docID,$table,$status=WORKFLOWDOC_STATUS_UNKNOWN){
			$doc=weWorkflowUtility::getWorkflowDocument($docID,$table,$status);
			if(isset($doc->ID)){
				if($doc->ID) return $doc->ID;
				else false;
			}
			else return false;
		}

		/*
			Functions tries to find workflow for defined
			documents parameters and returns new document object
		*/
		function getWorkflowDocumentForDoc($doctype=0, $categories="", $folder=-1){
			$workflowID=weWorkflow::getDocumentWorkflow($doctype, $categories, $folder);
			$newDoc=new weWorkflowDocument();
			$newDoc->workflowID=$workflowID;
			$newDoc->steps=weWorkflowDocumentStep::__createAllSteps($workflowID);
			return $newDoc;
		}

		/*
			Functions tries to find workflow for defined
			objects parametars and returns new document object
		*/
		function getWorkflowDocumentForObject($object, $categories=""){
			$workflowID=weWorkflow::getObjectWorkflow($object,$categories);
			$newDoc=new weWorkflowDocument();
			$newDoc->workflowID=$workflowID;
			$newDoc->steps=weWorkflowDocumentStep::__createAllSteps($workflowID);
			return $newDoc;
		}

		function getWorkflowName($workflowID){
			$foo = weWorkflowUtility::getAllWorkflows();
			return $foo[$workflowID];
		}

		function getAllWorkflows($status=WE_WORKFLOW_STATE_ACTIVE,$table=FILE_TABLE){ // returns hash array with ID as key and Name as value
			$type=weWorkflowUtility::getTypeForTable($table);
			return weWorkflow::getAllWorkflowsInfo($status,$type);

		}

		function inWorkflow($docID,$table){
			$doc=weWorkflowUtility::getWorkflowDocument($docID,$table);
			if(isset($doc->ID) && $doc->ID) return true;
			else return false;
		}


		function isWorkflowFinished($docID,$table){
			$doc=weWorkflowUtility::getWorkflowDocument($docID,$table);
			if(!isset($doc->ID)) return false;
			$i=$doc->findLastActiveStep();			
			if($i<=0) return false;
			if($i<count($doc->steps)-1) return false;
			if($doc->steps[$i]->findNumOfFinishedTasks()<count($doc->steps[$i]->tasks)) return false;
			return true;
		}


		/*
			Function returns true if user is in workflow for
			defined documnet id, otherwise false
		*/
		function isUserInWorkflow($docID,$table,$userID){
			$doc=weWorkflowUtility::getWorkflowDocument($docID,$table);
			if(isset($doc->ID)){
				$i=$doc->findLastActiveStep();
				if($i<0) return false;
				$j=$doc->steps[$i]->findTaskByUser($userID);
				if($j>-1){
					if($doc->steps[$i]->tasks[$j]->Status==WORKFLOWDOC_TASK_STATUS_UNKNOWN) return true;
					else return false;
				}
				else return false;
			}
			return false;

		}

		/*
			Function returns true if user can edit
			defined documnet, otherwise false
		*/
		function canUserEditDoc($docID,$table,$userID){
			if($_SESSION["perms"]["ADMINISTRATOR"]) return true;
			$doc=weWorkflowUtility::getWorkflowDocument($docID,$table);
			if(isset($doc->ID)){
				$i=$doc->findLastActiveStep();
				if($i<0) return false;
				$wStep=new weWorkflowStep($doc->steps[$i]->workflowStepID);
				foreach($wStep->tasks as $k=>$v){
					if($v->userID==$userID && $v->Edit) return true;
				}

			}
			return false;
		}
		
		function getWorkflowDocsForUser($userID,$table,$isAdmin=false,$permPublish=false,$ws=""){
			
			if($isAdmin){
				return weWorkflowUtility::getAllWorkflowDocs($table);
			}else if($permPublish){
				$ids = weWorkflowUtility::getWorkflowDocsFromWorkspace($table,$ws);
			}else{
				$ids=array();
			}

			$wids = weWorkflowUtility::getAllWorkflowDocs($table);

			foreach($wids as $id){
				if(!in_array($id,$ids)){
					if(weWorkflowUtility::isUserInWorkflow($id,$table,$userID)){
						array_push($ids,$id);
					}
				}
			}

			return $ids;
		}

		function getAllWorkflowDocs($table){

			$type=weWorkflowUtility::getTypeForTable($table);
			$db=new DB_WE();
			$ids=array();
			$db->query("SELECT DISTINCT ".WORKFLOW_DOC_TABLE.".documentID as ID FROM ".WORKFLOW_DOC_TABLE.",".WORKFLOW_TABLE." WHERE ".WORKFLOW_DOC_TABLE.".workflowID=".WORKFLOW_TABLE.".ID AND ".WORKFLOW_DOC_TABLE.".Status = ".WORKFLOWDOC_STATUS_UNKNOWN." AND ".WORKFLOW_TABLE.".Type IN(".$type.")");
			while($db->next_record()){
				if(!in_array($db->f("ID"),$ids)){
					array_push($ids,$db->f("ID"));
				}
			}
			return $ids;
		}

		function getWorkflowDocsFromWorkspace($table,$ws){
			
			$wids = weWorkflowUtility::getAllWorkflowDocs($table);
			$ids=array();

			foreach($wids as $id){
				if(!in_array($id,$ids)){
					if(is_array($ws) && sizeof($ws)){
						if(in_workspace($id,$ws,$table,$db)){
							array_push($ids,$id);
						}
					}else{
						array_push($ids,$id);
					}
				}
			}

			return $ids;
		}

		function findLastActiveStep($docID,$table){
			$doc=weWorkflowUtility::getWorkflowDocument($docID,$table);
			if(!isset($doc->ID)) return false;
			return $doc->findLastActiveStep();
		}

		function getNumberOfSteps($docID,$table){
			$doc=weWorkflowUtility::getWorkflowDocument($docID,$table);
			if(!isset($doc->ID)) return false;
			return $doc->steps;
		}


		function getDocumentStatusInfo($docID,$table){
			$doc=weWorkflowUtility::getWorkflowDocumentID($docID,$table);
			if($doc){
				include_once(WE_WORKFLOW_MODULE_DIR."weWorkflowView.php");
				return weWorkflowView::getDocumentStatus($doc,700);
			}
		}

		/*
			Cronjob function
		*/
		function forceOverdueDocuments($userID=0){		
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".WE_LANGUAGE."/modules/workflow.inc.php");         
         		               
			$db=new DB_WE();         
			$ret="";
			$db->query("SELECT ".WORKFLOW_DOC_TABLE.".ID AS docID,".WORKFLOW_DOC_STEP_TABLE.".ID AS docstepID,".WORKFLOW_STEP_TABLE.".ID AS stepID FROM ".WORKFLOW_DOC_TABLE.",".WORKFLOW_DOC_STEP_TABLE.",".WORKFLOW_STEP_TABLE." WHERE ".WORKFLOW_DOC_TABLE.".ID=".WORKFLOW_DOC_STEP_TABLE.".workflowDocID AND ".WORKFLOW_DOC_STEP_TABLE.".workflowStepID=".WORKFLOW_STEP_TABLE.".ID AND ".WORKFLOW_DOC_STEP_TABLE.".startDate<>0 AND (".WORKFLOW_DOC_STEP_TABLE.".startDate+(".WORKFLOW_STEP_TABLE.".Worktime*3600))<".time()." AND ".WORKFLOW_DOC_STEP_TABLE.".finishDate=0 AND ".WORKFLOW_DOC_STEP_TABLE.".Status=".WORKFLOWDOC_STEP_STATUS_UNKNOWN." AND ".WORKFLOW_DOC_TABLE.".Status=".WORKFLOWDOC_STATUS_UNKNOWN);
			while($db->next_record()){            
				@set_time_limit(50);
				$workflowDocument=new weWorkflowDocument($db->f("docID"));
				$userID = $userID ? $userID : $workflowDocument->userID;            
				$_SESSION["user"]["ID"]=$userID;				
				if(!weWorkflowUtility::isWorkflowFinished($workflowDocument->document->ID,$workflowDocument->document->Table)){					
					$next=false;
					$workflowStep=new weWorkflowStep($db->f("stepID"));
					$next=$workflowStep->timeAction==1 ? true : false;
					if($next){
						if($workflowDocument->findLastActiveStep()>=count($workflowDocument->steps)-1){
                     		$workflowDocument->decline($userID,$GLOBALS["l_workflow"]["auto_declined"],true);
                     		$ret.="(ID: ".$workflowDocument->ID.") ".$GLOBALS["l_workflow"]["auto_declined"]."\n";
                  		}                     
                  		else{
                     		$workflowDocument->approve($userID,$GLOBALS["l_workflow"]["auto_approved"],true);
                     		$ret.="(ID: ".$workflowDocument->ID.") ".$GLOBALS["l_workflow"]["auto_approved"]."\n";
                  		}                     
               		}               
					$workflowDocument->save();
				}
			}
         	return $ret;
		}
		
		function getLogButton($docID,$table){
			$we_button = new we_button();
			$type=weWorkflowUtility::getTypeForTable($table);
			return $we_button->create_button("logbook", "javascript:new jsWindow('" . WE_WORKFLOW_MODULE_PATH . "edit_workflow_frameset.php?pnt=log&art=".$docID."&type=".$type."','workflow_history',-1,-1,640,480,true,false,true);");
		}


	}

?>