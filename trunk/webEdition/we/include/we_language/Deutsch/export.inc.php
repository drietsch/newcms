<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//
// $Id: export.inc.php,v 1.62 2008/03/31 13:40:12 alexander.lindenstruth Exp $

/**
 * Language file: export.inc.php
 * Provides language strings.
 * Language: DeutschF
 */
$l_export["save_changed_export"] = "Der Export wurde ge�ndert.\\nM�chten Sie Ihre �nderungen speichern?";
$l_export["auto_selection"] = "Automatische Auswahl";
$l_export["txt_auto_selection"] = "Exportiert automatisch - nach Dokument-Typ oder Klasse - ausgew�hlte Dokumente oder Objekte.";
$l_export["txt_auto_selection_csv"] = "Exportiert automatisch - nach Klasse - ausgew�hlte Objekte.";
$l_export["manual_selection"] = "Manuelle Auswahl";
$l_export["txt_manual_selection"] = "Exportiert manuell ausgew�hlte Dokumente oder Objekte.";
$l_export["txt_manual_selection_csv"] = "Exportiert manuell ausgew�hlte Objekte.";
$l_export["element"] = "Elementauswahl";
$l_export["documents"] = "Dokumente";
$l_export["objects"] = "Objekte";
$l_export["step1"] = "Elementauswahl bestimmen";
$l_export["step2"] = "Zu exportierende Elemente ausw�hlen";
$l_export["step3"] = "Generic Export";
$l_export["step10"] = "Export beendet";
$l_export["step99"] = "Fehler w�hrend des Exportierens";
$l_export["step99_notice"] = "Export nicht m�glich";
$l_export["server_finished"] = "Die Export-Datei wurde auf dem Server gespeichert.";
$l_export["backup_finished"] = "Der Export wurde erfolgreich beendet.";
$l_export["download_starting"] = "Der Download der Export-Datei wurde gestartet.<br><br>Sollte der Download nach 10 Sekunden nicht starten,<br>";
$l_export["download"] = "klicken Sie bitte hier.";
$l_export["download_failed"] = "Die angeforderte Datei existiert entweder nicht oder Sie haben keine Berechtigung, sie herunterzuladen.";
$l_export["file_format"] = "Datei Format";
$l_export["export_to"] = "Exportieren nach";
$l_export["export_to_server"] = "Server";
$l_export["export_to_local"] = "Lokale Festplatte";
$l_export["cdata"] = "Kodierung";
$l_export["export_xml_cdata"] = "CDATA-Abschnitte hinzuf�gen";
$l_export["export_xml_entities"] = "Entit�ten ersetzen";
$l_export["filename"] = "Dateiname";
$l_export["path"] = "Pfad";
$l_export["doctypename"] = "Dokumente des Dokument-Typs";
$l_export["classname"] = "Objekte der Klasse";
$l_export["dir"] = "Verzeichnis";
$l_export["categories"] = "Kategorien";
$l_export["wizard_title"] = "Export Wizard";
$l_export["xml_format"] = "XML";
$l_export["csv_format"] = "CSV";
$l_export["csv_delimiter"] = "Trennzeichen";
$l_export["csv_enclose"] = "Textbegrenzer";
$l_export["csv_escape"] = "Escapezeichne";
$l_export["csv_lineend"] = "Dateiformat";
$l_export["csv_null"] = "NULL-Ersetzung";
$l_export["csv_fieldnames"] = "Erste Zeile enth�lt Feldnamen";
$l_export["windows"] = "Windows Format";
$l_export["unix"] = "UNIX Format";
$l_export["mac"] = "Mac Format";
$l_export["generic_export"] = "Generic Export";
$l_export["title"] = "Export Wizard";
$l_export["gxml_export"] = "Generic XML Export";
$l_export["txt_gxml_export"] = "Export von webEdition-Seiten und Objekten in eine \"flache\" XML-Datei (3 Ebenen).";
$l_export["csv_export"] = "CSV Export";
$l_export["txt_csv_export"] = "Export von webEdition Objekten in eine CSV-Datei (Comma Separated Values).";
$l_export["csv_params"] = "Einstellungen";
$l_export["error"] = "Der Export verlief nicht fehlerfrei!";
$l_export["error_unknown"] = "Ein unbekannter Fehler ist aufgetreten!";
$l_export["error_object_module"] = "Der Export von Dokumenten in CSV Dateien wird z.Z. nicht unterst�tzt!<br><br>Da das DB/Objekt Modul nicht installiert ist, ist der Export in CSV Dateien nicht verf�gbar.";
$l_export["error_nothing_selected_docs"] = "Der Export wurde nicht ausgef�hrt!<br><br>Es wurden keine Dokumente ausgew�hlt.";
$l_export["error_nothing_selected_objs"] = "Der Export wurde nicht ausgef�hrt!<br><br>Es wurden keine Dokumente oder Objekte ausgew�hlt.";
$l_export["error_download_failed"] = "Die Export Datei konnte nicht heruntergeladen werden.";
$l_export["comma"] = ", {Komma}";
$l_export["semicolon"] = "; {Semikolon}";
$l_export["colon"] = ": {Doppelpunkt}";
$l_export["tab"] = "\\t {Tab}";
$l_export["space"] = "  {Leerzeichen}";
$l_export["double_quote"] = "\" {Anf�hrungszeichen}";
$l_export["single_quote"] = "' {einfaches Anf�hrungszeichen}";
$l_export['we_export'] = 'wE Export';
$l_export['wxml_export'] = 'webEdition XML Export';
$l_export['txt_wxml_export'] = 'Export von webEdition-Seiten, Vorlagen, Objekten und Klassen, entsprechend der webEdition spezifischen DTD (Dokumenttyp-Definition).';

