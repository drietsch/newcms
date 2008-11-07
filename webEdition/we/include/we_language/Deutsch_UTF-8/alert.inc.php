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
 * Language file: alert.inc.php
 * Provides language strings.
 * Language: Deutsch
 */

// Workarround for bug 1292
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/backup.inc.php");
if (!isset($l_backup)) {
	include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/backup.inc.php");
}

$l_alert["notice"] = "Hinweis";
$l_alert["warning"] = "Warnung";
$l_alert["error"] = "Fehler";

$l_alert["noRightsToDelete"] = "Fehler beim Löschen von \\'%s\\'! Sie haben nicht die erforderlichen Rechte!";
$l_alert["noRightsToMove"] = "Fehler beim Verschieben von \\'%s\\'! Sie haben nicht die erforderlichen Rechte!";
$l_alert[FILE_TABLE]["in_wf_warning"] = "Bevor das Dokument in den Workflow gegeben werden kann, muß es gespeichert werden!\\nSoll das Dokument jetzt gespeichert werden?";
if( defined("OBJECT_FILES_TABLE") ){
	$l_alert[OBJECT_FILES_TABLE]["in_wf_warning"] = "Bevor das Objekt in den Workflow gegeben werden kann, muß es gespeichert werden!\\nSoll das Dokument jetzt gespeichert werden?";
	$l_alert[OBJECT_TABLE]["in_wf_warning"] = "Bevor die Klasse in den Workflow gegeben werden kann, muß sie gespeichert werden!\\nSoll die Klasse jetzt gespeichert werden?";
}
$l_alert[TEMPLATES_TABLE]["in_wf_warning"] = "Bevor das Template in den Workflow gegeben werden kann, muß es gespeichert werden!\\nSoll das Template jetzt gespeichert werden?";
$l_alert[FILE_TABLE]["not_im_ws"] = "Die Datei befindet sich nicht in Ihrem Arbeitsbereich!";
$l_alert["folder"]["not_im_ws"] = "Dieses Verzeichnis befindet sich nicht in Ihrem Arbeitsbereich!";
$l_alert[TEMPLATES_TABLE]["not_im_ws"] = "Die Vorlage befindet sich nicht in Ihrem Arbeitsbereich!";
$l_alert["required_field_alert"] = "Das Feld '%s' ist ein Pflichtfeld und muß ausgefüllt sein!";
$l_alert["phpError"] = "webEdition kann nicht gestartet werden";
$l_alert["3timesLoginError"] = "Der LogIn ist %sx fehlgeschlagen! Bitte warten Sie %s Minuten und versuchen Sie es noch einmal!";
$l_alert["popupLoginError"] = "Das webEdition Fenster konnte nicht geöffnet werden!\\n\\nwebEdition kann nur gestartet werden, wenn ihr Browser keine Pop-Ups unterdrückt.";
$l_alert['publish_when_not_saved_message'] = "Das Dokument ist noch nicht gespeichert! Möchten Sie trotzdem veröffentlichen?";
$l_alert["template_in_use"] = "Die Vorlage wird benutzt und kann daher nicht entfernt werden!";
$l_alert["no_cookies"] = "Sie haben Cookies nicht aktiviert. Bitte aktivieren Sie in Ihrem Browser Cookies, damit webEdition funktioniert!";
$l_alert["doctype_hochkomma"] = "Der Name eines Dokument-Typs darf kein ' (Hochkomma) kein , (Komma) und kein \" (Anführungszeichen) enthalten!";
$l_alert["thumbnail_hochkomma"] = "Der Name einer Miniaturansicht darf kein ' (Hochkomma) und kein , (Komma) enthalten!";
$l_alert["can_not_open_file"] = "Die Datei %s konnte nicht geöffnet werden!";
$l_alert["no_perms_title"] = "Keine Berechtigung";
$l_alert["no_perms_action"] = "Sie haben keine Berechtigung für diese Aktion.";
$l_alert["access_denied"] = "Zugriff verweigert!";
$l_alert["no_perms"] = "Bitte wenden Sie sich an den Eigentümer (%s)<br>oder einen Administrator, wenn Sie Zugriff benötigen!";
$l_alert["temporaere_no_access"] = "Zugriff zur Zeit nicht möglich";
$l_alert["temporaere_no_access_text"] = "Die Datei (%s) wird gerade vom Benutzer '%s' bearbeitet.";
$l_alert["file_locked_footer"]  = "Das Dokument wird gerade vom Benutzer \"%s\" bearbeitet.";
$l_alert["file_no_save_footer"] = "Sie haben nicht die erforderlichen Rechte, dieses Dokument zu speichern.";
$l_alert["login_failed"] = "Benutzername und/oder Kennwort falsch!";
$l_alert["login_failed_security"] = "webEdition konnte nicht gestartet werden!\\n\\nAus Sicherheitsgründen wurde der Loginvorgang abgebrochen, da die maximale Anmeldezeit überschritten wurde!\\n\\nBitte melden Sie sich neu an.";
$l_alert["perms_no_permissions"] = "Sie haben keine Berechtigung für diese Aktion!\\nBitte melden Sie sich neu an!";
$l_alert["no_image"] = "Bei der ausgewählten Datei handelt es sich nicht um eine Grafik!";
$l_alert["delete_ok"] = "Dateien bzw. Verzeichnisse erfolgreich gelöscht!";
$l_alert["delete_cache_ok"] = "Cache erfolgreich gelöscht!";
$l_alert["nothing_to_delete"] = "Es wurde nichts zum Löschen ausgewählt!";
$l_alert["no_new"]["objectFile"] = "Sie dürfen keine neuen Objekte erstellen, da Ihnen entweder die Rechte fehlen<br>oder es keine Klasse gibt, in welcher einer Ihrer Arbeitsbereiche gültig ist!";
$l_alert["delete"] = "Ausgewählte Einträge löschen?\\nSind Sie sicher?";
$l_alert["delete_cache"] = "Cache zu den ausgewählten Einträgen löschen?\\nSind Sie sicher?";
$l_alert["delete_folder"] = "Ausgewähltes Verzeichnis löschen?\\nBedenken Sie, dass bei einem Verzeichnis alle darin enthaltenen Dokumente und Verzeichnisse automatisch mit gelöscht werden!\\nSind Sie sicher?";
$l_alert["delete_nok_error"] = "Die Datei '%s' kann nicht gelöscht werden.";
$l_alert["delete_nok_file"] = "Die Datei '%s' kann nicht gelöscht werden.\\nMöglicherweise ist die Datei schreibgeschützt.";
$l_alert["delete_nok_folder"] = "Das Verzeichnis '%s' kann nicht gelöscht werden.\\nMöglicherweise ist das Verzeichnis schreibgeschützt.";
$l_alert["delete_nok_noexist"] = "Diese Datei '%s' existiert nicht!";
$l_alert["noResourceTitle"] = "Kein Dokument bzw. Verzeichnis!";
$l_alert["noResource"] = "Das Dokument bzw. Verzeichnis existiert nicht!";
$l_alert["move_exit_open_docs_question"] = "Vor dem Verschieben müssen alle %s geschlossen werden.\\nWenn Sie fortfahren, werden die folgenden %s geschlossen, ungespeicherte Änderungen gehen dabei verloren.\\n\\n";
$l_alert["move_exit_open_docs_continue"] = "Fortfahren?";
$l_alert["move"] = "Ausgewählte Einträge verschieben?\\nSind Sie sicher?";
$l_alert["move_ok"] = "Dateien wurden erfolgreich verschoben!";
$l_alert["move_duplicate"] = "Gleichnamige Dateien im Zielverzeichnis vorhanden.\\nDie Dateien konnten nicht verschoben werden.";
$l_alert["move_nofolder"] = "Die ausgewählten Dateien konnten nicht verschoben werden.\\nEs können keine Verzeichnisse verschoben werden.";
$l_alert["move_onlysametype"] = "Die ausgewählten Dateien konnten nicht verschoben werden.\\nObjekte können nur innerhalb des eigenen Klassenverzeichnisses verschoben werden.";
$l_alert["move_no_dir"] = "Es wurde kein Zielverzeichnis ausgewählt.";
$l_alert["nothing_to_move"] = "Es wurde nichts zum Verschieben ausgewählt.";
$l_alert["document_move_warning"] = "Nach dem verschieben von Dokumenten ist ein Rebuild erforderlich.<br />Möchten Sie diesen jetzt durchführen?";
$l_alert["move_of_files_failed"] = "Eine oder mehrere der zu verschiebenden Dateien konnten nicht verschoben werden! Verschieben Sie diese Dateien manuell.\\n Folgende Dateien sind davon betroffen:\\n%s";
$l_alert["template_save_warning"] = "Diese Vorlage wird von %s veröffentlichten Dokumenten benutzt. Sollen diese Dokumente neu gespeichert werden?<br>ACHTUNG bei vielen Dokumenten kann das sehr lange dauern!";
$l_alert["template_save_warning1"] = "Diese Vorlage wird von einem veröffentlichten Dokument benutzt. Soll dieses Dokument neu gespeichert werden?";
$l_alert["template_save_warning2"] = "Diese Vorlage wird von anderen Vorlagen und Dokumenten benutzt. Sollen diese neu gespeichert werden?";
$l_alert["thumbnail_exists"] = "Diese Miniaturansicht ist bereits vorhanden!";
$l_alert["thumbnail_not_exists"] = "Diese Miniaturansicht ist nicht vorhanden!";
$l_alert["doctype_exists"] = "Dieser Dokument-Typ ist bereits vorhanden!";
$l_alert["doctype_empty"] = "Sie haben noch keinen Namen eingegeben!";
$l_alert["delete_cat"] = "Möchten Sie die ausgewählte Kategorie wirklich löschen?";
$l_alert["delete_cat_used"] = "Diese Kategorie wird schon benutzt und kann daher nicht gelöscht werden!";
$l_alert["cat_exists"] = "Die Kategorie ist bereits vorhanden!";
$l_alert["cat_changed"] = "Diese Kategorie wird schon benutzt! Wenn die Kategorie in Dokumenten angezeigt wird, dann müssen Sie diese Dokumente neu speichern!\\nSoll die Kategorie trotzdem geändert werden?";
$l_alert["max_name_cat"] = "Der Name der Kategorie darf maximal 32 Zeichen lang sein!";
$l_alert["not_entered_cat"] = "Sie haben keinen Namen der Kategorie eingegeben!";
$l_alert["cat_new_name"] = "Bitte geben Sie den neuen Namen der Kategorie ein!";
$l_alert["delete_recipient"] = "Möchten Sie die ausgewählte E-Mail-Adresse wirklich löschen?";
$l_alert["recipient_exists"] = "Die E-Mail-Adresse ist bereits vorhanden!";
$l_alert["input_name"] = "Bitte geben Sie eine neue E-Mail-Adresse ein!";
$l_alert['input_file_name'] = "Bitte geben Sie einen Dateinamen an.";
$l_alert["max_name_recipient"] = "Die E-Mail-Adresse darf maximal 255 Zeichen lang sein!";
$l_alert["not_entered_recipient"] = "Sie haben keine E-Mail-Adresse eingegeben!";
$l_alert["recipient_new_name"] = "E-Mail-Adresse ändern!";
$l_alert["we_backup_import_upload_err"] = "Es gab einen Fehler beim Hochladen der Backup-Datei! Die maximal erlaubte Dateigrösse für Uploads beträgt %s. Wenn Ihre Backup-Datei grösser ist, dann kopieren Sie diese per FTP in das Verzeichnis webEdition/we_backup und wählen '".$l_backup["import_from_server"]."'!";
$l_alert["rebuild_nodocs"] = "Es gibt keine Dokumente, welche den ausgewählten Kriterien entsprechen!";
$l_alert["we_name_not_allowed"] = "Die Namen 'we' und 'webEdition' werden von webEdition selbst benutzt und dürfen deshalb nicht verwendet werden!";
$l_alert["we_filename_empty"] = "Sie haben noch keinen Dateinamen für dieses Dokument bzw. Verzeichnis eingegeben!";
$l_alert["exit_multi_doc_question"] = "Einige geöffnete Dokumente enthalten noch ungespeicherte Änderungen. Wenn Sie fortfahren, werden diese Änderungen verworfen. Wollen Sie fortfahren und alle ungespeicherten Änderungen verwerfen?";
$l_alert["exit_doc_question_".FILE_TABLE] = "Es scheint, als ob Sie das Dokument verändert haben.<br>Möchten Sie Ihre &Auml;nderungen speichern?";
$l_alert["exit_doc_question_".TEMPLATES_TABLE] = "Es scheint, als ob Sie die Vorlage verändert haben.<br>Möchten Sie Ihre &Auml;nderungen speichern?";
if( defined("OBJECT_TABLE") ){
	$l_alert["exit_doc_question_".OBJECT_TABLE] = "Es scheint, als ob Sie die Klasse verändert haben.<br>Möchten Sie Ihre &Auml;nderungen speichern?";
	$l_alert["exit_doc_question_".OBJECT_FILES_TABLE] = "Es scheint, als ob Sie das Objekt verändert haben.<br>Möchten Sie Ihre &Auml;nderungen speichern?";
}
$l_alert["deleteTempl_notok_used"] = "Die Aktion konnte nicht ausgeführt werden, da eine oder mehrere zu löschende Vorlagen schon benutzt werden!";
$l_alert["deleteClass_notok_used"] = "Die Aktion konnte nicht ausgeführt werden, da eine oder mehrere zu löschende Klassen schon benutzt werden!";
$l_alert["delete_notok"] = "Es gab einen Fehler beim Löschen!";
$l_alert["nothing_to_save"] = "Die Speicherfunktion ist im Moment nicht durchführbar!";
$l_alert["nothing_to_publish"] = "Ein Veröffentlichen ist im Moment nicht möglich!";
$l_alert["we_filename_notValid"] = "Der eingegebene Dateiname ist nicht gültig!\\nErlaubte Zeichen sind Buchstaben von a bis z (Groß- oder Kleinschreibung), Zahlen, Unterstrich (_), Minus (-) und Punkt (.).";
$l_alert["empty_image_to_save"] = "Gewählte Grafik ist leer.\\nTrotzdem weitermachen?";
$l_alert["path_exists"] = "Das Dokument bzw. Verzeichnis %s konnte nicht gespeichert werden, da es bereits ein anderes Dokument an dieser Stelle gibt!";
$l_alert["folder_not_empty"] = "Da eines oder mehrere der zu löschende Verzeichnisse nicht ganz leer waren, konnten Sie nicht vollständig vom Server gelöscht werden! Löschen Sie die Dateien manuell.\\n Folgende Verzeichnisse sind davon betroffen:\\n%s";
$l_alert["name_nok"] = "Namen dürfen die Zeichen '<' und '>' nicht erhalten!";
$l_alert["found_in_workflow"] = "Ein oder mehrere zu löschende Einträge befinden sich zur Zeit im Workflow! Möchten Sie diese Einträge aus dem Workflow entfernen?";
$l_alert["import_we_dirs"] = "Sie versuchen einen Import von einem, mit webEdition verwaltetem Verzeichnis zu machen!\\nDiese Verzeichnisse sind geschützt und deswegen es ist nicht möglich von ihnen zu importieren!";
$l_alert["wrong_file"]["image/*"] = "Die Datei konnte nicht angelegt werden. Entweder handelt es sich nicht um eine Grafik oder es steht nicht ausreichend Speicherplatz (Webspace) zur Verfügung!";
$l_alert["wrong_file"]["application/x-shockwave-flash"] = "Die Datei konnte nicht angelegt werden. Entweder handelt es sich um keinen Flash-Datei oder ihr Speicherplatz (Festplatte) ist erschöpft!";
$l_alert["wrong_file"]["video/quicktime"] = "Die Datei konnte nicht angelegt werden. Entweder handelt es sich um keinen Quicktime-Datei oder ihr Speicherplatz (Festplatte) ist erschöpft!";
$l_alert["wrong_file"]["text/css"] = "Die Datei konnte nicht angelegt werden. Entweder handelt es sich um keine CSS-Datei oder ihr Speicherplatz (Festplatte) ist erschöpft!";
$l_alert["no_file_selected"] = "Sie haben keine Datei zum Hochladen ausgewählt!";
$l_alert["browser_crashed"] = "Das Fenster konnte nicht geöffnet werden, da Ihr Browser einen Fehler verursacht hat!  Bitte sichern Sie Ihre Arbeit und starten Ihren Browser neu.";
$l_alert["copy_folders_no_id"] = "Das aktuelle Verzeichnis muß zuerst gespeichert werden!";
$l_alert["copy_folder_not_valid"] =  "Das gleiche Verzeichnis oder eins der Elternverzeichnisse kann nicht kopiert werden!";
$l_alert['no_views']['headline']    = 'Achtung';
$l_alert['no_views']['description'] = 'Für dieses Dokument ist keine Ansicht verfügbar.';
$l_alert['navigation']['last_document']  = 'Sie befinden sich auf dem letzten Dokument.';
$l_alert['navigation']['first_document'] = 'Sie befinden sich auf dem ersten Dokument.';
$l_alert['navigation']['doc_not_found']  = 'Could not find matching document.';
$l_alert['navigation']['no_entry']       = 'Kein Eintrag in der History vorhanden.';
$l_alert['navigation']['no_open_document'] = 'Es ist kein Dokument geöffnet.';
$l_alert['delete_single']['confirm_delete']  = 'Soll dieses Dokument wirklich gelöscht werden?';
$l_alert['delete_single']['no_delete']       = 'Die Datei konnte nicht gelöscht werden.';
$l_alert['delete_single']['return_to_start'] = 'Die Datei wurde erfolgreich gelöscht.\\nZurück zum seeMode Startdokument.';
$l_alert['move_single']['return_to_start'] = 'Die Datei wurde erfolgreich verschoben.\\nZurück zum seeMode Startdokument.';
$l_alert['move_single']['no_delete'] = 'Die Datei konnte nicht verschoben werden.';
$l_alert['cockpit_not_activated'] = 'Die Aktion konnte nicht ausgeführt werden, da das Cockpit nicht aktiviert ist.';
$l_alert['cockpit_reset_settings'] = 'Sollen die aktuellen Cockpit Einstellungen geslöscht werden und die Standard-Einstellungen wiederhergestellt werden?';
$l_alert['save_error_fields_value_not_valid'] = 'Die markierten Felder enthalten keine gültigen Werte.\\nBitte tragen Sie gültige Werte ein.';

