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

$lang["Wizard"]["DetailWizard"]["title"] = "";


//
// ---> Steps
//

// Startscreen
$lang["Step"]["Startscreen"]["title"] = "Willkommen";
$lang["Step"]["Startscreen"]["headline"] = "Willkommen";
$lang["Step"]["Startscreen"]["content"] = "Herzlich Willkommen zum First Steps Wizard für Erweiterungen. In den folgenden Schritten können Sie webEdition um weitere Funktionen ergänzen.<br /><br />Der Import dieser funktionellen Einheiten erfolgt analog zu der Installation Ihres Layouts mit dem First Steps Wizard.<br /><br />Die Importe, die Sie hier vornehmen können, bestehen aus einer Reihe von einzelnen Dateien: Vorlagen, Dokumente, Beispieldateien oder Grafiken.<br /><br />Informieren Sie sich regelmäßig auf unserer Homepage <a href=\"http://www.living-e.de/\" target=\"_blank\" class=\"defaultfont\">http://www.living-e.de</a>, ob neue Funktionen für webEdition zur Verfügung stehen.<br /><br />Sie vermissen die webEdition Demoseiten? Kein Problem: laden Sie die webEdition Demos als Backup unter <a href=\"http://demo.webedition.de/\" target=\"_blank\" class=\"defaultfont\">http://demo.webedtion.de</a> kostenlos von unserer Website. Der Import erfolgt über Datei > Backup > Backup wiederherstellen...";
$lang["Step"]["Startscreen"]["description"] = "Ab Version 5 von webEdition ist das Export Modul bereits in der Basisversion enthalten. Damit können Sie selbst funktionelle Einheiten, wie z.B. ein Gästebuch, exportieren und anderen Nutzern zur Verfügung stellen.<br /><br />In webEdition 5 sind viele ehemalige Module bereits in der Basisversion integriert: Voting, Banner, Benutzerverwaltung usw...<br /><br />Mit den Buttons Weiter und Zurück können Sie innerhalb des Wizards eine Seite nach vorne oder hinten springen.";

$lang["Step"]["Startscreen"]["no_connection"] = "Es konnte keine Verbindung zum Vorlagenserver aufgebaut werden.";
$lang["Step"]["Startscreen"]["error"] = "Fehler";


// ChooseDesign
$lang["Step"]["ChooseDesign"]["title"] = "Erweiterung wählen";
$lang["Step"]["ChooseDesign"]["headline"] = "Erweiterung wählen";
$lang["Step"]["ChooseDesign"]["content"] = "";
$lang["Step"]["ChooseDesign"]["description"] = "Bitte wählen Sie hier eine der derzeit zur Verfügung stehenden Erweiterungen aus.<br /><br />Die dargestellten Erweiterungen können kostenfrei verwendet und nach Ihren Bedürfnissen angepasst werden.<br /><br />Sie können diesen Vorgang jederzeit wiederholen und so weitere Funktionen hinzufügen.<br /><br />Klicken Sie auf Vorschau, um sich eine Funktion vergrößert anzeigen zu lassen.<br /><br />Das webEdition Team wird auch in Zukunft weitere Erweiterungen veröffentlichen. Rufen Sie einfach den First Steps Wizard erneut auf und lassen Sie sich überraschen.<br /><br />Bei der Installation werden Vorlagen und Dokumente installiert, auf der die gewählte Funktion basiert.<br /><br />Mit webEdition können Sie barrierefreie Webseiten ertstellen, die auch von Screenreadern und auf Handhelds gelesen werden können";

$lang["Step"]["ChooseDesign"]["no_import"] = "Sie haben keine Erweiterung ausgewählt.";


