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
$l_workflow["message"] = "Message"; // TRANSLATE
$l_workflow["in_workflow"] = "Document dans le Gestion de Flux";
$l_workflow["decline_workflow"] = "Repousser le document";
$l_workflow["pass_workflow"] = "Transmettre le document";

$l_workflow[FILE_TABLE]["in_workflow_ok"] = "Le document a �t� plac� dans le Gestion de Flux avec succ�s!";
$l_workflow[FILE_TABLE]["in_workflow_notok"] = "Le document n'a pas pu �tre plac� dans le Gestion de Flux!";
if(defined("OBJECT_FILES_TABLE")){
	$l_workflow[OBJECT_FILES_TABLE]["in_workflow_ok"] = "L'object a �t� plac� dans le Gestion de Flux avec succ�s!";
	$l_workflow[OBJECT_FILES_TABLE]["in_workflow_notok"] = "L'object n'a pas pu �tre plac� dans le Gestion de Flux!";
	$l_workflow[OBJECT_FILES_TABLE]["pass_workflow_ok"] = "L'object a �t� transmis avec succ�s!";
	$l_workflow[OBJECT_FILES_TABLE]["pass_workflow_notok"] = "L'object n'a pas pu �tre transmis!";
	$l_workflow[OBJECT_FILES_TABLE]["decline_workflow_ok"] = "L'object a �t� repouss� � l'auteur!";
	$l_workflow[OBJECT_FILES_TABLE]["decline_workflow_notok"] = "L'object n'a pas pu �tre repouss� � l'auteur!";
}
$l_workflow[FILE_TABLE]["pass_workflow_ok"] = "Le document a �t� transmis avec succ�s!";
$l_workflow[FILE_TABLE]["pass_workflow_notok"] = "Le document n'a pas pu �tre transmis!";

$l_workflow[FILE_TABLE]["decline_workflow_ok"] = "Le document a �t� repouss� � l'auteur!";
$l_workflow[FILE_TABLE]["decline_workflow_notok"] = "Le docuemtn n'a pas pu �tre repouss� � l'auteur!";

$l_workflow["no_wf_defined"] = "Aucun Gestion de Flux a �t� d�fini pour ce document!";

$l_workflow["document"] = "Document"; // TRANSLATE

$l_workflow["del_last_step"] = "La derni�re �tape s�rielle ne peut pas �tre supprim�e!";
$l_workflow["del_last_task"] = "La derni�re �tape parall�le ne peut pas �tre supprim�e!";
$l_workflow["save_ok"] = "Le Gestion de Flux a �t� enregistr� avec succ�s!";
$l_workflow["delete_ok"] = "Le Gestion de Flux a �t� supprim� avec succ�s!";
$l_workflow["delete_nok"] = "Le Gestion de Flux n'a pas pu �tre supprim�!";

$l_workflow["name"] = "Nom";
$l_workflow["type"] = "Type"; // TRANSLATE
$l_workflow["type_dir"] = "� la base de R�pertoires";
$l_workflow["type_doctype"] = "� la base de Types-de-Document/Categories";
$l_workflow["type_object"] = "� la base d'Objects";

$l_workflow["dirs"] = "R�pertoires";
$l_workflow["doctype"] = "Type-de-Document";
$l_workflow["categories"] = "Categories"; // TRANSLATE
$l_workflow["classes"] = "Classes"; // TRANSLATE

$l_workflow["active"] = "Gestion de Flux est active";

$l_workflow["step"] = "�tape";
$l_workflow["and_or"] = "ET&nbsp;/&nbsp;OU";
$l_workflow["worktime"] = "Temps de travail (hr.)";
$l_workflow["user"] = "Utilisateur ";

$l_workflow["edit"] = "�diter";
$l_workflow["send_mail"] = "Envoyer un E-Mail";
$l_workflow["select_user"] = "Select user"; // TRANSLATE

$l_workflow["and"] = " and "; // TRANSLATE
$l_workflow["or"] = " or "; // TRANSLATE

$l_workflow["waiting_on_approval"] = "En attente de l'autorisation de %s";
$l_workflow["status"] = "�tat";
$l_workflow["step_from"] = "�tape %s de %s";

$l_workflow["step_time"] = "Step time"; // TRANSLATE
$l_workflow["step_start"] = "Temps de d�marrage";
$l_workflow["step_plan"] = "P�rim� le";
$l_workflow["step_worktime"] = "Temps pr�vu";

$l_workflow["current_time"] = "Temps actuel";
$l_workflow["time_elapsed"] = "Temps �coul� (h:m:s)";
$l_workflow["time_remained"] = "Temps restant (h:m:s)";

$l_workflow["todo_subject"] = "Tache de Gestion de Flux";
$l_workflow["todo_next"] = "La prochaine d'�tape de Gestion.";

$l_workflow["go_next"] = "Next step"; // TRANSLATE

$l_workflow["new_step"] = "Create additional serial step."; // TRANSLATE
$l_workflow["new_task"] = "Create additional parallel step."; // TRANSLATE

$l_workflow["delete_step"] = "Delete serial step."; // TRANSLATE
$l_workflow["delete_task"] = "Delete parallel step."; // TRANSLATE

$l_workflow["save_question"] = "All documents that are in the workflow will be removed from it.\\nAre you sure that you want to do this?"; // TRANSLATE
$l_workflow["nothing_to_save"] = "Nothing to save!"; // TRANSLATE
$l_workflow["save_changed_workflow"] = "Workflow has been changed.\\nDo you want to save your changes?"; // TRANSLATE

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

$l_workflow["todo_returned"] = "Un document a �t� rejet�.";

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
$l_workflow["emty_log_question"] = "��tes-vous s�r de vider le jornal compl�ment?";
$l_workflow["empty_log_ok"] = "The logbook is now emtpy."; // TRANSLATE
$l_workflow["log_is_empty"] = "The logbook is emtpy."; // TRANSLATE

$l_workflow["log_question_all"] = "Clear all"; // TRANSLATE
$l_workflow["log_question_time"] = "Clear older than"; // TRANSLATE
$l_workflow["log_question_text"] = "Choose option:"; // TRANSLATE

$l_workflow["log_remove_doc"] = "Document is removed from workflow."; // TRANSLATE
$l_workflow["action"] = "Action"; // TRANSLATE

$l_workflow[FILE_TABLE]["messagePath"] = "Document"; // TRANSLATE
if(defined("OBJECT_FILES_TABLE")){
	$l_workflow[OBJECT_FILES_TABLE]["messagePath"] = "Object"; // TRANSLATE
}
$l_workflow["auto_approved"] = "Document has been automatically approved."; // TRANSLATE
$l_workflow["auto_declined"] = "Document has been automatically declined."; // TRANSLATE

$l_workflow["doc_deleted"] = "Document has been deleted!"; // TRANSLATE
$l_workflow["ask_before_recover"] = "There are still documents/objects in the workflow process! Do you want to remove them from the workflow process?"; // TRANSLATE

$l_workflow["double_name"] = "Workflow name already exists!"; // TRANSLATE

$l_workflow["more_information"] = "Informations suppl�mentaire";
$l_workflow["less_information"] = "Moins Informations";

$l_workflow["no_wf_defined_object"] = "Aucun Gestion de Flux a �t� d�fini pour cet object!";
?>