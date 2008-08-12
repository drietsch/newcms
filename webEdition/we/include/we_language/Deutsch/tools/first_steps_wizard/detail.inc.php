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
$lang["Buttons"]["back"] = "zur�ck";


//
// ---> Wizards
//

$lang["Wizard"]["DetailWizard"]["title"] = "";


//
// ---> Steps
//

// Startscreen
$lang["Step"]["Startscreen"]["title"] = "Willkommen";
$lang["Step"]["Startscreen"]["headline"] = "Willkommen";
$lang["Step"]["Startscreen"]["content"] = "Herzlich Willkommen zum First Steps Wizard f�r Erweiterungen. In den folgenden Schritten k�nnen Sie webEdition um weitere Funktionen erg�nzen.<br /><br />Der Import dieser funktionellen Einheiten erfolgt analog zu der Installation Ihres Layouts mit dem First Steps Wizard.<br /><br />Die Importe, die Sie hier vornehmen k�nnen, bestehen aus einer Reihe von einzelnen Dateien: Vorlagen, Dokumente, Beispieldateien oder Grafiken.<br /><br />Informieren Sie sich regelm��ig auf unserer Homepage <a href=\"http://www.living-e.de/\" target=\"_blank\" class=\"defaultfont\">http://www.living-e.de</a>, ob neue Funktionen f�r webEdition zur Verf�gung stehen.<br /><br />Sie vermissen die webEdition Demoseiten? Kein Problem: laden Sie die webEdition Demos als Backup unter <a href=\"http://demo.webedition.de/\" target=\"_blank\" class=\"defaultfont\">http://demo.webedtion.de</a> kostenlos von unserer Website. Der Import erfolgt �ber Datei > Backup > Backup wiederherstellen...";
$lang["Step"]["Startscreen"]["description"] = "Ab Version 5 von webEdition ist das Export Modul bereits in der Basisversion enthalten. Damit k�nnen Sie selbst funktionelle Einheiten, wie z.B. ein G�stebuch, exportieren und anderen Nutzern zur Verf�gung stellen.<br /><br />In webEdition 5 sind viele ehemalige Module bereits in der Basisversion integriert: Voting, Banner, Benutzerverwaltung usw...<br /><br />Mit den Buttons Weiter und Zur�ck k�nnen Sie innerhalb des Wizards eine Seite nach vorne oder hinten springen.";

$lang["Step"]["Startscreen"]["no_connection"] = "Es konnte keine Verbindung zum Vorlagenserver aufgebaut werden.";
$lang["Step"]["Startscreen"]["error"] = "Fehler";


// ChooseDesign
$lang["Step"]["ChooseDesign"]["title"] = "Erweiterung w�hlen";
$lang["Step"]["ChooseDesign"]["headline"] = "Erweiterung w�hlen";
$lang["Step"]["ChooseDesign"]["content"] = "";
$lang["Step"]["ChooseDesign"]["description"] = "Bitte w�hlen Sie hier eine der derzeit zur Verf�gung stehenden Erweiterungen aus.<br /><br />Die dargestellten Erweiterungen k�nnen kostenfrei verwendet und nach Ihren Bed�rfnissen angepasst werden.<br /><br />Sie k�nnen diesen Vorgang jederzeit wiederholen und so weitere Funktionen hinzuf�gen.<br /><br />Klicken Sie auf Vorschau, um sich eine Funktion vergr��ert anzeigen zu lassen.<br /><br />Das webEdition Team wird auch in Zukunft weitere Erweiterungen ver�ffentlichen. Rufen Sie einfach den First Steps Wizard erneut auf und lassen Sie sich �berraschen.<br /><br />Bei der Installation werden Vorlagen und Dokumente installiert, auf der die gew�hlte Funktion basiert.<br /><br />Mit webEdition k�nnen Sie barrierefreie Webseiten ertstellen, die auch von Screenreadern und auf Handhelds gelesen werden k�nnen";

$lang["Step"]["ChooseDesign"]["no_import"] = "Sie haben keine Erweiterung ausgew�hlt.";