$l_export["options"] = "Optionen";
$l_export["handle_document_options"] = "Dokumente";
$l_export["handle_template_options"] = "Vorlagen";
$l_export["handle_def_templates"] = "Standard-Vorlagen exportieren";
$l_export["handle_document_includes"] = "Enthaltene Dokumente exportieren";
$l_export["handle_document_linked"] = "Verlinkte Dokumente exportieren";
$l_export["handle_object_options"] = "Objekte";
$l_export["handle_def_classes"] = "Standard-Klassen exportieren";
$l_export["handle_object_includes"] = "Enthaltene Objekte exportieren";
$l_export["handle_classes_options"] = "Klassen";
$l_export["handle_class_defs"] = "Vorgegebene Werte";
$l_export["handle_object_embeds"] = "Eingebundene Objekte exportieren";
$l_export["handle_doctype_options"] = "Dokument-Typen<br>Kategorien<br>Navigation";
$l_export["handle_doctypes"] = "Dokument-Typen";
$l_export["handle_categorys"] = "Kategorien";
$l_export["export_depth"] = "Export Tiefe";
$l_export["to_level"] = "bis Ebene";
$l_export["select_export"] ="Markieren Sie im Explorermen� die Eintr�ge, welchen Sie exportieren m�chten. Bedenken Sie, dass alle markierten Eintr�ge in allen Bereichen exportiert werden und dass bei einem Verzeichnis alle darin enthaltenen Eintr�ge automatisch mit exportiert werden!";
$l_export["templates"] = "Vorlagen";
$l_export["classes"] = "Klassen";

$l_export['nothing_to_delete'] = "Es gibt nichts zu l�schen.";
$l_export['nothing_to_save'] = 'Es gibts nichts zu speichern!';
$l_export['no_perms'] = 'Sie haben keine Berechtigung!';
$l_export['new'] = 'Neu';
$l_export['export'] = 'Export';
$l_export['group'] = 'Gruppe';
$l_export['save'] = 'Speichern';
$l_export['delete'] = 'L�schen';
$l_export['quit'] = 'Schlie�en';
$l_export['property'] = 'Eigenschaften';
$l_export['name'] = 'Name';
$l_export['save_to'] = 'Speichern nach:';
$l_export['selection'] = 'Auswahl';
$l_export['save_ok'] = 'Export wurde gespeichert.';
$l_export['save_group_ok'] = 'Gruppe wurde gespeichert.';
$l_export['log'] = 'Details';
$l_export['start_export'] = 'Export startet';
$l_export['prepare'] = 'Export vorbereiten...';

