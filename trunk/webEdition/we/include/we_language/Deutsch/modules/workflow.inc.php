<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//
// $Id: workflow.inc.php,v 1.12 2007/10/09 14:18:16 alexander.lindenstruth Exp $

$l_workflow["new_workflow"]="Neuer Workflow";
$l_workflow["workflow"]="Workflow";

$l_workflow["doc_in_wf_warning"]="Das Dokument befindet sich gerade im Workflow!";
$l_workflow["message"] = "Mitteilung";
$l_workflow["in_workflow"] = "Dokument in Workflow";
$l_workflow["decline_workflow"] = "Dokument zur&uuml;ckweisen";
$l_workflow["pass_workflow"] = "Dokument weitergeben";

$l_workflow[FILE_TABLE]["in_workflow_ok"] = "Das Dokument wurde erfolgreich in den Workflow �bergeben!";
$l_workflow[FILE_TABLE]["in_workflow_notok"] = "Das Dokument konnte nicht in den Workflow �bergeben werden!";
if(defined("OBJECT_FILES_TABLE")){
	$l_workflow[OBJECT_FILES_TABLE]["in_workflow_ok"] = "Das Objekt wurde erfolgreich in den Workflow �bergeben!";
	$l_workflow[OBJECT_FILES_TABLE]["in_workflow_notok"] = "Das Objekt konnte nicht in den Workflow �bergeben werden!";
	$l_workflow[OBJECT_FILES_TABLE]["pass_workflow_ok"] = "Das Objekt wurde erfolgreich weitergegeben!";
	$l_workflow[OBJECT_FILES_TABLE]["pass_workflow_notok"] = "Das Objekt konnte nicht weitergegeben werden!";
	$l_workflow[OBJECT_FILES_TABLE]["decline_workflow_ok"] = "Das Objekt wurde an den Autor zur�ckgegeben!";
	$l_workflow[OBJECT_FILES_TABLE]["decline_workflow_notok"] = "Das Objekt konnte nicht an den Autor zur�ckgegeben werden!";
}
$l_workflow[FILE_TABLE]["pass_workflow_ok"] = "Das Dokument wurde erfolgreich weitergegeben!";
$l_workflow[FILE_TABLE]["pass_workflow_notok"] = "Das Dokument konnte nicht weitergegeben werden!";

$l_workflow[FILE_TABLE]["decline_workflow_ok"] = "Das Dokument wurde an den Autor zur�ckgegeben!";
$l_workflow[FILE_TABLE]["decline_workflow_notok"] = "Das Dokument konnte nicht an den Autor zur�ckgegeben werden!";

$l_workflow["no_wf_defined"] = "F�r dieses Dokument ist kein Workflow definiert!";

$l_workflow["document"]="Dokument";

$l_workflow["del_last_step"] = "Die letzte serielle Stufe kann nicht gel�scht werden!";
$l_workflow["del_last_task"] = "Die letzte parallele Stufe kann nicht gel�scht werden!";
$l_workflow["save_ok"] = "Der Workflow wurde erfolgreich gespeichert!";
$l_workflow["delete_ok"] = "Der Workflow wurde erfolgreich gel�scht!";
$l_workflow["delete_nok"] = "Der Workflow konnte nicht gel�scht werden!";

$l_workflow["name"] = "Name";
$l_workflow["type"] = "Typ";
$l_workflow["type_dir"] = "Verzeichnisbasiert";
$l_workflow["type_doctype"] = "DocumentType/Category basiert";
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
$l_workflow["select_user"]="Benutzer ausw�hlen";

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
$l_workflow["todo_next"] = "N�chste Workflow-Stufe.";

$l_workflow["go_next"]="N�chste Stufe";

$l_workflow["new_step"]="Erzeuge zus�tzliche serielle Stufe";
$l_workflow["new_task"]="Erzeuge zus�tzliche parallele Stufe";

$l_workflow["delete_step"]="Serielle Stufe l�schen";
$l_workflow["delete_task"]="Parallele Stufe l�schen";

