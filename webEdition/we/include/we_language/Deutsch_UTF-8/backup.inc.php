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
 * Language file: backup.inc.php
 * Provides language strings.
 * Language: Deutsch
 */
$l_backup["save_not_checked"] = "Sie haben noch nicht ausgewählt, wohin die Backup-Datei gespeichert werden soll!";
$l_backup["wizard_title"] = "Backup wiederherstellen Wizard";
$l_backup["wizard_title_export"] = "Backup Wizard";
$l_backup["save_before"] = "Während des Wiederherstellens der Backup-Datei werden die vorhandenen Daten gelöscht! Es wird daher empfohlen, die vorhandenen Daten vorher zu speichern.";
$l_backup["save_question"] = "Möchten Sie dies jetzt tun?";
$l_backup["step1"] = "Schritt 1/4 - Vorhandene Daten speichern";
$l_backup["step2"] = "Schritt 2/4 - Datenquelle auswählen";
$l_backup["step3"] = "Schritt 3/4 - Gesicherte Daten wiederherstellen";
$l_backup["step4"] = "Schritt 4/4 - Wiederherstellung beendet";
$l_backup["extern"] = "webEdition-externe Dateien/Verzeichnisse wiederherstellen";
$l_backup["settings"] = "Einstellungen wiederherstellen";
$l_backup["rebuild"] = "Automatischer Rebuild";
$l_backup["select_upload_file"] = "Wiederherstellung aus lokaler Datei hochladen";
$l_backup["select_server_file"] = "Wählen Sie die gewünschte Backup-Datei aus.";
$l_backup["charset_warning"] = "Sollte es Probleme beim Wiederherstellen eines Backups geben, achten Sie bitte darauf, dass im Zielsystem derselbe Zeichensatz (Charset) wie im Quellsystem verwendet wird. Dies gilt sowohl für den Zeichensatz der Datenbank (collation) als auch für den Zeichensatz der verwendeten Oberflächensprache!";
$l_backup["finished_success"] = "Der Import der Backup-Daten wurde erfolgreich beendet.";
$l_backup["finished_fail"] = "Der Import der Backup-Daten wurde nicht erfolgreich beendet.";
$l_backup["question_taketime"] = "Der Export dauert einige Zeit.";
$l_backup["question_wait"] = "Bitte haben Sie etwas Geduld!";
$l_backup["export_title"] = "Backup erstellen";
$l_backup["finished"] = "Beendet";
$l_backup["extern_files_size"] = "Dieser Vorgang kann einige Minuten dauern. Es werden unter Umständen mehrere Dateien angelegt, da die Datenbankeinstellung auf eine maximale Dateigröße von %.1f MB (%s Byte) beschränkt ist.";
$l_backup["extern_files_question"] = "webEdition-externe Dateien/Verzeichnisse sichern";
$l_backup["export_location"] = "Bitte wählen Sie aus, wo die Backup-Datei gespeichert werden soll. Wird die Datei auf dem Server gespeichert, finden Sie diese unter '/webEdition/we_backup'.";
$l_backup["export_location_server"] = "Auf dem Server";
$l_backup["export_location_send"] = "Auf Ihrer lokalen Festplatte";
$l_backup["can_not_open_file"] = "Die Datei '%s' kann nicht geöffnet werden.";
$l_backup["too_big_file"] = "Die Datei '%s' kann nicht gespeichert werden, da die maximale Dateigröße überschritten wurde.";
$l_backup["cannot_save_tmpfile"] = " Temporäre Datei kann nicht angelegt werden! Prüfen Sie bitte, ob Sie die Rechte haben in %s zu schreiben.";
$l_backup["cannot_save_backup"] = "Die Backup-Datei kann nicht gespeichert werden.";
$l_backup["cannot_send_backup"] = " Backup kann nicht ausgeführt werden ";
$l_backup["finish"] = "Die Backup-Datei wurde erstellt und kann nun heruntergeladen werden.";
$l_backup["finish_error"] = " Fehler: Backup konnte nicht erfolgreich ausgeführt werden";
$l_backup["finish_warning"] = "Warnung: Backup wurde ausgeführt, möglicherweise wurden nicht alle Dateien vollständig angelegt";
$l_backup["export_step1"] = "Schritt 1/2 - Backup Parameter";
$l_backup["export_step2"] = "Schritt 2/2 - Backup beendet";
$l_backup["unspecified_error"] = "Ein unbekannter Fehler ist aufgetreten";
$l_backup["export_users_data"] = "Benutzerdaten sichern";
$l_backup["import_users_data"] = "Benutzerdaten wiederherstellen";
$l_backup["import_from_server"] = "Daten vom Server laden";
$l_backup["import_from_local"] = "Daten aus lokal gesicherter Datei laden";
$l_backup["backup_form"] = "Backup vom ";
$l_backup["nothing_selected"] = "Es wurde nichts ausgewählt!";
$l_backup["query_is_too_big"] = "Die Backup-Datei enthält eine Datei, welche nicht wiederhergestellt werden konnte, da sie größer als %s bytes ist!";
$l_backup["show_all"] = "Zeige alle Dateien";
$l_backup["import_customer_data"] = "Kundendaten wiederherstellen";
$l_backup["import_shop_data"] = "Shopdaten wiederherstellen";
$l_backup["export_customer_data"] = "Kundendaten sichern";
$l_backup["export_shop_data"] = "Shopdaten sichern";
$l_backup["working"] = "In Arbeit...";
$l_backup["preparing_file"] = "Daten fürs Wiederherstellen vorbereiten...";
$l_backup["external_backup"] = "Externe Daten sichern...";
$l_backup["import_content"] = "Inhalt wiederherstellen";
$l_backup["import_files"] = "Dateien wiederherstellen";
$l_backup["import_doctypes"] = "Dateien wiederherstellen";
$l_backup["import_user_data"] = "Benutzerdaten wiederherstellen";
$l_backup["import_templates"] = "Vorlagen wiederherstellen";
$l_backup["export_content"] = "Inhalt sichern";
$l_backup["export_files"] = "Dateien sichern";
$l_backup["export_doctypes"] = "Dateien sichern";
$l_backup["export_user_data"] = "Benutzerdaten sichern";
$l_backup["export_templates"] = "Vorlagen sichern";
$l_backup["download_starting"] = "Der Download der Backup-Datei wurde gestartet.<br><br>Sollte der Download nach 10 Sekunden nicht starten,<br>";
$l_backup["download"] = "klicken Sie bitte hier.";
$l_backup["download_failed"] = "Die angeforderte Datei existiert entweder nicht oder Sie haben keine Berechtigung, sie herunterzuladen.";
$l_backup["extern_backup_question_exp"] = "Sie haben 'webEdition-externe Dateien/Verzeichnisse sichern' ausgewählt. Diese Auswahl kann sehr zeitintensiv sein und zu Systemfehlern führen. Trotzdem fortfahren?";
$l_backup["extern_backup_question_exp_all"] = "Sie haben 'Alle auswählen' ausgewählt. Damit wird automatisch 'webEdition-externe Dateien/Verzeichnisse sichern' mit ausgewählt. Dieser Vorgang kann sehr zeitintensiv sein und zu Systemfehlern führen.\\n'webEdition-externe Dateien/Verzeichnisse sichern' ausgewählt lassen?";
$l_backup["extern_backup_question_imp"] = "Sie haben 'webEdition-externe Dateien/Verzeichnisse wiederherstellen' ausgewählt. Diese Auswahl kann sehr zeitintensiv sein und zu Systemfehlern führen. Trotzdem fortfahren?";
$l_backup["extern_backup_question_imp_all"] = "Sie haben 'Alle auswählen' ausgewählt. Damit wird automatisch 'webEdition-externe Dateien/Verzeichnisse wiederherstellen' mit ausgewählt. Dieser Vorgang kann sehr zeitintensiv sein und zu Systemfehlern führen.\\n'webEdition-externe Dateien/Verzeichnisse wiederherstellen' ausgewählt lassen?";
$l_backup["nothing_selected_fromlist"] = "Bitte wählen Sie eine Backup-Datei aus der Liste!";
$l_backup["export_workflow_data"] = "Workflowdaten sichern";
$l_backup["export_todo_data"] = "Todo/Messaging Daten sichern";
$l_backup["import_workflow_data"] = "Workflowdaten wiederherstellen";
$l_backup["import_todo_data"] = "Todo/Messaging Daten wiederherstellen";
$l_backup["import_check_all"] = "Alle auswählen";
$l_backup["export_check_all"] = "Alle auswählen";
$l_backup["import_shop_dep"] = "Sie haben 'Shopdaten wiederherstellen' ausgewählt. Der Shop braucht die Kundendaten um richtig zu funktionieren und deswegen wird 'Kundendaten sichern' automatisch markiert.";
$l_backup["export_shop_dep"] = "Sie haben 'Shopdaten sichern' ausgewählt. Das Shop Modul braucht die Kundendaten um richtig zu funktionieren und deswegen wird 'Kundendaten sichern' automatisch markiert.";
$l_backup["import_workflow_dep"] = "Sie haben 'Workflow wiederherstellen' ausgewählt. Das Workflow braucht die Dokumente und Benutzerdaten um richtig zu funktionieren und deswegen wird 'Dokumente und Vorlage wiederherstellen' und 'Benutzerdaten wiederherstellen' automatisch markiert.";
$l_backup["export_workflow_dep"] = "Sie haben 'Workflow sichern' ausgewählt. Das Workflow braucht die Dokumente und Benutzerdaten um richtig zu funktionieren und deswegen wird 'Dokumente und Vorlage sichern' und 'Benutzerdaten sichern' automatisch markiert.";
$l_backup["import_todo_dep"] = "Sie haben 'Todo/Messaging wiederherstellen' ausgewählt. Das Todo/Mess. braucht die Benutzerdaten um richtig zu funktionieren und deswegen wird 'Benutzerdaten wiederherstellen' automatisch markiert.";
$l_backup["export_todo_dep"] = "Sie haben 'Todo/Messaging sichern' ausgewählt. Das Todo/Messaging braucht die Benutzerdaten um richtig zu funktionieren und deswegen wird 'Benutzerdaten sichern' automatisch markiert.";
$l_backup["export_newsletter_data"] = "Newsletterdaten sichern";
$l_backup["import_newsletter_data"] = "Newsletterdaten wiederherstellen";
$l_backup["export_newsletter_dep"] = "Sie haben 'Newsletterdaten sichern' ausgewählt. Der Newsletter braucht die Dokumente, Objekte und die Kundendaten um richtig zu funktionieren und deswegen wird 'Dokumente und Vorlage sichern', 'Objekte und Klasse sichern' und 'Kundendaten sichern' automatisch markiert.";
$l_backup["import_newsletter_dep"] = "Sie haben 'Newsletterdaten wiederherstellen' ausgewählt. Der Newsletter braucht die Dokumente, Objekte und die Kundendaten um richtig zu funktionieren und deswegen wird 'Dokumente und Vorlage wiederherstellen', 'Objekte und Klasse wiederherstellen' und 'Kundendaten wiederherstellen' automatisch markiert.";
$l_backup["warning"] = "Warnung";
$l_backup["error"] = "Fehler";
$l_backup["export_temporary_data"] = "Temporäre Dateien sichern";
$l_backup["import_temporary_data"] = "Temporäre Dateien wiederherstellen";
$l_backup["export_banner_data"] = "Bannerdaten sichern";
$l_backup["import_banner_data"] = "Bannerdaten wiederherstellen";
$l_backup["export_prefs"] = "Einstellungen sichern";
$l_backup["import_prefs"] = "Einstellungen wiederherstellen";
$l_backup["export_links"] = "Links sichern";
$l_backup["import_links"] = "Links wiederherstellen";
$l_backup["export_indexes"] = "Indizes sichern";
$l_backup["import_indexes"] = "Indizes wiederherstellen";
$l_backup["filename"] = "Dateiname";
$l_backup["compress"] = "Komprimieren";
$l_backup["decompress"] = "Dekomprimieren";
$l_backup["option"] = "Backup-Optionen";
$l_backup["filename_compression"] = "Geben Sie hier der Ziel-Backup-Datei einen Namen. Sie können auch die Dateikompression aktivieren. Die Backup-Datei wird dann mit gzip komprimiert und wird die Dateiendung .gz erhalten. Dieser Vorgang kann einige Minuten dauern!<br>Wenn das Backup nicht erfolgreich ist, ändern Sie bitte die Einstellungen.";
$l_backup["export_core_data"] = "Dokumente und Vorlagen sichern";
$l_backup["import_core_data"] = "Dokumente und Vorlagen wiederherstellen";
$l_backup["export_object_data"] = "Objekte und Klassen sichern";
$l_backup["import_object_data"] = "Objekte und Klassen wiederherstellen";
$l_backup["export_binary_data"] = "Binarydaten (Bilder, PDFs, ...) sichern";
$l_backup["import_binary_data"] = "Binarydaten (Bilder, PDFs, ...) wiederherstellen";
$l_backup["export_schedule_data"] = "Scheduledaten sichern";
$l_backup["import_schedule_data"] = "Scheduledaten wiederherstellen";
$l_backup["export_settings_data"] = "Einstellungen sichern";
$l_backup["import_settings_data"] = "Einstellungen wiederherstellen";
$l_backup["export_extern_data"] = "webEdition-externe Dateien/Verzeichnisse sichern";
$l_backup["import_extern_data"] = "webEdition-externe Dateien/Verzeichnisse wiederherstellen";
$l_backup["export_binary_dep"] = "Sie haben 'Binarydaten sichern' ausgewählt. Um richtig zu funktionieren, benötigen die Binarydaten auch die Dokumente. Deswegen wird 'Dokumente und Vorlage sichern' automatisch markiert.";
$l_backup["import_binary_dep"] = "Sie haben 'Binarydaten wiederherstellen' ausgewählt. Um richtig zu funktionieren, benötigen die Binarydaten auch die Dokumente. Deswegen wird 'Dokumente und Vorlage wiederherstellen' automatisch markiert.";
$l_backup["export_schedule_dep"]="Sie haben 'Scheduledaten sichern' ausgewählt. Um richtig zu funktionieren, benötigen die Scheduledaten auch die Dokumente und die Objekte. Deswegen wird 'Dokumente und Vorlage sichern' und 'Objekte und Klassen sichern' automatisch markiert.";
$l_backup["import_schedule_dep"]="Sie haben 'Scheduledaten wiederherstellen' ausgewählt. Um richtig zu funktionieren, benötigen die Scheduledaten auch die Dokumente und die Objekte. Deswegen wird 'Dokumente und Vorlage wiederherstellen' und 'Objekte und Klassen wiederherstellen' automatisch markiert.";
$l_backup["export_temporary_dep"] = "Sie haben 'Temporäre Dateien sichern' ausgewählt. Um richtig zu funktionieren, benötigen die Temporäre Dateien auch die Dokumente. Deswegen wird 'Dokumente und Vorlage sichern' automatisch markiert.";
$l_backup["import_temporary_dep"] = "Sie haben 'Temporäre Dateien wiederherstellen' ausgewählt. Um richtig zu funktionieren, benötigen die 'Temporäre Dateien auch die Dokumente. Deswegen wird 'Dokumente und Vorlage wiederherstellen' automatisch markiert.";
$l_backup["compress_file"] = "Datei komprimieren";
$l_backup["export_options"] = "Wählen Sie die zu sichernden Daten aus.";
$l_backup["import_options"] = "Wählen Sie die wiederherzustellenden Daten aus.";
$l_backup["extern_exp"] = "Achtung! Diese Option ist sehr zeitintensiv und kann zu Systemfehlern führen";
$l_backup["unselect_dep2"] = "Sie haben '%s' abgewählt. Folgende Optionen werden automatisch abgewählt:";
$l_backup["unselect_dep3"] = "Sie können trotzdem die nicht selektierten Optionen auswählen.";
$l_backup["gzip"] = "gzip";
$l_backup["zip"] = "zip";
$l_backup["bzip"] = "bzip";
$l_backup["none"] = "kein";
$l_backup["cannot_split_file"] = "Kann die Datei '%s' nicht zur Wiederherstellung vorbereiten!";
$l_backup["cannot_split_file_ziped"] = "Die Datei wurde mit einer nicht unterstützen Komprimierungsmethode komprimiert.";
$l_backup["export_banner_dep"]="Sie haben 'Bannerdaten sichern' ausgewählt. Um richtig zu funktionieren, benötigen die Bannerdaten auch die Dokumente. Deswegen wird 'Dokumente und Vorlage sichern' automatisch markiert.";
$l_backup["import_banner_dep"]="Sie haben 'Bannerdaten wiederherstellen' ausgewählt. Um richtig zu funktionieren, benötigen die Bannerdaten auch die Dokumente. Deswegen wird 'Dokumente und Vorlage wiederherstellen' automatisch markiert.";

