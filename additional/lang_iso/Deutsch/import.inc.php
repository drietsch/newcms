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
 * Language file: import.inc.php
 * Provides language strings.
 * Language: Deutsch
 */

$l_import['title'] = 'Import-Wizard';
$l_import['wxml_import'] = 'webEdition XML Import';
$l_import['gxml_import'] = 'Generic XML Import';
$l_import['csv_import'] = 'CSV Import';
$l_import['import'] = 'Importiere';
$l_import['none'] = '-- keine --';
$l_import['any'] = '-- ohne --';
$l_import['source_file'] = 'Quelldatei';
$l_import['import_dir'] = 'Zielverzeichnis';
$l_import['select_source_file'] = 'Bitte w�hlen Sie eine Quelldatei.';
$l_import['we_title'] = 'Titel';
$l_import['we_description'] = 'Beschreibungstext';
$l_import['we_keywords'] = 'Schl�sselw�rter';
$l_import['uts'] = 'Unix-Timestamp';
$l_import['unix_timestamp'] = 'Der Unix-Timestamp z�hlt die Anzahl der Sekunden seit dem Beginn der Unix-Epoche (01.01.1970).';
$l_import['gts'] = 'GMT Timestamp';
$l_import['gmt_timestamp'] = 'General Mean Time bzw. Greenwich Mean Time (kurz GMT).';
$l_import['fts'] = 'Eigenes Format';
$l_import['format_timestamp'] = 'Innerhalb der Formatieranweisung sind folgende Symbole zul�ssig: Y (vierstellige Ausgabe des Jahres: 2004), y (zweistellige Ausgabe des Jahres: 04), m (Monat mit f�hrender Null: 01 bis 12), n (Monat ohne f�hrende Null: 1 bis 12), d (Tag des Monats mit zwei Stellen und f�hrender Null: 01 bis 31), j (Tag des Monats ohne f�hrende Null: 1 bis 31), H (Stunde im 24-Stunden-Format: 00 bis 23), G (Stunde im 24-Stunden-Format ohne f�hrende Null: 0 bis 23), i (Minuten: 00 bis 59), s (Sekunden mit f�hrender Null: 00 bis 59)';
$l_import['import_progress'] = 'Importiere';
$l_import['prepare_progress'] = 'Vorbereitung';
$l_import['finish_progress'] = 'Fertig';
$l_import['finish_import'] = 'Der Import wurde erfolgreich beendet!';
$l_import['import_file'] = 'Datei-Import';
$l_import['import_data'] = 'Daten-Import';
$l_import['file_import'] = 'Lokale Dateien importieren';
$l_import['txt_file_import'] = 'Eine oder mehrere Dateien von der lokalen Festplatte importieren.';
$l_import['site_import'] = 'Dateien vom Server importieren';
$l_import['site_import_isp'] = 'Grafiken vom Server importieren';
$l_import['txt_site_import'] = 'Dateien eines Server-Verzeichnisses importieren. W�hlen Sie durch das Setzen von Filteroptionen, ob Grafiken, HTML-, Flash-, JavaScript-, CSS-, Text-Dateien oder sonstige Dateien importiert werden sollen.';
$l_import['txt_site_import_isp'] = 'Grafiken eines Server-Verzeichnisses importieren. W�hlen Sie aus, welche Grafiken importiert werden sollen.';
$l_import['txt_wxml_import'] = 'webEdition XML-Dateien enthalten Informationen �ber webEdition-Seiten, Vorlagen oder Objekte. Legen Sie fest in welches Verzeichnis die Dokumente oder Objekte importiert werden sollen.';
$l_import['txt_gxml_import'] = 'Import von "flachen" XML-Dateien, wie sie z.B. von  phpMyAdmin erzeugt werden. Die Datensatz-Felder werden den webEdition Feldern zugeordnet. Nutzen Sie diesen Import um XML-Dateien zu importieren die ohne Exportmodul aus webEdition exportiert wurden.';
$l_import['txt_csv_import'] = 'Import von CSV-Dateien (Comma Separated Values) oder davon abgewandelter Textformate (z. B. *.txt). Die Datensatz-Felder werden den webEdition Feldern zugeordnet.';
$l_import['add_expat_support'] = 'Die XML Import-Schnittstelle erfordert die XML expat Erweiterung von James Clark. Kompilieren Sie PHP mit der expat Erweiterung neu, damit die XML Import Funktionalit�t unterst�tzt werden kann.';
$l_import['xml_file'] = 'XML-Datei';
$l_import['templates'] = 'Vorlagen';
$l_import['classes'] = 'Klassen';
$l_import['predetermined_paths'] = 'Vorgegebene Pfade';
$l_import['maintain_paths'] = 'Pfade beibehalten';
$l_import['import_options'] = 'Import Optionen';
$l_import['file_collision'] = 'Bei existierender Datei';
$l_import['collision_txt'] = 'Beim Import von Dateien in ein Verzeichnis, das eine Datei mit gleichem Namen enth�lt, kommt es zu Konflikten. Geben Sie an, wie der Import Wizard diese Dateien behandeln soll.';
$l_import['replace'] = 'Ersetzen';
$l_import['replace_txt'] = 'Bestehende Datei l�schen und mit den neuen Eintr�gen Ihrer vorliegenden Datei ersetzen.';
$l_import['rename'] = 'Umbenennen';
$l_import['rename_txt'] = 'Dem Dateinamen wird eine eindeutige ID hinzugef�gt. Alle Links, die auf diese Datei verweisen, werden entsprechend angepasst.';
$l_import['skip'] = '�berspringen';
$l_import['skip_txt'] = 'Beim �berspringen der vorliegenden Datei bleibt die bestehende Datei erhalten.';
$l_import['extra_data'] = 'Extra Daten';
$l_import['integrated_data'] = 'Eingebundene Daten importieren';
$l_import['integrated_data_txt'] = 'W�hlen Sie diese Option, wenn die von den Vorlagen inkludierten Daten, bzw. Dokumente importiert werden sollen.';
$l_import['max_level'] = 'bis Ebene';
$l_import['import_doctypes'] = 'Dokument-Typen importieren';
$l_import['import_categories'] = 'Kategorien importieren';
$l_import['invalid_wxml'] = 'Es k�nnen nur XML-Dateien importiert werden, die der webEdition Dokumenttyp-Definition (DTD) entsprechen.';
$l_import['valid_wxml'] = 'Die XML-Datei ist wohlgeformt und g�ltig, d.h. es entspricht der webEdition Dokumenttyp-Definition (DTD).';
$l_import['specify_docs'] = 'Bitte w�hlen Sie die Dokumente, die Sie importieren m�chten.';
$l_import['specify_objs'] = 'Bitte w�hlen Sie die Objekte, die Sie importieren m�chten.';
$l_import['specify_docs_objs'] = 'Bitte w�hlen Sie, ob Sie Dokumente und/oder Objekte importieren m�chten.';
$l_import['no_object_rights'] = 'Sie haben jedoch keine Berichtigung Objekte zu importieren.';
$l_import['display_validation'] = 'XML-Validierung anzeigen';
$l_import['xml_validation'] = 'XML-Validierung';
$l_import['warning'] = 'Warnung';
$l_import['attribute'] = 'Attribut';
$l_import['invalid_nodes'] = 'ung�ltiger XML-Knoten an der Position ';
$l_import['no_attrib_node'] = 'fehlendes XML-Element "attrib" an der Position ';
$l_import['invalid_attributes'] = 'ung�ltige Attribute an der Position ';
$l_import['attrs_incomplete'] = 'die Liste der als #required und #fixed definierten Attribute ist unvollst�ndig an der Position ';
$l_import['wrong_attribute'] = 'ein Attributname wurde weder als #required, noch als #implied definiert an der Position ';
$l_import['documents'] = 'Dokumente';
$l_import['objects'] = 'Objekte';
$l_import['fileselect_server'] = 'Quelldatei vom Server laden';
$l_import['fileselect_local'] = 'Quelldatei von der lokalen Festplatte hochladen';
$l_import['filesize_local'] = 'Die hochzuladende Datei darf auf Grund von PHP Einschr�nkungen nicht gr��er als %s sein!';
$l_import['invalid_path'] = 'Der Pfad der Quelldatei ist ung�ltig.';
$l_import['xml_mime_type'] = 'Die ausgew�hlte Datei kann nicht importiert werden. Mime-Typ:';
$l_import['ext_xml'] = 'Bitte w�hlen Sie eine Quelldatei mit der Dateierweiterung ".xml".';
$l_import['store_docs'] = 'Zielverzeichnis Dokumente';
$l_import['store_tpls'] = 'Zielverzeichnis Seitenvorlagen';
$l_import['store_objs'] = 'Zielverzeichnis Objekte';
$l_import['doctype'] = 'Dokument Typ';
$l_import['gxml'] = 'Generic XML';
$l_import['data_import'] = 'Daten importieren';
$l_import['documents'] = 'Dokumente';
$l_import['objects'] = 'Objekte';
$l_import['type'] = 'Typ';
$l_import['template'] = 'Vorlage';
$l_import['class'] = 'Klasse';
$l_import['categories'] = 'Kategorien';
$l_import['isDynamic'] = 'Seite dynamisch generieren';
$l_import['extension'] = 'Erweiterung';
$l_import['filetype'] = 'Dateityp';
$l_import['directory'] = 'Verzeichnis';
$l_import['select_data_set'] = 'Datensatz ausw�hlen';
$l_import['select_docType'] = 'Bitte w�hlen Sie eine Vorlage aus.';
$l_import['file_exists'] = 'Die ausgew�hlte Quelldatei existiert nicht. Bitte �berpr�fen Sie die Pfadangabe. Pfad: ';
$l_import['file_readable'] = 'Die ausgew�hlte Quelldatei hat keine Leserechte und kann somit nicht importiert werden.';
$l_import['asgn_rcd_flds'] = 'Datenfelder zuordnen';
$l_import['we_flds'] = 'webEdition&nbsp;Felder';
$l_import['rcd_flds'] = 'Datensatz&nbsp;Felder';
$l_import['name'] = 'Name';
$l_import['auto'] = 'automatisch';
$l_import['asgnd'] = 'zugeordnet';
$l_import['pfx'] = 'Pr�fix';
$l_import['pfx_doc'] = 'Dokument';
$l_import['pfx_obj'] = 'Objekt';
$l_import['rcd_fld'] = 'Datensatz Feld';
$l_import['import_settings'] = 'Import-Einstellungen';
$l_import['xml_valid_1'] = 'Die XML-Datei ist g�ltig und enth�lt';
$l_import['xml_valid_s2'] = 'Elemente. Bitte w�hlen Sie die Elemente aus, die Sie importieren m�chten.';
$l_import['xml_valid_m2'] = 'XML Kind-Knoten in der ersten Ebene mit unterschiedlichen Namen. Bitte w�hlen Sie den XML-Knoten und die Anzahl der Elemente, die Sie importieren m�chten.';
$l_import['well_formed'] = 'Die XML-Datei ist fehlerfrei (wohlgeformt).';
$l_import['not_well_formed'] = 'Die XML-Datei ist nicht wohlgeformt und kann nicht importiert werden.';
$l_import['missing_child_node'] = 'Die XML-Datei ist wohlgeformt, enth�lt aber keine XML-Knoten und kann somit nicht importiert werden.';
$l_import['select_elements'] = 'Bitte w�hlen Sie die Datens�tze aus, die Sie importieren m�chten.';
$l_import['num_elements'] = 'Bitte w�hlen Sie die Anzahl der Datens�tze zwischen 1 und ';
$l_import['xml_invalid'] = '';
$l_import['option_select'] = 'Auswahl..';
$l_import['num_data_sets'] = 'Datens�tze:';
$l_import['to'] = 'bis';
$l_import['assign_record_fields'] = 'Datenfelder zuordnen';
$l_import['we_fields'] = 'webEdition Felder';
$l_import['record_fields'] = 'Datensatz Felder';
$l_import['record_field'] = 'Datensatz Feld ';
$l_import['attributes'] = 'Attribute';
$l_import['settings'] = 'Einstellungen';
$l_import['field_options'] = 'Feld-Optionen';
$l_import['csv_file'] = 'CSV-Datei';
$l_import['csv_settings'] = 'CSV Einstellungen';
$l_import['xml_settings'] = 'XML Einstellungen';
$l_import['file_format'] = 'Datei-Format';
$l_import['field_delimiter'] = 'Trennzeichen';
$l_import['comma'] = ', {Komma}';
$l_import['semicolon'] = '; {Semikolon}';
$l_import['colon'] = ': {Doppelpunkt}';
$l_import['tab'] = "\\t {Tab}";
$l_import['space'] = '  {Leerzeichen}';
$l_import['text_delimiter'] = 'Textbegrenzer';
$l_import['double_quote'] = '" {Anf�hrungszeichen}';
$l_import['single_quote'] = '\' {einfaches Anf�hrungszeichen}';
$l_import['contains'] = 'Erste Zeile enth�lt Feldnamen';
$l_import['split_xml'] = 'Datens�tze der Reihe nach importieren';
$l_import['wellformed_xml'] = '�berpr�fung auf Wohlgeformtheit';
$l_import['validate_xml'] = 'XML-Validierung';
$l_import['select_csv_file'] = 'Bitte w�hlen Sie die CSV-Quelldatei.';
$l_import['select_seperator'] = 'Bitte w�hlen Sie ein Trennzeichen.';
$l_import['format_date'] = 'Datumsformat';
$l_import['info_sdate'] = 'W�hlen Sie das Datumsformat f�r das webEdition Feld';
$l_import['info_mdate'] = 'W�hlen Sie das Datumsformat f�r die webEdition Felder';
$l_import['remark_csv'] = 'Sie k�nnen CSV-Dateien (Comma Separated Values) oder davon abgewandelte Textformate (z. B. *.txt) importieren. Beim Import dieser Dateiformate kann das Spaltentrennzeichen (z. B. , ; Tab, Leerzeichen) und der Textbegrenzer (= das Zeichen, welches Texteintr�ge kapselt) eingestellt werden.';
$l_import['remark_xml'] = 'W�hlen Sie die Option "Datens�tze einzeln importieren", damit gro�e Dateien innerhalb der als Timeout definierten Ausf�hrungszeit eines PHP-Scriptes importiert werden k�nnen.<br>Wenn Sie nicht sicher sind, ob es sich bei der ausgew�hlten Datei um webEdition XML handelt, dann k�nnen Sie die Datei vor dem Import auf Wohlgeformtheit und G�ltigkeit �berpr�fen.';

