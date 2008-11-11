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


//
// ---> Template
//

$lang["Template"]["headline"] = "First Steps Wizard";
$lang["Template"]["title"] = "First Steps Wizard";
$lang["Template"]["autocontinue"] = "Sie werden automatisch in %s Sekunden weitergeleitet.";


//
// ---> Buttons
//

$lang["Buttons"]["next"] = "weiter";
$lang["Buttons"]["back"] = "zur�ck";


//
// ---> Wizards
//
//

$lang["Wizard"]["MasterWizard"]["title"] = "";


//
// ---> Steps
//

// Startscreen
$lang["Step"]["Startscreen"]["title"] = "Willkommen";
$lang["Step"]["Startscreen"]["headline"] = "Willkommen";
$lang["Step"]["Startscreen"]["content"] = "Herzlich Willkommen zum webEdition First Steps Wizard (FSW). Dieser Einrichtungsassistent richtet sich in erster Linie an neue webEdition Benutzer, die ohne langes Handbuchstudium zu einem ersten Grundger�st f�r Ihre Website gelangen m�chten. Aber auch f�r webEdition Experten bietet der Wizard die M�glichkeit, mit wenigen Mausklicks eine funktionierende webEdition Pr�senz zu erstellen, die dann individuell angepasst werden kann.<br /><br />Auf den folgenden Seiten unterst�tzt Sie der FSW bei der Installation eines ersten Layouts f�r Ihre Website. Im rechten Drittel des Wizards finden Sie hilfreiche Hinweise und Erkl�rungen zu den jeweiligen Schritten.<br /><br />Nach der Installation des Layouts k�nnen Sie den Funktionsumfang Ihrer Seite durch weitere Funktionen, wie z.B G�stebuch oder Bildergalerie erweitern. Auch hierbei unterstz�tzt Sie der FSW: �ber Datei > Neu > webEdition-Seite > Sonstige erreichen Sie den FSW, der Sie bei der Installation weiterer Funktionen unterst�tzt.<br /><br />Sie vermissen die webEdition Demoseiten? Kein Problem: laden Sie die webEdition Demos als Backup unter <a href=\"http://demo.webedition.de/\" target=\"_blank\" class=\"defaultfont\">http://demo.webedition.de</a> kostenlos von unserer Website. Der Import erfolgt �ber Datei > Backup > Backup wiederherstellen...";
$lang["Step"]["Startscreen"]["description"] = "Der webEdition <b>First Steps Wizard (FSW)</b> unterst�tzt Sie bei Ihren ersten Schritten mit dem <b>Web Content Management System (WCMS)</b> webEdition.<br /><br />webEdition installiert in der Version 5 keine Beispieldateien mehr. Dadurch haben Sie ein sofort einsatzf�higes System zur Verf�gung.<br /><br />Die Anzahl der Layouts f�r den FSW wird weiterwachsen. �berpr�fen Sie von Zeit zu Zeit, ob neue Layouts vorhanden sind. Dazu m�ssen Sie nur den FSW ausf�hren.<br /><br />Sie k�nnen den First Steps Wizard jederzeit �ber Datei > Neu > Wizards > First Steps Wizard aufrufen.<br /><br />Mit den Buttons Weiter und Zur�ck k�nnen Sie innerhalb des Wizards eine Seite nach vorne oder hinten springen.";

$lang["Step"]["Startscreen"]["no_connection"] = "Es konnte keine Verbindung zum Vorlagenserver aufgebaut werden.";
$lang["Step"]["Startscreen"]["error"] = "Fehler";


// ChooseDesign
$lang["Step"]["ChooseDesign"]["title"] = "Layout w�hlen";
$lang["Step"]["ChooseDesign"]["headline"] = "Layout w�hlen";
$lang["Step"]["ChooseDesign"]["content"] = "";
$lang["Step"]["ChooseDesign"]["description"] = "Bitte w�hlen Sie hier eines der derzeit zur Verf�gung stehenden Layouts aus.<br /><br />Die dargestellten Layouts k�nnen kostenfrei verwendet und nach Ihren Bed�rfnissen angepasst werden.<br /><br />Sie k�nnen diesen Vorgang jederzeit wiederholen und so auf einfache Weise das Layout Ihrer Webseite �ndern.<br /><br />Klicken Sie auf Vorschau, um sich ein Design vergr��ert anzeigen zu lassen.<br /><br />Das webEdition Team wird auch in Zukunft weitere Designs ver�ffentlichen. Rufen Sie einfach den First Steps Wizard erneut auf und lassen Sie sich �berraschen.<br /><br />Bei der Installation wird eine sogenannte <b>Hauptvorlage (Mastertemplate)</b> installiert, auf der das Aussehen aller Seiten basiert.<br /><br />Mit webEdition k�nnen Sie barrierefreie Webseiten ertstellen, die auch von Screenreadern und auf Handhelds gelesen werden k�nnen.";

