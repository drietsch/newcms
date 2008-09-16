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

$l_alert["noRightsToDelete"] = "Fehler beim L�schen von \\'%s\\'! Sie haben nicht die erforderlichen Rechte!";
$l_alert["noRightsToMove"] = "Fehler beim Verschieben von \\'%s\\'! Sie haben nicht die erforderlichen Rechte!";
$l_alert[FILE_TABLE]["in_wf_warning"] = "Bevor das Dokument in den Workflow gegeben werden kann, mu� es gespeichert werden!\\nSoll das Dokument jetzt gespeichert werden?";
if( defined("OBJECT_FILES_TABLE") ){
	$l_alert[OBJECT_FILES_TABLE]["in_wf_warning"] = "Bevor das Objekt in den Workflow gegeben werden kann, mu� es gespeichert werden!\\nSoll das Dokument jetzt gespeichert werden?";
	$l_alert[OBJECT_TABLE]["in_wf_warning"] = "Bevor die Klasse in den Workflow gegeben werden kann, mu� sie gespeichert werden!\\nSoll die Klasse jetzt gespeichert werden?";
}
$l_alert[TEMPLATES_TABLE]["in_wf_warning"] = "Bevor das Template in den Workflow gegeben werden kann, mu� es gespeichert werden!\\nSoll das Template jetzt gespeichert werden?";
$l_alert[FILE_TABLE]["not_im_ws"] = "Die Datei befindet sich nicht in Ihrem Arbeitsbereich!";
$l_alert["folder"]["not_im_ws"] = "Dieses Verzeichnis befindet sich nicht in Ihrem Arbeitsbereich!";
$l_alert[TEMPLATES_TABLE]["not_im_ws"] = "Die Vorlage befindet sich nicht in Ihrem Arbeitsbereich!";
$l_alert["required_field_alert"] = "Das Feld '%s' ist ein Pflichtfeld und mu� ausgef�llt sein!";
$l_alert["phpError"] = "webEdition kann nicht gestartet werden";
$l_alert["3timesLoginError"] = "Der LogIn ist %sx fehlgeschlagen! Bitte warten Sie %s Minuten und versuchen Sie es noch einmal!";
$l_alert["popupLoginError"] = "Das webEdition Fenster konnte nicht ge�ffnet werden!\\n\\nwebEdition kann nur gestartet werden, wenn ihr Browser keine Pop-Ups unterdr�ckt.";
$l_alert['publish_when_not_saved_message'] = "Das Dokument ist noch nicht gespeichert! M�chten Sie trotzdem ver�ffentlichen?";
$l_alert["template_in_use"] = "Die Vorlage wird benutzt und kann daher nicht entfernt werden!";
$l_alert["no_cookies"] = "Sie haben Cookies nicht aktiviert. Bitte aktivieren Sie in Ihrem Browser Cookies, damit webEdition funktioniert!";
$l_alert["doctype_hochkomma"] = "Der Name eines Dokument-Typs darf kein ' (Hochkomma) kein , (Komma) und kein \" (Anf�hrungszeichen) enthalten!";
$l_alert["thumbnail_hochkomma"] = "Der Name einer Miniaturansicht darf kein ' (Hochkomma) und kein , (Komma) enthalten!";
$l_alert["can_not_open_file"] = "Die Datei %s konnte nicht ge�ffnet werden!";
$l_alert["no_perms_title"] = "Keine Berechtigung";
$l_alert["no_perms_action"] = "Sie haben keine Berechtigung f�r diese Aktion.";
$l_alert["access_denied"] = "Zugriff verweigert!";
$l_alert["no_perms"] = "Bitte wenden Sie sich an den Eigent�mer (%s)<br>oder einen Administrator, wenn Sie Zugriff ben�tigen!";
$l_alert["temporaere_no_access"] = "Zugriff zur Zeit nicht m�glich";
$l_alert["temporaere_no_access_text"] = "Die Datei (%s) wird gerade vom Benutzer '%s' bearbeitet.";
$l_alert["file_locked_footer"]  = "Das Dokument wird gerade vom Benutzer \"%s\" bearbeitet.";
$l_alert["file_no_save_footer"] = "Sie haben nicht die erforderlichen Rechte, dieses Dokument zu speichern.";
$l_alert["login_failed"] = "Benutzername und/oder Kennwort falsch!";
$l_alert["login_failed_security"] = "webEdition konnte nicht gestartet werden!\\n\\nAus Sicherheitsgr�nden wurde der Loginvorgang abgebrochen, da die maximale Anmeldezeit �berschritten wurde!\\n\\nBitte melden Sie sich neu an.";
$l_alert["perms_no_permissions"] = "Sie haben keine Berechtigung f�r diese Aktion!\\nBitte melden Sie sich neu an!";
$l_alert["no_image"] = "Bei der ausgew�hlten Datei handelt es sich nicht um eine Grafik!";
$l_alert["delete_ok"] = "Dateien bzw. Verzeichnisse erfolgreich gel�scht!";
$l_alert["delete_cache_ok"] = "Cache erfolgreich gel�scht!";
$l_alert["nothing_to_delete"] = "Es wurde nichts zum L�schen ausgew�hlt!";
$l_alert["no_new"]["objectFile"] = "Sie d�rfen keine neuen Objekte erstellen, da Ihnen entweder die Rechte fehlen<br>oder es keine Klasse gibt, in welcher einer Ihrer Arbeitsbereiche g�ltig ist!";
$l_alert["delete"] = "Ausgew�hlte Eintr�ge l�schen?\\nSind Sie sicher?";
$l_alert["delete_cache"] = "Cache zu den ausgew�hlten Eintr�gen l�schen?\\nSind Sie sicher?";
$l_alert["delete_folder"] = "Ausgew�hltes Verzeichnis l�schen?\\nBedenken Sie, dass bei einem Verzeichnis alle darin enthaltenen Dokumente und Verzeichnisse automatisch mit gel�scht werden!\\nSind Sie sicher?";
$l_alert["delete_nok_error"] = "Die Datei '%s' kann nicht gel�scht werden.";
$l_alert["delete_nok_file"] = "Die Datei '%s' kann nicht gel�scht werden.\\nM�glicherweise ist die Datei schreibgesch�tzt.";
$l_alert["delete_nok_folder"] = "Das Verzeichnis '%s' kann nicht gel�scht werden.\\nM�glicherweise ist das Verzeichnis schreibgesch�tzt.";
$l_alert["delete_nok_noexist"] = "Diese Datei '%s' existiert nicht!";
$l_alert["noResourceTitle"] = "Kein Dokument bzw. Verzeichnis!";
$l_alert["noResource"] = "Das Dokument bzw. Verzeichnis existiert nicht!";
$l_alert["move_exit_open_docs_question"] = "Vor dem Verschieben m�ssen alle %s geschlossen werden.\\nWenn Sie fortfahren, werden die folgenden %s geschlossen, ungespeicherte �nderungen gehen dabei verloren.\\n\\n";
$l_alert["move_exit_open_docs_continue"] = "Fortfahren?";
$l_alert["move"] = "Ausgew�hlte Eintr�ge verschieben?\\nSind Sie sicher?";
$l_alert["move_ok"] = "Dateien wurden erfolgreich verschoben!";
$l_alert["move_duplicate"] = "Gleichnamige Dateien im Zielverzeichnis vorhanden.\\nDie Dateien konnten nicht verschoben werden.";
$l_alert["move_nofolder"] = "Die ausgew�hlten Dateien konnten nicht verschoben werden.\\nEs k�nnen keine Verzeichnisse verschoben werden.";
$l_alert["move_onlysametype"] = "Die ausgew�hlten Dateien konnten nicht verschoben werden.\\nObjekte k�nnen nur innerhalb des eigenen Klassenverzeichnisses verschoben werden.";
$l_alert["move_no_dir"] = "Es wurde kein Zielverzeichnis ausgew�hlt.";
$l_alert["nothing_to_move"] = "Es wurde nichts zum Verschieben ausgew�hlt.";
$l_alert["document_move_warning"] = "Nach dem verschieben von Dokumenten ist ein Rebuild erforderlich.<br />M�chten Sie diesen jetzt durchf�hren?";
$l_alert["move_of_files_failed"] = "Eine oder mehrere der zu verschiebenden Dateien konnten nicht verschoben werden! Verschieben Sie diese Dateien manuell.\\n Folgende Dateien sind davon betroffen:\\n%s";
$l_alert["template_save_warning"] = "Diese Vorlage wird von %s ver�ffentlichten Dokumenten benutzt. Sollen diese Dokumente neu gespeichert werden?<br>ACHTUNG bei vielen Dokumenten kann das sehr lange dauern!";
$l_alert["template_save_warning1"] = "Diese Vorlage wird von einem ver�ffentlichten Dokument benutzt. Soll dieses Dokument neu gespeichert werden?";
$l_alert["template_save_warning2"] = "Diese Vorlage wird von anderen Vorlagen und Dokumenten benutzt. Sollen diese neu gespeichert werden?";
$l_alert["thumbnail_exists"] = "Diese Miniaturansicht ist bereits vorhanden!";
$l_alert["thumbnail_not_exists"] = "Diese Miniaturansicht ist nicht vorhanden!";
$l_alert["doctype_exists"] = "Dieser Dokument-Typ ist bereits vorhanden!";
$l_alert["doctype_empty"] = "Sie haben noch keinen Namen eingegeben!";
$l_alert["delete_cat"] = "M�chten Sie die ausgew�hlte Kategorie wirklich l�schen?";
$l_alert["delete_cat_used"] = "Diese Kategorie wird schon benutzt und kann daher nicht gel�scht werden!";
$l_alert["cat_exists"] = "Die Kategorie ist bereits vorhanden!";
$l_alert["cat_changed"] = "Diese Kategorie wird schon benutzt! Wenn die Kategorie in Dokumenten angezeigt wird, dann m�ssen Sie diese Dokumente neu speichern!\\nSoll die Kategorie trotzdem ge�ndert werden?";
$l_alert["max_name_cat"] = "Der Name der Kategorie darf maximal 32 Zeichen lang sein!";
$l_alert["not_entered_cat"] = "Sie haben keinen Namen der Kategorie eingegeben!";
$l_alert["cat_new_name"] = "Bitte geben Sie den neuen Namen der Kategorie ein!";
$l_alert["delete_recipient"] = "M�chten Sie die ausgew�hlte E-Mail-Adresse wirklich l�schen?";
$l_alert["recipient_exists"] = "Die E-Mail-Adresse ist bereits vorhanden!";
$l_alert["input_name"] = "Bitte geben Sie eine neue E-Mail-Adresse ein!";
$l_alert['input_file_name'] = "Bitte geben Sie einen Dateinamen an.";
$l_alert["max_name_recipient"] = "Die E-Mail-Adresse darf maximal 255 Zeichen lang sein!";
$l_alert["not_entered_recipient"] = "Sie haben keine E-Mail-Adresse eingegeben!";
$l_alert["recipient_new_name"] = "E-Mail-Adresse �ndern!";
$l_alert["we_backup_import_upload_err"] = "Es gab einen Fehler beim Hochladen der Backup-Datei! Die maximal erlaubte Dateigr�sse f�r Uploads betr�gt %s. Wenn Ihre Backup-Datei gr�sser ist, dann kopieren Sie diese per FTP in das Verzeichnis webEdition/we_backup und w�hlen '".$l_backup["import_from_server"]."'!";
$l_alert["rebuild_nodocs"] = "Es gibt keine Dokumente, welche den ausgew�hlten Kriterien entsprechen!";
$l_alert["we_name_not_allowed"] = "Die Namen 'we' und 'webEdition' werden von webEdition selbst benutzt und d�rfen deshalb nicht verwendet werden!";
$l_alert["we_filename_empty"] = "Sie haben noch keinen Dateinamen f�r dieses Dokument bzw. Verzeichnis eingegeben!";
$l_alert["exit_multi_doc_question"] = "Einige ge�ffnete Dokumente enthalten noch ungespeicherte �nderungen. Wenn Sie fortfahren, werden diese �nderungen verworfen. Wollen Sie fortfahren und alle ungespeicherten �nderungen verwerfen?";
$l_alert["exit_doc_question_".FILE_TABLE] = "Es scheint, als ob Sie das Dokument ver�ndert haben.<br>M�chten Sie Ihre &Auml;nderungen speichern?";
$l_alert["exit_doc_question_".TEMPLATES_TABLE] = "Es scheint, als ob Sie die Vorlage ver�ndert haben.<br>M�chten Sie Ihre &Auml;nderungen speichern?";
if( defined("OBJECT_TABLE") ){
	$l_alert["exit_doc_question_".OBJECT_TABLE] = "Es scheint, als ob Sie die Klasse ver�ndert haben.<br>M�chten Sie Ihre &Auml;nderungen speichern?";
	$l_alert["exit_doc_question_".OBJECT_FILES_TABLE] = "Es scheint, als ob Sie das Objekt ver�ndert haben.<br>M�chten Sie Ihre &Auml;nderungen speichern?";
}
$l_alert["deleteTempl_notok_used"] = "Die Aktion konnte nicht ausgef�hrt werden, da eine oder mehrere zu l�schende Vorlagen schon benutzt werden!";
$l_alert["deleteClass_notok_used"] = "Die Aktion konnte nicht ausgef�hrt werden, da eine oder mehrere zu l�schende Klassen schon benutzt werden!";
$l_alert["delete_notok"] = "Es gab einen Fehler beim L�schen!";
$l_alert["nothing_to_save"] = "Die Speicherfunktion ist im Moment nicht durchf�hrbar!";
$l_alert["nothing_to_publish"] = "Ein Ver�ffentlichen ist im Moment nicht m�glich!";
$l_alert["we_filename_notValid"] = "Der eingegebene Dateiname ist nicht g�ltig!\\nErlaubte Zeichen sind Buchstaben von a bis z (Gro�- oder Kleinschreibung), Zahlen, Unterstrich (_), Minus (-) und Punkt (.).";
$l_alert["empty_image_to_save"] = "Gew�hlte Grafik ist leer.\\nTrotzdem weitermachen?";
$l_alert["path_exists"] = "Das Dokument bzw. Verzeichnis %s konnte nicht gespeichert werden, da es bereits ein anderes Dokument an dieser Stelle gibt!";
$l_alert["folder_not_empty"] = "Da eines oder mehrere der zu l�schende Verzeichnisse nicht ganz leer waren, konnten Sie nicht vollst�ndig vom Server gel�scht werden! L�schen Sie die Dateien manuell.\\n Folgende Verzeichnisse sind davon betroffen:\\n%s";
$l_alert["name_nok"] = "Namen d�rfen die Zeichen '<' und '>' nicht erhalten!";
$l_alert["found_in_workflow"] = "Ein oder mehrere zu l�schende Eintr�ge befinden sich zur Zeit im Workflow! M�chten Sie diese Eintr�ge aus dem Workflow entfernen?";
$l_alert["import_we_dirs"] = "Sie versuchen einen Import von einem, mit webEdition verwaltetem Verzeichnis zu machen!\\nDiese Verzeichnisse sind gesch�tzt und deswegen es ist nicht m�glich von ihnen zu importieren!";
$l_alert["wrong_file"]["image/*"] = "Die Datei konnte nicht angelegt werden. Entweder handelt es sich nicht um eine Grafik oder es steht nicht ausreichend Speicherplatz (Webspace) zur Verf�gung!";
$l_alert["wrong_file"]["application/x-shockwave-flash"] = "Die Datei konnte nicht angelegt werden. Entweder handelt es sich um keinen Flash-Datei oder ihr Speicherplatz (Festplatte) ist ersch�pft!";
$l_alert["wrong_file"]["video/quicktime"] = "Die Datei konnte nicht angelegt werden. Entweder handelt es sich um keinen Quicktime-Datei oder ihr Speicherplatz (Festplatte) ist ersch�pft!";
$l_alert["no_file_selected"] = "Sie haben keine Datei zum Hochladen ausgew�hlt!";
$l_alert["browser_crashed"] = "Das Fenster konnte nicht ge�ffnet werden, da Ihr Browser einen Fehler verursacht hat!  Bitte sichern Sie Ihre Arbeit und starten Ihren Browser neu.";
$l_alert["copy_folders_no_id"] = "Das aktuelle Verzeichnis mu� zuerst gespeichert werden!";
$l_alert["copy_folder_not_valid"] =  "Das gleiche Verzeichnis oder eins der Elternverzeichnisse kann nicht kopiert werden!";
$l_alert['no_views']['headline']    = 'Achtung';
$l_alert['no_views']['description'] = 'F�r dieses Dokument ist keine Ansicht verf�gbar.';
$l_alert['navigation']['last_document']  = 'Sie befinden sich auf dem letzten Dokument.';
$l_alert['navigation']['first_document'] = 'Sie befinden sich auf dem ersten Dokument.';
$l_alert['navigation']['doc_not_found']  = 'Could not find matching document.';
$l_alert['navigation']['no_entry']       = 'Kein Eintrag in der History vorhanden.';
$l_alert['navigation']['no_open_document'] = 'Es ist kein Dokument ge�ffnet.';
$l_alert['delete_single']['confirm_delete']  = 'Soll dieses Dokument wirklich gel�scht werden?';
$l_alert['delete_single']['no_delete']       = 'Die Datei konnte nicht gel�scht werden.';
$l_alert['delete_single']['return_to_start'] = 'Die Datei wurde erfolgreich gel�scht.\\nZur�ck zum seeMode Startdokument.';
$l_alert['move_single']['return_to_start'] = 'Die Datei wurde erfolgreich verschoben.\\nZur�ck zum seeMode Startdokument.';
$l_alert['move_single']['no_delete'] = 'Die Datei konnte nicht verschoben werden.';
$l_alert['cockpit_not_activated'] = 'Die Aktion konnte nicht ausgef�hrt werden, da das Cockpit nicht aktiviert ist.';
$l_alert['cockpit_reset_settings'] = 'Sollen die aktuellen Cockpit Einstellungen gesl�scht werden und die Standard-Einstellungen wiederhergestellt werden?';
$l_alert['save_error_fields_value_not_valid'] = 'Die markierten Felder enthalten keine g�ltigen Werte.\\nBitte tragen Sie g�ltige Werte ein.';

