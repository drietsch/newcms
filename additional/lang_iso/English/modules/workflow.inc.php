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
 * @package    webEdition_language
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


/**
 * Language file: workflow.inc.php
 * Provides language strings.
 * Language: English
 */

$l_workflow["new_workflow"] = "New workflow";
$l_workflow["workflow"] = "Workflow";

$l_workflow["doc_in_wf_warning"] = "The document is in workflow!";
$l_workflow["message"] = "Message";
$l_workflow["in_workflow"] = "Document in workflow";
$l_workflow["decline_workflow"] = "Decline document";
$l_workflow["pass_workflow"] = "Forward document";

$l_workflow[FILE_TABLE]["in_workflow_ok"] = "The document was successfully placed in the workflow!";
$l_workflow[FILE_TABLE]["in_workflow_notok"] = "The document cannot be placed in the workflow!";
if(defined("OBJECT_FILES_TABLE")){
	$l_workflow[OBJECT_FILES_TABLE]["in_workflow_ok"] = "The object was successfully placed in the workflow!";
	$l_workflow[OBJECT_FILES_TABLE]["in_workflow_notok"] = "The object cannot be placed in the workflow!";
	$l_workflow[OBJECT_FILES_TABLE]["pass_workflow_ok"] = "The object was successfully passed on!";
	$l_workflow[OBJECT_FILES_TABLE]["pass_workflow_notok"] = "The object cannot be passed on!";
	$l_workflow[OBJECT_FILES_TABLE]["decline_workflow_ok"] = "The object was returned to the author!";
	$l_workflow[OBJECT_FILES_TABLE]["decline_workflow_notok"] = "The object cannot be returned to the author!";
}
$l_workflow[FILE_TABLE]["pass_workflow_ok"] = "The document was successfully passed on!";
$l_workflow[FILE_TABLE]["pass_workflow_notok"] = "The document cannot be passed on!";

$l_workflow[FILE_TABLE]["decline_workflow_ok"] = "The document was returned to the author!";
$l_workflow[FILE_TABLE]["decline_workflow_notok"] = "The document cannot be returned to the author!";

$l_workflow["no_wf_defined"] = "No workflow has been defined for this document!";

$l_workflow["document"] = "Document";

$l_workflow["del_last_step"] = "Cannot delete last serial step!";
$l_workflow["del_last_task"] = "Cannot delete last parallel step!";
$l_workflow["save_ok"] = "Workflow is saved.";
$l_workflow["delete_ok"] = "Workflow is deleted.";
$l_workflow["delete_nok"] = "Delete failed!";

$l_workflow["name"] = "Name";
$l_workflow["type"] = "Type";
$l_workflow["type_dir"] = "Directory-based";
$l_workflow["type_doctype"] = "Document type/Category-based";
$l_workflow["type_object"] = "Object-based";

$l_workflow["dirs"] = "Directories";
$l_workflow["doctype"] = "Document type";
$l_workflow["categories"] = "Categories";
$l_workflow["classes"] = "Classes";

$l_workflow["active"] = "Workflow is active.";

$l_workflow["step"] = "Step";
$l_workflow["and_or"] = "AND&nbsp;/&nbsp;OR";
$l_workflow["worktime"] = "Worktime (H)";
$l_workflow["user"] = "User";

$l_workflow["edit"] = "Edit";
$l_workflow["send_mail"] = "Send mail";
$l_workflow["select_user"] = "Select user";

$l_workflow["and"] = " and ";
$l_workflow["or"] = " or ";

$l_workflow["waiting_on_approval"] = "Waiting for approval from %s.";
$l_workflow["status"] = "Status";
$l_workflow["step_from"] = "Step %s from %s";

$l_workflow["step_time"] = "Step time";
$l_workflow["step_start"] = "Step start date";
$l_workflow["step_plan"] = "End date";
$l_workflow["step_worktime"] = "Planed worktime";

$l_workflow["current_time"] = "Current time";
$l_workflow["time_elapsed"] = "Time elapsed";
$l_workflow["time_remained"] = "Time remaining";

$l_workflow["todo_subject"] = "Workflow task";
$l_workflow["todo_next"] = "There is a document waiting for you in the workflow.";

$l_workflow["go_next"] = "Next step";

$l_workflow["new_step"] = "Create additional serial step.";
$l_workflow["new_task"] = "Create additional parallel step.";

$l_workflow["delete_step"] = "Delete serial step.";
$l_workflow["delete_task"] = "Delete parallel step.";

$l_workflow["save_question"] = "All documents that are in the workflow will be removed from it.\\nAre you sure that you want to do this?";
$l_workflow["nothing_to_save"] = "Nothing to save!";
$l_workflow["save_changed_workflow"] = "Workflow has been changed.\\nDo you want to save your changes?";

$l_workflow["delete_question"] = "All workflow data will be deleated!\\nAre you sure that you want to do this?";
$l_workflow["nothing_to_delete"] = "Nothing to delete!";

$l_workflow["user_empty"] = "No defined users for step %s.";
$l_workflow["folders_empty"] = "Folder is not defined for workflow!";
$l_workflow["objects_empty"] = "Object is not defined for workflow!";
$l_workflow["doctype_empty"] = "Document type or category are not defined for workflow";
$l_workflow["worktime_empty"] = "Worktime is not defined for step %s!";
$l_workflow["name_empty"] = "Name is not defined for workflow!";
$l_workflow["cannot_find_active_step"] = "Cannot find active step!";

$l_workflow["no_perms"] = "No permissions!";
$l_workflow["plan"] = "(plan)";

$l_workflow["todo_returned"] = "The document has been returned from the workflow.";

$l_workflow["description"] = "Description";
$l_workflow["time"] = "Time";

$l_workflow["log_approve_force"] = "User has forcibly approved document.";
$l_workflow["log_approve"] = "User has approved document.";
$l_workflow["log_decline_force"] = "User has forcibly cancelled document workflow.";
$l_workflow["log_decline"] = "User has cancelled document workflow.";
$l_workflow["log_doc_finished_force"] = "Workflow has been forcibly finished.";
$l_workflow["log_doc_finished"] = "Workflow is finished.";
$l_workflow["log_insert_doc"] = "Document has been inserted into wokflow.";

$l_workflow["logbook"] = "Logbook";
$l_workflow["empty_log"] = "Empty logbook";
$l_workflow["emty_log_question"] = "Do you really want to empty the logbook?";
$l_workflow["empty_log_ok"] = "The logbook is now emtpy.";
$l_workflow["log_is_empty"] = "The logbook is emtpy.";

$l_workflow["log_question_all"] = "Clear all";
$l_workflow["log_question_time"] = "Clear older than";
$l_workflow["log_question_text"] = "Choose option:";

$l_workflow["log_remove_doc"] = "Document is removed from workflow.";
$l_workflow["action"] = "Action";

$l_workflow[FILE_TABLE]["messagePath"] = "Document";
if(defined("OBJECT_FILES_TABLE")){
	$l_workflow[OBJECT_FILES_TABLE]["messagePath"] = "Object";
}
$l_workflow["auto_approved"] = "Document has been automatically approved.";
$l_workflow["auto_declined"] = "Document has been automatically declined.";

$l_workflow["doc_deleted"] = "Document has been deleted!";
$l_workflow["ask_before_recover"] = "There are still documents/objects in the workflow process! Do you want to remove them from the workflow process?";

$l_workflow["double_name"] = "Workflow name already exists!";

$l_workflow["more_information"] = "More information";
$l_workflow["less_information"] = "Less information";

$l_workflow["no_wf_defined_object"] = "No workflow has been defined for this object!";
?>