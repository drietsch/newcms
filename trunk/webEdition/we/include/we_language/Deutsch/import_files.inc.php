<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//
// $Id: import_files.inc.php,v 1.17 2007/10/15 12:20:19 holger.meyer Exp $

/**
 * Language file: import_files.inc.php
 * Provides language strings.
 * Language: Deutsch
 */
$GLOBALS["l_import_files"]["destination_dir"] = "Zielverzeichnis";
$GLOBALS["l_import_files"]["file"] = "Datei";
$GLOBALS["l_import_files"]["sameName_expl"] = "Bestimmen Sie hier das Verhalten von webEdition, wenn eine Datei mit gleichem Namen existiert.";
$GLOBALS["l_import_files"]["sameName_overwrite"] = "Existierende Datei überschreiben";
$GLOBALS["l_import_files"]["sameName_rename"] = "Neue Datei umbenennen";
$GLOBALS["l_import_files"]["sameName_nothing"] = "Datei nicht importieren";
$GLOBALS["l_import_files"]["sameName_headline"] = "Was tun bei<br>gleichem Namen?";
$GLOBALS["l_import_files"]["step1"] = "Lokale Dateien importieren - Schritt 1 von 3";
$GLOBALS["l_import_files"]["step2"] = "Lokale Dateien importieren - Schritt 2 von 3";
$GLOBALS["l_import_files"]["step3"] = "Lokale Dateien importieren - Schritt 3 von 3";
$GLOBALS["l_import_files"]["import_expl"] = "Durch Klick auf den Button neben dem Eingabefeld können Sie eine Datei auf Ihrer Festplatte auswählen. Nach der Auswahl erscheint ein neues Eingabefeld mit dem Sie eine weitere Datei auswählen können. Beachten Sie, daß pro Datei die maximale Größe von %s auf Grund von PHP und MySQL Einschränkungen nicht überschritten werden darf!<br><br>Klicken Sie auf \"Weiter\", um den Import zu starten.";
$GLOBALS["l_import_files"]["import_expl_jupload"] = "Durch Klick auf den Button im Java-Applet können Sie mehrere Dateien auf Ihrer Festplatte auswählen. Alternativ können Sie die Dateien aus dem File Manager per 'Drag and Drop' in das Applet ziehen. Beachten Sie, daß pro Datei die maximale Größe von %s auf Grund von PHP und MySQL Einschränkungen nicht überschritten werden darf!<br><br>Klicken Sie auf \"Hochladen\" im Applet, um den Import zu starten.";

$GLOBALS["l_import_files"]["error"] = "Es sind Fehler beim Import aufgetreten!\\n\\nFolgende Dateien konnten nicht importiert werden:\\n%s";
$GLOBALS["l_import_files"]["finished"] = "Der Import wurde erfolgreich beendet!";
$GLOBALS["l_import_files"]["import_file"] = "Importiere Datei %s";

$GLOBALS["l_import_files"]["no_perms"] = "Fehler: keine Berechtigung";
$GLOBALS["l_import_files"]["move_file_error"] = "Fehler: move_uploaded_file()";
$GLOBALS["l_import_files"]["read_file_error"] = "Fehler: fread()";
$GLOBALS["l_import_files"]["php_error"] = "Fehler: upload_max_filesize()";
$GLOBALS["l_import_files"]["same_name"] = "Fehler: Datei existiert";
$GLOBALS["l_import_files"]["save_error"] = "Fehler beim speichern";
$GLOBALS["l_import_files"]["publish_error"] = "Fehler beim veröffentlichen";

$GLOBALS["l_import_files"]["root_dir_1"] = "Sie haben als Quellverzeichnis das Root-Verzeichnis des Webservers angegeben. Sind Sie sicher, dass Sie sämtlichen Inhalt des Root-Verzeichnisses importieren möchten?";
$GLOBALS["l_import_files"]["root_dir_2"] = "Sie haben als Zielverzeichnis das Root-Verzeichnis des Webservers angegeben. Sind Sie sicher, dass Sie alles direkt in das Root-Verzeichnis importieren möchten?";
$GLOBALS["l_import_files"]["root_dir_3"] = "Sie haben als Quell- und Zielverzeichnis das Root-Verzeichnis des Webservers angegeben. Sind Sie sicher, dass Sie sämtlichen Inhalt des Root-Verzeichnisses wieder direkt in das Root-Verzeichnis importieren möchten?";

$GLOBALS["l_import_files"]["thumbnails"] = "Miniaturansichten";
$GLOBALS["l_import_files"]["make_thumbs"] = "Erzeuge<br>Miniaturansichten";
$GLOBALS["l_import_files"]["image_options_open"] = "Grafikfunktionen einblenden";
$GLOBALS["l_import_files"]["image_options_close"] = "Grafikfunktionen ausblenden";
$GLOBALS["l_import_files"]["add_description_nogdlib"] = "Damit Ihnen die Grafikfunktionen zur Verfügung stehen, muß die GD Library auf Ihrem Server installiert sein!";

$GLOBALS["l_import_files"]["noFiles"] = "Im angegebenen Quellverzeichnis existieren keine Dateien, welche den Importeinstellungen entsprechen!";
$GLOBALS["l_import_files"]["emptyDir"] = "Das Quellverzeichnis ist leer!";

$GLOBALS["l_import_files"]["metadata"] = "Metadaten";
$GLOBALS["l_import_files"]["import_metadata"] = "Vorhandene Metadaten importieren";
?>