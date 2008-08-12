<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//
// $Id: users.inc.php,v 1.23 2007/10/31 16:36:50 holger.meyer Exp $

/**
 * Language file: users.inc.php
 * Provides language strings.
 * Language: Deutsch
 */
$l_users["user_same"] = "Der eigene Benutzer kann nicht gel�scht werden!";
$l_users["grant_owners_ok"] = "Die Besitzer wurden erfolgreich �bertragen!";
$l_users["grant_owners_notok"] = "Es gab einen Fehler beim �bertragen der Besitzer!";
$l_users["grant_owners"] = "Besitzer �bertragen";
$l_users["grant_owners_expl"] = "�bertragen Sie die oben eingestellten Besitzer und Benutzer auf alle Dateien und Verzeichnisse, welche sich in diesem Verzeichnis befinden.";
$l_users["make_def_ws"] = "Standard";
$l_users["user_saved_ok"] = "Der Benutzer '%s' wurde erfolgreich gespeichert";
$l_users["group_saved_ok"] = "Die Gruppe '%s' wurde erfolgreich gespeichert";
$l_users["alias_saved_ok"] = "Das Alias '%s' wurde erfolgreich gespeichert";
$l_users["user_saved_nok"] = "Der Benutzer '%s' kann nicht gespeichert werden!";
$l_users["nothing_to_save"] = "Es gibt nichts zu speichern!";
$l_users["username_exists"] = "Der Benutzername '%s' existiert schon!";
$l_users["username_empty"] = "Der Benutzername ist nicht ausgef�llt!";
$l_users["user_deleted"] = "Der Benutzer '%s' wurde erfolgreich gel�scht!";
$l_users["nothing_to_delete"] = "Es gibt nichts zu l�schen!";
$l_users["delete_last_user"] = "Zur Verwaltung wird mindestens ein Administrator ben�tigt. Sie k�nnen den letzten Administrator nicht l�schen.";
$l_users["modify_last_admin"] = "Zur Verwaltung wird mindestens ein Administrator ben�tigt. Sie k�nnen die Rechte des letzten Administrators nicht �ndern.";
$l_users["user_path_nok"] = "Der Pfad ist nicht korrekt!";
$l_users["user_data"] = "Benutzerdaten";
$l_users["first_name"] = "Vorname";
$l_users["second_name"] = "Nachname";
$l_users["username"] = "Benutzername";
$l_users["password"] = "Kennwort";
$l_users["workspace_specify"] = "Arbeitsbereich spezifizieren";
$l_users["permissions"] = "Rechte";
$l_users["user_permissions"] = "Redakteur";
$l_users["admin_permissions"] = "Administrator";
$l_users["password_alert"] = "Das Kennwort mu� mindestens 4 Zeichen lang sein";
$l_users["delete_alert_user"] = "Alle Benutzerdaten f�r den Benutzernamen '%s' werden gel�scht.\\nSind Sie sicher?";
$l_users["delete_alert_alias"] = "Alle Aliasdaten f�r das Alias '%s' werden gel�scht.\\nSind Sie sicher?";
$l_users["delete_alert_group"] = "Alle Gruppendaten und Gruppenbenutzer f�r die Gruppe '%s' werden gel�scht.\\nSind Sie sicher?";
$l_users["created_by"] = "Erstellt von";
$l_users["changed_by"] = "Ge�ndert von";
$l_users["no_perms"] = "Sie haben keine Berechtigung, diese Option zu benutzen!";
$l_users["publish_specify"] = "Benutzer darf ver�ffentlichen";
$l_users["work_permissions"] = "Arbeitsrechte";
$l_users["control_permissions"] = "Kontrollrechte";
$l_users["log_permissions"] = "Logrechte";
$l_users["file_locked"][FILE_TABLE] = "Die Datei '%s' wird gerade von Benutzer '%s' bearbeitet!";
$l_users["file_locked"][TEMPLATES_TABLE] = "Die Vorlage '%s' wird gerade von Benutzer '%s' bearbeitet!";
if(defined("OBJECT_TABLE")){
	$l_users["file_locked"][OBJECT_TABLE] = "Die Klasse '%s' wird gerade von Benutzer '%s' bearbeitet!";
	$l_users["file_locked"][OBJECT_FILES_TABLE] = "Das Objekt '%s' wird gerade von Benutzer '%s' bearbeitet!";
}
$l_users["acces_temp_denied"] = "Zugriff zur Zeit nicht m&ouml;glich";
$l_users["description"] = "Beschreibung";
$l_users["group_data"] = "Gruppendaten";
$l_users["group_name"] = "Gruppenname";
$l_users["group_member"] = "Gruppenmitgliedschaft";
$l_users["group"] = "Gruppe";
$l_users["address"] = "Adresse";
$l_users["houseno"] = "Hausnummer";
$l_users["state"] = "Bundesland";
$l_users["PLZ"] = "Postleitzahl";
$l_users["city"] = "Stadt";
$l_users["country"] = "Land";
$l_users["tel_pre"] = "Telefon Vorwahl";
$l_users["fax_pre"] = "Fax Vorwahl";
$l_users["telephone"] = "Telefon";
$l_users["fax"] = "Fax";
$l_users["mobile"] = "Handy";
$l_users["email"] = "E-Mail";
$l_users["general_data"] = "Allgemeine Daten";
$l_users["workspace_documents"] = "Arbeitsbereich Dokumente";
$l_users["workspace_templates"] = "Arbeitsbereich Vorlagen";
$l_users["workspace_objects"] = "Arbeitsbereich Objekte";
$l_users["save_changed_user"] = "Der Benutzer wurde ge�ndert.\\nM�chten Sie Ihre �nderungen speichern?";
$l_users["not_able_to_save"] = " Daten wurden nicht gespeichert, da sie ung�ltig sind!";
$l_users["cannot_save_used"] = " Status kann nicht ge�ndert werden, da gerade in Bearbeitung!";
$l_users["geaendert_von"] = "Ge�ndert  von";
$l_users["geaendert_am"] = "Ge�ndert  am";
$l_users["angelegt_am"] = "Angelegt  am";
$l_users["angelegt_von"] = "Angelegt  von";
$l_users["status"] = "Status";
$l_users["value"] = " Wert ";
$l_users["gesperrt"] = "gesperrt";
$l_users["freigegeben"] = "freigegeben";
$l_users["gel�scht"] = "gel�scht";
$l_users["ohne"] = "Ohne";
$l_users["user"] = "Benutzer";
$l_users["usertyp"] = "Benutzer-Typ";
$l_users["search"] = "Suche";
$l_users["search_result"] = "Ergebnis";
$l_users["search_for"] = "Suche nach";
$l_users["inherit"] = "�bernehme Rechte von Elterngruppe";
$l_users["inherit_ws"] = "�bernehme Dokument-Arbeitsbereiche der Elterngruppe";
$l_users["inherit_wst"] = "�bernehme Vorlagen-Arbeitsbereiche der Elterngruppe";
$l_users["inherit_wso"] = "�bernehme Objekt-Arbeitsbereiche der Elterngruppe";
$l_users["organization"] = "Organisation";
$l_users["give_org_name"] = "Der Name der Organisation";
$l_users["can_not_create_org"] = "Die Organisation kann nicht erstellt worden";
$l_users["org_name_empty"] = "Der Name der Organisation ist leer";
$l_users["salutation"] = "Anrede";
$l_users["sucheleer"] = "Es wurde kein Suchwort angegeben.";
$l_users["alias_data"] = "Alias Daten";
$l_users["rights_and_workspaces"] = "Rechte und<br>Arbeitsbereiche";
$l_users["workspace_navigations"] = "Arbeitsbereich Navigation";
$l_users["inherit_wsn"] = "�bernehme Navigations-Arbeitsbereiche der Elterngruppe";
$l_users["workspace_newsletter"] = "Arbeitsbereich Newsletter";
$l_users["inherit_wsnl"] = "�bernehme Newsletter-Arbeitsbereiche der Elterngruppe";

$l_users["delete_user_same"] = "Sie k�nnen nicht Ihr eigenes Konto l�schen.";
$l_users["delete_group_user_same"] = "Sie k�nnen nicht Ihre eigene Gruppe l�schen.";

$l_users["login_denied"] = "Login gesperrt";

$l_users["workspaceFieldError"] = "FEHLER: Falscher Wert f�r einen Arbeitsbereich!";
$l_users["noGroupError"] = "FEHLER: Gruppe existiert nicht!";

?>