$l_backup["delold_notice"] = "Es wird empfohlen, die vorhandenen Dateien vorher zu löschen.<br>Möchten Sie dies jetzt tun?";
$l_backup["delold_confirm"] = "Sind Sie sicher, dass Sie alle Dateien vom Server löschen möchten?";
$l_backup["delete_entry"] = "Lösche %s";
$l_backup["delete_nok"] = "Die Dateien kann nicht gelöscht werden!";
$l_backup["nothing_to_delete"] = "Es gibt nichts zu löschen!";

$l_backup["files_not_deleted"] = "Eine oder mehrere der zu löschende Dateien konnten nicht vollständig vom Server gelöscht werden! Möglicherweise sind sie schreibgeschützt. Löschen Sie die Dateien manuell. Folgende Dateien sind davon betroffen:";

$l_backup["delete_old_files"]="Lösche alte Dateien...";

$l_backup["export_configuration_data"]="Konfiguration sichern";
$l_backup["import_configuration_data"]="Konfiguration wiederherstellen";

$l_backup["export_export_data"] = "Exportdaten sichern";
$l_backup["import_export_data"] = "Exportdaten wiederherstellen";

$l_backup["export_versions_data"] = "Versionierungsdaten sichern";
$l_backup["export_versions_binarys_data"] = "Versions-Binary-Dateien sichern";
$l_backup["import_versions_data"] = "Versionierungsdaten wiederherstellen";
$l_backup["import_versions_binarys_data"] = "Vorhandene Versions-Binary-Dateien wiederherstellen";

