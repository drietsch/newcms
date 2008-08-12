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
$l_workflow["message"] = "Wiadomo¶æ";
$l_workflow["in_workflow"] = "Dokument w opracowaniu";
$l_workflow["decline_workflow"] = "Odrzuæ dokument";
$l_workflow["pass_workflow"] = "Przeka¿ dokument dalej";

$l_workflow[FILE_TABLE]["in_workflow_ok"] = "Dokument zosta³ pomy¶lnie przekazany do opracowania!";
$l_workflow[FILE_TABLE]["in_workflow_notok"] = "Nie mo¿na by³o przekazaæ dokumentu do opracowania!";
if(defined("OBJECT_FILES_TABLE")){
	$l_workflow[OBJECT_FILES_TABLE]["in_workflow_ok"] = "Obiekt zosta³ pomy¶lnie przekazany do opracowania!";
	$l_workflow[OBJECT_FILES_TABLE]["in_workflow_notok"] = "Nie mo¿na by³o przekazaæ obiektu do opracowania!";
	$l_workflow[OBJECT_FILES_TABLE]["pass_workflow_ok"] = "Obiekt zosta³ pomy¶lnie przekazany dalej!";
	$l_workflow[OBJECT_FILES_TABLE]["pass_workflow_notok"] = "Nie mo¿na by³o przekazaæ dalej obiektu!";
	$l_workflow[OBJECT_FILES_TABLE]["decline_workflow_ok"] = "Obiekt zosta³ zwrócony autorowi!";
	$l_workflow[OBJECT_FILES_TABLE]["decline_workflow_notok"] = "Nie mo¿na by³o zwróciæ obiektu autorowi!";
}
$l_workflow[FILE_TABLE]["pass_workflow_ok"] = "Dokument zosta³ pomy¶lnie przekazany dalej!";
$l_workflow[FILE_TABLE]["pass_workflow_notok"] = "Nie mo¿na by³o przekazaæ dalej dokumentu!";

$l_workflow[FILE_TABLE]["decline_workflow_ok"] = "Dokument zosta³ pomy¶lnie przekazany autorowi!";
$l_workflow[FILE_TABLE]["decline_workflow_notok"] = "Nie mo¿na by³o zwróciæ dokumentu autorowi!";

$l_workflow["no_wf_defined"] = "Dla tego dokumentu nie zdefiniowano operacji!";

$l_workflow["document"] = "Document"; // TRANSLATE

$l_workflow["del_last_step"] = "Nie mo¿na by³o usun±æ ostatniego poziomu szeregowego!";
$l_workflow["del_last_task"] = "Nie mo¿na by³o usun±æ ostatniego poziomu równoleg³ego!";
$l_workflow["save_ok"] = "Nie mo¿na by³o zapisaæ pomy¶lnie operacji!";
$l_workflow["delete_ok"] = "Operacja zosta³a zapisana pomy¶lnie!";
$l_workflow["delete_nok"] = "Nie mo¿na by³o usun±æ operacji!";

$l_workflow["name"] = "Nazwa";
$l_workflow["type"] = "Typ";
$l_workflow["type_dir"] = "Skatalogowany";
$l_workflow["type_doctype"] = "DocumentType/skategoryzowany";
$l_workflow["type_object"] = "Zobiektyzowany";

$l_workflow["dirs"] = "Katalogi";
$l_workflow["doctype"] = "Typ dokumentu";
$l_workflow["categories"] = "Kategorie";
$l_workflow["classes"] = "Klasy";

$l_workflow["active"] = "Workflow jest aktywny";

$l_workflow["step"] = "Poziom";
$l_workflow["and_or"] = "I&nbsp;/&nbsp;LUB";
$l_workflow["worktime"] = "Czas pracy (godz.)";
$l_workflow["user"] = "Nazwa u¿ytkownika ";