$l_import["import_docs"]="Dokumente importieren";
$l_import["import_templ"]="Vorlagen importieren";
$l_import["import_objs"]="Objekte importieren";
$l_import["import_classes"]="Klassen importieren";
$l_import["import_doctypes"]="Dokument-Typen importieren";
$l_import["import_cats"]="Kategorien importieren";
$l_import["documents_desc"]="Geben Sie bitte das Verzeichnis an, in welches die Dokumente importiert werden sollen. Falls die Option \"".$l_import['maintain_paths']."\" ausgew�hlt ist, werden die entsprechenden Pfade automatisch wiederhergestellt, anderenfalls werden die Pfade ignoriert.";
$l_import["templates_desc"]="Geben Sie bitte das Verzeichnis an, in welches die Vorlagen importiert werden sollen. Falls die Option \"".$l_import['maintain_paths']."\" ausgew�hlt ist, werden die entsprechenden Pfade automatisch wiederhergestellt, anderenfalls werden die Pfade ignoriert.";

$l_import['handle_document_options'] = 'Dokumente';
$l_import['handle_template_options'] = 'Vorlagen';
$l_import['handle_object_options'] = 'Objekte';
$l_import['handle_class_options'] = 'Klasse';
$l_import["handle_doctype_options"] = "Dokument-Typen";
$l_import["handle_category_options"] = "Kategorien";
$l_import['log'] = 'Details';
$l_import['start_import'] = 'Import startet';
$l_import['prepare'] = 'Vobereitung...';
$l_import['update_links'] = 'Links-Aktualisierung...';
$l_import['doctype'] = 'Dokument-Typ';
$l_import['category'] = 'Kategorie';
$l_import['end_import'] = 'Import beendet';