$l_backup["export_versions_dep"] = "Sie haben 'Versionierungsdaten sichern' ausgewählt. Um richtig zu funktionieren, benötigen die Versionen auch die zugehörigen Dokumente, Objekte und Binärdateien. Deswegen wird 'Dokumente und Vorlage sichern', 'Objekte und Klassen sichern' und 'Binärdateien sichern' automatisch markiert.";
$l_backup["import_versions_dep"] = "Sie haben 'Versionierungsdaten wiederherstellen' ausgewählt. Um richtig zu funktionieren, benötigen die Versionen auch zugehörigen Dokumente, Objekte und Binärdateien. Deswegen wird 'Dokumente und Vorlage wiederherstellen', 'Objekte und Klassen wiederherstellen' und 'Binärdateien wiederherstellen' automatisch markiert.";

$l_backup["export_versions_binarys_dep"] = "Sie haben 'Versions-Binary-Dateien sichern' ausgewählt. Um richtig zu funktionieren, benötigen die Versionen auch die zugehörigen Dokumente, Objekte und Versionierungsdaten. Deswegen wird 'Dokumente und Vorlage sichern', 'Objekte und Klassen sichern' und 'Versionierungsdaten sichern' automatisch markiert.";
$l_backup["import_versions_binarys_dep"] = "Sie haben 'Versions-Binary-Dateien wiederherstellen' ausgewählt. Um richtig zu funktionieren, benötigen die Versionen auch zugehörigen Dokumente, Objekte und Versionierungsdaten. Deswegen wird 'Dokumente und Vorlage wiederherstellen', 'Objekte und Klassen wiederherstellen' und 'Versionierungsdaten wiederherstellen' automatisch markiert.";