// DetermineFiles
$lang["Step"]["DetermineFiles"]["title"] = "Ben�tigte Dateien herunterladen";
$lang["Step"]["DetermineFiles"]["headline"] = "Ben�tigte Dateien herunterladen";
$lang["Step"]["DetermineFiles"]["content"] = "Die Dateien f�r die von Ihnen ausgew�hlte Funktion werden nun von unserem Server auf Ihren Server �bertragen und in webEdition importiert. Es handelt sich dabei um die ben�tigen Vorlagen, CSS-Stile und layoutspezifische Dateien, wie z.B. Bilder und Grafiken. Beispielseiten k�nnen Sie in einem sp�teren Schritt anlegen.<br /><br />Die heruntergeladenen Dateien werden nach dem erfolgreichen Import im webEdition Dateibaum angezeigt.<br /><br />Links neben dem Dateibaum befinden sich Karteireiter (Tabs), mit denen Sie zwischen Dokumenten und Vorlagen umschalten k�nnen. Dokumente und Vorlagen haben jeweils einen eigenen Dateibaum und enthalten unterschiedliche Dateien.<br /><br />Wenn Sie bereits ein Layout mit dem Wizard installiert haben, wird dieses durch das neue Layout �berschrieben! Falls Sie das alte Layout bewahren wollen, m�ssen Sie die dazugeh�rigen Dateien in andere Ordner verschieben.<br /><br />Im webEdition Dokumentenverzeichnis werden folgende Verzeichnisse angelegt:<br />&nbsp;&nbsp;&nbsp;{gew�hltes Verzeichnis}/{Erweiterung}<br /><br />Im webEdition Vorlagenverzeichnis werden folgende Verzeichnisse angelegt:<br />&nbsp;&nbsp;&nbsp;/living-e/{Erweiterung}<br /><br />Um weitere Funktionen zu erg�nzen, starten Sie bitte nach erfolgreichem Import den FSW erneut mit Datei > Neu > webEdition-Seite > Sonstige";
$lang["Step"]["DetermineFiles"]["description"] = "Je nach Gr��e und Anzahl der Dateien und der Geschwindigkeit der Internetanbindung kann der Download einige Zeit in Anspruch nehmen.<br /><br />Das WCMS webEdition trennt strikt zwischen Inhalt und Design. So kann eine einheitliche Gestaltung der Website gew�hrleistet werden.<br /><br />Die Layouts werden von unserem Server geladen; dabei werden keinerlei pers�nliche Daten erfasst oder gespeichert.<br /><br />Bearbeitbare Bereiche werden in webEdition mit sogenannten &lt;we:tags&gt; ausgezeichnet. Derzeit gibt es knapp 200 davon!<br /><br />Mit dem Editor PlugIn k�nnen Sie Ihre webEdition Vorlagen ganz einfach in Ihrem HTML-Editor bearbeiten.";

// DownloadFiles
$lang["Step"]["DownloadFiles"]["title"] = $lang["Step"]["DetermineFiles"]["title"];
$lang["Step"]["DownloadFiles"]["headline"] = $lang["Step"]["DetermineFiles"]["headline"];
$lang["Step"]["DownloadFiles"]["content"] = $lang["Step"]["DetermineFiles"]["content"];
$lang["Step"]["DownloadFiles"]["description"] = $lang["Step"]["DetermineFiles"]["description"];

// PostDownloadFiles
$lang["Step"]["PostDownloadFiles"]["title"] = $lang["Step"]["DetermineFiles"]["title"];
$lang["Step"]["PostDownloadFiles"]["headline"] = $lang["Step"]["DetermineFiles"]["headline"];
$lang["Step"]["PostDownloadFiles"]["content"] = $lang["Step"]["DetermineFiles"]["content"];
$lang["Step"]["PostDownloadFiles"]["description"] = $lang["Step"]["DetermineFiles"]["description"];