$l_alert['eplugin_exit_doc'] = "Die Verbindung zwischen webEdition und dem externen Editor wird beim Schlie�en des Dokuments getrennt und die Inhalte werden nicht mehr synchronisiert.\\nM�chten Sie das Dokument schlie�en?";

$l_alert['delete_workspace_user'] = "Das Verzeichnis %s kann nicht gel�scht werden! Es ist als Arbeitsbereich f�r folgende Benutzer bzw. Gruppen definiert:\\n%s";
$l_alert['delete_workspace_user_r'] = "Das Verzeichnis %s kann nicht gel�scht werden! Innerhalb des Verzeichnisses befinden sich weitere Verzeichnisse, welche als Arbeitsbereich f�r folgende Benutzer bzw. Gruppen definiert sind:\\n%s";
$l_alert['delete_workspace_object'] = "Das Verzeichnis %s kann nicht gel�scht werden. Es ist als Arbeitsbereich in folgenden Objekten definiert:\\n%s";
$l_alert['delete_workspace_object_r'] = "Das Verzeichnis %s kann nicht gel�scht werden. Innerhalb des Verzeichnisses befinden sich weitere Verzeichnisse, welche als Arbeitsbereich in folgenden Objekten definiert sind:\\n%s";

$l_alert['field_contains_incorrect_chars'] = "Ein Feld (vom Typ %s) enth�lt ung�ltige Zeichen.";
$l_alert['field_input_contains_incorrect_length'] = "Die maximale L�nge eines Feldes vom Typ \'Textinput\' betr�gt 255 Zeichen. Wenn Sie mehr Zeichen ben�tigen, dann verwenden Sie ein Feld vom Typ \'Textarea\'.";
$l_alert['field_int_contains_incorrect_length'] = "Die maximale L�nge eines Feldes vom Typ \'Integer\' betr�gt 10 Zeichen.";
$l_alert['field_int_value_to_height'] = "Der maximale Wert eines Feldes vom Typ \'Integer\' ist 2147483647.";

