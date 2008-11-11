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


$l_workflow["new_workflow"]="Neuer Workflow";
$l_workflow["workflow"]="Workflow";

$l_workflow["doc_in_wf_warning"]="Das Dokument befindet sich gerade im Workflow!";
$l_workflow["message"] = "Mitteilung";
$l_workflow["in_workflow"] = "Dokument in Workflow";
$l_workflow["decline_workflow"] = "Dokument zur&uuml;ckweisen";
$l_workflow["pass_workflow"] = "Dokument weitergeben";

$l_workflow[FILE_TABLE]["in_workflow_ok"] = "Das Dokument wurde erfolgreich in den Workflow übergeben!";
$l_workflow[FILE_TABLE]["in_workflow_notok"] = "Das Dokument konnte nicht in den Workflow übergeben werden!";
if(defined("OBJECT_FILES_TABLE")){
	$l_workflow[OBJECT_FILES_TABLE]["in_workflow_ok"] = "Das Objekt wurde erfolgreich in den Workflow übergeben!";
	$l_workflow[OBJECT_FILES_TABLE]["in_workflow_notok"] = "Das Objekt konnte nicht in den Workflow übergeben werden!";
	$l_workflow[OBJECT_FILES_TABLE]["pass_workflow_ok"] = "Das Objekt wurde erfolgreich weitergegeben!";
	$l_workflow[OBJECT_FILES_TABLE]["pass_workflow_notok"] = "Das Objekt konnte nicht weitergegeben werden!";
	$l_workflow[OBJECT_FILES_TABLE]["decline_workflow_ok"] = "Das Objekt wurde an den Autor zurückgegeben!";
	$l_workflow[OBJECT_FILES_TABLE]["decline_workflow_notok"] = "Das Objekt konnte nicht an den Autor zurückgegeben werden!";
}
$l_workflow[FILE_TABLE]["pass_workflow_ok"] = "Das Dokument wurde erfolgreich weitergegeben!";
$l_workflow[FILE_TABLE]["pass_workflow_notok"] = "Das Dokument konnte nicht weitergegeben werden!";

$l_workflow[FILE_TABLE]["decline_workflow_ok"] = "Das Dokument wurde an den Autor zurückgegeben!";
$l_workflow[FILE_TABLE]["decline_workflow_notok"] = "Das Dokument konnte nicht an den Autor zurückgegeben werden!";

$l_workflow["no_wf_defined"] = "Für dieses Dokument ist kein Workflow definiert!";

$l_workflow["document"]="Dokument";

$l_workflow["del_last_step"] = "Die letzte serielle Stufe kann nicht gelöscht werden!";
$l_workflow["del_last_task"] = "Die letzte parallele Stufe kann nicht gelöscht werden!";
$l_workflow["save_ok"] = "Der Workflow wurde erfolgreich gespeichert!";
$l_workflow["delete_ok"] = "Der Workflow wurde erfolgreich gelöscht!";
$l_workflow["delete_nok"] = "Der Workflow konnte nicht gelöscht werden!";

$l_workflow["name"] = "Name";
$l_workflow["type"] = "Typ";
$l_workflow["type_dir"] = "Verzeichnisbasiert";
$l_workflow["type_doctype"] = "Document-Typ/Kategorie basiert";
$l_workflow["type_object"] = "Objektbasiert";

$l_workflow["dirs"] = "Verzeichnisse";
$l_workflow["doctype"] = "Dokument-Typ";
$l_workflow["categories"] = "Kategorien";
$l_workflow["classes"] = "Klassen";

$l_workflow["active"] = "Workflow ist aktiv";

$l_workflow["step"] = "Stufe";
$l_workflow["and_or"] = "UND&nbsp;/&nbsp;ODER";
$l_workflow["worktime"] = "Arbeitszeit (Std.)";
$l_workflow["user"] = "Benutzer ";

$l_workflow["edit"] = "Bearbeiten";
$l_workflow["send_mail"] = "E-Mail verschicken";
$l_workflow["select_user"]="Benutzer auswählen";

$l_workflow["and"]=" UND ";
$l_workflow["or"]=" ODER ";

$l_workflow["waiting_on_approval"] = "Warte auf Freigabe von %s";
$l_workflow["status"] = "Status";
$l_workflow["step_from"] = "Stufe %s von %s";

$l_workflow["step_time"]= "Zeit";
$l_workflow["step_start"] = "Startzeit";
$l_workflow["step_plan"] = "Abgelaufen am";
$l_workflow["step_worktime"] = "Geplante Zeit";