// ImportOptions
$lang["Step"]["ImportOptions"]["title"] = "Einstellungen";
$lang["Step"]["ImportOptions"]["headline"] = "Einstellungen";
$lang["Step"]["ImportOptions"]["content"] = "Hier k�nnen Sie einstellen, welche Hauptvorlage f�r Ihren Import verwendet werden soll. Wenn Sie bereits mit dem First Steps Wizard ein Layout importiert haben, sollte die korrekte Vorlage bereits vorausgew�hlt sein. Sie k�nnen nat�rlich auch ein eigens erstelltes Template verwenden.<br /><br />Aktivieren Sie Dokumente erstellen, so werden in dem von Ihnen ausgew�hlten Verzeichnis sofort webEdition-Seiten mit den neuen Funktionen angelegt, die Sie dann an Ihre Bed�rfnisse anpassen k�nnen.<br /><br />Aktivieren Sie die Checkbox Navigationseintr�ge hinzuf�gen, so k�nnen Sie die neuen Dokumente auch �ber die Navigation unter dem entsprechenden Eintrag erreichen";
$lang["Step"]["ImportOptions"]["description"] = "Ein <b>Mastertemplate</b> ist eine <b>Hauptvorlage</b> f�r webEdition-Seiten. Sie k�nnen gleichbleibende Elemente, die auf allen Seiten Ihrer Website identisch sein sollen, in der Hauptvorlage definieren: z.B das Logo, die Navigation und �hnliches. So ist die Konsistenz Ihrer Seite stets gew�hrleistet.<br /><br />Wenn Sie eine neue webEdition Vorlage erstellen, k�nnen Sie eine Hauptvorlage ausw�hlen, auf der sie basieren soll. So steht das Grundger�st in wenigen Sekunden.<br /><br />Die <b>Navigation</b> Ihrer Seite k�nnen Sie bequem mit dem Navigationstool anpassen. Sie erreichen es �ber Extras > Navigation...<br /><br />Wenn Sie die Option Dokumente erstellen nicht aktivieren, werden nur die Vorlagen importiert. Sie k�nnen dann die Dokumente selbst erstellen und Ihnen in der Ansicht Eigenschaften die entsprechende Vorlage zuweisen.";

$lang["Step"]["ImportOptions"]["choose_mastertemplate"] = "Auf welchem Mastertemplate sollen die Vorlagen basieren:";
$lang["Step"]["ImportOptions"]["labelUseDocuments"] = "Ja, Dokumente sollen erstellt werden";
$lang["Step"]["ImportOptions"]["choose_document_path"] = "Bitte w�hlen Sie hier das Verzeichnis in welchem die Dokumente erstellt werden sollen:";
$lang["Step"]["ImportOptions"]["labelUseNavigation"] = "Ja, Navigationseintr�ge hinzuf�gen";
$lang["Step"]["ImportOptions"]["choose_navigation_path"] = "Bitte w�hlen Sie hier den Ordner in welchem die Naviagtionseintr�ge hinzugef�gt werden sollen:";

