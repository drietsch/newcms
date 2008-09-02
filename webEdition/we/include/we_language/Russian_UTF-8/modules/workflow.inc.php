<?php

/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_language
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


/**
 * Language file: workflow.inc.php
 * Provides language strings.
 * Language: English
 */

$l_workflow["new_workflow"] = "New workflow"; // TRANSLATE
$l_workflow["workflow"] = "Workflow"; // TRANSLATE

$l_workflow["doc_in_wf_warning"] = "The document is in workflow!"; // TRANSLATE
$l_workflow["message"] = "Сообщение";
$l_workflow["in_workflow"] = "Документ в потоке";
$l_workflow["decline_workflow"] = "Отклонить документ";
$l_workflow["pass_workflow"] = "Документ перенаправить";

$l_workflow[FILE_TABLE]["in_workflow_ok"] = "Документ успешно передан в поток!";
$l_workflow[FILE_TABLE]["in_workflow_notok"] = "Невозможно передать документ в поток!";
if(defined("OBJECT_FILES_TABLE")){
	$l_workflow[OBJECT_FILES_TABLE]["in_workflow_ok"] = "Объект успешно передан в поток!";
	$l_workflow[OBJECT_FILES_TABLE]["in_workflow_notok"] = "Невозможно передать объект в поток!";
	$l_workflow[OBJECT_FILES_TABLE]["pass_workflow_ok"] = "Объект успешно перенаправлен!";
	$l_workflow[OBJECT_FILES_TABLE]["pass_workflow_notok"] = "Невозможно перенаправить объект!";
	$l_workflow[OBJECT_FILES_TABLE]["decline_workflow_ok"] = "Объект возвращен автору!";
	$l_workflow[OBJECT_FILES_TABLE]["decline_workflow_notok"] = "Невозможно возвратить объект его автору!";
}
$l_workflow[FILE_TABLE]["pass_workflow_ok"] = "Документ успешно перенаправлен!";
$l_workflow[FILE_TABLE]["pass_workflow_notok"] = "Невозможно перенаправить документ!";

$l_workflow[FILE_TABLE]["decline_workflow_ok"] = "Документ возвращен автору!";
$l_workflow[FILE_TABLE]["decline_workflow_notok"] = "Невозможно возвратить документ его автору!";

$l_workflow["no_wf_defined"] = "Для данного документа не задан поток!";

$l_workflow["document"] = "Document"; // TRANSLATE

$l_workflow["del_last_step"] = "Нельзя удалить заключительный последовательный уровень!";
$l_workflow["del_last_task"] = "Нельзя удалить заключительный параллельный уровень!";
$l_workflow["save_ok"] = "Поток сохранен";
$l_workflow["delete_ok"] = "Поток удален";
$l_workflow["delete_nok"] = "Поток невозможно удалить";

$l_workflow["name"] = "Имя";
$l_workflow["type"] = "Тип";
$l_workflow["type_dir"] = "На базе директории";
$l_workflow["type_doctype"] = "На базе типа документа/категории";
$l_workflow["type_object"] = "На базе объекта";

$l_workflow["dirs"] = "Директории";
$l_workflow["doctype"] = "Тип документа";
$l_workflow["categories"] = "Категории";
$l_workflow["classes"] = "Классы";

$l_workflow["active"] = "Поток активирован";

$l_workflow["step"] = "Уровень";
$l_workflow["and_or"] = "И&nbsp;/&nbsp;ИЛИ";
$l_workflow["worktime"] = "Часы работы";
$l_workflow["user"] = "Пользователь";

$l_workflow["edit"] = "редактировать";
$l_workflow["send_mail"] = "отправить письмо";
$l_workflow["select_user"] = "Select user"; // TRANSLATE

$l_workflow["and"] = " and "; // TRANSLATE
$l_workflow["or"] = " or "; // TRANSLATE

$l_workflow["waiting_on_approval"] = "Ожидание резолюции %s";
$l_workflow["status"] = "Статус";
$l_workflow["step_from"] = "Уровень %s из %s";

$l_workflow["step_time"] = "Step time"; // TRANSLATE
$l_workflow["step_start"] = "Дата начала";
$l_workflow["step_plan"] = "Дата завершения";
$l_workflow["step_worktime"] = "Запланированное время обработки";

$l_workflow["current_time"] = "Текущее время";
$l_workflow["time_elapsed"] = "Использованное время";
$l_workflow["time_remained"] = "Оставшееся время";

$l_workflow["todo_subject"] = "Задание для потока";
$l_workflow["todo_next"] = "Документ следующий в очереди на обработку";

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

$l_workflow["todo_returned"] = "Документ возвращен из потока";

$l_workflow["description"] = "Description"; // TRANSLATE
$l_workflow["time"] = "Time"; // TRANSLATE

$l_workflow["log_approve_force"] = "User has forcibly approved document."; // TRANSLATE
$l_workflow["log_approve"] = "User has approved document."; // TRANSLATE
$l_workflow["log_decline_force"] = "User has forcibly cancelled document workflow."; // TRANSLATE
$l_workflow["log_decline"] = "User has cancelled document workflow."; // TRANSLATE
$l_workflow["log_doc_finished_force"] = "Workflow has been forcibly finished."; // TRANSLATE
$l_workflow["log_doc_finished"] = "Workflow is finished."; // TRANSLATE
$l_workflow["log_insert_doc"] = "Document has been inserted into wokflow."; // TRANSLATE

$l_workflow["logbook"] = "Журнал записей";
$l_workflow["empty_log"] = "Empty logbook"; // TRANSLATE
$l_workflow["emty_log_question"] = "Do you really want to empty the logbook?"; // TRANSLATE
$l_workflow["empty_log_ok"] = "The logbook is now emtpy."; // TRANSLATE
$l_workflow["log_is_empty"] = "The logbook is emtpy."; // TRANSLATE

$l_workflow["log_question_all"] = "Clear all"; // TRANSLATE
$l_workflow["log_question_time"] = "Clear older than"; // TRANSLATE
$l_workflow["log_question_text"] = "Choose option:"; // TRANSLATE

$l_workflow["log_remove_doc"] = "Document is removed from workflow."; // TRANSLATE
$l_workflow["action"] = "Action"; // TRANSLATE

$l_workflow[FILE_TABLE]["messagePath"] = "Документ";
if(defined("OBJECT_FILES_TABLE")){
	$l_workflow[OBJECT_FILES_TABLE]["messagePath"] = "Объект";
}
$l_workflow["auto_approved"] = "Document has been automatically approved."; // TRANSLATE
$l_workflow["auto_declined"] = "Document has been automatically declined."; // TRANSLATE

$l_workflow["doc_deleted"] = "Document has been deleted!"; // TRANSLATE
$l_workflow["ask_before_recover"] = "There are still documents/objects in the workflow process! Do you want to remove them from the workflow process?"; // TRANSLATE

$l_workflow["double_name"] = "Workflow name already exists!"; // TRANSLATE

$l_workflow["more_information"] = "Больше информации";
$l_workflow["less_information"] = "Меньше информации";

$l_workflow["no_wf_defined_object"] = "Для данного объекта не задан рабочий поток!";
?>