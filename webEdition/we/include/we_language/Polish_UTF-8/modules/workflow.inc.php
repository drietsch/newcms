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

$l_workflow["new_workflow"] = "New workflow"; // TRANSLATE
$l_workflow["workflow"] = "Workflow"; // TRANSLATE

$l_workflow["doc_in_wf_warning"] = "The document is in workflow!"; // TRANSLATE
$l_workflow["message"] = "Wiadomość";
$l_workflow["in_workflow"] = "Dokument w opracowaniu";
$l_workflow["decline_workflow"] = "Odrzuć dokument";
$l_workflow["pass_workflow"] = "Przekaż dokument dalej";

$l_workflow[FILE_TABLE]["in_workflow_ok"] = "Dokument został pomyślnie przekazany do opracowania!";
$l_workflow[FILE_TABLE]["in_workflow_notok"] = "Nie można było przekazać dokumentu do opracowania!";
if(defined("OBJECT_FILES_TABLE")){
	$l_workflow[OBJECT_FILES_TABLE]["in_workflow_ok"] = "Obiekt został pomyślnie przekazany do opracowania!";
	$l_workflow[OBJECT_FILES_TABLE]["in_workflow_notok"] = "Nie można było przekazać obiektu do opracowania!";
	$l_workflow[OBJECT_FILES_TABLE]["pass_workflow_ok"] = "Obiekt został pomyślnie przekazany dalej!";
	$l_workflow[OBJECT_FILES_TABLE]["pass_workflow_notok"] = "Nie można było przekazać dalej obiektu!";
	$l_workflow[OBJECT_FILES_TABLE]["decline_workflow_ok"] = "Obiekt został zwrócony autorowi!";
	$l_workflow[OBJECT_FILES_TABLE]["decline_workflow_notok"] = "Nie można było zwrócić obiektu autorowi!";
}
$l_workflow[FILE_TABLE]["pass_workflow_ok"] = "Dokument został pomyślnie przekazany dalej!";
$l_workflow[FILE_TABLE]["pass_workflow_notok"] = "Nie można było przekazać dalej dokumentu!";

$l_workflow[FILE_TABLE]["decline_workflow_ok"] = "Dokument został pomyślnie przekazany autorowi!";
$l_workflow[FILE_TABLE]["decline_workflow_notok"] = "Nie można było zwrócić dokumentu autorowi!";

$l_workflow["no_wf_defined"] = "Dla tego dokumentu nie zdefiniowano operacji!";

$l_workflow["document"] = "Document"; // TRANSLATE

$l_workflow["del_last_step"] = "Nie można było usunąć ostatniego poziomu szeregowego!";
$l_workflow["del_last_task"] = "Nie można było usunąć ostatniego poziomu równoległego!";
$l_workflow["save_ok"] = "Nie można było zapisać pomyślnie operacji!";
$l_workflow["delete_ok"] = "Operacja została zapisana pomyślnie!";
$l_workflow["delete_nok"] = "Nie można było usunąć operacji!";

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
$l_workflow["user"] = "Nazwa użytkownika ";

$l_workflow["edit"] = "Edytuj";
$l_workflow["send_mail"] = "Wyślij email";
$l_workflow["select_user"] = "Select user"; // TRANSLATE

$l_workflow["and"] = " and "; // TRANSLATE
$l_workflow["or"] = " or "; // TRANSLATE

$l_workflow["waiting_on_approval"] = "Czekam na zezwolenie z  %s";
$l_workflow["status"] = "Status"; // TRANSLATE
$l_workflow["step_from"] = "Poziom %s z %s";

$l_workflow["step_time"] = "Step time"; // TRANSLATE
$l_workflow["step_start"] = "Godzina startu";
$l_workflow["step_plan"] = "Upłynęło w dniu";
$l_workflow["step_worktime"] = "Planowany czas";

$l_workflow["current_time"] = "Aktualny czas";
$l_workflow["time_elapsed"] = "Czas zużyty (h:m:s)";
$l_workflow["time_remained"] = "Czas pozostały (h:m:s)";

$l_workflow["todo_subject"] = "Zadanie operacji";
$l_workflow["todo_next"] = "Następny poziom operacji.";

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

$l_workflow["todo_returned"] = "Jeden dokument został odrzucony.";

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
$l_workflow["emty_log_question"] = "Czy rzeczywiście chcesz wyczyścić całą książkę logów?";
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

$l_workflow["more_information"] = "Pozostałe informacje";
$l_workflow["less_information"] = "Mniej informacji";

$l_workflow["no_wf_defined_object"] = "Dla tego obiektu nie został zdefiniowany żaden workflow!";
?>