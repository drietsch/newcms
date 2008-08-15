<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+


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
$lang["Buttons"]["back"] = "zurück";


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
$lang["Step"]["Startscreen"]["content"] = "Herzlich Willkommen zum webEdition First Steps Wizard (FSW). Dieser Einrichtungsassistent richtet sich in erster Linie an neue webEdition Benutzer, die ohne langes Handbuchstudium zu einem ersten Grundgerüst für Ihre Website gelangen möchten. Aber auch für webEdition Experten bietet der Wizard die Möglichkeit, mit wenigen Mausklicks eine funktionierende webEdition Präsenz zu erstellen, die dann individuell angepasst werden kann.<br /><br />Auf den folgenden Seiten unterstützt Sie der FSW bei der Installation eines ersten Layouts für Ihre Website. Im rechten Drittel des Wizards finden Sie hilfreiche Hinweise und Erklärungen zu den jeweiligen Schritten.<br /><br />Nach der Installation des Layouts können Sie den Funktionsumfang Ihrer Seite durch weitere Funktionen, wie z.B Gästebuch oder Bildergalerie erweitern. Auch hierbei unterstzützt Sie der FSW: Über Datei > Neu > webEdition-Seite > Sonstige erreichen Sie den FSW, der Sie bei der Installation weiterer Funktionen unterstützt.<br /><br />Sie vermissen die webEdition Demoseiten? Kein Problem: laden Sie die webEdition Demos als Backup unter <a href=\"http://demo.webedition.de/\" target=\"_blank\" class=\"defaultfont\">http://demo.webedition.de</a> kostenlos von unserer Website. Der Import erfolgt über Datei > Backup > Backup wiederherstellen...";
$lang["Step"]["Startscreen"]["description"] = "Der webEdition <b>First Steps Wizard (FSW)</b> unterstützt Sie bei Ihren ersten Schritten mit dem <b>Web Content Management System (WCMS)</b> webEdition.<br /><br />webEdition installiert in der Version 5 keine Beispieldateien mehr. Dadurch haben Sie ein sofort einsatzfähiges System zur Verfügung.<br /><br />Die Anzahl der Layouts für den FSW wird weiterwachsen. Überprüfen Sie von Zeit zu Zeit, ob neue Layouts vorhanden sind. Dazu müssen Sie nur den FSW ausführen.<br /><br />Sie können den First Steps Wizard jederzeit über Datei > Neu > Wizards > First Steps Wizard aufrufen.<br /><br />Mit den Buttons Weiter und Zurück können Sie innerhalb des Wizards eine Seite nach vorne oder hinten springen.";

$lang["Step"]["Startscreen"]["no_connection"] = "Es konnte keine Verbindung zum Vorlagenserver aufgebaut werden.";
$lang["Step"]["Startscreen"]["error"] = "Fehler";


// ChooseDesign
$lang["Step"]["ChooseDesign"]["title"] = "Layout wählen";
$lang["Step"]["ChooseDesign"]["headline"] = "Layout wählen";
$lang["Step"]["ChooseDesign"]["content"] = "";
$lang["Step"]["ChooseDesign"]["description"] = "Bitte wählen Sie hier eines der derzeit zur Verfügung stehenden Layouts aus.<br /><br />Die dargestellten Layouts können kostenfrei verwendet und nach Ihren Bedürfnissen angepasst werden.<br /><br />Sie können diesen Vorgang jederzeit wiederholen und so auf einfache Weise das Layout Ihrer Webseite ändern.<br /><br />Klicken Sie auf Vorschau, um sich ein Design vergrößert anzeigen zu lassen.<br /><br />Das webEdition Team wird auch in Zukunft weitere Designs veröffentlichen. Rufen Sie einfach den First Steps Wizard erneut auf und lassen Sie sich überraschen.<br /><br />Bei der Installation wird eine sogenannte <b>Hauptvorlage (Mastertemplate)</b> installiert, auf der das Aussehen aller Seiten basiert.<br /><br />Mit webEdition können Sie barrierefreie Webseiten ertstellen, die auch von Screenreadern und auf Handhelds gelesen werden können.";