$l_alert['eplugin_exit_doc'] = "Die Verbindung zwischen webEdition und dem externen Editor wird beim Schließen des Dokuments getrennt und die Inhalte werden nicht mehr synchronisiert.\\nMöchten Sie das Dokument schließen?";

$l_alert['delete_workspace_user'] = "Das Verzeichnis %s kann nicht gelöscht werden! Es ist als Arbeitsbereich für folgende Benutzer bzw. Gruppen definiert:\\n%s";
$l_alert['delete_workspace_user_r'] = "Das Verzeichnis %s kann nicht gelöscht werden! Innerhalb des Verzeichnisses befinden sich weitere Verzeichnisse, welche als Arbeitsbereich für folgende Benutzer bzw. Gruppen definiert sind:\\n%s";
$l_alert['delete_workspace_object'] = "Das Verzeichnis %s kann nicht gelöscht werden. Es ist als Arbeitsbereich in folgenden Objekten definiert:\\n%s";
$l_alert['delete_workspace_object_r'] = "Das Verzeichnis %s kann nicht gelöscht werden. Innerhalb des Verzeichnisses befinden sich weitere Verzeichnisse, welche als Arbeitsbereich in folgenden Objekten definiert sind:\\n%s";

$l_alert['field_contains_incorrect_chars'] = "Ein Feld (vom Typ %s) enthält ungültige Zeichen.";
$l_alert['field_input_contains_incorrect_length'] = "Die maximale Länge eines Feldes vom Typ \'Textinput\' beträgt 255 Zeichen. Wenn Sie mehr Zeichen benötigen, dann verwenden Sie ein Feld vom Typ \'Textarea\'.";
$l_alert['field_int_contains_incorrect_length'] = "Die maximale Länge eines Feldes vom Typ \'Integer\' beträgt 10 Zeichen.";
$l_alert['field_int_value_to_height'] = "Der maximale Wert eines Feldes vom Typ \'Integer\' ist 2147483647.";

