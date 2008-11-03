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
 * Language file: backup.inc.php
 * Provides language strings.
 * Language: Deutsch
 */
$l_backup["save_not_checked"] = "Sie haben noch nicht ausgew�hlt, wohin die Backup-Datei gespeichert werden soll!";
$l_backup["wizard_title"] = "Backup wiederherstellen Wizard";
$l_backup["wizard_title_export"] = "Backup Wizard";
$l_backup["save_before"] = "W�hrend des Wiederherstellens der Backup-Datei werden die vorhandenen Daten gel�scht! Es wird daher empfohlen, die vorhandenen Daten vorher zu speichern.";
$l_backup["save_question"] = "M�chten Sie dies jetzt tun?";
$l_backup["step1"] = "Schritt 1/4 - Vorhandene Daten speichern";
$l_backup["step2"] = "Schritt 2/4 - Datenquelle ausw�hlen";
$l_backup["step3"] = "Schritt 3/4 - Gesicherte Daten wiederherstellen";
$l_backup["step4"] = "Schritt 4/4 - Wiederherstellung beendet";
$l_backup["extern"] = "webEdition-externe Dateien/Verzeichnisse wiederherstellen";
$l_backup["settings"] = "Einstellungen wiederherstellen";
$l_backup["rebuild"] = "Automatischer Rebuild";
$l_backup["select_upload_file"] = "Wiederherstellung aus lokaler Datei hochladen";
$l_backup["select_server_file"] = "W�hlen Sie die gew�nschte Backup-Datei aus.";
$l_backup["finished_success"] = "Der Import der Backup-Daten wurde erfolgreich beendet.";
$l_backup["finished_fail"] = "Der Import der Backup-Daten wurde nicht erfolgreich beendet.";
$l_backup["question_taketime"] = "Der Export dauert einige Zeit.";
$l_backup["question_wait"] = "Bitte haben Sie etwas Geduld!";
$l_backup["export_title"] = "Backup erstellen";
$l_backup["finished"] = "Beendet";
$l_backup["extern_files_size"] = "Dieser Vorgang kann einige Minuten dauern. Es werden unter Umst�nden mehrere Dateien angelegt, da die Datenbankeinstellung auf eine maximale Dateigr��e von %.1f MB (%s Byte) beschr�nkt ist.";
$l_backup["extern_files_question"] = "webEdition-externe Dateien/Verzeichnisse sichern";
$l_backup["export_location"] = "Bitte w�hlen Sie aus, wo die Backup-Datei gespeichert werden soll. Wird die Datei auf dem Server gespeichert, finden Sie diese unter '/webEdition/we_backup'.";
$l_backup["export_location_server"] = "Auf dem Server";
$l_backup["export_location_send"] = "Auf Ihrer lokalen Festplatte";
$l_backup["can_not_open_file"] = "Die Datei '%s' kann nicht ge�ffnet werden.";
$l_backup["too_big_file"] = "Die Datei '%s' kann nicht gespeichert werden, da die maximale Dateigr��e �berschritten wurde.";
$l_backup["cannot_save_tmpfile"] = " Tempor�re Datei kann nicht angelegt werden! Pr�fen Sie bitte, ob Sie die Rechte haben in %s zu schreiben.";
$l_backup["cannot_save_backup"] = "Die Backup-Datei kann nicht gespeichert werden.";
$l_backup["cannot_send_backup"] = " Backup kann nicht ausgef�hrt werden ";
$l_backup["finish"] = "Die Backup-Datei wurde erstellt und kann nun heruntergeladen werden.";
$l_backup["finish_error"] = " Fehler: Backup konnte nicht erfolgreich ausgef�hrt werden";
$l_backup["finish_warning"] = "Warnung: Backup wurde ausgef�hrt, m�glicherweise wurden nicht alle Dateien vollst�ndig angelegt";
$l_backup["export_step1"] = "Schritt 1/2 - Backup Parameter";
$l_backup["export_step2"] = "Schritt 2/2 - Backup beendet";
$l_backup["unspecified_error"] = "Ein unbekannter Fehler ist aufgetreten";
$l_backup["export_users_data"] = "Benutzerdaten sichern";
$l_backup["import_users_data"] = "Benutzerdaten wiederherstellen";
$l_backup["import_from_server"] = "Daten vom Server laden";
$l_backup["import_from_local"] = "Daten aus lokal gesicherter Datei laden";
$l_backup["backup_form"] = "Backup vom ";
$l_backup["nothing_selected"] = "Es wurde nichts ausgew�hlt!";
$l_backup["query_is_too_big"] = "Die Backup-Datei enth�lt eine Datei, welche nicht wiederhergestellt werden konnte, da sie gr��er als %s bytes ist!";
$l_backup["show_all"] = "Zeige alle Dateien";
$l_backup["import_customer_data"] = "Kundendaten wiederherstellen";
$l_backup["import_shop_data"] = "Shopdaten wiederherstellen";
$l_backup["export_customer_data"] = "Kundendaten sichern";
$l_backup["export_shop_data"] = "Shopdaten sichern";
$l_backup["working"] = "In Arbeit...";
$l_backup["preparing_file"] = "Daten f�rs Wiederherstellen vorbereiten...";
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
$l_backup["extern_backup_question_exp"] = "Sie haben 'webEdition-externe Dateien/Verzeichnisse sichern' ausgew�hlt. Diese Auswahl kann sehr zeitintensiv sein und zu Systemfehlern f�hren. Trotzdem fortfahren?";
$l_backup["extern_backup_question_exp_all"] = "Sie haben 'Alle ausw�hlen' ausgew�hlt. Damit wird automatisch 'webEdition-externe Dateien/Verzeichnisse sichern' mit ausgew�hlt. Dieser Vorgang kann sehr zeitintensiv sein und zu Systemfehlern f�hren.\\n'webEdition-externe Dateien/Verzeichnisse sichern' ausgew�hlt lassen?";
$l_backup["extern_backup_question_imp"] = "Sie haben 'webEdition-externe Dateien/Verzeichnisse wiederherstellen' ausgew�hlt. Diese Auswahl kann sehr zeitintensiv sein und zu Systemfehlern f�hren. Trotzdem fortfahren?";
$l_backup["extern_backup_question_imp_all"] = "Sie haben 'Alle ausw�hlen' ausgew�hlt. Damit wird automatisch 'webEdition-externe Dateien/Verzeichnisse wiederherstellen' mit ausgew�hlt. Dieser Vorgang kann sehr zeitintensiv sein und zu Systemfehlern f�hren.\\n'webEdition-externe Dateien/Verzeichnisse wiederherstellen' ausgew�hlt lassen?";
$l_backup["nothing_selected_fromlist"] = "Bitte w�hlen Sie eine Backup-Datei aus der Liste!";
$l_backup["export_workflow_data"] = "Workflowdaten sichern";
$l_backup["export_todo_data"] = "Todo/Messaging Daten sichern";
$l_backup["import_workflow_data"] = "Workflowdaten wiederherstellen";
$l_backup["import_todo_data"] = "Todo/Messaging Daten wiederherstellen";
$l_backup["import_check_all"] = "Alle ausw�hlen";
$l_backup["export_check_all"] = "Alle ausw�hlen";
$l_backup["import_shop_dep"] = "Sie haben 'Shopdaten wiederherstellen' ausgew�hlt. Der Shop braucht die Kundendaten um richtig zu funktionieren und deswegen wird 'Kundendaten sichern' automatisch markiert.";
$l_backup["export_shop_dep"] = "Sie haben 'Shopdaten sichern' ausgew�hlt. Das Shop Modul braucht die Kundendaten um richtig zu funktionieren und deswegen wird 'Kundendaten sichern' automatisch markiert.";
$l_backup["import_workflow_dep"] = "Sie haben 'Workflow wiederherstellen' ausgew�hlt. Das Workflow braucht die Dokumente und Benutzerdaten um richtig zu funktionieren und deswegen wird 'Dokumente und Vorlage wiederherstellen' und 'Benutzerdaten wiederherstellen' automatisch markiert.";
$l_backup["export_workflow_dep"] = "Sie haben 'Workflow sichern' ausgew�hlt. Das Workflow braucht die Dokumente und Benutzerdaten um richtig zu funktionieren und deswegen wird 'Dokumente und Vorlage sichern' und 'Benutzerdaten sichern' automatisch markiert.";
$l_backup["import_todo_dep"] = "Sie haben 'Todo/Messaging wiederherstellen' ausgew�hlt. Das Todo/Mess. braucht die Benutzerdaten um richtig zu funktionieren und deswegen wird 'Benutzerdaten wiederherstellen' automatisch markiert.";
$l_backup["export_todo_dep"] = "Sie haben 'Todo/Messaging sichern' ausgew�hlt. Das Todo/Messaging braucht die Benutzerdaten um richtig zu funktionieren und deswegen wird 'Benutzerdaten sichern' automatisch markiert.";
$l_backup["export_newsletter_data"] = "Newsletterdaten sichern";
$l_backup["import_newsletter_data"] = "Newsletterdaten wiederherstellen";
$l_backup["export_newsletter_dep"] = "Sie haben 'Newsletterdaten sichern' ausgew�hlt. Der Newsletter braucht die Dokumente, Objekte und die Kundendaten um richtig zu funktionieren und deswegen wird 'Dokumente und Vorlage sichern', 'Objekte und Klasse sichern' und 'Kundendaten sichern' automatisch markiert.";
$l_backup["import_newsletter_dep"] = "Sie haben 'Newsletterdaten wiederherstellen' ausgew�hlt. Der Newsletter braucht die Dokumente, Objekte und die Kundendaten um richtig zu funktionieren und deswegen wird 'Dokumente und Vorlage wiederherstellen', 'Objekte und Klasse wiederherstellen' und 'Kundendaten wiederherstellen' automatisch markiert.";
$l_backup["warning"] = "Warnung";
$l_backup["error"] = "Fehler";
$l_backup["export_temporary_data"] = "Tempor�re Dateien sichern";
$l_backup["import_temporary_data"] = "Tempor�re Dateien wiederherstellen";
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
$l_backup["filename_compression"] = "Geben Sie hier der Ziel-Backup-Datei einen Namen. Sie k�nnen auch die Dateikompression aktivieren. Die Backup-Datei wird dann mit gzip komprimiert und wird die Dateiendung .gz erhalten. Dieser Vorgang kann einige Minuten dauern!<br>Wenn das Backup nicht erfolgreich ist, �ndern Sie bitte die Einstellungen.";
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
$l_backup["export_binary_dep"] = "Sie haben 'Binarydaten sichern' ausgew�hlt. Um richtig zu funktionieren, ben�tigen die Binarydaten auch die Dokumente. Deswegen wird 'Dokumente und Vorlage sichern' automatisch markiert.";
$l_backup["import_binary_dep"] = "Sie haben 'Binarydaten wiederherstellen' ausgew�hlt. Um richtig zu funktionieren, ben�tigen die Binarydaten auch die Dokumente. Deswegen wird 'Dokumente und Vorlage wiederherstellen' automatisch markiert.";
$l_backup["export_schedule_dep"]="Sie haben 'Scheduledaten sichern' ausgew�hlt. Um richtig zu funktionieren, ben�tigen die Scheduledaten auch die Dokumente und die Objekte. Deswegen wird 'Dokumente und Vorlage sichern' und 'Objekte und Klassen sichern' automatisch markiert.";
$l_backup["import_schedule_dep"]="Sie haben 'Scheduledaten wiederherstellen' ausgew�hlt. Um richtig zu funktionieren, ben�tigen die Scheduledaten auch die Dokumente und die Objekte. Deswegen wird 'Dokumente und Vorlage wiederherstellen' und 'Objekte und Klassen wiederherstellen' automatisch markiert.";
$l_backup["export_temporary_dep"] = "Sie haben 'Tempor�re Dateien sichern' ausgew�hlt. Um richtig zu funktionieren, ben�tigen die Tempor�re Dateien auch die Dokumente. Deswegen wird 'Dokumente und Vorlage sichern' automatisch markiert.";
$l_backup["import_temporary_dep"] = "Sie haben 'Tempor�re Dateien wiederherstellen' ausgew�hlt. Um richtig zu funktionieren, ben�tigen die 'Tempor�re Dateien auch die Dokumente. Deswegen wird 'Dokumente und Vorlage wiederherstellen' automatisch markiert.";
$l_backup["compress_file"] = "Datei komprimieren";
$l_backup["export_options"] = "W�hlen Sie die zu sichernden Daten aus.";
$l_backup["import_options"] = "W�hlen Sie die wiederherzustellenden Daten aus.";
$l_backup["extern_exp"] = "Achtung! Diese Option ist sehr zeitintensiv und kann zu Systemfehlern f�hren";
$l_backup["unselect_dep2"] = "Sie haben '%s' abgew�hlt. Folgende Optionen werden automatisch abgew�hlt:";
$l_backup["unselect_dep3"] = "Sie k�nnen trotzdem die nicht selektierten Optionen ausw�hlen.";
$l_backup["gzip"] = "gzip";
$l_backup["zip"] = "zip";
$l_backup["bzip"] = "bzip";
$l_backup["none"] = "kein";
$l_backup["cannot_split_file"] = "Kann die Datei '%s' nicht zur Wiederherstellung vorbereiten!";
$l_backup["cannot_split_file_ziped"] = "Die Datei wurde mit einer nicht unterst�tzen Komprimierungsmethode komprimiert.";
$l_backup["export_banner_dep"]="Sie haben 'Bannerdaten sichern' ausgew�hlt. Um richtig zu funktionieren, ben�tigen die Bannerdaten auch die Dokumente. Deswegen wird 'Dokumente und Vorlage sichern' automatisch markiert.";
$l_backup["import_banner_dep"]="Sie haben 'Bannerdaten wiederherstellen' ausgew�hlt. Um richtig zu funktionieren, ben�tigen die Bannerdaten auch die Dokumente. Deswegen wird 'Dokumente und Vorlage wiederherstellen' automatisch markiert.";