$l_export['doctype'] = 'Dokument-Typ';
$l_export['category'] = 'Kategorie';
$l_export['end_export'] = 'Export beendet';
$l_export['newFolder'] = "Neue Gruppe";
$l_export['folder_empty'] = "Die Gruppe ist leer";
$l_export['folder_path_exists'] = "Diese Gruppe existiert schon!";
$l_export['wrongtext'] = 'Der Name ist nicht g�ltig!\\nErlaubte Zeichen sind Buchstaben von a bis z (Gro�- oder Kleinschreibung), Zahlen, Unterstrich (_), Minus (-), Punkt (.), Leerzeichen ( ) und Klammeraffen (@).';
$l_export['wrongfilename'] = "Der Dateiname ist nicht g�ltig!";
$l_export['folder_exists'] = "Diese Gruppe existiert schon!";
$l_export['delete_ok'] = 'Der Export wurde gel�scht.';
$l_export['delete_nok'] = 'FEHLER: Der Export wurde nicht gel�scht';
$l_export['delete_group_ok'] = 'Die Gruppe wurde gel�scht.';
$l_export['delete_group_nok'] = 'FEHLER: Die Gruppe wurde nicht gel�scht';
$l_export['delete_question'] = 'M�chten Sie den aktuellen Export l�schen?';
$l_export['delete_group_question'] = 'M�chten Sie die aktuelle Gruppe l�schen?';
$l_export['download_starting2'] = 'Der Download der Export-Datei wurde gestartet.';
$l_export['download_starting3'] = 'Sollte der Download nach 10 Sekunden nicht starten,';
$l_export['working'] = 'Arbeiten';

$l_export['txt_document_options'] = 'Die Standard-Vorlage ist die Vorlage die in den Dokument-Eigenschaften definiert wurde. Die enthaltenen Dokumente sind die interne Dokumente die �ber die Tags we:include, we:form, we:url, we:linkToSeeMode, we:a, we:href, we:link, we:css, we:js, we:addDelNewsletterEmail in das exportierte Dokument eingebunden werden. Die enthaltenen Objekte sind die Objekte die �ber die Tags we:object und we:form in das exportierte Dokument eingebunden werden. Die verlinkten Dokumente sind die internen Dokumente die �ber die HTML-Tags body, a, img, table, td mit dem exportierten Dokument verlinkt sind.';
$l_export['txt_object_options'] = 'Die Standard-Klasse ist die Klasse die in den Objekt-Eigenschaften definiert wurde. Um die in den Objekten enthaltenen interne Dokumente, z.B. Bilder, zu exportieren, aktivieren Sie bitte die Option "Enthaltene Dokumente exportieren" weiter oben.';
$l_export['txt_exportdeep_options'] = 'Die Export Tiefe ist die Tiefe bis zu der die enthaltenen Dokumente bzw. Objekte exportiert werden. Das Feld muss numerisch sein!';
$l_export['name_empty'] = 'Der Name darf nicht leer sein!';
$l_export['name_exists'] = 'Der Name existiert bereits!';

$l_export['help'] = 'Hilfe';
$l_export['info'] = 'Info';
$l_export['path_nok'] = 'Der Pfad ist nicht korrekt!';

$l_export['must_save'] = 'Der Export wurde ver�ndert.\\nBevor Sie exportieren k�nnen, m�ssen Sie den Export speichern!';
$l_export['handle_owners_option'] = 'Besitzerdaten';
$l_export['handle_owners'] = 'Besitzerdaten exportieren';
$l_export['txt_owners'] = 'Die verlinkten Benutzerdaten mit exportieren.';

$l_export['weBinary'] = 'Datei';
$l_export['handle_navigation'] = 'Navigation';
$l_export['weNavigation'] = 'Navigation';
$l_export['weNavigationRule'] = 'Navigation-Regel';
$l_export['weThumbnail'] = 'Miniaturansichten';
$l_export['handle_thumbnails'] = 'Miniaturansichten';
$l_export['navigation_hint'] = 'Um Navigationseintr�ge zu exportieren muss auch die Vorlage, auf welcher die Navigation ausgegeben wird, exportiert werden!';


?>