$l_workflow["save_question"]="Alle Dokumente, welche sich im Workflow befinden, werden entfernt!\\nTrotzdem fortfahren?";
$l_workflow["nothing_to_save"]="Es gibt nichts zu speichern!";
$l_workflow["save_changed_workflow"] = "Der Workflow wurde ge�ndert.\\nM�chten Sie Ihre �nderungen speichern?";

$l_workflow["delete_question"]="Alle Daten des Workflows werden gel�scht!\\nTrotzdem fortfahren?";
$l_workflow["nothing_to_delete"]="Es gibt nichts zu l�schen!";

$l_workflow["user_empty"]="F�r die %s. Stufe wurden keine Beutzer definiert!";
$l_workflow["folders_empty"]="F�r den Workflow wurde kein Verzeichnis definiert!";
$l_workflow["objects_empty"]="F�r den Workflow wurde keine Klasse definiert!";
$l_workflow["doctype_empty"]="F�r den Workflow wurde kein Dokument-Typ oder Kategorie definiert!";
$l_workflow["worktime_empty"]="F�r die %s. Stufe wurd keine Arbeitszeit definiert!";
$l_workflow["name_empty"]="F�r den Workflow wurde noch kein Name definiert!";
$l_workflow["cannot_find_active_step"]="Kann aktive Stufe nicht finden!";

$l_workflow["no_perms"]="Keine Berechtigung!";
$l_workflow["plan"]="(planm��ig)";

$l_workflow["todo_returned"] = "Ein Dokument wurde zur�ckgewiesen.";

$l_workflow["description"]="Beschreibung";
$l_workflow["time"]="Zeit";

$l_workflow["log_approve_force"]="Das Dokument wurde weitergegeben";
$l_workflow["log_approve"]="Das Dokument wurde weitergegeben";
$l_workflow["log_decline_force"]="Das Dokument wurde wegen Zeit�berschreitung zur�ckgegeben";
$l_workflow["log_decline"]="Das Dokument wurde zur�ckgegeben";
$l_workflow["log_doc_finished_force"]="Der Workflow wurde wegen Zeit�berschreitung beendet";
$l_workflow["log_doc_finished"]="Der Workflow wurde beendet";
$l_workflow["log_insert_doc"]="Das Dokument wurde in den Workflow �bergeben";

$l_workflow["logbook"]           = "Logbuch";
$l_workflow["empty_log"]         = "Logbuch leeren";
$l_workflow["emty_log_question"] = "M�chten Sie wirklich das ganze Logbuch leeren?";
$l_workflow["empty_log_ok"]      = "Das Logbuch wurde geleert!";
$l_workflow["log_is_empty"]      = "Das Logbuch ist leer!";

$l_workflow["log_question_all"]="Alle Eintr�ge l�schen";
$l_workflow["log_question_time"]="Alle Eintr�ge l�schen, welche �lter sind als:";
$l_workflow["log_question_text"]="Bitte w�hlen Sie:";

$l_workflow["log_remove_doc"]="Das Dokument wurde vom Workflow entfernt";
$l_workflow["action"]="Aktion";

$l_workflow[FILE_TABLE]["messagePath"] = "Dokument";
if(defined("OBJECT_FILES_TABLE")){
	$l_workflow[OBJECT_FILES_TABLE]["messagePath"] = "Objekt";
}

$l_workflow["auto_approved"]="Dokument wurde automatisch weitergegeben";
$l_workflow["auto_declined"]="Dokument wurde automatisch zur�ckgewiesen";

$l_workflow["doc_deleted"]="Dokument wurde gel�scht!";
$l_workflow["ask_before_recover"]="Es befinden sich noch Dokumente/Objekte im Workflow! M�chten Sie diese Dokumente/Objekte aus dem Workflow entfernen?";

$l_workflow["double_name"]="Der Workflow Name existiert bereits!";

$l_workflow["more_information"] = "Weitere Informationen";
$l_workflow["less_information"] = "Weniger Informationen";

$l_workflow["no_wf_defined_object"] = "F�r dieses Objekt ist kein Workflow definiert!";

?>