$l_backup["del_backup_confirm"] = "Möchten Sie ausgewählte Backup-Datei löschen?";
$l_backup["name_notok"] = "Der Dateiname ist nicht korrekt!";
$l_backup["backup_deleted"] = "Die Backup-Datei %s wurde gelöscht";
$l_backup['error_delete'] = "Backup-Datei konnte nicht gelöscht werden. Bitte löschen Sie die Datei über Ihr FTP-Programm aus dem Ordner /webEdition/we_backup";

$l_backup['core_info'] = 'Alle Vorlagen und Dokumente.';
$l_backup['object_info'] = 'Objekte und Klassen des DB/Objekt Moduls.';
$l_backup['binary_info'] = 'Binärdateien von Bildern, PDFs und anderen Dokumenten.';
$l_backup['user_info'] = 'Benutzer und Zugangsdaten der Benutzerverwaltung.';
$l_backup['customer_info'] = 'Kunden und Zugangsdaten der Kundenverwaltung.';
$l_backup['shop_info'] = 'Bestellungen des Shop Moduls.';
$l_backup['workflow_info'] = 'Daten des Workflow Moduls.';
$l_backup['todo_info'] = 'Mitteilungen und Aufgaben des ToDo/Messaging Moduls.';
$l_backup['newsletter_info'] = 'Daten des Newsletter Moduls.';
$l_backup['banner_info'] = 'Banner und Statistiken des Banner Moduls.';
$l_backup['schedule_info'] = 'Zeitgesteuerte Aktionen des Scheduler Moduls.';
$l_backup['settings_info'] = 'webEdition Programmeinstellungen.';
$l_backup['temporary_info'] = 'Noch nicht veröffentlichte Dokumente und Objekte bzw. noch nicht veröffentlichte Änderungen.';
$l_backup['export_info'] = 'Daten des Export Moduls.';
$l_backup['glossary_info'] = 'Daten des Glossars.';
$l_backup['versions_info'] = 'Daten der Versionierung.';
$l_backup['versions_binarys_info'] = 'Achtung! Diese Option kann sehr zeit- und speicherintensiv sein da der Ordner "'.VERSION_DIR.'" unter Umständen sehr groß sein kann. Daher wird empfohlen diesen Ordner manuell zu sichern.';