$lang["Step"]["ChooseDesign"]["no_import"] = "Sie haben kein Layout ausgew�hlt.";


// DetermineFiles
$lang["Step"]["DetermineFiles"]["title"] = "Ben�tigte Dateien herunterladen";
$lang["Step"]["DetermineFiles"]["headline"] = "Ben�tigte Dateien herunterladen";
$lang["Step"]["DetermineFiles"]["content"] = "Die Dateien f�r das von Ihnen ausgew�hlte Layout werden nun von unserem Server auf Ihren Server �bertragen und in webEdition importiert. Es handelt sich dabei um die Hauptvorlage (Mastertemplate), eine Vorlage f�r Textseiten, CSS-Stile und layoutspezifische Dateien, wie z.B. Bilder und Grafiken.<br /><br />Die heruntergeladenen Dateien werden nach dem erfolgreichen Import im webEdition Dateibaum angezeigt.<br /><br />Links neben dem Dateibaum befinden sich Karteireiter (Tabs), mit denen Sie zwischen Dokumenten und Vorlagen umschalten k�nnen. Dokumente und Vorlagen haben jeweils einen eigenen Dateibaum und enthalten unterschiedliche Dateien.<br /><br />Wenn Sie bereits ein Layout mit dem Wizard installiert haben, wird dieses durch das neue Layout �berschrieben! Falls Sie das alte Layout bewahren wollen, m�ssen Sie die dazugeh�rigen Dateien in andere Ordner verschieben.<br /><br />Im webEdition Dokumentenverzeichnis werden folgende Verzeichnisse angelegt:<br />&nbsp;&nbsp;&nbsp;_include<br />&nbsp;&nbsp;&nbsp;_layout<br /><br />Im webEdition Vorlagenverzeichnis werden folgende Verzeichnisse angelegt:<br />&nbsp;&nbsp;&nbsp;include<br />&nbsp;&nbsp;&nbsp;master<br /><br />Um weitere Funktionen zu erg�nzen, starten Sie bitte nach erfolgreichem Import des Layouts den FSW erneut mit Datei > Neu > webEdition-Seite > Sonstige";
$lang["Step"]["DetermineFiles"]["description"] = "Je nach Gr��e und Anzahl der Dateien und der Geschwindigkeit der Internetanbindung kann der Download einige Zeit in Anspruch nehmen.<br /><br />Das WCMS webEdition trennt strikt zwischen Inhalt und Design. So kann eine einheitliche Gestaltung der Website gew�hrleistet werden.<br /><br />Die Layouts werden von unserem Server geladen; dabei werden keinerlei pers�nliche Daten erfasst oder gespeichert.<br /><br />Bearbeitbare Bereiche werden in webEdition mit sogenannten &lt;we:tags&gt; ausgezeichnet. Derzeit gibt es knapp 200 davon!<br /><br />Mit dem Editor PlugIn k�nnen Sie Ihre webEdition Vorlagen ganz einfach in Ihrem HTML-Editor bearbeiten.";

// DownloadFiles
$lang["Step"]["DownloadFiles"]["title"] = $lang["Step"]["DetermineFiles"]["title"];
$lang["Step"]["DownloadFiles"]["headline"] = $lang["Step"]["DetermineFiles"]["headline"];
$lang["Step"]["DownloadFiles"]["content"] = $lang["Step"]["DetermineFiles"]["content"];
$lang["Step"]["DownloadFiles"]["description"] = $lang["Step"]["DetermineFiles"]["description"];

// ImportOptions
$lang["Step"]["ImportOptions"]["title"] = $lang["Step"]["DetermineFiles"]["title"];
$lang["Step"]["ImportOptions"]["headline"] = $lang["Step"]["DetermineFiles"]["headline"];
$lang["Step"]["ImportOptions"]["content"] = $lang["Step"]["DetermineFiles"]["content"];
$lang["Step"]["ImportOptions"]["description"] = $lang["Step"]["DetermineFiles"]["description"];