$l_alert["we_filename_notValid"] = "Der Dateiname der hochzuladenden Datei ist nicht gültig!\\nErlaubte Zeichen sind Buchstaben von a bis z (Groß- oder Kleinschreibung), Zahlen, Unterstrich (_), Minus (-) und Punkt (.).";
$l_alert["login_denied_for_user"] = "Der Benutzer kann sich nicht anmelden. Sein Zugang wurde gesperrt";

$l_alert["no_perm_to_delete_single_document"] = "Sie verfügen nicht über die benötigten Rechte, um das aktive Dokument zu löschen";

$l_confim["applyWeDocumentCustomerFiltersDocument"] = "Das Dokument wurde in einen Ordner mit abweichenden Zugriffsrechten für Kunden verschoben. Sollen die Einstellungen des Ordners auf dieses Dokument übertragen werden?";
$l_confim["applyWeDocumentCustomerFiltersFolder"]   = "Das Verzeichnis wurde in einen Ordner mit abweichenden Zugriffsrechten für Kunden verschoben. Sollen die Einstellungen für dieses Verzeichnis und alle Unterelemente übertragen werden? ";

$l_alert['error_fields_value_not_valid'] = 'Eingabe-Felder enthalten ungültige Werte!';
$l_alert['field_in_tab_notvalid_pre'] = "Die Einstellungen konnten nicht gespeichert werden, da folgende Felder ungültige Werte enthalten:";
$l_alert['field_in_tab_notvalid'] = ' - Feld %s im Tab %s';
$l_alert['field_in_tab_notvalid_post'] = 'Bitte korrigieren Sie die Felder und speichern Sie die Einstellungen erneut.';
$l_alert['discard_changed_data'] = 'Es gibt nicht gespeicherte Änderungen, die verloren gehen. Sind sie sicher?';
?>