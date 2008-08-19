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
 * Language file: metadata.inc.php
 * Provides language strings.
 * Language: Deutsch
 */

/*****************************************************************************
 * DOCUMENT TAB
 *****************************************************************************/

$l_metadata["filesize"] = "Dateigröße";
$l_metadata["supported_types"] = "Metadatenformate";
$l_metadata["none"] = "keine";
$l_metadata["filetype"] = "Dateityp";

/*****************************************************************************
 * METADATA FIELD MAPPING
 *****************************************************************************/

$l_metadata["headline"] = "Metadatenfelder";
$l_metadata["tagname"] = "Feldname";
$l_metadata["type"] = "Typ";
$l_metadata["dummy"] = "dummy";

$l_metadata["save"] = "Einstellungen werden gespeichert, einen Moment ...";
$l_metadata["save_wait"] = "Speichere Einstellungen";

$l_metadata["saved"] = "Die Einstellungen wurden erfolgreich gespeichert.";
$l_metadata["saved_successfully"] = "Einstellungen gespeichert";

$l_metadata["properties"] = "Eigenschaften";


$l_metadata["fields_hint"] = "Definieren Sie hier zusätzliche Felder für Metadaten. In der Originaldatei bereits hinterlegte Daten (Exif, IPTC) können beim Import automatisch übernommen werden. Geben Sie dazu ein oder mehrere einzulesende Felder im Eingabefeld &quot;importiere von&quot; im Format &quot;[Typ]/[Feldname]&quot; an. Beispiel: &quot;exif/copyright,iptc/copyright&quot;. Mehrere Felder können kommasepariert angegeben werden. Der Import durchsucht alle angegebenen Felder bis zum ersten mit Daten gefüllten Feld.<br><br>Weitere Informationen zum Exif-Standard finden Sie auf der <a target=\"_blank\" href=\"http://www.exif.org\">Exif Homepage</a>. Informationen über IPTC finden Sie auf der <a target=\"_blank\" href=\"http://www.iptc.org/IIM\">IPTC homepage</a>.";
$l_metadata["import_from"] = "Importiere von";
$l_metadata["fields"] = "Felder";
$l_metadata['add'] = "hinzufügen";

/*****************************************************************************
 * UPLOAD
 *****************************************************************************/

$l_metadata["import_metadata_at_upload"] = "Vorhandene Metadaten importieren";

/*****************************************************************************
 * ERROR MESSAGES
 *****************************************************************************/

$l_metadata['error_meta_field_empty_msg'] = "Der Feldname der %s1. Zeile darf nicht leer sein!";
$l_metadata['meta_field_wrong_chars_messsage'] = "Der Feldname '%s1' ist nicht gültig! Er darf nur aus Buchstaben (groß oder klein, aber ohne Umlaute und Sonderzeichen), Zahlen (a-z, A-Z, 0-9) und Unterstrichen bestehen!";
$l_metadata['meta_field_wrong_name_messsage'] = "Der Feldname '%s1' ist nicht gültig, da er von webEdition intern benutzt wird! Folgende Namen sind nicht zulässig:%s2";


/*****************************************************************************
 * INFO TAB
 *****************************************************************************/

$l_metadata['info_exif_data'] = "Exif Daten";
$l_metadata['info_iptc_data'] = "IPTC Daten";
$l_metadata['no_exif_data'] = "Keine Exif Daten vorhanden";
$l_metadata['no_iptc_data'] = "Keine IPTC Daten vorhanden";
$l_metadata['no_exif_installed'] = "Die PHP Exif Erweiterung ist nicht installiert!";
$l_metadata['no_metadata_supported'] = "webEdition unterstützt für diesen Dateityp keine Metadatenformate.";

?>