$l_backup["export_voting_data"] = "Votingdaten sichern";
$l_backup["import_voting_data"] = "Votingdaten wiederherstellen";
$l_backup['voting_info'] = 'Daten aus dem Voting Modul.';

$l_backup['we_backups'] = 'webEdition Backups';
$l_backup['other_files'] = 'Sonstige Datei';

$l_backup['filename_info'] = 'Geben Sie hier der Ziel-Backup-Datei einen Namen.';
$l_backup['backup_log_exp'] = 'Das Logbuch wird in /webEdition/we_backup/tmp/lastlog.php erstellt';
$l_backup['export_backup_log'] = 'Logbuch erstellen';

$l_backup['download_file'] = 'Datei herunterladen';

$l_backup['import_file_found'] = 'Hier handelt es sich um eine Import-Datei. Nutzen Sie bitte die Option \"Import/Export\" aus dem Datei-Menü um die Datei zu importieren.';
$l_backup['customer_import_file_found'] = 'Hier handelt es sich um eine Import-Datei aus der Kundenverwaltung. Nutzen Sie bitte die Option \"Import/Export\" aus der Kundenverwaltung (PRO) um die Datei zu importieren.';
$l_backup['import_file_found_question'] = 'Möchten Sie gleich das aktuelle Fenster schließen und einen Import-Wizard für den webEditon XML-Import starten?';
$l_backup['format_unknown'] = 'Das Format der Datei ist unbekannt!';
$l_backup['upload_failed'] = 'Die Datei kann nicht hochgeladen werden! Prüfen Sie bitte ob die Größe der Datei %s überschreitet';
$l_backup['file_missing'] = 'Die Backup-Datei fehlt!';
$l_backup['recover_option'] = 'Wiederherstellen-Optionen';