// ImportFiles
$lang["Step"]["ImportFiles"]["title"] = "Ben�tigte Dateien vorbereiten";
$lang["Step"]["ImportFiles"]["headline"] = "Ben�tigte Dateien vorbereiten";
$lang["Step"]["ImportFiles"]["content"] = "Die Layout Dateien befinden sich nun auf Ihrem Server. In diesem Schritt werden Sie in webEdition importiert. Im Rahmen dieses Importes werden die Inhalte in die Datenbank eingetragen und die Verzeichnisse und Dateien in der webEdition Oberfl�che angelegt.<br /><br />F�r Ihre ersten Schritte mit webEdition wird ein einfaches Textdokument mitgeliefert. Hier k�nnen Sie in einem WYSIWYG-Textfeld (What you see is what you get) bereits erste Inhalte anlegen und mit Ihrer Webseite experimentieren.<br /><br />Legen Sie Ihre erste textbasierte Seite mit Datei > Neu > webEdition-Seite > Textseite an. Hier k�nnen Sie zum Beispiel bereits Ihre G�ste begr��en oder Ihre Webseite kurz vorstellen.<br /><br />Eine zweistufige Navigation ist bereits angelegt. Passen Sie die Navigation f�r Ihre neue Webseite mit dem Navigationstool an. Das Navigationstool erreichen Sie �ber Extras > Naviagtion... Hier k�nnen Sie komfortabel neue Navigationseintr�ge erstellen oder bearbeiten.<br /><br />Bevor die �nderungen an einer webEdition-Seite auf Ihrer Homepage angezeigt werden, m�ssen Sie es speichern und ver�ffentlichen!<br /><br />Mit den neuen MultiTabs k�nnen Sie mehrere webEdition-Seiten und Vorlagen gleichzeitig ge�ffnet haben. So k�nnen Sie schnell zwischen einem Dokument und dessen Vorlage hin und herschalten, um �nderungen am Quellcode sofort nachvollziehen zu k�nnen.<br /><br />Dokumente und Vorlagen verf�gen �ber mehrere Karteireiter am oberen Rand, mit denen Sie zwischen verschiedenen Ansichten umschalten k�nnen. So lassen sich  Dokumente validieren oder weitere Informationen �ber Vorlagen anzeigen.";
$lang["Step"]["ImportFiles"]["description"] = "Kennen Sie den seeMode? In dieser vereinfachten Darstellung navigieren Sie in webEdition wie auf der fertigen Webseite. Aktivieren Sie einfach den seeMode Radiobutton beim Login.<br /><br />Importierte Bilder k�nnen Sie direkt in webEdition beschneiden oder skalieren. W�hlen Sie einfach die Datei in der Ansicht Bearbeiten aus.<br /><br />Das neue Editor PlugIn kann Dateiformate, wie z.B. .doc oder .jpg, direkt mit der Ausgangsapplikation verkn�pfen: Editor starten, Datei bearbeiten, speichern -fertig!<br /><br />Sie finden nicht das richtige we:tag? In der Bearbeiten Ansicht von Vorlagen finden Sie den Tagwizard: dort sind alle Tags mit einer kurzen Erkl�rung aufgef�hrt!";

// Finish
$lang["Step"]["Finish"]["title"] = "Layout wurde angelegt";
$lang["Step"]["Finish"]["headline"] = "Das Layout wurde angelegt...";
$lang["Step"]["Finish"]["content"] = "Herzlichen Gl�ckwunsch, das Layout wurde erfolgreich importiert!<br /><br />Bevor Sie loslegen, k�nnen Sie noch einen Rebuild durchf�hren:";
$lang["Step"]["Finish"]["description"] = "In der Sidebar k�nnen beliebige webEdition-Seiten angezeigt werden: Ob Onlinehilfe oder eine �bersicht aller Shopartikel - nutzen Sie die neuen M�glichkeiten.<br /><br />Sie k�nnen das webEdition Cockpit nach Ihren Vorstellungen anpassen: �ber Cockpit > Widget hinzuf�gen k�nnen Sie weitere Widgets anzeigen lassen.<br /><br />Erstellen Sie regelm��ig  Backups Ihrer Webseite? Mit webEdition ist das ganz einfach: Datei > Backup > Backup erstellen...<br /><br />Was ist eigentlich ein <b>Rebuild</b>? webEdition erstellt Webseiten basierend auf Vorlagen. Sollten Sie die Vorlage einer statischen webEdition-Seite ver�ndern, so mu� diese neu \\\"gebaut\\\" und abgespeichert werden!";

$lang["Step"]["Finish"]["content_2"] = "Sollten Sie bereits fr�her ein Layout importiert haben, so m�ssen Sie auf jeden Fall einen Rebuild durchf�hren!<br /><br />In der neuen Sidebar k�nnen Sie sich die weiteren M�glichkeiten f�r Ihre neue Webseite anzeigen lassen. Sie gelangen dort direkt zu neuen Textdokumenten oder weiteren Funktionen, die Sie f�r die Seite nachinstallieren k�nnen!<br /><br />Wir w�nschen Ihnen mit dem WCMS webEdition viel Spa�. Wenn Sie immer �ber die neuesten Entwicklungen informiert werden m�chten, abonnieren Sie doch unseren Newsletter unter <a href=\"http://www.living-e.de/de/newsletter/\" target=\"_blank\" class=\"defaultfont\">http://www.living-e.de/de/newsletter</a><br /><br />Bei Fragen wenden Sie sich bitte an unseren Support unter <a href=\"http://support.living-e.de/de/webedition/\" target=\"_blank\" class=\"defaultfont\">http://support.living-e.de/de/webedition</a>";

?>