// DetermineFiles
$lang["Step"]["DetermineFiles"]["title"] = "Benötigte Dateien herunterladen";
$lang["Step"]["DetermineFiles"]["headline"] = "Benötigte Dateien herunterladen";
$lang["Step"]["DetermineFiles"]["content"] = "Die Dateien für die von Ihnen ausgewählte Funktion werden nun von unserem Server auf Ihren Server übertragen und in webEdition importiert. Es handelt sich dabei um die benötigen Vorlagen, CSS-Stile und layoutspezifische Dateien, wie z.B. Bilder und Grafiken. Beispielseiten können Sie in einem späteren Schritt anlegen.<br /><br />Die heruntergeladenen Dateien werden nach dem erfolgreichen Import im webEdition Dateibaum angezeigt.<br /><br />Links neben dem Dateibaum befinden sich Karteireiter (Tabs), mit denen Sie zwischen Dokumenten und Vorlagen umschalten können. Dokumente und Vorlagen haben jeweils einen eigenen Dateibaum und enthalten unterschiedliche Dateien.<br /><br />Wenn Sie bereits ein Layout mit dem Wizard installiert haben, wird dieses durch das neue Layout überschrieben! Falls Sie das alte Layout bewahren wollen, müssen Sie die dazugehörigen Dateien in andere Ordner verschieben.<br /><br />Im webEdition Dokumentenverzeichnis werden folgende Verzeichnisse angelegt:<br />&nbsp;&nbsp;&nbsp;{gewähltes Verzeichnis}/{Erweiterung}<br /><br />Im webEdition Vorlagenverzeichnis werden folgende Verzeichnisse angelegt:<br />&nbsp;&nbsp;&nbsp;/living-e/{Erweiterung}<br /><br />Um weitere Funktionen zu ergänzen, starten Sie bitte nach erfolgreichem Import den FSW erneut mit Datei > Neu > webEdition-Seite > Sonstige";
$lang["Step"]["DetermineFiles"]["description"] = "Je nach Größe und Anzahl der Dateien und der Geschwindigkeit der Internetanbindung kann der Download einige Zeit in Anspruch nehmen.<br /><br />Das WCMS webEdition trennt strikt zwischen Inhalt und Design. So kann eine einheitliche Gestaltung der Website gewährleistet werden.<br /><br />Die Layouts werden von unserem Server geladen; dabei werden keinerlei persönliche Daten erfasst oder gespeichert.<br /><br />Bearbeitbare Bereiche werden in webEdition mit sogenannten &lt;we:tags&gt; ausgezeichnet. Derzeit gibt es knapp 200 davon!<br /><br />Mit dem Editor PlugIn können Sie Ihre webEdition Vorlagen ganz einfach in Ihrem HTML-Editor bearbeiten.";

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
$lang["Step"]["ImportOptions"]["content"] = "Hier können Sie einstellen, welche Hauptvorlage für Ihren Import verwendet werden soll. Wenn Sie bereits mit dem First Steps Wizard ein Layout importiert haben, sollte die korrekte Vorlage bereits vorausgewählt sein. Sie können natürlich auch ein eigens erstelltes Template verwenden.<br /><br />Aktivieren Sie Dokumente erstellen, so werden in dem von Ihnen ausgewählten Verzeichnis sofort webEdition-Seiten mit den neuen Funktionen angelegt, die Sie dann an Ihre Bedürfnisse anpassen können.<br /><br />Aktivieren Sie die Checkbox Navigationseinträge hinzufügen, so können Sie die neuen Dokumente auch über die Navigation unter dem entsprechenden Eintrag erreichen";
$lang["Step"]["ImportOptions"]["description"] = "Ein <b>Mastertemplate</b> ist eine <b>Hauptvorlage</b> für webEdition-Seiten. Sie können gleichbleibende Elemente, die auf allen Seiten Ihrer Website identisch sein sollen, in der Hauptvorlage definieren: z.B das Logo, die Navigation und Ähnliches. So ist die Konsistenz Ihrer Seite stets gewährleistet.<br /><br />Wenn Sie eine neue webEdition Vorlage erstellen, können Sie eine Hauptvorlage auswählen, auf der sie basieren soll. So steht das Grundgerüst in wenigen Sekunden.<br /><br />Die <b>Navigation</b> Ihrer Seite können Sie bequem mit dem Navigationstool anpassen. Sie erreichen es über Extras > Navigation...<br /><br />Wenn Sie die Option Dokumente erstellen nicht aktivieren, werden nur die Vorlagen importiert. Sie können dann die Dokumente selbst erstellen und Ihnen in der Ansicht Eigenschaften die entsprechende Vorlage zuweisen.";

$lang["Step"]["ImportOptions"]["choose_mastertemplate"] = "Auf welchem Mastertemplate sollen die Vorlagen basieren:";
$lang["Step"]["ImportOptions"]["labelUseDocuments"] = "Ja, Dokumente sollen erstellt werden";
$lang["Step"]["ImportOptions"]["choose_document_path"] = "Bitte wählen Sie hier das Verzeichnis in welchem die Dokumente erstellt werden sollen:";
$lang["Step"]["ImportOptions"]["labelUseNavigation"] = "Ja, Navigationseinträge hinzufügen";
$lang["Step"]["ImportOptions"]["choose_navigation_path"] = "Bitte wählen Sie hier den Ordner in welchem die Naviagtionseinträge hinzugefügt werden sollen:";