$l_workflow["current_time"] = "Aktuelle Zeit";
$l_workflow["time_elapsed"] = "Verbrauchte Zeit (h:m:s)";
$l_workflow["time_remained"] = "&Uuml;brige Zeit (h:m:s)";

$l_workflow["todo_subject"] = "Workflow Aufgabe";
$l_workflow["todo_next"] = "Nächste Workflow-Stufe.";

$l_workflow["go_next"]="Nächste Stufe";

$l_workflow["new_step"]="Erzeuge zusätzliche serielle Stufe";
$l_workflow["new_task"]="Erzeuge zusätzliche parallele Stufe";

$l_workflow["delete_step"]="Serielle Stufe löschen";
$l_workflow["delete_task"]="Parallele Stufe löschen";

$l_workflow["save_question"]="Alle Dokumente, welche sich im Workflow befinden, werden entfernt!\\nTrotzdem fortfahren?";
$l_workflow["nothing_to_save"]="Es gibt nichts zu speichern!";
$l_workflow["save_changed_workflow"] = "Der Workflow wurde geändert.\\nMöchten Sie Ihre Änderungen speichern?";

$l_workflow["delete_question"]="Alle Daten des Workflows werden gelöscht!\\nTrotzdem fortfahren?";
$l_workflow["nothing_to_delete"]="Es gibt nichts zu löschen!";

$l_workflow["user_empty"]="Für die %s. Stufe wurden keine Benutzer definiert!";
$l_workflow["folders_empty"]="Für den Workflow wurde kein Verzeichnis definiert!";
$l_workflow["objects_empty"]="Für den Workflow wurde keine Klasse definiert!";
$l_workflow["doctype_empty"]="Für den Workflow wurde kein Dokument-Typ oder Kategorie definiert!";
$l_workflow["worktime_empty"]="Für die %s. Stufe wurd keine Arbeitszeit definiert!";
$l_workflow["name_empty"]="Für den Workflow wurde noch kein Name definiert!";
$l_workflow["cannot_find_active_step"]="Kann aktive Stufe nicht finden!";

$l_workflow["no_perms"]="Keine Berechtigung!";
$l_workflow["plan"]="(planmäßig)";

$l_workflow["todo_returned"] = "Ein Dokument wurde zurückgewiesen.";

$l_workflow["description"]="Beschreibung";
$l_workflow["time"]="Zeit";

$l_workflow["log_approve_force"]="Das Dokument wurde weitergegeben";
$l_workflow["log_approve"]="Das Dokument wurde weitergegeben";
$l_workflow["log_decline_force"]="Das Dokument wurde wegen Zeitüberschreitung zurückgegeben";
$l_workflow["log_decline"]="Das Dokument wurde zurückgegeben";
$l_workflow["log_doc_finished_force"]="Der Workflow wurde wegen Zeitüberschreitung beendet";
$l_workflow["log_doc_finished"]="Der Workflow wurde beendet";
$l_workflow["log_insert_doc"]="Das Dokument wurde in den Workflow übergeben";

$l_workflow["logbook"]           = "Logbuch";
$l_workflow["empty_log"]         = "Logbuch leeren";
$l_workflow["emty_log_question"] = "Möchten Sie wirklich das ganze Logbuch leeren?";
$l_workflow["empty_log_ok"]      = "Das Logbuch wurde geleert!";
$l_workflow["log_is_empty"]      = "Das Logbuch ist leer!";

$l_workflow["log_question_all"]="Alle Einträge löschen";
$l_workflow["log_question_time"]="Alle Einträge löschen, welche älter sind als:";
$l_workflow["log_question_text"]="Bitte wählen Sie:";

$l_workflow["log_remove_doc"]="Das Dokument wurde vom Workflow entfernt";
$l_workflow["action"]="Aktion";

$l_workflow[FILE_TABLE]["messagePath"] = "Dokument";
if(defined("OBJECT_FILES_TABLE")){
	$l_workflow[OBJECT_FILES_TABLE]["messagePath"] = "Objekt";
}

$l_workflow["auto_approved"]="Dokument wurde automatisch weitergegeben";
$l_workflow["auto_declined"]="Dokument wurde automatisch zurückgewiesen";

$l_workflow["doc_deleted"]="Dokument wurde gelöscht!";
$l_workflow["ask_before_recover"]="Es befinden sich noch Dokumente/Objekte im Workflow! Möchten Sie diese Dokumente/Objekte aus dem Workflow entfernen?";

$l_workflow["double_name"]="Der Workflow Name existiert bereits!";

$l_workflow["more_information"] = "Weitere Informationen";
$l_workflow["less_information"] = "Weniger Informationen";

$l_workflow["no_wf_defined_object"] = "Für dieses Objekt ist kein Workflow definiert!";

?>