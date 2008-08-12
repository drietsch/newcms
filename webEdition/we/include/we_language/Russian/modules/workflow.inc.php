<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


/**
 * Language file: workflow.inc.php
 * Provides language strings.
 * Language: English
 */

$l_workflow["new_workflow"] = "New workflow"; // TRANSLATE
$l_workflow["workflow"] = "Workflow"; // TRANSLATE

$l_workflow["doc_in_wf_warning"] = "The document is in workflow!"; // TRANSLATE
$l_workflow["message"] = "���������";
$l_workflow["in_workflow"] = "�������� � ������";
$l_workflow["decline_workflow"] = "��������� ��������";
$l_workflow["pass_workflow"] = "�������� �������������";

$l_workflow[FILE_TABLE]["in_workflow_ok"] = "�������� ������� ������� � �����!";
$l_workflow[FILE_TABLE]["in_workflow_notok"] = "���������� �������� �������� � �����!";
if(defined("OBJECT_FILES_TABLE")){
	$l_workflow[OBJECT_FILES_TABLE]["in_workflow_ok"] = "������ ������� ������� � �����!";
	$l_workflow[OBJECT_FILES_TABLE]["in_workflow_notok"] = "���������� �������� ������ � �����!";
	$l_workflow[OBJECT_FILES_TABLE]["pass_workflow_ok"] = "������ ������� �������������!";
	$l_workflow[OBJECT_FILES_TABLE]["pass_workflow_notok"] = "���������� ������������� ������!";
	$l_workflow[OBJECT_FILES_TABLE]["decline_workflow_ok"] = "������ ��������� ������!";
	$l_workflow[OBJECT_FILES_TABLE]["decline_workflow_notok"] = "���������� ���������� ������ ��� ������!";
}
$l_workflow[FILE_TABLE]["pass_workflow_ok"] = "�������� ������� �������������!";
$l_workflow[FILE_TABLE]["pass_workflow_notok"] = "���������� ������������� ��������!";

$l_workflow[FILE_TABLE]["decline_workflow_ok"] = "�������� ��������� ������!";
$l_workflow[FILE_TABLE]["decline_workflow_notok"] = "���������� ���������� �������� ��� ������!";

$l_workflow["no_wf_defined"] = "��� ������� ��������� �� ����� �����!";

$l_workflow["document"] = "Document"; // TRANSLATE

$l_workflow["del_last_step"] = "������ ������� �������������� ���������������� �������!";
$l_workflow["del_last_task"] = "������ ������� �������������� ������������ �������!";
$l_workflow["save_ok"] = "����� ��������";
$l_workflow["delete_ok"] = "����� ������";
$l_workflow["delete_nok"] = "����� ���������� �������";

$l_workflow["name"] = "���";
$l_workflow["type"] = "���";
$l_workflow["type_dir"] = "�� ���� ����������";
$l_workflow["type_doctype"] = "�� ���� ���� ���������/���������";
$l_workflow["type_object"] = "�� ���� �������";

$l_workflow["dirs"] = "����������";
$l_workflow["doctype"] = "��� ���������";
$l_workflow["categories"] = "���������";
$l_workflow["classes"] = "������";

$l_workflow["active"] = "����� �����������";

$l_workflow["step"] = "�������";
$l_workflow["and_or"] = "�&nbsp;/&nbsp;���";
$l_workflow["worktime"] = "���� ������";
$l_workflow["user"] = "������������";

$l_workflow["edit"] = "�������������";
$l_workflow["send_mail"] = "��������� ������";
$l_workflow["select_user"] = "Select user"; // TRANSLATE

$l_workflow["and"] = " and "; // TRANSLATE
$l_workflow["or"] = " or "; // TRANSLATE

$l_workflow["waiting_on_approval"] = "�������� ��������� %s";
$l_workflow["status"] = "������";
$l_workflow["step_from"] = "������� %s �� %s";

$l_workflow["step_time"] = "Step time"; // TRANSLATE
$l_workflow["step_start"] = "���� ������";
$l_workflow["step_plan"] = "���� ����������";
$l_workflow["step_worktime"] = "��������������� ����� ���������";

$l_workflow["current_time"] = "������� �����";
$l_workflow["time_elapsed"] = "�������������� �����";
$l_workflow["time_remained"] = "���������� �����";

$l_workflow["todo_subject"] = "������� ��� ������";
$l_workflow["todo_next"] = "�������� ��������� � ������� �� ���������";