// ImportFiles
$lang["Step"]["ImportFiles"]["title"] = "Benötigte Dateien vorbereiten";
$lang["Step"]["ImportFiles"]["headline"] = "Benötigte Dateien vorbereiten";
$lang["Step"]["ImportFiles"]["content"] = "Die Dateien für Ihre neue Funktion befinden sich nun auf Ihrem Server. In diesem Schritt werden Sie in webEdition importiert. Im Rahmen dieses Importes werden die Inhalte in die Datenbank eingetragen und die Verzeichnisse und Dateien in der webEdition Oberfläche angelegt.<br /><br />Je nach Art und Anzahl der Dateien kann der Import ein wenig Zeit in Anspruch nehmen. Der Fortschritt wird Ihnen weiter unten angezeigt.<br /><br />Wenn Sie die entsprechenden Einstellungen auf dem letzten Bildschirm ausgewählt haben, befinden sich die neuen Dokumente bereits in Ihrer Navigation und können sofort auf Ihrer Webseite erreicht werden.<br /><br />Bevor die Änderungen an einer webEdition-Seite auf Ihrer Homepage angezeigt werden, müssen Sie es speichern und veröffentlichen!<br /><br />Mit den neuen MultiTabs können Sie mehrere webEdition-Seiten und Vorlagen gleichzeitig geöffnet haben. So können Sie schnell zwischen einem Dokument und dessen Vorlage hin und herschalten, um Änderungen am Quellcode sofort nachvollziehen zu können.<br /><br />Dokumente und Vorlagen verfügen über mehrere Karteireiter am oberen Rand, mit denen Sie zwischen verschiedenen Ansichten umschalten können. So lassen sich  Dokumente validieren oder weitere Informationen über Vorlagen anzeigen.";
$lang["Step"]["ImportFiles"]["description"] = "Kennen Sie den seeMode? In dieser vereinfachten Darstellung navigieren Sie in webEdition wie auf der fertigen Webseite. Aktivieren Sie einfach den seeMode Radiobutton beim Login.<br /><br />Importierte Bilder können Sie direkt in webEdition beschneiden oder skalieren. Wählen Sie einfach die Datei in der Ansicht Bearbeiten aus.<br /><br />Das neue Editor PlugIn kann Dateiformate, wie z.B. .doc oder .jpg, direkt mit der Ausgangsapplikation verknüpfen: Editor starten, Datei bearbeiten, speichern -fertig!<br /><br />Sie finden nicht das richtige we:tag? In der Bearbeiten Ansicht von Vorlagen finden Sie den Tagwizard: dort sind alle Tags mit einer kurzen Erklärung aufgeführt!";

// Finish
$lang["Step"]["Finish"]["title"] = "Layout wurde angelegt";
$lang["Step"]["Finish"]["headline"] = "Das Layout wurde angelegt...";
$lang["Step"]["Finish"]["content"] = "Herzlichen Glückwunsch, das Layout wurde erfolgreich importiert!<br />Bevor Sie loslegen, können Sie noch einen Rebuild durchführen:<br />Nach dem Import von Detailvorlagen ist ein Rebuild auf jeden Fall notwendig";
$lang["Step"]["Finish"]["description"] = "In der Sidebar können beliebige webEdition-Seiten angezeigt werden: Ob Onlinehilfe oder eine Übersicht aller Shopartikel - nutzen Sie die neuen Möglichkeiten.<br /><br />Sie können das webEdition Cockpit nach Ihren Vorstellungen anpassen: über Cockpit > Widget hinzufügen können Sie weitere Widgets anzeigen lassen.<br /><br />Erstellen Sie regelmäßig  Backups Ihrer Webseite? Mit webEdition ist das ganz einfach: Datei > Backup > Backup erstellen...<br /><br />Was ist eigentlich ein <b>Rebuild</b>? webEdition erstellt Webseiten basierend auf Vorlagen. Sollten Sie die Vorlage einer statischen webEdition-Seite verändern, so muß diese neu \\\"gebaut\\\" und abgespeichert werden!";

$lang["Step"]["Finish"]["content_2"] = "In der neuen Sidebar können Sie sich die weiteren Möglichkeiten für Ihren neuen Import anzeigen lassen. Sie gelangen dort direkt zu neuen Dokumenten oder weiteren Funktionen!<br /><br />Wir wünschen Ihnen mit dem WCMS webEdition viel Spaß. Wenn Sie immer über die neuesten Entwicklungen informiert werden möchten, abonnieren Sie doch unseren Newsletter unter<br /><a href=\"http://www.living-e.de/de/newsletter/\" target=\"blank\" class=\"defaultfont\">http://www.living-e.de/de/newsletter</a><br /><br />Bei Fragen wenden Sie sich bitte an unseren Support unter<br /><a href=\"http://support.living-e.de/de/webedition/\" class=\"defaultfont\" target=\"_blank\">http://support.living-e.de/de/webedition</a>";

?>