$l_backup["delold_notice"] = "Es wird empfohlen, die vorhandenen Dateien vorher zu l�schen.<br>M�chten Sie dies jetzt tun?";
$l_backup["delold_confirm"] = "Sind Sie sicher, dass Sie alle Dateien vom Server l�schen m�chten?";
$l_backup["delete_entry"] = "L�sche %s";
$l_backup["delete_nok"] = "Die Dateien kann nicht gel�scht werden!";
$l_backup["nothing_to_delete"] = "Es gibt nichts zu l�schen!";

$l_backup["files_not_deleted"] = "Eine oder mehrere der zu l�schende Dateien konnten nicht vollst�ndig vom Server gel�scht werden! M�glicherweise sind sie schreibgesch�tzt. L�schen Sie die Dateien manuell. Folgende Dateien sind davon betroffen:";

$l_backup["delete_old_files"]="L�sche alte Dateien...";

$l_backup["export_configuration_data"]="Konfiguration sichern";
$l_backup["import_configuration_data"]="Konfiguration wiederherstellen";

$l_backup["export_export_data"] = "Exportdaten sichern";
$l_backup["import_export_data"] = "Exportdaten wiederherstellen";

$l_backup["export_versions_data"] = "Versionierungsdaten sichern";
$l_backup["export_versions_binarys_data"] = "Versions-Binary-Dateien sichern";
$l_backup["import_versions_data"] = "Versionierungsdaten wiederherstellen";
$l_backup["import_versions_binarys_data"] = "Vorhandene Versions-Binary-Dateien wiederherstellen";