$l_workflow["go_next"] = "Next step"; // TRANSLATE

$l_workflow["new_step"] = "Create additional serial step."; // TRANSLATE
$l_workflow["new_task"] = "Create additional parallel step."; // TRANSLATE

$l_workflow["delete_step"] = "Delete serial step."; // TRANSLATE
$l_workflow["delete_task"] = "Delete parallel step."; // TRANSLATE

$l_workflow["save_question"] = "All documents that are in the workflow will be removed from it.\\nAre you sure that you want to do this?"; // TRANSLATE
$l_workflow["nothing_to_save"] = "Nothing to save!"; // TRANSLATE

$l_workflow["delete_question"] = "All workflow data will be deleated!\\nAre you sure that you want to do this?"; // TRANSLATE
$l_workflow["nothing_to_delete"] = "Nothing to delete!"; // TRANSLATE

$l_workflow["user_empty"] = "No defined users for step %s."; // TRANSLATE
$l_workflow["folders_empty"] = "Folder is not defined for workflow!"; // TRANSLATE
$l_workflow["objects_empty"] = "Object is not defined for workflow!"; // TRANSLATE
$l_workflow["doctype_empty"] = "Document type or category are not defined for workflow"; // TRANSLATE
$l_workflow["worktime_empty"] = "Worktime is not defined for step %s!"; // TRANSLATE
$l_workflow["name_empty"] = "Name is not defined for workflow!"; // TRANSLATE
$l_workflow["cannot_find_active_step"] = "Cannot find active step!"; // TRANSLATE

$l_workflow["no_perms"] = "No permissions!"; // TRANSLATE
$l_workflow["plan"] = "(plan)"; // TRANSLATE

$l_workflow["todo_returned"] = "�������� ��������� �� ������";

$l_workflow["description"] = "Description"; // TRANSLATE
$l_workflow["time"] = "Time"; // TRANSLATE

$l_workflow["log_approve_force"] = "User has forcibly approved document."; // TRANSLATE
$l_workflow["log_approve"] = "User has approved document."; // TRANSLATE
$l_workflow["log_decline_force"] = "User has forcibly cancelled document workflow."; // TRANSLATE
$l_workflow["log_decline"] = "User has cancelled document workflow."; // TRANSLATE
$l_workflow["log_doc_finished_force"] = "Workflow has been forcibly finished."; // TRANSLATE
$l_workflow["log_doc_finished"] = "Workflow is finished."; // TRANSLATE
$l_workflow["log_insert_doc"] = "Document has been inserted into wokflow."; // TRANSLATE

$l_workflow["logbook"] = "������ �������";
$l_workflow["empty_log"] = "Empty logbook"; // TRANSLATE
$l_workflow["emty_log_question"] = "Do you really want to empty the logbook?"; // TRANSLATE
$l_workflow["empty_log_ok"] = "The logbook is now emtpy."; // TRANSLATE
$l_workflow["log_is_empty"] = "The logbook is emtpy."; // TRANSLATE

$l_workflow["log_question_all"] = "Clear all"; // TRANSLATE
$l_workflow["log_question_time"] = "Clear older than"; // TRANSLATE
$l_workflow["log_question_text"] = "Choose option:"; // TRANSLATE

$l_workflow["log_remove_doc"] = "Document is removed from workflow."; // TRANSLATE
$l_workflow["action"] = "Action"; // TRANSLATE

$l_workflow[FILE_TABLE]["messagePath"] = "��������";
if(defined("OBJECT_FILES_TABLE")){
	$l_workflow[OBJECT_FILES_TABLE]["messagePath"] = "������";
}
$l_workflow["auto_approved"] = "Document has been automatically approved."; // TRANSLATE
$l_workflow["auto_declined"] = "Document has been automatically declined."; // TRANSLATE

$l_workflow["doc_deleted"] = "Document has been deleted!"; // TRANSLATE
$l_workflow["ask_before_recover"] = "There are still documents/objects in the workflow process! Do you want to remove them from the workflow process?"; // TRANSLATE

$l_workflow["double_name"] = "Workflow name already exists!"; // TRANSLATE

$l_workflow["more_information"] = "������ ����������";
$l_workflow["less_information"] = "������ ����������";

$l_workflow["no_wf_defined_object"] = "��� ������� ������� �� ����� ������� �����!";
?>