$l_alert["we_filename_notValid"] = "Der Dateiname der hochzuladenden Datei ist nicht g�ltig!\\nErlaubte Zeichen sind Buchstaben von a bis z (Gro�- oder Kleinschreibung), Zahlen, Unterstrich (_), Minus (-) und Punkt (.).";
$l_alert["login_denied_for_user"] = "Der Benutzer kann sich nicht anmelden. Sein Zugang wurde gesperrt";

$l_alert["no_perm_to_delete_single_document"] = "Sie verf�gen nicht �ber die ben�tigten Rechte, um das aktive Dokument zu l�schen";

$l_confim["applyWeDocumentCustomerFiltersDocument"] = "Das Dokument wurde in einen Ordner mit abweichenden Zugriffsrechten f�r Kunden verschoben. Sollen die Einstellungen des Ordners auf dieses Dokument �bertragen werden?";
$l_confim["applyWeDocumentCustomerFiltersFolder"]   = "Das Verzeichnis wurde in einen Ordner mit abweichenden Zugriffsrechten f�r Kunden verschoben. Sollen die Einstellungen f�r dieses Verzeichnis und alle Unterelemente �bertragen werden? ";

$l_alert['error_fields_value_not_valid'] = 'Eingabe-Felder enthalten ung�ltige Werte!';
$l_alert['field_in_tab_notvalid_pre'] = "Die Einstellungen konnten nicht gespeichert werden, da folgende Felder ung�ltige Werte enthalten:";
$l_alert['field_in_tab_notvalid'] = ' - Feld %s im Tab %s';
$l_alert['field_in_tab_notvalid_post'] = 'Bitte korrigieren Sie die Felder und speichern Sie die Einstellungen erneut.';
$l_alert['discard_changed_data'] = 'Es gibt nicht gespeicherte �nderungen, die verloren gehen. Sind sie sicher?';
?>