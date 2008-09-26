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


define("LOG_TYPE_APPROVE","1");
define("LOG_TYPE_APPROVE_FORCE","2");
define("LOG_TYPE_DECLINE","3");
define("LOG_TYPE_DECLINE_FORCE","4");
define("LOG_TYPE_DOC_FINISHED","5");
define("LOG_TYPE_DOC_FINISHED_FORCE","6");
define("LOG_TYPE_DOC_INSERTED","7");
define("LOG_TYPE_DOC_REMOVED","8");
define("NUMBER_LOGS","8");

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");

class weWorkflowLog{


	function logDocumentEvent($workflowDocID,$userID,$type,$description){
		$db = new DB_WE();
		$db->query("INSERT INTO ".WORKFLOW_LOG_TABLE." (ID, RefID, docTable, userID, logDate, Type, Description) VALUES ('', '".$workflowDocID."', '".WORKFLOW_TABLE."', '".$userID."', '".time()."', '".$type."', '".addslashes($description)."');");
	}

	function logWorkflowEvent($workflowID,$userID,$type,$description){
		$db = new DB_WE();
		$db->query("INSERT INTO ".WORKFLOW_LOG_TABLE." (ID, RefID, docTable, userID, logDate, Type, Description) VALUES ('', '".$workflowDocID."', '".WORKFLOW_TABLE."', '".$userID."', '".time()."', '".$type."', '".addslashes($description)."');");
	}

	function getLogForDocument($docID,$order="DESC",$wfType=0){
		global $l_workflow;

		$offset = isset($_REQUEST["offset"]) ? $_REQUEST["offset"] : 0;

		$q = "SELECT ".WORKFLOW_LOG_TABLE.".* FROM ".WORKFLOW_LOG_TABLE.",".WORKFLOW_DOC_TABLE.",".WORKFLOW_TABLE." WHERE ".WORKFLOW_DOC_TABLE.".workflowID=".WORKFLOW_TABLE.".ID AND ".WORKFLOW_TABLE.".Type IN(".$wfType.") AND ".WORKFLOW_LOG_TABLE.".RefID=".WORKFLOW_DOC_TABLE.".ID AND  ".WORKFLOW_DOC_TABLE.".documentID='".$docID."' ORDER BY ".WORKFLOW_LOG_TABLE.".logDate ".$order.",ID DESC";


		$db = new DB_WE();
		$db->query($q);

		$GLOBALS["ANZ_LOGS"] = $db->num_rows();

		$q .= " LIMIT $offset,".NUMBER_LOGS;
		$db->query($q);

		$hash=array();
		while($db->next_record()) $hash[]=$db->Record;
		foreach($hash as $k=>$v){
			switch($hash[$k]["Type"]){
				case LOG_TYPE_APPROVE: $hash[$k]["Type"]=$l_workflow["log_approve"];
				break;
				case LOG_TYPE_APPROVE_FORCE: $hash[$k]["Type"]=$l_workflow["log_approve_force"];
				break;
				case LOG_TYPE_DECLINE: $hash[$k]["Type"]=$l_workflow["log_decline"];
				break;
				case LOG_TYPE_DECLINE_FORCE: $hash[$k]["Type"]=$l_workflow["log_decline_force"];
				break;
				case LOG_TYPE_DOC_FINISHED: $hash[$k]["Type"]=$l_workflow["log_doc_finished"];
				break;
				case LOG_TYPE_DOC_FINISHED_FORCE: $hash[$k]["Type"]=$l_workflow["log_doc_finished_force"];
				break;
				case LOG_TYPE_DOC_INSERTED: $hash[$k]["Type"]=$l_workflow["log_insert_doc"];
				break;
				case LOG_TYPE_DOC_REMOVED: $hash[$k]["Type"]=$l_workflow["log_remove_doc"];
				break;
			}
		}
		return $hash;
	}

	function getLogForUser($userID){
		$db = new DB_WE();
		$db->query("SELECT * FROM ".WORKFLOW_LOG_TABLE." WHERE userID='".$userID."'");
		return $db->Record;
	}

	function clearLog($stamp=0){
		$db = new DB_WE();
		$db->query("DELETE FROM ".WORKFLOW_LOG_TABLE." ".($stamp ? "WHERE logDate<".$stamp : "").";");
	}
}

?>