<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//
// $Id: global.inc.php,v 1.24 2007/11/05 15:40:10 damjan.denic Exp $

/**
 * Language file: global.inc.php
 * Provides language strings.
 * Language: Deutsch
 */
include_once(dirname(__FILE__)."/enc_".basename(__FILE__));

$GLOBALS["l_global"]["new_link"] = "Neuer Link"; // important to use for this the GLOBALS ARRAY (because in linklists the file is included in a function)!!!
$GLOBALS["l_global"]["load_menu_info"] = "Lade Daten!<br>Dies kann bei vielen Menü-Einträgen etwas länger dauern ...";
$GLOBALS["l_global"]["text"] = "Text";
$GLOBALS["l_global"]["yes"] = "ja";
$GLOBALS["l_global"]["no"] = "nein";
$GLOBALS["l_global"]["checked"] = "Aktiv";
$GLOBALS["l_global"]["max_file_size"] = "Max. Dateigr&ouml;&szlig;e (in Bytes)";
$GLOBALS["l_global"]["default"] = "Voreinstellung";
$GLOBALS["l_global"]["values"] = "Werte";
$GLOBALS["l_global"]["name"] = "Name";
$GLOBALS["l_global"]["type"] = "Typ";
$GLOBALS["l_global"]["attributes"] = "Attribute";
$GLOBALS["l_global"]["formmailerror"] = "Das Formular wurde aus folgendem Grund nicht übermittelt:";
$GLOBALS["l_global"]["email_notallfields"] = "Sie haben nicht alle notwendigen Felder ausgef&uuml;llt!";
$GLOBALS["l_global"]["email_ban"] = "Sie sind nicht berechtigt dieses Script zu benutzen!";
$GLOBALS["l_global"]["email_recipient_invalid"] = "Empf&auml;ngeradresse nicht g&uuml;ltig!";
$GLOBALS["l_global"]["email_no_recipient"] = "Empf&auml;ngeradresse nicht vorhanden!";
$GLOBALS["l_global"]["email_invalid"] = "Ihre <b>E-Mail Adresse</b> ist nicht g&uuml;ltig!";
$GLOBALS["l_global"]["captcha_invalid"] = "Der eingegebene Sicherheitscode ist falsch!";
$GLOBALS["l_global"]["question"] = "Frage";
$GLOBALS["l_global"]["warning"] = "Warnung";
$GLOBALS["l_global"]["we_alert"] = "Diese Funktion ist in der Demo-Version von webEdition nicht verfügbar!";
$GLOBALS["l_global"]["index_table"] = "Index Tabelle";
$GLOBALS["l_global"]["cannotconnect"] = "Es konnte keine Verbindung zum webEdition Server hergestellt werden!";
$GLOBALS["l_global"]["recipients"] = "Formmail-Empfänger";
$GLOBALS["l_global"]["recipients_txt"] = "Tragen Sie hier alle E-Mail-Adressen ein, an welche Formulare mit der Formmail-Funktion (&lt;we:form type=&quot;formmail&quot; ..&gt;) geschickt werden dürfen. Ist hier keine E-Mail-Adresse eingetragen, kann man keine Formulare mit der Formmail-Funktion verschicken!";
$GLOBALS["l_global"]["std_subject_newObj"] = "Neues Objekt";
$GLOBALS["l_global"]["std_mailtext_newObj"] = "Es wurde ein neues Objekt %s der Klasse %s erzeugt!";
$GLOBALS["l_global"]["std_subject_newDoc"] = "Neues Dokument";
$GLOBALS["l_global"]["std_mailtext_newDoc"] = "Es wurde ein neues Dokument %s erzeugt!";
$GLOBALS["l_global"]["std_subject_delObj"] = "Objekt geloescht";
$GLOBALS["l_global"]["std_mailtext_delObj"] = "Das Objekt %s wurde gelöscht!";
$GLOBALS["l_global"]["std_subject_delDoc"] = "Dokument geloescht";
$GLOBALS["l_global"]["std_mailtext_delDoc"] = "Das Dokument %s wurde gelöscht!";
$GLOBALS["l_global"]["we_make_same"]["text/html"] = "Nach Speichern neue Seite";
$GLOBALS["l_global"]["we_make_same"]["text/webedition"] = $GLOBALS["l_global"]["we_make_same"]["text/html"];
$GLOBALS["l_global"]["we_make_same"]["objectFile"] = "Nach Speichern neues Objekt";
$GLOBALS["l_global"]["no_entries"] = "Keine Einträge vorhanden!";
$GLOBALS["l_global"]["save_temporaryTable"] = "Temporäre Arbeitsdokumente neu speichern";
$GLOBALS["l_global"]["save_mainTable"] = "Haupttabelle der Datenbank neu schreiben";
$GLOBALS["l_global"]["add_workspace"] = "Arbeitsbereich hinzufügen";
$GLOBALS["l_global"]["folder_not_editable"] = "Dieses Verzeichnis darf nicht ausgewählt werden!";
$GLOBALS["l_global"]["modules"] = "Module";
$GLOBALS["l_global"]["modules_and_tools"] = "Module und Werkzeuge";
$GLOBALS["l_global"]["center"] = "Zentrieren";
$GLOBALS["l_global"]["jswin"] = "Popup Fenster";
$GLOBALS["l_global"]["open"] = "Öffnen";
$GLOBALS["l_global"]["posx"] = "x Position";
$GLOBALS["l_global"]["posy"] = "y Position";
$GLOBALS["l_global"]["status"] = "Status";
$GLOBALS["l_global"]["scrollbars"] = "Scrollbars";
$GLOBALS["l_global"]["menubar"] = "Menubar";
$GLOBALS["l_global"]["toolbar"] = "Toolbar";
$GLOBALS["l_global"]["resizable"] = "Resizable";
$GLOBALS["l_global"]["location"] = "Location";
$GLOBALS["l_global"]["title"] = "Titel";
$GLOBALS["l_global"]["description"] = "Beschreibung";
$GLOBALS["l_global"]["required_field"] = "Pflichtfeld";
$GLOBALS["l_global"]["from"] = "von";
$GLOBALS["l_global"]["to"] = "bis";
$GLOBALS["l_global"]["search"] = "Suche";
$GLOBALS["l_global"]["in"] = "in";
$GLOBALS["l_global"]["we_rebuild_at_save"] = "Automatischer Rebuild";
$GLOBALS["l_global"]["we_publish_at_save"] = "Beim Speichern veröffentlichen";
$GLOBALS["l_global"]["we_new_doc_after_save"] = "Nach Speichern neues Dokument";
$GLOBALS["l_global"]["we_new_folder_after_save"] = "Nach Speichern neuer Ordner";
$GLOBALS["l_global"]["we_new_entry_after_save"] = "Nach Speichern neuer Eintrag";
$GLOBALS["l_global"]["wrapcheck"] = "Zeilenumbruch";
$GLOBALS["l_global"]["static_docs"] = "Statische Dokumente";
$GLOBALS["l_global"]["save_templates_before"] = "Vorher Vorlagen neu sichern";
$GLOBALS["l_global"]["specify_docs"] = "Dokumente mit folgenden Kriterien";
$GLOBALS["l_global"]["object_docs"] = "Alle Objekte";
$GLOBALS["l_global"]["all_docs"] = "Alle Dokumente";
$GLOBALS["l_global"]["ask_for_editor"] = "vorher nach gew&uuml;nschtem Editor fragen";
$GLOBALS["l_global"]["cockpit"] = "Cockpit";
$GLOBALS["l_global"]["introduction"] = "Einf&uuml;hrung";
$GLOBALS["l_global"]["doctypes"] = "Dokument-Typen";
$GLOBALS["l_global"]["content"] = "Inhalt";
$GLOBALS["l_global"]["site_not_exist"] = "Diese Seite existiert nicht!";
$GLOBALS["l_global"]["site_not_published"] = "Diese Seite ist noch nicht veröffentlicht!";
$GLOBALS["l_global"]["required"] = "Eintrag erforderlich";
$GLOBALS["l_global"]["all_rights_reserved"] = "Alle Rechte vorbehalten";
$GLOBALS["l_global"]["width"] = "Breite";
$GLOBALS["l_global"]["height"] = "Höhe";
$GLOBALS["l_global"]["new_username"] = "Neuer Benutzername";
$GLOBALS["l_global"]["password"] = "Kennwort";
$GLOBALS["l_global"]["username"] = "Benutzername";
$GLOBALS["l_global"]["documents"] = "Dokumente";
$GLOBALS["l_global"]["templates"] = "Vorlagen";
$GLOBALS["l_global"]["objects"] = "Objekte";
$GLOBALS["l_global"]["licensed_to"] = "Lizenznehmer";
$GLOBALS["l_global"]["left"] = "links";
$GLOBALS["l_global"]["right"] = "rechts";
$GLOBALS["l_global"]["top"] = "oben";
$GLOBALS["l_global"]["bottom"] = "unten";
$GLOBALS["l_global"]["topleft"] = "oben links";
$GLOBALS["l_global"]["topright"] = "oben rechts";
$GLOBALS["l_global"]["bottomleft"] = "unten links";
$GLOBALS["l_global"]["bottomright"] = "unten rechts";
$GLOBALS["l_global"]["true"] = "ja";
$GLOBALS["l_global"]["false"] = "nein";
$GLOBALS["l_global"]["showall"] = "zeige alles";
$GLOBALS["l_global"]["noborder"] = "ohne Rand";
$GLOBALS["l_global"]["border"] = "Rand";
$GLOBALS["l_global"]["align"] = "Ausrichtung";
$GLOBALS["l_global"]["hspace"] = "horiz. Abstand";
$GLOBALS["l_global"]["vspace"] = "vert. Abstand";
$GLOBALS["l_global"]["exactfit"] = "exactfit";
$GLOBALS["l_global"]["select_color"] = "Farbe auswählen";
$GLOBALS["l_global"]["loginok"] =  "<strong>Login ok!</strong><br>webEdition sollte sich nun in einem neuen Fenster öffnen.<br>Ist dies nicht der Fall, haben Sie wahrscheinlich Pop-Ups in Ihrem Browser unterdrückt!";
$GLOBALS["l_global"]["apple"] = "&#x2318;";
$GLOBALS["l_global"]["shift"] = "SHIFT";
$GLOBALS["l_global"]["ctrl"] = "STRG";
$GLOBALS["l_global"]["changeUsername"] = "Benutzername ändern";
$GLOBALS["l_global"]["changePass"] = "Kennwort ändern";
$GLOBALS["l_global"]["oldPass"] = "Altes Kennwort";
$GLOBALS["l_global"]["newPass"] = "Neues Kennwort";
$GLOBALS["l_global"]["newPass2"] = "Neues Kennwort Wiederholung";
$GLOBALS["l_global"]["pass_not_confirmed"] = "Die Wiederholung des neuen Kennworts stimmt nicht mit dem neuen Kennwort überein!";
$GLOBALS["l_global"]["pass_not_match"] = "Das alte Kennwort stimmt nicht!";
$GLOBALS["l_global"]["passwd_not_match"] = "Das Kennwort stimmt nicht!";
$GLOBALS["l_global"]["pass_to_short"] = "Das Kennwort muss mindestens 4 Zeichen lang sein!";
$GLOBALS["l_global"]["pass_changed"] = "Das Kennwort wurde erfolgreich geändert!";
$GLOBALS["l_global"]["username_wrong_chars"] = "Der Benutzername darf nur Buchstaben (a-z und A-Z), Zahlen (0-9), '.', '_' oder '-' enthalten!";
$GLOBALS["l_global"]["pass_wrong_chars"] = "Das Kennwort darf nur Buchstaben (a-z und A-Z) und Zahlen (0-9) enthalten!";
$GLOBALS["l_global"]["all"] = "Alle";
$GLOBALS["l_global"]["selected"] = "Ausgewählt";
$GLOBALS["l_global"]["username_to_short"] = "Der Benutzername muss mindestens 4 Zeichen lang sein!";
$GLOBALS["l_global"]["username_changed"] = "Der Benutzername wurde erfolgreich geändert!";
$GLOBALS["l_global"]["published"] = "Veröffentlicht";
$GLOBALS["l_global"]["help_welcome"] = "Willkommen im Hilfesystem von webEdition";
$GLOBALS["l_global"]["edit_file"] = "Datei bearbeiten";
$GLOBALS["l_global"]["docs_saved"] = "Dokumente erfolgreich gesichert!";
$GLOBALS["l_global"]["preview"] = "Vorschau";
$GLOBALS["l_global"]["close"] = "Fenster schließen";
$GLOBALS["l_global"]["required_fields"] = "Pflichtfelder";
$GLOBALS["l_global"]["no_file_uploaded"] = "<p class=\"defaultfont\">Es wurde noch kein Dokument hochgeladen.</p>";
$GLOBALS["l_global"]["openCloseBox"] = "Auf-/Zuklappen";
$GLOBALS["l_global"]["rebuild"] = "Rebuild";
$GLOBALS["l_global"]["welcome_to_we"] = "Willkommen bei webEdition 3";
$GLOBALS["l_global"]["tofit"] = "Willkommen bei webEdition 3";
$GLOBALS["l_global"]["unlocking_document"] = "gebe Dokument frei";
$GLOBALS["l_global"]["variant_field"] = "Variantfeld";
$GLOBALS["l_global"]["redirect_to_login_failed"] = "Falls Sie nicht innerhalb von 30 Sekunden auf die webEdition-Login-Seite geleitent werden, klicken Sie bitte auf den folgenden Link: ";
$GLOBALS["l_global"]["redirect_to_login_name"] = "zur webEdition-Login-Seite";
$GLOBALS["l_global"]["untitled"] = "Unbenannt";
$GLOBALS["l_global"]["no_document_opened"] = "Es ist kein Dokument geöffnet!";
?>