$lang["Step"]["ChooseDesign"]["no_import"] = "Sie haben kein Layout ausgewählt.";


// DetermineFiles
$lang["Step"]["DetermineFiles"]["title"] = "Benötigte Dateien herunterladen";
$lang["Step"]["DetermineFiles"]["headline"] = "Benötigte Dateien herunterladen";
$lang["Step"]["DetermineFiles"]["content"] = "Die Dateien für das von Ihnen ausgewählte Layout werden nun von unserem Server auf Ihren Server übertragen und in webEdition importiert. Es handelt sich dabei um die Hauptvorlage (Mastertemplate), eine Vorlage für Textseiten, CSS-Stile und layoutspezifische Dateien, wie z.B. Bilder und Grafiken.<br /><br />Die heruntergeladenen Dateien werden nach dem erfolgreichen Import im webEdition Dateibaum angezeigt.<br /><br />Links neben dem Dateibaum befinden sich Karteireiter (Tabs), mit denen Sie zwischen Dokumenten und Vorlagen umschalten können. Dokumente und Vorlagen haben jeweils einen eigenen Dateibaum und enthalten unterschiedliche Dateien.<br /><br />Wenn Sie bereits ein Layout mit dem Wizard installiert haben, wird dieses durch das neue Layout überschrieben! Falls Sie das alte Layout bewahren wollen, müssen Sie die dazugehörigen Dateien in andere Ordner verschieben.<br /><br />Im webEdition Dokumentenverzeichnis werden folgende Verzeichnisse angelegt:<br />&nbsp;&nbsp;&nbsp;_include<br />&nbsp;&nbsp;&nbsp;_layout<br /><br />Im webEdition Vorlagenverzeichnis werden folgende Verzeichnisse angelegt:<br />&nbsp;&nbsp;&nbsp;include<br />&nbsp;&nbsp;&nbsp;master<br /><br />Um weitere Funktionen zu ergänzen, starten Sie bitte nach erfolgreichem Import des Layouts den FSW erneut mit Datei > Neu > webEdition-Seite > Sonstige";
$lang["Step"]["DetermineFiles"]["description"] = "Je nach Größe und Anzahl der Dateien und der Geschwindigkeit der Internetanbindung kann der Download einige Zeit in Anspruch nehmen.<br /><br />Das WCMS webEdition trennt strikt zwischen Inhalt und Design. So kann eine einheitliche Gestaltung der Website gewährleistet werden.<br /><br />Die Layouts werden von unserem Server geladen; dabei werden keinerlei persönliche Daten erfasst oder gespeichert.<br /><br />Bearbeitbare Bereiche werden in webEdition mit sogenannten &lt;we:tags&gt; ausgezeichnet. Derzeit gibt es knapp 200 davon!<br /><br />Mit dem Editor PlugIn können Sie Ihre webEdition Vorlagen ganz einfach in Ihrem HTML-Editor bearbeiten.";

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
$lang["Step"]["ImportFiles"]["title"] = "Benötigte Dateien vorbereiten";
$lang["Step"]["ImportFiles"]["headline"] = "Benötigte Dateien vorbereiten";
$lang["Step"]["ImportFiles"]["content"] = "Die Layout Dateien befinden sich nun auf Ihrem Server. In diesem Schritt werden Sie in webEdition importiert. Im Rahmen dieses Importes werden die Inhalte in die Datenbank eingetragen und die Verzeichnisse und Dateien in der webEdition Oberfläche angelegt.<br /><br />Für Ihre ersten Schritte mit webEdition wird ein einfaches Textdokument mitgeliefert. Hier können Sie in einem WYSIWYG-Textfeld (What you see is what you get) bereits erste Inhalte anlegen und mit Ihrer Webseite experimentieren.<br /><br />Legen Sie Ihre erste textbasierte Seite mit Datei > Neu > webEdition-Seite > Textseite an. Hier können Sie zum Beispiel bereits Ihre Gäste begrüßen oder Ihre Webseite kurz vorstellen.<br /><br />Eine zweistufige Navigation ist bereits angelegt. Passen Sie die Navigation für Ihre neue Webseite mit dem Navigationstool an. Das Navigationstool erreichen Sie über Extras > Naviagtion... Hier können Sie komfortabel neue Navigationseinträge erstellen oder bearbeiten.<br /><br />Bevor die Änderungen an einer webEdition-Seite auf Ihrer Homepage angezeigt werden, müssen Sie es speichern und veröffentlichen!<br /><br />Mit den neuen MultiTabs können Sie mehrere webEdition-Seiten und Vorlagen gleichzeitig geöffnet haben. So können Sie schnell zwischen einem Dokument und dessen Vorlage hin und herschalten, um Änderungen am Quellcode sofort nachvollziehen zu können.<br /><br />Dokumente und Vorlagen verfügen über mehrere Karteireiter am oberen Rand, mit denen Sie zwischen verschiedenen Ansichten umschalten können. So lassen sich  Dokumente validieren oder weitere Informationen über Vorlagen anzeigen.";
$lang["Step"]["ImportFiles"]["description"] = "Kennen Sie den seeMode? In dieser vereinfachten Darstellung navigieren Sie in webEdition wie auf der fertigen Webseite. Aktivieren Sie einfach den seeMode Radiobutton beim Login.<br /><br />Importierte Bilder können Sie direkt in webEdition beschneiden oder skalieren. Wählen Sie einfach die Datei in der Ansicht Bearbeiten aus.<br /><br />Das neue Editor PlugIn kann Dateiformate, wie z.B. .doc oder .jpg, direkt mit der Ausgangsapplikation verknüpfen: Editor starten, Datei bearbeiten, speichern -fertig!<br /><br />Sie finden nicht das richtige we:tag? In der Bearbeiten Ansicht von Vorlagen finden Sie den Tagwizard: dort sind alle Tags mit einer kurzen Erklärung aufgeführt!";