$l_backup['no_resource'] = 'Kritischer Fehler: Nicht genügend freie Ressourcen, um das Backup abzuschließen!';
$l_backup['error_compressing_backup'] = 'Bei der Komprimierung ist ein Fehler aufgetreten, das Backup konnte nicht abgeschlossen werden!';
$l_backup['error_timeout'] = 'Bei der Erstellung des Backup ist ein timeout aufgetreten, das Backup konnte nicht abgeschlossen werden!';

$l_backup["export_spellchecker_data"] = "Daten der Rechtschreibprüfung sichern";
$l_backup["import_spellchecker_data"] = "Daten der Rechtschreibprüfung wiederherstellen";
$l_backup['spellchecker_info'] = 'Daten der Rechtschreibprüfung: Einstellungen, allgemeine und persönliche Wörterbücher';

$l_backup["export_banner_data"] = "Bannerdaten sichern";
$l_backup["import_banner_data"] = "Bannerdaten wiederherstellen";

$l_backup["export_glossary_data"] = "Glossardaten sichern";
$l_backup["import_glossary_data"] = "Glossardaten wiederherstellen";

$l_backup["protect"] = "Die Backup-Datei schützen";
$l_backup["protect_txt"] = "Um die Backup-Datei von unrechtmäßigem Herunterladen zu schützen, wird zusätzlicher PHP-Code in die Backup-Datei eingefügt und die PHP-Datei-Erweiterung verwendet. Diese Schutz benötigt beim Import zusätzlichen Speicherplatz!";

$l_backup["recover_backup_unsaved_changes"] = "Einige geöffnete Dateien haben noch ungespeicherte Änderungen. Bitte überprüfen Sie diese, bevor Sie fortfahren.";
$l_backup["file_not_readable"] = "Die Backup-Datei ist nicht lesbar. Bitte überprüfen Sie die Berechtigungen.";

$l_backup["tools_import_desc"] = "Hier können Sie die Daten der webEdition-Tools wiederhestellen. Wählen Sie bitte die gewünschte Tools aus.";
$l_backup["tools_export_desc"] = "Hier können Sie die Daten der webEdition-Tools sichern. Wählen Sie bitte die gewünschte Tools aus.";

$l_backup['ftp_hint'] = "Achtung! Benutzen Sie den Binary-Modus beim Download per FTP, wenn die Backup-Datei mit zip komprimiert ist! Ein 	Download im ASCII-Modus zerstört die Datei, so dass sie nicht wieder hergestellt werden kann!";

?>