$l_backup["export_versions_dep"] = "Sie haben 'Versionierungsdaten sichern' ausgew�hlt. Um richtig zu funktionieren, ben�tigen die Versionen auch die zugeh�rigen Dokumente, Objekte und Bin�rdateien. Deswegen wird 'Dokumente und Vorlage sichern', 'Objekte und Klassen sichern' und 'Bin�rdateien sichern' automatisch markiert.";
$l_backup["import_versions_dep"] = "Sie haben 'Versionierungsdaten wiederherstellen' ausgew�hlt. Um richtig zu funktionieren, ben�tigen die Versionen auch zugeh�rigen Dokumente, Objekte und Bin�rdateien. Deswegen wird 'Dokumente und Vorlage wiederherstellen', 'Objekte und Klassen wiederherstellen' und 'Bin�rdateien wiederherstellen' automatisch markiert.";

$l_backup["export_versions_binarys_dep"] = "Sie haben 'Versions-Binary-Dateien sichern' ausgew�hlt. Um richtig zu funktionieren, ben�tigen die Versionen auch die zugeh�rigen Dokumente, Objekte und Versionierungsdaten. Deswegen wird 'Dokumente und Vorlage sichern', 'Objekte und Klassen sichern' und 'Versionierungsdaten sichern' automatisch markiert.";
$l_backup["import_versions_binarys_dep"] = "Sie haben 'Versions-Binary-Dateien wiederherstellen' ausgew�hlt. Um richtig zu funktionieren, ben�tigen die Versionen auch zugeh�rigen Dokumente, Objekte und Versionierungsdaten. Deswegen wird 'Dokumente und Vorlage wiederherstellen', 'Objekte und Klassen wiederherstellen' und 'Versionierungsdaten wiederherstellen' automatisch markiert.";