// Finish
$lang["Step"]["Finish"]["title"] = "Layout wurde angelegt";
$lang["Step"]["Finish"]["headline"] = "Das Layout wurde angelegt...";
$lang["Step"]["Finish"]["content"] = "Herzlichen Glückwunsch, das Layout wurde erfolgreich importiert!<br /><br />Bevor Sie loslegen, können Sie noch einen Rebuild durchführen:";
$lang["Step"]["Finish"]["description"] = "In der Sidebar können beliebige webEdition-Seiten angezeigt werden: Ob Onlinehilfe oder eine Übersicht aller Shopartikel - nutzen Sie die neuen Möglichkeiten.<br /><br />Sie können das webEdition Cockpit nach Ihren Vorstellungen anpassen: über Cockpit > Widget hinzufügen können Sie weitere Widgets anzeigen lassen.<br /><br />Erstellen Sie regelmäßig  Backups Ihrer Webseite? Mit webEdition ist das ganz einfach: Datei > Backup > Backup erstellen...<br /><br />Was ist eigentlich ein <b>Rebuild</b>? webEdition erstellt Webseiten basierend auf Vorlagen. Sollten Sie die Vorlage einer statischen webEdition-Seite verändern, so muß diese neu \\\"gebaut\\\" und abgespeichert werden!";

$lang["Step"]["Finish"]["content_2"] = "Sollten Sie bereits früher ein Layout importiert haben, so müssen Sie auf jeden Fall einen Rebuild durchführen!<br /><br />In der neuen Sidebar können Sie sich die weiteren Möglichkeiten für Ihre neue Webseite anzeigen lassen. Sie gelangen dort direkt zu neuen Textdokumenten oder weiteren Funktionen, die Sie für die Seite nachinstallieren können!<br /><br />Wir wünschen Ihnen mit dem WCMS webEdition viel Spaß. Wenn Sie immer über die neuesten Entwicklungen informiert werden möchten, abonnieren Sie doch unseren Newsletter unter <a href=\"http://www.living-e.de/de/newsletter/\" target=\"_blank\" class=\"defaultfont\">http://www.living-e.de/de/newsletter</a><br /><br />Bei Fragen wenden Sie sich bitte an unseren Support unter <a href=\"http://support.living-e.de/de/webedition/\" target=\"_blank\" class=\"defaultfont\">http://support.living-e.de/de/webedition</a>";

?>