$l_workflow["edit"] = "Edytuj";
$l_workflow["send_mail"] = "Wy¶lij email";
$l_workflow["select_user"] = "Select user"; // TRANSLATE

$l_workflow["and"] = " and "; // TRANSLATE
$l_workflow["or"] = " or "; // TRANSLATE

$l_workflow["waiting_on_approval"] = "Czekam na zezwolenie z  %s";
$l_workflow["status"] = "Status"; // TRANSLATE
$l_workflow["step_from"] = "Poziom %s z %s";

$l_workflow["step_time"] = "Step time"; // TRANSLATE
$l_workflow["step_start"] = "Godzina startu";
$l_workflow["step_plan"] = "Up³ynê³o w dniu";
$l_workflow["step_worktime"] = "Planowany czas";

$l_workflow["current_time"] = "Aktualny czas";
$l_workflow["time_elapsed"] = "Czas zu¿yty (h:m:s)";
$l_workflow["time_remained"] = "Czas pozosta³y (h:m:s)";

$l_workflow["todo_subject"] = "Zadanie operacji";
$l_workflow["todo_next"] = "Nastêpny poziom operacji.";

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

$l_workflow["todo_returned"] = "Jeden dokument zosta³ odrzucony.";

$l_workflow["description"] = "Description"; // TRANSLATE
$l_workflow["time"] = "Time"; // TRANSLATE

$l_workflow["log_approve_force"] = "User has forcibly approved document."; // TRANSLATE
$l_workflow["log_approve"] = "User has approved document."; // TRANSLATE
$l_workflow["log_decline_force"] = "User has forcibly cancelled document workflow."; // TRANSLATE
$l_workflow["log_decline"] = "User has cancelled document workflow."; // TRANSLATE
$l_workflow["log_doc_finished_force"] = "Workflow has been forcibly finished."; // TRANSLATE
$l_workflow["log_doc_finished"] = "Workflow is finished."; // TRANSLATE
$l_workflow["log_insert_doc"] = "Document has been inserted into wokflow."; // TRANSLATE

$l_workflow["logbook"] = "Logbook"; // TRANSLATE
$l_workflow["empty_log"] = "Empty logbook"; // TRANSLATE
$l_workflow["emty_log_question"] = "Czy rzeczywi¶cie chcesz wyczy¶ciæ ca³± ksi±¿kê logów?";
$l_workflow["empty_log_ok"] = "The logbook is now emtpy."; // TRANSLATE
$l_workflow["log_is_empty"] = "The logbook is emtpy."; // TRANSLATE

$l_workflow["log_question_all"] = "Clear all"; // TRANSLATE
$l_workflow["log_question_time"] = "Clear older than"; // TRANSLATE
$l_workflow["log_question_text"] = "Choose option:"; // TRANSLATE

$l_workflow["log_remove_doc"] = "Document is removed from workflow."; // TRANSLATE
$l_workflow["action"] = "Action"; // TRANSLATE

$l_workflow[FILE_TABLE]["messagePath"] = "Dokument";
if(defined("OBJECT_FILES_TABLE")){
	$l_workflow[OBJECT_FILES_TABLE]["messagePath"] = "Obiekt";
}
$l_workflow["auto_approved"] = "Document has been automatically approved."; // TRANSLATE
$l_workflow["auto_declined"] = "Document has been automatically declined."; // TRANSLATE

$l_workflow["doc_deleted"] = "Document has been deleted!"; // TRANSLATE
$l_workflow["ask_before_recover"] = "There are still documents/objects in the workflow process! Do you want to remove them from the workflow process?"; // TRANSLATE

$l_workflow["double_name"] = "Workflow name already exists!"; // TRANSLATE

$l_workflow["more_information"] = "Pozosta³e informacje";
$l_workflow["less_information"] = "Mniej informacji";

$l_workflow["no_wf_defined_object"] = "Dla tego obiektu nie zosta³ zdefiniowany ¿aden workflow!";
?>