$l_backup["del_backup_confirm"] = "M�chten Sie ausgew�hlte Backup-Datei l�schen?";
$l_backup["name_notok"] = "Der Dateiname ist nicht korrekt!";
$l_backup["backup_deleted"] = "Die Backup-Datei %s wurde gel�scht";
$l_backup['error_delete'] = "Backup-Datei konnte nicht gel�scht werden. Bitte l�schen Sie die Datei �ber Ihr FTP-Programm aus dem Ordner /webEdition/we_backup";

$l_backup['core_info'] = 'Alle Vorlagen und Dokumente.';
$l_backup['object_info'] = 'Objekte und Klassen des DB/Objekt Moduls.';
$l_backup['binary_info'] = 'Bin�rdateien von Bildern, PDFs und anderen Dokumenten.';
$l_backup['user_info'] = 'Benutzer und Zugangsdaten der Benutzerverwaltung.';
$l_backup['customer_info'] = 'Kunden und Zugangsdaten der Kundenverwaltung.';
$l_backup['shop_info'] = 'Bestellungen des Shop Moduls.';
$l_backup['workflow_info'] = 'Daten des Workflow Moduls.';
$l_backup['todo_info'] = 'Mitteilungen und Aufgaben des ToDo/Messaging Moduls.';
$l_backup['newsletter_info'] = 'Daten des Newsletter Moduls.';
$l_backup['banner_info'] = 'Banner und Statistiken des Banner Moduls.';
$l_backup['schedule_info'] = 'Zeitgesteuerte Aktionen des Scheduler Moduls.';
$l_backup['settings_info'] = 'webEdition Programmeinstellungen.';
$l_backup['temporary_info'] = 'Noch nicht ver�ffentlichte Dokumente und Objekte bzw. noch nicht ver�ffentlichte �nderungen.';
$l_backup['export_info'] = 'Daten des Export Moduls.';
$l_backup['glossary_info'] = 'Daten des Glossars.';
$l_backup['versions_info'] = 'Daten der Versionierung.';
$l_backup['versions_binarys_info'] = 'Achtung! Diese Option kann sehr zeit- und speicherintensiv sein da der Ordner "'.VERSION_DIR.'" unter Umst�nden sehr gro� sein kann. Daher wird empfohlen diesen Ordner manuell zu sichern.';