$l_import['handle_owners_option'] = 'Besitzerdaten';
$l_import['txt_owners'] = 'Die verlinkten Benutzerdaten mit importieren.';
$l_import['handle_owners'] = 'Besitzerdaten wiederherstellen';
$l_import['notexist_overwrite'] = 'Sollte der Benutzer nicht existieren, dann wird die Option "Besitzerdaten �berschreiben" verwendet.';
$l_import['owner_overwrite'] = 'Besitzerdaten �berschreiben';

$l_import['name_collision'] = 'Bei gleichen Namen';

$l_import['item'] = 'Artikel';
$l_import['backup_file_found'] = 'Hier handelt es sich um eine Backup-Datei. Nutzen Sie bitte die Option \"Backup->Backup wiederherstellen\" aus dem Datei-Men� um die Datei zu importieren.';
$l_import['backup_file_found_question'] = 'M�chten Sie gleich das aktuelle Fenster schlie�en und einen Backup-Wizard f�r den Import starten?';
$l_import['close'] = 'Schlie�en';

$l_import['handle_file_options'] = 'Dateien';
$l_import['import_files'] = 'Dateien importieren';

$l_import['weBinary'] = 'Datei';

$l_import['format_unknown'] = 'Das Format der Datei ist unbekannt!';
$l_import['customer_import_file_found'] = 'Hier handelt es sich um eine Import-Datei aus der Kundenverwaltung. Nutzen Sie bitte die Option \"Import/Export\" aus der Kundenverwaltung (PRO) um die Datei zu importieren.';
$l_import['upload_failed'] = 'Die Datei kann nicht hochgeladen werden! Pr�fen Sie bitte ob die Gr��e der Datei %s �berschreitet';

$l_import['import_navigation'] = 'Navigation importieren';
$l_import['weNavigation'] = 'Navigation';
$l_import['navigation_desc'] = 'Geben Sie bitte das Verzeichnis an, in welches die Navigation importiert werden sollen.';
$l_import['weNavigationRule'] = 'Navigation-Regel';
$l_import['weThumbnail'] = 'Miniaturansichten';
$l_import['import_thumbnails'] = 'Miniaturansichten importieren';
$l_import['rebuild'] = 'Rebuild';
$l_import['rebuild_txt'] = 'Automatischer Rebuild';
$l_import['finished_success'] = 'Der Import der Daten wurde erfolgreich beendet.';

?>