// ImportFiles
$lang["Step"]["ImportFiles"]["title"] = "Ben�tigte Dateien vorbereiten";
$lang["Step"]["ImportFiles"]["headline"] = "Ben�tigte Dateien vorbereiten";
$lang["Step"]["ImportFiles"]["content"] = "Die Dateien f�r Ihre neue Funktion befinden sich nun auf Ihrem Server. In diesem Schritt werden Sie in webEdition importiert. Im Rahmen dieses Importes werden die Inhalte in die Datenbank eingetragen und die Verzeichnisse und Dateien in der webEdition Oberfl�che angelegt.<br /><br />Je nach Art und Anzahl der Dateien kann der Import ein wenig Zeit in Anspruch nehmen. Der Fortschritt wird Ihnen weiter unten angezeigt.<br /><br />Wenn Sie die entsprechenden Einstellungen auf dem letzten Bildschirm ausgew�hlt haben, befinden sich die neuen Dokumente bereits in Ihrer Navigation und k�nnen sofort auf Ihrer Webseite erreicht werden.<br /><br />Bevor die �nderungen an einer webEdition-Seite auf Ihrer Homepage angezeigt werden, m�ssen Sie es speichern und ver�ffentlichen!<br /><br />Mit den neuen MultiTabs k�nnen Sie mehrere webEdition-Seiten und Vorlagen gleichzeitig ge�ffnet haben. So k�nnen Sie schnell zwischen einem Dokument und dessen Vorlage hin und herschalten, um �nderungen am Quellcode sofort nachvollziehen zu k�nnen.<br /><br />Dokumente und Vorlagen verf�gen �ber mehrere Karteireiter am oberen Rand, mit denen Sie zwischen verschiedenen Ansichten umschalten k�nnen. So lassen sich  Dokumente validieren oder weitere Informationen �ber Vorlagen anzeigen.";
$lang["Step"]["ImportFiles"]["description"] = "Kennen Sie den seeMode? In dieser vereinfachten Darstellung navigieren Sie in webEdition wie auf der fertigen Webseite. Aktivieren Sie einfach den seeMode Radiobutton beim Login.<br /><br />Importierte Bilder k�nnen Sie direkt in webEdition beschneiden oder skalieren. W�hlen Sie einfach die Datei in der Ansicht Bearbeiten aus.<br /><br />Das neue Editor PlugIn kann Dateiformate, wie z.B. .doc oder .jpg, direkt mit der Ausgangsapplikation verkn�pfen: Editor starten, Datei bearbeiten, speichern -fertig!<br /><br />Sie finden nicht das richtige we:tag? In der Bearbeiten Ansicht von Vorlagen finden Sie den Tagwizard: dort sind alle Tags mit einer kurzen Erkl�rung aufgef�hrt!";

// Finish
$lang["Step"]["Finish"]["title"] = "Layout wurde angelegt";
$lang["Step"]["Finish"]["headline"] = "Das Layout wurde angelegt...";
$lang["Step"]["Finish"]["content"] = "Herzlichen Gl�ckwunsch, das Layout wurde erfolgreich importiert!<br />Bevor Sie loslegen, k�nnen Sie noch einen Rebuild durchf�hren:<br />Nach dem Import von Detailvorlagen ist ein Rebuild auf jeden Fall notwendig";
$lang["Step"]["Finish"]["description"] = "In der Sidebar k�nnen beliebige webEdition-Seiten angezeigt werden: Ob Onlinehilfe oder eine �bersicht aller Shopartikel - nutzen Sie die neuen M�glichkeiten.<br /><br />Sie k�nnen das webEdition Cockpit nach Ihren Vorstellungen anpassen: �ber Cockpit > Widget hinzuf�gen k�nnen Sie weitere Widgets anzeigen lassen.<br /><br />Erstellen Sie regelm��ig  Backups Ihrer Webseite? Mit webEdition ist das ganz einfach: Datei > Backup > Backup erstellen...<br /><br />Was ist eigentlich ein <b>Rebuild</b>? webEdition erstellt Webseiten basierend auf Vorlagen. Sollten Sie die Vorlage einer statischen webEdition-Seite ver�ndern, so mu� diese neu \\\"gebaut\\\" und abgespeichert werden!";

$lang["Step"]["Finish"]["content_2"] = "In der neuen Sidebar k�nnen Sie sich die weiteren M�glichkeiten f�r Ihren neuen Import anzeigen lassen. Sie gelangen dort direkt zu neuen Dokumenten oder weiteren Funktionen!<br /><br />Wir w�nschen Ihnen mit dem WCMS webEdition viel Spa�. Wenn Sie immer �ber die neuesten Entwicklungen informiert werden m�chten, abonnieren Sie doch unseren Newsletter unter<br /><a href=\"http://www.living-e.de/de/newsletter/\" target=\"blank\" class=\"defaultfont\">http://www.living-e.de/de/newsletter</a><br /><br />Bei Fragen wenden Sie sich bitte an unseren Support unter<br /><a href=\"http://support.living-e.de/de/webedition/\" class=\"defaultfont\" target=\"_blank\">http://support.living-e.de/de/webedition</a>";

?>