$l_backup["export_voting_data"] = "Votingdaten sichern";
$l_backup["import_voting_data"] = "Votingdaten wiederherstellen";
$l_backup['voting_info'] = 'Daten aus dem Voting Modul.';

$l_backup['we_backups'] = 'webEdition Backups';
$l_backup['other_files'] = 'Sonstige Datei';

$l_backup['filename_info'] = 'Geben Sie hier der Ziel-Backup-Datei einen Namen.';
$l_backup['backup_log_exp'] = 'Das Logbuch wird in /webEdition/we_backup/tmp/lastlog.php erstellt';
$l_backup['export_backup_log'] = 'Logbuch erstellen';

$l_backup['download_file'] = 'Datei herunterladen';

$l_backup['import_file_found'] = 'Hier handelt es sich um eine Import-Datei. Nutzen Sie bitte die Option \"Import/Export\" aus dem Datei-Men� um die Datei zu importieren.';
$l_backup['customer_import_file_found'] = 'Hier handelt es sich um eine Import-Datei aus der Kundenverwaltung. Nutzen Sie bitte die Option \"Import/Export\" aus der Kundenverwaltung (PRO) um die Datei zu importieren.';
$l_backup['import_file_found_question'] = 'M�chten Sie gleich das aktuelle Fenster schlie�en und einen Import-Wizard f�r den webEditon XML-Import starten?';
$l_backup['format_unknown'] = 'Das Format der Datei ist unbekannt!';
$l_backup['upload_failed'] = 'Die Datei kann nicht hochgeladen werden! Pr�fen Sie bitte ob die Gr��e der Datei %s �berschreitet';
$l_backup['file_missing'] = 'Die Backup-Datei fehlt!';
$l_backup['recover_option'] = 'Wiederherstellen-Optionen';

$l_backup['no_resource'] = 'Kritischer Fehler: Nicht gen�gend freie Ressourcen, um das Backup abzuschlie�en!';
$l_backup['error_compressing_backup'] = 'Bei der Komprimierung ist ein Fehler aufgetreten, das Backup konnte nicht abgeschlossen werden!';
$l_backup['error_timeout'] = 'Bei der Erstellung des Backup ist ein timeout aufgetreten, das Backup konnte nicht abgeschlossen werden!';

$l_backup["export_spellchecker_data"] = "Daten der Rechtschreibpr�fung sichern";
$l_backup["import_spellchecker_data"] = "Daten der Rechtschreibpr�fung wiederherstellen";
$l_backup['spellchecker_info'] = 'Daten der Rechtschreibpr�fung: Einstellungen, allgemeine und pers�nliche W�rterb�cher';

$l_backup["export_banner_data"] = "Bannerdaten sichern";
$l_backup["import_banner_data"] = "Bannerdaten wiederherstellen";

$l_backup["export_glossary_data"] = "Glossardaten sichern";
$l_backup["import_glossary_data"] = "Glossardaten wiederherstellen";

$l_backup["protect"] = "Die Backup-Datei sch�tzen";
$l_backup["protect_txt"] = "Um die Backup-Datei von unrechtm��igem Herunterladen zu sch�tzen, wird zus�tzlicher PHP-Code in die Backup-Datei eingef�gt und die PHP-Datei-Erweiterung verwendet. Diese Schutz ben�tigt beim Import zus�tzlichen Speicherplatz!";

$l_backup["recover_backup_unsaved_changes"] = "Einige ge�ffnete Dateien haben noch ungespeicherte �nderungen. Bitte �berpr�fen Sie diese, bevor Sie fortfahren.";
$l_backup["file_not_readable"] = "Die Backup-Datei ist nicht lesbar. Bitte �berpr�fen Sie die Berechtigungen.";

$l_backup["tools_import_desc"] = "Hier k�nnen Sie die Daten der webEdition-Tools wiederhestellen. W�hlen Sie bitte die gew�nschte Tools aus.";
$l_backup["tools_export_desc"] = "Hier k�nnen Sie die Daten der webEdition-Tools sichern. W�hlen Sie bitte die gew�nschte Tools aus.";

$l_backup['ftp_hint'] = "Achtung! Benutzen Sie den Binary-Modus beim Download per FTP, wenn die Backup-Datei mit zip komprimiert ist! Ein 	Download im ASCII-Modus zerst�rt die Datei, so dass sie nicht wieder hergestellt werden kann!";

?>